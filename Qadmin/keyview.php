<?php

if(isset($_POST['type'])) $type = $_POST['type']; else exit;
if(isset($_POST['key'])) $key = $_POST['key'];
if(isset($_POST['pos'])) $pos = $_POST['pos'];
if(isset($_POST['val'])) $val = $_POST['val'];

require_once 'cookie.php';

if($dbtype[3] == "test\n") $Qdatabase = substr($Qdatabase, 0, -5);
elseif($dbtype[3] == "clone\n") $Qdatabase = substr($Qdatabase, 0, -6);

require_once '../Quantico'.$tmp.'.php'; use Quantico as Q;

$ke = explode('@',$key);

function Qdettagli($dati){ if(is_array($dati)) { if(isset($dati['K'])) { $msg = array(); // JSON ---> Costruzione del Q\DB::out() completo della KEY Primaria
    foreach($dati['K'] as $keys) {
        if($keys[0] == '#' or $keys[0] == '@') { if($keys[0] == '#') $val = 'multiple'; else $val = 'cloned';
            $msg[$val][] = array('K' => substr($keys,1), 'N' => (int)$dati["N.$keys"], 'T' => (int)$dati["T.$keys"], 'value' => array(), 'time' => array()); $b = count($msg[$val])-1;
            for($a=0; $a<$dati["N.$keys"]; $a++) { $msg[$val][$b]['value'][$a] = mb_convert_encoding($dati[$keys][$a], 'UTF-8'); $msg[$val][$b]['time'][$a] = date('d M y - H:i:s',$dati[$keys]["t.$a"]); }
        } else $msg['associated'][] = array('K' => $keys, 'value' => mb_convert_encoding($dati[$keys], 'UTF-8'), 'time' => date('d M y - H:i:s',$dati["t.$keys"]));
    } global $Qposmax; $msg['posmax'] = $Qposmax; return json_encode($msg); }} return 0;
}

if($type == 1) { $dati = Q\DB::out("$ke[0]", rtrim($val), _T1_); exit(Qdettagli($dati)); }
elseif($type == 2) { if(Q\DB::in($key, rtrim($val), rtrim($pos)) !== false) exit('OK'); }
elseif($type == 3) { if(Q\DB::del($key, rtrim($pos), rtrim($val)) !== false) exit('OK'); }
elseif($type == 4) { $dati = Q\DB::out($key, rtrim($val)); $kc = explode('.', $key); $val = array(); for($a=2, $u=count($Qkeybase); $a<$u; $a++) { $kb = rtrim($Qkeybase[$a]); $ok = false; if(is_array($dati)) { if(isset($dati['K'])) { foreach($dati['K'] as $keys) if($kb == '' || $kb == $keys) { $ok = true; break; }} else { if($kb == '') $ok = true; }} else { if($kb == '') $ok = true; } if(!$ok) $val[] = rtrim($Qkeybase[$a]); }
    for($c=1; $c<8; $c++) { $keycomb = Qchiaro(file("$dirschema/$c.php")); for($d=2, $u=count($keycomb); $d<$u; $d++) { $kc = explode('.', $keycomb[$d]); if(isset($Qkeybase[$kc[0]])) { $tmp = rtrim($Qkeybase[$kc[0]]); $uc = count($kc); if($uc > 2) { for($e=1; $e<($uc-1); $e++) { if(isset($Qkeybase[$kc[$e]])) $tmp .= '.'.rtrim($Qkeybase[$kc[$e]]); } if($key != $tmp) $val[] = $tmp; }}}} exit(json_encode($val)); }
