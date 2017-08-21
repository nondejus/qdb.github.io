<?php

namespace Quantico;

class Qsx extends Qout
{
    protected static function ccc($numkey,$dati) { $t = array(); $d = array(); if($numkey[3]) { $x = $numkey[3]; $y = $numkey[4]; if($numkey[5]){ for($a=0; $a<count($dati); $a++) { $tempo = substr($dati[$a],0,10); if($tempo >= $x && $tempo <= $y) { $t[] = $tempo; $d[] = substr($dati[$a],10,-1); }}} else { for($a=count($dati)-1; $a>=0; $a--) { $tempo = substr($dati[$a],0,10); if($tempo >= $x && $tempo <= $y) { $t[] = $tempo; $d[] = substr($dati[$a],10,-1); }}}} else { for($a=0; $a<count($dati); $a++) { $t[$a] = substr($dati[$a],0,10); $d[$a] = substr($dati[$a],10,-1); }} return array($d,$t); }
    protected static function diff($at,$dfk,$dfl,$per,$opz=false) { if(!$at) return false; for($a=0; $a<count($dfk); $a++) { SYS::$dataval = false; $x = explode(' ',$dfk[$a]); $y = SYS::combina($x[0]); $z = false; if(isset($x[1])) $z = SYS::combina($x[1]); if($y) { if(!is_array($dfl[$a])) $dfl[$a] = array($dfl[$a]); foreach($dfl[$a] as $l) { if(SYS::$dataval) $l = SYS::dataval($l); $keyper = SYS::c($per,$y); if($z) $keyper = SYS::c($keyper,$z); $keyper = SYS::lh($keyper,Qhash(trim(mb_strtolower($l,'UTF-8')))).'/idem.php'; if(file_exists($keyper)) { $fp = array_slice(file($keyper),2); $at = array_diff($at,$fp); }}}} return $at; }
    protected static function search($keys, $valass, $opz, $type, $all, $ora){ global $keybase; global $Qposdef;
        if(is_array($valass)) { if(is_array($opz)) return SYS::error(2,4); $akt = array_keys($valass); $dfk = array(); $dfl = array(); $key[1] = false; $perass = false; $kk = false; $ky = false; $y = false;
            if(strpos($keys, ' ') > 1) { $ky = explode(' ', $keys, 2); if(!$ky[1]) return false; $key = Qout::analisi($ky[1]); $keyass = Qout::analisi($ky[0]); $key[1] = SYS::sort($key[1]); if(!$key[1]) return false; $y = $ky; if($key[9]) { $key[19] = $key[1]; $key[1] = array($key[1]); if(is_array($key[13])) $key[1] = array_merge($key[1],$key[13]); }} else { if(strpos($keys,'!') > 1) { $j = strpos($keys,'!') - 1; $z = false; if($keys[$j] == ')') $z = ')'; elseif($keys[$j] == ']') $z = ']'; elseif($keys[$j] == '}') $z = '}'; if($z) { $ky = explode($z, $keys, 2); return Qout::Qdbout($ky[0].$z.' '.$ky[1],$valass,$opz,$type); }} $ccc = strpos($keys,'@'); $ccl = strpos($keys,'#'); if($ccc > 0) { if(!$ccl || $ccl > $ccc) { $ky[0] = substr($keys,0,$ccc); $ky[1] = substr($keys,$ccc); return Qout::Qdbout($ky[0].' '.$ky[1],$valass,$opz,$type); }} elseif($ccl > 1) { $ky[0] = substr($keys,0,$ccl); $ky[1] = substr($keys,$ccl); if(strstr($ky[1],',')) return Qout::Qdbout($ky[0].' '.$ky[1],$valass,$opz,$type); $keyass = Qout::analisi($ky[0]); $key = Qout::analisi($ky[1]); $key[1] = SYS::sort(explode(',',$ky[1])); if(!$y) { $y[0] = $keys; $y[1] = ''; }} else { $keyass = Qout::analisi($keys); $y[0] = $keys; $y[1] = ''; if(!$ky) $ky = $y; }}
            if(strpos($keyass[1], '#') > 1) { $ky = explode('#', $ky[0], 2); $keyass[1] = $ky[0]; $kk = '#'.$ky[1]; } elseif(strpos($keyass[1], '@') > 1) { $ky = explode('@', $ky[0], 2); $keyass[1] = $ky[0]; $kk = '@'.$ky[1]; } elseif(strpos($keys, '@') > 1) { $ky = explode('@', $keys, 2); $kk = '@'.$ky[1]; $y[0] .= $y[1]; $y[1] = ''; } else { $z = false; if(strpos($keyass[1][0], ')') > 1) $z = ')'; elseif(strpos($keyass[1][0], ']') > 1) $z = ']'; elseif(strpos($keyass[1][0], '}') > 1) $z = '}'; if($z) { $ky = explode($z, $keys, 2); return Qout::Qdbout($ky[0].$z.' '.$ky[1],$valass,$opz,$type); }} $keyper = SYS::combina($keyass[1], 2); $ac = array(); $at = array();
            
            if($akt[0] == '0') { if(!$opz) return false; $tmp = false; $fpt = false; $fp = false; $ai = array(); $ap = array(); $tot = 0; // ******************************************** ricerca all'interno della stringa
                if($kk[0] == '#') { $keyass = Qout::analisi($kk); $keyper = SYS::combina(substr($keyass[1],1),2); $perass = true; } elseif($kk[0] == '@') { $keyass = Qout::analisi($kk); $keyper .= '/@/'.str_replace('.', '/', rtrim(SYS::combina(substr($keyass[1],1), 1))); $perass = true; } elseif(is_array($key[1])) { if(count($key[1]) == 1 && $key[1][0][0] == '#') { $keyass = Qout::analisi($key[1][0]); $keyper = SYS::combina(substr($keyass[1],1),2); $perass = true; }} if($keyass[0] == '') $num = $Qposdef; else $num = $keyass[0]-2; if($keyass[6]) $num = $keyass[2]; if($keyass[2] != -1) $num++; global $QprcCerca; $per = explode('{',$y[1]); $circa = $num + ceil($num/$QprcCerca)*count($per)*2;
                if($keyper) { $parole = SYS::trak(mb_strtolower($opz,'UTF-8'));
                    if($parole) { if($perass) { $j = array_search(-1,$valass); if($j !== false) { $valass = SYS::cancella($valass,$j); $all = -1; } else { $j = array_search(-2,$valass); if($j !== false) { $valass = SYS::cancella($valass,$j); $all = -2; }} if($type == -1 || $type == -2) $all = $type; $as = Qout::outmix($keybase, $y[1], $y[0], $type, $all, $ora, 3); if(!$as) return false; if($all == -1 || $all == -2) { if($keyass[1][0] == '@') { for($a=2; $a<count($as); $a++) { $e = explode('.',rtrim($as[$a])); $fpt[$a-2] = array_pop($e); $as[$a] = implode('.',$e)."\n"; }} else { if($type == NULL || $type == -1 || $type == -2) { for($a=2; $a<count($as); $a++) { $e = explode('.',rtrim($as[$a])); $as[$a] = $e[0]."\n"; $fpt[$a-2] = substr($e[0],0,10); }} else { for($a=2; $a<count($as); $a++) { $e = explode('.',rtrim($as[$a])); $as[$a] = $e[0]."\n"; $fpt[$a-2] = $e[1]; }}}}} $kk = array_keys($valass); for($a=0; $a<count($kk); $a++) { if(!is_numeric($kk[$a])) { if($kk[$a][0] == '!') { $dfk[] = substr($kk[$a],1); $dfl[] = $valass[$kk[$a]]; } $valass = SYS::cancella($valass,$kk[$a]); }} if($dfl) { $v = 0; foreach($dfl as $a) $v += count($a); $circa += ceil($num/$QprcCerca)*$v*2; }
                        foreach($valass as $v) { $ky = explode(' ',$v); $per = SYS::c($keyper,SYS::combina($ky[0])); if(isset($ky[1])) $per = SYS::c($per,SYS::combina($ky[1])); 
                            if($per) { foreach($parole as $p) { $pers = "$per/".Qord($p[0]); $pert = "$pers/keyt.php"; if(file_exists($pert)) { $ft = file($pert); $fc = file("$pers/keyc.php"); $fi = file("$pers/keyi.php"); $trv = 0; if($perass || strstr($y[1],'{')) { $high = count($ft)-1; $low = 2; } else { if($keyass[3]){ $high = SYS::binary($keyass[4],$fc,1); $low = SYS::binary($keyass[3],$fc,0); } else { $high = count($ft)-1; $low = 2; $keyass[5] = 1; }} 
                                if($keyass[1][0] == '@') { if($keyass[5]){ for($a=$high; $a>=$low; $a--) { $kk = substr($fi[$a],10,-1); if(mb_strpos($ft[$a],$p,0,'UTF-8') !== false && !in_array($kk,$ai)) { $ac[] = $fc[$a]; $ai[] = $kk; $ap[] = "$pers#$a"; if(!$perass) { $trv++; if($trv > $circa) break; }}}} else { for($a=$low; $a<=$high; $a++) { $kk = substr($fi[$a],10,-1); if(mb_strpos($ft[$a],$p,0,'UTF-8') !== false && !in_array($kk,$ai)) { $ac[] = $fc[$a]; $ai[] = $kk; $ap[] = "$pers#$a"; if(!$perass) { $trv++; if($trv > $circa) break; }}}}} else { if($keyass[5]){ for($a=$high; $a>=$low; $a--) if(mb_strpos($ft[$a],$p,0,'UTF-8') !== false && !in_array($fc[$a],$ac) && !in_array($fi[$a],$ai)) { $ac[] = $fc[$a]; $ai[] = $fi[$a]; $ap[] = "$pers#$a"; if(!$perass) { $trv++; if($trv > $circa) break; }}} else { for($a=$low; $a<=$high; $a++) if(mb_strpos($ft[$a],$p,0,'UTF-8') !== false && !in_array($fc[$a],$ac) && !in_array($fi[$a],$ai)) { $ac[] = $fc[$a]; $ai[] = $fi[$a]; $ap[] = "$pers#$a"; if(!$perass) { $trv++; if($trv > $circa) break; }}}}}}
                            }
                        } if($dfk) { $ai = self::diff($ai,$dfk,$dfl,$keyper,true); if(!$ai) return false; $kk = array_keys($ai); $ai = array_values($ai); $act = array(); $apt = array(); foreach($kk as $v) { $act[] = $ac[$v]; $apt[] = $ap[$v]; } $ac = $act; $ap = $apt; } if($perass) { if($ai) { $tot = $as[0]; if($type != NULL && $type != -1 && $type != -2) { if($as[2][0] == '#') { for($a=2; $a<count($as); $a++) $as[$a-2] = substr($as[$a],1); unset($as[count($as)-1]); unset($as[count($as)-1]); } else { $as = Qout::tagli01($as,true); if($keyass[1][0] != '@') $ai = SYS::val(Qout::adesso($ai)); $tmp = true; }} else $as = Qout::tagli01($as); if($keyass[1][0] == '@') { if($type == NULL || $type == -1 || $type == -2) $as = SYS::val($as); } $ky = array_intersect($ai,$as); if(!$ky) return false; $k = array_keys($ky); $act = array(); $ait = array(); $apt = array(); for($b=0; $b<count($k); $b++) { $act[$b] = $ac[$k[$b]]; $ait[$b] = $ai[$k[$b]]; $apt[$b] = $ap[$k[$b]]; } $ac = $act; $ai = $ait; $ap = $apt; if($fpt) { $fp = array(); for($b=0; $b<count($k); $b++) $fp[$b] = $fpt[array_search($ai[$b],$as)]; }} else return false; }
                        if($ac) { $ac = SYS::val($ac); $chiaro = SYS::trak(mb_strtolower($opz,'UTF-8'),1); if($fpt) $fpt = array(); $trv = 0; $b = -1; for($a=0; $a<count($ac); $a++) { $v = mb_strtolower($ac[$a],'UTF-8'); $b++; $ok = false; foreach($chiaro as $c) if(mb_strpos($v,$c,0,'UTF-8') !== false && !in_array($ai[$b],$at)) { $at[] = $ai[$b]; if($fp) $fpt[] = $fp[$b]; $ok = true; $trv++; if($trv == $num) { $a = 9999999999; break; }} if(!$ok) { $ai = SYS::cancella($ai,$b); $ap = SYS::cancella($ap,$b); $b--; }}} else return false; if($at) { if($fpt) array_multisort($fpt,SORT_DESC,SORT_NUMERIC,$at); else { if($type == -1 || $type == -2) rsort($at); } Qout::stato($ap); $ccc = false; if($perass) { if(strpos($y[0],'#')) $y[0] = substr($y[0],strpos($y[0],'#')+1); elseif(strpos($y[0],'@')) { $ccc = substr($y[0],0,strpos($y[0],'@')); $y[0] = substr($y[0],strpos($y[0],'@')+1); } else return false; $type = $all; } return Qout::outmix($keybase, $y[1], $y[0], $type, NULL, $ora, 0, $at, $tmp, $tot, $fpt, $ccc); } else return false; 
                    }
                }
            } else { $alt = array_values($valass); $n = -1; // *************************************************************************************************************************** ricerca esatta della parola
                if($kk[0] == '#') { $keyass = Qout::analisi($kk); $keyper = SYS::combina(substr($keyass[1],1), 2); $perass = true; } elseif($kk[0] == '@') { $keyass = Qout::analisi($kk); $keyper .= '/@/'.str_replace('.', '/', rtrim(SYS::combina(substr($keyass[1],1), 1))); $perass = true; } elseif($key[1][0] == '@') { $keyper .= '/@/'.str_replace('.', '/', rtrim(SYS::combina(substr($key[1],1), 1))); $perass = true; $y[0] .= $y[1]; $y[1] = ''; } elseif(is_array($key[1]) && count($key[1]) == 1) { if($key[1][0][0] == '#') { $keyass = Qout::analisi($key[1][0]); $keyper = SYS::combina(substr($keyass[1],1), 2); $perass = true; }} $kk = array(); $dv = array();
                for($a=0; $a<count($akt); $a++) { $ac = array(); if($akt[$a][0] == '!') { $dfk[] = substr($akt[$a],1); $dfl[] = $alt[$a]; } else { $n++; $z = explode(' ',$akt[$a]); $b[$n] = SYS::combina($z[0]); $dv[$n] = SYS::$dataval; if(isset($z[1])) $cc[$n] = SYS::combina($z[1]); $kk[$n] = $alt[$a]; $ok = false; if($b[$n] && is_array($kk[$n])) { $link = array_unique($kk[$n]); foreach($link as $l) { if($dv[$n]) $l = SYS::dataval($l); $per = SYS::c($keyper,$b[$n]); if(isset($cc[$n])) $per = SYS::c($per,$cc[$n]); $per = SYS::lh($per,Qhash(trim(mb_strtolower($l,'UTF-8')))).'/idem.php'; if(file_exists($per)) { $fp = file($per); $ac = array_unique(array_merge($ac,array_slice($fp,2))); $ok = true; }}} if($ok) { if($at) $at = array_intersect($at,$ac); else $at = $ac; }}}
                for($a=0; $a<=$n; $a++) { if($b[$a] && !is_array($kk[$a])) { if($dv[$a]) $kk[$a] = SYS::dataval($kk[$a]); else $kk[$a] = SYS::speciali($kk[$a],true); $per = SYS::c($keyper,$b[$a]); if(isset($cc[$a])) $per = SYS::c($per,$cc[$a]); $per = SYS::lh($per,Qhash(trim(mb_strtolower($kk[$a],'UTF-8')))).'/idem.php'; if(file_exists($per)) { $fp = array_slice(file($per),2); if($at) $at = array_intersect($at,$fp); else $at = $fp; }}} if($dfk) { if(!$at && $key[9]) exit('NON so ancora come risolverlo !!! ci devo pensare !!!'); $at = self::diff($at,$dfk,$dfl,$keyper); } if($at) { rsort($at); if($perass) return Qout::outmix($keybase, $y[1], $y[0], $opz, $type, $ora, 2, $at); else return Qout::outmix($keybase, $ky[1], $ky[0], $opz, NULL, $ora, 0, $at); } else return false;
            }
        }
    }        
}

?>