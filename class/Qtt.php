<?php

namespace Quantico;

class tt extends SYS
{
    protected static function crealista($keyperindex, $keyper, $keyval, $kn, $val, $num, $type){ $fk = file($keyperindex); $par = 2; $arr = count($fk)-1; 
        for($a=count($fk)-2; $a>1; $a--) { $k = explode('.', $fk[$a]); if($num[4] < $k[0]) { $a--; $arr = $a; } else { if($num[3] >= $k[0] && $num[3] <= $k[1]) $par = $a; if($num[4] >= $k[0] && $num[4] <= $k[1]) $arr = $a; if($num[3] > $k[1]) { $par = $a+1; break; }}} $fp = tt::trovatempo($keyper, $par, $arr, $num[3], $num[4], $num[2], $num[0], $num[5], $type, $val); 
        if($num[6]) { if($fp[1]) { $keyval[1] = $fp[1]; for($c=$fp[1]+1; $c>1; $c--) $keyval[] = $fp[$c]; return $keyval; }} else { if($fp[1]) { $fp[0] = $kn[2]; return $fp; }} return false;
    }
    protected static function trovatempo($keyper, $par, $arr, $min, $max, $inizio, $fine, $opz, $type, $val){ $n = 2; $s = 0; $fp = false; if($inizio == -1) $fine--;
        if($opz) { for($a=$arr; $a>=$par; $a--) { $keypos = "$keyper/$a.php"; if(file_exists($keypos)){ $fx = file($keypos); 
            if($type) { $keypos = "$keyper/v$a.php"; if(file_exists($keypos)) $fv = file($keypos); else { $fp[0] = 1; $fp[1] = $n - 2; return $fp; } if($type == 2) for($x=2,$u=count($fx); $x<$u; $x++) $fv[$x] = rtrim($fv[$x]).'|'.$fx[$x]; } if($val) { $ff = file("$keyper/c$a.php"); for($x=2,$u=count($ff); $x<$u; $x++) $fv[$x] .= '|'.rtrim($ff[$x]).'|'.$fx[$x]; } 
            if($a == $arr) $inz = SYS::ordina($max, $fx, 1, 1); else $inz = count($fx)-1; for($b=$inz; $b>1; $b--) { $f = substr($fx[$b],0,10); if($f >= $min) { $s++; if($s > $inizio) { if($s == $fine) { $fp[0] = 1; $fp[1] = $n - 2; return $fp; } if($type) $fp[$n] = $fv[$b]; else $fp[$n] = $fx[$b]; $n++; }}}}}
        } else { for($a=$par; $a<=$arr; $a++) { $keypos = "$keyper/$a.php"; if(file_exists($keypos)){ $fx = file($keypos); 
            if($type) { $keypos = "$keyper/v$a.php"; if(file_exists($keypos)) $fv = file($keypos); else { $fp[0] = 1; $fp[1] = $n - 2; return $fp; } if($type == 2) for($x=2,$u=count($fx); $x<$u; $x++) $fv[$x] = rtrim($fv[$x]).'|'.$fx[$x]; } if($val) { $ff = file("$keyper/c$a.php"); for($x=2,$u=count($ff); $x<$u; $x++) $fv[$x] .= '|'.rtrim($ff[$x]).'|'.$fx[$x]; } 
            if($a == $par) $inz = SYS::ordina($min, $fx, 0, 1); else $inz = 2; for($b=$inz,$u=count($fx); $b<$u; $b++) { $f = substr($fx[$b],0,10); if($f <= $max) { $s++; if($s > $inizio) { if($s == $fine) { $fp[0] = 1; $fp[1] = $n - 2; return $fp; } if($type) $fp[$n] = $fv[$b]; else $fp[$n] = $fx[$b]; $n++; }}}}}
        } $fp[0] = 1; $fp[1] = $n - 2; return $fp;
    }
}