<?php

if(isset($_POST['type'])) $type = $_POST['type']; else exit;
if(isset($_POST['key'])) $key = $_POST['key'];
if(isset($_POST['pos'])) $pos = $_POST['pos'];
if(isset($_POST['val'])) $val = $_POST['val'];

require_once 'cookie.php'; $tmp = '';
if($dbtype[3] == "test\n") $tmp = '.test'; elseif($dbtype[3] == "clone\n") $tmp = '.clone'; require_once '../Quantico'.$tmp.'.php'; use Quantico as Q;

$ke = explode('@',$key);

function Qh($val){ return hash('sha512', $val); }
function Qdec($str){ global $dirqdb; if(!file_exists($dirqdb.'Qsession.php')) exit; $key = file($dirqdb.'Qsession.php'); return Qdecrypt(rawurldecode($str), $key[2]); }
function Qchiaro($keycomb){ global $Qdatabase; $key = substr(Qdec($_POST['sid']),0,64); $iv = substr($key,16,32); if(is_array($keycomb)) { for($a=2; $a<count($keycomb); $a++) { $r = Qdecrypt(rtrim($keycomb[$a]), $key, $iv); if($r && substr($r,0,128) == Qh(substr($r,128))) $keycomb[$a] = substr($r,128); } return $keycomb; } else { $r = Qdecrypt($keycomb, $key, $iv); if($r && substr($r,0,128) == Qh(substr($r,128))) return substr($r,128); else return false; }}
function Qdettagli($dati){ if(is_array($dati)) { if(isset($dati['K'])) { $msg = array(); // JSON ---> Costruzione del Q\DB::out() completo della KEY Primaria
    foreach($dati['K'] as $keys) {
        if($keys[0] == '#' or $keys[0] == '@') { if($keys[0] == '#') $val = 'multiple'; else $val = 'cloned';
            $msg[$val][] = array('K' => substr($keys,1), 'N' => (int)$dati["N.$keys"], 'T' => (int)$dati["T.$keys"], 'value' => array(), 'time' => array()); $b = count($msg[$val])-1;
            for($a=0; $a<$dati['N.'.$keys]; $a++) { $msg[$val][$b]['value'][$a] = mb_convert_encoding($dati[$keys][$a], 'UTF-8'); $msg[$val][$b]['time'][$a] = date('d M y - H:i:s',$dati[$keys]["t.$a"]); }
        } else $msg['associated'][] = array('K' => $keys, 'value' => mb_convert_encoding($dati[$keys], 'UTF-8'), 'time' => date('d M y - H:i:s',$dati["t.$keys"]));
    } global $Qposmax; $msg['posmax'] = $Qposmax; return json_encode($msg); }} return 0;
}

