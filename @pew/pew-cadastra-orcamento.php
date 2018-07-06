<?php
    session_start();
    
    $thisPageURL = substr($_SERVER["REQUEST_URI"], strpos($_SERVER["REQUEST_URI"], '@pew'));
    $_POST["next_page"] = str_replace("@pew/", "", $thisPageURL);
    $_POST["invalid_levels"] = array(1);
    
    require_once "@link-important-functions.php";
    require_once "@valida-sessao.php";

    $navigation_title = "Cadastrar orçamento - " . $pew_session->empresa;
    $page_title = "Cadastrar orçamento";
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
        <!--THIS PAGE CSS-->
        <style>
            .view-total-desconto{
                height: 8px;
                width: 40px;
                padding: 10px 5px 10px 5px;
            }
            .view-qtd-produto{
                position: absolute;
                height: 50px;
                top: 0px;
                right: 0px;
                padding: 0px 20px 0px 20px;
                background-color: rgba(238, 238, 238, 0.6);
            }
            .display-produtos-relacionados .lista-relacionados .label-relacionados:hover .view-qtd-produto{
                background-color: rgba(255, 255, 255, 0.6);
            }
            .ctrl-quantidade-produto{
                width: 45px;
                height: 15px;
                padding: 5px;
                background-color: #eee;
                color: #666;
                border-color: #999;
                font-size: 14px;
            }
            /*PRODUTOS RELACIONADOS CSS*/
            .btn-produtos-relacionados{
                padding: 10px;
                cursor: pointer;
                border: 1px solid #333;
                transition: .2s;
            }
            .btn-produtos-relacionados:hover{
                background-color: #fff;
            }
            .display-produtos-relacionados{
                position: fixed;
                width: 60%;
                height: 70vh;
                margin: 0 auto;
                top: 15vh;
                left: 0;
                right: 0;
                z-index: 200;
                visibility: hidden;
                opacity: 0;
                transition: .3s;
            }
            .display-produtos-relacionados .header-relacionados{
                position: relative;
                width: 100%;
                height: 10vh;
                background-color: #f78a14;
                color: #fff;
                border-radius: 6px 6px 0px 0px;
                text-align: center;
                line-height: 10vh;
                text-align: center;
                z-index: 50;
            }
            .display-produtos-relacionados .header-relacionados .title-relacionados{
                width: 26%;
                height: 10vh;
                margin: 0px;
                padding: 0px 2% 0px 2%;
                float: left;
            }
            .display-produtos-relacionados .header-relacionados .busca-relacionados{
                width: 38%;
                height: 5vh;
                font-size: 14px;
                margin: 2.5vh 1% 0px 1%;
                padding: 0px 1% 0px 1%;
                float: left;
                border: none;
            }
            .display-produtos-relacionados .header-relacionados label{
                width: 26%;
                height: 10vh;
                margin: 0px 2% 0px 0px;
                font-size: 12px;
                cursor: pointer;
            }
            .display-produtos-relacionados .header-relacionados label input{
                position: relative;
                vertical-align: middle;
                top: -1px;
                cursor: pointer;
            }
            .display-produtos-relacionados .bottom-relacionados{
                position: relative;
                width: 100%;
                height: 10vh;
                background-color: #eee;
                line-height: 10vh;
                text-align: center;
                border-radius: 0px 0px 6px 6px;
                border-top: 2px solid #dedede;
            }
            .display-produtos-relacionados .bottom-relacionados .btn-salvar-relacionados{
                background-color: limegreen;
                color: #fff;
                padding: 10px 30px 10px 30px;
                cursor: pointer;
            }
            .display-produtos-relacionados .bottom-relacionados .btn-salvar-relacionados:hover{
                background-color: green;
            }
            .display-produtos-relacionados .lista-relacionados{
                position: relative;
                height: 50vh;
                overflow-x: auto;
                padding: 0px 0px 40px 0px;
                background-color: #eee;
                transition: .2s;
                clear: both;
                z-index: 40;
            }
            .display-produtos-relacionados .lista-relacionados .loading-background{
                position: fixed;
                width: 60%;
                height: 53vh;
                line-height: 53vh;
                margin: 0 auto;
                top: 30vh;
                left: 0;
                right: 0;
                background-color: rgba(255, 255, 255, .4);
                z-index: 50;
                visibility: hidden;
                transition: .3s;
                opacity: 0;
            }
            .display-produtos-relacionados .lista-relacionados .loading-background .loading-message{
                font-size: 18px;
                text-align: center;
                color: #f78a14;
                margin: 0px;
            }
            .display-produtos-relacionados .lista-relacionados .lista-relacionados-msg{
                position: fixed;
                width: 60%;
                height: 5px;
                line-height: 5px;
                margin: -30px 0px 0px 0px;
                visibility: hidden;
                opacity: 0;
                transition: .3s;
                background-color: #eee;
                border-bottom: 1px solid #dedede;
                z-index: 40;
            }
            .display-produtos-relacionados .lista-relacionados .lista-relacionados-msg h4{
                margin: 0px;
                padding: 0px 1% 5px 1%;
            }
            .display-produtos-relacionados .lista-relacionados .lista-relacionados-msg .limpar-todos-relacionados{
                position: absolute;
                height: 30px;
                top: 0px;
                right: 12.5%;
                width: 12%;
                font-size: 14px;
                white-space: nowrap;
                text-align: center;
                visibility: hidden;
            }
            .display-produtos-relacionados .lista-relacionados .label-relacionados{
                position: relative;
                cursor: pointer;
                width: 98%;
                height: 40px;
                line-height: 40px;
                padding: 5px 1% 5px 1%;
                float: none;
                display: inline-block;
            }
            .display-produtos-relacionados .lista-relacionados .label-relacionados:hover{
                background-color: #fff;
            }
            .display-produtos-relacionados .bottom-relacionados .view-total-orcamento-selection{
                position: absolute;
                height: 10vh;
                right: 50px;
                margin: 0px;
                line-height: 10vh;
                top: 0px;
                font-weight: normal;
            }
            /*END PRODUTOS RELACIONADOS CSS*/
        </style>
        <!--FIM THIS PAGE CSS-->
        <script>
            $(document).ready(function($){
                phone_mask("#telefoneCliente");
                input_mask("#rgCliente", "99.999.999-9");
                input_mask("#cpfCliente", "999.999.999-99");
                input_mask("#cepCliente", "99999-999");

                /*PRODUTOS RELACIONADOS*/
                var botaoProdutosRelacionados = $(".btn-produtos-relacionados");
                var displayRelacionados = $(".display-produtos-relacionados");
                var background = $(".background-interatividade");
                var botaoSalvarRelacionados = $(".btn-salvar-relacionados");
                var botaoCleanRelacionados = $(".limpar-todos-relacionados");
                var barraBusca = $(".busca-relacionados");
                var checkOnlyActives = $("#checkOnlyActives");
                var listaRelacionados = $(".lista-relacionados");
                var msgListaRelacionados = $(".lista-relacionados .lista-relacionados-msg");
                var buscandoProduto = false;
                var resetingBackground = false;
                var lastSearchString = null;

                /*!IMPORTANT FUNCTIONS*/
                function isJson(str){
                    try{
                        JSON.parse(str);
                    }catch(e){
                        return false;
                    }
                    return true;
                }
                function setMessageRelacionados(str){
                    listaRelacionados.css("padding", "30px 0px 10px 0px");
                    msgListaRelacionados.children("h4").text(str);
                    msgListaRelacionados.css({
                        height: "30px",
                        lineHeight: "30px",
                        visibility: "visible",
                        opacity: "1"
                    });
                }
                function resetMessageRelacionados(){
                    listaRelacionados.css("padding", "0px 0px 40px 0px");
                    msgListaRelacionados.children("h4").text("");
                    msgListaRelacionados.css({
                        height: "5px",
                        lineHeight: "5px",
                        visibility: "hidden",
                        opacity: "0"
                    });
                }
                function resetAllInputs(){
                    var onlyActives = checkOnlyActives.prop("checked");
                    var ctrlView = 0;
                    $(".label-relacionados").each(function(){
                        var label = $(this);
                        var input = label.children("input");
                        if(onlyActives && input.prop("checked") == true){
                            label.css("display", "inline-block").removeClass("last-search");
                            ctrlView++;
                        }else if(!onlyActives){
                            label.css("display", "inline-block").removeClass("last-search");
                            ctrlView++;
                        }
                    });
                    if(onlyActives){
                        setMessageRelacionados("Resultados encontrados: "+ctrlView);
                    }else{
                        resetMessageRelacionados();
                    }
                }
                function listLastSearch(){
                    var onlyActives = checkOnlyActives.prop("checked");
                    var ctrlQtd = 0;
                    $(".label-relacionados").each(function(){
                        var label = $(this);
                        var input = label.children("input");
                        if(onlyActives && label.hasClass("last-search") && input.prop("checked") == true){
                            label.css("display", "inline-block");
                            ctrlQtd++;
                        }else if(!onlyActives && label.hasClass("last-search")){
                            label.css("display", "inline-block");
                            ctrlQtd++;
                        }
                    });
                    if(ctrlQtd > 0){
                        setMessageRelacionados("Exibindo resultados mais aproximados:");
                    }else{
                        setMessageRelacionados("Nenhum resultado foi encontrado");
                        botaoCleanRelacionados.css("visibility", "hidden");
                    }
                }
                function contarProdutosSelecionados(){
                    var contagem = 0;
                    $(".label-relacionados").each(function(){
                        var label = $(this);
                        var input = label.children("input");
                        if(input.prop("checked") == true){
                            contagem++;
                        }
                    });
                    return contagem;
                }
                function clearRelacionados(){
                    $(".label-relacionados").each(function(){
                        var label = $(this);
                        var input = label.children("input");
                        if(label.css("display") != "none"){
                            input.prop("checked", false);
                        }
                    });
                }
                /*OPEN AND CLOSE*/
                function abrirRelacionados(){
                    background.css("display", "block");
                    displayRelacionados.css({
                        visibility: "visible",
                        opacity: "1"
                    });
                    /*SEARCH TRIGGRES*/
                    barraBusca.on("keyup", function(){
                        buscarProdutos();
                    });
                    barraBusca.on("search", function(){
                        buscarProdutos();
                    });
                    /*END SEARCH TRIGGRES*/
                    /*BOTAO SOMENTE SELECIONADOS*/
                    checkOnlyActives.off().on("change", function(){
                        var checked = $(this).prop("checked");
                        var buscaAtiva = barraBusca.val().length > 0 ? true : false;
                        if(checked && !buscaAtiva){
                            var ctrlQtd = 0;
                            $(".label-relacionados").each(function(){
                                var label = $(this);
                                var input = label.children("input");
                                var qtd = label.children("input");
                                var selecionado = input.prop("checked");
                                if(!selecionado){
                                    label.css("display", "none");
                                }else{
                                    ctrlQtd++;
                                }
                            });
                            botaoCleanRelacionados.css("visibility", "visible");
                            setMessageRelacionados("Resultados encontrados: "+ctrlQtd);
                        }else if(buscaAtiva){
                            lastSearchString = null;
                            buscarProdutos();
                            if(checked){
                                botaoCleanRelacionados.css("visibility", "visible");
                            }else{
                                botaoCleanRelacionados.css("visibility", "hidden");
                            }
                        }else{
                            /*LISTA TODOS OS PRODUTOS*/
                            resetAllInputs();
                            botaoCleanRelacionados.css("visibility", "hidden");
                        }
                    });
                    /*END BOTAO SOMENTE SELECIONADOS*/
                    /*LIMPAR RELACIONADOS*/
                    botaoCleanRelacionados.off().on("click", function(){
                        clearRelacionados();
                    });
                }
                function fecharRelacionados(){
                    displayRelacionados.css({
                        visibility: "hidden",
                        opacity: "0"
                    });
                    setTimeout(function(){
                        background.css("display", "none");
                    }, 200);
                    var totalSelecionados = contarProdutosSelecionados();
                    botaoProdutosRelacionados.text("Produtos Selecionados ("+totalSelecionados+")");
                }
                /*END OPEN AND CLOSE*/
                /*END !IMPORTANT FUNCTIONS*/

                /*MAIN SEARCH FUNCTION*/
                function buscarProdutos(){
                    buscandoProduto = true;
                    var busca = barraBusca.val();
                    var loadingBackground = $(".lista-relacionados .loading-background");
                    var urlBuscaProdutos = "pew-busca-produtos.php";
                    onlyActives = checkOnlyActives.prop("checked");

                    function resetBackgroundLoading(){
                        if(!resetingBackground){
                            setInterval(function(){
                                resetingBackground = true;
                                if(!buscandoProduto){
                                    loadingBackground.css({
                                        visibility: "hidden",
                                        opacity: "0"
                                    });
                                }
                            }, 500);
                        }
                    }
                    resetBackgroundLoading();
                    if(busca.length > 0 && lastSearchString != busca){
                        lastSearchString = busca;
                        $.ajax({
                            type: "POST",
                            url: urlBuscaProdutos,
                            data: {busca: busca},
                            error: function(){
                                loadingBackground.css({
                                    visibility: "hidden",
                                    opacity: "0"
                                });
                                notificacaoPadrao("Ocorreu um erro ao busca o produto.");
                            },
                            success: function(resposta){
                                setTimeout(function(){
                                    buscandoProduto = false;
                                }, 500);
                                var selectedProdutos = [];
                                var ctrlVQtdView = 0;
                                function listarOpcoes(){
                                    $(".label-relacionados").each(function(){
                                        var label = $(this);
                                        var input = label.children("input");
                                        var inputIdProduto = input.attr("pew-id-produto");
                                        var inputChecked = input.prop("checked");
                                        var arraySearch = selectedProdutos.some(function(id){
                                            if(onlyActives){
                                                return id === inputIdProduto && inputChecked == true;
                                            }else{
                                                return id === inputIdProduto;
                                            }
                                        });
                                        if(arraySearch == false){
                                            if(onlyActives){
                                                label.css("display", "none");
                                            }else{
                                                label.css("display", "none").removeClass("last-search");
                                            }
                                        }else{
                                            ctrlVQtdView++;
                                            label.css("display", "inline-block").addClass("last-search");
                                        }
                                    });
                                    setMessageRelacionados("Resultados encontrados: "+ctrlVQtdView);
                                    if(ctrlVQtdView == 0){
                                        listLastSearch();
                                    }
                                }
                                if(resposta != "false" && isJson(resposta) == true){
                                    var jsonData = JSON.parse(resposta);
                                    var ctrlQtd = 0;
                                    jsonData.forEach(function(id_produto){
                                        selectedProdutos[ctrlQtd] = id_produto;
                                        ctrlQtd++;
                                    });
                                    listarOpcoes();
                                }else{
                                    if(onlyActives){
                                        listarOpcoes();
                                    }else{
                                        setMessageRelacionados("Exibindo resultados mais aproximados:");
                                        listLastSearch();
                                    }
                                }
                            },
                            beforeSend: function(){
                                loadingBackground.css({
                                    visibility: "visible",
                                    opacity: "1"
                                });
                            }
                        });
                    }else if(busca.length == 0){
                        resetAllInputs();
                    }
                }
                /*END MAIN SEARCH FUNCTION*/

                /*ORCAMENTO FUNCTINALITY*/
                function setPrecoOrcamento(passedPreco){
                    var viewTotalOrcamento = $(".view-total-orcamento");
                    var viewTotalOrcamentoSelection = $(".view-total-orcamento-selection span");
                    var viewTotalDesconto = $(".view-total-desconto");
                    var ctrlTotalOrcamento = $(".ctrl-total-orcamento");
                    var ctrlTotalDesconto = $(".ctrl-total-desconto");
                    var totalDesconto = viewTotalDesconto.val();
                    var descontoAtivo = false;
                    var valorTotal = 0;
                    var valorTotalSelection = 0;
                    passedPreco = typeof passedPreco != "undefined" && passedPreco.length > 0 ? passedPreco : false;
                    descontoAtivo = totalDesconto.length > 0 && totalDesconto > 0 ? true : false;

                    function somarValorProdutos(){
                        var totalSoma = 0;
                        $(".label-relacionados").each(function(){
                            var label = $(this);
                            var input = label.children(".ctrl-selection-produto");
                            var idProduto = input.attr("pew-id-produto");
                            var viewQtd = label.children(".view-qtd-produto");
                            var objQtdProdutos = viewQtd.children(".ctrl-quantidade-produto");
                            if(input.prop("checked") == true){
                                var precoProduto = input.attr("pew-preco-produto");
                                var qtdProdutos = objQtdProdutos.val();
                                qtdProdutos = qtdProdutos.length > 0 ? qtdProdutos : 1;
                                var totalPrecoProduto = precoProduto * qtdProdutos;
                                var refIdInput = idProduto+"||"+qtdProdutos;
                                totalSoma += parseFloat(totalPrecoProduto);
                                input.val(refIdInput);
                                if(!objQtdProdutos.is(":focus") && objQtdProdutos.val() == ""){
                                    objQtdProdutos.val(1);
                                }
                            }
                        });
                        return totalSoma;
                    }

                    if(passedPreco != false && ctrlTotalSelecionados == 0){
                        valorTotal = passedPreco;
                        valorTotalSelection = passedPreco;
                    }else if(contarProdutosSelecionados() > 0){
                        var valorProdutos = somarValorProdutos();
                        valorTotal = valorProdutos;
                        valorTotalSelection = valorProdutos;
                    }else{
                        valorTotal = "0.00";
                        valorTotalSelection = "0.00";
                    }
                    if(descontoAtivo){
                        totalDesconto = 1 - (totalDesconto / 100);
                        valorTotal = valorTotal * totalDesconto;
                    }else{
                        valorTotal = number_format(valorTotal, 2, ".");
                    }
                    valorTotal = number_format(valorTotal, 2, ".");
                    valorTotalSelection = number_format(valorTotalSelection, 2, ".");
                    viewTotalOrcamento.text(valorTotal);
                    viewTotalOrcamentoSelection.text(valorTotalSelection);
                    ctrlTotalOrcamento.val(valorTotal);
                    ctrlTotalDesconto.val(viewTotalDesconto.val());
                }

                setInterval(function(){
                    setPrecoOrcamento();
                }, 300);
                /*END ORCAMENTO FUNCTINALITY*/

                /*TRIGGERS*/
                botaoProdutosRelacionados.off().on("click", function(){
                    abrirRelacionados();
                });
                botaoSalvarRelacionados.off().on("click", function(){
                    fecharRelacionados();
                });
                background.off().on("click", function(){
                    fecharRelacionados();
                });
                /*END TRIGGERS*/

                /*END PRODUTOS RELACIONADOS*/

                var formCadastra = $(".formulario-cadastro-orcamento");
                var cadastrando = false;
                formCadastra.off().on("submit", function(){
                    event.preventDefault();
                    if(!cadastrando){
                        cadastrando = true;
                        var objNome = $("#nomeCliente");
                        var objTelefone = $("#telefoneCliente");
                        var objEmail = $("#emailCliente");
                        var objCpf = $("#cpfCliente");
                        var nome = objNome.val();
                        var telefone = objTelefone.val();
                        var email = objEmail.val();
                        var cpf = objCpf.val();
                        function validarCampos(){
                            if(nome.length < 2){
                                mensagemAlerta("O Campo Nome deve conter no mínimo 2 caracteres", objNome);
                                return false;
                            }
                            if(telefone.length < 14){
                                mensagemAlerta("O Campo Telefone deve conter no mínimo 14 caracteres", objTelefone);
                                return false;
                            }
                            if(!validarEmail(email)){
                                mensagemAlerta("O Campo E-mail deve ser preenchido corretamente", objEmail);
                                return false;
                            }
                            if(cpf.length < 11){
                                mensagemAlerta("O Campo CPF deve conter no mínimo 11 caracteres", objCpf);
                                return false;
                            }
                            return true;
                        }
                        if(validarCampos()){
                            formCadastra.submit();
                        }else{
                            cadastrando = false;
                        }
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
        
            // SET TABLES
            $tabela_produtos = $pew_custom_db->tabela_produtos;
            $tabela_orcamentos = $pew_custom_db->tabela_orcamentos;
            $tabela_carrinhos = $pew_custom_db->tabela_carrinhos;
        
            $nomeCliente = null;
            $telefoneCliente = null;
            $emailCliente = null;
            $cpfCliente = null;
            $desconto = 0;
            $selectedProdutos = array();
            $ctrlProdutos = 0;
        
            $quantidadesProdutos = array();
        
            if(isset($_GET["id_orcamento"]) && $pew_functions->contar_resultados($tabela_orcamentos, "id = '{$_GET["id_orcamento"]}'") > 0){
                $idOrcamento = $_GET["id_orcamento"];
                $query = mysqli_query($conexao, "select * from $tabela_orcamentos where id = '$idOrcamento'");
                $info = mysqli_fetch_array($query);
                
                $nomeCliente = $info["nome_cliente"];
                $telefoneCliente = $info["telefone_cliente"];
                $emailCliente = $info["email_cliente"];
                $cpfCliente = $info["cpf_cliente"];
                $tokenCarrinho = $info["token_carrinho"];
                $desconto = $info["porcentagem_desconto"];
                
                $queryCarrinho = mysqli_query($conexao, "select * from $tabela_carrinhos where token_carrinho = '$tokenCarrinho'");
                while($infoCarrinho = mysqli_fetch_array($queryCarrinho)){
                    $idProduto = $infoCarrinho["id_produto"];
                    $selectedProdutos[$ctrlProdutos] = $idProduto;
                    $quantidadesProdutos[$idProduto] = $infoCarrinho["quantidade_produto"];
                    $ctrlProdutos++;
                }
            }
        ?>
        <!--PAGE CONTENT-->
        <h1 class="titulos"><?php echo $page_title; ?><a href="pew-orcamentos.php" class="btn-voltar"><i class="fa fa-arrow-left" aria-hidden="true"></i> Voltar</a></h1>
        <section class="conteudo-painel">
            <form method="post" action="pew-grava-orcamento.php" class="formulario-cadastro-orcamento">
                <div class="group clear">
                    <h3 align='left' style="margin: 0px;">Informações do cliente</h3>
                    <label class="label half">
                        <h3 class="label-title" align=left>Nome</h3>
                        <input type="text" name="nome_cliente" id="nomeCliente" placeholder="Nome" class="label-input" value='<?php echo $nomeCliente; ?>'>
                    </label>
                    <label class="label half">
                        <h3 class="label-title" align=left>Telefone</h3>
                        <input type="text" name="telefone_cliente" id="telefoneCliente" placeholder="(DDD) 99999-9999" class="label-input" value='<?php echo $telefoneCliente; ?>'>
                    </label>
                    <label class="label half">
                        <h3 class="label-title" align=left>E-mail</h3>
                        <input type="text" name="email_cliente" id="emailCliente" placeholder="email@dominio.com.br" class="label-input" value='<?php echo $emailCliente; ?>'>
                    </label>
                    <label class="label small">
                        <h3 class="label-title" align=left>CPF</h3>
                        <input type="text" name="cpf_cliente" id="cpfCliente" placeholder="CPF Cliente" class="label-input" value='<?php echo $cpfCliente; ?>'>
                    </label>
                    <br style="clear: both;">
                </div>
                <div class="label small">
                    <h3>Produtos para o orçamento:</h3><br>
                    <!--PRODUTOS RELACIONADOS-->
                    <a class="btn-produtos-relacionados">Produtos Selecionados (<?php echo count($selectedProdutos); ?>)</a>
                    <div class="display-produtos-relacionados">
                        <div class="header-relacionados">
                            <h3 class="title-relacionados">Lista de produtos</h3>
                            <!--<h5 class="descricao-relacionados">Selecione os produtos relacionados</h5>-->
                            <input type="search" class="busca-relacionados" name="busca_relacionados" placeholder="Busque categoria, nome, marca, id, ou sku" form="busca_produto">
                            <label title="Listar somente os produtos que já foram selecionados"><input type="checkbox" id="checkOnlyActives"> Somente os selecionados</label>
                        </div>
                        <div class="lista-relacionados">
                            <div class="loading-background">
                                <h4 class="loading-message"><i class='fa fa-spinner fa-pulse fa-3x fa-fw'></i></h4>
                            </div>
                            <div class="lista-relacionados-msg"><h4>Exibindo todos os produtos:</h4><a class="link-padrao limpar-todos-relacionados" title="Limpar todos os produtos listados abaixo e que foram selecionados">Limpar todos</a></div>
                        <?php
                            $queryAllProdutos = mysqli_query($conexao, "select id, nome, preco from $tabela_produtos where status = 1 order by nome asc");
                            while($infoRelacionados = mysqli_fetch_array($queryAllProdutos)){
                                $idProdutoRelacionado = $infoRelacionados["id"];
                                $nomeProdutoRelacionado = $infoRelacionados["nome"];
                                $precoProduto = $infoRelacionados["preco"] != "" ? $infoRelacionados["preco"] : "0.00";
                                $precoProduto = number_format($precoProduto, 2, ".", "");
                                $search = array_search($idProdutoRelacionado, $selectedProdutos);
                                if($search !== false){
                                    $checked = "checked";
                                    $quantidade = $quantidadesProdutos[$idProdutoRelacionado];
                                }else{
                                    $checked = "";
                                    $quantidade = 1;
                                }
                                echo "<label class='label-relacionados'><input type='checkbox' name='produtos_orcamento[]' value='$idProdutoRelacionado||$quantidade' pew-id-produto='$idProdutoRelacionado' pew-preco-produto='$precoProduto' class='ctrl-selection-produto' $checked> $nomeProdutoRelacionado [R$ $precoProduto] <span class='view-qtd-produto'>QTD: <input type='number' class='ctrl-quantidade-produto' placeholder='QTD' value='$quantidade'></span></label>";
                            }
                        ?>
                        </div>
                        <div class="bottom-relacionados">
                            <a class="btn-salvar-relacionados">Salvar</a>
                            <h3 class="view-total-orcamento-selection">Total: R$ <span>0.00</span></h3>
                        </div>
                    </div>
                    <!--END PRODUTOS RELACIONADOS-->
                </div>
                <div class="label small">
                    <div class="full">
                        <h3 class='label-title'>Desconto:&nbsp; <input type="number" class="view-total-desconto label-input" value='<?php echo $desconto; ?>' max="100"> %</h3>
                    </div>
                    <div class="full">
                        <h3 class='label-title'>Total: R$ <span class="view-total-orcamento">0.00</span></h3>
                    </div>
                    <input type="hidden" class="ctrl-total-desconto" name="total_desconto" value="0">
                    <input type="hidden" class="ctrl-total-orcamento" name="total_orcamento" value="0">
                </div>
                <div class="label small clear">
                    <input type="submit" class="btn-submit label-input" value="Cadastrar">
                </div>
                <br class='clear'>
            </form>
        </section>
    </body>
</html>