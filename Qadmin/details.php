<?php

    if(isset($_GET['i']) and isset($_GET['k'])) $k = $_GET['k']; else exit; 
    
    require_once 'cookie.php'; require_once '../Quantico'.$tmp.'.php'; use Quantico as Q;
    
    $ke = explode('@', $k); $ke[1] = substr($ke[1],0,-2); $ke[0] = str_replace(' ','@',$ke[0]); $ogg = explode('@',$ke[0]);
    
    if($ke[4] == 0) { $ora = strtotime(gmdate("M d Y H:i:s", time())) + $Qgmt; $y[0] = date("d", $ora); $y[1] = date("m", $ora); $y[2] = date("Y", $ora); $z[0] = $y[0]; $z[1] = $y[1]; $z[2] = $y[2]; $inizio = 0; $fine = $Qposmax - 1; $dat = 0; } else { $x = explode(':', $ke[2]); $y = explode('-', $x[0]); $z = explode('-', $x[1]); $inizio = $ke[3]; $fine = $ke[4]; $dat = 1; }
    if($ke[2] == '0-0-0:0-0-0') { $ora = strtotime(gmdate("M d Y H:i:s", time())) + $Qgmt; $y[0] = date("d", $ora); $y[1] = date("m", $ora); $y[2] = date("Y", $ora); $z[0] = $y[0]; $z[1] = $y[1]; $z[2] = $y[2]; $dat = 0; } $k = $ke[0].'@'.$ke[1]; $lng = file('language/'.rtrim($dbtype[4]).'/details.php', FILE_IGNORE_NEW_LINES);

