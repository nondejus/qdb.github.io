<?php

    function creation($dir){ if(file_exists($dir)){ $fx = file($dir); if(count($fx) > 10) return true; }
        if(file_put_contents($dir, "<?php\ndate_default_timezone_set(\"Europe/London\"); setlocale(LC_ALL,\"en_GB.utf8\");\n".'$Qsito = '."'https://quanticodb.com/';\n".'$Qprotezione = "<?php header(\'Location: $Qsito\'); exit; ?>\n<html><head><META HTTP-EQUIV=REFRESH CONTENT=\'0; URL=$Qsito\'><script type=\'text/javascript\'>location.href = \'$Qsito\';</script></head></html>\n";'."\n?>")){
            $fx = file('../Quantico.php'); $fx[2] = "namespace Quantico; require_once '$dir'; if(".'$Qmaintenance'.") return array('maintenance' => ".'$Qmaintenance'."); ini_set('display_errors', 1); error_reporting(E_ALL); /* ini_set & error_reporting (can remove) */ mb_internal_encoding('UTF-8'); mb_http_output('UTF-8'); require_once 'class/Qsys.php'; require_once 'class/Qfx.php';\n"; 
            file_put_contents('../Quantico.php', $fx); return true;
        } return false;
    } $success = "success'>Ok</td>"; $warning = "warning'>Warning</td>"; $alert = "warning'>Alert</td>"; $error = "error'>Error</td>"; $td = "<td class='wd80 ht36 brt"; $ok = 0; $esiste = true;
    
?>
<!DOCTYPE html>
<meta charset="utf-8">
<title>QuanticoDB System Check</title>
<link rel="stylesheet" href="css/index.css">
<head>
    <script>
        function check(){ location.reload(true); }
        function next(){ location.href = 'setup.php'; }
    </script>
