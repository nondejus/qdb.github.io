<?php

class Qdel extends Qfx
{
    protected static function delink($keyass, $key) { global $Qdatabase; $fp = file($Qdatabase.'/link.php'); $link = rtrim(Qfx::combina($keyass,1)).'#'.rtrim(Qfx::combina($key,1)).".0\n"; $j = array_search($link,$fp); if($j > 1) { $fp = Qfx::cancella($fp,$j); Qw($Qdatabase.'/link.php',$fp); }}
    protected static function directory($dir, $opz=0, $dirdel=0, $ora=0, $id=0, $keydel=0, $linkdel=0) { if(is_dir($dir)) { $files = array_diff(scandir($dir), array('.','..','-0')); if($ora) { if(!is_dir($dirdel)) Qfx::ix($dirdel); self::scrivi($dirdel, $ora, "\n", 0, $id); $id = $ora.rtrim($id); $a = substr($id,0,4); $b = substr($id,4,4); $c = substr($id,8,4); $d = substr($id,12); $dirdel .= '/'.$a; if(!is_dir($dirdel)) Qfx::ix($dirdel); $dirdel .= '/'.$b; if(!is_dir($dirdel)) Qfx::ix($dirdel); $dirdel .= '/'.$c; if(!is_dir($dirdel)) Qfx::ix($dirdel); $dirdel .= '/'.$d; if(!is_dir($dirdel)) Qfx::ix($dirdel); foreach($files as $file) { if(is_file("$dir/$file")) copy("$dir/$file","$dirdel/$file"); } if(is_array($keydel)) { Qa("$dirdel/keys.php",$keydel); Qa("$dirdel/link.php",$linkdel); }} foreach($files as $file) { (is_dir("$dir/$file")) ? self::directory("$dir/$file") : unlink("$dir/$file"); } if($opz) { global $Qprotezione; Qw("$dir/index.php",$Qprotezione); return true; } else return rmdir($dir); } else return false; }
    protected static function delete($fp, $fl, $x, $p, $pr, $keypery, $keyperl, $hashpos, $ora=0, $type=0) { global $Qdatabase; global $Qlivtime; if(count($fp) == 3) { unlink($keypery); unlink($keyperl); } else { $fp = Qfx::cancella($fp,$x); $fl = Qfx::cancella($fl,$x); Qw($keypery,$fp); Qw($keyperl,$fl); } $f1 = file($hashpos.'/index.php'); $f2 = file($p.'/keyp.php'); $f = explode('.', $f2[2]); $x = count($f)-1; $r4 = $Qdatabase.'/'; for($a=0; $a<$x; $a++) $r4 .= $f[$a].'/'; $r = $pr.'0'; $rf = rtrim($f[$x]); $r5 = $r4.$r.'/v'.$rf.'.php'; if(file_exists($r5)) { $f5 = file($r5); $j = array_search($f1[2], $f5); if($j > 1) { $f4 = file($r4.$r.'/'.$rf.'.php'); $f5 = Qfx::cancella($f5,$j); $f4 = Qfx::cancella($f4,$j); Qw($r5,$f5); Qw($r4.$r.'/'.$rf.'.php',$f4); if($ora) { $x = substr($p,strlen($Qdatabase)+3); $f = explode('/', $x); $pr = $ora.'-'.$f[0].'.'; for($a=1; $a<(count($f)-$Qlivtime-1); $a++) $pr .= $f[$a].'.'; copy($p.'/log.php',$hashpos.'/'.$pr.'0.php'); } self::elimina($r4.$r, $rf, 2); if($type != 888) self::directory($p); }}}
    protected static function scrivi($keyper, $orapsw, $posold, $opz=0, $type=0, $pos=0, $mod=0, $etc=0, $db=0) { global $Qprotezione; $keynum = $keyper.'/in.php'; if(!file_exists($keynum)) Qw($keynum,"2.0.0.0\n"); $f = fopen($keynum,'r'); $kn = explode('.',fread($f,filesize($keynum))); fclose($f); $keypos = $keyper.'/'.$kn[0].'.php'; $kn[1]++; $kn[2]++; $kt = $kn[0]; $kp = $kn[1];
        if($opz) { if($orapsw <= rtrim($kn[3])) return Qfx::error(1,2,$orapsw); else $kn[3] = $orapsw; } $keycode = $keyper.'/index.php'; if(is_readable($keycode)) $kc = file($keycode); else exit; $kcn = count($kc); $tipo = rtrim(substr($kc[1],-2)); if($tipo == '>') { if($type[0] == '#') $kc[1] = rtrim($kc[1])."2\n"; else $kc[1] = rtrim($kc[1])."1\n"; } elseif($tipo == 1 and $type[0] == '#') return -1; elseif($tipo == 2 and is_numeric($type[0])) return -2; $QprcNum = Qfx::prcnumber();
        if($kn[1] == 1) { if($opz) $kc[$kcn] = $orapsw.'.'; else $kc[$kcn] = substr($orapsw, 0, 10).'.'; $msg = ''; for($x=0; $x<=$kcn; $x++) $msg .= $kc[$x]; Qw($keycode,$msg); Qw($keypos,$Qprotezione.$orapsw.$posold); 
            if($type) { Qw($keyper.'/v'.$kn[0].'.php',$Qprotezione.$type); if($pos) Qa($keyper.'/c'.$kn[0].'.php',$Qprotezione.$pos."\n"); if($mod == 2) { if($db) $n = floor((int)substr($type,1,10)/$QprcNum); else $n = floor((int)substr($type,0,10)/$QprcNum); $filel = $keyper.'/l'.$n.'.php'; $filet = $keyper.'/t'.$n.'.php'; if(!file_exists($filel)) { Qw($filel,$Qprotezione.$type); Qw($filet,$Qprotezione.$orapsw."\n"); } else { Qa($filel,$type); Qa($filet,$orapsw."\n"); }}}
        } elseif($kn[1] > $QprcNum) { if($opz) $kc[$kcn-1] .= $orapsw.'.'.$kn[1]."\n"; else $kc[$kcn-1] .= substr($orapsw, 0, 10).'.'.$kn[1]."\n"; if(!file_exists($keypos)) Qw($keypos,$Qprotezione.$orapsw.$posold); else Qa($keypos,$orapsw.$posold);
            if($type) { $keyv = $keyper.'/v'.$kn[0].'.php'; if(!file_exists($keyv)) Qw($keyv,$Qprotezione.$type); else Qa($keyv,$type); if($pos) { $keyc = $keyper.'/c'.$kn[0].'.php'; if(!file_exists($keyc)) Qw($keyc,$Qprotezione.$pos."\n"); else Qa($keyc,$pos."\n"); } if($mod == 2) { if($db) $n = floor((int)substr($type,1,10)/$QprcNum); else $n = floor((int)substr($type,0,10)/$QprcNum); $filel = $keyper.'/l'.$n.'.php'; $filet = $keyper.'/t'.$n.'.php'; if(!file_exists($filel)) { Qw($filel,$Qprotezione.$type); Qw($filet,$Qprotezione.$orapsw."\n"); } else { Qa($filel,$type); Qa($filet,$orapsw."\n"); }}} $kp = $kn[1]; $kn[0]++; $kn[1] = 0; $msg = ''; for($x=0; $x<$kcn; $x++) $msg .= $kc[$x]; Qw($keycode,$msg);
        } else { if(!file_exists($keypos)) Qw($keypos,$Qprotezione.$orapsw.$posold); else Qa($keypos,$orapsw.$posold); 
            if($type) { $keyv = $keyper.'/v'.$kn[0].'.php'; if(!file_exists($keyv)) Qw($keyv,$Qprotezione.$type); else Qa($keyv,$type); if($pos) { $keyc = $keyper.'/c'.$kn[0].'.php'; if(!file_exists($keyc)) Qw($keyc,$Qprotezione.$pos."\n"); else Qa($keyc,$pos."\n"); } if($mod == 2) { if($db) $n = floor((int)substr($type,1,10)/$QprcNum); else $n = floor((int)substr($type,0,10)/$QprcNum); $filel = $keyper.'/l'.$n.'.php'; $filet = $keyper.'/t'.$n.'.php'; if(!file_exists($filel)) { Qw($filel,$Qprotezione.$type); Qw($filet,$Qprotezione.$orapsw."\n"); } else { Qa($filel,$type); Qa($filet,$orapsw."\n"); }}}
        } Qw($keynum, $kn[0].'.'.$kn[1].'.'.$kn[2].'.'.rtrim($kn[3])."\n"); if($mod == 1) { $kp++; return $kt.'.'.$kp; } if($etc == 1) return $kt; elseif($etc == 2) return $kn[2]; else { if($type == 1 and $opz == 1) return $kt; else return $keyper; }
    }
    protected static function elimina($keyper, $val, $opz=0, $ora=0) { global $Qprotezione; $keyperin = $keyper.'/in.php'; $keyperindex = $keyper.'/index.php';
        if(file_exists($keyperin)){ $f = fopen($keyperin,'r'); $fi = fread($f,filesize($keyperin)); fclose($f); $fk = file($keyperindex); $fine = count($fk)-1; $k[2] = 1; $y = 0; $del = array(); 
            if($opz == 2) { $n = explode('.', $fk[$val]); $k = explode('.',$fi); $k[2]--; if($val == $fine) $k[1]--; if($k[1] < 0) $k[1] = 0; if(count($n) > 2) { $n[2] = (int)$n[2] - 1; if($n[2] < 1) { $fk[$val] = "\n"; unlink($keyper.'/'.$val.'.php'); unlink($keyper.'/v'.$val.'.php'); } else $fk[$val] = $n[0].'.'.$n[1].'.'.$n[2]."\n"; } elseif(count($n) == 2) { if($k[1] < 1) { $fk[$fine] = ''; unlink($keyper.'/v'.$val.'.php'); unlink($keyper.'/'.$val.'.php'); }} Qw($keyperindex,$fk); Qw($keyperin,$k[0].'.'.$k[1].'.'.$k[2].'.'.rtrim($k[3])."\n"); if($k[2] < 1) return -1; else return $k[2]; } $QprcNum = Qfx::prcnumber();
            if(is_array($val)) { $ok = true; $o = false; $fl = array();
                foreach($val as $v) { if($v[0] == '#') $n = floor((int)substr($v,1,10)/$QprcNum); else $n = floor((int)substr($v,0,10)/$QprcNum); $keyl = $keyper.'/l'.$n.'.php'; $keyt = $keyper.'/t'.$n.'.php'; if(!isset($fl['l'.$n])) $fl['l'.$n] = false;
                    if(is_array($fl['l'.$n])) { $j = array_search($v."\n", $fl['l'.$n]); if($j > 1) { $o[] = $n; $vl[] = $v."\n"; $del[] = rtrim($ft['l'.$n][$j]); $fl['l'.$n] = Qfx::cancella($fl['l'.$n], $j); $ft['l'.$n] = Qfx::cancella($ft['l'.$n], $j); if($ora) Qa($keyper.'/log.php',$ora.'-'.$v."\n"); }} else { if(file_exists($keyl)){ $ft['l'.$n] = file($keyt); $fl['l'.$n] = file($keyl); $j = array_search($v."\n", $fl['l'.$n]); if($j > 1) { $o[] = $n; $vl[] = $v."\n"; $del[] = rtrim($ft['l'.$n][$j]); $fl['l'.$n] = Qfx::cancella($fl['l'.$n], $j); $ft['l'.$n] = Qfx::cancella($ft['l'.$n], $j); if($ora) Qa($keyper.'/log.php',$ora.'-'.$v."\n"); }}}
                } if(is_array($o)) { $val = $vl; $o = Qfx::u($o); foreach($o as $n) { Qw($keyper.'/l'.$n.'.php', $fl['l'.$n]); Qw($keyper.'/t'.$n.'.php', $ft['l'.$n]); }} else return false;
            } else { if($val[0] == '#') $n = floor((int)substr($val,1,10)/$QprcNum); else $n = floor((int)substr($val,0,10)/$QprcNum); if($opz == 0) $del[0] = substr($val, 0, 10); else { $keyl = $keyper.'/l'.$n.'.php'; $keyt = $keyper.'/t'.$n.'.php'; $val .= "\n"; if(file_exists($keyl)){ $fl = file($keyl); $j = array_search($val,$fl); if($j > 1) { $ft = file($keyt); $del[0] = rtrim($ft[$j]); $fl = Qfx::cancella($fl,$j); $ft = Qfx::cancella($ft,$j); Qw($keyl,$fl); Qw($keyt,$ft); Qa($keyper.'/log.php',$ora.'-'.$val); } else return false; } else return false; } $val = array($val); $ok = false; } $k = explode('.',$fi);
            for($x=0; $x<count($del); $x++) { for($a=count($fk)-1; $a>1; $a--) { $n = explode('.', $fk[$a]);
                if(count($n) > 2) { if($del[$x] >= $n[0] and $del[$x] <= $n[1]) { if($opz) $key = $keyper.'/v'.$a.'.php'; else $key = $keyper.'/'.$a.'.php'; if(file_exists($key)){ $fy = file($key); $j = array_search($val[$x], $fy); if($j > 1) { $n[2] = (int)$n[2] - 1; if($n[2] < 1) { $fk[$a] = "\n"; unlink($key); if($opz) unlink($keyper.'/'.$a.'.php'); } else { $fk[$a] = $n[0].'.'.$n[1].'.'.$n[2]."\n"; $fy = Qfx::cancella($fy, $j); Qw($key, $fy); if($opz) { $fe = file($keyper.'/'.$a.'.php'); $fe = Qfx::cancella($fe, $j); Qw($keyper.'/'.$a.'.php', $fe); }} $k[2]--; if(!$ok) { Qw($keyperin,$k[0].'.'.$k[1].'.'.$k[2].'.'.rtrim($k[3])."\n"); if($k[2] < 1) { Qw($keyperindex,$Qprotezione); return -1; } else { Qw($keyperindex,$fk); return $k[2]; }} else $y++; }}}}
                elseif(count($n) == 2) { if($opz) $key = $keyper.'/v'.$a.'.php'; else $key = $keyper.'/'.$a.'.php'; if(file_exists($key)){ $fe = file($key); $j = array_search($val[$x], $fe); if($j > 1) { $k[1]--; $k[2]--; $fe = Qfx::cancella($fe, $j); Qw($key, $fe); if($opz) { $fy = file($keyper.'/'.$a.'.php'); $fy = Qfx::cancella($fy, $j); Qw($keyper.'/'.$a.'.php', $fy); } if($k[1] < 1) { $fk[$a] = "\n"; unlink($key); if($opz) unlink($keyper.'/'.$a.'.php'); } if(!$ok) { Qw($keyperin,$k[0].'.'.$k[1].'.'.$k[2].'.'.rtrim($k[3])."\n"); if($k[2] < 1) { Qw($keyperindex,$Qprotezione); return -1; } else { Qw($keyperindex,$fk); return $k[2]; }} else $y++; }}}}
            } if($k[2] < 1) Qw($keyperindex,$Qprotezione); else Qw($keyperindex,$fk); Qw($keyperin,$k[0].'.'.$k[1].'.'.$k[2].'.'.rtrim($k[3])."\n"); if($ok){ $es[1] = $y; if($k[2] < 1) $es[0] = -1; else $es[0] = 0; return $es; } else return false;
        } else return Qfx::error(3,0,$keyperin);
    }
    protected static function Qdbdel($keys=NULL, $valass=NULL, $opz=NULL, $type=0) { if(is_array($opz)) { $tmp = $opz; $opz = $valass; $valass = $tmp; } if(is_array($valass)) if(is_array($opz) or $opz == NULL) return Qfx::error(3,4); global $Qprotezione; global $Qdatabase; global $Qpostime; global $keybase; $ora = Qdb::time(); 
        if(is_array($valass)) { for($a=0; $a<count($valass); $a++) $valass[$a] = Qfx::speciali($valass[$a],1); } else $valass = Qfx::speciali($valass,1); 
        if(strpos($keys, ' ') > 1) {
            $ky = explode(' ', $keys, 2); $key = $ky[1]; $keyass = $ky[0]; if($valass == NULL) return Qfx::error(3,7,$keys,$keyass);
        } else { $key = $keys; $keyass = 0;
            if($valass == NULL and $opz == NULL) { if($key[0] == '#') { $per = Qfx::combina($key,2).'/id.php'; if(file_exists($per)){ $keys = rtrim(Qr($per)); if($keys > 0) { $key = substr($key, 1); if(self::Qdbdel($key, $keys)) return $keys; }} return false; } else return Qfx::error(3,9,$key); } if($key[0] == '#') { $key = substr($key, 1); return self::Qdbdel($key, $valass); }
            if(strpos($keys, '#') > 1) { $ky = explode('#', $keys, 2); $key = $ky[1]; $keyass = $ky[0]; if($type > 1000) { $per = substr($key,0,-2)."\n"; $valass = base64_decode($valass); } else $per = Qfx::combina($key,1);
                if($per) { if($type == 1971) $perass = explode('.',$keyass); else $perass = Qfx::combina($keyass);
                    if($perass) { if($opz) $hash = Qhash($opz); else $hash = Qhash($valass); $hashpos = Qfx::hashpos($hash, $perass); $keypery = $hashpos.'/keys.php'; $keyperl = $hashpos.'/link.php';
                        if(file_exists($keypery)){ $fp = file($keypery); $per = rtrim($per); $x = array_search($per.".0\n", $fp); 
                            if($x > 1) { $fl = file($keyperl); $p = $Qdatabase.'/'.rtrim($fl[$x]); $keyper = $Qdatabase; $pr = ''; foreach($perass as $b) { $keyper .= '/'.$b; $pr .= $b.'.'; } $keypers = $keyper.'/keys.php'; $keypern = $keyper.'/keyn.php';
                                if(file_exists($keypers)){ $fk = file($keypers); $fn = file($keypern); $b = array_search($fp[$x],$fk);
                                    if($b > 1) { $fn[$b] = rtrim($fn[$b]);
                                        if($opz) {
                                            if(is_array($valass)) { $valass = Qfx::u($valass); $valok = false; $valstr = false; foreach($valass as $a) if(Qfx::isnumber($a)) $valok[] = $a; else $valstr[] = $a;
                                                if($valok or $valstr) { 
                                                    if($valok) { $es = self::elimina($p, $valok, 1, $ora); if(is_array($es)) { $fn[$b] = $fn[$b] - $es[1]; if($es[0] == -1) self::delete($fp, $fl, $x, $p, $pr, $keypery, $keyperl, $hashpos, $ora); } else return false; foreach($valok as $fx) self::Qdbdel($key.'#'.$keyass, $opz, $fx, 1); }
                                                    if($valstr) { $pe = Qfx::combina($key); 
                                                        foreach($valstr as $fx) { $fm = Qfx::hashpos(Qhash($fx), $pe).'/index.php'; if(file_exists($fm)){ $m = file($fm); $es = self::elimina($p, '#'.rtrim($m[2]), 1, $ora); } else { $dirdel = Qfx::combina($key,2).'/-0/'.Qhash($fx).'.php'; if(file_exists($dirdel)){ $m = file($dirdel); for($a=2; $a<count($m); $a++) { $es = self::elimina($p, '#'.rtrim($m[$a]), 1, $ora); if($es) break; }}}
                                                            if($es) { if($es == -1) { self::delete($fp, $fl, $x, $p, $pr, $keypery, $keyperl, $hashpos, $ora); $fn[$b] = 0; break; } else $fn[$b] = (int)$fn[$b] - 1; }
                                                        }
                                                    }
                                                } else return false;
                                            } else {
                                                if(Qfx::isnumber($valass)) {
                                                    if($type == 1) { $fm = Qfx::hashpos(Qhash($valass), Qfx::combina($key)).'/index.php'; if(file_exists($fm)){ $m = file($fm); $valass = '#'.rtrim($m[2]); }} $es = self::elimina($p, $valass, 1, $ora); 
                                                } else { if($type > 1000) { if($type == 1971) $pe = $Qdatabase.'/'.str_replace('.','/',$per); else { $type -= 1000; $pe = $Qdatabase; $ky = explode('.',$key); for($a=$type; $a<(count($ky)-1); $a++) $pe .= '/'.$ky[$a]; } $hash = Qhash($valass); $hashpr = Qfx::lh($pe,$hash); } else { $pe = Qfx::combina($key); $hashpr = Qfx::hashpos(Qhash($valass), $pe); } $fm = $hashpr.'/index.php';
                                                    if(file_exists($fm)){ $m = file($fm); $es = self::elimina($p, '#'.rtrim($m[2]), 1, $ora); } else { $type = true; $dirdel = Qfx::combina($key,2).'/-0/'.Qhash($valass).'.php'; if(file_exists($dirdel)){ $m = file($dirdel); for($a=2; $a<count($m); $a++) { $es = self::elimina($p, '#'.rtrim($m[$a]), 1, $ora); if($es) break; $es = self::elimina($p, rtrim($m[$a]), 1, $ora); if($es) break; }} else return false; }
                                                } if($es) { if(is_array($es)) { $fn[$b] = $fn[$b] - $es[1]; $es = $es[0]; } else $fn[$b] = (int)$fn[$b] - 1; } else return false; if($es == -1) { if($type == 1971) $pr = substr($pr,2); self::delete($fp, $fl, $x, $p, $pr, $keypery, $keyperl, $hashpos, $ora); } if(!$type) self::Qdbdel($key.'#'.$keyass,$opz,$valass,1); 
                                            }
                                        } else { $fe = array(); $fx = Qfx::leggi($p,0,array(-1,0,-1,0,0,0,0),1); for($a=2; $a<count($fx); $a++) $fe[$a-2] = rtrim($fx[$a]); if($type != 888) $es = self::elimina($p, $fe, 1, $ora); else $es = array(0,count($fe)); 
                                            if($es) { if(is_array($es)) $fn[$b] = $fn[$b] - $es[1]; else $fn[$b] = (int)$fn[$b] - 1; } else return false; self::delete($fp, $fl, $x, $p, $pr, $keypery, $keyperl, $hashpos, $ora, $type); foreach($fe as $fx) self::Qdbdel($key.'#'.$keyass, $valass, $fx, 1);
                                        } if($fn[$b] < 1) { $fk = Qfx::cancella($fk,$b); $fn = Qfx::cancella($fn,$b); $dir = $Qdatabase.'/'.str_replace('.','/',$per).'/'.$pr.'0'; self::directory($dir,1); Qw($keypers,$fk); self::delink($keyass,$key); } else $fn[$b] = $fn[$b]."\n"; Qw($keypern,$fn); return true;
                                    } else Qfx::error(3,13,$fp[$x],$keypers);
                                }
                            }
                        }
                    } 
                } return false;
            }
        } if($valass != NULL) { if(strpos($keys,',')) { require_once('Qver.php'); $k = explode(',',$keys); for($a=0; $a<count($k); $a++) if(Qver::Qdbver($k[$a],$valass) < 1) return false; for($a=0; $a<count($k); $a++) self::Qdbdel($k[$a],$valass); return true; } else $per = Qfx::combina($key); } else return Qfx::error(3,11,$key);
        if($per) { $keyper = $Qdatabase; $msg = '';
            if($keyass) { 
                if(Qfx::keyvalass($keyass, $valass, $per, 1)) {
                    if($opz != 999){ $perass = Qfx::combina($keyass); 
                        if($perass) { $linkphpass = $per[0]; for($a=1; $a<count($per); $a++) $linkphpass .= '.'.$per[$a]; $hashpos = Qfx::hashpos(Qhash($valass), $perass); $Qlog = $hashpos.'/'.$linkphpass.'.php'; if(file_exists($Qlog)) Qa($Qlog,$ora."\n"); 
                            foreach($perass as $a) $keyper .= '/'.$a; $linkphp = $keyper."/keys.php"; $linkpos = $keyper."/keyn.php"; $fp = file($linkphp); $a = array_search($linkphpass."\n", $fp);
                            if($a > 1) { $fl = file($linkpos); $fl[$a] = ((int)$fl[$a] - 1)."\n"; if(rtrim($fl[$a]) < 1) { $fl = Qfx::cancella($fl, $a); $fp = Qfx::cancella($fp, $a); Qw($linkphp,$fp); } Qw($linkpos,$fl); }
                        }
                    } return true; 
                }
            } else { if(is_array($valass)) { $tmp = $opz; $opz = $valass; $valass = $tmp; } $hashpos = Qfx::hashpos(Qhash($valass), $per); $hashposi = $hashpos.'/index.php'; $hashposk = $hashpos.'/keys.php'; $hashposl = $hashpos.'/link.php';
                if(file_exists($hashposi)){ $fi = file($hashposi); foreach($per as $a) { $keyper .= '/'.$a; $msg .= $a.'.'; } $linkphp = $keyper.'/keys.php'; $linkpos = $keyper.'/keyn.php'; $dirdel = $keyper.'/-0';
                    if(file_exists($hashposk)){ $fkk = file($hashposk); $fll = file($hashposl); $fss = file($linkphp); $fnn = file($linkpos); $fkkdel = array(); $flldel = array();
                        if(is_array($opz)) { $ak = array_keys($opz); $al = array_values($opz); $akk = array(); $all = array(); $as = array(); $ok = false;
                            for($a=0; $a<count($ak); $a++) { if(!Qfx::isnumber($ak[$a]) and $ak[$a][0] != '#') { $al[$a] = $ak[$a]; $ak[$a] = $a; } if(Qfx::isnumber($ak[$a])) { if($al[$a][0] == '#') $as[] = $al[$a]; else { $ky = ''; $x = explode('.',$al[$a]); for($b=0; $b<count($x); $b++) { $j = array_search($x[$b]."\n",$keybase); if($j > 1) $ky .= $j.'.'; } $ky = substr($ky,0,-1); $y = array_search($ky."\n",$fkk); if($y > 1) { $ok = true; $Qlog = $hashpos.'/'.$ky.'.php'; if(file_exists($Qlog)) Qa($Qlog,$ora."\n"); $fkk = Qfx::cancella($fkk,$y); $fll = Qfx::cancella($fll,$y); $x = array_search($ky."\n",$fss); if($x > 1) { $fnn[$x] = (int)$fnn[$x] - 1; if($fnn[$x] < 1) { $fss = Qfx::cancella($fss,$x); $fnn = Qfx::cancella($fnn,$x); } else $fnn[$x] .= "\n"; }}}} else { if($ak[$a][0] == '#') { $akk[] = $ak[$a]; $all[] = $al[$a]; }}}
                            Qw($hashposk,$fkk); Qw($hashposl,$fll); Qw($linkphp,$fss); Qw($linkpos,$fnn); if(count($akk) > 0) { for($a=0; $a<count($akk); $a++) { if(self::Qdbdel($keys.$akk[$a],$all[$a],$valass)) $ok = true; }} if(count($as) > 0) { for($a=0; $a<count($as); $a++) { if(self::Qdbdel($keys.$as[$a],$valass)) $ok = true; }} return $ok;
                        } 
                        for($a=2; $a<count($fkk); $a++) { $j = array_search($fkk[$a], $fss); 
                            if($j > 1) { 
                                if(strlen($fll[$a]) > 64) { // ------------------------------------------------------------------------------------------------- # Link !!!
                                    if($fll[$a][0] == 0) { $m = explode('.', rtrim($fkk[$a])); $ms = rtrim($keybase[$m[0]]); for($x=1; $x<count($m)-1; $x++) $ms .= '.'.rtrim($keybase[$m[$x]]); if(self::Qdbdel($keys.'#'.$ms,$valass,null,888)) { $fkkdel[] = $fkk[$a]; $flldel[] = $fll[$a]; }}
                                }
                            }
                        } $ok = false;
                        if(file_exists($hashposk)){ $fkk = file($hashposk); $fll = file($hashposl); $fss = file($linkphp); $fnn = file($linkpos); 
                            for($a=2; $a<count($fkk); $a++) { $j = array_search($fkk[$a], $fss); 
                                if($j > 1) { $fnn[$j] = rtrim($fnn[$j]); 
                                    if(strlen($fll[$a]) > 64) { // --------------------------------------------------------------------------------------------- @ Clonazione !!!
                                        if($fll[$a][0] == 1) { $f1 = file($Qdatabase.'/'.rtrim($fll[$a]).'/keyc.php'); $f2[0] = $fi[2]; $ok = true; 
                                            for($x=2; $x<count($f1); $x++) { $str = $Qdatabase; $g = explode('.', $f1[$x]); $z = count($g)-1; for($y=0; $y<$z; $y++) $str .= '/'.$g[$y]; $str .= '/'.$msg.'1/v'.rtrim($g[$z]).'.php'; $fp = file($str); $f3 = array_intersect($fp,$f2); $f4 = array_keys($f3); foreach($f4 as $k) $fp[$k] = '-0'.$ora.$fp[$k]; Qw($str,$fp); } $str = $Qdatabase.'/@/'.str_replace('.','/',substr($fkk[$a],0,-2)).'@'; $f1 = Qfx::leggi($Qdatabase.'/'.rtrim($fll[$a]),0,array(-1,0,-1,0,0,0,0),1); $tmp = $str;
                                            for($x=2; $x<count($f1); $x++) { $hash = Qhash(rtrim($f1[$x])); $str = Qfx::lh($str,$hash); $f3 = $str.'/keys.php'; $f4 = $str.'/link.php'; if(file_exists($f3)){ $fk = file($f3); $z = array_search($msg."0\n", $fk); if($z > 1) { $fl = file($f4); $g = Qfx::leggi($Qdatabase.'/'.rtrim($fll[$a]),0,array(-1,0,-1,0,0,0,0),1); $g = Qfx::cancella($g,1); $g = array_unique(Qfx::cancella($g,0)); sort($g); for($b=0; $b<count($g); $b++) { $hash = Qhash(rtrim($g[$b])); $str = $tmp; $str = Qfx::lh($str,$hash); $f5 = $str.'/keys.php'; $f6 = $str.'/link.php'; if(file_exists($f5)){ $mk = file($f5); $z = array_search($msg."0\n", $mk); if($z > 1) { $ml = file($f6); $str = $Qdatabase.'/'.rtrim($ml[$z]); $s = $str.'/in.php'; if(file_exists($s)){ $e = explode('.',Qr($s)); for($c=$e[0]; $c>1; $c--) { $s = $str.'/v'.$c.'.php'; if(file_exists($s)){ $fp = file($s); $z = array_intersect($fp,array('#'.$fi[2])); if($z) { $y = array_keys($z); foreach($y as $k) $fp[$k] = '-0'.$ora.substr($fp[$k],1); Qw($s,$fp); }}}}}}}}}}
                                        }
                                    } else { Qfx::keyvalass($key, $valass, explode('.',rtrim($fkk[$a])), 1, 2); $Qlog = $hashpos.'/'.rtrim($fkk[$a]).'.php'; if(file_exists($Qlog)) Qa($Qlog,$ora."\n"); $fnn[$j] = (int)$fnn[$j] - 1; } if($fnn[$j] < 1) { $fss = Qfx::cancella($fss, $j); $fnn = Qfx::cancella($fnn, $j); } else $fnn[$j] = $fnn[$j]."\n"; 
                                }
                            } Qw($linkphp,$fss); Qw($linkpos,$fnn); 
                        } self::directory($hashpos,0,$dirdel,$ora,$fi[2],$fkkdel,$flldel); $tot = self::elimina($keyper, $fi[2]); if($tot == -1) { $tot = 0; if(!file_exists($keyper.'/keyp.php')) self::directory($keyper,1); else { unlink($keyper.'/keys.php'); unlink($keyper.'/keyn.php'); }} if($ok) { $keyper = $Qdatabase.$Qpostime; $f = rtrim($f2[0]); $op0 = substr($f, 0, 3); $op1 = substr($f, 3, $f[12]); $op2 = substr($f, 3 + $f[12]); $keyper .= '/'.$op0; Qfx::ix($keyper); $keyper .= '/'.$op1; Qfx::ix($keyper); $keyper .= '/'.$op2; $keyperindex = Qfx::ix($keyper); for($x=2; $x<count($fll); $x++) { if(strlen($fll[$x]) > 64) { $fkk = Qfx::cancella($fkk,$x); $fll = Qfx::cancella($fll,$x); $x--; }} Qw($keyper.'/keys.php',$fkk); Qw($keyper.'/link.php',$fll); Qa($keyperindex,$ora); }
                    } else { self::directory($hashpos,0,$dirdel,$ora,$fi[2]); $tot = self::elimina($keyper, $fi[2]); if($tot == -1) $tot = 0; if($type == 999) { $id = file($keyper.'/id.php'); $id[0]--; Qw($keyper.'/id.php',$id[0]); }} if(!Qfx::isnumber($valass)) { $dirdel .= '/'.Qhash($valass).'.php'; if(!file_exists($dirdel)) Qw($dirdel,$Qprotezione); Qa($dirdel,$fi[2]); } return $tot; 
                }
            }
        } return false;
    }
}

?>