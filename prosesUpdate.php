<?php

require_once "App/backend/query.php";
$methodquery = new MethodQuery();

if (!isset($_SESSION["token_update"])) {
    header('Location: login');
} else {
    $error_date = "";
    $error_image = "";
    if (isset($_POST['simpan'])) {
         $error_date .= $methodquery->validateDate($_POST);
        if (!empty($_FILES)) {
            $error_image .= $methodquery->validateImage($_FILES);
        }
        $methodquery->updateData($_POST);
        header('Location: index');
    }
}
?>