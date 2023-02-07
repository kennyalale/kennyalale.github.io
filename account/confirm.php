<?php
	$invoice = $_GET["id"];
	if (strpos($_SERVER['HTTP_REFERER'], "coinpayments.net") !== false)
	{
		$j_data = json_decode(file_get_contents("../u.j"), false);
		$index = 0;
		foreach ($j_data -> DEPOSITS as $var) {
			if ($var -> ID == $invoice) {
				$token = $var -> user;
				$tokenn = 0;
				foreach ($j_data -> users -> $token -> deposits as $varr) {
					if ($varr -> ID == $var -> ID) {
						$amount = $j_data -> users -> $token -> deposits[$tokenn] -> amount;
						$j_data -> users -> $token -> account_balance += (int) $amount;
						$j_data -> users -> $token -> deposits[$tokenn] -> status = "COMPLETED";
						break;
					}
					$tokenn += 1;
				}
				unset($j_data -> DEPOSITS[$index]);
				$file = fopen("../u.j", "w");
				fwrite($file, json_encode($j_data, JSON_PRETTY_PRINT));
				fclose($file);
				break;
			}
			$index += 1;
		}
	}
	header("Location: account.php");
	exit();
?>