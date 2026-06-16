<?php

$host = "localhost";
$user = "root";
$pass = "";
$db   = "prototype_gamifikasi";

$conn = mysqli_connect($host,$user,$pass,$db);

if(!$conn){
    die("Koneksi gagal");
}

?>