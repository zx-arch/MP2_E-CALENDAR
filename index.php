<?php

session_start();
if (!isset($_SESSION["token_login"])) {
    header('Location: login');
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
</head>

<body>
	<a href="logout" style="position: absolute;">Logout</a>
	<h2 style="text-align: center;">Welcome <?= $_SESSION['username']; ?></h2>
	<div class="container">
		<div class="img">
			<div class="calendar">
				<button onclick="location.href='tambah'">Tambah Aktifitas</button>
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
				<?php if(isset($_SESSION['tambah_berhasil'])) : ?>
					<h4 style="color: blue; text-align: left;">Data berhasil ditambah.</h4>
                    <?php unset($_SESSION['tambah_berhasil']); ?>
                <?php endif; ?>
			</div>
		</div>
	</div>
    <script type="text/javascript" src="App/js/main.js"></script>
    <script src="App/js/script.js"></script>
</body>

</html>