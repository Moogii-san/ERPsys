<?php
	include("../includes/config.php");
	session_start();
	if(isset($_SESSION['admin_login'])) {
		if($_SESSION['admin_login'] == true) {
			$query_selectDistributor = "SELECT * FROM distributor";
			$result_selectDistributor = mysqli_query($con,$query_selectDistributor);
			if($_SERVER['REQUEST_METHOD'] == "POST") {
				if(isset($_POST['chkId'])) {
					$chkId = $_POST['chkId'];
					foreach($chkId as $id) {
						$query_deleteDistributor = "DELETE FROM distributor WHERE dist_id='$id'";
						$result = mysqli_query($con,$query_deleteDistributor);
					}
					if(!$result) {
						echo "<script> alert(\"You can not delete the distributor assigned on Invoice\"); </script>";
						header('Refresh:0');
					}
					else {
						echo "<script> alert(\"Distributor Deleted Successfully\"); </script>";
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
	<title> Борлуулагч харах </title>
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
		include("../includes/nav_admin.inc.php");
		include("../includes/aside_admin.inc.php");
	?>
	<section>
		<h1>Борлуулагч харах</h1>
		<form action="" method="POST" class="form">
		<table class="table_displayData">
			<tr>
				<th> <input type="checkbox" onClick="toggle(this)" /> </th>
				<th>Sr. Дугаар.</th>
				<th>Нэр</th>
				<th>Майл хаяг</th>
				<th>Дугаар</th>
				<th>Хаяг</th>
				<th> Засах </th>
			</tr>
			<?php $i=1; while($row_selectDistributor = mysqli_fetch_array($result_selectDistributor)) { ?>
			<tr>
				<td> <input type="checkbox" name="chkId[]" value="<?php echo $row_selectDistributor['dist_id']; ?>" /> </td>
				<td> <?php echo $i; ?> </td>
				<td> <?php echo $row_selectDistributor['dist_name']; ?> </td>
				<td> <?php echo $row_selectDistributor['dist_email']; ?> </td>
				<td> <?php echo $row_selectDistributor['dist_phone']; ?> </td>
				<td> <?php echo $row_selectDistributor['dist_address']; ?> </td>
				<td> <a href="edit_distributor.php?id=<?php echo $row_selectDistributor['dist_id']; ?>"><img src="../images/edit.png" alt="edit" /></a> </td>
			</tr>
			<?php $i++; } ?>
		</table>
		<input type="submit" value="Delete" class="submit_button"/>
		</form>
	</section>
	<?php
		include("../includes/footer.inc.php");
	?>
</body>
</html>