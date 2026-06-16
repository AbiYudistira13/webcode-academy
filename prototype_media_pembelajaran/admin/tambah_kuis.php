<?php

session_start();

if(!isset($_SESSION['role'])){

header("Location:../login.php");
exit();

}

include "../config/koneksi.php";

if(isset($_POST['simpan'])){

$kategori = $_POST['kategori'];

$pertanyaan = $_POST['pertanyaan'];

$a = $_POST['a'];
$b = $_POST['b'];
$c = $_POST['c'];
$d = $_POST['d'];

$jawaban = $_POST['jawaban'];

mysqli_query($conn,

"INSERT INTO kuis
(
pertanyaan,
pilihan_a,
pilihan_b,
pilihan_c,
pilihan_d,
jawaban_benar,
skor,
kategori
)

VALUES
(
'$pertanyaan',
'$a',
'$b',
'$c',
'$d',
'$jawaban',
10,
'$kategori'
)");

echo "<script>
alert('Soal berhasil ditambahkan');
window.location='tambah_kuis.php';
</script>";

}

/* Statistik */

$html = mysqli_fetch_assoc(
mysqli_query($conn,
"SELECT COUNT(*) as total
FROM kuis
WHERE kategori='HTML'")
);

$css = mysqli_fetch_assoc(
mysqli_query($conn,
"SELECT COUNT(*) as total
FROM kuis
WHERE kategori='CSS'")
);

$js = mysqli_fetch_assoc(
mysqli_query($conn,
"SELECT COUNT(*) as total
FROM kuis
WHERE kategori='JAVASCRIPT'")
);

/* Data Soal */

$data = mysqli_query($conn,
"SELECT * FROM kuis
ORDER BY id_kuis DESC");

?>

<!DOCTYPE html>
<html>
<head>

<title>Kelola Kuis</title>

<link rel="stylesheet"
href="../css/style.css">

<style>

.header-admin{

background:linear-gradient(
135deg,
#1976d2,
#42a5f5
);

color:white;

padding:35px;

border-radius:20px;

margin-bottom:25px;

}

.stats-grid{

display:grid;

grid-template-columns:
repeat(auto-fit,minmax(220px,1fr));

gap:20px;

margin-bottom:25px;

}

.stat-card{

background:white;

padding:25px;

border-radius:15px;

text-align:center;

box-shadow:0 4px 15px rgba(0,0,0,.08);

}

.stat-card h1{

color:#1976d2;

margin-bottom:10px;

}

.form-card{

background:white;

padding:25px;

border-radius:15px;

box-shadow:0 4px 15px rgba(0,0,0,.08);

margin-bottom:25px;

}

.form-card input,
.form-card select,
.form-card textarea{

width:100%;

padding:12px;

margin-top:10px;
margin-bottom:15px;

border:1px solid #ddd;

border-radius:10px;

}

.btn-simpan{

background:#1976d2;

color:white;

border:none;

padding:12px 25px;

border-radius:10px;

cursor:pointer;

}

.table-card{

background:white;

padding:25px;

border-radius:15px;

box-shadow:0 4px 15px rgba(0,0,0,.08);

}

table{

width:100%;

border-collapse:collapse;

}

th{

background:#1976d2;

color:white;

padding:15px;

}

td{

padding:15px;

border-bottom:1px solid #eee;

}

.kategori-html{

background:#e3f2fd;

padding:6px 12px;

border-radius:20px;

color:#1976d2;

font-weight:bold;

}

.kategori-css{

background:#fff3e0;

padding:6px 12px;

border-radius:20px;

color:#ef6c00;

font-weight:bold;

}

.kategori-js{

background:#fffde7;

padding:6px 12px;

border-radius:20px;

color:#f9a825;

font-weight:bold;

}

.btn-kembali{

display:inline-block;

margin-top:20px;

padding:12px 25px;

background:#1976d2;

color:white;

text-decoration:none;

border-radius:10px;

}

</style>

</head>

<body>

<div class="container">

<div class="header-admin">

<h1>
📝 Kelola Kuis
</h1>

<p>

Tambah dan kelola soal kuis
untuk setiap materi pembelajaran.

</p>

</div>

<div class="stats-grid">

<div class="stat-card">

<h1>
<?php echo $html['total']; ?>
</h1>

<p>Soal HTML</p>

</div>

<div class="stat-card">

<h1>
<?php echo $css['total']; ?>
</h1>

<p>Soal CSS</p>

</div>

<div class="stat-card">

<h1>
<?php echo $js['total']; ?>
</h1>

<p>Soal JavaScript</p>

</div>

</div>

<div class="form-card">

<h2>➕ Tambah Soal Baru</h2>

<form method="POST">

<select name="kategori">

<option value="HTML">
HTML
</option>

<option value="CSS">
CSS
</option>

<option value="JAVASCRIPT">
JAVASCRIPT
</option>

</select>

<textarea
name="pertanyaan"
rows="4"
placeholder="Masukkan Pertanyaan"
required></textarea>

<input
type="text"
name="a"
placeholder="Pilihan A"
required>

<input
type="text"
name="b"
placeholder="Pilihan B"
required>

<input
type="text"
name="c"
placeholder="Pilihan C"
required>

<input
type="text"
name="d"
placeholder="Pilihan D"
required>

<select name="jawaban">

<option value="A">
Jawaban Benar A
</option>

<option value="B">
Jawaban Benar B
</option>

<option value="C">
Jawaban Benar C
</option>

<option value="D">
Jawaban Benar D
</option>

</select>

<button
type="submit"
name="simpan"
class="btn-simpan">

Simpan Soal

</button>

</form>

</div>

<div class="table-card">

<h2>
📋 Daftar Soal Kuis
</h2>

<table>

<tr>

<th>No</th>
<th>Kategori</th>
<th>Pertanyaan</th>
<th>Jawaban</th>
<th>Aksi</th>

</tr>

<?php

$no = 1;

while($d = mysqli_fetch_assoc($data)){

?>

<tr>

<td>
<?php echo $no++; ?>
</td>

<td>

<?php

if($d['kategori']=="HTML"){

echo "<span class='kategori-html'>HTML</span>";

}
elseif($d['kategori']=="CSS"){

echo "<span class='kategori-css'>CSS</span>";

}
else{

echo "<span class='kategori-js'>JAVASCRIPT</span>";

}

?>

</td>

<td>

<?php echo $d['pertanyaan']; ?>

</td>

<td>

<?php echo $d['jawaban_benar']; ?>

</td>

<td>

<a
href="edit_kuis.php?id=<?php echo $d['id_kuis']; ?>">

✏ Edit

</a>

|

<a
href="hapus_kuis.php?id=<?php echo $d['id_kuis']; ?>"
onclick="return confirm('Hapus soal ini?')">

🗑 Hapus

</a>

</td>

</tr>

<?php
}
?>

</table>

<a
href="dashboard.php"
class="btn-kembali">

← Kembali ke Dashboard

</a>

</div>

</div>

</body>
</html>