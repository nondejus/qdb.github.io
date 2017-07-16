<?php  require_once 'cookie.php'; $lng = file('language/'.rtrim($dbtype[4]).'/importa.php', FILE_IGNORE_NEW_LINES); ?>
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
    <script type='text/javascript'>righe = 0; sid = '<?php echo rawurldecode($_GET['id']); ?>';
	    function xrshow(x,y) {
	    	if(y == 0) { $("#x" + x).hide(); $("#r" + x).hide(); $("#k" + x).hide(); } 
	    	if(y == 1) { $("#x" + x).show(); $("#r" + x).show(); $("#k" + x).show(); }
	    }
	    function cancella(x,y) {
	    	if(y == 0) $("#x" + x).attr("src","images/x_off.bmp");
	    	if(y == 1) $("#x" + x).attr("src","images/x_on.bmp");
	    	if(y == 2) { $.msgBox({ type: "error", title: "QuanticoDB", content: "<?php echo $lng[3]; ?>", buttons: [{ value: "<?php echo $lng[4]; ?>" }, { value: "<?php echo $lng[5]; ?>" }], success: function (result) { if (result == "<?php echo $lng[4]; ?>") { key = $("#keyb" + x).text(); $.post("keyline.php", { id: 'd', pos: 1, key: key }, function(msg){ if(msg == 1) location.href = 'importa.php?id=<?php echo rawurlencode($_GET['id']); ?>'; else errore();})}}});}
            if(y == 3) location.href = 'importa.php?id=<?php echo rawurlencode($_GET['id']); ?>';
        }
		function rinomina(x,y) {
	    	if(y == 0) { $("#r" + x).attr("src","images/ri_off.bmp"); $("#s" + x).attr("src","images/s_off.bmp"); }
	    	if(y == 1) { $("#r" + x).attr("src","images/ri_on.bmp"); $("#s" + x).attr("src","images/s_on.bmp"); }
	    	if(y == 2) { $.post("keyline.php", { id: 'r', pos: 1, key: x }, function(msg){ if(msg) { rimuovi(); $("#lista").append(msg); }}); }
	    	if(y == 3) { var key = $("#kbt").val(); $.post("keyline.php", { id: 'f', pos: x, key: key }, function(msg){ if(msg == 1) location.href = 'importa.php?id=<?php echo rawurlencode($_GET['id']); ?>'; else errore(); }); }
	    }
        function attiva(x,y,z=0,key=false) {
	    	if(y == 0) $("#k" + x).attr("src","images/a_off.bmp");
	    	if(y == 1) $("#k" + x).attr("src","images/a_on.bmp");
            if(y == 2) { $.msgBox({ title: "QuanticoDB", 
                content: "<?php echo $lng[6]; ?>", 
                buttons: [{ value: "<?php echo $lng[4]; ?>" }, { value: "<?php echo $lng[5]; ?>" }], 
                success: function (result) { if(result == "<?php echo $lng[4]; ?>") { if(!key) key = $("#keyb" + x).text(); $.post("keyline.php", { id: 'a', pos: 't', opz: z, key: key, sid: sid }, function(msg){ if(msg == 0) errore();
                    else if(msg == 1) $.msgBox({ type: 'info', title: 'QuanticoDB', content: "<b><?php echo $lng[7]; ?></b>" }); 
                    else if(msg == 2) $.msgBox({ type: 'alert', title: 'QuanticoDB', content: "<?php echo $lng[8]; ?>" });
                    else if(msg == 3) $.msgBox({ type: 'error', title: 'QuanticoDB', content: "<?php echo $lng[9]; ?>" });
                    else { var json = JSON.parse(msg); var m = '<table class="att'+x+'" border="0" width="100%" cellspacing="0" cellpadding="0">';
                        if(json['keys']) { m += '<tr><td colspan="2" class="td9 bg8 cl1"><b><?php echo $lng[10]; ?></b></td></tr><tr><td class="td7 bg3"><b><?php echo $lng[11]; ?></b></td><td class="td7 bg3"><b><?php echo $lng[12]; ?></b></td></tr>'; for(var a=0; a<json['keys']['now'].length; a++) m += '<tr><td class="td8 bg4">'+json['keys']['now'][a]+'</td><td class="td8 bg4 cl1">'+json['keys']['next'][a]+'</td></tr>'; m += '</table>'; $("#keyb" + x).append(m); } var m = '<br class="att'+x+'"><table class="att'+x+'" border="0" width="100%" cellspacing="0" cellpadding="0">';
                        if(json['trash']) { m += '<tr><td colspan="2" class="td9 bg8 cl1"><b><?php echo $lng[13]; ?></b></td></tr><tr><td class="td7 bg3"><b><?php echo $lng[11]; ?></b></td><td class="td7 bg3"><b><?php echo $lng[12]; ?></b></td></tr>'; for(var a=0; a<json['trash']['now'].length; a++) m += '<tr><td class="td8 bg4">'+json['trash']['now'][a]+'</td><td class="td8 bg4 cl1">'+json['trash']['next'][a]+'</td></tr>'; m += '</table>'; $("#keyb" + x).append(m); } 
                        $("#keyb" + x).append('<br class="att'+x+'"><input class="att'+x+'" type="submit" style="width:100%; height:50px" value="<?php echo $lng[14]; ?>" onclick="javscript:pulisci('+x+')"><input class="att'+x+'" type="submit" style="width:100%; height:50px" value="<?php echo $lng[15]; ?>" onclick="javscript:pulisci('+x+'); javscript:attiva('+x+',2,1,\''+key+'\')"><br class="att'+x+'"><br class="att'+x+'">');
                    }});}
                }}); 
            }
        }
        function pulisci(x) { $('.att' + x).remove(); }
        function rimuovi() { for(a=1; a<=righe; a++) $("#tab" + a).remove(); $("#tform").remove(); $("#form").remove(); }
        function validateExtension(x) { if(x.substring(x.length-8) == '.Qdb.zip') simp.submit(); else $.msgBox({ type: 'error', title: 'QuanticoDB', content: '<?php echo $lng[16]; ?>' }); }
        function errore() { $.msgBox({ type: 'error', title: 'QuanticoDB', content: "<font color='#F00'><?php echo $lng[17]; ?></font>", buttons: [{ value: 'Ok' }]}); }
    </script> 
