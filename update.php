<?php

require_once "App/backend/query.php";
$methodquery = new MethodQuery();

if (!isset($_SESSION["token_login"])) {
    header('Location: login');
} else {
    if (isset($_POST['update'])) {
        $data = mysqli_fetch_assoc($methodquery->getDataById($_SESSION['username'], $_POST['id']));
    }
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

    <h1>Update Agenda</h1>
    <div class="form-container">

        <form action="prosesUpdate" method="post" enctype="multipart/form-data">    
            <?php $_SESSION['token_update'] = bin2hex(random_bytes(32)); ?>
            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" name="nama" id="nama" value="<?= $data['nama'] ?>">
            </div>

            <div class="form-group">
                <label for="tgl_mulai">Tanggal mulai:</label>
                <input type="date" name="tgl_mulai" id="tgl_mulai" value="<?= $data['tgl_mulai'] ?>">
            </div>

            <div class="form-group">
                <label for="tgl_selesai">Tanggal selesai:</label>
                <input type="date" name="tgl_selesai" id="tgl_selesai" value="<?= $data['tgl_selesai'] ?>">
            </div>

            <div class="form-group">
                <label for="level">Level:</label>

                <?php if($data['level'] == 'Biasa') : ?>

                    <input type="radio" name="level" checked id="level" value="biasa"> Biasa
                    <input type="radio" name="level" id="level" value="Sedang"> Sedang
                    <input type="radio" name="level" id="level" value="sangat_penting"> Sangat penting
                    <?php elseif($data['level'] == 'Sedang') : ?>
                    <input type="radio" name="level" id="level" value="biasa"> Biasa
                    <input type="radio" name="level" checked id="level" value="sedang"> Sedang
                    <input type="radio" name="level" id="level" value="Sangat penting"> Sangat penting
                    <?php elseif($data['level'] == 'Sangat penting') : ?>
                    <input type="radio" name="level" id="level" value="biasa"> Biasa
                    <input type="radio" name="level" id="level" value="Sedang"> Sedang
                    <input type="radio" name="level" checked id="level" value="sangat_penting"> Sangat penting
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="durasi">Durasi:</label>
                    <input type="number" id="durasi_jam" name="durasi_jam"
                        value="<?= round((int) $data['durasi']/60, 0); ?>"> Jam
                    <input type="number" id="durasi_menit" name="durasi_menit" value="<?= (int) $data['durasi']%60; ?>">
                    Menit
                </div>

                <div class="form-group">
                    <label for="lokasi">Lokasi:</label>
                    <textarea name="lokasi" id="lokasi" cols="20" rows="10"><?= $data['lokasi']; ?></textarea>
                </div>

                <div class="form-group">
                    <label for="gambar">Foto Profil:</label>
                    <input type="file" id="gambar" name="gambar" value="<?= $data['gambar']; ?>">
                </div>

                <div class="form-group" style="float: left;margin-right: 10px;">
                    <input type="hidden" name="id" id="id" value="<?= $data['id']; ?>">
                    <input type="submit" name="simpan" id="simpan" value="Simpan">
                </div>
            </form>

            <form action="detail" method="post">
                <input type="hidden" name="id" id="id" value="<?= $data['id']; ?>">

                <input type="submit" name="simpan" id="simpan" value="Simpan">
            </div>
        </form>
        
        <form action="detail" method="post">
            <input type="hidden" name="id" id="id" value="<?= $data['id']; ?>">
            <input type="submit" class="button-back" value="Kembali">
        </form>


    </div>

</body>

</html>