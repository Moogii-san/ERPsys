<?php
	include("../includes/config.php");
	session_start();
	if(isset($_SESSION['manufacturer_login'])) {
		if($_SESSION['manufacturer_login'] == true) {
			$query_selectUnit = "SELECT * FROM unit";
			$result_selectUnit = mysqli_query($con,$query_selectUnit);
			if($_SERVER['REQUEST_METHOD'] == "POST") {
				if(isset($_POST['chkId'])) {
					$chkId = $_POST['chkId'];
					foreach($chkId as $id) {
						$query_deleteUnit = "DELETE FROM unit WHERE id='$id'";
						$result = mysqli_query($con,$query_deleteUnit);
					}
					if(!$result) {
						echo "<script> alert(\"Алдаа гарлаа\"); </script>";
						header('Refresh:0');
					}
					else {
						echo "<script> alert(\"Амжилттай\"); </script>";
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
	<title> Хэмжээ харах </title>
	<link rel="stylesheet" href="../includes/main_style.css" >
	<script language="JavaScript">
	function toggle(source) {
		checkboxes = document.getElementsByName('chkId[]');
		for(var i=0, n=checkboxes.length;i<n;i++) {
			checkboxes[i].checked = source.checked;
		}
	}
	</script>
</head>
<body>
	<?php
		include("../includes/header.inc.php");
		include("../includes/nav_manufacturer.inc.php");
		include("../includes/aside_manufacturer.inc.php");
	?>
	<section>
		<h1>Нэгж харах</h1>
		<form action="" method="POST" class="form">
		<table class="table_displayData">
			<tr>
				<th> <input type="checkbox" onClick="toggle(this)" /> </th>
				<th>Sr дугаар.</th>
				<th>Нэр</th>
				<th>Тайлбар</th>
				<th>Засах </th>
			</tr>
			<?php $i=1; while($row_selectUnit = mysqli_fetch_array($result_selectUnit)) { ?>
			<tr>
				<td> <input type="checkbox" name="chkId[]" value="<?php echo $row_selectUnit['id']; ?>" /> </td>
				<td> <?php echo $i; ?> </td>
				<td> <?php echo $row_selectUnit['unit_name']; ?> </td>
				<td> <?php echo $row_selectUnit['unit_details']; ?> </td>
				<td> <a href="edit_unit.php?id=<?php echo $row_selectUnit['id']; ?>"><img src="../images/edit.png" alt="edit" /></a> </td>
			</tr>
			<?php $i++; } ?>
		</table>
		<input type="submit" value="Устгах" class="submit_button"/>
		<a href="add_unit.php"><input type="button" value="Нэмэх" class="submit_button"/></a>
		</form>
	</section>
	<?php
		include("../includes/footer.inc.php");
	?>
</body>
</html>