<?php

require_once "App/backend/query.php";
$methodquery = new MethodQuery();

if (!isset($_SESSION["token_login"]) or !isset($_COOKIE['login'])) {
    header('Location: login');
} else {
    $error_date = "";
	if (isset($_POST['submit'])) {
		if (isset($_SESSION['token_tambah'])) {
            $error_date .= $methodquery->validateDate($_POST);
            $methodquery->insertNewData($_POST,$_SESSION['username']);
            if ($error_date == "") {
                header('Location: index');
                $_SESSION['tambah_berhasil'] = true;
            }
        }
	}
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MP2 Calendar</title>
    <link rel="stylesheet" href="App/css/style3.css">
</head>

<body>
    <h1>Tambah Agenda</h1>
    <div class="form-container">
        <form action="" method="POST">
            <?php $_SESSION['token_tambah'] = bin2hex(random_bytes(32)); ?>
            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" id="nama" name="nama" required placeholder="Masukkan nama agenda" value="<?= ($error_date != '') ? $_POST['nama'] : "" ?>">
            </div>

            <?php if($error_date == "") : ?>
                <div class="form-group">
                    <label for="tgl_mulai">Tanggal mulai:</label>
                    <input type="date" id="tgl_mulai" name="tgl_mulai" required placeholder="Masukkan tgl mulai agenda">
                </div>
                <div class="form-group">
                    <label for="tgl_selesai">Tanggal selesai:</label>
                    <input type="date" id="tgl_selesai" name="tgl_selesai" required placeholder="Masukkan tgl selesai agenda">
                </div>
            <?php else : ?>
                <div class="form-group">
                    <label for="tgl_mulai">Tanggal mulai:</label>
                    <input type="date" id="tgl_mulai" name="tgl_mulai" required placeholder="Masukkan tgl mulai agenda" style="border: 1px solid red;" value="<?= ($error_date != '') ? $_POST['tgl_mulai'] : "" ?>">
                </div>
                <div class="form-group">
                    <label for="tgl_selesai">Tanggal selesai:</label>
                    <input type="date" id="tgl_selesai" name="tgl_selesai" required placeholder="Masukkan tgl selesai agenda" style="border: 1px solid red;" value="<?= ($error_date != '') ? $_POST['tgl_selesai'] : "" ?>">
                </div>
            <?php endif; ?>

            <div class="form-group">
                <label>Level:</label>
                <?php if($error_date == "") : ?>
                    <input type="radio" id="level-biasa" name="level" value="biasa"> Biasa
                    <input type="radio" id="level-sedang" name="level" value="sedang"> Sedang
                    <input type="radio" id="level-sangat_penting" name="level" value="sangat_penting"> Sangat penting
                <?php elseif($error_date != "") : ?>
                    <?php if($_POST['level'] == "biasa") : ?>
                        <input type="radio" id="level-biasa" name="level" checked value="biasa"> Biasa
                        <input type="radio" id="level-sedang" name="level" value="sedang"> Sedang
                        <input type="radio" id="level-sangat_penting" name="level" value="sangat_penting"> Sangat penting
                    <?php elseif($_POST['level'] == "sedang") : ?>
                        <input type="radio" id="level-biasa" name="level" value="biasa"> Biasa
                        <input type="radio" id="level-sedang" name="level" checked value="sedang"> Sedang
                        <input type="radio" id="level-sangat_penting" name="level" value="sangat_penting"> Sangat penting
                    <?php elseif($_POST['level'] == "sangat_penting") : ?>
                        <input type="radio" id="level-biasa" name="level" value="biasa"> Biasa
                        <input type="radio" id="level-sedang" name="level" value="sedang"> Sedang
                        <input type="radio" id="level-sangat_penting" name="level" checked value="sangat_penting"> Sangat penting
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        
            <div class="form-group">
                <label for="durasi">Durasi:</label>
                <input type="number" id="durasi_jam" required name="durasi_jam" value="<?= ($error_date != '') ? $_POST['durasi_jam'] : "" ?>"> Jam
                <input type="number" id="durasi_menit" required name="durasi_menit" value="<?= ($error_date != '') ? $_POST['durasi_menit'] : "" ?>"> Menit
            </div>

            <div class="form-group">
                <label for="lokasi">Lokasi:</label>
                <textarea name="lokasi" id="lokasi" cols="20" rows="10" required placeholder="Masukkan lokasi agenda"><?= ($error_date != '') ? $_POST['lokasi'] : "" ?></textarea>
            </div>

            <div class="form-group">
                <label for="photo">Foto Profil:</label>
                <input type="file" id="photo" name="photo">
            </div>

            <div class="form-group">
                <input type="submit" name="submit" id="submit" value="Submit">
                <input type="button" class="button-back" onclick="location.href='index'" value="Kembali">
            </div>
        </form>

        <?php if($error_date != "") : ?>
            <p style="color: red; font-style: italic;"><?= $error_date; ?></p>
        <?php endif; ?>
    </div>
</body>

</html>