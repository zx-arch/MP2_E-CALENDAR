<?php 

require_once 'constants.php';
session_start();
$_SESSION = [];
session_unset();
session_destroy();

$script = "<script>
window.location = '".BASEURL."';</script>";
echo $script;