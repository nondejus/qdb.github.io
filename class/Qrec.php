<?php

function Qrecupero($val)
{
    global $Qdatabase; global $Qpassword; global $Qpostime; $ok = false;
    
    $keyper = "$Qdatabase$Qpostime/".substr($val, 0, 3).'/'.substr($val, 3, $val[12]);
    $keyperindex = "$keyper/index.php"; $keyper .= '/sync.php'; $fp = file($keyperindex); $fx = file($keyper); $pos = substr(rtrim($val), 13);
    $key = $Qpassword[hexdec(substr($val, 10, 2))]; $orapsw = substr($val, 0, 12); $iv = Qiv($orapsw, $key); $v = Qdecrypt($fx[$pos], $key, $iv);
    
    if($orapsw == substr($v, -12)) { if(count($fp) < count($fx)) array_splice($fp, $pos, 0, $fx[$pos]); else $fp[$pos] = $fx[$pos]; Qfx::w($keyperindex,$fp); $msg = 'SUCCESS'; $ok = true; } else $msg = 'FAILED'; 
    Qfx::a('Quantico_errors.log', date('[d-M-Y H:i:s',time()).' UTC] AUTO Recovery <<< '.$msg.' >>> Encrypted File Corrupt: Position ('.$pos.') & File: '.$keyperindex.chr(13).chr(10)); 
    
    if($ok) return $v; else return false;
}

?>