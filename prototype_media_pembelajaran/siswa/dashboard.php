<?php

session_start();

if(!isset($_SESSION['id_user'])){

header("Location:../login.php");
exit();

}

include "../config/koneksi.php";

$id_user = $_SESSION['id_user'];
$nama = $_SESSION['nama'];

$data = mysqli_query($conn,
"SELECT * FROM poin
WHERE id_user='$id_user'");

$poin = mysqli_fetch_assoc($data);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>

    <link rel="stylesheet"
    href="../css/style.css">
</head>

<body>

<div class="hero">

<div class="container">

<div class="hero-content">

<span class="badge-hero">
🚀 Media Pembelajaran Interaktif
</span>

<h1>
WebCode Academy
</h1>

<h2>
Kuasai Pemrograman Web dengan Cara yang
Lebih Interaktif dan Menyenangkan
</h2>

<p>

Belajar Pemrograman Web melalui
materi pembelajaran, video tutorial,
kuis evaluasi, serta sistem gamifikasi
yang membantu meningkatkan motivasi belajar.

</p>

<div class="hero-button">

<a href="#"
class="btn-hero"
onclick="showBelajar(); return false;">

📚 Mulai Belajar

</a>

<a href="#"
class="btn-outline"
onclick="showProgress(); return false;">

📈 Lihat Progress

</a>

</div>

</div>

</div>

</div>

<div id="menu-belajar" style="display:none;">

<div class="container">

<div class="section">

<h2>
👋 Selamat Datang,
<?php echo $nama; ?>
</h2>

<p>

Teruskan perjalanan belajarmu dan
tingkatkan kemampuan pemrograman web
melalui materi, kuis, dan tantangan yang tersedia.

</p>

</div>

<div class="section">

<h2
onclick="toggleMateri()"
style="
cursor:pointer;
user-select:none;
">

📚 Materi Pembelajaran
<span id="iconMateri">▼</span>

</h2>

<div id="daftarMateri"
style="display:none;">

<div class="course">

<h3>HTML Dasar</h3>

<p>
Mempelajari struktur dasar halaman web menggunakan HTML.
</p>

<a class="btn"
href="materi.php?kategori=HTML">
Mulai Belajar
</a>

</div>

<div class="course">

<h3>CSS Dasar</h3>

<p>
Mempelajari cara mempercantik tampilan website.
</p>

<a class="btn"
href="materi.php?kategori=CSS">
Mulai Belajar
</a>

</div>

<div class="course">

<h3>JavaScript Dasar</h3>

<p>
Mempelajari interaksi pada halaman website.
</p>

<a class="btn"
href="materi.php?kategori=JAVASCRIPT">
Mulai Belajar
</a>

</div>

</div>

</div>

<div class="section">

<h2>🏆 Fitur Pembelajaran</h2>

<div class="feature-container">

<a href="leaderboard.php"
class="feature-card">

<h3>🏅 Leaderboard</h3>

<p>
Lihat peringkat siswa berdasarkan poin yang diperoleh.
</p>

</a>

<a href="profil.php"
class="feature-card">

<h3>👤 Profil Saya</h3>

<p>
Lihat informasi akun dan pencapaian pembelajaran.
</p>

</a>

<a href="../logout.php"
class="feature-card">

<h3>🚪 Logout</h3>

<p>
Keluar dari sistem dan kembali ke halaman login.
</p>

</a>

</div>

</div>

</div>

</div>

<div id="menu-progress" style="display:none;">

<div class="container">

<div class="section">

<h2>📈 Ringkasan Progress Belajar</h2>

<p>
Pantau perkembangan pembelajaran Anda secara keseluruhan.
</p>

<div class="progress-dashboard">

<div class="progress-info">

<h3>Progress Keseluruhan</h3>

<p>
Anda telah menyelesaikan sebagian besar materi pembelajaran.
</p>

<div class="progress-bar-modern">

<div class="progress-fill-modern"
style="width:75%;">
</div>

</div>

<p>
<strong>75% Selesai</strong>
</p>

</div>

<a class="btn"
href="progress.php">

Lihat Detail Progress

</a>

</div>

</div>

</div>

</div>

<script>

function showBelajar(){

document.getElementById("menu-belajar").style.display = "block";

document.getElementById("menu-progress").style.display = "none";

window.scrollTo({
top:700,
behavior:"smooth"
});

}

function showProgress(){

document.getElementById("menu-progress").style.display = "block";

document.getElementById("menu-belajar").style.display = "none";

window.scrollTo({
top:700,
behavior:"smooth"
});

}

function toggleMateri(){

let materi =
document.getElementById("daftarMateri");

let icon =
document.getElementById("iconMateri");

if(materi.style.display == "none"){

materi.style.display = "block";

icon.innerHTML = "▲";

}
else{

materi.style.display = "none";

icon.innerHTML = "▼";

}

}

</script>

</body>
</html>