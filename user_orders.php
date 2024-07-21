<?php session_start(); ?>

<?php
if (!isset($_SESSION['valid']) || $_SESSION['role'] !== 'user') {
    header('Location: login.php');
    exit();
}

include_once("connection.php");

$user_id = $_SESSION['id']; // Assurez-vous que l'ID utilisateur est stocké dans la session lors de la connexion
$result = mysqli_query($mysqli, "SELECT orders.id, products.name, orders.quantity, products.price, (orders.quantity * products.price) as total_price, orders.order_date FROM orders JOIN products ON orders.product_id = products.id WHERE orders.user_id = $user_id ORDER BY orders.order_date DESC");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Orders</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>

    <style>
        /* Custom styles */
        #ordersTable {
            width: 100%;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>User Orders</h2>
    <a href="index.php" class="btn btn-link">Home</a> | <a href="logout.php" class="btn btn-link">Logout</a>
    <br/><br/>

    <table class="table table-striped" id="ordersTable">
        <thead class="thead-dark">
        <tr>
            <th>Order ID</th>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Total Price</th>
            <th>Order Date</th>
        </tr>
        </thead>
        <tbody>
        <?php 
        $grand_total = 0;
        while ($row = mysqli_fetch_assoc($result)): 
            $grand_total += $row['total_price'];
        ?>
            <tr>
                <td><?= $row['id']; ?></td>
                <td><?= $row['name']; ?></td>
                <td><?= $row['quantity']; ?></td>
                <td><?= $row['price']; ?></td>
                <td><?= $row['total_price']; ?></td>
                <td><?= $row['order_date']; ?></td>
            </tr>
        <?php endwhile; ?>
        <tr>
            <td colspan="4"><strong>Grand Total</strong></td>
            <td><strong><?= $grand_total; ?>Dt</strong></td>
            <td></td>
        </tr>
        </tbody>
    </table>

    <button class="btn btn-primary" id="downloadPdf">Download as PDF</button>
</div>
<script>
 // Attendez que le DOM soit entièrement chargé
document.addEventListener("DOMContentLoaded", function() {
    // Sélectionnez le bouton de téléchargement PDF
    const downloadButton = document.getElementById('downloadPdf');

    // Écoutez le clic sur le bouton
    downloadButton.addEventListener('click', function() {
        // Sélectionnez l'élément HTML à convertir en PDF (dans cet exemple, je suppose un élément avec l'id 'ordersTable')
        const element = document.getElementById('ordersTable');

        // Options pour la conversion PDF
        const options = {
            filename: 'orders.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'pt', format: 'a4', orientation: 'portrait' }
        };

        // Convertir en PDF avec html2pdf
        html2pdf().from(element).set(options).save();
    });
});


</script>
</body>
</html>
