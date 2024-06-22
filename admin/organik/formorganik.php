<?php
include "modelorganik.php";

$formOrganik = new SampahOrganik();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
    $formOrganik->tambahOrganik($_POST, $_FILES);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelaporan Bank Sampah (Ekonomis)</title>
    <link rel="stylesheet" href="form-sampah.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-1ZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9s+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../assets/css/formorganik.css">
</head>
<body>
    <div class="wrapper">
        <div class="title">Laporan Sampah Organik</div>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form">
                <div class="inputfield">
                    <label>Nama Bank Sampah</label>
                    <input type="text" class="input" id="name" name="fname" placeholder="Masukkan nama bank sampah" maxlength="30" />
                </div>
                <div class="inputfield" id="jenis">
                    <label for="">Jenis Bank Sampah</label>
                    <input type="radio" name="jenis" id="radio" value="BSI" />BSI
                    <input type="radio" name="jenis" id="radio" value="BSU" />BSU
                </div>
                <div class="inputfield">
                    <label for="">Jumlah Sampah Organik</label>
                    <input type="text" class="input" name="jumlah" placeholder="Kg" title="Masukkan hanya angka" />
                </div>
                <div class="inputfield">
                    <label for="">Tanggal Laporan</label>
                    <input type="date" class="input" name="tgl" />
                </div>
                <div class="inputfield">
                    <label for="kecamatan">Kecamatan</label>
                    <select class="input" name="kecamatan" onchange="kec()" id="kecamatan">
                        <option>--Pilih--</option>
                        <?= $formOrganik->getKecamatanOptions(); ?>
                    </select>
                </div>
                <div class="inputfield" id="desaField">
                    <label for="desa">Desa</label>
                    <select name="desa" class="input" id="desa">
                        <option>--Pilih--</option>
                    </select>
                </div>
                <div class="inputfield">
                    <label>Bukti Laporan</label>
                    <input type="file" class="input" name="bukti_lap" id="bukti" accept="image/*" />
                </div>
                <div class="inputfield btns" id="btn">
                    <input type="button" value="Kembali" onclick="goToDashboard()">
                    <input type="submit" name="save" value="Kirim" class="btn">
                </div>
            </div>
        </form>
    </div>
    <script>
         $(document).ready(function() {
            $('input[name="jenis"]').on('change', function() {
                if ($(this).val() === 'BSI') {
                    $('#desaField').hide();
                    $('#desa').prop('disabled', true);
                } else {
                    $('#desaField').show();
                    $('#desa').prop('disabled', false);
                }
            });
        });

        function kec(){
            let id = $('#kecamatan').val();
            let url = 'desa.php';
            $.post(url, { id: id }, function(data) {
                $('#desa').html(data);
            });
        }
        
        function goToDashboard() {
            window.location.href = "view_organik.php";
        }
        
    </script>
</body>
</html>
