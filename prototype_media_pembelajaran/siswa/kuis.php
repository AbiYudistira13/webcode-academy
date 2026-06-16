<?php

include "../config/koneksi.php";

$kategori = $_GET['kategori'] ?? '';

$data = mysqli_query(
    $conn,
    "SELECT * FROM kuis WHERE kategori='$kategori'"
);

?>

<!DOCTYPE html>
<html>
<head>

    <title>Kuis <?php echo $kategori; ?></title>

    <link rel="stylesheet" href="../css/style.css">

    <style>

    body{
        background:#f5f7fa;
        font-family:Arial, sans-serif;
    }

    .container{
        width:90%;
        max-width:900px;
        margin:auto;
        padding:20px;
    }

    .quiz-header{
        background:white;
        padding:25px;
        border-radius:15px;
        box-shadow:0 2px 10px rgba(0,0,0,0.1);
        margin-bottom:20px;
        text-align:center;
    }

    .quiz-card{
        background:white;
        padding:25px;
        border-radius:15px;
        box-shadow:0 2px 10px rgba(0,0,0,0.1);
        margin-bottom:20px;
    }

    .quiz-card h3{
        margin-top:0;
        color:#1976d2;
    }

    .option{
        margin:12px 0;
    }

    .option label{
        cursor:pointer;
        margin-left:5px;
    }

    .btn-submit{
        background:#1976d2;
        color:white;
        border:none;
        padding:12px 25px;
        border-radius:8px;
        cursor:pointer;
        font-size:16px;
    }

    .btn-submit:hover{
        background:#1565c0;
    }

    .btn-kembali{
        display:inline-block;
        margin-top:15px;
        text-decoration:none;
        background:#6c757d;
        color:white;
        padding:12px 25px;
        border-radius:8px;
    }

    </style>

</head>

<body>

<div class="container">

    <div class="quiz-header">

        <h1>
            📝 Kuis <?php echo htmlspecialchars($kategori); ?>
        </h1>

        <p>
            Jawab seluruh pertanyaan berikut dengan benar.
        </p>

    </div>

    <form action="hasil_kuis.php" method="POST">

        <input
            type="hidden"
            name="kategori"
            value="<?php echo htmlspecialchars($kategori); ?>">

        <?php

        $no = 1;

        while($d = mysqli_fetch_assoc($data)){

        ?>

        <div class="quiz-card">

            <h3>
                Soal <?php echo $no++; ?>
            </h3>

            <p>
                <strong>
                    <?php echo htmlspecialchars($d['pertanyaan']); ?>
                </strong>
            </p>

            <div class="option">

                <input
                    type="radio"
                    name="jawaban_<?php echo $d['id_kuis']; ?>"
                    value="A"
                    required>

                <label>
                    <?php echo htmlspecialchars($d['pilihan_a']); ?>
                </label>

            </div>

            <div class="option">

                <input
                    type="radio"
                    name="jawaban_<?php echo $d['id_kuis']; ?>"
                    value="B">

                <label>
                    <?php echo htmlspecialchars($d['pilihan_b']); ?>
                </label>

            </div>

            <div class="option">

                <input
                    type="radio"
                    name="jawaban_<?php echo $d['id_kuis']; ?>"
                    value="C">

                <label>
                    <?php echo htmlspecialchars($d['pilihan_c']); ?>
                </label>

            </div>

            <div class="option">

                <input
                    type="radio"
                    name="jawaban_<?php echo $d['id_kuis']; ?>"
                    value="D">

                <label>
                    <?php echo htmlspecialchars($d['pilihan_d']); ?>
                </label>

            </div>

        </div>

        <?php
        }
        ?>

        <button
            type="submit"
            class="btn-submit">

            ✅ Selesai Kuis

        </button>

        <br>

        <a
            href="dashboard.php"
            class="btn-kembali">

            ← Kembali ke Dashboard

        </a>

    </form>

</div>

</body>
</html>