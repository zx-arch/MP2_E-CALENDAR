<?php

require_once "App/backend/query.php";
$methodquery = new MethodQuery();

if (!isset($_SESSION["token_login"])) {
    header('Location: login');
} else {
    $error_date = "";
    $error_image = "";
    $error_duration = "";
	if (isset($_POST['submit'])) {
		if (isset($_SESSION['token_tambah'])) {
            $error_date .= $methodquery->validateDate($_POST);
            if ($_POST['durasi_menit'] > 59) {
                $error_duration .= "* Durasi menit tidak boleh lebih dari 59 menit";
            } if($_FILES['gambar']['name'] == '') {
                $methodquery->insertNewDataWithoutImage($_POST,$_SESSION['username']);
                if ($error_date == "") {
                    header('Location: index');
                    $_SESSION['tambah_berhasil'] = true;
                }
            } else {
                $error_date .= $methodquery->validateDate($_POST);
                $error_image .= $methodquery->validateImage($_FILES);
                $methodquery->insertNewData($_POST,$_FILES,$_SESSION['username']);
                if ($error_date == "" and $error_image =="") {
                        header('Location: index');
                        $_SESSION['tambah_berhasil'] = true;
                }
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
        <form action="" method="POST" enctype="multipart/form-data">
            <?php $_SESSION['token_tambah'] = bin2hex(random_bytes(32)); ?>

            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" id="nama" name="nama" required placeholder="Masukkan nama agenda"
                    value="<?= ($error_date != '' or $error_image !='' or $error_duration != '') ? $_POST['nama'] : "" ?>">
            </div>

            <?php if($error_date == "" and !isset($_POST['submit'])) : ?>
            <div class="form-group">
                <label for="tgl_mulai">Tanggal mulai:</label>
                <input type="date" id="tgl_mulai" name="tgl_mulai" required placeholder="Masukkan tgl mulai agenda">
            </div>
            <div class="form-group">
                <label for="tgl_selesai">Tanggal selesai:</label>
                <input type="date" id="tgl_selesai" name="tgl_selesai" required
                    placeholder="Masukkan tgl selesai agenda">
            </div>
            <?php elseif($error_date == "" and isset($_POST['submit'])) : ?>
            <div class="form-group">
                <label for="tgl_mulai">Tanggal mulai:</label>
                <input type="date" id="tgl_mulai" value="<?= $_POST['tgl_mulai']; ?>" name="tgl_mulai" required
                    placeholder="Masukkan tgl mulai agenda">
            </div>
            <div class="form-group">
                <label for="tgl_selesai">Tanggal selesai:</label>
                <input type="date" id="tgl_selesai" value="<?= $_POST['tgl_selesai']; ?>" name="tgl_selesai" required
                    placeholder="Masukkan tgl selesai agenda">
            </div>
            <?php elseif($error_date != "") : ?>
            <div class="form-group">
                <label for="tgl_mulai">Tanggal mulai:</label>
                <input type="date" id="tgl_mulai" name="tgl_mulai" required placeholder="Masukkan tgl mulai agenda"
                    style="border: 1px solid red;"
                    value="<?= ($error_date != ''  or $error_image != '' or $error_duration != '') ? $_POST['tgl_mulai'] : "" ?>">
            </div>
            <div class="form-group">
                <label for="tgl_selesai">Tanggal selesai:</label>
                <input type="date" id="tgl_selesai" name="tgl_selesai" required
                    placeholder="Masukkan tgl selesai agenda" style="border: 1px solid red;"
                    value="<?= ($error_date != ''  or $error_image != '' or $error_duration != '') ? $_POST['tgl_selesai'] : "" ?>">
            </div>
            <?php endif; ?>

            <div class="form-group">
                <label>Level:</label>
                <?php if($error_date == "" and !isset($_POST['submit'])) : ?>
                <input type="radio" id="level-biasa" name="level" value="biasa"> Biasa
                <input type="radio" id="level-sedang" name="level" value="sedang"> Sedang
                <input type="radio" id="level-sangat_penting" name="level" value="sangat_penting"> Sangat penting
                <?php elseif($error_date != "" and isset($_POST['submit'])) : ?>
                <?php if($_POST['level'] == "biasa" or $_POST['level'] == "Biasa") : ?>
                <input type="radio" id="level-biasa" name="level" checked value="biasa"> Biasa
                <input type="radio" id="level-sedang" name="level" value="sedang"> Sedang
                <input type="radio" id="level-sangat_penting" name="level" value="sangat_penting"> Sangat penting
                <?php elseif($_POST['level'] == "sedang" or $_POST['level'] == "Sedang") : ?>
                <input type="radio" id="level-biasa" name="level" value="biasa"> Biasa
                <input type="radio" id="level-sedang" name="level" checked value="sedang"> Sedang
                <input type="radio" id="level-sangat_penting" name="level" value="sangat_penting"> Sangat penting
                <?php elseif($_POST['level'] == "sangat_penting" or $_POST['level'] == "Sangat_penting" or $_POST['level'] = "Sangat penting") : ?>
                <input type="radio" id="level-biasa" name="level" value="biasa"> Biasa
                <input type="radio" id="level-sedang" name="level" value="sedang"> Sedang
                <input type="radio" id="level-sangat_penting" name="level" checked value="sangat_penting"> Sangat
                penting
                <?php endif; ?>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="durasi">Durasi:</label>
                <input type="number" id="durasi_jam" required name="durasi_jam"
                    value="<?= ($error_date != '' or $error_image != '' or $error_duration != '') ? $_POST['durasi_jam'] : "" ?>">
                Jam
                <input type="number" id="durasi_menit" required name="durasi_menit"
                    value="<?= ($error_date != '' or $error_image != '' or $error_duration != '') ? $_POST['durasi_menit'] : "" ?>">
                Menit
            </div>

            <div class="form-group">
                <label for="lokasi">Lokasi:</label>
                <textarea name="lokasi" id="lokasi" cols="20" rows="10" required
                    placeholder="Masukkan lokasi agenda"><?= ($error_date != '' or $error_image != '' or $error_duration != '') ? $_POST['lokasi'] : "" ?></textarea>
            </div>

            <?php if($error_image != "") : ?>
            <div class="form-group">
                <label for="gambar">Foto Profil:</label>
                <input type="file" style="border: 1px solid red;" id="gambar" name="gambar">
            </div>
            <?php else : ?>
            <div class="form-group">
                <label for="gambar">Foto Profil:</label>
                <input type="file" id="gambar" name="gambar">
            </div>
            <?php endif; ?>


            <div class="form-group">
                <input type="submit" name="submit" id="submit" value="Submit">
                <input type="button" class="button-back" onclick="location.href='index'" value="Kembali">
            </div>
        </form>

        <?php if($error_image != "") : ?>
        <p style="color: red; font-style: italic;"><?= $error_image; ?></p>
        <?php endif; ?>

        <?php if($error_date != "") : ?>
        <p style="color: red; font-style: italic;"><?= $error_date; ?></p>
        <?php endif; ?>

        <?php if($error_duration != "") : ?>
        <p style="color: red; font-style: italic;"><?= $error_duration; ?></p>
        <?php endif; ?>

    </div>
</body>

</html>