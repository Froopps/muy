<?php
    # computing a hash value using blowfish; 22 characters salt and 7 iterations by default
    function blowhash($input,$round=7){
        $salt="";
        $salt_values=array_merge(range('A','Z'),range(0,9),range('a','z'));
        for($i=0;$i<22;$i++){
            #takes a random value from the array of salt characters
            $salt.=$salt_values[array_rand($salt_values)];
        }
        return crypt($input, sprintf('$2a$%02d$',$round). $salt);
    }
    #hash matching test
    function hash_match($input,$hashed){
        return crypt($input,$hashed)==$hashed;
    }
    #log into a file
    function log_into($msg){
        $logfile=realpath($_SERVER["DOCUMENT_ROOT"]."/../muy_res/log_files")."/db_error.txt";
        $timestamp=date('Y-m-d H:i:s',time());
        $fp=fopen($logfile,"a");
        fwrite($fp,$msg.$timestamp."\n");
        fclose($fp);
    }
    #set the value for visibility of a user
    function set_visibility($arr){
        $info=array("email"=>0,"nome"=>1,"cognome"=>2,"dataNascita"=>3,"sesso"=>4,"città"=>5);
        $visibility_mask=0;
        foreach($arr as $key){
            $visibility_mask+=pow(2,$info[$key]);
        }
        return $visibility_mask;
    }
    #get the list of visible info for a user
    function get_visible_list($vis){
        $info=array("email","nome","cognome","dataNascita","sesso","citta");
        $public_list=array();
        foreach($info as $a){
            if($vis%2==0){
                array_push($public_list,$a);
            }
            $vis=(int)$vis/2;
        }
        return $public_list;
    }
    #checking email validity and existence at insertion
    function valid_new_email($value,$connected_db){
        $res=array("error"=>FALSE,"msg"=>"","result"=>"");
        #using a restrictive policy (declare what is valid and not what is not) to increase security and a validation
        #conform to the RFC standards on valid characters in email addresses
        if(!preg_match('/^[A-Za-z0-9\?\.\+\^\[\]\'&~=_-èéàòù ]+@[A-Za-z0-9\?\.\+\^\'&~=_-èéàòù ]+\.{1}[A-Za-z]{2,6}$/',$value)){
            $res["error"]=TRUE;
            $res["msg"]="Mail non valida";
            return $res;
        }
        #verify that no accounts are currently associated with this before continuing to process other incoming data
        $email=escape($value,$connected_db);
        $query="SELECT COUNT(*) FROM utente WHERE email='".$email."'";
        $query_res=$connected_db->query($query);
        if(!$query_res){
            $res["error"]=TRUE;
            $res["msg"]="Errore nella connessione con il database";
            log_into("Errore di esecuzione della query ".$query." ".$connected_db->error);
            return $res;
        }
        if($query_res->fetch_row()[0]!=0){
            $res["error"]=TRUE;
            $res["msg"]="Esiste già un account associato alla mail inserita";
            return $res;
        }
        $res["result"]=$email;
        return $res;
    }
    #case sensitiveness(php) and obliviousness(sql) make the world null evil
    function escape($str,$connected_db){
        $str=trim($str);
        if(strtolower($str)=="null"){
            $str="\\".$str;
        }
        return $connected_db->real_escape_string($str);
    }

    function valutazione($content_path,$connected_db){
        $res=array("error"=>FALSE,"msg"=>"","result"=>"");
        $query="SELECT voto FROM valutazione WHERE relativoA='".escape($content_path,$connected_db)."'";
        $query_res=$connected_db->query($query);
        if(!$query_res){
            $res["error"]=TRUE;
            $res["msg"]="db err";
            log_into("Errore di esecuzione della query ".$query." ".$connected_db->error);
            return $res;
        }
        $add=0;
        $cont=0;
        if(empty($row))
            return 0;
        else{
            while($row=$query_res->fetch_assoc()){
                $add+=$row["voto"];
                $cont++;
            }
        }
        $rating=$add/$cont;
        $res["result"]=substr($rating,0,3);
        return $res["result"];
    }

    function toUpperFirst($str){
        $str=strtoupper($str[0]).substr($str,1);
        return $str;
    }
?>