<?php
session_start();

if (!isset($_SESSION['valid'])) {
    header('Location: login.php');
    exit();
}

include_once("connection.php");

$result = mysqli_query($mysqli, "SELECT * FROM products");

if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    $user_id = $_SESSION['id'];

    // Vérifier si le produit existe
    $result = mysqli_query($mysqli, "SELECT * FROM products WHERE id=$product_id");
    if (mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
        $quantity = 1; // Par défaut, 1 article commandé
        $order = mysqli_query($mysqli, "INSERT INTO orders(product_id, user_id, quantity) VALUES('$product_id', '$user_id', '$quantity')");

        if ($order) {
            echo "Order placed successfully.";
        } else {
            echo "Failed to place order.";
        }
    } else {
        echo "Product not found.";
    }
} else {
    echo "No product selected.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Product</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <a href="viewUser.php" class="btn btn-link">Back to Products</a>
</div>
</body>
</html>
