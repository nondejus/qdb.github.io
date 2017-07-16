<?php

require 'dirqdb.php'; require $dirqdb.'Qconfig.php'; require 'function.php'; $qdb = file($dirqdb.'Qconfig.php'); $Qclonatot = 0;

$c = '0123456789-abcdefghijklmnopqrstuvwxyz_ABCDEFGHIJKLMNOPQRSTUVWXYZ'; $Qdatabase = Qgp(mt_rand(16,24),$c).Qgp(mt_rand(16,24),$c); $Qpostime = '/'.Qgp(mt_rand(8,16),$c); $db = $dirqdb.$Qdatabase;
$c .= 'ìùàòèé§ç?*+&%!€#@°^=:|!£è[<()>],;/'; $psw = Qgp(mt_rand(16,24),$c); for($a=0; $a<257; $a++) $psw .= '.'.Qgp(mt_rand(16,24),$c); $Qaes256iv = Qgp(16,$c); $file = "$db/link.php";

if(!file_exists($file)){ mkdir($db,0755); mkdir($db.$Qpostime,0755); $Qprotezi = rtrim($Qprotezione).";\n"; 
    for($a=0; $a<4; $a++) { mkdir("$db/$a",0755); Qw("$db/$a/index.php",$Qprotezione); } mkdir("$db/@",0755);
    Qw("$db/@/index.php",$Qprotezione); Qw("$db/2/id.php",'0'); Qw("$db/3/id.php",'0');
    Qw("$db/key.php",$Qprotezione."email\npassword\n");
    Qw("$db/index.php",$Qprotezione);
    Qw("$db/trash.php",$Qprotezione."\n\n");
    Qw("$db/psw.php",$Qprotezi.$psw."\n");
    Qw("$db$Qpostime/index.php",$Qprotezione.'2');
    Qw($file,$Qprotezione); $fp = fopen($dirqdb.'Qconfig.php','w');
    for($a=0; $a<4; $a++) fwrite($fp, $qdb[$a]);
    fwrite($fp, '$Qdatabase = "'.$db.'";'."\n");
    fwrite($fp, '$Qpostime = "'.$Qpostime.'";'."\n");
    fwrite($fp, '$Qposmax = 100;'."\n");
    fwrite($fp, '$Qposdef = 10;'."\n");
    fwrite($fp, '$Qlivtime = 1;'."\n");
    fwrite($fp, '$Qmaxtime = array(0,999999,1999999,4999999,9999999,19999999);'."\n");
    fwrite($fp, '$Qgmt = 0;'."\n");
    fwrite($fp, '$Qidkey = 0;'."\n");
    fwrite($fp, '$Qckadm = 0;'."\n");
    fwrite($fp, '$Qserver = "";'."\n");
    fwrite($fp, '$QprcCerca = 5;'."\n");
    fwrite($fp, '$QprcPersonal = 100;'."\n");
    fwrite($fp, '$QprcNumber = array(0,99999,499999,999999,1999999,4999999,9999999);'."\n");
    fwrite($fp, '$Qaes256iv = "'.$Qaes256iv.'"'.";\n");
    fwrite($fp, '$Qmaintenance = false;'."\n");
    fwrite($fp, '?>'); fclose($fp); require('clona.php'); clona($db,"$db-test");
    $fp = file('schema/command.php'); $fp[1] = rtrim($fp[1]).time()."\n"; Qw('schema/command.php',$fp);
} else echo 'http://www.quanticodb.com';

?>