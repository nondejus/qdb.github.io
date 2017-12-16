<?php 

    $x = explode('/',__DIR__); $dirqdb = $x[0]; 
    
    for($a=1, $n=count($x)-3; $a<$n; $a++){ 
        if(is_dir("$dirqdb/QDB")) break; else $dirqdb .= '/'.$x[$a]; 
    } $tmp = $dirqdb;
    
    for($b=$a, $n=count($x)-1; $b<$n; $b++){ 
        if(is_dir("$tmp/QDB")) { $dirqdb = $tmp; $a = $b; break; } else $tmp .= '/'.$x[$b]; 
    } $dirqdb .= '/QDB/';
    
    for($n=$a, $u=count($x)-1; $n<$u; $n++) $dirqdb .= '-'.$x[$n].'/';
     
?>