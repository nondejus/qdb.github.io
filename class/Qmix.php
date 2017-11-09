<?php

namespace Quantico;

class Qmix extends Qout
{
    private static function valopz($key, $keyass, $valass, $opz, $ora) { $per = SYS::combina($key); if($per) { $perass = SYS::keyvalass($keyass, $valass, $per); if($perass) { $val = SYS::val($perass."\n"); if($opz !== _T1_ && $opz !== _T2_) return $val; $keyval['K'] = $key; $keyval[$key] = $val; $qt = SYS::tempo($opz,$perass,$ora); if($qt !== null) $keyval["t.$key"] = $qt; return $keyval; }} return NULL; }
    private static function keyval($keyass, $valass, $opz) { if(strpos($keyass,'#') > 1) { $e = explode('#',$keyass); if(!strpos($e[0],'[') && strpos($e[1],'[')) { $e[0] .= substr($e[1], strpos($e[1],'['), strpos($e[1],']')); } if(!strpos($e[0],'(' && strpos($e[1],'('))) { $e[0] .= substr($e[1], strpos($e[1],'('), strpos($e[1],')')); } return Qout::Qdbout("#$e[0] $e[1]",$valass); } else return Qout::Qdbout($keyass, $valass, $opz); }
    private static function percorso($ok, $ky, $numkey, $valass, $opz) { if(strstr($ky[1],'[')) { $tmp = Qout::analisi($ky[1]); $tmp[1] = $ky[0]; $ky[1] = substr($ky[1],0,strpos($ky[1],'[')); } else $tmp = Qout::analisi($ky[0]); $percorso = SYS::combina($tmp[1],2).'/'.rtrim(SYS::combina($numkey[1],1)).$opz; if($numkey[0] == '') { $numkey = $tmp; $numkey[1] = $ky[1]; } if($valass === _T1_ || $valass === _T2_) $ok = 2; return [$percorso, $numkey, $ok]; }
    private static function moltiplicatore($num, $opz=0) { if($opz) { global $QprcPersonal; $Qmol = $QprcPersonal; } else $Qmol = 1; if($num[0] == '') { global $Qposdef; $num[0] = $Qposdef*$Qmol; $num[2] = 0; } elseif($num[2] == -1) { $num[0] = ($num[0]-2)*$Qmol; $num[2] = 0; } else { if($num[6]) { $num[0] = $num[2]*$Qmol; $num[2] = 0; $num[6] = ''; } else { $num[0] = ($num[0]-2)*$Qmol; $num[2] = 0; }} return $num; }
    
