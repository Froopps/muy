<?php
    include_once realpath($_SERVER["DOCUMENT_ROOT"]."/muy/common/setup.php");
    $redirect_with_error="Location: http://localhost/muy/frontend/signup.php?error=";
    
    if($_FILES["cropped_pro_pic"]["error"]>0){
        $redirect_with_error.="errore nel caricamento della foto profilo. Assegnata quella di default";
        log_into($_FILES["cropped_pro_pic"]["error"]);
        header($redirect_with_error);
        $connected_db->close();
        exit();
    }
    
    #the cropping is made as a change to an existing user
    /*if(file_exists($_SERVER["DOCUMENT_ROOT"]."/../muy_res/user_data/".$_POST["user"]."/pro_pic"."/".$_FILES["cropped_pro_pic"]["name"])){
        unlink

    }*/

?>