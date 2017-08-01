<?php if(!isset($_GET['type'])) exit; require_once 'cookie.php'; $lng = file('language/'.rtrim($dbtype[4]).'/clone.php', FILE_IGNORE_NEW_LINES); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo rtrim($dbtype[4]); ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta http-equiv="Content-Language" content="<?php echo rtrim($dbtype[4]); ?>">
    <meta name="author" content="Piazzi Raffaele">
    <title>QuanticoDB</title>
    <link type="text/css" rel="stylesheet" href="css/style.css" />
    <link rel="shortcut icon" href="images/favicon.ico" />
    <script type='text/javascript'>
        function clona(x) { location.href = 'clone.php?type=' + x; }
    </script>
</head>
<body background="images/dbclone.jpg"><br><br><table align="center" border="0" width="440" cellspacing="0" cellpadding="0">
<?php

    if($_GET['type'] == 0) { // --------------------------------------------- domanda clonazione
        echo "<tr><td align='center'>".$lng[3]."<br><br> ".$lng[4].":<br>".$lng[5].'<br><br><font color="red"><b>'.$lng[6].'</b></font></td></tr><tr><td align="center" height="100"><input type="submit" style="width:260px; height:50px" value="'.$lng[7].'" onclick="javscript:clona(2)">';
    }
    elseif($_GET['type'] == 1) { // ----------------------------------------- verifica clonazione
        if(file_exists($Qdatabase.'-clone/clone.php')) { $cnf = file($Qdatabase.'-clone/clone.php'); $fine = gmdate("d M Y H:i:s", rtrim($cnf[3]));
            echo "<tr><td align='center'>".$lng[8].":<br><font size='5'><b>".$fine.'</b></font></td></tr><tr><td align="center" height="180"><input type="submit" style="width:260px; height:50px" value="'.$lng[9].'" onclick="javscript:clona(3)"><br><br><input type="submit" style="width:260px; height:50px" value="'.$lng[10].'" onclick="javscript:clona(0)">';
        } else {
            header('Location: clone.php?type=0'); exit;
        }
    } 
    elseif($_GET['type'] == 2) { // ----------------------------------------- inizio clonazione
        echo '<tr><td align="center"><font size="6"><b>'.$lng[11].'</b></font></td></tr></table>'; $inizio = strtotime(gmdate("M d Y H:i:s", time())) + $Qgmt; $Qclonatot = 0; require_once 'clona.php'; clona($Qdatabase,$Qdatabase.'-clone'); $fine = strtotime(gmdate("M d Y H:i:s", time())) + $Qgmt;
        if($Qclonatot) { $Qclonatot++; 
        
            $cnf = file('../Quantico.php'); 
            $cnf[2] = str_replace('Qmaintenance);','Qmaintenance); $Qdatabase .= \'-clone\';',$cnf[2]); 
            $dbtype[3] = "clone\n";
            
            copy('schema/command.php','schema/clone/command.php'); 
            copy('schema/note.php','schema/clone/note.php'); 
            copy('schema/key.php','schema/clone/key.php'); 
            for($a=1; $a<8; $a++) copy("schema/$a.php","schema/clone/$a.php"); 
            
            file_put_contents($Qdatabase.'-clone/clone.php',$Qprotezione.$inizio."\n".$fine."\n"); 
            file_put_contents('../Quantico.clone.php',$cnf); 
            file_put_contents('config.php',$dbtype);
            
            echo "<span style='position:absolute; left:0; top:100px; z-index:$Qclonatot; background:#FFF; color:red; font-size:128px'><font size='6'><b>&emsp;&emsp;".$lng[12]."<br>&emsp;&emsp;&emsp;&emsp;".$lng[13]."</b></font><font size='4' color='blue'><br><br><br>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&ensp; <u>".$lng[14]."</u></font></span>";
        } else {
            echo "<span style='position:absolute; left:0; top:100px; z-index:$Qclonatot; background:#FFF; color:red; font-size:128px'><font size='6'><b>&emsp;".$lng[15]."</b></font><font size='4' color='blue'><br><br><br>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&ensp; <u>".$lng[14]."</u></font></span>";
        } exit;
    }
    elseif($_GET['type'] == 3) { // ----------------------------------------- usa il database clonato
        $dbtype[3] = "clone\n"; file_put_contents('config.php',$dbtype); echo '<tr><td align="center"><br><font color="blue"><u>'.$lng[14].'</u></font>';
    } echo '</td></tr></table>';
?>
</body>
</html>