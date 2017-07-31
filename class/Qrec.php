<?php

namespace Quantico;

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

?>