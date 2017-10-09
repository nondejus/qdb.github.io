<?php

namespace Quantico;

class Qup extends Qin
{
    protected static function key($key, $val, $valass, $pr, $per, $keyper, $tmp, $ora){ $nhashpos = SYS::hashpos(Qhash($val),$per); if(!file_exists($nhashpos)) return false; $nhashposi = "$nhashpos/index.php"; $files = scandir($nhashpos);
        if(file_exists($nhashposi)) { $fi = file($nhashposi); $nhashposk = "$nhashpos/keys.php"; $nhashposl = "$nhashpos/link.php";
            if(Qin::Qdbin($key,$valass)) { global $Qdatabase; $npos = SYS::hashpos(Qhash($valass),$per); $nhashposi = "$npos/index.php"; $i = file($nhashposi);
                if(count($files) > 5) { $files = array_slice($files,2,-3); for($b=0, $ub=count($files); $b<$ub; $b++) copy($nhashpos.'/'.$files[$b],$npos.'/'.$files[$b]); }
                if(file_exists($nhashposk)) { $fk = file($nhashposk); $fl = file($nhashposl); $nhashposk = "$npos/keys.php"; $nhashposl = "$npos/link.php"; w($nhashposk,$fk); w($nhashposl,$fl);
                    for($b=2, $ub=count($fl); $b<$ub; $b++) {
                        if(strlen($fl[$b]) > 64) { $f = explode('/',$fl[$b]);
                            if($f[0] == 0) { $f1 = file($Qdatabase.'/'.rtrim($fl[$b]).'/keyp.php'); $g = explode('.',$f1[2]); $z = count($g) - 1;
                                $npos = $Qdatabase.'/'.$g[0].'/'; for($x=1; $x<$z; $x++) $npos .= $g[$x].'/'; $npos .= $pr.$f[0];
                                $r4 = $npos.'/v'.rtrim($g[$z]).'.php'; $f4 = file($r4); $j = array_search($fi[2],$f4);
                                if($j > 1) { global $Qprotezione; $r5 = $npos.'/'.rtrim($g[$z]).'.php'; $f5 = file($r5); $f4 = SYS::cancella($f4,$j); $f5 = SYS::cancella($f5,$j);
                                    w($r4,$f4); w($r5,$f5); $f6 = Qdel::scrivi($npos,$ora,"\n",0,$i[2],0,0,1); w($Qdatabase.'/'.rtrim($fl[$b]).'/keyp.php',$Qprotezione.$f[1].'.'.$f6."\n");
                                    $npos .= '/in.php'; $g = r($npos); $g = explode('.',$g); $g[1]--; $g[2]--; w($npos,$g[0].'.'.$g[1].'.'.$g[2].'.'.rtrim($g[3])."\n");
                                }
                            } elseif($f[0] == 1) { $f1 = file($Qdatabase.'/'.rtrim($fl[$b]).'/keyc.php'); $f2[0] = $fi[2];
                                for($x=2, $ux=count($f1); $x<$ux; $x++) { $msg = $Qdatabase; $g = explode('.',$f1[$x]); $z = count($g) - 1;
                                    for($y=0; $y<$z; $y++) $msg .= '/'.$g[$y]; $msg .= '/'.$pr.'1/v'.rtrim($g[$z]).'.php'; $fp = file($msg);
                                    $f3 = array_intersect($fp,$f2); $f4 = array_keys($f3); foreach($f4 as $k) $fp[$k] = $i[2]; w($msg,$fp);
                                }
                            }
                        }
                    } if(Qdel::elimina($keyper,$fi[2]) == -1) Qdel::directory($keyper); Qdel::directory($nhashpos);
                } else { Qdel::elimina($keyper,$fi[2]); Qdel::directory($nhashpos); } for($a=count($fi); $a>2; $a--) $fi[$a] = $fi[$a - 1]; $keyper = $tmp.'/'.substr($fi[2],0,3).'/'.substr($fi[2],3,$fi[2][12]);
                $keyv = "$keyper/keyv.php"; $keyn = "$keyper/keyn.php"; Qdel::protezione($keyv,$keyn); a($keyv,$fi[2]); a($keyn,$i[2]); $fi[2] = $i[2]; w($nhashposi,$fi); return true;
            }
        } return false;
    }
}