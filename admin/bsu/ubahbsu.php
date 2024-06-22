<?php
include "modelbsu.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ubah'])) {
    $nasabahBsu = new NasabahBSU();
    $nasabahBsu->ubahBsu($_GET['id'], $_POST);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sistem Informasi Pengolahan Sampah</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
        crossorigin="anonymous"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;700&display=swap"
        rel="stylesheet"
    />
    <link rel="stylesheet" href="../../assets/css/formbsi.css">
</head>
<body>
    <?php
    $nasabahBsu = new NasabahBSU();
    $tampil = $nasabahBsu->fetchBsuData($_GET['id']);
    ?>
    <div class="content">
        <h1 class="title">Sistem Informasi Pengolahan Sampah</h1>
        <hr />
        <h2 class="title2">Registrasi Sampah BSU</h2>
        <form name="formbsi" method="POST" action="" onsubmit="return validasi();" enctype="multipart/form-data">
            <div class="box">
                <div class="form-group">
                    <label for="kode">ID</label>
                    <input value="<?php echo $tampil['id']; ?>" name="kode" type="text" placeholder="Masukan kode" id="kode" disabled />
                </div>
                <div class="form-group">
                    <label for="nama">Nama Bank Sampah</label>
                    <input name="nama" value="<?php echo $tampil['nama_bs']; ?>" type="text" placeholder="Masukan nama bank sampah" id="nama"/>
                </div>
                <div class="form-group">
                    <label for="kecamatan">Kecamatan</label>
                    <select id="kecamatan" name="kecamatan" onchange="getDesa()" required>
                        <option value="">Pilih Kecamatan</option>
                        <?php echo $nasabahBsu->getKecamatanOptions(); ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="desa">Desa</label>
                    <select name="desa" id="desa">
                        <option>--Pilih--</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" placeholder="Masukan email" id="email" name="email" value="<?php echo $tampil['email']; ?>" />
                </div>
                <div class="form-group">
                    <label for="kontak">Kontak</label>
                    <input type="text" placeholder="Masukan nomor HP" id="kontak" name="kontak" value="<?php echo $tampil['kontak']; ?>" />
                </div>
                <div class="form-group">
                    <label for="penanggung-jawab">Penanggung Jawab</label>
                    <input name="pjawab" value="<?php echo $tampil['png_jawab']; ?>" type="text" placeholder="Penanggung jawab" id="penanggung-jawab" />
                </div>
                <div class="form-group">
                    <label for="manager-produksi">Manager Produksi</label>
                    <input name="mproduksi" value="<?php echo $tampil['mng_produksi']; ?>" type="text" placeholder="Manager produksi" id="manager-produksi" />
                </div>
                <div class="form-group">
                    <label for="manager-keuangan">Manager Keuangan</label>
                    <input name="mkeuangan" value="<?php echo $tampil['mng_keuangan']; ?>" type="text" placeholder="Manager keuangan" id="manager-keuangan" />
                </div>
                <div class="form-group">
                    <label for="tata-usaha">Tata Usaha</label>
                    <input type="text" placeholder="Tata usaha" id="nomor" name="tata_usaha" value="<?php echo $tampil['t_usaha']; ?>"/>
                </div>
                <div class="form-group">
                    <label for="divisi-pemilihan">Divisi Pemilihan</label>
                    <input name="dpemilihan" value="<?php echo $tampil['dvs_pemilihan']; ?>" type="text" placeholder="Divisi pemilihan" id="divisi-pemilihan" />
                </div>
                <div class="form-group">
                    <label for="divisi-penyimpanan">Divisi Penyimpanan</label>
                    <input name="dpenyimpanan" value="<?php echo $tampil['dvs_penyimpanan']; ?>" type="text" placeholder="Divisi penyimpanan" id="divisi-penyimpanan" />
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea placeholder="Masukan alamat lengkap" id="alamat" name="alamat"><?php echo $tampil['alamat']; ?></textarea>
                </div>
                <div class="inputfield btns button-container" id="btn">
                    <a href="lihatbsu.php?cari1=">
                        <input class="btn" type="button" value="Kembali" />
                    </a>
                    <input class="btn" type="submit" value="ubah" name="ubah"/>
                </div>
                <div class="copy">
                    <h3>DINAS LINGKUNGAN HIDUP DAN KEHUTANAN</h3>
                    <h4>&copy; 2023 Informatika - Horizon University</h4>
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
            }

            function getDesa() {
                var kecamatanId = $("#kecamatan").val();

                if (kecamatanId !== "") {
                    $.ajax({
                        type: "POST",
                        url: "desa_update.php",
                        data: { id: kecamatanId },
                        success: function (data) {
                            $("#desa").html(data);
                            // Jika ada data desa, simpan id_desa yang terpilih
                            var selectedDesa = $("#desa").val();
                            $("#selected_desa").val(selectedDesa);
                        }
                    });
                } else {
                    $("#desa").html('<option value="">Pilih Desa</option>');
                    // Reset nilai selected_desa saat tidak ada kecamatan terpilih
                    $("#selected_desa").val("");
                }
            }
        </script>
    </body>
</html>
