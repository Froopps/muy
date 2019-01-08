<?php
    include_once realpath($_SERVER["DOCUMENT_ROOT"]."/muy/common/setup.php");
    $redirect_with_error="Location: http://localhost/muy/frontend/signup.php?error=";
    
    if(isset($_POST["default"])){
        echo $_POST["user"];
        $q_pro_pic="defaults/default-profile-pic.png";
        $query="UPDATE utente SET foto='".$q_pro_pic."' WHERE email='".escape($_POST["user"],$connected_db)."'";
        $connected_db->query($query);
        exit();
    }
    if($_FILES["cropped_pro_pic"]["error"]>0){
        $redirect_with_error.="errore nel caricamento della foto profilo. Assegnata quella di default";
        log_into($_FILES["cropped_pro_pic"]["error"]);
        header($redirect_with_error);
        $connected_db->close();
        exit();
    }
    #query before saving the result to avoid unused image on server
    $pro_pic=$_SERVER["DOCUMENT_ROOT"]."/../muy_res/content/".$_POST["user"]."/pro_pic"."/".$_FILES["cropped_pro_pic"]["name"];
    $q_pro_pic=escape("content/".$_POST["user"]."/pro_pic"."/".$_FILES["cropped_pro_pic"]["name"],$connected_db);
    $query="UPDATE utente SET foto='".$q_pro_pic."' WHERE email='".escape($_POST["user"],$connected_db)."'";
    $connected_db->query($query);
    #the cropping is made as a change to an existing user
    if(file_exists($pro_pic)){
        unlink($pro_pic);
    }
    move_uploaded_file($_FILES["cropped_pro_pic"]["tmp_name"],$pro_pic);


?>