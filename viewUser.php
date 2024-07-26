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
    <a href="index.php" class="btn btn-link">Home</a> | <a href="logout.php" class="btn btn-link">Logout</a>
    <br/><a href="user_orders.php" class="btn btn-link">Panier</a><br/>
    <h2>View Products</h2>

    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-info"><?= $_SESSION['message']; ?></div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <table class="table table-striped">
        <thead class="thead-dark">
            <tr>
                <th>Name</th>
                <th>Quantity</th>
                <th>Price (Dinar)</th>
                <th>Image</th>
                <?php if ($_SESSION['role'] !== 'admin'): ?>
                    <th>Order</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= $row['name']; ?></td>
                <td><?= $row['qty']; ?></td>
                <td><?= $row['price']; ?></td>
                <td><?php echo "<img src='uploads/" . $row['image'] . "' alt='" . $row['name'] . "' width='100'>"; ?></td>
                <?php if ($_SESSION['role'] !== 'admin'): ?>
                    <td>
                        <form action="order.php" method="post">
                            <input type="hidden" name="product_id" value="<?= $row['id']; ?>">
                            <input type="number" name="order_qty" min="1" max="<?= $row['qty']; ?>" required>
                            <button type="submit" class="btn btn-success btn-sm">Order</button>
                        </form>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
