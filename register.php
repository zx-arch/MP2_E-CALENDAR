<?php

require_once "App/backend/query.php";
$methodquery = new MethodQuery();

if (isset($_SESSION["token_login"])) {
    header('Location: index');
}

$error_register = false;
$username_available = false;

if (isset($_POST['register'])) {
    if ($_POST['password'] !== $_POST['conf_password']) {
        $error_register = true;
    } else {
        $check = $methodquery->checkAccount($_POST['username']);
        if ($check === false) { 
            $_SESSION["token_register"] = bin2hex(random_bytes(32));
            $_SESSION['success_create_account'] = true;
            $methodquery->insertNewUser($_POST);
            header('Location: login');
        } else {
            $username_available = true;
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

                <?php if ($error_register == false && $username_available == false) : ?>
                    <div class="input-div one">
                        <div class="i">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="div">
                            <h5>Username</h5>
                            <input type="text" name="username" id="username" required pattern="[A-Za-z0-9\-_\.]{4,}" title="Username minimal 4 karakter yang hanya boleh ada alfabet dan angka" class="input">
                        </div>
                    </div>
                    <div class="input-div pass">
                        <div class="i">
                            <i class="fas fa-lock"></i>
                        </div>
                        <div class="div">
                            <h5>Password</h5>
                            <input type="password" name="password" id="password" required pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$" title="Password minimal 8 karakter minimal 1 huruf 1 angka" class="input">
                        </div>
                    </div>
                    <div class="input-div pass">
                        <div class="i">
                            <i class="fas fa-lock"></i>
                        </div>
                        <div class="div">
                            <h5>Confirm Password</h5>
                            <input type="password" name="conf_password" id="conf_password" required pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$" title="Password minimal 8 karakter minimal 1 huruf 1 angka" class="input">
                        </div>
                    </div>

                <?php elseif ($error_register == true) : ?>
                    <div class="input-div one">
                        <div class="i">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="div">
                            <input type="text" value="<?= $_POST['username']; ?>" name="username" id="username" class="input">
                        </div>
                    </div>
                    <div class="input-div pass">
                        <div class="i">
                            <i class="fas fa-lock"></i>
                        </div>
                        <div class="div">
                            <input type="password" value="<?= $_POST['password']; ?>" name="password" id="password" class="input">
                        </div>
                    </div>
                    <div class="input-div pass">
                        <div class="i">
                            <i class="fas fa-lock"></i>
                        </div>
                        <div class="div">
                            <input type="password" name="conf_password" id="conf_password" class="input">
                        </div>
                    </div>
                    <p style="color: red; font-size: 13px; text-align: left;">Sandi tersebut tidak cocok. Coba lagi.</p>
                
                <?php elseif ($username_available == true) : ?>
                    <div class="input-div one">
                        <div class="i">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="div">
                            <input type="text" value="<?= $_POST['username']; ?>" name="username" id="username" class="input">
                        </div>
                    </div>
                    <div class="input-div pass">
                        <div class="i">
                            <i class="fas fa-lock"></i>
                        </div>
                        <div class="div">
                            <input type="password" value="<?= $_POST['password']; ?>" name="password" id="password" class="input">
                        </div>
                    </div>
                    <div class="input-div pass">
                        <div class="i">
                            <i class="fas fa-lock"></i>
                        </div>
                        <div class="div">
                            <input type="password" name="conf_password" id="conf_password" class="input">
                        </div>
                    </div>
                    <p style="color: red; font-size: 13px; text-align: left;">Username telah tersedia.</p>
                <?php endif; ?>

				<input type="submit" class="btn-blue" name="register" id="register" value="Register">
			</form>
		</div>
	</div>
	<script type="text/javascript" src="App/js/main.js"></script>
	<script src="App/js/script.js"></script>
</body>

</html>