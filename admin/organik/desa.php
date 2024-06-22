<?php
include "modelorganik.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $formOrganik = new SampahOrganik();
    echo $formOrganik->getDesaOptions($_POST['id']);
}
?>
