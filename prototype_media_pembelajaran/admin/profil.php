<?php

session_start();

if(!isset($_SESSION['id_user'])){
    header("Location:../login.php");
    exit();
}

include "../config/koneksi.php";

$id_user = $_SESSION['id_user'];

if(isset($_POST['upload_foto'])){

    if(!empty($_FILES['foto']['name'])){

        $namaFile =
        time()."_".$_FILES['foto']['name'];

        $tmp =
        $_FILES['foto']['tmp_name'];

        if(!is_dir("../uploads/profil")){
            mkdir("../uploads/profil",0777,true);
        }

        move_uploaded_file(
            $tmp,
            "../uploads/profil/".$namaFile
        );

        mysqli_query($conn,

        "UPDATE users SET
        foto='$namaFile'
        WHERE id_user='$id_user'");

    }

    header("Location:profil.php");
    exit();
}

$user = mysqli_query($conn,

"SELECT * FROM users
WHERE id_user='$id_user'");

$u = mysqli_fetch_assoc($user);

?>

<!DOCTYPE html>
<html>
<head>

<title>Profil Guru</title>

<link rel="stylesheet"
href="../css/style.css">

<style>

.profile-card{
    background:white;
    padding:25px;
    border-radius:10px;
    box-shadow:0px 2px 10px rgba(0,0,0,0.1);
    margin-bottom:20px;
}

.profile-top{
    background:linear-gradient(135deg,#1976d2,#42a5f5);
    color:white;
    text-align:center;
    padding:30px;
    border-radius:10px 10px 0 0;
}

.profile-image{
    width:140px;
    height:140px;
    border-radius:50%;
    object-fit:cover;
    border:5px solid white;
    margin-bottom:15px;
}

.info-item{
    display:flex;
    justify-content:space-between;
    padding:15px 0;
    border-bottom:1px solid #eee;
}

.info-item label{
    font-weight:bold;
    color:#666;
}

.upload-card{
    background:white;
    padding:25px;
    border-radius:10px;
    box-shadow:0px 2px 10px rgba(0,0,0,0.1);
    margin-bottom:20px;
}

.file-input{
    width:100%;
    padding:10px;
    margin-top:10px;
}

.upload-btn{
    background:#1976d2;
    color:white;
    border:none;
    padding:12px 20px;
    border-radius:8px;
    cursor:pointer;
    margin-top:10px;
}

.back-btn{
    display:inline-block;
    text-decoration:none;
    background:#1976d2;
    color:white;
    padding:10px 20px;
    border-radius:5px;
}

</style>

</head>

<body>

<div class="container">

<div class="profile-card">

<div class="profile-top">

<?php
if(!empty($u['foto'])){
?>

<img
src="../uploads/profil/<?php echo $u['foto']; ?>"
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

<h2>
<?php echo $u['nama']; ?>
</h2>

<p>
<?php echo ucfirst($u['role']); ?>
</p>

</div>

<div class="profile-info">

<div class="info-item">
<label>Nama Lengkap</label>
<span><?php echo $u['nama']; ?></span>
</div>

<div class="info-item">
<label>Username</label>
<span><?php echo $u['username']; ?></span>
</div>

<div class="info-item">
<label>Role</label>
<span><?php echo ucfirst($u['role']); ?></span>
</div>

</div>

</div>

<div class="upload-card">

<h2>📷 Ubah Foto Profil</h2>

<form
method="POST"
enctype="multipart/form-data">

<input
type="file"
name="foto"
class="file-input"
required>

<br>

<button
type="submit"
name="upload_foto"
class="upload-btn">

Upload Foto

</button>

</form>

</div>

<a
class="back-btn"
href="dashboard.php">

← Kembali ke Dashboard

</a>

</div>

</body>
</html>