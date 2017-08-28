<?php

namespace Quantico;

function Qrecupero($val)
{
    global $Qpostime; $ok = true;
    
    if(is_array($val)) // :::::::::::::::::::::: Recupero di tutti i files
    {
        for($a=count($val)-1; $a>2; $a--)
        {
            if(strpos($val[$a],"$Qpostime/")) // ========= Encrypted Files
            {
                $fx = file(substr($val[$a],0,-6).'sync.php');
                
                if(file_put_contents($val[$a], count($fx)))
                {
                    if(file_put_contents(substr($val[$a],0,-6).'index.php', $fx))
                        $msg = 'SUCCESS'; else { $msg = 'FAILED'; $ok = false; }
                        
                } else { $msg = 'FAILED'; $ok = false; }
            }
            else // ========================================= System Files
            {
                $fx = substr($val[$a],0,-4).'_SYNC_.php';
                
                if(file_exists($fx))
                {
                    if(copy($fx, $val[$a])) $msg = 'SUCCESS';
                    else { $msg = 'FAILED'; $ok = false; }
                }
            }
            
            Qerror(5, 17, $msg, $val[$a]);  // ------- System File Corrupt
        }
        
        if(!$ok) { Qerror(5, 18); exit; } // ------- QuanticoDB is Blocked
    }
    else // :::::::::::::::::::::::::::::: Recupero della stringa criptata
    {
        global $Qdatabase; global $Qpassword; $ok = false;
        
        $keyper = "$Qdatabase$Qpostime/".substr($val, 0, 3).'/'.substr($val, 3, $val[12]);
        $keyperindex = "$keyper/index.php"; $keyper .= '/sync.php';
        
        $fp = file($keyperindex);
        $fx = file($keyper);
        
        $pos = substr(rtrim($val), 13);
        $key = $Qpassword[hexdec(substr($val, 10, 2))];
        $orapsw = substr($val, 0, 12);
        
        $iv = Qiv($orapsw, $key);
        $v = Qdecrypt($fx[$pos], $key, $iv);
        
        if($orapsw == substr($v, -12))
        { 
            $fp[$pos] = $fx[$pos];
            $ok = w($keyperindex, $fp, true);
            $msg = 'SUCCESS';
            
        } else $msg = 'FAILED';
        
        Qerror(5, 15, $msg, $pos, $keyperindex); // Encrypted File Corrupt
        
        if($ok) return $v; else return false;
    }
}