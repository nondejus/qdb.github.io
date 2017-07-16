<?php

if($Qmaintenance) { header('location: class/updated.htm'); exit; } ini_set('display_errors', 1); error_reporting(E_ALL); /* ini_set + error_reporting (remove) */ require_once 'class/Qfx.php';

class Qdb
{      
    public static function in($k=NULL, $v=NULL, $s=NULL, $o=0) { if(is_array($k)) return false; global $Qdatabase; $x = fopen($Qdatabase.'/x.php','w'); if(flock($x,LOCK_EX) == false) { fclose($x); return false; } else { require_once 'class/Qin.php'; $v = Qin::Qdbin($k,$v,$s,$o); flock($x,LOCK_UN); fclose($x); return $v; }}
    public static function del($k=NULL, $v=NULL, $s=NULL) { if(is_array($k)) return false; global $Qdatabase; $x = fopen($Qdatabase.'/x.php','w'); if(flock($x,LOCK_EX) == false) { fclose($x); return false; } else { require_once 'class/Qdel.php'; if(strpos($k,'#') > 1 or strpos($k,',') > 2) $v = Qdel::Qdbdel($k,$v,$s); else $v = Qdel::Qdbdel($k,$v,$s,0); flock($x,LOCK_UN); fclose($x); return $v; }}
    public static function ver($k=NULL, $v=NULL, $s=NULL, $o=NULL) { if(is_array($k)) return false; global $Qdatabase; $x = fopen($Qdatabase.'/x.php','w'); if(flock($x,LOCK_EX) == false) { fclose($x); return false; } else { require_once 'class/Qver.php'; $v = Qver::Qdbver($k,$v,$s,$o); flock($x,LOCK_UN); fclose($x); return $v; }}
    public static function out($k=NULL, $v=NULL, $s=NULL, $o=NULL) { if(is_array($k)) return false; require_once 'class/Qout.php'; return Qout::Qdbout($k,$v,$s,$o); }
    public static function time() { global $Qgmt; return strtotime(gmdate("M d Y H:i:s", time())) + $Qgmt; }
}

?>