<?php

namespace Quantico;

class Qst extends SYS
{
    private static function number($key, $chiaro, $j){ $hashpos = "$key/list.php"; if(file_exists($hashpos)){ $h = file($hashpos); $f = explode('#',$h[2]); if($chiaro == $f[0]) { $fn = file("$key/n2.php"); if(isset($fn[2])) { if($fn[2] == "1\n") { $fv = file("$key/v2.php"); $f[2] = (int)$f[2] - 1; if($f[2] > 0) $h[2] = rtrim($fv[3]).'#'.$f[1].'#'.$f[2]."\n"; else $h[2] = $f[1].'#'.$f[1].'#'.$f[2]."\n"; $fn = SYS::cancella($fn,2); $fv = SYS::cancella($fv,2); w("$key/n2.php",$fn); w("$key/v2.php",$fv); } else { if($j > 1) { $f[2] = (int)$f[2] - 1; $h[2] = $f[0].'#'.$f[1].'#'.$f[2]."\n"; $fn[2] = ((int)$fn[2] - 1)."\n"; w("$key/n2.php",$fn); }}}} else { $pos = count($h); $min = $pos - 1; $f = explode('#',$h[$min]); 
        if($chiaro == $f[1]) { $fn = file("$key/n$min.php"); $max = count($fn)-1; if($fn[$max] == "1\n") { if(count($fn) > 3) { $fv = file("$key/v$min.php"); $f[2] = (int)$f[2] - 1; $h[$min] = $f[0].'#'.rtrim($fv[count($fv)-2]).'#'.$f[2]."\n"; array_pop($fn); array_pop($fv); w("$key/n$min.php",$fn); w("$key/v$min.php",$fv); } else { array_pop($h); unlink("$key/n$min.php"); unlink("$key/v$min.php"); }} else { if($j > 1) { $f[2] = (int)$f[2] - 1; $h[2] = $f[0].'#'.$f[1].'#'.$f[2]."\n"; $fn[$max] = ((int)$fn[$max] - 1)."\n"; w("$key/n2.php",$fn); }}} else { for($b=2; $b<$pos; $b++){ $f = explode('#',$h[$b]);
        if($chiaro >= $f[0] && $chiaro <= $f[1]) { if($f[2] > 0) { $f[2] = (int)$f[2] - 1; $h[$b] = $f[0].'#'.$f[1].'#'.$f[2]."\n"; $fn = file("$key/n$b.php"); $fv = file("$key/v$b.php"); $j = array_search($chiaro."\n",$fv); if($j > 1) { $fn[$j] = (int)$fn[$j] - 1; if($fn[$j] < 1) { $fn = SYS::cancella($fn,$j); $fv = SYS::cancella($fv,$j); w("$key/v$b.php",$fv); } else $fn[$j] .= "\n"; w("$key/n$b.php",$fn); }} break; }}}} w($hashpos,$h); }
    }
    protected static function stat1($keyass, $hashpos, $dir, $del) { $f = file("$hashpos/index.php"); $chiaro = mb_strtolower(trim(SYS::val($del)),'UTF-8'); if(SYS::$dataval) { SYS::$dataval = false; $chiaro = SYS::dataval($chiaro); } $hashpos = SYS::combina($keyass,2).'/'.$dir; $key = $hashpos; $hashpos = SYS::lh($hashpos,Qhash($chiaro)); $keyass = $hashpos.'/index.php'; $hashpos .= '/idem.php';
        if(file_exists($hashpos)){ $h = file($hashpos); $j = array_search($f[2],$h); if($j > 1) { if(SYS::$update) $h[$j] = SYS::$update; else $h = SYS::cancella($h,$j); w($hashpos,$h); } if(!SYS::$update) { $h = file($keyass); $h[2]--; w($keyass,$h); } if(is_numeric($chiaro) && !SYS::$update) Qst::number($key, $chiaro, $j); } $dir = []; $t = SYS::trak($chiaro); $s = $t[0][0]; $str[0] = $t[0]; $a = 0; 
        for($b=1,$u=count($t); $b<$u; $b++) { if($s == $t[$b][0]) $str[$a] .= $t[$b]; else { $dir[] = Qord($str[$a]); $a++; $s = $t[$b][0]; $str[$a] = $t[$b]; }} $dir[] = Qord($str[$a]); for($a=0,$u=count($dir); $a<$u; $a++) { $f = "$key/$dir[$a]"; $ftraccia = "$f/keyt.php"; $fstato = "$f/stat.php"; $fcript = "$f/keyc.php"; $findex = "$f/keyi.php"; 
            if(file_exists($fcript)){ $ftc = file($fcript); $j = array_search($del,$ftc); if($j > 1) { $fti = file($findex); if(SYS::$update) $fti[$j] = SYS::$update; else { $ftr = file($ftraccia); $fts = file($fstato); $ftr = SYS::cancella($ftr,$j); $fts = SYS::cancella($fts,$j); $ftc = SYS::cancella($ftc,$j); $fti = SYS::cancella($fti,$j); w($ftraccia,$ftr); w($fstato,$fts); w($fcript,$ftc); } w($findex,$fti); }}
        }
    }
}