?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo rtrim($dbtype[4]); ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta http-equiv="Content-Language" content="<?php echo rtrim($dbtype[4]); ?>">
    <meta name="author" content="Piazzi Raffaele">
    <title>QuanticoDB</title>
    <script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="js/msgbox/msgbox.js"></script>
    <link type="text/css" rel="stylesheet" href="css/msgbox.css" />
    <link type="text/css" rel="stylesheet" href="css/style.css" />
    <link rel="shortcut icon" href="images/favicon.ico" />
    <script type='text/javascript'> sid = '<?php echo rawurldecode(base64_decode($_GET['i'])); ?>';
        function dettagli_json(msg,x,y,z,id,type) { var json = JSON.parse(msg); var b = 0; var c = 0; var c1 = 'cl1'; var c2 = 'cl3'; if(type) { c1 = 'cl4'; c2 = 'cl5'; } msg = '<table id="'+id+z+'" border="0" width="100%" cellspacing="0" cellpadding="0"><tr><td class="td1 '+c1+'">KEY</td><td class="td1 '+c2+'"><?php echo $lng[3]; ?></td><td class="td1">Data</td></tr></tr>';
            if(json.associated) { // --------> Associato o Modello
                for(var a=0; a<json.associated.length; a++) { var p = json.associated[a].time.split(' '); p = p[0]+'&nbsp;'+p[1]+'&nbsp;'; b++; c = z+'-'+b; msg += '<tr><td class="td3"><span id="k'+c+'">'+json.associated[a]['K'].split('.').join('&nbsp;.&nbsp;')+'</span></td>';
                    if(type) msg += '<td class="td3 cl6"><span id="kv'+c+'">'+json.associated[a].value; else msg += '<td class="td3"><a href="javascript:modifica(\'v'+c+'\',1)"><span id="kv'+c+'">'+json.associated[a].value+'</a>'; 
                    msg += '<span id="v'+c+'"></span></span></td><td class="td3"><font size="1" title=" <?php echo $lng[4]; ?> : '+json.associated[a].time+' ">'+p+'</font></td></tr>';
                }
            }
            if(json.multiple) { // ----------> LINKATO
                for(var a=0; a<json.multiple.length; a++) { b++; c = 1; var lnk = ''; var key = json.multiple[a]; for(var d=0; d<key['N']; d++) { var v = key.value[d]; var t = key.time[d]; lnk += '<a href="javascript:espandi(\'s'+z+'-'+b+'-'+c+'\','+v+')"><span id="s'+z+'-'+b+'-'+c+'" title=" <?php echo $lng[5]; ?> : '+t+'">'+v+'</span></a> &nbsp; '; c++; }
                    if(key['N'] == key['T']) lnk += '<span class="ft1 cl9"><b>[</b>'+key['N']+'/'+key['T']+'<b>]</b></span><div id="sk'+z+'-'+b+'-0"></div>'; else { var p = z.split('-'); if(p[1]) { var k1 = '#k'+p[0]; for(var n=1; n<(p.length-1); n++) k1 += '-'+p[n]; k1 = $(k1).text().split(' ').join(''); } else var k1 = "<?php echo $ke[1]; ?>"; k1 += '#'+key['K']+'('+key['N']+':'+(key['N']+json['posmax'])+')'; k1 = window.btoa(k1); var k2 = window.btoa(y); lnk += '<span id="s'+z+'-'+b+'-'+c+'-'+key['N']+'"><a class="ft1 cl8" href="javascript:next(\''+k1+'\',\''+k2+'\',\'s'+z+'-'+b+'-'+c+'-'+key['N']+'\',8)"><b>[</b>'+key['N']+'/'+key['T']+'<b>]</b></a></span><div id="sk'+z+'-'+b+'-0"></div>'; }
                    msg += '<tr><td class="td3 cl7"><span class="ft0 bg2" id="k'+z+'-'+b+'">'+key['K'].split('.').join('&nbsp;.&nbsp;')+'</span></td><td class="td3">'+lnk+'</td><td class="td3"></td></tr>'; 
                }
            }
            if(json.cloned) { // ------------> CLONATO
                for(var a=0; a<json.cloned.length; a++) { b++; c = 1; var lnk = ''; var key = json.cloned[a]; for(var d=0; d<key['N']; d++) { var v = key.value[d]; var t = key.time[d]; lnk += '<a href="javascript:guarda(\'s'+z+'-'+b+'-'+c+'\',\''+v+'@'+key['K']+'\')"><span id="s'+z+'-'+b+'-'+c+'" title=" <?php echo $lng[6]; ?> : '+t+'">'+v+'</span></a> &nbsp;'; c++; };
                    if(key['N'] == key['T']) lnk += '<span class="ft1 cl9"><b>[</b>'+key['N']+'/'+key['T']+'<b>]</b></span><div id="sk'+z+'-'+b+'-0"></div>'; else { var p = z.split('-'); if(p[1]) { var k1 = '#k'+p[0]; for(var n=1; n<(p.length-1); n++) k1 += '-'+p[n]; k1 = $(k1).text().split(' ').join(''); } else var k1 = "<?php echo $ke[1]; ?>"; k1 += '@'+key['K']+'('+key['N']+':'+(key['N']+json['posmax'])+')'; k1 = window.btoa(k1); var k2 = window.btoa(y); lnk += '<span id="s'+z+'-'+b+'-'+c+'-'+key['N']+'"><a class="ft1 cl8" href="javascript:next(\''+k1+'\',\''+k2+'\',\'s'+z+'-'+b+'-'+c+'-'+key['N']+'\',8)"><b>[</b>'+key['N']+'/'+key['T']+'<b>]</b></a></span><div id="sk'+z+'-'+b+'-0"></div>'; }
                    msg += '<tr><td class="td3 cl7"><span class="ft0 bg7" id="k'+z+'-'+b+'">'+key['K'].split('.').join('&nbsp;.&nbsp;')+'</span></td><td class="td3">'+lnk+'</td><td class="td3"></td></tr>';
                } 
            } if(id == 't') var s = 'height:24px'; else var s = 'border-bottom:1px solid #CCD; height=0px'; msg += '<tr><td colspan="3" style="'+s+'"></td></tr></table>'; $('#' + x).append(msg);
        }
        function dettagli(x,y) { z = x.substring(1); w = "'" + x + "'";
            if($("#e" + z).length) { $("#m" + z).html(''); $("#a" + z).remove(); } else { $('#m' + z).html('&nbsp;&nbsp;<a href="javascript:modifica(' + w + ',3)"><img id="e' + z + '" src="images/s_on.bmp" border="0" width="7" height="8" title="<?php echo $lng[7]; ?>"></a> <a href="javascript:modifica(' + w + ',4)"><img src="images/x_off.bmp" border="0" title="<?php echo $lng[8]; ?>"></a> <a href="javascript:modifica(' + w + ',5)"><img src="images/ru_on.bmp" border="0" title="<?php echo $lng[9]; ?>"></a>'); }    
            if($("#t" + z).length) { $("#t" + z).remove(); $("#a" + z).remove(); } else { $.post("keyview.php", { type: 1, key: <?php echo "'$ke[1]'"; ?>, val: y, pos: z }, function(msg){ if(msg != 0) dettagli_json(msg,x,y,z,'t',false); });}
        }
        function modifica(x,y) {
            if(y == 0) { $.msgBox({ title: "QuanticoDB", content: "<?php echo $lng[10]; ?>", buttons: [{ value: "<?php echo $lng[11]; ?>" }, { value: "<?php echo $lng[12]; ?>" }],
                success: function (result) { if(result == "<?php echo $lng[11]; ?>") { z = x.substring(1); u = z.split('-'); k = $("#k" + z).text(); kv = $("#k" + u[0]).text(); kc = <?php echo "'$ke[1] '"; ?>; ks = ''; s = 'k'; if(u.length > 3) { for(a=0; a<(u.length-2); a++) { s = s + u[a] + '-'; }; s = s.substring(0,s.length-1); ks = $("#" + s).text(); ks = $.trim(ks); s = 's'; for(a=0; a<(u.length-1); a++) { s = s + u[a] + '-'; }; s = s.substring(0,s.length-1); s = $("#" + s).text(); }; if(ks == '') { kc = kc + k; } else { kc = ks + ' ' + k; kv = s; }; $.post('keyview.php', { type: 3, key: kc, val: 0, pos: kv }, function(msg){ if(msg) { $("#t" + u[0]).remove(); $("#m" + z).html(''); dettagli('v' + u[0],kv); } else error(); });}}});}
            else if(y == 1) { z = x.substring(1); w = "'" + x + "'"; if($("#qsx").length) { $("#" + x).html(''); } else { $("#" + x).append(' <input class="ykc" id="d' + z + '" type="text"> <a href="javascript:modifica(' + w + ',2)"><img id="qsx" src="images/s_on.bmp" border="0" width="7" height="8" title="<?php echo $lng[7]; ?>"></a> <a href="javascript:modifica(' + w + ',0)"><img src="images/x_off.bmp" border="0" title="<?php echo $lng[8]; ?>"></a>'); }}
            else if(y == 2) { z = x.substring(1); u = z.split('-'); k = $("#k" + z).text(); kv = $("#k" + u[0]).text(); kc = <?php echo "'$ke[1] '"; ?>; kd = $("#d" + z).val(); ks = ''; s = 'k'; if(u.length > 3) { for(a=0; a<(u.length-2); a++) { s = s + u[a] + '-'; }; s = s.substring(0,s.length-1); ks = $("#" + s).text(); ks = $.trim(ks); s = 's'; for(a=0; a<(u.length-1); a++) { s = s + u[a] + '-'; }; s = s.substring(0,s.length-1); s = $("#" + s).text(); }; if(ks == '') { kc = kc + k; } else { kc = ks + ' ' + k; kv = s; }; if(kd != '') { $.post('keyview.php', { type: 2, key: kc, val: kd, pos: kv }, function(msg){ if(msg) { $("#v" + z).html(''); $("#kv" + z).html(kd); } else { alert('<?php echo $lng[13]; ?>'); }}); } else { $("#v" + z).html(''); }}
            else if(y == 3) { z = x.substring(1); if($("#d" + z).length) { kd = $("#d" + z).val(); if(kd != '') { kv = $("#k" + z).text(); kc = <?php echo "'$ke[1]'"; ?>; $.post('keyview.php', { type: 2, key: kc, val: kv, pos: kd }, function(msg){ if(msg > 0) { $("#m" + z).html(''); $("#k" + z).html(kd); } else { alert('<?php echo $lng[13]; ?>'); }}); }} else { $("#m" + z).html(''); $('#m' + z).html(' <input class="ykc" id="d' + z + '" type="text"> <a href="javascript:modifica(' + w + ',3)"><img id="e' + z + '" src="images/s_on.bmp" border="0" width="7" height="8" title="<?php echo $lng[7]; ?>"></a> <a href="javascript:modifica(' + w + ',4)"><img src="images/x_off.bmp" border="0" title="<?php echo $lng[8]; ?>"></a> <a href="javascript:modifica(' + w + ',5)"><img src="images/ru_on.bmp" border="0" title="<?php echo $lng[9]; ?>"></a>'); }}  
            else if(y == 4) { $.msgBox({ title: "QuanticoDB", content: "<?php echo $lng[14]; ?>", buttons: [{ value: "<?php echo $lng[11]; ?>" }, { value: "<?php echo $lng[12]; ?>" }], 
                success: function (result) { if(result == "<?php echo $lng[11]; ?>") { z = x.substring(1); kv = $("#k" + z).text(); kc = <?php echo "'$ke[1]'"; ?>; $.post('keyview.php', { type: 3, key: kc, val: 0, pos: kv }, function(msg){ if(msg > 0) { $("#m" + z).html(''); $("#v" + z).html(''); dettagli('v' + z,kv); } else error(); });}}});}
            else if(y == 5) { z = x.substring(1); kv = $("#k" + z).text(); kc = <?php echo "'$ke[1]'"; ?>; if($("#a" + z).length == 0) { $.post('keyview.php', { type: 4, key: kc, val: kv, pos: z, sid: sid }, function(msg){ $('#' + x).append(msg); }); }}
        }
        function cancellato(x,y) { z = x.substring(1);
            if($("#t" + z).length) { $("#t" + z).remove(); $("#a" + z).remove(); } else { $.post("keyview.php", { type: 7, key: <?php echo "'$ke[1]'"; ?>, val: y, pos: z }, function(msg){ if(msg != 0) { $('#' + x).append(msg); }}); }
        }
        function aggiungi(x,y) {
	    	if(y == 0) { $("#ag" + x).attr("src","images/ru_off.bmp"); } else if(y == 1) { $("#ag" + x).attr("src","images/ru_on.bmp"); } else if(y == 2) { u = x.split('-'); k = $("#ak" + x).text(); kp = $("#k" + u[0]).text(); kv = $("#av" + x).val(); kc = <?php echo "'$ke[1] '"; ?>; kc = kc + k; $.post("keyview.php", { type: 2, key: kc, val: kv, pos: kp }, function(msg){ if(msg) { $("#ar" + x).remove(); } else { alert('<?php echo $lng[13]; ?>'); }}); }
        }
        function data() { fine = <?php echo $Qposmax - 1; ?>;
            dag = $("#da_giorno").val(); dam = $("#da_mese").val(); daa = $("#da_anno").val(); ag = $("#a_giorno").val(); am = $("#a_mese").val(); aa = $("#a_anno").val();
	    	location.href = 'view.php?k=<?php echo $k; ?>@' + dag + '-' + dam + '-' + daa + ':' + ag + '-' + am + '-' + aa + '@0@' + fine;
        }
        function part(x,y) {
            dag = $("#da_giorno").val(); dam = $("#da_mese").val(); daa = $("#da_anno").val(); ag = $("#a_giorno").val(); am = $("#a_mese").val(); aa = $("#a_anno").val();
	    	location.href = 'view.php?k=<?php echo $k; ?>@' + dag + '-' + dam + '-' + daa + ':' + ag + '-' + am + '-' + aa + '@' + x + '@' + y;
        }
        function pos(x,y) {
            location.href = 'view.php?k=<?php echo $k; ?>@0-0-0:0-0-0@' + x + '@' + y;
        }
        function espandi(x,y) { z = x.substring(1); g = z.split('-'); v = ''; for(a=0; a<(g.length - 1); a++) { v = v + g[a] + '-'; }; p = v + '0'; v = v.substring(0, (v.length - 1)); r = $("#k" + v).text(); r = $.trim(r);
            if($("#n" + z).length) { $("#n" + z).remove(); $('#' + x).css('color','#09C'); } else { $.post("keyview.php", { type: 1, key: r, val: y, pos: z }, function(msg){ if(msg != 0) { $('#' + x).css('color','red'); x = 'sk'+p; dettagli_json(msg,x,y,z,'n',false); }});}
        }
        function guarda(x,y) { z = x.substring(1); g = z.split('-'); v = ''; for(a=0; a<(g.length - 1); a++) { v = v + g[a] + '-'; }; p = v + '0'; v = v.substring(0, (v.length - 1)); r = $("#k" + v).text(); r = $.trim(r);
            if($("#n" + z).length) { $("#n" + z).remove(); $('#' + x).css('color','#09C'); } else { $.post("keyview.php", { type: 6, key: r, val: y, pos: z }, function(msg){ if(msg != 0) { $('#' + x).css('color','red'); x = 'sk'+p; dettagli_json(msg,x,y,z,'n',true); }});}
        }
        function chiudi(x,y) {
        	if(y == 0) { $("#x" + x).attr("src","images/x_off.bmp"); } if(y == 1) { $("#x" + x).attr("src","images/x_on.bmp"); } if(y == 2) { $("#a" + x).remove(); }
        }
        function setdata(a,b,c,d,e,f,dat) { if(dat == 0) $("#xp").css('font-weight', 'bold'); else $("#xd").css('font-weight', 'bold');
            $("#da_giorno").val(a); $("#da_mese").val(b); $("#da_anno").val(c); $("#a_giorno").val(d); $("#a_mese").val(e); $("#a_anno").val(f);
        }
        function next(x,y,z,w) {
            $.post("keyview.php", { type: w, key: x, val: y, pos: z }, function(msg){ if(msg != 0) $('#' + z).html(msg); });
        }
        function error() {
            $.msgBox({ type: 'error', title: 'QuanticoDB', content: '<?php echo $lng[15]; ?>' });
        }
    </script>
