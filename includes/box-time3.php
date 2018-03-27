<style>
    #team{overflow: hidden;background: #f9f9f9;}
    .team-item-img {
        position: relative;
    }
    .team-item-img .team-item-detail {
        background-color:rgba(29, 29, 29, 0.7);
        text-align: center;
        color: #fff;
        display: -webkit-flex;
        display: flex;
        height: 100%;
        width: 100%;
        position: absolute;
        top: 0;
        left: 0;
        opacity: 0;
        visibility: hidden;
        overflow: hidden;
        transition: all 0.5s ease-in-out 0s;
        -moz-transition: all 0.5s ease-in-out 0s;
        -webkit-transition: all 0.5s ease-in-out 0s;
        -o-transition: all 0.5s ease-in-out 0s;
    }
    .team-item:hover .team-item-detail {
        opacity: 1;
        visibility: visible;
    }
    .team-item-img .team-item-detail .team-item-detail-inner, .cent-mid-content {
        margin: auto;
        padding: 20px;
    }
    @media (max-width: 1199px) and (min-width: 992px){
        .team-item-img .team-item-detail .team-item-detail-inner, .cent-mid-content{
            padding: 10px;
        }
        .light-color h5{
            margin-top: 0px;
        }
        .team-item-detail-inner p{
            margin-bottom: 0px;
        }

    }

    .team-item-img .team-item-detail .team-item-detail-inner .social {
        margin: 0;
        padding: 15px 0;
    }
    .team-item-img .team-item-detail .team-item-detail-inner .social li {
        list-style: none;
        display: inline-block;
        margin: 0px 5px;
    }
    .team-item-img .team-item-detail .team-item-detail-inner .social li a {
        width: 35px;
        height: 35px;
        background:#6cbe03;
        color: #fff;
        border-radius: 100%;
        display: block;
        line-height: 40px;
        font-size: 18px;
    }
    @media (max-width: 1199px) and (min-width: 992px){
        .team-item-img .team-item-detail .team-item-detail-inner .social li a{
            width: 29px;
            height: 29px;
            line-height: 31px;
            font-size: 15px;
        }
    }

    #team #team-carousel .owl-controls .owl-dots{
        width: 100%;
        text-align:center;
    }
    #team #team-carousel .owl-controls .owl-dots .owl-dot{
        display: inline-block;
    }
    #team #team-carousel .owl-controls .owl-dots .owl-dot span{
        display: inline-block;
        height: 15px;
        width: 15px;
        background: #222;
        margin: 0px 5px;
        border-radius: 50%;
    }
    #team #team-carousel .owl-controls .owl-dots .active span{
        background:#6cbe03;
    }

    .team-item-info {
        padding-top: 15px;
        text-align: center;
    }
    .team-item-info h5 {
        margin-bottom: 0px; font-size: 15px;font-weight: 800;color: #323232;
        text-transform: uppercase;
    }
    .light-color h5{    
        margin-bottom: 10px;
        text-transform: uppercase;
        color: #fff;
        font-size: 15px;
        font-weight: 800;}
    .light-color a {
        color: #fff;
    }
</style>

