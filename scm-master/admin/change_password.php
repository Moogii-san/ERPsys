<?php
	include("../includes/config.php");
	include("../includes/validate_data.php");
	session_start();
	if(isset($_SESSION['admin_login'])) {
		$requireErr = $oldPasswordErr = $matchErr ="";
		if($_SERVER['REQUEST_METHOD'] == "POST") {
			if(!empty($_POST['txtOldPassword'])){
				$password = $_POST['txtOldPassword'];
				$query_oldPassword = "SELECT password FROM admin WHERE password='$password'";
				$result_oldPassword = mysqli_query($con,$query_oldPassword);
				$row_oldPassword = mysqli_fetch_array($result_oldPassword);
				if($row_oldPassword) {
					if(!empty($_POST['txtNewPassword']) && !empty($_POST['txtConfirmPassword'])){
						$newPassword = $_POST['txtNewPassword'];
						$confirmPassword = $_POST['txtConfirmPassword'];
						if(strcmp($newPassword,$confirmPassword) == 0) {
							$query_UpdatePassword = "UPDATE admin SET password='$confirmPassword' WHERE id=1";
							if(mysqli_query($con,$query_UpdatePassword)) {
								echo "<script> alert(\"Амжилттай\"); </script>";
								header("Refresh:0");
							}
							else {
								$requireErr = "* Алдаа гарлаа";
							}
						}
						else {
							$matchErr = "* Нууц үг таарахгүй бана";
						}
					}
					else {
						$requireErr = "* Бүгд бүрэн байх ёстой.";
					}
				}
				else {
					$oldPasswordErr = "* Хуучин нууц үг буруу байна.";
				}
			}
	}
	}
	else {
		header('Location:../index.php');
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title> Профайл хаяг </title>
	<link rel="stylesheet" href="../includes/main_style.css" >
</head>
<body>
	<?php
		include("../includes/header.inc.php");
		include("../includes/nav_admin.inc.php");
		include("../includes/aside_admin.inc.php");
	?>
	<section>
		<h1>Профайл хаяг</h1>
		<form action="" method="POST" class="form">
		<ul class="form-list">
		<li>
			<div class="label-block"> <label for="oldPassword">Хуучин нууц үг</label> </div>
			<div class="input-box"> <input type="password" id="oldPassword" name="txtOldPassword" placeholder="Old Password" required /> </div> <span class="error_message"><?php echo $oldPasswordErr; ?></span>
		</li>
		<li>
			<div class="label-block"> <label for="newPassword">Шинэ нууц үг</label> </div>
			<div class="input-box"> <input type="password" id="newPassword" name="txtNewPassword" placeholder="New Password"  required /> </div>
		</li>
		<li>
			<div class="label-block"> <label for="confirmPassword">Шинэ нууц үг</label> </div>
			<div class="input-box"> <input type="password" id="confirmPassword" name="txtConfirmPassword" placeholder="Confirm Password"  required /> </div><span class="error_message"><?php echo $matchErr; ?></span>
		</li>
		<li>
			<input type="submit" value="Шинэчлэх" class="submit_button" /> <span class="error_message"> <?php echo $requireErr; ?>
		</li>
		</ul>
		</form>
	</section>
	<?php
		include("../includes/footer.inc.php");
	?>
</body>
</html>