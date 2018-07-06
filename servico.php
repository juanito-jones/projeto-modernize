<?php
require_once "@classe-paginas.php";
require_once "@pew/pew-system-config.php";
require_once "@classe-produtos.php";

$cls_paginas->set_titulo('Página Inicial');
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
        if(isset($_GET["id_produto"]) && !empty($_GET["id_produto"])){
            $id = $_GET["id_produto"];
            $cls_produtos = new Produtos();
            $cls_produtos->montar_produto($id);
            $infoProduto = $cls_produtos->montar_array();

            $dirImagens = 'imagens/produtos/';
            $imagens = $infoProduto["imagens"];
            $qtdImagens = count($imagens);
            $imageExiste = false;
            if($qtdImagens > 0){
                $imagemPrincipal = $imagens[0];
                $srcImagem = $imagemPrincipal["src"];
                if(file_exists($dirImagens.$srcImagem) && $srcImagem != ""){
                    $imageExiste = true;
                    echo __DIR__;
                }
                if(!$imageExiste){
                    $srcImagem = $dirImagens."produto-padrao.png";
                }else{
                    $srcImagem = $dirImagens.$srcImagem;
                }
            }else{
                $srcImagem = "produto-padrao.png";
            }
        }else{
            echo "<h3>Produto não encontrado.</h3>";
        }
        ?>
        <!-- Intro Section -->
        <div class="page-header parallax" style="background-image: url('imagens/departamentos/produtos-modernize.png')">
            <div class="container">
                <h1 class="title">Gostou? Entre em contato!</h1>
            </div>
            <div class="breadcrumb-box">
                <div class="container">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Página Inicial</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><?= $infoProduto["nome"]; ?></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div id="services-section" class="padding pt-xs-60">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-7">
                        <div class="text-box mt-40">
                            <div class="box-title mb-20">
                                <h2><?= $infoProduto["nome"]; ?></h2>
                            </div>
                            <div class="text-content">
                                <p><?= $infoProduto["descricao_longa"]; ?></p>
                            </div>
                        </div>
                        <div class="row mt-45 clearfix">
                            <div class="col-md-12 mb-30 col-lg-4">
                                <?php
                                foreach($imagens as $img){
                                    $img = $img["src"];
                                    echo "<img class='img-responsive' src='$dirImagens/$img' alt='{$infoProduto["nome"]}'>";
                                }
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 faq-service mb-30 mt-30">
                                <h2>Especificações Tecnicas</h2>
                                <div class="text-content mb-30">
                                    <p>Aenean suscipit eget mi act fermentum phasellus vulputate turpis tincidunt. Aenean suscipit eget..</p>
                                </div>
                                <div class="display-espec">
                                    <div class="box-espec">
                                        <ul>
                                            <li>Aenean suscipit eget mi</li>
                                        </ul>
                                    </div>	
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        include "includes/footer.php";
        ?>
    </body>
    <?php require_once "@link-standard-js.php"; ?>
</html>
