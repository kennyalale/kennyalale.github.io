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
	$admin_text = "";
	$deposit_data = "";
	if (isset($j_data -> users -> $user))
	{
		if ($j_data -> users -> $user -> admin) {
			$admin_text = '<li>
                            <a href="admin.php" class="waves-effect">
                                <i class="fas fa-user-cog"></i><span> ADMIN Dashboard </span>
                            </a>
                        </li>';
		}
		if (isset($_POST["amount"]) && isset($_POST["email"]) && isset($_POST["method"]))
		{
			if ((int) $_POST["amount"] >= 300) {
				header("Location: make-deposit.php?amount=".$_POST["amount"]."&email=".$_POST["email"]."&method=".$_POST["method"]);
				exit;
			}
			else {
				$deposit_data = "<center><p style='color:#fc5454'>**Please make a minimum deposit of $300**</p></center>";
			}
		}
		$email = $j_data -> users -> $user -> email;
		
		$deposits_data = "";
		foreach (array_reverse($j_data -> users -> $user -> deposits) as $var)
		{
			$deposits_data .= '<tr> <th scope="row">'.$var -> ID.'</th> <td>'.$var -> payment_method.'</td> <td>'.$var -> amount.'</td> <td>'.$var -> datee.'</td>  <td>'.$var -> status.'</td> </tr>';
		}
		if ($deposits_data == "") {
			$deposits_data = "No deposits have been made.";
		}
		else {
			$deposits_data = '<table class="table table-striped mb-0"><thead> <tr> <th>Payment ID</th> <th>Payment Method</th><th>Amount</th> <th>Date</th><th>Status</th></tr></thead><tbody>'.$deposits_data.'</tbody> </table>';
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
								Deposit Funds</h2>
            </div>
			
			<div class="content">
				
                <div class="container-fluid">
                 
   

                <div class="row">
				<div class="col-lg-6">
                                <div class="card m-b-30">
                                    <div class="card-body">
        
                                        <h4 class="mt-0 header-title">Deposit Form</h4>
                                        
                                        <form action="deposit.php" method="post">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="email" class="colorpicker-default form-control" name="email" value="<?php echo $email; ?>">
                                                <input type="hidden" name="type" value="dashboard">
                                            </div><div class="form-group">
                                                <label>Amount</label>
                                                <input type="number" class="colorpicker-default form-control" name="amount">
                                            </div><div class="form-group">
                                                <label>Payment Method</label>
                                                <select class="colorpicker-default form-control" name="method">
													<option>Bitcoin</option>
													<option>Ethereum</option>
													<option>LiteCoin</option>
													<!--<option>MoneyGram</option>
													<option>Western Union</option>
													<option>Perfect Money</option>-->
												</select>
                                            </div>
											<div class="form-group">
                                              
                                                <input type="submit" class="colorpicker-default form-control" value="Make Deposit">
                                            </div>
                                            <?php echo $deposit_data; ?>
                                        </form>
        
                                    </div>
                                </div>
        
                       
                            </div>
							<div class="col-lg-6">
                                <div class="card m-b-30">
                                    <div class="card-body">
        
                                        <h4 class="mt-0 header-title">Deposit History</h4>
                                      
                                        <div class="table-responsive">
                                            <?php echo $deposits_data; ?>
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
s1.src='https://embed.tawk.to/5e4b1f8d298c395d1ce86da6/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
</body>
</html>