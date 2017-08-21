<?php

namespace Quantico;

class Qdk extends Qout
{
    protected static function key($key, $keyass, $valass, $opz, $type, $ora) { global $Qdatabase; global $keybase; $numkeyass = Qout::analisi(substr($keyass,1)); $per = SYS::combina($numkeyass[1]);
        if($per) { if(strlen($type) > 4) $hashpos = $type.'/'; else $hashpos = SYS::hashpos(Qhash($valass), $per).'/'; 
            if($key[0] == '#') { $numkeyass = Qout::analisi($key); $key = substr($numkeyass[1],1); $ok = true; $tempo = false; $ky = ''; if(strpos($key,':') > 1) { $x = explode(':',$key); $key = $x[0]; $tempo = $x[1]; } $x = explode('.',$key); for($a=0, $u=count($x); $a<$u; $a++) { $b = array_search($x[$a]."\n",$keybase); if($b > 1) $ky .= $b.'.'; else return false; } 
                if($tempo) $hashpos .= $tempo.'-'.$ky.'0.php'; else { if(file_exists($hashpos.'keys.php')){ $fp = file($hashpos.'keys.php'); $b = array_search($ky."0\n",$fp); if($b > 1) { $fp = file($hashpos.'link.php'); $hashpos = $Qdatabase.'/'.rtrim($fp[$b]).'/log.php'; } else return false; } else return false; }
            } else { $ok = false; if($key[0] == '_') $key = substr($key,1); $x = explode('.',$key); for($a=0, $u=count($x); $a<$u; $a++) { $b = array_search($x[$a]."\n",$keybase); if($b > 1) $hashpos .= $b.'.'; else return false; } $hashpos .= 'php'; } if(file_exists($hashpos)){ $fp = file($hashpos); if($numkeyass[3]) { $low = SYS::binary($numkeyass[3],$fp,0); $high = SYS::binary($numkeyass[4],$fp,1); $fp = array_slice($fp,$low,$high-$low+1); } else $fp = array_slice($fp,2); if(!$fp) return false; $tot = count($fp); if($tot < 1) return false; $fp = Qout::selezione(array_reverse($fp),$numkeyass); $keyval = array(); 
                for($a=0, $u=count($fp); $a<$u; $a++) { if(strlen($fp[$a]) == 11) $keyval[$a] = null; else { if($ok) { if($fp[$a][10] == '#') $keyval[$a] = SYS::val(substr($fp[$a],11)); elseif($fp[$a][11] == '#') $keyval[$a] = '-'.SYS::val(substr($fp[$a],12)); else $keyval[$a] = rtrim(substr($fp[$a],10)); } else $keyval[$a] = SYS::val($fp[$a]); } if($qt=Qout::tempo($opz,$fp[$a],$ora)) $keyval["t.$a"] = $qt; } if($keyval) { if($opz == '-1' || $opz == '-2') $keyval['N'] = count($keyval)/2; else $keyval['N'] = count($keyval); $keyval['T'] = $tot; return $keyval; }
            }
        } return false;
    }
    protected static function mix($key, $valass, $opz, $type, $ora) { global $Qdatabase; global $Qpostime; global $keybase; $key = substr($key, 1);
        if($opz > 0) { $ccc = strpos($key, '@'); $ccl = strpos($key, '#'); if($ccc > 0) { if($ccl > 0) { if($ccc < $ccl) { $keyass = substr($key,0,$ccc); $key = substr($key,$ccc); } else { $keyass = substr($key,0,$ccl); $key = substr($key,$ccl); }} else { $keyass = substr($key,0,$ccc); $key = substr($key,$ccc); }} else { if($ccl > 0) { $keyass = substr($key,0,$ccl); $key = substr($key,$ccl); } else { $keyass = $key; $key = ''; }} if($keyass[0] == '$') $per = SYS::combina(substr($keyass,1),2).'/-0/'; else $per = SYS::combina($keyass,2).'/-0/'; $keyperindex = $per.'index.php'; if(file_exists($keyperindex)) { $fk = file($keyperindex); for($a=2, $u=count($fk); $a<$u; $a++) { $n = explode('.', $fk[$a]); if(count($n) > 2) { if($opz >= $n[0] && $opz <= $n[1]) { $pert = $per.$a.'.php'; break; }} elseif(count($n) == 2) $pert = $per.$a.'.php'; }} else return false;
            if(file_exists($pert)) { $fp = file($pert); $j = array_search($opz."\n",$fp);
                if($j > 1) { $fp = file($per.'v2.php'); $id = $opz.rtrim($fp[$j]); $per .= substr($id, 0, 4).'/'.substr($id, 4, 4).'/'.substr($id, 8, 4).'/'.substr($id, 12);
                    if($key) return Qout::Qdbout($keyass.' '.$key, $valass, $type, $per); elseif($type == -3) { $fp = file("$per/index.php"); return substr(rtrim($fp[2]),0,10); } else { $keyperk = "$per/keys.php"; $keyperl = "$per/link.php";
                        if(file_exists($keyperk)) { $f1 = file($keyperk); $f2 = file($keyperl); $fk = array(); $fl = array(); $fkx = array(); $flx = array(); $keyval = array(); $ex = array('.','..','index.php','keys.php','link.php','index_SYNC_.php','keys_SYNC_.php','link_SYNC_.php'); for($a=2, $ua=count($f2); $a<$ua; $a++) { $x = explode('.',rtrim($f1[$a])); $k = rtrim($keybase[$x[0]]); for($b=1, $ub=count($x); $b<$ub; $b++) if($x[$b] > 1) $k .= '.'.rtrim($keybase[$x[$b]]); if(strlen($f2[$a]) > 64) { if($f2[$a][0] == 0) $fkx[] = '#'.$k; else $fkx[] = '@'.$k; } else { $fk[] = $k; $fl[] = $f2[$a]; } $ex[] = rtrim($f1[$a]).'.php'; $ex[] = rtrim($f1[$a]).'_SYNC_.php'; }
                            $fl = SYS::val($fl); $fk = array_merge($fk,$fkx); $fl = array_merge($fl,$flx); $cfp = count($fk); for($a=0; $a<$cfp; $a++) { $keyval['K'][$a] = $fk[$a]; if(isset($fl[$a])) $keyval[$fk[$a]] = $fl[$a]; } $keyval['N.K'] = $cfp; $files = array_diff(scandir($per),$ex); rsort($files); $cfp = count($files);
                            for($a=0; $a<$cfp; $a++) { if(strpos($files[$a], '-')) { $key = substr($files[$a],11,-4); $del = substr($files[$a],0,10); } else { $key = substr($files[$a],0,-4); $del = false; } $x = explode('.',$key); $k = rtrim($keybase[$x[0]]); for($b=1, $u=count($x); $b<$u; $b++) if($x[$b] == 0) $k = '#'.$k; elseif($x[$b] == 1) $k = '@'.$k; else $k .= '.'.rtrim($keybase[$x[$b]]); $keyval['H'][$a] = $k; $keyval[$a] = $del; } $keyval['N.H'] = $cfp; $keyval['T'] = $keyval['N.K'] + $keyval['N.H']; return $keyval; }
                    }
                }
            }
        } else { $numkey = Qout::analisi($key); $key = $numkey[1]; $per = SYS::combina($key);
            if($per) { if(is_string($valass) && $valass != NULL) { $valass = rtrim(base64_decode($valass)); $keyper = $Qdatabase.$Qpostime; $keyper .= '/'.substr($valass,0,3).'/'.substr($valass,3,$valass[12]).'/'.substr($valass,3+$valass[12]); $keyperi = "$keyper/index.php"; $keyperk = "$keyper/keys.php"; $keyperl = "$keyper/link.php"; if(file_exists($keyperk)) { $f1 = file($keyperk); $f2 = file($keyperl); $fk[0] = ''; $fl[0] = $valass."\n"; for($a=2, $u=count($f2); $a<$u; $a++) { $fk[$a-1] = $f1[$a]; $fl[$a-1] = $f2[$a]; } $vl = SYS::val($fl); $n = -1; foreach($vl as $val) { $n++; if(!$n) { $keyval['K'][0] = '-'; $keyval['-'] = $val; $keymsg = '-'; } else { $keymsg = SYS::kb($fk[$n]); $keyval['K'][$n] = $keymsg; $keyval[$keymsg] = $val; }
            if($qt=Qout::tempo($opz,$fl[$n],$ora)) $keyval["t.$keymsg"] = $qt; } $f1 = file($keyperi); $keyval['N'] = count($keyval['K']); $keyval['T'] = $f1[2]; return $keyval; }} else { $keyper = $Qdatabase; foreach($per as $corso) $keyper .= '/'.$corso; $keyper .= '/-0'; $fx = SYS::leggi($keyper ,0 ,$numkey, 2); $vl = false; for($a=2, $u=count($fx); $a<$u; $a++) { $f = explode('.',$fx[$a]); $vl[$a-2] = $f[0]."\n"; $ft[$a-2] = $f[1]; } if($vl) { $v = SYS::val($vl); $n = -1; foreach($v as $val) { $n++; $keyval[$n] = $val; if($qt=Qout::tempo($valass,$ft[$n],$ora)) $keyval["t.$n"] = $qt; } if($fx[1]) { $keyval['N'] = $fx[1]; $keyval['T'] = $fx[0]; unset($keyval['K']); return $keyval; }}}}
        } return false;
    }
}

?>