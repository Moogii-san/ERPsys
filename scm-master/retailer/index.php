<?php
	include("../includes/config.php");
	session_start();
	if(isset($_SESSION['retailer_login'])) {
		if($_SESSION['retailer_login'] == true) {
			$id = $_SESSION['retailer_id'];
			$query_selectRetailer = "SELECT * FROM retailer,area WHERE retailer.area_id=area.area_id AND retailer_id='$id'";
			$result_selectRetailer = mysqli_query($con,$query_selectRetailer);
			$row_selectRetailer = mysqli_fetch_array($result_selectRetailer);
			$query_selectOrder = "SELECT * FROM orders WHERE retailer_id='$id' ORDER BY order_id DESC LIMIT 5";
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
	<title> Хэрэгэлэгч: Нүүр </title>
	<link rel="stylesheet" href="../includes/main_style.css" />
</head>
<body>
	<?php
		include("../includes/header.inc.php");
		include("../includes/nav_retailer.inc.php");
		include("../includes/aside_retailer.inc.php");
	?>
	<section>
		Welcome <?php echo $_SESSION['sessUsername']; ?>
		<article>
			<h2>Профайл</h2>
			<table class="table_displayData">
				<tr>
					<th>Нэр</th>
					<th>Код</th>
					<th>Дугаар</th>
					<th>Майл хаяг</th>
					<th>Хаяг</th>
					<th> Засах </th>
				</tr>
				<tr>
					<td> <?php echo $row_selectRetailer['username']; ?> </td>
					<td> <?php echo $row_selectRetailer['area_code']; ?> </td>
					<td> <?php echo $row_selectRetailer['phone']; ?> </td>
					<td> <?php echo $row_selectRetailer['email']; ?> </td>
					<td> <?php echo $row_selectRetailer['address']; ?> </td>
					<td> <a href="../retailer/edit_profile.php"><img src="../images/edit.png" alt="edit" /></a> </td>
				</tr>
			</table>
		</article>
		<article>
			<h2>Миний захиалгууд</h2>
			<table class="table_displayData" style="margin-top:20px;">
			<tr>
				<th> Захилга ID </th>
				<th> Огноо </th>
				<th> Баталгаажсан </th>
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
							echo "Хүлээгдэж байна";
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