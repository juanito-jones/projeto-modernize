<?php

    $post_fields = array("id_produto", "nome", "marca", "descricao_curta", "descricao_longa", "url_video", "status");
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
        $idProduto = addslashes($_POST["id_produto"]);
        $nomeProduto = addslashes($_POST["nome"]);
        $marcaProduto = addslashes($_POST["marca"]);
        $descricaoCurtaProduto = addslashes($_POST["descricao_curta"]);
        $descricaoLongaProduto = addslashes($_POST["descricao_longa"]);
        $categoriasProduto = isset($_POST["categorias"]) ? $_POST["categorias"] : "";
        $especificacoes = isset($_POST["especicacao_produto"]) ? $_POST["especicacao_produto"] : "";
        $departamentosProduto = isset($_POST["departamentos"]) ? $_POST["departamentos"] : "";
        $subcategoriasProduto = isset($_POST["subcategorias"]) ? $_POST["subcategorias"] : "";
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
        $tabela_departamentos = $pew_custom_db->tabela_departamentos;
        $tabela_departamentos_produtos = $pew_custom_db->tabela_departamentos_produtos;
        $tabela_categorias_produtos = $pew_custom_db->tabela_categorias_produtos;
        $tabela_subcategorias_produtos = $pew_custom_db->tabela_subcategorias_produtos;
        $tabela_especificacoes_produtos = $pew_custom_db->tabela_especificacoes_produtos;
        
        /*END SET TABLES*/

        if($nomeProduto != ""){
            echo "<h3 align=center>Gravando dados...</h3>";
            
            mysqli_query($conexao, "update $tabela_produtos set nome = '$nomeProduto', marca = '$marcaProduto', descricao_curta = '$descricaoCurtaProduto', descricao_longa = '$descricaoLongaProduto', url_video = '$urlVideoProduto', data = '$dataAtual', status = '$statusProduto' where id = '$idProduto'");

            /*ATUALIZA DEPARTAMENTOS*/
            if($departamentosProduto != ""){
                mysqli_query($conexao, "delete from $tabela_departamentos_produtos where id_produto = '$idProduto'");
                foreach($departamentosProduto as $idDepartamento){
                    mysqli_query($conexao, "insert into $tabela_departamentos_produtos (id_produto, id_departamento) values ('$idProduto', '$idDepartamento')");
                }
            }
            /*ATUALIZA CATEGORIAS DO PRODUTO*/
            if($categoriasProduto != ""){
                $queryCategoriasAtuais = mysqli_query($conexao, "select id_categoria from $tabela_categorias_produtos where id_produto = '$idProduto'");
                while($categoriasA = mysqli_fetch_array($queryCategoriasAtuais)){
                    $idCat = $categoriasA["id_categoria"];
                    $removeCategoria = true;
                    foreach($categoriasProduto as $checkedCategoria){
                        if($checkedCategoria == $idCat){
                            $removeCategoria = false;
                        }
                    }
                    if($removeCategoria){/*Se o POST não foi enviado, desvincular categoria com produto*/
                        mysqli_query($conexao, "delete from $tabela_categorias_produtos where id_produto = '$idProduto' and id_categoria = '$idCat'");
                    }
                }
                foreach($categoriasProduto as $idCategoria){
                    $queryCategoria = mysqli_query($conexao, "select categoria from $tabela_categorias where id = '$idCategoria'");
                    $arrayCategoria = mysqli_fetch_array($queryCategoria);
                    $tituloCategoria = $arrayCategoria["categoria"];
                    $contarCategoria = mysqli_query($conexao, "select count(id) as total_categorias from $tabela_categorias_produtos where id_categoria = '$idCategoria' and id_produto = '$idProduto'");
                    $contagem = mysqli_fetch_assoc($contarCategoria);
                    if($contagem["total_categorias"] == 0){
                        mysqli_query($conexao, "insert into $tabela_categorias_produtos (id_produto, id_categoria) values ('$idProduto', '$idCategoria')");
                    }
                }
            }else{
                mysqli_query($conexao, "delete from $tabela_categorias_produtos where id_produto = '$idProduto'");
            }
            /*FIM ATUALIZA CATEGORIAS DO PRODUTO*/

            /*ATUALIZA SUBCATEGORIAS DO PRODUTO*/
            if($subcategoriasProduto != ""){
                
                mysqli_query($conexao, "delete from $tabela_subcategorias_produtos where id_produto = '$idProduto'");
                
                foreach($subcategoriasProduto as $infoSubcategoria){
                    $info = explode("||", $infoSubcategoria);
                    $refSubcategoria = $info[0];
                    $idCategoriaPrincipal = $info[1];
                    
                    $querySubcategoria = mysqli_query($conexao, "select id from $tabela_subcategorias where ref = '$refSubcategoria'");
                    $arraySubcategoria = mysqli_fetch_array($querySubcategoria);
                    $idSubcategoria = $arraySubcategoria["id"];
                    
                    $contarSubcategoria = mysqli_query($conexao, "select count(id) as total_subcategorias from $tabela_subcategorias_produtos where id_subcategoria = '$idSubcategoria' and id_produto = '$idProduto'");
                    $contagem = mysqli_fetch_assoc($contarSubcategoria);
                    
                    if($contagem["total_subcategorias"] == 0){
                        mysqli_query($conexao, "insert into $tabela_subcategorias_produtos (id_produto, id_categoria, id_subcategoria) values ('$idProduto', '$idCategoriaPrincipal', '$idSubcategoria')");
                    }
                }
            }else{
                mysqli_query($conexao, "delete from $tabela_subcategorias_produtos where id_produto = '$idProduto'");
            }
            /*FIM ATUALIZA SUBCATEGORIAS DO PRODUTO*/

            /*ATUALIZA IMAGENS DO PRODUTO*/
            $maxImagens = isset($_POST["maximo_imagens"]) && (int)$_POST["maximo_imagens"] ? (int)$_POST["maximo_imagens"] : 4;
            for($i = 1; $i <= $maxImagens; $i++){
                $posicao = $i;
                
                if(isset($_FILES["imagem$i"])){
                    $condicaoPosImagem = "id_produto = '$idProduto' and posicao = '$posicao'";
                    
                    $totalImgPosicao = $pew_functions->contar_resultados($tabela_imagens, $condicaoPosImagem);
                    $nomeIMG = $_FILES["imagem$i"]["name"];
                    if($nomeIMG != ""){
                        
                        $ext = pathinfo($_FILES["imagem$i"]["name"], PATHINFO_EXTENSION);
                        $ref = substr(md5($nomeProduto.$posicao), 0, 4);
                        $urlTitulo = $pew_functions->url_format($nomeProduto);
                        $nomeFinalImagem = $urlTitulo."-".$ref.".".$ext;
                        
                        if($totalImgPosicao > 0){
                            $queryImagem = mysqli_query($conexao, "select imagem from $tabela_imagens where $condicaoPosImagem");
                            $arrayImagem = mysqli_fetch_array($queryImagem);
                            $imagem = $arrayImagem["imagem"];
                            
                            if(file_exists($dirImagensProdutos.$imagem) && $imagem != ""){
                                unlink($dirImagensProdutos.$imagem);
                            }
                            
                            mysqli_query($conexao, "update $tabela_imagens set imagem = '$nomeFinalImagem', status = 1 where id_produto = '$idProduto' and posicao = '$posicao'");
                        }else{
                            mysqli_query($conexao, "insert into $tabela_imagens (id_produto, imagem, posicao, status) values ('$idProduto', '$nomeFinalImagem', '$posicao', 1)");
                        }
                        
                        move_uploaded_file($_FILES["imagem$i"]["tmp_name"], $dirImagensProdutos.$nomeFinalImagem);
                    }
                }
            }
            /*FIM ATUALIZA IMAGENS DO PRODUTO*/

            /*INSERE ESPECIFICAÇÕES PRODUTO*/
            if($especificacoes != ""){
                mysqli_query($conexao, "delete from $tabela_especificacoes_produtos where id_produto = '$idProduto'");
                foreach($especificacoes as $infoEspecificacao){
                    $explodeInfo = explode("|-|", $infoEspecificacao);
                    $idEspecificacao = $explodeInfo[0];
                    $descricaoEspecificacao = $explodeInfo[1];
                    mysqli_query($conexao, "insert into $tabela_especificacoes_produtos (id_especificacao, id_produto, descricao) values ('$idEspecificacao', '$idProduto', '$descricaoEspecificacao')");
                }
            }

            echo "<script>window.location.href='pew-edita-produto.php?msg=Produto atualizado com sucesso&msgType=success&id_produto=$idProduto';</script>";
        }else{
            echo "<script>window.location.href='pew-edita-produto.php?erro=validacao_do_produto&msg=Não foi possível atualizar o produto&msgType=error&id_produto=$idProduto';</script>";
        }
    }else{
        //print_r($invalid_fields); //Caso ocorra erro de envio de dados
        echo "<script>window.location.href='pew-produtos.php?erro=dados_enviados_insuficientes&msg=Não foi possível atualizar o produto&msgType=error&';</script>";
    }
?>
