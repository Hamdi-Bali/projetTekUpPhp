<?php session_start(); ?>

<?php
include_once("connection.php");

if(isset($_POST['login'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];

	$result = mysqli_query($mysqli, "SELECT * FROM login WHERE username='$username' AND password=md5('$password')");

	if(mysqli_num_rows($result) == 1) {
		$row = mysqli_fetch_assoc($result);
		$_SESSION['valid'] = true;
		$_SESSION['username'] = $username;
		$_SESSION['id'] = $row['id'];
		$_SESSION['role'] = $row['role'];

		if ($_SESSION['role'] == 'admin') {
			header('Location: admin_dashboard.php');
		} else {
			header('Location: index.php');
		}
		exit();
	} else {
		echo "Invalid username or password";
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login</title>
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
<a href="index.php" class="btn btn-link">Home</a>
    <br />
	<h2>Login</h2>
	<form method="post" action="login.php">
		<div class="form-group">
			<label for="username">Username</label>
			<input type="text" class="form-control" id="username" name="username" required>
		</div>
		<div class="form-group">
			<label for="password">Password</label>
			<input type="password" class="form-control" id="password" name="password" required>
		</div>
		<button type="submit" name="login" class="btn btn-primary">Login</button>
	</form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
