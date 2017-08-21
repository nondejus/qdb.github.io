<?php

    require 'dirqdb.php'; $dirqdb .= 'Qconfig.php'; if(!file_exists($dirqdb)) { header('location: index.php'); exit; } require_once $dirqdb; 
    
    $qdb = file($Qdatabase.'/index.php'); if(count($qdb) < 3) { header('location: index.php'); exit; } else setcookie('Qdb#admin','',time()-99999);
    $cnf = file('config.php'); $lng = file('language/'.rtrim($cnf[4]).'/login.php', FILE_IGNORE_NEW_LINES);
    
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=rtrim($cnf[4])?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta http-equiv="Content-Language" content="<?=rtrim($cnf[4])?>">
    <meta name="author" content="Piazzi Raffaele">
    <title>QuanticoDB | Login</title>
    <script type="text/javascript" language="javascript" src="js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" language="javascript" src="js/msgbox/msgbox.js"></script>
    <script type="text/javascript" language="javascript" src="js/yoshi/yoshi.js"></script>
    <script type="text/javascript" language="javascript" src="js/yoshi/bg.js"></script>
    <link type="text/css" rel="stylesheet" media="screen" href="css/msgbox.css" />
    <link type="text/css" rel="stylesheet" media="screen" href="css/style.css" />
    <link type="text/css" rel="stylesheet" media="screen" href="css/yoshi.css" />
    <link rel="shortcut icon" href="images/favicon.ico" />
    <script type='text/javascript'> ok = 1;
    function scrivi() { $.post("reglog.php", { type: 's', user: 'c', pass: 'r' }, function(msg){ if(msg == 1) { ok = false; diritti(); }})}
    function diritti() { $.msgBox({ type: "alert", title: "QuanticoDB", content: '<?=$lng[3]?>', buttons: [{ value: "Ok" }]}); }
    function form() { if(ok) { if(ok == 1) { var eml = $('#YesIm_Username').val().toString(); var psw = $('#YesIm_Password').val().toString(); regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if(eml.length > 0){ if(regex.test(eml)){ if(psw.length > 0){ if(psw.length > 5){ ok = 2; $('#loading').html('<img src="images/load.gif" style="margin:8px 10px">');
            $.post("reglog.php", { type: 'Login', user: eml, pass: psw }, function(msg){ ok = 1; $('#loading').html('&nbsp;'); if(msg.length > 1) location.href = 'database.php?id=' + msg; else error(msg); });
        } else error(4); } else error(3); } else error(2); } else error(1); }} else diritti(); }
    function error(x) {
        if(x == 0) msg ="<?=$lng[4]?>";
        if(x == 1) msg ="<?=$lng[5]?>";
    	if(x == 2) msg ="<?=$lng[6]?>";
        if(x == 3) msg ="<?=$lng[7]?>";
        if(x == 4) msg ="<?=$lng[8]?>";
        if(x == 5) msg ="<?=$lng[9]?>";
        if(x == 9) msg ="<?=$lng[10]?>";
	    $.msgBox({ type: "error", title: "QuanticoDB", content: msg, buttons: [{ value: "Ok" }]});
	}
    </script> 
</head>
<body onload="javascript:scrivi()">
<div class="yoshi_full_screen"></div>
<div align="center"><br><br><br><br>
	<table border="0" width="790" cellspacing="0" cellpadding="0">
		<tr><td width="790" colspan="2" height="70"><img border="0" src="images/Q.box.header.jpg" width="790" height="70"></td></tr>
		<tr>
			<td width="330" valign="top" background="images/Q.box.line.jpg"><img border="0" src="images/Q.box.logo.png"><img border="0" src="images/Q.box.left.jpg" width="330" height="60"></td>
			<td width="460" background="images/Q.admin.login.jpg" height="410">
			<table border="0" width="100%" cellspacing="0" cellpadding="0" height="100%">
				<tr><td width="60" rowspan="4">&nbsp;</td><td height="160" colspan="2">&nbsp;</td></tr>
				<tr><form action="javascript:form()"><td height="68" colspan="2" align="left" valign="top"><a class="tooltip-right" data-tooltip="<?=$lng[11]?>"><input class="inp" type="email" id="YesIm_Username"></a></td></tr>
				<tr><td height="52" colspan="2" align="left" valign="top"><a class="tooltip-right" data-tooltip="<?=$lng[12]?>"><input class="inp" type="password" id="YesIm_Password"></a></td></tr>
				<tr><td width="223" align="right" valign="top" id="loading">&nbsp;</td><td align="left" valign="top"><a class="tooltip-right" data-tooltip="<?=$lng[13]?>"><input type="submit" id="YesIm" value=" " style="width:57; height:27; border:1px solid #FFF; background-color:#FFF; background-image:url('images/login.jpg')"></a></td></tr></form>
			</table></td>
		</tr>
		<tr><td id="tb5" width="790" colspan="2"><table border="0" width="790" cellspacing="0" cellpadding="0" background="images/Q.box.line.jpg" height="20"><tr><td width="790" height="20"></td></tr></table></td></tr>
		<tr><td width="790" colspan="2" height="120"><img border="0" src="images/Q.box.footer.jpg" width="790" height="120"></td></tr>
		<tr><td width="790" colspan="2" align="center">
			<table border="0" width="100%" cellspacing="0" cellpadding="0">
				<tr>
					<td width="30" rowspan="3">&nbsp;</td>
					<td align="center" width="730"><font face="Arial" size="1"><?=$lng[14]?></font></td>
					<td width="30" rowspan="3">&nbsp;</td>
				</tr>
			</table>
		</td></tr>
	</table>
</div>
</body>
</html>