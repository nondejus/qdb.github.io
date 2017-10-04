<?php

namespace Quantico;

class Qml extends Qin
{
    protected static function creamodir($mod, $per, $perass, $dirass, $ora) { global $Qdatabase; $dir = $Qdatabase; foreach($dirass as $f) $dir .= '/'.$f; $dir .= '/@'; Qdel::ix($dir); foreach($perass as $f) { $dir .= '/'.$f; Qdel::ix($dir); } $md = explode('.',$mod); $per = SYS::lh($per,Qhash($md[0])); $mk = file("$per/keys.php"); $ml = file("$per/link.php"); $n = 1; for($a=2, $ua=count($mk); $a<$ua; $a++) { $per = $dir; if(strlen($ml[$a]) < 64) { $e = explode('.',rtrim($mk[$a])); $per .= '/.'.$e[0]; Qdel::ix($per); for($f=1, $uf=count($e); $f<$uf; $f++) { $per .= '/'.$f; Qdel::ix($per); } Qin::Querin($per, SYS::val($ml[$a]), $ml[$a], $ora.$mod."\n"); } else { if($md[$n]) { $dirass = $Qdatabase.'/@'; $e = explode('.',$mk[$a]); $dirass .= '/'.$e[0]; $per .= '/.'.$e[0]; Qdel::ix($per); for($f=1, $uf=count($e)-1; $f<$uf; $f++) { $dirass .= '/'.$f; $per .= '/'.$f; Qdel::ix($per); } $dirass = SYS::lh($dirass,Qhash($md[$n])); $fk = file("$dirass/keys.php"); $fl = file("$dirass/link.php"); for($b=2, $ub=count($fk); $b<$ub; $b++) { if(strlen($fl[$b]) < 64) { $p = $per; $e = explode('.',rtrim($fk[$b])); $p .= '/.'.$e[0]; Qdel::ix($p); for($f=1, $uf=count($e); $f<$uf; $f++) { $p .= '/'.$f; Qdel::ix($p); } Qin::Querin($p, SYS::val($fl[$b]), $fl[$b], $ora.$mod."\n"); }}} $n++; }}}
    protected static function creamodello($per, $fi, $fk=false, $fl=false) { global $Qprotezione; global $Qlivtime; $m = substr($fi[2],8-$Qlivtime,$Qlivtime+2); $km = "$per/m/m$m.php"; $str = rtrim($fi[2]); if($fk){ for($a=2, $u=count($fl); $a<$u; $a++) if(strlen($fl[$a]) < 64) $str .= rtrim($fl[$a]); } $str .= "\n"; $mod = 0; if(file_exists($km)){ $fp = file($km); $mod = array_search($str,$fp); } else { Qdel::ix("$per/m"); Qdel::ix("$per/p"); w($km,$Qprotezione); w("$per/p/p$m.php",$Qprotezione); } if(!$mod){ $ky = "$per/index.php"; $fp = file($ky); $mod = (int)$fp[2] + 1; $b = Qin::m($per,Qhash($mod)); if(!is_dir($b)) mkdir($b,0755); w("$b/index.php", $fi); if($fk) { w("$b/keys.php", $fk); w("$b/link.php", $fl); } w($ky,$Qprotezione.$mod); a($km,$str); a("$per/p/p$m.php",$mod."\n"); } else { $ok = false; $fp= file("$per/p/p$m.php"); $mod = rtrim($fp[$mod]); if($fl){ $ky = $per; $per = SYS::lh($per,Qhash($mod)); $keyk = "$per/keys.php"; $keyl = "$per/link.php"; if(file_exists($keyk)){ $mk = file($keyk); $ml = file($keyl); } else { $mk[0] = $fk[0]; $ml[0] = $fl[0]; $mk[1] = $fk[1]; $ml[1] = $fl[1]; } for($a=2, $u=count($fl); $a<$u; $a++) { if(strlen($fl[$a]) > 64) { $j = array_search($fl[$a],$ml); if($j < 2) { $mk[] = $fk[$a]; $ml[] = $fl[$a]; $ok = true; }}} if($ok) { w($keyk,$mk); w($keyl,$ml); }}} return $mod; }
    protected static function modello($key, $keyass, $val, $valass, $ora, $tdb) { if($val == NULL) return SYS::error(1,11,$keyass); if($valass == NULL) return SYS::error(1,11,$key); $per = SYS::combina($key);
        if($per) { $perass = SYS::combina($keyass);
            if($perass) { if(!is_numeric($val) || strstr($val,'.')) return SYS::error(1,12,$key); $hash = SYS::hashpos(Qhash($val), $per); $hashindex = "$hash/index.php"; $hashkeys = "$hash/keys.php"; $hashlink = "$hash/link.php"; $hashstat = "$hash/stat.php"; if(!file_exists($hashindex)) return SYS::error(1,5,$key); $hashpos = SYS::hashpos(Qhash($valass), $perass); $indexpos = "$hashpos/index.php"; if(!file_exists($indexpos)) return SYS::error(1,5,$keyass); global $Qdatabase;
                $linkphp = "$hashpos/keys.php"; $linkpos = "$hashpos/link.php"; $keyper = "$Qdatabase/@"; $keyper1 = "$Qdatabase/1"; $keyperc = $Qdatabase; $plk = ''; Qdel::protezione($linkphp,$linkpos); foreach($per as $corso) { $plk .= $corso.'.'; $keyper .= '/'.$corso; $keyper1 .= '/'.$corso; $keyperc .= '/'.$corso; Qdel::ix($keyper1); Qdel::ix($keyper,1); } $fx = file($indexpos); $fi = file($hashindex); $corso = $keyperc; $keyperc .= '/keyc.php'; $fi[3] = $val."\n"; $plp = $plk; $plk .= "1\n"; if(file_exists($hashkeys)) { $fk = file($hashkeys); $fl = file($hashlink); if(file_exists($hashstat)) { $fs = file($hashstat); for($c=2, $uc=count($fs); $c<$uc; $c++) if($fs[$c] == "0\n") { $fk = SYS::cancella($fk,$c); $fl = SYS::cancella($fl,$c); }} $mod = Qml::creamodello($keyper, $fi, $fk, $fl); } else $mod = Qml::creamodello($keyper, $fi); $fk = file($linkphp); $j = array_search($plk, $fk); 
                if($j > 1) { $fl = file($linkpos); $pos = Qdel::scrivi($Qdatabase.'/'.rtrim($fl[$j]) ,$ora ,"\n" ,0 ,$mod."\n" ,0 ,1).'@'.rtrim($fl[$j]); } else { $keyper = Qin::crea($keyper1, $mod, 1, 1); $msg = substr($keyper,$tdb); a($linkphp,$plk); a($linkpos,$msg."\n"); $pos = '2.2@'.$msg; } $keyper = $Qdatabase.'/'.$perass[0]; $msg = $perass[0]; for($a=1, $ua=count($perass); $a<$ua; $a++) { $keyper .= '/'.$perass[$a]; $msg .= '.'.$perass[$a]; } $lnk = $msg.'#'.$plk; $dir = $msg.'.1'; $msg = $msg."\n"; Qdel::protezione($keyperc); $linkphp = "$keyper/keys.php"; $linkpos = "$keyper/keyn.php"; $corso .= '/'.$dir; $fp = file($keyperc); $j = array_search($msg, $fp); if($j < 2) { a($keyperc,$msg); Qdel::ix($corso); } Qdel::protezione($linkphp,$linkpos); $f = Qdel::scrivi($corso ,$ora ,"\n" ,0 ,$fx[2] ,$mod, 1); $fp = file($linkphp); $j = array_search($plk,$fp);
                if($j > 1) { $fl = file($linkpos); $fl[$j] = ((int)$fl[$j] + 1)."\n"; w($linkpos,$fl); } else { a($linkphp,$plk); a($linkpos,"1\n"); } $k = explode('@',$pos); $p = explode('.',$f); $plp .= $p[0]."\n"; $keyperc = $Qdatabase.'/'.$k[1].'/keyc.php'; Qdel::protezione($keyperc); $fp = file($keyperc); $j = array_search($plp,$fp); if($j < 2) a($keyperc,$plp); $lk = file($Qdatabase.'/link.php'); $j = array_search($lnk,$lk); if($j < 2) a($Qdatabase.'/link.php',$lnk); return base64_encode($pos.'@'.$dir.'@'.$f.'@'.base64_encode($valass).'@'.$val);
            }
        } return false;
    }
    protected static function dettagli($key, $val, $valass, $ora) { $key = substr($key, 1); $n = 0; if(is_array($val)) { $ak = array_keys($val); $al = array_values($val); for($a=0, $ua=count($ak); $a<$ua; $a++) { if($ak[$a][0] == '#') $ak[$a] = substr($ak[$a],1); if(is_numeric($ak[$a])) return SYS::error(1,10); $per = SYS::combina($ak[$a]); if($per) { $hash = SYS::hashpos(Qhash($al[$a]), $per); $hashindex[$n] = "$hash/index.php"; if(file_exists($hashindex[$n])) { $hashkeys[$n] = "$hash/keys.php"; $hashlink[$n] = "$hash/link.php"; $hashstat[$n] = "$hash/stat.php"; $plk[$n] = ''; foreach($per as $b) $plk[$n] .= $b.'.'; $plk[$n] .= "0\n"; $tper[$n] = $per; $n++; } else SYS::error(1,11,$ak[$a]); }}} if(!$n) return false; $valass = base64_decode($valass); $m = '';
        if(strpos($valass, '@')) { $l = explode('@',$valass); if(!isset($l[5])) return false; $perass = SYS::combina($key); if(!$perass) return false; global $Qdatabase; global $Qlivtime; foreach($perass as $a) $m .= '/'.$a; $mr = $Qdatabase.'/@'.$m; $msg = '1'.$m.'/'; $q = explode('.',$l[3]); $ky = explode('.',$l[2]); array_pop($ky); $dir = $Qdatabase.$m.'/'.$l[2].'/c'.$q[0].'.php'; 
            if(strstr($l[1], $msg)) { $v = explode('.',$l[0]); $pos = $Qdatabase.'/'.$l[1].'/v'.$v[0].'.php'; if(!file_exists($pos)) return false; $si = false; $vv = false; $tmp = explode('/',$l[1]); $e = $tmp[1]; $b = 901; for($a=2, $ua=count($tmp)-$Qlivtime-1; $a<$ua; $a++) { $e .= '.'.$tmp[$a]; $b++; } $fp = file($pos); 
                for($w=0; $w<$n; $w++) { $x = rtrim($fp[$v[1]]); if(strpos($x, '.')) { $y = explode('.', $x); $z = $y[0]; } else { $y = 0; $z = $x; } $fi = file($hashindex[$w]); $fi[3] = $al[$w]."\n"; $m = SYS::lh($mr,Qhash($z)); $poskeys = $m.'/keys.php'; $poslink = $m.'/link.php'; 
                    if(file_exists($poskeys)) { $fk = file($poskeys); $keyper = $Qdatabase.'/@'; $j = array_search($plk[$w], $fk); if($j > 2) { foreach($tper[$w] as $a) { $keyper .= '/'.$a; Qdel::ix($keyper,1); } if(file_exists($hashkeys[$w])) { $fk = file($hashkeys[$w]); $fl = file($hashlink[$w]); if(file_exists($hashstat[$w])) { $fs = file($hashstat[$w]); for($c=2, $uc=count($fs); $c<$uc; $c++) if($fs[$c] == "0\n") { $fk = SYS::cancella($fk,$c); $fl = SYS::cancella($fl,$c); }} $mod = Qml::creamodello($keyper, $fi, $fk, $fl); } else $mod = Qml::creamodello($keyper, $fi); $i = 0; $d = 0; $h = -1; $fl = file($poslink); for($a=2, $ua=count($fl); $a<$ua; $a++) if(strlen($fl[$a]) > 64) { $i++; if($a == $j) { $h++; $z .= '.'.$mod; if($mod != $y[$i]) { $si = true; Qin::Qdbin( $ak[$h].'#'.$e.'.'.$l[2],$l[4],$al[$h],$b,1); if($y[$i] > 0) { if(!$vv) { $id = file(SYS::lh($keyper,Qhash($y[$i])).'/index.php'); $vv = rtrim($id[3]); } if($vv) Qdel::Qdbdel($ak[$h].'#'.$e.'.'.$l[2],$l[4],$vv,$b+100); }}} else { $d++; if($y) $z .= '.'.$y[$d]; else $z .= '.0'; }} $fp[$v[1]] = $z."\n"; }}
                } if($si) { $fx = file($dir); $fx[$q[1]] = $fp[$v[1]]; w($dir,$fx); w($pos,$fp); if(Qin::Qdbin($e,$z,NULL,998)){ $Qdatabase = substr($Qdatabase,0,-2); Qin::Qdbin($e.'#'.$l[2],$l[4],$z,1000+$l[5],1); Qml::creamodir($z,$mr,$perass,$ky,$ora); } if($vv) Qdel::Qdbdel('@.'.$e.'.@#'.$l[2],$l[4],$x,1971); return true; }
            }
        } return false;
    }
}