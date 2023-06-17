<?php

require_once "App/backend/query.php";
$methodquery = new MethodQuery();

if (!isset($_SESSION["token_update"])) {
    header('Location: login');
} else {
    $error_date = "";
    $error_image = "";
    if (isset($_POST['simpan'])) {

        $methodquery->updateData($_POST, $_FILES);

        header('Location: index');
    }
}
?>