<?php 
    require_once 'cookie.php'; if($dbtype[3] == "test\n") $tmp = '.test'; elseif($dbtype[3] == "clone\n") $tmp = '.clone'; else $tmp = ''; $link = false;
    require_once '../Quantico'.$tmp.'.php'; require 'temp/valore.php'; $key = file($Qdatabase.'/link.php'); $fp = file('temp/valore.php'); $v = substr($fp[0],23,strlen($fp[0])-25); $k = explode(' ',$v);
    for($a=0; $a<2; $a++) { 
        if(isset($k[$a])) { $b = strpos($k[$a],'{'); if($b > 1) $k[$a] = substr($k[$a],0,$b); }
        if(isset($k[$a])) { $b = strpos($k[$a],'['); if($b > 1) $k[$a] = substr($k[$a],0,$b); }
        if(isset($k[$a])) { $b = strpos($k[$a],'('); if($b > 1) $k[$a] = substr($k[$a],0,$b); }
        if(isset($k[$a])) { $b = strpos($k[$a],'"'); if($b > 1) $k[$a] = substr($k[$a],0,$b); }
        if(isset($k[$a])) { $b = strpos($k[$a],"'"); if($b > 1) $k[$a] = substr($k[$a],0,$b); }
    } for($a=2; $a<count($key); $a++) { $b = explode('#',$key[$a]); if($b[0][strlen($b[0])-1] != '@') $link[$a-2] = $b[0]; } $lng = file('language/'.rtrim($dbtype[4]).'/tabella.php',FILE_IGNORE_NEW_LINES);
    if($link) { $lk = array_unique($link); sort($lk); } else exit('<br><h1 align="center">'.$lng[3].'</h1>');
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo rtrim($dbtype[4]); ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta http-equiv="Content-Language" content="<?php echo rtrim($dbtype[4]); ?>">
    <meta name="author" content="Piazzi Raffaele">
    <title>QuanticoDB</title>
    <link type="text/css" rel="stylesheet" href="css/style.css" />
    <link rel="shortcut icon" href="images/favicon.ico" />
