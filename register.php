<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Register</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Zen+Kaku+Gothic+New:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/stylelogin.css">
</head>

<body>

    <form action="aksi_register.php" method="POST">
        <div class="header">
            <h1 class="judul">Daftar</h1>
            <p class="subtitle">Sistem Informasi Data Bank Sampah</p>
        </div>

        <div class="kotak">
            <div class="kotak-input">
                <label class="label">Email</label>
                <input class="input" type="email" name="email" placeholder="Email">
            </div>
            <div class="kotak-input">
                <label class="label">Nama Lengkap</label>
                <input class="input" type="text" name="nama_lengkap" placeholder="Nama Lengkap">
                <div class="kotak-input">
                    <label class="label">Password</label>
                    <input class="input" type="password" name="password" placeholder="Password">
                </div>
                <div class="kotak-input">
                    <label class="label">Ulangi Password</label>
                    <input class="input" type="password" name="ulangi_password" placeholder="Password">
                </div>

                <input class="tombol" type="submit" value="Daftar" name="daftar">
            </div>

            <a href="index.php">Sudah punya akun? Login Disini!</a>
    </form>

</body>

</html>
