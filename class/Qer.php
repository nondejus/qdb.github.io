<?php

namespace Quantico;

class Qer extends Qdel
{
    
    protected static function delink($keyass, $key) { global $Qdatabase; $fp = file("$Qdatabase/link.php"); $link = rtrim(SYS::combina($keyass,1)).'#'.rtrim(SYS::combina($key,1)).".0\n"; $j = array_search($link,$fp); if($j > 1) { $fp = SYS::cancella($fp,$j); w("$Qdatabase/link.php",$fp); }}
    protected static function elimina_adesso($file, $per, $ora, $opz=false) { $es = false; $file = file($file); for($a=2, $u=count($file); $a<$u; $a++) { $es = Qdel::elimina($per, '#'.rtrim($file[$a]), 1, $ora); if($es) break; if($opz){ $es = Qdel::elimina($p, rtrim($m[$a]), 1, $ora); if($es) break; }} return $es; }
    protected static function delete($fp, $fl, $x, $p, $pr, $keypery, $keyperl, $hashpos, $ora=0, $type=0) { global $Qdatabase; global $Qlivtime; if(count($fp) == 3) { unlink($keypery); unlink($keyperl); } else { $fp = SYS::cancella($fp,$x); $fl = SYS::cancella($fl,$x); w($keypery,$fp); w($keyperl,$fl); } $f1 = file("$hashpos/index.php"); $f2 = file("$p/keyp.php"); $f = explode('.', $f2[2]); $x = count($f)-1; $r4 = $Qdatabase.'/'; for($a=0; $a<$x; $a++) $r4 .= $f[$a].'/'; $r = $pr.'0'; $rf = rtrim($f[$x]); $r5 = "$r4$r/v$rf.php";
        if(file_exists($r5)) { $f5 = file($r5); $j = array_search($f1[2], $f5); if($j > 1) { $f4 = file("$r4$r/$rf.php"); $f5 = SYS::cancella($f5,$j); $f4 = SYS::cancella($f4,$j); w($r5,$f5); w("$r4$r/$rf.php",$f4); if($ora) { $x = substr($p,strlen($Qdatabase)+3); $f = explode('/', $x); $pr = $ora.'-'.$f[0].'.'; for($a=1, $u=count($f)-$Qlivtime-1; $a<$u; $a++) $pr .= $f[$a].'.'; copy("$p/log.php",$hashpos.'/'.$pr.'0.php'); } Qdel::elimina($r4.$r, $rf, 2); if($type != 888) Qdel::directory($p); }}
    }
    protected static function link($keys, $valass, $opz, $type) { $ky = explode('#', $keys, 2); $key = $ky[1]; $keyass = $ky[0]; if($type > 1000) { $per = substr($key,0,-2)."\n"; $valass = base64_decode($valass); } else $per = SYS::combina($key,1);
        if($per) { if($type == 1971) $perass = explode('.',$keyass); else $perass = SYS::combina($keyass);
            if($perass) { if($opz !== null) $hash = Qhash($opz); else $hash = Qhash($valass); $hashpos = SYS::hashpos($hash, $perass); $keypery = $hashpos.'/keys.php'; $keyperl = $hashpos.'/link.php';
                if(file_exists($keypery)){ $fp = file($keypery); $per = rtrim($per); $x = array_search($per.".0\n", $fp); 
                    if($x > 1) { global $Qdatabase; $fl = file($keyperl); $p = $Qdatabase.'/'.rtrim($fl[$x]); $keyper = $Qdatabase; $pr = ''; foreach($perass as $b) { $keyper .= '/'.$b; $pr .= $b.'.'; } $keypers = $keyper.'/keys.php'; $keypern = $keyper.'/keyn.php';
                        if(file_exists($keypers)){ $fk = file($keypers); $fn = file($keypern); $b = array_search($fp[$x],$fk);
                            if($b > 1) { $fn[$b] = rtrim($fn[$b]); $ora = SYS::time();
                                if($opz !== null) {
                                    if(is_array($valass)) { $valass = SYS::u($valass); $valok = false; $valstr = false; foreach($valass as $a) if(SYS::isNumber($a)) $valok[] = $a; else $valstr[] = $a;
                                        if($valok || $valstr) { if($valok) { $es = Qdel::elimina($p, $valok, 1, $ora); if(is_array($es)) { $fn[$b] = $fn[$b] - $es[1]; if($es[0] == -1) Qer::delete($fp, $fl, $x, $p, $pr, $keypery, $keyperl, $hashpos, $ora); } else return false; foreach($valok as $fx) Qdel::Qdbdel($key.'#'.$keyass, $opz, $fx, 1); }
                                            if($valstr) { $pe = SYS::combina($key); foreach($valstr as $fx) { $fm = SYS::hashpos(Qhash($fx), $pe).'/index.php'; if(file_exists($fm)) $es = Qer::elimina_adesso($fm, $p, $ora); else { $dirdel = SYS::combina($key,2).'/-0/'.Qhash($fx).'.php'; if(file_exists($dirdel)) $es = Qer::elimina_adesso($dirdel, $p, $ora); } if($es) { if($es == -1) { Qer::delete($fp, $fl, $x, $p, $pr, $keypery, $keyperl, $hashpos, $ora); $fn[$b] = 0; break; } else $fn[$b] = (int)$fn[$b]-1; }}}
                                        } else return false;
                                    } else { if(SYS::isNumber($valass)) { if($type == 1) { $fm = SYS::hashpos(Qhash($valass), SYS::combina($key)).'/index.php'; if(file_exists($fm)){ $m = file($fm); $valass = '#'.rtrim($m[2]); }} $es = Qdel::elimina($p, $valass, 1, $ora); 
                                        } else { if($type > 1000) { if($type == 1971) $pe = $Qdatabase.'/'.str_replace('.','/',$per); else { $type -= 1000; $pe = $Qdatabase; $ky = explode('.',$key); for($a=$type, $u=count($ky)-1; $a<$u; $a++) $pe .= '/'.$ky[$a]; } $hashpr = SYS::lh($pe,Qhash($valass)); } else $hashpr = SYS::hashpos(Qhash($valass), SYS::combina($key)); $fm = "$hashpr/index.php";
                                            if(file_exists($fm)){ $es = Qer::elimina_adesso($fm, $p, $ora); } else { $type = true; $dirdel = SYS::combina($key,2).'/-0/'.Qhash($valass).'.php'; if(file_exists($dirdel)) $es = Qer::elimina_adesso($dirdel, $p, $ora, true); else return false; }
                                        } if($es) { if(is_array($es)) { $fn[$b] = $fn[$b] - $es[1]; $es = $es[0]; } else $fn[$b] = (int)$fn[$b] - 1; } else return false; if($es == -1) { if($type == 1971) $pr = substr($pr,2); Qer::delete($fp, $fl, $x, $p, $pr, $keypery, $keyperl, $hashpos, $ora); } if(!$type) Qdel::Qdbdel($key.'#'.$keyass,$opz,$valass,1); 
                                    }
                                } else { $fe = []; $fx = SYS::leggi($p,0,[-1,0,-1,0,0,0,0],1); for($a=2, $u=count($fx); $a<$u; $a++) $fe[$a-2] = rtrim($fx[$a]); if($type != 888) $es = Qdel::elimina($p, $fe, 1, $ora); else $es = [0,count($fe)]; if($es) { if(is_array($es)) $fn[$b] = $fn[$b] - $es[1]; else $fn[$b] = (int)$fn[$b] - 1; } else return false; Qer::delete($fp, $fl, $x, $p, $pr, $keypery, $keyperl, $hashpos, $ora, $type); foreach($fe as $fx) { Qdel::Qdbdel($key.'#'.$keyass, $valass, $fx, 1); }}
                                if($fn[$b] < 1) { $fk = SYS::cancella($fk,$b); $fn = SYS::cancella($fn,$b); $dir = $Qdatabase.'/'.str_replace('.','/',$per).'/'.$pr.'0'; Qdel::directory($dir,1); w($keypers,$fk); Qer::delink($keyass,$key); } else $fn[$b] = $fn[$b]."\n"; w($keypern,$fn); return true;
                            } else return Qerror(3,13,$fp[$x],$keypers);
                        }
                    }
                }
            } 
        } return false;
    }
    protected static function clona($fkk, $fll, $fi, $msg, $ora) { global $Qdatabase; $ok = false; $f2 = [];
        if($fll[0] == 1) { $f1 = file($Qdatabase.'/'.rtrim($fll).'/keyc.php'); $f2[0] = $fi[2]; for($x=2, $ux=count($f1); $x<$ux; $x++) { $str = $Qdatabase; $g = explode('.', $f1[$x]); $z = count($g)-1; for($y=0; $y<$z; $y++) $str .= '/'.$g[$y]; $str .= '/'.$msg.'1/v'.rtrim($g[$z]).'.php'; $fp = file($str); $f3 = array_intersect($fp,$f2); $f4 = array_keys($f3); foreach($f4 as $k) $fp[$k] = '-0'.$ora.$fp[$k]; w($str,$fp); } $str = $Qdatabase.'/@/'.str_replace('.','/',substr($fkk,0,-2)).'@'; $f1 = SYS::leggi($Qdatabase.'/'.rtrim($fll),0,[-1,0,-1,0,0,0,0],1); $tmp = $str;
            for($x=2, $ux=count($f1); $x<$ux; $x++) { $str = SYS::lh($str,Qhash(rtrim($f1[$x]))); $f3 = "$str/keys.php"; $f4 = "$str/link.php"; 
                if(file_exists($f3)){ $fk = file($f3); $z = array_search($msg."0\n", $fk); 
                    if($z > 1) { $fl = file($f4); $g = SYS::leggi($Qdatabase.'/'.rtrim($fll),0,[-1,0,-1,0,0,0,0],1); $g = SYS::cancella($g,1); $g = array_unique(SYS::cancella($g,0)); sort($g); 
                        for($b=0, $ub=count($g); $b<$ub; $b++) { $str = SYS::lh($tmp,Qhash(rtrim($g[$b]))); $f5 = "$str/keys.php"; $f6 = "$str/link.php"; 
                            if(file_exists($f5)){ $mk = file($f5); $z = array_search($msg."0\n", $mk); if($z > 1) { $ml = file($f6); $str = $Qdatabase.'/'.rtrim($ml[$z]); $e = r("$str/in.php"); if($e){ $e = explode('.',$e); for($c=$e[0]; $c>1; $c--) { $s = "$str/v$c.php"; if(file_exists($s)){ $fp = file($s); for($d=2, $ud=count($fi); $d<$ud; $d++) { $z = array_intersect($fp,['#'.$fi[$d]]); if($z) { $y = array_keys($z); foreach($y as $k) $fp[$k] = "-0$ora".$fi[2]; w($s,$fp); $ok = true; break; }}}}}}}
                        }
                    }
                }
            }
        } return [$ok,$f2];
    }
}