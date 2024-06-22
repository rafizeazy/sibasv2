<?php
include_once "modelorganik.php";

$form = new SampahOrganik();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['simpan'])) {
    $form->updateOrganik($_POST);
}

$tampil = $form->getOrganikById($_GET['id']);
?>

<html>
<head>
    <title>Edit Data Organik</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" 
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" 
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../assets/css/ubahorganik.css">
</head>
<body>
    <div class="wrapper">
        <div class="title">Edit Data Organik</div>
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_laporan" value="<?php echo $tampil['id_laporan']; ?>">

            <div class="inputfield">
                <label>Nama Bank Sampah</label>
                <input type="text" class="input" name="fname" placeholder="Masukkan nama bank sampah" maxlength="30" value="<?php echo $tampil['nama_bs']; ?>" required />
            </div>

            <div class="inputfield" id="jenis">
                <label for="">Jenis Bank Sampah</label>
                <input type="radio" name="jenis" id="radio1" value="BSI" <?php echo ($tampil['jenis_bs'] == 'BSI') ? 'checked' : ''; ?> />BSI
                <input type="radio" name="jenis" id="radio2" value="BSU" <?php echo ($tampil['jenis_bs'] == 'BSU') ? 'checked' : ''; ?> />BSU
            </div>

            <div class="inputfield">
                <label for="">Jumlah</label>
                <input type="text" class="input" name="jumlah" placeholder="Kg" title="Masukkan hanya angka" value="<?php echo $tampil['jumlah']; ?>"/>
            </div>

            <div class="inputfield">
                <label for="">Tanggal Laporan</label>
                <input type="date" class="input" name="tgl" required value="<?php echo $tampil['tgl_laporan']; ?>" />
            </div>

            <div class="inputfield">
                    <label for="kecamatan">Kecamatan</label>
                    <select id="kecamatan" name="kecamatan" onchange="getDesa()" required>
                        <option value="">Pilih Kecamatan</option>
                        <?php echo $form->getKecamatanOptions(); ?>
                    </select>
                </div>
                <div class="inputfield">
                    <label for="desa">Desa</label>
                    <select name="desa" id="desa">
                        <option>--Pilih--</option>
                    </select>
                </div>

                

            <div class="inputfield btns" id="btn">
                <a href="lihatorganik.php">
                    <input type="button" name="kembali" id="" value="kembali">
                </a>
                <input type="submit" name="simpan" value="Simpan">
            </div>
        </form>
    </div>
    <script>
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
