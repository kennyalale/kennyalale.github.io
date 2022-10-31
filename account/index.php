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
if (isset($j_data->users->$user)) {

    if ($j_data->users->$user->idverified != 2) {
        header("Location: verify.php");
    }

    if ($j_data->users->$user->admin) {
        $admin_text = '<li>
                            <a href="admin.php" class="waves-effect">
                                <i class="fas fa-user-cog"></i><span> ADMIN Dashboard </span>
                            </a>
                        </li>';
    }
    $email = $j_data->users->$user->email;
    $interest_rate = $j_data->users->$user->interest_rate;
    $investment_date = $j_data->users->$user->investment_date;
    $investment_plan = $j_data->users->$user->investment_plan;
    $account_balance = $j_data->users->$user->account_balance;
    $investment_profits = $j_data->users->$user->investment_profits;

    $seconds_past = time() - $investment_date;
    $minutes_past = $seconds_past / 60;
    $hours_past = $minutes_past / 60;
    $days_past = $hours_past / 24;
    $weeks_past = $days_past / 7;

    if (!isset($j_data->users->$user->refs_earnings)) {
        $j_data->users->$user->refs_earnings = 0;
    }
    $refs_earnings = $j_data->users->$user->refs_earnings;
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
    <title>Fortextrade - User Dashboard</title>

    <link rel="shortcut icon" href="assets/images/favicon.png">


    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/metismenu.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="assets/css/style.css" rel="stylesheet" type="text/css">

</head>

<body>

    <script type="text/javascript">
        alert('Dear <?php echo $name; ?>, update your withdrawal details in edit profile to be able to withdraw funds.')
    </script>

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
                    Dashboard</h2>
            </div>

            <!-- TradingView Widget BEGIN -->
            <div class="tradingview-widget-container">
                <div class="tradingview-widget-container__widget"></div>
                <div class="tradingview-widget-copyright"><a href="https://www.tradingview.com" rel="noopener" target="_blank"><span class="blue-text">Ticker Tape</span></a> by TradingView</div>
                <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-ticker-tape.js" async>
                    {
                        "symbols": [{
                                "title": "S&P 500",
                                "proName": "OANDA:SPX500USD"
                            },
                            {
                                "title": "Nasdaq 100",
                                "proName": "OANDA:NAS100USD"
                            },
                            {
                                "title": "EUR/USD",
                                "proName": "FX_IDC:EURUSD"
                            },
                            {
                                "title": "BTC/USD",
                                "proName": "BITSTAMP:BTCUSD"
                            },
                            {
                                "title": "ETH/USD",
                                "proName": "BITSTAMP:ETHUSD"
                            }
                        ],
                        "colorTheme": "dark",
                        "isTransparent": false,
                        "displayMode": "adaptive",
                        "locale": "en"
                    }
                </script>
            </div>
            <!-- TradingView Widget END -->
            <hr style="border-color:white">


            <!-- Start content -->

            <div class="content">

                <div class="container-fluid">


                    <?php

                    if (strlen($j_data->users->$user->notification) > 0) {
                        echo '<div class="card p-3">' . $j_data->users->$user->notification . '</div>';
                    }

                    ?>

                    <div class="row">

                        <div class="col-sm-6 col-xl-6">
                            <div class="card">
                                <div class="card-heading p-4">
                                    <div class="mini-stat-icon float-right">
                                        <i class="fas fa-dollar-sign bg-primary text-white"></i>
                                    </div>
                                    <div>
                                        <h5 class="font-16">Account Balance</h5>
                                    </div>
                                    <h3 class="mt-4">$ <?php echo $account_balance; ?></h3>

                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-xl-6">
                            <div class="card">
                                <div class="card-heading p-4">
                                    <div class="mini-stat-icon float-right">
                                        <i class="fas fa-money-bill-alt bg-danger  text-white"></i>
                                    </div>
                                    <div>
                                        <h5 class="font-16">Investment Profits</h5>
                                    </div>
                                    <h3 class="mt-4">$<?php

                                                        $profit = (($interest_rate / 100) * $account_balance) * $days_past;

                                                        echo number_format($profit, 2);

                                                        ?></h3>

                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-xl-6">
                            <div class="card">
                                <div class="card-heading p-4">
                                    <div class="mini-stat-icon float-right">
                                        <i class="fas fa-coins bg-warning  text-white"></i>
                                    </div>
                                    <div>
                                        <h5 class="font-16">Investment Plan</h5>
                                    </div>
                                    <h3 class="mt-4"><?php echo $investment_plan; ?></h3>

                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-xl-6">
                            <div class="card">
                                <div class="card-heading p-4">
                                    <div class="mini-stat-icon float-right">
                                        <i class="fas fa-donate bg-success  text-white"></i>
                                    </div>
                                    <div>
                                        <h5 class="font-16">Referral Earnings</h5>
                                    </div>
                                    <h3 class="mt-4">$<?php echo $refs_earnings; ?></h3>

                                </div>
                            </div>
                        </div>



                    </div>
                </div>
            </div>
            <hr style="border-color:white">



            <div class="content">

                <div class="container-fluid">



                    <div class="row">
                        <div class="col-xl-4">
                            <!-- TradingView Widget BEGIN -->
                            <div class="tradingview-widget-container">
                                <div class="tradingview-widget-container__widget"></div>
                                <div class="tradingview-widget-copyright"><a href="https://www.tradingview.com/symbols/FX-EURUSD/" rel="noopener" target="_blank"><span class="blue-text">EURUSD Rates</span></a> by TradingView</div>
                                <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-single-quote.js" async>
                                    {
                                        "symbol": "FX:EURUSD",
                                        "width": "350",
                                        "colorTheme": "dark",
                                        "isTransparent": false,
                                        "locale": "en"
                                    }
                                </script>
                            </div>
                            <!-- TradingView Widget END -->



                        </div>
                        <!-- end col -->

                        <div class="col-xl-4">
                            <!-- TradingView Widget BEGIN -->
                            <div class="tradingview-widget-container">
                                <div class="tradingview-widget-container__widget"></div>
                                <div class="tradingview-widget-copyright"><a href="https://www.tradingview.com/symbols/BITSTAMP-BTCUSD/" rel="noopener" target="_blank"><span class="blue-text">BTCUSD Rates</span></a> by TradingView</div>
                                <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-single-quote.js" async>
                                    {
                                        "symbol": "BITSTAMP:BTCUSD",
                                        "width": "350",
                                        "colorTheme": "dark",
                                        "isTransparent": false,
                                        "locale": "en"
                                    }
                                </script>
                            </div>
                            <!-- TradingView Widget END -->
                        </div>
                        <!-- end col -->
                        <div class="col-xl-4">
                            <!-- TradingView Widget BEGIN -->
                            <div class="tradingview-widget-container">
                                <div class="tradingview-widget-container__widget"></div>
                                <div class="tradingview-widget-copyright"><a href="https://www.tradingview.com/symbols/BINANCE-ETHBTC/" rel="noopener" target="_blank"><span class="blue-text">ETHBTC Rates</span></a> by TradingView</div>
                                <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-single-quote.js" async>
                                    {
                                        "symbol": "BINANCE:ETHBTC",
                                        "width": "350",
                                        "colorTheme": "dark",
                                        "isTransparent": false,
                                        "locale": "en"
                                    }
                                </script>
                            </div>
                            <!-- TradingView Widget END -->

                        </div>
                        <!-- end col -->
                    </div>


                    <!-- START ROW -->
                    <div class="row">
                        <div class="col-xl-12">
                            <br>
                            <!-- TradingView Widget BEGIN -->
                            <div class="tradingview-widget-container">
                                <div id="tradingview_8f093"></div>
                                <div class="tradingview-widget-copyright"><a href="https://www.tradingview.com/symbols/FX-EURUSD/" rel="noopener" target="_blank"><span class="blue-text">EURUSD Chart</span></a> by TradingView</div>
                                <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
                                <script type="text/javascript">
                                    new TradingView.widget({
                                        "width": "100%",
                                        "height": 610,
                                        "symbol": "FX:EURUSD",
                                        "interval": "D",
                                        "timezone": "Etc/UTC",
                                        "theme": "Dark",
                                        "style": "1",
                                        "locale": "en",
                                        "toolbar_bg": "#f1f3f6",
                                        "enable_publishing": false,
                                        "allow_symbol_change": true,
                                        "container_id": "tradingview_8f093"
                                    });
                                </script>
                            </div>
                            <!-- TradingView Widget END -->
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <br>
                            <!-- TradingView Widget BEGIN -->
                            <div class="tradingview-widget-container">
                                <div class="tradingview-widget-container__widget"></div>
                                <div class="tradingview-widget-copyright"><a href="https://www.tradingview.com/markets/cryptocurrencies/prices-all/" rel="noopener" target="_blank"><span class="blue-text">Cryptocurrency Markets</span></a> by TradingView</div>
                                <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-screener.js" async>
                                    {
                                        "width": "100%",
                                        "height": 490,
                                        "defaultColumn": "overview",
                                        "screener_type": "crypto_mkt",
                                        "displayCurrency": "USD",
                                        "colorTheme": "dark",
                                        "locale": "en"
                                    }
                                </script>
                            </div>
                            <!-- TradingView Widget END -->
                        </div>

                    </div>

                    <!-- END ROW -->

                </div>
                <!-- container-fluid -->

            </div>
            <!-- content -->

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
        (function() {
            var options = {
                whatsapp: "+1 (619) 777-7497", // WhatsApp number
                call_to_action: "Message us", // Call to action
                position: "left", // Position may be 'right' or 'left'
            };
            var proto = document.location.protocol,
                host = "getbutton.io",
                url = proto + "//static." + host;
            var s = document.createElement('script');
            s.type = 'text/javascript';
            s.async = true;
            s.src = url + '/widget-send-button/js/init.js';
            s.onload = function() {
                WhWidgetSendButton.init(host, proto, options);
            };
            var x = document.getElementsByTagName('script')[0];
            x.parentNode.insertBefore(s, x);
        })();
    </script>
    <!-- /GetButton.io widget -->

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