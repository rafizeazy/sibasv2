<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Zen+Kaku+Gothic+New:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/stylelogin.css">
</head>

<body>

    <form action="aksi_login.php?op=in" method="post">
        <div class="header">
            <h1 class="judul">SIBAS</h1>
            <p class="subtitle">Sistem Informasi Data Bank Sampah</p>
        </div>

        <div class="kotak">
            <div class="kotak-input">
                <label class="label">Email</label>
                <input class="input" type="text" name="email" placeholder="Masukkan email">
            </div>
            <div class="kotak-input">
                <label class="label">Password</label>
                <input class="input" type="password" name="password" placeholder="Password">
            </div>
            <p class="daftar-link"><a href="register.php">Belum punya akun? Daftar disini!</a></p>
            <button class="tombol">Login</button>
        </div>

        <footer>
            <p class="footer"><b>Sistem Informasi Data Bank Sampah</b>
                <br>&copy; 2023 All Right Reserved. </br>
            </p>
        </footer>
    </form>

</body>

</html>
