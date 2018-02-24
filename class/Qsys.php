<?php

namespace Quantico;

class SYS extends DB
{
    protected $orapsw = false, $pospsw = false;
    protected static $dataval = false, $update = false, $partial = 0;
        
    public static function time(){ global $Qgmt; return strtotime(gmdate("M d Y H:i:s", time())) + $Qgmt; }
    public static function dir($key=null, $val=null){ if($key && $val !== null) { $val = SYS::hashpos(Qhash($val), SYS::combina($key)); if(file_exists("$val/index.php")) return $val; } return false; }
    
    private static function sel($num, $tot){ $d = explode(':', $num[7]); if(count($d) == 1) { $num[6] = true; $num[2] = $tot - 1; if($num[7] === '-') { global $Qposdef; $num[0] = $tot - $Qposdef; } elseif($num[7] === '-0') { global $Qposmax; $num[0] = $tot - $Qposmax; } else $num[0] = $tot + $num[7]; if($num[0] < 0) $num[0] = 0; $num[0] += 2; } elseif(count($d) == 2) { if($d[0] < 0 || $d[0] === '-0') { $num[2] = $tot + $d[0]; if($d[1] < 0 || $d[1] === '-0') { if($tot + $d[0] < 1 && $tot + $d[1] < 1) return false; $num[0] = $tot + $d[1] - 1; if($d[0] < 0) $num[2]--; if($num[0] < 0) $num[0] = 0; $d[1] = $num[0]; $num[0] += 2; } else { $num[0] = $d[1] + 2; if($d[0] <= 0) $num[2]--; } if($num[2] < 0) $num[2] = 0; $d[0] = $num[2]; } else { $num[2] = $d[0]; if($d[1] < 0 || $d[1] === '-0') { $num[0] = $tot + $d[1] - 1; if($num[0] < 0) $num[0] = 0; } else $num[0] = $tot + $d[1]; $d[1] = $num[0]; $num[0] += 2; } if($d[0] > $d[1]) $num[6] = true; else $num[6] = false; } else return false; return $num; }
    private static function vals($val, $op=null, $file=null, $keytmp=null){ global $Qdatabase; global $Qpostime; global $Qpassword; $x = substr($val, 0, 3); $y = substr($val, 3, $val[12]); $psw = $Qpassword[hexdec(substr($val, 10, 2))]; $orapsw = substr($val, 0, 12); $iv = Qiv($orapsw, $psw); if($val[strlen($val) - 2] == '_') { $d = substr($val, 13, -2); SYS::$dataval = true; } else $d = substr($val, 13, -1); $keyperindex = $Qdatabase.$Qpostime. "/$x/$y/index.php"; if($op !== null) { $z = $x.$y; if(in_array($z, $op)){ $keyval = Qdecrypt($file[$z][$d], $psw, $iv); $keytmp[] = SYS::keyval($orapsw, $keyval, $val); } else { if(file_exists($keyperindex)){ $file[$z] = file($keyperindex); $op[] = $z; $keyval = Qdecrypt($file[$z][$d], $psw, $iv); $keytmp[] = SYS::keyval($orapsw, $keyval, $val); } else $keytmp[] = false; } return array($op, $file, $keytmp); } else { if(file_exists($keyperindex)){ $str = file($keyperindex); $keyval = Qdecrypt($str[$d], $psw, $iv); return SYS::keyval($orapsw, $keyval, $val); }} return false; }
    private static function chars($val){ $l = mb_strlen($val, 'UTF-8'); $x = []; for($a=0; $a<$l; $a++) { $y = mb_substr($val, $a, 1, 'UTF-8'); if(!isset($x[$y])) $x[$y] = 0; $x[$y]++; } $x = array_keys($x); rsort($x); return implode('',$x); }
    private static function keyval($orapsw, $keyval, $val){ if($orapsw == substr($keyval,-12)) return substr($keyval,0,-12); else { require_once 'Qrec.php'; return Qrecupero($val); }}
    