</head>
<body background="images/fw.jpg"><div id="lista" align="center">
<?php

    function Qdirectory($dir) { $files = array_diff(scandir($dir), array('.','..')); $lista = array(); foreach ($files as $file) { (is_dir($dir.'/'.$file)) ? Qdirectory($dir.'/'.$file) : $lista[] = $file; } return $lista; }
    
    $lista = Qdirectory('backup/framework'); $b = 0; echo '<br><br>';
    foreach($lista as $files) {
        if(substr($files, -8) == '.Qdb.zip') { $b++; $nome = substr($files, 0, strlen($files)-8); echo '
            <table id="tab'.$b.'" border="0" width="230" cellspacing="0" cellpadding="0" height="35">
             <tr>
            	<td class="td14">'.$b.'.</td>
            	<td width="180" onmouseover="javascript:xrshow('.$b.',1)" onmouseout="javascript:xrshow('.$b.',0)"><span id="keyb'.$b.'"><h6>'.$nome.'</h6></span></td>
            	<td width="15" valign="top" onmouseover="javascript:xrshow('.$b.',1)" onmouseout="javascript:xrshow('.$b.',0)"><a href="javascript:cancella('.$b.',2)"><img id="x'.$b.'" src="images/x_off.bmp" border="0" style="display:none" onmouseover="javascript:cancella('.$b.',1)" onmouseout="javascript:cancella('.$b.',0)" title="'.$lng[18].'"></a><a href="javascript:rinomina('.$b.',2)"><img id="r'.$b.'" src="images/ri_off.bmp" border="0" vspace="2" style="display: none" onmouseover="javascript:rinomina('.$b.',1)" onmouseout="javascript:rinomina('.$b.',0)" title="'.$lng[19].'"></a><a href="javascript:attiva('.$b.',2)"><img id="k'.$b.'" src="images/a_off.bmp" border="0" style="display: none" onmouseover="javascript:attiva('.$b.',1)" onmouseout="javascript:attiva('.$b.',0)" title="'.$lng[20].'"></a></td>
             </tr>
            </table>';
        }
    } echo '<table id="tform" border="0" width="230" cellspacing="0" cellpadding="0" height="25"><tr><td>&nbsp;</td></tr></table><script type="text/javascript">righe = '.$b.';</script>';
    
?>
<form id="form" name="simp" method="post" action="import.php?id=<?php echo rawurlencode($_GET['id']); ?>" enctype="multipart/form-data"><input type="file" accept=".Qdb.zip" name="backup" id="form" onchange="validateExtension(this.value)"></form>
</div>
</body>
</html>