<?php
    
    if(!isset($_COOKIE['Qdb#admin'])) { header('location: login.php'); exit; } require_once('dirqdb.php'); if(!file_exists($dirqdb.'Qconfig.php')) exit;
    require_once($dirqdb.'Qconfig.php'); if($Qckadm != $_COOKIE['Qdb#admin']) { if(strpos($_SERVER['PHP_SELF'], 'database.php')) echo '<center><font face="Verdana" size="7"><br><b>REFRESH this page!</b></font></center>'; exit; }

?>