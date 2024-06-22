<?php
session_start();
if ($_SESSION['nama_lengkap'] == null) {
    echo "<script>
        alert('Silahkan Login Terlebih Dahulu !');
        window.location.href = 'index.php';
    </script>";
    exit();
}


include "modelorganik.php";

$db = new Database();
$organik = new SampahOrganik($db);

if (isset($_GET['id'])) {
    $organik->hapusOrganik($_GET['id']);
    echo "<script>document.location='lihatorganik.php'</script>";
    exit();
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
    <link rel="stylesheet" href="../../assets/css/styleorganik.css">
    <link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet" />
    <style>
        table thead tr th {
            padding: 10px 15px;
        }
        .tcontainer {
            height: 1000px;
            overflow: auto;
        }
        .email {
            overflow: auto;
            overflow: hidden;
        }
        .ganjil {
            background-color: #f2f2f2;
        }
        .genap {
            background-color: #ffffff;
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
            <li><a href="../home_admin.php"><i class="bx bx-grid-alt"></i><span class="links_name">Dashboard</span></a></li>
            <li><a href="../akun/kelolaakun.php"><i class="bx bx-user"></i><span class="links_name">Kelola Akun</span></a></li>
            <li><a href="lihatorganik.php" class="active"><i class="bx bxs-trash"></i><span class="links_name">Laporan Sampah Organik</span></a></li>
            <li><a href="../ekonomis/lihatekonomis.php"><i class="bx bxs-trash"></i><span class="links_name">Laporan Sampah Ekonomis</span></a></li>
            <li><a href="../bsi/lihatbsi.php"><i class="bx bxs-user-plus"></i><span class="links_name">Nasabah BSI</span></a></li>
            <li><a href="../bsu/lihatbsu.php"><i class="bx bxs-user-plus"></i><span class="links_name">Nasabah BSU</span></a></li>
            <!-- <li><a href="#"><i class="bx bx-cog"></i><span class="links_name">Pengaturan</span></a></li> -->
            <li class="login"><a href="../../aksi_login.php?op=out"><span class="links_name login_out">Keluar</span><i class="bx bx-log-out" id="log_out"></i></a></li>
        </ul>
    </div>

    <section class="home_section">
        <div class="topbar">
            <div class="toggle"><i class="bx bx-menu" id="btn"></i></div>
            <h2 class="tbsi">Data Laporan Sampah Organik</h2>
            <div class="user_wrapper">Hai, <?php echo "<b>" . $_SESSION['nama_lengkap'] . "</b>"; ?></div>
        </div>

        <div class="content read">
            <h3>Data Laporan Organik</h3>
            <a href="formorganik.php" class="create-contact">Lapor Sampah</a>
            <form action="" method="post">
                <div class="search">
                    <input class="cari" type="text" name="cari1" id="" placeholder="Masukkan nama" autofocus autocomplete="off">
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
                            <th>Jumlah</th>
                            <th>Tanggal Laporan</th>
                            <th>Kecamatan</th>
                            <th>Desa</th>
                            <th>Bukti Laporan</th>
                            <th colspan=2>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($_POST['cari'])) {
                            $keyword = $_POST['cari1'];
                            $result = $organik->cariOrganik($keyword);
                        } else {
                            $result = $organik->tampilOrganik();
                        }

                        $no = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                            $class = ($no % 2 == 0) ? 'genap' : 'ganjil';
                            echo "<tr class='$class'>
                                    <td>{$no}</td>
                                    <td>{$row['id_laporan']}</td>
                                    <td>{$row['nama_bs']}</td>
                                    <td>{$row['jenis_bs']}</td>
                                    <td>{$row['jumlah']}</td>
                                    <td>{$row['tgl_laporan']}</td>
                                    <td>{$row['kecamatan']}</td>
                                    <td>{$row['kelurahan']}</td>
                                    <td>{$row['bukti']}</td>
                                    <td class='actions'><a class='edit' href='ubahorganik.php?id={$row['id_laporan']}'>Ubah</a></td>
                                    <td class='actions2'><a class='trash' href='?id={$row['id_laporan']}' onclick=\"return confirm('Yakin Hapus Data')\">Hapus</a></td>
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
