<?php session_start(); ?>

<?php
if(!isset($_SESSION['valid'])) {
	header('Location: login.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Add Data</title>
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
	<a href="admin_dashboard.php" class="btn btn-link">Home</a> | <a href="view.php" class="btn btn-link">View Products</a> | <a href="logout.php" class="btn btn-link">Logout</a>
	<br/><br/>

	<h2>Add New Product</h2>

	<?php
	// including the database connection file
	include_once("connection.php");

	if(isset($_POST['Submit'])) {	
		$name = $_POST['name'];
		$qty = $_POST['qty'];
		$price = $_POST['price'];
		$loginId = $_SESSION['id'];
		$image = $_FILES['image']['name'];
		$target = "uploads/" . basename($image);
	
		if(empty($name) || empty($qty) || empty($price) || empty($image)) {
			if(empty($name)) {
				echo "<div class='alert alert-danger'>Name field is empty.</div>";
			}
			if(empty($qty)) {
				echo "<div class='alert alert-danger'>Quantity field is empty.</div>";
			}
			if(empty($price)) {
				echo "<div class='alert alert-danger'>Price field is empty.</div>";
			}
			if(empty($image)) {
				echo "<div class='alert alert-danger'>Image field is empty.</div>";
			}
			
			echo "<br/><a href='javascript:self.history.back();' class='btn btn-warning'>Go Back</a>";
		} else {
			if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
				$result = mysqli_query($mysqli, "INSERT INTO products(name, qty, price, login_id, image) VALUES('$name','$qty','$price', '$loginId', '$image')");
				echo "<div class='alert alert-success'>Data added successfully.</div>";
				echo "<br/><a href='view.php' class='btn btn-primary'>View Result</a>";
			} else {
				echo "<div class='alert alert-danger'>Failed to upload image.</div>";
			}
		}
	}
	
	?>

<form action="add.php" method="post" name="form1" enctype="multipart/form-data">
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" name="name" id="name">
    </div>
    <div class="form-group">
        <label for="qty">Quantity</label>
        <input type="text" class="form-control" name="qty" id="qty">
    </div>
    <div class="form-group">
        <label for="price">Price</label>
        <input type="text" class="form-control" name="price" id="price">
    </div>
    <div class="form-group">
        <label for="image">Product Image</label>
        <input type="file" class="form-control" name="image" id="image">
    </div>
    <button type="submit" class="btn btn-success" name="Submit">Add</button>
</form>

</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
