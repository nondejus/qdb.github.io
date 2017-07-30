<?php

namespace Quantico;

class Qver extends fx
{
    protected static function Qdbverify($qvl, $val, $file, $orapsw, $opz) {
        if(substr($qvl,0,-12) == $val) { if(file_exists($file)) { $fl = file($file); if(count($fl) > 2) return 2; } if($opz == -1) return substr($orapsw,0,10); elseif($opz == -2) return $ora-substr($orapsw,0,10); else return 1; } return 0;
    }
    protected static function Qdbvertot($keyass, $per, $opz=0, $num=NULL) { $perass = fx::combina($keyass,2); $keys = $perass.'/keys.php';
        if(file_exists($keys)) { $fp = file($keys);
            if($opz) { global $Qdatabase; global $keybase; $fn = file($perass.'/keyn.php'); $keyval = array(); for($a=2; $a<count($fp); $a++) { $j = explode('.',rtrim($fp[$a])); $str = rtrim($keybase[$j[0]]); for($b=1; $b<count($j); $b++) { if($j[$b] == 0) $str = '#'.$str; elseif($j[$b] == 1) $str = '@'.$str; else $str .= '.'.rtrim($keybase[$j[$b]]); } $keyval['K'][] = $str; } if(!isset($keyval['K'])) return false; 
                if(is_array($opz)) { $keyval['K'] = array_intersect($keyval['K'],$opz); if(!$keyval['K']) return false; $keys = array_keys($keyval['K']); for($a=0; $a<count($keys); $a++) $keyval[$keyval['K'][$keys[$a]]] = rtrim($fn[$keys[$a]+2]); $keyval['K'] = array_values($keyval['K']); } else { for($a=0; $a<count($keyval['K']); $a++) $keyval[$keyval['K'][$a]] = rtrim($fn[$a+2]); } $str = ''; foreach($per as $a) $str .= '/'.$a; if($num) { $keyval['K'] = array_unique(array_merge($keyval['K'],$num['K'])); unset($num['K']); unset($num['N']); unset($num['T']); $keyval = array_merge($keyval,$num); } 
                $val = "$Qdatabase/@$str/index.php"; if(file_exists($val)){ $fp = file($val); $keyval['@'] = rtrim($fp[2]); } else $keyval['@'] = 0; $keyval['#'] = r($Qdatabase.$str.'/id.php'); if(!$keyval['#']) $keyval['#'] = 0; $keyval['N'] = count($keyval['K']); $j = r($Qdatabase.$str.'/in.php'); if($j){ $j = explode('.',$j); $keyval['T'] = $j[2]; } else $keyval['T'] = 0; return $keyval;
            } else { $str = $per[0]; for($a=1; $a<count($per); $a++) $str .= '.'.$per[$a]; $j = array_search($str."\n",$fp); if($j > 1) { $fp = file("$perass/keyn.php"); if(isset($fp[$j])) return rtrim($fp[$j]); } else { $j = r("$perass/$str/in.php"); if($j) { $j = explode('.',$j); return $j[2]; }}}
        } return 0;
    }
    protected static function Qdbver($keys=NULL, $val=NULL, $valass=NULL, $opz=NULL) { if(is_array($valass)) { $tmp = $val; $val = $valass; $valass = $tmp; } if(is_array($valass) || is_array($opz)) { include_once 'Qerr.php'; return Qerror(4,3,$keys); } global $Qdatabase; global $Qpostime; $ora = fx::time(); $val = fx::speciali($val,1); $valass = fx::speciali($valass,1); $k = strpos($keys,'['); if($k > 1) { if($keys[$k+2] == ']') { $ky = $keys[$k+1]; if($ky == 'T') { if($keys[0] == '-') $per = fx::combina(substr($keys,1,$k-1),2).'/-0'; else $per = fx::combina(substr($keys,0,$k),2); if($per) return fx::tot($per); } else { if($val != NULL) $per = fx::hashpos(Qhash($val),fx::combina(substr($keys,0,$k))); else $per = fx::combina(substr($keys,0,$k),2); $per .= '/keys.php'; if(file_exists($per)) $per = array_slice(file($per),2); else return false;
        if($ky == 'K' || $ky == '#' || $ky == '@' || $ky == ' ') { $tmp = count($per); if($ky == '#') { for($a=0; $a<$tmp; $a++) if(substr($per[$a],-3) != ".0\n") unset($per[$a]); } elseif($ky == '@') { for($a=0; $a<$tmp; $a++) if(substr($per[$a],-3) != ".1\n") unset($per[$a]); } elseif($ky == ' ') { for($a=0; $a<$tmp; $a++) { $keys = substr($per[$a],-3); if($keys == ".0\n" || $keys == ".1\n") unset($per[$a]); }} if($per) { global $keybase; $per = array_values($per); for($a=0; $a<count($per); $a++) { $k = explode('.',rtrim($per[$a])); $keys = rtrim($keybase[$k[0]]); for($b=1; $b<count($k); $b++) { if($k[$b] == '0') $keys = '#'.$keys; elseif($k[$b] == '1') $keys = '@'.$keys; else $keys .= '.'.rtrim($keybase[$k[$b]]); } $per[$a] = $keys; } if($per) { $per = fx::Qsort($per); $per['N'] = count($per); $per['T'] = $tmp; return $per; }}}}} return false; } $Qdb = new fx;
        if(strpos($keys, ' ') > 1) { if(is_array($val)) { include_once 'Qerr.php'; return Qerror(4,3,$keys); } $ky = explode(' ', $keys, 2); if(!isset($ky[1][1])) return false; $key = $ky[1]; $keyass = $ky[0];
            if(strpos($key, '{') > 1) { $j = array_unique(explode(',',$key)); $ml = array(); $fl = array(); foreach($j as $a) if(strpos($a, '{') > 1) $ml[] = $a; else $fl[] = $a; if($ml) { require_once 'Qout.php'; $num = array(); $s = array(); foreach($ml as $a) { $j = $Qdb->_out("$keyass $a", NULL, NULL, NULL, 'Qver'); if($j) { $s[] = $j['K'][0]; $num = array_merge($num,$j); }}} if($s) $num['K'] = $s; if(!$fl) $fl = $num['K']; if($num) return self::Qdbvertot($keyass,fx::combina($keyass),$fl,$num); else return false; }
            if(strpos($key, ',') > 1) return self::Qdbvertot($keyass,fx::combina($keyass),explode(',',$key)); $per = fx::combina($key); if($valass == NULL) { if($key[0] == '#' or $key[0] == '@') return self::Qdbver($ky[0].$ky[1],$val); if($val == NULL) return self::Qdbvertot($keyass,$per); else { if($per) { $val = strlen(fx::keyvalass($keyass, $val, $per)); if($val > 10 and $val < 64) return 1; } return 0; }}
        } else { $key = $keys; $keyass = 0;
            if($key[0] == '#') { if(is_array($val)) { include_once 'Qerr.php'; return Qerror(4,3,$keys); } $key = substr($key, 1); if(!$key) return false; $per = fx::combina($key); if($per) { if($val == NULL) { $key = $Qdatabase.'/'.$per[0]; for($a=1; $a<count($per); $a++) $key .= '/'.$per[$a]; if(file_exists($key.'/keyp.php')) return true; } else { if($valass == NULL) { $hashpos = fx::hashpos(Qhash($val), $per).'/index.php'; if(file_exists($hashpos)) return true; }}} return false; }
            if($key[0] == '@') { if(is_array($val)) { include_once 'Qerr.php'; return Qerror(4,3,$keys); } $key = substr($key, 1); if(!$key) return false; $per = fx::combina($key); if($per) { if($val == NULL) { $key = $Qdatabase.'/'.$per[0]; for($a=1; $a<count($per); $a++) $key .= '/'.$per[$a]; if(file_exists($key.'/keyc.php')) return true; } else { if($valass == NULL) { $hashpos = fx::hashpos(Qhash($val), $per).'/index.php'; if(file_exists($hashpos)) return true; }}} return false; }
            if(strpos($keys, '#') > 1) { $ky = explode('#', $keys, 2); $key = $ky[1]; $keyass = $ky[0]; if(!$key) return false; $per = fx::combina($key); if($per) { $tmp = $per; $per[] = 0; 
                if($valass == NULL) { if(is_array($val)) { include_once 'Qerr.php'; return Qerror(4,3,$keys); }
                    if($val == NULL) return self::Qdbvertot($keyass,$per); else { $keys = fx::keyvalass($keyass, $val, $per); if(strlen($keys) > 64) return fx::tot("$Qdatabase/$keys"); }
                } else { $keys = fx::keyvalass($keyass, $valass, $per);
                    if(strlen($keys) > 64) { if(is_array($val)) { $v = array_unique($val); $ok = true; } else { $v = array($val); $ok = false; } $ak = array(); $al = array(); $s = array();
                        foreach($v as $val) { if(fx::isnumber($val)) { if($opz != -1 and $opz != -2) { if(fx::leggi($Qdatabase.'/'.$keys, $val."\n")) $al[] = $val; else $ak[] = $val; } else { $per = fx::leggi($Qdatabase.'/'.$keys, $val."\n", 1); if($per) { $s[] = $per; $ak[] = $val; }}} else { $hash = fx::hashpos(Qhash($val), $tmp).'/index.php'; if(file_exists($hash)) { $fp = file($hash); if($opz != -1 and $opz != -2) { if(fx::leggi($Qdatabase.'/'.$keys, '#'.$fp[count($fp)-1], 0, 1)) $al[] = $val; else $ak[] = $val; } else { $per = fx::leggi($Qdatabase.'/'.$keys, '#'.$fp[count($fp)-1], 1, 1); if($per) { $s[] = $per; $ak[] = $val; }}}}} 
                        if($ok) { if($opz == 1 || $opz == 'del') { if($al) { if($opz == 'del') { require_once 'Qdel.php'; if(!$Qdb->_del("$keyass#$key",$al,$valass)) return false; } $al['N'] = count($al); $al['T'] = fx::tot($Qdatabase.'/'.$keys); return $al; }} else { if($ak) { if($opz == -1) { for($a=0; $a<count($s); $a++) $ak['t.'.$a] = $s[$a]; $ak['N'] = count($ak)/2; } elseif($opz == -2) { for($a=0; $a<count($s); $a++) $ak['t.'.$a] = $ora-$s[$a]; $ak['N'] = count($ak)/2; } else { if($opz == 'in') { require_once 'Qin.php'; if(!$Qdb->_in($keyass.'#'.$key,$ak,$valass)) return false; } $ak['N'] = count($ak); } $ak['T'] = fx::tot($Qdatabase.'/'.$keys); return $ak; }}} else { if($al) return true; else { if($s) { if($opz == -1) return $s[0]; elseif($opz == -2) return $ora-$s[0]; }}}
                    } else { if(is_array($val)) { $val = array_values(array_unique($val)); if($opz == 'in') { require_once 'Qin.php'; if(!$Qdb->_in($keyass.'#'.$key,$val,$valass)) return false; } elseif($opz == 'del' or $opz == 1 or $opz < 0) return false; $val['N'] = count($val); $val['T'] = $val['N']; return $val; }}
                }} return false; }
            if(strpos($keys, '@') > 0) { if(is_array($val)) { include_once 'Qerr.php'; return Qerror(4,3,$keys); } $ky = explode('@', $keys, 2); $key = $ky[1]; $keyass = $ky[0]; if(!$key) return false; $per = fx::combina($key);
                if($per) { if($val == NULL && $valass == NULL){ $ok = false; $m = explode('.',$keyass); for($a=0; $a<count($m); $a++) if(!is_numeric($m[$a])) { $ok = true; break; } if($ok) { $per[] = 1; return self::Qdbvertot($keyass,$per); } else { $str = $Qdatabase.'/@'; foreach($per as $a) $str .= '/'.$a; $s = $str; $str .= '/@'; $str = fx::lh($str,Qhash($keyass)).'/index.php'; if(file_exists($str)) { $fp = file($str); $hashpos = fx::hashpos(Qhash(rtrim($fp[3])), $per); $fl = file($hashpos.'/link.php'); $s = fx::lh($s,Qhash($m[0])).'/link.php'; $ml = file($s); for($a=2; $a<count($ml); $a++) if(strlen($ml[$a]) < 64) { if($ml[$a] != $fl[$a]) return false; } return rtrim($fp[3]); } else return false; }}
                if($valass == NULL) { $per[] = 1; $per = fx::keyvalass($keyass, $val, $per); if($per) return fx::tot($Qdatabase.'/'.$per); } else { $str = "$Qdatabase/@/"; foreach($per as $a) $str .= $a.'/'; $str .= '@'; $hash = Qhash($val); $str = fx::lh($str,$hash); $s = $str.'/link.php'; $str .= '/keys.php'; if(file_exists($str)) { $perass = fx::combina($keyass,1); if($perass) { $fp = file($str); $j = array_search(rtrim($perass).".0\n",$fp); if($j > 1) { $fp = file($s); $keyper = $Qdatabase.'/'.str_replace('.','/',rtrim($perass)); $hash = Qhash($valass); $keyper = fx::lh($keyper,$hash); $keyper .= '/index.php'; if(file_exists($keyper)) { $fi = file($keyper); return fx::leggi($Qdatabase.'/'.rtrim($fp[$j]),'#'.$fi[count($fi)-1],0,1,1); }}}}}} return false; }
        } if(!$key) return false; $per = fx::combina($key);
        if($per) { if($val == NULL) { $val = self::Qdbvertot($key,$per,1); if(!$val) $val = array('@' => 0,'#' => 0,'N' => 0,'T' => 0); return $val; }
            if(is_array($val)) { $ak = array_keys($val); $al = array_values($val);
                if($ak[0] == '0') { $ok = array(); $tmp = $Qdatabase.'/'.$per[0]; for($a=1; $a<count($per); $a++) $tmp .= '/'.$per[$a]; $tmp = fx::tot($tmp); if($valass == 'in' or $valass == NULL) { foreach($val as $a) { $file = fx::hashpos(Qhash($a),$per).'/index.php'; if(!file_exists($file)) $ok[] = $a; } if($valass == 'in') { $val = array(); require_once 'Qin.php'; foreach($ok as $a) if($Qdb->_in($key,$a)) $val[] = $a; if($val) { $val['N'] = count($val); $val['T'] = $tmp; return $val; }} else { if($ok) { $ok['N'] = count($ok); $ok['T'] = $tmp; return $ok; }}}
                    elseif($valass == 'del' or $valass == '1' or $valass == '-1' or $valass == '-2' or $valass == '-3') { $s = 0; foreach($val as $a) { $file = fx::hashpos(Qhash($a),$per).'/index.php'; if(file_exists($file)) { $ok[] = $a; if($valass < 0) { $fp = file($file); if($valass == '-1') $ok['t.'.$s] = substr($fp[2],0,10); elseif($valass == '-2') $ok['t.'.$s] = $ora - substr($fp[2],0,10); elseif($valass == '-3') $ok['t.'.$s] = substr($fp[count($fp)-1],0,10); $s++; }}} if($valass == 'del') { $val = array(); require_once 'Qdel.php'; foreach($ok as $a) if($Qdb->_del($key,$a)) $val[] = $a; if($val) { $val['N'] = count($val); $val['T'] = $tmp; return $val; }} else { if($ok) { if($s) $ok['N'] = count($ok)/2; else $ok['N'] = count($ok); $ok['T'] = $tmp; return $ok; }}} return false;
                } else { $perass = $per[0]; for($a=1; $a<count($per); $a++) $perass .= '/'.$per[$a]; $hashpos = $Qdatabase.'/'.$perass; $keyval = array(); for($a=0; $a<count($ak); $a++) { $per = fx::combina($ak[$a]); $riga = $hashpos.'/'.$per[0]; for($b=1; $b<count($per); $b++) $riga .= '/'.$per[$b]; if(!isset($keyval[$ak[$a]])) { $keyval['K'][] = $ak[$a]; if(is_array($al[$a])) $al[$a] = array_unique($al[$a]); else $al[$a] = array($al[$a]); for($c=0; $c<count($al[$a]); $c++) { $keyass = fx::lh($riga,Qhash(mb_strtolower(trim($al[$a][$c]),'UTF-8'))).'/index.php'; if(file_exists($keyass)) { $h = file($keyass); $keyval[$ak[$a]][] = $al[$a][$c]; $keyval['N.'.$ak[$a]][] = $h[2]; }}
                    if(isset($keyval[$ak[$a]])) $keyval['T.'.$ak[$a]] = array_sum($keyval['N.'.$ak[$a]]); else array_pop($keyval['K']); }} if($keyval['K']) { $file = "$Qdatabase/@/$perass/index.php"; if(file_exists($file)) { $h = file($file); $keyval['@'] = rtrim($h[2]); } else $keyval['@'] = 0; $keyval['#'] = r("$hashpos/id.php"); $keyval['N'] = count($keyval['K']); $keyval['T'] = fx::tot($hashpos); return $keyval; } else return false;
                }
            } $hashpos = fx::hashpos(Qhash($val),$per); $perass = 0;
            if($keyass) { $perass = fx::keyvalass($keyass, $valass, $per); } else { if($valass == NULL or $valass == -1 or $valass == -2 or $valass == -3) { $file = $hashpos.'/index.php'; if(file_exists($file)){ $fp = file($file); $perass = rtrim($fp[2]); if($valass == -1) return substr($fp[2],0,10); elseif($valass == -2) return $ora-substr($fp[2],0,10); elseif($valass == -3) return substr($fp[count($fp)-1],0,10); }} else { $hashpos = fx::hashpos(Qhash($valass), $per); $file = $hashpos.'/index.php'; if(file_exists($file)) return true; else return false; }}
            if($perass) { if($perass[10] == ':') { if($val == rtrim(substr($perass,11))) { if($opz == -1) return substr($perass,0,10); elseif($opz == -2) return $ora-substr($perass,0,10); else return 1; } else return 0; } else { if(strlen($perass) == 11) { if($val == 'true' and $perass[10] == 't') { if($opz == -1) return substr($perass,0,10); elseif($opz == -2) return $ora-substr($perass,0,10); else return 1; } elseif($val == 'false' and $perass[10] == 'f') { if($opz == -1) return substr($perass,0,10); elseif($opz == -2) return $ora-substr($perass,0,10); else return 1; } else return 0; }} $keyper = $Qdatabase.$Qpostime; $Qdb->orapsw = substr($perass,0,12); $Qdb->pospsw = substr($perass,13);
                if($Qdb->pospsw) { $keyperindex = $keyper.'/'.substr($Qdb->orapsw,0,3).'/'.substr($Qdb->orapsw,3,$perass[12]).'/index.php'; if(file_exists($keyperindex)){ global $Qpassword; $str = file($keyperindex); $key = $Qpassword[hexdec(substr($Qdb->orapsw,-2))]; $iv = Qiv($Qdb->orapsw, $key); $qvl = Qdecrypt($str[$Qdb->pospsw], $key, $iv); if(substr($qvl,-12) == $Qdb->orapsw) return self::Qdbverify($qvl,$val,"$hashpos/link.php",$perass,$opz); else { $qvl = Qrecupero($perass); if($qvl) return self::Qdbverify($qvl,$val,"$hashpos/link.php",$perass,$opz); }}}
            }
        } return 0;
    }
}

?>