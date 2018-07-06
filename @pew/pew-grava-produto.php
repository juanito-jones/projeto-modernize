<?php
    $post_fields = array("nome", "descricao_curta", "descricao_longa", "url_video", "status");
    $file_fields = array();
    $invalid_fields = array();
    $gravar = true;
    $i = 0;
    foreach($post_fields as $post_name){
        /*Validação se todos campos foram enviados*/
        if(!isset($_POST[$post_name])){
            $gravar = false;
            $i++;
            $invalid_fields[$i] = $post_name;
        }
    }
    foreach($file_fields as $file_name){
        /*Validação se todos campos foram enviados*/
        if(!isset($_FILES[$file_name])){
            $gravar = false;
            $i++;
            $invalid_fields[$i] = $file_name;
        }
    }
    if($gravar){
        require_once "pew-system-config.php";
        require_once "@classe-system-functions.php";
        
        $dataAtual = date("Y-m-d h:i:s");
        /*POST DATA*/
        $nomeProduto = addslashes($_POST["nome"]);
        $marcaProduto = addslashes($_POST["marca"]);
        $descricaoCurtaProduto = addslashes($_POST["descricao_curta"]);
        $descricaoLongaProduto = addslashes($_POST["descricao_longa"]);
        $departamentosProdutos = isset($_POST["departamentos"]) ? $_POST["departamentos"] : "";
        $categoriasProduto = isset($_POST["categorias"]) ? $_POST["categorias"] : "";
        $subcategoriasProduto = isset($_POST["subcategorias"]) ? $_POST["subcategorias"] : "";
        $especificacoes = isset($_POST["especicacao_produto"]) ? $_POST["especicacao_produto"] : "";
        $statusProduto = intval($_POST["status"]) == 1 ? 1 : 0;
        $urlVideoProduto = addslashes($_POST["url_video"]);
        
        $http = substr($urlVideoProduto, 0, 5);
        if($http != "http:" && $http != "https" && $urlVideoProduto != ""){
            $urlVideoProduto = "http://".$urlVideoProduto;
        }
        /*END POST DATA*/

        /*DIR VARS*/
        $dirImagensProdutos = "../imagens/produtos/";
        /*END DIR VARS*/

        /*SET TABLES*/
        $tabela_produtos = $pew_custom_db->tabela_produtos;
        $tabela_imagens = $pew_custom_db->tabela_imagens_produtos;
        $tabela_categorias = $pew_db->tabela_categorias;
        $tabela_subcategorias = $pew_db->tabela_subcategorias;
        $tabela_departamentos_produtos = $pew_custom_db->tabela_departamentos_produtos;
        $tabela_categorias_produtos = $pew_custom_db->tabela_categorias_produtos;
        $tabela_subcategorias_produtos = $pew_custom_db->tabela_subcategorias_produtos;
        $tabela_especificacoes_produtos = $pew_custom_db->tabela_especificacoes_produtos;
        /*END SET TABLES*/

        /*VALIDACOES E SQL FUNCTIONS*/
        if($nomeProduto != ""){
            echo "<h3 align=center>Gravando dados...</h3>";
            
            /*INSERE DADOS PRODUTO*/
            mysqli_query($conexao, "insert into $tabela_produtos (nome, marca, descricao_curta, descricao_longa, url_video, data, status) values ('$nomeProduto', '$marcaProduto', '$descricaoCurtaProduto', '$descricaoLongaProduto', '$urlVideoProduto', '$dataAtual', '$statusProduto')");

            /*PEGA ID PRODUTO INSERIDO*/
            $queryID = mysqli_query($conexao, "select last_insert_id()");
            $idProduto = mysqli_fetch_assoc($queryID);
            $idProduto = $idProduto["last_insert_id()"];

            /*INSERE DEPARTAMENTOS*/
            if($departamentosProdutos != ""){
                foreach($departamentosProdutos as $idDepartamento){
                    mysqli_query($conexao, "insert into $tabela_departamentos_produtos (id_produto, id_departamento) values ('$idProduto', '$idDepartamento')");
                }
            }
            /*INSERE CATEGORIAS*/
            if($categoriasProduto != ""){
                foreach($categoriasProduto as $idCategoria){
                    mysqli_query($conexao, "insert into $tabela_categorias_produtos (id_produto, id_categoria) values ('$idProduto', '$idCategoria')");
                }
            }
            /*INSERE SUBCATEGORIAS*/
            if($subcategoriasProduto != ""){
                foreach($subcategoriasProduto as $infoSubcategoria){
                    $info = explode("||", $infoSubcategoria);
                    $refSubcategoria = addslashes($info[0]);
                    $idCategoriaPrincipal = $info[1];
                    $querySubcategoria = mysqli_query($conexao, "select id from $tabela_subcategorias where ref = '$refSubcategoria'");
                    $arraySubcategoria = mysqli_fetch_array($querySubcategoria);
                    $idSubcategoria = $arraySubcategoria["id"];
                    mysqli_query($conexao, "insert into $tabela_subcategorias_produtos (id_produto, id_categoria, id_subcategoria) values ('$idProduto', '$idCategoriaPrincipal', '$idSubcategoria')");
                }
            }
            /*INSERE ESPECIFICAÇÕES PRODUTO*/
            if($especificacoes != ""){
                foreach($especificacoes as $infoEspecificacao){
                    $explodeInfo = explode("|-|", $infoEspecificacao);
                    $idEspecificacao = $explodeInfo[0];
                    $descricaoEspecificacao = $explodeInfo[1];
                    mysqli_query($conexao, "insert into $tabela_especificacoes_produtos (id_especificacao, id_produto, descricao) values ('$idEspecificacao', '$idProduto', '$descricaoEspecificacao')");
                }
            }
                        
            /*INSERE IMAGENS*/
            $maxImagens = isset($_POST["maximo_imagens"]) && (int)$_POST["maximo_imagens"] ? (int)$_POST["maximo_imagens"] : 4;
            for($i = 1; $i <= $maxImagens; $i++){
                $posicaoAnterior = $i - 1;                
                $condicaoImagem = "id_produto = '$idProduto' and posicao = '$posicaoAnterior'";
                $totalImagem = $pew_functions->contar_resultados($tabela_imagens, $condicaoImagem);
                
                if($totalImagem == 0 && $posicaoAnterior > 0){
                    $posicao = $posicaoAnterior;
                }else{
                    $posicao = $i;
                }
                
                if(isset($_FILES["imagem$i"])){
                    $nomeIMG = $_FILES["imagem$i"]["name"];
                    if($nomeIMG != ""){
                        $ext = pathinfo($_FILES["imagem$i"]["name"], PATHINFO_EXTENSION);
                        $ref = substr(md5($nomeProduto.$posicao), 0, 4);
                        $urlTitulo = $pew_functions->url_format($nomeProduto);
                        $nomeFinalImagem = $urlTitulo."-".$ref.".".$ext;
                        
                        move_uploaded_file($_FILES["imagem$i"]["tmp_name"], $dirImagensProdutos.$nomeFinalImagem);
                        
                        mysqli_query($conexao, "insert into $tabela_imagens (id_produto, imagem, posicao, status) values ('$idProduto', '$nomeFinalImagem', '$posicao', 1)");
                    }
                }
            }
            echo "<script>window.location.href='pew-produtos.php?msg=Produto cadastrado com sucesso&msgType=success';</script>";
        }else{
            //Erro de validação = Nome do produto vazio
            echo "<script>window.location.href='pew-produtos.php?erro=validação_do_produto&msg=Ocorreu um erro ao cadastrar o produto&msgType=error';</script>";
        }
        /*END VALIDACOES E SQL FUNCTIONS*/
    }else{
        //print_r($invalid_fields); //Caso ocorra erro de envio de dados
        echo "<script>window.location.href='pew-produtos.php?erro=dados_enviados_insuficientes&msg=Ocorreu um erro ao cadastrar o produto&msgType=error';</script>";
    }
?>