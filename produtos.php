<?php
    require_once "@classe-paginas.php";

    $cls_paginas->set_titulo("Servicos");
    $cls_paginas->set_descricao("...");

    $buscarDepartamento = isset($_GET["departamento"]) ? true : false;
    $buscarCategoria = isset($_GET["categoria"]) ? true : false;
    $buscarSubcategoria = isset($_GET["subcategoria"]) ? true : false;

    $getDepartamento = $buscarDepartamento == true ? addslashes($_GET["departamento"]) : null;
    $getCategoria = $buscarCategoria == true ? addslashes($_GET["categoria"]) : null;
    $getSubcategoria = $buscarSubcategoria == true ? addslashes($_GET["subcategoria"]) : null;

    require_once "@pew/pew-system-config.php";
    require_once "@classe-produtos.php";

    $cls_produtos = new Produtos();

    if($buscarSubcategoria){
        $headInfo = $cls_produtos->get_referencias("subcategoria", "ref = '$getSubcategoria'");
        if($headInfo != false){
            $cls_paginas->set_titulo($headInfo["titulo"]);
            $cls_paginas->set_descricao($headInfo["descricao"]);
        }
    }elseif($buscarCategoria){
        $headInfo = $cls_produtos->get_referencias("categoria", "ref = '$getCategoria'");
        if($headInfo != false){
            $cls_paginas->set_titulo($headInfo["titulo"]);
            $cls_paginas->set_descricao($headInfo["descricao"]);
        }
    }elseif($buscarDepartamento){
        $headInfo = $cls_produtos->get_referencias("departamento", "ref = '$getDepartamento'");
        if($headInfo != false){
            $cls_paginas->set_titulo($headInfo["titulo"]);
            $cls_paginas->set_descricao($headInfo["descricao"]);
        }
    }

    $dirImagensDepartamento = "imagens/departamentos/";
    $bgPadrao = "background-vitrine-padrao.png";

    if($getDepartamento != null){
        $tabela_departamentos = $pew_custom_db->tabela_departamentos;
        $queryImagem = mysqli_query($conexao, "select imagem from $tabela_departamentos where ref = '$getDepartamento'");
        $infoImagem = mysqli_fetch_array($queryImagem);
        
        $imagemDepartamento = $infoImagem["imagem"];
        $imageExiste = false;
        if(file_exists(__DIR__.'/'.$dirImagensDepartamento.$imagemDepartamento) && $imagemDepartamento != ""){
            $imageExiste = true;
        }
        if(!$imageExiste){
            $backgroundVitrine = $dirImagensDepartamento.$bgPadrao;
        }else{
            $backgroundVitrine = $dirImagensDepartamento.$imagemDepartamento;
        }
        
    }else{
        $backgroundVitrine = $dirImagensDepartamento.$bgPadrao;
    }
?>

