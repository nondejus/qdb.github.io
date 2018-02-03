<?php

namespace Quantico; if($Qmaintenance) return array('maintenance' => $Qmaintenance); ini_set('display_errors', 1); error_reporting(E_ALL); /* ini_set & error_reporting (can remove) */ mb_internal_encoding('UTF-8'); mb_http_output('UTF-8'); require_once 'class/Qsys.php'; require_once 'class/Qfx.php';

class DB
{
    private static function exit($k, $v, $s, $o){ if(!$k || is_array($k) || function_exists($k)) return true; if(!is_array($v) && function_exists($v)) return true; if(!is_array($s) && function_exists($s)) return true; if(!is_array($o) && function_exists($o)) return true; return false; }
    
    public static function in($k=null, $v=null, $s=null, $o=0){ if(DB::exit($k,$v,$s,$o)) return null; global $Qdatabase; $x = fopen("$Qdatabase/lock.php","w"); if(flock($x,LOCK_EX) == false) { fclose($x); return null; } else { require_once 'class/Qin.php'; $v = Qin::Qdbin(trim($k),$v,$s,$o); Qsync('*',true); flock($x,LOCK_UN); fclose($x); return $v; }}
    public static function ver($k=null, $v=null, $s=null, $o=null){ if(DB::exit($k,$v,$s,$o)) return null; global $Qdatabase; $x = fopen("$Qdatabase/lock.php","w"); if(flock($x,LOCK_EX) == false) { fclose($x); return null; } else { require_once 'class/Qver.php'; $v = Qver::Qdbver(trim($k),$v,$s,$o); Qsync('*',true); flock($x,LOCK_UN); fclose($x); return $v; }}
    public static function del($k=null, $v=null, $s=null){ if(DB::exit($k,$v,$s,0)) return null; global $Qdatabase; $x = fopen("$Qdatabase/lock.php","w"); if(flock($x,LOCK_EX) == false) { fclose($x); return null; } else { require_once 'class/Qdel.php'; if(strpos($k,'#') > 1 || strpos($k,',') > 2) $v = Qdel::Qdbdel(trim($k),$v,$s); else $v = Qdel::Qdbdel(trim($k),$v,$s,0); Qsync('*',true); flock($x,LOCK_UN); fclose($x); return $v; }}
    public static function out($k=null, $v=null, $s=null, $o=null){ if(DB::exit($k,$v,$s,$o)) return null; require_once 'class/Qout.php'; return Qout::Qdbout(trim($k),$v,$s,$o); }
}

?>