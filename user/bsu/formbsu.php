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
    <style>
      @import url('https://fonts.googleapis.com/css2?family=Great+Vibes&family=Sacramento&family=Teko:wght@500&family=Work+Sans:wght@100;400;600;700&display=swap');
      @import url('https://fonts.googleapis.com/css2?family=Great+Vibes&family=IBM+Plex+Sans:wght@600;700&family=Sacramento&family=Work+Sans:wght@100;400;600;700&display=swap');
    </style>
  </head>
  <body>
    <?php
      include '../../database/Database.php';
      
      class FormBsu {
          private $db;
          public $kodeauto;

          public function __construct() {
              $this->db = new Database();
              $this->generateKodeauto();
          }

          private function generateKodeauto() {
              $query = "SELECT MAX(SUBSTRING(id, 5)) as max_urut FROM bsu WHERE SUBSTRING(id, 1, 4) = 'BSUK'";
              $result = $this->db->query($query);
              $row = $result->fetch_assoc();
              $max_urut = $row['max_urut'];
              $new_urut = ($max_urut == null) ? 1 : $max_urut + 1;
              $this->kodeauto = 'BSUK' . sprintf('%03d', $new_urut);
          }

          public function getKecamatanOptions() {
              $options = "";
              $result = $this->db->query("SELECT * FROM kecamatan ORDER BY nama ASC");
              while ($data = $result->fetch_assoc()) {
                  $options .= "<option value='{$data['id']}'>{$data['nama']}</option>";
              }
              return $options;
          }

          public function tambahBsu($data, $files) {
              $direktori = "berkas/";
              $file_name = $files['ktp']['name'];
              move_uploaded_file($files['ktp']['tmp_name'], $direktori . $file_name);
              $nama_file = $files['sk']['name'];
              move_uploaded_file($files['sk']['tmp_name'], $direktori . $nama_file);

              $kecamatan_id = $data['kecamatan'];
              $query_kecamatan = "SELECT nama FROM kecamatan WHERE id = '$kecamatan_id'";
              $result_kecamatan = $this->db->query($query_kecamatan);
              $row_kecamatan = $result_kecamatan->fetch_assoc();
              $nama_kecamatan = $row_kecamatan['nama'];

              $this->db->query("INSERT INTO bsu SET
                  id = '{$this->kodeauto}',
                  nama_bs = '{$data['nama']}',
                  kecamatan = '$nama_kecamatan',
                  desa = '{$data['desa']}',
                  email = '{$data['email']}',
                  kontak = '{$data['kontak']}',
                  png_jawab = '{$data['pjawab']}',
                  mng_produksi = '{$data['mproduksi']}',
                  mng_keuangan = '{$data['mkeuangan']}',
                  t_usaha = '{$data['tata_usaha']}',
                  dvs_pemilihan = '{$data['dpemilihan']}',
                  dvs_penyimpanan = '{$data['dpenyimpanan']}',
                  alamat ='{$data['alamat']}',
                  jam_kerja = '{$data['jam_kerja']}',
                  ktp = '$file_name',
                  sk = '$nama_file'
              ");

              echo "<script>alert('Data Berhasil Disimpan'); document.location='lihatbsu.php'</script>";
          }

          public function __destruct() {
              $this->db->close();
          }
      }

      $formBsu = new FormBsu();

      if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
          $formBsu->tambahBsu($_POST, $_FILES);
      }
    ?>

    <div class="content">
      <h1 class="title">Sistem Informasi Pengolahan Sampah</h1>
      <hr />
      <h2 class="title2">Registrasi Sampah BSU</h2>
      <form
        name="formbsi"
        method="POST"
        action=""
        onsubmit="return validasi();"
        enctype="multipart/form-data"
      >
        <div class="box">
          <div class="form-group">
            <label for="kode">ID</label>
            <input
              value="<?php echo $formBsu->kodeauto; ?>"
              name="kode"
              type="text"
              placeholder="Masukan kode"
              id="kode"
              disabled
            />
          </div>
          <div class="form-group">
            <label for="nama">Nama Bank Sampah</label>
            <input
              name="nama"
              type="text"
              placeholder="Masukan nama bank sampah"
              id="nama"
            />
          </div>
          <div class="form-group">
            <label for="kecamatan">Kecamatan</label>
            <select name="kecamatan" onchange="kec()" id="kecamatan">
              <option>--Pilih--</option>
              <?php echo $formBsu->getKecamatanOptions(); ?>
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
            <input
              type="email"
              placeholder="Masukan email"
              id="email"
              name="email"
            />
          </div>
          <div class="form-group">
            <label for="kontak">Kontak</label>
            <input
              type="text"
              placeholder="Masukan nomor HP"
              id="kontak"
              name="kontak"
            />
          </div>
          <div class="form-group">
            <label for="penanggung-jawab">Penanggung Jawab</label>
            <input
              name="pjawab"
              type="text"
              placeholder="Penanggung jawab"
              id="penanggung-jawab"
            />
          </div>
          <div class="form-group">
            <label for="manager-produksi">Manager Produksi</label>
            <input
              name="mproduksi"
              type="text"
              placeholder="Manager produksi"
              id="manager-produksi"
            />
          </div>
          <div class="form-group">
            <label for="manager-keuangan">Manager Keuangan</label>
            <input
              name="mkeuangan"
              type="text"
              placeholder="Manager keuangan"
              id="manager-keuangan"
            />
          </div>
          <div class="form-group">
            <label for="tata-usaha">Tata Usaha</label>
            <input
              type="text"
              placeholder="Tata usaha"
              id="tata-usaha"
              name="tata_usaha"
            />
          </div>
          <div class="form-group">
            <label for="divisi-pemilihan">Divisi Pemilihan</label>
            <input
              name="dpemilihan"
              type="text"
              placeholder="Divisi pemilihan"
              id="divisi-pemilihan"
            />
          </div>
          <div class="form-group">
            <label for="divisi-penyimpanan">Divisi Penyimpanan</label>
            <input
              name="dpenyimpanan"
              type="text"
              placeholder="Divisi penyimpanan"
              id="divisi-penyimpanan"
            />
          </div>
          <div class="form-group">
            <label for="alamat">Alamat</label>
            <textarea
              placeholder="Masukan alamat lengkap"
              id="alamat"
              name="alamat"
            ></textarea>
          </div>
          <div class="form-group">
            <label for="jam-kerja">Jam Kerja</label>
            <input
              type="time"
              placeholder="Masukan jam kerja"
              id="jam-kerja"
              name="jam_kerja"
            />
          </div>
          <div class="form-group">
            <label for="up-ktp">Upload KTP</label>
            <input
              type="file"
              id="up-ktp"
              name="ktp"
              accept="image/*"
            />
          </div>
          <div class="form-group">
            <label for="up-sk">Izin SK</label>
            <input
              type="file"
              id="up-sk"
              name="sk"
              accept="image/*"
            />
          </div>
          <div class="inputfield btns button-container" id="btn">
            <a href="lihatbsu.php?cari1=">   
              <input class="btn" type="button" value="Kembali" onclick="goToDashboard()"/>
            </a>
            <input class="btn" type="submit" value="Kirim" name="save"/>
          </div>
          <div class="copy">
            <h3>DINAS LINGKUNGAN HIDUP DAN KEHUTANAN</h3>
            <h4>&copy; 2023 Informatika - Horizon University</h4>
          </div>
      </form>
    </div>
    <script>
      function validasi() {
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
        var kontakInput = document.getElementById('kontak').value;
        var angka = /^\d+$/;
        if (!angka.test(kontakInput)) {
          alert('Kontak Harus di isi oleh angka');
          document.getElementById('kontak').focus();
          return false;
        }
      }
      function goToDashboard() {
            window.location.href = "lihatbsu.php";
        }

      function kec() {
        let id = $('#kecamatan').val();
        let url = 'desa.php';

        $.post(url, {
          id: id
        }, function(data) {
          $('#desa').html(data);
        });
      }
    </script>
  </body>
</html>
