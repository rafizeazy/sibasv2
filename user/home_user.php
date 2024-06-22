<?php
session_start();
if ($_SESSION['nama_lengkap'] == null) {
    echo "<script>
				alert('Silahkan Login Terlebih Dahulu !');
				window.location.href = 'index.php';
			</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>
    <link rel="stylesheet" href="../assets/css/home_admin.css" />
    <link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet" />
</head>

<body>
    <div class="sidebar">
        <div class="logo_details">
            <a href="../index.php">
                <i class="bx bx-home-alt"></i>
                <span class="logo_name">SIBAS</span>
            </a>
        </div>
        <ul>
            <li>
                <a href="home_admin.php" class="active">
                    <i class="bx bx-grid-alt"></i>
                    <span class="links_name"> Dashboard </span>
                </a>
            </li>
            <li>
                <a href="organik/lihatorganik.php">
                    <i class="bx bxs-trash"></i>
                    <span class="links_name"> Laporan Sampah Organik</span>
                </a>
            </li>
            <li>
                <a href="ekonomis/lihatekonomis.php">
                    <i class="bx bxs-trash"></i>
                    <span class="links_name"> Laporan Sampah Ekonomis</span>
                </a>
            </li>
            <li>
                <a href="bsi/lihatbsi.php">
                    <i class="bx bxs-user-plus"></i>
                    <span class="links_name"> Nasabah BSI </span>
                </a>
            </li>
            <li>
                <a href="bsu/lihatbsu.php">
                    <i class="bx bxs-user-plus"></i>
                    <span class="links_name"> Nasabah BSU </span>
                </a>
            </li>
            <!-- <li>
                <a href="#">
                    <i class="bx bx-cog"></i>
                    <span class="links_name"> Pengaturan </span>
                </a>
            </li> -->
            <li class="login">
                <a href="../aksi_login.php?op=out">
                    <span class="links_name login_out"> Keluar </span>
                    <i class="bx bx-log-out" id="log_out"></i>
                </a>
            </li>
        </ul>
    </div>
    <!-- End Sideber -->
    <section class="home_section">
        <div class="topbar">
            <div class="toggle">
                <i class="bx bx-menu" id="btn"></i>
            </div>
            <div class="user_wrapper">Hai,
                <?php
                echo "<b>" . $_SESSION['nama_lengkap'] . "</b>";
                ?> </a>
            </div>
        </div>

    </section>

    <script>
        let sidebar = document.querySelector(".sidebar");
        let closeBtn = document.querySelector("#btn");

        closeBtn.addEventListener("click", () => {
            sidebar.classList.toggle("open");
            // call function
            changeBtn();
        });

        function changeBtn() {
            if (sidebar.classList.contains("open")) {
                closeBtn.classList.replace("bx-menu", "bx-menu-alt-right");
            } else {
                closeBtn.classList.replace("bx-menu-alt-right", "bx-menu");
            }
        }
    </script>
</body>

</html>