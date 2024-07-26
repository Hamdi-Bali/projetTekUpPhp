<?php session_start(); ?>
<?php
if (!isset($_SESSION['valid'])) {
    header('Location: login.php');
}
?>
<?php
include_once("connection.php");

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $qty = $_POST['qty'];
    $price = $_POST['price'];

    if (empty($name) || empty($qty) || empty($price)) {
        if (empty($name)) {
            echo "<div class='alert alert-danger'>Name field is empty.</div>";
        }
        if (empty($qty)) {
            echo "<div class='alert alert-danger'>Quantity field is empty.</div>";
        }
        if (empty($price)) {
            echo "<div class='alert alert-danger'>Price field is empty.</div>";
        }
    } else {
        $result = mysqli_query($mysqli, "UPDATE products SET name='$name', qty='$qty', price='$price' WHERE id=$id");
        header("Location: view.php");
    }
}
?>
<?php
$id = $_GET['id'];
$result = mysqli_query($mysqli, "SELECT * FROM products WHERE id=$id");
while ($res = mysqli_fetch_array($result)) {
    $name = $res['name'];
    $qty = $res['qty'];
    $price = $res['price'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <a href="admin_dashboard.php" class="btn btn-link">Home</a> | <a href="view.php" class="btn btn-link">View Products</a> | <a href="logout.php" class="btn btn-link">Logout</a>
    <br/><br/>
    <h2>Edit Product</h2>
    <form name="form1" method="post" action="edit.php">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" name="name" id="name" value="<?php echo $name; ?>">
        </div>
        <div class="form-group">
            <label for="qty">Quantity</label>
            <input type="text" class="form-control" name="qty" id="qty" value="<?php echo $qty; ?>">
        </div>
        <div class="form-group">
            <label for="price">Price</label>
            <input type="text" class="form-control" name="price" id="price" value="<?php echo $price; ?>">
        </div>
        <input type="hidden" name="id" value=<?php echo $_GET['id']; ?>>
        <button type="submit" class="btn btn-primary" name="update">Update</button>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
