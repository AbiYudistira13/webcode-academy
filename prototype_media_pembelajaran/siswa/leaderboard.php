<?php

include "../config/koneksi.php";

$data = mysqli_query($conn,

"SELECT users.nama,
poin.jumlah_poin

FROM users

JOIN poin

ON users.id_user = poin.id_user

ORDER BY jumlah_poin DESC");
?>

<!DOCTYPE html>
<html>
<head>

<title>Leaderboard</title>

<link rel="stylesheet"
href="../css/style.css">

</head>

<body>

<div class="container">

<h1>🏆 Leaderboard</h1>

<?php

$rank = 1;

while($d = mysqli_fetch_array($data)){

echo "<div class='section'>";

echo "<h3>";

if($rank == 1) echo "🥇 ";
elseif($rank == 2) echo "🥈 ";
elseif($rank == 3) echo "🥉 ";

echo $d['nama'];

echo "</h3>";

echo "<p>".$d['jumlah_poin']." poin</p>";

echo "</div>";

$rank++;
}
?>

<a class="btn"
href="dashboard.php">
Kembali
</a>

</div>

</body>
</html>