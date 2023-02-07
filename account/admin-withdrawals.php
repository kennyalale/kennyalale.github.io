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

	$user = $_COOKIE["user"];
	$j_data = json_decode(file_get_contents("../u.j"), false);
	$rem = false;
	if (isset($_GET["ID"])) {
			$rem = true;
	}
	if (isset($j_data -> users -> $user))
	{
		if ($j_data -> users -> $user -> admin) {
			$withdrawals_data = "";
			$idd = 0;
			foreach ($j_data -> WITHDRAWS as $var)
			{
				$id = $var -> user;
				$index = 0;
				foreach ($j_data -> users -> $id -> withdraws as $varr)
				{
					if ($varr -> ID == $var -> ID) {
						if ($rem) {
							if ($_GET["ID"] == $var -> ID) {
								$j_data -> users -> $id -> withdraws[$index] -> status = "COMPLETED";
								unset($j_data -> WITHDRAWS[$idd]);
								$file = fopen("../u.j", "w");
								fwrite($file, json_encode($j_data, JSON_PRETTY_PRINT));
								fclose($file);
								break;
							}
						}
						$withdrawals_data .= '<tr> <th scope="row">'.$varr -> ID.'</th> <td>'.$varr -> datee.'</td> <td>'.$varr -> payment_method.'</td> <td>'.$varr -> amount.'</td> <td><a href="admin-withdrawal-view.php?email='.$varr -> email.'"><button>View Withdrawal Details</button></a></td> <td><a href="admin-withdrawals.php?ID='.$varr -> ID.'"><button>Clear Withdraw Request</button></a></td> </tr>';
						break;
					}
					$index += 1;
				}
				$idd += 1;
			}

			if ($withdrawals_data == "") {
				$withdrawals_data = "There are no pending withdrawals";
			}
			else {
				$withdrawals_data = '<table class="table table-striped mb-0"><thead> <tr> <th>ID</th> <th>Date</th><th>Payment Method</th> <th>Amount</th><th>View Withdrawal Details</th><th>Clear Withdraw Request</th></tr></thead><tbody>'.$withdrawals_data.'</tbody> </table>';
			}
		}
		else {
			header("Location: account.php");
			exit();
		}
	}
	else
	{
		setcookie("user", "logout", time() - (24 * 60 * 60 * 24), "/");
		header("Location: ../login.html");
		exit();
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
								Users Withdrawals</h2>
            </div>

			<div class="content">

                <div class="container-fluid">



                <div class="row">

                        <div class="col-lg-12">
                                <div class="card m-b-30">
                                    <div class="card-body">

                                        <h4 class="mt-0 header-title">User Withdrawals</h4>

                                        <div class="table-responsive">
                                            <?php echo $withdrawals_data; ?>
										</div>
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
