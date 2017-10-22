<?php

namespace Quantico;

class tt extends SYS // $val[3] = Tempo PARTENZA    $val[4] = Tempo ARRIVO     $val[5] = STATO ---> true = MAX:min | false = min:MAX
{
    protected static function crealista($keyperindex, $keyper, $keyval, $kn, $val, $num, $type){ $fk = file($keyperindex); $par = 2; $arr = count($fk)-1; $num[19] = $kn[2]; $fp = [];
        for($a=count($fk)-2; $a>1; $a--) { $k = explode('.', $fk[$a]); if($num[4] < $k[0]) { $a--; $arr = $a; } else { if($num[3] >= $k[0] && $num[3] <= $k[1]) $par = $a; if($num[4] >= $k[0] && $num[4] <= $k[1]) $arr = $a; if($num[3] > $k[1]) { $par = $a+1; break; }}}
        if($num[5]) { // ------------------------------------------------> $num[4] => $num[3]
            for($a=$arr; $a>=$par; $a--) { $keypos = "$keyper/$a.php"; 
                if(file_exists($keypos)) { $fx = file($keypos); 
                    if($type) { $keypos = "$keyper/v$a.php"; 
                        if(file_exists($keypos)) $fv = file($keypos); else return false; 
                        if($type == 2) for($x=2,$u=count($fx); $x<$u; $x++) $fv[$x] = rtrim($fv[$x]).'|'.$fx[$x]; 
                    } 
                    if($val) { $ff = file("$keyper/c$a.php"); for($x=2,$u=count($ff); $x<$u; $x++) $fv[$x] .= '|'.rtrim($ff[$x]).'|'.$fx[$x]; } 
                    if($a == $arr) $high = SYS::ordina($num[4], $fx, 1, 1); else $high = count($fx)-1; $low = SYS::ordina($num[3], $fx, 0, 1);
                    if($type) $fp = array_merge($fp, array_slice($fv, $low, $high-$low+1)); else $fp = array_merge($fp, array_slice($fx, $low, $high-$low+1));
                }
            } return SYS::selezione(array_reverse($fp), $num);
        } else { // -----------------------------------------------------> $num[3] => $num[4]
            for($a=$par; $a<=$arr; $a++) { $keypos = "$keyper/$a.php"; 
                if(file_exists($keypos)) { $fx = file($keypos);
                    if($type) { $keypos = "$keyper/v$a.php"; 
                        if(file_exists($keypos)) $fv = file($keypos); else return false; 
                        if($type == 2) for($x=2,$u=count($fx); $x<$u; $x++) $fv[$x] = rtrim($fv[$x]).'|'.$fx[$x]; 
                    } 
                    if($val) { $ff = file("$keyper/c$a.php"); for($x=2,$u=count($ff); $x<$u; $x++) $fv[$x] .= '|'.rtrim($ff[$x]).'|'.$fx[$x]; } 
                    if($a == $par) $low = SYS::ordina($num[3], $fx, 0, 1); else $low = 2; $high = SYS::ordina($num[4], $fx, 1, 1);
                    if($type) $fp = array_merge($fp, array_slice($fv, $low, $high-$low+1)); else $fp = array_merge($fp, array_slice($fx, $low, $high-$low+1));
                }
            } return SYS::selezione($fp, $num);
        }
    }
}