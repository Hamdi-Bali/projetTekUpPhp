<?php
session_start();
if (!isset($_SESSION['valid'])) {
    header('Location: login.php');
}
include("connection.php");
$id = $_SESSION['id'];
$result = mysqli_query($mysqli, "SELECT * FROM login WHERE id=$id");
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div id="main-content" class="container mt-5">
    <a href="admin_dashboard.php" class="btn btn-primary">Home</a>
    <a href="logout.php" class="btn btn-danger">Logout</a>
    <h2>Profile</h2>
    <table class="table table-bordered">
        <tr>
            <th>Name</th>
            <td><?php echo $user['name']; ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?php echo $user['email']; ?></td>
        </tr>
        <tr>
            <th>Username</th>
            <td><?php echo $user['username']; ?></td>
        </tr>
    </table>
    <a href="edit_profile.php" class="btn btn-warning">Edit Profile</a>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
