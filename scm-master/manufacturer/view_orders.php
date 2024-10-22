<?php
	require("../includes/config.php");
	include("../includes/validate_data.php");
	error_reporting(0);
	session_start();
		if(isset($_SESSION['manufacturer_login'])) {
			$error = "";
			$querySelectRetailer = "SELECT *,area.area_id AS area_id FROM retailer,area WHERE retailer.area_id = area.area_id";
			$resultSelectRetailer = mysqli_query($con,$querySelectRetailer);
			if($_SERVER['REQUEST_METHOD'] == "POST") {
				if(isset($_POST['cmbFilter'])) {
					if(!empty($_POST['txtId'])) {
						$result = validate_number($_POST['txtId']);
						if($result == 1) {
							$order_id = $_POST['txtId'];
							$query_selectOrder = "SELECT * FROM orders,retailer,area WHERE orders.retailer_id=retailer.retailer_id AND retailer.area_id=area.area_id AND order_id='$order_id'";
							$result_selectOrder = mysqli_query($con,$query_selectOrder);
							$row_selectOrder = mysqli_fetch_array($result_selectOrder);
							if(empty($row_selectOrder)){
							   $error = "* Ийм ID-тай захиалга олдсонгүй";
							}
							else {
								mysqli_data_seek($result_selectOrder,0);
							}
						}
						else {
							$error = "* Буруу ID";
						}
					}
					else if(!empty($_POST['cmbRetailer'])) {
						$retailer_id = $_POST['cmbRetailer'];
						$query_selectOrder = "SELECT * FROM orders,retailer,area WHERE orders.retailer_id=retailer.retailer_id AND retailer.area_id=area.area_id AND orders.retailer_id='$retailer_id' ORDER BY approved,status,order_id DESC";
						$result_selectOrder = mysqli_query($con,$query_selectOrder);
						$row_selectOrder = mysqli_fetch_array($result_selectOrder);
						if(empty($row_selectOrder)){
						   $error = "* Энэ хэрэглэгчдээр захиалга байхгүй байна.";
						}
						else {
							mysqli_data_seek($result_selectOrder,0);
						}
					}
					else if(!empty($_POST['txtDate'])) {
						$date = $_POST['txtDate'];
						$query_selectOrder = "SELECT * FROM orders,retailer,area WHERE orders.retailer_id=retailer.retailer_id AND retailer.area_id=area.area_id AND date='$date'";
						$result_selectOrder = mysqli_query($con,$query_selectOrder);
						$row_selectOrder = mysqli_fetch_array($result_selectOrder);
						if(empty($row_selectOrder)){
						   $error = "* Энэ огноо дээр бүртгэлтэй захиалга байхгүй байна.";
						}
						else {
							mysqli_data_seek($result_selectOrder,0);
						}
						
					}
					else if(!empty($_POST['cmbStatus'])) {
						if($_POST['cmbStatus'] == "zero") {
							$status = 0;
						}
						else {
							$status = $_POST['cmbStatus'];
						}
						$query_selectOrder = "SELECT * FROM orders,retailer,area WHERE orders.retailer_id=retailer.retailer_id AND retailer.area_id=area.area_id AND status='$status' ORDER BY approved,order_id DESC";
						$result_selectOrder = mysqli_query($con,$query_selectOrder);
						$row_selectOrder = mysqli_fetch_array($result_selectOrder);
						if(empty($row_selectOrder)){
						   $error = "* Захиалга олдсонгүй";
						}
						else {
							mysqli_data_seek($result_selectOrder,0);
						}
					}
					else if(!empty($_POST['cmbApproved'])) {
						if($_POST['cmbStatus'] == "zero") {
							$approved = 0;
						}
						else {
							$approved = $_POST['cmbApproved'];
						}
						$query_selectOrder = "SELECT * FROM orders,retailer,area WHERE orders.retailer_id=retailer.retailer_id AND retailer.area_id=area.area_id AND approved='$approved' ORDER BY order_id DESC";
						$result_selectOrder = mysqli_query($con,$query_selectOrder);
						$row_selectOrder = mysqli_fetch_array($result_selectOrder);
						if(empty($row_selectOrder)){
						   $error = "* Захиалга олдсонгүй";
						}
						else {
							mysqli_data_seek($result_selectOrder,0);
						}
					}
					else {
						$error = "* Огноогоор хайна уу";
					}
				}
				else {
					$error = "Төрөл хэсгээс төрлөө сонгоно уу";
				}
			}
			else {
				$query_selectOrder = "SELECT * FROM orders,retailer,area WHERE orders.retailer_id=retailer.retailer_id AND retailer.area_id=area.area_id ORDER BY approved,status,order_id DESC;";
				$result_selectOrder = mysqli_query($con,$query_selectOrder);
			}
		}
		else {
			header('Location:../index.php');
		}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Захиалга харах </title>
	<link rel="stylesheet" href="../includes/main_style.css" >
	<link rel="stylesheet" href="css/smoothness/jquery-ui.css">
	<script type="text/javascript" src="../includes/jquery.js"> </script>
	<script src="js/jquery-ui.js"></script>
	<script>
  $(function() {
    $( "#datepicker" ).datepicker({
     changeMonth:true,
     changeYear:true,
     yearRange:"-100:+0",
     dateFormat:"yy-mm-dd"
  });
  });
  </script>
