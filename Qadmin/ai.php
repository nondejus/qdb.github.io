<?php  require_once('cookie.php'); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta http-equiv="Content-Language" content="en">
    <meta name="author" content="Piazzi Raffaele">
    <title>QuanticoDB | Artificial Intelligence</title>
    <link type="text/css" rel="stylesheet" href="css/style.css" />
    <link rel="shortcut icon" href="images/favicon.ico" />
    <script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
    <script>function service(x){ $('#ai' + x).toggle(); }</script>
</head>
<body background="images/ai.jpg"><div id="lista" align="center">
<?php

    if(isset($_GET['id']) && $_GET['id']) {
        
    } else {
        
        function Qdirectory($dir) { $files = array_diff(scandir($dir), array('.','..')); $lista = array(); foreach ($files as $file) { (is_dir($dir.'/'.$file)) ? Qdirectory($dir.'/'.$file) : $lista[] = $file; } return $lista; }
        
        $lista = Qdirectory('../class/Qai'); $msg = '<br><br>'; $b = 0;
        foreach($lista as $files) {
            if(substr($files, -4) == '.php') { $e = false; $i = 11; $b++; $nome = substr($files, 0, strlen($files)-4); $fp = file('../class/Qai/'.$files);
                $msg .= '<table id="tab'.$b.'" border="0" width="270" cellspacing="0" cellpadding="0" height="35"><tr>
                	<td class="td14">'.$b.'.</td>
                	<td width="235">
                        <h6 style="font-size:18px"><a href="javascript:service('.$b.')">'.$nome.'</a>
                            <div id="ai'.$b.'" style="display:none">
                                <table cellpadding="0" cellspacing="0" style="background-color:whitesmoke; border:1px solid lightblue; width:100%; margin-top:5px">';
                                    $pos = strpos($fp[2],'@author'); if($pos) $msg .= '<tr><td style="height:26px; padding-left:8px"><h5>Author:</h5></td><td style="height:26px; text-align:center"><h6>'.substr(rtrim($fp[2]),$pos+8).'</h6></td></tr>';
                                	$pos = strpos($fp[3],'@date'); $ver = strpos($fp[4],'@release'); if($pos && $ver) $msg .= '<tr><td style="height:26px; padding-left:8px"><h5>Release:</h5></td><td style="height:26px; text-align:center"><h6>'.substr(rtrim($fp[4]),$ver+9).' &nbsp;('.substr(rtrim($fp[3]),$pos+6).')</h6></td></tr>';
									$pos = strpos($fp[5],'@license'); if($pos) { $x = explode(',',substr($fp[5],$pos+9)); if(isset($x[1])) $z = trim($x[1]); else $z = '';
									   $msg .= '<tr><td style="height:26px; padding-left:8px"><h5>License:</h5></td><td style="height:26px; text-align:center"><h6><a target="_blank" href="'.$z.'">'.$x[0].'</a></h6></td></tr>';
                                    } $msg .= '<tr><td style="height:26; background-color:lavender; text-align:center" colspan="2"><h4 style="color:indigo">Provider</h4></td></tr>';	
									$pos = strpos($fp[7],'@provider'); if($pos) { $x = explode(',',substr($fp[7],$pos+10)); 
                                        for($a=0; $a<count($x); $a++) { $i++; $y = explode('--> ',rtrim($fp[$i])); if(isset($y[1])) $z = $y[1]; else $z = '';
                                            $msg .= '<tr><td style="height:26px; padding-left:8px"><h5>'.trim(strtolower($x[$a])).'</h5></td><td style="height:26px; text-align:center"><a target="_blank" href="'.$z.'"><img src="images/doc.png" width="26px" height="26px"></a></td></tr>';
                                        } $i += 4;
                                    } $msg .= '<tr><td style="height:26; background-color:plum; text-align:center" colspan="2"><h4 style="color:purple">KEY</h4></td></tr>';
									$pos = strpos($fp[8],'@key'); if($pos) { $x = explode(',',substr($fp[8],$pos+5));
                                        for($a=0; $a<count($x); $a++) { $x[$a] = trim(strtolower($x[$a])); $y = explode(' ',$x[$a]); if(isset($y[1])) $z = $y[1]; else $z = '';
                                            $msg .= '<tr><td style="height:26px; padding-left:8px"><h5>'.$y[0].'</h5></td><td style="height:26px; text-align:center"><h6>'.$z.'</h6></td></tr>';
                                        }
                                    } $msg .= ' <tr><td style="height:26; background-color:crimson; text-align:center" colspan="2"><h4 style="color:seashell">Example</h4></td></tr><td style="padding:8px" colspan="2"><h5>';
                                    while(!$e) { $x = trim(substr($fp[$i],2)); $i++;
                                        if($x[0] == "Q") $msg .= '<b>Q\DB::out</b><font color="purple">'.substr($x,8).'</font><br>'; 
                                        elseif($x[0] == "a") $msg .= '<span style="padding-left:18px"><b>array</b></span><span style="color:crimson">'.substr($x,5).'</span><br>';
                                        elseif($x[0] == "'") { $y = explode('=>',$x); $msg .= '<span style="padding-left:56px; color:crimson">'.$y[0].'=></span><span style="color:#09C">'.$y[1].'</span><br>'; }
                                        elseif($x[0] == ")") { $msg .= '<span style="padding-left:18px">'.$x.'</span><br>'; $e = true; }
                                    } $msg .= ');</h5></td>
								</table>
                            </div>
                        </h6>
                    </td>
                 </tr>
                </table>';
            }
        } $msg .= '<table id="tform" border="0" width="230" cellspacing="0" cellpadding="0" height="25"><tr><td>&nbsp;</td></tr></table>'; echo $msg;
    }
    
?>
</div>
</body>
</html>