</head>
<body>
<?php
    if(isset($val['K'])) { $ok = true;
        if(strpos($fp[0], '!') > 17) { echo '<table width="100%" cellspacing="0" cellpadding="0" class="td0"><tr><td class="td7 cl1">Array</td><td class="td7 cl1">'.$val['K'][0]."</td><td class='td7 cl1'>".$lng[4]."</td></tr>";
            for($a=0; $a<$val['N']; $a++) echo '<tr><td class="td8">'.$a.'</td><td class="td8 cl2">'.$val[$val['K'][0]][$a].'</td><td class="td8 cl2">'.$val['N.'.$val['K'][0]][$a].'</td></tr>'; echo '<tr><td class="td8"></td><td class="td8">'.$lng[5].': '.$val['N'].'</td><td class="td8">'.$lng[5].': '.$val['T.'.$val['K'][0]].'</td></tr></table>';
        } else {
            if(isset($val[0])) { for($a=0; $a<2; $a++) { $b = strpos($k[$a],'#'); if($b > 1) $k[$a] = substr($k[$a],0,$b); $b = strpos($k[$a],'@'); if($b > 1) $k[$a] = substr($k[$a],0,$b); } echo '<table width="100%" cellspacing="0" cellpadding="0" class="td0"><tr><td class="td7 cl1">Array</td><td class="td7 cl1">'.$k[0].'</td>';
                foreach($val['K'] as $key) echo '<td class="td7 cl1">'.$key.'</td>'; echo '</tr>'; for($a=0; $a<$val['N']; $a++) { echo '<tr><td class="td8">'.$a.'</td><td class="td8 cl3">'.$val[$a].'</td>';
                    foreach($val['K'] as $key) {
                        if($key[0] == '#') { echo '<td class="td8 cl8">'; if(isset($val['N.'.$key.'.'.$a])) { for($b=0; $b<$val['N.'.$key.'.'.$a]; $b++) echo $val[$key.'.'.$a][$b].'&nbsp; '; echo '<font size="1" color="#F00"> <b>[</b> '.$val['N.'.$key.'.'.$a].'/'.$val['T.'.$key.'.'.$a].' <b>]</b></font></td>'; } else echo '</td>'; }
                        elseif($key[0] == '@')  { echo '<td class="td8">'; if(isset($val['N.'.$key.'.'.$a])) { for($b=0; $b<$val['N.'.$key.'.'.$a]; $b++) echo $val[$key.'.'.$a][$b].'&nbsp; '; echo '<font size="1" color="#F00"> <b>[</b> '.$val['N.'.$key.'.'.$a].'/'.$val['T.'.$key.'.'.$a].' <b>]</b></font></td>'; } else echo '</td>'; }
                        else echo '<td class="td8 cl2">'.$val[$key][$a].'</td>';
                    }
                } echo '</tr><tr><td class="td8"></td><td class="td8">'.$lng[5].': '.$val['N'].'</td>'; foreach($val['K'] as $key) echo '<td class="td8">'.$lng[5].': '.$val['N.'.$key].'</td>'; echo '</tr></table>';
            } else { $max = 0; foreach($val['K'] as $key) if($key[0] != '#') $ok = false; else { if($val['N.'.$key] > $max) $max = $val['N.'.$key]; }
                if($ok) { echo '<table width="100%" cellspacing="0" cellpadding="0" class="td0"><tr><td class="td7 cl1">Array</td>'; foreach($val['K'] as $key) echo '<td class="td7 cl1">'.$key.'</td>'; echo '</tr>';
                    for($a=0; $a<$max; $a++) { echo '<tr><td class="td8">'.$a.'</td>'; foreach($val['K'] as $key) echo '<td class="td8 cl2">'.$val[$key][$a].'</td>'; echo '</tr>'; } echo '<tr><td class="td8"></td>'; foreach($val['K'] as $key) echo '<td class="td8">'.$lng[5].': '.$val['N.'.$key].'</td>'; echo '</tr></table>';
                } else { echo '<table width="100%" cellspacing="0" cellpadding="0" class="td0"><tr>'; foreach($val['K'] as $key) echo '<td class="td7 cl1">'.$key.'</td>'; echo '</tr><tr>';
                    foreach($val['K'] as $key) {
                        if($key[0] == '#') { echo '<td class="td8 cl8">'; for($a=0; $a<$val['N.'.$key]; $a++) echo $val[$key][$a].'&nbsp; '; echo '<font size="1" color="#F00"> <b>[</b> '.$val['N.'.$key].'/'.$val['T.'.$key].' <b>]</b></font></td>'; }
                        elseif($key[0] == '@') { echo '<td class="td8">'; for($a=0; $a<$val['N.'.$key]; $a++) echo $val[$key][$a].'&nbsp; '; echo '<font size="1" color="#F00"> <b>[</b> '.$val['N.'.$key].'/'.$val['T.'.$key].' <b>]</b></font></td>'; }
                        else echo '<td class="td8 cl2">'.$val[$key].'</td>';
                    } echo '</tr></table>';
                }
            }
        } echo'<br><p align="center"><font face="Arial" size="3">'.$lng[5].' <font color="#F00"><b>'.$k[0].'</font> : '.$val['T'].'</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </font>'; $val = substr($fp[0],21,strlen($fp[0])-25); echo '<font face="Arial" size="5"><font color="#9C0">Qdb<font color="#00f">::<font color="#9C0">out</font><font color="#333">'.$val.'</p><br>';
    } elseif(isset($val['p.0'])) { echo '<table width="100%" cellspacing="0" cellpadding="0" class="td0"><tr><td class="td7 cl1">Array</td><td class="td7 cl1">'.$k[0].'</td><td class="td7 cl1">'.$k[1].'</td></tr>';
        for($a=0; $a<$val['N']; $a++) { if($val['-.'.$a]) $v = '<font color="#F00" title="'.$lng[6].'">'.$val[$a].'</font>'; else $v = '<h6>'.$val[$a].'</h6>'; echo '<tr><td class="td8">'.$a.'</td><td class="td8">'.$val['p.'.$a].'</td><td class="td8">'.$v.'</td></tr>'; }
        echo '<tr><td class="td8"></td><td class="td8">'.$lng[5].': '.$val['N'].'</td><td class="td8">'.$lng[5].': '.$val['N'].'</td></tr></table><br><p align="center"><font face="Arial" size="3">'.$lng[5].' <font color="#F00"><b>'.$k[0].'</font> : '.$val['T'].'</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </font>'; 
        $val = substr($fp[0],21,strlen($fp[0])-25); echo '<font face="Arial" size="5"><font color="#9C0">Qdb<font color="#00f">::<font color="#9C0">out</font><font color="#333">'.$val.'</p><br>';
    } elseif(isset($val['-.0'])) { echo '<table width="100%" cellspacing="0" cellpadding="0" class="td0"><tr><td class="td7 cl1">Array</td><td class="td7 cl1">'.$k[1].'</td></tr>';
        for($a=0; $a<$val['N']; $a++) { if($val['-.'.$a]) $v = '<font color="#F00" title="'.$lng[6].'">'.$val[$a].'</font>'; else $v = '<h6>'.$val[$a].'</h6>'; echo '<tr><td class="td8">'.$a.'</td><td class="td8">'.$v.'</td></tr>'; }
        echo '<tr><td class="td8"></td><td class="td8">'.$lng[5].': '.$val['N'].'</td></tr></table><br><p align="center"><font face="Arial" size="3">'.$lng[5].' <font color="#F00"><b>'.$k[0].'</font> : '.$val['T'].'</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </font>'; 
        $val = substr($fp[0],21,strlen($fp[0])-25); echo '<font face="Arial" size="5"><font color="#9C0">Qdb<font color="#00f">::<font color="#9C0">out</font><font color="#333">'.$val.'</p><br>';
    } else echo "<br><h2 align='center'>".$lng[7]."</h2>";
?>
</body>
</html>