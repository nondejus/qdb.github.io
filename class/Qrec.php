<?php

namespace Quantico;
define ('QFILESYNC', "$Qdatabase/sync.php");

function r($per=false){ if($per && file_exists($per)){ $l = filesize($per); if($l){ $f = fopen($per,'r'); if($f){ $h = fread($f,$l); fclose($f); return $h; }}} return false; }
function a($file=false, $val=false){ if($file && $val){ Qsync($file); if(is_array($val)) $val = implode('',$val); $f = fopen($file,'a+'); if($f){ fwrite($f,$val); fclose($f); return true; }} return false; }
function w($file=false, $val=false, $opz=false){ if($file && $val){ Qsync($file); if(is_array($val)) $val = implode('',$val); if(!$opz) $f = fopen($file,'w+'); if($f){ fwrite($f,$val); fclose($f); return true; }} return false; }
function Qord($val){ $ord0 = ord($val); if($ord0 >= 0 && $ord0 <= 127) return $ord0; if(!isset($val[1])) return false; $ord1 = ord($val[1]); if($ord0 >= 192 && $ord0 <= 223) return ($ord0-192)*64 + ($ord1-128); if(!isset($val[2])) return false; $ord2 = ord($val[2]); if($ord0 >= 224 && $ord0 <= 239) return ($ord0-224)*4096 + ($ord1-128)*64 + ($ord2-128); if(!isset($val[3])) return false; $ord3 = ord($val[3]); if($ord0 >= 240 && $ord0 <= 247) return ($ord0-240)*262144 + ($ord1-128)*4096 + ($ord2-128)*64 + ($ord3-128); if(!isset($val[4])) return false; $ord4 = ord($val[4]); if($ord0 >= 248 && $ord0 <= 251) return ($ord0-248)*16777216 + ($ord1-128)*262144 + ($ord2-128)*4096 + ($ord3-128)*64 + ($ord4-128); if(!isset($val[5])) return false; if($ord0 >= 252 && $ord0 <= 253) return ($ord0-252)*1073741824 + ($ord1-128)*16777216 + ($ord2-128)*262144 + ($ord3-128)*4096 + ($ord4-128)*64 + (ord($val[5])-128); if($ord0 >= 254 && $ord0 <= 255) return false; }
function Qsync($val, $opz=0){ if($opz) $f = fopen(QFILESYNC,'w+'); else { $f = fopen(QFILESYNC,'a+'); if(file_exists($val)) copy($val, substr($val,0,-4).'_SYNC_.php'); } fwrite($f, $val."\n"); fclose($f); }
function Qdecrypt($str, $key, $iv=false){ if(!$iv) { global $Qaes256iv; $iv = $Qaes256iv; } return @openssl_decrypt(base64_decode($str), 'aes-256-ctr', $key, OPENSSL_RAW_DATA, $iv); }
function Qcrypt($str, $key, $iv=false){ if(!$iv) $iv = Qiv(substr($str, -12), $key); return base64_encode(@openssl_encrypt($str, 'aes-256-ctr', $key, OPENSSL_RAW_DATA, $iv)); }
function Qiv($str, $key){ global $Qaes256iv; return substr(openssl_encrypt(md5((string)$str), 'aes-256-ctr', $key, OPENSSL_RAW_DATA, $Qaes256iv), 0, 16); }
function Qhash($val){ global $Qpassword; return hash('ripemd256', $Qpassword[256].$val.$Qpassword[257]); }
function Qrecupero($val){ global $Qdatabase; global $Qpassword; global $Qpostime; $ok = false;
    
    if(is_array($val)) // --- recupero di tutti i files
    {
        exit('RECUPERO');
    }
    else // ----------------- recupero della stringa criptata
    {
        $keyper = "$Qdatabase$Qpostime/".substr($val, 0, 3).'/'.substr($val, 3, $val[12]);
        $keyperindex = "$keyper/index.php"; $keyper .= '/sync.php'; $fp = file($keyperindex); $fx = file($keyper); $pos = substr(rtrim($val), 13);
        $key = $Qpassword[hexdec(substr($val, 10, 2))]; $orapsw = substr($val, 0, 12); $iv = Qiv($orapsw, $key); $v = Qdecrypt($fx[$pos], $key, $iv);
        
        if($orapsw == substr($v, -12)){ $fp[$pos] = $fx[$pos]; $ok = w($keyperindex, $fp, true); $msg = 'SUCCESS'; } else $msg = 'FAILED';
        include_once 'Qerr.php'; Qerror(5, 15, $msg, $pos, $keyperindex); // Encrypted File Corrupt
        
        if($ok) return $v; else return false;
    }
}

// ******************************************
// **** Controllo se ha completato tutto ****
// ******************************************


if(!file_exists(QFILESYNC)) Qsync($Qprotezione.'*', true);
$fp = file(QFILESYNC, FILE_IGNORE_NEW_LINES);

if(!isset($fp[2])) // File Error
{
    include_once 'Qerr.php';
    Qerror(5, 14, QFILESYNC);
}

if($fp[2] != '*' || $fp[count($fp)-1] != '*') Qrecupero($fp);
Qsync($Qprotezione.'*', true);

?>