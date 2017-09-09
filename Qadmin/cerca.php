<?php

    if(isset($_GET['id'])) $id = $_GET['id']; else exit; 
    
    require_once 'cookie.php';
    
    if($dbtype[3] == "test\n") $Qdatabase = substr($Qdatabase, 0, -5);
    elseif($dbtype[3] == "clone\n") $Qdatabase = substr($Qdatabase, 0, -6);
    
    require_once '../Quantico'.$tmp.'.php'; use Quantico as Q;
    
    $key = file($Qdatabase.'/link.php'); $link = false;
    
    for($a=2, $u=count($key); $a<$u; $a++) { $k = explode('#',$key[$a]); if($k[0][strlen($k[0])-1] != '@') $link[$a-2] = $k[0]; } $lng = file('language/'.rtrim($dbtype[4]).'/cerca.php', FILE_IGNORE_NEW_LINES);
    if($link) { $lk = array_unique($link); sort($lk); } else exit('<br><h1 align="center">'.$lng[3].'</h1>');

?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=rtrim($dbtype[4])?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta http-equiv="Content-Language" content="<?=rtrim($dbtype[4])?>">
    <meta name="author" content="Piazzi Raffaele">
    <title>QuanticoDB</title>
    <script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="js/msgbox/msgbox.js"></script>
    <link type="text/css" rel="stylesheet" href="css/msgbox.css" />
    <link type="text/css" rel="stylesheet" href="css/style.css" />
    <link rel="shortcut icon" href="images/favicon.ico" />
    <script type='text/javascript'> prima = 0; oltre = 0; cerca = 0; keyp = '';
    function form() { var parole = $('#par').val(); var keyo = ''; var keyc = '';
        if(!parole) errore(1); else if(!keyp) errore(2); else {
            for(a=1; a<=oltre; a++) { var v = $('#x' + a + ':checked').val(); if(v) keyo = keyo + v + ','; }
            for(a=1; a<=cerca; a++) { var v = $('#y' + a + ':checked').val(); if(v) keyc = keyc + v + ' '; }
            if(!keyc) errore(3); else { if(keyo) { key = keyp + ' ' + keyo; l = key.length; key = key.substring(0,l-1); } else key = keyp;
                $.post("keybase.php", { type: 12, val: parole, old: key, pos: keyc }, function(msg){ if(msg == 1) $('#rst').load('temp/risultato.php'); });
            }
        }
    }
    function key(x) { keyv = $('#kp' + prima).text(); $('#kp' + prima).text(keyv); prima = x; keyp = $('#kp' + x).text(); $('#kp' + x).html('<font color="#F00"><b>' + keyp + '</b></font>');
        $.post("keyline.php", { id: 'k', pos: 'p', key: keyp }, function(msg){ if(msg) { $('#kpo').html(''); str = msg.split('§'); oltre = str[1]; cerca = str[2]; $('#kpo').html(str[0]); keyp = keyp + '(0)'; } else errore(0); });
    }
    function errore(x) {
        if(x == 0) msg ="<?=$lng[4]?>";
        else if(x == 1) msg ="<?=$lng[5]?>";
        else if(x == 2) msg ="<?=$lng[6]?>";
        else if(x == 3) msg ="<?=$lng[7]?>";
	    $.msgBox({ type: "error", title: "QuanticoDB", content: msg, buttons: [{ value: "Ok" }]});
	}
	function pls() { $('#rst').html(''); }
    </script> 
</head>
<body>
<div align="center">
<table border="0" width="780" cellspacing="0" cellpadding="0">
	<tr><td width="470" height="50" valign="bottom"><h6><i><?=$lng[8]?>&nbsp;&nbsp;--&gt;&nbsp;&nbsp;<a href="javascript:pls()"><?=$lng[9]?></a></i></h6></td><td width="30" rowspan="2">&nbsp;</td><td rowspan="2" valign="top">
	<table border="0" cellspacing="0" cellpadding="0"><tr><td height="50" valign="bottom" width="280" colspan="3"><h6><font color="#666"><i><?=$lng[10]?></i></font></h6></td></tr>
		<tr><td width="280" colspan="3"><input class="inp" id="par" type="text"></td></tr><tr><td width="280" colspan="3" class="td9"><h6><font color="#F00"><?=$lng[11]?></font><br><br>
        <?php
            for($a=0, $ua=count($lk); $a<$ua; $a++) { $k = explode('.',$lk[$a]); $key = rtrim($Qkeybase[$k[0]]); 
            for($b=1, $ub=count($k); $b<$ub; $b++) $key .= '.'.rtrim($Qkeybase[$k[$b]]); echo '<a href="javascript:key('.$a.')"><span id="kp'.$a.'">'.$key.'</span></a><br>'; }
        ?>
        &nbsp;</td></tr></table><div id="kpo" width="280"></div></td></tr><tr><td width="470" valign="top" bgcolor="#FAFAFA" style="border: 1px solid #F0F0F0" height="600"><div id="rst"></div></td></tr>
    </table><br><br><br>
</div>
</body>
</html>