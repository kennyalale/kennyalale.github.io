<?php
	if (!isset($_COOKIE["user"]))
	{
		header("Location: ../login.html");
		exit();
	}

	if (isset($_GET["action"])) {
		if ($_GET["action"] == "logout")
		{
			setcookie("user", "logout", time() - (24 * 60 * 60 * 24), "/");
			header("Location: ../login.html");
			exit();
		}
	}

	function hashh($n) {
		$seed = "4Sn}_^g@SLiV4+07Rp4l<BVm";
		return hash('sha256', $seed.$n.$seed);
	}

	$user = $_COOKIE["user"];
	$j_data = json_decode(file_get_contents("../u.j"), false);
	$admin_text = "";
	if (isset($j_data -> users -> $user))
	{
		if ($j_data -> users -> $user -> admin) {
			$admin_text = '<li>
                            <a href="admin.php" class="waves-effect">
                                <i class="fas fa-user-cog"></i><span> ADMIN Dashboard </span>
                            </a>
                        </li>';
		}
		$name = $j_data -> users -> $user -> name;
		$email = $j_data -> users -> $user -> email;
		$country = $j_data -> users -> $user -> country;
		$number = $j_data -> users -> $user -> number;

		if (isset($_POST["btc_addr"])) {
			$j_data -> users -> $user -> btc_addr = $_POST["btc_addr"];
		}
if (isset($_POST["eth_addr"])) {
			$j_data -> users -> $user -> eth_addr = $_POST["eth_addr"];
		}
if (isset($_POST["bank_name"])) {
			$j_data -> users -> $user -> bank_name = $_POST["bank_name"];
		}
if (isset($_POST["acct_hold"])) {
			$j_data -> users -> $user -> acct_hold = $_POST["acct_hold"];
		}
if (isset($_POST["acct_num"])) {
			$j_data -> users -> $user -> acct_num = $_POST["acct_num"];
		}
if (isset($_POST["routing"])) {
			$j_data -> users -> $user -> routing = $_POST["routing"];
		}
if (isset($_POST["swift"])) {
			$j_data -> users -> $user -> swift = $_POST["swift"];
		}
if (isset($_POST["house_addr"])) {
			$j_data -> users -> $user -> house_addr = $_POST["house_addr"];
		}
if (isset($_POST["bank_addr"])) {
			$j_data -> users -> $user -> bank_addr = $_POST["bank_addr"];
		}
		
		if (!isset($j_data -> users -> $user -> refs_earnings)) {
			$j_data -> users -> $user -> refs_earnings = 0;
		}
		if (!isset($j_data -> users -> $user -> refs_num)) {
			$j_data -> users -> $user -> refs_num = 0;
		}
		$refs_num = $j_data -> users -> $user -> refs_num;
		$refs_earnings = $j_data -> users -> $user -> refs_earnings;
		$refs_link = "https://coincore.co/register.html?r=".$email;
		
		$file = fopen("../u.j", "w");
		fwrite($file, json_encode($j_data, JSON_PRETTY_PRINT));
		fclose($file);

		if (!isset($j_data -> users -> $user -> btc_addr)) {
			$j_data -> users -> $user -> btc_addr = "";
		}
		if (!isset($j_data -> users -> $user -> eth_addr)) {
			$j_data -> users -> $user -> eth_addr = "";
		}
		if (!isset($j_data -> users -> $user -> bank_name)) {
			$j_data -> users -> $user -> bank_name = "";
		}
		if (!isset($j_data -> users -> $user -> acct_hold)) {
			$j_data -> users -> $user -> acct_hold = "";
		}
		if (!isset($j_data -> users -> $user -> acct_num)) {
			$j_data -> users -> $user -> acct_num = "";
		}
		if (!isset($j_data -> users -> $user -> routing)) {
			$j_data -> users -> $user -> routing = "";
		}
		if (!isset($j_data -> users -> $user -> swift)) {
			$j_data -> users -> $user -> swift = "";
		}
		if (!isset($j_data -> users -> $user -> house_addr)) {
			$j_data -> users -> $user -> house_addr = "";
		}
		if (!isset($j_data -> users -> $user -> bank_addr)) {
			$j_data -> users -> $user -> bank_addr = "";
		}
		$btc_addr = $j_data -> users -> $user -> btc_addr;
		$eth_addr = $j_data -> users -> $user -> eth_addr;
		$bank_name = $j_data -> users -> $user -> bank_name;
		$acct_hold = $j_data -> users -> $user -> acct_hold;
		$acct_num = $j_data -> users -> $user -> acct_num;
		$routing = $j_data -> users -> $user -> routing;
		$swift = $j_data -> users -> $user -> swift;
		$house_addr = $j_data -> users -> $user -> house_addr;
		$bank_addr = $j_data -> users -> $user -> bank_addr;
	}
	else
	{
		setcookie("user", "logout", time() - (24 * 60 * 60 * 24), "/");
		header("Location: ../login.html");
	}

	$changed_pass = "";
	if (isset($_POST["currpass"]) && isset($_POST["newpass"]) && isset($_POST["confirmpass"]))
	{
		if ($j_data -> users -> $user -> password == hashh($_POST["currpass"])) {
			if ($_POST["newpass"] == $_POST["confirmpass"]) {
			$j_data -> users -> $user -> password = hashh($_POST["newpass"]);
			$file = fopen("../u.j", "w");
			fwrite($file, json_encode($j_data, JSON_PRETTY_PRINT));
			fclose($file);
			$changed_pass = "<p style='color:#02c58d'>**Successfully changed password**</p>";
			}
			else {
		$changed_pass = "<p style='color:#fc5454'>**Passwords do not match**</p>";
	}
		}
		else {
			$changed_pass = "<p style='color:#fc5454'>**Entered password is incorrect**</p>";
		}
	}
