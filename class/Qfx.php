<?php

namespace Quantico;

define ('QFILESYNC' , $Qdatabase.'/sync.php');
define ('QKEYBASE'  , file($Qdatabase.'/key.php'));
define ('_DEL_'     , 'QuanticoDB => Deleted'); // --- ver
define ('_IN_'      , 'QuanticoDB => Insert'); // ---- ver
define ('_T1_'      , 'QuanticoDB => Time -1'); // --- ver , out
define ('_T2_'      , 'QuanticoDB => Time -2'); // --- ver , out
define ('_T3_'      , 'QuanticoDB => Time -3'); // --- ver , out
define ('_ON_'      , 'QuanticoDB => Present'); // --- ver
define ('_OFF_'     , null); // ---------------------- ver
define ('_DIRECT_'  , 666); // ----------------------- in

function r($per=false){ if($per && file_exists($per)){ $l = filesize($per); if($l){ $f = fopen($per,'r'); if($f){ $h = fread($f,$l); fclose($f); return $h; }}} return false; }
function a($file=false, $val=false){ if($file && $val){ Qsync($file); if(is_array($val)) $val = implode('',$val); $f = fopen($file,'a+'); if($f){ fwrite($f,$val); fclose($f); return true; }} return false; }
function w($file=false, $val=false, $opz=false){ if($file && $val){ Qsync($file); if(is_array($val)) $val = implode('',$val); if(!$opz) $f = fopen($file,'w+'); if($f){ fwrite($f,$val); fclose($f); return true; }} return false; }
function Qord($val){ $ord0 = ord($val); if($ord0 >= 0 && $ord0 <= 127) return $ord0; if(!isset($val[1])) return false; $ord1 = ord($val[1]); if($ord0 >= 192 && $ord0 <= 223) return ($ord0-192)*64 + ($ord1-128); if(!isset($val[2])) return false; $ord2 = ord($val[2]); if($ord0 >= 224 && $ord0 <= 239) return ($ord0-224)*4096 + ($ord1-128)*64 + ($ord2-128); if(!isset($val[3])) return false; $ord3 = ord($val[3]); if($ord0 >= 240 && $ord0 <= 247) return ($ord0-240)*262144 + ($ord1-128)*4096 + ($ord2-128)*64 + ($ord3-128); if(!isset($val[4])) return false; $ord4 = ord($val[4]); if($ord0 >= 248 && $ord0 <= 251) return ($ord0-248)*16777216 + ($ord1-128)*262144 + ($ord2-128)*4096 + ($ord3-128)*64 + ($ord4-128); if(!isset($val[5])) return false; if($ord0 >= 252 && $ord0 <= 253) return ($ord0-252)*1073741824 + ($ord1-128)*16777216 + ($ord2-128)*262144 + ($ord3-128)*4096 + ($ord4-128)*64 + (ord($val[5])-128); if($ord0 >= 254 && $ord0 <= 255) return false; }
function Qsync($val, $opz=0){ if($opz) { global $Qprotezione; $val = $Qprotezione.$val; $f = fopen(QFILESYNC,'w+'); } else { $f = fopen(QFILESYNC,'a+'); if(file_exists($val) && (time()-filemtime($val)) > 0) copy($val, substr($val,0,-4).'_SYNC_.php'); } fwrite($f, $val."\n"); fclose($f); }
function Qcrypt($str, $key, $iv=false){ if(!$iv) $iv = Qiv(substr($str, -12), $key); if(strlen($str) != mb_strlen($str)) $str = utf8_encode($str); return base64_encode(@openssl_encrypt($str, 'aes-256-ctr', $key, OPENSSL_RAW_DATA, $iv)); }
function Qdecrypt($str, $key, $iv=false){ if(!$iv) { global $Qaes256iv; $iv = $Qaes256iv; } return @openssl_decrypt(base64_decode($str), 'aes-256-ctr', $key, OPENSSL_RAW_DATA, $iv); }
function Qerror($type, $id, $val=null, $valass=null, $key=null, $keyass=null){ include_once 'Qerr.php'; return Qerr($type, $id, $val, $valass, $key, $keyass); }
function Qiv($str, $key){ global $Qaes256iv; return substr(openssl_encrypt(md5((string)$str), 'aes-256-ctr', $key, OPENSSL_RAW_DATA, $Qaes256iv), 0, 16); }
function Qhash($val){ global $Qpassword; return hash('ripemd256', $Qpassword[256].$val.$Qpassword[257]); }
function Qcheck(){

    // ******************************************
    // **** Controllo se ha completato tutto ****
    // ******************************************
    
    if(!file_exists(QFILESYNC)) Qsync('*', true);
    $fs = file(QFILESYNC, FILE_IGNORE_NEW_LINES);
    
    if(!isset($fs[2])) // File Error
    {
        Qerror(5, 14, QFILESYNC);
    }
    
    if($fs[2] != '*' || $fs[count($fs)-1] != '*')
    {
        require_once 'Qrec.php';
        Qrecupero($fs);
    }
    
    // ******************************************
    // ****** Tutto OK si puo' proseguire *******
    // ******************************************
    
    Qsync('*', true); // -- New Call
}

$Qpassword = file( $Qdatabase.'/psw.php' );

//if($Qidkey){ @session_start(); $x = hash('ripemd256', substr($Qidkey,0,32)); $y = hash('sha512', substr($Qidkey,32)); if(isset($_SESSION[$x])) $z = Qdecrypt($_SESSION[$x],$y,$Qaes256iv); else { $z = file_get_contents($Qserver.'index.php?TOKEN='.hash('ripemd256',$Qidkey)); $z = Qdecrypt($z,$Qidkey,$Qaes256iv); $_SESSION[$x] = Qcrypt($z,$y,$Qaes256iv); } $Qpassword[2] = Qdecrypt($Qpassword[2],$z,$Qaes256iv); }
$Qpassword = explode('.',rtrim($Qpassword[2])); if(count($Qpassword) != 258) { include_once 'Qerr.php'; return Qerror(5, 16); }