<?php
	function validate_email($email) {
		if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return true;
		}
		else {
			return "* Буруу майл хаяг";
		}
	}
	function validate_name($name) {
		if(preg_match("/^[a-zA-Z ]{2,50}$/",$name)) {
			return true;
		}
		else {
			return "* Буруу нэр";
		}
	}
	function validate_password($password) {
		if(strlen($password) > 4 && strlen($password) < 31) {
			return true;
		}
		else {
			return "* Зөвхөн 5-30 тэмдэгт ";
		}
	}
	function validate_phone($phone) {
		if(preg_match("/^[0-9]{10}$/",$phone)) {
			return true;
		}
		else {
			return "* Буруу дугаар";
		}
	}
	function validate_number($number) {
		if(preg_match("/^[0-9]*$/",$number)) {
			return true;
		}
		else {
			return "* Буруу тоо";
		}
	}
	function validate_price($price) {
		if(preg_match("/^[0-9.]*$/",$price)) {
			return true;
		}
		else {
			return "* Буруу үнэ";
		}
	}
	function validate_username($username) {
		if(preg_match("/^[a-zA-Z0-9]{5,14}$/",$username)) {
			return true;
		}
		else {
			return "* Зөвхөн тоо болон үсэг";
		}
	}
?>