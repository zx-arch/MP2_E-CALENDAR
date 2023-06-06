<?php

require_once "App/backend/query.php";
$methodquery = new MethodQuery();
if (isset($_SESSION["token_login"])) {
    header('Location: index');
}

if (isset($_POST['submit'])) {
    $check = $methodquery->checkLogin($_POST['username'], $_POST['password']);
    if ($check == true) {
        $_SESSION['token_login'] = bin2hex(random_bytes(32));
        $_SESSION['username'] = $_POST['username']; 
        setcookie('login','time_login',time()+3600);
        header('Location: index');
    } else {
        header('Location: login');
    }
}
?>
<!DOCTYPE html>
<html>

<head>
	<title>MP2 Calendar</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="App/css/style.css">
	<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/a81368914c.js"></script>
</head>

<body>
	<img class="wave" src="App/img/wave.png">
	<div class="container">
		<div class="img">
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
			</div>
		</div>
		<div class="login-content">
			<form action="" method="POST">
				<h2 class="title">Welcome</h2>
				<div class="input-div one">
					<div class="i">
						<i class="fas fa-user"></i>
					</div>
					<div class="div">
						<h5>Username</h5>
						<input type="text" name="username" id="username" class="input">
					</div>
				</div>
				<div class="input-div pass">
					<div class="i">
						<i class="fas fa-lock"></i>
					</div>
					<div class="div">
						<h5>Password</h5>
						<input type="password" name="password" id="password" class="input">
					</div>
				</div>
				<a href="#">Forgot Password?</a>

                <?php if(isset($_SESSION['success_create_account'])) : ?>
                    <p style="color: red; font-size: 13px; text-align: left;">Akun berhasil dibuat.</p>
                    <?php unset($_SESSION['success_create_account']); ?>
                <?php endif; ?>

				<input type="submit" class="btn" name="submit" value="Login">
				<input type="button" onclick="location.href='register'" class="btn-blue" value="Register">
			</form>
		</div>
	</div>
	<script type="text/javascript" src="App/js/main.js"></script>
	<script src="App/js/script.js"></script>
</body>

</html>