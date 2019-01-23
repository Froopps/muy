<?php

$lettere = range('a', 'z');
$c=0;
foreach($lettere as $l){
    echo "INSERT INTO canale VALUES ('$l pubblico','$l@gmail.com','public','etichetta,canale tematico,tag','200$c-01-01','".date('Y-m-d H:i:s')."');";
    echo "<br>";
    echo "INSERT INTO canale VALUES ('$l social','$l@gmail.com','social','etichetta,canale tematico,tag','200$c-01-01','".date('Y-m-d H:i:s')."');";
    echo "<br>";
    echo "INSERT INTO canale VALUES ('$l privato','$l@gmail.com','private','etichetta,canale tematico,tag','200$c-01-01','".date('Y-m-d H:i:s')."');";
    echo "<br>";
    $c++;
    if($c>9)
        $c=0;
}

?>