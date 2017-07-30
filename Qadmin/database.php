<?php require_once 'cookie.php'; $lng = file('language/'.rtrim($dbtype[4]).'/database.php', FILE_IGNORE_NEW_LINES); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo rtrim($dbtype[4]); ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta http-equiv="Content-Language" content="<?php echo rtrim($dbtype[4]); ?>">
    <meta name="author" content="Piazzi Raffaele">
    <title>QuanticoDB | Admin</title>
    <script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="js/lytebox/lytebox.js"></script>
    <script type="text/javascript" src="js/msgbox/msgbox.js"></script>
<?php 
    if($dbtype[6] == "1\n") echo '
    <script type="text/javascript" src="js/yoshi/yoshi.js"></script>
    <script type="text/javascript" src="js/yoshi/bg.js"></script>
    <link type="text/css" rel="stylesheet" href="css/yoshi.css" />'."\n\n";
?>
    <link type="text/css" rel="stylesheet" href="css/lytebox.css" />
    <link type="text/css" rel="stylesheet" href="css/msgbox.css" />
    <link type="text/css" rel="stylesheet" href="css/style.css" />
    <link rel="shortcut icon" href="images/favicon.ico" />
    <script type='text/javascript'>kbase = new Array(); fi = new Array(0,0,0,0,0,0,0,0); nkey = 0; ok = 0; mk = 1; old = ''; lng = '<?php echo rtrim($dbtype[4]); ?>'; sid = '<?php echo rawurldecode($_GET["id"]); ?>'; dbmn = '<?php echo $Qmaintenance; ?>'; dbty = '<?php echo rtrim($dbtype[3]); ?>'; dbcl = parseInt(<?php echo rtrim($dbtype[5]); ?>); err = <?php echo count(file('../../php/index.php'))-2; ?>; QDBCountDown = 60; QDB_Count_Down = false;
        function simporta(x) {
	    	if(x == 0) $('#simp').attr('src','images/' + lng + '/is_off.bmp'); 
            if(x == 1) $('#simp').attr('src','images/' + lng + '/is_on.bmp');
            if(x == 2) { $lb.launch({ url: 'importa.php?id=<?php echo rawurlencode($_GET['id']); ?>', options: 'afterEnd:refresh width:480 navTop:true titleTop:true', title: "<h1 align='center'><?php echo $lng[3]; ?></h1>"})};
        }
        function sesporta(x) {
	    	if(x == 0) $('#sexp').attr('src','images/' + lng + '/es_off.bmp'); 
            if(x == 1) $('#sexp').attr('src','images/' + lng + '/es_on.bmp');
            if(x == 2) $.post("keyline.php", { id: 'e', pos: 's', key: 'p', sid: '<?php echo rawurlencode($_GET['id']); ?>' }, function(msg){
                if(msg) $.msgBox({ type: 'info', title: 'QuanticoDB', content: '<?php echo $lng[4]; ?> <a target="_blank" href="' + msg + '"><?php echo $lng[5]; ?></a>'}); else errore(10); 
            });
        }
        function cambia(x) { i = "<?php echo rawurlencode($_GET['id']); ?>";
            if(x == 3) { $lb.launch({ url: "email.php?id=" + i, options: "afterEnd:login width:480 height:700 navTop:true titleTop:true", title: "<h2 align='center'><?php echo $lng[6]; ?></h2>" });}
            if(x == 2) { $lb.launch({ url: "password.php?id=" + i, options: "afterEnd:login width:480 height:700 navTop:true titleTop:true", title: "<h2 align='center'><?php echo $lng[7]; ?></h2>" });}
            if(x == 1) { $.msgBox({ title: "QuanticoDB", 
                content: "<?php echo $lng[8]; ?>", 
                buttons: [{ value: "<?php echo $lng[9]; ?>" }, { value: "<?php echo $lng[10]; ?>" }], 
                success: function (result) { if (result == "<?php echo $lng[9]; ?>") { $.post("keyline.php", { id: 'c', pos: 'a', key: 'm' }, function(msg){
                    if(msg) { $.msgBox({ type: 'info', title: 'QuanticoDB', content: '<?php echo $lng[11]; ?>' }); menuhide();
                } else errore(10); });}}
            });}
        }
        function guarda(x,y='') { u = x.split('#'); s2 = ''; i = "<?php echo base64_encode($_GET['id']); ?>";
            if(u[1] != '0.0') { if(u[1].indexOf('.0') > 0) { l = u[1].length - 2; u[1] = u[1].substring(0,l); c = '#0154A0'; } else if(u[1].indexOf('.1') > 0) { l = u[1].length - 2; u[1] = u[1].substring(0,l); c = '#404042'; } else if(u[1].indexOf('.2') > 0) { l = u[1].length - 2; u[1] = u[1].substring(0,l); c = '#808082'; } else c = '#AFBED3';
            s2 = "<font color='#FFF' style='background-color: " + c + "'>&nbsp;" + u[1] + "&nbsp;</font>"; } x = x.replace('#','@'); $lb.launch({ url: "view.php?k=" + x + "@0-0-0:0-0-0@0@0" + y + "&i=" + i, options: "afterEnd:aggiorna width:820 navTop:true titleTop:true", title: "<h2 align='center'><font size='5'>&nbsp;&nbsp;&nbsp;&nbsp;" + u[0] + "&nbsp;&nbsp;</font>" + s2 + "</h2>"});
	    }
        function ai(x) { if(x == 'Account') i = "?id=<?php echo rawurlencode($_GET['id']); ?>"; else i = '';
            $lb.launch({ url: "ai.php" + i, options: "width:480 height:700 navTop:true titleTop:true", title: "<h2 align='center'>A.I.&nbsp; " + x + "</h2>" });
        }
        function pls() { $('#rst').html(''); }
        function login() { location.href = 'login.php'; }
        function refresh() { location.href = $(location).attr('href'); }
        function rimuovi() { for(var a=1; a<=nkey; a++) $("#tab" + a).remove(); }
        function pulisci(x) { for(var a=1; a<x; a++) { for(var b=1; b<=fi[a]; b++) { $("#kc" + a + "-" + b).remove(); }}}
        function aggiorna(json=false) {	$('#gio').text(''); pulisci(dbcl+1); key_combinate(dbcl,3); if(json) key_base(mk,json); }
        function language() { $.post("keybase.php", { type: 4 }, function(msg){ if(msg == 'OK') refresh(); else errore(msg); }); }
        function rawurlencode(x) { return encodeURIComponent((x + '').replace(/%(?![\da-f]{2})/gi, function() { return '%25'; })); }
        function animazione() { $.post("keybase.php", { type: 17 }, function(msg){ if(msg == 'OK') refresh(); else errore(msg); }); }
        function menuhide() { $("#qmenu").remove(); $("#qtrash").remove(); $("#qcest").remove(); $("#qimex").remove(); $("#qsvrp").remove(); }
        function tabella() { sito = 'tabella.php'; $lb.launch({ url: sito, options: "navTop:true titleTop:true", title: "<h2 align='center'><?php echo $lng[12]; ?></h2>" })}
        function defmax() { def = parseInt($('#def').val()); max = parseInt($('#max').val()); if(def < 10) errore(25); else { if(def > 1000) errore(26); else { if(max < 10) errore(27); else { if(max > 10000) errore(28); else { if(def > max) errore(29); else { $.post("keyline.php", { id: 'x', pos: def, key: max }, function(msg){ if(msg == '20') errore(20,1); else errore(msg); }); }}}}}}
        function elc(x,y) { if(y == 0) $("#px" + x).hide(); else if(y == 1) $("#px" + x).show(); else if(y == 2) { $.post("keyline.php", { id: 'u', pos: 'n', key: x }, function(msg){ if(msg > 0) errore(msg); else { $('#rst').load('temp/reverse.php'); $('#gio').html('<a class="agg" href="javascript:aggiorna()"><?php echo $lng[13]; ?></a>'); errore(20,1); }});}}
        function ora() { var o = $("#utc").val(); o = o.substring(3); $.post("keyline.php", { id: 'l', pos: o, key: 'c' }, function(msg){ var sl = msg.split('#'); $("#oral").text(sl[0]); $('select').val(sl[1]);}); }
        function xrshow(x,y) { if(y == 0) { $("#x" + x).hide(); $("#r" + x).hide(); $("#k" + x).hide(); } else if(y == 1 && ok == 0) { $("#x" + x).show(); $("#r" + x).show(); $("#k" + x).show(); }}
        function xrhide(x) { for(var a=1; a<x; a++) { $("#x" + a).hide(); $("#r" + a).hide(); $("#k" + a).hide(); }}
        function logout() { $.post("keyline.php", { id: 'o', pos: 'u', key: 't' }, function(msg){ if(msg == 1) login(); else errore(10); }); }
        function insu(x,y) { $.post("keyline.php", { id: 'u', pos: x, key: y, sid: sid }, function(msg){ if(msg == 1) aggiorna(); else errore(10); }); }
        function ingiu(x,y) { $.post("keyline.php", { id: 'g', pos: x, key: y, sid: sid }, function(msg){ if(msg == 1) aggiorna(); else errore(10); }); }
        function espandi(x,y) { $.post("keyline.php", { id: 'p', pos: x, key: y, sid: sid }, function(msg){ if(msg == 1) aggiorna(); else errore(10); }); }
        function comprimi(x,y) { $.post("keyline.php", { id: 'o', pos: x, key: y, sid: sid }, function(msg){ if(msg == 1) aggiorna(); else errore(10); }); }        
        function controllo() { if(dbcl == 4) { $('#imgcl').attr({'src':'images/Qkb4.jpg','title':'<?php echo $lng[14]; ?>'}); $('#kc5').hide(); $('#kc6').hide(); $('#kc7').hide(); $('#tdpls').width('210px'); } else $('#imgcl').attr({'src':'images/Qkb7.jpg','title':'<?php echo $lng[15]; ?>'}); }
        function search(x,y) { if(y == 0) { $('#sc' + x).hide(); $('#si' + x).hide(); } else if(y == 1) { $('#sc' + x).show(); $('#si' + x).show(); } else if(y == 2) $('#sc' + x).attr('src','images/search_on.bmp'); else if(y == 3) $('#sc' + x).attr('src','images/search_off.bmp'); else if(y == 4) { var v = $("#nm" + x).text(); var s = $('#si' + x).val(); guarda(v + '#0.0','@' + rawurlencode(s)); }}
        function dbmancd() { if(QDBCountDown > 0) { QDBCountDown = QDBCountDown - 1; $.msgBox({ title: "QuanticoDB", content: "<?php echo $lng[38]; ?>" + QDBCountDown + "s</b>", buttons: [{ value: "<?php echo $lng[84]; ?>" }], success: function (result) { if(result == "<?php echo $lng[84]; ?>") { refresh(); }}});} else { clearTimeout(QDB_Count_Down); $.post("keyline.php", { id: 'm', pos: 'n', key: 1 }, function(msg){ if(msg) refresh(); else errore(10); });} QDB_Count_Down = setTimeout('dbmancd()', 1000); }
        function colonne() { comandi(dbcl); if(dbcl == 7) { dbcl = 4; $('#kc5').hide(); $('#kc6').hide(); $('#kc7').hide(); $('#imgcl').attr({'src':'images/Qkb4.jpg','title':'<?php echo $lng[14]; ?>'}); $('#tdpls').width('210px'); if(fi[5] || fi[6] || fi[7]) $.msgBox({ type: "info", title: "QuanticoDB", content: "<?php echo $lng[16]; ?>" }); } else { dbcl = 7; $('#kc5').show(); $('#kc6').show(); $('#kc7').show(); $('#imgcl').attr({'src':'images/Qkb7.jpg','title':'<?php echo $lng[15]; ?>'}); $('#tdpls').width('410px'); }}
        function menu() { $.post("keyline.php", { id: 's', pos: 'e', key: 'r' }, function(msg){ var m = '<table id="qmenu" border="0" width="240" cellspacing="0" cellpadding="0" bgcolor="#F00" height="80"><tr><td align="center" height="14" width="240" colspan="2"><div id="ardb"></div></td></tr><tr><td align="right" height="30" width="152" valign="bottom"><a align="center" class="tooltip-bottom" data-tooltip="<?php echo $lng[17]; ?>" href="javascript:language()"><img border="0" src="images/' + lng + '/language.bmp" width="15" height="12"></a>&nbsp;<font color="#FFF" face="Arial"><?php echo $lng[18]; ?></font></td><td align="left" height="30" width="88" valign="bottom"><font color="#FFF" face="Arial"><b><span id="oral"></span></b></font></td></tr><tr><td align="center" colspan="2" valign="top"><table border="0" width="240" cellspacing="0" cellpadding="0" height="70"><tr><td width="137" align="right" height="30" colspan="2"><select size="1" id="utc"><option>UTC-12</option><option>UTC-11:30</option><option>UTC-11</option><option>UTC-10:30</option><option>UTC-10</option><option>UTC-9:30</option><option>UTC-9</option><option>UTC-8:30</option><option>UTC-8</option><option>UTC-7:30</option><option>UTC-7</option><option>UTC-6:30</option><option>UTC-6</option>';
            m += '<option>UTC-5:30</option><option>UTC-5</option><option>UTC-4:30</option><option>UTC-4</option><option>UTC-3:30</option><option>UTC-3</option><option>UTC-2:30</option><option>UTC-2</option><option>UTC-1:30</option><option>UTC-1</option><option>UTC-0:30</option><option>UTC+0</option><option>UTC+0:30</option><option>UTC+1</option><option>UTC+1:30</option><option>UTC+2</option><option>UTC+2:30</option><option>UTC+3</option><option>UTC+3:30</option><option>UTC+4</option><option>UTC+4:30</option><option>UTC+5</option><option>UTC+5:30</option><option>UTC+5:45</option><option>UTC+6</option><option>UTC+6:30</option><option>UTC+7</option><option>UTC+7:30</option><option>UTC+8</option><option>UTC+8:30</option><option>UTC+8:45</option><option>UTC+9</option><option>UTC+9:30</option><option>UTC+10</option><option>UTC+10:30</option><option>UTC+11</option>';
            m += '<option>UTC+11:30</option><option>UTC+12</option><option>UTC+12:45</option><option>UTC+13</option><option>UTC+13:45</option><option>UTC+14</option></select></td><td width="103" align="left" height="30"><a href="javascript:ora()"><input id="slv1" type="button" value="<?php echo $lng[19]; ?>"></a></td></tr><tr><td width="97" align="right" height="20"><img src="images/default.bmp"></td><td width="40" align="right" height="20"><input class="ydm" id="def" type="text" value="10" title="<?php echo $lng[20]; ?>"></td><td width="103" align="left" height="20"><a href="javascript:defmax()"><input id="slv2" type="button" value="<?php echo $lng[19]; ?>"></a></td></tr><tr><td width="97" align="right" height="20"><img src="images/max.bmp"></td><td width="40" align="right" height="20"><input class="ydm" id="max" type="text" value="100" title="<?php echo $lng[21]; ?>"></td><td width="103" align="left" height="20"><a href="javascript:defmax()"><input id="slv3" type="button" value="<?php echo $lng[19]; ?>"></a></td></tr></table></td></tr></table>';
            m += '<table id="qsvrp" border="0" width="240" cellspacing="0" cellpadding="0" height="53" bgcolor="#F00"><tr><td align="center" valign="bottom" height="20"><img border="0" src="images/cestline.bmp" width="170" height="1" vspace="4"></td></tr><tr><td align="center" valign="bottom" height="24"><a href="javascript:simporta(2)"><img id="simp" border="0" src="images/' + lng + '/is_off.bmp" onmouseover="javascript:simporta(1)" onmouseout="javascript:simporta(0)"></a></td></tr><tr><td align="center" valign="top" height="24"><a href="javascript:sesporta(2)"><img id="sexp" border="0" src="images/' + lng + '/es_off.bmp" onmouseover="javascript:sesporta(1)" onmouseout="javascript:sesporta(0)"></a></td></tr></table><table id="qtrash" border="0" width="240" cellspacing="0" cellpadding="0" bgcolor="#F00" height="80"><tr><td align="center" valign="top" height="20" colspan="2"><img border="0" src="images/cestline.bmp" width="170" height="1"></td></tr><tr><td width="75" align="right" valign="top" height="50" rowspan="2"><img border="0" src="images/ai.png" hspace="9"></td><td valign="bottom" height="22" align="left"><a class="tooltip-right" data-tooltip="<?php echo $lng[22]; ?>" href="javascript:ai(\'Service\')"><font face="Arial" color="#FFF" style="font-size: 11pt"><b>A.I. </b></font></a><font face="Arial" color="#FFF" size="2">Service</font></td></tr><tr><td valign="top" height="28" align="left"><a class="tooltip-right" data-tooltip="<?php echo $lng[23]; ?>" href="javascript:ai(\'Account\')"><font face="Arial" color="#FFF" style="font-size: 11pt"><b>A.I. </b></font></a><font face="Arial" color="#FFF" size="2">Account</font></td></tr>';
            if(dbty == 'live') m += '<tr><td align="right" valign="top" height="45" width="75" rowspan="2"><img src="images/email.jpg" hspace="10"></td><td valign="top" height="12"><a class="tooltip-right" data-tooltip="<?php echo $lng[24]; ?>" href="javascript:aggiornami()"><img id="agg" border="0" src="images/' + lng + '/aggiornami_no.bmp"></a></td></tr><tr><td valign="top" height="33"><a class="tooltip-right" data-tooltip="<?php echo $lng[25]; ?>" href="javascript:cambia(3)"><font face="Arial" color="#FFF" style="font-size: 11pt"><b><?php echo $lng[26]; ?> </b></font></a><font face="Arial" color="#FFF" size="2">Email</font></td></tr><tr><td width="75" align="right" valign="top" height="50" rowspan="2"><img border="0" src="images/aggiorna.jpg" width="41" height="39" hspace="8"></td><td valign="bottom" height="22" align="left"><a class="tooltip-right" data-tooltip="<?php echo $lng[27]; ?>" href="javascript:cambia(1)"><font face="Arial" color="#FFF" style="font-size: 11pt"><b><?php echo $lng[26]; ?> </b></font></a><font face="Arial" color="#FFF" style="font-size: 10pt">Database</font></td></tr><tr><td valign="top" height="28" align="left"><a class="tooltip-right" data-tooltip="<?php echo $lng[28]; ?>" href="javascript:cambia(2)"><font face="Arial" color="#FFF" style="font-size: 11pt"><b><?php echo $lng[26]; ?> </b></font></a><font face="Arial" color="#FFF" size="2">Password</font></td></tr>';
            m += '<tr><td rowspan="2" width="75" align="right" valign="top" height="60"><img border="0" src="images/cestino.png" width="48" height="48" hspace="5"></td><td valign="bottom" height="30"><a href="javascript:salva(0,3)"><font face="Arial" color="#FFF" style="font-size: 11pt"><b><?php echo $lng[29]; ?></b></font></a><font face="Arial" color="#FFF" size="2"> KEY Base</font></td></tr><tr><td height="30" valign="top"><a href="javascript:salva(0,4)"><font face="Arial" color="#FFF" style="font-size: 11pt"><?php echo $lng[30]; ?></td></tr></table><div id="qcest">'; if($("#qmenu").length) menuhide(); else $("#qdb").prepend(m); var json = JSON.parse(msg); $("#oral").text(json.ora); $('select').val(json.utc); $("#def").val(json.def); $("#max").val(json.max);
            if(dbty == 'live') {
                if(json.agg == 1) $('#agg').attr('src','images/' + lng + '/aggiornami_si.bmp'); else $('#agg').attr('src','images/' + lng + '/aggiornami_no.bmp');
                if(json.autorip == 1) $('#ardb').append('<a class="tooltip-right" data-tooltip="<?php echo $lng[31]; ?>" href="javascript:sicurezza(2)"><img border="0" src="images/' + lng + '/auto_ripristino_database.jpg"></a>'); 
                if(json.man == 'false') $('#ardb').append('<div class="ft3"><a class="tooltip-bottom" data-tooltip="<?php echo $lng[32]; ?>" href="javascript:dbman(1)"><img src="images/dbman.png" style="margin:4px"></a><a class="tooltip-bottom" data-tooltip="<?php echo $lng[33]; ?>" href="javascript:dbman(3)"><img src="images/dbtest.png" style="margin:4px; padding:0 5px 0 9px"></a><a class="tooltip-bottom" data-tooltip="<?php echo $lng[34]; ?>" href="javascript:dbman(4)"><img src="images/dbclone.png" style="margin:4px"></a></div>');
            } else { if(dbty == 'test') var col = 'greenyellow'; else if(dbty == 'clone') var col = 'lavender'; $('#ardb').css({'width':'240px','height':'14px','background-color':col}); $('#utc').attr("disabled", "disabled"); $('#def').attr("disabled", "disabled"); $('#max').attr("disabled", "disabled"); $('#slv1').attr("disabled", "disabled"); $('#slv2').attr("disabled", "disabled"); $('#slv3').attr("disabled", "disabled"); }});
        }
        function dbman(x) {
            if(x == 0) { $.msgBox({ title: "QuanticoDB", content: "<?php echo $lng[35]; ?>", buttons: [{ value: "<?php echo $lng[9]; ?>" }, { value: "<?php echo $lng[10]; ?>" }], success: function (result) { if(result == "<?php echo $lng[9]; ?>") { $.post("keyline.php", { id: 'm', pos: 'n', key: x }, function(msg){ $.msgBox({ type: 'info', title: 'QuanticoDB', content: '<b><?php echo $lng[36]; ?></b>' }); menuhide(); dbmn = msg; $('#dbstat').remove(); });}}});}
            else if(x == 1) { $.msgBox({ title: "QuanticoDB", content: "<?php echo $lng[37]; ?>", buttons: [{ value: "<?php echo $lng[9]; ?>" }, { value: "<?php echo $lng[10]; ?>" }], success: function (result) { if(result == "<?php echo $lng[9]; ?>") { dbmancd(); }}});}
            else if(x == 2) { $.msgBox({ title: "QuanticoDB", content: "<?php echo $lng[39]; ?>", buttons: [{ value: "<?php echo $lng[9]; ?>" }, { value: "<?php echo $lng[10]; ?>" }], success: function (result) { if(result == "<?php echo $lng[9]; ?>") { $.post("keyline.php", { id: 'm', pos: 'n', key: x }, function(){ refresh(); });}}});}
            else if(x == 3) { $.msgBox({ title: "QuanticoDB", content: "<?php echo $lng[40]; ?>", buttons: [{ value: "<?php echo $lng[9]; ?>" }, { value: "<?php echo $lng[10]; ?>" }], success: function (result) { if(result == "<?php echo $lng[9]; ?>") { $.post("keyline.php", { id: 'm', pos: 'n', key: x }, function(msg){ if(msg) refresh(); else errore(10); });}}});}
            else if(x == 4) { $lb.launch({ url: "clone.php?type=1", options: "afterEnd:refresh width:480 navTop:true titleTop:true", title: "<h2 align='center'><?php echo $lng[41]; ?></h2>" });}
            if($("#dbstat").length == 0) {
                if(dbmn) $("#qdb").prepend('<div id="dbstat" class="ft3" style="padding-top:8px"><?php echo $lng[42]; ?> <b>' + dbmn + '</b><a class="tooltip-right" data-tooltip="<?php echo $lng[43]; ?>" href="javascript:dbman(0)"><b style="font-size:17px">&nbsp; X</b></a></div>');
                else if(dbty == 'test') $("#qdb").prepend('<div id="dbstat" class="ft4" style="padding-top:8px"><?php echo $lng[44]; ?><a class="tooltip-right" data-tooltip="<?php echo $lng[45]; ?>" href="javascript:dbman(2)"><b style="font-size:17px">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; X</b></a></div>');
                else if(dbty == 'clone') $("#qdb").prepend('<div id="dbstat" class="ft5" style="padding-top:8px"><?php echo $lng[46]; ?><a class="tooltip-right" data-tooltip="<?php echo $lng[45]; ?>" href="javascript:dbman(2)"><b style="font-size:17px">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; X</b></a></div>');
            }
        }
        function comandi(x=false) { $.post("keybase.php", { type: 14, val: x }, function(msg){ var json = JSON.parse(msg); // JSON ---> Costruzione dei 20 input di comando
            if(dbcl == 7) { var y = 880; var z = 500; var w = 850; var c = 'cm7'; } else { var y = 480; var z = 100; var w = 450; var c = 'cmd'; } var str = '<table border="0" width="100%" cellspacing="0" cellpadding="0"><tr><td height="60" valign="bottom" width="'+y+'" colspan="2"><h6><i> <?php echo rtrim($lng[47]); ?></i><a href="javascript:cerca(1)" style="margin-left:'+z+'px">QUERY</a>&emsp; <a href="javascript:cerca(0)"><?php echo rtrim($lng[48]); ?></a></h6></td><td rowspan="11">&nbsp;</td></tr>'; var b = 0; for(var a=0; a<json.command.length; a++) { b = a + 2; str += '<tr><td width="'+w+'" onmouseover="javascript:elc('+b+',1)" onmouseout="javascript:elc('+b+',0)"><form action="javascript:carica('+b+')"><input class="'+c+'" id="cmd'+b+'" type="text" value="'+json.command[a]+'" title="<?php echo rtrim($lng[49]); ?>"></form></td><td width="30" align="center" valign="top" onmouseover="javascript:elc('+b+',1)" onmouseout="javascript:elc('+b+',0)"><a href="javascript:elc('+b+',2)"><img id="px'+b+'" src="images/undo.bmp" title="<?php echo rtrim($lng[50]); ?>" style="display: none" vspace="6"></a></td></tr>'; } $('#comandi').html(str+'</table>'); $('#creato').html('<font face="Verdana" size="1"><?php echo rtrim($lng[51]); ?>: <b>'+json['create']+'</b> &nbsp; <a href="javascript:logout()">LOGOUT</a><p><?php echo rtrim($lng[124]); ?>: <a href="javascript:animazione()"><?php if($dbtype[6] == "1\n") echo rtrim($lng[9]); else echo rtrim($lng[10]); ?></a></p></font>'); });
        }
        function key_combinate(x,y) {
        	if(y == 0) { $("#k" + x).attr("src","images/k_off.bmp"); }
        	if(y == 1) { $("#k" + x).attr("src","images/k_on.bmp"); }
        	if(y == 2) { val = $("#keyb" + x).text(); $.post("keycomb.php", { par: 0, arr: 1, pos: 8, key: val, sid: sid }, function(msg){ if(msg == 1) { aggiorna(); } else { errore(msg); }}); }
        	if(y == 3) { $.post("keycomb.php", { par: 0, arr: 0, pos: 8, key: 8, sid: sid }, function(msg){ body(msg); });}
        }
        function cancella(x,y) {
        	if(y == 0) { $("#x" + x).attr("src","images/x_off.bmp"); }
        	if(y == 1) { $("#x" + x).attr("src","images/x_on.bmp"); }
        	if(y == 2) { $.msgBox({ type: "error", title: "QuanticoDB", content: "<?php echo $lng[52]; ?>", buttons: [{ value: "<?php echo $lng[9]; ?>" }, { value: "<?php echo $lng[10]; ?>" }], success: function (result) { if (result == "<?php echo $lng[9]; ?>") { val = $("#keyb" + x).text(); $.post("keybase.php", { type: 3, val: val, old: dbcl+1, pos: mk, sid:sid }, function(msg){ if(msg.length > 2) { rimuovi(); aggiorna(msg); } else { errore(5); }});}}});}
        	if(y == 3) { $("#tab" + x).remove(); $("#qdb").append('<table id="tab' + x + '" border="0" width="100%" cellspacing="0" cellpadding="0" height="60"><tr><td width="41"></td><td align="left" valign="bottom" width="199"><a href="javascript:nuova_key_base(' + x + ',2)"><img id="nkb" border="0" src="images/' + lng + '/nuova_key_base_off.jpg" onmouseover="javascript:nuova_key_base(' + x + ',1)" onmouseout="javascript:nuova_key_base(' + x + ',0)"></a></td></tr></table>'); }
        }
        function dbripristina(x) {
        	if(x == 0) $("#dbr").attr("src","images/rd_off.bmp"); else if(x == 1) $("#dbr").attr("src","images/rd_on.bmp"); else if(x == 2) { $lb.launch({ url: "ripristina.php", options: "afterEnd:aggiorna width:480 navTop:true titleTop:true", title: "<h2 align='center'><?php echo $lng[53]; ?></h2>" })}
         }
        function dbsalva(x) {
        	if(x == 0) $("#dbs").attr("src","images/sd_off.bmp"); 
            else if(x == 1) $("#dbs").attr("src","images/sd_on.bmp");
            else if(x == 2) { $.msgBox({ title: "QuanticoDB", content: "<?php echo $lng[54]; ?>", buttons: [{ value: "<?php echo $lng[9]; ?>" }, { value: "<?php echo $lng[10]; ?>" }], success: function (result) { if(result == "<?php echo $lng[9]; ?>") { $.post("keyline.php", { id: 's', pos: 'd', key: 'b' }, function(msg){ if(msg) $.msgBox({ type: 'info', title: 'QuanticoDB', content: '<?php echo $lng[55]; ?> <a target="_blank" href="' + msg + '"><?php echo $lng[5]; ?></a>' }); else errore(10); });}}});}
        }
        function sicurezza(x) {
            if(x == 0) $("#alr").attr("src","images/alert_off.jpg"); 
            else if(x == 1) $("#alr").attr("src","images/alert_on.jpg");
            else if(x == 2) { $lb.launch({ url: 'security.php', options: "afterEnd:aggiorna width:480 navTop:true titleTop:true", title: "<h2 align='center'><?php echo $lng[56]; ?></h2>" });}
            else { $.post("keyline.php", { id: 's', pos: 'i', key: 'c' }, function(msg){
                if(msg == 1) { $.msgBox({ title: "QuanticoDB", content: "<?php echo $lng[57]; ?>", buttons: [{ value: "<?php echo $lng[9]; ?>" }, { value: "<?php echo $lng[10]; ?>" }], success: function (result) { if(result == "<?php echo $lng[9]; ?>") { $lb.launch({ url: 'security', options: "afterEnd:aggiorna width:480 navTop:true titleTop:true", title: "<h2 align='center'><?php echo $lng[56]; ?></h2>" });}}});}
                else if(msg == 2) { $.msgBox({ title: "QuanticoDB", type: "error", content: "<?php echo $lng[58]; ?>", success: function (result) { login(); }});}
                else if(msg == 3) { $.msgBox({ title: "QuanticoDB", type: "error", content: "<?php echo $lng[59]; ?>", success: function (result) { login(); }});}
                else if(msg == 4) { $.msgBox({ title: "QuanticoDB", type: "error", content: "<?php echo $lng[60]; ?>", success: function (result) { login(); }});}
                else if(msg == 5) $("#sic").html('<img src="images/Qdb0.jpg">');
            });}
        }
        function carica(x) { vl = $('#cmd' + x).val(); com = vl.substring(6,9); vl = vl.replace(/'/g,'#####1'); vl = vl.replace(/"/g,'#####2'); $('#gio').html('<img src="images/load.gif" style="float:right; margin-bottom:6px">');
            $.post("keybase.php", { type: 11, val: vl, old: 1, pos: x }, function(msg){ if(msg == 'OK') { $('#rst').load('temp/risultato.php').show(); if(com == 'in(' || com == 'del' || com == 'ver') $('#gio').html('<a class="agg" href="javascript:aggiorna()"><?php echo $lng[13]; ?></a>'); else if(com == 'out') $('#gio').html('&nbsp;&nbsp;&nbsp; <a class="agg" href="javascript:tabella()"><?php echo $lng[12]; ?></a>'); else if(com == 'tim' || com == 'dir') $('#gio').html(''); }});
        }
        function cerca(x) { if(x) { sito = 'query.php?id='+dbcl; titolo = 'QUERY'; } else { sito = 'cerca.php?id='+dbcl; titolo = '<?php echo $lng[48]; ?>'; }
            $lb.launch({ url: sito, options: "afterEnd:aggiorna width:820 navTop:true titleTop:true", title: "<h3 align='center'>" + titolo + "</h3>" })
        }
        function key_base(x,json = false) { // JSON ---> JSON ---> Costruzione del menu ( KEY Base - 7 parti )
            if(json) { kbase = JSON.parse(json); nkey = kbase[x-1].length + 1; menukb(x); } else { $.post("keybase.php", { type: 1, val: x, old: old, pos: 0 }, function(msg){ key_base(x,msg); });}
        }
        function menukb(x) { $("#mkb" + mk).attr("src","images/" + mk + "off.jpg"); $("#mkb" + x).attr("src","images/" + x + "on.jpg"); rimuovi(); var msg = ''; var b = 0;
            if(kbase) { for(var a=0; a<kbase[x-1].length; a++) { b = a + 1;
                msg += '<table id="tab'+b+'" border="0" width="100%" cellspacing="0" cellpadding="0" height="35"><tr><td align="right" width="35" onmouseover="javascript:sposta(\'km'+b+'\',1)" onmouseout="javascript:sposta(\'km'+b+'\',0)"><table border="0" width="17" cellspacing="0" cellpadding="0" height="23"><tr><td align="center" height="8" colspan="3"><a href="javascript:sposta(\'mu'+b+'\',2)"><img id="mu'+b+'" class="im0" src="images/mu_off.bmp" onmouseover="javascript:sposta(\'mu'+b+'\',1)" onmouseout="javascript:sposta(\'mu'+b+'\',0)" title="<?php echo $lng[61]; ?>"></a></td></tr><tr><td height="7" width="8"><a href="javascript:sposta(\'ml'+b+'\',2)"><img id="ml'+b+'" class="im0" src="images/ml_off.bmp" onmouseover="javascript:sposta(\'ml'+b+'\',1)" onmouseout="javascript:sposta(\'ml'+b+'\',0)" title="<?php echo $lng[62]; ?>"></a></td><td height="7" width="1"><img border="0" src="images/mx.bmp"></td><td height="7" width="8"><a href="javascript:sposta(\'mr'+b+'\',2)"><img id="mr'+b+'" class="im0" src="images/mr_off.bmp" onmouseover="javascript:sposta(\'mr'+b+'\',1)" onmouseout="javascript:sposta(\'mr'+b+'\',0)" title="<?php echo $lng[63]; ?>"></a></td></tr>';
                msg += '<tr><td align="center" height="8" colspan="3"><a href="javascript:sposta(\'md'+b+'\',2)"><img id="md'+b+'" class="im0" src="images/md_off.bmp" onmouseover="javascript:sposta(\'md'+b+'\',1)" onmouseout="javascript:sposta(\'md'+b+'\',0)" title="<?php echo $lng[64]; ?>"></a></td></tr></table></td><td align="center" width="34"><h2>'+b+'.</h2></td><td width="156" onmouseover="javascript:xrshow('+b+',1)" onmouseout="javascript:xrshow('+b+',0)"><span id="keyb'+b+'"><h1>'+kbase[x-1][a]+'</h1></span></td><td width="15" onmouseover="javascript:xrshow('+b+',1)" onmouseout="javascript:xrshow('+b+',0)"><a href="javascript:cancella('+b+',2)"><img id="x'+b+'" src="images/x_off.bmp" border="0" style="display: none" onmouseover="javascript:cancella('+b+',1)" onmouseout="javascript:cancella('+b+',0)" title="<?php echo $lng[65]; ?>"></a><a href="javascript:rinomina('+b+',2)"><img id="r'+b+'" src="images/r_off.bmp" border="0" vspace="2" style="display: none" onmouseover="javascript:rinomina('+b+',1)" onmouseout="javascript:rinomina('+b+',0)" title="<?php echo $lng[66]; ?>"></a><a href="javascript:key_combinate('+b+',2)"><img id="k'+b+'" src="images/k_off.bmp" border="0" style="display: none" onmouseover="javascript:key_combinate('+b+',1)" onmouseout="javascript:key_combinate('+b+',0)" title="<?php echo $lng[67]; ?>"></a></td></tr></table>';
            }} b++; msg += '<table id="tab'+b+'" border="0" width="100%" cellspacing="0" cellpadding="0" height="60"><tr><td width="41"></td><td align="left" valign="bottom" width="199"><a href="javascript:nuova_key_base('+b+',2)"><img id="nkb" border="0" src="images/'+ lng + '/nuova_key_base_off.jpg" onmouseover="javascript:nuova_key_base('+b+',1)" onmouseout="javascript:nuova_key_base('+b+',0)"></a></td></tr></table>'; $("#qdb").append(msg); nkey = kbase[x-1].length + 1; mk = x;
        }
        function rinomina(x,y) {
        	if(y == 0) { $("#r" + x).attr("src","images/r_off.bmp"); }
        	else if(y == 1) { $("#r" + x).attr("src","images/r_on.bmp"); }
        	else if(y == 2) { var msg = ''; var b = 0; for(var a=0; a<kbase[mk-1].length; a++) { b = a + 1; if(a == (x-1)) { msg += '<table id="tab'+b+'" border="0" width="100%" cellspacing="0" cellpadding="0" height="35"><tr><td align="center" width="69"><h2>&nbsp;&nbsp;&nbsp;'+b+'.</h2></td><td width="156"><input class="ytc" id="kbt" type="text" value="'+kbase[mk-1][x-1]+'"></td><td width="15"><a href="javascript:menukb('+mk+')"><img id="x'+b+'" src="images/x_off.bmp" border="0" hspace="1" vspace="2" onmouseover="javascript:cancella('+b+',1)" onmouseout="javascript:cancella('+b+',0)" title="<?php echo $lng[68]; ?>"></a><a href="javascript:rinomina('+b+',3)"><img id="s'+b+'" src="images/s_on.bmp" border="0" vspace="2" onmouseover="javascript:salva('+b+',1)" onmouseout="javascript:salva('+b+',0)" title="<?php echo $lng[69]; ?>"></a></td></tr></table>'; } else { msg += '<table id="tab'+b+'" border="0" width="100%" cellspacing="0" cellpadding="0" height="35"><tr><td align="center" width="69"><h2>&nbsp;&nbsp;&nbsp;'+b+'.</h2></td><td width="156"><span id="keyb'+b+'"><h1>'+kbase[mk-1][a]+'</h1></span></td><td width="15"></td></tr></table>'; }} rimuovi(); $("#qdb").append(msg); }
        	else if(y == 3) { var val = $("#kbt").val(); old = kbase[mk-1][x-1]; $.post("keybase.php", { type: 5, val: val, old: old, pos: mk }, function(msg){ if(msg.length > 2) { aggiorna(msg); } else { errore(msg); }});}
        }
        function salva(x,y) {
        	if(y == 0) { $("#s" + x).attr("src","images/s_on.bmp"); }
        	else if(y == 1) { $("#s" + x).attr("src","images/s_off.bmp"); }
        	else if(y == 2) { var val = $("#kbt").val(); $.post("keybase.php", { type: 2, val: val, old: mk, pos: 0}, function(msg){ if(msg.length > 2) key_base(mk,msg); else errore(msg); });}
            else if(y == 3) { $.post("keybase.php", { type: 7, val: 7, old: 7, pos: 0 }, function(msg){ if(msg) $("#qcest").html(msg); else errore(10); }); }
            else if(y == 4) { $.msgBox({ type: "error", title: "QuanticoDB", content: "<?php echo $lng[70]; ?>", buttons: [{ value: "<?php echo $lng[9]; ?>" }, { value: "<?php echo $lng[10]; ?>" }], success: function (result) { if(result == "<?php echo $lng[9]; ?>") { $.post("keybase.php", { type: 6, val: 6, old: 6, pos: 0 }, function(msg){ if(msg == 1) { $("#qmenu").remove(); $("#qtrash").remove(); $("#qcest").remove(); $("#qimex").remove(); $("#qsvrp").remove(); } else { errore(10); }})}}});}
            else if(y == 5) { var val = $("#ce" + x).text(); $.post("keybase.php", { type: 8, val: val, old: x, pos: 0 }, function(msg){ if(msg.length > 2) { aggiorna(msg); menuhide(); } else errore(msg); });}
            else if(y == 6) { $("#qcest").html(''); }
        }
        function modifica(x,y) { z = x.substring(0,2); w = x.substring(2); u = w.split('-');
        	if(z == "ri") {
        		if(y == 0) { $("#rp" + w).hide(); $("#rx" + w).hide(); $("#ru" + w).hide(); $("#fu" + w).hide(); $("#fd" + w).hide(); $("#ce" + w).hide(); }
        		else if(y == 1 && ok == 0) { $("#rp" + w).show(); $("#rx" + w).show(); $("#ru" + w).show(); $("#fu" + w).show(); $("#fd" + w).show(); $("#ce" + w).show(); }
        	} else {
            	if(y == 0) { $("#" + x).attr("src","images/" + z + "_off.bmp"); }
            	else if(y == 1) { $("#" + x).attr("src","images/" + z + "_on.bmp"); }
            	else if(y == 2) { v = $("#nm" + w).text(); v = $.trim(v);
            		if(z == "rp") { $.post("keyline.php", { id: 1, pos: u[0], key: v, sid: sid }, function(msg){ $("#nm" + w).append(msg); ok = 1; });}
            		else if(z == "ru") { $.post("keyline.php", { id: 3, pos: u[0], key: v, sid: sid }, function(msg){ if(msg == 1) { aggiorna(); } else { errore(msg); }});}
            		else if(z == "rx") { $.post("keyline.php", { id: 2, pos: u[0], key: v, sid: sid }, function(msg){ if(msg == 1) { aggiorna(); } else { errore(msg); }});}
                }
            	else if(y == 3) { $("#keybc").remove(); ok = 0; }
            	else if(y == 4) { v = w.substring(2); $.post("keyline.php", { id: 4, pos: u[0], key: v, sid: sid }, function(msg){ ok = 0; if(msg == 1) { aggiorna(); } else { alert(msg); }});}
            }
        }
        function sposta(x,y) { z = x.substring(0,2); w = x.substring(2); u = w.split('-');
        	if(z == "kc") {
        		if(y == 0) { $("#fx" + w).hide(); $("#fl" + w).hide(); $("#fr" + w).hide(); $("#fu" + w).hide(); $("#fd" + w).hide(); }
        		if(y == 1 && ok == 0) { $("#fx" + w).show(); $("#fl" + w).show(); $("#fr" + w).show(); $("#fu" + w).show(); $("#fd" + w).show();
        		if(u[0] == 1) { $("#fl" + w).hide(); }; if(u[0] == dbcl) { $("#fr" + w).hide(); }; if(u[1] == 1) { $("#fu" + w).hide(); }; if(u[1] >= fi[u[0]]) { $("#fd" + w).hide(); }}
        	}
            else if(z == "km") {
        		if(y == 0) { $("#ml" + w).hide(); $("#mr" + w).hide(); $("#mu" + w).hide(); $("#md" + w).hide(); }
        		if(y == 1) { $("#ml" + w).show(); $("#mr" + w).show(); $("#mu" + w).show(); $("#md" + w).show(); $("#mu1").hide(); $("#md" + (nkey - 1)).hide(); if(mk == 1) $("#ml" + w).hide(); if(mk == 7) $("#mr" + w).hide(); }
        	} else {
            	if(y == 0) { $("#" + x).attr("src","images/" + z + "_off.bmp"); };
            	if(y == 1) { $("#" + x).attr("src","images/" + z + "_on.bmp"); }
            	if(y == 2) { v = $("#nm" + w).text();
            		if(z == "fl") { var k = parseInt(u[0]) - 1; $.post("keycomb.php", { par: u[0], arr: k, pos: 1, key: v, sid: sid }, function(msg){ if(msg == 1) { aggiorna(); } else { errore(msg); }});}
            		if(z == "fr") { var k = parseInt(u[0]) + 1; $.post("keycomb.php", { par: u[0], arr: k, pos: 1, key: v, sid: sid }, function(msg){ if(msg == 1) { aggiorna(); } else { errore(msg); }});}
            		if(z == "fu") { $.post("keycomb.php", { par: u[0], arr: u[0], pos: 0, key: v, sid: sid }, function(msg){ if(msg == 1) { aggiorna(); } else { errore(msg); }});}
            		if(z == "fd") { $.post("keycomb.php", { par: u[0], arr: u[0], pos: 1, key: v, sid: sid }, function(msg){ if(msg == 1) { aggiorna(); } else { errore(msg); }});}
            		if(z == "fx") { $.post("keycomb.php", { par: u[0], arr: u[0], pos: 2, key: v, sid: sid }, function(msg){ if(msg == 1) { aggiorna(); } else { errore(msg); }});}
                    if(z == "fc") { $.post("keycomb.php", { par: u[0], arr: u[0], pos: 3, key: v, sid: sid }, function(msg){ if(msg == 1) { aggiorna(); } else { errore(msg); }});}
                    if(z == "fe") { $.post("keycomb.php", { par: u[0], arr: u[0], pos: 4, key: v, sid: sid }, function(msg){ if(msg == 1) { aggiorna(); } else { errore(msg); }});}
                    if(z == "md") { i = parseInt(w); $.post("keybase.php", { type: 9, val: i, old: i-1, pos: mk }, function(msg){ if(msg.length > 2) key_base(mk,msg); else errore(10); });}
                    if(z == "mu") { i = parseInt(w); $.post("keybase.php", { type: 9, val: i-2, old: i-1, pos: mk }, function(msg){ if(msg.length > 2) key_base(mk,msg); else errore(10); });}
                    if(z == "mr") { i = parseInt(w); $.post("keybase.php", { type: 10, val: mk, old: mk+1, pos: i }, function(msg){ if(msg.length > 2) { rimuovi(); key_base(mk,msg); } else errore(10); });}
                    if(z == "ml") { i = parseInt(w); $.post("keybase.php", { type: 10, val: mk, old: mk-1, pos: i }, function(msg){ if(msg.length > 2) { rimuovi(); key_base(mk,msg); } else errore(10); });}
            	}
            }
        }
        function body(msg) { var json = JSON.parse(msg); var x = 0; var y = 0; var msg2 = '<tr><td colspan="3" height="12"></td></tr>';
            for(var a=0; a<json.length; a++){ u = 2; x = a + 1; fi[x] = json[a].length; // ------------------------------------- scorro le colonne in orrizzontale da 1 a 7
                for(var b=0; b<json[a].length; b++){ y = b + 1; var blk = json[a][b]['block']; // ------------------------------ scorro la colonna in verticale ( Key Primarie )
                    if(blk) { msg = header(json[a][b]['value'],x,y,false);
                        for(var c=0; c<blk.length; c++){ var n = 0; var z = x+'-'+y+'-'+(c+1); var key = blk[c]; var base = key['K'].split('.').join('&nbsp;.&nbsp;'); var msg1 = ' <table border="0" width="29" height="20" cellspacing="0" cellpadding="0" onmouseover="javascript:modifica(\'ri'+z+'\',1)" onmouseout="javascript:modifica(\'ri'+z+'\',0)"><tr><td width="9" align="left"><a href="javascript:modifica(\'rp'+z+'\',2)"><img id="rp'+z+'" class="im0" src="images/rp_off.bmp" onmouseover="javascript:modifica(\'rp'+z+'\',1)" onmouseout="javascript:modifica(\'rp'+z+'\',0)" title="<?php echo $lng[71]; ?>"></a></td><td width="10" align="center"><a href="javascript:modifica(\'rx'+z+'\',2)"><img id="rx'+z+'" class="im0" src="images/rx_off.bmp" onmouseover="javascript:modifica(\'rx'+z+'\',1)" onmouseout="javascript:modifica(\'rx'+z+'\',0)" title="<?php echo $lng[72]; ?>"></a></td><td width="10" align="center"><a href="javascript:modifica(\'ru'+z+'\',2)"><img id="ru'+z+'" class="im0" src="images/ru_off.bmp" onmouseover="javascript:modifica(\'ru'+z+'\',1)" onmouseout="javascript:modifica(\'ru'+z+'\',0)" title="<?php echo $lng[73]; ?>"></a></td></tr></table></td></td></tr>';
                            
                            if(key['associated']){ for(var d=0; d<key['associated'].length; d++) { n++; keyComb = key['K']+'#as#'+key['associated'][d]['K']; msg += '<tr><td class="wh6"></td><td class="td13 bg4"><h5>'+base+'<span class="ft0 bg8" title=" <?php echo $lng[74]; ?> ">'+key['associated'][d]['K'].split('.').join('&nbsp;.&nbsp;')+'</span>'+note(keyComb,z+'-'+n,0,key['associated'][d]['note'])+'</h5></td><td class="td12 cl2"><a href="javascript:guarda(\''+key['K']+'#'+key['associated'][d]['K']+'\')">'+key['associated'][d]['T']+'</a></td></td></tr>'; }}
                            if(key['multiple']){ for(var d=0; d<key['multiple'].length; d++) { n++; keyComb = key['K']+'#mu#'+key['multiple'][d]['K']; msg += '<tr><td class="wh6"></td><td class="td13 bg4"><h5>'+base+'<span class="ft0 bg2" title=" <?php echo $lng[75]; ?> ">'+key['multiple'][d]['K'].split('.').join('&nbsp;.&nbsp;')+'</span>'+note(keyComb,z+'-'+n,0,key['multiple'][d]['note'])+'</h5></td><td class="td12 cl2"><a href="javascript:guarda(\''+key['K']+'#'+key['multiple'][d]['K']+'.0\')">'+key['multiple'][d]['T']+'</a></td></td></tr>'; }}
                            if(key['multiple_auto']){ for(var d=0; d<key['multiple_auto'].length; d++) { n++; keyComb = key['K']+'#ma#'+key['multiple_auto'][d]['K']; msg += '<tr><td class="wh6"></td><td class="td13 bg4"><h5>'+base+'<span class="ft0 bg5" title=" <?php echo $lng[76]; ?> ">'+key['multiple_auto'][d]['K'].split('.').join('&nbsp;.&nbsp;')+'</span>'+note(keyComb,z+'-'+n,0,key['multiple_auto'][d]['note'])+'</h5></td><td class="td12 cl2"><a href="javascript:guarda(\''+key['K']+'#'+key['multiple_auto'][d]['K']+'.0\')">'+key['multiple_auto'][d]['T']+'</a></td></td></tr>'; }}
                            if(key['cloned']){ for(var d=0; d<key['cloned'].length; d++) { n++; keyComb = key['K']+'#cl#'+key['cloned'][d]['K']; msg += '<tr><td class="wh6"></td><td class="td13 bg4"><h5>'+base+'<span class="ft0 bg7" title=" <?php echo $lng[77]; ?> ">'+key['cloned'][d]['K'].split('.').join('&nbsp;.&nbsp;')+'</span>'+note(keyComb,z+'-'+n,0,key['cloned'][d]['note'])+'</h5></td><td class="td12 cl2"><a href="javascript:guarda(\''+key['K']+'#'+key['cloned'][d]['K']+'.1\')">'+key['cloned'][d]['T']+'</a></td></td></tr>'; }}
                            if(key['cloned_auto_product']){ for(var d=0; d<key['cloned_auto_product'].length; d++) { n++; keyComb = key['K']+'#cp#'+key['cloned_auto_product'][d]['K']; msg += '<tr><td class="wh6"></td><td class="td13 bg4"><h5>'+base+'<span class="ft0 bg6" title=" <?php echo $lng[78]; ?> ">'+key['cloned_auto_product'][d]['K'].split('.').join('&nbsp;.&nbsp;')+'</span>'+note(keyComb,z+'-'+n,0,key['cloned_auto_product'][d]['note'])+'</h5></td><td class="td12 cl2"><a href="javascript:guarda(\''+key['K']+'#'+key['cloned_auto_product'][d]['K']+'.0\')">'+key['cloned_auto_product'][d]['T']+'</a></td></td></tr>'; }}
                            if(key['cloned_auto_seller']){ for(var d=0; d<key['cloned_auto_seller'].length; d++) { n++; keyComb = key['K']+'#cs#'+key['cloned_auto_seller'][d]['K']; msg += '<tr><td class="wh6"></td><td class="td13 bg4"><h5>'+base+'<span class="ft0 bg0" title=" <?php echo $lng[79]; ?> ">'+key['cloned_auto_seller'][d]['K'].split('.').join('&nbsp;.&nbsp;')+'</span>'+note(keyComb,z+'-'+n,0,key['cloned_auto_seller'][d]['note'])+'</h5></td><td class="td12 cl2"><a href="javascript:guarda(\''+key['K']+'#'+key['cloned_auto_seller'][d]['K']+'.2\')">'+key['cloned_auto_seller'][d]['T']+'</a></td></td></tr>'; }}
                            
                            if(key['close']) msg += '<tr><td class="wh6"></td><td class="td13 cl11"><a href="javascript:espandi('+x+','+u+')" title="<?php echo $lng[80]; ?>"><span id="nm'+z+'">'+base+'</span></a><span class="ft2 cl12">'+key['T']+'</span></td><td class="td12">';
                            else  { msg += '<tr><td class="wh6"></td><td class="td13" onmouseover="javascript:modifica(\'ri'+z+'\',1)" onmouseout="javascript:modifica(\'ri'+z+'\',0)"><h5><span id="nm'+z+'">'+base;
                                if(key['T'] > 0){ if(blk.length == 1) msg += '</span><span class="ft2 cl2"><a href="javascript:guarda(\''+key['K']+'#0.0\')">'+key['T']+'</a></span><a href="javascript:comprimi('+x+','+u+')"><img id="ce'+z+'" class="im1" src="images/ce_off.bmp" onmouseover="javascript:modifica(\'ce'+z+'\',1)" onmouseout="javascript:modifica(\'ce'+z+'\',0)" title="<?php echo $lng[81]; ?>"></a><a href="javascript:ingiu('+x+','+u+')"><img id="fd'+z+'" class="im4" src="images/fd_off.bmp" onmouseover="javascript:modifica(\'fd'+z+'\',1)" onmouseout="javascript:modifica(\'fd'+z+'\',0)" title="<?php echo $lng[82]; ?>"></a></h5></td><td class="td12">'+msg1;
                                    else { msg += '</span><span class="ft2 cl2"><a href="javascript:guarda(\''+key['K']+'#0.0\')">'+key['T']+'</a></span><a href="javascript:comprimi('+x+','+u+')"><img id="ce'+z+'" class="im2" src="images/ce_off.bmp" onmouseover="javascript:modifica(\'ce'+z+'\',1)" onmouseout="javascript:modifica(\'ce'+z+'\',0)" title="<?php echo $lng[81]; ?>"></a><a href="javascript:insu('+x+','+u+')"><img id="fu'+z+'" class="im3" src="images/fu_off.bmp" onmouseover="javascript:modifica(\'fu'+z+'\',1)" onmouseout="javascript:modifica(\'fu'+z+'\',0)" title="<?php echo $lng[83]; ?>"></a><a href="javascript:ingiu('+x+','+u+')"><img id="fd'+z+'" class="im4" src="images/fd_off.bmp" onmouseover="javascript:modifica(\'fd'+z+'\',1)" onmouseout="javascript:modifica(\'fd'+z+'\',0)" title="<?php echo $lng[82]; ?>"></a></h5></td><td class="td12">'+msg1+msg2; }
                                } else msg += '</span></h5></td><td class="td12">'+msg1;
                            } u++;
                        } 
                    } else msg = header(json[a][b]['value'],x,y,true); $("#kc" + x).append(msg+'<tr><td colspan="3" height="30"></td></tr></table>');
                }
            } if(dbcl == 4) { if(fi[5] || fi[6] || fi[7]) $.msgBox({ type: "info", title: "QuanticoDB", content: "<?php echo $lng[16]; ?>" });}
        }
        function note(key,x,y,z='') { if(y == 1) { if($('#ta' + x).length < 1) $('#note' + x).hide(); } else if(y == 2) $('#note' + x).show(); else if(y == 3) { if($('#ta' + x).length < 1) $('#span' + x).append('<div id="ta'+x+'" style="margin:3px; text-align:right"><textarea id="area'+x+'" rows="4" cols="16">'+z+'</textarea><br><span id="load'+x+'"></span> <input type="submit" value="<?php echo $lng[85]; ?>" style="margin:2px 4px 0 0; font-size:11px" onclick="javascript:note(\''+key+'\',\''+x+'\',5)"><input type="reset" value="<?php echo $lng[86]; ?>" style="margin-top:2px; font-size:11px" onclick="javascript:note(\''+key+'\',\''+x+'\',4,\''+z+'\')"></div>'); else $('#ta' + x).remove(); } else if(y == 4) { $('#ta' + x).remove(); if(z == '') $('#note' + x).hide(); } else if(y == 5) { $('#load' + x).html('<img src="images/load.gif">'); var val = $('#area' + x).val().toString(); $.post('keybase.php', { type: 15, val: val, pos: key, sid: sid }, function(msg){ if(msg == 'OK') { $('#span' + x).removeAttr('onmouseover onmouseout').html('&nbsp;&nbsp;<a href="javascript:note(\''+key+'\',\''+x+'\',3,\''+val+'\')"><img id="note'+x+'" src="images/note_on.bmp" title="'+val+'" style="vertical-align:bottom"></a><span onmouseover="note(0,\''+x+'\',6)" onmouseout="note(0,\''+x+'\',7)">&nbsp;<a id="del'+x+'" href="javascript:note(\''+key+'\',\''+x+'\',8)" title="<?php echo $lng[87]; ?>" style="display:none"><b>x</b></a></span>'); $('#ta' + x).remove(); } else errore(msg); });} 
            else if(y == 6) $('#del' + x).show(); else if(y == 7) $('#del' + x).hide(); else if(y == 8) { $.post('keybase.php', { type: 16, pos: key, sid: sid }, function(msg){ if(msg == 'OK') { $('#span' + x).attr({onmouseover:'javascript:note(\''+key+'\',\''+x+'\',2)', onmouseout:'javascript:note(\''+key+'\',\''+x+'\',1)'}).html('&nbsp;&nbsp;<a href="javascript:note(\''+key+'\',\''+x+'\',3)"><img id="note'+x+'" src="images/note_off.bmp" title="<?php echo $lng[88]; ?>" style="vertical-align:bottom; display:none"></a>'); $('#ta' + x).remove(); } else errore(msg); });} else { if(z) return '<span id="span'+x+'" >&nbsp;&nbsp;<a href="javascript:note(\''+key+'\',\''+x+'\',3,\''+z+'\')"><img id="note'+x+'" src="images/note_on.bmp" title="'+z+'" style="vertical-align:bottom"></a><span onmouseover="note(0,\''+x+'\',6)" onmouseout="note(0,\''+x+'\',7)">&nbsp;<a id="del'+x+'" href="javascript:note(\''+key+'\',\''+x+'\',8)" title="<?php echo $lng[87]; ?>" style="display:none"><b>x</b></a></span></span>'; else return '<span id="span'+x+'" onmouseover="javascript:note(\''+key+'\',\''+x+'\',2)" onmouseout="javascript:note(\''+key+'\',\''+x+'\',1)" >&nbsp;&nbsp;<a href="javascript:note(\''+key+'\',\''+x+'\',3)"><img id="note'+x+'" src="images/note_off.bmp" title="<?php echo $lng[88]; ?>" style="vertical-align:bottom; display:none"></a></span>'; }
        }
        function header(key,x,y,opz) { var z = x + '-' + y; if(opz) { var sp = 'fe'+z; var bg = 'bg3'; var tt = '<?php echo $lng[89]; ?>'; var sk = ''; var ms = '<tr><td colspan="3" height="12"></td></td></tr></table>'; } else { var sp = 'fc'+z; var bg = 'bg2'; var tt = '<?php echo $lng[90]; ?>'; var sk = '<span onmouseover=javascript:search("'+z+'",1) onmouseout=javascript:search("'+z+'",0)>&nbsp;<input id="si'+z+'" type="text" style="width:45%; font-size:11px; display:none">&nbsp;<a href=javascript:search("'+z+'",4)><img id="sc'+z+'" src="images/search_off.bmp" onmouseover=javascript:search("'+z+'",2) onmouseout=javascript:search("'+z+'",3) style="display:none"></a></span>'; var ms = ''; }
            return '<table id="kc'+z+'" height="25" border="0" cellspacing="0" cellpadding="0"><tr><td class="wh8"></td><td class="wh7 '+bg+'" onmouseover="javascript:sposta(\'kc'+z+'\',1)" onmouseout="javascript:sposta(\'kc'+z+'\',0)"><h4><a href="javascript:sposta(\''+sp+'\',2)"><span id="nm'+z+'" title="'+tt+'" style="color:white">'+key+'</span></a>'+sk+'</h4></td><td class="wh0"><table class="wh0" cellspacing="0" cellpadding="0" onmouseover="javascript:sposta(\'kc'+z+'\',1)" onmouseout="javascript:sposta(\'kc'+z+'\',0)"><tr><td class="wh1"></td><td class="wh2"><a href="javascript:sposta(\'fu'+z+'\',2)"><img id="fu'+z+'" class="im0" src="images/fu_off.bmp" onmouseover="javascript:sposta(\'fu'+z+'\',1)" onmouseout="javascript:sposta(\'fu'+z+'\',0)" title="<?php echo $lng[61]; ?>"></a></td><td class="wh1"></td></tr><tr><td class="wh4"><a href="javascript:sposta(\'fl'+z+'\',2)"><img id="fl'+z+'" class="im0" src="images/fl_off.bmp" onmouseover="javascript:sposta(\'fl'+z+'\',1)" onmouseout="javascript:sposta(\'fl'+z+'\',0)" title="<?php echo $lng[91]; ?>"></a></td><td class="wh3""><a href="javascript:sposta(\'fx'+z+'\',2)"><img id="fx'+z+'" class="im0" src="images/fx_off.bmp" onmouseover="javascript:sposta(\'fx'+z+'\',1)" onmouseout="javascript:sposta(\'fx'+z+'\',0)" title="<?php echo $lng[92]; ?>"></a></td><td class="wh5"><a href="javascript:sposta(\'fr'+z+'\',2)"><img id="fr'+z+'" class="im0" src="images/fr_off.bmp" onmouseover="javascript:sposta(\'fr'+z+'\',1)" onmouseout="javascript:sposta(\'fr'+z+'\',0)" title="<?php echo $lng[93]; ?>"></a></td></tr><tr><td class="wh1"></td><td class="wh2"><a href="javascript:sposta(\'fd'+z+'\',2)"><img id="fd'+z+'" class="im0" src="images/fd_off.bmp" onmouseover="javascript:sposta(\'fd'+z+'\',1)" onmouseout="javascript:sposta(\'fd'+z+'\',0)" title="<?php echo $lng[64]; ?>"></a></td><td class="wh1"></td></tr></table></td></tr>'+ms;
        }
        function aggiornami() {
        	$.post('keyline.php', { id: 'a', pos: 'g', key: 'g' }, function(msg){
                if(msg == 1) { $('#agg').attr('src','images/' + lng + '/aggiornami_si.bmp'); $.msgBox({ type: "info", title: "QuanticoDB", content: "<?php echo $lng[94]; ?>", buttons: [{ value: "Ok" }]});}
                else { $('#agg').attr('src','images/' + lng + '/aggiornami_no.bmp'); $.msgBox({ type: "info", title: "QuanticoDB", content: "<?php echo $lng[95]; ?>", buttons: [{ value: "Ok" }]});} 
            });     
        }
        function nuova_key_base(x,y) { 
            if(y == 0) $('#nkb').attr('src','images/' + lng + '/nuova_key_base_off.jpg'); else if(y == 1 && ok == 0) $('#nkb').attr('src','images/' + lng + '/nuova_key_base_on.jpg'); else if(y == 2 && ok == 0) { $('#tab' + x).remove(); $('#qdb').append('<table id="tab' + x + '" border="0" width="100%" cellspacing="0" cellpadding="0" height="40"><tr><td align="center" width="69"><h2>&nbsp;&nbsp;&nbsp;' + x + '.</h2></td><td width="156"><input class="ytc" id="kbt" type="text"></td><td width="15"><a href="javascript:cancella(' + x + ',3)"><img id="x' + x + '" src="images/x_off.bmp" border="0" hspace="1" vspace="2" onmouseover="javascript:cancella(' + x + ',1)" onmouseout="javascript:cancella(' + x + ',0)" title="<?php echo $lng[65]; ?>"></a><a href="javascript:salva(' + x + ',2)"><img id="s' + x + '" src="images/s_on.bmp" border="0" vspace="2" onmouseover="javascript:salva(' + x + ',1)" onmouseout="javascript:salva(' + x + ',0)" title="<?php echo $lng[96]; ?>"></a></td></tr></table>'); }
        }
        function errore(x,y,z,w) {
        	if(x == 2) msg = "<?php echo $lng[97]; ?>";
        	if(x == 3) msg = "<?php echo $lng[98]; ?>";
        	if(x == 4) msg = "<?php echo $lng[99]; ?>";
        	if(x == 5) msg = "<?php echo $lng[100]; ?>";
        	if(x == 6) msg = "<?php echo $lng[101]; ?>";
        	if(x == 7) msg = "<?php echo $lng[102]; ?>";
        	if(x == 8) msg = "<?php echo $lng[103]; ?>";
        	if(x == 9) msg = "<?php echo $lng[104]; ?>";
        	if(x == 10) msg = "<?php echo $lng[105]; ?>";
            if(x == 11) msg = "<?php echo $lng[106]; ?>";
            if(x == 12) msg = "<?php echo $lng[107]; ?>";
            if(x == 13) msg = "<?php echo $lng[108]; ?>";
            if(x == 14) msg = "<?php echo $lng[109]; ?>";
            if(x == 15) msg = "<?php echo $lng[110]; ?>";
            if(x == 16) msg = "<?php echo $lng[111]; ?>";
            if(x == 20) msg = "<?php echo $lng[112]; ?>";
            if(x == 24) msg = "<?php echo $lng[113]; ?>";
            if(x == 25) msg = "<?php echo $lng[114]; ?>";
            if(x == 26) msg = "<?php echo $lng[115]; ?>";
            if(x == 27) msg = "<?php echo $lng[116]; ?>";
            if(x == 28) msg = "<?php echo $lng[117]; ?>";
            if(x == 29) msg = "<?php echo $lng[118]; ?>";
            if(y == 1) tipo = 'info'; else tipo = 'error'; $.msgBox({ type: tipo, title: "QuanticoDB", content: msg, buttons: [{ value: "Ok" }]});
        }
    </script> 
</head>
<body onload="javascript:controllo(); javascript:key_base(1); javascript:key_combinate(0,3); javascript:comandi(); javascript:sicurezza(); javascript:dbman()"><div class="yoshi_full_screen"></div><div align="center">
<table border="0" cellspacing="0" cellpadding="0" height="100%">
	<tr>
        <td width="240" align="left" valign="top" background="images/QKEY_base_sfondo.jpg" height="100%" rowspan="3"><div id="qdb" width="240"><img src="images/Qdb1.jpg"><img src="images/Qdb2.jpg" height="41" width="54"><span id="sic"><a class="tooltip-right" data-tooltip="<?php echo $lng[119]; ?>" href="javascript:sicurezza(2)"><img id="alr" src="images/alert_off.jpg" border="0" onmouseover="javascript:sicurezza(1)" onmouseout="javascript:sicurezza(0)"></a></span><img src="images/Qdb3.jpg"><a href="javascript:menu()"><img src="images/Qdb4.png" border="0" title="<?php echo $lng[120]; ?>"></a><a href="javascript:menu()"><img src="images/Qdb7.png" border="0" title="<?php echo $lng[120]; ?>"></a><img src="images/Qdb8.jpg">
        <a href="javascript:colonne()"><img id="imgcl" border="0" src="" title=""></a><div align="center"><img id="mkb1" src="images/1on.jpg" border="0" onmouseover="javascript:menukb(1)"><img id="mkb2" src="images/2off.jpg" border="0" onmouseover="javascript:menukb(2)"><img id="mkb3" src="images/3off.jpg" border="0" onmouseover="javascript:menukb(3)"><img id="mkb4" src="images/4off.jpg" border="0" onmouseover="javascript:menukb(4)"><img id="mkb5" src="images/5off.jpg" border="0" onmouseover="javascript:menukb(5)"><img id="mkb6" src="images/6off.jpg" border="0" onmouseover="javascript:menukb(6)"><img id="mkb7" src="images/7off.jpg" border="0" onmouseover="javascript:menukb(7)"></div><img src="images/Qkbs.jpg" border="0"></div></td>
        <td align="left" valign="top" style="background-color:#fff"><div id="kc1"><img src="images/colonna.bmp" width="200" height="25"></div></td>
		<td align="left" valign="top" style="background-color:#fff"><div id="kc2"><img src="images/colonna.bmp" width="200" height="25"></div></td>
		<td align="left" valign="top" style="background-color:#fff"><div id="kc3"><img src="images/colonna.bmp" width="200" height="25"></div></td>
		<td align="left" valign="top" style="background-color:#fff"><div id="kc4"><img src="images/colonna.bmp" width="200" height="25"></div></td>
        <td align="left" valign="top" style="background-color:#fff"><div id="kc5"><img src="images/colonna.bmp" width="200" height="25"></div></td>
		<td align="left" valign="top" style="background-color:#fff"><div id="kc6"><img src="images/colonna.bmp" width="200" height="25"></div></td>
		<td align="left" valign="top" style="background-color:#fff"><div id="kc7"><img src="images/colonna.bmp" width="200" height="25"></div></td>
	</tr>
		<tr>
		<td valign="top" colspan="7">
		<table border="0" width="100%" cellspacing="0" cellpadding="0" height="100%">
			<tr><td width="30" rowspan="3">&nbsp;</td><td id="tdpls" width="410" height="60" valign="bottom"><h6><i><?php echo $lng[121]; ?>&nbsp;&nbsp;--&gt;&nbsp;&nbsp;<a href="javascript:pls()"><?php echo $lng[122]; ?></a></i></h6></td><td width="90" height="60" valign="bottom" align="left"><h6><span id="gio"></span></h6></td><td width="30" rowspan="3">&nbsp;</td><td rowspan="3" valign="top"><span id="comandi"></span></td></tr>
			<tr><td valign="top" bgcolor="#FAFAFA" style="border: 1px solid #F0F0F0" colspan="2"><div id="rst"></div></td></tr><tr><td height="20" colspan="2">&nbsp;</td></tr>
		</table>
		</td>
	</tr>
</table>
<div align="center">
	<table border="0" width="92%" cellspacing="0" cellpadding="0">
		<tr>
            <td rowspan="3" width="525">&nbsp;</td>
            <td height="100" align="center" valign="top"><font face="Arial" size="1"><?php echo $lng[123]; ?></font></td>
            <td rowspan="3" align="right" valign="top"><span id="creato"></span></td>
        </tr>
	</table>
</div>
</div>
</body>
</html>