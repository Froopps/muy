<?php
    include_once realpath($_SERVER["DOCUMENT_ROOT"]."/muy/common/setup.php");
    $redirect_with_error="Location: http://localhost/muy/frontend/signup.php?error=";
    
    header("Content-type: text/xml; charset=utf-8");
    echo "<?xml version='1.0' encoding='UTF-8'?>";
    echo "<error triggered='true'><message>Figlio di puttana</message></error>";



?>