<?php

session_start();

include "config/koneksi.php";

if(isset($_POST['login'])){

$username = $_POST['username'];
$password = $_POST['password'];

$data = mysqli_query($conn,

"SELECT * FROM users
WHERE username='$username'
AND password='$password'");

if(mysqli_num_rows($data)>0){

$user = mysqli_fetch_assoc($data);

$_SESSION['id_user'] = $user['id_user'];
$_SESSION['nama'] = $user['nama'];
$_SESSION['role'] = $user['role'];

if($user['role']=="admin"){

header("Location:admin/dashboard.php");

}else{

header("Location:siswa/dashboard.php");

}

exit();

}else{

$error = "Username atau Password Salah!";

}

}

?>

<!DOCTYPE html>
<html>
<head>

<title>Login - WebCode Academy</title>

<meta charset="UTF-8">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
}

body{

background:linear-gradient(
135deg,
#1976d2,
#42a5f5
);

min-height:100vh;

display:flex;
justify-content:center;
align-items:center;

padding:20px;

}

.login-container{

width:100%;
max-width:450px;

background:white;

padding:40px;

border-radius:20px;

box-shadow:
0 15px 35px rgba(0,0,0,0.15);

}

.logo{

text-align:center;
margin-bottom:30px;

}

.logo h1{

color:#1976d2;
margin-bottom:10px;

}

.logo p{

color:#666;
line-height:1.6;

}

.badge{

display:inline-block;

background:#e3f2fd;

color:#1976d2;

padding:8px 15px;

border-radius:30px;

font-size:14px;

font-weight:bold;

margin-bottom:15px;

}

.input-group{

margin-bottom:20px;

}

.input-group label{

display:block;

margin-bottom:8px;

font-weight:600;

color:#444;

}

.input-group input{

width:100%;

padding:14px;

border:1px solid #ddd;

border-radius:10px;

font-size:15px;

outline:none;

}

.input-group input:focus{

border-color:#1976d2;

}

.btn-login{

width:100%;

padding:15px;

border:none;

border-radius:10px;

background:#1976d2;

color:white;

font-size:16px;

font-weight:bold;

cursor:pointer;

transition:.3s;

}

.btn-login:hover{

background:#1565c0;

}

.error{

background:#ffebee;

color:#d32f2f;

padding:12px;

border-radius:8px;

margin-bottom:20px;

text-align:center;

}

.register-box{

margin-top:20px;
text-align:center;

}

.register-box p{

margin-bottom:10px;
color:#666;

}

.btn-register{

display:inline-block;

padding:12px 25px;

background:#4caf50;

color:white;

text-decoration:none;

border-radius:10px;

font-weight:bold;

}

.btn-register:hover{

background:#43a047;

}

.footer{

margin-top:25px;

text-align:center;

color:#888;

font-size:13px;

}

</style>

</head>

<body>

<div class="login-container">

<div class="logo">

<span class="badge">
🚀 Media Pembelajaran Interaktif
</span>

<h1>
WebCode Academy
</h1>

<p>

Belajar Pemrograman web
dengan sistem gamifikasi yang
interaktif dan menyenangkan.

</p>

</div>

<?php
if(isset($error)){
?>

<div class="error">

<?php echo $error; ?>

</div>

<?php
}
?>

<form method="POST">

<div class="input-group">

<label>
Username
</label>

<input
type="text"
name="username"
placeholder="Masukkan Username"
required>

</div>

<div class="input-group">

<label>
Password
</label>

<input
type="password"
name="password"
placeholder="Masukkan Password"
required>

</div>

<button
type="submit"
name="login"
class="btn-login">

Login

</button>

</form>

<div class="register-box">

<p>Belum punya akun?</p>

<a
href="register.php"
class="btn-register">

Daftar Sekarang

</a>

</div>

<div class="footer">

© WebCode Academy

</div>

</div>

</body>
</html>