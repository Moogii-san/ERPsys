<?php
	include("../includes/config.php");
	session_start();
	if(isset($_SESSION['manufacturer_login'])) {
		if($_SESSION['manufacturer_login'] == true) {
			$querySelectProduct = "SELECT * FROM products,unit WHERE products.unit=unit.id AND quantity IS NOT NULL";
			$resultSelectProduct = mysqli_query($con,$querySelectProduct);
			if($_SERVER['REQUEST_METHOD'] == "POST") {
				if(isset($_POST['txtQuantity'])){
					$arrayQuantity = $_POST['txtQuantity'];
					foreach($arrayQuantity as $key => $value) {
						$queryUpdateStock = "UPDATE products SET quantity='$value' WHERE pro_id='$key'";
						$result = mysqli_query($con,$queryUpdateStock);
					}
					if(!$result) {
						$requireErr = "Алдаа гарлаа";
					}
					else {
						echo "<script> alert(\"Ажилттай\"); </script>";
						header('Refresh:0');
					}
				}
				
			}
		}
		else {
			header('Location:../index.php');
		}
	}
	else {
		header('Location:../index.php');
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title> Админ: Нүүр</title>
	<link rel="stylesheet" href="../includes/main_style.css" >
</head>
<body>
	<?php
		include("../includes/header.inc.php");
		include("../includes/nav_manufacturer.inc.php");
		include("../includes/aside_manufacturer.inc.php");
	?>
	<section>
		<h1>Нөөц</h1>
		<form action="" method="POST" class="form">
		<table class="table_displayData" style="margin-top:20px;">
			<tr>
				<th> Бүтээгдэхүүн ID </th>
				<th> Нэр </th>
				<th> НЭгж </th>
				<th> Тоо хэмжээ </th>
			</tr>
			<?php while($rowSelectProduct = mysqli_fetch_array($resultSelectProduct)){ ?>
			<tr>
				<td><?php echo $rowSelectProduct['pro_id']; ?></td>
				<td><?php echo $rowSelectProduct['pro_name']; ?></td>
				<td><?php echo $rowSelectProduct['unit_name']; ?></td>
				<td><input type="text" name="txtQuantity[<?php echo $rowSelectProduct['pro_id']; ?>]" value="<?php echo $rowSelectProduct['quantity']; ?>" size="10"/></td>
			</tr>
			<?php } ?>
		</table>
			<input id="btnSubmit" type="submit" value="Шинэчлэх" class="submit_button" />
		</form>
	</section>
	<?php
		include("../includes/footer.inc.php");
	?>
</body>
</html>