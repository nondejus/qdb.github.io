<?php

namespace Quantico;

class Qdel extends SYS
{
    private static function ik($per, $val) { w($per,$val[0].'.'.$val[1].'.'.$val[2].'.'.rtrim($val[3])."\n"); }
    private static function ok($keyperin, $keyperindex, $fk, $k) { Qdel::ik($keyperin,$k); if($k[2] < 1) { Qdel::protezione($keyperindex,true); return -1; } else { w($keyperindex,$fk); return $k[2]; }}
    private static function mod2($db, $type, $QprcNum, $keyper, $orapsw) { if($db) $n = floor((int)substr($type,1,10)/$QprcNum); else $n = floor((int)substr($type,0,10)/$QprcNum); $filel = $keyper.'/l'.$n.'.php'; $filet = $keyper.'/t'.$n.'.php'; if(!file_exists($filel)) { global $Qprotezione; w($filel,$Qprotezione.$type); w($filet,$Qprotezione.$orapsw."\n"); } else { Qdel::ia($filel,$type); Qdel::ia($filet,$orapsw."\n"); }}
    private static function opz2($val, $fk, $fi, $keyper, $keyperin, $keyperindex) { $u = count($fk)-1; $n = explode('.', $fk[$val]); $k = explode('.',$fi); $k[2]--; if($val == $u) $k[1]--; if($k[1] < 0) $k[1] = 0; if(count($n) > 2) { $n[2] = (int)$n[2] - 1; if($n[2] < 1) { $fk[$val] = "\n"; unlink($keyper.'/'.$val.'.php'); unlink($keyper.'/v'.$val.'.php'); } else $fk[$val] = $n[0].'.'.$n[1].'.'.$n[2]."\n"; } elseif(count($n) == 2) { if($k[1] < 1) { $fk[$u] = ''; unlink($keyper.'/'.$val.'.php'); unlink($keyper.'/v'.$val.'.php'); }} w($keyperindex,$fk); Qdel::ik($keyperin,$k); if($k[2] < 1) return -1; else return $k[2]; }
    private static function opz999($keyper, $keyass, $valass, $per, $ora) { $perass = SYS::combina($keyass); if($perass) { $linkphpass = $per[0]; for($a=1, $u=count($per); $a<$u; $a++) $linkphpass .= '.'.$per[$a]; $hashpos = SYS::hashpos(Qhash($valass), $perass); $Qlog = "$hashpos/$linkphpass.php"; if(file_exists($Qlog)) a($Qlog,$ora."\n"); foreach($perass as $a) $keyper .= '/'.$a; $linkphp = "$keyper/keys.php"; $linkpos = "$keyper/keyn.php"; $fp = file($linkphp); $a = array_search($linkphpass."\n", $fp); if($a > 1) { $fl = file($linkpos); $fl[$a] = ((int)$fl[$a] - 1)."\n"; if(rtrim($fl[$a]) < 1) { $fl = SYS::cancella($fl, $a); $fp = SYS::cancella($fp, $a); w($linkphp,$fp); } w($linkpos,$fl); }}}
    private static function opzArray($keys, $valass, $opz, $ora, $fkk, $fll, $fss, $fnn, $hashpos, $hashposk, $hashposl, $linkphp, $linkpos) { $ak = array_keys($opz); $al = array_values($opz); $akk = []; $all = []; $as = []; $ok = false;
        for($a=0, $ua=count($ak); $a<$ua; $a++) { if(!SYS::isNumber($ak[$a]) && $ak[$a][0] != '#') { $al[$a] = $ak[$a]; $ak[$a] = $a; } if(SYS::isNumber($ak[$a])) { if($al[$a][0] == '#') $as[] = $al[$a]; else { $ky = SYS::isKey($al[$a]); $y = array_search($ky."\n",$fkk); if($y > 1) { $ok = true; $Qlog = "$hashpos/$ky.php"; if(file_exists($Qlog)) a($Qlog,$ora."\n"); $fkk = SYS::cancella($fkk,$y); $fll = SYS::cancella($fll,$y); $x = array_search($ky."\n",$fss); if($x > 1) { $fnn[$x] = (int)$fnn[$x] - 1; if($fnn[$x] < 1) { $fss = SYS::cancella($fss,$x); $fnn = SYS::cancella($fnn,$x); } else $fnn[$x] .= "\n"; }}}} else { if($ak[$a][0] == '#') { $akk[] = $ak[$a]; $all[] = $al[$a]; }}} w($hashposk,$fkk); w($hashposl,$fll); w($linkphp,$fss); w($linkpos,$fnn); if(count($akk) > 0) { for($a=0, $u=count($akk); $a<$u; $a++) { if(Qdel::Qdbdel($keys.$akk[$a],$all[$a],$valass)) $ok = true; }} if(count($as) > 0) { for($a=0, $u=count($as); $a<$u; $a++) { if(Qdel::Qdbdel($keys.$as[$a],$valass)) $ok = true; }} return $ok;
    }
    protected static function ia($per, $val) { if(file_put_contents($per, $val, FILE_APPEND) > 1) file_put_contents(QFILESYNC, "-$per\n", FILE_APPEND); } // da Modificare NON garantisce il SYNCRO perfetto in caso di spegnimento del Server !!!!!
    protected static function ix($keyper, $opz=false) { $k = "$keyper/index.php"; if(!file_exists($k)){ global $Qprotezione; $p = $Qprotezione; if($opz) $p .= '0'; if(!is_dir($keyper)) mkdir($keyper,0755); file_put_contents($k,$p); } return $k; }
    protected static function directory($dir, $opz=0, $dirdel=0, $ora=0, $id=0, $keydel=0, $linkdel=0) { if(is_dir($dir)) { $files = array_diff(scandir($dir), ['.','..','-0']); if($ora) { if(!is_dir($dirdel)) Qdel::ix($dirdel); Qdel::scrivi($dirdel, $ora, "\n", 0, $id); $id = $ora.rtrim($id); $a = substr($id,0,4); $b = substr($id,4,4); $c = substr($id,8,4); $d = substr($id,12); $dirdel .= "/$a"; if(!is_dir($dirdel)) Qdel::ix($dirdel); $dirdel .= "/$b"; if(!is_dir($dirdel)) Qdel::ix($dirdel); $dirdel .= "/$c"; if(!is_dir($dirdel)) Qdel::ix($dirdel); $dirdel .= "/$d"; if(!is_dir($dirdel)) Qdel::ix($dirdel); foreach($files as $file) { if(is_file("$dir/$file")) copy("$dir/$file","$dirdel/$file"); } if(is_array($keydel)) { a("$dirdel/keys.php",$keydel); a("$dirdel/link.php",$linkdel); }} foreach($files as $file) { (is_dir("$dir/$file")) ? Qdel::directory("$dir/$file") : unlink("$dir/$file"); } if($opz) { Qdel::protezione("$dir/index.php",true); return true; } else return rmdir($dir); } else return false; }
    protected static function scrivi($keyper, $orapsw, $posold, $opz=0, $type=0, $pos=0, $mod=0, $etc=0, $db=0) { global $Qprotezione; $keynum = "$keyper/in.php"; if(file_exists($keynum)){ $kn = r($keynum); $kn = explode('.',$kn); $kn[1]++; $kn[2]++; } else $kn = [2,1,1,"0\n"]; $keypos = $keyper.'/'.$kn[0].'.php'; $kt = $kn[0]; $kp = $kn[1]; if($opz) { if($orapsw <= rtrim($kn[3])) return Qerror(1,2,$orapsw); else $kn[3] = $orapsw; } $keycode = "$keyper/index.php"; $kc = file($keycode); $kcn = count($kc); $tipo = rtrim(substr($kc[1],-2)); if($tipo == '>') { if($type[0] == '#') $kc[1] = rtrim($kc[1])."2\n"; else $kc[1] = rtrim($kc[1])."1\n"; } elseif($tipo == 1 && $type[0] == '#') return -1; elseif($tipo == 2 && is_numeric($type[0])) return -2; $QprcNum = SYS::prcnumber();
        if($kn[1] == 1) { if($opz) $kc[$kcn] = $orapsw.'.'; else $kc[$kcn] = substr($orapsw, 0, 10).'.'; $msg = ''; for($x=0; $x<=$kcn; $x++) $msg .= $kc[$x]; file_put_contents($keycode,$msg); file_put_contents($keypos,$Qprotezione.$orapsw.$posold); if($type) { file_put_contents($keyper.'/v'.$kn[0].'.php',$Qprotezione.$type); if($pos) Qdel::ia($keyper.'/c'.$kn[0].'.php',$Qprotezione.$pos."\n"); if($mod == 2) Qdel::mod2($db,$type,$QprcNum,$keyper,$orapsw); }} else { Qdel::protezione($keypos); Qdel::ia($keypos,$orapsw.$posold); if($type) { $keyv = $keyper.'/v'.$kn[0].'.php'; Qdel::protezione($keyv); Qdel::ia($keyv,$type); if($pos) { $keyc = $keyper.'/c'.$kn[0].'.php'; Qdel::protezione($keyc); Qdel::ia($keyc,$pos."\n"); } if($mod == 2) Qdel::mod2($db,$type,$QprcNum,$keyper,$orapsw); } if($kn[1] > $QprcNum) { if($opz) $kc[$kcn-1] .= $orapsw.'.'.$kn[1]."\n"; else $kc[$kcn-1] .= substr($orapsw, 0, 10).'.'.$kn[1]."\n"; $kp = $kn[1]; $kn[0]++; $kn[1] = 0; $msg = ''; for($x=0; $x<$kcn; $x++) $msg .= $kc[$x]; file_put_contents($keycode,$msg); }} Qdel::ik($keynum,$kn);
        if($mod == 1) { $kp++; return $kt.'.'.$kp; } if($etc == 1) return $kt; elseif($etc == 2) return $kn[2]; else { if($type == 1 && $opz == 1) return $kt; else return $keyper; }}
    protected static function protezione($file1, $file2=false, $opz=false){ if(!file_exists($file1) || $file2 === true) { if(!$opz) { global $Qprotezione; $opz = $Qprotezione; } file_put_contents($file1,$opz); if($file2 && $file2 !== true) file_put_contents($file2,$opz); }}
    protected static function elimina($keyper, $val, $opz=0, $ora=0) { $keyperin = "$keyper/in.php"; $keyperindex = "$keyper/index.php"; $fi = r($keyperin); if(!$fi) return Qerror(3,0,$keyperin); $fk = file($keyperindex); if($opz == 2) return Qdel::opz2($val, $fk, $fi, $keyper, $keyperin, $keyperindex); $k[2] = 1; $y = 0; $del = []; $QprcNum = SYS::prcnumber();
        if(is_array($val)) { $ok = true; $o = false; $fl = []; foreach($val as $v) { if($v[0] == '#') $n = floor((int)substr($v,1,10)/$QprcNum); else $n = floor((int)substr($v,0,10)/$QprcNum); $keyl = "$keyper/l$n.php"; $keyt = "$keyper/t$n.php"; if(!isset($fl['l'.$n])) { $ft['l'.$n] = file($keyt); $fl['l'.$n] = file($keyl); } $j = array_search($v."\n",$fl['l'.$n]); if($j > 1) { $o[] = $n; $vl[] = $v."\n"; $del[] = rtrim($ft['l'.$n][$j]); $fl['l'.$n] = SYS::cancella($fl['l'.$n],$j); $ft['l'.$n] = SYS::cancella($ft['l'.$n],$j); if($ora) Qdel::ia("$keyper/log.php","$ora-$v\n"); }}
            if(is_array($o)) { $val = $vl; $o = SYS::u($o); foreach($o as $n) { w("$keyper/l$n.php", $fl['l'.$n]); w("$keyper/t$n.php", $ft['l'.$n]); }} else return false;
        } else { if($val[0] == '#') $n = floor((int)substr($val,1,10)/$QprcNum); else $n = floor((int)substr($val,0,10)/$QprcNum); if($opz == 0) $del[0] = substr($val, 0, 10); else { $keyl = "$keyper/l$n.php"; $keyt = "$keyper/t$n.php"; $val .= "\n"; if(file_exists($keyl)){ $fl = file($keyl); $j = array_search($val,$fl); if($j > 1) { $ft = file($keyt); $del[0] = rtrim($ft[$j]); $fl = SYS::cancella($fl,$j); $ft = SYS::cancella($ft,$j); w($keyl,$fl); w($keyt,$ft); Qdel::ia("$keyper/log.php","$ora-$val"); } else return false; } else return false; } $val = array($val); $ok = false; } $k = explode('.',$fi);
        for($x=0, $u=count($del); $x<$u; $x++) { for($a=count($fk)-1; $a>1; $a--) { $n = explode('.', $fk[$a]);
            if(count($n) > 2) { if($del[$x] >= $n[0] && $del[$x] <= $n[1]) { if($opz) $key = "$keyper/v$a.php"; else $key = "$keyper/$a.php"; if(file_exists($key)){ $fy = file($key); $j = array_search($val[$x], $fy); if($j > 1) { $n[2] = (int)$n[2] - 1; if($n[2] < 1) { $fk[$a] = "\n"; unlink($key); if($opz) unlink("$keyper/$a.php"); } else { $fk[$a] = $n[0].'.'.$n[1].'.'.$n[2]."\n"; $fy = SYS::cancella($fy, $j); w($key, $fy); if($opz) { $fe = file("$keyper/$a.php"); $fe = SYS::cancella($fe, $j); w("$keyper/$a.php", $fe); }} $k[2]--; if(!$ok) return Qdel::ok($keyperin,$keyperindex,$fk,$k); else $y++; }}}}
            elseif(count($n) == 2) { if($opz) $key = "$keyper/v$a.php"; else $key = "$keyper/$a.php"; if(file_exists($key)){ $fe = file($key); $j = array_search($val[$x], $fe); if($j > 1) { $k[1]--; $k[2]--; $fe = SYS::cancella($fe, $j); w($key, $fe); if($opz) { $fy = file("$keyper/$a.php"); $fy = SYS::cancella($fy, $j); w("$keyper/$a.php", $fy); } if($k[1] < 1) { $fk[$a] = "\n"; unlink($key); if($opz) unlink("$keyper/$a.php"); } if(!$ok) return Qdel::ok($keyperin,$keyperindex,$fk,$k); else $y++; }}}}
        } if($k[2] < 1) Qdel::protezione($keyperindex,true); else w($keyperindex,$fk); Qdel::ik($keyperin,$k); if($ok){ $es[1] = $y; if($k[2] < 1) $es[0] = -1; else $es[0] = 0; return $es; } else return false;
    }
    protected static function Qdbdel($keys=null, $valass=null, $opz=null, $type=0) { if(is_array($opz)){ $tmp = $opz; $opz = $valass; $valass = $tmp; } if(is_array($valass)){ if(is_array($opz) || $opz == null) return Qerror(3,4); } if(is_array($valass)){ for($a=0, $u=count($valass); $a<$u; $a++) { if(isset($valass[$a])) $valass[$a] = SYS::speciali($valass[$a],1); }} else $valass = SYS::speciali($valass,1);
        if(strpos($keys, ' ') > 1) { $ky = explode(' ', $keys, 2); $key = $ky[1]; $keyass = $ky[0]; if($valass == null) return Qerror(3,7,$keys,$keyass); } else { $key = $keys; $keyass = 0; if($valass == null && $opz == null) { if($key[0] == '#') { $per = SYS::combina($key,2).'/id.php'; $keys = (int)r($per); if($keys > 0) { $key = substr($key, 1); if(Qdel::Qdbdel($key, $keys)) return $keys; } return false; } else return Qerror(3,9,$key); } if($key[0] == '#') { $key = substr($key, 1); return Qdel::Qdbdel($key, $valass); }
            if(strpos($keys, '#') > 1) { require_once 'Qer.php'; return Qer::link($keys, $valass, $opz, $type); }
        } if($valass != null) { if($keyass && strpos($key,',')) { $k = explode(',',$key); $ok = false; for($a=0, $u=count($k); $a<$u; $a++) { $k[$a] = trim($k[$a]); if($k[$a][0] != '#' && $k[$a][0] != '@') $k[$a] = ' '.$k[$a]; if(Qdel::Qdbdel($keyass.$k[$a],$valass)) $ok = true; } return $ok; } elseif(strpos($keys,',')) { $k = explode(',',$keys); require_once 'Qver.php'; $Qdb = new SYS; for($a=0; $a<count($k); $a++) if($Qdb->_ver($k[$a],$valass) < 1) return false; for($a=0; $a<count($k); $a++) Qdel::Qdbdel($k[$a],$valass); return true; } else $per = SYS::combina($key); } else return Qerror(3,11,$key);
        if($per) { global $Qdatabase; $keyper = $Qdatabase; $msg = ''; $ora = SYS::time(); 
            if($keyass) { if(SYS::keyvalass($keyass, $valass, $per, 1)) { if($opz != 999) Qdel::opz999($keyper, $keyass, $valass, $per, $ora); return true; }
            } else { if(is_array($valass)) { $tmp = $opz; $opz = $valass; $valass = $tmp; } $hashpos = SYS::hashpos(Qhash($valass), $per); $hashposi = "$hashpos/index.php"; $hashposk = "$hashpos/keys.php"; $hashposl = "$hashpos/link.php";
                if(file_exists($hashposi)){ $fi = file($hashposi); foreach($per as $a) { $keyper .= '/'.$a; $msg .= $a.'.'; } $linkphp = "$keyper/keys.php"; $linkpos = "$keyper/keyn.php"; $dirdel = "$keyper/-0";
                    if(file_exists($hashposk)){ $fkk = file($hashposk); $fll = file($hashposl); $fss = file($linkphp); $fnn = file($linkpos); $fkkdel = []; $flldel = [];
                        if(is_array($opz)) return Qdel::opzArray($keys, $valass, $opz, $ora, $fkk, $fll, $fss, $fnn, $hashpos, $hashposk, $hashposl, $linkphp, $linkpos);
                        for($a=2, $u=count($fkk); $a<$u; $a++) { $j = array_search($fkk[$a], $fss);  // --------------- # Link !!!
                            if($j > 1) { if(strlen($fll[$a]) > 64) { if($fll[$a][0] == 0) { $ms = SYS::kb($fkk[$a], '', 1); if(Qdel::Qdbdel($keys.'#'.$ms,$valass,null,888)) { $fkkdel[] = $fkk[$a]; $flldel[] = $fll[$a]; }}}}} $ok = false;
                        if(file_exists($hashposk)){ $fkk = file($hashposk); $fll = file($hashposl); $fss = file($linkphp); $fnn = file($linkpos);
                            for($a=2, $ua=count($fkk); $a<$ua; $a++) { $j = array_search($fkk[$a], $fss); 
                                if($j > 1) { $fnn[$j] = rtrim($fnn[$j]); 
                                    if(strlen($fll[$a]) > 64) { // ---------------------------------------------------- @ Clonazione !!!  $fkk[$a] $fll[$a]
                                        require_once 'Qer.php'; $ok = Qer::clona($fkk[$a], $fll[$a], $fi, $msg, $ora); $f2 = $ok[1]; $ok = $ok[0];
                                    } else { SYS::keyvalass($key, $valass, explode('.',rtrim($fkk[$a])), 1, 2);
                                        $Qlog = $hashpos.'/'.rtrim($fkk[$a]).'.php'; if(file_exists($Qlog)) a($Qlog,$ora."\n"); $fnn[$j] = (int)$fnn[$j] - 1; 
                                    } if($fnn[$j] < 1) { $fss = SYS::cancella($fss, $j); $fnn = SYS::cancella($fnn, $j); } else $fnn[$j] = $fnn[$j]."\n"; 
                                }
                            } w($linkphp,$fss); w($linkpos,$fnn); 
                        } Qdel::directory($hashpos,0,$dirdel,$ora,$fi[2],$fkkdel,$flldel); $tot = Qdel::elimina($keyper, $fi[2]); if($tot == -1) { $tot = 0; if(!file_exists("$keyper/keyp.php")) Qdel::directory($keyper,1); else { unlink("$keyper/keys.php"); unlink("$keyper/keyn.php"); }} if($ok) { global $Qpostime; $keyper = $Qdatabase.$Qpostime; $f = rtrim($f2[0]); $op0 = substr($f, 0, 3); $op1 = substr($f, 3, $f[12]); $op2 = substr($f, 3 + $f[12]); $keyper .= '/'.$op0; Qdel::ix($keyper); $keyper .= '/'.$op1; Qdel::ix($keyper); $keyper .= '/'.$op2; $keyperindex = Qdel::ix($keyper); for($x=2; $x<count($fll); $x++) { if(strlen($fll[$x]) > 64) { $fkk = SYS::cancella($fkk,$x); $fll = SYS::cancella($fll,$x); $x--; }} w("$keyper/keys.php",$fkk); w("$keyper/link.php",$fll); a($keyperindex,$ora); }
                    } else { Qdel::directory($hashpos,0,$dirdel,$ora,$fi[2]); $tot = Qdel::elimina($keyper, $fi[2]); if($tot == -1) $tot = 0; if($type == 999) { $keyper .= '/id.php'; $id = r($keyper); $id = (int)$id - 1; file_put_contents($keyper,$id); }} if(!SYS::isNumber($valass)) { $dirdel .= '/'.Qhash($valass).'.php'; Qdel::protezione($dirdel); a($dirdel,$fi[2]); } return $tot; 
                }
            }
        } return false;
    }
}