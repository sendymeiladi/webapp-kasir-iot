<?php
    session_start();

    if(!$_SESSION['nama_pegawai']){
        header("Location: login.php");
    }
?>