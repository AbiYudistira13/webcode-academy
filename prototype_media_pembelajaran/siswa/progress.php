<?php

session_start();

if(!isset($_SESSION['id_user'])){
    header("Location:../login.php");
    exit();
}

include "../config/koneksi.php";

$id_user = $_SESSION['id_user'];

/* DATA POIN */

$poin = mysqli_query($conn,
"SELECT * FROM poin
WHERE id_user='$id_user'");

$data = mysqli_fetch_assoc($poin);

if(!$data){
    $data = [
        'jumlah_poin' => 0,
        'badge' => 'Pemula',
        'level_user' => 'Level 1'
    ];
}

/* HITUNG PROGRESS */

$totalMateri = mysqli_num_rows(
mysqli_query($conn,
"SELECT * FROM materi")
);

$materiSelesai = mysqli_num_rows(
mysqli_query($conn,
"SELECT * FROM progress_belajar
WHERE id_user='$id_user'")
);

$overall = 0;

if($totalMateri > 0){
    $overall = round(
        ($materiSelesai / $totalMateri) * 100
    );
}

/* HTML */

$html = mysqli_num_rows(

mysqli_query($conn,

"SELECT *

FROM progress_belajar

WHERE id_user='$id_user'

AND id_materi=1")

) > 0 ? 100 : 0;

/* CSS */

$css = mysqli_num_rows(

mysqli_query($conn,

"SELECT *

FROM progress_belajar

WHERE id_user='$id_user'

AND id_materi=2")

) > 0 ? 100 : 0;

/* JS */

$js = mysqli_num_rows(

mysqli_query($conn,

"SELECT *

FROM progress_belajar

WHERE id_user='$id_user'

AND id_materi=3")

) > 0 ? 100 : 0;

?>

<!DOCTYPE html>
<html>
<head>

<title>Progress Belajar</title>

<link rel="stylesheet" href="../css/style.css">

<style>

.progress-card{
background:white;
padding:25px;
border-radius:15px;
box-shadow:0 4px 15px rgba(0,0,0,.08);
margin-bottom:20px;
}

.progress-header{
background:linear-gradient(135deg,#1976d2,#42a5f5);
color:white;
padding:30px;
border-radius:20px;
margin-bottom:25px;
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
background:linear-gradient(135deg,#1976d2,#42a5f5);
}

.stat-grid{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(200px,1fr));
gap:20px;
margin-bottom:25px;
}

.stat-box{
background:white;
padding:25px;
text-align:center;
border-radius:15px;
box-shadow:0 4px 15px rgba(0,0,0,.08);
}

.stat-box h2{
margin:0;
color:#1976d2;
}

.overall-card{
background:white;
padding:25px;
border-radius:15px;
box-shadow:0 4px 15px rgba(0,0,0,.08);
margin-bottom:25px;
}

.back-btn{
display:inline-block;
padding:12px 25px;
background:#1976d2;
color:white;
text-decoration:none;
border-radius:10px;
margin-top:10px;
}

</style>

</head>

<body>

<div class="container">

<div class="progress-header">

<h1>📈 Progress Belajar</h1>

<p>
Pantau perkembangan pembelajaran Anda secara real-time.
</p>

</div>

<div class="overall-card">

<h2>🎯 Progress Keseluruhan</h2>

<div class="progress-bar">

<div
class="progress-fill"
style="width:<?php echo $overall; ?>%;">
</div>

</div>

<p>

<strong>

<?php echo $overall; ?>% Selesai

</strong>

</p>

</div>

<div class="stat-grid">

<div class="stat-box">
<h2><?php echo $data['jumlah_poin']; ?></h2>
<p>Total Poin</p>
</div>

<div class="stat-box">
<h2><?php echo $data['badge']; ?></h2>
<p>Badge</p>
</div>

<div class="stat-box">
<h2><?php echo $data['level_user']; ?></h2>
<p>Level</p>
</div>

</div>

<div class="progress-card">

<h3>📚 HTML Dasar</h3>

<div class="progress-bar">
<div class="progress-fill"
style="width:<?php echo $html; ?>%;">
</div>
</div>

<p><?php echo $html; ?>% Selesai</p>

</div>

<div class="progress-card">

<h3>🎨 CSS Dasar</h3>

<div class="progress-bar">
<div class="progress-fill"
style="width:<?php echo $css; ?>%;">
</div>
</div>

<p><?php echo $css; ?>% Selesai</p>

</div>

<div class="progress-card">

<h3>⚡ JavaScript Dasar</h3>

<div class="progress-bar">
<div class="progress-fill"
style="width:<?php echo $js; ?>%;">
</div>
</div>

<p><?php echo $js; ?>% Selesai</p>

</div>

<a
class="back-btn"
href="dashboard.php">

← Kembali ke Dashboard

</a>

</div>

</body>
</html>