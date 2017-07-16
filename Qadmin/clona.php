<?php

function clonaflush() { if(@ob_get_contents()) @ob_end_flush(); flush(); }
function clonatot($s,$d) { global $Qclonatot; $Qclonatot++; echo "<span style='position:absolute; left:0; right:0; top:100px; margin-left:auto; margin-right:auto; z-index:$Qclonatot; background:#FFF; color:red; font-size:128px'>$Qclonatot</span>"; clonaflush(); copy($s,$d); }
function clona($src,$dst) { $dir = opendir($src); @mkdir($dst); while(false !== ($file = readdir($dir))) { if($file != '.' && $file != '..') { $s = $src.'/'.$file; $d = $dst.'/'.$file; if(is_dir($s)) clona($s,$d); else { if(file_exists($d)) { if(md5_file($s) != md5_file($d)) clonatot($s,$d); } else clonatot($s,$d); }}} closedir($dir); } 

?>