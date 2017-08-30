<?php
    
    if(isset($_POST['id'])) $id = $_POST['id']; else exit;
    if(isset($_POST['pos'])) $pos = $_POST['pos']; else exit;
    if(isset($_POST['key'])) $key = $_POST['key']; else exit;
    
    require_once 'cookie.php'; $per = $Qdatabase.'/';
    
    function Qdirectory($dir) { $files = array_diff(scandir($dir), array('.','..')); $lista = array(); foreach ($files as $file) { (is_dir($dir.'/'.$file)) ? Qdirectory($dir.'/'.$file) : $lista[] = $file; } return $lista; }
    
    if($id == "s" and $pos == "e" and $key == "r") { // ORA del Server
        $utc = array(-43200 => '-12',-41400 => '-11:30',-39600 => '-11',-37800 => '-10:30',-36000 => '-10',-34200 => '-9:30',-32400 => '-9',-30600 => '-8:30',-28800 => '-8',-27000 => '-7:30',-25200 => '-7',-23400 => '-6:30',-21600 => '-6',-19800 => '-5:30',-18000 => '-5',-16200 => '-4:30',-14400 => '-4',-12600 => '-3:30',-10800 => '-3',-9000 => '-2:30',-7200 => '-2',-5400 => '-1:30',-3600 => '-1',-1800 => '-0:30',0 => '+0',1800 => '+0:30',3600 => '+1',5400 => '+1:30',7200 => '+2',9000 => '+2:30',10800 => '+3',12600 => '+3:30',14400 => '+4',16200 => '+4:30',18000 => '+5',19800 => '+5:30',20700 => '+5:45',21600 => '+6',23400 => '+6:30',25200 => '+7',27000 => '+7:30',28800 => '+8',30600 => '+8:30',31500 => '+8:45',32400 => '+9',34200 => '+9:30',36000 => '+10',37800 => '+10:30',39600 => '+11',41400 => '+11:30',43200 => '+12',45900 => '+12:45',46800 => '+13',49500 => '+13:45',50400 => '+14');
        $agg = file('config.php'); $cnf = file($dirqdb.'Qconfig.php'); $cn = substr($cnf[10],8,-2); $pos = strtotime(gmdate("M d Y H:i:s", time())) + $cn; $tmp['ora'] = date('H:i', $pos); $tmp['utc'] = 'UTC'.$utc[$cn]; $tmp['agg'] = (int)$agg[2]; $tmp['def'] = $Qposdef; $tmp['max'] = $Qposmax; $tmp['man'] = substr($cnf[18],16,-2); if($Qidkey) $tmp['autorip'] = 0; else $tmp['autorip'] = 1; exit(json_encode($tmp));
    }
    elseif($id == "a" and $pos == "g" and $key == "g") {
        $agg = file('config.php'); if($agg[2] == "1\n") $agg[2] = "0\n"; else $agg[2] = "1\n"; Qw('config.php',$agg); exit(rtrim($agg[2]));
    }
    elseif($id == "l" and $key == "c") { $tmp = 'UTC'.$pos; // ORA Locale
        if(strpos($pos,":")){ $sl = explode(":", $pos); $Qgmt = $sl[0] * 3600; if($sl[0] < 1) { if($tmp == 'UTC+0:30') $Qgmt += $sl[1] * 60; else $Qgmt -= $sl[1] * 60; } else $Qgmt += $sl[1] * 60; } else $Qgmt = $pos * 3600;
        $cnf = file($dirqdb.'Qconfig.php'); $cnf[10] = '$Qgmt = '.$Qgmt.";\n"; Qw($dirqdb.'Qconfig.php', $cnf, true); $pos = $Qgmt + strtotime(gmdate("M d Y H:i:s", time())); Qsync('*'); exit(date('H:i', $pos).'#'.$tmp);
    }
    elseif($id == "o" and $pos == "u" and $key == "t") { // LOGOUT
        setcookie('Qdb#admin', null, time()-3600); if(file_exists($dirqdb.'Qsession.php')) unlink($dirqdb.'Qsession.php'); exit('1');
    }
    elseif($id == "c" and $pos == "a" and $key == "m") { $b = mt_rand(32,48); $db = Qgp($b,'0123456789-abcdefghijklmnopqrstuvwxyz_ABCDEFGHIJKLMNOPQRSTUVWXYZ'); $db = $dirqdb.$db; $fp = file($dirqdb.'Qconfig.php'); $fp[4] = '$Qdatabase = "'.$db.'";'."\n"; 
        rename($Qdatabase,$db); rename("$Qdatabase-test","$db-test"); if(file_exists("$Qdatabase-clone")) rename("$Qdatabase-clone","$db-clone"); Qw($dirqdb.'Qconfig.php', $fp, true); Qsync('*'); exit('1');
    }
    elseif($id == "s" and $pos == "i" and $key == "c") { // sicurezza massima se NO ---> Offro la versione a pagamento
        $sic = file($per.'psw.php'); $cnf = $sic[1][strlen($sic[1])-2]; if($cnf == ';') { if($Qidkey) echo 5; else echo 1; } elseif($cnf == '1') echo 2; elseif($cnf == '2') echo 3; else echo 4; exit;
    }
    elseif($id == "s" and $pos == "d" and $key == "b") { // salvataggio del Database
        $zip = new ZipArchive(); $data = date('d-m-Y-H-i-s',time()); $bck = 'backup/database/'.$data.'.zip'; $zip->open($bck, ZipArchive::CREATE);
        if(!is_dir($Qdatabase)) exit('0'); if(substr($Qdatabase, -1) != DIRECTORY_SEPARATOR){ $Qdatabase.= DIRECTORY_SEPARATOR; } 
        $dirStack = array($Qdatabase); $cutFrom = strrpos(substr($Qdatabase, 0, -1), '/')+1; // trova l'indice da cui inizia l'ultima cartella
        while(!empty($dirStack)){ $currentDir = array_pop($dirStack); $filesToAdd = array(); $dir_folder = dir($currentDir); 
            while( false !== ($node = $dir_folder->read()) ){ if( ($node == '..') || ($node == '.') ){ continue; } if(is_dir($currentDir . $node)){ array_push($dirStack, $currentDir . $node . '/'); } if(is_file($currentDir . $node)){ $filesToAdd[] = $node; }} 
            $localDir = substr($currentDir, $cutFrom); $zip->addEmptyDir($localDir); foreach($filesToAdd as $file){ $zip->addFile($currentDir . $file, $localDir . $file); } 
        } $zip->close(); $uri = explode('/', $_SERVER['SERVER_NAME']); $uri[count($uri)-1] = $bck; $url = ''; foreach($uri as $u) $url .= $u.'/'; exit(substr($url,0,-1));
    }
    elseif($id == "e" and $pos == "s" and $key == "p") { $backup = file("$dirschema/key.php"); for($a=2, $u=count($backup); $a<$u; $a++) $backup[$a] = base64_encode($backup[$a])."\n"; // --> Esportazione del Framework
        for($a=1; $a<8; $a++) { $backup[$a+8] = ''; $str = file("$dirschema/$a.php"); for($b=2, $u=count($str); $b<$u; $b++) $backup[$a+8] .= Qchiaro($str[$b]); $backup[$a+8] = base64_encode($backup[$a+8])."\n"; } $backup[16] = ''; $backup[17] = ''; $backup[18] = '';
        $key = file("$Qdatabase/key.php"); for($a=2, $u=count($key); $a<$u; $a++) $backup[16] .= $key[$a]; $backup[16] = base64_encode($backup[16])."\n"; $trash = file("$Qdatabase/trash.php"); for($a=2, $u=count($trash); $a<$u; $a++) $backup[17] .= $trash[$a]; $backup[17] = base64_encode($backup[17])."\n";
        $note = file("$dirschema/note.php"); for($a=2, $u=count($note); $a<$u; $a++) $backup[18] .= Qchiaro($note[$a])."\n"; $backup[18] = base64_encode($backup[18])."\n"; $data = date('d-M-Y H.i.s',time()); $str = 'backup/framework/'.rtrim($dbtype[3]).' '.$data.'.Qdb.zip'; Qw($str,$backup); $f = explode('/',$_SERVER['HTTP_REFERER']); array_pop($f); $f = implode('/',$f); exit("$f/$str"); 
    }
    elseif($id == "a" and $pos == "t") { $key = 'backup/framework/'.$key.'.Qdb.zip'; // ----------------------------------------------------------------------------------------------> Importazione del Framework
        if(file_exists($key)) { $file = file($key); for($a=9; $a<16; $a++) { if($file[$a] != "\n") { $f = explode("\n",base64_decode(rtrim($file[$a]))); $file[$a] = ''; for($b=0, $u=count($f)-1; $b<$u; $b++) $file[$a] .= Qscuro($f[$b]."\n"); } else $file[$a] = ''; } $key = $Qprotezione; $ffk = base64_decode(rtrim($file[16])); $keys = explode("\n",$ffk); $ffc = base64_decode(rtrim($file[17])); $cest = explode("\n",$ffc); $f = explode("\n",base64_decode(rtrim($file[18]))); $note = $Qprotezione; for($a=0, $u=count($f)-1; $a<$u; $a++) $note .= Qscuro($f[$a]); Qw("$dirschema/note.php",$note);
        if($_POST['opz']) { Qw("$Qdatabase/key.php", $Qprotezione.$ffk, true); Qw("$Qdatabase/trash.php", $Qprotezione.$ffc, true); } else { $fk = file("$Qdatabase/key.php"); $fc = file("$Qdatabase/trash.php"); if((count($fk)+count($fc)-4) > (count($keys)+count($cest))) exit('3'); $f = array(); for($a=2, $u=count($fk); $a<$u; $a++) { if(rtrim($fk[$a]) != $keys[$a-2]) { $f['keys']['now'][] = rtrim($fk[$a]); $f['keys']['next'][] = $keys[$a-2]; } if(rtrim($fc[$a]) != $cest[$a-2]) { $f['trash']['now'][] = rtrim($fc[$a]); $f['trash']['next'][] = $cest[$a-2]; }} if($f) exit(json_encode($f)); Qw("$Qdatabase/key.php", $Qprotezione.$ffk, true); Qw("$Qdatabase/trash.php", $Qprotezione.$ffc, true); }
        for($a=2; $a<9; $a++) $key .= base64_decode(rtrim($file[$a])); Qw("$dirschema/key.php", $key, true); for($a=9; $a<16; $a++) Qw("$dirschema/".($a-8).'.php', $Qprotezione.$file[$a], true); for($a=0, $u=count($keys)-1; $a<$u; $a++) { if($keys[$a] == '') $keys[$a] = $cest[$a]; } for($a=0, $u=count($keys)-1; $a<$u; $a++) { if($keys[$a] != '') { $b = $a + 2; $fi = "$Qdatabase/$b/index.php"; if(!file_exists($fi)){ if(!is_dir("$Qdatabase/$b")) mkdir("$Qdatabase/$b"); Qw($fi,$Qprotezione); } $fi = "$Qdatabase/$b/id.php"; if(!file_exists($fi)) Qw($fi,0,true); }}
        for($a=1; $a<8; $a++) { $str = Qchiaro(file("$dirschema/$a.php")); for($b=2, $ub=count($str); $b<$ub; $b++) { $comb = explode('.',$str[$b]); $per = ''; for($c=0, $uc=count($comb)-1; $c<$uc; $c++) { $per .= '/'.$comb[$c]; $fi = $Qdatabase.$per.'/index.php'; if(!file_exists($fi)){ if(!is_dir($Qdatabase.$per)) mkdir($Qdatabase.$per); Qw($fi,$Qprotezione); } $fi = $Qdatabase.$per.'/id.php'; if(!file_exists($fi)) Qw($fi,0,true); }}} Qsync('*'); exit('1'); } exit('0');
    }
    elseif($id == "u" and $pos == "n") { $cmd = file("$dirschema/command.php"); $c = explode('DB::',$cmd[$key]); if($c[1][0] != 'i' && $c[1][0] != 'd') exit('12'); elseif($c[1][0] == 'd' && strpos($c[1],' ') > 1) exit('15'); elseif($c[1][0] == 'd' && strpos($c[1],'#') > 1) { $a = explode(',',$c[1]); if(count($a) != 3) exit('14'); } elseif($c[1][0] == 'd' && strpos($c[1],'@') !== false) exit('13'); elseif($c[1][0] == 'd') { $a = explode(',',$c[1]); if(count($a) > 2) exit('16'); } if($c[1][0] == 'd') $val = '<?php require "../../Quantico.php"; $val = Quantico\DB::in'.rtrim(substr($c[1],3)).'; echo "<pre>"; print_r($val); echo "</pre>"; ?>'; if($c[1][0] == 'i') {
        $val = substr($c[1],4); $a = explode(',',$val); $val = substr($a[0],0,strlen($a[0])-1); if(count($a) == 3 && strpos($val,' ') === false && strpos($val,'#') === false && strpos($val,'@') === false) { $val = '<?php require "../../Quantico.php"; $val = Quantico\DB::in("'.$val.'",'.substr($a[2],0 ,strpos($a[2],')')).','.$a[1].'); echo "<pre>"; print_r($val); echo "</pre>"; ?>'; } else { if(strpos($val,'@') !== false) exit('13'); else { if(count($a) == 3 && strpos($val,' ')) $val = '<?php require "../../Quantico.php"; $val = Quantico\DB::del("'.$val.'",'.rtrim($a[2]).'; echo "<pre>"; print_r($val); echo "</pre>"; ?>'; else $val = '<?php require "../../Quantico.php"; $val = Quantico\DB::del'.rtrim(substr($c[1],2)).'; echo "<pre>"; print_r($val); echo "</pre>"; ?>'; }}} Qw('temp/reverse.php',$val); exit('0'); 
    }
    elseif($id == "m" and $pos == "n") { $cnf = file($dirqdb.'Qconfig.php'); if($key) { if($key == 1) { $cn = substr($cnf[10],8,-2); $pos = gmdate("d M Y H:i:s", time() + $cn); $cnf[18] = substr($cnf[18],0,16)."'$pos';\n"; } else { if($key == 3) { $dbtype[3] = "test\n"; $cnf = file('../Quantico.php'); $cnf[2] = str_replace('Qmaintenance);','Qmaintenance); $Qdatabase .= \'-test\';',$cnf[2]); Qw('../Quantico.test.php',$cnf); } else $dbtype[3] = "live\n"; Qw('config.php',$dbtype); exit('1'); }} else { $pos = false; $cnf[18] = substr($cnf[18],0,16)."false;\n"; } Qw($dirqdb.'Qconfig.php', $cnf, true); Qsync('*'); exit($pos); }
    elseif($id == "b" and $pos == "k") { $lista = Qdirectory('backup/database'); $key .= '.zip'; $j = array_search($key,$lista); if($j !== false) { $zip = new ZipArchive; if($zip->open('backup/database/'.$key) === TRUE) { if(rename($per,$Qdatabase.'---'.time().'/')) { $zip->extractTo($dirqdb); $zip->close(); exit('1'); }}} exit('0'); }
    elseif($id == "x") { if($pos < 10) echo 25; else { if($pos > 1000) echo 26; else { if($key < 10) echo 27; else { if($key > 10000) echo 28; else { if($pos > $key) echo 29; else { $cnf = file($dirqdb.'Qconfig.php'); $cnf[6] = '$Qposmax = '.$key.";\n"; $cnf[7] = '$Qposdef = '.$pos.";\n"; if(Qw($dirqdb.'Qconfig.php', $cnf, true)) { Qsync('*'); echo 20; } else { Qsync('*'); echo 10; }}}}}} exit; }
    elseif($id == "d") { if($pos == 1) { $key = 'backup/framework/'.$key.'.Qdb.zip'; if(file_exists($key) && unlink($key)) exit('1'); } if($pos == 2) { $key = 'backup/database/'.$key.'.zip'; if(file_exists($key) && unlink($key)) exit('1'); } exit('0'); }
    elseif($id == "w") { require 'class/Qdb.php'; $key_pass = Qdb($pos,'Qpass.ini','Login'); if(!$key_pass) exit('0'); $key_pass = Qdb($key,'Qpass.ini','Register'); if(!$key_pass) exit('0'); $key = array('schema/note.php','schema/test/note.php','schema/clone/note.php'); foreach($key as $pos) if(file_exists($pos)) { $fs = Qscuro(Qchiaro(file($pos)), false, $key_pass); Qw($pos,$fs,true); } for($a=1; $a<8; $a++) { $fs = Qscuro(Qchiaro(file("schema/$a.php")), false, $key_pass); Qw("schema/$a.php",$fs,true); $fs = Qscuro(Qchiaro(file("schema/test/$a.php")), false, $key_pass); Qw("schema/test/$a.php",$fs,true); if(file_exists('schema/clone/1.php')){ $fs = Qscuro(Qchiaro(file("schema/clone/$a.php")), false, $key_pass); Qw("schema/clone/$a.php",$fs,true); }} Qsync('*'); exit('OK'); } // $pos = vecchia password , $key = nuova password
    elseif($id == "m") { require 'class/Qdb.php'; $key_user = Qdb($pos,'Quser.ini','Login'); if(!$key_user) exit('0'); $key_user = Qdb($key,'Quser.ini','Register'); if(!$key_user) exit('0'); $key = array('schema/note.php','schema/test/note.php','schema/clone/note.php'); foreach($key as $pos) if(file_exists($pos)) { $fs = Qscuro(Qchiaro(file($pos)), $key_user, false); Qw($pos,$fs,true); } for($a=1; $a<8; $a++) { $fs = Qscuro(Qchiaro(file("schema/$a.php")), $key_user, false); Qw("schema/$a.php",$fs,true); $fs = Qscuro(Qchiaro(file("schema/test/$a.php")), $key_user, false); Qw("schema/test/$a.php",$fs,true); if(file_exists('schema/clone/1.php')){ $fs = Qscuro(Qchiaro(file("schema/clone/$a.php")), $key_user, false); Qw("schema/clone/$a.php",$fs,true); }} Qsync('*');exit('OK'); } // $pos = vecchia email , $key = nuova email
    elseif($id == "f") { $lista = Qdirectory('backup/framework'); $b = 0; foreach($lista as $files) if(substr($files, -4) == '.zip') { $b++; if($pos == $b) { rename('backup/framework/'.$files, 'backup/framework/'.$key.'.Qdb.zip'); exit('1'); }} exit('0'); }
    elseif($id == "h") { $lista = Qdirectory('backup/database'); $b = 0; foreach($lista as $files) if(substr($files, -4) == '.zip') { $b++; if($pos == $b) { rename('backup/database/'.$files, 'backup/database/'.$key.'.zip'); exit('1'); }} exit('0'); } 
    else { 
        
        $lng = file('language/'.rtrim($dbtype[4]).'/keyline.php', FILE_IGNORE_NEW_LINES); // italiano - inglese
        
        if($id == "k" and $pos == "p") { $Qkeybase = file($Qdatabase.'/key.php'); $l = file($Qdatabase.'/link.php'); $l1 = array(); $l2 = array(); $l3 = array(); $link = array(); $y = array(); $x = false; // CERCA
            for($a=2, $u=count($l); $a<$u; $a++) { $s = explode('#',$l[$a]); if($s[1] == $x) $l3[] = $l[$a]; else { $x = false; if(strpos($s[1],".0\n")) { if(strpos($s[0],'@')) { $s[0] = substr($s[0],0,-2); $l3[] = $s[0].'#'.rtrim($s[1]).".@\n"; } else { if(strpos($l[$a+1],'#'.$s[0].".0\n")) { $l2[] = $l[$a]; $a++; $l2[] = $l[$a]; } else $l2[] = $l[$a]; }} elseif(strpos($s[1],".1\n")) { $l3[] = $l[$a]; $x = substr($s[1],0,-2).$s[0].".0\n"; $y[] = rtrim($x); } else $l1[] = $l[$a]; }} $link = array_merge($l1,$l2,$l3); $k = explode('.',$key); $key = ''; foreach($k as $x) { $j = array_search($x."\n",$Qkeybase); if($j > 1) $key .= $j.'.'; }
            if($key) { $key = substr($key,0,-1); $x = 0; $y = 0; $tmp = array(); $crc = array(); for($a=0, $u=count($link); $a<$u; $a++) { $k = explode('#',$link[$a]); if($key == $k[0] and !strpos($k[1],"@\n")) $tmp[] = rtrim($k[1]); } $key = '<table border="0" width="280" cellspacing="0" cellpadding="0"><tr><td colspan="2" class="td9 cl1">'.$lng[3].'</td></tr>';
                foreach($tmp as $t) { $x++; $k = explode('.',$t); $j = rtrim($Qkeybase[$k[0]]); $l = count($k); if($k[$l-1] == 0) { $col = '#000080'; $j = '#'.$j; $l--; } elseif($k[$l-1] == 1) { $col = '#333'; $j = '@'.$j; $l--; } else { $col = '#09C'; $crc[] = $j; } for($a=1; $a<$l; $a++) $j .= '.'.rtrim($Qkeybase[$k[$a]]); $key .= '<tr><td class="td10"><input type="checkbox" id="x'.$x.'" value="'.$j.'"></td><td class="td11"><font color="'.$col.'">&nbsp;'.$j.'</font></td></tr>'; }
                $key .= '<tr><td width="280" colspan="2" class="td3"></td></tr></table><table border="0" width="280" cellspacing="0" cellpadding="0"><tr><td colspan="2" class="td9 bg1 cl10">'.$lng[4].'</td></tr>'; foreach($crc as $t) { $y++; $key .= '<tr><td class="td10 bg1"><input type="checkbox" id="y'.$y.'" value="'.$t.'"></td><td class="td11 bg1 cl0">&nbsp;'.$t.'</td></tr>'; }
                $key .= '<tr><td width="280" colspan="2" class="td3 bg1"></td></tr></table><br><h2 align="center"><a href="javascript:form()">'.$lng[5].'</a></h2>�'.$x.'�'.$y; exit($key); } exit('0');
        }
        elseif($id == "k" and $pos == "q") { $Qkeybase = file($Qdatabase.'/key.php'); $l = file($Qdatabase.'/link.php'); $l1 = array(); $l2 = array(); $l3 = array(); $link = array(); $y = array(); $x = false; // QUERY
            for($a=2, $u=count($l); $a<$u; $a++) { $s = explode('#',$l[$a]); if($s[1] == $x) $l3[] = $l[$a]; else { $x = false; if(strpos($s[1],".0\n")) { if(strpos($s[0],'@')) { $s[0] = substr($s[0],0,-2); $l3[] = $s[0].'#'.rtrim($s[1]).".@\n"; } else { if(strpos($l[$a+1],'#'.$s[0].".0\n")) { $l2[] = $l[$a]; $a++; $l2[] = $l[$a]; } else $l2[] = $l[$a]; }} elseif(strpos($s[1],".1\n")) { $l3[] = $l[$a]; $x = substr($s[1],0,-2).$s[0].".0\n"; $y[] = rtrim($x); } else $l1[] = $l[$a]; }} $link = array_merge($l1,$l2,$l3); $k = explode('.',$key); $key = ''; foreach($k as $x) { $j = array_search($x."\n",$Qkeybase); if($j > 1) $key .= $j.'.'; } 
            if($key) { $key = substr($key,0,-1); $x = 0; $y = 0; $tmp = array(); $crc = array(); for($a=0, $u=count($link); $a<$u; $a++) { $k = explode('#',$link[$a]); if($key == $k[0] and !strpos($k[1],"@\n")) $tmp[] = rtrim($k[1]); } $key = '<table border="0" width="280" cellspacing="0" cellpadding="0"><tr><td colspan="2" class="td9 cl1">'.$lng[3].'</td></tr>';
                foreach($tmp as $t) { $x++; $k = explode('.',$t); $j = rtrim($Qkeybase[$k[0]]); $l = count($k); if($k[$l-1] == 0) { $col = '#000080'; $j = '#'.$j; $l--; } elseif($k[$l-1] == 1) { $col = '#333'; $j = '@'.$j; $l--; } else { $col = '#09C'; $crc[] = $j; } for($a=1; $a<$l; $a++) $j .= '.'.rtrim($Qkeybase[$k[$a]]); $key .= '<tr><td class="td10"><input type="checkbox" id="x'.$x.'" value="'.$j.'"></td><td class="td11"><font color="'.$col.'">&nbsp;'.$j.'</font></td></tr>'; } 
                $key .= '<tr><td width="280" colspan="2" class="td3"></td></tr></table><table border="0" width="280" cellspacing="0" cellpadding="0"><tr><td colspan="2" class="td9 bg1 cl10">'.$lng[6].'</td></tr>'; foreach($crc as $t) { $y++; $key .= '<tr><td class="td10 bg1 cl0"><span id="y'.$y.'">'.$t.'</span>&nbsp;&nbsp;</td><td class="td11 bg1"><input class="in7" id="p'.$y.'" type="text" title="'.$lng[7].'"></td></tr>'; }
                $key .= '<tr><td width="280" colspan="2" class="td3 bg1"></td></tr></table><br><h2 align="center"><a href="javascript:form()">'.$lng[8].'</a></h2>�'.$x.'�'.$y; exit($key); } exit('0');
        }
        elseif($id == "r") { if($pos == 1) { $dir = 'backup/framework'; $ext = '.zip'; $ok = 8; } if($pos == 2) { $dir = 'backup/database'; $ext = '.zip'; $ok = 4; } $lista = Qdirectory($dir); $b = 0; $msg = '';
            foreach($lista as $files) { if(substr($files, -4) == $ext) { $b++; $nome = substr($files, 0, strlen($files)-$ok); $msg .= '<table id="tab'.$b.'" border="0" width="230" cellspacing="0" cellpadding="0" height="35"><tr><td align="center" width="40"><font color="#F00" face="Arial" size="4"><b>'.$b.'.</b></font></td>'; 
                if($key == $b) $msg .= '<td width="180">&nbsp;<input class="yim" id="kbt" type="text" value="'.$nome.'"></td><td width="15"><a href="javascript:cancella('.$b.',3)"><img id="x'.$b.'" src="images/x_off.bmp" border="0" hspace="1" vspace="2" onmouseover="javascript:cancella('.$b.',1)" onmouseout="javascript:cancella('.$b.',0)" title="'.$lng[9].'"></a><a href="javascript:rinomina('.$b.',3)"><img id="s'.$b.'" src="images/s_on.bmp" border="0" vspace="2" onmouseover="javascript:rinomina('.$b.',1)" onmouseout="javascript:rinomina('.$b.',0)" title="'.$lng[10].'"></a></td></tr></table>';
                else $msg .= '<td width="180" onmouseover="javascript:xrshow('.$b.',1)" onmouseout="javascript:xrshow('.$b.',0)"><span id="keyb'.$b.'"><h6>'.$nome.'</h6></span></td>';'<td width="15"></td></tr></table>';
            }} exit($msg);
        } else { $keycomb = Qchiaro(file("$dirschema/$pos.php"));
            if($id == "o") { $keycomb[$key] = str_replace(".0\n",".x\n",$keycomb[$key]); Qw("$dirschema/$pos.php", Qscuro($keycomb), true); Qsync('*'); exit('1'); }
            if($id == "p") { $keycomb[$key] = str_replace(".x\n",".0\n",$keycomb[$key]); Qw("$dirschema/$pos.php", Qscuro($keycomb), true); Qsync('*'); exit('1'); }
            if($id == "u") { $key--; $tmp = $keycomb[$key]; $keycomb[$key] = $keycomb[$key+1]; $keycomb[$key+1] = $tmp; Qw("$dirschema/$pos.php", Qscuro($keycomb), true); Qsync('*'); exit('1'); }
            if($id == "g") { $b = $key + 1; if($b < count($keycomb)) { $ek = explode('.',$keycomb[$key]); $eb = explode('.',$keycomb[$b]); if($ek[0] == $eb[0]) { $tmp = $keycomb[$b]; $keycomb[$b] = $keycomb[$key]; $keycomb[$key] = $tmp; Qw("$dirschema/$pos.php", Qscuro($keycomb), true); }} Qsync('*'); exit('1'); }
            if($id == 4) { $val = explode("-", $key); $x = count($val)-1; $y = $val[$x]; $str = '';
                for($a=0; $a<$x; $a++) { $str = $str.$val[$a].'.'; $per = $per.$val[$a].'/'; } $str .= '0'; $per .= $y; for($a=2, $u=count($keycomb); $a<$u; $a++) { if($str == rtrim($keycomb[$a])) { $key .= "-0\n"; $keycomb[$a] = str_replace('-', '.', $key); $file = $per.'/index.php'; if(!file_exists($file)){ mkdir($per,0755); Qw($file,$Qprotezione); } $file = $per.'/id.php'; if(!file_exists($file)) Qw($file, 0, true); Qw("$dirschema/$pos.php", Qscuro($keycomb), true); Qsync('*'); exit('1'); }} exit('10'); }
                $val = explode('.', $key); $str = ''; $lv = count($val) - 1; $Qkeybase = file($Qdatabase.'/key.php'); if($lv == 0) $val[0] = $key; else { $val[0] = substr($val[0], 0, -2); for($a=1; $a<$lv; $a++) { $val[$a] = substr($val[$a], 2, -2); }; $val[$lv] = substr($val[$lv], 2); } for($a=0, $ua=count($val); $a<$ua; $a++) { for($b=2, $ub=count($Qkeybase); $b<$ub; $b++) if(rtrim($Qkeybase[$b]) == $val[$a]) { $str .= $b.'.'; $per .= $b.'/'; break; }} $w = "$pos-".str_replace('.', '-', $str); $str .= '0';
            for($a=2, $ua=count($keycomb); $a<$ua; $a++) { if($str == rtrim($keycomb[$a])) { 
                if($id == 1) { $x = count($val)-1; $d = trim($val[$x]); $msg = '<table id="keybc" border="0" width="100%" cellspacing="0" cellpadding="0" style="border:1px solid #FCC"><tr><td align="center"><h6>'; for($b=2, $ub=count($Qkeybase); $b<$ub; $b++) { $c = rtrim($Qkeybase[$b]); if($c != '' and $c != $d) $msg .= '<a href="javascript:modifica(\'xx'.$w.$b.'\',4)">'.$c.'</a><br>'; } $msg .= '<br><a href="javascript:modifica(\'xx0-0\',3)"><font color="#F00"><b>'.$lng[11].'</b></font></a></h6></td></tr></table>'; exit($msg); }
                elseif ($id == 2) { $keycomb = Qcancella($keycomb, $a); Qw("$dirschema/$pos.php", Qscuro($keycomb), true); Qsync('*'); exit('1'); }
                elseif ($id == 3) { for($b=count($keycomb); $b>($a+1); $b--) $keycomb[$b] = $keycomb[$b-1]; $val = explode('.', $str); $keycomb[$a+1] = $val[0].".0\n"; Qw("$dirschema/$pos.php", Qscuro($keycomb), true); Qsync('*'); exit('1'); }}
            }
        }
    } exit('10');
?>