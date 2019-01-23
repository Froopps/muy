<?php

$lettere = range('a', 'z');
foreach($lettere as $l){
    mkdir($_SERVER["DOCUMENT_ROOT"]."/muy/muy_res/content/$l@gmail.com",0770);
    mkdir($_SERVER["DOCUMENT_ROOT"]."/muy/muy_res/content/$l@gmail.com/$l pubblico",0770);
    mkdir($_SERVER["DOCUMENT_ROOT"]."/muy/muy_res/content/$l@gmail.com/$l social",0770);
    mkdir($_SERVER["DOCUMENT_ROOT"]."/muy/muy_res/content/$l@gmail.com/$l privato",0770);
    
}

?>