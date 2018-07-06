<style>
    .services-section {
        position: relative;
        padding: 95px 0px 60px;
    }

    .services-block {
        position: relative;
    }

    .services-block .inner-box {
        position: relative;
        display: block;
    }

    .services-block .inner-box .image {
        position: relative;
    }

    .services-block .inner-box .image img {
        position: relative;
        width: 100%;
        display: block;
    }
    .services-block .inner-box .lower-box h3 {
        position: relative;
        color: #333333;
        font-size: 22px;
        font-weight: 500;
        line-height: 1.2em;
    }

    .services-block .inner-box .lower-box a {
        color: #333333;
        transition: all 0.3s ease;
        -moz-transition: all 0.3s ease;
        -webkit-transition: all 0.3s ease;
        -ms-transition: all 0.3s ease;
        -o-transition: all 0.3s ease;
    }

    .services-block .inner-box .lower-box a:hover {
        color: #966A45;
    }

</style>

<section id="service" class="padding ptb-xs-40 gray-bg">
    <div class="container">
        <div class="row pb-50 pb-xs-30">
            <div class="col-md-12">
                <div class="sec-title">
                    <h2><?= $headInfo["titulo"];?></h2>
                    <p style="text-align: justify"><?= $cls_paginas->descricao;?></p>
                </div>
            </div>
        </div>
        <div class="row">
                <?php
                if(!empty($selectedProdutos)){
                    foreach($selectedProdutos as $prod){
                        $cls_produtos->montar_produto($prod);
                        $infoProduto = $cls_produtos->montar_array();
                        $nomeProduto = $infoProduto['nome'];
                        $idProduto = $infoProduto['id'];
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
                        echo "<div class='services-block col-lg-4 col-md-6 col-xs-12 mb-30 mb-sm-30 mb-xs-30'>";
                            echo "<div class='inner-box hvr-float'>";
                                echo "<div class='image'>";
                                    echo "<img src='$srcImagem' alt='Imagem - {$nomeProduto}'>";
                                echo "</div>";
                                    echo "<div class='lower-box'>";
                                    echo "<h3><a href='servico.php?id_produto=$idProduto'>{$nomeProduto}</a></h3>";
                                echo "</div>";
                            echo "</div>";
                        echo "</div>";
                    }
                }else{
                    echo "<div class='services-block col-lg-12'>";
                        echo "<div class='inner-box hvr-float'>";
                            echo "<div class='lower-box'>";
                                echo "<h3>Desculpa, nossos produtos podem ter esgotado.</h3>";
                            echo "</div>";
                        echo "</div>";
                    echo "</div>";
                }
                ?>
                
        </div>
    </div>
</section>