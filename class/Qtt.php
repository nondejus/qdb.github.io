<?php

namespace Quantico;

class tt extends SYS
{
    protected static function crealista($keyperindex, $keyper, $keyval, $kn, $val, $num, $type){ $fk = file($keyperindex); $par = 2; $arr = count($fk)-1;
        for($a=count($fk)-2; $a>1; $a--) { $k = explode('.', $fk[$a]); if($num[4] < $k[0]) { $a--; $arr = $a; } else { if($num[3] >= $k[0] && $num[3] <= $k[1]) $par = $a; if($num[4] >= $k[0] && $num[4] <= $k[1]) $arr = $a; if($num[3] > $k[1]) { $par = $a+1; break; }}}
        $fp = tt::trovatempo($keyper, $par, $arr, $num, $type, $val); if($num[6]) { if($fp[1]) { $keyval[1] = $fp[1]; for($c=$fp[1]+1; $c>1; $c--) $keyval[] = $fp[$c]; return $keyval; }} else { if($fp[1]) { $fp[0] = $kn[2]; return $fp; }} return false;
    }
    protected static function trovatempo($keyper, $par, $arr, $num, $type, $val){ $n = 2; $fp = false; if($num[2] == -1) $num[0]--;
        if($num[5]) {
            for($a=$arr; $a>=$par; $a--) { $keypos = "$keyper/$a.php"; 
                if(file_exists($keypos)){ $fx = file($keypos); 
                    if($type) { $keypos = "$keyper/v$a.php"; if(file_exists($keypos)) $fv = file($keypos); else { $fp[0] = 1; $fp[1] = $n - 2; return $fp; } if($type == 2) for($x=2,$u=count($fx); $x<$u; $x++) $fv[$x] = rtrim($fv[$x]).'|'.$fx[$x]; } 
                    if($val) { $ff = file("$keyper/c$a.php"); for($x=2,$u=count($ff); $x<$u; $x++) $fv[$x] .= '|'.rtrim($ff[$x]).'|'.$fx[$x]; } if($a == $arr) $inz = SYS::ordina($num[4], $fx, 1, 1); else $inz = count($fx)-1; if($num[6]) $s = $inz-4; else $s = 0;                    
                    for($b=$inz; $b>1; $b--) { $f = substr($fx[$b],0,10); if($f >= $num[3]) { $s++; if($s > $num[2]) { if($s == $num[0]) { $fp[0] = 1; $fp[1] = $n - 2; return $fp; } if($type) $fp[$n] = $fv[$b]; else $fp[$n] = $fx[$b]; $n++; }}}
                }
            }
        } else { 
            for($a=$par; $a<=$arr; $a++) { $keypos = "$keyper/$a.php"; 
                if(file_exists($keypos)){ $fx = file($keypos);
                    if($type) { $keypos = "$keyper/v$a.php"; if(file_exists($keypos)) $fv = file($keypos); else { $fp[0] = 1; $fp[1] = $n - 2; return $fp; } if($type == 2) for($x=2,$u=count($fx); $x<$u; $x++) $fv[$x] = rtrim($fv[$x]).'|'.$fx[$x]; } 
                    if($val) { $ff = file("$keyper/c$a.php"); for($x=2,$u=count($ff); $x<$u; $x++) $fv[$x] .= '|'.rtrim($ff[$x]).'|'.$fx[$x]; } if($a == $par) $inz = SYS::ordina($num[3], $fx, 0, 1); else $inz = 2; if($num[6]) $s = $inz-2; else $s = 0;
                    for($b=$inz,$u=count($fx); $b<$u; $b++) { $f = substr($fx[$b],0,10); if($f <= $num[4]) { $s++; if($s > $num[2]) { if($s == $num[0]) { $fp[0] = 1; $fp[1] = $n - 2; return $fp; } if($type) $fp[$n] = $fv[$b]; else $fp[$n] = $fx[$b]; $n++; }}}
                }
            }
        } $fp[0] = 1; $fp[1] = $n - 2; return $fp;
    }
}