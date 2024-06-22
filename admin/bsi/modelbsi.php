<?php
class NasabahBSI {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function lihatBsi($keyword = '') {
        if ($keyword) {
            $keyword = $this->db->escape_string($keyword);
            $query = "SELECT * FROM bsi WHERE nama_bs LIKE '$keyword%'";
        } else {
            $query = "SELECT * FROM bsi ORDER BY id ASC";
        }

        return $this->db->query($query);
    }

    public function cariBsi($keyword) {
        $keyword = $this->db->escape_string($keyword);
        $query = "SELECT * FROM bsi WHERE nama_bs LIKE '$keyword%'";
        return $this->db->query($query);
    }

    public function hapusBsi($id) {
        $id = $this->db->escape_string($id);
        $this->db->query("DELETE FROM bsi WHERE id='$id'");
    }

    public function getNewId() {
        $query = "SELECT MAX(SUBSTRING(id, 5)) as max_urut FROM bsi WHERE SUBSTRING(id, 1, 4) = 'BSIK'";
        $result = $this->db->query($query);
        $row = $result->fetch_assoc();
        $max_urut = $row['max_urut'];
        $new_urut = ($max_urut == null) ? 1 : $max_urut + 1;
        return 'BSIK' . sprintf('%03d', $new_urut);
    }

    public function populateKecamatan() {
        $sql_kec = $this->db->query("SELECT * FROM kecamatan ORDER by nama ASC");
        while ($tampil = $sql_kec->fetch_assoc()) {
            echo '<option value="' . $tampil['nama'] . '">' . $tampil['nama'] . '</option>';
        }
    }

    public function tambahBsi() {
        if (isset($_POST['kirim'])) {
            $direktori = "berkas/";
            $file_ktp = $_FILES['ktp']['name'];
            move_uploaded_file($_FILES['ktp']['tmp_name'], $direktori . $file_ktp);
            $file_sk = $_FILES['sk']['name'];
            move_uploaded_file($_FILES['sk']['tmp_name'], $direktori . $file_sk);

            $new_id = $this->getNewId();

            $this->db->query("INSERT INTO bsi SET
                id = '$new_id',
                nama_bs = '" . $this->db->escape_string($_POST['nama']) . "',
                kecamatan = '" . $this->db->escape_string($_POST['kecamatan']) . "',
                email = '" . $this->db->escape_string($_POST['email']) . "',
                kontak = '" . $this->db->escape_string($_POST['kontak']) . "',
                png_jawab = '" . $this->db->escape_string($_POST['pjawab']) . "',
                jmlh_nasabah = '" . $this->db->escape_string($_POST['jmlhnasabah']) . "',
                mng_produksi = '" . $this->db->escape_string($_POST['mproduksi']) . "',
                mng_keuangan = '" . $this->db->escape_string($_POST['mkeuangan']) . "',
                t_usaha = '" . $this->db->escape_string($_POST['tusaha']) . "',
                dvs_pemilihan = '" . $this->db->escape_string($_POST['dpemilihan']) . "',
                dvs_penyimpanan = '" . $this->db->escape_string($_POST['dpenyimpanan']) . "',
                alamat ='" . $this->db->escape_string($_POST['alamat']) . "',
                jam_kerja = '" . $this->db->escape_string($_POST['jkerja']) . "',
                ktp = '$file_ktp',
                sk = '$file_sk'
            ");

            echo "<script>alert('Data Berhasil Disimpan'); document.location='lihatbsi.php'</script>";
        }
    }

    public function fetchBsiData($id) {
        $sql = $this->db->query("SELECT * FROM bsi WHERE id='" . $this->db->escape_string($id) . "'");
        return $sql->fetch_assoc();
    }

    public function fetchKecamatanOptions($selectedKecamatan = '') {
        $options = "";
        $kec = $this->db->query("SELECT * FROM kecamatan ORDER BY nama ASC");
        if (!$kec) {
            die('Invalid query: ' . $this->db->koneksi->error);
        }
        while ($data = $kec->fetch_assoc()) {
            $selected = $data['nama'] == $selectedKecamatan ? 'selected="selected"' : '';
            $options .= "<option value='{$data['nama']}' $selected>{$data['nama']}</option>";
        }
        return $options;
    }

    public function ubahBsi($postData, $id) {
        $sql = "UPDATE bsi SET
            nama_bs = '" . $this->db->escape_string($postData['nama']) . "',
            kecamatan = '" . $this->db->escape_string($postData['kecamatan']) . "',
            email = '" . $this->db->escape_string($postData['email']) . "',
            kontak = '" . $this->db->escape_string($postData['kontak']) . "',
            png_jawab = '" . $this->db->escape_string($postData['pjawab']) . "',
            mng_produksi = '" . $this->db->escape_string($postData['mproduksi']) . "',
            mng_keuangan = '" . $this->db->escape_string($postData['mkeuangan']) . "',
            t_usaha = '" . $this->db->escape_string($postData['tusaha']) . "',
            dvs_pemilihan = '" . $this->db->escape_string($postData['dpemilihan']) . "',
            dvs_penyimpanan = '" . $this->db->escape_string($postData['dpenyimpanan']) . "',
            alamat ='" . $this->db->escape_string($postData['alamat']) . "' 
            WHERE id='" . $this->db->escape_string($id) . "'";
        $this->db->query($sql);
    }
}