<?php

namespace Quantico;

class Qout extends SYS
{
    protected static function stato($key) { $keyper = array(); foreach($key as $k) { $s = explode('#',$k); if(isset($keyper[$s[0]])) $keyper[$s[0]][$s[1]] = ((int)$keyper[$s[0]][$s[1]] + 1)."\n"; else { $stato = $s[0].'/stat.php'; if(file_exists($stato)){ $keyper[$s[0]] = file($stato); $keyper[$s[0]][$s[1]] = ((int)$keyper[$s[0]][$s[1]] + 1)."\n"; }}} $ak = array_keys($keyper); foreach($ak as $k) w($k.'/stat.php',$keyper[$k]); }
    protected static function selezione($keyval,$num,$opz=0) { if(!$keyval) return false; global $Qposdef; $key = array(); if($opz) { if($num[3]) { $inizio = $num[3]; $fine = $num[4]; if(!$num[5]) $keyval = array_reverse($keyval); foreach($keyval as $a) { $n = substr($a,0,10); if($n >= $inizio && $n <= $fine) $key[] = $a; } if(count($key) == 0) return false; $keyval = $key; $key = array(); }} if(!isset($num[7])) return false;
        if(strstr($num[7],'-')) { global $Qposmax; $tot = count($keyval); $d = explode(':', $num[7]); if(count($d) == 1) { $num[6] = 1; $num[2] = $tot - 1; if($num[7] == '-') $num[0] = $tot - $Qposdef; elseif($num[7] == '-0') $num[0] = $tot - $Qposmax; else $num[0] = $tot + $num[7]; if($num[0] < 0) $num[0] = 0; $num[0] += 2; } elseif(count($d) == 2) { if($d[0] < 0 && $d[1] < 0) { $num[2] = $tot + $d[0]; $num[0] = $tot + $d[1]; if($num[0] < 0) $num[0] = 0; if($num[2] < 0) $num[2] = 0; $d[1] = $num[0]; $d[0] = $num[2]; $num[0] += 2; } elseif($d[0] < 0) { $num[2] = $tot + $d[0]; $num[0] = $d[1] + 2; if($num[2] < 0) $num[2] = 0; $d[0] = $num[2]; } else { $num[2] = $d[0]; $num[0] = $tot + $d[1]; if($num[0] < 0) $num[0] = 0; $d[1] = $num[0]; $num[0] += 2; } if($d[0] > $d[1]) $num[6] = true; } else return false; } if($num[0] == '') $fine = $Qposdef-1; else $fine = $num[0]-3; if($num[2] == -1) $inizio = 0; else { $fine++; if($num[6]) { $inizio = $fine; $fine = $num[2]; } else $inizio = $num[2]; } $n = count($keyval)-1; if($inizio > $n) return false; if($fine > $n) $fine = $n; if($num[6]) { for($a=$fine; $a>=$inizio; $a--) $key[] = $keyval[$a]; } else { for($a=$inizio; $a<=$fine; $a++) $key[] = $keyval[$a]; } return $key; }
    protected static function parentesi($key,$keyass,$valass,$opz,$type,$sel) { if(strpos($keyass, ',') > 1) { $val = array(' ','#','@'); $par = array(')',']','}'); foreach($par as $p) { $j = strpos($keyass, $p); if($j > 1) { $j++; if(!in_array($keyass[$j],$val)) { $j = explode($p, $keyass, 2); return self::Qdbout($j[0]."$p ".$j[1].$sel.$key,$valass,$opz); }}}} if(strpos($key, ',') > 1) { if($sel == '#') return self::Qdbout("$keyass #$key",$valass,$opz,$type); else return self::Qdbout("$keyass @$key",$valass,$opz); } return false; }
    protected static function time12($keyval,$type=0,$ora=0,$arr=false) { if(!$keyval) return false; $key = SYS::val(self::adesso($keyval)); if(is_array($arr)) $keyval = $arr; if($type == -1) { for($a=0; $a<count($keyval); $a++) $key['t.'.$a] = substr($keyval[$a], 0, 10); } elseif($type == -2) { if(!$ora) $ora = SYS::time(); for($a=0; $a<count($keyval); $a++) $key['t.'.$a] = $ora - substr($keyval[$a], 0, 10); } return $key; }
    protected static function tagli01($fx,$opz=0) { if($opz) { for($a=2; $a<count($fx); $a++) $fx[$a-2] = rtrim($fx[$a]); } else { for($a=2; $a<count($fx); $a++) $fx[$a-2] = $fx[$a]; } unset($fx[count($fx)-1]); unset($fx[count($fx)-1]); return $fx; }
    protected static function moltiplicatore($num,$opz=0) { global $Qposdef; if($opz) { global $QprcPersonal; $Qmol = $QprcPersonal; } else $Qmol = 1; if($num[0] == '') { $num[0] = $Qposdef*$Qmol; $num[2] = 0; } elseif($num[2] == -1) { $num[0] = ($num[0]-2)*$Qmol; $num[2] = 0; } else { if($num[6]) { $num[0] = $num[2]*$Qmol; $num[2] = 0; $num[6] = ''; } else { $num[0] = ($num[0]-2)*$Qmol; $num[2] = 0; }} return $num; }
    protected static function adesso_aggiorna($keyval,$k,$kv) { if(is_array($keyval) && $k) { $pos = array_keys($keyval,$k); foreach($pos as $p) $keyval[$p] = $kv; return $keyval; } else return false; }
    protected static function adesso($keyval){ global $Qdatabase; global $Qpostime; $per = $Qdatabase.$Qpostime; $keyper = array(); if(is_array($keyval)) $key = SYS::u($keyval); else $key = array($keyval); foreach($key as $k) { if($k[10] != ':') { $z = substr($k,0,3).'/'.substr($k,3,$k[12]); $per = "$Qdatabase$Qpostime/$z"; $pern = "$per/keyn.php"; $perv = "$per/keyv.php";
        if(isset($keyper[$z.'v'])) { $ok = true; while($ok){ $j = array_search($k,$keyper[$z.'v']); if($j > 1) { $kv = $keyper[$z.'n'][$j]; $z = substr($kv,0,3).'/'.substr($kv,3,$kv[12]); if(!isset($keyper[$z.'v'])) { $keyval = self::adesso_aggiorna($keyval,$k,$kv); $per = "$Qdatabase$Qpostime/$z"; $pern = "$per/keyn.php"; $perv = "$per/keyv.php"; if(file_exists($pern)){ $keyper[$z.'n'] = file($pern); $keyper[$z.'v'] = file($perv); } else $ok = false; } else $keyval = self::adesso_aggiorna($keyval,$k,$kv); $k = $kv; } else $ok = false; }} else { if(file_exists($pern)){ $keyper[$z.'n'] = file($pern); $keyper[$z.'v'] = file($perv); $ok = true; while($ok){ $j = array_search($k,$keyper[$z.'v']); if($j > 1) { $kv = $keyper[$z.'n'][$j]; $z = substr($kv,0,3).'/'.substr($kv,3,$kv[12]); if(!isset($keyper[$z.'v'])) { if(is_array($keyval)) $keyval = self::adesso_aggiorna($keyval,$k,$kv); $per = "$Qdatabase$Qpostime/$z"; $pern = "$per/keyn.php"; $perv = "$per/keyv.php"; if(file_exists($pern)){ $keyper[$z.'n'] = file($pern); $keyper[$z.'v'] = file($perv); } else $ok = false; } else $keyval = self::adesso_aggiorna($keyval,$k,$kv); $k = $kv; } else $ok = false; }}}}} if(is_array($keyval)) return $keyval; else return $k; }
    protected static function ora($o, $t, $ora) { $v = array(0,0,0,23,59,59); $val = false; if(!strpos($o[0], '-')) { if(count($t) == 1) $t = explode('-', date('d-m-Y', $ora)); if(isset($o[0])) { $v[0] = $o[0]; $v[3] = $v[0]; } if(isset($o[1])) { $v[1] = $o[1]; $v[4] = $v[1]; } if(isset($o[2])) { $v[2] = $o[2]; $v[5] = $v[2]; }} if(isset($t[0]) && isset($t[1]) && isset($t[2])) { if(strlen($t[0]) > 0 && strlen($t[1]) > 0 && strlen($t[2]) == 4) { $val[0] = mktime($v[0], $v[1], $v[2], $t[1], $t[0], $t[2]); $val[1] = mktime($v[3], $v[4], $v[5], $t[1], $t[0], $t[2]); $val[2] = $t[0].$t[1].$t[2]; } elseif(strlen($t[0]) == 4 && strlen($t[1]) > 0 && strlen($t[2]) > 0) { $val[0] = mktime($v[0], $v[1], $v[2], $t[1], $t[2], $t[0]); $val[1] = mktime($v[3], $v[4], $v[5], $t[1], $t[2], $t[0]); $val[2] = $t[2].$t[1].$t[0]; } return $val; } return false; }
    protected static function solokey($key) { if(strpos($key, '{') > 1) $key = substr($key, 0, strpos($key, '{')); if(strpos($key, '[') > 1) $key = substr($key, 0, strpos($key, '[')); if(strpos($key, '(') > 1) $key = substr($key, 0, strpos($key, '(')); return $key; }
    protected static function operatori($val, $x=NULL){ if($x === NULL) { if($val[1][0] == '!') { $val[1] = substr($val[1],1); $val[20] = $val[1]; } if($val[1][strlen($val[1])-1] == '!') { $val[1] = substr($val[1], 0, -1); $val[18] = true; } $val = self::operatori_segno($val); } else { if($val[1][$x][0] == '!') { $val[1][$x] = substr($val[1][$x],1); $val[20] = $val[1][$x]; } if($val[1][$x][strlen($val[1][$x])-1] == '!') { $val[1][$x] = substr($val[1][$x], 0, -1); $val[18] = true; } $val = self::operatori_segno($val,$x); } if(!$val[16]) $val[18] = false; return $val; }
    protected static function operatori_segno($val, $x=NULL){ if($x === NULL) { if($val[1][strlen($val[1])-1] == '+') { $val[1] = substr($val[1], 0, -1); $val[16] = $val[1]; $val[17] = 1; } elseif($val[1][strlen($val[1])-1] == '-') { $val[1] = substr($val[1], 0, -1); $val[16] = $val[1]; $val[17] = 2; }} else { if($val[1][$x][strlen($val[1][$x])-1] == '+') { $val[1][$x] = substr($val[1][$x], 0, -1); $val[16] = $val[1][$x]; $val[17] = 1; } elseif($val[1][$x][strlen($val[1][$x])-1] == '-') { $val[1][$x] = substr($val[1][$x], 0, -1); $val[16] = $val[1][$x]; $val[17] = 2; }} return $val; }
    protected static function analisi($key) { global $Qposmax; $Qmax = $Qposmax + 2; $ora = SYS::time(); if(strpos($key, ',') > 1) $key = SYS::u(explode(',',$key),true); $a = strpos($key, '{'); $val = array(false,false,-1); for($e=3; $e<19; $e++) $val[$e] = false; $ok = false; $z = 0;
        if($a > 1) { $b = strpos($key, '}'); $z = $b;
            if($b > $a) { $val[9] = trim(substr($key, $a+1, $b-$a-1));
                if(strpos($key, ',') > 1) { $v = SYS::u(explode(',',$key)); $tmp = $val[9]; $val[13] = array();
                    foreach($v as $c) {
                        
                        if($c[0] == '_' || $c[1] == '_') SYS::$dataval = true;
                        
                        if(strpos($c,$tmp) === false) { 
                            if(!strstr($c,'!#') && !strstr($c,'!@')) $val[13][] = $c; 
                        } else { 
                            if($c[0] != '!') $val[1] = substr($c, 0, strpos($c, '{')); 
                            else { 
                                if($c[1] != '#' && $c[1] != '@') { 
                                    $val[1] = substr($c,1,strpos($c, '{')-1); $ok = true; 
                                } else return SYS::error(2, 30, $c);
                            } $tmp = false; 
                        }
                    }
                } else {
                    
                    if($key[0] == '_' || $key[1] == '_') SYS::$dataval = true;
                    
                    if($key[0] != '!') $val[1] = substr($key, 0, $a); 
                    else { 
                        if($key[1] != '#' && $key[1] != '@') { 
                            $val[1] = substr($key, 1, $a-1); $ok = true; 
                        } else return SYS::error(2, 30, $key);
                    }
                } 
                
                $c = explode(':', $val[9]);
                
                if(count($c) == 1) { 
                    if($val[9][0] == '>') { 
                        $val[15] = 1; 
                        $v = substr($val[9],1);
                        if(SYS::$dataval) $v = SYS::dataval($v);
                        if(is_numeric($v)) $val[10] = $v;
                    } 
                    elseif($val[9][0] == '<') { 
                        $val[15] = 2; 
                        $v = substr($val[9],1);
                        if(SYS::$dataval) $v = SYS::dataval($v);
                        if(is_numeric($v)) { 
                            $val[10] = $v; 
                            $val[12] = 1; 
                        }
                    } else {
                        if(SYS::$dataval) $val[9] = SYS::dataval($val[9]);
                        if(is_numeric($val[9])) { 
                            $val[10] = $val[9]; 
                            $val[11] = $val[9]; 
                        }
                    }
                } 
                elseif(count($c) == 2) {
                    if(SYS::$dataval) { $c[0] = SYS::dataval($c[0]); $c[1] = SYS::dataval($c[1]); }
                    if(is_numeric($c[0])) $val[10] = $c[0];
                    if(is_numeric($c[1])) $val[11] = $c[1];
                    if($val[11] < $val[10]) { 
                        $b = $val[11]; 
                        $val[11] = $val[10]; 
                        $val[10] = $b; 
                        $val[12] = 1; 
                    }
                } else return false; SYS::$dataval = false; $val = self::operatori($val);
            }
        } $a = strpos($key, '['); // $val[3] = Tempo PARTENZA    $val[4] = Tempo ARRIVO     $val[5] = STATO ---> true = MAX:min | false = min:MAX
        if($a > 1) { if(!$z || ($a-$z) == 1) { $b = strpos($key, ']'); 
            if($b > $a) { if(!$val[10]) $val[1] = substr($key, 0, $a); $val[8] = trim(substr($key, $a+1, $b-$a-1)); $d = explode(':', $val[8]);
                if(count($d) == 1) { if(strpos($val[8],'=')) { $c = substr($key,$a+1,$b-$a-1); $key = str_replace($c,"$c:$c",$key); return self::analisi($key); } else { if(strpos($val[8],'-')) { $t = explode('-', $val[8]); $o = explode('.', $val[8]); $v = self::ora($o, $t, $ora); $val[3] = $v[0]; $val[4] = $v[1]; $val[5] = true; } else { $o = explode('.', $val[8]); $val[5] = true; $val[4] = $ora; if(isset($o[2])) $val[3] = $ora - $o[0]*3600 + $o[1]*60 + $o[2]; elseif(isset($o[1])) $val[3] = $ora - $o[0]*60 + $o[1]; elseif(isset($o[0])) $val[3] = $ora - $o[0]; }}}
                elseif(count($d) == 2) { $e1 = explode('=', $d[0]); $e2 = explode('=', $d[1]); if(count($e1) == 1 && count($e2) == 1) { $t = explode('-', $d[0]); $o = explode('.', $d[0]); $v1 = self::ora($o, $t, $ora); $val[3] = $v1[0]; $t1 = $v1[2]; $t = explode('-', $d[1]); $o = explode('.', $d[1]); $v2 = self::ora($o, $t, $ora); $val[4] = $v2[1]; $t2 = $v1[2]; if($val[4] < $val[3]) { $val[5] = true; $val[3] = $v2[0]; $val[4] = $v1[1]; }} elseif(count($e1) == 2 && count($e2) == 2) { if(strpos($e1[0], '-')) { $t = explode('-', $e1[0]); $o = explode('.', $e1[1]); $v1 = self::ora($o, $t, $ora); $val[3] = $v1[0]; } if(strpos($e1[1], '-')) { $t = explode('-', $e1[1]); $o = explode('.', $e1[0]); $v1 = self::ora($o, $t, $ora); $val[3] = $v1[0]; } if(strpos($e2[0], '-')) { $t = explode('-', $e2[0]); $o = explode('.', $e2[1]); $v2 = self::ora($o, $t, $ora); $val[4] = $v2[1]; } if(strpos($e2[1], '-')) { $t = explode('-', $e2[1]); $o = explode('.', $e2[0]); $v2 = self::ora($o, $t, $ora); $val[4] = $v2[1]; } if($val[4] < $val[3]) { $val[5] = true; $val[3] = $v2[0]; $val[4] = $v1[1]; }}} else return false; if(!$val[3] || !$val[4]) { $val[3] = false; $val[4] = false; } $key = $val[1].substr($key,$b+1); $z = 0; }
            }
        } $a = strpos($key, '('); // $val[2] = Posizione PARTENZA    $val[0] = Posizione ARRIVO     $val[6] = STATO ---> true = MAX:min | false = min:MAX
        if($a > 1) { if(!$z || ($a-$z) == 1) { $b = strpos($key, ')'); if($b > $a) { if(!$val[10]) $val[1] = substr($key, 0, $a); $val[7] = trim(substr($key, $a+1, $b-$a-1)); $d = explode(':', $val[7]); if(count($d) == 1) { $val[0] = abs($val[7]) + 2; if($val[0] == 2 || $val[0] > $Qmax) $val[0] = $Qmax; } elseif(count($d) == 2) { $val[2] = abs($d[0]); $val[0] = abs($d[1]) + 2; if($d[0] > $d[1]) $val[6] = true; if(($val[0] - $val[2]) > $Qmax) $val[0] = $val[2] + $Qmax; } else return false; }}} if($ok) $val[14] = $val[1]; if(!$val[1]) $val[1] = $key;

        
        if(!$val[10]) {
            if(strpos($key, ',') > 1) { $v = SYS::u(explode(',',$key)); $val[1] = array(); $x = -1; 
                foreach($v as $a) if($a) { $x++;
                    if($a[0] != '!') { $val[1][$x] = $a; 
                        $val = self::operatori_segno($val,$x);
                    } else { 
                        if($a[1] != '#' && $a[1] != '@') {
                            $val[1][$x] = substr($a,1);
                            $val = self::operatori($val,$x);
                            $val[14] = $val[1][$x]; break; 
                        } else return SYS::error(2, 30, $a);
                    }
                }
            } else { 
                if($key[0] != '!') {
                    if(!$val[1]) $val[1] = $key; 
                    $val = self::operatori_segno($val);
                } else { 
                    if($val[1] != '#' && $val[1] != '@') { 
                        $val[1] = substr($val[1],1); 
                        $val = self::operatori($val);
                        $val[14] = $val[1]; 
                    } else return SYS::error(2, 30, $val);
                }
            }
        } if($val[14]) $val[14] = self::solokey($val[14]); return $val; 
    }
    protected static function Qdbout($keys=NULL, $valass=NULL, $opz=NULL, $type=0, $all=NULL){ global $Qdatabase; global $Qpostime; global $Qlivtime; $ora = SYS::time();
        if(is_array($opz) || is_array($valass)) { if(is_array($opz)) { if($keys[0] == '*') { $keys = strtolower(substr($keys,1)); if(file_exists("class/Qai/$keys.php")) { require_once "Qai/$keys.php"; return Qai::query($valass, $opz); } return false; } $tmp = $valass; $valass = $opz; $opz = $tmp; } require_once 'Qsx.php'; return Qsx::search($keys, $valass, $opz, $type, $all, $ora); } else $valass = SYS::speciali($valass,1); $keyval['K'][] = 0; global $keybase; global $Qposdef;
        if(strpos($keys, ' ') > 1) { $ky = explode(' ', $keys, 2); if(!isset($ky[1][1])) return false; if($ky[1][0] == ',') { if(strpos($ky[0], '#')) { $k = explode('#',$ky[0]); return self::Qdbout($k[0].' #'.$k[1].$ky[1]); } elseif(strpos($ky[0], '@')) { $k = explode('@',$ky[0]); return self::Qdbout($k[0].' @'.$k[1].$ky[1]); }} if(strpos($ky[1], ',') !== false) { if($ky[0][0] == '!') return self::Qdbout($ky[0]); } $pk = substr($ky[0],-1); if($pk == '!') { $ky[0] = substr($ky[0],0,-1); $key = '!'.$ky[1]; } else $key = $ky[1]; if($ky[0][0] != '!') $keyass = $ky[0]; else $keyass = substr($ky[0],1);
            if($valass == NULL && $opz == NULL && $type == 0) { $numkeyass = self::analisi($keyass); if($numkeyass[0] == '' && $numkeyass[3] == '') $keyass .= "($Qposdef)"; else { if($keyass[0] == '#' || $keyass[0] == '@') return self::Qdbout("$keyass $key", 0, 0); else { if(strpos($numkeyass[1], '#') > 1) { $ky = explode('#', $numkeyass[1], 2); if($numkeyass[17] == 1) $ky[0] .= '+'; elseif($numkeyass[17] == 2) $ky[0] .= '-'; if($numkeyass[3]) $ky[0] .= '['.$numkeyass[8].']'; if($numkeyass[0]) $ky[0] .= '('.$numkeyass[7].')'; return self::Qdbout($ky[0].'#'.$ky[1].' '.$key); }}}}
            if($keyass[0] == '#' || $keyass[0] == '@') { $ky = explode(' ', $keys, 2); if($ky[0][0] == '@' && $valass > 0) return self::Qdbout($ky[0],$valass,$opz,$type,explode(',',$ky[1]));
                if($valass < 1) { $numkey = self::analisi($ky[1]); if(is_array($numkey[1])) return false; $key = SYS::combina($numkey[1],1); $numkeyass = self::analisi($ky[0]); $keyass = $numkeyass[1];
                    if($key) { $keyper = SYS::combina($keyass, 2);
                        if($keyass) { if($keyass[0] == '#') $keypers = "$keyper/keyp.php"; else $keypers = "$keyper/keyc.php";
                            if(file_exists($keypers)){ $fp = file($keypers); $key = rtrim($key); if($keyass[0] == '#') $p = '.0'; else $p = '.1'; $keyper .= '/'.$key.$p; if($valass == -1 || $valass == -2) $o = 2; else $o = 1; $a = array_search($key."\n",$fp); 
                                if($a > 1) { $fp = array(); if($keyass[0] == '#') { $fx = SYS::leggi($keyper ,0 ,$numkeyass ,$o); for($x=2; $x<count($fx); $x++) { $n = $x-2; if($valass) { $f = explode('.', rtrim($fx[$x])); $fp[$n] = $f[0]."\n"; if($valass == -1) $keyval['t.'.$n] = $f[1]; elseif($valass == -2) $keyval['t.'.$n] = $ora - $f[1]; } else $fp[$n] = $fx[$x]; }
                                    } else { $fx = SYS::leggi($keyper ,0 ,$numkeyass ,1 ,$o); for($x=2; $x<count($fx); $x++) { $f = explode('.', $fx[$x]); $i = count($f)-1; $n = $x-2; if($f[0][0] == '-') { $fp[$n] = substr($f[0], 12); $tempo = substr($f[0], 2, 10); $keyval['-.'.$n] = base64_encode($fp[$n]); } else { $fp[$n] = $f[0]; $keyval['-.'.$n] = 0; $tempo = substr($f[$i], 0, 10); } 
                                        $keyval["p.$n"] = $f[1]; for($h=2; $h<$i; $h++) $keyval["p.$n"] .= '.'.$f[$h]; if($valass == -1) $keyval["t.$n"] = $tempo; elseif($valass == -2) $keyval["t.$n"] = $ora - $tempo; }
                                    } if($fp) { $vl = SYS::val($fp); foreach($vl as $val) $keyval[] = $val; unset($keyval['K']); return self::flusso($numkey,$keyval,$fx[0],$fx[1],1,$numkeyass); }
                                }
                            }
                        }
                    }
                } return false;
            } if(strpos($keyass, '#') > 1) return self::outmix($keybase,$key,$keyass,$valass,$opz,$ora,1);
            if(strpos($keyass, '@') > 0) { require_once 'Qcl.php'; return Qcl::key($key,$keyass,$valass,$opz,$ora); } 
            if($keys[0] == '$') { require_once 'Qdk.php'; return Qdk::key($key,$keyass,$valass,$opz,$type,$ora); }
            if($keys[0] == '-') { $keyass = substr($keyass,1); if($opz > 0) { if($keyass[0] == '$') $per = SYS::combina(substr($keyass,1),2).'/-0/'; else $per = SYS::combina($keyass,2).'/-0/'; $keyperindex = $per.'index.php'; if(file_exists($keyperindex)) { $fk = file($keyperindex); for($a=2; $a<count($fk); $a++) { $n = explode('.', $fk[$a]); if(count($n) > 2) { if($opz >= $n[0] && $opz <= $n[1]) { $pert = $per.$a.'.php'; break; }} elseif(count($n) == 2) $pert = $per.$a.'.php'; }} else return false; if(file_exists($pert)) { $fp = file($pert); $j = array_search($opz."\n",$fp); if($j > 1) { $fp = file($per.'v2.php'); $id = $opz.rtrim($fp[$j]); $per .= substr($id,0,4).'/'.substr($id,4,4).'/'.substr($id,8,4).'/'.substr($id,12); return self::Qdbout($keyass.' '.$key, $valass, $type, $per); }}}}
        } else { $key = $keys; $keyass = 0;
            if($key[0] == '#' || $key[0] == '@') { if($valass != NULL && $key[0] == '@') return self::Qdbout($valass.$key,$opz,null,0,$all); $key = substr($key, 1); $keyper = SYS::combina($key, 2); if(!$keyper) return false; if($keys[0] == '#') $keyper .= '/keyp.php'; else $keyper .= '/keyc.php'; $cfp = 0; if(file_exists($keyper)){ $file = file($keyper); for($a=2; $a<count($file); $a++) { $k = explode('.', rtrim($file[$a])); if($k[count($k)-1] != '@') { $keyval[$a-2] = rtrim($keybase[$k[0]]); for($b=1; $b<count($k); $b++) $keyval[$a-2] .= '.'.rtrim($keybase[$k[$b]]);  $cfp++; }} if($cfp) { $keyval['N'] = $cfp; $keyval['T'] = $cfp; unset($keyval['K']); return $keyval; }} return false; }
            if($key[0] == '$') { if(strpos($key,'@') > 1) return false; elseif(strpos($key,'#') > 1) return self::Qdbout(str_replace('#',' #',$key),$valass,$opz); else { $key = substr($key, 1); $per = SYS::combina($key); if($per) { $hashpos = SYS::hashpos(Qhash($valass), $per).'/index.php'; if(file_exists($hashpos)){ $fp = file($hashpos); $cfp = count($fp); for($a=2; $a<$cfp; $a++) { $b = $a - 2; $keyval[$b] = SYS::val($fp[$a]); if($qt=self::tempo($opz,$fp[$a],$ora)) $keyval["t.$b"] = $qt; } $cfp -= 2; if($cfp) {$keyval['N'] = $cfp; $keyval['T'] = $cfp; unset($keyval['K']); return $keyval; }}} return false; }}
            if($key[0] == '-') { require_once 'Qdk.php'; return Qdk::mix($key,$valass,$opz,$type,$ora); } $ccc = strpos($keys, '@'); $ccl = strpos($keys, '#');
            if($ccc > 0) { require_once 'Qcl.php'; return Qcl::mix($keys,$valass,$opz,$type,$all,$ora,$ccl); }
            if($ccl > 1) { $ky = explode('#', $keys, 2); $key = $ky[1]; $keyass = $ky[0]; if($j = self::parentesi($key,$keyass,$valass,$opz,$type,'#')) return $j; $numkeyass = self::analisi($keyass);
            //---------------------------------------------------------------------------------------------->>>>>>> INIZIO Query  --->  self::Qdbout('user.email(20)#foto',2)
            if($numkeyass[0] != '' || $numkeyass[3] != '') {
                if($valass == NULL || $valass == -1 || $valass == -2) return self::Qdbout($keyass.' #'.$key, $valass, $opz, $type);
            } else { $numkey = self::analisi($key); if($valass == NULL && $opz == NULL) { if($numkey[0] != '' || $numkey[3] != '') { if($numkey[3]) $keyass .= '['.$numkey[8].']'; if($numkey[0]) $keyass .= '('.$numkey[7].')'; } return self::Qdbout($keyass.' #'.$key); } if($opz != -1 && $opz != -2) { if($valass == -1 || $valass == -2) { if($numkey[0] != '' || $numkey[3] != '') { if($numkey[3]) $keyass .= '['.$numkey[8].']'; if($numkey[0]) $keyass .= '('.$numkey[7].')'; return self::Qdbout($keyass.' #'.$numkey[1],$valass); }}} $pk = substr($keyass,-1);
                if($pk == '!') { $keyass = substr($keyass,0,-1); $key = '!'.$key; } $key = $numkey[1]; $per = SYS::combina($key); $per[] = 0; $id = SYS::keyvalass($keyass, $valass, $per, 0, $type); if($opz) $m = 2; else $m = 1; $fx = SYS::leggi($Qdatabase.'/'.$id ,0 ,$numkey, $m); $kat = array(); $tat = array(); $nick = false; for($b=2; $b<$fx[1]+2; $b++) { $c = $b - 2; if($opz) { $m = explode('.', rtrim($fx[$b])); if($m[0][0] == '#') { $kat[$c] = substr($m[0],1)."\n"; $tat[$c] = $m[1]; $nick = true; } else { $keyval[$c] = $m[0]; $nick = false; if($opz == -1) $keyval['t.'.$c] = $m[1]; elseif($opz == -2) $keyval['t.'.$c] = $ora - $m[1]; }} else { if($fx[$b][0] == '#') { $kat[$c] = substr($fx[$b],1); $tat[$c] = false; $nick = true; } else { $keyval[$c] = rtrim($fx[$b]); $nick = false; }}} if($nick) $keyval = self::time12($kat,$opz,$ora,$tat); if($fx[1]) { if(isset($keyval['K'])) { $numkey[18] = $keyval['K']; unset($keyval['K']); } return self::flusso($numkey,$keyval,$fx[0],$fx[1],1); }
            } return false; } //---------------------------------------------------------------------------->>>>>>>>> FINE Query
        } $numkeyass = self::analisi($keyass); $numkey = self::analisi($key,1); $keytmp = false; $per = false; $lnk = false; $cln = false;
        if(is_array($numkey[1])) { if($numkeyass[0] == false && $numkeyass[3] == false && $valass != NULL) return self::Qdbout($keyass, $valass, $opz, explode(',',$key), $type); else { if(!$numkey[14]) { if($valass == NULL) { $numkeyass[0] = $Qposdef + 2; $valass = 0; }} else { if($numkeyass[0] == false && $numkeyass[3] == false) $numkeyass[0] = $Qposdef + 2; else $valass = NULL; } $per = SYS::combina($numkeyass[1]); }} else { if($numkeyass[0] != '' || $numkeyass[3] != '') { if($key[0] == '!') { if($valass == NULL) $valass = 0; $opz = NULL; } $per = SYS::combina($numkey[1]); } else { if($valass == NULL && $opz == NULL && $type == 0) { if($numkeyass[1] == '0') $valass = 0; elseif($numkeyass[0] == false && $numkeyass[2] == -1) { $numkeyass[0] = $Qposdef + 2; $valass = 0; } else $keyass .= "($Qposdef)"; } if($numkey[1][0] == '#' || $numkey[1][0] == '@') return self::Qdbout($keyass.$key,$valass,$opz,$type); $key = $numkey[1]; $per = SYS::combina($key); }}
        if($per) { $keyper = $Qdatabase; $keyval = false; if($keyass) return self::outmix($keybase, $key, $keyass, $valass, $opz, $ora, 0, $all); else { if($valass < 1) { if(!$type) { if($numkey[0] != false || $numkey[3] != false) return self::Qdbout($keys, NULL, $valass, 1); }} if(!is_array($per)) return false; foreach($per as $a) $keyper .= '/'.$a; $numkeyok = false; if($valass == NULL) { $fp = SYS::leggi($keyper,0,$numkey); $keyper = $Qdatabase.$Qpostime; if($fp) { if(!$fp[0]) return false; else $numtot = $fp[0]; } else return false; } else { if($all) $hashpos = $all; else $hashpos = SYS::hashpos(Qhash($valass), $per); if($opz == -3) { $keyperindex = $hashpos.'/index.php'; if(file_exists($keyperindex)) { $fp = file($keyperindex); return substr($fp[2],0,10); } else return false; } $keyperindex = $hashpos.'/link.php'; $numtot = SYS::tot($keyper); if(file_exists($keyperindex)) { $fp = file($keyperindex); $fk = file($hashpos.'/keys.php'); } else return false; }
            if(is_array($type)) { $type = array_values(array_unique($type)); $y = 0; $fpt = array(0,0); $fkt = array(0,0); $numkeyok = array(); foreach($type as $tp) { $numkeyok[$y] = self::analisi($tp); if($numkeyok[$y][1][0] == '#') { $fine = ".0\n"; $tp = substr($numkeyok[$y][1], 1); } elseif($numkeyok[$y][1][0] == '@') { $fine = ".1\n"; $tp = substr($numkeyok[$y][1], 1); } elseif($numkeyok[$y][1][0] == '_') { $fine = "\n"; $tp = substr($numkeyok[$y][1], 1); } else $fine = "\n"; $fe = explode('.',$tp); $keymsg = ''; $x = 0; foreach($fe as $f) { $j = array_search($f."\n",$keybase); if($j > 1) { $keymsg .= $j.'.'; $x++; }} if(count($fe) == $x) { $keymsg = substr($keymsg,0,-1); $keymsg .= $fine; $j = array_search($keymsg,$fk); if($j > 1) { $fkt[] = $fk[$j]; $fpt[] = $fp[$j]; }} $y++; } $fp = $fpt; $fk = $fkt; } $cfp = count($fp); $keytmp = false; $nick = false;
            for($a=2; $a<$cfp; $a++) { $nick = false; if(strlen($fp[$a]) < 64) { $keytmp[$a-2] = $fp[$a]; // *************************** Hyper Velocità
                } else { $keytmp[$a-2] = false; $ff = explode('/', $fp[$a]); if($ff[0]) { // ******************************************* è stato clonato
                    if($opz == -1 || $opz == -2) $o=2; else $o=1; if(!$numkeyok) $u = $numkey; else $u = $numkeyok[$a-2]; $dati = SYS::leggi($Qdatabase.'/'.rtrim($fp[$a]),0,$u,$o); $keymsg = SYS::kb($fk[$a], '@', 1); $dat = array(); for($b=2; $b<$dati[1]+2; $b++) { $c = $b - 2; $dat[$c] = rtrim($dati[$b]); if($opz) { $f = explode('.',$dat[$c]); $dat[$c] = $f[0]; for($d=1; $d<count($f)-1; $d++) $dat[$c] .= '.'.$f[$d]; if($qt=self::tempo($opz,$f[count($f)-1],$ora)) $dat["t.$c"] = $qt; }}
                } else { // ************************************************************************************************************ è stato linkato
                    if($opz) $m = 2; else $m = 1; if(!$numkeyok) $u = $numkey; else $u = $numkeyok[$a-2]; $dati = SYS::leggi($Qdatabase.'/'.rtrim($fp[$a]),0,$u,$m); $dat = array(); $kat = array(); $tat = array(); $keymsg = SYS::kb($fk[$a], '#', 1); for($b=2; $b<$dati[1]+2; $b++) { $c = $b - 2; if($opz) { $m = explode('.', rtrim($dati[$b])); if($m[0][0] == '#') { $kat[$c] = substr($m[0],1)."\n"; $tat[$c] = $m[1]; $nick = true; } else { $dat[$c] = $m[0]; $nick = false; if($opz == -1) $dat['t.'.$c] = $m[1]; elseif($opz == -2) $dat['t.'.$c] = $ora - $m[1]; }} else { if($dati[$b][0] == '#') { $kat[$c] = substr($dati[$b],1); $tat[$c] = false; $nick = true; } else { $dat[$c] = rtrim($dati[$b]); $nick = false; }}}} if($nick) $dat = self::time12($kat,$opz,$ora,$tat); if($dati[1]) { $keyval['K'][$a-2] = $keymsg; $keyval[$keymsg] = $dat; $keyval['N.'.$keymsg] = $dati[1]; $keyval['T.'.$keymsg] = $dati[0]; }}}
            if($keytmp) { $a = 1; $vl = SYS::val($keytmp); foreach($vl as $val) { $a++; if($val !== false) { if($valass == NULL) { $v = $a - 2; $keyval[$v] = $val; if($qt=self::tempo($opz,$fp[$a],$ora)) $keyval["t.$v"] = $qt; } else { $keymsg = SYS::kb($fk[$a], '', 0, 'Qout'); if($fp[$a][strlen($fp[$a])-2] == '_') $keymsg = '_'.$keymsg; $keyval['K'][$a-2] = $keymsg; $keyval[$keymsg] = $val; if($qt=self::tempo($opz,$fp[$a],$ora)) $keyval["t.$keymsg"] = $qt; }}} if(isset($keyval['K'])) $keyval['K'] = SYS::Qsort($keyval['K']); } $cfp -= 2; if($cfp) { $keyval['N'] = $cfp; $keyval['T'] = $numtot; return $keyval; }}
        } return false;
    }
    protected static function flusso($numkey,$keyval,$tot,$n,$opz=0,$numkeyass=0) { $ok = true; $si = false; if(!isset($numkey[13])) $numkey[13] = NULL; if(!isset($numkey[14])) $numkey[14] = NULL; if(!isset($numkey[17])) $numkey[17] = NULL; $tmp = true;
        if(is_array($numkeyass)) { if($numkeyass[14] || $numkeyass[17]) { if(!$opz) { $ok = false; $numkey[18][] = $numkeyass[1]; for($a=0; $a<18; $a++) $numkey[$a] = $numkeyass[$a]; for($a=0; $a<$n; $a++) $keyval[$numkey[1]][$a] = $keyval[$a]; if(isset($keyval['t.0'])) { for($a=0; $a<$n; $a++) $keyval['t.'.$numkey[1]][$a] = $keyval[$a]; }} else $numkey = $numkeyass; } else { if($numkey[9]) { if(!$numkey[18] || is_array($numkey[18])) $ok = false; if($numkey[17]) $ok = true; }}} if($numkey[14] == '' && $numkey[16] == '') { if(is_array($numkey[18])) { $t = $numkey[18]; foreach($t as $x) { if($x[0] == '!') { $x = substr($x,1); $ok = false; if($x[strlen($x)-1] == '!') { $x = substr($x,0,-1); $numkey[18] = true; $ok = true; } else $numkey[18] = false; $numkey[14] = $x; $numkey[1] = $x; } if(strpos($x,'+') > 1) { $numkey[16] = substr($x,0,strpos($x,'+')); $numkey[17] = 1; $numkey[1] = $numkey[16]; $ok = true; $si = true; break; } elseif(strpos($x,'-') > 1) { $numkey[16] = substr($x,0,strpos($x,'-')); $numkey[17] = 2; $numkey[1] = $numkey[16]; $ok = true; $si = true; break; }}}}
        if($numkey[14]) { $tmp = false; if($opz == 1) { if($numkey[1][0] == '@') { for($a=0; $a<$n; $a++) $keyval[$numkey[1]][$a] = $keyval['p.'.$a]; } else { for($a=0; $a<$n; $a++) $keyval[$numkey[1]][$a] = $keyval[$a]; }} elseif($opz == 2) { if($numkey[1][0] == '#' || $numkey[1][0] == '@') { for($a=0; $a<$n; $a++) $keyval[$numkey[1]][$a] = $keyval[$a]; }} else { if($numkey[1][0] == '#' || $numkey[1][0] == '@') { for($a=0; $a<$n; $a++) { if(isset($keyval['N.'.$numkey[1].'.'.$a])) { for($b=0; $b<$keyval['N.'.$numkey[1].'.'.$a]; $b++) $keyval[$numkey[1]][] = $keyval[$numkey[1].'.'.$a][$b]; }}}} $kk['K'][0] = $numkey[1]; if(!isset($keyval[$numkey[1]])) return false;
            if(isset($numkey[20])) { $x = array(); foreach($keyval[$numkey[1]] as $a) { $a = SYS::trak($a,true); if(is_array($a)) $x = array_merge($x,$a); else $x[] = $a; } $keyval[$numkey[1]] = $x; } for($a=0; $a<count($keyval[$numkey[1]]); $a++) if($keyval[$numkey[1]][$a] === false || $keyval[$numkey[1]][$a] === NULL) $keyval[$numkey[1]][$a] = ''; $k = array_count_values($keyval[$numkey[1]]); $av = array_keys($k); $an = array_values($k); $n = 0; for($a=0; $a<count($av); $a++) { $kk[$numkey[1]][$a] = $av[$a]; $kk['N.'.$numkey[1]][$a] = $an[$a]; $n += $an[$a]; } if($numkey[17]) { if($numkey[18] && $ok) { if($numkey[17] == 1) array_multisort($kk['N.'.$numkey[1]],SORT_DESC,SORT_NUMERIC,$kk[$numkey[1]]); elseif($numkey[17] == 2) array_multisort($kk['N.'.$numkey[1]],SORT_ASC,SORT_NUMERIC,$kk[$numkey[1]]); } else { if($numkey[17] == 1) array_multisort($kk[$numkey[1]],SORT_ASC,SORT_FLAG_CASE,$kk['N.'.$numkey[1]]); elseif($numkey[17] == 2) array_multisort($kk[$numkey[1]],SORT_DESC,SORT_FLAG_CASE,$kk['N.'.$numkey[1]]); }} $kk['T.'.$numkey[1]] = $n; $kk['N'] = count($av); $kk['T'] = $tot; if($kk['T'] > 0) return $kk;
        } else { if($numkey[17] == '' && is_array($numkey[13])) { foreach($numkey[13] as $a) { $b = $a[strlen($a)-1]; if($b == '+') { $numkey[17] = 1; $numkey[16] = substr($a,0,-1); $j = array_search($a,$numkey[18]); if($j !== false) $numkey[18][$j] = $numkey[16]; break; } elseif($b == '-') { $numkey[17] = 2; $numkey[16] = substr($a,0,-1); $j = array_search($a,$numkey[18]); if($j !== false) $numkey[18][$j] = $numkey[16]; break; }} if(!isset($keyval[$numkey[16]])) return SYS::error(2, 30, $a); } if($numkey[17]) { $tmp = false; $t = false; $x = -1; if($opz) { for($a=0; $a<$n; $a++) $keyval[$numkey[1]][$a] = $keyval[$a]; if(isset($keyval['-.0'])) $numkey[18] = array('-','p'); else $numkey[18] = array(); } else { if(is_array($numkey[18])) { $b = $numkey[16]; if($si) { if($numkey[17] == 1) $b .= '+'; else $b .= '-'; } $j = array_search($b,$numkey[18]); if($j !== false) unset($numkey[18][$j]); $numkey[18] = SYS::Qsort($numkey[18]); }} if(isset($keyval['t.0']) || $numkey[0] == '@2') { $t = true; if($opz) $numkey[18][] = 't'; } for($a=0; $a<$n; $a++) $keyval['Q'][$a] = $a;
            if($t && !$opz) { if($numkey[17] == 1) array_multisort($keyval[$numkey[16]],SORT_ASC,SORT_FLAG_CASE,$keyval['Q'],$keyval['t.'.$numkey[16]]); elseif($numkey[17] == 2) array_multisort($keyval[$numkey[16]],SORT_DESC,SORT_FLAG_CASE,$keyval['Q'],$keyval['t.'.$numkey[16]]); } else { if($numkey[17] == 1) array_multisort($keyval[$numkey[16]],SORT_ASC,SORT_FLAG_CASE,$keyval['Q']); elseif($numkey[17] == 2) array_multisort($keyval[$numkey[16]],SORT_DESC,SORT_FLAG_CASE,$keyval['Q']); } if($numkey[0] != '@1' && $numkey[0] != '@2') { foreach($keyval['Q'] as $a) { $x++; $kk[$x] = $keyval[$a]; if($t && !$opz) $kk["t.$x"] = $keyval["t.$a"]; }} if($opz) { foreach($numkey[18] as $k) { $x = -1; foreach($keyval['Q'] as $a) { $x++; $kk["$k.$x"] = $keyval["$k.$a"]; }}} else { if(isset($keyval['K'])) $kk['K'] = SYS::u($keyval['K']); if($ok) { $kk[$numkey[16]] = $keyval[$numkey[16]]; if($t) $kk['t.'.$numkey[16]] = $keyval['t.'.$numkey[16]]; $kk['N.'.$numkey[16]] = $keyval['N.'.$numkey[16]]; } 
            if(isset($kk['K'])) { foreach($kk['K'] as $k) { $x = -1; foreach($keyval['Q'] as $a) { $x++; if($k[0] == '#' || $k[0] == '@') { if(isset($keyval["$k.$a"])) { $kk["$k.$x"] = $keyval["$k.$a"]; if($t) $kk["$k.t.$x"] = $keyval["$k.t.$a"]; $kk["N.$k.$x"] = $keyval["N.$k.$a"]; $kk["T.$k.$x"] = $keyval["T.$k.$a"]; }} else { if($numkey[16] != $k) { $kk[$k][$x] = $keyval[$k][$a]; if($t) $kk["t.$k"][$x] = $keyval["t.$k"][$a]; }}} if(isset($keyval["N.$k"])) $kk["N.$k"] = $keyval["N.$k"]; else $kk["N.$k"] = 0; }}} $kk['N'] = $n; $kk['T'] = $tot; if($kk['T'] > 0) return $kk; } $keyval['N'] = $n; $keyval['T'] = $tot; if($keyval['T'] > 0) return $keyval;
        } return false;
    }
    protected static function outmix($keybase, $key, $keyass, $valass=NULL, $opz=NULL, $ora, $type, $at=NULL, $ac=NULL, $tot=0, $fpt=NULL, $ccc=NULL) { $num = false; $ky = false; $valok = false; $percorso = ''; if($type) { if(strpos($keyass, '#') > 0) { $ky = explode('#', $keyass, 2); $valok = $ky[0]; $numkey = self::analisi($ky[1]); if($numkey[9] || is_array($numkey[1])) return self::Qdbout($ky[0].' #'.$ky[1].$key,$valass,$opz); } else { $ccc = true; $ky = explode('@', $keyass, 2); $valok = $ky[0]; $numkey = self::analisi($ky[1]); if($numkey[9] || is_array($numkey[1])) return self::Qdbout($ky[0].' @'.$ky[1].$key,$valass,$opz); } if($key) { $numkeyass = self::analisi($key); if(!$numkeyass[9] && !is_array($numkeyass[1])) $numkeyass[1] = array($numkeyass[1]); } else { $numkeyass[1] = false; $numkeyass[9] = false; $numkeyass[13] = false; $numkeyass[14] = false; }} else { $numkey = self::analisi($keyass); if($key) { $numkeyass = self::analisi($key); if($numkeyass[14]) $num = array($numkeyass[14],$numkeyass[16],$numkeyass[17],$numkeyass[18]); } else { $numkeyass[1] = false; $numkeyass[9] = false; }} $keyval['K'] = array();
        if($numkeyass[9] || $type > 1) { global $Qdatabase; $numkeyass14 = $numkeyass[14]; if($at == 'Qver') $numkeyass[14] = $numkeyass[1]; else { $numkey[8] = '#'; $numkeyass[14] = ''; } $ok = 0; if($valass != NULL && $valass != '-1' && $valass != '-2') { if(is_array($ky)) { $tmp = SYS::combina($numkey[1]); if($ccc) $tmp[] = '1'; else $tmp[] = '0'; $percorso = $Qdatabase.'/'.SYS::keyvalass($ky[0], $valass, $tmp); $valass = $opz; if($opz == -1 || $opz == -2) $ok = 2; else $ok = 1; } else return false; } else { if($type && !$ccc) { if(strstr($ky[1],'[')) { $tmp = self::analisi($ky[1]); $tmp[1] = $ky[0]; $ky[1] = substr($ky[1],0,strpos($ky[1],'[')); } else $tmp = self::analisi($ky[0]); $percorso = SYS::combina($tmp[1],2).'/'.rtrim(SYS::combina($numkey[1],1)).'.0'; if($numkey[0] == '') { $numkey = $tmp; $numkey[1] = $ky[1]; } if($valass == -1 || $valass == -2) $ok = 2; } else { if($type == 3 && $ccc) { if(strstr($ky[1],'[')) { $tmp = self::analisi($ky[1]); $tmp[1] = $ky[0]; $ky[1] = substr($ky[1],0,strpos($ky[1],'[')); } else $tmp = self::analisi($ky[0]); $percorso = SYS::combina($tmp[1],2).'/'.rtrim(SYS::combina($numkey[1],1)).'.@.0'; if($numkey[0] == '') { $numkey = $tmp; $numkey[1] = $ky[1]; } if($valass == -1 || $valass == -2) $ok = 2; }}} $y = $numkey;
            if($numkeyass[9] && $type < 3) { require_once 'Qnr.php'; $numkey[7] = '#'; if($ccc) { if($type) $per = SYS::combina($valok,2).'/@'; else $per = SYS::combina($ccc,2).'/@'; $tmp = SYS::combina($numkey[1]); foreach($tmp as $a) $per .= '/'.$a; } else $per = SYS::combina($numkey[1],2); $dati = Qnr::numerico($per,$numkeyass,$numkey); if(!$dati) return false; if(is_array($at) && $at) { $x = false; if($ac) { if($ccc) { $x = Qsx::ccc($numkey,$dati); $dati = $x[0]; $tempo = $x[1]; } else $dati = SYS::val($dati); } $dati = array_values(array_intersect($at,$dati)); if(!$dati) return false; if($ccc && !$x) { $x = Qsx::ccc($numkey,$dati); $dati = $x[0]; $tempo = $x[1]; } unset($x); } else { if($at == 'Qver') return $dati; }} else { if($type < 3) { if($ccc) { $x = Qsx::ccc($numkey,$at); $dati = $x[0]; $tempo = $x[1]; unset($x); } else $dati = $at; }}
            if($type) { if($type == 3 && $opz < 0) $ok = 2; 
                if($ok == 2) { $fp = SYS::leggi($percorso,0,self::moltiplicatore($numkey,1),2); if(!isset($fp[2])) return false; if($type == 3) return $fp; 
                    if($fp[2][0] == '#') { 
                        for($a=2; $a<count($fp); $a++) { $e = explode('.',$fp[$a]); $fx[$a-2] = substr($e[0],1)."\n"; $fp[$a-2] = $e[1]; } $ok = -1; 
                    } else { 
                        if($opz == -1 || $opz == -2) { 
                            for($a=2; $a<count($fp); $a++) { $e = explode('.',$fp[$a]); 
                                if($ccc) { $fp[$a-2] = array_pop($e); $fx[$a-2] = implode('.',$e); } else { $fx[$a-2] = $e[0]; $fp[$a-2] = $e[1]; $ok = -2; }
                            }
                        } else { 
                            for($a=2; $a<count($fp); $a++) { $e = explode('.',$fp[$a]); $fx[$a-2] = $e[0]."\n"; $fp[$a-2] = $e[1]; }
                        }
                    } unset($fp[count($fp)-1]); unset($fp[count($fp)-1]); 
                } else { 
                    if(!$ccc) { 
                        $fx = SYS::leggi($percorso,0,self::moltiplicatore($numkey,1),1); if(!isset($fx[2])) return false; if($type == 3) return $fx; if($fx[2][0] == '#') $ok = 0; $fx = self::tagli01($fx,$ok); 
                    } else { 
                        if($percorso) { $fx = SYS::leggi($percorso,0,self::moltiplicatore($numkey,1),1); if(!isset($fx[2])) return false; if($type == 3) return $fx; $fx = self::tagli01($fx,$ok); } else { $fx = $dati; $fp = $tempo; $ccc = 2; }
                    }
                }
                if($fx) { 
                    if($ccc) { 
                        if($opz == -1 || $opz == -2 || $valass == -1 || $valass == -2) $ok = 2; else $ok = 1; 
                    } else { 
                        if($fx[0][0] == '#') { 
                            for($a=0; $a<count($fx); $a++) $fx[$a] = substr($fx[$a],1); 
                        } else { 
                            if($ok > 0) { if($valass != -1 && $valass != -2) $dati = SYS::val(self::adesso($dati)); else $ok = -1; } elseif($ok == -2) $dati = SYS::val(self::adesso($dati)); 
                        }
                    } 
                    if($ccc !== 2) { 
                        $fx = array_intersect($fx,$dati); if(!$fx) return false; if(!$numkeyass[9] && $y[7][0] == '-') $y[7] = substr($y[7],1); 
                    } $val = self::selezione(array_values($fx),$y); 
                    if($ok) { if($ok == -1) $keyval = SYS::val(self::adesso($val)); else $keyval = $val; 
                        if($ok == 2 || $ok < 0) { $val = array(); $e = array_keys($fx); foreach($e as $a) $val[] = $fp[$a]; $val = self::selezione($val,$y); }
                    } else $keyval = SYS::val(self::adesso($val)); 
                    
                    $keyk = count($keyval); if($valass == -1 || $valass == -2) $opz = $valass; if($opz == -1 || $opz == -2) { for($a=0; $a<count($val); $a++) if($qt=self::tempo($opz,$val[$a],$ora)) $keyval["t.$a"] = $qt; } 
                    if(!is_array($numkeyass[1])) $numkeyass[1] = array($numkeyass[1]); if($numkeyass[13] != '') $numkeyass[1] = array_merge($numkeyass[1],$numkeyass[13]); $numkeyass[14] = $numkeyass14; 
                    if(!$ccc) $keyl = SYS::tot($percorso); else $keyl = count($at); 
                    
                } else return false;
            } else { if(is_array($at) && !$ac) $dati = array_values(array_intersect($at,$dati)); 
                if($fpt) { $fp = array(); $k = array_keys($dati); for($a=0; $a<count($k); $a++) $fp[$a] = $fpt[$k[$a]]; $fpt = self::selezione($fp,$y); $keyk = count($fpt);
                    if($ac) $keyval = self::selezione($dati,$y); else $keyval = self::selezione(SYS::val(self::adesso($dati)),$y); for($a=0; $a<$keyk; $a++) $keyval["t.$a"] = $fpt[$a]; 
                } else {
                    if($ccc) $keyval = self::selezione($dati,$y); else $keyval = self::selezione($dati,$y,1); $keyk = count($keyval); 
                } 
                if($keyk > 0) { 
                    if($ac) $keyl = $tot; else { if(!$fpt) $keyval = self::time12($keyval,$valass,$ora); if($tot) $keyl = $tot; else $keyl = SYS::tot(SYS::combina($numkey[1],2)); } 
                    if(!is_array($numkeyass[1])) $numkeyass[1] = array($numkeyass[1]); if($numkeyass[13]) $numkeyass[1] = array_merge($numkeyass[1],$numkeyass[13]); 
                    if($num) { $numkeyass[14] = $num[0]; $numkeyass[16] = $num[1]; $numkeyass[17] = $num[2]; $numkeyass[18] = $num[3]; }
                } else return false; if($valass == -1 || $valass == -2) $opz = $valass; 
            }
        } else { if($at == 'Qver') return false; 
            if(is_array($at) && $at) { 
                if(is_array($at)) $at = self::selezione($at,$numkey); else $at = self::selezione($at,$numkey,1); if(!$at) return false; 
                if($ac) $keyval = $at; else { if(!$ccc) { if(!$fpt) $keyval = self::time12($at,$valass,$ora); else $keyval = SYS::val(self::adesso($at)); } else $keyval = $at; } 
                if($valass == -1 || $valass == -2) { $opz = $valass; if($fpt) { $fpt = self::selezione($fpt,$numkey,1); for($a=0; $a<count($fpt); $a++) $keyval["t.$a"] = $fpt[$a]; $keyval['N'] = count($keyval)/2; } else $keyval['N'] = count($keyval)/2; } else $keyval['N'] = count($keyval); 
                if($tot) $keyval['T'] = $tot; else $keyval['T'] = SYS::tot(SYS::combina($numkey[1],2)); 
            } 
            elseif($valass == NULL) $keyval = self::Qdbout($keyass); 
            else { 
                if($type || $valass == -1 || $valass == -2) { 
                    $keyval = self::Qdbout($keyass,$valass,$opz); if($valass == -1 || $valass == -2) $opz = $valass; 
                } else { $key = $numkeyass[1]; $per = SYS::combina($key); 
                    if($per) { $perass = SYS::keyvalass($keyass, $valass, $per); if($perass) { $val = SYS::val($perass."\n"); if($opz == NULL) return $val; $keyval['K'] = $key; $keyval[$key] = $val; if($qt=self::tempo($opz,$perass,$ora)) $keyval["t.$key"] = $qt; return $keyval; }} return false; 
                }
            } if(!$numkeyass[1]) return $keyval; $keyk = $keyval['N']; $keyl = $keyval['T']; unset($keyval['N']); unset($keyval['T']); 
        } if(!$numkeyass[1][0]) { $keyval['N'] = $keyk; $keyval['T'] = $keyl; return $keyval; }
        
        $numkeyass[1] = SYS::Qsort($numkeyass[1]); $w = 0; $dat = array(); $ky = array();
         
        if(is_array($numkeyass[1])) {
            foreach($numkeyass[1] as $key) { $dati = self::analisi($key); 
                if($dati[1][0] == '#' || $dati[1][0] == '@') $k = explode(' ',substr($dati[1],1)); else { if($dati[1][0] == '_') $k = explode(' ',substr($dati[1],1)); else $k = explode(' ',$dati[1]); $ok = true; }
                foreach($k as $x) { $y = explode('.',$x); foreach($y as $z) if(!in_array($z."\n",$keybase)) { $ok = false; break; }} 
                if($ok) { $keyval['K'][$w] = $dati[1]; $ky[$w] = $key; $w++; } else SYS::error(0,1,$dati[1]); 
            } $ky = array_reverse($ky); $x = $w; 
        } else { $keyval['K'][0] = $numkeyass[1]; $ky[0] = $key; $x = 1; } if(!isset($keyval[0])) return false; $si = false; 
        
        foreach($ky as $key) { $x--; $y = $keyval['K'][$x];
            if($key[0] == '#' || $key[0] == '@') {
                for($a=0; $a<$keyk; $a++) { $val = self::Qdbout($numkey[1].' '.$key,$keyval[$a],$opz);
                    if($val) { if($opz == '-1' || $opz == '-2') { for($b=0; $b<$val['N']; $b++) { $keyval["$y.t.$a"][$b] = $val["t.$b"]; unset($val["t.$b"]); }} 
                        $keyval["$y.$a"] = $val; unset($keyval["$y.$a"]['N']); unset($keyval["$y.$a"]['T']); $keyval["N.$y.$a"] = $val['N']; $keyval["T.$y.$a"] = $val['T']; 
                        if(isset($dat["N.$y"])) $dat["N.$y"]++; else $dat["N.$y"] = 1; 
                    } // else unset($keyval['K'][$x]); 
                }
            } else { $si = true;
                if($valass == NULL || $valass == -1 || $valass == -2) { 
                    if(strpos($valok,'#') > 1) { 
                        for($a=0; $a<$keyk; $a++) { $w = 0; 
                            if($opz) { 
                                for($b=0; $b<$keyval["N.#$numkey[1].$a"]; $b++) { $val = self::Qdbout($numkey[1].' '.$key,$keyval["#$numkey[1].$a"][$b],$opz); $keyval["$y.$a"][$b] = $val[$key]; $keyval["$y.t.$a"][$b] = $val["t.$key"]; if($keyval["$y.$a"][$b] != '') $w++; } $keyval["N.$y.$a"] = $w; 
                            } else { 
                                for($b=0; $b<$keyval["N.#$numkey[1].$a"]; $b++) { $keyval["$y.$a"][$b] = self::Qdbout($numkey[1].' '.$key,$keyval["#$numkey[1].$a"][$b]); if($keyval["$y.$a"][$b] != '') $w++; } $keyval["N.$y.$a"] = $w; 
                            }
                        } $keyval["N.$y"] = $keyval["N.#$numkey[1]"]; 
                    } else { $w = 0; 
                        for($a=0; $a<$keyk; $a++) { 
                            if($opz) { 
                                if($ccc) $val = self::Qdbout("@$numkey[1] $key",$keyval[$a],$opz); else $val = self::Qdbout("$numkey[1] $key",$keyval[$a],$opz); $keyval[$y][$a] = $val[$y]; $keyval["t.$y"][$a] = $val["t.$y"]; 
                            } else { 
                                if($ccc) $keyval[$y][$a] = self::Qdbout("@$numkey[1] $key",$keyval[$a]); else $keyval[$y][$a] = self::Qdbout("$numkey[1] $key",$keyval[$a]); 
                            } if($keyval[$y][$a] != '') $w++; 
                        } $keyval["N.$y"] = $w; 
                    }
                } else { $w = 0; 
                    for($a=0; $a<$keyk; $a++) { if($opz) { $val = self::Qdbout("$numkey[1] $key",$keyval[$a],$opz); $keyval[$y][$a] = $val[$y]; $keyval["t.$y"][$a] = $val["t.$y"]; } else $keyval[$y][$a] = self::Qdbout("$numkey[1] $key",$keyval[$a]); if($keyval[$y][$a] != '') $w++; } $keyval["N.$y"] = $w; 
                }
            }
        }
        if($si) { for($a=0; $a<$keyk; $a++) { if($opz) unset($keyval["#$numkey[1].t.$a"]); unset($keyval["#$numkey[1].$a"]); unset($keyval["N.#$numkey[1].$a"]); unset($keyval["T.#$numkey[1].$a"]); } unset($keyval["N.#$numkey[1]"]); } if($dat) $keyval = array_merge($keyval,$dat); $keyval['N'] = $keyk; $keyval['T'] = $keyl; if($numkeyass[14]) $numkeyass[1] = $numkeyass[14]; else $numkeyass[18] = $ky; if($keyval['N'] > 0) return self::flusso($numkeyass,$keyval,$keyval['T'],$keyval['N'],0,$numkey); else return false;
    }
}

?>