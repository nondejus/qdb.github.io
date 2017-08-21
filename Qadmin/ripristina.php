<?php  require_once('cookie.php')?>
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
    <script type='text/javascript'>righe = 0;
        function rimuovi() {
	    	for(a=1; a<=righe; a++) $("#tab" + a).remove(); $("#tform").remove(); $("#form").remove();
	    }
	    function xrshow(x,y) {
	    	if(y == 0) { $("#x" + x).hide(); $("#r" + x).hide(); $("#k" + x).hide(); } 
	    	if(y == 1) { $("#x" + x).show(); $("#r" + x).show(); $("#k" + x).show(); }
	    }
	    function cancella(x,y) {
	    	if(y == 0) $("#x" + x).attr("src","images/x_off.bmp");
	    	if(y == 1) $("#x" + x).attr("src","images/x_on.bmp");
	    	if(y == 2) { $.msgBox({ type: "error", title: "QuanticoDB", content: "Sei sicuro di volerlo cancellare ?", buttons: [{ value: "SI" }, { value: "No" }], success: function (result) { if (result == "SI") { key = $("#keyb" + x).text(); $.post("keyline.php", { id: 'd', pos: 2, key: key }, function(msg){ if(msg == 1) location.href = 'ripristina.php'; else errore(); })}}}); }
            if(y == 3) location.href = 'ripristina.php';
        }
		function rinomina(x,y) {
	    	if(y == 0) { $("#r" + x).attr("src","images/ri_off.bmp"); $("#s" + x).attr("src","images/s_off.bmp"); }
	    	if(y == 1) { $("#r" + x).attr("src","images/ri_on.bmp"); $("#s" + x).attr("src","images/s_on.bmp"); }
	    	if(y == 2) { $.post("keyline.php", { id: 'r', pos: 2, key: x }, function(msg){ if(msg) { rimuovi(); $("#lista").append(msg); }}); }
	    	if(y == 3) { var key = $("#kbt").val(); $.post("keyline.php", { id: 'h', pos: x, key: key }, function(msg){ if(msg == 1) location.href = 'ripristina.php'; else errore(); }); }
	    }
        function attiva(x,y) {
	    	if(y == 0) $("#k" + x).attr("src","images/a_off.bmp");
	    	if(y == 1) $("#k" + x).attr("src","images/a_on.bmp");
            if(y == 2) { 
                $.msgBox({ title: "QuanticoDB", 
                    content: "Il ripristino di questo backup comporta la completa sostituzione dell'attuale DB con quello selezionato (tutti i dati verranno sostituiti). Sei sicuro di voler continuare?", 
                    buttons: [{ value: "SI" }, { value: "No" }], 
                    success: function (result) { if (result == "SI") { key = $("#keyb" + x).text(); $.post("keyline.php", { id: 'b', pos: 'k', key: key }, function(msg){ if(msg == 1) $.msgBox({ type: 'info', title: 'QuanticoDB', content: '<b>Ripristino Eseguito Correttamente !!!</b>' }); else errore(); }); }}
                }); 
            }
        }
        function validateExtension(x) {
            if(x.substring(x.length-4) == '.zip') simp.submit(); else $.msgBox({ type: 'error', title: 'QuanticoDB', content: '<b>Estensione SBAGLIATA</b> e\' consentito importare solo e soltando file <b>.zip</b>' });
        }
        function errore() {
            $.msgBox({ type: 'error', title: 'QuanticoDB', content: "<font color='#FF0000'><b>In questo momento NON e' possibile eseguire l'operazione richiesta !!!</b></font>", buttons: [{ value: 'Ok' }]});
		}
    </script> 
</head>
<body background="images/db.jpg"><div id="lista" align="center">
<?php

    function Qdirectory($dir) { $files = array_diff(scandir($dir), array('.','..')); $lista = array(); foreach ($files as $file) { (is_dir($dir.'/'.$file)) ? Qdirectory($dir.'/'.$file) : $lista[] = $file; } return $lista; }
    
    $lista = Qdirectory('backup/database'); $b = 0; echo '<br>';
    foreach($lista as $files) {
        if(substr($files, -4) == '.zip') { $b++; $nome = substr($files, 0, strlen($files)-4); echo '
            <table id="tab'.$b.'" border="0" width="230" cellspacing="0" cellpadding="0" height="35">
             <tr>
            	<td align="center" width="40"><font color="#FF0000" face="Arial" size="4"><b>'.$b.'.</b></font></td>
            	<td width="180" onmouseover="javascript:xrshow('.$b.',1)" onmouseout="javascript:xrshow('.$b.',0)"><span id="keyb'.$b.'"><h6>'.$nome.'</h6></span></td>
            	<td width="15" onmouseover="javascript:xrshow('.$b.',1)" onmouseout="javascript:xrshow('.$b.',0)"><a href="javascript:cancella('.$b.',2)"><img id="x'.$b.'" src="images/x_off.bmp" border="0" style="display: none" onmouseover="javascript:cancella('.$b.',1)" onmouseout="javascript:cancella('.$b.',0)" title="Cancella questo Backup"></a><a href="javascript:rinomina('.$b.',2)"><img id="r'.$b.'" src="images/ri_off.bmp" border="0" vspace="2" style="display: none" onmouseover="javascript:rinomina('.$b.',1)" onmouseout="javascript:rinomina('.$b.',0)" title="Rinomina questo Backup"></a><a href="javascript:attiva('.$b.',2)"><img id="k'.$b.'" src="images/a_off.bmp" border="0" style="display: none" onmouseover="javascript:attiva('.$b.',1)" onmouseout="javascript:attiva('.$b.',0)" title="Importa e Attiva questo Backup"></a></td>
             </tr>
            </table>';
        }
    } echo '<table id="tform" border="0" width="230" cellspacing="0" cellpadding="0" height="25"><tr><td>&nbsp;</td></tr></table><script type="text/javascript">righe = '.$b.';</script>';
    
?>
<form id="form" name="simp" method="post" action="restore.php" enctype="multipart/form-data"><input type="file" accept=".zip" name="backup" id="form" onchange="validateExtension(this.value)"></form>
</div>
</body>
</html>