<?php

session_start();

if(!isset($_SESSION['role'])){

header("Location:../login.php");
exit();

}

include "../config/koneksi.php";

if(isset($_POST['simpan'])){

$judul = $_POST['judul'];
$kategori = $_POST['kategori'];
$isi = $_POST['isi_materi'];
$video = $_POST['video'];

mysqli_query($conn,

"INSERT INTO materi
(
judul,
kategori,
isi_materi,
video
)

VALUES
(
'$judul',
'$kategori',
'$isi',
'$video'
)");

echo "<script>
alert('Materi berhasil ditambahkan');
window.location='tambah_materi.php';
</script>";

}

$html = mysqli_fetch_assoc(
mysqli_query($conn,
"SELECT COUNT(*) as total
FROM materi
WHERE kategori='HTML'")
);

$css = mysqli_fetch_assoc(
mysqli_query($conn,
"SELECT COUNT(*) as total
FROM materi
WHERE kategori='CSS'")
);

$js = mysqli_fetch_assoc(
mysqli_query($conn,
"SELECT COUNT(*) as total
FROM materi
WHERE kategori='JAVASCRIPT'")
);

$data = mysqli_query($conn,
"SELECT * FROM materi
ORDER BY id_materi DESC");

?>

<!DOCTYPE html>
<html>
<head>

<title>Kelola Materi</title>

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

border:1px solid #ddd;

border-radius:10px;

margin-top:10px;
margin-bottom:15px;

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

.btn-kembali{

display:inline-block;

margin-top:20px;

background:#1976d2;

color:white;

padding:12px 25px;

border-radius:10px;

text-decoration:none;

}

</style>

</head>

<body>

<div class="container">

<div class="header-admin">

<h1>📚 Kelola Materi</h1>

<p>
Tambah, edit, dan kelola materi pembelajaran.
</p>

</div>

<div class="stats-grid">

<div class="stat-card">

<h1>
<?php echo $html['total']; ?>
</h1>

<p>Materi HTML</p>

</div>

<div class="stat-card">

<h1>
<?php echo $css['total']; ?>
</h1>

<p>Materi CSS</p>

</div>

<div class="stat-card">

<h1>
<?php echo $js['total']; ?>
</h1>

<p>Materi JavaScript</p>

</div>

</div>

<div class="form-card">

<h2>➕ Tambah Materi Baru</h2>

<form method="POST">

<input
type="text"
name="judul"
placeholder="Judul Materi"
required>

<select name="kategori">

<option value="HTML">HTML</option>
<option value="CSS">CSS</option>
<option value="JAVASCRIPT">JAVASCRIPT</option>

</select>

<textarea
name="isi_materi"
rows="8"
placeholder="Isi Materi"
required></textarea>

<input
type="text"
name="video"
placeholder="Link Video YouTube">

<button
type="submit"
name="simpan"
class="btn-simpan">

Simpan Materi

</button>

</form>

</div>

<div class="table-card">

<h2>📋 Daftar Materi</h2>

<table>

<tr>

<th>No</th>
<th>Judul</th>
<th>Kategori</th>
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
<?php echo $d['judul']; ?>
</td>

<td>
<?php echo $d['kategori']; ?>
</td>

<td>

<a
href="edit_materi.php?id=<?php echo $d['id_materi']; ?>">

✏ Edit

</a>

|

<a
href="hapus_materi.php?id=<?php echo $d['id_materi']; ?>"
onclick="return confirm('Hapus materi ini?')">

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