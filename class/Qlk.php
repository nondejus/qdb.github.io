<?php

namespace Quantico;

class Qlk extends Qin
{
    protected static function Qarrin($hash, $aln, $aper, $fp, $y, $perass, $index){ $Qlog = $hash.'/'.rtrim($aper).'.php'; Qdel::protezione($Qlog); a($Qlog,$y); $e = explode('.',rtrim($fp)); $perass .= '/.'.$e[0]; Qdel::ix($perass); for($f=1, $u=count($e); $f<$u; $f++) { $perass .= '/'.$e[$f]; Qdel::ix($perass); } Qin::Querin($perass, $aln, $y, $index); }
    protected static function Qarray($akt, $alt, $keyass, $valass, $ora, $hash, $keyper, $per){ global $Qdatabase; global $Qpassword; global $Qlivtime; $msgkeys = ''; $msgcript = ''; $msglink = ''; $z = 0; $n = 2; $aper = false; $si = false; $ak = []; $al = []; $id = []; $dv = []; $ok = []; $fpi = file("$hash/index.php"); $op0 = substr($ora,0,3); $op1 = substr($ora,3,$Qlivtime); $keyper .= '/'.$op0; Qdel::ix($keyper); $keyper .= '/'.$op1; $keyperindex = Qdel::ix($keyper); $keyperpos = "$keyper/id.php"; Qdel::protezione($keyperpos,false,2); $linkphp = "$hash/keys.php"; $linkpos = "$hash/link.php"; $lnk = $per[0]; $perass = $Qdatabase.'/'.$per[0]; for($a=1, $ua=count($per); $a<$ua; $a++) { $lnk .= '.'.$per[$a]; $perass .= '/'.$per[$a]; } $poscript = r($keyperpos); $Qdb = new SYS;
        for($a=0, $ua=count($alt); $a<$ua; $a++) { $alt[$a] = SYS::speciali($alt[$a],1); if($alt[$a] != '') { if($akt[$a][0] == '!') { $ak[] = substr($akt[$a],1); $id[] = false; } else { $ak[] = $akt[$a]; $id[] = true; } $al[] = $alt[$a]; }} for($a=0, $ua=count($ak); $a<$ua; $a++) { SYS::$dataval = false; if($ak[$a][0] == '#') { if(!is_array($al[$a])) $al[$a] = array($al[$a]); if($ak[$a] == "#$keyass" && in_array($valass,$al[$a])) return false; $b = SYS::combina(substr($ak[$a], 1)); if($b) { $aper[$n] = $b[0].".0\n"; $aln[$n] = $al[$a]; $ak[$n-2] = $ak[$a]; $dv[$n-2] = false; $alnk[$n] = $lnk.'#'.$aper[$n]; $n++; }} else { $b = SYS::combina($ak[$a],1); if($b) { $aper[$n] = $b; $aln[$n] = $al[$a]; $ak[$n-2] = $ak[$a]; $dv[$n-2] = SYS::$dataval; $alnk[$n] = $lnk.'#'.$b; if($id[$a]) $ok[$n] = true; else $ok[$n] = false; $n++; }}} SYS::$dataval = false;
        if($aper && file_exists($linkphp)){ $fp = file($linkphp); $fi = file($linkpos); for($x=2, $ux=count($fp); $x<$ux; $x++) { $j = array_search($fp[$x], $aper); if($j > 1) { if(is_array($aln[$j])) { $msglink .= $fi[$x]; $aln[$j] = SYS::u($aln[$j]); if(SYS::isnumber($valass)) { foreach($aln[$j] as $val) if(Qin::Qdbin(substr($ak[$j-2],1).'#'.$keyass,$valass,$val,0)) $si = true; } else { if(Qin::Qdbin($keyass.$ak[$j-2],$aln[$j],$valass,0)) $si = true; }} else { if($aln[$j] == 'false') $y = $ora."f\n"; elseif($aln[$j] == 'true') $y = $ora."t\n"; else { $Qdb->orapos($ora); $y = $Qdb->orapsw.$Qlivtime.$poscript; if($dv[$j-2]) $y .= "_\n"; else $y .= "\n"; $msgcript .= Qcrypt($aln[$j].$Qdb->orapsw, $Qpassword[$Qdb->pospsw])."\n"; $poscript++; } $msglink .= $y; if(SYS::keyvalass($keyass, $valass, explode('.',rtrim($fp[$x])), 1, $y)) $si = true; if($ok[$j]) Qlk::Qarrin($hash, $aln[$j], $aper[$j], $fp[$x], $y, $perass, $fpi[2]); }} else $msglink .= $fi[$x]; } $dif = array_diff($aper, $fp); if($msgcript) { w($keyperpos,$poscript); Qin::sy($keyper,$msgcript); file_put_contents($keyperindex,$msgcript,FILE_APPEND); $msgcript = ''; }
        if($msglink) { global $Qprotezione; w($linkpos,$Qprotezione.$msglink); $msglink = ''; }} else $dif = $aper; if($dif) $difk = array_keys($dif); else $difk = false; if($difk) { $l = str_replace('.', '/', $lnk); $filekeys = "$Qdatabase/$l/keys.php"; $filekeyn = "$Qdatabase/$l/keyn.php"; $msg_keys = ''; $msg_link = ''; Qdel::protezione($filekeys,$filekeyn); $fs = file($filekeys); $fn = file($filekeyn); $lk = file("$Qdatabase/link.php"); foreach($difk as $x) { if(is_array($aln[$x])) { $afk[$z] = $ak[$x-2]; $afl[$z] = $aln[$x]; $z++; } else { if($aln[$x] == 'false') $y = $ora."f\n"; elseif($aln[$x] == 'true') $y = $ora."t\n"; else { $Qdb->orapos($ora); $y = $Qdb->orapsw.$Qlivtime.$poscript; if($dv[$x-2]) $y .= "_\n"; else $y .= "\n"; $msgcript .= Qcrypt($aln[$x].$Qdb->orapsw, $Qpassword[$Qdb->pospsw])."\n"; $poscript++; } $msglink .= $y; if($ok[$x]) Qlk::Qarrin($hash, $aln[$x], $aper[$x], $aper[$x], $y, $perass, $fpi[2]); $msgkeys .= $aper[$x]; $j = array_search($aper[$x], $fs); if($j > 1) $fn[$j] = ((int)$fn[$j] + 1)."\n"; else { $msg_keys .= $aper[$x]; $fn[] = "1\n"; } $j = array_search($alnk[$x], $lk); if($j < 2) $msg_link .= $alnk[$x]; }}
        if($msgcript) { $si = true; w($keyperpos,$poscript); Qin::sy($keyper,$msgcript); file_put_contents($keyperindex,$msgcript,FILE_APPEND); } w($filekeyn,$fn); Qdel::protezione($linkphp,$linkpos); if($msglink) a($linkpos,$msglink); if($msgkeys) a($linkphp,$msgkeys); if($msg_keys) a($filekeys,$msg_keys); if($msg_link) a("$Qdatabase/link.php",$msg_link); } if($z) { for($a=0; $a<$z; $a++) { $afl[$a] = SYS::u($afl[$a]); if(SYS::isnumber($valass)) { foreach($afl[$a] as $val) if(Qin::Qdbin(substr($afk[$a],1).'#'.$keyass,$valass,$val,0)) $si = true; } else { foreach($afl[$a] as $val) if(Qin::Qdbin($keyass.$afk[$a],$val,$valass,0)) $si = true; }}} return $si; }
    protected static function keytab($per, $pos, $opz=0) { global $Qdatabase; $keyper = $Qdatabase; $lnk = ''; if($opz > 1000) $keyper .= '/@'; foreach($per as $a) { $keyper .= '/'.$a; $lnk .= $a.'.'; } $linkphp = "$keyper/keys.php"; $linkpos = "$keyper/keyn.php"; Qdel::protezione($linkphp,$linkpos); $lnk = substr($lnk, 0, -1).'#'.$pos; $lk = file("$Qdatabase/link.php"); $j = array_search($lnk,$lk); if($j < 2) a("$Qdatabase/link.php",$lnk); $fp = file($linkphp); $j = array_search($pos,$fp); if($j > 1) { $fl = file($linkpos); $fl[$j] = ((int)$fl[$j] + 1)."\n"; w($linkpos, $fl); return true; } a($linkphp,$pos); a($linkpos,"1\n"); return true; }
    protected static function multi($keys, $val, $valass, $opz, $ora, $tdb) { $ky = explode('#', $keys, 2); $key = $ky[1]; $keyass = $ky[0]; if($keyass == $key && $valass == $val) return false; global $Qdatabase; $valtmp = []; $n = 0; if($opz > 900) { $per = explode('.',$key); array_pop($per); $val = base64_decode($val); $keyper = $Qdatabase; if($opz > 1000) { $perass = explode('.', $keyass); $perass[] = '@'; } else foreach($per as $p) { $keyper .= '/'.$p; Qdel::ix($keyper); }} else $per = SYS::combina($key);
        if($per) { if($opz < 1001) $perass = SYS::combina($keyass);
            if($perass) { $nick = 0; $valok = false; $b = false; $c = false;
                if(is_array($val)) { if($opz == 666) return false; if($keyass == $key && in_array($valass,$val)) return false; $val = SYS::u($val); foreach($val as $a) if(SYS::isnumber($a)) $b[] = $a; else $c[] = $a;
                    if($c) { if($b) return false; if(!$opz) { foreach($c as $a) if(Qin::Qdbin($key.'#'.$keyass,$valass,$a)) $b = true; return $b; } foreach($c as $a) { $hash = SYS::hashpos(Qhash($a), $per).'/index.php'; if(file_exists($hash)) { $fp = file($hash); $valok[$n] = '#'.rtrim($fp[2]); $valtmp[$n] = $a; $n++; $nick = 998; }}} else { if($b) foreach($b as $a) { $hash = SYS::hashpos(Qhash($a), $per).'/index.php'; if(file_exists($hash)) { $valok[$n] = $a; $n++; }}}
                } else { if(!$opz) { if(SYS::isnumber($val)) { $hash = SYS::hashpos(Qhash($val), $per).'/index.php'; if(file_exists($hash)) { $valok[0] = $val; $n = 1; }} else { if(SYS::isnumber($valass)) return Qin::Qdbin($key.'#'.$keyass,$valass,$val); $hash = SYS::hashpos(Qhash($val), $per).'/index.php'; if(file_exists($hash)) { $fp = file($hash); $valok[0] = '#'.rtrim($fp[2]); $valtmp[0] = $val; $n = 1; $nick = 998; }}} else { if($opz == 666) { $Qdb = new SYS; $Qdb->orapos($ora); $valok[0] = '#'.$this->orapsw.rtrim(Qin::fs($val,$Qdb->orapsw,$Qdb->pospsw)); $n = 1; $nick = 998; $opz = 999; } else { if($opz > 900 && $opz < 1001) { $p = $per; for($a=900; $a<$opz; $a++) $p = SYS::cancella($p,0); $hash = SYS::hashpos(Qhash($val),$p).'/index.php'; } else $hash = SYS::hashpos(Qhash($val),$per).'/index.php'; if(file_exists($hash)) { $fp = file($hash); $valok[0] = '#'.rtrim($fp[2]); $n = 1; $nick = 998; }}}}
                if(!$n) return false; $hashpos = SYS::hashpos(Qhash($valass),$perass,$opz); $keyper = $Qdatabase; $b = $Qdatabase.'/0'; $indexpos = $hashpos.'/index.php'; $vals = $val; $pos = '';
                if(file_exists($indexpos)){ global $Qprotezione; $linkphp = "$hashpos/keys.php"; $linkpos = "$hashpos/link.php"; if(!file_exists($linkphp)){ Qdel::protezione($linkphp,$linkpos); if($opz > 1000) { $tmp = $opz - 1000; a($indexpos,$tmp."\n"); }} foreach($per as $a) { $pos .= $a.'.'; $keyper .= '/'.$a; $b .= '/'.$a; Qdel::ix($b); } $s = $pos; $pos .= "0\n"; $fk = file($linkphp); $q = array_search($pos, $fk);
                    if($q > 1) { $fl = file($linkpos); $dir = $Qdatabase.'/'.rtrim($fl[$q]); $n = 0; $vals = false; 
                        foreach($valok as $val) { if($nick != 998) { if($opz < 901 && SYS::leggi($dir, "$val\n")) Qerror(1,7,$val,$valass,$key,$keyass); else { $tmp = Qdel::scrivi($dir,$ora,"\n",0,"$val\n",0,2,1); if($tmp < 0) { if(SYS::isnumber($val) && SYS::isnumber($valass)) return Qin::Qdbin($key.'#'.$keyass,$valass,$val); else return Qerror(1,6,$keys); } elseif($tmp) { a($dir.'/log.php',$ora.$val."\n"); if(Qlk::keytab($perass,$pos,$opz)) { $vals[$n] = $val; $n++; }} else return false; }} else { if($opz < 901 && SYS::leggi($dir, "$val\n", 0, 1)) Qerror(1,7,$val,$valass,$key,$keyass); else { $tmp = Qdel::scrivi($dir,$ora,"\n",0,"$val\n",0,2,1,1); if($tmp < 1) return Qerror(1,6,$keys); elseif($tmp) { a($dir.'/log.php',$ora.$val."\n"); if(Qlk::keytab($perass,$pos,$opz)) { $vals[$n] = $val; $n++; }} else return false; }}}
                        if($n) { if($opz == 999) return true; $msg = '/'.$perass[0]; for($a=1; $a<count($perass); $a++) $msg .= '.'.$perass[$a]; $msk = $keyper.$msg.'.0'; $dir .= '/keyp.php'; if(!file_exists($dir) || !file_exists($indexpos)) return false; $fp = file($indexpos); $fi = file($dir); $f = explode('.',$fi[2]); $k = rtrim($f[count($f)-1]); $l = $msk.'/v'.$k.'.php'; if(!file_exists($l)) return false; $fop = file($l); $y = array_search($fp[2],$fop); $n = 0; 
                            if($y > 1) { $p = $msk.'/'.$k.'.php'; if(!file_exists($p)) return false; $ftp = file($p); $fop = SYS::cancella($fop,$y); $ftp = SYS::cancella($ftp,$y); w($p,$ftp); w($l,$fop); Qdel::elimina($msk, $k, 2); $f = Qdel::scrivi($msk,$ora,"\n",0,$fp[2],0,0,1); w($dir, $Qprotezione.$s.$f."\n"); if($nick == 998) $vals = $valtmp; 
                                if(!$opz) { if(!is_array($vals)) $vals = array($vals); foreach($vals as $v) Qin::Qdbin($key.'#'.$keyass,$valass,$v,1); } return true; 
                            }
                        } else return false;
                    } else { if($nick != 998) $dir = Qin::crea($b,$valok[0],1,1,2); else $dir = Qin::crea($b,$valok[0],1,1,2,1); w($dir.'/log.php',$Qprotezione.$ora.$valok[0]."\n"); $msg = substr($dir,$tdb); a($linkphp,$pos); a($linkpos,$msg."\n"); $keyperp = $keyper.'/keyp.php'; $msk = $msg; $msg = $perass[0]; for($a=1, $ua=count($perass); $a<$ua; $a++) $msg .= '.'.$perass[$a]; $keyper .= '/'.$msg.'.0'; $msg .= "\n"; Qdel::protezione($keyperp);
                        $fp = file($keyperp); $j = array_search($msg, $fp); if($j < 2) { a($keyperp,$msg); Qdel::ix($keyper); } $fi = file($indexpos); $f = Qdel::scrivi($keyper,$ora,"\n",0,$fi[2],0,0,1); $keyper = "$Qdatabase/$msk/keyp.php"; Qdel::protezione($keyper); a($keyper,$s.$f."\n"); Qlk::keytab($perass,$pos,$opz); if(isset($valtmp[0])) Qin::Qdbin($key.'#'.$keyass,$valass,$valtmp[0],1); 
                    }
                    if($nick == 998) { 
                        for($a=1, $ua=count($valok); $a<$ua; $a++) { $tmp = Qdel::scrivi($dir,$ora,"\n",0,$valok[$a]."\n",0,2,1,1);
                            if($tmp < 0) return false; /* vanno invertiti */ elseif($tmp) { a($dir.'/log.php',$ora.$valok[$a]."\n"); Qlk::keytab($perass,$pos,$opz); if(isset($valtmp[$a])) Qin::Qdbin($key.'#'.$keyass,$valass,$valtmp[$a],1); }
                        }
                    } else { 
                        if(!$opz) Qin::Qdbin($key.'#'.$keyass,$valass,$valok[0],1); else if($opz < 1001) { $n = $hashpos.'/stat.php'; if(!file_exists($n)){ $b = $Qprotezione; for($a=2, $ua=count($fk); $a<$ua; $a++) $b .= "1\n"; $b .= "0\n"; w($n,$b); } else a($n,"0\n"); }
                        $valok = SYS::cancella($valok,0); if($valok) return Qin::Qdbin($keys,$valok,$valass); 
                    } return true;
                }
            }
        } return false; 
    }
}