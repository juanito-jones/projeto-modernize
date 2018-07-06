<?php
    session_start();
    
    $thisPageURL = substr($_SERVER["REQUEST_URI"], strpos($_SERVER["REQUEST_URI"], '@pew'));
    $_POST["next_page"] = str_replace("@pew/", "", $thisPageURL);
    $_POST["invalid_levels"] = array(1);
    
    require_once "@link-important-functions.php";
    require_once "@valida-sessao.php";

    $navigation_title = "Cores - " . $pew_session->empresa;
    $page_title = "Gerenciamento de Cores";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Acesso Restrito. Efectus Web.">
        <meta name="author" content="Efectus Web">
        <title><?php echo $navigation_title; ?></title>
        <?php
            require_once "@link-standard-styles.php";
            require_once "@link-standard-scripts.php";
        ?>
        <script>
            var filaAtiva = false;
            var cadastrando = false;
            var classBoxActive = "box-categoria-active";
            var classBoxCrudActive = "display-ger-categorias-active";
            var attrIdCor = "pew-box-id";
            var attrBoxTitle = "pew-box-title";
            var animationDelay = 100;
            var objCrudBox = null;
            var lastBoxActive = null;
            var boxActive = null;
            var botaoCadastrar = null;
            var classBtnActive = "active-box";
            var classIconOpen = "fa-folder-open";
            var classIconClose = "fa-folder";
            var countBox = 0;
            function carregarMarca(idCor, boxMarca){
                boxActive = idCor;
                boxMarca.addClass(classBoxActive);
                var icone = boxMarca.children("h3").children("i");
                icone.removeClass(classIconClose).addClass(classIconOpen);
                if(filaAtiva){
                    if(lastBoxActive != null){
                        var lastIcone = lastBoxActive.children("h3").children("i");
                        lastIcone.removeClass(classIconOpen).addClass(classIconClose);
                        lastBoxActive.removeClass(classBoxActive);
                    }
                    objCrudBox.removeClass(classBoxCrudActive);
                }
                filaAtiva = true;

                function loadPage(){
                    lastBoxActive = boxMarca;
                    if(!cadastrando){
                        var url = "pew-edita-cor.php";
                        objCrudBox.load(url, {id_cor: idCor}, function(){
                            setTimeout(function(){
                                objCrudBox.addClass(classBoxCrudActive);
                            }, 300);
                        });
                    }
                }
                setTimeout(function(){
                    loadPage();
                }, animationDelay);
            }

            function listFocus(tituloMarca){
                setTimeout(function(){
                    unselectMarca();
                    $(".box-categoria").each(function(){
                        var box = $(this);
                        var titulo = box.attr(attrBoxTitle);
                        var id = box.attr(attrIdCor);
                        if(titulo == tituloMarca){
                            carregarMarca(id, box);
                        }
                    });
                }, animationDelay);
            }

            function unselectMarca(){
                if(countBox > 0 && lastBoxActive != null){
                    var lastIcone = lastBoxActive.children("h3").children("i");
                    lastIcone.removeClass(classIconOpen).addClass(classIconClose);
                    lastBoxActive.removeClass(classBoxActive);
                    lastBoxActive = null;
                    boxActive = null;
                }
            }

            $(document).ready(function(){
                objCrudBox = $(".display-ger-categorias");
                botaoCadastrar = $(".btn-cad-categoria");

                var firstMarca = true;
                $(".box-categoria").each(function(){
                    countBox++;
                    var boxMarca = $(this);
                    var botaoAlternativo = boxMarca.children("h3");
                    var idCor = boxMarca.attr(attrIdCor);
                    function selectMarca(){
                        if(boxActive != idCor){
                            carregarMarca(idCor, boxMarca);
                        }
                    }
                    if(firstMarca){
                        firstMarca = false;
                        selectMarca();
                    }
                    boxMarca.off().on("click", function(){
                        selectMarca();
                    });
                    botaoAlternativo.off().on("click", function(){
                        if(boxActive == idCor){
                            boxActive = null;
                            filaAtiva = false;
                        }
                        carregarMarca(idCor, boxMarca);
                    });
                });
                botaoCadastrar.off().on("click", function(){
                    if(!cadastrando){
                        cadastrando = true;
                        var url = "pew-cadastra-cor.php";
                        $(".mensagem-padrao").hide();
                        unselectMarca();
                        objCrudBox.removeClass(classBoxCrudActive);
                        setTimeout(function(){
                            objCrudBox.load(url, function(){
                                objCrudBox.addClass(classBoxCrudActive);
                                cadastrando = false;
                            });
                        }, animationDelay);
                    }
                });
            });
        </script>
    </head>
    <body>
        <?php
            // STANDARD REQUIRE
            require_once "@include-body.php";
            if(isset($block_level) && $block_level == true){
                $pew_session->block_level();
            }
            
            /*SET TABLES*/
            $tabela_cores = $pew_custom_db->tabela_cores;
            /*END SET TABLES*/

            if(isset($_GET["focus"])){
                $focus = $_GET["focus"];
                echo "<script>$(document).ready(function(){ listFocus('$focus'); })</script>";
            }
        ?>
        <!--PAGE CONTENT-->
        <h1 class="titulos"><?php echo $page_title; ?></h1>
        <section class="conteudo-painel">
            <div class="full label clear">
                <a class="btn-flat btn-cad-categoria" title="Cadastre uma nova cor"><i class="fas fa-plus"></i> Cadastrar nova cor</a>
            </div>
            <div class='painel-categorias full'>
                <?php
                    $fileIcon = "<i class='fa fa-folder icone-categorias' aria-hidden='true'></i>";
                    $plusIcon = "<i class='fa fa-plus icone-categorias' aria-hidden='true'></i>";
    
                    $condicaoCores = "status = 1";
                    $totalCores = $pew_functions->contar_resultados($tabela_cores, $condicaoCores);
                    $ctrlCores = 0;
                    if($totalCores > 0){
                        echo "<h2 class='titulo'>Cores ativas:</h2>";
                        echo "<div class='display-categorias'>";
                        $queryCores = mysqli_query($conexao, "select id, cor from $tabela_cores where $condicaoCores order by cor asc");
                        while($infoCor = mysqli_fetch_array($queryCores)){
                            $idCor = $infoCor["id"];
                            $tituloCor = $infoCor["cor"];
                            $ctrlCores++;
                            echo "<div class='box-categoria' pew-box-id='$idCor' style='height: 20px;' pew-box-title='$tituloCor'>";
                                echo "<h3 class='alter-button-box-categoria' pew-box-id='$idCor' pew-box-title='$tituloCor'>".$fileIcon." ".$tituloCor."</h3>";
                            echo "</div>";
                        }
                        echo "</div>";
                    }
                    
                    $condicaoCoresDesativadas = "status = 0";
                    $totalCoresDestativadas = $pew_functions->contar_resultados($tabela_cores, $condicaoCoresDesativadas);
                    if($totalCoresDestativadas > 0){
                        echo "<h2 class='titulo'>Cores desativadas:</h2>";
                        echo "<div class='display-categorias'>";
                        $queryCoresD = mysqli_query($conexao, "select id, cor from $tabela_cores where $condicaoCoresDesativadas order by cor asc");
                        while($infoCor = mysqli_fetch_array($queryCoresD)){
                            $idCor = $infoCor["id"];
                            $tituloCor = $infoCor["cor"];
                            $ctrlCores++;
                            echo "<div class='box-categoria disable-categorias' pew-box-id='$idCor' pew-box-title='$tituloCor'>$fileIcon $tituloCor</div>";
                        }
                        echo "</div>";
                    }
                ?>
            </div>
            <?php
                $class = "";
                if($ctrlCores == 0){
                    echo "<br style='clear: both;'><h3 class='mensagem-padrao'>Nenhuma cor foi encontrada. <a class='link-padrao btn-cad-categoria'>Clique aqui e cadastre</a></h3>";
                    $class = "display-ger-center";
                }
                echo "<div class='display-ger-categorias $class'></div>";
            ?>
        </section>
    </body>
</html>