    protected static function tagli01($fx,$opz=0) { if($opz) { for($a=2, $u=count($fx); $a<$u; $a++) $fx[$a-2] = rtrim($fx[$a]); } else { for($a=2, $u=count($fx); $a<$u; $a++) $fx[$a-2] = $fx[$a]; } unset($fx[count($fx)-1]); unset($fx[count($fx)-1]); return $fx; }
    protected static function valass($key, $keyass, $numkey, $numkeyass, $valass, $ora) { $keyper = SYS::combina($keyass, 2); if($keyass[0] == '#') $keypers = "$keyper/keyp.php"; else $keypers = "$keyper/keyc.php"; if(file_exists($keypers)){ $fp = file($keypers); $key = rtrim($key); if($keyass[0] == '#') $p = '.0'; else $p = '.1'; $keyper .= '/'.$key.$p; if($valass === _T1_ || $valass === _T2_) $o = 2; else $o = 1; $a = array_search($key."\n",$fp); 
        if($a > 1) { $fp = []; if($keyass[0] == '#') { $fx = SYS::leggi($keyper ,0 ,$numkeyass ,$o); for($x=2, $u=count($fx); $x<$u; $x++) { $n = $x-2; if($valass === _T1_ || $valass === _T2_) { $f = explode('|', rtrim($fx[$x])); $fp[$n] = $f[0]."\n"; $qt = SYS::tempo($valass,$f[1],$ora); if($qt !== null) $keyval["t.$n"] = $qt; } else $fp[$n] = $fx[$x]; }} else { $fx = SYS::leggi($keyper ,0 ,$numkeyass ,1 ,$o); for($x=2, $u=count($fx); $x<$u; $x++) { $f = explode('|', $fx[$x]); $n = $x-2; if($f[0][0] == '-') { $fp[$n] = substr($f[0], 12); $tempo = (int)substr($f[0], 2, 10); $keyval['-.'.$n] = base64_encode($fp[$n]); } else { $fp[$n] = $f[0]; $keyval['-.'.$n] = 0; $tempo = (int)substr($f[count($f)-1], 0, 10); } $keyval["p.$n"] = $f[1]; if($valass === _T1_) $keyval["t.$n"] = $tempo; elseif($valass === _T2_) $keyval["t.$n"] = $ora - $tempo; }} if($fp) { $vl = SYS::val($fp); foreach($vl as $val) $keyval[] = $val; unset($keyval['K']); $Qdb = new SYS; return $Qdb->_flusso($numkey,$keyval,(int)$fx[0],(int)$fx[1],1,$numkeyass); }}} return false;
    }
    protected static function outmix($key, $keyass, $valass=null, $opz=null, $ora, $type, $at=null, $ac=null, $tot=0, $fpt=null, $ccc=null) { $ky = false; $num = false; $dati = false; $valok = false; $percorso = ''; if($type) { if(strpos($keyass, '#') > 0) { $ky = explode('#', $keyass, 2); $valok = $ky[0]; $numkey = Qout::analisi($ky[1]); if($numkey[9] || is_array($numkey[1])) return Qout::Qdbout($ky[0].' #'.$ky[1].$key,$valass,$opz); } else { $ccc = true; $ky = explode('@', $keyass, 2); $valok = $ky[0]; $numkey = Qout::analisi($ky[1]); if($numkey[9] || is_array($numkey[1])) return Qout::Qdbout($ky[0].' @'.$ky[1].$key,$valass,$opz); } if($key) { $numkeyass = Qout::analisi($key); if(!$numkeyass[9] && !is_array($numkeyass[1])) $numkeyass[1] = array($numkeyass[1]); } else { $numkeyass[1] = false; $numkeyass[9] = false; $numkeyass[13] = false; $numkeyass[14] = false; }} else { $numkey = Qout::analisi($keyass); if($key) { $numkeyass = Qout::analisi($key); if($numkeyass[14]) $num = array($numkeyass[14],$numkeyass[16],$numkeyass[17],$numkeyass[18]); } else { $numkeyass[1] = false; $numkeyass[9] = false; }} $keyval['K'] = [];
        if($numkeyass[9] || $type > 1) { $numkeyass14 = $numkeyass[14]; if($at == 'Qver') $numkeyass[14] = $numkeyass[1]; else { $numkey[8] = '#'; $numkeyass[14] = ''; } $ok = 0; if($valass != null && $valass !== _T1_ && $valass !== _T2_){ if(is_array($ky)) { global $Qdatabase; $tmp = SYS::combina($numkey[1]); if($ccc) $tmp[] = '1'; else $tmp[] = '0'; $percorso = $Qdatabase.'/'.SYS::keyvalass($ky[0], $valass, $tmp); $valass = $opz; if($opz === _T1_ || $opz === _T2_) $ok = 2; else $ok = 1; } else return false; } else { if($type && !$ccc) { $percorso = Qmix::percorso($ok, $ky, $numkey, $valass, '.0'); $ok = $percorso[2]; $numkey = $percorso[1]; $percorso = $percorso[0]; } else { if($type == 3 && $ccc) { $percorso = Qmix::percorso($ok, $ky, $numkey, $valass, '.@.0'); $ok = $percorso[2]; $numkey = $percorso[1]; $percorso = $percorso[0]; }} if(is_array($numkeyass[13])){ foreach($numkeyass[13] as $y){ if($y[0] == '!'){ $numkey[8] = '#'; break; }}}} $y = $numkey;
            if($numkeyass[9] && $type < 3) { $numkey[7] = '#'; require_once 'Qnr.php'; $dati = Qnr::numerico($numkeyass,$numkey,$type,$ccc,$valok); if(!$dati) return false;
                if(is_array($at) && $at) { $x = false; 
                    if($ac) { if($ccc) { $x = Qsx::ccc($numkey,$dati); $dati = $x[0]; $tempo = $x[1]; } else $dati = SYS::val($dati); } 
                    $dati = array_values(array_intersect($at,$dati)); if(!$dati) return false; 
                    if($ccc && !$x) { $x = Qsx::ccc($numkey,$dati); $dati = $x[0]; $tempo = $x[1]; } unset($x); 
                } else { 
                    if($at == 'Qver') return $dati; 
                }
            } else { 
                if($type < 3) { 
                    if($ccc) { $x = Qsx::ccc($numkey,$at); $dati = $x[0]; $tempo = $x[1]; unset($x); } else $dati = $at; 
                }
            }
            if($type) {
                if($type == 3){ if($opz === _T1_ || $opz === _T2_) $ok = 2; } 
                if($ok == 2) { $fp = SYS::leggi($percorso,0,Qmix::moltiplicatore($numkey,1),2); if(!isset($fp[2])) return false; if($type == 3) return $fp; 
                    if($fp[2][0] == '#') { 
                        for($a=2, $u=count($fp); $a<$u; $a++) { $e = explode('|',$fp[$a]); $fx[$a-2] = substr($e[0],1)."\n"; $fp[$a-2] = $e[1]; } $ok = -1; 
                    } else { 
                        if($opz === _T1_ || $opz === _T2_) { 
                            for($a=2, $u=count($fp); $a<$u; $a++) { $e = explode('|',$fp[$a]); $fp[$a-2] = $e[1]; $fx[$a-2] = $e[0]; } if(!$ccc) $ok = -2; 
                        } else { 
                            for($a=2, $u=count($fp); $a<$u; $a++) { $e = explode('|',$fp[$a]); $fx[$a-2] = $e[0]."\n"; $fp[$a-2] = $e[1]; }
                        }
                    } unset($fp[count($fp)-1]); unset($fp[count($fp)-1]); 
                } else { 
                    if(!$ccc || $percorso) { $fx = SYS::leggi($percorso,0,Qmix::moltiplicatore($numkey,1),1); if(!isset($fx[2])) return false; if($type == 3) return $fx; 
                        if(!$ccc && $fx[2][0] == '#') $ok = 0; $fx = Qmix::tagli01($fx,$ok); 
                    } else { $fx = $dati; $fp = $tempo; $ccc = 2; }
                } 
                if(!$fx) return false;
                 
                if($ccc) { 
                    if($opz === _T1_ || $opz === _T2_ || $valass === _T1_ || $valass === _T2_) $ok = 2; else $ok = 1; 
                } else { 
                    if($fx[0][0] == '#') { 
                        for($a=0, $u=count($fx); $a<$u; $a++) $fx[$a] = substr($fx[$a],1); 
                    } else { 
                        if($ok > 0) { if($valass !== _T1_ && $valass !== _T2_) $dati = SYS::val(Qout::now($dati)); else $ok = -1; } 
                        elseif($ok == -2) $dati = SYS::val(Qout::now($dati)); 
                    }
                }
                if($ccc !== 2) { $fx = array_intersect($fx,$dati); if(!$fx) return false; if(!$numkeyass[9] && $y[7][0] == '-') $y[7] = substr($y[7],1); }
                
                $val = SYS::selezione(array_values($fx),$y);
                
                if($ok) { 
                    if($ok == -1) $keyval = SYS::val(Qout::now($val)); else $keyval = $val; 
                    if($ok == 2 || $ok < 0) { $val = []; $e = array_keys($fx); foreach($e as $a) $val[] = $fp[$a]; $val = SYS::selezione($val,$y); }
                } else $keyval = SYS::val(Qout::now($val)); $keyk = count($keyval);
                 
                if($valass === _T1_ || $valass === _T2_) $opz = $valass; 
                if($opz === _T1_ || $opz === _T2_) { for($a=0, $u=count($val); $a<$u; $a++) { $qt = SYS::tempo($opz,$val[$a],$ora); if($qt !== null) $keyval["t.$a"] = $qt; }} 
                if(!is_array($numkeyass[1])) $numkeyass[1] = array($numkeyass[1]); if($numkeyass[13] != '') $numkeyass[1] = array_merge($numkeyass[1],$numkeyass[13]); $numkeyass[14] = $numkeyass14; 
                if(!$ccc) $keyl = SYS::tot($percorso); else $keyl = count($at); 
            } else { 
                if(is_array($at) && !$ac) $dati = array_values(array_intersect($at,$dati)); 
                if($fpt) { $fp = []; $k = array_keys($dati); 
                    for($a=0, $u=count($k); $a<$u; $a++) $fp[$a] = $fpt[$k[$a]]; 
                    $fpt = SYS::selezione($fp,$y); $keyk = count($fpt); 
                    if($ac) $keyval = SYS::selezione($dati,$y); else $keyval = SYS::selezione(SYS::val(Qout::now($dati)),$y); 
                    for($a=0; $a<$keyk; $a++) $keyval["t.$a"] = $fpt[$a]; 
                } else { 
                    if($ccc) $keyval = SYS::selezione($dati,$y); else $keyval = SYS::selezione($dati,$y,1); $keyk = count($keyval); 
                } 
                if(!$keyk) return false;
                 
                if($ac) $keyl = $tot; else { if(!$fpt) $keyval = Qout::time12($keyval,$valass,$ora); if($tot) $keyl = $tot; else $keyl = SYS::tot(SYS::combina($numkey[1],2)); } 
                if(!is_array($numkeyass[1])) $numkeyass[1] = array($numkeyass[1]); 
                if($numkeyass[13]) $numkeyass[1] = array_merge($numkeyass[1],$numkeyass[13]); 
                if($num) { $numkeyass[14] = $num[0]; $numkeyass[16] = $num[1]; $numkeyass[17] = $num[2]; $numkeyass[18] = $num[3]; }
                if($valass === _T1_ || $valass === _T2_) $opz = $valass; 
            }
        } else { if($at == 'Qver') return false;
            if(is_array($at) && $at) { $tmp = false;
                if(is_array($at)) { if($numkey[3]) $tmp = true; } else $tmp = true; 
                
                $at = SYS::selezione($at,$numkey,$tmp); if(!$at) return false; 
                
                if($ac) $keyval = $at; else { if(!$ccc) { if(!$fpt) $keyval = Qout::time12($at,$valass,$ora); else $keyval = SYS::val(Qout::now($at)); } else $keyval = $at; } 
                if($valass === _T1_ || $valass === _T2_) { $opz = $valass; 
                    if($fpt) { 
                        $fpt = SYS::selezione($fpt,$numkey,1); 
                        for($a=0, $u=count($fpt); $a<$u; $a++) $keyval["t.$a"] = $fpt[$a]; 
                        $keyval['N'] = count($keyval)/2; 
                    } else $keyval['N'] = count($keyval)/2; 
                } else $keyval['N'] = count($keyval); 
                if($tot) $keyval['T'] = $tot; else $keyval['T'] = SYS::tot(SYS::combina($numkey[1],2)); 
            } 
            elseif($valass == null) $keyval = Qmix::keyval($keyass, $valass, $opz);
            else { 
                if($type || $valass === _T1_ || $valass === _T2_) {
                    if(is_array($numkeyass[1])) $keyval = Qout::Qdbout($keyass, $valass, $opz);
                    else {
                        if(!$numkey[0] && !$numkey[3]) return Qmix::valopz($numkeyass[1], $keyass, $valass, $opz, $ora);
                        $keyval = Qmix::keyval($keyass, $valass, $opz);
                    } 
                    if($valass === _T1_ || $valass === _T2_) $opz = $valass; 
                } else return Qmix::valopz($numkeyass[1], $keyass, $valass, $opz, $ora); 
            }
            if(!$numkeyass[1]) {
                if($numkey[17]) { 
                    if($numkey[14]) $numkey[14] = false; $Qdb = new SYS;
                    return $Qdb->_flusso($numkey, $keyval, $keyval['T'], $keyval['N'], 1); 
                }
                return $keyval;
            }
            
            $keyk = $keyval['N']; 
            $keyl = $keyval['T']; 
            unset($keyval['N']); 
            unset($keyval['T']); 
        }
        if(!$numkeyass[1][0]) { $keyval['N'] = $keyk; $keyval['T'] = $keyl; return $keyval; } require_once 'Qmxf.php';
        return Qmxf::mixflusso($keyval, $key, $keyk, $keyl, $numkey, $numkeyass, $dati, $ccc, $opz, $valass, $valok);
    }
}