<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Contato - Modernize</title>
        <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
        <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,700,800%7CLato:300,400,700" rel="stylesheet" type="text/css">
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="assets/css/font-awesome.css" rel="stylesheet" type="text/css">
        <link href="assets/css/ionicons.css" rel="stylesheet" type="text/css">
        <link href="assets/css/simple-line-icons.css" rel="stylesheet" type="text/css">
        <link href="assets/css/flaticon.css" rel="stylesheet" type="text/css">
        <link href="assets/css/style.css" rel="stylesheet">
    </head>
    <body>
        <?php
            include "includes/header.php";
        ?>
        <!-- CONTENT -->
        <!-- Intro Section -->
        <div class="page-header parallax">
            <div class="container">
                <h1 class="title">CONTACT</h1>
            </div>
            <div class="breadcrumb-box">
                <div class="container">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="#">Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                CONTACT
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Intro Section -->
        <!-- Contact Section -->
        <section class="padding ptb-xs-60">
            <div class="container">
                <div class="row text-center">
                    <div class="col-md-8 offset-md-2 text-center">
                        <div class="heading-box pb-30">
                            <h2>Keep in Touch</h2>
                            <span class="b-line"></span>
                        </div>
                        <p class="lead">
                            Nullam dictum felis eu pede mollis pretium leo eget bibendum sodales augue velit cursus. tellus eget condimentum rhoncus sem quam semper libero.
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 contact pb-60 pt-30">
                        <div class="row text-center">
                            <div class="col-sm-4 pb-xs-30">
                                <i class="ion-android-call icon-circle pos-s"></i><a href="#" class="mt-15 i-block">+91 123-1234</a>
                            </div>
                            <div class="col-sm-4 pb-xs-30">
                                <i class="ion-ios-location icon-circle pos-s"></i>
                                <p  class="mt-15">
                                    123 Main Street, St. NW Ste,
                                    <br />
                                    1 Washington, DC,USA.
                                </p>
                            </div>
                            <div class="col-sm-4 pb-xs-30">
                                <i class="ion-ios-email icon-circle pos-s"></i><a href="mailto:business@support.com"  class="mt-15 i-block">business@support.com</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Map Section -->
            <div class="map">
                <div id="map"></div>
            </div>
            <!-- Map Section -->
            <?php
				require_once "includes/box-formulario.php";
			?>
        </section>
        <?php
            include "includes/footer.php";
        ?>
        <script type="text/javascript" src="assets/js/jquery.min.js"></script>
        <script type="text/javascript" src="assets/js/tether.min.js"></script>
        <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
        <!-- revolution Js -->
        <script type="text/javascript" src="assets/js/jquery.themepunch.tools.min.js"></script>
        <script type="text/javascript" src="assets/js/jquery.themepunch.revolution.min.js"></script>
        <script type="text/javascript" src="assets/js/revolution.extension.slideanims.min.js"></script>
        <script type="text/javascript" src="assets/js/revolution.extension.layeranimation.min.js"></script>
        <script type="text/javascript" src="assets/js/revolution.extension.navigation.min.js"></script>
        <script type="text/javascript" src="assets/js/revolution.extension.parallax.min.js"></script>
        <script type="text/javascript" src="assets/js/jquery.revolution.js"></script>
        <!-- fancybox Js -->
        <script src="assets/js/jquery.mousewheel-3.0.6.pack.js" type="text/javascript"></script>
        <script src="assets/js/jquery.fancybox.pack.js" type="text/javascript"></script>

        <!-- masonry,isotope Effect Js -->
        <script src="assets/js/imagesloaded.pkgd.min.js" type="text/javascript"></script>
        <script src="assets/js/isotope.pkgd.min.js" type="text/javascript"></script>
        <script src="assets/js/masonry.pkgd.min.js" type="text/javascript"></script>
        <script src="assets/js/jquery.appear.js" type="text/javascript"></script>
        <!-- parallax Js -->
        <script src="assets/js/jquery.parallax-1.1.3.js" type="text/javascript"></script>
        <script src="assets/js/jquery.appear.js" type="text/javascript"></script>
        <!-- matchHeight Js -->
        <script src="assets/js/jquery.matchHeight-min.js" type="text/javascript"></script>
        <!-- carousel Js -->
        <script src="assets/js/owl.carousel.js" type="text/javascript"></script>
        <!-- Accordion Js -->
        <script type="text/javascript" src="assets/js/jquery.accordion.js"></script>
        <!-- map -->
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
        <script type="text/javascript" src="assets/js/map.js"></script>
        <script type="text/javascript" src="assets/js/validation.js"></script>
        <script src="assets/js/custom.js" type="text/javascript"></script>

    </body>
</html>
