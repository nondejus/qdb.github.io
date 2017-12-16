<?php

    if(isset($_POST['type'])) $type = $_POST['type']; else exit;
    if(isset($_POST['user'])) $user = $_POST['user']; else exit;
    if(isset($_POST['pass'])) $pass = $_POST['pass']; else exit;
    
    require 'dirqdb.php'; if(!file_exists($dirqdb.'Qconfig.php')) exit;
    
    if($type == 's' and $user == 'c' and $pass == 'r') { // ----------------------------------------------------------------------------------------- Permessi
        if(is_writable($dirqdb.'Qconfig.php')) exit('0'); else exit('1'); 
    } else { $user = strtolower(filter_var($user, FILTER_SANITIZE_EMAIL)); if(!$user) exit;
    
        require $dirqdb.'Qconfig.php'; require '../class/Qai/Qdb.php'; require 'function.php';
        
        if($type == 'Login') { $key_user = Qdb($user,'Quser.ini',$type); if(!$key_user) exit('5'); $key_pass = Qdb($pass,'Qpass.ini',$type);
            if($key_pass) { 
                if(Qcookie($dirqdb)) {
                    echo Qrawenc($key_user.$key_pass.Qh($key_user.$key_pass)); // ------------------------------------------------------------------- Login OK
                } else echo 9;
            } else { $agg = file('config.php'); if($agg[2] == "1\n") { require_once 'error.php'; login_error($user); } echo 5; } // ----------------- Login Sbagliato
        }
        elseif($type == 'Register') { $Qdb = file("$Qdatabase/index.php"); if(count($Qdb) > 2) { header('location: login.php'); exit; } // ---------- Sei già Registrato
            $key_user = Qdb($user,'Quser.ini',$type); if(!$key_user) exit('0'); $key_pass = Qdb($pass,'Qpass.ini',$type); if(!$key_pass) exit('0');
            if(Qcookie($dirqdb)) {
                echo Qrawenc($key_user.$key_pass.Qh($key_user.$key_pass)); // ----------------------------------------------------------------------- Registrazione OK
            } else echo 9;
        } 
    }

?>