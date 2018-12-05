<?php
    # computing a hash value using blowfish
    function blowhash($input,$round=7){
        $salt="";
        $salt_values=array_merge(range('A','Z'),range(0,9),range('a','z'));
        for($i=0;$i<22;$i++){
            $salt.=$salt_values[array_rand($salt_values)];
        }
        return crypt($input, sprintf('$2a$%02d$',$round). $salt);
    }
?>