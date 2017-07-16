<?php

function login_error($email) { $cnf = file('config.php'); $lng = file('language/'.rtrim($cnf[4]).'/error.php',FILE_IGNORE_NEW_LINES); $link = $_SERVER['SERVER_NAME']; $u = explode('/',$_SERVER['REQUEST_URI']); for($a=0; $a<count($u)-1; $a++) $link .= $u[$a].'/';
    
    $messaggio = '<html><head><title>QuanticoDB | Alert</title></head><body>
    <div align="center"><br><table border="0" cellspacing="0" cellpadding="0" width="500" height="200"><tr><td width="200" align="left" style="border-right: 2px solid #F00">
    	<img src="http://www.quanticodb.com/images/QuanticoDB_bianco.jpg" width="180" height="200"></td><td align="center"><b><font face="Corbel" color="#F00" size="7">
    	<img src="http://www.quanticodb.com/images/no.jpg" width="125" height="100">Login<br></font>
    	<font face="Corbel" color="#F00" style="font-size: 43pt">ERROR !!!</font></b></td></tr></table><br><br>
    		<font face="Calibri" size="5" color="#333">'.gmdate("d M Y", time()).'&nbsp;&nbsp;</font><font face="Calibri" size="6" color="#F00">|</font><font face="Calibri" size="5" color="#333">&nbsp; '.gmdate("H:i:s", time()).'&nbsp; </font>
    	<font face="Calibri" size="6" color="#F00">|</font><font face="Calibri" size="5" color="#333">&nbsp; IP: '.$_SERVER['REMOTE_ADDR'].'</font><p><font face="Calibri" color="#808080" size="2">'.$lng[3].': </font><font face="Calibri" size="2" color="#333"><b>'.$link.'</b></font>
    </div></body></html>';
    
    $intestazione  = "MIME-Version: 1.0\r\n";
    $intestazione .= "Content-type: text/html; charset=iso-8859-1\r\n";
    $intestazione .= "From: QDB Alert <admin@quanticodb.com>\r\n";
    
    return mail($email, $_SERVER['SERVER_NAME'], $messaggio, $intestazione);
}

?>