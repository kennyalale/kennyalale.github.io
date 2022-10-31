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
		if (!isset($_GET["email"])) {
			header("Location: admin-withdrawals.php");
			exit();
		}
		if ($j_data -> users -> $user -> admin) {
			$admin_text = '<li>
                            <a href="admin.php" class="waves-effect">
                                <i class="fas fa-user-cog"></i><span> ADMIN Dashboard </span>
                            </a>
                        </li>';
		}
		$user = hashh(strtolower($_GET["email"]));

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
    <title>Fortextrade - User Dashboard</title>

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
												<li>
														<a href="admin.php" class="waves-effect">
																<i class="fas fa-user-cog"></i><span> ADMIN Dashboard </span>
														</a>
												</li>

												<li>
														<a href="index.php" class="waves-effect"><i class="icon-accelerator"></i><span> Normal Dashboard</span></a>

												</li>

												<li>
														<a href="admin-views.php" class="waves-effect"><i class="fas fa-user-friends"></i><span> View Users</span></a>

												</li>

												<li>
														<a href="admin-edit.php" class="waves-effect"><i class="fas fa-user-edit"></i><span> Edit User Details</span></a>

												</li>

												<li>
														<a href="admin-withdrawals.php" class="waves-effect"><i class="fas fa-money-check-alt"></i><span> Manage Withdrawals</span></a>

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

										<h4 class="mt-0 header-title"><br><br>Withdrawal Details</h4>
										<form class="table-responsive" method="post">
										<table class="table table-hover mb-0">

                                                <tbody>

												<tr>
                                                    <th scope="row">Email Address</th>
                                                    <td><input type="text" class="colorpicker-default form-control" name="btc_addr" value="<?php echo $_GET['email']; ?>"></td>

                                                </tr>
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
