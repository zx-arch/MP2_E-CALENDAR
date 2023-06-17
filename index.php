<?php

require_once "App/backend/query.php";
$methodquery = new MethodQuery();

if (!isset($_SESSION["token_login"])) {
    header('Location: login');

} else {
	$month = array("Januari"=>"01", "Februari"=>"02", "Maret"=>"03", "April"=>"04","Mei"=>"05","Juni"=>"06","Juli"=>"07","Agustus"=>"08","September"=>"09","October"=>"10","November"=>"11","Desember"=>"12");
	$getdate = "";

	if (isset($_GET['data'])) {
		$_SESSION['getmonth'] = $_GET['data'];
		if ($_GET['data'] !== '' and strlen($_GET['data']) !== 0) {
			if (strpos($_GET['data'],'-')) {
				$getyear = (string) explode("-",$_GET['data'])[1] . '-';
				$getmonth = (string) explode("-",$_GET['data'])[0];
				foreach ($month as $key => $value) {
					if ($key == $getmonth) {
						$getdate .= $getyear . $value;
						break;
					}
				}
			} else {
				header('Location: index');
			}
		} else {
			header('Location: index');
		}
    }

	if (isset($_POST['search'])) {
		
	} else {
		$data = $methodquery->getAll($_SESSION['username'], $getdate);
	}

	if (isset($_POST['detail'])) {
		$_SESSION['detailditekan'] = true;
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
    <link rel="stylesheet" type="text/css" href="App/css/style2.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>
    <link rel="stylesheet" type="text/css" href="App/css/style4.css">

</head>

<body>
    <div class="container">
        <div class="img">

            <?php if(!isset($_GET['data'])) : ?>

            <button onclick="window.location='logout'" style="position: absolute;" class="btn-logout">Logout</button>
            <h2 style="text-align: center;">Welcome <?= $_SESSION['username']; ?></h2>
            <button onclick="location.href='tambah'" class="btn-orange">Tambah Aktifitas</button>
            <div class="calendar">
                <div class="header">
                    <button class="prev" onclick="prevMonth()">&lt;</button>
                    <h1 id="month-year"></h1>
                    <button class="next" onclick="nextMonth()">&gt;</button>
                </div>
                <table id="calendar-table">
                    <thead>
                        <tr>
                            <th>Sun</th>
                            <th>Mon</th>
                            <th>Tue</th>
                            <th>Wed</th>
                            <th>Thu</th>
                            <th>Fri</th>
                            <th>Sat</th>
                        </tr>
                    </thead>
                    <tbody id="calendar-body"></tbody>
                </table>
            </div><br>
            <button id="showData" class="btn-green"></button>

            <?php if(isset($_SESSION['tambah_berhasil'])) : ?>
            <h4 style="color: blue; text-align: left;margin-left: 33%;margin-top: 14px;">Data berhasil ditambah.</h4>
            <?php unset($_SESSION['tambah_berhasil']); ?>
            <?php endif; ?>

            <?php endif; ?>

            <?php if(isset($_GET['data'])) : ?>
            <h2 style="text-align: center;">Agenda Bulan <?= str_replace('-',' ',$_GET['data']); ?></h2><br>
            <div class="form-group">
                <form action="" method="post" id="formSearch">
                    <input type="text" name="search" id="search" placeholder="Search..."><br>
                </form>
            </div>

            <button class="button-back" onclick="window.location='index'">Kembali</button><br><br>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kegiatan</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Level</th>
                            <th>Durasi</th>
                            <th>Lokasi</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=0; ?>
                        <?php foreach($data as $dt) : ?>
                        <?php $i++; ?>
                        <tr>
                            <td><?= $i; ?></td>
                            <td><?= $dt['nama']; ?></td>
                            <td><?= $dt['tgl_mulai']; ?></td>
                            <td><?= $dt['tgl_selesai']; ?></td>
                            <td><?= $dt['level']; ?></td>
                            <td><?= round($dt['durasi']/60,0); ?> Jam <?= $dt['durasi']%60; ?> Menit</td>
                            <td><?= $dt['lokasi']; ?></td>
                            <td>
                                <div class="form-action">
                                    <form action="detail" method="post">
                                        <input type="hidden" name="id" value="<?= $dt['id']; ?>">
                                        <input type="submit" name="detail" id="detail" class="btn-orange"
                                            value="Detail">
                                    </form>

                                    <form action="delete" method="post">
                                        <?php $_SESSION['token_hapus'] = bin2hex(random_bytes(32)); ?>
                                        <input type="hidden" name="id" value="<?= $dt['id']; ?>">
                                        <input type="submit" class="btn-green" value="Delete">
                                    </form>
                                </div>
                            </td>
                            <!-- <td><a href="">Detail</a> | <a href="">Delete</a></td> -->
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <script type="text/javascript" src="App/js/main.js"></script>
    <script src="App/js/script.js"></script>
</body>

</html>