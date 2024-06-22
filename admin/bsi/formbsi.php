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

    $formBsi = new NasabahBSI();
    $formBsi->tambahBsi();
    ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sistem Informasi Pengolahan Sampah</title>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../../assets/css/formbsi.css">
</head>

<body>
    <div class="content">
        <h1 class="title">Sistem Informasi Pengolahan Sampah</h1>
        <hr />
        <h2 class="title2">Registrasi Sampah BSI</h2>
        <form name="formbsi" method="POST" action="#" onsubmit="return validasi();" enctype="multipart/form-data">
            <div class="box">
                <div class="form-group">
                    <label for="kode">ID</label>
                    <input value="<?php echo $formBsi->getNewId(); ?>" name="kode" type="text" placeholder="Masukan kode" id="kode" disabled />
                </div>
                <div class="form-group">
                    <label for="nama">Nama Bank Sampah</label>
                    <input name="nama" type="text" placeholder="Masukan nama bank sampah" id="nama" autofocus/>
                </div>
                <div class="form-group">
                    <label for="kecamatan">Kecamatan</label>
                    <select name="kecamatan" id="kecamatan">
                        <option value="">--pilih--</option>
                        <?php
                        $formBsi->populateKecamatan();
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" placeholder="Masukan email" id="email" name="email" />
                </div>
                <div class="form-group">
                    <label for="kontak">Kontak</label>
                    <input type="text" placeholder="Masukan nomor HP" id="kontak" name="kontak" />
                </div>
                <div class="form-group">
                    <label for="penanggung-jawab">Penanggung Jawab</label>
                    <input name="pjawab" type="text" placeholder="Penanggung jawab" id="penanggung-jawab" />
                </div>
                <div class="form-group">
                    <label for="jumlah-nasabah">Jumlah nasabah</label>
                    <input name="jmlhnasabah" type="text" placeholder="Jumlah nasabah" id="jumlah-nasabah" />
                </div>
                <div class="form-group">
                    <label for="manager-produksi">Manager Produksi</label>
                    <input name="mproduksi" type="text" placeholder="Manager produksi" id="manager-produksi" />
                </div>
                <div class="form-group">
                    <label for="manager-keuangan">Manager Keuangan</label>
                    <input name="mkeuangan" type="text" placeholder="Manager keuangan" id="manager-keuangan" />
                </div>
                <div class="form-group">
                    <label for="tata-usaha">Tata Usaha</label>
                    <input type="text" placeholder="Tata usaha" id="tata-usaha" name="tusaha" />
                </div>
                <div class="form-group">
                    <label for="divisi-pemilihan">Divisi Pemilihan</label>
                    <input name="dpemilihan" type="text" placeholder="Divisi pemilihan" id="divisi-pemilihan" />
                </div>
                <div class="form-group">
                    <label for="divisi-penyimpanan">Divisi Penyimpanan</label>
                    <input name="dpenyimpanan" type="text" placeholder="Divisi penyimpanan" id="divisi-penyimpanan" />
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea placeholder="Masukan alamat lengkap" id="alamat" name="alamat"></textarea>
                </div>
                <div class="form-group">
                    <label for="jam-kerja">Jam Kerja</label>
                    <input type="time" placeholder="Masukan jam kerja" id="jam-kerja" name="jkerja" />
                </div>
                <div class="form-group">
                    <label for="up-ktp">Upload KTP</label>
                    <input type="file" id="up-ktp" name="ktp" accept="image/*" />
                </div>
                <div class="form-group">
                    <label for="up-sk">Izin SK</label>
                    <input type="file" id="up-sk" name="sk" accept="image/*" />
                </div>
                <div class="inputfield btns button-container" id="btn">
                    <a href="lihat_bsi.php"><button type="button" class="btn" onclick="goToDashboard()">Kembali</button></a>
                    <input class="btn" type="submit" name="kirim" value="Kirim">
                </div>

                <div class="copy">
                    <h3>DINAS LINGKUNGAN HIDUP DAN KEHUTANAN</h3>
                    <h4>&copy; 2023 Informatika - Horizon University Indonesia</h4>
                </div>
        </form>
    </div>

    <script>
        function validasi() {
            // Validasi kosong
            if (document.forms["formbsi"]["nama"].value == "") {
                alert('Harap isi Tidak boleh kosong');
                document.forms["formbsi"]["nama"].focus();
                return false;
            }
            if (document.forms["formbsi"]["email"].value == "") {
                alert('Harap isi Tidak boleh kosong');
                document.forms["formbsi"]["email"].focus();
                return false;
            }
            if (document.forms["formbsi"]["kecamatan"].value == "") {
                alert('Harap isi Tidak boleh kosong');
                document.forms["formbsi"]["kecamatan"].focus();
                return false;
            }
            if (document.forms["formbsi"]["kontak"].value == "") {
                alert('Harap isi Tidak boleh kosong');
                document.forms["formbsi"]["kontak"].focus();
                return false;
            }
            if (document.forms["formbsi"]["penanggung-jawab"].value == "") {
                alert('Harap isi Tidak boleh kosong');
                document.forms["formbsi"]["penanggung-jawab"].focus();
                return false;
            }
            if (document.forms["formbsi"]["manager-produksi"].value == "") {
                alert('Harap isi Tidak boleh kosong');
                document.forms["formbsi"]["manager-produksi"].focus();
                return false;
            }
            if (document.forms["formbsi"]["manager-keuangan"].value == "") {
                alert('Harap isi Tidak boleh kosong');
                document.forms["formbsi"]["manager-keuangan"].focus();
                return false;
            }
            if (document.forms["formbsi"]["tata-usaha"].value == "") {
                alert('Harap isi Tidak boleh kosong');
                document.forms["formbsi"]["tata-usaha"].focus();
                return false;
            }
            if (document.forms["formbsi"]["divisi-pemilihan"].value == "") {
                alert('Harap isi Tidak boleh kosong');
                document.forms["formbsi"]["divisi-pemilihan"].focus();
                return false;
            }
            if (document.forms["formbsi"]["divisi-penyimpanan"].value == "") {
                alert('Harap isi Tidak boleh kosong');
                document.forms["formbsi"]["divisi-penyimpanan"].focus();
                return false;
            }
            if (document.forms["formbsi"]["alamat"].value == "") {
                alert('Harap isi Tidak boleh kosong');
                document.forms["formbsi"]["alamat"].focus();
                return false;
            }
            if (document.forms["formbsi"]["jam-kerja"].value == "") {
                alert('Harap isi Tidak boleh kosong');
                document.forms["formbsi"]["jam-kerja"].focus();
                return false;
            }
            if (document.forms["formbsi"]["up-ktp"].value == "") {
                alert('Harap isi Tidak boleh kosong');
                document.forms["formbsi"]["up-ktp"].focus();
                return false;
            }
            if (document.forms["formbsi"]["up-sk"].value == "") {
                alert('Harap isi Tidak boleh kosong');
                document.forms["formbsi"]["up-sk"].focus();
                return false;
            }
            function goToDashboard() {
            window.location.href = "lihatbsi.php";
        }


            // Validasi kontak
            var kontakInput = document.getElementById('kontak').value;
            var angka = /^\d+$/; // Hanya angka diizinkan

            if (kontakInput === "")
                if (!angka.test(kontakInput)) {
                    alert('Kontak Harus di isi oleh angka');
                    document.getElementById('kontak').focus();
                    return false;
                }
        }
    </script>
</body>

</html>
