<?php

include "../config/koneksi.php";

$id = $_GET['id'];

mysqli_query($conn,

"DELETE FROM kuis
WHERE id_kuis='$id'");

header("Location:tambah_kuis.php");

?>