<?php 
    /*--------------------------------------------------------*/
    /*LÓGICA PARA MOSTRAR OS PRODUTOS DEPENDENDO DA BUSCA COLETADA EM CIMA*/
    /*--------------------------------------------------------*/
    $selectedProdutos = array();
    $ctrlProdutos = 0;

    function add_produto($id){
        global $selectedProdutos, $ctrlProdutos;
        if(array_search($id, $selectedProdutos) >= 0){
            $selectedProdutos[$ctrlProdutos] = $id;
            $ctrlProdutos++;
        }
    }

    $tituloVitrine = "Ocorreu um erro. Contate um administrador!";
    $descricaoVitrine = "Ocorreu um erro. Contate um administrador!";
    
    $navigationTree = "";
    $ctrlNavigation = 0;
    $urlServicoFinal = "";
    function add_navigation($titulo, $url){
        global  $navigationTree, $ctrlNavigation, $urlServicoFinal;
        
        $urlServicoFinal = $url;
        $iconArrow = "<i class='fas fa-angle-right icon'></i>";

        $titulo = mb_convert_case($titulo, MB_CASE_TITLE, "UTF-8");

        $navigationTree .= $ctrlNavigation == 0 ? "<a class='breadcrumb-item active' href='$url'>$titulo</a>" : "&nbsp/ <a href='$url'>$titulo</a>";
        $ctrlNavigation++;
    }

    add_navigation("Página inicial", "index.php");

    if($buscarSubcategoria){
        $selected = array();
        $ctrlSelected = 0;
        $selectedFinal = array();
        $ctrlSelectedFinal = 0;

        $infoVitrine = $cls_produtos->get_referencias("subcategoria", "ref = '$getSubcategoria'");
        if($infoVitrine != false){

            $tituloVitrine = $infoVitrine["titulo"];
            $descricaoVitrine = $infoVitrine["descricao"];

            if($buscarDepartamento && $buscarCategoria){
                $selectedDepartamento = $cls_produtos->search_departamentos_produtos("ref = '$getDepartamento'");
                $selectedCategoria = $cls_produtos->search_categorias_produtos("ref = '$getCategoria'");
                $selectedSubcategoria = $cls_produtos->search_subcategorias_produtos("ref = '$getSubcategoria'");
                foreach($selectedCategoria as $idProduto){
                    if(array_search($idProduto, $selectedDepartamento) >= 0 || array_search($idProduto, $selectedDepartamento) != null){
                        $selected[$ctrlSelected] = $idProduto;
                        $ctrlSelected++;
                    }
                }
                foreach($selectedSubcategoria as $idProduto){
                    if(array_search($idProduto, $selected) >= 0 || array_search($idProduto, $selected) != null){
                        $selectedFinal[$ctrlSelectedFinal] = $idProduto;
                        $ctrlSelectedFinal++;
                    }
                }

                $navInfoDepart = $cls_produtos->get_referencias("departamento", "ref = '$getDepartamento'");
                if($navInfoDepart != false){
                    add_navigation($navInfoDepart["titulo"], "produtos.php?departamento=$getDepartamento");
                }

                $navInfoCat = $cls_produtos->get_referencias("categoria", "ref = '$getCategoria'");
                if($navInfoCat != false){
                    add_navigation($navInfoCat["titulo"], "produtos.php?departamento=$getDepartamento&categoria=$getCategoria");
                }

                add_navigation($tituloVitrine, "produtos.php?departamento=$getDepartamento&categoria=$getCategoria&subcategoria=$getSubcategoria");

            }else if($buscarCategoria){
                $selectedCategoria = $cls_produtos->search_categorias_produtos("ref = '$getCategoria'");
                $selectedSubcategoria = $cls_produtos->search_subcategorias_produtos("ref = '$getSubcategoria'");

                foreach($selectedSubcategoria as $idProduto){
                    if(array_search($idProduto, $selectedCategoria) >= 0 || array_search($idProduto, $selectedCategoria) != null){
                        $selectedFinal[$ctrlSelectedFinal] = $idProduto;
                        $ctrlSelectedFinal++;
                    }
                }

                $navInfoCat = $cls_produtos->get_referencias("categoria", "ref = '$getCategoria'");
                if($navInfoCat != false){
                    add_navigation($navInfoCat["titulo"], "produtos.php?departamento=$getDepartamento&categoria=$getCategoria");
                }

                add_navigation($tituloVitrine, "categoria=$getCategoria&subcategoria=$getSubcategoria");

            }else{
                $selectedSubcategoria = $cls_produtos->search_subcategorias_produtos("ref = '$getSubcategoria'");

                foreach($selectedSubcategoria as $idProduto){
                    $selectedFinal[$ctrlSelectedFinal] = $idProduto;
                    $ctrlSelectedFinal++;
                }

                add_navigation($tituloVitrine, "subcategoria=$getSubcategoria");
            }

            foreach($selectedFinal as $id){
                add_produto($id);
            }

        }
    }else if($buscarCategoria){
        $selectedFinal = array();
        $ctrlSelectedFinal = 0;

        $infoVitrine = $cls_produtos->get_referencias("categoria", "ref = '$getCategoria'");
        $tituloVitrine = $infoVitrine["titulo"];
        $descricaoVitrine = $infoVitrine["descricao"];

        if($buscarDepartamento && $buscarCategoria){
            $selectedDepartamento = $cls_produtos->search_departamentos_produtos("ref = '$getDepartamento'");
            $selectedCategoria = $cls_produtos->search_categorias_produtos("ref = '$getCategoria'");

            foreach($selectedCategoria as $idProduto){
                if(array_search($idProduto, $selectedDepartamento) >= 0 || array_search($idProduto, $selectedDepartamento) != null){
                    $selectedFinal[$ctrlSelectedFinal] = $idProduto;
                    $ctrlSelectedFinal++;
                }
            }

            $navInfoDepart = $cls_produtos->get_referencias("departamento", "ref = '$getDepartamento'");
            if($navInfoDepart != false){
                add_navigation($navInfoDepart["titulo"], "produtos.php?departamento=$getDepartamento");
            }

            add_navigation($tituloVitrine, "produtos.php?departamento=$getDepartamento&categoria=$getCategoria");

        }else{
            $selectedCategoria = $cls_produtos->search_categorias_produtos("ref = '$getCategoria'");
            foreach($selectedCategoria as $idProduto){
                $selectedFinal[$ctrlSelectedFinal] = $idProduto;
                $ctrlSelectedFinal++;
            }

            add_navigation($tituloVitrine, "categoria=$getCategoria");
        }
        foreach($selectedFinal as $id){
            add_produto($id);
        }
    }else if($buscarDepartamento){
        $selected = array();
        $ctrlSelected = 0;
        $selectedFinal = array();
        $ctrlSelectedFinal = 0;
        $infoVitrine = $cls_produtos->get_referencias("departamento", "ref = '$getDepartamento'");
        $tituloVitrine = $infoVitrine["titulo"];
        $descricaoVitrine = $infoVitrine["descricao"];

        $selectedDepartamento = $cls_produtos->search_departamentos_produtos("ref = '$getDepartamento'");

        foreach($selectedDepartamento as $idProduto){
            $selectedFinal[$ctrlSelectedFinal] = $idProduto;
            $ctrlSelectedFinal++;
        }

        add_navigation($tituloVitrine, "produtos.php?departamento=$getDepartamento");

        foreach($selectedFinal as $id){
            add_produto($id);
        }
    }else if(isset($_GET["busca"])){
        $busca = addslashes($_GET["busca"]);
        $tituloVitrine = "Exibindo resultados para: " . $busca;
        $selectedProdutos = $cls_produtos->buscar($busca);
        $totalResultados = count($selectedProdutos);
        $descricaoVitrine = "Foram encontrados <b>$totalResultados resultados</b>";
    }
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
			include "includes/box-breadcrumb-servicos.php";
            include "includes/box-servicos4.php";
            include "includes/footer.php";
		?>
    </body>
        <?php require_once "@link-standard-js.php"; ?>
</html>
