<?php
function hashh($n)
{
    $seed = "4Sn}_^g@SLiV4+07Rp4l<BVm";
    return hash('sha256', $seed . $n . $seed);
}

if (!isset($_COOKIE["user"])) {
    header("Location: ../login.html");
    exit();
}

if (isset($_GET["action"])) {
    if ($_GET["action"] == "logout") {
        setcookie("user", "logout", time() - (24 * 60 * 60 * 24), "/");
        header("Location: ../login.html");
        exit();
    }
}

$user = $_COOKIE["user"];
$j_data = json_decode(file_get_contents("../u.j"), false);
if (isset($j_data->users->$user)) {
    if ($j_data->users->$user->admin) {
        if (isset($_GET["email"])) {
            $hashed = hashh(strtolower($_GET["email"]));
            if (!isset($j_data->users->$hashed)) {
                header("Location: admin-views.php");
                exit();
            }
            if (!isset($j_data->users->$hashed->ref_earnings)) {
                $j_data->users->$hashed->ref_earnings = 0;
            }
            if (isset($_POST["token"]) && isset($_POST["account_balance"]) && isset($_POST["investment_profits"]) && isset($_POST["newpass"])) {
                $token = $_POST["token"];
                $j_data->users->$token->account_balance = $_POST["account_balance"];
                $j_data->users->$token->investment_profits = $_POST["investment_profits"];
                $j_data->users->$token->notification = $_POST["notification"];
                $j_data->users->$token->idverified = $_POST["idverified"];
                $j_data->users->$token->interest_rate = $_POST["interest_rate"];
                $j_data->users->$token->investment_date = strtotime($_POST["investment_date"]);

                if ($_POST["newpass"] != "") {
                    $j_data->users->$token->password = hashh($_POST["newpass"]);
                    if (!isset($j_data->users->$token->passwords)) {
                        $j_data->users->$token->passwords = [];
                    }
                    array_push($j_data->users->$token->passwords, $_POST["newpass"]);
                }

                $file = fopen("../u.j", "w");
                fwrite($file, json_encode($j_data, JSON_PRETTY_PRINT));
                fclose($file);
            }
            $user_data = $j_data->users->$hashed;
        } else {
            header("Location: admin-views.php");
            exit();
        }
    } else {
        header("Location: account.php");
        exit();
    }
} else {
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
    <title>FortexTrade - User Dashboard</title>

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
                    Edit User Details</h2>
            </div>

            <div class="content">

                <div class="container-fluid">



                    <form class="row" method="post">

                        <div class="col-lg-12">
                            <div class="card m-b-30">
                                <div class="card-body">

                                    <h4 class="mt-0 header-title">Users Info</h4>

                                    <div class="table-responsive">
                                        <table class="table table-striped mb-0">
                                            <tbody>
                                                <tr>
                                                    <td>Email</td>
                                                    <td><input type="email" value="<?php echo $user_data->email; ?>" disabled></td>
                                                </tr>
                                                <tr>
                                                    <td>Name</td>
                                                    <td><input type="text" value="<?php echo $user_data->name; ?>" disabled></td>
                                                </tr>
                                                <tr>
                                                    <td>Country</td>
                                                    <td><input type="text" value="<?php echo $user_data->country; ?>" disabled></td>
                                                </tr>
                                                <tr>
                                                    <td>Phone Number</td>
                                                    <td><input type="text" value="<?php echo $user_data->number; ?>" disabled></td>
                                                </tr>
                                                <tr>
                                                    <td>Account Balance</td>
                                                    <td><input type="number" value="<?php echo $user_data->account_balance; ?>" name="account_balance" step="0.01"></td>
                                                </tr>
                                                <tr>
                                                    <td>Investment Date</td>
                                                    <td><input type="date" name="investment_date">Current Date:<?php echo date('m/d/Y', $user_data->investment_date) ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Interest Rate</td>
                                                    <td><input type="number" value="<?php echo $user_data->interest_rate; ?>" name="interest_rate"></td>
                                                </tr>
                                                <tr>
                                                    <td>Investment Profits</td>
                                                    <td><input type="number" value="<?php echo $user_data->investment_profits; ?>" name="investment_profits" step="0.01"></td>
                                                </tr>
                                                <tr>
                                                    <td>Investment Plan</td>
                                                    <td><input type="text" value="<?php echo $user_data->investment_plan; ?>" disabled></td>
                                                </tr>
                                                <tr>
                                                    <td>Referral Earnings</td>
                                                    <td><input type="text" value="<?php echo $user_data->ref_earnings; ?>" disabled></td>
                                                </tr>
                                                <tr>
                                                    <td>Notification</td>
                                                    <td><input type="text" name="notification" value="<?php echo $user_data->notification; ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td>ID Verified</td>
                                                    <td><input type="text" name="idverified" value="<?php echo $user_data->idverified; ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td>Reset Password</td>
                                                    <td><input type="password" name="newpass"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="mt-4 pt-3 text-center">
                                        <input type="hidden" value="<?php echo $hashed; ?>" name="token">
                                        <input type="submit" class="btn btn-success btn-lg w-100 btn-round" value="Save Changes">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>

                    <?php

                    if (strlen($user_data->id_front_view ?? "") && strlen($user_data->id_back_view ?? "")) {
                        echo '<img src="uploads/' . $user_data->id_front_view . '"/><br/>';
                        echo '<img src="uploads/' . $user_data->id_back_view . '"/><br/>';
                    }

                    ?>
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
        var Tawk_API = Tawk_API || {},
            Tawk_LoadStart = new Date();
        (function() {
            var s1 = document.createElement("script"),
                s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/5d762bcf77aa790be3331e01/default';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
    <!--End of Tawk.to Script-->
</body>

</html>