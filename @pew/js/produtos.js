$(document).ready(function(){
    /*STATUS AND FUNCTION BUTTONS*/
    $(".btn-status-produto").off().on("click", function(){
        var botao = $(this);
        var idProduto = botao.attr("data-produto-id");
        var viewStatusProd = $("#boxProduto"+idProduto+" #viewStatusProd");
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
                        if(resposta == "true"){
                            var resultado = acao == "ativar" ? "ativado" : "desativado";
                            notificacaoPadrao("O Produto foi "+resultado+"!", "success", 5000);
                            if(resultado == "ativado"){
                                botao.addClass("btn-desativar").removeClass("btn-ativar").text("Desativar");
                                botao.attr("data-acao", "desativar");
                                viewStatusProd.text("Ativo");
                            }else{
                                botao.addClass("btn-ativar").removeClass("btn-desativar").text("Ativar");
                                botao.attr("data-acao", "ativar");
                                viewStatusProd.text("Desativado");
                            }
                        }else{
                            notificacaoPadrao("Não foi possível "+resultado+" o produto", "error", 5000);
                        }
                    }, 500);
                }
            });
        }
        mensagemConfirma("Tem certeza que deseja "+acao+" este produto?", statusProduto);
    });
    /*END STATUS AND FUNCTION BUTTONS*/
    /*END COLOR SELECT FUNCTION*/

    /*PREVIEW SELECT IMAGE FILE*/
    function previewFile(input, target, legenda){
        var loadingGIF = "imagens/estrutura/loading.gif";
        target.html("<img src='"+loadingGIF+"' class='loading'>");
        if(input.files && input.files[0]){
            var reader = new FileReader();
            reader.onload = function (e) {
                var dir = e.target.result;
                target.html("<img src='"+dir+"' class='preview'>");
                legenda.text("Arquivo selecionado").css("background-color", "limegreen");
            };
            reader.readAsDataURL(input.files[0]);
        }
        else{
            target.html("<i class='fa fa-plus' aria-hidden='true'></i>");
        }
    }
    $(".file-field").each(function(){
        var id = $(this).prop("id");
        $("#"+id+" input").off().on("change", function(){
            var input = this;
            var valor = $(this).val();
            var legenda = $("#"+id+" .legenda");
            var target = $("#"+id+" .view");
            setTimeout(function(){
                previewFile(input, target, legenda);
                if(valor != ""){
                    legenda.text("Arquivo selecionado").css("background-color", "limegreen");
                }else{
                    legenda.text("Selecione o arquivo").css("background-color", "#111");
                }
            }, 200);
        });
    });
    /*END PREVIEW SELECT IMAGE FILE*/

    /*VALIDAÇÕES CADASTRA E EDIÇÃO PRODUTO*/

    /*CADASTRO DE PRODUTO*/
    var cadastrandoProduto = false;
    $("#formCadastraProduto").off().on("submit", function(event){
        event.preventDefault();
        var formCadastraProduto = $(this);
        if(cadastrandoProduto == false){
            cadastrandoProduto = true;
            /*SET REQUIRED INPUTS*/
            var objNome = $("#formCadastraProduto #nome");
            var objDescricaoCurta = $("#formCadastraProduto #descricaoCurta");
            var objDescricaoLonga = CKEDITOR.instances["descricaoLonga"];
            var objImagemPrincipal = $("#formCadastraProduto #imagemPrincipal");
            var nome = objNome.val();
            var descricaoCurta = objDescricaoCurta.val();
            var descricaoLonga = objDescricaoLonga.getData();
            var imagemPrincipal = objImagemPrincipal.val();
            /*END SET REQUIRED INPUTS*/
            
            function enviarFormulario(){
                formCadastraProduto.unbind("submit").submit();
            }

            function validaCampos(){
                function validaPadrao(){
                    if(nome.length <= 6){
                        mensagemAlerta("O campo Nome do Produto deve conter no mínimo 6 caracteres.", objNome);
                        return false;
                    }
                    if(descricaoCurta.length <= 20){
                        mensagemAlerta("O campo Descricao Curta deve conter no mínimo 20 caracteres.", objDescricaoCurta);
                        return false;
                    }
                    if($(descricaoLonga).text().length <= 40){
                        mensagemAlerta("O campo Descricao Longa deve conter no mínimo 40 caracteres.", objDescricaoLonga);
                        return false;
                    }
                    if(imagemPrincipal == ""){
                        mensagemAlerta("Selecione uma imagem para o produto.", objImagemPrincipal);
                        return false;
                    }
                    
                    enviarFormulario();
                }
                
                function validaDadosDuplicados(){
                    var tabela_produtos = "pew_produtos";
                    var urlBuscaProdutos = "pew-busca-produtos.php";
                    var validarCampos = ["nome"];
                    var validandoCampo = null;
                    var camposValidados = [];
                    var totalCampos = validarCampos.length;
                    var ctrlValidados = 0;
                    var refreshRate = 100;

                    function isJson(str){
                        try{
                            JSON.parse(str);
                        }catch(e){
                            return false;
                        }
                        return true;
                    }

                    var buscando = false;
                    function busca(table, condition, inputID, msg){
                        var duplicado = false;
                        buscando = true;
                        $.ajax({
                            type: "POST",
                            url: urlBuscaProdutos,
                            data: {custom_table: table, busca: condition},
                            error: function(){
                                loadingBackground.css({
                                    visibility: "hidden",
                                    opacity: "0"
                                });
                                notificacaoPadrao("Ocorreu um erro ao buscar o produto.");
                                buscando = false;
                            },
                            success: function(resposta){
                                if(resposta != "false" && isJson(resposta) == true){
                                    var jsonData = JSON.parse(resposta);
                                    var ctrlQtd = 0;
                                    var selectedId = [];
                                    jsonData.forEach(function(id_produto){
                                        selectedId[ctrlQtd] = id_produto;
                                        ctrlQtd++;
                                    });
                                    if(ctrlQtd > 0){
                                        duplicado = true;
                                    }else{
                                        duplicado = false;
                                    }
                                }else{
                                    duplicado = false;
                                }
                                buscando = false;
                            }
                        });
                        var validaBusca = setInterval(function(){
                            function finishField(msg, objInput){
                                mensagemAlerta(msg, objInput);
                                camposValidados[ctrlValidados] = false;
                                validandoCampo = null;
                                ctrlValidados++;
                            }
                            
                            if(!buscando){
                                clearInterval(validaBusca);
                                if(duplicado){
                                    switch(inputID){
                                        case "nome":
                                            finishField(msg, objNome);
                                            break;
                                    }
                                }else{
                                    camposValidados[ctrlValidados] = true;
                                    validandoCampo = null;
                                    ctrlValidados++;
                                }
                            }
                        }, 1);
                    }
                    var validacao = setInterval(function(){
                        var i = 0;
                        validarCampos.forEach(function(field){
                            if(validandoCampo == null && ctrlValidados < totalCampos && typeof camposValidados[i] == "undefined"){
                                validandoCampo = field;
                                camposValidados[i] = "running";
                                switch(field){
                                    case "nome":
                                        busca(tabela_produtos, "nome = '" + nome + "'", "nome", "Já existe um produto com este nome cadastrado");
                                        break;
                                }
                            }
                            i++;
                        });
                        if(ctrlValidados == totalCampos){
                            var retorno = true;
                            camposValidados.forEach(function(valor){
                                retorno = valor == false ? false : retorno;
                            });
                            
                            clearInterval(validacao);
                            
                            if(retorno == true){
                                if(validaPadrao() == false){
                                    cadastrandoProduto = false;   
                                }
                            }else{
                                cadastrandoProduto = false;
                            }
                        }
                    }, refreshRate);
                }
                
                validaDadosDuplicados(); // Irá dar o callback para a seguinte validação se retorno = true
                notificacaoPadrao("Validando dados...", "success", 800);
            }
            
            validaCampos();
        }
    });
    /*END CADASTRO DE PRODUTO*/


    /*EDIÇÃO DE PRODUTO*/
    var atualizandoProduto = false;
    $("#formAtualizaProduto").off().on("submit", function(event){
        event.preventDefault();
        var formAtualizaProduto = $(this);
        if(atualizandoProduto == false){
            atualizandoProduto = true;
            /*SET REQUIRED INPUTS*/
            var objIdProduto = $("#formAtualizaProduto #idProduto");
            var objNome = $("#formAtualizaProduto #nome");
            var objDescricaoCurta = $("#formAtualizaProduto #descricaoCurta");
            var objDescricaoLonga = CKEDITOR.instances["descricaoLonga"];
            var objImagemPrincipal = $("#formAtualizaProduto #imagemPrincipal");
            var idProduto = objIdProduto.val();
            var nome = objNome.val();
            var descricaoCurta = objDescricaoCurta.val();
            var descricaoLonga = objDescricaoLonga.getData();
            var imagemPrincipal = objImagemPrincipal.val();
            /*END SET REQUIRED INPUTS*/
            
            function enviarFormulario(){
                formAtualizaProduto.unbind("submit").submit();
            }

            function validaCampos(){
                function validaPadrao(){
                    if(nome.length <= 6){
                        mensagemAlerta("O campo Nome do Produto deve conter no mínimo 6 caracteres.", objNome);
                        return false;
                    }
                    if(descricaoCurta.length <= 20){
                        mensagemAlerta("O campo Descricao Curta deve conter no mínimo 20 caracteres.", objDescricaoCurta);
                        return false;
                    }
                    if($(descricaoLonga).text().length <= 40){
                        mensagemAlerta("O campo Descricao Longa deve conter no mínimo 40 caracteres.", objDescricaoLonga);
                        return false;
                    }
                    if(imagemPrincipal == ""){
                        mensagemAlerta("Selecione uma imagem para o produto.", objImagemPrincipal);
                        return false;
                    }
                    
                    enviarFormulario();
                }
                
                function validaDadosDuplicados(){
                    var tabela_produtos = "pew_produtos";
                    var urlBuscaProdutos = "pew-busca-produtos.php";
                    var validarCampos = ["nome"];
                    var validandoCampo = null;
                    var camposValidados = [];
                    var totalCampos = validarCampos.length;
                    var ctrlValidados = 0;
                    var refreshRate = 100;

                    function isJson(str){
                        try{
                            JSON.parse(str);
                        }catch(e){
                            return false;
                        }
                        return true;
                    }

                    var buscando = false;
                    function busca(table, condition, inputID, msg){
                        var duplicado = false;
                        buscando = true;
                        $.ajax({
                            type: "POST",
                            url: urlBuscaProdutos,
                            data: {custom_table: table, busca: condition},
                            error: function(){
                                loadingBackground.css({
                                    visibility: "hidden",
                                    opacity: "0"
                                });
                                notificacaoPadrao("Ocorreu um erro ao buscar o produto.");
                                buscando = false;
                            },
                            success: function(resposta){
                                if(resposta != "false" && isJson(resposta) == true){
                                    var jsonData = JSON.parse(resposta);
                                    var ctrlQtd = 0;
                                    var selectedId = [];
                                    jsonData.forEach(function(id_produto){
                                        selectedId[ctrlQtd] = id_produto;
                                        ctrlQtd++;
                                    });
                                    if(ctrlQtd > 0){
                                        duplicado = true;
                                    }else{
                                        duplicado = false;
                                    }
                                }else{
                                    duplicado = false;
                                }
                                buscando = false;
                            }
                        });
                        var validaBusca = setInterval(function(){
                            function finishField(msg, objInput){
                                mensagemAlerta(msg, objInput);
                                camposValidados[ctrlValidados] = false;
                                validandoCampo = null;
                                ctrlValidados++;
                            }
                            
                            if(!buscando){
                                clearInterval(validaBusca);
                                if(duplicado){
                                    switch(inputID){
                                        case "nome":
                                            finishField(msg, objNome);
                                            break;
                                    }
                                }else{
                                    camposValidados[ctrlValidados] = true;
                                    validandoCampo = null;
                                    ctrlValidados++;
                                }
                            }
                        }, 1);
                    }
                    var validacao = setInterval(function(){
                        var i = 0;
                        validarCampos.forEach(function(field){
                            if(validandoCampo == null && ctrlValidados < totalCampos && typeof camposValidados[i] == "undefined"){
                                validandoCampo = field;
                                camposValidados[i] = "running";
                                switch(field){
                                    case "nome":
                                        busca(tabela_produtos, "nome = '" + nome + "' and id != '" + idProduto + "'", "nome", "Já existe um produto com este nome cadastrado");
                                        break;
                                }
                            }
                            i++;
                        });
                        if(ctrlValidados == totalCampos){
                            var retorno = true;
                            camposValidados.forEach(function(valor){
                                retorno = valor == false ? false : retorno;
                            });
                            
                            clearInterval(validacao);
                            if(retorno == true){
                                if(validaPadrao() == false){
                                    atualizandoProduto = false;   
                                }
                            }else{
                                atualizandoProduto = false;
                            }
                        }
                    }, refreshRate);
                }
                
                validaDadosDuplicados(); // Irá dar o callback para a seguinte validação se retorno = true
                notificacaoPadrao("Validando dados...", "success", 800);
            }
            
            validaCampos();
        }
    });
    /*END EDIÇÃO DE PRODUTO*/
});
