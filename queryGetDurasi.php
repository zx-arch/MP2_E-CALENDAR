<?php

require_once "App/backend/query.php";
$methodQuery = new MethodQuery();
$account = "zaki";
$rentangTanggal = $methodQuery->getRentangTanggal($account);
?>

<script>
  var rentangTanggal = <?php echo json_encode($rentangTanggal); ?>;
  // Lakukan sesuatu dengan rentangTanggal di sini
  console.log(rentangTanggal);
</script>
