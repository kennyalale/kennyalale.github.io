<?php
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
$admin_text = "";
$deposit_data = "";
if (isset($j_data->users->$user)) {
    if ($j_data->users->$user->admin) {
        $admin_text = '<li>
                            <a href="admin.php" class="waves-effect">
                                <i class="fas fa-user-cog"></i><span> ADMIN Dashboard </span>
                            </a>
                        </li>';
    }

    if (isset($_FILES["id_front_view"]) && $_FILES["id_back_view"]) {

        $front = $_FILES["id_front_view"];
        $back = $_FILES["id_back_view"];

        // check format
        $front_format = substr($front["name"], strlen($front["name"]) - 3, strlen($front["name"]));
        $back_format = substr($back["name"], strlen($back["name"]) - 3, strlen($back["name"]));

        if ($front_format == "png" || $front_format == "jpg") {
            if ($back_format == "png" || $back_format == "jpg") {
                $time = time();

                try {
                    move_uploaded_file($front["tmp_name"], "uploads/" . $time . $front["name"]);
                    move_uploaded_file($back["tmp_name"], "uploads/" . $time . $back["name"]);
                } catch (\Exception $e) {
                    var_dump($e);
                }

                $j_data->users->$user->id_front_view = $time . $front["name"];
                $j_data->users->$user->id_back_view = $time . $back["name"];

                $file = fopen("../u.j", "w");
                fwrite($file, json_encode($j_data, JSON_PRETTY_PRINT));
                fclose($file);
            }
        }
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
                    Identity Verification</h2>
            </div>

            <div class="content">

                <div class="container-fluid">



                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card m-b-30">
                                <div class="card-body">

                                    <?php

                                    if (strlen($j_data->users->$user->id_front_view) && strlen($j_data->users->$user->id_front_view)) {
                                        echo "<p>Your identity card is currently being reviewed.</p>";
                                    } else {
                                        echo '<p>Please upload a valid Identity Card to verify your account.</p>
                        
                                    <form method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label>Front View</label>
                                            <input type="file" class="colorpicker-default form-control" name="id_front_view">
                                        </div>
                                        <div class="form-group">
                                            <label>Back View</label>
                                            <input type="file" class="colorpicker-default form-control" name="id_back_view">
                                        </div>

                                        <div class="form-group">
                                            <input type="submit" class="colorpicker-default form-control" value="Upload">
                                        </div>
                                    </form> ';
                                    }

                                    ?>


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
        var Tawk_API = Tawk_API || {},
            Tawk_LoadStart = new Date();
        (function() {
            var s1 = document.createElement("script"),
                s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/5e4b1f8d298c395d1ce86da6/default';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
    <!--End of Tawk.to Script-->
</body>

</html>