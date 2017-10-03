<?php

namespace Quantico;

class Qmix extends Qout
{
    protected static function tagli01($fx,$opz=0) { if($opz) { for($a=2, $u=count($fx); $a<$u; $a++) $fx[$a-2] = rtrim($fx[$a]); } else { for($a=2, $u=count($fx); $a<$u; $a++) $fx[$a-2] = $fx[$a]; } unset($fx[count($fx)-1]); unset($fx[count($fx)-1]); return $fx; }
    protected static function valopz($key, $keyass, $valass, $opz, $ora) { $per = SYS::combina($key); if($per) { $perass = SYS::keyvalass($keyass, $valass, $per); if($perass) { $val = SYS::val($perass."\n"); if($opz !== _T1_ && $opz !== _T2_) return $val; $keyval['K'] = $key; $keyval[$key] = $val; if($qt=SYS::tempo($opz,$perass,$ora)) $keyval["t.$key"] = $qt; return $keyval; }} return false; }
    protected static function moltiplicatore($num,$opz=0) { if($opz) { global $QprcPersonal; $Qmol = $QprcPersonal; } else $Qmol = 1; if($num[0] == '') { global $Qposdef; $num[0] = $Qposdef*$Qmol; $num[2] = 0; } elseif($num[2] == -1) { $num[0] = ($num[0]-2)*$Qmol; $num[2] = 0; } else { if($num[6]) { $num[0] = $num[2]*$Qmol; $num[2] = 0; $num[6] = ''; } else { $num[0] = ($num[0]-2)*$Qmol; $num[2] = 0; }} return $num; }
    protected static function flusso($numkey, $keyval, $tot, $n, $opz=0, $numkeyass=0) { $ok = true; $si = false; if(!isset($numkey[13])) $numkey[13] = NULL; if(!isset($numkey[14])) $numkey[14] = NULL; if(!isset($numkey[17])) $numkey[17] = NULL; $tmp = true;
        if(is_array($numkeyass)) { if($numkeyass[14] || $numkeyass[17]) { if(!$opz) { $ok = false; $numkey[18][] = $numkeyass[1]; for($a=0; $a<18; $a++) $numkey[$a] = $numkeyass[$a]; for($a=0; $a<$n; $a++) $keyval[$numkey[1]][$a] = $keyval[$a]; if(isset($keyval['t.0'])) { for($a=0; $a<$n; $a++) $keyval['t.'.$numkey[1]][$a] = $keyval[$a]; }} else $numkey = $numkeyass; } else { if($numkey[9]) { if(!$numkey[18] || is_array($numkey[18])) $ok = false; if($numkey[17]) $ok = true; }}} if($numkey[14] == '' && $numkey[16] == '') { if(is_array($numkey[18])) { $t = $numkey[18]; foreach($t as $x) { if(strpos($x,'{')) $x = substr($x,0,strpos($x,'{')); if($x[0] == '!') { $ok = false; $x = substr($x,1); if($x[strlen($x)-1] == '!') { $x = substr($x,0,-1); $numkey[18] = true; $ok = true; } else $numkey[18] = false; $numkey[14] = $x; $numkey[1] = $x; } if(strpos($x,'+') > 1) { $numkey[16] = substr($x,0,strpos($x,'+')); $numkey[17] = 1; $numkey[1] = $numkey[16]; $ok = true; $si = true; break; } elseif(strpos($x,'-') > 1) { $numkey[16] = substr($x,0,strpos($x,'-')); $numkey[17] = 2; $numkey[1] = $numkey[16]; $ok = true; $si = true; break; }}}}
        if($numkey[14]) { $tmp = false; if($opz == 1) { if($numkey[1][0] == '@') { for($a=0; $a<$n; $a++) $keyval[$numkey[1]][$a] = $keyval['p.'.$a]; } else { for($a=0; $a<$n; $a++) $keyval[$numkey[1]][$a] = $keyval[$a]; }} elseif($opz == 2) { if($numkey[1][0] == '#' || $numkey[1][0] == '@') { for($a=0; $a<$n; $a++) $keyval[$numkey[1]][$a] = $keyval[$a]; }} else { if($numkey[1][0] == '#' || $numkey[1][0] == '@') { for($a=0; $a<$n; $a++) { if(isset($keyval['N.'.$numkey[1].'.'.$a])) { for($b=0; $b<$keyval['N.'.$numkey[1].'.'.$a]; $b++) $keyval[$numkey[1]][] = $keyval[$numkey[1].'.'.$a][$b]; }}}} $kk['K'][0] = $numkey[1]; if(!isset($keyval[$numkey[1]])) return false;
            if(isset($numkey[20])) { $x = []; foreach($keyval[$numkey[1]] as $a) { $a = SYS::trak($a,true); if(is_array($a)) $x = array_merge($x,$a); else $x[] = $a; } $keyval[$numkey[1]] = $x; } for($a=0, $u=count($keyval[$numkey[1]]); $a<$u; $a++) if($keyval[$numkey[1]][$a] === false || $keyval[$numkey[1]][$a] === NULL) $keyval[$numkey[1]][$a] = ''; $k = array_count_values($keyval[$numkey[1]]); $av = array_keys($k); $an = array_values($k); $n = 0; for($a=0, $u=count($av); $a<$u; $a++) { $kk[$numkey[1]][$a] = $av[$a]; $kk['N.'.$numkey[1]][$a] = $an[$a]; $n += $an[$a]; } if($numkey[17]) { if($numkey[18] && $ok) { if($numkey[17] == 1) array_multisort($kk['N.'.$numkey[1]],SORT_DESC,SORT_NUMERIC,$kk[$numkey[1]]); elseif($numkey[17] == 2) array_multisort($kk['N.'.$numkey[1]],SORT_ASC,SORT_NUMERIC,$kk[$numkey[1]]); } else { if($numkey[17] == 1) array_multisort($kk[$numkey[1]],SORT_ASC,SORT_FLAG_CASE,$kk['N.'.$numkey[1]]); elseif($numkey[17] == 2) array_multisort($kk[$numkey[1]],SORT_DESC,SORT_FLAG_CASE,$kk['N.'.$numkey[1]]); }} $kk['T.'.$numkey[1]] = $n; $kk['N'] = count($av); $kk['T'] = $tot; if($kk['T'] > 0) return $kk;
        } else { if($numkey[17] == '' && is_array($numkey[13])) { foreach($numkey[13] as $a) { $b = $a[strlen($a)-1]; if($b == '+') { $numkey[17] = 1; $numkey[16] = substr($a,0,-1); $j = array_search($a,$numkey[18]); if($j !== false) $numkey[18][$j] = $numkey[16]; break; } elseif($b == '-') { $numkey[17] = 2; $numkey[16] = substr($a,0,-1); $j = array_search($a,$numkey[18]); if($j !== false) $numkey[18][$j] = $numkey[16]; break; }} if(!isset($keyval[$numkey[16]])) return SYS::error(2, 30, $a); } if($numkey[17]) { $tmp = false; $t = false; $x = -1; if($opz) { for($a=0; $a<$n; $a++) $keyval[$numkey[1]][$a] = $keyval[$a]; if(isset($keyval['-.0'])) $numkey[18] = array('-','p'); else $numkey[18] = []; } else { if(is_array($numkey[18])) { $b = $numkey[16]; if($si) { if($numkey[17] == 1) $b .= '+'; else $b .= '-'; } $j = array_search($b,$numkey[18]); if($j !== false) unset($numkey[18][$j]); $numkey[18] = SYS::sort($numkey[18]); }} if(isset($keyval['t.0']) || $numkey[0] == '@2') { $t = true; if($opz) $numkey[18][] = 't'; } for($a=0; $a<$n; $a++) $keyval['Q'][$a] = $a;
            if($t && !$opz) { if($numkey[17] == 1) array_multisort($keyval[$numkey[16]],SORT_ASC,SORT_FLAG_CASE,$keyval['Q'],$keyval['t.'.$numkey[16]]); elseif($numkey[17] == 2) array_multisort($keyval[$numkey[16]],SORT_DESC,SORT_FLAG_CASE,$keyval['Q'],$keyval['t.'.$numkey[16]]); } else { if($numkey[17] == 1) array_multisort($keyval[$numkey[16]],SORT_ASC,SORT_FLAG_CASE,$keyval['Q']); elseif($numkey[17] == 2) array_multisort($keyval[$numkey[16]],SORT_DESC,SORT_FLAG_CASE,$keyval['Q']); } if($numkey[0] != '@1' && $numkey[0] != '@2') { foreach($keyval['Q'] as $a) { $x++; $kk[$x] = $keyval[$a]; if($t && !$opz) $kk["t.$x"] = $keyval["t.$a"]; }} if($opz) { foreach($numkey[18] as $k) { $x = -1; foreach($keyval['Q'] as $a) { $x++; $kk["$k.$x"] = $keyval["$k.$a"]; }}} else { if(isset($keyval['K'])) $kk['K'] = SYS::u($keyval['K']); if($ok) { $kk[$numkey[16]] = $keyval[$numkey[16]]; if($t) $kk['t.'.$numkey[16]] = $keyval['t.'.$numkey[16]]; $kk['N.'.$numkey[16]] = $keyval['N.'.$numkey[16]]; } 
            if(isset($kk['K'])) { foreach($kk['K'] as $k) { $x = -1; foreach($keyval['Q'] as $a) { $x++; if($k[0] == '#' || $k[0] == '@') { if(isset($keyval["$k.$a"])) { $kk["$k.$x"] = $keyval["$k.$a"]; if($t) $kk["$k.t.$x"] = $keyval["$k.t.$a"]; $kk["N.$k.$x"] = $keyval["N.$k.$a"]; $kk["T.$k.$x"] = $keyval["T.$k.$a"]; }} else { if($numkey[16] != $k) { $kk[$k][$x] = $keyval[$k][$a]; if($t) $kk["t.$k"][$x] = $keyval["t.$k"][$a]; }}} if(isset($keyval["N.$k"])) $kk["N.$k"] = $keyval["N.$k"]; else $kk["N.$k"] = 0; }}} $kk['N'] = $n; $kk['T'] = $tot; if($kk['T'] > 0) return $kk; } $keyval['N'] = $n; $keyval['T'] = $tot; if($keyval['T'] > 0) return $keyval;
        } return false;
    }
    protected static function outmix($keybase, $key, $keyass, $valass=NULL, $opz=NULL, $ora, $type, $at=NULL, $ac=NULL, $tot=0, $fpt=NULL, $ccc=NULL) { $num = false; $ky = false; $valok = false; $percorso = ''; if($type) { if(strpos($keyass, '#') > 0) { $ky = explode('#', $keyass, 2); $valok = $ky[0]; $numkey = self::analisi($ky[1]); if($numkey[9] || is_array($numkey[1])) return self::Qdbout($ky[0].' #'.$ky[1].$key,$valass,$opz); } else { $ccc = true; $ky = explode('@', $keyass, 2); $valok = $ky[0]; $numkey = self::analisi($ky[1]); if($numkey[9] || is_array($numkey[1])) return self::Qdbout($ky[0].' @'.$ky[1].$key,$valass,$opz); } if($key) { $numkeyass = self::analisi($key); if(!$numkeyass[9] && !is_array($numkeyass[1])) $numkeyass[1] = array($numkeyass[1]); } else { $numkeyass[1] = false; $numkeyass[9] = false; $numkeyass[13] = false; $numkeyass[14] = false; }} else { $numkey = self::analisi($keyass); if($key) { $numkeyass = self::analisi($key); if($numkeyass[14]) $num = array($numkeyass[14],$numkeyass[16],$numkeyass[17],$numkeyass[18]); } else { $numkeyass[1] = false; $numkeyass[9] = false; }} $keyval['K'] = [];
        if($numkeyass[9] || $type > 1) { $numkeyass14 = $numkeyass[14]; if($at == 'Qver') $numkeyass[14] = $numkeyass[1]; else { $numkey[8] = '#'; $numkeyass[14] = ''; } $ok = 0; if($valass != NULL) { if(is_array($ky)) { global $Qdatabase; $tmp = SYS::combina($numkey[1]); if($ccc) $tmp[] = '1'; else $tmp[] = '0'; $percorso = $Qdatabase.'/'.SYS::keyvalass($ky[0], $valass, $tmp); $valass = $opz; if($opz === _T1_ || $opz === _T2_) $ok = 2; else $ok = 1; } else return false; } else { if($type && !$ccc) { if(strstr($ky[1],'[')) { $tmp = self::analisi($ky[1]); $tmp[1] = $ky[0]; $ky[1] = substr($ky[1],0,strpos($ky[1],'[')); } else $tmp = self::analisi($ky[0]); $percorso = SYS::combina($tmp[1],2).'/'.rtrim(SYS::combina($numkey[1],1)).'.0'; if($numkey[0] == '') { $numkey = $tmp; $numkey[1] = $ky[1]; } if($valass === _T1_ || $valass === _T2_) $ok = 2; } else { if($type == 3 && $ccc) { if(strstr($ky[1],'[')) { $tmp = self::analisi($ky[1]); $tmp[1] = $ky[0]; $ky[1] = substr($ky[1],0,strpos($ky[1],'[')); } else $tmp = self::analisi($ky[0]); $percorso = SYS::combina($tmp[1],2).'/'.rtrim(SYS::combina($numkey[1],1)).'.@.0'; if($numkey[0] == '') { $numkey = $tmp; $numkey[1] = $ky[1]; } if($valass === _T1_ || $valass === _T2_) $ok = 2; }} if(is_array($numkeyass[13])){ foreach($numkeyass[13] as $y){ if($y[0] == '!'){ $numkey[8] = '#'; break; }}}} $y = $numkey;
            if($numkeyass[9] && $type < 3) { require_once 'Qnr.php'; $numkey[7] = '#'; if($ccc) { if($type) $per = SYS::combina($valok,2).'/@'; else $per = SYS::combina($ccc,2).'/@'; $tmp = SYS::combina($numkey[1]); foreach($tmp as $a) $per .= '/'.$a; } else $per = SYS::combina($numkey[1],2); $dati = Qnr::numerico($per,$numkeyass,$numkey); if(!$dati) return false; if(is_array($at) && $at) { $x = false; if($ac) { if($ccc) { $x = Qsx::ccc($numkey,$dati); $dati = $x[0]; $tempo = $x[1]; } else $dati = SYS::val($dati); } $dati = array_values(array_intersect($at,$dati)); if(!$dati) return false; if($ccc && !$x) { $x = Qsx::ccc($numkey,$dati); $dati = $x[0]; $tempo = $x[1]; } unset($x); } else { if($at == 'Qver') return $dati; }} else { if($type < 3) { if($ccc) { $x = Qsx::ccc($numkey,$at); $dati = $x[0]; $tempo = $x[1]; unset($x); } else $dati = $at; }}
            if($type) { if($type == 3){ if($opz === _T1_ || $opz === _T2_) $ok = 2; } if($ok == 2) { $fp = SYS::leggi($percorso,0,self::moltiplicatore($numkey,1),2); if(!isset($fp[2])) return false; if($type == 3) return $fp; if($fp[2][0] == '#') { for($a=2, $u=count($fp); $a<$u; $a++) { $e = explode('.',$fp[$a]); $fx[$a-2] = substr($e[0],1)."\n"; $fp[$a-2] = $e[1]; } $ok = -1; } else { if($opz === _T1_ || $opz === _T2_) { for($a=2, $u=count($fp); $a<$u; $a++) { $e = explode('.',$fp[$a]); if($ccc) { $fp[$a-2] = array_pop($e); $fx[$a-2] = implode('.',$e); } else { $fx[$a-2] = $e[0]; $fp[$a-2] = $e[1]; $ok = -2; }}} else { for($a=2, $u=count($fp); $a<$u; $a++) { $e = explode('.',$fp[$a]); $fx[$a-2] = $e[0]."\n"; $fp[$a-2] = $e[1]; }}} unset($fp[count($fp)-1]); unset($fp[count($fp)-1]); } else { if(!$ccc) { $fx = SYS::leggi($percorso,0,self::moltiplicatore($numkey,1),1); if(!isset($fx[2])) return false; if($type == 3) return $fx; if($fx[2][0] == '#') $ok = 0; $fx = self::tagli01($fx,$ok); } else { if($percorso) { $fx = SYS::leggi($percorso,0,self::moltiplicatore($numkey,1),1); if(!isset($fx[2])) return false; if($type == 3) return $fx; $fx = self::tagli01($fx,$ok); } else { $fx = $dati; $fp = $tempo; $ccc = 2; }}}
                if($fx) { if($ccc) { if($opz === _T1_ || $opz === _T2_ || $valass === _T1_ || $valass === _T2_) $ok = 2; else $ok = 1; } else { if($fx[0][0] == '#') { for($a=0, $u=count($fx); $a<$u; $a++) $fx[$a] = substr($fx[$a],1); } else { if($ok > 0) { if($valass !== _T1_ && $valass !== _T2_) $dati = SYS::val(self::adesso($dati)); else $ok = -1; } elseif($ok == -2) $dati = SYS::val(self::adesso($dati)); }} if($ccc !== 2) { $fx = array_intersect($fx,$dati); if(!$fx) return false; if(!$numkeyass[9] && $y[7][0] == '-') $y[7] = substr($y[7],1); } $val = Qout::selezione(array_values($fx),$y); if($ok) { if($ok == -1) $keyval = SYS::val(self::adesso($val)); else $keyval = $val; if($ok == 2 || $ok < 0) { $val = []; $e = array_keys($fx); foreach($e as $a) $val[] = $fp[$a]; $val = Qout::selezione($val,$y); }} else $keyval = SYS::val(self::adesso($val)); $keyk = count($keyval); if($valass === _T1_ || $valass === _T2_) $opz = $valass; if($opz === _T1_ || $opz === _T2_) { for($a=0, $u=count($val); $a<$u; $a++) if($qt=SYS::tempo($opz,$val[$a],$ora)) $keyval["t.$a"] = $qt; } if(!is_array($numkeyass[1])) $numkeyass[1] = array($numkeyass[1]); if($numkeyass[13] != '') $numkeyass[1] = array_merge($numkeyass[1],$numkeyass[13]); $numkeyass[14] = $numkeyass14; if(!$ccc) $keyl = SYS::tot($percorso); else $keyl = count($at); } else return false;
            } else { if(is_array($at) && !$ac) $dati = array_values(array_intersect($at,$dati)); if($fpt) { $fp = []; $k = array_keys($dati); for($a=0, $u=count($k); $a<$u; $a++) $fp[$a] = $fpt[$k[$a]]; $fpt = Qout::selezione($fp,$y); $keyk = count($fpt); if($ac) $keyval = Qout::selezione($dati,$y); else $keyval = Qout::selezione(SYS::val(self::adesso($dati)),$y); for($a=0; $a<$keyk; $a++) $keyval["t.$a"] = $fpt[$a]; } else { if($ccc) $keyval = Qout::selezione($dati,$y); else $keyval = Qout::selezione($dati,$y,1); $keyk = count($keyval); } if($keyk > 0) { if($ac) $keyl = $tot; else { if(!$fpt) $keyval = self::time12($keyval,$valass,$ora); if($tot) $keyl = $tot; else $keyl = SYS::tot(SYS::combina($numkey[1],2)); } if(!is_array($numkeyass[1])) $numkeyass[1] = array($numkeyass[1]); if($numkeyass[13]) $numkeyass[1] = array_merge($numkeyass[1],$numkeyass[13]); if($num) { $numkeyass[14] = $num[0]; $numkeyass[16] = $num[1]; $numkeyass[17] = $num[2]; $numkeyass[18] = $num[3]; }} else return false; if($valass === _T1_ || $valass === _T2_) $opz = $valass; }
        } else { if($at == 'Qver') return false;
            if(is_array($at) && $at) { $tmp = false; if(is_array($at)) { if($numkey[3]) $tmp = true; } else $tmp = true; $at = Qout::selezione($at,$numkey,$tmp); if(!$at) return false; if($ac) $keyval = $at; else { if(!$ccc) { if(!$fpt) $keyval = self::time12($at,$valass,$ora); else $keyval = SYS::val(self::adesso($at)); } else $keyval = $at; } if($valass === _T1_ || $valass === _T2_) { $opz = $valass; if($fpt) { $fpt = Qout::selezione($fpt,$numkey,1); for($a=0, $u=count($fpt); $a<$u; $a++) $keyval["t.$a"] = $fpt[$a]; $keyval['N'] = count($keyval)/2; } else $keyval['N'] = count($keyval)/2; } else $keyval['N'] = count($keyval); if($tot) $keyval['T'] = $tot; else $keyval['T'] = SYS::tot(SYS::combina($numkey[1],2)); } elseif($valass == NULL) $keyval = self::Qdbout($keyass); else { if($type || $valass === _T1_ || $valass === _T2_) { if(!$numkey[0] && !$numkey[3]) return self::valopz($numkeyass[1], $keyass, $valass, $opz, $ora); $keyval = self::Qdbout($keyass,$valass,$opz); if($valass === _T1_ || $valass === _T2_) $opz = $valass; } else return self::valopz($numkeyass[1], $keyass, $valass, $opz, $ora); } if(!$numkeyass[1]) return $keyval; $keyk = $keyval['N']; $keyl = $keyval['T']; unset($keyval['N']); unset($keyval['T']); 
        } if(!$numkeyass[1][0]) { $keyval['N'] = $keyk; $keyval['T'] = $keyl; return $keyval; } $numkeyass[1] = SYS::sort($numkeyass[1]); $w = 0; $dat = []; $ky = []; if(is_array($numkeyass[1])) { foreach($numkeyass[1] as $key) { $dati = self::analisi($key); if($dati[1][0] == '#' || $dati[1][0] == '@') $k = explode(' ',substr($dati[1],1)); else { if($dati[1][0] == '_') $k = explode(' ',substr($dati[1],1)); else $k = explode(' ',$dati[1]); $ok = true; } foreach($k as $x) { $y = explode('.',$x); foreach($y as $z) if(!in_array($z."\n",$keybase)) { $ok = false; break; }} if($ok) { $keyval['K'][$w] = $dati[1]; $ky[$w] = $key; $w++; } else SYS::error(0,1,$dati[1]); } $ky = array_reverse($ky); $x = $w; } else { $keyval['K'][0] = $numkeyass[1]; $ky[0] = $key; $x = 1; } if(!isset($keyval[0])) return false; $si = false; foreach($ky as $key) { $x--; $y = $keyval['K'][$x]; if($key[0] == '#' || $key[0] == '@') { for($a=0; $a<$keyk; $a++) { $val = self::Qdbout($numkey[1].' '.$key,$keyval[$a],$opz); if($val) { if($opz === _T1_ || $opz === _T2_) { for($b=0; $b<$val['N']; $b++) { $keyval["$y.t.$a"][$b] = $val["t.$b"]; unset($val["t.$b"]); }} $keyval["$y.$a"] = $val; unset($keyval["$y.$a"]['N']); unset($keyval["$y.$a"]['T']); $keyval["N.$y.$a"] = $val['N']; $keyval["T.$y.$a"] = $val['T']; if(isset($dat["N.$y"])) $dat["N.$y"]++; else $dat["N.$y"] = 1; }}} else { $si = true; 
            if($valass == NULL || $valass === _T1_ || $valass === _T2_) { if(strpos($valok,'#') > 1) { for($a=0; $a<$keyk; $a++) { $w = 0; if($opz) { for($b=0; $b<$keyval["N.#$numkey[1].$a"]; $b++) { $val = self::Qdbout($numkey[1].' '.$key,$keyval["#$numkey[1].$a"][$b],$opz); $keyval["$y.$a"][$b] = $val[$key]; $keyval["$y.t.$a"][$b] = $val["t.$key"]; if($keyval["$y.$a"][$b] != '') $w++; } $keyval["N.$y.$a"] = $w; } else { for($b=0; $b<$keyval["N.#$numkey[1].$a"]; $b++) { $keyval["$y.$a"][$b] = self::Qdbout($numkey[1].' '.$key,$keyval["#$numkey[1].$a"][$b]); if($keyval["$y.$a"][$b] != '') $w++; } $keyval["N.$y.$a"] = $w; }} $keyval["N.$y"] = $keyval["N.#$numkey[1]"]; } else { $w = 0; for($a=0; $a<$keyk; $a++) { if($opz) { if($ccc) $val = self::Qdbout("@$numkey[1] $key",$keyval[$a],$opz); else $val = self::Qdbout("$numkey[1] $key",$keyval[$a],$opz); $keyval[$y][$a] = $val[$y]; $keyval["t.$y"][$a] = $val["t.$y"]; } else { if($ccc) $keyval[$y][$a] = self::Qdbout("@$numkey[1] $key",$keyval[$a]); else $keyval[$y][$a] = self::Qdbout("$numkey[1] $key",$keyval[$a]); } if($keyval[$y][$a] != '') $w++; } $keyval["N.$y"] = $w; }} else { $w = 0; for($a=0; $a<$keyk; $a++) { if($opz) { $val = self::Qdbout("$numkey[1] $key",$keyval[$a],$opz); $keyval[$y][$a] = $val[$y]; $keyval["t.$y"][$a] = $val["t.$y"]; } else $keyval[$y][$a] = self::Qdbout("$numkey[1] $key",$keyval[$a]); if($keyval[$y][$a] != '') $w++; } $keyval["N.$y"] = $w; }}
        } if($si) { for($a=0; $a<$keyk; $a++) { if($opz) unset($keyval["#$numkey[1].t.$a"]); unset($keyval["#$numkey[1].$a"]); unset($keyval["N.#$numkey[1].$a"]); unset($keyval["T.#$numkey[1].$a"]); } unset($keyval["N.#$numkey[1]"]); } if($dat) $keyval = array_merge($keyval,$dat); $keyval['N'] = $keyk; $keyval['T'] = $keyl; if($numkeyass[14]) $numkeyass[1] = $numkeyass[14]; else $numkeyass[18] = $ky; if($keyval['N'] > 0) return Qmix::flusso($numkeyass,$keyval,$keyval['T'],$keyval['N'],0,$numkey); else return false;
    }
}