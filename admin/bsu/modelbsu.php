<?php
include "../../database/Database.php";

class NasabahBSU {
    private $koneksi;

    public function __construct() {
        $database = new Database();
        $this->koneksi = $database->koneksi;
    }

    // Existing methods...

    public function lihatBsu() {
        $query = "SELECT * FROM bsu ORDER BY id ASC";
        return mysqli_query($this->koneksi, $query);
    }

    public function cariBsu($keyword) {
        $query = "SELECT * FROM bsu WHERE nama_bs LIKE '$keyword%'";
        return mysqli_query($this->koneksi, $query);
    }

    public function hapusBsu($id) {
        $query = "DELETE FROM bsu WHERE id='$id'";
        return mysqli_query($this->koneksi, $query);
    }

    public function tambahBsu($data, $files) {
        $direktori = "berkas/";
        $file_name = $files['ktp']['name'];
        move_uploaded_file($files['ktp']['tmp_name'], $direktori . $file_name);
        $nama_file = $files['sk']['name'];
        move_uploaded_file($files['sk']['tmp_name'], $direktori . $nama_file);

        $kecamatan_id = $data['kecamatan'];
        $query_kecamatan = "SELECT nama FROM kecamatan WHERE id = '$kecamatan_id'";
        $result_kecamatan = mysqli_query($this->koneksi, $query_kecamatan);
        $row_kecamatan = mysqli_fetch_assoc($result_kecamatan);
        $nama_kecamatan = $row_kecamatan['nama'];

        $query = "INSERT INTO bsu SET
            id = '{$data['kode']}',
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
        ";

        mysqli_query($this->koneksi, $query);
        echo "<script>alert('Data Berhasil Disimpan'); document.location='lihatbsu.php'</script>";
    }

    public function generateKodeauto() {
        $query = "SELECT MAX(SUBSTRING(id, 5)) as max_urut FROM bsu WHERE SUBSTRING(id, 1, 4) = 'BSUK'";
        $result = mysqli_query($this->koneksi, $query);
        $row = mysqli_fetch_assoc($result);
        $max_urut = $row['max_urut'];
        $new_urut = ($max_urut == null) ? 1 : $max_urut + 1;
        return 'BSUK' . sprintf('%03d', $new_urut);
    }

    public function getKecamatanOptions() {
        $options = "";
        $result = mysqli_query($this->koneksi, "SELECT * FROM kecamatan ORDER BY nama ASC");
        while ($data = mysqli_fetch_assoc($result)) {
            $options .= "<option value='{$data['id']}'>{$data['nama']}</option>";
        }
        return $options;
    }

    // New methods for fetching and updating BSU data

    public function fetchBsuData($id) {
        $query = "SELECT * FROM bsu WHERE id='$id'";
        $result = mysqli_query($this->koneksi, $query);
        return mysqli_fetch_assoc($result);
    }

    public function ubahBsu($id, $data) {
        $desa_id = $data['desa'];
        $kecamatan_id = $data['kecamatan'];

        $query_desa = "SELECT nama FROM desa WHERE id_desa = '$desa_id'";
        $result_desa = mysqli_query($this->koneksi, $query_desa);
        $row_desa = mysqli_fetch_assoc($result_desa);
        $nama_desa = $row_desa['nama'];

        $query_kecamatan = "SELECT nama FROM kecamatan WHERE id = '$kecamatan_id'";
        $result_kecamatan = mysqli_query($this->koneksi, $query_kecamatan);
        $row_kecamatan = mysqli_fetch_assoc($result_kecamatan);
        $nama_kecamatan = $row_kecamatan['nama'];

        $query = "UPDATE bsu SET
            nama_bs = '{$data['nama']}',
            kecamatan = '$nama_kecamatan',
            desa = '$nama_desa',
            email = '{$data['email']}',
            kontak = '{$data['kontak']}',
            png_jawab = '{$data['pjawab']}',
            mng_produksi = '{$data['mproduksi']}',
            mng_keuangan = '{$data['mkeuangan']}',
            t_usaha = '{$data['tata_usaha']}',
            dvs_pemilihan = '{$data['dpemilihan']}',
            dvs_penyimpanan = '{$data['dpenyimpanan']}',
            alamat = '{$data['alamat']}' WHERE id='$id'
        ";

        mysqli_query($this->koneksi, $query);
        echo "<script>alert('Data Berhasil Disimpan'); document.location='lihatbsu.php'</script>";
    }
}
?>
