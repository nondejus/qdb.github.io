<?php  require_once 'cookie.php'; $lng = file('language/'.rtrim($dbtype[4]).'/email.php', FILE_IGNORE_NEW_LINES); ?>
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
    <script type='text/javascript'> ok = true; sid = '<?php echo rawurldecode($_GET['id']); ?>';
    function form() { if(ok) { vem = $('#veml').val().toString(); nem = $('#neml').val().toString(); cem = $('#ceml').val().toString(); regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if(vem.length > 0){ if(regex.test(vem)){ if(nem.length > 0){ if(regex.test(nem)){ if(cem.length > 0){ if(cem == nem){ ok = false; $('#loading').html('<img src="images/load.gif" style="margin:8px 10px">');
            $.post("keyline.php", { id: 'm', pos: vem, key: nem, sid: sid }, function(msg){ ok = true; $('#loading').html('&nbsp;'); if(msg == 'OK') $.msgBox({ type: 'info', title: 'QuanticoDB', content: '<?php echo $lng[3]; ?>' }); else error(msg); });
        } else error(6); } else error(5); } else error(4); } else error(3); } else error(2); } else error(1); }
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
<body>
<?php
    if(array_key_exists("HTTP_REFERER", $_SERVER) && strpos($_SERVER["HTTP_REFERER"], '?id=')) {
        require_once '../Quantico.php'; $ok = false; $qdb = file($Qdatabase.'/index.php'); if(count($qdb) < 3) dberror();
        
        function dberror() { exit("<br><br><h2 align='center'>".$lng[12]."</h2><br><h1 align='center'>".$lng[13]."</h1>"); }
        
        for($a=1; $a<8; $a++) { $fp = file("schema/$a.php"); if(count($fp) > 2) { $ok = true; for($b=2; $b<count($fp); $b++) if(strpos($fp[$b],".0\n")) dberror(); }} if(!$ok) dberror();
    } else exit("<br><br><br><h2 align='center'>".$lng[14]."</h2><br><h1 align='center'>!!!..... ".$lng[15]." .....!!!</h1>");
?>
<div align="center">
<table border="0" width="460" cellspacing="0" cellpadding="0" height="650">
<tr><td align="center" valign="top"><table border="0" width="280" cellspacing="0" cellpadding="0">
<tr><td height="30" colspan="2"><h5>&nbsp;</h5></td></tr>
<tr><td height="20" colspan="2"><h5><?php echo $lng[16]; ?></h5></td></tr>
<tr><form action="javascript:form()"><td height="60" colspan="2" align="left" valign="top"><a data-tooltip="<?php echo $lng[17]; ?>"><input class="inp" type="email" id="veml"></a></td></tr>
<tr><td height="20" colspan="2"><h5><?php echo $lng[18]; ?></h5></td></tr>
<tr><td height="60" colspan="2" align="left" valign="top"><a data-tooltip="<?php echo $lng[19]; ?>"><input class="inp" type="email" id="neml"></a></td></tr>
<tr><td height="20" colspan="2"><h5><?php echo $lng[20]; ?></h5></td></tr>
<tr><td height="60" colspan="2" align="left" valign="top"><a data-tooltip="<?php echo $lng[21]; ?>"><input class="inp" type="email" id="ceml"></a></td></tr>
<tr><tr><td width="197" align="right" valign="top" id="loading">&nbsp;</td><td align="left" valign="top"><a data-tooltip="<?php echo $lng[22]; ?>"><input type="submit" value=" " style="width:81; height:27; border:1px solid #FFF; background-color:#FFF; background-image:url('images/change.jpg')"></a></td></tr></form>
</table></td></tr><tr><td align="center" height="350"><img src="images/mail.jpg"></td></tr></table>
</div>
</body>
</html>