<?php
include "../../database/Database.php";

class FormEkonomis {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getNewId() {
        $tanggal_bulan = date('ym');
        $query = "SELECT MAX(SUBSTRING(id_laporan, 5)) as max_urut FROM ekonomis WHERE SUBSTRING(id_laporan, 1, 4) = '$tanggal_bulan'";
        $result = $this->db->query($query);
        $row = $result->fetch_assoc();
        $max_urut = $row['max_urut'];
        $new_urut = ($max_urut == null) ? 1 : $max_urut + 1;
        return $tanggal_bulan . sprintf('%02d', $new_urut);
    }

    public function tambahEkonomis($data, $file) {
        $new_id = $this->getNewId();
        $direktori = "berkas/";
        $file_name = $file['bukti_lap']['name'];
        move_uploaded_file($file['bukti_lap']['tmp_name'], $direktori . $file_name);

        $kecamatan_id = $data['kecamatan'];
        $query_kecamatan = "SELECT nama FROM kecamatan WHERE id = '$kecamatan_id'";
        $result_kecamatan = $this->db->query($query_kecamatan);
        $row_kecamatan = $result_kecamatan->fetch_assoc();
        $nama_kecamatan = $row_kecamatan['nama'];

        $desa = ($data['jenis'] == 'BSI') ? '' : $data['desa'];

        $query = "INSERT INTO ekonomis SET
                  id_laporan = '$new_id',
                  nama_bs = '{$data['fname']}',
                  jenis_bs = '{$data['jenis']}',
                  jns_plastik = '{$data['plastik']}',
                  jns_kertas = '{$data['kertas']}',
                  jns_logam = '{$data['logam']}',
                  jns_kaca = '{$data['kaca']}',
                  jns_kayu = '{$data['kayu']}',
                  jns_plastikmulti = '{$data['plastikmulti']}',
                  tgl_laporan = '{$data['tgl']}',
                  kecamatan = '$nama_kecamatan',
                  kelurahan = '$desa',
                  bukti_lap = '$file_name'";
        $this->db->query($query);

        echo "<script>alert('Data Berhasil Disimpan'); document.location='lihatekonomis.php'</script>";
    }

    public function getKecamatanOptions() {
        $options = "";
        $kec = $this->db->query("SELECT * FROM kecamatan ORDER BY nama ASC");
        while ($data = $kec->fetch_assoc()) {
            $options .= "<option value='{$data['id']}'>{$data['nama']}</option>";
        }
        return $options;
    }

    public function getDesaOptions($kecamatan_id) {
        $options = "";
        $desa = $this->db->query("SELECT * FROM desa WHERE id_kecamatan='$kecamatan_id' ORDER BY nama ASC");
        while ($data = $desa->fetch_assoc()) {
            $options .= "<option value='{$data['nama']}'>{$data['nama']}</option>";
        }
        return $options;
    }
}

$formEkonomis = new FormEkonomis();

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

        .hidden {
            display: none;
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
                    <input type="radio" name="jenis" id="bsi" value="BSI" />BSI
                    <input type="radio" name="jenis" id="bsu" value="BSU" />BSU
                </div>
                <div class="inputfield">
                    <label for="">Plastik (HDPE, PP, PET, Selopan)</label>
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
                <div class="inputfield hidden" id="desa-field">
                    <label for="desa">Desa</label>
                    <select name="desa" class="input" id="desa">
                        <option>--Pilih / kosong --</option>
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
        function kec() {
            let id = $('#kecamatan').val();
            let url = 'desa.php';
            $.post(url, { id: id }, function(data) {
                $('#desa').html(data);
            });
        }
        
        function goToDashboard() {
            window.location.href = "lihatekonomis.php";
        }

        $(document).ready(function() {
            $('input[name="jenis"]').change(function() {
                if ($(this).val() == 'BSI') {
                    $('#desa-field').addClass('hidden');
                } else {
                    $('#desa-field').removeClass('hidden');
                }
            });
        });
    </script>
</body>
</html>
