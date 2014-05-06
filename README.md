Domain-parser-remote-http
=========================

Vezme ze vzdáleného serveru HTML, kde je v tabulce html seznam domen.
Parserem se to zpracuje, a výjde pole s kategorií ve kterém je pole s ID a DOMENOU.

pro Khaldora :-)

ERROR
-----
Ukládá se do proměné error po zavolání vrací TRUE/FALSE

Spuštění
---------
Co víc dodat?

    $s = new ParserDomain();
    $s->check();
    $s->constructTable(1);

    //eror true/false
    $s->error

    //vypise kategorie
    echo $s->getCategories();

    //vypise vsechna data
    echo $s->getDataAll();

    //vypise data v kategorii 1
    echo $s->getData(1); 
 
 