if($type == 1) { $dati = Q\DB::out("$ke[0]", rtrim($val), -1); exit(Qdettagli($dati)); }
elseif($type == 2) { if(Q\DB::in($key, rtrim($val), rtrim($pos)) !== false) exit('OK'); }
elseif($type == 3) { if(Q\DB::del($key, rtrim($pos), rtrim($val)) !== false) exit('OK'); }
elseif($type == 4) { $dati = Q\DB::out($key, rtrim($val)); $kc = explode('.', $key); $val = array();
    for($a=2; $a<count($keybase); $a++) { $kb = rtrim($keybase[$a]); $ok = false; if(is_array($dati)) { if(isset($dati['K'])) { foreach($dati['K'] as $keys) if($kb == '' or $kb == $keys or '#'.$kb == $keys or '@'.$kb == $keys) { $ok = true; break; }} else { if($kb == '') $ok = true; }} else { if($kb == '') $ok = true; } if(!$ok) $val[] = rtrim($keybase[$a]); }
    for($c=1; $c<8; $c++) { $keycomb = Qchiaro(file("$dirschema/$c.php")); for($d=2; $d<count($keycomb); $d++) { $kc = explode('.', $keycomb[$d]); if(isset($keybase[$kc[0]])) { $tmp = rtrim($keybase[$kc[0]]); if(count($kc) > 2) { for($e=1; $e<(count($kc)-1); $e++) { if(isset($keybase[$kc[$e]])) $tmp .= '.'.rtrim($keybase[$kc[$e]]); } if($key != $tmp) $val[] = $tmp; }}}} exit(json_encode($val));
}
elseif($type == 6) { $dati = Q\DB::out($val, -1); exit(Qdettagli($dati)); }
else { $lng = file('language/'.rtrim($dbtype[4]).'/keyview.php', FILE_IGNORE_NEW_LINES);
    if($type == 7) { $dati = Q\DB::out("-$ke[0]", $val, -1);
        if(is_array($dati)) { $msg = '<table id="t'.$pos.'" border="0" width="100%" cellspacing="0" cellpadding="0"><tr><td class="td1 cl4">KEY</td><td class="td1 cl5">'.$lng[3].'</td><td class="td1">Data</td></tr></tr>';
            foreach($dati['K'] as $keys) { $tempo = date('d M',$dati["t.$keys"]); $tot = date('d M y - H:i:s',$dati["t.$keys"]); if($keys != '-') $msg .= '<tr><td class="td3">'.$keys.'</td><td class="td3 cl6">'.$dati[$keys].'</td><td class="td3"><font size="1" title=" '.$lng[4].' : '.$tot.' ">'.$tempo.'</font></td></tr>'; }; $msg .= '<tr><td height="24" colspan="3"></td></tr></table>'; exit($msg);
        }
    } elseif($type == 8) { $key = base64_decode($key); $dati = Q\DB::out($key,base64_decode($val),-1); $e1 = strpos($key,':')+1; $e2 = strpos($key,')'); $max = substr($key,$e1,$e2-$e1);
        if(is_array($dati)) { $lnk = ''; $pos = explode('-',$pos); $c = array_pop($pos); $tmp = implode('-',$pos); $b = array_pop($pos); $pos = implode('-',$pos); $b = $c; for($a=0; $a<$dati['N']; $a++) { $c++; $tot = date('d M y - H:i:s',$dati["t.$a"]); $lnk .= '<a href="javascript:espandi(\''.$pos.'-'.$c.'\',\''.$dati[$a].'\')"><span id="'.$pos.'-'.$c.'" title=" '.$lng[5].' : '.$tot.'">'.$dati[$a].'</span></a> &nbsp; '; }
            if($c == $dati['T']) $lnk .= '<b><font style="color:#404042; font-size:7pt">[</b>'.($dati["N"]+$b).'/'.$dati["T"].'<b>]</font></b>'; else { $e3 = strpos($key,'(')+1; $k1 = base64_encode(substr($key,0,$e3).$c.':'.($c+$Qposmax).')'); $lnk .= '<span id="'.$tmp.'-'.$c.'"><a href="javascript:next(\''.$k1.'\',\''.$val.'\',\''.$tmp.'-'.$c.'\',8)"><b><font style="color:#00F font-size:7pt">[</b>'.$c.'/'.$dati["T"].'<b>]</font></b></a></span>'; } exit($lnk);
        }
    } elseif($type == 9) { $key = base64_decode($key); $dati = Q\DB::out($key,base64_decode($val),-1); $e1 = strpos($key,':')+1; $e2 = strpos($key,')'); $e3 = strpos($key,'(')+1; $e4 = strpos($key,'@'); $e5 = substr($key,$e4,$e3-$e4-1); $max = substr($key,$e1,$e2-$e1);
        if(is_array($dati)) { $lnk = ''; $pos = explode('-',$pos); $c = array_pop($pos); $tmp = implode('-',$pos); $b = array_pop($pos); $pos = implode('-',$pos); $b = $c; for($a=0; $a<$dati['N']; $a++) { $c++; $tot = date('d M y - H:i:s',$dati["t.$a"]); $lnk .= '<a href="javascript:guarda(\''.$pos.'-'.$c.'\',\''.$dati[$a].$e5.'\')"><span id="'.$pos.'-'.$c.'" title=" '.$lng[6].' : '.$tot.'">'.$dati[$a].'</span></a> &nbsp;'; }          
            if($c == $dati['T']) $lnk .= '<b><font style="color:#404042; font-size:7pt">[</b>'.($dati["N"]+$b).'/'.$dati["T"].'<b>]</font></b>'; else { $k1 = base64_encode(substr($key,0,$e3).$c.':'.($c+$Qposmax).')'); $lnk .= '<span id="'.$tmp.'-'.$c.'"><a href="javascript:next(\''.$k1.'\',\''.$val.'\',\''.$tmp.'-'.$c.'\',9)"><b><font style="color:#00F; font-size:7pt">[</b>'.$c.'/'.$dati["T"].'<b>]</font></b></a></span>'; } exit($lnk);
        }
    }
} exit('0');
    
?>