<?php

namespace Quantico; if($Qmaintenance) return array('maintenance' => $Qmaintenance); ini_set('display_errors', 1); error_reporting(E_ALL); /* ini_set & error_reporting (can remove) */ mb_internal_encoding('UTF-8'); mb_http_output('UTF-8'); require_once 'class/Qsys.php'; require_once 'class/Qfx.php';

class DB
{
    public static function in($k=null, $v=null, $s=null, $o=0) { if(is_array($k)) return false; global $Qdatabase; $x = fopen("$Qdatabase/lock.php","w"); if(flock($x,LOCK_EX) == false) { fclose($x); return null; } else { require_once 'class/Qin.php'; $v = Qin::Qdbin($k,$v,$s,$o); Qsync('*'); flock($x,LOCK_UN); fclose($x); return $v; }}
    public static function ver($k=null, $v=null, $s=null, $o=null) { if(is_array($k)) return false; global $Qdatabase; $x = fopen("$Qdatabase/lock.php","w"); if(flock($x,LOCK_EX) == false) { fclose($x); return null; } else { require_once 'class/Qver.php'; $v = Qver::Qdbver($k,$v,$s,$o); Qsync('*'); flock($x,LOCK_UN); fclose($x); return $v; }}
    public static function del($k=null, $v=null, $s=null) { if(is_array($k)) return false; global $Qdatabase; $x = fopen("$Qdatabase/lock.php","w"); if(flock($x,LOCK_EX) == false) { fclose($x); return null; } else { require_once 'class/Qdel.php'; if(strpos($k,'#') > 1 || strpos($k,',') > 2) $v = Qdel::Qdbdel($k,$v,$s); else $v = Qdel::Qdbdel($k,$v,$s,0); Qsync('*'); flock($x,LOCK_UN); fclose($x); return $v; }}
    public static function out($k=null, $v=null, $s=null, $o=null) { if(is_array($k)) return false; require_once 'class/Qout.php'; return Qout::Qdbout($k,$v,$s,$o); }
}

?>