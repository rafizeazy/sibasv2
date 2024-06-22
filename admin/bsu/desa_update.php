<?php
include "../../database/Database.php";

class DesaUpdate {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getDesaOptions($kecamatanId) {
        $options = '<option value="">Pilih Desa</option>';
        $result = $this->db->query("SELECT * FROM desa WHERE id = '$kecamatanId' ORDER BY nama ASC");

        if ($result) {
            while ($row = $this->db->fetch_assoc($result)) {
                $options .= '<option value="' . $row['id_desa'] . '">' . $row['nama'] . '</option>';
            }
        } else {
            $options .= '<option value="">Data Desa tidak ditemukan</option>';
        }

        return $options;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $desaUpdate = new DesaUpdate();
    echo $desaUpdate->getDesaOptions($_POST['id']);
}
?>
