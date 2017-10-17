<?php

namespace Quantico;
require_once 'Qdel.php';

class Qin extends Qdel
{
    protected static function sy($keyper,$val){ $k = "$keyper/sync.php"; Qdel::protezione($k); file_put_contents($k, $val, FILE_APPEND); }
    protected static function m($keyper,$hash){ global $Qlivtime; for($a=0; $a<$Qlivtime; $a++) { $keyper .= '/'.substr($hash, $a*2, 2); Qdel::ix($keyper); } return "$keyper/$hash"; }
    protected static function fs($val,$orapsw,$psw,$opz=false){ global $Qdatabase; global $Qpassword; global $Qpostime; global $Qlivtime; global $Qmaxtime; if($opz == 998) $keyper = substr($Qdatabase,0,-2).$Qpostime; else $keyper = $Qdatabase.$Qpostime; $val = Qcrypt($val.$orapsw,$Qpassword[$psw]); $op0 = substr($orapsw,0,3); $op1 = substr($orapsw,3,$Qlivtime); $keyper .= '/'.$op0; Qdel::ix($keyper); $keyper .= '/'.$op1; $keyperindex = Qdel::ix($keyper); Qin::sy($keyper,$val."\n"); file_put_contents($keyperindex,$val."\n",FILE_APPEND); $keyperpos = "$keyper/id.php"; Qdel::protezione($keyperpos,false,2); $poscript = r($keyperpos); $posold = $Qlivtime.$poscript; if(SYS::$dataval) $posold .= "_\n"; else $posold .= "\n"; $poscript++; w($keyperpos,$poscript); if($poscript > $Qmaxtime[$Qlivtime] && $Qlivtime < 6){ $y = dirname($Qdatabase).'/Qconfig.php'; $x = file($y); $Qlivtime++; $x[8] = '$Qlivtime = '.$Qlivtime.";\n"; file_put_contents($y,$x); } return $posold; }
    protected static function crea($keyper, $val, $opz=0, $type=0, $stat=0, $db=0) { $hash = $val; if($opz) { $keyperid = "$keyper/id.php"; if(!file_exists($keyperid)){ if(!is_dir($keyper)) mkdir($keyper,0755); file_put_contents($keyperid,1); } $id = r($keyperid); $hash = Qhash($id); $id++; w($keyperid,$id); } $keyper = Qin::m($keyper,$hash); $keyindex = Qdel::ix($keyper); $Qdb = new SYS; if($type) return Qdel::scrivi($keyper, SYS::time(), "\n", 0, $val."\n", 0, $stat, 0, $db); else { if($opz) return Qdel::scrivi($keyper, $val, "\n", 1); else return $keyindex; }}
    protected static function Querin($keyper, $chiaro, $criptato, $index){ if($criptato[strlen($criptato)-2] == '_') $chiaro = SYS::dataval($chiaro); else $chiaro = mb_strtolower(trim($chiaro),'UTF-8'); $QprcNum = SYS::prcnumber(); $key = $keyper; $keyper = Qin::m($keyper,Qhash($chiaro)); Qdel::ix($keyper); $keyperindex = "$keyper/index.php"; $keyper .= '/idem.php'; Qdel::protezione($keyper); $fp = file($keyper); if(count($fp) < $QprcNum) Qdel::ia($keyper,$index); else { $fp = SYS::cancella($fp,2); $fp[] = $index; w($keyper,$fp); } $fp = file($keyperindex); if(isset($fp[2])) $fp[2]++; else $fp[2] = 1; w($keyperindex,$fp); $f = SYS::trak($chiaro); $s = $f[0][0]; $str[0] = $f[0]; $a = 0; for($b=1, $ub=count($f); $b<$ub; $b++) { if($s == $f[$b][0]) $str[$a] .= $f[$b]; else { $dir[] = Qord($str[$a]); $a++; $s = $f[$b][0]; $str[$a] = $f[$b]; }} $dir[] = Qord($str[$a]);
        for($a=0, $ua=count($dir); $a<$ua; $a++){ $f = $key.'/'.$dir[$a]; $keyperindex = "$f/index.php"; $ftraccia = "$f/keyt.php"; $fstato = "$f/stat.php"; $fcript = "$f/keyc.php"; $findex = "$f/keyi.php"; if(!file_exists($keyperindex)){ if(!is_dir($f)) mkdir($f,0755); Qdel::protezione($keyperindex); } if(!file_exists($ftraccia)){ Qdel::protezione($ftraccia,$fstato); Qdel::protezione($fcript,$findex); } $ftr = file($ftraccia); if(count($ftr) < $QprcNum) { Qdel::ia($ftraccia,$str[$a]."\n"); Qdel::ia($fstato,"0\n"); Qdel::ia($fcript,$criptato); Qdel::ia($findex,$index); } else { $fts = file($fstato); $ftc = file($fcript); $fti = file($findex); $min = 9999999999; $pos = 0; for($b=2, $ub=count($fts); $b<$ub; $b++) { if($fts[$b] == 0) { $pos = $b; break; } else if($fts[$b] < $min) { $min = $fts[$b]; $pos = $b; }} $ftr = SYS::cancella($ftr,$pos); $fts = SYS::cancella($fts,$pos); $ftc = SYS::cancella($ftc,$pos); $fti = SYS::cancella($fti,$pos); $ftr[] = $str[$a]."\n"; $fts[] = "0\n"; $ftc[] = $criptato; $fti[] = $index; w($ftraccia,$ftr); w($fstato,$fts); w($fcript,$ftc); w($findex,$fti); }}
        if(is_numeric($chiaro)) { global $Qprotezione; $keyperindex = "$key/list.php"; if(!file_exists($keyperindex)) { w($keyperindex,$Qprotezione.$chiaro.'#'.$chiaro."#1\n"); w("$key/v2.php",$Qprotezione.$chiaro."\n"); w("$key/n2.php",$Qprotezione."1\n"); } else { $fp = file($keyperindex); $f = explode('#',$fp[2]); if($chiaro < $f[0]) { $f[2] = (int)$f[2] + 1; if($f[2] == 1 && !isset($fp[3])) { $fp[2] = $chiaro.'#'.$chiaro."#1\n"; $fv = $Qprotezione.$chiaro."\n"; $fn = $Qprotezione."1\n"; } else { $fp[2] = $chiaro.'#'.$f[1].'#'.$f[2]."\n"; $fv = file("$key/v2.php"); $fn = file("$key/n2.php"); array_splice($fv, 2, 0, $chiaro."\n"); array_splice($fn, 2, 0, "1\n"); } w("$key/v2.php",$fv); w("$key/n2.php",$fn); } else { $pos = count($fp); $min = $pos - 1; $f = explode('#',$fp[$min]);
        if($chiaro > $f[1]) { $f[2] = (int)$f[2] + 1; if($f[2] == 1) { $fp[2] = "$chiaro#$chiaro#1\n"; w("$key/v2.php",$Qprotezione.$chiaro."\n"); w("$key/n2.php",$Qprotezione."1\n"); } else { if($f[2] > $QprcNum) { $fp[$pos] = $f[1]."#$chiaro#1\n"; w("$key/v$pos.php",$Qprotezione.$chiaro."\n"); w("$key/n$pos.php",$Qprotezione."1\n"); } else { $fp[$min] = $f[0].'#'.$chiaro.'#'.$f[2]."\n"; a("$key/v$min.php",$chiaro."\n"); a("$key/n$min.php","1\n"); }}} else { for($a=2; $a<$pos; $a++) { $f = explode('#',$fp[$a]); if($chiaro >= $f[0] && $chiaro <= $f[1]) { $f[2] = (int)$f[2] + 1; $fp[$a] = $f[0].'#'.$f[1].'#'.$f[2]."\n"; $fn = file("$key/n$a.php"); $fv = file("$key/v$a.php"); $j = array_search($chiaro."\n",$fv); if($j > 1) { $fn[$j] = ((int)$fn[$j] + 1)."\n"; w("$key/n$a.php",$fn); } else { $s = SYS::ordina($chiaro, $fv, 0, 0); array_splice($fv, $s, 0, $chiaro."\n"); array_splice($fn, $s, 0, "1\n"); w("$key/v$a.php",$fv); w("$key/n$a.php",$fn); } break; }}}} w($keyperindex,$fp); }}}
    protected static function Qdbin($keys=null, $val=null, $valass=null, $opz=0) { global $Qdatabase; $tdb = strlen($Qdatabase)+1; $ora = SYS::time(); $Qdb = new SYS;
        if(is_array($valass)) { $tmp = $val; $val = $valass; $valass = $tmp; } if(is_array($val)) { if(is_array($valass)) return Qerror(1,4); if($valass === null && $keys[0] != '#') return false; } else { if($val === false || strtolower($val) === 'false') { $val = 'false'; $Qdb->orapsw = $ora."f\n"; } elseif($val === true || strtolower($val) === 'true') { $val = 'true'; $Qdb->orapsw = $ora."t\n"; } elseif($val === 0) $val = '0'; $valass = SYS::speciali($valass,1); $posizione = true; $poscript = false; $ind = false; } 
        if(strpos($keys, ' ') > 1) { $ky = explode(' ', $keys, 2); if(!isset($ky[1][1])) return false; 
            if($ky[1][0] == '!') { $key = substr($ky[1],1); $ind = $keys; $keys = $ky[0].' '.$key; } else $key = $ky[1]; $keyass = $ky[0]; if($val != '') $vals = $val; else return false; 
            if($key[0] == '#') return Qin::Qdbin($keyass.$key,$val,$valass,$opz); 
            if($keyass[0] == '@') { $dati[$key] = $val; return Qin::Qdbin($keyass,$dati,$valass); } if($valass == null) return false; $perass = SYS::combina($keyass); if(!$perass) return false; 
            $hashpos = SYS::hashpos(Qhash($valass), $perass); if(!file_exists("$hashpos/index.php")) return Qerror(1,5,$keyass); $fpi = file("$hashpos/index.php");
        } else { $key = $keys; $keyass = 0;
            if($key[0] == '#') { if(strpos($key,',') > 1) { $vls = explode(',',$key); $a = Qin::Qdbin($vls[0],null,null,997); if($a) { $tmp = explode('#',$a); $tmp[0] = (int)$tmp[0]; for($a=1, $ua=count($vls); $a<$ua; $a++) { if($vls[$a]) { $pos = Qin::Qdbin($vls[$a], null, rtrim($tmp[1]), 996); if($tmp[0] != $pos) { if($pos) Qdel::Qdbdel(substr($vls[$a],1),$pos,0,999); for($b=$a-1; $b>-1; $b--) Qdel::Qdbdel(substr($vls[$b],1),$tmp[0],0,999); return false; }}} return $tmp[0]; } return false; } //   $tmp[0] = posizione   $tmp[1] = orapsw  *****  Qdb::in('#foto.mattina,#foto.pomeriggio,#foto.sera')
                if(is_array($val)) { $posizione = Qin::Qdbin($key); $key = substr($key,1); if(Qin::Qdbin($key, $val, $posizione)) return $posizione; else return false; } $key = substr($key,1); $per = SYS::combina($key,2); if(!$per) return false; if($opz != 996) { if($val != null || $valass != null) Qerror(1,8,$key); } if($val == null) { require_once 'Qver.php'; $per .= '/id.php'; $id = (int)r($per); do $id++; while($Qdb->_ver($key,$id)); if($opz == 996) $posizione = Qin::Qdbin($key,$id,$valass,996); elseif($opz == 997) $posizione = Qin::Qdbin($key,$id,null,997); else { if(Qin::Qdbin($key,$id)) $posizione = $id; else $posizione = false; } if($posizione) { w($per,$id); return $posizione; } else return false; }
            } else {
                if($key[0] == '@') { if($valass == null) return Qerror(1,9,$key); require_once 'Qml.php'; return Qml::dettagli($key, $val, $valass, $ora); } 
                if(strpos($keys, '@') > 1) { $ky = explode('@',$keys,2); if(is_array($opz)) { $id = Qin::Qdbin($keys,$val,$valass); if($id) return Qin::Qdbin('@'.$ky[1],$id,$opz); else return false; } require_once 'Qml.php'; return Qml::modello($ky[1], $ky[0], $val, $valass, $ora, $tdb); } 
                if(strpos($keys, '#') > 1) { if($val == null) return false; require_once 'Qlk.php'; return Qlk::multi($keys, $val, $valass, $opz, $ora, $tdb); }
            }
        } if($val == null) return Qerror(1,11,$key); global $Qpostime; $tmp = $Qdatabase.$Qpostime;
        if(is_array($val)) { $ak = array_keys($val); foreach($ak as $a) if(is_numeric($a)) Qerror(1,10); $per = SYS::combina($keys); if(!$per) return false; $hash = SYS::hashpos(Qhash($valass), $per); if(!file_exists("$hash/index.php")) $posizione = Qin::Qdbin($keys,$valass,null,995); else $posizione = false; $al = array_values($val); require_once 'Qlk.php'; if(Qlk::Qarray($ak, $al, $keys, $valass, $ora, $hash, $tmp, $per)){ if($posizione) return $posizione; else return true; } return false; } 
        if($opz == 998) { $per = explode('.',$key); $per[] = '@'; $Qdatabase .= '/@'; $keyper = $Qdatabase; foreach($per as $p) { $keyper .= '/'.$p; Qdel::ix($keyper); }} else $per = SYS::combina($key);  
        if($per) { if($opz != 996) { if($opz == 998) { $keyper = SYS::lh($keyper,Qhash($val)).'/index.php'; if(file_exists($keyper)) return true; } else { if(!$Qdb->orapsw) { require_once 'Qver.php'; if($Qdb->_ver($keys, $val, $valass)) return false; }} if(!$Qdb->orapsw) { if(SYS::isnumber($val)) $Qdb->orapsw = $ora.":$val\n"; else $Qdb->orapos($ora); }} $id = $val; $vhash = Qhash($val); $keyper = $Qdatabase; $lnk = ''; $pr = '';
            if(!$keyass) { foreach($per as $a) { $keyper .= '/'.$a; $pr .= $a.'.'; }
                if($valass != null && $opz != 996) { if(SYS::isnumber($val)) return Qerror(1,19,$key); require_once 'Qup.php'; return Qup::key($key, $val, $valass, $pr, $per, $keyper, $tmp, $ora); } $keyindex = Qin::crea($keyper, $vhash);
                if($opz != 996) { if($Qdb->orapsw[10] != ':' && $Qdb->orapsw[11] != "\n") $posold = Qin::fs($val,$Qdb->orapsw,$Qdb->pospsw,$opz); else $posold = ''; } else { $Qdb->orapsw = $valass; $posold = "\n"; } a($keyindex,$Qdb->orapsw.$posold); $posizione = Qdel::scrivi($keyper,$Qdb->orapsw,$posold,0,0,0,0,2);
            } else { $linkphp = "$hashpos/keys.php"; $linkpos = "$hashpos/link.php"; Qdel::protezione($linkphp); Qdel::protezione($linkpos); $keyper = $Qdatabase.'/'.$perass[0]; $linkphpass = $per[0]; $lnk = $perass[0]; for($a=1, $ua=count($perass); $a<$ua; $a++) { $keyper .= '/'.$perass[$a]; $lnk .= '.'.$perass[$a]; } $lnk .= '#'.$per[0]; $keyper .= '/.'.$per[0]; Qdel::ix($keyper); for($a=1, $ua=count($per); $a<$ua; $a++) { $keyper .= '/'.$per[$a]; $linkphpass .= '.'.$per[$a]; $lnk .= '.'.$per[$a]; Qdel::ix($keyper); } $fp = file($linkphp); $a = array_search($linkphpass."\n", $fp); if($a > 1) { if(Qdel::Qdbdel($keys, $valass, 999)) { if($ind) $keys = $ind; return Qin::Qdbin($keys, $vals, $valass, 999); } else return false; } else { if($opz != 996) { if($Qdb->orapsw[10] != ':' && $Qdb->orapsw[11] != "\n") $posold = Qin::fs($val,$Qdb->orapsw,$Qdb->pospsw); else $posold = ''; } else { $Qdb->orapsw = $valass; $posold = "\n"; }} a($linkphp, $linkphpass."\n"); a($linkpos, $Qdb->orapsw.$posold); 
                if(!$ind) { $Qlog = "$hashpos/$linkphpass.php"; Qdel::protezione($Qlog); a($Qlog, $Qdb->orapsw.$posold); Qin::Querin($keyper, $vals, $Qdb->orapsw.$posold, $fpi[2]); } if($opz != 999) { $keyper = SYS::combina($keyass,2); $linkphp = "$keyper/keys.php"; $linkpos = "$keyper/keyn.php"; Qdel::protezione($linkphp,$linkpos); $fp = file($linkphp); $a = array_search($linkphpass."\n",$fp); if($a > 1) { $fl = file($linkpos); $fl[$a] = ((int)$fl[$a] + 1)."\n"; w($linkpos,$fl); } else { a($linkphp,$linkphpass."\n"); a($linkpos,"1\n"); } $lk = file("$Qdatabase/link.php"); $a = array_search($lnk."\n", $lk); if($a > 1) return true; a("$Qdatabase/link.php",$lnk."\n"); }
            } if($opz == 997) $posizione .= '#'.$Qdb->orapsw.rtrim($posold); return $posizione;
        } return false;
    }
}