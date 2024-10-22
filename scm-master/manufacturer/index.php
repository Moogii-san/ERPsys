<?php
	include("../includes/config.php");
	session_start();
	if(isset($_SESSION['manufacturer_login'])) {
		if($_SESSION['manufacturer_login'] == true) {
			$id = $_SESSION['manufacturer_id'];
			$query_selectManufacturer = "SELECT * FROM manufacturer WHERE man_id='$id'";
			$result_selectManufacturer = mysqli_query($con,$query_selectManufacturer);
			$row_selectManufacturer = mysqli_fetch_array($result_selectManufacturer);
			$query_selectOrder = "SELECT * FROM orders ORDER BY order_id DESC LIMIT 5";
			$result_selectOrder = mysqli_query($con,$query_selectOrder);
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
	<title> Үйлдвэрлэгч: Нүүр </title>
	<link rel="stylesheet" href="../includes/main_style.css" >
</head>
<body>
	<?php
		include("../includes/header.inc.php");
		include("../includes/nav_manufacturer.inc.php");
		include("../includes/aside_manufacturer.inc.php");
	?>
	<section>
		Тавтай морил <?php echo $_SESSION['sessUsername']; ?>
		<article>
			<h2>Профайл</h2>
			<table class="table_displayData">
			<tr>
				<th>Нэр</th>
				<th>Майл хаяг</th>
				<th>Дугаар</th>
				<th>Нэвтрэх нэр</th>
				<th> Засах </th>
			</tr>
			<tr>
				<td> <?php echo $row_selectManufacturer['man_name']; ?> </td>
				<td> <?php echo $row_selectManufacturer['man_email']; ?> </td>
				<td> <?php echo $row_selectManufacturer['man_phone']; ?> </td>
				<td> <?php echo $row_selectManufacturer['username']; ?> </td>
				<td> <a href="edit_profile.php"><img src="../images/edit.png" alt="edit" /></a> </td>
			</tr>
		</table>
		</article>
		<article>
			<h2>Сүүлийн захиалга</h2>
			<table class="table_displayData" style="margin-top:20px;">
			<tr>
				<th> Захилга ID </th>
				<th> Огноо </th>
				<th> Хүлээн авсан </th>
				<th> Төлөв </th>
				<th> Тайлбар </th>
			</tr>
			<?php $i=1; while($row_selectOrder = mysqli_fetch_array($result_selectOrder)) { ?>
			<tr>
			
				<td> <?php echo $row_selectOrder['order_id']; ?> </td>
				
				<td> <?php echo date("d-m-Y",strtotime($row_selectOrder['date'])); ?> </td>
				<td>
					<?php
						if($row_selectOrder['approved'] == 0) {
							echo "Зөвшөөрөгдөөгүй";
						}
						else {
							echo "Зөвшөөрсөн";
						}
					?>
				</td>
				<td>
					<?php
						if($row_selectOrder['status'] == 0) {
							echo "Хүлээгдэж байна.";
						}
						else {
							echo "Баталгаажсан";
						}
					?>
				</td>
				<td> <a href="view_order_items.php?id=<?php echo $row_selectOrder['order_id']; ?>">Дэлгэрэнгүй</a> </td>
			</tr>
			<?php $i++; } ?>
		</table>
		</article>
	</section>
	<?php
		include("../includes/footer.inc.php");
	?>
</body>
</html>