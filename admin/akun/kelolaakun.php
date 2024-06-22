<?php
session_start();
if ($_SESSION['nama_lengkap'] == null) {
    echo "<script>
                alert('Silahkan Login Terlebih Dahulu !');
                window.location.href = 'index.php';
            </script>";
    exit();
}

class KelolaAkun
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function tampilAkun($keyword = '')
    {
        if ($keyword) {
            $keyword = $this->db->escape_string($keyword);
            $query = "SELECT * FROM multiuser WHERE nama_lengkap LIKE '%$keyword%'";
        } else {
            $query = "SELECT * FROM multiuser ORDER BY nama_lengkap ASC";
        }

        return $this->db->query($query);
    }

    public function hapusAkun($nameuser)
    {
        $nameuser = $this->db->escape_string($nameuser);
        $query = "DELETE FROM multiuser WHERE nama_lengkap = '$nameuser'";
        return $this->db->query($query);
    }
}

include "../../database/Database.php";
$db = new Database();
$kelolaAkun = new KelolaAkun($db);

$success_message = '';

if (isset($_POST['hapus'])) {
    $nameuser = $_POST['nameuser'];
    if ($kelolaAkun->hapusAkun($nameuser)) {
        $success_message = "Berhasil hapus data.";
    } else {
        $success_message = "Gagal hapus data. Silakan coba lagi nanti.";
    }
}

$keyword = isset($_POST['cari1']) ? $_POST['cari1'] : '';
$nsb = $kelolaAkun->tampilAkun($keyword);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Kelola Akun</title>

    <link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../../assets/css/home_admin.css" />
    <link rel="stylesheet" href="../../assets/css/stylebsi.css">
</head>

<body>
    <div class="sidebar">
        <div class="logo_details">
            <a href="page/home.php">
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
                <a href="kelola_user.php" class="active">
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
    <!-- End Sidebar -->
    <section class="home_section">
        <div class="topbar">
            <div class="toggle">
                <i class="bx bx-menu" id="btn"></i>
            </div>
            <h2 class="tbsi">Kelola Akun</h2>
            <div class="user_wrapper">Hai,
                <?php
                echo "<b>" . $_SESSION['nama_lengkap'] . "</b>";
                ?> </a>
            </div>
        </div>
        <div class="content read">
            <?php
            if ($success_message != '') {
                echo "<div class='alert alert-success'>$success_message</div>";
            }
            ?>
            <form action="" method="post">
                <div class="search">
                    <input class="cari" type="text" name="cari1" id="" placeholder="Masukkan nama" autofocus autocomplete="off">
                    <button class="tombol" type="submit" name="cari">Cari</button>
                </div>
            </form>
            <table>
                <thead>
                    <tr>
                        <td>No</td>
                        <td>Email</td>
                        <td>Nama Pengguna</td>
                        <td>Opsi</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    while ($tampil = mysqli_fetch_array($nsb)) {
                    ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $tampil['emailuser']; ?></td>
                            <td><?php echo $tampil['nama_lengkap']; ?></td>
                            <td>
                                <form action="#" method="post">
                                    <input type="hidden" value="<?php echo $tampil['nama_lengkap']; ?>" name="nameuser">
                                    <input type="submit" class="trash" name="hapus" value="Hapus" style="background-color: red; color: white; padding: 5px 10px; border: none; cursor: pointer;">
                                </form>
                            </td>
                        </tr>
                    <?php
                    };
                    ?>
                </tbody>
            </table>
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