</head>
<body>
<?php
    $giorno = '<option selected value="01">01</option><option value="02">02</option><option value="03">03</option><option value="04">04</option><option value="05">05</option><option value="06">06</option><option value="07">07</option><option value="08">08</option><option value="09">09</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option></select> ';
    $mese = '<option selected value="01">'.$lng[16].'</option><option value="02">'.$lng[17].'</option><option value="03">'.$lng[18].'</option><option value="04">'.$lng[19].'</option><option value="05">'.$lng[20].'</option><option value="06">'.$lng[21].'</option><option value="07">'.$lng[22].'</option><option value="08">'.$lng[23].'</option><option value="09">'.$lng[24].'</option><option value="10">'.$lng[25].'</option><option value="11">'.$lng[26].'</option><option value="12">'.$lng[27].'</option></select> ';
    $anno = '<option value="2017">2017</option><option value="2018">2018</option><option value="2019">2019</option><option value="2020">2020</option><option value="2021">2021</option><option value="2022">2022</option><option value="2023">2023</option><option value="2024">2024</option><option value="2025">2025</option><option value="2026">2026</option><option value="2027">2027</option><option value="2028">2028</option><option value="2029">2029</option><option value="2030">2030</option><option value="2031">2031</option><option value="2032">2032</option><option value="2033">2033</option><option value="2034">2034</option><option value="2035">2035</option><option value="2036">2036</option><option value="2037">2037</option><option value="2038">2038</option><option value="2039">2039</option><option value="2040">2040</option></select> ';
    $val = Q\DB::out($ke[0],-1); echo '<div align="center"><table border="0" width="800" cellspacing="0" cellpadding="0" bgcolor="#FFFEFF"><tr><td class="td5 cl1" title="'.$lng[28].'">&nbsp;Array&nbsp;</td><td class="td5 cl4">KEY</td><td class="td5 cl5">'.$lng[3].'</td><td class="td5">&nbsp;Data&nbsp;</td></tr><tr><td height="10"></td><td height="10"></td><td height="10"></td><td height="10"></td></tr>';
    
    for($a=0; $a<$val['N']; $a++) { $tempo = date('d M',$val['t.'.$val['K'][$a]]); $tot = date('d M y - H:i:s',$val['t.'.$val['K'][$a]]); echo '<tr><td class="td4">'.($inizio+$a).'</td><td class="td4">'.$val['K'][$a].'</td><td class="td4 cl3">'.$val[$val['K'][$a]].'</td><td class="td4"><font size="2" title=" '.$lng[4].' : '.$tot.' ">'.$tempo.'</font></td></tr>'; }
    echo '</table><table width="800" cellspacing="0" cellpadding="0" class="td2"><tr><td align="center" colspan="2" class="td6 cl1"><b>'.$ogg[0].'</b>&nbsp;&nbsp; <font size="5">&gt;&gt;&gt;&nbsp;&nbsp; '.$ogg[1].' : <b>'.Q\DB::ver($ke[0]).'</b></font></td></tr><tr><td align="center" colspan="2" style="border-bottom: 1px solid #F0F0F0"><table border="0" width="100%" cellspacing="0" cellpadding="0" height="100%"><tr><td class="td2 cl1" title="'.$lng[28].'">&nbsp;Array&nbsp;</td><td class="td2 cl3">'.$ke[1].'</td><td class="td2">&nbsp;Data&nbsp;</td></tr><tr>'; if($ke[2] == '0-0-0:0-0-0') { $val = Q\DB::out($ke[0]."($inizio:$fine) $ke[1]", -1); $t = 0; } else { $val = Q\DB::out($ke[0]."[$ke[2]]($inizio:$fine) $ke[1]", -1); $t = 1; }
    
    for($a=0; $a<$val['N']; $a++) { $tempo = date('d M',$val["t.$a"]); $tot = date('d M y - H:i:s',$val["t.$a"]); if($val["-.$a"]) { if(strpos($val[$a],"'") !== false) $href = '<a class="cl1" href=javascript:cancellato("v'.$a.'","'.$val["-.$a"].'")>'; else $href = '<a class="cl1" href=\'javascript:cancellato("v'.$a.'","'.$val["-.$a"].'")\'>'; echo '<td class="td4">'.$a.'</td><td id="v'.$a.'" class="td4 cl1">'.$href.'<span id="k'.$a.'">'.$val[$a].'</span></a><span id="m'.$a.'"></span></td><td class="td4"><font size="2" title=" '.$lng[29].' : '.$tot.' ">'.$tempo.'</font></td><tr></tr>'; } else { if(strpos($val[$a],"'") !== false) $href = '<a href=javascript:dettagli("v'.$a.'","'.$val[$a].'")>'; else $href = '<a href=\'javascript:dettagli("v'.$a.'","'.$val[$a].'")\'>'; echo '<td class="td4">'.$a.'</td><td id="v'.$a.'" class="td4">'.$href.'<span id="k'.$a.'">'.$val[$a].'</span></a><span id="m'.$a.'"></span></td><td class="td4"><font size="2" title=" '.$lng[4].' : '.$tot.' ">'.$tempo.'</font></td><tr></tr>'; }}
    echo '</table></td></tr><tr><td align="center" height="60"><select size="1" id="da_giorno">'.$giorno.'<select size="1" id="da_mese">'.$mese.'<select size="1" id="da_anno">'.$anno.'<select size="1" id="a_giorno">'.$giorno.'<select size="1" id="a_mese">'.$mese.'<select size="1" id="a_anno">'.$anno.'<font face="Arial" size="2">&nbsp;&nbsp;<a href="javascript:data()" title="'.$lng[30].'"><span id="xd">Data</span></a>&nbsp&nbsp|&nbsp&nbsp<a href="javascript:pos(0,0)" title="'.$lng[31].'"><span id="xp">'.$lng[32].'</span></a></font></td><td align="center" height="60"><h6>';
    
    if($dat) { if($inizio > 0) echo '<a href="javascript:part('.($inizio-$Qposmax).','.($inizio-1).')">'.$lng[33].'</a> '; if(($fine+1) <= $val['T']) { if($val['N'] == 0) echo '<b>( 0 )</b> <a href="javascript:part('.($fine+1).','.($fine+$Qposmax).')">'.$lng[34].'</a>'; else echo '<b>('.$inizio.' - '.$fine.')</b> <a href="javascript:part('.($fine+1).','.($fine+$Qposmax).')">'.$lng[34].'</a>'; } else echo '<b>('.$inizio.' - '.($inizio+$val['N']-1).')</b>'; } else { if($inizio > 0) echo '<a href="javascript:pos('.($inizio-$Qposmax).','.($inizio-1).')">'.$lng[33].'</a> '; if(($fine+1) <= $val['T']) { if($val['N'] == 0) echo '<b>( 0 )</b> <a href="javascript:pos('.($fine+1).','.($fine+$Qposmax).')">'.$lng[34].'</a>'; else echo '<b>('.$inizio.' - '.$fine.')</b> <a href="javascript:pos('.($fine+1).','.($fine+$Qposmax).')">'.$lng[34].'</a>'; } else echo '<b>('.$inizio.' - '.($inizio+$val['N']-1).')</b>'; } echo '</h6></td></tr></table></div>';
?>
<script>setdata(<?php echo "'$y[0]','$y[1]','$y[2]','$z[0]','$z[1]','$z[2]',$dat"; ?>);</script>
</body>
</html>