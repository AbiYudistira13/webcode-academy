<?php

session_start();

if(!isset($_SESSION['role'])){
    header("Location:../login.php");
    exit();
}

if($_SESSION['role'] != 'admin'){
    header("Location:../login.php");
    exit();
}

include "../config/koneksi.php";

$id_user = $_SESSION['id_user'];

$guru = mysqli_query($conn,
"SELECT * FROM users
WHERE id_user='$id_user'");

$data_guru = mysqli_fetch_assoc($guru);

/* ===========================
   STATISTIK DASHBOARD
=========================== */

$total_siswa = mysqli_fetch_assoc(
mysqli_query($conn,
"SELECT COUNT(*) as total
FROM users
WHERE role='siswa'")
);

$total_materi = mysqli_fetch_assoc(
mysqli_query($conn,
"SELECT COUNT(*) as total
FROM materi")
);

$total_kuis = mysqli_fetch_assoc(
mysqli_query($conn,
"SELECT COUNT(*) as total
FROM kuis")
);

$total_poin = mysqli_fetch_assoc(
mysqli_query($conn,
"SELECT SUM(jumlah_poin) as total
FROM poin")
);

/* ===========================
   PROGRESS MATERI
=========================== */

$html_progress = mysqli_num_rows(
mysqli_query($conn,
"SELECT pb.*
FROM progress_belajar pb
JOIN materi m
ON pb.id_materi = m.id_materi
WHERE m.kategori='HTML'")
);

$css_progress = mysqli_num_rows(
mysqli_query($conn,
"SELECT pb.*
FROM progress_belajar pb
JOIN materi m
ON pb.id_materi = m.id_materi
WHERE m.kategori='CSS'")
);

$js_progress = mysqli_num_rows(
mysqli_query($conn,
"SELECT pb.*
FROM progress_belajar pb
JOIN materi m
ON pb.id_materi = m.id_materi
WHERE m.kategori='JAVASCRIPT'")
);

$total_progress =
$html_progress +
$css_progress +
$js_progress;

if($total_progress == 0){

$html_percent = 0;
$css_percent = 0;
$js_percent = 0;

}else{

$html_percent =
round(($html_progress/$total_progress)*100);

$css_percent =
round(($css_progress/$total_progress)*100);

$js_percent =
round(($js_progress/$total_progress)*100);

}

/* ===========================
   TOP SISWA
=========================== */

$ranking = mysqli_query($conn,

"SELECT
users.nama,
poin.jumlah_poin

FROM users

JOIN poin
ON users.id_user = poin.id_user

WHERE users.role='siswa'

ORDER BY poin.jumlah_poin DESC

LIMIT 5");

?>

<!DOCTYPE html>
<html>
<head>

<title>Dashboard Guru</title>

<link rel="stylesheet"
href="../css/style.css">

<style>

.dashboard-hero{

background:linear-gradient(
135deg,
#1976d2,
#42a5f5
);

padding:50px;
border-radius:20px;
color:white;

margin-top:20px;
margin-bottom:30px;

box-shadow:0 8px 20px rgba(0,0,0,.1);

}

.dashboard-hero h1{
margin:0;
font-size:42px;
}

.dashboard-hero p{
font-size:18px;
margin-top:10px;
}

.stats-grid{

display:grid;

grid-template-columns:
repeat(auto-fit,minmax(220px,1fr));

gap:20px;

margin-bottom:30px;

}

.stat-card{

background:white;

padding:25px;

border-radius:15px;

box-shadow:
0 4px 15px rgba(0,0,0,.08);

text-align:center;

}

.stat-card h1{

color:#1976d2;
margin:0;

font-size:40px;

}

.stat-card p{

margin-top:10px;
color:#666;

}

.section-card{

background:white;

padding:25px;

border-radius:15px;

box-shadow:
0 4px 15px rgba(0,0,0,.08);

margin-bottom:25px;

}

.section-title{

font-size:28px;
margin-bottom:20px;

}

.progress-box{

margin-bottom:20px;

}

.progress-box label{

display:block;

margin-bottom:8px;

font-weight:bold;

}

.progress-bar{

width:100%;
height:22px;

background:#e0e0e0;

border-radius:20px;

overflow:hidden;

}

.progress-fill{

height:22px;

background:linear-gradient(
135deg,
#1976d2,
#42a5f5
);

}

.flex-grid{

display:grid;

grid-template-columns:
1fr 1fr;

gap:20px;

}

.rank-item{

display:flex;

justify-content:space-between;

padding:12px 0;

border-bottom:
1px solid #eee;

}

.rank-item:last-child{
border-bottom:none;
}

.menu-grid{

display:grid;

grid-template-columns:
repeat(auto-fit,minmax(220px,1fr));

gap:20px;

}

.menu-card{

background:white;

padding:30px;

border-radius:15px;

box-shadow:
0 4px 15px rgba(0,0,0,.08);

text-decoration:none;

color:#333;

transition:.3s;

}

.menu-card:hover{

transform:translateY(-5px);

}

.menu-card h3{

margin-bottom:10px;

color:#1976d2;

}

.profile-box{

display:flex;

align-items:center;

gap:20px;

}

.profile-image{

width:90px;
height:90px;

border-radius:50%;

object-fit:cover;

border:4px solid #1976d2;

}

@media(max-width:900px){

.flex-grid{

grid-template-columns:1fr;

}

}

</style>

</head>

<body>

<div class="container">

<!-- HERO -->

<div class="dashboard-hero">

<h1>
📚 WebCode Academy
</h1>

<p>

Selamat Datang,
<b><?php echo $_SESSION['nama']; ?></b>

</p>

<p>

Kelola materi, kuis,
monitoring siswa,
dan evaluasi pembelajaran
melalui dashboard modern ini.

</p>

</div>

<!-- PROFIL -->

<div class="section-card">

<div class="profile-box">

<?php
if(!empty($data_guru['foto'])){
?>
<img
src="../uploads/profil/<?php echo $data_guru['foto']; ?>"
class="profile-image">
<?php
}else{
?>
<img
src="https://via.placeholder.com/150"
class="profile-image">
<?php
}
?>

<div>

<h2>
👨‍🏫 <?php echo $data_guru['nama']; ?>
</h2>

<p>
<?php echo ucfirst($data_guru['role']); ?>
</p>

</div>

</div>

</div>

<!-- STATISTIK -->

<div class="stats-grid">

<div class="stat-card">

<h1>

<?php
echo $total_siswa['total'];
?>

</h1>

<p>
👨‍🎓 Total Siswa
</p>

</div>

<div class="stat-card">

<h1>

<?php
echo $total_materi['total'];
?>

</h1>

<p>
📚 Total Materi
</p>

</div>

<div class="stat-card">

<h1>

<?php
echo $total_kuis['total'];
?>

</h1>

<p>
📝 Total Kuis
</p>

</div>

<div class="stat-card">

<h1>

<?php
echo $total_poin['total'] ?? 0;
?>

</h1>

<p>
🏆 Total Poin
</p>

</div>

</div>

<!-- PROGRESS -->

<div class="section-card">

<h2 class="section-title">
📊 Ringkasan Pembelajaran
</h2>

<div class="progress-box">

<label>
HTML (<?php echo $html_percent; ?>%)
</label>

<div class="progress-bar">

<div
class="progress-fill"
style="width:<?php echo $html_percent; ?>%;">
</div>

</div>

</div>

<div class="progress-box">

<label>
CSS (<?php echo $css_percent; ?>%)
</label>

<div class="progress-bar">

<div
class="progress-fill"
style="width:<?php echo $css_percent; ?>%;">
</div>

</div>

</div>

<div class="progress-box">

<label>
JavaScript (<?php echo $js_percent; ?>%)
</label>

<div class="progress-bar">

<div
class="progress-fill"
style="width:<?php echo $js_percent; ?>%;">
</div>

</div>

</div>

</div>

<!-- TOP SISWA -->

<div class="flex-grid">

<div class="section-card">

<h2>
🏆 Top 5 Siswa
</h2>

<?php

$no = 1;

while($r = mysqli_fetch_assoc($ranking)){

?>

<div class="rank-item">

<span>

<?php
echo $no++;
?>

.
<?php
echo $r['nama'];
?>

</span>

<b>

<?php
echo $r['jumlah_poin'];
?>

 poin

</b>

</div>

<?php
}
?>

</div>

<div class="section-card">

<h2>
📈 Aktivitas Sistem
</h2>

<p>
👨‍🎓 Total Siswa :
<b>
<?php echo $total_siswa['total']; ?>
</b>
</p>

<p>
📚 Total Materi :
<b>
<?php echo $total_materi['total']; ?>
</b>
</p>

<p>
📝 Total Kuis :
<b>
<?php echo $total_kuis['total']; ?>
</b>
</p>

<p>
🏆 Total Poin :
<b>
<?php echo $total_poin['total'] ?? 0; ?>
</b>
</p>

</div>

</div>

<!-- QUICK MENU -->

<div class="section-card">

<h2 class="section-title">
⚡ Quick Menu
</h2>

<div class="menu-grid">

<a
href="tambah_materi.php"
class="menu-card">

<h3>
📚 Kelola Materi
</h3>

<p>
Tambah dan kelola materi pembelajaran.
</p>

</a>

<a
href="tambah_kuis.php"
class="menu-card">

<h3>
📝 Kelola Kuis
</h3>

<p>
Tambah dan kelola soal kuis.
</p>

</a>

<a
href="monitoring.php"
class="menu-card">

<h3>
📊 Monitoring Siswa
</h3>

<p>
Pantau perkembangan belajar siswa.
</p>

</a>

<a
href="profil.php"
class="menu-card">

<h3>
👤 Profil Guru
</h3>

<p>
Lihat dan edit profil guru.
</p>

</a>

<a
href="../logout.php"
class="menu-card">

<h3>
🚪 Logout
</h3>

<p>
Keluar dari sistem.
</p>

</a>

</div>

</div>

</div>

</body>
</html>