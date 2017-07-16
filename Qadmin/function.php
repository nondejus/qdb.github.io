<?php 

    function Qh($val){ return hash('sha512', $val); }
    function Qw($file, $fx){ return file_put_contents($file, $fx); }
    function Qa($file, $fx){ return file_put_contents($file, $fx, FILE_APPEND); }
    function Qcancella($array, $item){ if(isset($array[$item])) unset($array[$item]); return array_merge($array); }
    function Qscuro($keycomb, $key_user=false, $key_pass=false){ $key = substr(Qrawdec($_POST['sid']),0,64); if($key_user) $key = $key_user.substr($key,32); if($key_pass) $key = substr($key,0,32).$key_pass; $iv = substr($key,16,32); if(is_array($keycomb)) { for($a=2; $a<count($keycomb); $a++) $keycomb[$a] = Qcrypt(Qh($keycomb[$a]).$keycomb[$a], $key, $iv)."\n"; return $keycomb; } else return Qcrypt(Qh($keycomb).$keycomb, $key, $iv)."\n"; }
    function Qchiaro($keycomb){ $key = substr(Qrawdec($_POST['sid']),0,64); $iv = substr($key,16,32); if(is_array($keycomb)) { for($a=2; $a<count($keycomb); $a++) { $r = Qdecrypt(rtrim($keycomb[$a]), $key, $iv); if($r && substr($r,0,128) == Qh(substr($r,128))) $keycomb[$a] = substr($r,128); } return $keycomb; } else { $r = Qdecrypt($keycomb, $key, $iv); if($r && substr($r,0,128) == Qh(substr($r,128))) return substr($r,128); else return false; }}
    function Qcookie($dirqdb) { $key = Qgp(32,'0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'); if(setcookie('Qdb#admin',$key)) { $cnf = file($dirqdb.'Qconfig.php'); $cnf[12] = '$Qckadm = "'.$key.'";'."\n"; Qw($dirqdb.'Qconfig.php',$cnf); return true; } return false; }
    function Qdecrypt($str, $key, $iv = false){ if(!$iv) { global $Qaes256iv; $iv = $Qaes256iv; } return @openssl_decrypt(base64_decode($str), 'aes-256-ctr', $key, OPENSSL_RAW_DATA, $iv); }
    function Qcrypt($str, $key, $iv = false){ if(!$iv) { global $Qaes256iv; $iv = $Qaes256iv; } return base64_encode(@openssl_encrypt($str, 'aes-256-ctr', $key, OPENSSL_RAW_DATA, $iv)); }
    function Qrawenc($str){ global $dirqdb; global $Qprotezione; $key = ''; $i = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ�������?*+&%!�#@�^=-:|!��[<()>]_,;/'; for($a=0; $a<64; $a++) $key .= Qgp(mt_rand(4,8),$i); Qw($dirqdb.'Qsession.php',$Qprotezione.$key); return rawurlencode(Qcrypt($str, $key)); }
    function Qrawdec($str){ global $dirqdb; if(!file_exists($dirqdb.'Qsession.php')) exit; $key = file($dirqdb.'Qsession.php'); return Qdecrypt(rawurldecode($str), $key[2]); }
    function Qgp($x, $y) { $p = ''; $i = 0; while($i < $x) { $z = substr($y,mt_rand(0,strlen($y)-1),1); if(!strstr($p,$z)) { $p .= $z; $i++; }} return $p; }
    function Qdb($val,$file,$type) { global $Qdatabase; global $Qpostime; global $dirqdb; $md5 = md5(strrev($Qpostime).$val.$Qpostime); $hex = array(); $out = array(); for($a=0; $a<32; $a++) $hex[$a] = hexdec($md5[$a]); $key = '';
        if($type == 'Login') { $Qdb = new Quantico(32, 32, 128); $Qdb->load($dirqdb.$file); $out = $Qdb->calculate($hex);
            for($a=0; $a<128; $a+=4) { $x = 0; if($out[$a] > 0.99) $x += 8; elseif($out[$a] > -0.99) return false; if($out[$a+1] > 0.99) $x += 4; elseif($out[$a+1] > -0.99) return false; if($out[$a+2] > 0.99) $x += 2; elseif($out[$a+2] > -0.99) return false; if($out[$a+3] > 0.99) $x += 1; elseif($out[$a+3] > -0.99) return false; $key .= dechex($x); }
            if($key) { $fp = file("$Qdatabase/index.php"); if($file = 'Quser.ini' && Qh($val.$key) == rtrim($fp[2])) return $key; if($file = 'Qpass.ini' && Qh($val.$key) == rtrim($fp[3])) return $key; }
        }
        elseif($type == 'Register') { for($a=0; $a<128; $a++) { $x = mt_rand(0,1); if(!$x) $x = -1; $out[$a] = $x; } $Qdb = new Quantico(32, 32, 128); $Qdb->addTestData($hex,$out); while(!($success = $Qdb->train(1000, 0.01))) return false;
            if($success) { for($a=0; $a<128; $a+=4) { $x = 0; if($out[$a] == 1) $x += 8; if($out[$a+1] == 1) $x += 4; if($out[$a+2] == 1) $x += 2; if($out[$a+3] == 1) $x += 1; $key .= dechex($x); } 
                if($key) { $Qdb->save($dirqdb.$file); $x = Qh($val.$key)."\n"; $fp = file("$Qdatabase/index.php"); if($file == 'Quser.ini') $fp[2] = $x; if($file == 'Qpass.ini') $fp[3] = $x;
                    Qw("$Qdatabase/index.php",$fp); Qw("$Qdatabase-test/index.php",$fp); if(file_exists("$Qdatabase-clone/index.php")) Qw("$Qdatabase-clone/index.php",$fp); return $key; 
                }
            }
        } return false;
    }

?>