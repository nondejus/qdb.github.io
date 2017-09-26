<?php

namespace Quantico;

class Qdel extends SYS
{
    protected static function delink($keyass, $key) { global $Qdatabase; $fp = file("$Qdatabase/link.php"); $link = rtrim(SYS::combina($keyass,1)).'#'.rtrim(SYS::combina($key,1)).".0\n"; $j = array_search($link,$fp); if($j > 1) { $fp = SYS::cancella($fp,$j); w("$Qdatabase/link.php",$fp); }}
    protected static function directory($dir, $opz=0, $dirdel=0, $ora=0, $id=0, $keydel=0, $linkdel=0) { if(is_dir($dir)) { $files = array_diff(scandir($dir), array('.','..','-0')); if($ora) { if(!is_dir($dirdel)) SYS::ix($dirdel); self::scrivi($dirdel, $ora, "\n", 0, $id); $id = $ora.rtrim($id); $a = substr($id,0,4); $b = substr($id,4,4); $c = substr($id,8,4); $d = substr($id,12); $dirdel .= "/$a"; if(!is_dir($dirdel)) SYS::ix($dirdel); $dirdel .= "/$b"; if(!is_dir($dirdel)) SYS::ix($dirdel); $dirdel .= "/$c"; if(!is_dir($dirdel)) SYS::ix($dirdel); $dirdel .= "/$d"; if(!is_dir($dirdel)) SYS::ix($dirdel); foreach($files as $file) { if(is_file("$dir/$file")) copy("$dir/$file","$dirdel/$file"); } if(is_array($keydel)) { a("$dirdel/keys.php",$keydel); a("$dirdel/link.php",$linkdel); }} foreach($files as $file) { (is_dir("$dir/$file")) ? self::directory("$dir/$file") : unlink("$dir/$file"); } if($opz) { global $Qprotezione; w("$dir/index.php",$Qprotezione); return true; } else return rmdir($dir); } else return false; }
    protected static function delete($fp, $fl, $x, $p, $pr, $keypery, $keyperl, $hashpos, $ora=0, $type=0) { global $Qdatabase; global $Qlivtime; if(count($fp) == 3) { unlink($keypery); unlink($keyperl); } else { $fp = SYS::cancella($fp,$x); $fl = SYS::cancella($fl,$x); w($keypery,$fp); w($keyperl,$fl); } $f1 = file("$hashpos/index.php"); $f2 = file("$p/keyp.php"); $f = explode('.', $f2[2]); $x = count($f)-1; $r4 = $Qdatabase.'/'; for($a=0; $a<$x; $a++) $r4 .= $f[$a].'/'; $r = $pr.'0'; $rf = rtrim($f[$x]); $r5 = "$r4$r/v$rf.php"; if(file_exists($r5)) { $f5 = file($r5); $j = array_search($f1[2], $f5); if($j > 1) { $f4 = file("$r4$r/$rf.php"); $f5 = SYS::cancella($f5,$j); $f4 = SYS::cancella($f4,$j); w($r5,$f5); w("$r4$r/$rf.php",$f4); if($ora) { $x = substr($p,strlen($Qdatabase)+3); $f = explode('/', $x); $pr = $ora.'-'.$f[0].'.'; for($a=1, $u=count($f)-$Qlivtime-1; $a<$u; $a++) $pr .= $f[$a].'.'; copy("$p/log.php",$hashpos.'/'.$pr.'0.php'); } self::elimina($r4.$r, $rf, 2); if($type != 888) self::directory($p); }}}
    protected static function mod2($db, $type, $QprcNum, $keyper, $orapsw) { if($db) $n = floor((int)substr($type,1,10)/$QprcNum); else $n = floor((int)substr($type,0,10)/$QprcNum); $filel = $keyper.'/l'.$n.'.php'; $filet = $keyper.'/t'.$n.'.php'; if(!file_exists($filel)) { global $Qprotezione; w($filel,$Qprotezione.$type); w($filet,$Qprotezione.$orapsw."\n"); } else { a($filel,$type); a($filet,$orapsw."\n"); }}
    protected static function scrivi($keyper, $orapsw, $posold, $opz=0, $type=0, $pos=0, $mod=0, $etc=0, $db=0) { global $Qprotezione; $keynum = "$keyper/in.php"; if(!file_exists($keynum)) file_put_contents($keynum,"2.0.0.0\n"); $kn = r($keynum); $kn = explode('.',$kn); $keypos = $keyper.'/'.$kn[0].'.php'; $kn[1]++; $kn[2]++; $kt = $kn[0]; $kp = $kn[1]; if($opz) { if($orapsw <= rtrim($kn[3])) return SYS::error(1,2,$orapsw); else $kn[3] = $orapsw; } $keycode = "$keyper/index.php"; if(is_readable($keycode)) $kc = file($keycode); else exit; $kcn = count($kc); $tipo = rtrim(substr($kc[1],-2)); if($tipo == '>') { if($type[0] == '#') $kc[1] = rtrim($kc[1])."2\n"; else $kc[1] = rtrim($kc[1])."1\n"; } elseif($tipo == 1 && $type[0] == '#') return -1; elseif($tipo == 2 && is_numeric($type[0])) return -2; $QprcNum = SYS::prcnumber();
        if($kn[1] == 1) { if($opz) $kc[$kcn] = $orapsw.'.'; else $kc[$kcn] = substr($orapsw, 0, 10).'.'; $msg = ''; for($x=0; $x<=$kcn; $x++) $msg .= $kc[$x]; w($keycode,$msg); w($keypos,$Qprotezione.$orapsw.$posold); if($type) { w($keyper.'/v'.$kn[0].'.php',$Qprotezione.$type); if($pos) a($keyper.'/c'.$kn[0].'.php',$Qprotezione.$pos."\n"); if($mod == 2) self::mod2($db,$type,$QprcNum,$keyper,$orapsw); }} else { SYS::protezione($keypos); a($keypos,$orapsw.$posold); if($type) { $keyv = $keyper.'/v'.$kn[0].'.php'; SYS::protezione($keyv); a($keyv,$type); if($pos) { $keyc = $keyper.'/c'.$kn[0].'.php'; SYS::protezione($keyc); a($keyc,$pos."\n"); } if($mod == 2) self::mod2($db,$type,$QprcNum,$keyper,$orapsw); } if($kn[1] > $QprcNum) { if($opz) $kc[$kcn-1] .= $orapsw.'.'.$kn[1]."\n"; else $kc[$kcn-1] .= substr($orapsw, 0, 10).'.'.$kn[1]."\n"; $kp = $kn[1]; $kn[0]++; $kn[1] = 0; $msg = ''; for($x=0; $x<$kcn; $x++) $msg .= $kc[$x]; w($keycode,$msg); }} w($keynum, $kn[0].'.'.$kn[1].'.'.$kn[2].'.'.rtrim($kn[3])."\n");
        if($mod == 1) { $kp++; return $kt.'.'.$kp; } if($etc == 1) return $kt; elseif($etc == 2) return $kn[2]; else { if($type == 1 && $opz == 1) return $kt; else return $keyper; }}
    protected static function elimina_adesso($file, $per, $ora, $opz=false) { $es = false; $file = file($file); for($a=2, $u=count($file); $a<$u; $a++) { $es = self::elimina($per, '#'.rtrim($file[$a]), 1, $ora); if($es) break; if($opz) { $es = self::elimina($p, rtrim($m[$a]), 1, $ora); if($es) break; }} return $es; }
    protected static function elimina($keyper, $val, $opz=0, $ora=0) { global $Qprotezione; $keyperin = "$keyper/in.php"; $keyperindex = "$keyper/index.php"; $fi = r($keyperin); if(!$fi) return SYS::error(3,0,$keyperin); $fk = file($keyperindex); $fine = count($fk)-1; $k[2] = 1; $y = 0; $del = []; 
        if($opz == 2) { $n = explode('.', $fk[$val]); $k = explode('.',$fi); $k[2]--; if($val == $fine) $k[1]--; if($k[1] < 0) $k[1] = 0; if(count($n) > 2) { $n[2] = (int)$n[2] - 1; if($n[2] < 1) { $fk[$val] = "\n"; unlink($keyper.'/'.$val.'.php'); unlink($keyper.'/v'.$val.'.php'); } else $fk[$val] = $n[0].'.'.$n[1].'.'.$n[2]."\n"; } elseif(count($n) == 2) { if($k[1] < 1) { $fk[$fine] = ''; unlink($keyper.'/v'.$val.'.php'); unlink($keyper.'/'.$val.'.php'); }} w($keyperindex,$fk); w($keyperin,$k[0].'.'.$k[1].'.'.$k[2].'.'.rtrim($k[3])."\n"); if($k[2] < 1) return -1; else return $k[2]; } $QprcNum = SYS::prcnumber();
        if(is_array($val)) { $ok = true; $o = false; $fl = [];
            foreach($val as $v) { if($v[0] == '#') $n = floor((int)substr($v,1,10)/$QprcNum); else $n = floor((int)substr($v,0,10)/$QprcNum); $keyl = "$keyper/l$n.php"; $keyt = "$keyper/t$n.php"; if(!isset($fl['l'.$n])) $fl['l'.$n] = false;
                if(is_array($fl['l'.$n])) { $j = array_search($v."\n", $fl['l'.$n]); if($j > 1) { $o[] = $n; $vl[] = $v."\n"; $del[] = rtrim($ft['l'.$n][$j]); $fl['l'.$n] = SYS::cancella($fl['l'.$n], $j); $ft['l'.$n] = SYS::cancella($ft['l'.$n], $j); if($ora) a("$keyper/log.php","$ora-$v\n"); }} else { if(file_exists($keyl)){ $ft['l'.$n] = file($keyt); $fl['l'.$n] = file($keyl); $j = array_search($v."\n", $fl['l'.$n]); if($j > 1) { $o[] = $n; $vl[] = $v."\n"; $del[] = rtrim($ft['l'.$n][$j]); $fl['l'.$n] = SYS::cancella($fl['l'.$n], $j); $ft['l'.$n] = SYS::cancella($ft['l'.$n], $j); if($ora) a("$keyper/log.php","$ora-$v\n"); }}}
            } if(is_array($o)) { $val = $vl; $o = SYS::u($o); foreach($o as $n) { w("$keyper/l$n.php", $fl['l'.$n]); w("$keyper/t$n.php", $ft['l'.$n]); }} else return false;
        } else { if($val[0] == '#') $n = floor((int)substr($val,1,10)/$QprcNum); else $n = floor((int)substr($val,0,10)/$QprcNum); if($opz == 0) $del[0] = substr($val, 0, 10); else { $keyl = "$keyper/l$n.php"; $keyt = "$keyper/t$n.php"; $val .= "\n"; if(file_exists($keyl)){ $fl = file($keyl); $j = array_search($val,$fl); if($j > 1) { $ft = file($keyt); $del[0] = rtrim($ft[$j]); $fl = SYS::cancella($fl,$j); $ft = SYS::cancella($ft,$j); w($keyl,$fl); w($keyt,$ft); a("$keyper/log.php","$ora-$val"); } else return false; } else return false; } $val = array($val); $ok = false; } $k = explode('.',$fi);
        for($x=0, $u=count($del); $x<$u; $x++) { for($a=count($fk)-1; $a>1; $a--) { $n = explode('.', $fk[$a]);
            if(count($n) > 2) { if($del[$x] >= $n[0] && $del[$x] <= $n[1]) { if($opz) $key = "$keyper/v$a.php"; else $key = "$keyper/$a.php"; if(file_exists($key)){ $fy = file($key); $j = array_search($val[$x], $fy); if($j > 1) { $n[2] = (int)$n[2] - 1; if($n[2] < 1) { $fk[$a] = "\n"; unlink($key); if($opz) unlink("$keyper/$a.php"); } else { $fk[$a] = $n[0].'.'.$n[1].'.'.$n[2]."\n"; $fy = SYS::cancella($fy, $j); w($key, $fy); if($opz) { $fe = file("$keyper/$a.php"); $fe = SYS::cancella($fe, $j); w("$keyper/$a.php", $fe); }} $k[2]--; if(!$ok) { w($keyperin,$k[0].'.'.$k[1].'.'.$k[2].'.'.rtrim($k[3])."\n"); if($k[2] < 1) { w($keyperindex,$Qprotezione); return -1; } else { w($keyperindex,$fk); return $k[2]; }} else $y++; }}}}
            elseif(count($n) == 2) { if($opz) $key = "$keyper/v$a.php"; else $key = "$keyper/$a.php"; if(file_exists($key)){ $fe = file($key); $j = array_search($val[$x], $fe); if($j > 1) { $k[1]--; $k[2]--; $fe = SYS::cancella($fe, $j); w($key, $fe); if($opz) { $fy = file("$keyper/$a.php"); $fy = SYS::cancella($fy, $j); w("$keyper/$a.php", $fy); } if($k[1] < 1) { $fk[$a] = "\n"; unlink($key); if($opz) unlink("$keyper/$a.php"); } if(!$ok) { w($keyperin,$k[0].'.'.$k[1].'.'.$k[2].'.'.rtrim($k[3])."\n"); if($k[2] < 1) { w($keyperindex,$Qprotezione); return -1; } else { w($keyperindex,$fk); return $k[2]; }} else $y++; }}}}
        } if($k[2] < 1) w($keyperindex,$Qprotezione); else w($keyperindex,$fk); w($keyperin,$k[0].'.'.$k[1].'.'.$k[2].'.'.rtrim($k[3])."\n"); if($ok){ $es[1] = $y; if($k[2] < 1) $es[0] = -1; else $es[0] = 0; return $es; } else return false;
    }
    protected static function Qdbdel($keys=NULL, $valass=NULL, $opz=NULL, $type=0) { if(is_array($opz)){ $tmp = $opz; $opz = $valass; $valass = $tmp; } if(is_array($valass)){ if(is_array($opz) || $opz == NULL) return SYS::error(3,4); } global $Qdatabase; $ora = SYS::time(); if(is_array($valass)){ for($a=0, $u=count($valass); $a<$u; $a++) { if(isset($valass[$a])) $valass[$a] = SYS::speciali($valass[$a],1); }} else $valass = SYS::speciali($valass,1);
        if(strpos($keys, ' ') > 1) { $ky = explode(' ', $keys, 2); $key = $ky[1]; $keyass = $ky[0]; if($valass == NULL) return SYS::error(3,7,$keys,$keyass);
        } else { $key = $keys; $keyass = 0; if($valass == NULL && $opz == NULL) { if($key[0] == '#') { $per = SYS::combina($key,2).'/id.php'; $keys = (int)r($per); if($keys){ if($keys > 0) { $key = substr($key, 1); if(self::Qdbdel($key, $keys)) return $keys; }} return false; } else return SYS::error(3,9,$key); } if($key[0] == '#') { $key = substr($key, 1); return self::Qdbdel($key, $valass); }
            if(strpos($keys, '#') > 1) { $ky = explode('#', $keys, 2); $key = $ky[1]; $keyass = $ky[0]; if($type > 1000) { $per = substr($key,0,-2)."\n"; $valass = base64_decode($valass); } else $per = SYS::combina($key,1);
                if($per) { if($type == 1971) $perass = explode('.',$keyass); else $perass = SYS::combina($keyass);
                    if($perass) { if($opz) $hash = Qhash($opz); else $hash = Qhash($valass); $hashpos = SYS::hashpos($hash, $perass); $keypery = $hashpos.'/keys.php'; $keyperl = $hashpos.'/link.php';
                        if(file_exists($keypery)){ $fp = file($keypery); $per = rtrim($per); $x = array_search($per.".0\n", $fp); 
                            if($x > 1) { $fl = file($keyperl); $p = $Qdatabase.'/'.rtrim($fl[$x]); $keyper = $Qdatabase; $pr = ''; foreach($perass as $b) { $keyper .= '/'.$b; $pr .= $b.'.'; } $keypers = $keyper.'/keys.php'; $keypern = $keyper.'/keyn.php';
                                if(file_exists($keypers)){ $fk = file($keypers); $fn = file($keypern); $b = array_search($fp[$x],$fk);
                                    if($b > 1) { $fn[$b] = rtrim($fn[$b]);
                                        if($opz) {
                                            if(is_array($valass)) { $valass = SYS::u($valass); $valok = false; $valstr = false; foreach($valass as $a) if(SYS::isnumber($a)) $valok[] = $a; else $valstr[] = $a;
                                                if($valok || $valstr) { if($valok) { $es = self::elimina($p, $valok, 1, $ora); if(is_array($es)) { $fn[$b] = $fn[$b] - $es[1]; if($es[0] == -1) self::delete($fp, $fl, $x, $p, $pr, $keypery, $keyperl, $hashpos, $ora); } else return false; foreach($valok as $fx) self::Qdbdel($key.'#'.$keyass, $opz, $fx, 1); }
                                                    if($valstr) { $pe = SYS::combina($key); foreach($valstr as $fx) { $fm = SYS::hashpos(Qhash($fx), $pe).'/index.php'; if(file_exists($fm)) $es = self::elimina_adesso($fm, $p, $ora); else { $dirdel = SYS::combina($key,2).'/-0/'.Qhash($fx).'.php'; if(file_exists($dirdel)) $es = self::elimina_adesso($dirdel, $p, $ora); } if($es) { if($es == -1) { self::delete($fp, $fl, $x, $p, $pr, $keypery, $keyperl, $hashpos, $ora); $fn[$b] = 0; break; } else $fn[$b] = (int)$fn[$b] - 1; }}}
                                                } else return false;
                                            } else { if(SYS::isnumber($valass)) { if($type == 1) { $fm = SYS::hashpos(Qhash($valass), SYS::combina($key)).'/index.php'; if(file_exists($fm)){ $m = file($fm); $valass = '#'.rtrim($m[2]); }} $es = self::elimina($p, $valass, 1, $ora); 
                                                } else { if($type > 1000) { if($type == 1971) $pe = $Qdatabase.'/'.str_replace('.','/',$per); else { $type -= 1000; $pe = $Qdatabase; $ky = explode('.',$key); for($a=$type, $u=count($ky)-1; $a<$u; $a++) $pe .= '/'.$ky[$a]; } $hashpr = SYS::lh($pe,Qhash($valass)); } else $hashpr = SYS::hashpos(Qhash($valass), SYS::combina($key)); $fm = "$hashpr/index.php";
                                                    if(file_exists($fm)){ $es = self::elimina_adesso($fm, $p, $ora); } else { $type = true; $dirdel = SYS::combina($key,2).'/-0/'.Qhash($valass).'.php'; if(file_exists($dirdel)) $es = self::elimina_adesso($dirdel, $p, $ora, true); else return false; }
                                                } if($es) { if(is_array($es)) { $fn[$b] = $fn[$b] - $es[1]; $es = $es[0]; } else $fn[$b] = (int)$fn[$b] - 1; } else return false; if($es == -1) { if($type == 1971) $pr = substr($pr,2); self::delete($fp, $fl, $x, $p, $pr, $keypery, $keyperl, $hashpos, $ora); } if(!$type) self::Qdbdel($key.'#'.$keyass,$opz,$valass,1); 
                                            }
                                        } else { $fe = []; $fx = SYS::leggi($p,0,array(-1,0,-1,0,0,0,0),1); for($a=2, $u=count($fx); $a<$u; $a++) $fe[$a-2] = rtrim($fx[$a]); if($type != 888) $es = self::elimina($p, $fe, 1, $ora); else $es = array(0,count($fe)); if($es) { if(is_array($es)) $fn[$b] = $fn[$b] - $es[1]; else $fn[$b] = (int)$fn[$b] - 1; } else return false; self::delete($fp, $fl, $x, $p, $pr, $keypery, $keyperl, $hashpos, $ora, $type); foreach($fe as $fx) { self::Qdbdel($key.'#'.$keyass, $valass, $fx, 1); }} if($fn[$b] < 1) { $fk = SYS::cancella($fk,$b); $fn = SYS::cancella($fn,$b); $dir = $Qdatabase.'/'.str_replace('.','/',$per).'/'.$pr.'0'; self::directory($dir,1); w($keypers,$fk); self::delink($keyass,$key); } else $fn[$b] = $fn[$b]."\n"; w($keypern,$fn); return true;
                                    } else return SYS::error(3,13,$fp[$x],$keypers);
                                }
                            }
                        }
                    } 
                } return false;
            }
        } if($valass != NULL) { if($keyass && strpos($key,',')) { $k = explode(',',$key); $ok = false; for($a=0, $u=count($k); $a<$u; $a++) { $k[$a] = trim($k[$a]); if($k[$a][0] != '#' && $k[$a][0] != '@') $k[$a] = ' '.$k[$a]; if(self::Qdbdel($keyass.$k[$a],$valass)) $ok = true; } return $ok; } elseif(strpos($keys,',')) { $k = explode(',',$keys); require_once 'Qver.php'; $Qdb = new SYS; for($a=0; $a<count($k); $a++) if($Qdb->_ver($k[$a],$valass) < 1) return false; for($a=0; $a<count($k); $a++) self::Qdbdel($k[$a],$valass); return true; } else $per = SYS::combina($key); } else return SYS::error(3,11,$key);
        if($per) { $keyper = $Qdatabase; $msg = ''; if($keyass) { if(SYS::keyvalass($keyass, $valass, $per, 1)) { if($opz != 999){ $perass = SYS::combina($keyass); if($perass) { $linkphpass = $per[0]; for($a=1, $u=count($per); $a<$u; $a++) $linkphpass .= '.'.$per[$a]; $hashpos = SYS::hashpos(Qhash($valass), $perass); $Qlog = "$hashpos/$linkphpass.php"; if(file_exists($Qlog)) a($Qlog,$ora."\n"); foreach($perass as $a) $keyper .= '/'.$a; $linkphp = "$keyper/keys.php"; $linkpos = "$keyper/keyn.php"; $fp = file($linkphp); $a = array_search($linkphpass."\n", $fp); if($a > 1) { $fl = file($linkpos); $fl[$a] = ((int)$fl[$a] - 1)."\n"; if(rtrim($fl[$a]) < 1) { $fl = SYS::cancella($fl, $a); $fp = SYS::cancella($fp, $a); w($linkphp,$fp); } w($linkpos,$fl); }}} return true; }
            } else { if(is_array($valass)) { $tmp = $opz; $opz = $valass; $valass = $tmp; } $hashpos = SYS::hashpos(Qhash($valass), $per); $hashposi = "$hashpos/index.php"; $hashposk = "$hashpos/keys.php"; $hashposl = "$hashpos/link.php";
                if(file_exists($hashposi)){ $fi = file($hashposi); foreach($per as $a) { $keyper .= '/'.$a; $msg .= $a.'.'; } $linkphp = "$keyper/keys.php"; $linkpos = "$keyper/keyn.php"; $dirdel = "$keyper/-0";
                    if(file_exists($hashposk)){ $fkk = file($hashposk); $fll = file($hashposl); $fss = file($linkphp); $fnn = file($linkpos); $fkkdel = []; $flldel = [];
                        if(is_array($opz)) { $ak = array_keys($opz); $al = array_values($opz); $akk = []; $all = []; $as = []; $ok = false;
                            for($a=0, $ua=count($ak); $a<$ua; $a++) { if(!SYS::isnumber($ak[$a]) && $ak[$a][0] != '#') { $al[$a] = $ak[$a]; $ak[$a] = $a; } if(SYS::isnumber($ak[$a])) { if($al[$a][0] == '#') $as[] = $al[$a]; else { $ky = ''; $x = explode('.',$al[$a]); for($b=0, $ub=count($x); $b<$ub; $b++) { $j = array_search($x[$b]."\n",QKEYBASE); if($j > 1) $ky .= $j.'.'; } $ky = substr($ky,0,-1); $y = array_search($ky."\n",$fkk); if($y > 1) { $ok = true; $Qlog = "$hashpos/$ky.php"; if(file_exists($Qlog)) a($Qlog,$ora."\n"); $fkk = SYS::cancella($fkk,$y); $fll = SYS::cancella($fll,$y); $x = array_search($ky."\n",$fss); if($x > 1) { $fnn[$x] = (int)$fnn[$x] - 1; if($fnn[$x] < 1) { $fss = SYS::cancella($fss,$x); $fnn = SYS::cancella($fnn,$x); } else $fnn[$x] .= "\n"; }}}} else { if($ak[$a][0] == '#') { $akk[] = $ak[$a]; $all[] = $al[$a]; }}}
                            w($hashposk,$fkk); w($hashposl,$fll); w($linkphp,$fss); w($linkpos,$fnn); if(count($akk) > 0) { for($a=0, $u=count($akk); $a<$u; $a++) { if(self::Qdbdel($keys.$akk[$a],$all[$a],$valass)) $ok = true; }} if(count($as) > 0) { for($a=0, $u=count($as); $a<$u; $a++) { if(self::Qdbdel($keys.$as[$a],$valass)) $ok = true; }} return $ok;
                        } 
                        for($a=2, $u=count($fkk); $a<$u; $a++) { $j = array_search($fkk[$a], $fss);  // -------- # Link !!!
                            if($j > 1) { if(strlen($fll[$a]) > 64) { if($fll[$a][0] == 0) { $ms = SYS::kb($fkk[$a], '', 1); if(self::Qdbdel($keys.'#'.$ms,$valass,null,888)) { $fkkdel[] = $fkk[$a]; $flldel[] = $fll[$a]; }}}}} $ok = false;
                        if(file_exists($hashposk)){ $fkk = file($hashposk); $fll = file($hashposl); $fss = file($linkphp); $fnn = file($linkpos);
                            for($a=2, $ua=count($fkk); $a<$ua; $a++) { $j = array_search($fkk[$a], $fss); 
                                if($j > 1) { $fnn[$j] = rtrim($fnn[$j]); 
                                    if(strlen($fll[$a]) > 64) { // -------------------------------------- @ Clonazione !!!
                                        if($fll[$a][0] == 1) { $f1 = file($Qdatabase.'/'.rtrim($fll[$a]).'/keyc.php'); $f2[0] = $fi[2]; $ok = true; for($x=2, $ux=count($f1); $x<$ux; $x++) { $str = $Qdatabase; $g = explode('.', $f1[$x]); $z = count($g)-1; for($y=0; $y<$z; $y++) $str .= '/'.$g[$y]; $str .= '/'.$msg.'1/v'.rtrim($g[$z]).'.php'; $fp = file($str); $f3 = array_intersect($fp,$f2); $f4 = array_keys($f3); foreach($f4 as $k) $fp[$k] = '-0'.$ora.$fp[$k]; w($str,$fp); } $str = $Qdatabase.'/@/'.str_replace('.','/',substr($fkk[$a],0,-2)).'@'; $f1 = SYS::leggi($Qdatabase.'/'.rtrim($fll[$a]),0,array(-1,0,-1,0,0,0,0),1); $tmp = $str;
                                            for($x=2, $ux=count($f1); $x<$ux; $x++) { $str = SYS::lh($str,Qhash(rtrim($f1[$x]))); $f3 = "$str/keys.php"; $f4 = "$str/link.php"; if(file_exists($f3)){ $fk = file($f3); $z = array_search($msg."0\n", $fk); if($z > 1) { $fl = file($f4); $g = SYS::leggi($Qdatabase.'/'.rtrim($fll[$a]),0,array(-1,0,-1,0,0,0,0),1); $g = SYS::cancella($g,1); $g = array_unique(SYS::cancella($g,0)); sort($g); for($b=0, $ub=count($g); $b<$ub; $b++) { $str = SYS::lh($tmp,Qhash(rtrim($g[$b]))); $f5 = "$str/keys.php"; $f6 = "$str/link.php"; if(file_exists($f5)){ $mk = file($f5); $z = array_search($msg."0\n", $mk); if($z > 1) { $ml = file($f6); $str = $Qdatabase.'/'.rtrim($ml[$z]); $e = r("$str/in.php"); if($e){ $e = explode('.',$e); for($c=$e[0]; $c>1; $c--) { $s = "$str/v$c.php"; if(file_exists($s)){ $fp = file($s); for($d=2, $ud=count($fi); $d<$ud; $d++) { $z = array_intersect($fp,array('#'.$fi[$d])); if($z) { $y = array_keys($z); foreach($y as $k) $fp[$k] = "-0$ora".$fi[2]; w($s,$fp); break; }}}}}}}}}}}
                                        }
                                    } else { SYS::keyvalass($key, $valass, explode('.',rtrim($fkk[$a])), 1, 2); $Qlog = $hashpos.'/'.rtrim($fkk[$a]).'.php'; if(file_exists($Qlog)) a($Qlog,$ora."\n"); $fnn[$j] = (int)$fnn[$j] - 1; } if($fnn[$j] < 1) { $fss = SYS::cancella($fss, $j); $fnn = SYS::cancella($fnn, $j); } else $fnn[$j] = $fnn[$j]."\n"; 
                                }
                            } w($linkphp,$fss); w($linkpos,$fnn); 
                        } self::directory($hashpos,0,$dirdel,$ora,$fi[2],$fkkdel,$flldel); $tot = self::elimina($keyper, $fi[2]); if($tot == -1) { $tot = 0; if(!file_exists("$keyper/keyp.php")) self::directory($keyper,1); else { unlink("$keyper/keys.php"); unlink("$keyper/keyn.php"); }} if($ok) { global $Qpostime; $keyper = $Qdatabase.$Qpostime; $f = rtrim($f2[0]); $op0 = substr($f, 0, 3); $op1 = substr($f, 3, $f[12]); $op2 = substr($f, 3 + $f[12]); $keyper .= '/'.$op0; SYS::ix($keyper); $keyper .= '/'.$op1; SYS::ix($keyper); $keyper .= '/'.$op2; $keyperindex = SYS::ix($keyper); for($x=2; $x<count($fll); $x++) { if(strlen($fll[$x]) > 64) { $fkk = SYS::cancella($fkk,$x); $fll = SYS::cancella($fll,$x); $x--; }} w("$keyper/keys.php",$fkk); w("$keyper/link.php",$fll); a($keyperindex,$ora); }
                    } else { self::directory($hashpos,0,$dirdel,$ora,$fi[2]); $tot = self::elimina($keyper, $fi[2]); if($tot == -1) $tot = 0; if($type == 999) { $keyper .= '/id.php'; $id = r($keyper); $id = (int)$id - 1; file_put_contents($keyper,$id); }} if(!SYS::isnumber($valass)) { $dirdel .= '/'.Qhash($valass).'.php'; SYS::protezione($dirdel); a($dirdel,$fi[2]); } return $tot; 
                }
            }
        } return false;
    }
}