?>

<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>CoinCore - User Dashboard</title>

    <link rel="shortcut icon" href="assets/images/favicon.png">


    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/metismenu.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="assets/css/style.css" rel="stylesheet" type="text/css">

</head>

<body>

    <!-- Begin page -->
    <div id="wrapper">

        <!-- Top Bar Start -->
        <div class="topbar">

            <!-- LOGO -->
            <div class="topbar-left">
                <a href="index.php" class="logo">
                    <span class="logo-light">
                            <img src="assets/images/logo-light.png" width="100%">
                        </span>
                    <span class="logo-sm">
                            <i class="fas fa-home"></i>
                        </span>
                </a>
            </div>

            <nav class="navbar-custom">


                <ul class="list-inline menu-left mb-0">
                    <li class="float-left">
                        <button class="button-menu-mobile open-left waves-effect">
                            <i class="mdi mdi-menu"></i>
                        </button>
                    </li>

                </ul>

            </nav>

        </div>
        <!-- Top Bar End -->

        <!-- ========== Left Sidebar Start ========== -->
        <div class="left side-menu">
            <div class="slimscroll-menu" id="remove-scroll">

                <!--- Sidemenu -->
                <div id="sidebar-menu">
                    <!-- Left Menu Start -->
                    <ul class="metismenu" id="side-menu">
                        <li class="menu-title">Menu</li>
						<?php echo $admin_text; ?>
                        <li>
                            <a href="index.php" class="waves-effect">
                                <i class="icon-accelerator"></i><span> Dashboard </span>
                            </a>
                        </li>

                        <li>
                            <a href="account.php" class="waves-effect"><i class="fas fa-book"></i><span> Account Overview</span></a>

                        </li>

                        <li>
                            <a href="profile.php" class="waves-effect"><i class="fas fa-user"></i><span> Profile</span></a>

                        </li>

                        <li>
                            <a href="deposit.php" class="waves-effect"><i class="fas fa-hand-holding-usd"></i><span> Deposit</span></a>

                        </li>

                        <li>
                            <a href="plans.php" class="waves-effect"><i class="fas fa-coins"></i><span> Plans</span></a>

                        </li>

                        <li>
                            <a href="withdraw.php" class="waves-effect"><i class="fas fa-donate"></i><span> Withdraw</span></a>

                        </li>

						<li>
                            <a href="support.php" class="waves-effect"><i class="fas fa-mail-bulk"></i><span> Customer Support</span></a>

                        </li>

						<li>
                            <a href="index.php?action=logout" class="waves-effect"><i class="fas fa-power-off"></i><span> Logout</span></a>

                        </li>



                    </ul>

                </div>
                <!-- Sidebar -->
                <div class="clearfix"></div>

            </div>
            <!-- Sidebar -left -->

        </div>
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="content-page">
            <!-- Start content -->
			<div class="col-sm-12">
                                <h2 class="page-title">

								<br>
								<br>
								Profile Overview</h2>
            </div>

			<div class="content">

                <div class="container-fluid">



                <div class="row">
					<div class="col-lg-12">
                                <div class="card m-b-30">
                                    <div class="card-body">

                                        <h4 class="mt-0 header-title">Profile Info</h4>


                                        <div class="table-responsive">
                                            <table class="table table-hover mb-0">

                                                <tbody>
                                                <tr>
                                                    <th scope="row">Full Name</th>
                                                    <td><?php echo $name; ?></td>

                                                </tr>
                                                 <tr>
                                                    <th scope="row">Email</th>
                                                    <td><?php echo $email; ?></td>

                                                </tr>
                                                 <tr>
                                                    <th scope="row">Country</th>
                                                    <td><?php echo $country; ?></td>

                                                </tr>
                                                 <tr>
                                                    <th scope="row">Phone Number</th>
                                                    <td><?php echo $number; ?></td>

                                                </tr>
												 <tr>
                                                    <th scope="row">Number of Referrals</th>
                                                    <td><?php echo $refs_num; ?></td>

												</tr>
												<tr>
                                                    <th scope="row">Referral Earnings</th>
                                                    <td>$<?php echo $refs_earnings; ?></td>

												</tr>
												<tr>
                                                    <th scope="row">Referral Link</th>
                                                    <td><span id="reflink"><?php echo $refs_link; ?></span> <br><button id="clipboard" data-clipboard-target="#reflink">Copy</button></td>
                                                  
												</tr>
											</tbody>
										</table>
										</div>
										<h4 class="mt-0 header-title"><br><br>Withdrawal Details</h4>
										<form class="table-responsive" method="post">
										<table class="table table-hover mb-0">

                                                <tbody>

												<tr>
                                                    <th scope="row">Bitcoin Address</th>
                                                    <td><input type="text" class="colorpicker-default form-control" name="btc_addr" value="<?php echo $btc_addr; ?>"></td>

                                                </tr><tr>
                                                    <th scope="row">Ethereum Address</th>
                                                    <td><input type="text" class="colorpicker-default form-control" name="eth_addr" value="<?php echo $eth_addr; ?>"></td>

                                                </tr><tr>
                                                    <th scope="row">Bank Name</th>
                                                    <td><input type="text" class="colorpicker-default form-control" name="bank_name" value="<?php echo $bank_name; ?>"></td>

                                                </tr><tr>
                                                    <th scope="row">Account Holder Name</th>
                                                    <td><input type="text" class="colorpicker-default form-control" name="acct_hold" value="<?php echo $acct_hold; ?>"></td>

                                                </tr><tr>
                                                    <th scope="row">Account Number</th>
                                                    <td><input type="text" class="colorpicker-default form-control" name="acct_num" value="<?php echo $acct_num; ?>"></td>

                                                </tr><tr>
                                                    <th scope="row">Routing</th>
                                                    <td><input type="text" class="colorpicker-default form-control" name="routing" value="<?php echo $routing; ?>"></td>

                                                </tr><tr>
                                                    <th scope="row">Swift Code</th>
                                                    <td><input type="text" class="colorpicker-default form-control" name="swift" value="<?php echo $swift; ?>"></td>

                                                </tr><tr>
                                                    <th scope="row">House Address</th>
                                                    <td><input type="text" class="colorpicker-default form-control" name="house_addr" value="<?php echo $house_addr; ?>"></td>

                                                </tr><tr>
                                                    <th scope="row">Bank Address</th>
                                                    <td><input type="text" class="colorpicker-default form-control" name="bank_addr" value="<?php echo $bank_addr; ?>"></td>

                                                </tr>

                                                </tbody>
                                            </table>
																						<input type="submit" class="colorpicker-default form-control" value="Set Withdrawal Details">
                                        </form>
                                    </div>
                                </div>
                            </div>
				</div>
				<hr style="border-color:white">
				<div class="row">
					<div class="col-lg-12">
                                <div class="card m-b-30">
                                    <div class="card-body">

                                        <h4 class="mt-0 header-title">Change Password</h4>
                                        <?php echo $changed_pass; ?>
                                        <form method="post">
                                            <div class="form-group">
                                                <label>Current Password</label>
                                                <input type="password" class="colorpicker-default form-control" name="currpass">

                                            </div><div class="form-group">
                                                <label>New Password</label>
                                                <input type="password" class="colorpicker-default form-control" name="newpass">

                                            </div><div class="form-group">
                                                <label>Confirm Password</label>
                                                <input type="password" class="colorpicker-default form-control" name="confirmpass">

                                            </div>
											<div class="form-group">

                                                <input type="submit" class="colorpicker-default form-control" value="Change Password">
                                            </div>

                                        </form>

                                    </div>
                                </div>


                            </div>
				</div>
			</div>
		</div>

            <footer class="footer">
                © 2019 All Rights Reserved
            </footer>

        </div>
        <!-- ============================================================== -->
        <!-- End Right content here -->
        <!-- ============================================================== -->

    </div>
    <!-- END wrapper -->

    <!-- jQuery  -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/metismenu.min.js"></script>
    <script src="assets/js/jquery.slimscroll.js"></script>
    <script src="assets/js/waves.min.js"></script>

    <script src="assets/pages/dashboard.init.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.0/clipboard.min.js"></script>
	<script>
		new ClipboardJS('#clipboard');
	</script>

    <!-- App js -->
    <script src="assets/js/app.js"></script>
	<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/5d762bcf77aa790be3331e01/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
</body>
</html>
