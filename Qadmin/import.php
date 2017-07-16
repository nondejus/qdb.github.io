<?php

    require_once('cookie.php');
    
    $cartella = 'backup/framework/';
    $percorso = $_FILES['backup']['tmp_name'];
    $nome = $_FILES['backup']['name'];
    move_uploaded_file($percorso, $cartella.$nome);
    header('location: importa.php?id='.rawurlencode($_GET['id']));

?>