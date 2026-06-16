<?php

include "config/koneksi.php";

if(isset($_POST['register'])){

    $nama = mysqli_real_escape_string($conn,$_POST['nama']);
    $username = mysqli_real_escape_string($conn,$_POST['username']);
    $password = mysqli_real_escape_string($conn,$_POST['password']);
    $role = mysqli_real_escape_string($conn,$_POST['role']);

    $cek = mysqli_query($conn,

    "SELECT * FROM users
    WHERE username='$username'");

    if(mysqli_num_rows($cek) > 0){

        $error = "Username sudah digunakan!";

    }else{

        mysqli_query($conn,

        "INSERT INTO users
        (
            nama,
            username,
            password,
            role,
            foto
        )

        VALUES
        (
            '$nama',
            '$username',
            '$password',
            '$role',
            NULL
        )");

        $id_user = mysqli_insert_id($conn);

        if($role == "siswa"){

            mysqli_query($conn,

            "INSERT INTO poin
            (
                id_user,
                jumlah_poin,
                badge,
                level_user
            )

            VALUES
            (
                '$id_user',
                0,
                'Pemula',
                'Level 1'
            )");

        }

        $success = "Registrasi berhasil! Silakan login.";

    }

}

?>

<!DOCTYPE html>
<html>
<head>

<title>Register - WebCode Academy</title>

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

.register-container{

width:100%;
max-width:500px;

background:white;

padding:40px;

border-radius:20px;

box-shadow:
0 15px 35px rgba(0,0,0,.15);

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

font-weight:bold;

color:#444;

}

.input-group input,
.input-group select{

width:100%;

padding:14px;

border:1px solid #ddd;

border-radius:10px;

font-size:15px;

outline:none;

}

.input-group input:focus,
.input-group select:focus{

border-color:#1976d2;

}

.btn-register{

width:100%;

padding:15px;

border:none;

border-radius:10px;

background:#4caf50;

color:white;

font-size:16px;

font-weight:bold;

cursor:pointer;

transition:.3s;

}

.btn-register:hover{

background:#43a047;

}

.success{

background:#e8f5e9;

color:#2e7d32;

padding:12px;

border-radius:8px;

margin-bottom:20px;

text-align:center;

}

.error{

background:#ffebee;

color:#d32f2f;

padding:12px;

border-radius:8px;

margin-bottom:20px;

text-align:center;

}

.login-link{

text-align:center;

margin-top:20px;

}

.login-link a{

color:#1976d2;

font-weight:bold;

text-decoration:none;

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

<div class="register-container">

<div class="logo">

<span class="badge">
📝 Registrasi Akun
</span>

<h1>
WebCode Academy
</h1>

<p>

Daftarkan akun baru untuk mulai
belajar dan mengelola pembelajaran.

</p>

</div>

<?php
if(isset($success)){
?>

<div class="success">
<?php echo $success; ?>
</div>

<?php
}
?>

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

<label>Nama Lengkap</label>

<input
type="text"
name="nama"
required>

</div>

<div class="input-group">

<label>Username</label>

<input
type="text"
name="username"
required>

</div>

<div class="input-group">

<label>Password</label>

<input
type="password"
name="password"
required>

</div>

<div class="input-group">

<label>Role</label>

<select name="role" required>

<option value="siswa">
Siswa
</option>

<option value="admin">
Guru / Admin
</option>

</select>

</div>

<button
type="submit"
name="register"
class="btn-register">

Daftar Sekarang

</button>

</form>

<div class="login-link">

Sudah punya akun?

<br><br>

<a href="login.php">

Login Disini

</a>

</div>

<div class="footer">

© WebCode Academy

</div>

</div>

</body>
</html>