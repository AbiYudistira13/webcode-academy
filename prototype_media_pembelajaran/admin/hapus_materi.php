<?php

include "../config/koneksi.php";

$id = $_GET['id'];

mysqli_query($conn,

"DELETE FROM materi
WHERE id_materi='$id'");

header("Location:tambah_materi.php");

?>