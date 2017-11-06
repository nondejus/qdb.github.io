<?php

namespace Quantico;

class Qnr extends Qmix
{
    private static function key($keyass, $key, $num, $dif, $fv, $y) { $keyper = SYS::lh($keyass,Qhash($fv)).'/idem.php'; if(!file_exists($keyper)) return false; $fi = file($keyper); if($num[5]) { for($b=2, $ub=count($fi); $b<$ub; $b++){ if($y > $dif) break; if($num[3]){ $z = substr($fi[$b],0,10); if($z >= $num[3] && $z <= $num[4]) { $key[$y] = $fi[$b]; $y++; }} else { $key[$y] = $fi[$b]; $y++; }}} else { for($b=count($fi)-1; $b>1; $b--){ if($y > $dif) break; if($num[3]){ $z = substr($fi[$b],0,10); if($z >= $num[3] && $z <= $num[4]) { $key[$y] = $fi[$b]; $y++; }} else { $key[$y] = $fi[$b]; $y++; }}} return [$key,$y]; }
    private static function idem($keyass, $key, $num, $dif, $pos, $fv, $x, $y, $opz) { if($opz) { for($a=$pos; $a>1; $a--) { $fv[$a] = rtrim($fv[$a]); if($fv[$a] < $num[10] || $x > $dif) break; $z = Qnr::key($keyass, $key, $num, $dif, $fv[$a], $y); if($z) $key = $z[0]; $y = $z[1]; }} else { for($a=$pos, $ua=count($fv); $a<$ua; $a++) { $fv[$a] = rtrim($fv[$a]); if($fv[$a] > $num[11] || $y > $dif) break; $z = Qnr::key($keyass, $key, $num, $dif, $fv[$a], $y); if($z) $key = $z[0]; $y = $z[1]; }} return [$key,$y]; }
    private static function num($key, $num, $dif, $pos, $fv, $fn, $x, $opz) { if($opz) { for($a=$pos; $a>1; $a--) { $fv[$a] = rtrim($fv[$a]); if($fv[$a] < $num[10] || $x > $dif) break; $key['val'][$x] = $fv[$a]; $key['num'][$x] = (int)$fn[$a]; $x++; }} else { for($a=$pos, $ua=count($fv); $a<$ua; $a++) { $fv[$a] = rtrim($fv[$a]); if($fv[$a] > $num[11] || $x > $dif) break; $key['val'][$x] = $fv[$a]; $key['num'][$x] = (int)$fn[$a]; $x++; }} return [$key,$x]; }
    
