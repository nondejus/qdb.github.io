<?php

    if(isset($_GET['id'])) $id = $_GET['id']; else exit; 
    
    require_once 'cookie.php'; require_once '../Quantico'.$tmp.'.php'; use Quantico as Q;
    
    $key = file($Qdatabase.'/link.php'); $link = false;
    
    for($a=2; $a<count($key); $a++) { $k = explode('#',$key[$a]); if($k[0][strlen($k[0])-1] != '@') $link[$a-2] = $k[0]; } $lng = file('language/'.rtrim($dbtype[4]).'/query.php', FILE_IGNORE_NEW_LINES);
    if($link) { $lk = array_unique($link); sort($lk); } else exit('<br><h1 align="center">'.$lng[3].'</h1>');

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
    <script type='text/javascript'> prima = 0; oltre = 0; cerca = 0; keyp = '';
    function form() { var keyo = ''; var keyc = ''; var keyv = '';
        for(a=1; a<=oltre; a++) { var v = $('#x' + a + ':checked').val(); if(v) keyo = keyo + v + ','; }
        for(a=1; a<=cerca; a++) { var v = $('#p' + a).val(); if(v) { keyc = keyc + v + '|'; var v = $('#y' + a).text(); keyv = keyv + v + ' '; }}
        if(!keyc) errore(1); else { if(keyo) { key = keyp + ' ' + keyo; l = key.length; key = key.substring(0,l-1); } else key = keyp;
            $.post("keybase.php", { type: 13, val: keyv, old: key, pos: keyc }, function(msg){ if(msg == 1) $('#rst').load('temp/risultato.php'); });
        }
    }
    function key(x) { keyv = $('#kp' + prima).text(); $('#kp' + prima).text(keyv); prima = x; keyp = $('#kp' + x).text(); $('#kp' + x).html('<font color="#F00"><b>' + keyp + '</b></font>');
        $.post("keyline.php", { id: 'k', pos: 'q', key: keyp }, function(msg){ if(msg) { $('#kpo').html(''); str = msg.split('§'); oltre = str[1]; cerca = str[2]; $('#kpo').html(str[0]); keyp = keyp + '(0)'; } else errore(0); });
    }
    function errore(x) {
        if(x == 0) msg ="<?php echo $lng[4]; ?>";
        else if(x == 1) msg ="<?php echo $lng[5]; ?>";
	    $.msgBox({ type: "error", title: "QuanticoDB", content: msg, buttons: [{ value: "Ok" }]});
	}
	function pls() { $('#rst').html(''); }
    </script> 
</head>
<body>
<div align="center">
<table border="0" width="780" cellspacing="0" cellpadding="0">
	<tr><td width="470" height="50" valign="bottom"><h6><i><?php echo $lng[6]; ?>&nbsp;&nbsp;--&gt;&nbsp;&nbsp;<a href="javascript:pls()"><?php echo $lng[7]; ?></a></i></h6></td><td width="30" rowspan="2">&nbsp;</td><td rowspan="2" valign="top">
	<table border="0" cellspacing="0" cellpadding="0"><tr><td height="50" valign="bottom" width="280"></td></tr><tr><td width="280" align="center" style="border:1px solid #F0F0F0"><h6><font color="#F00"><?php echo $lng[8]; ?></font><br><br>
        <?php
            for($a=0; $a<count($lk); $a++) { $k = explode('.',$lk[$a]); $key = rtrim($keybase[$k[0]]); 
            for($b=1; $b<count($k); $b++) $key .= '.'.rtrim($keybase[$k[$b]]); echo '<a href="javascript:key('.$a.')"><span id="kp'.$a.'">'.$key.'</span></a><br>'; }
        ?>
        &nbsp;</h6></td></tr></table><div id="kpo" width="280"></div></td></tr><tr><td width="470" valign="top" bgcolor="#FAFAFA" style="border: 1px solid #F0F0F0" height="600"><div id="rst"></div></td></tr>
    </table><br><br><br>
</div>
</body>
</html>