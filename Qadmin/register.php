<?php
    require 'dirqdb.php'; $dirqdb .= 'Qconfig.php'; if(!file_exists($dirqdb)) { header('location: index.php'); exit; } if(file_exists('creadb.php')) unlink('creadb.php');
    require_once $dirqdb; $qdb = file($Qdatabase.'/index.php'); if(count($qdb) > 2) { header('location: login.php'); exit; }
    $cnf = file('config.php'); $lng = file('language/'.rtrim($cnf[4]).'/register.php', FILE_IGNORE_NEW_LINES);
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo rtrim($cnf[4]); ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta http-equiv="Content-Language" content="<?php echo rtrim($cnf[4]); ?>">
    <meta name="author" content="Piazzi Raffaele">
    <title>QuanticoDB | Register</title>
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
    function diritti() { $.msgBox({ type: "alert", title: "QuanticoDB", content: '<?php echo $lng[3]; ?>', buttons: [{ value: "Ok" }]}); }
    function form() { if(ok) { if(ok == 1) { var eml = $('#email').val().toString(); var psw = $('#password').val().toString(); var cpw = $('#confpsw').val().toString(); regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if(eml.length > 0){ if(regex.test(eml)){ if(psw.length > 0){ if(psw.length > 5){ if(cpw.length > 0){ if(cpw == psw){ ok = 2; $('#loading').html('<img src="images/load.gif" style="margin:8px 10px">');
            $.post("reglog.php", { type: 'Register', user: eml, pass: psw }, function(msg){ ok = 1; $('#loading').html('&nbsp;'); if(msg.length > 1) location.href = 'database.php?id=' + msg; else error(msg); });
        } else error(6); } else error(5); } else error(4); } else error(3); } else error(2); } else error(1); }} else diritti();
    }
    function error(x) {
        if(x == 0) msg ="<?php echo $lng[4]; ?>";
        if(x == 1) msg ="<?php echo $lng[5]; ?>";
    	if(x == 2) msg ="<?php echo $lng[6]; ?>";
        if(x == 3) msg ="<?php echo $lng[7]; ?>";
        if(x == 4) msg ="<?php echo $lng[8]; ?>";
        if(x == 5) msg ="<?php echo $lng[9]; ?>";
        if(x == 6) msg ="<?php echo $lng[10]; ?>";
        if(x == 9) msg ="<?php echo $lng[11]; ?>";
	    $.msgBox({ type: "error", title: "QuanticoDB", content: msg, buttons: [{ value: "Ok" }]});
	}
    </script>
</head>
<body onload="javascript:scrivi()">
<div class="yoshi_full_screen"></div>
<div align="center"><br><br><br><br>
	<table border="0" width="790" cellspacing="0" cellpadding="0">
		<tr><td width="790" colspan="2" height="70"><img border="0" src="images/Q.box.header.jpg" width="790" height="70"></td></tr>
		<tr><td width="330" valign="top" background="images/Q.box.line.jpg"><img border="0" src="images/Q.box.logo.png"><img border="0" src="images/Q.box.left.jpg" width="330" height="60"></td>
			<td width="460" background="images/Q.admin.register.jpg" height="410">
			<table border="0" width="100%" cellspacing="0" cellpadding="0" height="100%">
				<tr><td width="60" rowspan="5">&nbsp;</td><td height="160" colspan="2">&nbsp;</td></tr>
				<tr><form action="javascript:form()"><td height="68" colspan="2" align="left" valign="top"><a class="tooltip-right" data-tooltip="<?php echo $lng[12]; ?>"><input class="inp" type="email" id="email"></a></td></tr>
				<tr><td height="68" colspan="2" align="left" valign="top"><a class="tooltip-right" data-tooltip="<?php echo $lng[13]; ?>"><input class="inp" type="password" id="password"></a></td></tr>
				<tr><td height="52" colspan="2" align="left" valign="top"><a class="tooltip-right" data-tooltip="<?php echo $lng[14]; ?>"><input class="inp" type="password" id="confpsw"></a></td></tr>
				<tr><td width="197" align="right" valign="top" id="loading">&nbsp;</td><td align="left" valign="top"><a class="tooltip-right" data-tooltip="<?php echo $lng[15]; ?>"><input type="submit" value=" " style="width:81; height:27; border:1px solid #FFF; background-color:#FFF; background-image:url('images/register.jpg')"></a></td>
                </tr></form>
			</table></td>
		</tr>
		<tr><td id="tb5" width="790" colspan="2"><table border="0" width="790" cellspacing="0" cellpadding="0" background="images/Q.box.line.jpg" height="20"><tr>
			<td width="790" height="20" align="right"><h6><?php echo $lng[16]; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </h6></td></tr></table></td></tr>
		<tr><td width="790" colspan="2" height="120"><img border="0" src="images/Q.box.footer.jpg" width="790" height="120"></td></tr>
		<tr><td width="790" colspan="2" align="center">
			<table border="0" width="100%" cellspacing="0" cellpadding="0">
				<tr>
					<td width="30" rowspan="3">&nbsp;</td>
					<td align="center" width="730"><font face="Arial" size="1"><?php echo $lng[17]; ?></font></td>
					<td width="30" rowspan="3">&nbsp;</td>
				</tr>
				<tr><td align="center" valign="bottom" height="110"><a target="_blank" href="https://www.a2hosting.com/refer/64197"><img border="0" src="images/a2hosting_turbo20x.png" title=" BEST Hosting Solution " width="682" height="84"></a></td></tr>
			</table>
		</td></tr>
	</table>
</div>
</body>
</html>