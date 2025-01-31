<?php
	include("../includes/config.php");
	include("../includes/validate_data.php");
	session_start();
	if(isset($_SESSION['admin_login'])) {
		if($_SESSION['admin_login'] == true) {
			$name = $email = $phone = $username = $password = "";
			$nameErr = $emailErr = $phoneErr = $usernameErr = $passwordErr = $requireErr = $confirmMessage = "";
			$nameHolder = $emailHolder = $phoneHolder = $usernameHolder = "";
			if($_SERVER['REQUEST_METHOD'] == "POST") {
				if(!empty($_POST['txtManufacturerName'])) {
					$nameHolder = $_POST['txtManufacturerName'];
					$resultValidate_name = validate_name($_POST['txtManufacturerName']);
					if($resultValidate_name == 1) {
						$name = $_POST['txtManufacturerName'];
					}
					else{
						$nameErr = $resultValidate_name;
					}
				}
				if(!empty($_POST['txtManufacturerEmail'])) {
					$emailHolder = $_POST['txtManufacturerEmail'];
					$resultValidate_email = validate_email($_POST['txtManufacturerEmail']);
					if($resultValidate_email == 1) {
						$email = $_POST['txtManufacturerEmail'];
					}
					else {
						$emailErr = $resultValidate_email;
					}
				}
				if(!empty($_POST['txtManufacturerPhone'])) {
					$phoneHolder = $_POST['txtManufacturerPhone'];
					$resultValidate_phone = validate_phone($_POST['txtManufacturerPhone']);
					if($resultValidate_phone == 1) {
						$phone = $_POST['txtManufacturerPhone'];
					}
					else {
						$phoneErr = $resultValidate_phone;
					}
				}
				if(!empty($_POST['txtManufacturerUname'])) {
					$usernameHolder = $_POST['txtManufacturerUname'];
					$resultValidate_username = validate_username($_POST['txtManufacturerUname']);
					if($resultValidate_username == 1) {
						$username = $_POST['txtManufacturerUname'];
					}
					else{
						$usernameErr = $resultValidate_username;
					}
				}
				if(!empty($_POST['txtManufacturerPassword'])) {
					$resultValidate_password = validate_password($_POST['txtManufacturerPassword']);
					if($resultValidate_password == 1) {
						$password = $_POST['txtManufacturerPassword'];
					}
					else {
						$passwordErr = $resultValidate_password;
					}
				}
				if($name != null && $email != null && $username != null && $password != null) {
					$query_addManufacturer = "INSERT INTO manufacturer(man_name,man_email,man_phone,username,password) VALUES('$name','$email','$phone','$username','$password')";
					if(mysqli_query($con,$query_addManufacturer)) {
						echo "<script> alert(\"Амжилттай\"); </script>";
						header('Refresh:0');
					}
					else {
						$requireErr = "Алдаа гарлаа";
					}
				}
				else {
					$requireErr = "* Нэр, имэйл, хэрэглэгчийн нэр, нууц үг заавал байх ёстой";
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
	<title> Үйлдвэрлэгч нэмэх </title>
	<link rel="stylesheet" href="../includes/main_style.css" >
</head>
<body>
	<?php
		include("../includes/header.inc.php");
		include("../includes/nav_admin.inc.php");
		include("../includes/aside_admin.inc.php");
	?>
	<section>
		<h1>Үйлдвэрлэгч нэмэх</h1>
		<form action="" method="POST" class="form">
		<ul class="form-list">
		<li>
			<div class="label-block"> <label for="manufacturer:name">Нэр</label> </div>
			<div class="input-box"> <input type="text" id="manufacturer:name" name="txtManufacturerName" placeholder="Name" value="<?php echo $nameHolder; ?>" required /> </div> <span class="error_message"><?php echo $nameErr; ?></span>
		</li>
		<li>
			<div class="label-block"> <label for="manufacturer:email">Майл хаяг</label> </div>
			<div class="input-box"> <input type="text" id="manufacturer:email" name="txtManufacturerEmail" placeholder="Email" value="<?php echo $emailHolder; ?>" required /> </div> <span class="error_message"><?php echo $emailErr; ?></span>
		</li>
		<li>
			<div class="label-block"> <label for="manufacturer:phone">Дугаар</label> </div>
			<div class="input-box"> <input type="text" id="manufacturer:phone" name="txtManufacturerPhone" placeholder="Phone" value="<?php echo $phoneHolder; ?>" /> </div> <span class="error_message"><?php echo $phoneErr; ?></span>
		</li>
		<li>
			<div class="label-block"> <label for="manufacturer:username">НЭр</label> </div>
			<div class="input-box"> <input type="text" id="manufacturer:username" name="txtManufacturerUname" placeholder="Username" value="<?php echo $usernameHolder; ?>" required /> </div> <span class="error_message"><?php echo $usernameErr; ?></span>
		</li>
		<li>
			<div class="label-block"> <label for="manufacturer:password">Нууц үг</label> </div>
			<div class="input-box"> <input type="password" id="manufacturer:password" name="txtManufacturerPassword" placeholder="Password" required /> </div> <span class="error_message"><?php echo $passwordErr; ?></span>
		</li>
		<li>
			<input type="submit" value="Нэмэх" class="submit_button" /> <span class="error_message"> <?php echo $requireErr; ?> </span><span class="confirm_message"> <?php echo $confirmMessage; ?> </span>
		</li>
		</ul>
		</form>
	</section>
	<?php
		include("../includes/footer.inc.php");
	?>
</body>
</html>