    protected static function numerico($num, $numass, $type, $ccc, $valok) { if(is_array($num[1])) return false; if($ccc) { if($type) $keyass = SYS::combina($valok,2).'/@'; else $keyass = SYS::combina($ccc,2).'/@'; $tmp = SYS::combina($numass[1]); foreach($tmp as $a) $keyass .= '/'.$a; } else $keyass = SYS::combina($numass[1],2); $e = explode(' ',$num[1],2); $per = SYS::combina($e[0]); if(!is_array($per)) return false; $val = array($num[1]); if(is_array($num[13])) { foreach($num[13] as $a) if(strpos($a,'{') > 1) $val[] = $a; } if(count($val) > 1 || $numass[7] == '#') { global $QprcPersonal; $Qmol = $QprcPersonal; } else $Qmol = 1; $keys = $keyass; $keyval = false; $tmp = []; $x = 0; $y = 0;
        for($v=0, $uv=count($val); $v<$uv; $v++) { $e = false; SYS::$dataval = false; if($val[$v][0] == '_' || $val[$v][1] == '_') SYS::$dataval = true; if($v) { $num = Qout::analisi($val[$v]); $e = explode(' ',$num[1],2); $per = SYS::combina($e[0]); if(!is_array($per)) return false; } else { if(isset($numass[0]) && $numass[0] != '' && $num[0] == '' && $numass[7] == '') { $num[0] = $numass[0]; $num[2] = $numass[2]; $num[6] = $numass[6]; }} if($numass[8] == '#') $num[14] = ''; $keyass = SYS::c($keys,$per); if(isset($e[1])) $keyass = SYS::c($keyass,$e[1]); $flist = "$keyass/list.php";
            if(file_exists($flist)){ $list = file($flist); $key = []; if($num[0] == '') { global $Qposdef; $num[0] = $Qposdef*$Qmol - 1; $num[2] = 0; } elseif($num[2] == -1) { $num[0] = $num[0]*$Qmol - 3; $num[2] = 0; } else { if($num[6]) { $num[0] -= 2; $num[2] = ($num[2]+2)*$Qmol-2; } else $num[0] = $num[0]*$Qmol - 2; } if($num[15] == 1) { $f = explode('#',$list[count($list)-1]); $num[11] = $f[1]; } elseif($num[15] == 2) { $f = explode('#',$list[2]); $num[11] = $num[10]; $num[10] = $f[0]; } if($num[6]) $dif = $num[2]; else $dif = $num[0]; if($num[12]) { $fine = 2; $inizio = count($list)-1; } else { $inizio = 2; $fine = count($list)-1; }
                for($a=2, $ua=count($list); $a<$ua; $a++) { $f = explode('#',$list[$a]); if($num[10] >= $f[0]) { if($num[12]) $fine = $a; else $inizio = $a; } if($num[11] <= $f[1]) { if($num[12]) $inizio = $a; else $fine = $a; break; }} $fn = file("$keyass/n$inizio.php"); $fv = file("$keyass/v$inizio.php");
                if($num[12]){ $pos = SYS::ordina($num[11], $fv, 1, 0); 
                    if($num[14]){ $x = Qnr::num($key, $num, $dif, $pos, $fv, $fn, $x, true); $key = $x[0]; $x = $x[1]; for($a=$inizio-1; $a>=$fine; $a--) { $fn = file("$keyass/n$a.php"); $fv = file("$keyass/v$a.php"); $x = Qnr::num($key, $num, $dif, count($fv)-1, $fv, $fn, $x, true); $key = $x[0]; $x = $x[1]; }} else { $y = Qnr::idem($keyass, $key, $num, $dif, $pos, $fv, $x, $y, true); $key = $y[0]; $y = $y[1]; for($a=$inizio-1; $a>=$fine; $a--) { $fv = file("$keyass/v$a.php"); $y = Qnr::idem($keyass, $key, $num, $dif, count($fv)-1, $fv, $x, $y, true); $key = $y[0]; $y = $y[1]; }}
                } else { $pos = SYS::ordina($num[10], $fv, 0, 0);
                    if($num[14]){ $x = Qnr::num($key, $num, $dif, $pos, $fv, $fn, $x, false); $key = $x[0]; $x = $x[1]; for($a=$inizio+1; $a<=$fine; $a++) { $fn = file("$keyass/n$a.php"); $fv = file("$keyass/v$a.php"); $x = Qnr::num($key, $num, $dif, 2, $fv, $fn, $x, false); $key = $x[0]; $x = $x[1]; }} else { $y = Qnr::idem($keyass, $key, $num, $dif, $pos, $fv, $x, $y, false); $key = $y[0]; $y = $y[1]; for($a=$inizio+1; $a<=$fine; $a++) { $fv = file("$keyass/v$a.php"); $y = Qnr::idem($keyass, $key, $num, $dif, 2, $fv, $x, $y, false); $key = $y[0]; $y = $y[1]; }}
                } if(!$key) return false;
                if($y && $num[14] == '') { if($v) $tmp = array_intersect($key,$tmp); else { if($num[5]) $key = array_reverse($key); if($num[2]) { if($num[6]) $tmp = array_reverse(array_slice($key,$num[0])); else $tmp = array_slice($key,$num[2]); } else $tmp = $key; }}
             }
         } if($numass[7] == '#' && $num[14] == '') { $tmp = array_values($tmp); if($num[3]){ if($num[5]) rsort($tmp); else sort($tmp); } return $tmp; }
         if($x) { $keyval['K'][0] = $num[14]; $tot = 0; $n = 0; if($num[6]) { for($a=$x-1; $a>=$num[0]; $a--) { $keyval[$num[14]][] = $key['val'][$a]; $keyval['N.'.$num[14]][] = $key['num'][$a]; $tot += $key['num'][$a]; $n++; }} else { for($a=$num[2]; $a<$x; $a++) { $keyval[$num[14]][] = $key['val'][$a]; $keyval['N.'.$num[14]][] = $key['num'][$a]; $tot += $key['num'][$a]; $n++; }} $keyval['T.'.$num[14]] = $tot; 
            if($num[17]) { if($num[18]) { if($num[17] == 1) array_multisort($keyval['N.'.$num[14]],SORT_DESC,SORT_NUMERIC,$keyval[$num[16]]); elseif($num[17] == 2) array_multisort($keyval['N.'.$num[14]],SORT_ASC,SORT_NUMERIC,$keyval[$num[16]]); } else { if($num[17] == 1) array_multisort($keyval[$num[14]],SORT_ASC,SORT_FLAG_CASE,$keyval['N.'.$num[16]]); elseif($num[17] == 2) array_multisort($keyval[$num[14]],SORT_DESC,SORT_FLAG_CASE,$keyval['N.'.$num[16]]); }} $keyval['N'] = $n; $keyval['T'] = SYS::tot($keys); return $keyval; 
         } return false;
    }
}