<style>
    .wrapper {
        position: relative;
        width: 100%;
        overflow: hidden;
        background:#fff;
    }
    .boxed {
        margin-left: auto;
        margin-right: auto;
        max-width: 1170px;
    }
    #header, .header {
         /*background: #314555; */
    }
    #header.header-1 {
		position: fixed;
        background: rgba(29, 29, 29, 0.58); 
        top: 0;
        z-index: 9;
        width: 100%;
    }
    @media (max-width: 767px) {
        #header.header-1{
            background:#1d1d1d;
        }
        #header.header-1{
            position: static;
        }
    }
    .logo, .nav-bg {
        position: relative;
        z-index: 9;
    }
    .logo a {
        display: inline-block;
        padding: 26px 0;
    }
    .header-1 .logo a {
        display: inline-block;
        padding: 15px 0 7px;
    }
    @media (min-width: 992px) {
        .header-1 .logo a {
            padding: 12px 0 0;
        }
    }
    .nav-wrap{
        background: transparent;
        transition: all 0.3s ease-in-out;
        z-index: 999;
    }
    .stricky{
        background: #1d1d1d;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
    }
    .menu {
        border:none;
        border-bottom: 4px solid #966a45;
        border-top: 4px solid #966a45;
        height: 29px;
        position: absolute;
        right: 29px;
        top: 40px;
        width: 44px;
        background: none;
        z-index: 10;
    }
    .menu:after {
        position: absolute;
        top: 9px;
        right: 0;
        content: '';
        width: 100%;
        height: 4px;
        background:#966a45;
    }
    .header ul {
        float: right;
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .header ul li {
        float: left;
        position: relative;
    }
    .navigation ul li a {
        font-size: 12px;
        font-family: 'Raleway', sans-serif;
        font-weight: 600;
        text-decoration: none;
        text-transform: uppercase;
    }
    .navigation > ul > li > a {
        display: block;
        padding: 38px 16px;
        color: #fff;
        transition: all 0.25s ease 0s;
        -webkit-transition: all 0.25s ease 0s;
        -moz-transition: all 0.25s ease 0s;
        -o-transition: all 0.25s ease 0s;
        outline: none;
    }
    .navigation > ul > li:last-child a {
        padding-right: 0;
    }
    .header_tran .navigation .sub-nav {
        left: 0;
        border-top: 0;
        position: absolute;
        top: 175%;
        width: 200px;
        z-index: 3;
        background-clip: padding-box;
        padding: 0;
        transition: top 0.3s ease 0s, visibility 0.2s ease 0.2s, opacity 0.2s ease 0.1s;
        -webkit-transition: top 0.3s ease 0s, visibility 0.2s ease 0.2s, opacity 0.2s ease 0.1s;
        -moz-transition: top 0.3s ease 0s, visibility 0.2s ease 0.2s, opacity 0.2s ease 0.1s;
        -ms-transition: top 0.3s ease 0s, visibility 0.2s ease 0.2s, opacity 0.2s ease 0.1s;
        -o-transition: top 0.3s ease 0s, visibility 0.2s ease 0.2s, opacity 0.2s ease 0.1s;
        opacity: 0;
        visibility: hidden;
        background-color: #966a45;
        -webkit-backface-visibility:hidden;
    }
    .navigation .sub-nav li {
        display: block;
        float: none;
        margin: 0;
        border-bottom: 1px solid #ffffff;
        padding-bottom: 0;
        position: relative;
    }
    .navigation .sub-nav li a:hover{
        color: #fff !important;
    }
    .navigation li:hover .sub-nav {
        opacity: 1;
        top: 100%;
        transition: top 0.3s ease 0s;
        -webkit-transition: top 0.3s ease 0s;
        visibility: visible;
    }
    .navigation li.sub-menu .sub-nav {
        border: none;
        opacity: 0;
        top: 0;
        visibility: visible;
        left: auto;
        right: 110%;
        visibility: hidden;
        transition: all 0.3s ease 0s;
        -webkit-transition: all 0.3s ease 0s;
    }

    .navigation li.sub-menu:hover .sub-nav {
        visibility: visible;
        opacity: 1;
        right: 100%;
        transition: all 0.3s ease 0s;
        -webkit-transition: all 0.3s ease 0s;
    }

    .navigation .sub-nav li:last-child {
        border-bottom: 0;
    }
    .navigation .sub-nav li a {
        padding: 8px 20px;
        display: block;
        color: #fff;
    }
    /*Top bar*/
    .header-1 .top-bar-section{
        /* background:rgba(22, 22, 22, 0.58)  !important; */
    }

    .top-contact {
        float: left;
        text-align: center;
    }
    .top-social-icon {
        float: right;
    }
    .top-social-icon {
        text-align: center;
    }
    .header_tran .top-bar-section.top-bar-bg-color a {
        color: #fff;
    }
    .top-contact a i {
        padding-left: 5px;
        padding-right: 5px;
    }
    .header_tran .top_loction ul li:first-child{
        margin: 0px;
    }
    .header_tran .top_loction ul li{
        margin:0px 0px 0px 25px;
    }
    .header_tran .top_loction ul li a i{
        margin-right: 5px;
        color: #966a45;
    }
    @media only screen and (min-width: 992px) and (max-width: 1199px) {
        .header .top_loction ul li {
            margin: 0px 0px 0px 10px;
        }
    }
    .header .top_loction{
        margin-top: 12px;
    }
    .top-social-icon {
        float: right;
    }
    .top-social-icon {
        text-align: center;
    }
    .top-social-icon ul {
        margin: 0;
        padding: 0;
    }
    .top-social-icon li {
        margin-left: 10px;
    }

    .header-1 .top-contact  .welcome-text{
        color:#2c3740;
    }
    .welcome-text i{
        margin-right: 6px;
    }
    .top-bar-section a i {
        font-size: 16px;
    }
    .top-social-icon a.btn {
        padding: 9px 20px;
    }
    .top-social-icon a.btn:hover {
        color: #1fcab8;
    }
    .link-hover-black > a:last-child {
        margin-left: 10px;
    }
    .header_tran .top-bar-section .top-social-icon .icons-hover-black a{
        display: inline-block;
        font-size: 18px;
        line-height: 49px;
        /* border-left: 1px solid #073D51; */
        padding: 0 12px;
        color: #966a45;
        /* border-color: #212121; */
        transition: all .3s ease;
    }
    .header_tran .top-bar-section .top-social-icon .icons-hover-black a:hover, .header_tran .top_loction ul li a:hover{
        color: #966a45;
    }
    /*  Header style 2   ||-----------*/
    .header-2 .primary-header {
        background: #fff;
        box-shadow: 0 0 5px rgba(0,0,0,0.2);
    }
    .header-2 .navigation > ul {
        float: left;
    }
    .header-2 .navigation > ul > li {
        border-left: 1px solid #dedddd;
    }

    @media only screen and (min-width: 768px) {
        .header-2 .navigation > ul > li:hover {
            background: #2a3b48;
        }
    }
    .header-2 .navigation > ul > li > a {
        color: #314555;
        padding: 18px 32px;
    }
    .header-2 .navigation li:hover>a{
        color:#fff;
    }
    .header-2 .navigation li:hover .sub-nav {
        top: 67%;
    }
    .call-us ul {
        list-style-type: none;
        line-height: 1.3;
        padding-top: 22px;
    }
    .call-us ul li {
        display: inline-block;
        font-weight: bold;
        padding: 0 1px;
        vertical-align: top;
        position: relative;
        padding-left: 33px;
    }
    .call-us ul li:first-child:after {
        content: "";
        background: #d5dce4;
        display: block;
        position: absolute;
        right: -15px;
        top: -5px;
        width: 1px;
        height: 67px;
    }

    .call-box {
        display: inline-block;
        font-weight: 600;
        font-size: 15px;
        color: rgba(255, 255, 255, 0.58);
        text-transform: uppercase;
    }
    .call-box > span {
        display: block;
    }
    .call-us .phone-nomber i {
        font-size: 23px;

        margin-right: 12px;
        vertical-align: top;
        margin-top: 0;
        display: inline-block;
        color: rgba(255, 255, 255, 0.58);
    }
    .call-us i.ion-ios-email-outline{
        margin-top: -10px;
    }
    .call-us ul li .position {
        float: left;
        display: inline;
        margin-left: 6px;
        margin-right: 6px;
        padding-top: 5px;
        color: rgba(255, 255, 255, 0.58);
    }
    .call-us ul li .icon-fa {
        font-size: 50px;
        font-weight: 400;
        font-family: oswald;
        float: left;
        display: inline;
        margin-left: 3px;
        margin-right: 3px;
        color: rgba(255, 255, 255, 0.58);
        line-height: 47px;
    }
    .call-us ul li .time_block {
        color: #fff;
        font-size: 16px;
        font-weight: 500;
        padding-bottom: 2px;
    }
    .call-us ul li .date-block {
        color: #fff;
        font-weight: 600;
        font-size: 18px;
        font-family: open sans;
    }
    .call-us ul li a {
        font-size: 22px;
        color: #fff;
        line-height: 1;
        transition: 1s all ease;
        -webkit-transition: 1s all ease;
    }
    .call-us ul li.phone-nomber a{
        font-size: 33px;
    }

    .call-us ul li:first-child {

        padding-left: 49px;
    }
    .mailing-icon{
        margin-right: 7px;
    }
    .icons-hover-black .mailing-icon i{
        background: none;
        width: 17px;
    }
    .header-2 .top-bar-section {
        background: #F7F7F7;
        border-bottom: 1px solid #364f63;
        padding-top: 4px;
        padding-bottom: 4px;
    }
    .header-2 .top-bar-section.top-bar-bg-color a, .header-2 .top-social-icon li {
        color: #909090;
    }
    .header-2 .top-bar-section.top-bar-bg-color a:hover, .call-us ul li a:hover {
        color: #1fcab8;
    }
    .col-right {
        text-align: right;
    }
    .col-right .opening {
        float: right;
        text-align: left;
        padding: 25px 0 0 33px
    }
    .header .col-right ul, .header .col-right ul li {
        float: none;
        position: relative;
        color: #2c3740 !important;
        font-weight: bold;
    }
    .header .col-right ul li span, .header .col-right ul li * {
        color: #2c3740 !important;
    }
    .col-right .call-us {
        display: inline-block;
        text-align: right;
        float: none;
    }
    .col-right .opening ul:after {
        content: "";
        background: #d5dce4;
        display: block;
        position: absolute;
        left: -15px;
        top: -9px;
        width: 1px;
        height: 67px;
    }
    .header-style {
        box-shadow: 0 0px 1px 1px rgba(0,0,0,0.1);
    }
    .header-style, .header-1  {
        box-shadow: 0px -1px 0px 0px rgba(255, 255, 255, 0.47);

    }

    .header-1 .reletiv_box {
        position: relative;
    }

    .header-1 .reletiv_box:after {
        content: '';
        position: absolute;
        top: 0;
        left: 50%;
        width: 0;
        height: 0;
        border-right-color: transparent;
        border-top-color: transparent;
        border-bottom-color:rgba(232, 162, 13, 0.58);
        border-left-color:rgba(232, 162, 13, 0.58);
        border-style: solid;
        border-top-width: 46px;
        border-right-width: 34px;
        border-bottom-width: 40px;
        border-left-width: 40px;
        margin-left: -338px;
        display: none;
    }
    .header-1 .reletiv_box:before {
        content: '';
        width: 50%;
        height: 86px;
        background:rgba(232, 162, 13, 0.58);
        position: absolute;
        top: 0;
        left: -338px;
        display: none;
    }

    .header-1 .stricky .reletiv_box:before{
        background: #E8A20D;
    }
    .header-1 .stricky .reletiv_box:after{
        border-bottom-color:#E8A20D;
        border-left-color:#E8A20D;
    }

    .header-1 .navigation > ul > li > a {
        padding: 30px 16px;
    }

    .fix-header #header {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 999;
    }
    @media (min-width: 768px) and (max-width: 991px) {
        .header-1 .top-bar-section{
            display: none;
        }	
        .header-1 .reletiv_box:before{
            width: 67.2%;
        }
        .header-1 .reletiv_box:after{
            left: 67.2%;
        }
    }
    @media only screen and (min-width: 767px) {
        #header.fix .nav-wrap, #header.fix .primary-header, .header-style.fix-header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 999999;
        }
        #header.fix .nav-wrap, .header-style.fix-header {
            background: #fff;
        }
        .p-top {
            padding-top: 157px;
        }

    }
    .boxed #header.fix .nav-wrap, .boxed #header.fix .primary-header, .boxed .header-style.fix-header {
        max-width: 1170px;
        left: 0;
        right: 0;
        margin-left: auto;
        margin-right: auto;
    }
    @media (min-width: 992px) and (max-width: 1199px) {
        .header-2 .navigation > ul > li > a {
            padding-left: 28px;
            padding-right: 28px;
        }
        .header.header-2 .navigation > ul > li > a {
            padding-left: 28px;
            padding-right: 25px;
        }
        .header-1 .reletiv_box:before{
            width: 59.1%;
        }
        .header-1 .reletiv_box:after{
            left:59.1%;
        }
        .header-1 .stricky .reletiv_box:after{
            left: 59%;
        }
    }

    @media (min-width: 768px) and (max-width: 991px) {
        .navigation {
            margin-left: 0;
        }
        .navigation > ul > li > a {
            padding: 38px 13px;
        }
        .navigation .sub-nav {
            left: -27px;
        }
        .header-1 .nav-wrap:after {
            margin-left: -167px;
        }
        .header-1 .nav-wrap:before {
            left: -166px;
        }
        .header-1 .navigation li:hover .sub-nav {
            top: 77%;
        }
        .call-us ul li a{
            font-size: 16px;
        }
        .header-2 .navigation > ul > li > a {
            padding: 18px 23px;
        }
        .header-1 .navigation > ul > li > a {
            padding: 30px 10px;
        }
        .header.header-2 .navigation > ul > li > a {
            padding: 18px 10px;
        }
        .navigation .btn-text{
            padding: 0 10px;
            min-width:160px;
        }
        .top-contact  .welcome-text{
            font-size: 11px;
        }	

    }

    @media (max-width: 767px) {
        .container {
            margin: 0 auto;
            max-width: 480px;
            width: 100%;
        }
        .header_tran .navigation .sub-nav{
            width: 100%;
            position: static;
            background: #4d8a00;
        }

        .header_tran .navigation .sub-nav li{
            border-color:#966a45;
        }

        .header ul, .header ul li {
            float: none !important;
        }
        .top-social-icon {
            text-align: center;
        }
        .top-social-icon ul li {
            display: inline-block;
            margin: 0 4px !important;
        }
        .top-social-icon ul li:last-child, .top-social-icon ul li:last-child a {
            width: 100%;
            margin: 0;
        }
        .story-content, .video-frame {
            width: 100%;
            margin-left: 0;
            margin-right: 0;
            float: none !important;
        }
        .logo a {
            padding: 29px 0px !important;
        }
        .header-1 .logo a {
            padding: 26px 0 20px !important;
        }
        .navigation {
            display: none;
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            z-index: 9;
            background:#966a45;
        }
        .header-1 .navigation {
            top: 1px;
        }
        .navigation ul li {
            border-bottom: 1px solid #fff;
        }
        .header-2 .navigation > ul > li {
            border-left: none;
        }
        .navigation > ul > li > a, .header-2 .navigation > ul > li > a, .navigation > ul > li:last-child a, .header-1 .navigation > ul > li > a {
            padding: 10px 15px;
            color: #fff;
        }
        .header-2 .primary-header {
            border-bottom: 1px solid #fff;
            background: none;
        }
        .navigation .sub-nav, .navigation li.sub-menu .sub-nav, .navigation li.sub-menu:hover .sub-nav {
            position: static;
            opacity: 1;
            visibility: visible;
            width: 100%;
            border-top: none;
            transition: inherit;
            -webkit-transition: inherit;
            padding: 0;
        }
        .navigation ul li i {
            color: #fff;
            font-size: 25px;
            position: absolute;
            right: 15px;
            top: 9px;
            cursor: pointer;
            pointer-events: none;
        }
        .navigation ul li ul {
            display: none;
        }
        .navigation .on > .ion-ios-plus-empty:before {
            content: '\f462';
            font-family: "Ionicons";
        }
        .nf-col-padding {
            padding-left: 15px;
            padding-right: 15px;
        }

        .footer h5:after {
            margin-bottom: 18px;
        }
        .footer-info .col-xs-12 {
            min-height: 0;
        }

        .call-us ul li a {
            font-size: 24px;
        }
        .col-right .opening ul::after, .col-right {
            display: none;
        }

        .header-style .logo {
            padding-bottom: 56px;
        }
        .header-style .navigation {
            top: 163px;
        }
        .header-2 .navigation > ul, .top-social-icon {
            float: none !important;
            ;
        }
        .header-2 .top-social-icon ul li:last-child, .header-2 .top-social-icon ul li:last-child a {
            width: auto;
        }
        .header-2 .top-social-icon {
            padding-bottom: 0;
        }
        .header-2 .appointment-button {
            display: block;
            margin: 10px auto;
            width: 200px;
        }
        .header-2 .navigation {
            top: 3px;
        }
        .header-2.header-style .navigation {
            top: 148px;
        }
        .header-1 .nav-wrap:before, .header-1 .nav-wrap:after {
            display: none;
        }
        .header-1 .top-bar-section{
            display: none;
        }	
    }
