<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="jumbotron">
        <h1 class="display-4">Welcome to my page!</h1>
    </div>
    <?php
    if (isset($_SESSION['valid'])) {
        include("connection.php");
        $result = mysqli_query($mysqli, "SELECT * FROM login");
    ?>
        <div class="alert alert-success">
            Welcome <?php echo $_SESSION['username'] ?>! <a href='logout.php' class="btn btn-danger btn-sm">Logout</a>
        </div>
        
        <a href='viewUser.php' class="btn btn-primary">View and Add Products</a>
        <a href='profile.php' class="btn btn-primary">Profile</a>
    <?php
    } else {
        echo "<div class='alert alert-warning'>You must be logged in to view this page.</div>";
        echo "<a href='login.php' class='btn btn-primary'>Login</a> ";
        echo "<a href='register.php' class='btn btn-secondary'>Register</a>";
    }
    ?>
    <div class="footer mt-5">
        <p class="text-muted">Created by <a href="" title="TEKUP">TEKUP</a></p>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
