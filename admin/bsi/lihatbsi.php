<?php
session_start();
if ($_SESSION['nama_lengkap'] == null) {
    echo "<script>
        alert('Silahkan Login Terlebih Dahulu !');
        window.location.href = 'index.php';
    </script>";
    exit;
}

include "../../database/Database.php";
include "modelbsi.php";

$nasabahBSI = new NasabahBSI();

if (isset($_GET['id'])) {
    $nasabahBSI->hapusBsi($_GET['id']);
    echo "<script> document.location='lihatbsi.php'</script>";
    exit;
}

$keyword = isset($_POST['cari']) ? $_POST['cari1'] : '';
$nsb = ($keyword != '') ? $nasabahBSI->cariBsi($keyword) : $nasabahBSI->lihatBsi();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>
    <link rel="stylesheet" href="../../assets/css/home_admin.css" />
    <link rel="stylesheet" href="../../assets/css/stylebsi.css">
    <link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet" />
    <style>
        .tcontainer {
            height: 500px;
            overflow: auto;
        }
        .email {
            overflow: auto;
            overflow: hidden;
        }
        h3 {
            display: none;
        }
        @media screen and (max-width: 600px) {
            h2 {
                display: none;
            }
            h3 {
                display: block;
            }
            .content {
                padding-top: 20px;
                width: 90%;
                margin: 0 auto;
            }
            .read .create-contact {
                font-size: 11px;
                padding: 8px 12px;
                margin: 12px 0;
                border-radius: 5px;
            }
            .search {
                max-width: 200px;
                padding-bottom: 14px;
            }
            .cari {
                padding: 4px 2px;
            }
            .tombol {
                padding: 4px 12px;
            }
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <div class="logo_details">
            <a href="../../index.php">
                <i class="bx bx-home-alt"></i>
                <span class="logo_name">SIBAS</span>
            </a>
        </div>
        <ul>
            <li>
                <a href="../home_admin.php">
                    <i class="bx bx-grid-alt"></i>
                    <span class="links_name"> Dashboard </span>
                </a>
            </li>
            <li>
                <a href="../akun/kelolaakun.php">
                    <i class="bx bx-user"></i>
                    <span class="links_name"> Kelola Akun </span>
                </a>
            </li>
            <li>
                <a href="../organik/lihatorganik.php">
                    <i class="bx bxs-trash"></i>
                    <span class="links_name"> Laporan Sampah Organik</span>
                </a>
            </li>
            <li>
                <a href="../ekonomis/lihatekonomis.php">
                    <i class="bx bxs-trash"></i>
                    <span class="links_name"> Laporan Sampah Ekonomis</span>
                </a>
            </li>
            <li>
                <a href="lihatbsi.php" class="active">
                    <i class="bx bxs-user-plus"></i>
                    <span class="links_name"> Nasabah BSI </span>
                </a>
            </li>
            <li>
                <a href="../bsu/lihatbsu.php">
                    <i class="bx bxs-user-plus"></i>
                    <span class="links_name"> Nasabah BSU </span>
                </a>
            </li>
            <li class="login">
                <a href="../../aksi_login.php?op=out">
                    <span class="links_name login_out"> Keluar </span>
                    <i class="bx bx-log-out" id="log_out"></i>
                </a>
            </li>
        </ul>
    </div>
    <!-- End Sidebar -->
    <section class="home_section">
        <div class="topbar">
            <div class="toggle">
                <i class="bx bx-menu" id="btn"></i>
            </div>
            <h2 class="tbsi">Data Bank Sampah BSI</h2>
            <div class="user_wrapper">Hai,
                <?php
                echo "<b>" . $_SESSION['nama_lengkap'] . "</b>";
                ?>
            </div>
        </div>
        <div class="content read">
            <h3>Data Bank Sampah BSI</h3>
            <a href="formbsi.php" class="create-contact">Tambah Bank Sampah</a>
            <form action="" method="post">
                <div class="search">
                    <input class="cari" type="text" name="cari1" id="" placeholder="Masukkan nama" autofocus autocomplete="off">
                    <button class="tombol" type="submit" name="cari">Cari</button>
                </div>
            </form>
            <div class="tcontainer">
                <?php if ($nsb->num_rows > 0) { ?>
                    <table>
                        <thead>
                            <tr>
                                <td>#</td>
                                <td>ID</td>
                                <td>Nama Bank Sampah</td>
                                <td>Kecamatan</td>
                                <td>Email</td>
                                <td>Penanggung Jawab</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $k = 1;
                            while ($tampil = $nsb->fetch_assoc()) {
                                $class = ($k % 2 == 1) ? 'ganjil' : 'genap';
                                echo "
                                <tr class='$class'>
                                    <td align='center'>$k</td>
                                    <td align='center'>{$tampil['id']}</td>
                                    <td align='center'>{$tampil['nama_bs']}</td>
                                    <td align='center'>{$tampil['kecamatan']}</td>
                                    <td align='center' class='email'>{$tampil['email']}</td>
                                    <td align='center'>{$tampil['png_jawab']}</td>
                                    <td><a href='detail.php?id={$tampil['id']}' class='detail'>DETAIL</a></td>
                                    <td class='actions'>
                                        <a class='edit' href='ubahbsi.php?id={$tampil['id']}'>Ubah</a>
                                    </td>
                                    <td class='actions2'>
                                        <a class='trash' href='?id={$tampil['id']}' onclick=\"return confirm('Yakin Hapus Data')\">Hapus</a>
                                    </td>
                                </tr>
                                ";
                                $k++;
                            }
                            ?>
                        </tbody>
                    </table>
                <?php } else { ?>
                    <p>Data tidak ditemukan.</p>
                <?php } ?>
            </div>
        </div>
    </section>

    <script>
        let sidebar = document.querySelector(".sidebar");
        let closeBtn = document.querySelector("#btn");

        closeBtn.addEventListener("click", () => {
            sidebar.classList.toggle
            ("open");
            changeBtn();
        });

        function changeBtn() {
            if (sidebar.classList.contains("open")) {
                closeBtn.classList.replace("bx-menu", "bx-menu-alt-right");
            } else {
                closeBtn.classList
                .replace("bx-menu-alt-right", "bx-menu");
            }
        }
    </script>
</body>

</html>

