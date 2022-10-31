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
	$plan_message = "";
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
		if (isset($_GET["plan"])) {
			$plan = $_GET["plan"];
			if ($plan == "BRONZE") {
				$min = 300;
				$max = 5000;
			}
			else if ($plan == "SILVER"){
				$min = 6000;
				$max = 15000;
			}
			else if ($plan == "GOLD") {
				$min = 16000;
				$max = 50000;
			}
			else {
				header("Location: plans.php");
			}
			
			$account_balance = (float) $j_data -> users -> $user -> account_balance;
			if ($account_balance >= $min) {
				if ($account_balance >= $max) {
					$plan_amount = $max;
				}
				else {
					$plan_amount = $account_balance;
				}
				$j_data -> users -> $user -> account_balance = $account_balance - $plan_amount;
				$j_data -> users -> $user -> investment_profits = (float)$j_data -> users -> $user -> investment_profits + $plan_amount;
				$j_data -> users -> $user -> investment_plan = $plan;
				
				if (!isset($j_data -> users -> $user -> referrer)) {
					$j_data -> users -> $user -> referrer = "none";
				}
				if ($j_data -> users -> $user -> referrer != "none") {
					$referrer = $j_data -> users -> $user -> referrer;
					if (!isset($j_data -> users -> $referrer -> refs_earnings)) {
						$j_data -> users -> $referrer -> refs_earnings = 0;
					}
					$j_data -> users -> $referrer -> refs_earnings += ($plan_amount * 5 / 100);
					$j_data -> users -> $referrer -> account_balance += ($plan_amount * 5 / 100);
				}
				$file = fopen("../u.j", "w");
				fwrite($file, json_encode($j_data, JSON_PRETTY_PRINT));
				fclose($file);
				header("Location: account.php");
			}
			else {
				$plan_message = "<p style='color:#fc5454'>**Insufficient balance for this plan**</p>";
			}
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
    <title>PurefxTrades - User Dashboard</title>
   
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
								Investment Plans</h2>
            </div>
			
			<div class="content">
                <div class="container-fluid">
                  

                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="text-center">
                                <h5>Choose an Investment Plan</h5>
                                <p class="text-muted">To start earning on PurefxTrades please make sure you have funded your account before choosing an Investment plan</p>
								<?php echo $plan_message; ?>
                            </div>
                        </div>
                    </div>

					<form method="post">
                    <div class="row m-t-30">
                        <div class="col-xl-4 col-md-6">
                            <div class="card pricing-box mt-4">
                                <div class="pricing-icon">
                                    <i class="fas fa-dollar-sign bg-success"></i>
                                </div>
                                <div class="pricing-content">
                                    <div class="text-center">
                                        <h5 class="text-uppercase mt-5">BRONZE</h5>
                                        <div class="pricing-plan mt-4 pt-2">
                                            <h1><sup>$ </sup>300 - 1000</h1>
                                        </div>
                                        
                                    </div>
                                    <div class="pricing-features mt-4">
                                            <p class="font-14 mb-2"><i class="ti-check-box text-success mr-3"></i> 50% ROI </p>
                                            <p class="font-14 mb-2"><i class="ti-check-box text-success mr-3"></i> 1 Week Contract Frame</p>
                                            <p class="font-14 mb-2"><i class="ti-check-box text-success mr-3"></i> 20% Management Fee </p>
                                            <p class="font-14 mb-2"><i class="ti-check-box text-success mr-3"></i> 100% Guaranteed</p>
                                            <p class="font-14 mb-2"><i class="ti-check-box text-success mr-3"></i> Customer Support</p>
                                    </div>
                                    <div class="pricing-border mt-4"></div>
                                    <div class="mt-4 pt-3 text-center">
                                        <a href="plans.php?plan=BRONZE" class="btn btn-success btn-lg w-100 btn-round">Get Started</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-md-6">
                                <div class="card pricing-box mt-4">
                                    <div class="pricing-icon">
                                        <i class="fas fa-dollar-sign bg-primary"></i>
                                    </div>
                                    <div class="pricing-content">
                                    <div class="text-center">
                                        <h5 class="text-uppercase mt-5">SILVER</h5>
                                        <div class="pricing-plan mt-4 pt-2">
                                            <h1><sup>$ </sup>2000 - 5000</h1>
                                        </div>
                                        
                                    </div>
                                    <div class="pricing-features mt-4">
                                            <p class="font-14 mb-2"><i class="ti-check-box text-success mr-3"></i> 60% ROI </p>
                                            <p class="font-14 mb-2"><i class="ti-check-box text-success mr-3"></i> 10 days Contract Frame</p>
                                            <p class="font-14 mb-2"><i class="ti-check-box text-success mr-3"></i> 20% Management Fee </p>
                                            <p class="font-14 mb-2"><i class="ti-check-box text-success mr-3"></i> 100% Guaranteed</p>
                                            <p class="font-14 mb-2"><i class="ti-check-box text-success mr-3"></i> Customer Support</p>
                                    </div>
                                    <div class="pricing-border mt-4"></div>
                                    <div class="mt-4 pt-3 text-center">
                                        <a href="plans.php?plan=SILVER" class="btn btn-primary btn-lg w-100 btn-round">Get Started</a>
                                    </div>
                                </div>
                                </div>
                            </div>

                            <div class="col-xl-4 col-md-6">
                                    <div class="card pricing-box mt-4">
                                        <div class="pricing-icon">
                                            <i class="fas fa-dollar-sign bg-warning"></i>
                                        </div>
                                        <div class="pricing-content">
                                    <div class="text-center">
                                        <h5 class="text-uppercase mt-5">GOLD</h5>
                                        <div class="pricing-plan mt-4 pt-2">
                                            <h1><sup>$ </sup>6000 - 50000</h1>
                                        </div>
                                        
                                    </div>
                                    <div class="pricing-features mt-4">
                                            <p class="font-14 mb-2"><i class="ti-check-box text-success mr-3"></i> 70% ROI </p>
                                            <p class="font-14 mb-2"><i class="ti-check-box text-success mr-3"></i> 2 Weeks Contract Frame</p>
                                            <p class="font-14 mb-2"><i class="ti-check-box text-success mr-3"></i> 20% Management Fee </p>
                                            <p class="font-14 mb-2"><i class="ti-check-box text-success mr-3"></i> 100% Guaranteed</p>
                                            <p class="font-14 mb-2"><i class="ti-check-box text-success mr-3"></i> Customer Support</p>
                                    </div>
                                    <div class="pricing-border mt-4"></div>
                                    <div class="mt-4 pt-3 text-center">
                                        <a href="plans.php?plan=GOLD" class="btn btn-warning btn-lg w-100 btn-round">Get Started</a>
                                    </div>
                                </div>
                                    </div>
                                </div>

                    </div>
					</form>

                </div>
                <!-- container-fluid -->

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
<!-- GetButton.io widget -->
<script type="text/javascript">
    (function () {
        var options = {
            whatsapp: "+1 (619) 777-7497", // WhatsApp number
            call_to_action: "Message us", // Call to action
            position: "left", // Position may be 'right' or 'left'
        };
        var proto = document.location.protocol, host = "getbutton.io", url = proto + "//static." + host;
        var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = url + '/widget-send-button/js/init.js';
        s.onload = function () { WhWidgetSendButton.init(host, proto, options); };
        var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(s, x);
    })();
</script>
<!-- /GetButton.io widget -->

<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/5e4b1f8d298c395d1ce86da6/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
</html>