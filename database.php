<?php
    $db = mysqli_connect('localhost','root','','webapp_kasir');

    if(!$db){
        die("ERROR: Gagal Terhubung :". mysqli_connect_error());
    }
?>