</style>
<div id="preloader">
    <div class="sk-circle">
        <div class="sk-circle1 sk-child"></div>
        <div class="sk-circle2 sk-child"></div>
        <div class="sk-circle3 sk-child"></div>
        <div class="sk-circle4 sk-child"></div>
        <div class="sk-circle5 sk-child"></div>
        <div class="sk-circle6 sk-child"></div>
        <div class="sk-circle7 sk-child"></div>
        <div class="sk-circle8 sk-child"></div>
        <div class="sk-circle9 sk-child"></div>
        <div class="sk-circle10 sk-child"></div>
        <div class="sk-circle11 sk-child"></div>
        <div class="sk-circle12 sk-child"></div>
    </div>
</div>
<!--loader-->
<!-- HEADER -->
<header id="header" class="header header-1 header_tran">
    <div id="top-bar" class="top-bar-section top-bar-bg-color">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="top_loction pull-left">
                        <ul>
                            <li><a href="#!"><i class="fa fa-map-marker"></i> Rua Dr. Roberto Barrozo, 1588 Bom Retiro Curitiba</a></li>
                            <li><a href="mailto:Support@Domain.Com"><i class="fa fa-envelope"></i> falecom@lojadopaisagista.com</a></li>
                            <li><a href="tel:1234567890"><i class="fa fa-phone"></i> (41) 3022 1925</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="top-social-icon icons-hover-black">
                        <div class="icons-hover-black">
                            <a href="javascript:avoid(0);"> <i class="fa fa-facebook"></i> </a>
                            <a href="javascript:avoid(0);"> <i class="fa fa-twitter"></i> </a>
                            <a href="javascript:avoid(0);"> <i class="fa fa-youtube"></i> </a>
                            <a href="javascript:avoid(0);"> <i class="fa fa-dribbble"></i> </a>
                            <a href="javascript:avoid(0);"> <i class="fa fa-linkedin"></i> </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="nav-wrap">
        <div class="reletiv_box">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <div class="logo">
                            <a href="index.php"><img src="assets/images/logo2.png" alt=""></a>
                        </div>
                        <!-- Phone Menu button -->
                        <button id="menu" class="menu hidden-md-up"></button>
                    </div>
                    <div class="col-md-9 nav-bg">
                        <nav class="navigation">
                            <ul>
                                <li><a href="index.php">PÁGINA INICIAL</a><i class="ion-ios-plus-empty hidden-md-up"></i></li>
                                <li><a href="sobre.php">QUEM SOMOS</a></li>
                                <li><a href="vitrine-servicos.php">PERSIANAS</a><i class="ion-ios-plus-empty hidden-md-up"></i>
                                    <ul class="sub-nav">
                                        <li><a href="servico.php">Persiana Horizontal</a></li>
                                        <li><a href="servico.php">Persiana Vertical</a></li>
                                        <li><a href="servico.php">Persiana Motorizada</a></li>
                                        <li><a href="servico.php">Persiana Rolo</a></li>
                                        <li><a href="servico.php">Persiana Romana</a></li>
                                        <li><a href="servico.php">Persiana de Madeira</a></li>
                                    </ul>
                                </li>
                                <li><a href="vitrine-servicos.php">CORTINAS</a><i class="ion-ios-plus-empty hidden-md-up"></i>
                                    <ul class="sub-nav">
                                        <li><a href="servico.php">Cortina Rolo</a></li>
                                        <li><a href="servico.php">Cortina Plissada</a></li>
                                        <li><a href="servico.php">Cortina Romana</a></li>
                                        <li><a href="servico.php">Cortina de Teto</a></li>
                                    </ul>
                                </li>
                                <li><a href="vitrine-servicos.php">VENEZIANAS</a><i class="ion-ios-plus-empty hidden-md-up"></i></li>
                                <li><a href="vitrine-servicos.php">OMBRELONES</a><i class="ion-ios-plus-empty hidden-md-up"></i></li>
                                <li><a href="contato.php">CONTATO</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- END HEADER -->