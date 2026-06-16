<?php

include "../config/koneksi.php";

$id = $_GET['id'];

$data = mysqli_query($conn,

"SELECT * FROM kuis
WHERE id_kuis='$id'");

$d = mysqli_fetch_assoc($data);

if(isset($_POST['update'])){

mysqli_query($conn,

"UPDATE kuis SET

pertanyaan='$_POST[pertanyaan]',
pilihan_a='$_POST[a]',
pilihan_b='$_POST[b]',
pilihan_c='$_POST[c]',
pilihan_d='$_POST[d]',
jawaban_benar='$_POST[jawaban]'

WHERE id_kuis='$id'");

echo "<script>

alert('Soal berhasil diupdate');

window.location='tambah_kuis.php';

</script>";

}

?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Kuis</title>
</head>

<body>

<h1>Edit Soal</h1>

<form method="POST">

<textarea
name="pertanyaan"><?php echo $d['pertanyaan']; ?></textarea>

<br><br>

<input
type="text"
name="a"
value="<?php echo $d['pilihan_a']; ?>">

<br><br>

<input
type="text"
name="b"
value="<?php echo $d['pilihan_b']; ?>">

<br><br>

<input
type="text"
name="c"
value="<?php echo $d['pilihan_c']; ?>">

<br><br>

<input
type="text"
name="d"
value="<?php echo $d['pilihan_d']; ?>">

<br><br>

<select name="jawaban">

<option value="A">A</option>
<option value="B">B</option>
<option value="C">C</option>
<option value="D">D</option>

</select>

<br><br>

<button
type="submit"
name="update">

Update Soal

</button>

</form>

</body>
</html>