<section id="team" class="fadeIn ptb ptb-sm-80 text-center">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="heading-box pb-30">
                    <h2><span>Our</span> Team</h2>
                    <span class="b-line"></span>
                </div>
            </div>
        </div>

        <!--Team Carousel -->
        <div class="row mt-10">
            <div id="team-carousel" class="owl-carousel team-carousel nf-carousel-theme">

                <div class="item dental">
                    <div class="team-item ">
                        <div class="team-item-img"> <img src="assets/images/finance-bg2.jpg" alt="" />
                            <div class="team-item-detail">
                                <div class="team-item-detail-inner light-color">
                                    <h5>angelina KAPPOS</h5>
                                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit,</p>
                                    <ul class="social">
                                        <li><a href="javascript:avoid(0);"><i class="fa fa-facebook"></i></a></li>
                                        <li><a href="javascript:avoid(0);"><i class="fa fa-twitter"></i></a></li>
                                        <li><a href="javascript:avoid(0);"><i class="fa fa-linkedin"></i></a></li>
                                        <li><a href="javascript:avoid(0);"><i class="fa fa-google-plus"></i></a></li>
                                    </ul>
                                    <a href="#" class="btn btn-md btn-white-line  mt-15">Read More</a> </div>
                            </div>
                        </div>
                        <div class="team-item-info">
                            <h5>angelina KAPPOS</h5>
                            <p class="">DIRECTOR</p>
                        </div>
                    </div>
                </div>

                <div class="item gynaecological">
                    <div class="team-item ">
                        <div class="team-item-img"> <img src="assets/images/finance-bg3.jpg" alt="" />
                            <div class="team-item-detail">
                                <div class="team-item-detail-inner light-color">
                                    <h5>Leonardo da Vinci</h5>
                                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit,</p>
                                    <ul class="social">
                                        <li><a href="javascript:avoid(0);"><i class="fa fa-facebook"></i></a></li>
                                        <li><a href="javascript:avoid(0);"><i class="fa fa-twitter"></i></a></li>
                                        <li><a href="javascript:avoid(0);"><i class="fa fa-linkedin"></i></a></li>
                                        <li><a href="javascript:avoid(0);"><i class="fa fa-google-plus"></i></a></li>
                                    </ul>
                                    <a href="#" class="btn btn-md btn-white-line  mt-15">Read More</a> </div>
                            </div>
                        </div>
                        <div class="team-item-info">
                            <h5>Leonardo da Vinci</h5>
                            <p class="">DIRECTOR</p>
                        </div>
                    </div>
                </div>

                <div class="item pediatric">
                    <div class="team-item ">
                        <div class="team-item-img"> <img src="assets/images/finance-bg4.jpg" alt="" />
                            <div class="team-item-detail">
                                <div class="team-item-detail-inner light-color">
                                    <h5>Sneha Doe</h5>
                                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit,</p>
                                    <ul class="social">
                                        <li><a href="javascript:avoid(0);"><i class="fa fa-facebook"></i></a></li>
                                        <li><a href="javascript:avoid(0);"><i class="fa fa-twitter"></i></a></li>
                                        <li><a href="javascript:avoid(0);"><i class="fa fa-linkedin"></i></a></li>
                                        <li><a href="javascript:avoid(0);"><i class="fa fa-google-plus"></i></a></li>
                                    </ul>
                                    <a href="#" class="btn btn-md btn-white-line  mt-15">Read More</a> </div>
                            </div>
                        </div>
                        <div class="team-item-info">
                            <h5>Sneha Doe</h5>
                            <p class="">DIRECTOR</p>
                        </div>
                    </div>
                </div>

                <div class="item dental">
                    <div class="team-item ">
                        <div class="team-item-img"> <img src="assets/images/finance-bg2.jpg" alt="" />
                            <div class="team-item-detail">
                                <div class="team-item-detail-inner light-color">
                                    <h5>angelina KAPPOS</h5>
                                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit,</p>
                                    <ul class="social">
                                        <li><a href="javascript:avoid(0);"><i class="fa fa-facebook"></i></a></li>
                                        <li><a href="javascript:avoid(0);"><i class="fa fa-twitter"></i></a></li>
                                        <li><a href="javascript:avoid(0);"><i class="fa fa-linkedin"></i></a></li>
                                        <li><a href="javascript:avoid(0);"><i class="fa fa-google-plus"></i></a></li>
                                    </ul>
                                    <a href="#" class="btn btn-md btn-white-line  mt-15">Read More</a> </div>
                            </div>
                        </div>
                        <div class="team-item-info">
                            <h5>angelina KAPPOS</h5>
                            <p class="">DIRECTOR</p>
                        </div>
                    </div>
                </div>

                <div class="item gynaecological">
                    <div class="team-item ">
                        <div class="team-item-img"> <img src="assets/images/finance-bg3.jpg" alt="" />
                            <div class="team-item-detail">
                                <div class="team-item-detail-inner light-color">
                                    <h5>Leonardo da Vinci</h5>
                                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit,</p>
                                    <ul class="social">
                                        <li><a href="javascript:avoid(0);"><i class="fa fa-facebook"></i></a></li>
                                        <li><a href="javascript:avoid(0);"><i class="fa fa-twitter"></i></a></li>
                                        <li><a href="javascript:avoid(0);"><i class="fa fa-linkedin"></i></a></li>
                                        <li><a href="javascript:avoid(0);"><i class="fa fa-google-plus"></i></a></li>
                                    </ul>
                                    <a href="#" class="btn btn-md btn-white-line  mt-15">Read More</a> </div>
                            </div>
                        </div>
                        <div class="team-item-info">
                            <h5>Leonardo da Vinci</h5>
                            <p class="">DIRECTOR</p>
                        </div>
                    </div>
                </div>

                <div class="item pediatric">
                    <div class="team-item ">
                        <div class="team-item-img"> <img src="assets/images/finance-bg4.jpg" alt="" />
                            <div class="team-item-detail">
                                <div class="team-item-detail-inner light-color">
                                    <h5>Sneha Doe</h5>
                                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit,</p>
                                    <ul class="social">
                                        <li><a href="javascript:avoid(0);"><i class="fa fa-facebook"></i></a></li>
                                        <li><a href="javascript:avoid(0);"><i class="fa fa-twitter"></i></a></li>
                                        <li><a href="javascript:avoid(0);"><i class="fa fa-linkedin"></i></a></li>
                                        <li><a href="javascript:avoid(0);"><i class="fa fa-google-plus"></i></a></li>
                                    </ul>
                                    <a href="#" class="btn btn-md btn-white-line  mt-15">Read More</a> </div>
                            </div>
                        </div>
                        <div class="team-item-info">
                            <h5>Sneha Doe</h5>
                            <p class="">DIRECTOR</p>
                        </div>
                    </div>
                </div>


            </div>
        </div>
        <!--End Team Carousel --> 
    </div>
</section>