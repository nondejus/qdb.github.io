<?php

    if(!isset($_COOKIE['Qdb#admin']) || $_COOKIE['Qdb#admin'] != 'Setup') { header('location: index.php'); exit; }
    require_once 'dirqdb.php'; $dirqdb .= 'Qconfig.php'; if(!file_exists($dirqdb)) { header('location: index.php'); exit; }
    
    $qdb = file('config.php'); $lng = file('language/'.rtrim($qdb[4]).'/setup.php', FILE_IGNORE_NEW_LINES); $ok = file($dirqdb);

    if(count($ok) > 6) { 
        header('location: register.php'); exit; 
    } else { 
        if(isset($_GET['lng'])) { if($_GET['lng'] != 'en' && $_GET['lng'] != 'it') exit;
            $qdb[4] = $_GET['lng']."\n"; file_put_contents('config.php', $qdb); 
            $lng = file('language/'.$_GET['lng'].'/setup.php', FILE_IGNORE_NEW_LINES); 
        }
    }

?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=rtrim($qdb[4])?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta http-equiv="Content-Language" content="<?=rtrim($qdb[4])?>">
    <meta name="author" content="Piazzi Raffaele">
    <title>QuanticoDB</title>
    <script type="text/javascript" language="javascript" src="js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" language="javascript" src="js/msgbox/msgbox.js"></script>
    <script type="text/javascript" language="javascript" src="js/yoshi/yoshi.js"></script>
    <script type="text/javascript" language="javascript" src="js/yoshi/bg.js"></script>
    <link type="text/css" rel="stylesheet" media="screen" href="css/msgbox.css" />
    <link type="text/css" rel="stylesheet" media="screen" href="css/style.css" />
    <link type="text/css" rel="stylesheet" media="screen" href="css/yoshi.css" />
    <link rel="shortcut icon" href="images/favicon.ico" />
    <script type='text/javascript'> ok = true;
    function scrivi() { $.post("keyline.php", { id: 's', pos: 'c', key: 'r' }, function(msg){ if(msg == 1) { ok = false; diritti(); }})}
    function diritti() { $.msgBox({ type: "alert", title: "QuanticoDB", content: '<?=$lng[9]?>', buttons: [{ value: "Ok" }]}); }
    function cominciamo(x) { if(ok) { if(x == 2) $.post("creadb.php", function(){ location.href = 'register.php'; }); else if(x == 1) $('#start').attr('src','images/<?=rtrim($qdb[4])?>/cominciamo_on.jpg'); else $('#start').attr('src','images/<?=rtrim($qdb[4])?>/cominciamo_off.jpg'); } else diritti(); }
</script> 
</head>
<body onload="javascript:scrivi()">
<div class="yoshi_full_screen"></div>
<div align="center"><br><br><br><br>
	<table border="0" width="790" cellspacing="0" cellpadding="0">
		<tr><td width="790" colspan="2" height="70"><img border="0" src="images/Q.box.header.jpg" width="790" height="70"></td></tr>
		<tr>
			<td width="330" height="310"><img border="0" src="images/Q.box.logo.png"></td>
			<td width="460" background="images/Q.box.type.jpg" rowspan="3" height="430">
			<table border="0" width="100%" cellspacing="0" cellpadding="0" height="100%">
				<tr>
					<td align="center" valign="top" style="height:80" colspan="2"><font face="Tw Cen MT" color="#484848" size="7"><b><?=$lng[10]?></b></font></td>
					<td align="center" valign="top" rowspan="6" style="width: 60">&nbsp;</td>
				</tr>
				<tr>
					<td align="left" style="width:72"><font face="Tw Cen MT" color="#F00" size="7"><b>&nbsp;1</b></font></td>
					<td align="left">
					<font face="Tw Cen MT" color="#09C" size="6" style="text-align:justify" class="tooltip-right" data-tooltip="<?=$lng[11]?>"><b><?=$lng[12]?></b></font></td>
				</tr>
				<tr>
					<td align="left" style="width:72"><font face="Tw Cen MT" color="#F00" size="7"><b>&nbsp;2</b></font></td>
					<td align="left"><font face="Tw Cen MT" color="#09C" size="6" style="text-align:justify" class="tooltip-right" data-tooltip="<?=$lng[13]?>"><b><?=$lng[14]?></b></font></td>
				</tr>
				<tr>
					<td align="left" style="width:72"><font face="Tw Cen MT" color="#F00" size="7"><b>&nbsp;3</b></font></td>
					<td align="left"><font face="Tw Cen MT" color="#09C" size="6" style="text-align:justify" class="tooltip-right" data-tooltip="<?=$lng[15]?>"><b><?=$lng[16]?></b></font></td>
				</tr>
				<tr>
					<td align="left" style="width:72"><font face="Tw Cen MT" color="#F00" size="7"><b>&nbsp;4</b></font></td>
					<td align="left"><font face="Tw Cen MT" color="#09C" size="6" style="text-align:justify" class="tooltip-right" data-tooltip="<?=$lng[17]?>"><b><?=$lng[18]?></b></font></td>
				</tr>
				<tr>
					<td align="left" style="height:90"><font face="Tw Cen MT" size="6" style="text-align:center" class="tooltip-left" data-tooltip="<?=$lng[19]?>"><a href="setup.php?lng=en"><img src="images/en/language.bmp" style="margin:30px 0 4px 12px; border:0"></a></font><br><font face="Tw Cen MT" size="6" style="text-align:center" class="tooltip-left" data-tooltip="<?=$lng[20]?>"><a href="setup.php?lng=it"><img src="images/it/language.bmp" style="margin-left:12px; border:0"></a></font></td>
					<td align="left" style="height:90" valign="bottom"><font face="Tw Cen MT" size="6" style="text-align:justify" class="tooltip-right" data-tooltip="<?=$lng[21]?>"><a href="javascript:cominciamo(2)"><img border="0" id="start" src="images/<?=rtrim($qdb[4])?>/cominciamo_off.jpg" onmouseover="javascript:cominciamo(1)" onmouseout="javascript:cominciamo(0)"></a></font></td>
				</tr>
				</table>
			</td>
		</tr>
		<tr><td width="330"><img border="0" src="images/Q.box.left.jpg" width="330" height="60"></td></tr>
		<tr><td id="tb5" width="330" height="60" background="images/Q.box.line.jpg"></td></tr>
		<tr><td width="790" colspan="2" height="120"><img border="0" src="images/Q.box.footer.jpg" width="790" height="120"></td></tr>
		<tr><td width="790" colspan="2" align="center">
			<table border="0" width="100%" cellspacing="0" cellpadding="0">
				<tr>
					<td width="30" rowspan="3">&nbsp;</td>
					<td align="center" width="730"><font face="Arial" size="1"><?=$lng[22]?></font></td>
					<td width="30" rowspan="3">&nbsp;</td>
				</tr>
			</table>
		</td></tr>
	</table>
</div>
</body>
</html>