    protected function orapos($ora) { $this->pospsw = mt_rand(0,255); if($this->pospsw < 16) $this->orapsw = $ora.'0'; else $this->orapsw = $ora; $this->orapsw .= dechex($this->pospsw); }
    protected function _flusso($numkey, $keyval, $tot, $n, $opz=0, $numkeyass=0) { require_once 'Qfls.php'; return Qfls::flusso($numkey, $keyval, $tot, $n, $opz, $numkeyass); }
    protected function _out($keys=null, $valass=null, $opz=null, $type=0, $all=null) { require_once 'Qout.php'; return Qout::Qdbout($keys, $valass, $opz, $type, $all); }
    protected function _ver($keys=null, $val=null, $valass=null, $opz=null) { require_once 'Qver.php'; return Qver::Qdbver($keys, $val, $valass, $opz); }
    protected function _del($keys=null, $valass=null, $opz=null, $type=0) { require_once 'Qdel.php'; return Qdel::Qdbdel($keys, $valass, $opz, $type); }
    protected function _in($keys=null, $val=null, $valass=null, $opz=0) { require_once 'Qin.php'; return Qin::Qdbin($keys, $val, $valass, $opz); }
    
    protected static function c($per, $key) { $per .= '/.'.$key[0]; for($a=1,$u=count($key); $a<$u; $a++) $per .= '/'.$key[$a]; return $per; }
    protected static function u($val, $opz=false){ $val = array_values(array_unique(array_filter(array_map('trim',$val),'strlen'))); if($opz) { $ok = []; for($a=0,$u=count($val); $a<$u; $a++) { if($val[$a][0] == '_'){ $ok[] = $val[$a]; unset($val[$a]); } elseif(isset($val[$a][1]) && $val[$a][1] == '_'){ $ok[] = $val[$a]; unset($val[$a]); }} sort($val); $val = implode(',',array_merge($ok,$val)); } return $val; }
    protected static function kb($key, $type='', $dif=0, $opz=false){ $k = explode('.', rtrim($key)); if($opz){ if($opz == 'Qout') $key = ''; else $key = rtrim(QKEYBASE[$opz]).' '; foreach($k as $f) $key .= rtrim(QKEYBASE[$f]).'.'; $key = substr($key, 0, -1); } else { $key = $type.rtrim(QKEYBASE[$k[0]]); for($a=1,$u=count($k)-$dif; $a<$u; $a++) $key .= '.'.rtrim(QKEYBASE[$k[$a]]); } return $key; }
    protected static function lh($keyper, $hash){ global $Qlivtime; for($a=0; $a<$Qlivtime; $a++) { $keyper .= '/'.substr($hash, $a*2, 2); $per = "$keyper/$hash"; if(is_dir($per)) return $per; } return $per; }
    protected static function combina($key, $opz=0){ global $Qdatabase; if(!$key || is_array($key)) return false; $verper = $Qdatabase; if($key[0] == '_') { $key = substr($key,1); SYS::$dataval = $key; } $key = explode('.', $key); $x = ''; $per = []; $id = "\n"; if($key[0][0] == '#') { $key[0] = substr($key[0],1); $id = ".0\n"; } elseif($key[0][0] == '@') { $key[0] = substr($key[0],1); $id = ".1\n"; } for($a=0,$u=count($key); $a<$u; $a++) { $per[$a] = 0; $j = array_search($key[$a]."\n",QKEYBASE); if($j > 1) { $x .= $j.'.'; $verper .= '/'.$j; if(is_dir($verper)) $per[$a] = $j; else return Qerror(0,0,$verper); } else return Qerror(0,1,$key[$a]); } if($opz == 1) return substr($x, 0, -1).$id; elseif($opz == 2) return $verper; else return $per; }
    protected static function trak($chiaro, $opz=0){ $chiaro = str_replace(array('?','!',';',',','"','(',')','[',']','{','}',"'","\n","\r"), ' ', $chiaro); $f = array_unique(explode(' ', $chiaro)); $a = 0; $x = false; foreach($f as $s) if(mb_strlen($s,'UTF-8') > 2 || is_numeric($s)) { $y = mb_substr($s,-1,1,'UTF-8'); if($y == '.' || $y == ':') $s = mb_substr($s,0,-1,'UTF-8'); if(mb_strpos($s,'@',0,'UTF-8') > 2) { $e = explode('@',$s); if($opz) { $x[$a] = $e[0]; $a++; $x[$a] = $e[1]; $a++; } else { $x[$a] = SYS::chars($e[0]); $a++; $x[$a] = SYS::chars($e[1]); $a++; }} if(mb_strpos($s,'/',0,'UTF-8') !== false) { $e = explode('/',$s); foreach($e as $z) if(strlen($z) > 0) { if($opz) $x[$a] = $z; else $x[$a] = SYS::chars($z); $a++; }} if($opz) $x[$a] = $s; else $x[$a] = SYS::chars($s); $a++; } if($x) { $f = array_unique($x); sort($f); return $f; } else return false; }
    protected static function opz($keyper, $opz, $num, $type, $val) { $QprcNum = SYS::prcnumber(); if($type) $n = floor((int)substr($opz,1,10) / $QprcNum); else $n = floor((int)substr($opz,0,10) / $QprcNum); $keypert = "$keyper/t$n.php"; $keyper .= "/l$n.php"; if(file_exists($keyper)) { $fk = file($keyper); if($val) { foreach($fk as $j) if($j == $opz) $num++; return $num; } else { $j = array_search($opz,$fk); if($j > 1) { if($num) { $fk = file($keypert); return rtrim($fk[$j]); } else return $j-1; }}} return false; }
    protected static function sort($val) { if(is_array($val)) { $w = []; $x = []; $y = []; $z = []; $s = []; foreach($val as $v) { if($v) { if($v[0] == '#') $y[] = $v; elseif($v[0] == '@') $z[] = $v; elseif($v[0] == '_') $w[] = $v; elseif(strpos($v,' ') > 1) $s[] = $v; elseif(strpos($v,'{') > 1) $x[] = substr($v,0,strpos($v,'{')); elseif(strlen($v) > 1) $x[] = $v; }} return array_merge($w,$x,$y,$z,$s); } else return $val; }
    protected static function ordina($key, $array, $opz, $type){ $high = count($array)-1; $low = 2; if($opz) { while ($low <= $high) { $mid = floor(($low + $high) / 2); if($type) $val = substr($array[$mid],0,10); else $val = rtrim($array[$mid]); if($val <= $key) $low = $mid + 1; else $high = $mid - 1; } return $high; } else { while ($low <= $high) { $mid = floor(($low + $high) / 2); if($type) $val = substr($array[$mid],0,10); else $val = rtrim($array[$mid]); if($val >= $key) $high = $mid - 1; else $low = $mid + 1; } return $low; }}
    protected static function speciali($val, $opz=0){ if($opz) { if(is_array($val)) return $val; else { if($val === false || strtolower($val) === 'false') $val = 'false'; elseif($val === true || strtolower($val) === 'true') $val = 'true'; elseif($val === 0) $val = '0'; return $val; }} if($val[10] == 't') return 'true'; elseif($val[10] == 'f') return 'false'; }
    protected static function hashpos($hash, $per, $opz=0){ if(!is_array($per)) return false; global $Qdatabase; $keyper = $Qdatabase; if($opz > 1000) $keyper .= '/@'; foreach($per as $corso) $keyper .= '/'.$corso; return SYS::lh($keyper,$hash); }
    protected static function isKey($val){ $x = ''; $y = explode('.',$val); foreach($y as $z){ $j = array_search($z."\n",QKEYBASE); if($j > 1) $x .= $j.'.'; else return false; } return substr($x,0,-1); }
    protected static function isNumber($val){ if(strstr($val,'.')){ if(filter_var($val, FILTER_VALIDATE_IP)) return true; } else { if(is_numeric($val) && $val > 0) return true; } return false; }
    protected static function tempo($opz, $time, $ora){ if($opz === _T1_) return (int)substr($time, 0, 10); elseif($opz === _T2_) return $ora-(int)substr($time, 0, 10); else return null; }
    protected static function prcnumber(){ global $QprcNumber; global $Qlivtime; if($QprcNumber[0]) return $QprcNumber[0]; else return $QprcNumber[$Qlivtime]; }
    protected static function cancella($array, $item){ if(isset($array[$item])) unset($array[$item]); return array_merge($array); }
    protected static function tot($per){ $l = r("$per/in.php"); if(!$l) return 0; $l = explode('.',$l); return (int)$l[2]; }
    protected static function dataval($val) { return (string)strtotime(str_replace(array('/',' '), '-', $val)); }
    protected static function keyvalass($keyass, $valass, $per, $stat=0, $opz=0){ $hash = Qhash($valass); $x = 0; $keyval = false;
        if($stat == 2) { $keyass = SYS::lh($keyass, $hash); $comb = "$keyass/keys.php"; $link = "$keyass/link.php"; if(file_exists($comb)){ $fcomb = file($comb); $flink = file($link); if(is_array($opz)) { foreach($per as $key) { $j = array_search($opz[$x],$fcomb); $x++; if($j > 1) $keyval[$key] = $flink[$j]; else $keyval[$key] = false; } return $keyval; } else $x = array_search($per,$fcomb); } else if(is_array($opz)) { foreach($per as $key) $keyval[$key] = false; return $keyval; }} else { if(strlen($opz) > 64) $hashpos = $opz; else $hashpos = SYS::hashpos($hash, SYS::combina($keyass)); if($hashpos) { $comb = "$hashpos/keys.php"; $link = "$hashpos/link.php"; $riga = $per[0]; $dir = '.'.$per[0]; for($a=1,$u=count($per); $a<$u; $a++) { $riga .= '.'.$per[$a]; $dir .= '/'.$per[$a]; } if(file_exists($comb)){ $fcomb = file($comb); $x = array_search($riga."\n",$fcomb); }}}
        if($x > 1) { $flink = file($link); if($stat == 1) { require_once 'Qst.php'; Qst::stat1($keyass, $hashpos, $dir, $flink[$x]); if($opz == 0) { $flink = SYS::cancella($flink, $x); $fcomb = SYS::cancella($fcomb, $x); w($link, $flink); w($comb, $fcomb); } elseif($opz == 1) { $flink[$x] = $opz; w($link, $flink); } return true; } else return rtrim($flink[$x]); } return false;
    }
    protected static function leggi($keyper, $opz=0, $num=0, $type=0, $val=0){ if($opz) return SYS::opz($keyper,$opz,$num,$type,$val); $keyperindex = "$keyper/in.php"; $l = r($keyperindex); if(!$l) return false; if(isset($num[7])) { if(strstr($num[7],'-') !== false) { if(!$num = SYS::sel($num,SYS::tot($keyper))) return false; }} $kn = explode('.',$l); $fstart = $kn[0]; $keyval[0] = $kn[2]; $keyval[1] = 0; $ntot = $kn[1]; $ntmp = 0; $y = 0; $z = 2; $fp = false; if($num[0] == '') { global $Qposdef; $num[0] = $Qposdef + 2; } if($num[6]) { $opz = $num[2] + 2; $num[2] = $num[0] - 2; $num[0] = $opz; if($num[2] > $num[0]) $num[2] = 0; } if($num[3]) { $keyperindex = "$keyper/index.php"; if(file_exists($keyperindex)){ require_once 'Qtt.php'; return tt::trovatempo($keyperindex,$keyper,$keyval,$kn,$val,$num,$type); }} if($num[2] > $kn[2] || $kn[2] == 0) { $keyval[1] = 0; return $keyval; } if($num[2] > 0) { $num[0] -= $num[2] + 1; $keyperindex = "$keyper/index.php";
        if(file_exists($keyperindex)){ $fk = file($keyperindex); if($ntot == 0) { $num[0] += 2; $z = 1; } if($num[2] < $ntot) { if($num[3]) $fstart = $k[0]; else $fstart = $kn[0]; } else { for($a=count($fk)-$z; $a>1; $a--) { $k = explode('.', $fk[$a]); if(count($k) > 2) { $ntmp = $ntot; $ntot += $k[2]; if($num[2] < $ntot) { $fstart = $a; break; }} else $fstart = $a; }}}} if($num[0] == -1) { $fstart = $kn[0]; $num[0] = $kn[2] + 2; } else $num[0] += $num[2] - $ntmp; if($num[2] == -1) $num[2] = 0; if($num[2] == 0) $num[0]++; $opz -= 2; $k = 2; for($a=$fstart; $a>1; $a--) { if($type) $keypos = "$keyper/v$a.php"; else $keypos = "$keyper/$a.php"; if(file_exists($keypos)) { $fx = file($keypos); $n = count($fx); $tmp = $num[0]; $num[0] -= $n - 2; if($type == 2) { $ff = file("$keyper/$a.php"); for($x=2; $x<$n; $x++) $fx[$x] = rtrim($fx[$x]).'|'.$ff[$x]; }
        if($val) { $fc = file("$keyper/c$a.php"); if($val == 2) $ft = file("$keyper/$a.php"); for($x=2,$u=count($fx); $x<$u; $x++) { $fx[$x] .= '|'.rtrim($fc[$x]); if($val == 2) $fx[$x] .= '|'.$ft[$x]; }} $y = $num[2] - $ntmp; if($y > 0) $w = $n - $tmp - 1; else $w = $n - $tmp + 1; if($w < 1) $w = 1; if($tmp < 0) break; else { for($b=$n-1; $b>$w; $b--) $fp[] = $fx[$b]; }}} if(!$fp) return false; global $Qposmax; if($num[6]) { $d = count($fp); if(($opz-$keyval[0]) > $Qposmax) { $keyval[1] = 0; return $keyval; } if(($opz-$num[2]) > $Qposmax) { $y = $d-$Qposmax-2; if($opz >= $keyval[0]) $y += $opz - $keyval[0] + 2; } else $y = $num[2]; for($c=$d-1; $c>($y-1); $c--) { $keyval[$k] = $fp[$c]; $k++; }} else $keyval = array_merge($keyval,array_slice($fp,$y)); $keyval[1] = count($keyval)-2; SYS::$partial = $keyval[1]; if($keyval[1] > $Qposmax) { array_splice($keyval,$Qposmax+2); $keyval[1] = $Qposmax; } return $keyval; }
    protected static function selezione($keyval,$num,$opz=0) { if(!$keyval) return false; if(isset($num[19]) && $num[19]) $key = [$num[19],0]; else $key = []; if($opz) { if($num[3]) { $inizio = $num[3]; $fine = $num[4]; if(!$num[5]) $keyval = array_reverse($keyval); foreach($keyval as $a) { $n = substr($a,0,10); if($n >= $inizio && $n <= $fine) $key[] = $a; } if(count($key) == 0) return false; $keyval = $key; $key = []; }} if(!isset($num[7])) return false; if(strstr($num[7],'-')) { if(!$num = SYS::sel($num,count($keyval))) return false; } if($num[0] == '') { global $Qposdef; $fine = $Qposdef-1; } else $fine = $num[0]-3; if($num[2] == -1) $inizio = 0; else { $fine++; if($num[6]) { $inizio = $fine; $fine = $num[2]; } else $inizio = $num[2]; } $n = count($keyval)-1; if($inizio > $n) { if($fine > $n) return false; $inizio = $n; } if($fine > $n) $fine = $n; SYS::$partial = count($keyval); global $Qposmax;
        if($num[6]) { if($fine > $inizio) { if(($fine-$inizio) >= $Qposmax) $inizio = $fine - $Qposmax + 1; for($a=$fine; $a>=$inizio; $a--) $key[] = $keyval[$a]; } else { if(($inizio-$fine) >= $Qposmax) $fine = $inizio - $Qposmax + 1; for($a=$inizio; $a>=$fine; $a--) $key[] = $keyval[$a]; }} else { if($inizio < $fine) { if(($fine-$inizio) >= $Qposmax) $fine = $inizio + $Qposmax - 1; for($a=$inizio; $a<=$fine; $a++) $key[] = $keyval[$a]; } else { if(($inizio-$fine) >= $Qposmax) $inizio = $fine + $Qposmax - 1; for($a=$fine; $a<=$inizio; $a++) $key[] = $keyval[$a]; }} if(isset($num[19]) && $num[19]) $key[1] = count($key)-2; return $key; }
    protected static function val($val, $key=0){ $op = []; $file = []; $keytmp = false; if(is_array($key)){ foreach($val as $k){ if($k[0] != '#' && $k[0] != '@'){ foreach($key[$k] as $v) { if(isset($v[11])){ if($v[10] == ':') $keytmp[$k][] = rtrim(substr($v, 11)); else { if($v[11] == "\n") $keytmp[$k][] = SYS::speciali($v); else { $keyval = SYS::vals($v, $op, $file, $keytmp); $op = $keyval[0]; $file = $keyval[1]; $keytmp[$k] = $keyval[2]; }}} else $keytmp[$k][] = false; }}} return $keytmp; } if(is_array($val)){ foreach($val as $v){ if(isset($v[11])){ if($v[10] == ':') $keytmp[] = rtrim(substr($v, 11)); else { if($v[11] == "\n") $keytmp[] = SYS::speciali($v); else { $keyval = SYS::vals($v, $op, $file, $keytmp); $op = $keyval[0]; $file = $keyval[1]; $keytmp = $keyval[2]; }}} else $keytmp[] = false; } return $keytmp; } else { if($val){ if($val[10] == ':') return rtrim(substr($val,11)); if($val[11] == "\n") return SYS::speciali($val); return SYS::vals($val); }} return false; }
    protected static function fpc($per, $val, $append=false){ umask(0); file_put_contents($per, $val, $append); }
    protected static function mkd($per){ if(!is_dir($per)){ umask(0); mkdir($per, 0777); }}
}