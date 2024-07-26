<?php session_start(); ?>

<?php
if (!isset($_SESSION['valid']) || $_SESSION['role'] !== 'admin') {
	header('Location: login.php');
	exit();
}

include_once("connection.php");

$result = mysqli_query($mysqli, "SELECT id, name, username, email, role FROM login WHERE role != 'admin'");

// Récupérer le nombre total des utilisateurs
$user_count_result = mysqli_query($mysqli, "SELECT COUNT(*) AS user_count FROM login WHERE role != 'admin'");
$user_count_row = mysqli_fetch_assoc($user_count_result);
$user_count = $user_count_row['user_count'];

// Récupérer le nombre de chaque rôle
$role_count_result = mysqli_query($mysqli, "SELECT role, COUNT(*) AS count FROM login WHERE role != 'admin' GROUP BY role");
$role_counts = [];
while ($row = mysqli_fetch_assoc($role_count_result)) {
    $role_counts[$row['role']] = $row['count'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<style>
        /* Définir les dimensions des éléments canvas pour réduire la taille des graphiques */
       #rolePieChart {
            width: 150px; /* largeur en pixels */
            height: 150px; /* hauteur en pixels */
        }
    </style>
</head>

<body>
<div class="container">
    <h2>Admin Dashboard</h2>
    <div class="alert alert-success">
        Welcome <?php echo $_SESSION['username'] ?>! <a href='logout.php' class="btn btn-danger btn-sm">Logout</a>
    </div>
    <a href='view.php' class="btn btn-primary">View and Add Products</a>
    <a href='orders.php' class="btn btn-primary">Orders</a>
    <a href='profileAdmin.php' class="btn btn-primary">Profile</a>
    <br/><br/>

    <div class="row">
        <div class="col-md-6">
            <canvas id="userCountChart"></canvas>
        </div>
        <div class="col-md-6">
            <canvas id="rolePieChart"></canvas>
        </div>
    </div>

    <br/><br/>

    <table class="table table-striped">
        <thead class="thead-dark">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= $row['id']; ?></td>
                <td><?= $row['username']; ?></td>
                <td><?= $row['email']; ?></td>
                <td><?= $row['role']; ?></td>
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
    const userCount = <?= $user_count; ?>;
    const roleCounts = <?= json_encode($role_counts); ?>;
    
    // Chart.js pour le nombre total des utilisateurs
    const userCountCtx = document.getElementById('userCountChart').getContext('2d');
    const userCountChart = new Chart(userCountCtx, {
        type: 'bar',
        data: {
            labels: ['Total Users'],
            datasets: [{
                label: 'Total Users',
                data: [userCount],
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

    // Chart.js pour le diagramme circulaire des rôles
    const rolePieCtx = document.getElementById('rolePieChart').getContext('2d');
    const roleLabels = Object.keys(roleCounts);
    const roleData = Object.values(roleCounts);
    const rolePieChart = new Chart(rolePieCtx, {
        type: 'pie',
        data: {
            labels: roleLabels,
            datasets: [{
                data: roleData,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        }
    });
</script>
</body>

</html>
