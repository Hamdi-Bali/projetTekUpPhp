<?php
session_start();
if (!isset($_SESSION['valid'])) {
    header('Location: login.php');
}
include("connection.php");
$id = $_SESSION['id'];
$result = mysqli_query($mysqli, "SELECT * FROM login WHERE id=$id");
$user = mysqli_fetch_assoc($result);

if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($name) || empty($email) || empty($username)) {
        echo "<div class='alert alert-danger'>All fields are required.</div>";
    } else {
        if (!empty($password)) {
            $password = md5($password);
            $update = mysqli_query($mysqli, "UPDATE login SET name='$name', email='$email', username='$username', password='$password' WHERE id=$id");
        } else {
            $update = mysqli_query($mysqli, "UPDATE login SET name='$name', email='$email', username='$username' WHERE id=$id");
        }

        if ($update) {
            echo "<div class='alert alert-success'>Profile updated successfully.</div>";
            header("Refresh:2; url=profile.php");
        } else {
            echo "<div class='alert alert-danger'>Failed to update profile.</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <a href="profile.php" class="btn btn-primary">Back to Profile</a>
    <a href="logout.php" class="btn btn-danger">Logout</a>
    <h2>Edit Profile</h2>
    <form method="post" action="edit_profile.php">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" name="name" value="<?php echo $user['name']; ?>">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" value="<?php echo $user['email']; ?>">
        </div>
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" name="username" value="<?php echo $user['username']; ?>">
        </div>
        <div class="form-group">
            <label for="password">New Password (leave blank to keep current password)</label>
            <input type="password" class="form-control" name="password">
        </div>
        <button type="submit" class="btn btn-success" name="update">Update</button>
    </form>
</div>
</body>
</html>
