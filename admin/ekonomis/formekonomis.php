<?php
include "modelekonomis.php"; // Include file SampahEkonomis

$formEkonomis = new SampahEkonomis(); // Ganti menjadi objek SampahEkonomis

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
    $formEkonomis->tambahEkonomis($_POST, $_FILES);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelaporan Bank Sampah (Ekonomis)</title>
    <!-- <link rel="stylesheet" href="../assets/css/form-sampah.css"> -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-1ZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9s+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <style>
        @import url("https://fonts.googleapis.com/css?family=Montserrat:400,700&display=swap");

* {
  margin: 0;
  padding: 0;
  padding-bottom: 2px;
  box-sizing: border-box;
  font-family: "Montserrat", sans-serif;
}

        body {
            background-image: url("Vector.png");
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: 100%;
            background-image: url("Vector.png");
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }

        .wrapper {
            max-width: 700px;
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .title {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }

        .inputfield {
            margin-bottom: 15px;
        }

        .inputfield label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .inputfield input[type="text"],
        .inputfield input[type="date"],
        .inputfield input[type="file"],
        .inputfield select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .inputfield input[type="radio"] {
            margin-right: 5px;
        }

        .inputfield .custom_select {
            position: relative;
            width: 100%;
        }

        .inputfield .custom_select select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
        }

        .inputfield .custom_select::after {
            content: '\25BC';
            position: absolute;
            top: 30%;
            right: 10px;
            pointer-events: none;
        }

        .inputfield.btns {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .inputfield.btns input[type="button"],
        .inputfield.btns input[type="submit"] {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            color: #fff;
            background-color: #4CAF50;
            cursor: pointer;
        }

        .inputfield.btns input[type="button"]:hover,
        .inputfield.btns input[type="submit"]:hover {
            background-color: #45a049;
        }

    </style>
</head>
<body>
    <div class="wrapper">
        <div class="title">Sampah Ekonomis</div>
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
                    <label for="">Plastik (HDPE, PP, PET, Selopan) </label>
                    <input type="text" class="input" name="plastik" placeholder="Kg" title="Masukkan hanya angka" />
                </div>
                <div class="inputfield">
                    <label for="">Kertas (HVS, Duplex, Tetrapack)</label>
                    <input type="text" class="input" name="kertas" placeholder="Kg" title="Masukkan hanya angka" />
                </div>

                <div class="inputfield">
                    <label for="">Logam (Besi, Alumunium, Tembaga, dsb.)</label>
                    <input type="text" class="input" name="logam" placeholder="Kg" title="Masukkan hanya angka" />
                </div>

                <div class="inputfield">
                    <label for="">Kaca (Pecahan kaca/Beling, Botol)</label>
                    <input type="text" class="input" name="kaca" placeholder="Kg" title="Masukkan hanya angka" />
                </div>

                <div class="inputfield">
                    <label for="">Kayu (Ttiplek, dsb.)</label>
                    <input type="text" class="input" name="kayu" placeholder="Kg" title="Masukkan hanya angka" />
                </div>

                <div class="inputfield">
                    <label for="">Plastik Multilayer (Plastik berlapis Alumunium)</label>
                    <input type="text" class="input" name="plastikmulti" placeholder="Kg" title="Masukkan hanya angka" />
                </div>

                <div class="inputfield">
                    <label for="">Tanggal Laporan</label>
                    <input type="date" class="input" name="tgl" />
                </div>
                <div class="inputfield">
                    <label for="kecamatan">Kecamatan</label>
                    <select class="input" name="kecamatan" onchange="kec()" id="kecamatan">
                        <option>--Pilih--</option>
                        <?= $formEkonomis->getKecamatanOptions(); ?>
                    </select>
                </div>
                <div class="inputfield">
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
                    <input type="button" value="kembali" onclick="goToDashboard()">
                    <input type="submit" name="save" value="Kirim" class="btn">
                </div>
            </div>
        </form>
    </div>
    <script>
        function kec(){
            let id = $('#kecamatan').val();
            let url = 'desa.php';
            $.post(url, { id: id }, function(data) {
                $('#desa').html(data);
            });
        }
        function goToDashboard() {
            window.location.href = "lihatekonomis.php";
        }
    </script>
    
</body>
</html>
