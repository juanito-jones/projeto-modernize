<?php
require_once "@classe-paginas.php";
$cls_paginas->set_titulo('Contato');
$cls_paginas->set_descricao('Descrição exemplar!');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $cls_paginas->titulo; ?></title>
        <meta name="description" content="<?php echo $cls_paginas->descricao; ?>">
        <?php require_once "@link-standard-styles.php"; ?>
        <?php require_once "@link-important-functions.php"; ?>
    </head>
    <body>
        <?php
        include "includes/header.php";
        include "includes/box-breadcrumb-contato.php";
        ?>
        <!-- Contact Section -->
        <section class="padding ptb-xs-60">
            <div class="container">
                <div class="row text-center">
                    <div class="col-md-8 offset-md-2 text-center">
                        <div class="heading-box pb-30">
                            <h2>Entre em Contato</h2>
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
                                <i class="ion-android-call icon-circle pos-s"></i><a href="#" class="mt-15 i-block">(41) 3328-6554</a>
                            </div>
                            <div class="col-sm-4 pb-xs-30">
                                <i class="ion-ios-location icon-circle pos-s"></i>
                                <p  class="mt-15">
                                    Rua Brasilio Itibere, 3723 - Água Verde
                                </p>
                            </div>
                            <div class="col-sm-4 pb-xs-30">
                                <i class="ion-ios-email icon-circle pos-s"></i><a href="mailto:contato@modernizecuritiba.com.br"  class="mt-15 i-block">contato@modernizecuritiba.com.br</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Map Section -->
            <div class="map">
                <iframe style="width: 100%;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3602.6094215670832!2d-49.28187468498535!3d-25.451318383778567!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94dce47e6fde4ea3%3A0xdb45b8ba93743511!2sR.+Bras%C3%ADlio+Itiber%C3%AA%2C+3723+-+%C3%81gua+Verde%2C+Curitiba+-+PR%2C+80240-060!5e0!3m2!1spt-BR!2sbr!4v1528469798488" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
            </div>
            <!-- Map Section -->
            <?php
            require_once "includes/box-formulario.php";
            ?>
        </section>
        <?php
        include "includes/footer.php";
        ?>
    </body>
    <?php require_once "@link-standard-js.php"; ?>
</html>
