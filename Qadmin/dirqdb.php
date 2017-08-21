<?php 

    $x = explode('/',$_SERVER['SCRIPT_FILENAME']); array_pop($x); array_pop($x); $u = count($x);
     
    if($x[1] == 'var')
    {
        $dirqdb = '/'.$x[1].'/qdb/'; if(!isset($x[3])) $x[3] = ''; 
        for($a=3; $a<$u; $a++) $dirqdb .= '-'.$x[$a].'/'; 
    } 
    else 
    {
        $dirqdb = '/'.$x[1].'/'.$x[2].'/qdb/'; if(!isset($x[4])) $x[4] = ''; 
        for($a=4; $a<$u; $a++) $dirqdb .= '-'.$x[$a].'/';
    }
    
?>