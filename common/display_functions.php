<?php
    include_once "functions.php";
    function user_info($info){
        echo "<table class='user_info'><tr>";
        $pub=get_visible_list($info["visibilita"]);
        if(isset($pub["foto"])){
            #change in /default/logo.jpg
            echo "<td rowspan='2'><a href='#user'><img class='propic' id='top-propic' src='../sources/images/cover.png' alt='propic'></a></td>";
        }
        else{
            echo "<td rowspan='2'><a href='#user'><img class='propic' id='top-propic' src='../sources/images/cover.png' alt='propic'></a></td>";
        }
        if(isset($pub["nickname"])){
            echo "<td class='info'><a class='utente' href='#user'><h1>".$info["nickname"]."</h1></a></td>";
        }
        else{
            echo "<td class='info'><a class='utente' href='#user'><h1>User</h1></a></td>";
        }
        echo "</tr><tr><td class='info'><ul>";
        foreach($pub as $key){
            if($key!="nickname"&&$key!="foto"){
                echo "<li>".htmlentities(stripslashes($info[$key]))."</li>";
            }
        }
        echo "</ul></td></tr></table>";
    }
?>