elseif($type == 6) { $dati = Q\DB::out($val, _T1_); exit(Qdettagli($dati)); }
else { $lng = file('language/'.rtrim($dbtype[4]).'/keyview.php', FILE_IGNORE_NEW_LINES);
    if($type == 7) { $dati = Q\DB::out("-$ke[0]", $val, _T1_);
        if(is_array($dati)) { $msg = '<table id="t'.$pos.'" border="0" width="100%" cellspacing="0" cellpadding="0"><tr><td class="td1 cl4">KEY</td><td class="td1 cl5">'.$lng[3].'</td><td class="td1">Data</td></tr></tr>';
            foreach($dati['K'] as $keys) { $tempo = date('d M',$dati["t.$keys"]); $tot = date('d M y - H:i:s',$dati["t.$keys"]); if($keys != '-') $msg .= '<tr><td class="td3">'.$keys.'</td><td class="td3 cl6">'.$dati[$keys].'</td><td class="td3"><font size="1" title=" '.$lng[4].' : '.$tot.' ">'.$tempo.'</font></td></tr>'; }; $msg .= '<tr><td height="24" colspan="3"></td></tr></table>'; exit($msg);
        }
    } elseif($type == 8) { $key = base64_decode($key); $dati = Q\DB::out($key,base64_decode($val), _T1_); $e1 = strpos($key,':')+1; $e2 = strpos($key,')'); $max = substr($key,$e1,$e2-$e1);
        if(is_array($dati)) { $lnk = ''; $pos = explode('-',$pos); $c = array_pop($pos); $tmp = implode('-',$pos); $b = array_pop($pos); $pos = implode('-',$pos); $b = $c; for($a=0; $a<$dati['N']; $a++) { $c++; $tot = date('d M y - H:i:s',$dati["t.$a"]); $lnk .= '<a href="javascript:espandi(\''.$pos.'-'.$c.'\',\''.$dati[$a].'\')"><span id="'.$pos.'-'.$c.'" title=" '.$lng[5].' : '.$tot.'">'.$dati[$a].'</span></a> &nbsp; '; }
            if($c == $dati['T']) $lnk .= '<b><font style="color:#404042; font-size:7pt">[</b>'.($dati["N"]+$b).'/'.$dati["T"].'<b>]</font></b>'; else { $e3 = strpos($key,'(')+1; $k1 = base64_encode(substr($key,0,$e3).$c.':'.($c+$Qposmax).')'); $lnk .= '<span id="'.$tmp.'-'.$c.'"><a href="javascript:next(\''.$k1.'\',\''.$val.'\',\''.$tmp.'-'.$c.'\',8)"><b><font style="color:#00F font-size:7pt">[</b>'.$c.'/'.$dati["T"].'<b>]</font></b></a></span>'; } exit($lnk);
        }
    } elseif($type == 9) { $key = base64_decode($key); $dati = Q\DB::out($key,base64_decode($val), _T1_); $e1 = strpos($key,':')+1; $e2 = strpos($key,')'); $e3 = strpos($key,'(')+1; $e4 = strpos($key,'@'); $e5 = substr($key,$e4,$e3-$e4-1); $max = substr($key,$e1,$e2-$e1);
        if(is_array($dati)) { $lnk = ''; $pos = explode('-',$pos); $c = array_pop($pos); $tmp = implode('-',$pos); $b = array_pop($pos); $pos = implode('-',$pos); $b = $c; for($a=0; $a<$dati['N']; $a++) { $c++; $tot = date('d M y - H:i:s',$dati["t.$a"]); $lnk .= '<a href="javascript:guarda(\''.$pos.'-'.$c.'\',\''.$dati[$a].$e5.'\')"><span id="'.$pos.'-'.$c.'" title=" '.$lng[6].' : '.$tot.'">'.$dati[$a].'</span></a> &nbsp;'; }          
            if($c == $dati['T']) $lnk .= '<b><font style="color:#404042; font-size:7pt">[</b>'.($dati["N"]+$b).'/'.$dati["T"].'<b>]</font></b>'; else { $k1 = base64_encode(substr($key,0,$e3).$c.':'.($c+$Qposmax).')'); $lnk .= '<span id="'.$tmp.'-'.$c.'"><a href="javascript:next(\''.$k1.'\',\''.$val.'\',\''.$tmp.'-'.$c.'\',9)"><b><font style="color:#00F; font-size:7pt">[</b>'.$c.'/'.$dati["T"].'<b>]</font></b></a></span>'; } exit($lnk);
        }
    }
} exit('0');
    
?>