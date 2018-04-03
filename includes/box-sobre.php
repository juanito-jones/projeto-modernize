<style>
    .sec-title {
        position: relative;
    }
    .sec-title h2 {
        position: relative;
        font-size: 36px;
        font-weight: 700;
        line-height: 1.2em;
        padding-bottom: 15px;
    }
    .sec-title h2:before {
        position: absolute;
        content: '';
        left: 0px;
        bottom: 0px;
        width: 270px;
        border-bottom: 2px solid #e4e4e4;
    }
    .sec-title h2:after {
        position: absolute;
        content: '';
        left: 0px;
        bottom: 0px;
        width: 70px;
        border-bottom: 5px solid #6cbe03;
    }
    .center_bdr h2:before, .center_bdr h2:after {
        left: 50%;
        transform: translateX(-50%);
    }
	.texto{
		height: 100px;
	}
</style>
<!-- about -->
<div class="section-bar padding ptb-xs-40">
    <div class="container">
        <div class="row pb-50 pb-xs-30 text-center">
            <div class="col-md-12">
                <div class="sec-title center_bdr">
                    <h2>Sobre Nós</h2>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 top_compy mt-xs-30 push-lg-6">
                <span>Easy Way To Build Websites</span>
                <h2>Bem-vindo Modernize</h2>
                <p>
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the 's standard dummy text. Lorem Ipsum has been the industry's standard dummy text ever since. Lorem Ipsum is simply dummy text.
                </p>
                <div class="row mt-30 text-center ">
                    <div class="col-lg-6 col-md-6 compny_point mb-xs-30">
                       	<img src="assets/images/icon/icone-persiana.png">
						<a href="vitrine-servicos.php"><h4>Nossa Persiana</h4></a>
                        <p class="texto">
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                        </p>
                    </div>
                    <div class="col-lg-6 col-md-6 compny_point">
                        <img src="assets/images/icon/tool.png">
                        <a href="sobre.php"><h4>Nossos Serviços</h4></a>
                        <p class="texto">
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                        </p>
                    </div>

                </div>
            </div>
            <div class="col-lg-6 pull-lg-6 mt-sm-30 mt-xs-30">
                <img src="assets/images/images.jpg" alt="" />
            </div>
        </div>
    </div>
</div>
<!-- about_End -->