<?php

namespace Quantico;

class Qnr extends Qout
{
    protected static function numerico($keyass,$num,$numass,$valass=0) { $e = explode(' ',$num[1]); $per = fx::combina($e[0]); if(!is_array($per)) return false; global $Qposdef; $val = array($num[1]); if(is_array($num[13])) { foreach($num[13] as $a) if(strpos($a,'{') > 1) $val[] = $a; } if(count($val) > 1 or $numass[7] == '#') { global $QprcPersonal; $Qmol = $QprcPersonal; } else $Qmol = 1; $keys = $keyass; $keyval = false; $tmp = array(); $x = 0; $y = 0; for($v=0; $v<count($val); $v++) { if($v) { $num = Qout::analisi($val[$v]); $e = explode(' ',$num[1]); $per = fx::combina($e[0]); if(!is_array($per)) return false; } else { if(isset($numass[0]) and $numass[0] != '' and $num[0] == '' and $numass[7] == '') { $num[0] = $numass[0]; $num[2] = $numass[2]; $num[6] = $numass[6]; }} if($numass[8] == '#') $num[14] = ''; $keyass = Qout::cc($keys,$per); if(isset($e[1])) $keyass = Qout::cc($keyass,$e[1]); $flist = $keyass.'/list.php';
        if(file_exists($flist)){ $list = file($flist); $key = array(); if($num[0] == '') { $num[0] = $Qposdef*$Qmol - 1; $num[2] = 0; } elseif($num[2] == -1) { $num[0] = $num[0]*$Qmol - 3; $num[2] = 0; } else { if($num[6]) { $num[0] -= 2; $num[2] = ($num[2]+2)*$Qmol-2; } else $num[0] = $num[0]*$Qmol - 2; } if($num[15] == 1) { $f = explode('#',$list[count($list)-1]); $num[11] = $f[1]; } elseif($num[15] == 2) { $f = explode('#',$list[2]); $num[11] = $num[10]; $num[10] = $f[0]; } if($num[6]) $dif = $num[2]; else $dif = $num[0]; if($num[12]) { $fine = 2; $inizio = count($list)-1; } else { $inizio = 2; $fine = count($list)-1; } for($a=2; $a<count($list); $a++) { $f = explode('#',$list[$a]); if($num[10] >= $f[0]) { if($num[12]) $fine = $a; else $inizio = $a; } if($num[11] <= $f[1]) { if($num[12]) $inizio = $a; else $fine = $a; break; }} $fn = file($keyass."/n$inizio.php"); $fv = file($keyass."/v$inizio.php"); 
        if($num[12]){ $pos = fx::ordina($num[11],$fv,1); if($num[14]){ for($a=$pos; $a>1; $a--) { $fv[$a] = rtrim($fv[$a]); if($fv[$a] < $num[10] or $x > $dif) break; $key['val'][$x] = $fv[$a]; $key['num'][$x] = rtrim($fn[$a]); $x++; } for($a=$inizio-1; $a>=$fine; $a--) { $fn = file($keyass."/n$a.php"); $fv = file($keyass."/v$a.php"); for($b=count($fv)-1; $b>1; $b--) { $fv[$b] = rtrim($fv[$b]); if($fv[$b] < $num[10] or $x > $dif) break; $key['val'][$x] = $fv[$b]; $key['num'][$x] = rtrim($fn[$b]); $x++; }}} else { for($a=$pos; $a>1; $a--) { $fv[$a] = rtrim($fv[$a]); if($fv[$a] < $num[10] or $x > $dif) break; $keyper = fx::lh($keyass,Qhash($fv[$a])).'/idem.php'; if(file_exists($keyper)){ $fi = file($keyper); if($num[5]) { for($b=2; $b<count($fi); $b++){ if($y > $dif) break; if($num[3]){ $z = substr($fi[$b],0,10); if($z >= $num[3] and $z <= $num[4]) { $key[$y] = $fi[$b]; $y++; }} else { $key[$y] = $fi[$b]; $y++; }}} else { for($b=count($fi)-1; $b>1; $b--){ if($y > $dif) break; if($num[3]){ $z = substr($fi[$b],0,10); if($z >= $num[3] and $z <= $num[4]) { $key[$y] = $fi[$b]; $y++; }} else { $key[$y] = $fi[$b]; $y++; }}}}} 
        for($a=$inizio-1; $a>=$fine; $a--) { $fv = file($keyass."/v$a.php"); for($b=count($fv)-1; $b>1; $b--) { $fv[$b] = rtrim($fv[$b]); if($fv[$b] < $num[10] or $x > $dif) break; $keyper = fx::lh($keyass,Qhash($fv[$b])).'/idem.php'; if(file_exists($keyper)){ $fi = file($keyper); if($num[5]) { for($c=2; $c<count($fi); $c++){ if($y > $dif) break; if($num[3]){ $z = substr($fi[$c],0,10); if($z >= $num[3] and $z <= $num[4]) { $key[$y] = $fi[$c]; $y++; }} else { $key[$y] = $fi[$c]; $y++; }}} else { for($c=count($fi)-1; $c>1; $c--){ if($y > $dif) break; if($num[3]){ $z = substr($fi[$c],0,10); if($z >= $num[3] and $z <= $num[4]) { $key[$y] = $fi[$c]; $y++; }} else { $key[$y] = $fi[$c]; $y++; }}}}}}}} else { $pos = fx::ordina($num[10],$fv); if($num[14]){ for($a=$pos; $a<count($fv); $a++) { $fv[$a] = rtrim($fv[$a]); if($fv[$a] > $num[11] or $x > $dif) break; $key['val'][$x] = $fv[$a]; $key['num'][$x] = rtrim($fn[$a]); $x++; } for($a=$inizio+1; $a<=$fine; $a++) { $fn = file($keyass."/n$a.php"); $fv = file($keyass."/v$a.php"); for($b=2; $b<count($fv); $b++) { $fv[$b] = rtrim($fv[$b]); if($fv[$b] > $num[11] or $x > $dif) break; $key['val'][$x] = $fv[$b]; $key['num'][$x] = rtrim($fn[$b]); $x++; }}} else { 
        for($a=$pos; $a<count($fv); $a++) { $fv[$a] = rtrim($fv[$a]); if($fv[$a] > $num[11] or $y > $dif) break; $keyper = fx::lh($keyass,Qhash($fv[$a])).'/idem.php'; if(file_exists($keyper)){ $fi = file($keyper); if($num[5]) { for($b=2; $b<count($fi); $b++){ if($y > $dif) break; if($num[3]){ $z = substr($fi[$b],0,10); if($z >= $num[3] and $z <= $num[4]) { $key[$y] = $fi[$b]; $y++; }} else { $key[$y] = $fi[$b]; $y++; }}} else { for($b=count($fi)-1; $b>1; $b--){ if($y > $dif) break; if($num[3]){ $z = substr($fi[$b],0,10); if($z >= $num[3] and $z <= $num[4]) { $key[$y] = $fi[$b]; $y++; }} else { $key[$y] = $fi[$b]; $y++; }}}}} for($a=$inizio+1; $a<=$fine; $a++) { $fv = file($keyass."/v$a.php"); for($b=2; $b<count($fv); $b++) { $fv[$b] = rtrim($fv[$b]); if($fv[$b] > $num[11] or $x > $dif) break; $keyper = fx::lh($keyass,Qhash($fv[$b])).'/idem.php'; if(file_exists($keyper)){ $fi = file($keyper); if($num[5]) { for($c=2; $c<count($fi); $c++){ if($y > $dif) break; if($num[3]){ $z = substr($fi[$c],0,10); if($z >= $num[3] and $z <= $num[4]) { $key[$y] = $fi[$c]; $y++; }} else { $key[$y] = $fi[$c]; $y++; }}} else { for($c=count($fi)-1; $c>1; $c--){ if($y > $dif) break; if($num[3]){ $z = substr($fi[$c],0,10); if($z >= $num[3] and $z <= $num[4]) { $key[$y] = $fi[$c]; $y++; }} else { $key[$y] = $fi[$c]; $y++; }}}}}}} if(!$key) return false; }
        if($y and $num[14] == '') { if($v) $tmp = array_intersect($key,$tmp); else { if($num[5]) $key = array_reverse($key); if($num[2]) { if($num[6]) $tmp = array_reverse(array_slice($key,$num[0])); else $tmp = array_slice($key,$num[2]); } else $tmp = $key; }}}} if($numass[7] == '#' and $num[14] == '') return array_values($tmp); if($x) { $keyval['K'][0] = $num[14]; $tot = 0; $n = 0; if($num[6]) { for($a=$x-1; $a>=$num[0]; $a--) { $keyval[$num[14]][] = $key['val'][$a]; $keyval['N.'.$num[14]][] = $key['num'][$a]; $tot += $key['num'][$a]; $n++; }} else { for($a=$num[2]; $a<$x; $a++) { $keyval[$num[14]][] = $key['val'][$a]; $keyval['N.'.$num[14]][] = $key['num'][$a]; $tot += $key['num'][$a]; $n++; }} $keyval['T.'.$num[14]] = $tot; if($num[17]) { if($num[18]) { if($num[17] == 1) array_multisort($keyval['N.'.$num[14]],SORT_DESC,SORT_NUMERIC,$keyval[$num[16]]); elseif($num[17] == 2) array_multisort($keyval['N.'.$num[14]],SORT_ASC,SORT_NUMERIC,$keyval[$num[16]]); } else { if($num[17] == 1) array_multisort($keyval[$num[14]],SORT_ASC,SORT_FLAG_CASE,$keyval['N.'.$num[16]]); elseif($num[17] == 2) array_multisort($keyval[$num[14]],SORT_DESC,SORT_FLAG_CASE,$keyval['N.'.$num[16]]); }} $keyval['N'] = $n; $keyval['T'] = fx::tot($keys); return $keyval; } return false;
    }
}

?>