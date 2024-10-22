<?php
	require("../includes/config.php");
	session_start();
	if(isset($_SESSION['manufacturer_login']) || isset($_SESSION['admin_login']) || isset($_SESSION['retailer_login'])) {
			$order_id = $_GET['id'];
			$query_selectManOrderItems = "SELECT *,order_items.quantity as quantity FROM orders,order_items,products WHERE order_items.order_id='$order_id' AND order_items.pro_id=products.pro_id AND order_items.order_id=orders.order_id";
			$result_selectManOrderItems = mysqli_query($con,$query_selectManOrderItems);
			$query_selectManOrder = "SELECT date,approved,status FROM orders WHERE order_id='$order_id'";
			$result_selectManOrder = mysqli_query($con,$query_selectManOrder);
			$row_selectManOrder = mysqli_fetch_array($result_selectManOrder);
		}
		else {
			header('Location:../index.php');
		}
?>

<!DOCTYPE html>
<html>
<head>
	<title> Захиалга харах </title>
	<link rel="stylesheet" href="../includes/main_style.css" >
</head>
<body>
	<?php
		include("../includes/header.inc.php");
		include("../includes/nav_manufacturer.inc.php");
		include("../includes/aside_manufacturer.inc.php");
	?>
	<section>
		<h1>Захиалгууд</h1>
		<table class="table_infoFormat">
		<tr>
			<td> Захиалгын дугаар: </td>
			<td> <?php echo $order_id; ?> </td>
		</tr>
		<tr>
			<td> Төлөв: </td>
			<td>
			<?php
				if($row_selectManOrder['status'] == 0) {
					echo "Хүлээгдэж байна";
				}
				else {
					echo "Баталгаажсан";
				}
			?>
			</td>
		</tr>
		<tr>
			<td> Огноо: </td>
			<td> <?php echo date("d-m-Y",strtotime($row_selectManOrder['date'])); ?> </td>
		</tr>
		</table>
		<form action="" method="POST" class="form">
		<table class="table_invoiceFormat">
			<tr>
				<th> Бүтээгдэхүүн </th>
				<th> Тус бүрийн үнэ </th>
				<th> Тоо хэмжээ </th>
				<th> Үнэ </th>
			</tr>
			<?php $i=1; while($row_selectManOrderItems = mysqli_fetch_array($result_selectManOrderItems)) { ?>
			<tr>
				<td> <?php echo $row_selectManOrderItems['pro_name']; ?> </td>
				<td> <?php echo $row_selectManOrderItems['pro_price']; ?> </td>
				<td> <?php echo $row_selectManOrderItems['quantity']; ?> </td>
				<td> <?php echo $row_selectManOrderItems['quantity']*$row_selectManOrderItems['pro_price']; ?> </td>
			</tr>
			<?php $i++; } ?>
			<tr style="height:40px;vertical-align:bottom;">
				<td colspan="3" style="text-align:right;"> Нийт үнэ: </td>
				<td>
				<?php
					mysqli_data_seek($result_selectManOrderItems,0);
					$row_selectManOrderItems = mysqli_fetch_array($result_selectManOrderItems);
					echo $row_selectManOrderItems['total_amount'];
				?>
				</td>
			</tr>
		</table>
			
			<?php
				if($row_selectManOrder['approved'] == 0) {
					?>
				<a href="confirm_order.php?id=<?php echo $order_id; ?>"><input type="button" value="Захиалга илгээх" class="submit_button"/></a>
				<?php
				}
				else {
					if($row_selectManOrder['status'] == 0) {
				?>
					<a href="generate_invoice.php?id=<?php echo $order_id; ?>"><input type="button" value="Нэхэмжлэл" class="submit_button"/></a>
				<?php
					}
					else {
					}
				}
				?>
		</form>
	</section>
	<?php
		include("../includes/footer.inc.php");
	?>
</body>
</html>