<?php
require_once "../../database/Database.php";

class SampahOrganik {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function tampilOrganik($keyword = null) {
        if ($keyword) {
            $query = "SELECT * FROM organik WHERE nama_bs LIKE '%$keyword%'";
        } else {
            $query = "SELECT * FROM organik ORDER BY id_laporan ASC";
        }
        return mysqli_query($this->db->koneksi, $query);
    }

    public function cariOrganik($keyword) {
        $query = "SELECT * FROM organik WHERE nama_bs LIKE '$keyword%'";
        return mysqli_query($this->db->koneksi, $query);
    }

    public function hapusOrganik($id) {
        $query = "DELETE FROM organik WHERE id_laporan='$id'";
        return mysqli_query($this->db->koneksi, $query);
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

        $desa = isset($data['desa']) ? $data['desa'] : '';

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

    public function getOrganikById($id) {
        $id = $this->db->escape_string($id);
        $sql = $this->db->query("SELECT * FROM organik WHERE id_laporan='$id'");
        return $sql->fetch_assoc();
    }


    public function updateOrganik($data) {
        $id_laporan = $this->db->escape_string($data['id_laporan']);
        $fname = $this->db->escape_string($data['fname']);
        $jenis = $this->db->escape_string($data['jenis']);
        $jumlah = $this->db->escape_string($data['jumlah']);
        $tgl = $this->db->escape_string($data['tgl']);
        $kecamatan_id = $this->db->escape_string($data['kecamatan']);
        $desa_id = $this->db->escape_string($data['desa']);

        $query_desa = "SELECT nama FROM desa WHERE id_desa='$desa_id'";
        $result_desa = $this->db->query($query_desa);
        $row_desa = $result_desa->fetch_assoc();
        $nama_desa = $row_desa['nama'];

        $query_kecamatan = "SELECT nama FROM kecamatan WHERE id='$kecamatan_id'";
        $result_kecamatan = $this->db->query($query_kecamatan);
        $row_kecamatan = $result_kecamatan->fetch_assoc();
        $nama_kecamatan = $row_kecamatan['nama'];

        $this->db->query("UPDATE organik SET
            nama_bs='$fname',
            jenis_bs='$jenis',
            jumlah='$jumlah',
            tgl_laporan='$tgl',
            kecamatan='$nama_kecamatan',
            kelurahan='$nama_desa'
            WHERE id_laporan='$id_laporan'
        ");

        echo "<script>alert('Data berhasil diubah');document.location='lihatorganik.php'</script>";
    }
}
?>
