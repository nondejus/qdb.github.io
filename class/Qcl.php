<?php

namespace Quantico;

class Qcl extends Qout
{
    protected static function key($key, $keyass, $valass, $opz, $ora) { global $Qdatabase; $ky = explode('@', $keyass, 2); $numkey = Qout::analisi($ky[1]);
        if($key) { if($ky[0]) { $keyass = $numkey[1]; $per = SYS::combina($key,1);
            if($per) { $perass = SYS::combina($keyass,1); 
                if($perass) { $keyper = $Qdatabase.'/@/'.str_replace('.','/',rtrim($perass)).'/@'; $keyper = SYS::lh($keyper,Qhash($ky[0])); $fkeys = "$keyper/keys.php"; $flink = "$keyper/link.php"; $per = rtrim($per).".0\n"; $val = false; 
                    if(file_exists($fkeys)){ $fk = file($fkeys); $j = array_search($per,$fk); if($j > 1){ $fl = file($flink); if($valass == -1 || $valass == -2) { $fx = SYS::leggi($Qdatabase.'/'.rtrim($fl[$j]),0,$numkey,2); for($a=2; $a<count($fx); $a++) { $f = explode('.',$fx[$a]); $ft[$a-2] = rtrim($f[1]); if($f[0][0] == '-') { $val[$a-2] = substr($f[0],12)."\n"; $del[$a-2] = base64_encode($val[$a-2]); $ft[$a-2] = substr($f[0],2,10); } else { $val[$a-2] = substr($f[0],1)."\n"; $del[$a-2] = 0; }}
                    } else { $fx = SYS::leggi($Qdatabase.'/'.rtrim($fl[$j]),0,$numkey,1); for($a=2; $a<count($fx); $a++) { if($fx[$a][0] == '-') { $val[$a-2] = substr($fx[$a],12); $del[$a-2] = base64_encode($val[$a-2]); } else { $val[$a-2] = substr($fx[$a],1); $del[$a-2] = 0; }}} if($val) { $keyval = SYS::val(Qout::adesso($val)); for($a=0; $a<count($val); $a++) { $keyval["-.$a"] = $del[$a]; if($valass == -1) $keyval["t.$a"] = $ft[$a]; elseif($valass == -2) $keyval["t.$a"] = $ora - $ft[$a]; } $keyval['N'] = $fx[1]; $keyval['T'] = $fx[0]; return $keyval; }}}}} return false; } $numkeyass = Qout::analisi($key); $arr = Qout::Qdbout($keyass,$valass,$opz); $ok = false;
                if($valass != NULL && $valass != -1 && $valass != -2) { $tmp = array_unique($arr); unset($tmp['N']); unset($tmp['T']); $valass = $opz; if($opz == -1 || $opz == -2) $numkeyass[0] = '@2'; else $numkeyass[0] = '@1'; $ok = true; } else { $tmp = $arr["@$numkey[1].0"]; for($a=1; $a<$arr["N.@$numkey[1]"]; $a++) $tmp = array_unique(array_merge($tmp,$arr["@$numkey[1].$a"])); } if(is_array($numkeyass[1])) $x = $numkeyass[1]; else $x = array($numkeyass[1]); $k = array(); $kk = array(); if($tmp) { foreach($tmp as $v) { $avl[$v] = Qout::Qdbout("$v@$numkey[1]",$valass); unset($avl[$v]['K']); unset($avl[$v]['N']); unset($avl[$v]['T']); foreach($x as $y) if($avl[$v][$y]) { $k[$v][$y] = $avl[$v][$y]; if(isset($avl[$v]["t.$y"])) $k[$v]["t.$y"] = $avl[$v]["t.$y"]; if(!in_array($y,$kk)) $kk[] = $y; }}}
            if($k) { $keyval = array(); if($ok) { $keyval['K'] = $kk; foreach($kk as $c) { $n = 0; for($b=0; $b<$arr['N']; $b++) { $x = $k[$arr[$b]]; if(isset($x[$c])) { $keyval[$c][$b] = $x[$c]; if(isset($x["t.$c"])) $keyval["t.$c"][$b] = $x["t.$c"]; $n++; } else { $keyval[$c][$b] = ''; if(isset($x["t.$c"])) $keyval["t.$c"][$b] = ''; } $keyval["N.$c"] = $n; }} $keyval['N'] = $arr['N']; $keyval['T'] = $arr['T'];
            } else { for($a=0; $a<$arr['N']; $a++) $keyval[$a] = $arr[$a]; $keyval['K'] = $kk; foreach($kk as $c) { for($a=0; $a<$arr['N']; $a++) { $n = 0; for($b=0; $b<$arr["N.@$numkey[1].$a"]; $b++) { $x = $k[$arr["@$numkey[1].$a"][$b]]; if(isset($x[$c])) { $keyval["$c.$a"][$b] = $x[$c]; if(isset($x["t.$c"])) $keyval["t.$c.$a"][$b] = $x["t.$c"]; $n++; } else { $keyval["$c.$a"][$b] = ''; if(isset($x["t.$c"])) $keyval["t.$c.$a"][$b] = ''; }} $keyval["N.$c.$a"] = $n; }} $keyval['N'] = $arr['N']; $keyval['T'] = $arr['T']; } $numkeyass[18] = explode(',',$key); if($numkeyass[14]) $numkeyass[1] = $numkeyass[14]; return Qout::flusso($numkeyass,$keyval,$keyval['T'],$keyval['N']); } return false;
        } else { $keyass = $numkey[1]; $per = SYS::combina($key,1); if($per) { $perass = SYS::combina($keyass,1); 
            if($perass) { $keyper = $Qdatabase.'/@/'.str_replace('.','/',rtrim($perass)).'/@'; $keyper = SYS::lh($keyper,Qhash($ky[0])); $fkeys = $keyper.'/keys.php'; $flink = $keyper.'/link.php'; $per = rtrim($per).".0\n"; $val = false; if(file_exists($fkeys)){ $fk = file($fkeys); $j = array_search($per,$fk); if($j > 1){ $fl = file($flink); if($valass == -1 || $valass == -2) { $fx = SYS::leggi($Qdatabase.'/'.rtrim($fl[$j]),0,$numkey,2); for($a=2; $a<count($fx); $a++) { $f = explode('.',$fx[$a]); $ft[$a-2] = rtrim($f[1]); if($f[0][0] == '-') { $val[$a-2] = substr($f[0],12)."\n"; $del[$a-2] = base64_encode($val[$a-2]); $ft[$a-2] = substr($f[0],2,10); } else { $val[$a-2] = substr($f[0],1)."\n"; $del[$a-2] = 0; }}
            } else { $fx = SYS::leggi($Qdatabase.'/'.rtrim($fl[$j]),0,$numkey,1); for($a=2; $a<count($fx); $a++) { if($fx[$a][0] == '-') { $val[$a-2] = substr($fx[$a],12); $del[$a-2] = base64_encode($val[$a-2]); } else { $val[$a-2] = substr($fx[$a],1); $del[$a-2] = 0; }}} if($val) { $keyval = SYS::val(Qout::adesso($val)); for($a=0; $a<count($val); $a++) { $keyval["-.$a"] = $del[$a]; if($valass == -1) $keyval["t.$a"] = $ft[$a]; elseif($valass == -2) $keyval["t.$a"] = $ora - $ft[$a]; } $keyval['N'] = $fx[1]; $keyval['T'] = $fx[0]; return $keyval; }}}}} return false; 
        }
    }
    protected static function mix($keys, $valass, $opz, $type, $all, $ora, $ccl) { global $Qdatabase; global $Qposdef; global $Qlivtime; global $keybase; $ky = explode('@', $keys, 2); $key = $ky[1]; $keyass = $ky[0]; if($j = self::parentesi($key,$keyass,$valass,$opz,$type,'@')) return $j; if($type == 999) { $per = SYS::combina($keyass); if($per) { $hashpos = SYS::hashpos(Qhash($opz), $per); $keyperindex = "$hashpos/link.php"; if(file_exists($keyperindex)){ $fp = file($keyperindex); for($a=2; $a<count($fp); $a++) { if(strlen($fp[$a]) > 64) { $k = explode('/', $fp[$a]); if($key == rtrim($keybase[$k[1]])) return SYS::leggi($Qdatabase.'/'.rtrim($fp[$a]), $valass); }}}} return false; }
        //-------------------------------------------------------------------------------------------->>>>>>> INIZIO Query  --->  Qout::Qdbout('user.email(20)#foto',2)
        if($keyass[strlen($keyass)-1] == '!') { $keyass = substr($keyass,0,-1); $key = '!@'.$key; $opz = NULL; } else $key = '@'.$key; $numkeyass = Qout::analisi($keyass); if(strpos($keyass,',') > 1) { if($ccl) { $ky = explode('#', $keyass, 2); return Qout::Qdbout($ky[0].' #'.$ky[1].$key,$valass,$opz); } else return false; } if($numkeyass[9]) { $ky = explode('#', $keyass, 2); return Qout::Qdbout($ky[0].' #'.$ky[1].$key); }
        if($numkeyass[0] != '' || $numkeyass[3] != '') { if($valass == NULL) { if($key[0] == '@') $key = ' '.$key; return Qout::Qdbout($keyass.$key, $valass, $opz, 666); } elseif($valass == -1 || $valass == -2) return Qout::Qdbout($keyass.$key, NULL, $valass, 666); } else { if($type == 0) { $ok = true; $x = explode('.',$keyass); foreach($x as $a) if(!is_numeric($a)) { $ok = false; break; } if($ok) { $opz = $valass; $valass = NULL; } else { if($valass == NULL) return Qout::Qdbout($keyass."($Qposdef)".$key, $valass, $opz, 666); elseif($valass == -1 || $valass == -2) return Qout::Qdbout($keyass."($Qposdef)".$key, NULL, $valass, 666); }}}
        if($valass == NULL) { $arr = false; $avl = false;
            if($ok) { $key = substr($key,1); $per = SYS::combina($key); if(!is_array($per)) return false; $keyper = $Qdatabase.'/@'; foreach($per as $a) $keyper .= '/'.$a; $keyper = SYS::lh($keyper,Qhash($x[0])); $keyperk = $keyper.'/keys.php'; $keyperl = $keyper.'/link.php'; $n = 0; $k = 0;
                if(file_exists($keyperk)) { $fk = file($keyperk); $fl = file($keyperl); // -------------- LEGGO la CLONAZIONE ------- INIZIO --------
                    for($a=0; $a<count($all); $a++) { $b = self::analisi($all[$a]); $all[$a] = $b[1]; }
                    for($a=2; $a<count($fl); $a++) {
                        if(strlen($fl[$a]) < 64) { $keymsg = SYS::kb($fk[$a]);
                            if(is_array($all)) { if(in_array($keymsg,$all)) { $arr[$k] = $keymsg; $avl[$keymsg][] = $fl[$a]; $keyval['K'][$k] = $keymsg; if($qt=Qout::tempo($opz,$fl[$a],$ora)) $keyval["t.$keymsg"] = $qt; $k++; }} else { $arr[$k] = $keymsg; $avl[$keymsg][] = $fl[$a]; $keyval['K'][$k] = $keymsg; if($qt=Qout::tempo($opz,$fl[$a],$ora)) $keyval["t.$keymsg"] = $qt; $k++; }
                        } else { $n++; $y = explode('/',$fl[$a]); if($y[0] == 0 && count($x) > 1) { if(isset($x[$n]) && $x[$n] > 0) { $ccc = $Qdatabase.'/@/'.$y[1]; for($b=2; $b<count($y)-$Qlivtime-2; $b++) $ccc .= '/'.$y[$b]; $ccc = SYS::lh($ccc,Qhash($x[$n])); $keyk = "$ccc/keys.php"; $keyl = "$ccc/link.php";
                            if(file_exists($keyk)) { $mk = file($keyk); $ml = file($keyl);
                                for($b=2; $b<count($ml); $b++) { 
                                    if(strlen($ml[$b]) < 64) { $keymsg = SYS::kb($mk[$b], '', 0, $y[1]);
                                        if(is_array($all)) { if(in_array($keymsg,$all)) { $arr[$k] = $keymsg; $avl[$keymsg][] = $ml[$b]; $keyval['K'][$k] = $keymsg; if($qt=Qout::tempo($opz,$ml[$b],$ora)) $keyval["t.$keymsg"] = $qt; $k++; }} else { $arr[$k] = $keymsg; $avl[$keymsg][] = $ml[$b]; $keyval['K'][$k] = $keymsg; if($qt=Qout::tempo($opz,$ml[$b],$ora)) $keyval["t.$keymsg"] = $qt; $k++; }
                                    }
                                } 
                            } else { $ccc = $Qdatabase.'/@/'.$y[1]; for($b=2; $b<count($y)-$Qlivtime-2; $b++) $ccc .= '/'.$y[$b]; $ccc = SYS::lh($ccc,Qhash($x[$n])); $keyi = "$ccc/index.php";
                                if(file_exists($keyi)) { $mi = file($keyi); $keymsg = rtrim($keybase[$y[1]]); $arr[$k] = $keymsg; $avl[$keymsg][] = $mi[2]; $keyval['K'][$k] = $keymsg; if($qt=Qout::tempo($opz,$mi[2],$ora)) $keyval["t.$keymsg"] = $qt; $k++; }}}
                            }
                        }
                    } if(!$arr) { $keyi = "$keyper/index.php"; if(file_exists($keyi)) { $mi = file($keyi); $val = SYS::val($mi[2]); $keyval['K'][0] = 0; $keyval[0] = $val; if($qt=Qout::tempo($opz,$mi[2],$ora)) $keyval["t.0"] = $qt; $keyval['N'] = 1; $keyval['T'] = false; }}
                    else { $vl = SYS::val($arr,$avl); foreach($arr as $key) foreach($vl[$key] as $val) $keyval[$key] = $val; $keyval['K'] = SYS::Qsort($keyval['K']); $keyval['N'] = $k; $keyval['T'] = false; } if(count($keyval) == 4) return $keyval[$keyval['K'][0]]; else return $keyval;
                } else { $keyi = "$keyper/index.php"; if(file_exists($keyi)) { $mi = file($keyi); $val = SYS::val($mi[2]); if(is_numeric($keyass)) $keymsg = 0; else $keymsg = rtrim($keybase[$keyass]); $keyval['K'][$k] = $keymsg; $keyval[$keymsg] = $val;
                    if($qt=Qout::tempo($opz,$mi[2],$ora)) $keyval["t.$keymsg"] = $qt; $keyval['K'] = SYS::Qsort($keyval['K']); $keyval['N'] = $k + 1; $keyval['T'] = false; return $keyval; }} return false;
            } // ------------------------------------------------------------------------------------------------------ LEGGO la CLONAZIONE ------- FINE --------
        } else { $numkey = Qout::analisi($key); $per = SYS::combina($numkey[1]); $per[] = 1; $id = SYS::keyvalass($keyass, $valass, $per, 0, $type); if($opz == -1 || $opz == -2) $o = 2; else $o = 1; $fx = SYS::leggi($Qdatabase.'/'.$id ,0 ,$numkey ,$o);
            for($b=2; $b<$fx[1]+2; $b++) { $a = $b - 2; $fx[$b] = rtrim($fx[$b]); if($opz == -1 || $opz == -2) { $type = explode('.', $fx[$b]); $n = count($type)-1; $keyval[$a] = $type[0]; for($c=1; $c<$n; $c++) $keyval[$a] .= '.'.$type[$c]; if($qt=Qout::tempo($opz,$type[$n],$ora)) $keyval["t.$a"] = $qt; } else $keyval[$a] = $fx[$b]; } if($fx[1]) { unset($keyval['K']); return Qout::flusso($numkey,$keyval,$fx[0],$fx[1],2); }
        } return false; //---------------------------------------------------------------------------------------------->>>>>>>>> FINE Query
    }
}

?>