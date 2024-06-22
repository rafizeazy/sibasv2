<?php
include "../../database/Database.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Database();
    $id = $_POST['id'];
    $desaOptions = "";

    $desa = $db->query("SELECT * FROM desa WHERE id='$id' ORDER BY nama ASC");
    while ($data = $desa->fetch_assoc()) {
        $desaOptions .= "<option value='{$data['nama']}'>{$data['nama']}</option>";
    }

    echo $desaOptions;
    $db->close();
}
?>
