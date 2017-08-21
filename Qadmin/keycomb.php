<?php

    if(isset($_POST['key'])) $key = $_POST['key']; else exit;
    if(isset($_POST['pos'])) $pos = $_POST['pos'];
    if(isset($_POST['par'])) $par = $_POST['par'];
    if(isset($_POST['arr'])) $arr = $_POST['arr'];
    
    require_once 'cookie.php'; $keybase = file("$Qdatabase/key.php"); $l = file("$Qdatabase/link.php"); $l1 = array(); $l2 = array(); $l3 = array(); $inv = array(); $val = array(); $link = array(); $y = array(); $x = false;
    for($a=2, $u=count($l); $a<$u; $a++) { $s = explode('#',$l[$a]); if($s[1] == $x) $l3[] = $l[$a]; else { $x = false; if(strpos($s[1],".0\n")) { if(strpos($s[0],'@')) { $s[0] = substr($s[0],0,-2); $l3[] = $s[0].'#'.rtrim($s[1]).".@\n"; } else { if(isset($l[$a+1])) { if(strpos($l[$a+1],'#'.$s[0].".0\n")) { $l2[] = $l[$a]; $a++; $l2[] = $l[$a]; } else $l2[] = $l[$a]; } else $l2[] = $l[$a]; }} elseif(strpos($s[1],".1\n")) { $l3[] = $l[$a]; $x = substr($s[1],0,-2).$s[0].".0\n"; $y[] = rtrim($x); } else $l1[] = $l[$a]; }} $link = array_merge($l1,$l2,$l3);
    
    function keyb($keyb,$k,$arr) { $msg = rtrim($keyb[$arr[0]]); for($a=1; $a<=$k; $a++) if(isset($keyb[$arr[$a]]) && $arr[$a] != 0 && $arr[$a] != 1) $msg .= '.'.rtrim($keyb[$arr[$a]]); return $msg; }
    function note($arr,$lun,$st,$opz,$type,$msg,$note,$nval,$nu) { global $val; $val[$arr][$lun]['block'][$st][$opz][] = array('K' => $msg, 'T' => (int)$nu); $k = $val[$arr][$lun]['block'][$st]['K']."#$type#$msg";
        $j = array_search($k,$note); if($j > 1) $val[$arr][$lun]['block'][$st][$opz][count($val[$arr][$lun]['block'][$st][$opz])-1]['note'] = $nval[$j];
    }
    function tabella($arr, $lun, $key, $keyc, $keyb, $st, $fc, $lk, $nu, $inv, $note, $nval) { global $dirschema; global $val; $arr--; $lun--; $st--; $f = explode('.', $fc); $val[$arr][$lun]['value'] = rtrim($key);
        if(is_array($lk)) { $val[$arr][$lun]['block'][$st] = array('T' => (int)$f[2]); $k = count($keyc)-1; $msg = keyb($keyb,$k,$keyc); $val[$arr][$lun]['block'][$st]['K'] = $msg; if($keyc[$k] == "x\n") $val[$arr][$lun]['block'][$st]['close'] = true;
            if($lk[0]) {
                for($b=0, $u=count($lk); $b<$u; $b++) { $str = explode('#', $lk[$b]); $s2 = explode('.', $str[1]); $k = count($s2)-1; $msg = keyb($keyb,$k,$s2);
                    if($s2[$k] == 0) { 
                        if($inv[$b] == 1) note($arr,$lun,$st,'multiple_auto','ma',$msg,$note,$nval,$nu[$b]); // --------------------- Multipla Automatica
                        elseif($inv[$b] == 2) note($arr,$lun,$st,'cloned_auto_product','cp',$msg,$note,$nval,$nu[$b]); // ----------- Clonata  Automatica Prodotto
                        else note($arr,$lun,$st,'multiple','mu',$msg,$note,$nval,$nu[$b]); // --------------------------------------- Multipla
                    }
                    elseif($s2[$k] == 1) { 
                        if($inv[$b]) { 
                            if($inv[$b] == 3) note($arr,$lun,$st,'cloned_auto_seller','cs',$msg,$note,$nval,$nu[$b]); // ------------ Clonata  Automatica Venditore
                            else note($arr,$lun,$st,'cloned_auto_product','cp',$msg,$note,$nval,$nu[$b]); // ------------------------ Clonata  Automatica Prodotto
                        } else note($arr,$lun,$st,'cloned','cl',$msg,$note,$nval,$nu[$b]); // --------------------------------------- Clonata  Compratore
                    } else note($arr,$lun,$st,'associated','as',$msg,$note,$nval,$nu[$b]); // --------------------------------------- Associata
                }
            }
       } return $val;
    }
    
    if($par == 0) {
        if($arr == 0) { $note = Qchiaro(file("$dirschema/note.php")); $nval = array("\n","\n");
            for($a=2, $ua=count($note); $a<$ua; $a++) { $z = explode('=',$note[$a],2); $x = explode('#',$z[0]);
                $y = explode('.',$x[0]); $x[0] = rtrim($keybase[$y[0]]); for($b=1, $ub=count($y); $b<$ub; $b++) $x[0] .= '.'.rtrim($keybase[$y[$b]]);
                $y = explode('.',$x[2]); $x[2] = rtrim($keybase[$y[0]]); for($b=1, $ub=count($y); $b<$ub; $b++) $x[2] .= '.'.rtrim($keybase[$y[$b]]);
                $note[$a] = $x[0].'#'.$x[1].'#'.$x[2]; $nval[$a] = rtrim($z[1]);
            }
            for($a=1; $a<$pos; $a++) { $tymem = false; $keycomb = Qchiaro(file("$dirschema/$a.php")); $lun = count($keycomb); if($lun > 2) { $str = explode('.', $keycomb[2]); $stt[0] = $str[0]; } else $stt[0] = 0;
                if($lun == 2) $val[$a-1] = array(); else { $d = 0; $st = 0; $tmp = 0;
                    for($c=2; $c<$lun; $c++) { $si = true; $lk = array(0); $nu = array(0); $k = 0; $fc[0] = '0.0.0'; $pc = substr($keycomb[$c], 0, -3); $w = explode('.',$keycomb[$c]); 
                        if($w) { $ty = rtrim(array_pop($w)); if($ty == 1) $tymem = $w[0]; else { if(isset($w[0]) and $w[0] == $tymem) $si = false; else $tymem = false; }} else { $ty = false; $tymem = false; }
                        $kcomb = str_replace('.', '/', $pc).'/in.php'; $kcomb = $Qdatabase.'/'.$kcomb;
                            if(file_exists($kcomb)){ $fc = file($kcomb); $str = explode('.', $pc); $pc = '';
                                if($ty != 1) { for($j=0, $u=count($str); $j<$u; $j++) $pc .= $keybase[$str[$j]].'.'; $pc = substr($pc, 0, -1).'#0.0';
                                    for($j=0, $u=count($link); $j<$u; $j++) { $lnk = explode('#', $link[$j]); $ln = $lnk[0].".0\n"; $r = false;
                                        if($ln == $keycomb[$c]) { $keyperin = $Qdatabase.'/'.str_replace('.', '/', $lnk[0]);
                                            if(strpos($lnk[1],'@')) { $keyper = $Qdatabase.'/@/'.str_replace('.', '/', $lnk[0]).'/@'; $lnk[1] = substr($lnk[1],0,-3)."\n"; $link[$j] = substr($link[$j],0,-4)."1\n"; $r = true; } else $keyper = $keyperin;
                                            if(file_exists("$keyper/keys.php")) { $fk = file("$keyper/keys.php"); $fn = file("$keyper/keyn.php"); $fc = file("$keyperin/in.php"); $x = array_search($lnk[1],$fk);
                                                if($x > 1) { $lk[$k] = rtrim($link[$j]); $nu[$k] = rtrim($fn[$x]); if($r) $inv[$k] = 3; else $inv[$k] = 0; $sp = explode('#', rtrim($link[$j])); if(array_intersect(array($sp[1]),$y)) $inv[$k] = 2; $z = strpos($lnk[1],".0\n"); if($z > 0) { $v = substr($lnk[1],0,$z).'#'.$lnk[0].".0\n"; if($v == $link[$j-1]) $inv[$k] = 1; } $k++; }
                                            }                                
                                        }
                                    }
                                } else { $st = 0; $lk = false; $inv = false; }
                            } else { if($ty != 1) $fc[0] = '0.0.0'; else { $st = 0; $lk = false; $inv = false; }} $str = explode('.', $keycomb[$c]); $ok = false;
                            if(($c + 1) < $lun) $stt = explode('.', $keycomb[$c+1]); if($tmp == $str[0]) { if($st) $st++; else $st = 0; } else { $st = 1; $d++; }
                        if($si) { if(isset($keybase[$str[0]])) tabella($a, $d, $keybase[$str[0]], $str, $keybase, $st, $fc[0], $lk, $nu, $inv, $note, $nval); } $tmp = $str[0];
                    }
                }
            } exit(json_encode($val));
        } else { for($a=2, $ua=count($keybase); $a<$ua; $a++) { if(rtrim($keybase[$a]) == $key) { for($x=1; $x<$pos; $x++) { $keycomb = Qchiaro(file("$dirschema/$x.php")); for($c=2, $uc=count($keycomb); $c<$uc; $c++) { $str = explode('.', $keycomb[$c]); if(rtrim($keybase[$str[0]]) == $key) exit('7'); }} Qa("$dirschema/1.php", Qscuro("$a.0\n"), true); Qsync('*'); exit('1'); }} exit('8'); }
    } else { $par = "$dirschema/$par.php"; $arr = "$dirschema/$arr.php"; if($par != $arr) { for($a=2, $ua=count($keybase); $a<$ua; $a++) { if(rtrim($keybase[$a]) == $key) { $keypar = Qchiaro(file($par)); $keyarr = Qchiaro(file($arr)); $k = count($keyarr); $p = 0; for($b=2, $ub=count($keypar); $b<$ub; $b++) { $str = explode('.', $keypar[$b]); if($a == $str[0]) { $keyarr[$k] = $keypar[$b]; $k++; } else { $kpar[$p] = $keypar[$b]; $p++; }} Qw($par, $Qprotezione); for($d=0; $d<$p; $d++) Qa($par, Qscuro($kpar[$d]), true); Qw($arr, Qscuro($keyarr), true); Qsync('*'); exit('1'); }} exit('9');
        } else { for($a=2, $ua=count($keybase); $a<$ua; $a++) { if(rtrim($keybase[$a]) == $key) { $keypar = Qchiaro(file($par)); $p = 2; $b1 = 0; $b2 = 0; $ok = false; for($b=2, $ub=count($keypar); $b<$ub; $b++) { $str = explode(".", $keypar[$b]); if($a == $str[0]) { if($pos == 3) { $keypar[$b] = substr($keypar[$b],0,-2)."1\n"; Qw($par, Qscuro($keypar), true); Qsync('*'); exit('1'); } elseif($pos == 4) { $keypar[$b] = substr($keypar[$b],0,-2)."0\n"; Qw($par, Qscuro($keypar), true); Qsync('*'); exit('1'); } else { $kb1[$b1] = $keypar[$b]; $b1++; $ok = true; }} else { if($ok == false) { $kcb = $str[0]; $p = $b + 1; } else break; }} 
            if($pos == 1) { $str = explode(".", $keypar[$b]); $kcb = $str[0]; } elseif($pos == 2) { for($c=$p+$b1, $uc=count($keypar); $c<$uc; $c++) $keypar[$c-$b1] = $keypar[$c]; Qw($par, $Qprotezione); for($d=2, $ud=count($keypar)-$b1; $d<$ud; $d++) Qa($par, Qscuro($keypar[$d]), true); Qsync('*'); exit('1'); } for($b=2, $ub=count($keypar); $b<$ub; $b++) { $str = explode(".", $keypar[$b]); if($kcb == $str[0]) { $kb2[$b2] = $keypar[$b]; $b2++; }}
            if($pos == 1) { for($b=$p; $b<($p+$b2); $b++) $keypar[$b] = $kb2[$b-$p]; for($b=$p+$b2; $b<($p+$b2+$b1); $b++) $keypar[$b] = $kb1[$b-$p-$b2]; } else { $p -= $b2; for($b=$p; $b<($p+$b1); $b++) $keypar[$b] = $kb1[$b-$p]; for($b=$p+$b1; $b<($p+$b1+$b2); $b++) $keypar[$b] = $kb2[$b-$p-$b1]; } Qw($par, Qscuro($keypar), true); Qsync('*'); exit('1'); }} exit('9');
        }
    }
?>