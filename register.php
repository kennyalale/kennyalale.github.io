<?php
function hashh($n)
{
	$seed = "4Sn}_^g@SLiV4+07Rp4l<BVm";
	return hash('sha256', $seed . $n . $seed);
}

function redirectlgn()
{
	header("Location: register.html");
	exit;
}

function sanitize($n)
{
	return filter_var($n, FILTER_SANITIZE_STRING);
}

if (isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["country"]) && isset($_POST["number"]) && isset($_POST["password"])) {
	$email = hashh(strtolower($_POST["email"]));
	$mail = sanitize(strtolower($_POST["email"]));
	$pass = hashh($_POST["password"]);
	$j_data = json_decode(file_get_contents("u.j"), false);
	if (isset($j_data->$email)) {
		redirectlgn();
	}
	$j_data->users->$email->password = $pass;
	$j_data->users->$email->email = $mail;
	$j_data->users->$email->name = sanitize($_POST["name"]);
	$j_data->users->$email->country = sanitize($_POST["country"]);
	$j_data->users->$email->number = sanitize($_POST["number"]);
	$j_data->users->$email->admin = false;
	$j_data->users->$email->account_balance = 0;
	$j_data->users->$email->investment_profits = 0;
	$j_data->users->$email->investment_date = time();
	$j_data->users->$email->investment_plan = "None";
	$j_data->users->$email->interest_rate = 0;
	$j_data->users->$email->num_deposits = 0;
	$j_data->users->$email->num_withdraws = 0;
	$j_data->users->$email->notification = "";
	$j_data->users->$email->id_front_view = "";
	$j_data->users->$email->id_back_view = "";
	$j_data->users->$email->idverified = 1;
	$j_data->users->$email->deposits = [];
	$j_data->users->$email->withdraws = [];
	if (!isset($j_data->TOTAL_USERS)) {
		$j_data->TOTAL_USERS = 0;
		$j_data->users->$email->admin = true;
	}
	$myref = hashh(sanitize($_POST["ref"]));
	if (!isset($j_data->users->$myref)) {
		$myref = "none";
	} else {
		$myref = hashh(sanitize($_POST["ref"]));
	}
	$j_data->users->$email->referrer = $myref;
	if (!isset($j_data->WITHDRAWS)) {
		$j_data->WITHDRAWS = [];
	}
	if (!isset($j_data->DEPOSITS)) {
		$j_data->DEPOSITS = [];
	}
	$j_data->TOTAL_USERS += 1;
	$file = fopen("u.j", "w");
	fwrite($file, json_encode($j_data, JSON_PRETTY_PRINT));
	fclose($file);
	header("Location: login.html");
	exit;
}
header("Location: register.html");
exit;
