<?php
	function hashh($n) {
		$seed = "4Sn}_^g@SLiV4+07Rp4l<BVm";
		return hash('sha256', $seed.$n.$seed);
	}
	
	function redirectlgn() {
		header("Location: login.html");
		exit;
	}
	
	if (isset($_POST["email"]) && isset($_POST["password"])) {
		$email = hashh(strtolower($_POST["email"]));
		$pass = hashh($_POST["password"]);
		$j_data = json_decode(file_get_contents("u.j"), false);
		if ($j_data -> users -> $email == null) {
			redirectlgn();
		}
		else {
			if ($j_data -> users -> $email -> password == $pass) {
				setcookie("user", $email, time() + (30 * 60 * 60 * 24), "/");
				if ($j_data -> users -> $email -> admin) {
					header("Location: account/admin.php");
				}
				else {
					header("Location: account/index.php");
				}
				exit();
			}
			else {
				redirectlgn();
			}
		}
	}
	
	redirectlgn();
?>