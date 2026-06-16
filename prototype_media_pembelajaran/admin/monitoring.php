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

/* Statistik */

$total_siswa = mysqli_fetch_assoc(
mysqli_query($conn,
"SELECT COUNT(*) as total
FROM users
WHERE role='siswa'")
);

$total_poin = mysqli_fetch_assoc(
mysqli_query($conn,
"SELECT SUM(jumlah_poin) as total
FROM poin")
);

$badge_hebat = mysqli_fetch_assoc(
mysqli_query($conn,
"SELECT COUNT(*) as total
FROM poin
WHERE badge='Hebat'")
);

/* Data siswa */

$data = mysqli_query($conn,

"SELECT

users.id_user,
users.nama,

poin.jumlah_poin,
poin.badge,
poin.level_user

FROM users

LEFT JOIN poin
ON users.id_user = poin.id_user

WHERE users.role='siswa'

ORDER BY poin.jumlah_poin DESC");

?>

<!DOCTYPE html>
<html>
<head>

<title>Monitoring Siswa</title>

<link rel="stylesheet"
href="../css/style.css">

<style>

.container{
width:90%;
margin:auto;
padding:20px;
}

.monitor-header{
background:linear-gradient(
135deg,
#1976d2,
#42a5f5
);
color:white;
padding:40px;
border-radius:20px;
margin-bottom:30px;
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
box-shadow:0 4px 15px rgba(0,0,0,.08);
text-align:center;
}

.stat-card h1{
color:#1976d2;
margin-bottom:10px;
}

.table-card{
background:white;
padding:25px;
border-radius:15px;
box-shadow:0 4px 15px rgba(0,0,0,.08);
overflow-x:auto;
}

table{
width:100%;
border-collapse:collapse;
}

th{
background:#1976d2;
color:white;
padding:12px;
}

td{
padding:12px;
text-align:center;
border-bottom:1px solid #eee;
}

.progress-bar{
width:100%;
height:18px;
background:#e0e0e0;
border-radius:20px;
overflow:hidden;
}

.progress-fill{
height:18px;
background:linear-gradient(
135deg,
#1976d2,
#42a5f5
);
}

.status-selesai{
color:green;
font-weight:bold;
font-size:18px;
}

.status-belum{
color:red;
font-weight:bold;
font-size:18px;
}

.badge-hebat{
background:#4caf50;
color:white;
padding:5px 10px;
border-radius:20px;
}

.badge-aktif{
background:#ff9800;
color:white;
padding:5px 10px;
border-radius:20px;
}

.badge-pemula{
background:#9e9e9e;
color:white;
padding:5px 10px;
border-radius:20px;
}

.btn-kembali{
display:inline-block;
margin-top:25px;
padding:12px 25px;
background:#1976d2;
color:white;
text-decoration:none;
border-radius:10px;
}

body{
background:#f4f6f9;
font-family:'Poppins',sans-serif;
}

</style>

</head>

<body>

<div class="container">

<div class="monitor-header">

<h1>
📊 Monitoring Pembelajaran Siswa
</h1>

<p>
Pantau aktivitas dan perkembangan belajar siswa secara real-time.
</p>

</div>

<div class="stats-grid">

<div class="stat-card">
<h1><?php echo $total_siswa['total']; ?></h1>
<p>Total Siswa</p>
</div>

<div class="stat-card">
<h1><?php echo $total_poin['total'] ?? 0; ?></h1>
<p>Total Poin</p>
</div>

<div class="stat-card">
<h1><?php echo $badge_hebat['total']; ?></h1>
<p>Badge Hebat</p>
</div>

</div>

<div class="table-card">

<h2>
🏆 Monitoring Detail Siswa
</h2>

<br>

<table>

<tr>

<th>Rank</th>
<th>Nama</th>

<th>HTML</th>
<th>CSS</th>
<th>JS</th>

<th>Progress</th>

<th>Poin</th>
<th>Badge</th>
<th>Level</th>

</tr>

<?php

$rank = 1;

while($d = mysqli_fetch_assoc($data)){

$id_user = $d['id_user'];

$html = 0;
$css = 0;
$js = 0;

/* Ambil progress siswa */

$progress_siswa = mysqli_query($conn,

"SELECT id_materi
FROM progress_belajar
WHERE id_user='$id_user'");

while($p = mysqli_fetch_assoc($progress_siswa)){

if($p['id_materi'] == 1){
$html = 1;
}

if($p['id_materi'] == 2){
$css = 1;
}

if($p['id_materi'] == 3){
$js = 1;
}

}

$html_status = ($html == 1);
$css_status = ($css == 1);
$js_status = ($js == 1);

$progress = 0;

if($html_status){
$progress += 33;
}

if($css_status){
$progress += 33;
}

if($js_status){
$progress += 34;
}

?>

<tr>

<td>
<?php echo $rank++; ?>
</td>

<td>
<?php echo $d['nama']; ?>
</td>

<td>

<?php
echo $html_status
? "<span class='status-selesai'>✔</span>"
: "<span class='status-belum'>✘</span>";
?>

</td>

<td>

<?php
echo $css_status
? "<span class='status-selesai'>✔</span>"
: "<span class='status-belum'>✘</span>";
?>

</td>

<td>

<?php
echo $js_status
? "<span class='status-selesai'>✔</span>"
: "<span class='status-belum'>✘</span>";
?>

</td>

<td style="width:180px;">

<div class="progress-bar">

<div
class="progress-fill"
style="width:<?php echo $progress; ?>%;">
</div>

</div>

<br>

<b>
<?php echo $progress; ?>%
</b>

</td>

<td>
<?php echo $d['jumlah_poin'] ?? 0; ?>
</td>

<td>

<?php

$badge = $d['badge'] ?? 'Pemula';

if($badge=="Hebat"){

echo "<span class='badge-hebat'>Hebat</span>";

}
elseif($badge=="Aktif"){

echo "<span class='badge-aktif'>Aktif</span>";

}
else{

echo "<span class='badge-pemula'>Pemula</span>";

}

?>

</td>

<td>
<?php echo $d['level_user'] ?? 'Level 1'; ?>
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