<?php
session_start();
if ($_SESSION['nama_lengkap'] == null) {
    echo "<script>
        alert('Silahkan Login Terlebih Dahulu !');
        window.location.href = 'index.php';
    </script>";
}

include "../../database/Database.php";

class NasabahBsu {
    private $koneksi;

    public function __construct($koneksi) {
        $this->koneksi = $koneksi;
    }

    public function lihatBsu() {
        $query = "SELECT * FROM bsu ORDER BY id ASC";
        return mysqli_query($this->koneksi, $query);
    }

    public function cariBsu($keyword) {
        $query = "SELECT * FROM bsu WHERE nama_bs LIKE '$keyword%'";
        return mysqli_query($this->koneksi, $query);
    }

}

$database = new Database();
$koneksi = $database->koneksi;
$nasabahBsu = new NasabahBsu($koneksi);

$bsuData = null;
if(isset($_POST['cari'])) {
    $keyword = $_POST['cari1'];
    $bsuData = $nasabahBsu->cariBsu($keyword);
} else {
    $bsuData = $nasabahBsu->lihatBsu();
}
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
        height: 600px;
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
            display:none;
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
                <a href="../home_user.php">
                    <i class="bx bx-grid-alt"></i>
                    <span class="links_name"> Dashboard </span>
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
                <a href="../bsi/lihatbsi.php">
                    <i class="bx bxs-user-plus"></i>
                    <span class="links_name">Nasabah BSI </span>
                </a>
            </li>
            <li>
                <a href="lihatbsu.php" class="active">
                    <i class="bx bxs-user-plus"></i>
                    <span class="links_name">Nasabah BSU </span>
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
    <section class="home_section">
        <div class="topbar">
            <div class="toggle">
                <i class="bx bx-menu" id="btn"></i>
            </div>
            <h2 class="tbsi">Data Bank Sampah BSU</h2>
            <div class="user_wrapper">Hai,
                <?php echo "<b>" . $_SESSION['nama_lengkap'] . "</b>"; ?> 
            </div>
        </div>
        <div class="content read">
            <h3>Data Bank Sampah BSU</h3>
            <a href="formbsu.php" class="create-contact">Tambah Bank Sampah</a>
            <form action="" method="post">
                <div class="search">
                    <input class="cari" type="text" name="cari1" placeholder="Masukkan nama" autofocus autocomplete="off">
                    <button class="tombol" type="submit" name="cari">Cari</button>
                </div>
            </form>
            <div class="tcontainer">
                <table>
                    <thead>
                        <tr>
                            <td>#</td>
                            <td>ID</td>
                            <td>Nama Bank Sampah</td>
                            <td>Kecamatan</td>
                            <td>Desa</td>
                            <td>Email</td>
                            <td>Penanggung Jawab</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        while ($tampil = mysqli_fetch_array($bsuData)) {
                            echo "<tr class='" . ($no % 2 == 1 ? 'ganjil' : 'genap') . "'>
                                <td align='center'>$no</td>
                                <td align='center'>{$tampil['id']}</td>
                                <td align='center'>{$tampil['nama_bs']}</td>
                                <td align='center'>{$tampil['kecamatan']}</td>
                                <td align='center'>{$tampil['desa']}</td>
                                <td align='center' class='email'>{$tampil['email']}</td>
                                <td align='center'>{$tampil['png_jawab']}</td>
                            </tr>";
                            $no++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <script>
        let sidebar = document.querySelector(".sidebar");
        let closeBtn = document.querySelector("#btn");

        closeBtn.addEventListener("click", () => {
            sidebar.classList.toggle("open");
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
