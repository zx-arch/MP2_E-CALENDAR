<?php

require_once "App/backend/query.php";
$methodquery = new MethodQuery();

if (!isset($_SESSION["token_login"])) {
    header('Location: login');
} else {
    $data = mysqli_fetch_assoc($methodquery->getDataById($_SESSION['username'], $_POST['id']));
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MP2 Calendar</title>
    <link rel="stylesheet" href="App/css/style3.css">
</head>

<body>

    <h1>Detail Agenda</h1>
    <div class="form-container">
        <form action="update" method="post">
            <center>
                <img src="App/img/<?= $data['gambar']; ?>" disabled alt="" width=100 height=100
                    style="border-radius: 10px;"><br>
            </center>
            <br>
            <input type="hidden" name="id" id="id" value="<?= $data['id']; ?>">
            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" name="nama" disabled id="nama" value="<?= $data['nama'] ?>">
            </div>

            <div class="form-group">
                <label for="tgl_mulai">Tanggal mulai:</label>
                <input type="date" name="tgl_mulai" disabled id="tgl_mulai" value="<?= $data['tgl_mulai'] ?>">
            </div>

            <div class="form-group">
                <label for="tgl_selesai">Tanggal selesai:</label>
                <input type="date" name="tgl_selesai" disabled id="tgl_selesai" value="<?= $data['tgl_selesai'] ?>">
            </div>

            <div class="form-group">
                <label for="level">Level:</label>

                <?php if($data['level'] == 'Biasa') : ?>
                <input type="radio" name="level" disabled checked id="level" value="biasa"> Biasa
                <input type="radio" name="level" disabled id="level" value="Sedang"> Sedang
                <input type="radio" name="level" disabled id="level" value="sangat_penting"> Sangat penting
                <?php elseif($data['level'] == 'Sedang') : ?>
                <input type="radio" name="level" disabled id="level" value="biasa"> Biasa
                <input type="radio" name="level" disabled checked id="level" value="sedang"> Sedang
                <input type="radio" name="level" disabled id="level" value="Sangat penting"> Sangat penting
                <?php elseif($data['level'] == 'Sangat penting') : ?>
                <input type="radio" name="level" disabled id="level" value="biasa"> Biasa
                <input type="radio" name="level" disabled id="level" value="Sedang"> Sedang
                <input type="radio" name="level" disabled checked id="level" value="sangat_penting"> Sangat penting
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="durasi">Durasi:</label>
                <input type="text" name="durasi" id="durasi" disabled
                    value="<?= round((int) $data['durasi']/60, 0) . ' Jam '.strval((int) $data['durasi']%60).' menit '; ?>">
            </div>

            <div class="form-group">
                <label for="lokasi">Lokasi:</label>
                <textarea name="lokasi" id="lokasi" cols="20" rows="10" disabled><?= $data['lokasi']; ?></textarea>
            </div>

            <div class="form-group" style="float: left;margin-right: 10px;">
                <input type="submit" name="update" id="update" value="Update">
            </div>
        </form>

        <form action="index" method="get">
            <input type="hidden" name="data" id="data" value="<?= $_SESSION['getmonth']; ?>">
            <input type="submit" class="button-back" value="Kembali">
        </form>
    </div>

</body>

</html>