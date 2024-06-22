<?php
require_once "../../database/Database.php";

class SampahEkonomis {
    private $db;
    private $tampil;

    public function __construct() {
        $this->db = new Database();
    }

    public function tampilEkonomis($keyword = null) {
        if ($keyword) {
            $keyword = $this->db->escape_string($keyword);
            $query = "SELECT * FROM ekonomis WHERE nama_bs LIKE '%$keyword%'";
        } else {
            $query = "SELECT * FROM ekonomis ORDER BY id_laporan ASC";
        }
        return $this->db->query($query);
    }

    public function cariEkonomis($keyword) {
        $keyword = $this->db->escape_string($keyword);
        $query = "SELECT * FROM ekonomis WHERE nama_bs LIKE '$keyword%'";
        return $this->db->query($query);
    }

    public function hapusEkonomis($id) {
        $id = $this->db->escape_string($id);
        $query = "DELETE FROM ekonomis WHERE id_laporan='$id'";
        return $this->db->query($query);
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
                  kelurahan = '{$data['desa']}',
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

    public function loadData($id) {
        $id = $this->db->escape_string($id);
        $sql = $this->db->query("SELECT * FROM ekonomis WHERE id_laporan='$id'");
        $this->tampil = $sql->fetch_assoc();
        return $this->tampil;
    }

    public function getTampil() {
        return $this->tampil;
    }


    public function getDesaOptionsWithSelection($kecamatanId, $selectedDesa) {
        $options = '<option value="">Pilih Desa</option>';
        $resultDesa = $this->db->query("SELECT * FROM desa WHERE id = '$kecamatanId' ORDER BY nama ASC");

        while ($row = $resultDesa->fetch_assoc()) {
            $selected = ($row['id_desa'] == $selectedDesa) ? 'selected' : '';
            $options .= '<option value="' . $row['id_desa'] . '" ' . $selected . '>' . $row['nama'] . '</option>';
        }

        return $options;
    }

    public function ubahEkonomis($data) {
        $id_laporan = $this->db->escape_string($data['id_laporan']);
        $fname = $this->db->escape_string($data['fname']);
        $jenis = $this->db->escape_string($data['jenis']);
        $plastik = $this->db->escape_string($data['plastik']);
        $kertas = $this->db->escape_string($data['kertas']);
        $logam = $this->db->escape_string($data['logam']);
        $kaca = $this->db->escape_string($data['kaca']);
        $kayu = $this->db->escape_string($data['kayu']);
        $plastikmulti = $this->db->escape_string($data['plastikmulti']);
        $tgl = $this->db->escape_string($data['tgl']);
        $kecamatan_id = $this->db->escape_string($data['kecamatan']);
        $desa_id = $this->db->escape_string($data['desa']);

        $query_desa = "SELECT nama FROM desa WHERE id_desa = '$desa_id'";
        $result_desa = $this->db->query($query_desa);
        $row_desa = $result_desa->fetch_assoc();
        $nama_desa = $row_desa['nama'];

        $query_kecamatan = "SELECT nama FROM kecamatan WHERE id = '$kecamatan_id'";
        $result_kecamatan = $this->db->query($query_kecamatan);
        $row_kecamatan = $result_kecamatan->fetch_assoc();
        $nama_kecamatan = $row_kecamatan['nama'];

        $this->db->query("UPDATE ekonomis SET
            nama_bs = '$fname',
            jenis_bs = '$jenis',
            jns_plastik = '$plastik',
            jns_kertas = '$kertas',
            jns_logam = '$logam',
            jns_kaca = '$kaca',
            jns_kayu = '$kayu',
            jns_plastikmulti = '$plastikmulti',
            tgl_laporan = '$tgl',
            kecamatan = '$nama_kecamatan',
            kelurahan = '$nama_desa' WHERE id_laporan='$id_laporan'
        ");

        echo "<script>alert('Data berhasil diubah');document.location='lihatekonomis.php'</script>";
    }
}
?>