</head>
<body>
	<?php
		include("../includes/header.inc.php");
		include("../includes/nav_manufacturer.inc.php");
		include("../includes/aside_manufacturer.inc.php");
	?>
	<section>
		<h1>Захиалга</h1>
		<form action="" method="POST" class="form">
			Хайх: 
			<div class="input-box">
			<select name="cmbFilter" id="cmbFilter">
			<option value="" disabled selected>-- Сонгох --</option>
			<option value="id"> Id </option>
			<option value="retailer"> Хэрэглэгч </option>
			<option value="date"> Огноо </option>
			<option value="status"> Төлөв </option>
			<option value="approved"> Зөвшөөрөл </option>
			</select>
			</div>
			
			<div class="input-box"> <input type="text" name="txtId" id="txtId" style="display:none;" /> </div>
			<div class="input-box">
			<select name="cmbRetailer" id="cmbRetailer" style="display:none;">
				<option value="" disabled selected>-- Хэрэгэлэгч сонгох --</option>
				<?php while($rowSelectRetailer = mysqli_fetch_array($resultSelectRetailer)) { ?>
				<option value="<?php echo $rowSelectRetailer['retailer_id']; ?>"><?php echo $rowSelectRetailer['area_code']." (".$rowSelectRetailer['area_name'].")"; ?></option>
				<?php } ?>
			</select>
			</div>
			<div class="input-box"> <input type="text" id="datepicker" name="txtDate" style="display:none;"/> </div>
			<div class="input-box">
			<select name="cmbStatus" id="cmbStatus" style="display:none;">
				<option value="" disabled selected>-- Сонгох --</option>
				<option value="zero"> Хүлээгдэж байна </option>
				<option value="1"> Илгээсэн </option>
			</select>
			</div>
			<div class="input-box">
			<select name="cmbApproved" id="cmbApproved" style="display:none;">
				<option value="" disabled selected>-- Сонгох --</option>
				<option value="zero"> Зөвшөөрөгдөөгүй </option>
				<option value="1"> Зөвшөөрсөн </option>
			</select>
			</div>
			
			<input type="submit" class="submit_button" value="Search" /> <span class="error_message"> <?php echo $error; ?> </span>
		</form>
		<form action="" method="POST" class="form">
		<table class="table_displayData" style="margin-top:20px;">
			<tr>
				<th> Захиалга ID </th>
				<th> Үйлчлүүлэгч </th>
				<th> Огноо </th>
				<th> Зөвшөөрсөн төрөл</th>
				<th> Захиалгын төрөл </th>
				<th> Тайлбар </th>
				<th> Зөвшөөрөл </th>
				<th> Нэхэмжлэл </th>
			</tr>
			<?php $i=1; while($row_selectOrder = mysqli_fetch_array($result_selectOrder)) { ?>
			<tr>
			
				<td> <?php echo $row_selectOrder['order_id']; ?> </td>
				<td> <?php echo $row_selectOrder['area_code']; ?> </td>
				
				<td> <?php echo date("d-m-Y",strtotime($row_selectOrder['date'])); ?> </td>
				<td>
					<?php
						if($row_selectOrder['approved'] == 0) {
							echo "Илгээгүй";
						}
						else {
							echo "Илгээсэн";
						}
					?>
				</td>
				<td>
					<?php
						if($row_selectOrder['status'] == 0) {
							echo "Хүлээгдэж байна";
						}
						else {
							echo "Зөвшөөрсөн";
						}
					?>
				</td>
				<td> <a href="view_order_items.php?id=<?php echo $row_selectOrder['order_id']; ?>">Тайлбар</a> </td>
				<td>
					<?php
						if($row_selectOrder['approved'] == 0) {
							echo "<a href=\"confirm_order.php?id=".$row_selectOrder['order_id']."\">Confirm</a>";
						}
						else {
							
						}
					?>
				</td>
				<td>
					<?php
						if($row_selectOrder['approved'] == 1 && $row_selectOrder['status'] == 0) {
						?>
							<a href="generate_invoice.php?id=<?php echo $row_selectOrder['order_id']; ?>">Нэхэмжлэл</a>
						<?php
						}
						?>
				</td>
			</tr>
			<?php $i++; } ?>
		</table>
		</form>
	</section>
	<?php
		include("../includes/footer.inc.php");
	?>
	<script type="text/javascript">
		$('#cmbFilter').change(function() {
			var selected = $(this).val();
			if(selected == "id"){
				$('#txtId').show();
				$('#cmbRetailer').hide();
				$('#datepicker').hide();
				$('#cmbStatus').hide();
				$('#cmbApproved').hide();
			}
			else if (selected == "retailer"){
				$('#txtId').hide();
				$('#cmbRetailer').show();
				$('#datepicker').hide();
				$('#cmbStatus').hide();
				$('#cmbApproved').hide();
			}
			else if (selected == "date"){
				$('#txtId').hide();
				$('#cmbRetailer').hide();
				$('#datepicker').show();
				$('#cmbStatus').hide();
				$('#cmbApproved').hide();
			}
			else if (selected == "status"){
				$('#txtId').hide();
				$('#cmbRetailer').hide();
				$('#datepicker').hide();
				$('#cmbStatus').show();
				$('#cmbApproved').hide();
			}
			else if (selected == "approved"){
				$('#txtId').hide();
				$('#cmbRetailer').hide();
				$('#datepicker').hide();
				$('#cmbStatus').hide();
				$('#cmbApproved').show();
			}
		});
	</script>
</body>
</html>