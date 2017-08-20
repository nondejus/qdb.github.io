<?php

namespace Quantico;
require_once 'Qdel.php';

class Qin extends SYS
{
    protected static function sy($keyper,$val){ $k = $keyper.'/sync.php'; SYS::protezione($k); file_put_contents($k,$val,FILE_APPEND); }
    protected static function fs($val,$orapsw,$psw,$opz=false){ global $Qdatabase; global $Qpostime; global $Qlivtime; global $Qmaxtime; if($opz == 998) $keyper = substr($Qdatabase,0,-2).$Qpostime; else $keyper = $Qdatabase.$Qpostime; $val = Qcrypt($val.$orapsw,$psw); $op0 = substr($orapsw,0,3); $op1 = substr($orapsw,3,$Qlivtime); $keyper .= '/'.$op0; SYS::ix($keyper); $keyper .= '/'.$op1; $keyperindex = SYS::ix($keyper); self::sy($keyper,$val."\n"); file_put_contents($keyperindex,$val."\n",FILE_APPEND); $keyperpos = "$keyper/id.php"; SYS::protezione($keyperpos,false,2); $poscript = r($keyperpos); $posold = $Qlivtime.$poscript; if(self::$dataval) $posold .= "_\n"; else $posold .= "\n"; $poscript++; w($keyperpos,$poscript); if($poscript > $Qmaxtime[$Qlivtime] && $Qlivtime < 6){ $y = dirname($Qdatabase).'/Qconfig.php'; $x = file($y); $Qlivtime++; $x[8] = '$Qlivtime = '.$Qlivtime.";\n"; file_put_contents($y,$x); } return $posold; }
    protected static function crea($keyper, $val, $opz=0, $type=0, $stat=0, $db=0) { global $Qprotezione; $hash = $val; if($opz) { $keyperid = $keyper.'/id.php'; if(!file_exists($keyperid)){ if(!is_dir($keyper)) mkdir($keyper,0755); file_put_contents($keyperid,1); } $id = r($keyperid); $hash = Qhash($id); $id++; w($keyperid,$id); } $keyper = SYS::m($keyper,$hash); $keyindex = SYS::ix($keyper); $Qdb = new SYS; if($type) return $Qdb->_scrivi($keyper, SYS::time(), "\n", 0, $val."\n", 0, $stat, 0, $db); else { if($opz) return $Qdb->_scrivi($keyper, $val, "\n", 1); else return $keyindex; }}
    protected static function creamodir($mod, $per, $perass, $dirass, $ora) { global $Qdatabase; $dir = $Qdatabase; foreach($dirass as $f) $dir .= '/'.$f; $dir .= '/@'; SYS::ix($dir); foreach($perass as $f) { $dir .= '/'.$f; SYS::ix($dir); } $md = explode('.',$mod); $per = SYS::lh($per,Qhash($md[0])); $mk = file("$per/keys.php"); $ml = file("$per/link.php"); $n = 1; for($a=2; $a<count($mk); $a++) { $per = $dir; if(strlen($ml[$a]) < 64) { $e = explode('.',rtrim($mk[$a])); $per .= '/.'.$e[0]; SYS::ix($per); for($f=1; $f<count($e); $f++) { $per .= '/'.$f; SYS::ix($per); } self::Querin($per, SYS::val($ml[$a]), $ml[$a], $ora.$mod."\n"); } else { $dirass = $Qdatabase.'/@'; $e = explode('.',$mk[$a]); $dirass .= '/'.$e[0]; $per .= '/.'.$e[0]; SYS::ix($per); for($f=1; $f<(count($e)-1); $f++) { $dirass .= '/'.$f; $per .= '/'.$f; SYS::ix($per); } $dirass = SYS::lh($dirass,Qhash($md[$n])); $n++; $fk = file($dirass.'/keys.php'); $fl = file($dirass.'/link.php'); for($b=2; $b<count($fk); $b++) { if(strlen($fl[$b]) < 64) { $p = $per; $e = explode('.',rtrim($fk[$b])); $p .= '/.'.$e[0]; SYS::ix($p); for($f=1; $f<count($e); $f++) { $p .= '/'.$f; SYS::ix($p); } self::Querin($p, SYS::val($fl[$b]), $fl[$b], $ora.$mod."\n"); }}}}}
    protected static function creamodello($per, $fi, $fk=false, $fl=false) { global $Qprotezione; global $Qlivtime; $m = substr($fi[2],8-$Qlivtime,$Qlivtime+2); $km = "$per/m/m$m.php"; $str = rtrim($fi[2]); if($fk){ for($a=2; $a<count($fl); $a++) if(strlen($fl[$a]) < 64) $str .= rtrim($fl[$a]); } $str .= "\n"; $mod = 0; if(file_exists($km)){ $fp = file($km); $mod = array_search($str,$fp); } else { SYS::ix("$per/m"); SYS::ix("$per/p"); w($km,$Qprotezione); w("$per/p/p$m.php",$Qprotezione); } if(!$mod){ $ky = "$per/index.php"; $fp = file($ky); $mod = (int)$fp[2] + 1; $b = SYS::m($per,Qhash($mod)); if(!is_dir($b)) mkdir($b,0755); w("$b/index.php", $fi); if($fk) { w("$b/keys.php", $fk); w("$b/link.php", $fl); } w($ky,$Qprotezione.$mod); a($km,$str); a("$per/p/p$m.php",$mod."\n"); } else { $ok = false; $fp= file("$per/p/p$m.php"); $mod = rtrim($fp[$mod]); if($fl){ $ky = $per; $per = SYS::lh($per,Qhash($mod)); $keyk = "$per/keys.php"; $keyl = "$per/link.php"; if(file_exists($keyk)){ $mk = file($keyk); $ml = file($keyl); } else { $mk[0] = $fk[0]; $ml[0] = $fl[0]; $mk[1] = $fk[1]; $ml[1] = $fl[1]; } for($a=2; $a<count($fl); $a++) { if(strlen($fl[$a]) > 64) { $j = array_search($fl[$a],$ml); if($j < 2) { $mk[] = $fk[$a]; $ml[] = $fl[$a]; $ok = true; }}} if($ok) { w($keyk,$mk); w($keyl,$ml); }}} return $mod; }
    protected static function keytab($per, $pos, $opz=0) { global $Qdatabase; global $Qprotezione; $keyper = $Qdatabase; $lnk = ''; if($opz > 1000) $keyper .= '/@'; foreach($per as $a) { $keyper .= '/'.$a; $lnk .= $a.'.'; } $linkphp = "$keyper/keys.php"; $linkpos = "$keyper/keyn.php"; SYS::protezione($linkphp,$linkpos); $lnk = substr($lnk, 0, -1).'#'.$pos; $lk = file($Qdatabase.'/link.php'); $j = array_search($lnk,$lk); if($j < 2) a($Qdatabase.'/link.php',$lnk); $fp = file($linkphp); $j = array_search($pos,$fp); if($j > 1) { $fl = file($linkpos); $fl[$j] = ((int)$fl[$j] + 1)."\n"; w($linkpos, $fl); return true; } a($linkphp,$pos); a($linkpos,"1\n"); return true; }
    protected static function Querin($keyper, $chiaro, $criptato, $index){ global $Qprotezione; if($criptato[strlen($criptato)-2] == '_') $chiaro = SYS::dataval($chiaro); else $chiaro = mb_strtolower(trim($chiaro),'UTF-8'); $QprcNum = SYS::prcnumber(); $key = $keyper; $keyper = SYS::m($keyper,Qhash($chiaro)); SYS::ix($keyper); $keyperindex = "$keyper/index.php"; $keyper .= '/idem.php'; SYS::protezione($keyper); $fp = file($keyper); if(count($fp) < $QprcNum) a($keyper,$index); else { $fp = SYS::cancella($fp,2); $fp[] = $index; w($keyper,$fp); } $fp = file($keyperindex); if(isset($fp[2])) $fp[2]++; else $fp[2] = 1; w($keyperindex,$fp); $f = SYS::trak($chiaro); $s = $f[0][0]; $str[0] = $f[0]; $a = 0; for($b=1; $b<count($f); $b++) { if($s == $f[$b][0]) $str[$a] .= $f[$b]; else { $dir[] = Qord($str[$a]); $a++; $s = $f[$b][0]; $str[$a] = $f[$b]; }} $dir[] = Qord($str[$a]); for($a=0; $a<count($dir); $a++) { $keyperindex = $key.'/'.$dir[$a].'/index.php'; $ftraccia = $key.'/'.$dir[$a].'/keyt.php'; $fstato = $key.'/'.$dir[$a].'/stat.php'; $fcript = $key.'/'.$dir[$a].'/keyc.php'; $findex = $key.'/'.$dir[$a].'/keyi.php'; if(!file_exists($keyperindex)){ if(!is_dir($key.'/'.$dir[$a])) mkdir($key.'/'.$dir[$a],0755); w($keyperindex,$Qprotezione); } if(!file_exists($ftraccia)){ w($ftraccia,$Qprotezione); w($fstato,$Qprotezione); w($fcript,$Qprotezione); w($findex,$Qprotezione); } $ftr = file($ftraccia);
        if(count($ftr) < $QprcNum) { a($ftraccia,$str[$a]."\n"); a($fstato,"0\n"); a($fcript,$criptato); a($findex,$index); } else { $fts = file($fstato); $ftc = file($fcript); $fti = file($findex); $min = 9999999999; $pos = 0; for($b=2; $b<count($fts); $b++) { if($fts[$b] == 0) { $pos = $b; break; } else if($fts[$b] < $min) { $min = $fts[$b]; $pos = $b; }} $ftr = SYS::cancella($ftr,$pos); $fts = SYS::cancella($fts,$pos); $ftc = SYS::cancella($ftc,$pos); $fti = SYS::cancella($fti,$pos); $ftr[] = $str[$a]."\n"; $fts[] = "0\n"; $ftc[] = $criptato; $fti[] = $index; w($ftraccia,$ftr); w($fstato,$fts); w($fcript,$ftc); w($findex,$fti); }} if(is_numeric($chiaro)) { $keyperindex = "$key/list.php"; if(!file_exists($keyperindex)) { w($keyperindex,$Qprotezione.$chiaro.'#'.$chiaro."#1\n"); w("$key/v2.php",$Qprotezione.$chiaro."\n"); w("$key/n2.php",$Qprotezione."1\n"); } else { $fp = file($keyperindex); $f = explode('#',$fp[2]); if($chiaro < $f[0]) { $f[2] = (int)$f[2] + 1; if($f[2] == 1 && !isset($fp[3])) { $fp[2] = $chiaro.'#'.$chiaro."#1\n"; $fv = $Qprotezione.$chiaro."\n"; $fn = $Qprotezione."1\n"; } else { $fp[2] = $chiaro.'#'.$f[1].'#'.$f[2]."\n"; $fv = file("$key/v2.php"); $fn = file("$key/n2.php"); array_splice($fv, 2, 0, $chiaro."\n"); array_splice($fn, 2, 0, "1\n"); } w("$key/v2.php",$fv); w("$key/n2.php",$fn); } else { $pos = count($fp); $min = $pos - 1; $f = explode('#',$fp[$min]); 
        if($chiaro > $f[1]) { $f[2] = (int)$f[2] + 1; if($f[2] == 1) { $fp[2] = "$chiaro#$chiaro#1\n"; w("$key/v2.php",$Qprotezione.$chiaro."\n"); w("$key/n2.php",$Qprotezione."1\n"); } else { if($f[2] > $QprcNum) { $fp[$pos] = $f[1]."#$chiaro#1\n"; w("$key/v$pos.php",$Qprotezione.$chiaro."\n"); w("$key/n$pos.php",$Qprotezione."1\n"); } else { $fp[$min] = $f[0].'#'.$chiaro.'#'.$f[2]."\n"; a("$key/v$min.php",$chiaro."\n"); a("$key/n$min.php","1\n"); }}} else { for($a=2; $a<$pos; $a++) { $f = explode('#',$fp[$a]); if($chiaro >= $f[0] && $chiaro <= $f[1]) { $f[2] = (int)$f[2] + 1; $fp[$a] = $f[0].'#'.$f[1].'#'.$f[2]."\n"; $fn = file("$key/n$a.php"); $fv = file("$key/v$a.php"); $j = array_search($chiaro."\n",$fv); if($j > 1) { $fn[$j] = ((int)$fn[$j] + 1)."\n"; w("$key/n$a.php",$fn); } else { $s = SYS::ordina($chiaro, $fv); array_splice($fv, $s, 0, $chiaro."\n"); array_splice($fn, $s, 0, "1\n"); w("$key/v$a.php",$fv); w("$key/n$a.php",$fn); } break; }}}} w($keyperindex,$fp); }}}
    protected static function Qarrin($hash, $aln, $aper, $fp, $y, $perass, $index){ $Qlog = $hash.'/'.rtrim($aper).'.php'; SYS::protezione($Qlog); a($Qlog,$y); $e = explode('.',rtrim($fp)); $perass .= '/.'.$e[0]; SYS::ix($perass); for($f=1; $f<count($e); $f++) { $perass .= '/'.$e[$f]; SYS::ix($perass); } self::Querin($perass, $aln, $y, $index); }
    protected static function Qarray($akt, $alt, $lnk, $linkphp, $linkpos, $keyass, $valass, $keyperindex, $keyperpos, $ora, $index, $perass, $hash, $keyper){ global $Qdatabase; global $Qpassword; global $Qlivtime; $msgkeys = ''; $msgcript = ''; $msglink = ''; $z = 0; $n = 2; $aper = false; $si = false; $ak = array(); $al = array(); $id = array(); $dv = array(); $ok = array(); $poscript = r($keyperpos); $Qdb = new SYS; for($a=0; $a<count($alt); $a++) { $alt[$a] = SYS::speciali($alt[$a],1); if($alt[$a] != '') { if($akt[$a][0] == '!') { $ak[] = substr($akt[$a],1); $id[] = false; } else { $ak[] = $akt[$a]; $id[] = true; } $al[] = $alt[$a]; }} for($a=0; $a<count($ak); $a++) { SYS::$dataval = false; if($ak[$a][0] == '#') { if(!is_array($al[$a])) $al[$a] = array($al[$a]); if($ak[$a] == "#$keyass" && in_array($valass,$al[$a])) return false; $b = SYS::combina(substr($ak[$a], 1)); if($b) { $aper[$n] = $b[0].".0\n"; $aln[$n] = $al[$a]; $ak[$n-2] = $ak[$a]; $dv[$n-2] = false; $alnk[$n] = $lnk.'#'.$aper[$n]; $n++; }} else { $b = SYS::combina($ak[$a],1); if($b) { $aper[$n] = $b; $aln[$n] = $al[$a]; $ak[$n-2] = $ak[$a]; $dv[$n-2] = SYS::$dataval; $alnk[$n] = $lnk.'#'.$b; if($id[$a]) $ok[$n] = true; else $ok[$n] = false; $n++; }}} SYS::$dataval = false;
        if($aper && file_exists($linkphp)){ $fp = file($linkphp); $fi = file($linkpos); for($x=2; $x<count($fp); $x++) { $j = array_search($fp[$x], $aper); if($j > 1) { if(is_array($aln[$j])) { $msglink .= $fi[$x]; $aln[$j] = SYS::u($aln[$j]); if(SYS::isnumber($valass)) { foreach($aln[$j] as $val) if(self::Qdbin(substr($ak[$j-2],1).'#'.$keyass,$valass,$val,0,1)) $si = true; } else { if(self::Qdbin($keyass.$ak[$j-2],$aln[$j],$valass,0,1)) $si = true; }} else { if($aln[$j] == 'false') $y = $ora."f\n"; elseif($aln[$j] == 'true') $y = $ora."t\n"; else { $Qdb->orapos($ora); $y = $Qdb->orapsw.$Qlivtime.$poscript; if($dv[$j-2]) $y .= "_\n"; else $y .= "\n"; $msgcript .= Qcrypt($aln[$j].$Qdb->orapsw, $Qpassword[$Qdb->pospsw])."\n"; $poscript++; } $msglink .= $y; if(SYS::keyvalass($keyass, $valass, explode('.',rtrim($fp[$x])), 1, $y)) $si = true; if($ok[$j]) self::Qarrin($hash, $aln[$j], $aper[$j], $fp[$x], $y, $perass, $index); }} else $msglink .= $fi[$x]; } $dif = array_diff($aper, $fp); if($msgcript) { w($keyperpos,$poscript); self::sy($keyper,$msgcript); file_put_contents($keyperindex,$msgcript,FILE_APPEND); $msgcript = ''; } if($msglink) { global $Qprotezione; w($linkpos,$Qprotezione.$msglink); $msglink = ''; }} else $dif = $aper;
        if($dif) $difk = array_keys($dif); else $difk = false; if($difk) { $l = str_replace('.', '/', $lnk); $filekeys = "$Qdatabase/$l/keys.php"; $filekeyn = "$Qdatabase/$l/keyn.php"; $msg_keys = ''; $msg_link = ''; SYS::protezione($filekeys,$filekeyn); $fs = file($filekeys); $fn = file($filekeyn); $lk = file("$Qdatabase/link.php"); foreach($difk as $x) { if(is_array($aln[$x])) { $afk[$z] = $ak[$x-2]; $afl[$z] = $aln[$x]; $z++; } else { if($aln[$x] == 'false') $y = $ora."f\n"; elseif($aln[$x] == 'true') $y = $ora."t\n"; else { $Qdb->orapos($ora); $y = $Qdb->orapsw.$Qlivtime.$poscript; if($dv[$x-2]) $y .= "_\n"; else $y .= "\n"; $msgcript .= Qcrypt($aln[$x].$Qdb->orapsw, $Qpassword[$Qdb->pospsw])."\n"; $poscript++; } $msglink .= $y; if($ok[$x]) self::Qarrin($hash, $aln[$x], $aper[$x], $aper[$x], $y, $perass, $index); $msgkeys .= $aper[$x]; $j = array_search($aper[$x], $fs); if($j > 1) $fn[$j] = ((int)$fn[$j] + 1)."\n"; else { $msg_keys .= $aper[$x]; $fn[] = "1\n"; } $j = array_search($alnk[$x], $lk); if($j < 2) $msg_link .= $alnk[$x]; }}
        if($msgcript) { $si = true; w($keyperpos,$poscript); self::sy($keyper,$msgcript); file_put_contents($keyperindex,$msgcript,FILE_APPEND); } w($filekeyn,$fn); SYS::protezione($linkphp,$linkpos); if($msglink) a($linkpos,$msglink); if($msgkeys) a($linkphp,$msgkeys); if($msg_keys) a($filekeys,$msg_keys); if($msg_link) a("$Qdatabase/link.php",$msg_link); } if($z) { for($a=0; $a<$z; $a++) { $afl[$a] = SYS::u($afl[$a]); if(SYS::isnumber($valass)) { foreach($afl[$a] as $val) if(self::Qdbin(substr($afk[$a],1).'#'.$keyass,$valass,$val,0,1)) $si = true; } else { if(self::Qdbin($keyass.$afk[$a],$afl[$a],$valass,0,1)) $si = true; }}} return $si;
    }
    protected static function Qdbin($keys=NULL, $val=NULL, $valass=NULL, $opz=0) { global $Qdatabase; global $Qprotezione; global $Qpassword; global $Qpostime; global $Qlivtime; global $keybase; $tdb = strlen($Qdatabase)+1; $ora = SYS::time(); $Qdb = new SYS;
        if(is_array($valass)) { $tmp = $val; $val = $valass; $valass = $tmp; } if(is_array($val)) { if(is_array($valass)) return SYS::error(1,4); if($valass == NULL && $keys[0] != '#') return false; } else { if($val === false || strtolower($val) == 'false') { $val = (string)'false'; $Qdb->orapsw = $ora."f\n"; } elseif($val === true || strtolower($val) == 'true') { $val = (string)'true'; $Qdb->orapsw = $ora."t\n"; } elseif($val == 0) $val = (string)$val; $valass = SYS::speciali($valass,1); $posizione = true; $poscript = false; $ind = false; } 
        if(strpos($keys, ' ') > 1) { $ky = explode(' ', $keys, 2); if(!isset($ky[1][1])) return false; if($ky[1][0] == '!') { $key = substr($ky[1],1); $ind = $keys; $keys = $ky[0].' '.$key; } else $key = $ky[1]; $keyass = $ky[0]; if($val != '') $vals = $val; else return false; if($key[0] == '#') return self::Qdbin($keyass.$key,$val,$valass,$opz); if($keyass[0] == '@') { $dati[$key] = $val; return self::Qdbin($keyass,$dati,$valass); } if($valass == NULL) return false; $perass = SYS::combina($keyass); if(!$perass) return false; $hashpos = SYS::hashpos(Qhash($valass), $perass); if(!file_exists("$hashpos/index.php")) return SYS::error(1,5,$keyass); $fpi = file("$hashpos/index.php"); } 
        else { $key = $keys; $keyass = 0;
            if($key[0] == '#') { if(strpos($key,',') > 1) { $vls = explode(',',$key); $a = self::Qdbin($vls[0],NULL,NULL,997); if($a) { $tmp = explode('#',$a); for($a=1; $a<count($vls); $a++) { if($vls[$a]) { $pos = self::Qdbin($vls[$a],NULL,$tmp[1],996); if($tmp[0] != $pos) { if($pos) $Qdb->_del(substr($vls[$a],1),$pos,0,999); for($b=$a-1; $b>-1; $b--) $Qdb->_del(substr($vls[$b],1),$tmp[0],0,999); return false; }}} return $tmp[0]; } return false; } //   $tmp[0] = posizione   $tmp[1] = orapsw  *****  Qdb::in('#foto.mattina,#foto.pomeriggio,#foto.sera')
                if(is_array($val)) { $posizione = self::Qdbin($key); $key = substr($key,1); if(self::Qdbin($key, $val, $posizione)) return $posizione; else return false; } $key = substr($key,1); $per = SYS::combina($key,2); if(!$per) return false; if($opz != 996) { if($val != NULL || $valass != NULL) SYS::error(1,8,$key); } if($val == NULL) { $per .= '/id.php'; $id = r($per); $id++; require_once 'Qver.php'; while($Qdb->_ver($key,$id)) $id++; if($opz == 996) $posizione = self::Qdbin($key,$id,$valass,996); elseif($opz == 997) $posizione = self::Qdbin($key,$id,NULL,997); else { if(self::Qdbin($key,$id)) $posizione = $id; else $posizione = false; } if($posizione) { w($per,$id); return $posizione; } else return false; }
            } else {
                if($key[0] == '@') { if($valass == NULL) return SYS::error(1,9,$key); $key = substr($key, 1); $n = 0;
                    if(is_array($val)) { $ak = array_keys($val); $al = array_values($val); 
                        for($a=0; $a<count($ak); $a++) { if($ak[$a][0] == '#') $ak[$a] = substr($ak[$a],1); if(is_numeric($ak[$a])) return SYS::error(1,10); $per = SYS::combina($ak[$a]); if($per) { $hash = SYS::hashpos(Qhash($al[$a]), $per); $hashindex[$n] = "$hash/index.php"; if(file_exists($hashindex[$n])) { $hashkeys[$n] = "$hash/keys.php"; $hashlink[$n] = "$hash/link.php"; $hashstat[$n] = "$hash/stat.php"; $plk[$n] = ''; foreach($per as $b) $plk[$n] .= $b.'.'; $plk[$n] .= "0\n"; $tper[$n] = $per; $n++; } else SYS::error(1,11,$ak[$a]); }}
                    } if(!$n) return false; $valass = base64_decode($valass); $m = '';
                    if(strpos($valass, '@')) { $l = explode('@',$valass); if(!isset($l[5])) return false; $perass = SYS::combina($key); if(!$perass) return false; foreach($perass as $a) $m .= '/'.$a; $mr = $Qdatabase.'/@'.$m; $msg = '1'.$m.'/'; $q = explode('.',$l[3]); $ky = explode('.',$l[2]); array_pop($ky); $dir = $Qdatabase.$m.'/'.$l[2].'/c'.$q[0].'.php'; if(strstr($l[1], $msg)) { $v = explode('.',$l[0]); $pos = $Qdatabase.'/'.$l[1].'/v'.$v[0].'.php'; if(!file_exists($pos)) return false; $si = false; $vv = false; $tmp = explode('/',$l[1]); $e = $tmp[1]; $b = 901; for($a=2; $a<(count($tmp)-$Qlivtime-1); $a++) { $e .= '.'.$tmp[$a]; $b++; } $fp = file($pos); for($w=0; $w<$n; $w++) { $x = rtrim($fp[$v[1]]); if(strpos($x, '.')) { $y = explode('.', $x); $z = $y[0]; } else { $y = 0; $z = $x; } $fi = file($hashindex[$w]); $fi[3] = $al[$w]."\n"; $m = SYS::lh($mr,Qhash($z)); $poskeys = $m.'/keys.php'; $poslink = $m.'/link.php';
                        if(file_exists($poskeys)) { $fk = file($poskeys); $keyper = $Qdatabase.'/@'; $j = array_search($plk[$w], $fk); if($j > 2) { foreach($tper[$w] as $a) { $keyper .= '/'.$a; SYS::ix($keyper,1); } if(file_exists($hashkeys[$w])) { $fk = file($hashkeys[$w]); $fl = file($hashlink[$w]); if(file_exists($hashstat[$w])) { $fs = file($hashstat[$w]); for($c=2; $c<count($fs); $c++) if($fs[$c] == "0\n") { $fk = SYS::cancella($fk,$c); $fl = SYS::cancella($fl,$c); }} $mod = self::creamodello($keyper, $fi, $fk, $fl); } else $mod = self::creamodello($keyper, $fi); $i = 0; $fl = file($poslink); for($a=2; $a<count($fl); $a++) if(strlen($fl[$a]) > 64) { $i++; if($a == $j) { $z .= '.'.$mod; if($mod != $y[$i]) { $si = true; self::Qdbin($ak[$i-1].'#'.$e.'.'.$l[2],$l[4],$al[$i-1],$b,1); if($y[$i] > 0) { if(!$vv) { $id = file(SYS::lh($keyper,Qhash($y[$i])).'/index.php'); $vv = rtrim($id[3]); } if($vv) $Qdb->_del($ak[$i-1].'#'.$e.'.'.$l[2],$l[4],$vv,$b+100); }}} else { if($y) $z .= '.'.$y[$i]; else $z .= '.0'; }} $fp[$v[1]] = $z."\n"; }}} if($si) { $fx = file($dir); $fx[$q[1]] = $fp[$v[1]]; w($dir,$fx); w($pos,$fp); if(self::Qdbin($e,$z,NULL,998)){ $Qdatabase = substr($Qdatabase,0,-2); self::Qdbin($e.'#'.$l[2],$l[4],$z,1000+$l[5],1); self::creamodir($z,$mr,$perass,$ky,$ora); } if($vv) $Qdb->_del('@.'.$e.'.@#'.$l[2],$l[4],$x,1971); return true; }}} return false;
                    } if(strpos($keys, '@') > 1) { $ky = explode('@',$keys,2); if(is_array($opz)) { $id = self::Qdbin($keys,$val,$valass); if($id) return self::Qdbin('@'.$ky[1],$id,$opz); else return false; } $key = $ky[1]; $keyass = $ky[0]; if($val == NULL) return SYS::error(1,11,$keyass); if($valass == NULL) return SYS::error(1,11,$key); $per = SYS::combina($key); 
                        if($per) { $perass = SYS::combina($keyass);
                            if($perass) { if(!is_numeric($val) || strstr($val,'.')) return SYS::error(1,12,$key); $hash = SYS::hashpos(Qhash($val), $per); $hashindex = "$hash/index.php"; $hashkeys = "$hash/keys.php"; $hashlink = "$hash/link.php"; $hashstat = "$hash/stat.php";
                                if(file_exists($hashindex)){ $hashpos = SYS::hashpos(Qhash($valass), $perass); $indexpos = "$hashpos/index.php"; 
                                    if(file_exists($indexpos)){ $linkphp = "$hashpos/keys.php"; $linkpos = "$hashpos/link.php"; $keyper = "$Qdatabase/@"; $keyper1 = "$Qdatabase/1"; $keyperc = $Qdatabase; $plk = ''; SYS::protezione($linkphp,$linkpos); foreach($per as $corso) { $plk .= $corso.'.'; $keyper .= '/'.$corso; $keyper1 .= '/'.$corso; $keyperc .= '/'.$corso; SYS::ix($keyper1); SYS::ix($keyper,1); } $fx = file($indexpos); $fi = file($hashindex); $corso = $keyperc; $keyperc .= '/keyc.php'; $fi[3] = $val."\n"; $plp = $plk; $plk .= "1\n"; if(file_exists($hashkeys)) { $fk = file($hashkeys); $fl = file($hashlink); if(file_exists($hashstat)) { $fs = file($hashstat); for($c=2; $c<count($fs); $c++) if($fs[$c] == "0\n") { $fk = SYS::cancella($fk,$c); $fl = SYS::cancella($fl,$c); }} $mod = self::creamodello($keyper, $fi, $fk, $fl); } else $mod = self::creamodello($keyper, $fi); $fk = file($linkphp); $j = array_search($plk, $fk); 
                                        if($j > 1) { $fl = file($linkpos); $pos = $Qdb->_scrivi($Qdatabase.'/'.rtrim($fl[$j]) ,$ora ,"\n" ,0 ,$mod."\n" ,0 ,1).'@'.rtrim($fl[$j]); } else { $keyper = self::crea($keyper1, $mod, 1, 1); $msg = substr($keyper,$tdb); a($linkphp,$plk); a($linkpos,$msg."\n"); $pos = '2.2@'.$msg; } $keyper = $Qdatabase.'/'.$perass[0]; $msg = $perass[0]; for($a=1; $a<count($perass); $a++) { $keyper .= '/'.$perass[$a]; $msg .= '.'.$perass[$a]; } $lnk = $msg.'#'.$plk; $dir = $msg.'.1'; $msg = $msg."\n"; SYS::protezione($keyperc); $linkphp = "$keyper/keys.php"; $linkpos = "$keyper/keyn.php"; $corso .= '/'.$dir; $fp = file($keyperc); $j = array_search($msg, $fp); if($j < 2) { a($keyperc,$msg); SYS::ix($corso); } SYS::protezione($linkphp,$linkpos); $f = $Qdb->_scrivi($corso ,$ora ,"\n" ,0 ,$fx[2] ,$mod, 1); $fp = file($linkphp); $j = array_search($plk,$fp);
                                        if($j > 1) { $fl = file($linkpos); $fl[$j] = ((int)$fl[$j] + 1)."\n"; w($linkpos,$fl); } else { a($linkphp,$plk); a($linkpos,"1\n"); } $k = explode('@',$pos); $p = explode('.',$f); $plp .= $p[0]."\n"; $keyperc = $Qdatabase.'/'.$k[1].'/keyc.php'; SYS::protezione($keyperc); $fp = file($keyperc); $j = array_search($plp,$fp); if($j < 2) a($keyperc,$plp); $lk = file($Qdatabase.'/link.php'); $j = array_search($lnk,$lk); if($j < 2) a($Qdatabase.'/link.php',$lnk); return base64_encode($pos.'@'.$dir.'@'.$f.'@'.base64_encode($valass).'@'.$val);
                                    } else return SYS::error(1,5,$keyass);
                                } else return SYS::error(1,5,$key);
                            }
                        }
                    } if(strpos($keys, '#') > 1) { if($val == NULL) return false; $ky = explode('#', $keys, 2); $key = $ky[1]; $keyass = $ky[0]; if($keyass == $key && $valass == $val) return false; $valtmp = array(); $n = 0; if($opz > 900) { $per = explode('.',$key); array_pop($per); $val = base64_decode($val); $keyper = $Qdatabase; if($opz > 1000) { $perass = explode('.', $keyass); $perass[] = '@'; } else foreach($per as $p) { $keyper .= '/'.$p; SYS::ix($keyper); }} else $per = SYS::combina($key);
                        if($per) { if($opz < 1001) $perass = SYS::combina($keyass);
                            if($perass) { $nick = 0; $valok = false; $b = false; $c = false;
                                if(is_array($val)) { if($opz == 666) return false; if($keyass == $key && in_array($valass,$val)) return false; $val = SYS::u($val); foreach($val as $a) if(SYS::isnumber($a)) $b[] = $a; else $c[] = $a;
                                    if($c) { if($b) return false; if(!$opz) { foreach($c as $a) if(self::Qdbin($key.'#'.$keyass,$valass,$a)) $b = true; return $b; } foreach($c as $a) { $hash = SYS::hashpos(Qhash($a), $per).'/index.php'; if(file_exists($hash)) { $fp = file($hash); $valok[$n] = '#'.rtrim($fp[2]); $valtmp[$n] = $a; $n++; $nick = 998; }}} else { if($b) foreach($b as $a) { $hash = SYS::hashpos(Qhash($a), $per).'/index.php'; if(file_exists($hash)) { $valok[$n] = $a; $n++; }}}
                                } else { if(!$opz) { if(SYS::isnumber($val)) { $hash = SYS::hashpos(Qhash($val), $per).'/index.php'; if(file_exists($hash)) { $valok[0] = $val; $n = 1; }} else { if(SYS::isnumber($valass)) return self::Qdbin($key.'#'.$keyass,$valass,$val); $hash = SYS::hashpos(Qhash($val), $per).'/index.php'; if(file_exists($hash)) { $fp = file($hash); $valok[0] = '#'.rtrim($fp[2]); $valtmp[0] = $val; $n = 1; $nick = 998; }}
                                    } else { if($opz == 666) { $Qdb->orapos($ora); $valok[0] = '#'.$this->orapsw.rtrim(self::fs($val,$Qdb->orapsw,$Qpassword[$Qdb->pospsw])); $n = 1; $nick = 998; $opz = 999; } else { if($opz > 900 && $opz < 1001) { $p = $per; for($a=900; $a<$opz; $a++) $p = SYS::cancella($p,0); $hash = SYS::hashpos(Qhash($val),$p).'/index.php'; } else $hash = SYS::hashpos(Qhash($val),$per).'/index.php'; if(file_exists($hash)) { $fp = file($hash); $valok[0] = '#'.rtrim($fp[2]); $n = 1; $nick = 998; }}}
                                } if(!$n) return false; $hashpos = SYS::hashpos(Qhash($valass),$perass,$opz); $keyper = $Qdatabase; $b = $Qdatabase.'/0'; $indexpos = $hashpos.'/index.php'; $vals = $val; $pos = '';
                            if(file_exists($indexpos)){ $linkphp = "$hashpos/keys.php"; $linkpos = "$hashpos/link.php"; if(!file_exists($linkphp)){ w($linkphp,$Qprotezione); w($linkpos,$Qprotezione); if($opz > 1000) { $tmp = $opz - 1000; a($indexpos,$tmp."\n"); }} foreach($per as $a) { $pos .= $a.'.'; $keyper .= '/'.$a; $b .= '/'.$a; SYS::ix($b); } $s = $pos; $pos .= "0\n"; $fk = file($linkphp); $q = array_search($pos, $fk);
                            if($q > 1) { $fl = file($linkpos); $dir = $Qdatabase.'/'.rtrim($fl[$q]); $n = 0; $vals = false;
                                foreach($valok as $val) { if($nick != 998) { if($opz < 901 && SYS::leggi($dir, $val."\n")) SYS::error(1,7,$val,$valass,$key,$keyass); else { $tmp = $Qdb->_scrivi($dir,$ora,"\n",0,$val."\n",0,2,1); if($tmp < 0) { if(SYS::isnumber($val) && SYS::isnumber($valass)) return self::Qdbin($key.'#'.$keyass,$valass,$val); else return SYS::error(1,6,$keys); } elseif($tmp) { a($dir.'/log.php',$ora.$val."\n"); if(self::keytab($perass,$pos,$opz)) { $vals[$n] = $val; $n++; }} else return false; }
                                    } else { if($opz < 901 && SYS::leggi($dir, $val."\n", 0, 1)) SYS::error(1,7,$val,$valass,$key,$keyass); else { $tmp = $Qdb->_scrivi($dir,$ora,"\n",0,$val."\n",0,2,1,1); if($tmp < 1) return SYS::error(1,6,$keys); elseif($tmp) { a($dir.'/log.php',$ora.$val."\n"); if(self::keytab($perass,$pos,$opz)) { $vals[$n] = $val; $n++; }} else return false; }}
                                } if($n) { if($opz == 999) return true; $msg = '/'.$perass[0]; for($a=1; $a<count($perass); $a++) $msg .= '.'.$perass[$a]; $msk = $keyper.$msg.'.0'; $dir .= '/keyp.php'; if(!file_exists($dir) || !file_exists($indexpos)) return false; $fp = file($indexpos); $fi = file($dir); $f = explode('.',$fi[2]); $k = rtrim($f[count($f)-1]); $l = $msk.'/v'.$k.'.php'; if(!file_exists($l)) return false; $fop = file($l); $y = array_search($fp[2],$fop);
                                    if($y > 1) { $p = $msk.'/'.$k.'.php'; if(!file_exists($p)) return false; $ftp = file($p); $fop = SYS::cancella($fop,$y); $ftp = SYS::cancella($ftp,$y); w($p,$ftp); w($l,$fop); $Qdb->_elimina($msk, $k, 2); $f = $Qdb->_scrivi($msk,$ora,"\n",0,$fp[2],0,0,1); w($dir, $Qprotezione.$s.$f."\n"); if($nick == 998) { if(!$opz) { foreach($valtmp as $v) self::Qdbin($key.'#'.$keyass,$valass,$v,1); } return true; } else { if(!$opz) { if(is_array($vals)) { foreach($vals as $v) self::Qdbin($key.'#'.$keyass,$valass,$v,1); } else self::Qdbin($key.'#'.$keyass,$valass,$vals,1); } return true; }}
                                } else return false;
                            } else { if($nick != 998) $dir = self::crea($b,$valok[0],1,1,2); else $dir = self::crea($b,$valok[0],1,1,2,1); w($dir.'/log.php',$Qprotezione.$ora.$valok[0]."\n"); $msg = substr($dir,$tdb); a($linkphp,$pos); a($linkpos,$msg."\n"); $keyperp = $keyper.'/keyp.php'; $msk = $msg; $msg = $perass[0]; for($a=1; $a<count($perass); $a++) $msg .= '.'.$perass[$a]; $keyper .= '/'.$msg.'.0'; $msg .= "\n";
                                SYS::protezione($keyperp); $fp = file($keyperp); $j = array_search($msg, $fp); if($j < 2) { a($keyperp,$msg); SYS::ix($keyper); } $fi = file($indexpos); $f = $Qdb->_scrivi($keyper,$ora,"\n",0,$fi[2],0,0,1); $keyper = "$Qdatabase/$msk/keyp.php"; SYS::protezione($keyper); a($keyper,$s.$f."\n"); self::keytab($perass,$pos,$opz); if(isset($valtmp[0])) self::Qdbin($key.'#'.$keyass,$valass,$valtmp[0],1); }
                            if($nick == 998) { for($a=1; $a<count($valok); $a++) { $tmp = $Qdb->_scrivi($dir,$ora,"\n",0,$valok[$a]."\n",0,2,1,1);
                                if($tmp < 0) return false; /* vanno invertiti */ elseif($tmp) { a($dir.'/log.php',$ora.$valok[$a]."\n"); self::keytab($perass,$pos,$opz); if(isset($valtmp[$a])) self::Qdbin($key.'#'.$keyass,$valass,$valtmp[$a],1); }} return true;
                            } else { if(!$opz) self::Qdbin($key.'#'.$keyass,$valass,$valok[0],1); else if($opz < 1001) { $n = $hashpos.'/stat.php'; if(!file_exists($n)){ $b = $Qprotezione; for($a=2; $a<count($fk); $a++) $b .= "1\n"; $b .= "0\n"; w($n,$b); } else a($n,"0\n"); } $valok = SYS::cancella($valok,0); if($valok) return self::Qdbin($keys,$valok,$valass); } return true;
                        }
                    }
                } return false; }}
            } if($val == NULL) return SYS::error(1,11,$key); $kpr = $Qdatabase.$Qpostime;
        if(is_array($val)) { $ak = array_keys($val); foreach($ak as $a) if(is_numeric($a)) SYS::error(1,10); $per = SYS::combina($keys); if(!$per) return false; $hash = SYS::hashpos(Qhash($valass), $per); if(!file_exists("$hash/index.php")) $posizione = self::Qdbin($keys,$valass,NULL,995); else $posizione = false; $fpi = file("$hash/index.php"); $keyper = $kpr; $op0 = substr($ora,0,3); $op1 = substr($ora,3,$Qlivtime); $keyper .= '/'.$op0; SYS::ix($keyper); $keyper .= '/'.$op1; $keyperindex = SYS::ix($keyper); $keyperpos = "$keyper/id.php"; SYS::protezione($keyperpos,false,2); $linkphp = "$hash/keys.php"; $linkpos = "$hash/link.php"; $lnk = $per[0]; $pr = $Qdatabase.'/'.$per[0]; for($a=1; $a<count($per); $a++) { $lnk .= '.'.$per[$a]; $pr .= '/'.$per[$a]; } $al = array_values($val); if(self::Qarray($ak, $al, $lnk, $linkphp, $linkpos, $keys, $valass, $keyperindex, $keyperpos, $ora, $fpi[2], $pr, $hash, $keyper)) { if($posizione) return $posizione; else return true; } return false; } if($opz == 998) { $per = explode('.',$key); $per[] = '@'; $Qdatabase .= '/@'; $keyper = $Qdatabase; foreach($per as $p) { $keyper .= '/'.$p; SYS::ix($keyper); }} else $per = SYS::combina($key);
        if($per) { if($opz != 996) { if($opz == 998) { $keyper = SYS::lh($keyper,Qhash($val)).'/index.php'; if(file_exists($keyper)) return true; } else { if(!$Qdb->orapsw) { require_once 'Qver.php'; if($Qdb->_ver($keys, $val, $valass)) return false; }} if(!$Qdb->orapsw) { if(SYS::isnumber($val)) $Qdb->orapsw = $ora.":$val\n"; else $Qdb->orapos($ora); }} $id = $val; $vhash = Qhash($val); $keyper = $Qdatabase; $lnk = ''; $pr = '';
            if(!$keyass) { foreach($per as $a) { $keyper .= '/'.$a; $pr .= $a.'.'; }
                if($valass != NULL && $opz != 996) { $nhashpos = SYS::hashpos(Qhash($val), $per); $nhashposi = "$nhashpos/index.php"; $files = scandir($nhashpos);
                    if(file_exists($nhashposi)) { $fi = file($nhashposi); $nhashposk = "$nhashpos/keys.php"; $nhashposl = "$nhashpos/link.php"; 
                        if(self::Qdbin($key, $valass)) { $npos = SYS::hashpos(Qhash($valass), $per); $nhashposi = "$npos/index.php"; $i = file($nhashposi); if(count($files) > 5) { $files = array_slice($files,2,-3); for($b=0; $b<count($files); $b++) copy($nhashpos.'/'.$files[$b],$npos.'/'.$files[$b]); }
                            if(file_exists($nhashposk)){ $fk = file($nhashposk); $fl = file($nhashposl); $nhashposk = "$npos/keys.php"; $nhashposl = "$npos/link.php"; w($nhashposk,$fk); w($nhashposl,$fl); 
                                for($b=2; $b<count($fl); $b++) {
                                    if(strlen($fl[$b]) > 64) { $f = explode('/', $fl[$b]); if($f[0] == 0) { $f1 = file($Qdatabase.'/'.rtrim($fl[$b]).'/keyp.php'); $g = explode('.', $f1[2]); $z = count($g)-1; $npos = $Qdatabase.'/'.$g[0].'/'; for($x=1; $x<$z; $x++) $npos .= $g[$x].'/'; $npos .= $pr.$f[0]; $r4 = $npos.'/v'.rtrim($g[$z]).'.php'; $f4 = file($r4); $j = array_search($fi[2], $f4); if($j > 1) { $r5 = $npos.'/'.rtrim($g[$z]).'.php'; $f5 = file($r5); $f4 = SYS::cancella($f4,$j); $f5 = SYS::cancella($f5,$j); w($r4,$f4); w($r5,$f5); $f6 = $Qdb->_scrivi($npos,$ora,"\n",0,$i[2],0,0,1); w($Qdatabase.'/'.rtrim($fl[$b]).'/keyp.php',$Qprotezione.$f[1].'.'.$f6."\n"); $npos .= '/in.php'; $g = r($npos); $g = explode('.',$g); $g[1]--; $g[2]--; w($npos,$g[0].'.'.$g[1].'.'.$g[2].'.'.rtrim($g[3])."\n"); }} elseif($f[0] == 1) { $f1 = file($Qdatabase.'/'.rtrim($fl[$b]).'/keyc.php'); $f2[0] = $fi[2]; for($x=2; $x<count($f1); $x++) { $msg = $Qdatabase; $g = explode('.', $f1[$x]); $z = count($g)-1; for($y=0; $y<$z; $y++) $msg .= '/'.$g[$y]; $msg .= '/'.$pr.'1/v'.rtrim($g[$z]).'.php'; $fp = file($msg); $f3 = array_intersect($fp,$f2); $f4 = array_keys($f3); foreach($f4 as $k) $fp[$k] = $i[2]; w($msg,$fp); }}}
                                } if($Qdb->_elimina($keyper, $fi[2]) == -1) $Qdb->_directory($keyper); $Qdb->_directory($nhashpos);
                            } else { $Qdb->_elimina($keyper, $fi[2]); $Qdb->_directory($nhashpos); } for($a=count($fi); $a>2; $a--) $fi[$a] = $fi[$a-1]; $keyper = $kpr.'/'.substr($fi[2], 0, 3).'/'.substr($fi[2], 3, $fi[2][12]); $keyv = "$keyper/keyv.php"; $keyn = "$keyper/keyn.php"; SYS::protezione($keyv,$keyn); a($keyv,$fi[2]); a($keyn,$i[2]); $fi[2] = $i[2]; w($nhashposi,$fi); return true; 
                        }
                    } return false;
                } $keyindex = self::crea($keyper, $vhash); if($opz != 996) { if($Qdb->orapsw[10] != ':' && $Qdb->orapsw[11] != "\n") $posold = self::fs($val,$Qdb->orapsw,$Qpassword[$Qdb->pospsw],$opz); else $posold = ''; } else { $Qdb->orapsw = $valass; $posold = "\n"; } a($keyindex,$Qdb->orapsw.$posold); $posizione = $Qdb->_scrivi($keyper,$Qdb->orapsw,$posold,0,0,0,0,2);
            } else { $linkphp = "$hashpos/keys.php"; $linkpos = "$hashpos/link.php"; SYS::protezione($linkphp); SYS::protezione($linkpos); $keyper = $Qdatabase.'/'.$perass[0]; $linkphpass = $per[0]; $lnk = $perass[0]; for($a=1; $a<count($perass); $a++) { $keyper .= '/'.$perass[$a]; $lnk .= '.'.$perass[$a]; } $lnk .= '#'.$per[0]; $keyper .= '/.'.$per[0]; SYS::ix($keyper); for($a=1; $a<count($per); $a++) { $keyper .= '/'.$per[$a]; $linkphpass .= '.'.$per[$a]; $lnk .= '.'.$per[$a]; SYS::ix($keyper); } $fp = file($linkphp); $a = array_search($linkphpass."\n", $fp); if($a > 1) { if($Qdb->_del($keys, $valass, 999)) { if($ind) return self::Qdbin($ind, $vals, $valass, 999); else return self::Qdbin($keys, $vals, $valass, 999); } else return false; } else { if($opz != 996) { if($Qdb->orapsw[10] != ':' && $Qdb->orapsw[11] != "\n") $posold = self::fs($val,$Qdb->orapsw,$Qpassword[$Qdb->pospsw]); else $posold = ''; } else { $Qdb->orapsw = $valass; $posold = "\n"; }} a($linkphp, $linkphpass."\n"); a($linkpos, $Qdb->orapsw.$posold); 
                if(!$ind) { $Qlog = "$hashpos/$linkphpass.php"; SYS::protezione($Qlog); a($Qlog, $Qdb->orapsw.$posold); self::Querin($keyper, $vals, $Qdb->orapsw.$posold, $fpi[2]); } if($opz != 999) { $keyper = SYS::combina($keyass,2); $linkphp = "$keyper/keys.php"; $linkpos = "$keyper/keyn.php"; SYS::protezione($linkphp,$linkpos); $fp = file($linkphp); $a = array_search($linkphpass."\n",$fp); if($a > 1) { $fl = file($linkpos); $fl[$a] = ((int)$fl[$a] + 1)."\n"; w($linkpos,$fl); } else { a($linkphp,$linkphpass."\n"); a($linkpos,"1\n"); } $lk = file("$Qdatabase/link.php"); $a = array_search($lnk."\n", $lk); if($a > 1) return true; a("$Qdatabase/link.php",$lnk."\n"); }
            } if($opz == 997) $posizione .= '#'.$Qdb->orapsw.rtrim($posold); return $posizione;
        } return false;
    }
}

?>
