<?php
    session_start();
    
    $thisPageURL = substr($_SERVER["REQUEST_URI"], strpos($_SERVER["REQUEST_URI"], '@pew'));
    $_POST["next_page"] = str_replace("@pew/", "", $thisPageURL);
    $_POST["invalid_levels"] = array(1);
    
    require_once "@link-important-functions.php";
    require_once "@valida-sessao.php";

    $navigation_title = "Editar produto - " . $pew_session->empresa;
    $page_title = "Editando produto";
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
        <script type="text/javascript" src="js/produtos.js"></script>
        <script>
            var selecionandoCategoria = false;
            function checkSubcategorias(idSubcategoria){
                var startDelay = 200;
                $(document).ready(function(){
                    setTimeout(function(){
                        if(!selecionandoCategoria){
                            $(".checked-subcategoria-"+idSubcategoria).each(function(){
                                $(this).prop("checked", true);
                            });
                        }else{
                            checkSubcategorias(idSubcategoria);
                        }
                    }, startDelay);
                });
            }
            $(document).ready(function(){
                CKEDITOR.replace("descricaoLonga");
                var listCategorias = $(".list-categorias");
                var boxCategorias = listCategorias.children(".box-categoria");
                

                boxCategorias.each(function(){
                    var box = $(this);
                    var label = box.children("label");
                    var input = label.children(".check-categorias");
                    var listasubcategorias = box.children(".list-subcategorias");
                    var boxSubcategorias = listasubcategorias.children(".box-subcategoria");
                    var labelAberto = false;
                    input.off().on("change", function(){
                        var value = input.prop("checked");
                        labelAberto = value == true ? false : true;
                        if(!listasubcategorias.hasClass("list-subcategorias-active") && !labelAberto){
                            labelAberto = true;
                            listasubcategorias.css("display", "block");
                            setTimeout(function(){
                                listasubcategorias.addClass("list-subcategorias-active");
                            }, 50);
                        }else if(labelAberto){
                            listasubcategorias.removeClass("list-subcategorias-active");
                            labelAberto = false;
                            setTimeout(function(){
                                listasubcategorias.css("display", "none");
                            }, 300);
                            boxSubcategorias.each(function(){
                                var input = $(this).children("label").children(".check-subcategorias").prop("checked", false);
                            });
                        }
                        setTimeout(function(){
                            if(labelAberto){
                                listasubcategorias.css("display", "block");
                            }
                        }, 300);
                    });
                });

                var getIdProduto = $("#idProduto").val();
                setInterval(function(){
                    $(".botao-acao").off().on("click", function(){
                        var botao = $(this);
                        var idProduto = botao.attr("data-id-produto");
                        var acao = botao.attr("data-acao");
                        function statusProduto(){
                            $.ajax({
                                type: "POST",
                                url: "pew-status-produto.php",
                                data: {id_produto: idProduto, acao: acao},
                                beforeSend: function(){
                                    notificacaoPadrao("Aguarde...", "success");
                                },
                                error: function(){
                                    setTimeout(function(){
                                        notificacaoPadrao("Não foi possível "+acao+" o produto", "error", 5000);
                                    }, 1000);
                                },
                                success: function(resposta){
                                    console.log(resposta);
                                    setTimeout(function(){
                                        var resultado = null;
                                        var redirect = "pew-produtos.php";
                                        switch(acao){
                                            case "excluir":
                                                resultado  = "O produto foi excluido com sucesso";
                                                break;
                                            case "desativar":
                                                resultado = "O produto foi desativado";
                                                redirect = "pew-edita-produto.php?id_produto="+getIdProduto;
                                                break;
                                            case "excluir_imagem":
                                                resultado = "A imagem foi excluida com sucesso";
                                                redirect = "pew-edita-produto.php?id_produto="+getIdProduto;
                                                break;
                                            default:
                                                resultado = "O produto foi ativado com sucesso";
                                                redirect = "pew-edita-produto.php?id_produto="+getIdProduto;
                                        }
                                        if(resposta == "true"){
                                            mensagemAlerta(resultado, "", "limegreen", redirect);
                                        }else if(resposta == "imagem_excluida"){
                                            mensagemAlerta(resultado, "", "limegreen", redirect);
                                        }else{
                                            notificacaoPadrao("Não foi possível completar a ação", "error", 5000);
                                        }
                                    }, 500);
                                }
                            });
                        }
                        switch(acao){
                            case "excluir":
                                var msg  = "Tem certeza que deseja excluir este produto?";
                                break;
                            case "desativar":
                                var msg = "Tem certeza que deseja desativar este produto?";
                                break;
                            case "excluir_imagem":
                                var msg = "Tem certeza que deseja excluir a imagem deste produto?";
                                break;
                            default:
                                var msg = "Tem certeza que deseja ativar este produto?";
                        }
                        mensagemConfirma(msg, statusProduto);
                    });
                }, 500);

                /*ESPECIFICACOES TECNICAS*/
                var botaoAdicionarEspecificacao = $(".btn-especificacoes");
                var selectEspecificacao = $("#selectEspecificacao");
                var displayEspecificacoes = $(".display-especificacoes");
                var objTextareaEspecificacao = $("#descricaoEspecificacao");

                function resetEspecificacao(){
                    objTextareaEspecificacao.val("");
                    selectEspecificacao.val("");
                }

                botaoAdicionarEspecificacao.off().on("click", function(){
                    var selectedEspecificacaoId = selectEspecificacao.val();
                    if(selectedEspecificacaoId != ""){
                        selectEspecificacao.children("option").each(function(){
                            var option = $(this);
                            var idEspecificacao = option.val();
                            var tituloEspecificacao = option.text();
                            if(idEspecificacao == selectedEspecificacaoId){
                                var descricaoEspecificacao = objTextareaEspecificacao.val();
                                var ctrlInputVal = idEspecificacao+"|-|"+descricaoEspecificacao;
                                if(descricaoEspecificacao.length > 0){
                                    var addedEspecificacao = "<label class='label-especificacao'><b>"+tituloEspecificacao+": </b> <input type='text' class='input-especificacao' value='"+descricaoEspecificacao+"'><input type='hidden' class='input-ctrl-especificacao' name='especicacao_produto[]' value='"+ctrlInputVal+"' pew-id-especificacao='"+idEspecificacao+"'> <a class='btn-excluir-especificacao' title='Excluir especificação'><i class='fa fa-times' aria-hidden='true'></i></a></label>";
                                    displayEspecificacoes.append(addedEspecificacao);
                                    notificacaoPadrao("Especificação adicionada", "success");
                                    resetEspecificacao();
                                }else{
                                    mensagemAlerta("O campo descrição deve ser preenchido", objTextareaEspecificacao);
                                }
                            }
                        });
                    }else{
                        mensagemAlerta("Selecione uma especificação", selectEspecificacao);
                    }
                });

                setInterval(function(){
                    displayEspecificacoes.children(".label-especificacao").each(function(){
                        var label = $(this);
                        var objInputView = label.children(".input-especificacao");
                        var objInputCtrl = label.children(".input-ctrl-especificacao");
                        var idEspec = objInputCtrl.attr("pew-id-especificacao");
                        var botaoExcluir = label.children(".btn-excluir-especificacao");
                        var ctrlInputVal = idEspec+"|-|"+objInputView.val();
                        objInputCtrl.val(ctrlInputVal);
                        botaoExcluir.off().on("click", function(){
                            function excluir(){
                                label.remove();
                            }
                            mensagemConfirma("Você tem certeza que deseja excluir esta especificação?", excluir);
                        });
                    });
                }, 200);
                /*END ESPECIFICACOES TECNICAS*/
            });
        </script>
        <!--THIS PAGE CSS-->
        <style>
            .display-cores{
                width: 100%;
                height: 60px;
                padding-bottom: 10px;
                padding-top: 10px;
                text-align: center;
            }
            .display-cores .box-cor{
                width: 25px;
                height: 25px;
                background-color: #dedede;
                margin: 6px;
                display: inline-block;
                cursor: pointer;
                -webkit-box-shadow: 1px 1px 25px 1px rgba(0, 0, 0, 0.2);
                -moz-box-shadow: 1px 1px 25px 1px rgba(0, 0, 0, 0.2);
                box-shadow: 1px 1px 25px 1px rgba(0, 0, 0, 0.2);
            }
            .display-cores .box-cor:hover{
                border: 2px solid #111;
                border-radius: 5px;
                margin: 4px;
            }
            .display-cores .selected{
                border-radius: 50%;
                border: 2px solid #111;
                margin: 4px;
            }
            .display-cores .selected img{
                border-radius: 50%;
            }
            .display-cores .selected:hover{
                border-radius: 20px;
            }
            .file-field{
                height: 140px;
                line-height: 140px;
            }
            .file-field input{
                margin: 0px;
                padding: 0px;
            }
            .file-field:hover{
                line-height: 140px;
            }
            .btn-excluir-imagem{
                color: red;
                font-size: 16px;
                line-height: 20px;
                text-decoration: none;
                padding-bottom: 10px;
                position: absolute;
                bottom: -35px;
                margin: 0 auto;
                cursor: pointer;
                left: 0;
            }
            .msg-inputs{
                margin: 0px;
            }
            /*ESPECIFICACAO TECNICA*/
            .btn-especificacoes{
                cursor: pointer;
                border: 1px solid #333;
                transition: .2s;
                white-space: nowrap;
                text-align: center;
                display: block;
                width: 100%;
            }
            .btn-especificacoes:hover{
                background-color: #fff;
            }
            .label-especificacao{
                display: block;
                margin: 10px 0px 10px 20px;
            }
            .label-especificacao input{
                height: 14px;
                padding: 5px;
                font-size: 16px;
                margin-left: 6px;
            }
            .label-especificacao .btn-excluir-especificacao{
                cursor: pointer;
            }
            /*END ESPECIFICACAO TECNICA*/
        </style>
        <!--FIM THIS PAGE CSS-->
    </head>
    <body>
        <?php
            // STANDARD REQUIRE
            require_once "@include-body.php";
            if(isset($block_level) && $block_level == true){
                $pew_session->block_level();
            }
            
            require_once "../@classe-produtos.php";
        ?>
        <!--PAGE CONTENT-->
        <h1 class="titulos"><?php echo $page_title; ?><a href="pew-produtos.php" class="btn-voltar"><i class="fa fa-arrow-left" aria-hidden="true"></i> Voltar</a></h1>
        <?php
            /*SET TABLES*/
            $tabela_produtos = $pew_custom_db->tabela_produtos;
            $tabela_imagens_produtos = $pew_custom_db->tabela_imagens_produtos;
            $tabela_categorias = $pew_db->tabela_categorias;
            $tabela_subcategorias = $pew_db->tabela_subcategorias;
            $tabela_categorias_produtos = $pew_custom_db->tabela_categorias_produtos;
            $tabela_subcategorias_produtos = $pew_custom_db->tabela_subcategorias_produtos;
            $tabela_marcas = $pew_custom_db->tabela_marcas;
            $tabela_especificacoes = $pew_custom_db->tabela_especificacoes;
            $tabela_especificacoes_produtos = $pew_custom_db->tabela_especificacoes_produtos;
            $tabela_departamentos = $pew_custom_db->tabela_departamentos;
            $tabela_departamentos_produtos = $pew_custom_db->tabela_departamentos_produtos;
            /*END SET TABLES*/

            /*DEFAULT VARS*/
            $idProduto = isset($_GET["id_produto"]) ? (int)$_GET["id_produto"] : 0;
            $dirImagensProdutos = "../imagens/produtos";
            /*END DEFAULT VARS*/

            /*SET DADOS PRODUTOS*/
            $totalProduto = $pew_functions->contar_resultados($tabela_produtos, "id = '$idProduto'");
            if($totalProduto > 0){
                $produto = new Produtos();
                $produto->montar_produto($idProduto);
                $infoProduto = $produto->montar_array();
                $nomeProduto = $infoProduto["nome"];
                $marcaProduto = $infoProduto["marca"];
                $descricaoCurtaProduto = $infoProduto["descricao_curta"];
                $descricaoLongaProduto = $infoProduto["descricao_longa"];
                $urlVideoProduto = $infoProduto["url_video"];
                $statusProduto = $infoProduto["status"];
                $imagensProduto = $infoProduto["imagens"];
                $departamentosProduto = $produto->get_departamentos_produto();
                $categoriasProduto = $produto->get_categorias_produto();
                $subcategoriasProduto = $produto->get_subcategorias_produto();
                $especificacoesProduto = $produto->get_especificacoes_produto();
                
                $selectedDepartamentos = array();
                if($departamentosProduto != false){
                    foreach($departamentosProduto as $infoDepartamento){
                        $idDepartamento = $infoDepartamento["id"];
                        $selectedDepartamentos[$idDepartamento] = true;
                    }
                }
                
                $selectedCategorias = array();
                if($categoriasProduto != false){
                    foreach($categoriasProduto as $infoCategoria){
                        $idCategoria = $infoCategoria["id"];
                        $tituloCategoria = $infoCategoria["titulo"];
                        $selectedCategorias[$idCategoria] = $tituloCategoria;
                    }
                }
                
                $selectedSubcategorias = array();
                if($subcategoriasProduto != false){
                    foreach($subcategoriasProduto as $infoSubcategoria){
                        $idSubcategoria = $infoSubcategoria["id_subcategoria"];
                        $idCategoriaMain = $infoSubcategoria["id_categoria"];
                        $tituloSubcategoria = $infoSubcategoria["titulo"];
                        $selectedSubcategorias[$idSubcategoria] = $tituloSubcategoria;
                        echo "<script>$(document).ready(function(){ checkSubcategorias($idSubcategoria); });</script>";
                    }
                }
                

                /*END SET DADOS PRODUTO*/
        ?>
        <section class="conteudo-painel">
            <form id="formAtualizaProduto" name="formulario_cadastro" method="post" action="pew-update-produto.php" enctype="multipart/form-data">
                <input type="hidden" name="id_produto" value="<?php echo $idProduto;?>" id="idProduto">
                <!--LINHA 1-->
                <div class="label medium">
                    <h2 class='label-title'>Nome do Produto</h2>
                    <input type="text" name="nome" id="nome" placeholder="Produto" class="label-input" value="<?php echo $nomeProduto;?>">
                </div>
                <div class="label xsmall">
                    <h2 class='label-title'>Marca</h2>
                    <select name="marca" class="label-input">
                        <option value="">- Selecione -</option>
                        <?php
                            $contarMarcas = mysqli_query($conexao, "select count(id) as total from $tabela_marcas where status = 1");
                            $contagemMarcas = mysqli_fetch_array($contarMarcas);
                            $totalMarcas = $contagemMarcas["total"];
                            if($totalMarcas > 0){
                                $queryMarcas = mysqli_query($conexao, "select * from $tabela_marcas where status = 1");
                                while($infoMarcas = mysqli_fetch_array($queryMarcas)){
                                    $nomeMarca = $infoMarcas["marca"];
                                    $selected = $nomeMarca == $marcaProduto ? "selected" : "";
                                    echo "<option value='$nomeMarca' $selected>$nomeMarca</option>";
                                }
                            }
                        ?>
                    </select>
                    <?php
                    if($totalMarcas == 0){
                        echo "<h5 style='margin: 0px; margin-top: -6px;'>Nenhum marca cadastrada</h5>";
                    }
                    ?>
                </div>
                <div class="label xsmall">
                    <h2 class='label-title'>Status</h2>
                    <select name="status" class="label-input">
                        <?php
                            $possibleStatus = array(0, 1);
                            foreach($possibleStatus as $selectStatus){
                                $nameStatus = $selectStatus == 1 ? "Ativo" : "Inativo";
                                $selected = $selectStatus == $statusProduto ? "selected" : "";
                                echo "<option value='$selectStatus' $selected>$nameStatus</option>";
                            }
                        ?>
                    </select>
                </div>
                <!--LINHA 2-->
                <br class="clear">
                <div class="label half">
                    <h2 class='label-title'>Descrição Curta SEO Google<br>(Recomendado 156 caracteres)</h2>
                    <textarea placeholder="Descrição do produto" name="descricao_curta" maxlength="180" id="descricaoCurta" class="label-textarea" rows="3"><?php echo $descricaoCurtaProduto;?></textarea>
                </div>
                <div class="label half">
                    <h2 class='label-title'>Descrição Longa</h2>
                    <textarea placeholder="Descrição do produto" name="descricao_longa" id="descricaoLonga" class="label-input" rows="5"><?php echo $descricaoLongaProduto;?></textarea>
                </div>
                <!--END LINHA 2-->
                <br class="clear">
                <br class="clear">
                <!--LINHA 3-->
                <br class="clear">
                <br class="clear">
                <!--LINHA 4-->
                <div class="medium">
                    <div class="select-categorias">
                        <h3 class="titulo">Selecione os departamentos</h3>
                        <ul class="list-categorias">
                            <?php
                                $condicaoDepartamentos = "true";
                                $totalCategorias = $pew_functions->contar_resultados($tabela_departamentos, $condicaoDepartamentos);
                                if($totalCategorias > 0){
                                    $queryCategorias = mysqli_query($conexao, "select departamento, id from $tabela_departamentos where $condicaoDepartamentos");
                                    while($departamentos = mysqli_fetch_array($queryCategorias)){
                                        $idDepartamento = $departamentos["id"];
                                        $departamento = $departamentos["departamento"];
                                        $checkedStatus = isset($selectedDepartamentos[$idDepartamento]) ? true : false;
                                        $checked = $checkedStatus == true ? "checked" : "";
                                        echo "<li class='box-categoria'><label><i class='fas fa-folder icone'></i>$departamento<input type='checkbox' value='$idDepartamento' class='check-categorias' name='departamentos[]' $checked></label>";
                                        echo "</li>";
                                    }
                                }else{
                                    echo "<div class='full'>Nenhuma categoria foi cadastrada</div>";
                                }
                            ?>
                        </ul>
                    </div>
                </div>
                <div class="medium">
                    <div class="select-categorias">
                        <h3 class="titulo">Selecione as categorias e subcategorias</h3>
                        <ul class="list-categorias">
                            <?php
                                $condicaoCategorias = "status  = 1";
                                $totalCategorias = $pew_functions->contar_resultados($tabela_categorias, $condicaoCategorias);
                                if($totalCategorias > 0){
                                    $queryCategorias = mysqli_query($conexao, "select categoria, id from $tabela_categorias where $condicaoCategorias");
                                    while($categorias = mysqli_fetch_array($queryCategorias)){
                                        $idCategoria = $categorias["id"];
                                        $categoria = $categorias["categoria"];
                                        $condicaoSubcategorias = "status = 1 and id_categoria = '$idCategoria'";
                                        $totalSubcategorias = $pew_functions->contar_resultados($tabela_subcategorias, $condicaoSubcategorias);
                                        $checkedStatus = isset($selectedCategorias[$idCategoria]) ? true : false;
                                        $checkedCategoria = $checkedStatus == true ? "checked" : "";
                                        $classeSub = $checkedStatus == true ? "list-subcategorias-active" : "";
                                        $styleSub = $checkedStatus == true ? "style='display: block;'" : "";
                                        echo "<li class='box-categoria'><label><i class='fas fa-folder icone'></i>$categoria<input type='checkbox' value='$idCategoria' class='check-categorias' name='categorias[]' $checkedCategoria></label>";
                                        if($totalSubcategorias > 0){
                                            echo "<ul class='list-subcategorias $classeSub' $styleSub>";
                                            $querySubcategorias = mysqli_query($conexao, "select subcategoria, id, ref from $tabela_subcategorias where $condicaoSubcategorias");
                                            while($subcategorias = mysqli_fetch_array($querySubcategorias)){
                                                $idSubcategoria = $subcategorias["id"];
                                                $subcategoria = $subcategorias["subcategoria"];
                                                $refSubcategoria = $subcategorias["ref"];
                                                $checkedSub = isset($selectedSubcategorias[$idSubcategoria]) == true ? "checked" : "";
                                                echo "<li class='box-subcategoria'><label><i class='fas fa-folder icone'></i> $subcategoria<input type='checkbox' value='$refSubcategoria||$idCategoria' class='check-subcategorias' $checkedSub name='subcategorias[]'></label></li>";
                                            }
                                            echo "</ul>";
                                        }
                                        echo "</li>";
                                    }
                                }else{
                                    echo "<div class='full'>Nenhuma categoria foi cadastrada</div>";
                                }
                            ?>
                        </ul>
                    </div>
                </div>
                <br class="clear">
                <br class="clear">
                <!--LINHA 5-->
                <div class="half" align=right>
                    <h2 align=right>Especificações técnicas</h2>
                    <?php
                        $contarEspec = mysqli_query($conexao, "select count(id) as total from $tabela_especificacoes where status = 1");
                        $contagem = mysqli_fetch_assoc($contarEspec);
                        $totalEspec = $contagem["total"];
                        if($totalEspec > 0){
                            $queryEspecificacoes = mysqli_query($conexao, "select * from $tabela_especificacoes where status = 1 order by titulo asc");
                            echo "<div class='medium'>";
                            echo "<select id='selectEspecificacao' class='label-input'>";
                                echo "<option value=''>- Selecione -</option>";
                                while($infoEspecificacao = mysqli_fetch_array($queryEspecificacoes)){
                                    $tituloEspecificacao = $infoEspecificacao["titulo"];
                                    $idEspecificacao = $infoEspecificacao["id"];
                                    echo "<option value='$idEspecificacao'>$tituloEspecificacao</option>";
                                }
                            echo "</select>";
                            echo "</div>";
                            echo "<div class='medium'>";
                            echo "<input type='text' id='descricaoEspecificacao' class='label-input' placeholder='Descrição' form='addEspecificacao'>";
                            echo "</div>";
                            echo "<div class='medium'>";
                            echo "<a class='btn-especificacoes label-input'>Adicionar</a>";
                            echo "</div>";
                        }else{
                            echo "<h4>Nenhuma especificação foi cadastrada.</h4>";
                        }
                    ?>
                </div>
                <div class="label half" align=left>
                    <h2 class="label-title" align=left style="position: relative; top: 25px; margin-bottom: 25px;">Especificações adicionadas:</h2>
                    <div class="display-especificacoes">
                        <!--ESPECIFICACOES ADICIONADAS-->
                        <?php
                            $totalEspecificacoes = is_array($especificacoesProduto) ? count($especificacoesProduto) : 0;
                            if($totalEspecificacoes > 0 && $especificacoesProduto != null){
                                foreach($especificacoesProduto as $infoEspecificacao){
                                    $idEspec = $infoEspecificacao["id"];
                                    $tituloEspec = $infoEspecificacao["titulo"];
                                    $descricaoEspec = $infoEspecificacao["descricao"];
                                    $valueInput = $idEspec."|-|".$descricaoEspec;
                                    echo "<label class='label-especificacao'><b>$tituloEspec: </b> <input type='text' class='input-especificacao' value='$descricaoEspec'><input type='hidden' class='input-ctrl-especificacao' name='especicacao_produto[]' value='$valueInput' pew-id-especificacao='$idEspec'> <a class='btn-excluir-especificacao' title='Excluir especificação'><i class='fa fa-times' aria-hidden='true'></i></a></label>";
                                }
                            }
                        ?>
                    </div>
                </div>
                <!--END LINHA 5-->
                <br class="clear">
                <br class="clear">
                <br class="clear">
                
                <div class="label full">
                    <h2 class="label-title">Imagens do produto: (900px : 900px) OBRIGATÓRIO</h2>
                    <?php
                        $contarImagens = mysqli_query($conexao, "select count(id) as total_imagens from $tabela_imagens_produtos where id_produto = '$idProduto'");
                        $contagem = mysqli_fetch_assoc($contarImagens);
                        $maxImagens = 4;
                        $selectedImagens = 0;
                        foreach($imagensProduto as $infoImagem){
                            $selectedImagens++;
                            $idImagem = $infoImagem["id_imagem"];
                            $srcImagem = $infoImagem["src"];
                            $excludeImage = $selectedImagens > 1 ? "<br><a class='btn-excluir-imagem botao-acao' data-id-produto='$idImagem' data-acao='excluir_imagem'>Excluir imagem</a>" : "";
                            echo "<div class='file-field imagem-ativa small' id='imagem$selectedImagens' data-id-imagem='$idImagem'>";
                                echo "<div class='view'><img src='$dirImagensProdutos/$srcImagem' class='preview'></div>";
                                echo "<input type='file' name='imagem$selectedImagens' accept='image/*' title='Arquivo selecionado'>";
                                echo "<div class='legenda' style='background-color: limegreen;'>Arquivo selecionado</div><br>";
                                echo $excludeImage;
                            echo "</div>";
                        }
                        for($i = $selectedImagens + 1; $i <= $maxImagens; $i++){
                            echo "<div class='file-field small' id='imagem$i'>";
                            echo "<div class='view'><i class='fa fa-plus' aria-hidden='true'></i></div>";
                            echo "<input type='file' name='imagem$i' accept='image/*'>";
                            echo "<div class='legenda'>Selecione o arquivo</div>";
                            echo "</div>";
                        }
                        echo "<input type='hidden' name='maximo_imagens' value='$maxImagens'>";
                    ?>
                </div>
                <!--END LINHA 6-->
                <br style="clear: both;">
                <br style="clear: both;">
                <br style="clear: both;">
                <br style="clear: both;">
                <!--LINHA 7-->
                <div class="label medium" align="left">
                    <h3 class="label-title">Iframe Vídeo</h3>
                    <input type="text" class="label-input" name="url_video" placeholder="<iframe></iframe>" value="<?php echo $urlVideoProduto; ?>">
                </div>
                <br class="clear">
                <br class="clear">
                <div class="label full jc-center">
                    <div class="small">
                        <button type='button' class='btn-excluir botao-acao label-input' data-id-produto='<?php echo $idProduto; ?>' data-acao='excluir'><i class="fas fa-trash-alt"></i> Excluir produto</button>
                    </div>
                    <div class="small">
                    <?php
                        $botao = $statusProduto == 1 ? "<button type='button' class='btn-excluir botao-acao label-input' data-id-produto='$idProduto' data-acao='desativar'><i class='fas fa-power-off'></i> Desativar produto</button>" : "<button type='button' class='btn-submit botao-acao label-input' data-id-produto='$idProduto' data-acao='ativar'><i class='fas fa-power-off'></i> Ativar produto</button>";
                        echo $botao;
                    ?>
                    </div>
                    <div class="small">
                        <a href="pew-cadastra-produto.php?id_produto=<?php echo $idProduto;?>" class="btn-submit label-input" style="display: block; font-size: 18px; line-height: 40px; height: 36px;"><i class="fas fa-plus"></i> Clonar produto</a>
                    </div>
                    <div class="small">
                        <button type="submit" class="btn-submit label-input">
                            <i class="far fa-save"></i> Salvar
                        </button>
                    </div>
                </div>
                <br><br>
                <div class="full" align=center>
                    <a href="pew-produtos.php" class="link-padrao">Voltar</a>
                </div>
            </form>
        </section>
    </body>
</html>
<?php
            }else{
                echo "<h3 align='center'>Nenhum produto foi encontrado. <a href='pew-produtos.php' class='link-padrao'>Voltar.</a></h3>";
            }
?>