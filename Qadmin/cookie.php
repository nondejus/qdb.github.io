<?php

    if(!isset($_COOKIE['Qdb#admin'])) { header('location: login.php'); exit; } 
    
    require_once 'dirqdb.php'; if(!file_exists($dirqdb.'Qconfig.php')) exit;
    require_once $dirqdb.'Qconfig.php';
    
    if($Qckadm != $_COOKIE['Qdb#admin'])
    {
        if(strpos($_SERVER['PHP_SELF'], 'database.php'))
            exit('<center><font face="Verdana" size="7"><br><b>REFRESH this page!</b></font></center>');
    }
    
    $dbtype = file('config.php'); $dirschema = 'schema'; $tmp = '';
    
    if($dbtype[3] == "test\n") { $Qdatabase .= '-test'; $dirschema .= '/test'; $tmp = '.test'; }
    elseif($dbtype[3] == "clone\n") { $Qdatabase .= '-clone'; $dirschema .= '/clone'; $tmp = '.clone'; }
    
    require_once 'function.php';
    
    // ******************************************
    // **** Controllo se ha completato tutto ****
    // ******************************************
    
    $filesync = $dirschema.'/sync.php'; // sincronismo del pannello admin
    if(!file_exists($filesync)) file_put_contents($filesync, $Qprotezione."*\n");
    $fs = file($filesync, FILE_IGNORE_NEW_LINES);
            
    if(!isset($fs[2])) // File Error
    {
        require_once '../class/Qerr.php';
        Qerror(5, 14, $filesync);
    }
    
    if($fs[2] != '*' || $fs[count($fs)-1] != '*')
    {
        require_once '../class/Qerr.php';
        require_once '../class/Qrec.php';
        Qrecupero($fs);
    }
    
    // ******************************************
    // ******* Tutto OK si può proseguire *******
    // ******************************************

    Qsync($Qprotezione.'*', true); // New Admin Call

?>