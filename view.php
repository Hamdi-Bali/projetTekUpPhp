<?php session_start(); ?>

<?php
if (!isset($_SESSION['valid'])) {
    header('Location: login.php');
    exit();
}

include_once("connection.php");

$result = mysqli_query($mysqli, "SELECT * FROM products");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Products</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <a href="admin_dashboard.php" class="btn btn-link">Home</a> | <a href="logout.php" class="btn btn-link">Logout</a>
    <br/><a href="add.php" class="btn btn-link">Add Product</a><br/>
    <h2>View Products</h2>
    <table class="table table-striped">
        <thead class="thead-dark">
        <tr>
            <th>Name</th>
            <th>Quantity</th>
            <th>Price (Dinar)</th>
            <th>Image</th>
            <?php if ($_SESSION['role'] == 'admin'): ?>
            <th>Update</th>
            <?php else: ?>
            <th>Order</th>
            <?php endif; ?>
        </tr>
        </thead>
        <tbody>
        <?php while ($res = mysqli_fetch_array($result)) { ?>
            <tr>
                <td><?php echo $res['name']; ?></td>
                <td><?php echo $res['qty']; ?></td>
                <td><?php echo $res['price']; ?></td>
                <td><?php echo "<img src='uploads/" . $res['image'] . "' alt='" . $res['name'] . "' width='100'>"; ?></td>
                <?php if ($_SESSION['role'] == 'admin'): ?>
                <td><a href="edit.php?id=<?php echo $res['id']; ?>" class="btn btn-warning btn-sm">Edit</a> | <a href="delete.php?id=<?php echo $res['id']; ?>" class="btn btn-danger btn-sm" onClick="return confirm('Are you sure you want to delete?')">Delete</a></td>
                <?php else: ?>
                <td><a href="order.php?product_id=<?php echo $res['id']; ?>" class="btn btn-success btn-sm">Order</a></td>
                <?php endif; ?>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
