<?php session_start(); ?>

<?php
if (!isset($_SESSION['valid']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

include_once("connection.php");

$result = mysqli_query($mysqli, "SELECT orders.id, products.name, products.price, login.username, orders.quantity, orders.order_date, (products.price * orders.quantity) AS total_price FROM orders JOIN products ON orders.product_id = products.id JOIN login ON orders.user_id = login.id ORDER BY orders.order_date DESC");

// Récupérer le nombre total des produits
$product_count_result = mysqli_query($mysqli, "SELECT COUNT(*) AS product_count FROM products");
$product_count_row = mysqli_fetch_assoc($product_count_result);
$product_count = $product_count_row['product_count'];

// Récupérer le montant total gagné
$total_revenue_result = mysqli_query($mysqli, "SELECT SUM(products.price * orders.quantity) AS total_revenue FROM orders JOIN products ON orders.product_id = products.id");
$total_revenue_row = mysqli_fetch_assoc($total_revenue_result);
$total_revenue = $total_revenue_row['total_revenue'];


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Orders</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="container">
    <h2>Admin Orders</h2>
    <a href="admin_dashboard.php" class="btn btn-link">Home</a>
    <a href="logout.php" class="btn btn-link">Logout</a>
    <br/><br/>

    <div class="row">
        <div class="col-md-6">
            <canvas id="productCountChart"></canvas>
        </div>
        <div class="col-md-6">
            <canvas id="totalRevenueChart"></canvas>
        </div>
    </div>

    <br/><br/>

    <table class="table table-striped">
        <thead class="thead-dark">
        <tr>
            <th>Order ID</th>
            <th>Product Name</th>
            <th>Price (Dinar)</th>
            <th>Username</th>
            <th>Quantity</th>
            <th>Total Price (Dinar)</th>
            <th>Order Date</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= $row['id']; ?></td>
                <td><?= $row['name']; ?></td>
                <td><?= $row['price']; ?></td>
                <td><?= $row['username']; ?></td>
                <td><?= $row['quantity']; ?></td>
                <td><?= $row['total_price']; ?></td>
                <td><?= $row['order_date']; ?></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    // Récupérer les données PHP
    const productCount = <?= $product_count; ?>;
    const totalRevenue = <?= $total_revenue; ?>;

    // Chart.js pour le nombre total de produits
    const productCountCtx = document.getElementById('productCountChart').getContext('2d');
    const productCountChart = new Chart(productCountCtx, {
        type: 'bar',
        data: {
            labels: ['Total Products'],
            datasets: [{
                label: 'Total Products',
                data: [productCount],
                backgroundColor: ['rgba(75, 192, 192, 0.2)'],
                borderColor: ['rgba(75, 192, 192, 1)'],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Chart.js pour le montant total gagné
    const totalRevenueCtx = document.getElementById('totalRevenueChart').getContext('2d');
    const totalRevenueChart = new Chart(totalRevenueCtx, {
        type: 'bar',
        data: {
            labels: ['Total Revenue'],
            datasets: [{
                label: 'Total Revenue (Dinar)',
                data: [totalRevenue],
                backgroundColor: ['rgba(153, 102, 255, 0.2)'],
                borderColor: ['rgba(153, 102, 255, 1)'],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
</body>

</html>
