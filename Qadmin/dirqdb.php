<?php 

    define ('FILESYNC', "$Qdatabase/sync.php");
    
    if(!file_exists(FILESYNC)) file_put_contents(FILESYNC, "$Qprotezione*\n");
    $x = explode('/',$_SERVER['SCRIPT_FILENAME']); array_pop($x); array_pop($x);
     
    if($x[1] == 'var')
    {
        $dirqdb = '/'.$x[1].'/qdb/';
        
        if(!isset($x[3])) $x[3] = ''; 
        
        for($a=3; $a<count($x); $a++) $dirqdb .= '-'.$x[$a].'/'; 
    } 
    else 
    {
        $dirqdb = '/'.$x[1].'/'.$x[2].'/qdb/'; 
        
        if(!isset($x[4])) $x[4] = ''; 
        
        for($a=4; $a<count($x); $a++) $dirqdb .= '-'.$x[$a].'/';
    }
    
    $dbtype = file('config.php'); 
    $dirschema = 'schema'; 
    
    if($dbtype[3] == "test\n") $dirschema .= '/test'; 
    elseif($dbtype[3] == "clone\n") $dirschema .= '/clone';

?>