</head>
<body style="font-family:Arial; color:rgb(64,64,64)">
<table cellpadding="0" cellspacing="0" align="center" style="width:500px; margin-top:10px">
	<tr>
		<td colspan="4" style="width:500px; height:120px"><img src="images/Qdb_check.png"></td>
	</tr>
	<tr>
		<td rowspan="20" style="width:75px">&nbsp;</td>
		<td colspan="3" style="height:50px"><h2>System check</h2></td>
	</tr>
	<tr>
		<td rowspan="19" style="width: 15px">&nbsp;</td>
		<td class="wd330 ht36 brt">PHP version &gt;= 5.6</td>
        <?php if(substr(phpversion(),0,3) < 5.6) { echo "$td $error"; $ok++; } else echo "$td $success"; ?>
	</tr>
    	<tr>
		<td class="wd330 ht36 brt">PHP mbstring</td>
		<?php if(get_extension_funcs('mbstring') === false) { echo "$td $error"; $ok++; } else echo "$td $success"; ?>
	</tr>
    <tr>
		<td class="wd330 ht36 brt">PHP openssl</td>
		<?php if(get_extension_funcs('openssl') === false) { echo "$td $error"; $ok++; } else echo "$td $success"; ?>
	</tr>
	<tr>
		<td class="wd330 ht36 brt">PHP session</td>
        <?php if(get_extension_funcs('session') === false) { echo "$td $warning"; $ok++; } else echo "$td $success"; ?>
	</tr>
    <tr>
		<td class="wd330 ht36 brt">PHP hash</td>
		<?php if(get_extension_funcs('hash') === false) { echo "$td $error"; $ok++; } else echo "$td $success"; ?>
	</tr>
    <tr>
		<td class="wd330 ht36 brt">PHP date</td>
		<?php if(get_extension_funcs('date') === false) { echo "$td $error"; $ok++; } else echo "$td $success"; ?>
	</tr>
    <tr>
		<td class="wd330 ht36 brt">PHP json</td>
		<?php if(get_extension_funcs('json') === false) { echo "$td $error"; $ok++; } else echo "$td $success"; ?>
	</tr>
	<tr>
		<td class="wd330 ht36 brt">PHP curl</td>
		<?php if(get_extension_funcs('curl') === false) { echo "$td $warning"; $ok++; } else echo "$td $success"; ?>
	</tr>
    <tr>
		<td class="wd330 ht36 brt">PHP xml</td>
		<?php if(get_extension_funcs('xml') === false) { echo "$td $error"; $ok++; } else echo "$td $success"; ?>
	</tr>
    <tr>
		<td class="wd330 ht36 brt">./config.php&nbsp; <font color="silver">writable</font></td>
		<?php if(!is_writable('./config.php')) { echo "$td $error"; $ok++; } else echo "$td $success"; ?>
	</tr>
    <tr>
		<td class="wd330 ht36 brt">./temp/&nbsp; <font color="silver">writable (subfolder and files)</font></td>
		<?php if(!is_writable('./temp/risultato.php')) { echo "$td $warning"; $ok++; } else echo "$td $success"; ?>
	</tr>
    <tr>
		<td class="wd330 ht36 brt">./backup/&nbsp; <font color="silver">writable (subfolder and files)</font></td>
		<?php if(!is_writable('./backup/framework/index.php')) { echo "$td $warning"; $ok++; } else echo "$td $success"; ?>
	</tr>
    <tr>
		<td class="wd330 ht36 brt">./schema/&nbsp; <font color="silver">writable (subfolder and files)</font></td>
		<?php if(!is_writable('./schema/1.php')) { echo "$td $error"; $ok++; } else echo "$td $success"; ?>
	</tr>
    <tr>
		<td class="wd330 ht36 brt">../../QDB/&nbsp; <font color="silver">create (obbligatory permits: 6777)</td>
        <?php
            
            $x = explode('/', __DIR__); $u=count($x)-1; $dir = $x[0]; 
            for($a=1, $n=count($x)-3; $a<$n; $a++){ if(is_dir("$dir/QDB")) break; else $dir .= '/'.$x[$a]; } $tmp = $dir;
            for($b=$a, $n=count($x)-1; $b<$n; $b++){ if(is_dir("$tmp/QDB")) { $dir = $tmp; $a = $b; break; } else $tmp .= '/'.$x[$b]; } $dir .= '/QDB/';
            if(is_dir($dir)){ $perm = substr(sprintf("%o",fileperms($dir)),-4); if($perm > 6776) echo "$td $success"; else { echo "$td $error"; $esiste = false; $ok++; }}
            else { if(mkdir($dir, 6777)) echo "$td $success"; else { echo "$td $error"; $esiste = false; $ok++; }}
            
        ?>
	</tr>
	<tr>
		<td class="wd330 ht36 brt">../../QDB/&nbsp; <font color="silver">writable (subfolder and files)</font></td>
        <?php
        
            if($esiste && file_put_contents($dir.'.htaccess','Options All -Indexes')){
                for($n=$a; $n<$u; $n++) { $dir .= '-'.$x[$n].'/'; if(!is_dir($dir)) mkdir($dir); } $dir .= 'Qconfig.php';
                if(creation($dir)) { echo "$td $success"; setcookie('Qdb#admin','Setup'); } else { echo "$td $error"; $ok++; }
            } else { echo "$td $error"; $ok++; }
        
        ?>
	</tr>
    <tr>
		<td class="wd330 ht36 brt">../Quantico.php&nbsp; <font color="silver">writable</font></td>
		<?php if(!is_writable('../Quantico.php')) { echo "$td $error"; $ok++; } else echo "$td $success"; ?>
	</tr>
    <tr>
		<td class="wd330 ht36 brt">./Qadmin/&nbsp; <font color="silver">renamed</font></td>
		<?php if($x[$u] == 'Qadmin') echo "$td $alert"; else echo "$td $success"; ?>
	</tr>
	<tr>
		<td style="height:60px; text-align:right" colspan="2"><?php if($ok) echo '<a class="btn" href="javascript:check()">Check again</a>'; else echo '<a class="btn" href="javascript:next()">Next step</a>'; ?></td>
	</tr>
	<tr>
		<td style="height:30px; text-align:left; font-size:12px" colspan="2"><i><b>QuanticoDB</b> is released under the <a target="_blank" href="https://github.com/QuanticoDB/qdb.github.io/blob/master/LICENSE">MIT license</a></i></td>
	</tr>
</table>
</body>
</html>