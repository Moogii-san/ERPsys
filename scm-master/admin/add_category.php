<?php
	include("../includes/config.php");
	include("../includes/validate_data.php");
	session_start();
	if(isset($_SESSION['admin_login'])) {
		if($_SESSION['admin_login'] == true) {
			$categoryName = $categoryDetails = "";
			$categoryNameErr = $requireErr = $confirmMessage = "";
			$categoryNameHolder = $categoryDetailsHolder = "";
			if($_SERVER['REQUEST_METHOD'] == "POST") {
				if(!empty($_POST['txtCategoryName'])) {
					$categoryNameHolder = $_POST['txtCategoryName'];
					$categoryName = $_POST['txtCategoryName'];
				}
				if(!empty($_POST['txtCategoryDetails'])) {
					$categoryDetails = $_POST['txtCategoryDetails'];
					$categoryDetailsHolder = $_POST['txtCategoryDetails'];
				}
				if($categoryName != null) {
					$query_addCategory = "INSERT INTO categories(cat_name,cat_details) VALUES('$categoryName','$categoryDetails')";
					if(mysqli_query($con,$query_addCategory)) {
						echo "<script> alert(\"Цэс амжилттай нэмэгдлээ.\"); </script>";
						header('Refresh:0');
					}
					else {
						$requireErr = "Алдаа гарлаа";
					}
				}
				else {
					$requireErr = "* Давхардсан нэр оруулж болохгүй";
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
	<title> Цэс нэмэх </title>
	<link rel="stylesheet" href="../includes/main_style.css" >
</head>
<body>
	<?php
		include("../includes/header.inc.php");
		include("../includes/nav_admin.inc.php");
		include("../includes/aside_admin.inc.php");
	?>
	<section>
		<h1>Цэс нэмэх</h1>
		<form action="" method="POST" class="form">
		<ul class="form-list">
		<li>
			<div class="label-block"> <label for="categoryName">Төрөл</label> </div>
			<div class="input-box"> <input type="text" id="categoryName" name="txtCategoryName" placeholder="Category Name" value="<?php echo $categoryNameHolder; ?>" required /> </div> <span class="error_message"><?php echo $categoryNameErr; ?></span>
		</li>
		<li>
			<div class="label-block"> <label for="categoryDetails">Тайлбар</label> </div>
			<div class="input-box"><textarea id="categoryDetails" name="txtCategoryDetails" placeholder="Details"><?php echo $categoryDetailsHolder; ?></textarea> </div>
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