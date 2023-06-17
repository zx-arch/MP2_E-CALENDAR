<?php

require_once "App/backend/query.php";
$methodquery = new MethodQuery();

if (!isset($_SESSION["token_update"])) {
    header('Location: login');
} else {
    $error_date = "";
    $error_image = "";
    if (isset($_POST['simpan'])) {
<<<<<<< HEAD
        $methodquery->updateData($_POST, $_FILES);
=======
         $error_date .= $methodquery->validateDate($_POST);
        if (!empty($_FILES)) {
            $error_image .= $methodquery->validateImage($_FILES);
        }
        $methodquery->updateData($_POST);
>>>>>>> 29041b20dc05f23ca81c4e365f9e45d49b8aae59
        header('Location: index');
    }
}
?>