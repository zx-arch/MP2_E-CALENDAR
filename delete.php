<?php

require_once "App/backend/query.php";
$methodquery = new MethodQuery();

if (!isset($_SESSION["token_login"])) {
    header('Location: login');
} else {
    $error_date = "";
    $error_image = "";
	if (isset($_POST['id'])) {
		if (isset($_SESSION['token_hapus'])) {
            // print_r($_POST['id']);
            $delete = $methodquery->delete($_POST['id']);
             if ($delete) {
                    header('Location: ' . $_SERVER['HTTP_REFERER']);
            }
        }
	}
}


?>