<style>
    .project_bg .sec-title {
        float: left;
    }
    .project_bg .sec-title h2 {
        color: #fff;
    }
    .project_bg {
        background: url(../assets/images/project_bg.jpg);
        position: relative;
        background-repeat: no-repeat;
        background-size: cover;
        background-attachment: fixed;
    }
    .project_bg:before {
        position: absolute;
        content: "";
        top: 0px;
        left: 0px;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.69);
    }
    .container-filter {
        margin-top: 0;
        margin-right: 0;
        margin-left: 0;
        margin-bottom: 10px;
        padding: 0;
    }

    .container-filter li {
        list-style: none;
        display: inline-block;
        margin-bottom: 0px;
    }

    .container-filter li a {
        margin: 0px 4px 0px 0px;
        font-size: 13px;
        cursor: pointer;
        border-radius: 3px;
        border: none;
        padding: 10px 15px;
        color: #fff !important;
        position: relative;
        display: inline-block;
        -webkit-transition: color .3s ease-in-out, background-color .3s ease-in-out, border-color .3s ease-in-out;
        transition: color .3s ease-in-out, background-color .3s ease-in-out, border-color .3s ease-in-out;
        border: 1px solid transparent;
    }
    .container-filter li a.active, .container-filter li a:hover {
        color: #787878 !important;
        background: #fff;
    }
    .item-box {
        position: relative;
        overflow: hidden;
        display: block;
    }

    .item-box a {
        display: inline-block;
    }

    .item-box {
        position: relative;
        overflow: hidden;
        display: block;
        border: 1px solid #6cbe03;
    }
    .item-box img {
        width: 100%;
    }

    .gallery-heading h4 {
        margin-bottom: 0;
    }
    .gallery-heading h4 a {
        color: #fff;
    }
    .gallery-heading h4 a:hover {
        color: #6cbe03;
    }
    .gallery-heading {
        transition: all 0.2s linear 0s;
        -webkit-transition: all 0.2s linear 0s;
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        color: #fff;
        z-index: 1;
        background: #333;
        text-align: center;
        padding-bottom: 10px;
    }
    .gallery-heading p {
        margin-bottom: 0;
    }

    .item-container {
        -webkit-transform: translateY(0px);
        transform: translateY(0px);
        width: 100%;
        transition: transform .25s;
    }
    .item-box:hover .item-container {
        -webkit-transform: translateY(-70px);
        transform: translateY(-70px);
    }

    .item-box > a {
        display: block;
        position: relative;
        z-index: 2;
    }
    @media (min-width: 992px) and (max-width: 1199px) {
        .container-filter li a {
            padding:5px;
        }
    }
    @media (min-width: 768px) and (max-width: 991px) {
        .project_bg .sec-title {
            width: 100%;
        }
        .container-filter {
            float: left;
            margin-top: 20px;
        }
    }

    @media (max-width: 767px) {
        .project_bg .sec-title {
            width: 100%;
        }
        .container-filter {
            float: left;
            margin-top: 20px;
        }
        .container-filter li a {
            margin: 0px 4px 5px 0px;
        }
    }

</style>
<!-- Project-->
<section class="padding ptb-xs-40 project_bg">
    <div class="container">
        <div class="row pb-50 pb-xs-30">
            <div class="col-lg-4">
                <div class="sec-title">
                    <h2>Our Project</h2>
                </div>
            </div>
            <div class="col-lg-8 d-flex justify-content-end">
                <ul class="container-filter categories-filter">
                    <li>
                        <a class="categories active" data-filter="*">All Projects</a>
                    </li>
                    <li>
                        <a class="categories" data-filter=".branding">Office Building</a>
                    </li>
                    <li>
                        <a class="categories" data-filter=".design">Shopping Mall</a>
                    </li>
                    <li>
                        <a class="categories" data-filter=".photo">Private Estate</a>
                    </li>

                </ul>
            </div>
        </div>
        <div class="row">

            <div class="col-lg-12">
                <div class="row container-grid nf-col-3">
                    <div class="nf-item branding design spacing">
                        <div class="item-box">
                            <a href="assets/images/service/services-1.jpg" class="popup-btn" data-fancybox-group="light"> <img alt="1" src="assets/images/service/services-1.jpg" class="item-container"> </a>

                            <div class="gallery-heading">
                                <h4><a href="#">Branding</a></h4>
                                <p>
                                    At vero eos et rebum
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="nf-item photo design spacing">
                        <div class="item-box">
                            <a href="assets/images/service/services-2.jpg" class="popup-btn" data-fancybox-group="light"> <img alt="1" src="assets/images/service/services-2.jpg" class="item-container"> </a>

                            <div class="gallery-heading">
                                <h4><a href="#">Photo</a></h4>
                                <p>
                                    At vero eos et rebum
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="nf-item branding photo spacing">
                        <div class="item-box">
                            <a href="assets/images/service/services-3.jpg" class="popup-btn" data-fancybox-group="light"> <img alt="1" src="assets/images/service/services-3.jpg" class="item-container"> </a>

                            <div class="gallery-heading">
                                <h4><a href="#">Branding</a></h4>
                                <p>
                                    At vero eos et rebum
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="nf-item spacing branding">
                        <div class="item-box">
                            <a href="assets/images/service/services-4.jpg" class="popup-btn" data-fancybox-group="light"> <img alt="1" src="assets/images/service/services-4.jpg" class="item-container"> </a>

                            <div class="gallery-heading">
                                <h4><a href="#">Branding</a></h4>
                                <p>
                                    At vero eos et rebum
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="nf-item branding spacing photo">
                        <div class="item-box">
                            <a href="assets/images/service/services-5.jpg" class="popup-btn" data-fancybox-group="light"> <img alt="1" src="assets/images/service/services-5.jpg" class="item-container"> </a>

                            <div class="gallery-heading">
                                <h4><a href="#">Branding</a></h4>
                                <p>
                                    At vero eos et rebum
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="nf-item design spacing">
                        <div class="item-box">
                            <a href="assets/images/service/services-6.jpg" class="popup-btn" data-fancybox-group="light"> <img alt="1" src="assets/images/service/services-6.jpg" class="item-container"> </a>

                            <div class="gallery-heading">
                                <h4><a href="#">Branding</a></h4>
                                <p>
                                    At vero eos et rebum
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>
<!-- Project End-->