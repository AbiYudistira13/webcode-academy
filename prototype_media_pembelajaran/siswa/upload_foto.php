<?php

include "../config/koneksi.php";

$id_user = 2;

$nama_file = $_FILES['foto']['name'];
$tmp = $_FILES['foto']['tmp_name'];

$folder = "../uploads/profil/";

move_uploaded_file(
$tmp,
$folder.$nama_file
);

mysqli_query($conn,

"UPDATE users
SET foto='$nama_file'
WHERE id_user='$id_user'");

header("Location: profil.php");

?>