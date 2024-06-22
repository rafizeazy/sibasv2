<?php
session_start();
if ($_SESSION['nama_lengkap'] == null) {
    echo "<script>
                alert('Silahkan Login Terlebih Dahulu !');
                window.location.href = 'index.php';
            </script>";
}


include "modelekonomis.php"; // Include file SampahEkonomis

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>
    <link rel="stylesheet" href="../../assets/css/home_admin.css" />
    <link rel="stylesheet" href="../../assets/css/lihatekonomis.css">
    <link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet" />
    <style>
        .read table thead th {
            padding: 4px 10pxpx;
            font-size: 14px;
        }
        .read table thead th {
            width: 1000px;
        }
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
            .read table thead th {
                padding: 4px 12px;
                font-size: 12px;
            }
            .read table tbody td {
                padding: 4px 12px;
                font-size: 12px;
            }
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
                <a href="lihatekonomis.php" class="active">
                    <i class="bx bxs-trash"></i>
                    <span class="links_name"> Laporan Sampah Ekonomis</span>
                </a>
            </li>
            <li>
                <a href="../bsi/lihatbsi.php">
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
            <!-- <li>
                <a href="#">
                    <i class="bx bx-cog"></i>
                    <span class="links_name"> Pengaturan </span>
                </a>
            </li> -->
            <li class="login">
                <a href="../../aksi_login.php?op=out">
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
            <h2 class="tbsi">Data Laporan Ekonomis</h2>
            <div class="user_wrapper">Hai,
                <?php
                echo "<b>" . $_SESSION['nama_lengkap'] . "</b>";
                ?> 
            </div>
        </div>
        <div class="content read">
            <h3>Data Laporan Ekonomis</h3>
            <a href="formekonomis.php" class="create-contact">Lapor Sampah</a>
            <form action="" method="post">
                <div class="search">
                    <input class="cari
                    "type="text" name="cari1" id="" placeholder="Masukkan nama" autofocus autocomplete="off">
                    <button class="tombol" type="submit" name="cari">Cari</button>
                </div>
            </form>
            <div class="tcontainer">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Laporan</th>
                            <th>Nama Bank Sampah</th>
                            <th>Jenis Bank Sampah</th>
                            <th>Jenis Plastik</th>
                            <th>Jenis Kertas</th>
                            <th>Jenis Logam</th>
                            <th>Jenis Kaca</th>
                            <th> Jenis Kayu</th>
                            <th>Jenis Plastik Multilayer</th>
                            <th>Tanggal Laporan</th>
                            <th>Kecamatan</th>
                            <th>Desa</th>
                            <th>Bukti Laporan</th>
                            <th colspan=2>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $ekonomis = new SampahEkonomis();

                        if (isset($_POST['cari'])) {
                            $keyword = $_POST['cari1'];
                            $result = $ekonomis->cariEkonomis($keyword);
                        } else {
                            $result = $ekonomis->tampilEkonomis();
                        }

                        if ($result->num_rows === 0) {
                            echo "<tr><td colspan='15' align='center'>Data tidak ditemukan.</td></tr>";
                        } else {
                            $no = 1;
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr class='" . ($no % 2 == 0 ? "genap" : "ganjil") . "'>
                                    <td align='center'>{$no}</td>
                                    <td align='center'>{$row['id_laporan']}</td>
                                    <td align='center'>{$row['nama_bs']}</td>
                                    <td align='center'>{$row['jenis_bs']}</td>
                                    <td align='center'>{$row['jns_kertas']}</td>
                                    <td align='center'>{$row['jns_plastik']}</td>
                                    <td align='center'>{$row['jns_logam']}</td>
                                    <td align='center'>{$row['jns_kayu']}</td>
                                    <td align='center'>{$row['jns_kaca']}</td>
                                    <td align='center'>{$row['jns_plastikmulti']}</td>
                                    <td align='center'>{$row['tgl_laporan']}</td>
                                    <td align='center'>{$row['kecamatan']}</td>
                                    <td align='center'>{$row['kelurahan']}</td>
                                    <td align='center'>{$row['bukti_lap']}</td>
                                    <td class='actions'>
                                        <a class='edit' href='ubahekonomis.php?id={$row['id_laporan']}'>Ubah</a>
                                    </td>
                                    <td class='actions2'>
                                        <a class='trash' href='lihatekonomis.php?id={$row['id_laporan']}' onclick=\"return confirm('Yakin Hapus Data')\">Hapus</a>
                                    </td>
                                </tr>";
                                $no++;
                            }
                        }

                        if (isset($_GET['id'])) {
                            $ekonomis->hapusEkonomis($_GET['id']);
                            echo "<script>document.location='lihatekonomis.php'</script>";
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

