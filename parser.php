<?php

/**
 * @author Martin Nakládal <nakladal@intravps.cz>
 * @version 1.0
 */
class ParserDomain {

    private $domainStorageURL = "http://www.gigaserver.cz/hosting-a-domeny/expirujici-domeny/";

    /**
     * Pole s daty 
     * <code> 
     * array("categorii" => array("id" => 1 , "domain" => "ahoj") ) 
     * </code>
     */
    private $outPut = array();

    /**
     * Error proměná
     * error true = nastal problém, nejspíš neexistuje vzdálený server (nedostal odpověď 200)
     * error false = dostal v hlavičce odpověď 200, takže OK
     */
    public $error = false;

    /**
     * Nastavení serveru, odkud se domeny maji brát
     * 
     * @param string $url odkaz na server
     */
    public function setURL($url) {
        $this->domainStorageURL = $url;
    }

    /**
     * Zjištění URL, odkud se budou brát domeny
     * 
     * @return string url
     */
    public function getURL() {
        return $this->domainStorageURL;
    }

    /**
     * Zjištění kategorii
     * 
     * @return array
     */
    public function getCategories() {
        return array_keys($this->outPut);
    }

    /**
     * Všechna data v poli
     * 
     * @return array
     */
    public function getDataAll() {
        return $this->outPut;
    }

    /**
     * Všechna data v určité kategorii
     * 
     * @return array
     */
    public function getData($cat = 0) {
        return $this->outPut[$cat];
    }

    /**
     * Vytvoření tabulky kategorie
     * 
     * @return html
     */
    public function constructTable($cat = 1, $render = true) {
        $html = ""; 
        if (isset($this->outPut[$cat])) {
            $html = "<table>";
            foreach ($this->outPut[$cat] as $row) {
                $html .= "<tr><td>{$row["id"]}</td><td>{$row["domain"]}</td></tr>\n";
            }
            $html .= "</table>";
        }

        if ($render == true) {
            echo $html;
        }else {
            return $html;
        }
    }

    /**
     * Zpustí parsování a výsledek vráti do proměné
     *  
     */
    public function check() {
        $cat = 0;

        $getURL = @file_get_contents($this->domainStorageURL);

        $getURL == false ? $this->error = true : $this->error = false;

        $category = explode("<table", $getURL);

        $extract_tr = "/<tr>(.*)<\/tr>/isU";
        $extract_td = "/<td.*>(.*)<\/td>/Ui";

        foreach ($category as $table) {
            preg_match_all($extract_tr, $table, $match_tr, PREG_SET_ORDER);


            foreach ($match_tr as $val) {
                preg_match_all($extract_td, $val[1], $match_td, PREG_SET_ORDER);

                if (count($match_td) > 0) {
                    $this->outPut[$cat][] = array("id" => $match_td[0][1], "domain" => $match_td[1][1]);
                }
            }
            $cat++;
        } 
        return $this->outPut;
    }

}
 