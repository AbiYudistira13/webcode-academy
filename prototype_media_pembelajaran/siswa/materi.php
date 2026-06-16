<?php

include "../config/koneksi.php";

session_start();

$id_user = $_SESSION['id_user'];

$kategori = $_GET['kategori'] ?? '';

if($kategori == ''){

echo "Kategori belum dipilih";

exit;

}

$data = mysqli_query($conn,

"SELECT *
FROM materi

WHERE kategori='$kategori'");

?>

<!DOCTYPE html>
<html>
<head>

<title>Materi</title>

<link rel="stylesheet"
href="../css/style.css">

</head>

<body>

<div class="container">

<div class="section">

<h1>

📚 Materi Pengenalan

<?php echo $kategori; ?>

</h1>

<?php

while($d = mysqli_fetch_assoc($data)){

$id_materi = $d['id_materi'];

$cek = mysqli_query($conn,

"SELECT *

FROM progress_belajar

WHERE id_user='$id_user'

AND id_materi='$id_materi'");

if(mysqli_num_rows($cek)==0){

mysqli_query($conn,

"INSERT INTO progress_belajar
(
id_user,
id_materi,
status
)

VALUES
(
'$id_user',
'$id_materi',
'selesai'
)");

}

?>

<div class="materi-card">

<div class="materi-kategori">

📂 <?php echo $d['kategori']; ?>

</div>

<h2 class="materi-judul">

<?php echo $d['judul']; ?>

</h2>

<div class="materi-isi">

<?php echo nl2br($d['isi_materi']); ?>

</div>

<?php

if(!empty($d['video'])){

$link = $d['video'];

parse_str(
parse_url($link, PHP_URL_QUERY),
$params
);

$video_id = $params['v'] ?? '';

if(empty($video_id)){

$video_id =
basename(parse_url($link, PHP_URL_PATH));

}

?>

<br><br>

<h3>

🎥 Video Pembelajaran

</h3>

<div class="video-container">

<iframe
width="100%"
height="400"
src="https://www.youtube.com/embed/<?php echo $video_id; ?>"
frameborder="0"
allowfullscreen>

</iframe>

</div>

<?php
}
?>

<br><br>

<a
class="btn"
href="kuis.php?kategori=<?php echo $kategori; ?>">

📝 Kerjakan Kuis

</a>

</div>

<?php
}
?>

<a
class="btn"
href="dashboard.php">

Kembali

</a>

</div>

</div>

</body>
</html>