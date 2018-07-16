<?php
	ob_start();
	session_start();
	require_once $_SERVER['DOCUMENT_ROOT'].'/util/DbConnectionUtil.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/util/ConstantUtil.php';
?>
<?php
function sw_get_current_weekday() {
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $weekday = date("l");
    $weekday = strtolower($weekday);
    switch($weekday) {
        case 'monday':
            $weekday = 'Thứ hai';
            break;
        case 'tuesday':
            $weekday = 'Thứ ba';
            break;
        case 'wednesday':
            $weekday = 'Thứ tư';
            break;
        case 'thursday':
            $weekday = 'Thứ năm';
            break;
        case 'friday':
            $weekday = 'Thứ sáu';
            break;
        case 'saturday':
            $weekday = 'Thứ bảy';
            break;
        default:
            $weekday = 'Chủ nhật';
            break;
    }
    return $weekday.', '.date('d/m/Y');
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TechNews - HTML and CSS Template</title>

    <!-- favicon -->
    <link href="/template/public/img/favicon.png" rel=icon>

    <!-- web-fonts -->
    <link href='https://fonts.googleapis.com/css?family=Roboto:100,300,400,700,500' rel='stylesheet' type='text/css'>

    <!-- Bootstrap -->
    <link href="/template/public/css/bootstrap.min.css" rel="stylesheet">

    <!-- font-awesome -->
    <link href="/template/public/fonts/font-awesome/font-awesome.min.css" rel="stylesheet">
    <!-- Mobile Menu Style -->
    <link href="/template/public/css/mobile-menu.css" rel="stylesheet">

    <!-- Owl carousel -->
    <link href="/template/public/css/owl.carousel.css" rel="stylesheet">
    <link href="/template/public/css/owl.theme.default.min.css" rel="stylesheet">
    <!-- Theme Style -->
    <link href="/template/public/css/style.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body id="page-top" data-spy="scroll" data-target=".navbar">
    <div id="main-wrapper">
        <!-- Page Preloader -->
        <div id="preloader">
            <div id="status">
                <div class="status-mes"></div>
            </div>
        </div>
        <!-- preloader -->

        <div class="uc-mobile-menu-pusher">
            <div class="content-wrapper">
                <section id="header_section_wrapper" class="header_section_wrapper">
                    <div class="container">
                        <div class="header-section">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="left_section">
                                        <span class="date">
                                                <?php echo sw_get_current_weekday(); ?>
                                        </span>
                                        <div class="social">
                                            <a class="icons-sm fb-ic"><i class="fa fa-facebook"></i></a>
                                            <!--Twitter-->
                                            <a class="icons-sm tw-ic"><i class="fa fa-twitter"></i></a>
                                            <!--Google +-->
                                            <a class="icons-sm inst-ic"><i class="fa fa-instagram"> </i></a>
                                            <!--Linkedin-->
                                            <a class="icons-sm tmb-ic"><i class="fa fa-tumblr"> </i></a>
                                            <!--Pinterest-->
                                            <a class="icons-sm rss-ic"><i class="fa fa-rss"> </i></a>
                                        </div>
                                        <!-- Top Social Section -->
                                    </div>
                                    <!-- Left Header Section -->
                                </div>
                                <div class="col-md-4">
                                    <div class="logo">
                                        <a href="index.php"><img src="/template/public/img/logo.png" alt="Tech NewsLogo"></a>
                                    </div>
                                    <!-- Logo Section -->
                                </div>
                                <div class="col-md-4">
                                    <div class="right_section">
                                        <ul class="nav navbar-nav">
                                            <li><a href="#">Login</a></li>
                                            <li><a href="#">Register</a></li>
                                            <li class="dropdown lang">
                                                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">En <i
                                        class="fa fa-angle-down"></i></button>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                    <li><a href="#">Bn</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                        <!-- Language Section -->

                                        <ul class="nav-cta hidden-xs">
                                            <li class="dropdown"><a href="#" data-toggle="dropdown" class="dropdown-toggle"><i
                                    class="fa fa-search"></i></a>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <div class="head-search">
                                                            <form role="form">
                                                                <!-- Input Group -->
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" placeholder="Type Something"> <span class="input-group-btn">
                                                                            <button type="submit"
                                                                                    class="btn btn-primary">Search
                                                                            </button>
                                                                        </span></div>
                                                            </form>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                        <!-- Search Section -->
                                    </div>
                                    <!-- Right Header Section -->
                                </div>
                            </div>
                        </div>
                        <!-- Header Section -->
                        <?php
							require_once $_SERVER['DOCUMENT_ROOT']."/template/public/inc/navigation.php";
						?>
                        <!-- .navigation-section -->
                    </div>
                    <!-- .container -->
                </section>
                <!-- header_section_wrapper -->