<?php

session_start();

include "../config/koneksi.php";

$id = $_GET['id'];

$data = mysqli_query($conn,

"SELECT * FROM materi
WHERE id_materi='$id'");

$d = mysqli_fetch_assoc($data);

if(isset($_POST['update'])){

$judul = $_POST['judul'];
$kategori = $_POST['kategori'];
$isi = $_POST['isi_materi'];
$video = $_POST['video'];

mysqli_query($conn,

"UPDATE materi SET

judul='$judul',
kategori='$kategori',
isi_materi='$isi',
video='$video'

WHERE id_materi='$id'");

echo "<script>

alert('Materi berhasil diupdate');

window.location='tambah_materi.php';

</script>";

}

?>

<!DOCTYPE html>
<html>
<head>

<title>Edit Materi</title>

<link rel="stylesheet"
href="../css/style.css">

</head>

<body>

<div class="container">

<div class="form-card">

<h1>✏ Edit Materi</h1>

<form method="POST">

<input
type="text"
name="judul"
value="<?php echo $d['judul']; ?>"
required>

<br><br>

<select name="kategori">

<option
<?php if($d['kategori']=="HTML") echo "selected"; ?>>
HTML
</option>

<option
<?php if($d['kategori']=="CSS") echo "selected"; ?>>
CSS
</option>

<option
<?php if($d['kategori']=="JAVASCRIPT") echo "selected"; ?>>
JAVASCRIPT
</option>

</select>

<br><br>

<textarea
name="isi_materi"
rows="10"><?php echo $d['isi_materi']; ?></textarea>

<br><br>

<input
type="text"
name="video"
value="<?php echo $d['video']; ?>">

<br><br>

<button
type="submit"
name="update">

Update Materi

</button>

</form>

</div>

</div>

</body>
</html>