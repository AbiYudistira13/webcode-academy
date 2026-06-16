<?php

include "../config/koneksi.php";

$id_user = 2;

$kategori = $_POST['kategori'] ?? '';

$soal = mysqli_query(
    $conn,
    "SELECT * FROM kuis
    WHERE kategori='$kategori'"
);

$jumlah_benar = 0;
$total_soal = 0;

?>

<!DOCTYPE html>
<html>
<head>

<title>Hasil Kuis</title>

<link rel="stylesheet"
href="../css/style.css">

<style>

.hasil-header{
    background:linear-gradient(
    135deg,
    #1976d2,
    #42a5f5
    );
    color:white;
    padding:30px;
    border-radius:15px;
    margin-bottom:20px;
}

.hasil-card{
    background:white;
    padding:25px;
    border-radius:12px;
    box-shadow:0 2px 10px rgba(0,0,0,0.1);
    margin-bottom:20px;
}

.jawaban-box{
    background:#f8f9fa;
    padding:15px;
    border-radius:10px;
    margin-top:10px;
    margin-bottom:10px;
}

.jawaban-user{
    border-left:5px solid #ff9800;
}

.jawaban-benar{
    border-left:5px solid #4caf50;
}

.benar{
    color:#28a745;
    font-weight:bold;
    margin-top:15px;
}

.salah{
    color:#dc3545;
    font-weight:bold;
    margin-top:15px;
}

.summary{
    background:white;
    padding:25px;
    border-radius:12px;
    box-shadow:0 2px 10px rgba(0,0,0,0.1);
    margin-top:20px;
}

.summary h2{
    margin-top:0;
}

.btn{
    display:inline-block;
    margin-top:15px;
    padding:12px 25px;
    background:#1976d2;
    color:white;
    text-decoration:none;
    border-radius:8px;
}

.btn:hover{
    background:#1565c0;
}

</style>

</head>

<body>

<div class="container">

<div class="hasil-header">

<h1>
📝 Hasil Kuis <?php echo htmlspecialchars($kategori); ?>
</h1>

<p>
Berikut hasil pengerjaan kuis Anda.
</p>

</div>

<?php

while($d = mysqli_fetch_assoc($soal)){

$total_soal++;

$jawaban_siswa =
$_POST['jawaban_'.$d['id_kuis']] ?? '';

$jawaban_siswa_text = '';

if($jawaban_siswa == 'A'){
    $jawaban_siswa_text = $d['pilihan_a'];
}
elseif($jawaban_siswa == 'B'){
    $jawaban_siswa_text = $d['pilihan_b'];
}
elseif($jawaban_siswa == 'C'){
    $jawaban_siswa_text = $d['pilihan_c'];
}
elseif($jawaban_siswa == 'D'){
    $jawaban_siswa_text = $d['pilihan_d'];
}

$jawaban_benar_text = '';

if($d['jawaban_benar'] == 'A'){
    $jawaban_benar_text = $d['pilihan_a'];
}
elseif($d['jawaban_benar'] == 'B'){
    $jawaban_benar_text = $d['pilihan_b'];
}
elseif($d['jawaban_benar'] == 'C'){
    $jawaban_benar_text = $d['pilihan_c'];
}
elseif($d['jawaban_benar'] == 'D'){
    $jawaban_benar_text = $d['pilihan_d'];
}

?>

<div class="hasil-card">

<h3>
<?php echo htmlspecialchars($d['pertanyaan']); ?>
</h3>

<div class="jawaban-box jawaban-user">

<b>📝 Jawaban Anda</b>

<p>
<?php echo htmlspecialchars($jawaban_siswa_text); ?>
</p>

</div>

<div class="jawaban-box jawaban-benar">

<b>✅ Jawaban Benar</b>

<p>
<?php echo htmlspecialchars($jawaban_benar_text); ?>
</p>

</div>

<?php

if($jawaban_siswa == $d['jawaban_benar']){

echo "<p class='benar'>✅ Jawaban Anda Benar</p>";

$jumlah_benar++;

}else{

echo "<p class='salah'>❌ Jawaban Anda Salah</p>";

}

?>

</div>

<?php
}

$skor = $jumlah_benar * 10;

$data_poin = mysqli_query(
$conn,
"SELECT * FROM poin
WHERE id_user='$id_user'"
);

$poin = mysqli_fetch_assoc($data_poin);

$total_poin =
$poin['jumlah_poin'] + $skor;

$badge = "Pemula";
$level = "Level 1";

if($total_poin >= 30){

$badge = "Aktif";
$level = "Level 2";

}

if($total_poin >= 60){

$badge = "Hebat";
$level = "Level 3";

}

mysqli_query(
$conn,
"UPDATE poin SET
jumlah_poin='$total_poin',
badge='$badge',
level_user='$level'
WHERE id_user='$id_user'"
);

?>

<div class="summary">

<h2>📊 Ringkasan Hasil</h2>

<p>
Jumlah Soal :
<b><?php echo $total_soal; ?></b>
</p>

<p>
Jawaban Benar :
<b><?php echo $jumlah_benar; ?></b>
</p>

<p>
Skor :
<b><?php echo $skor; ?></b>
</p>

<hr>

<h2>🏆 Gamifikasi</h2>

<p>
Total Poin :
<b><?php echo $total_poin; ?></b>
</p>

<p>
Badge :
<b><?php echo $badge; ?></b>
</p>

<p>
Level :
<b><?php echo $level; ?></b>
</p>

<a
href="dashboard.php"
class="btn">

← Kembali ke Dashboard

</a>

</div>

</div>

</body>
</html>