<?php

    if(isset($_POST['type'])) $type = $_POST['type']; else exit;
    if(isset($_POST['old'])) $old = $_POST['old'];
    if(isset($_POST['pos'])) $pos = $_POST['pos'];
    if(isset($_POST['val'])) $val = $_POST['val'];
    
    require_once 'cookie.php'; $Qkeybase = file("$Qdatabase/key.php"); $cestino = file("$Qdatabase/trash.php"); $lkb = count($Qkeybase); $msg='';
    
    function keypos($key){ global $Qkeybase; $x = explode('#',$key); $y = '';
        $key = explode('.', $x[0]); for($a=0, $u=count($key); $a<$u; $a++) { $j = array_search($key[$a]."\n",$Qkeybase); if($j > 1) $y .= $j.'.'; } $y = substr($y,0,-1).'#'.$x[1].'#';
        $key = explode('.', $x[2]); for($a=0, $u=count($key); $a<$u; $a++) { $j = array_search($key[$a]."\n",$Qkeybase); if($j > 1) $y .= $j.'.'; } return substr($y,0,-1);
    }
    function keybase($key=false){ global $dirschema; if($key) { global $Qdatabase; $Qkeybase = file("$Qdatabase/key.php"); Qw("$dirschema/key.php", $key, true); } else { global $Qkeybase; $key = file("$dirschema/key.php"); }
        for($a=2, $ua=count($key); $a<$ua; $a++) { $y = rtrim($key[$a]); if($y) { $x = explode(' ',$y); for($b=0, $ub=count($x); $b<$ub; $b++) { if(isset($Qkeybase[$x[$b]])) $msg[$a-2][$b] = rtrim($Qkeybase[$x[$b]]); else $msg[$a-2][$b] = ''; }} else $msg[$a-2] = array(); } Qsync('*'); return json_encode($msg); 
    }
    function keycheck($key){ global $Qkeybase; global $cestino; global $lkb; $lun = strlen($key); if($lun < 2 or $lun > 14) return 2; // --------------------- KEY troppo corta o troppo lunga
        if(is_numeric($key) and strpos('.', $key) !== false) return 3; // ------------------------------------------------------------------------------------ KEY con caratteri non consentiti
        if(strpos('1234567890-_#@$.', $key[0]) !== false) return 11; // -------------------------------------------------------------------------------------- KEY con caratteri non consentiti
        for($a=1; $a<$lun; $a++) if(strpos('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890-_', $key[$a]) === false) return 3; // ------------- KEY con caratteri non consentiti
        for($a=2; $a<$lkb; $a++) if($key == rtrim($Qkeybase[$a]) or $key == rtrim($cestino[$a])) return 4; return false; // ---------------------------------- KEY esiste già
    }
    function prohibited($val){ $commands = ['eval','system','copy','chmod','chown','chgrp','base64','decode','unlink','readfile','fopen','file_get_','file_put_'];
        foreach($commands as $command) if(strpos($val, $command) !== false) exit('<h1>-:|:- Prohibited -:|:-</h1>');
    }
    if($type == 1){ // --------------------------------------------------------------------------------------------------------------------------------------- JSON ---> Costruzione del menu ( KEY Base - 7 parti )
        exit(keybase());
    } elseif($type == 2){ $key = keycheck($val); if($key) { echo $key; exit; } // ---------------------------------------------------------------------------- NUOVA ---> KEY Base
        $fi = "$Qdatabase/$lkb/index.php"; if(!file_exists($fi)){ mkdir("$Qdatabase/$lkb",0755); Qw($fi, $Qprotezione); }
        $fi = "$Qdatabase/$lkb/id.php"; if(!file_exists($fi)) Qw($fi, 0, true); Qa("$Qdatabase/key.php", $val."\n", true); Qa("$Qdatabase/trash.php", "\n", true); $old++;
        $key = file("$dirschema/key.php"); $key[$old] = rtrim($key[$old]); if($key[$old]) $key[$old] .= " $lkb\n"; else $key[$old] = "$lkb\n"; exit(keybase($key));
    } elseif($type == 3){ // --------------------------------------------------------------------------------------------------------------------------------- CANCELLA ---> KEY Base
        for($a=2; $a<$lkb; $a++) {
            if($val == rtrim($Qkeybase[$a])) { $cestino[$a] = $Qkeybase[$a]; $Qkeybase[$a] = "\n"; Qw("$Qdatabase/key.php", $Qkeybase, true); Qw("$Qdatabase/trash.php", $cestino, true); $tmp = $a; $key = file("$dirschema/key.php"); $pos++; $x = explode(' ',rtrim($key[$pos])); $j = array_search($a,$x); 
                if($j !== false) { $x = Qcancella($x,$j); $key[$pos] = ''; if($x) { $y = count($x)-1; for($a=0; $a<$y; $a++) $key[$pos] .= $x[$a].' '; $key[$pos] .= $x[$y]; } $key[$pos] .= "\n"; for($b=1; $b<$old; $b++) { $keycomb = Qchiaro(file("$dirschema/$b.php")); $k = 0; for($c=2, $uc=count($keycomb); $c<$uc; $c++) { $str = explode('.', $keycomb[$c]); $kct[$k] = ''; for($s=0, $us=count($str)-1; $s<$us; $s++) if($tmp != $str[$s]) $kct[$k] .= $str[$s].'.'; else break; if($kct[$k] != '') $kct[$k] .= "0\n"; $k++; } if($k) { Qw("$dirschema/$b.php",$Qprotezione); for($d=0; $d<$k; $d++) if($kct[$d]) Qa("$dirschema/$b.php", Qscuro($kct[$d]), true); }} exit(keybase($key)); }
            }
        } exit('0');
    } elseif($type == 4){ // --------------------------------------------------------------------------------------------------------------------------------- CAMBIA LINGUA al Pannello Amministrativo
        if($dbtype[4] == "it\n") $dbtype[4] = "en\n"; else $dbtype[4] = "it\n"; Qw('config.php',$dbtype); exit('OK');
    } elseif($type == 5){ $key = keycheck($val); if($key) { echo $key; exit; } // ---------------------------------------------------------------------------- RINOMINA ---> KEY Base
        for($a=2; $a<$lkb; $a++) { if($old == rtrim($Qkeybase[$a])) { $key = file("$dirschema/key.php"); $pos++; $x = explode(' ',rtrim($key[$pos])); $j = array_search($a,$x); $x[$j] = $a; $Qkeybase[$a] = $val."\n"; $key[$pos] = ''; $y = count($x)-1; for($b=0; $b<$y; $b++) $key[$pos] .= $x[$b].' '; $key[$pos] .= $x[$y]."\n"; Qw("$Qdatabase/key.php", $Qkeybase, true); exit(keybase($key)); }} exit('6');
    } elseif($type == 6){ Qw("$Qdatabase/trash.php", $Qprotezione); for($a=2, $u=count($cestino); $a<$u; $a++) Qa("$Qdatabase/trash.php", "\n", true); Qsync('*'); exit('1');
    } elseif($type == 7){ $msg = '<table id="keycest" border="0" width="43%" cellspacing="0" cellpadding="0" bgcolor="#FFF" style="border: 1px solid #FCC"><tr><td align="center"><h6>'; for($b=2, $u=count($cestino); $b<$u; $b++) { $c = rtrim($cestino[$b]); if($c != '') $msg .= '<a href="javascript:salva('.$b.',5)"><span id="ce'.$b.'">'.$c.'</span></a><br>'; } $lng = file('language/'.rtrim($dbtype[4]).'/keybase.php',FILE_IGNORE_NEW_LINES); $msg .= '<br><a href="javascript:salva(0,6)"><font color="#F00"><b>'.$lng[3].'</b></font></a></h6></td></tr></table>'; exit($msg);
    } elseif($type == 8){ if($val == rtrim($cestino[$old])) { $Qkeybase[$old] = $cestino[$old]; $cestino[$old] = "\n"; Qw("$Qdatabase/key.php", $Qkeybase, true); Qw("$Qdatabase/trash.php", $cestino, true); $key = file("$dirschema/key.php"); $key[2] = rtrim($key[2]); if($key[2]) $key[2] .= ' '.$old."\n"; else $key[2] = $old."\n"; exit(keybase($key)); } else exit('10');
    } elseif($type == 9){ $key = file("$dirschema/key.php"); $pos++; $x = explode(' ',rtrim($key[$pos])); $tmp = $x[$val]; $x[$val] = $x[$old]; $x[$old] = $tmp; $key[$pos] = ''; $y = count($x)-1; for($a=0; $a<$y; $a++) $key[$pos] .= $x[$a].' '; $key[$pos] .= $x[$y]."\n"; exit(keybase($key));
    } elseif($type == 10){ $key = file("$dirschema/key.php"); $val++; $old++; $pos--; $x = explode(' ',rtrim($key[$val])); $key[$old] = rtrim($key[$old]); if($key[$old]) $key[$old] .= ' '.$x[$pos]."\n"; else $key[$old] = $x[$pos]."\n"; $x = Qcancella($x,$pos); $y = count($x)-1; if($y > 0) { $key[$val] = ''; for($a=0; $a<$y; $a++) $key[$val] .= $x[$a].' '; $key[$val] .= $x[$y]."\n"; } else $key[$val] = "\n"; exit(keybase($key));
    } elseif($type == 11){ $val = json_decode($val); if(strpos($val, '"') !== false && strpos($val, "'") !== false) exit('<h1>-:|:- Prohibited -:|:-</h1>'); prohibited($val); $fp = file("$dirschema/command.php"); $fp[$pos] = $val."\n"; $val = str_replace('Q\\','Quantico\\',$val); $str = '<?php require "../../Quantico'.$tmp.'.php"; if(!isset($_COOKIE["Qdb#admin"]) || $Qckadm != $_COOKIE["Qdb#admin"]) exit; $val = '.$val.'; echo "<pre>"; print_r($val); echo "</pre>"; ?>'; $cmd = '<?php $val = '.$val.'; ?>'; Qw('temp/risultato.php', $str); Qw('temp/valore.php', $cmd); Qw("$dirschema/command.php", $fp, true); Qsync('*'); exit('OK');
    } elseif($type == 12){ $keyc = "'".str_replace(" ", "','", rtrim($pos))."'"; $str = '<?php require "../../Quantico'.$tmp.'.php"; $val = Quantico\DB::out(\''.$old.'\',array('.$keyc.'),\''.$val.'\'); echo "<pre>"; print_r($val); echo "</pre>"; ?>'; Qw('temp/risultato.php', $str); exit('1');
    } elseif($type == 13){ $k = explode('|',substr($pos,0,-1)); $v = explode(' ',rtrim($val)); $str = '<?php require "../../Quantico'.$tmp.'.php"; $val = Quantico\DB::out(\''.$old.'\',array('; $b = -1; foreach($k as $a) { $b++; if(strpos($a, ',')) { $a = "'".str_replace(",", "','", $a)."'"; $str .= "'$v[$b]' => array($a),"; } else $str .= "'$v[$b]' => '$a'"; } $str .= ')); echo "<pre>"; print_r($val); echo "</pre>"; ?>'; Qw('temp/risultato.php', $str); exit('1');
    } elseif($type == 14){ if($val) { if($val == 7) $val = 4; else $val = 7; $fp = file('config.php'); $fp[5] = $val."\n"; Qw('config.php',$fp); } $val = array(); $fp = file("$dirschema/command.php"); $val['create'] = date('d M Y',substr(rtrim($fp[1]),-10)); for($a=2, $u=count($fp); $a<$u; $a++) $val['command'][] = rtrim($fp[$a]); exit(json_encode($val));
    } elseif($type == 15){ $ok = true; $per = "$dirschema/note.php"; $pos = keypos($pos); $key = file($per); $fp = Qchiaro($key); for($a=2, $u=count($fp); $a<$u; $a++) { $x = explode('=',$fp[$a]); if($pos == $x[0]) { $key[$a] = Qscuro("$pos=$val"); $ok = false; break; }} if($ok) Qa($per, Qscuro("$pos=$val"), true); else Qw($per, $key, true); Qsync('*'); exit('OK');
    } elseif($type == 16){ $ok = true; $per = "$dirschema/note.php"; $pos = keypos($pos); $key = file($per); $fp = Qchiaro($key); for($a=2, $u=count($fp); $a<$u; $a++) { $x = explode('=',$fp[$a]); if($pos == $x[0]) { $key = Qcancella($key,$a); $ok = false; break; }} if($ok) exit('24'); else { Qw($per, $key, true); Qsync('*'); exit('OK'); }
    } elseif($type == 17){ if($dbtype[6] == "1\n") $dbtype[6] = "0\n"; else $dbtype[6] = "1\n"; Qw('config.php',$dbtype); exit('OK'); } // Animazione SI / NO
?>