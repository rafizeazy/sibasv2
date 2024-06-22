<head>
<link rel="stylesheet" href="../../assets/css/detail.css">
</head>


<?php
include "../../database/Database.php";
// Include the BankSampah class
class BankSampah {
    private $db;
    private $data;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getDetails($id) {
        $id = $this->db->escape_string($id);
        $query = "SELECT * FROM bsi WHERE id = '$id'";
        $result = $this->db->query($query);
        $this->data = $this->db->fetch_assoc($result);
        
        if(!$this->data) {
            die("Data tidak ditemukan!");
        }
        return $this->data;
    }

    public function displayDetails() {
        echo "
        <div class='content read'>
            <h2>Detail Bank Sampah BSI</h2>
            <table>
                <tr><th>ID</th><td>{$this->data['id']}</td></tr>
                <tr><th>Nama Bank Sampah</th><td>{$this->data['nama_bs']}</td></tr>
                <tr><th>Kecamatan</th><td>{$this->data['kecamatan']}</td></tr>
                <tr><th>Email</th><td>{$this->data['email']}</td></tr>
                <tr><th>Kontak</th><td>{$this->data['kontak']}</td></tr>
                <tr><th>Penanggung Jawab</th><td>{$this->data['png_jawab']}</td></tr>
                <tr><th>Jumlah Nasabah</th><td>{$this->data['jmlh_nasabah']}</td></tr>
                <tr><th>Manager Produksi</th><td>{$this->data['mng_produksi']}</td></tr>
                <tr><th>Manager Keuangan</th><td>{$this->data['mng_keuangan']}</td></tr>
                <tr><th>Tata Usaha</th><td>{$this->data['t_usaha']}</td></tr>
                <tr><th>Divisi Pemilihan</th><td>{$this->data['dvs_pemilihan']}</td></tr>
                <tr><th>Divisi Penyimpanan</th><td>{$this->data['dvs_penyimpanan']}</td></tr>
                <tr><th>Alamat</th><td>{$this->data['alamat']}</td></tr>
                <tr><th>Jam Kerja</th><td>{$this->data['jam_kerja']}</td></tr>
                <tr><th>KTP</th>
                    <td class='detail'>
                        <img src='berkas/{$this->data['ktp']}' alt='Foto Bank Sampah'>
                    </td>
                </tr>
                <tr><th>Surat Keterangan</th>
                    <td class='sk'>
                        <img src='berkas/{$this->data['sk']}' alt='Surat Keterangan'>
                    </td>
                </tr>
            </table>
            <a href='lihatbsi.php' class='back-link'>Back</a>
        </div>";
    }
}

// Main logic
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $database = new Database();
    $bankSampah = new BankSampah($database);
    $bankSampah->getDetails($id);
    $bankSampah->displayDetails();
    $database->close();
}
?>
