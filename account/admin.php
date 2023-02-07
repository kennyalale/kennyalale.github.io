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
	if (isset($j_data -> users -> $user))
	{
		if ($j_data -> users -> $user -> admin) {
			$total_users = count((array)$j_data -> users);
			$pending_withdrawals = count($j_data -> WITHDRAWS);
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
								ADMIN Site Overview</h2>
            </div>
			
			<div class="content">
				
                <div class="container-fluid">
                 
   

                <div class="row">

                        <div class="col-sm-6 col-xl-6">
                            <div class="card">
                                <div class="card-heading p-4">
                                    <div class="mini-stat-icon float-right">
                                        <i class="fas fa-user-friends bg-primary text-white"></i>
                                    </div>
                                    <div>
                                        <h5 class="font-16">Total Users</h5>
                                    </div>
                                    <h3 class="mt-4"><?php echo $total_users; ?></h3>
                                   
                                </div>
                            </div>
                        </div>

                         <div class="col-sm-6 col-xl-6">
                            <div class="card">
                                <div class="card-heading p-4">
                                    <div class="mini-stat-icon float-right">
                                        <i class="fas fa-money-check-alt bg-danger  text-white"></i>
                                    </div>
                                    <div>
                                        <h5 class="font-16">Pending Withdrawals</h5>
                                    </div>
                                    <h3 class="mt-4"><?php echo $pending_withdrawals; ?></h3>
                                   
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