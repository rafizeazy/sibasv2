<?php
include "../../database/Database.php";
// FormOrganik.php
class FormOrganik {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getNewId() {
        $tanggal_bulan = date('ym');
        $query = "SELECT MAX(SUBSTRING(id_laporan, 5)) as max_urut FROM organik WHERE SUBSTRING(id_laporan, 1, 4) = '$tanggal_bulan'";
        $result = $this->db->query($query);
        $row = $result->fetch_assoc();
        $max_urut = $row['max_urut'];
        $new_urut = ($max_urut == null) ? 1 : $max_urut + 1;
        return $tanggal_bulan . sprintf('%02d', $new_urut);
    }

    public function tambahOrganik($data, $file) {
        $new_id = $this->getNewId();
        $direktori = "berkas/";
        $file_name = $file['bukti_lap']['name'];
        move_uploaded_file($file['bukti_lap']['tmp_name'], $direktori . $file_name);

        $kecamatan_id = $data['kecamatan'];
        $query_kecamatan = "SELECT nama FROM kecamatan WHERE id = '$kecamatan_id'";
        $result_kecamatan = $this->db->query($query_kecamatan);
        $row_kecamatan = $result_kecamatan->fetch_assoc();
        $nama_kecamatan = $row_kecamatan['nama'];

        // Set desa to empty string if jenis is BSI
        $desa = ($data['jenis'] == 'BSI') ? '' : $data['desa'];

        $query = "INSERT INTO organik SET
                  id_laporan = '$new_id',
                  nama_bs = '{$data['fname']}',
                  jenis_bs = '{$data['jenis']}',
                  jumlah = '{$data['jumlah']}',
                  tgl_laporan = '{$data['tgl']}',
                  kecamatan = '$nama_kecamatan',
                  kelurahan = '$desa',
                  bukti = '$file_name'";
        $this->db->query($query);

        echo "<script>alert('Data Berhasil Disimpan'); document.location='lihatorganik.php'</script>";
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
        $desa = $this->db->query("SELECT * FROM desa WHERE id='$kecamatan_id' ORDER BY nama ASC");
        while ($data = $desa->fetch_assoc()) {
            $options .= "<option value='{$data['nama']}'>{$data['nama']}</option>";
        }
        return $options;
    }
}

$formOrganik = new FormOrganik();

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
    <style>
        .hidden {
            display: none;
        }
    </style>
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
                    <input type="radio" name="jenis" id="bsi" value="BSI" />BSI
                    <input type="radio" name="jenis" id="bsu" value="BSU" />BSU
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
                <div class="inputfield" id="desa-field">
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

        function toggleDesaField() {
            const desaField = document.getElementById('desa-field');
            const bsiRadio = document.getElementById('bsi');
            const bsuRadio = document.getElementById('bsu');
            if (bsiRadio.checked) {
                desaField.classList.add('hidden');
            } else if (bsuRadio.checked) {
                desaField.classList.remove('hidden');
            }
        }

        document.getElementById('bsi').addEventListener('change', toggleDesaField);
        document.getElementById('bsu').addEventListener('change', toggleDesaField);

        // Ensure the desa field visibility is set correctly on page load
        window.onload = toggleDesaField;
    </script>
</body>
</html>
