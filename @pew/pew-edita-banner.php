<?php
    session_start();
    
    $thisPageURL = substr($_SERVER["REQUEST_URI"], strpos($_SERVER["REQUEST_URI"], '@pew'));
    $_POST["next_page"] = str_replace("@pew/", "", $thisPageURL);
    $_POST["invalid_levels"] = array(2);
    
    require_once "@link-important-functions.php";
    require_once "@valida-sessao.php";

    $navigation_title = "Edita Banner - " . $pew_session->empresa;
    $page_title = "Editar Banner";
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
            $(document).ready(function(){
                $(".btn-excluir").each(function(){
                    var botao = $(this);
                    var link =  botao.attr("href");
                    botao.off().on("click", function(){
                        event.preventDefault();
                        function excluir(){
                            window.location.href=link;
                        }
                        mensagemConfirma("Tem certeza que deseja excluir este banner?", excluir);
                    });
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
    ?>
    <!--PAGE CONTENT-->
    <h1 class="titulos"><?php echo $page_title; ?><a href="pew-banners.php" class="btn-voltar"><i class="fa fa-arrow-left" aria-hidden="true"></i> Voltar</a></h1>
<?php
    $tabela_banners = $pew_db->tabela_banners;
    if(isset($_GET["id_banner"])){
        $idBanner = (int)$_GET["id_banner"];
        $idBanner = is_int($idBanner) ? $idBanner : 0;
        $contarBanner = mysqli_query($conexao, "select count(id) as total_banner from $tabela_banners where id = '$idBanner'");
        $contagem = mysqli_fetch_assoc($contarBanner);
        if($contagem["total_banner"] > 0){
            $queryBanner = mysqli_query($conexao, "select * from $tabela_banners where id = '$idBanner'");
            $banner = mysqli_fetch_array($queryBanner);
            $titulo = $banner["titulo"];
            $descricao = $banner["descricao"];
            $imagem = $banner["imagem"];
            $link = $banner["link"];
?>
        <section class="conteudo-painel">
            <form method="post" action="pew-update-banner.php" enctype="multipart/form-data">
                <input type="hidden" name="id_banner" value="<?php echo $idBanner;?>">
                <input type="hidden" name="imagem_antiga" value="<?php echo $imagem;?>">
                <div class="label medium">
                    <h2 class='label-title'>Título do Banner</h2>
                    <input type="text" name="titulo" placeholder="Título" min="3" class="label-input    " value="<?php echo $titulo;?>" required>
                </div>
                <div class="label medium">
                    <h2 class='label-title'>Descrição do Banner</h2>
                    <input type="text" name="descricao" placeholder="Descrição" min="3" class="label-input  " value="<?php echo $descricao;?>" required>
                </div>
                <div class="label medium">
                    <h2 class='label-title'>Link de redirecionamento</h2>
                    <input type="text" name="link" placeholder="www.efectusweb.com.br" class="label-input   " value="<?php echo $link;?>" required>
                </div>
                <div class="half">
                    <img src="../imagens/banners/<?php echo $imagem;?>" width="100%">
                </div>
                <div class="label half">
                    <h2 class='label-title'>Selecione a imagem do banner: (1200px : 450px)</h2>
                    <input type="file" name="imagem" class="label-input ">
                </div>
                <div class="group clear">
                    <div class="label xsmall">
                        <button type="submit" class="btn-submit label-input">
                            <i class="far fa-save"></i> Salvar
                        </button>
                    </div>
                    <div class="label xsmall">
                        <a href="pew-deleta-banner.php?id_banner=<?php echo $idBanner;?>&acao=deletar" class='btn-excluir label-input'><i class="fas fa-trash-alt"></i> Excluir</a>
                    </div>
                
                </div>
            </form>
        </section>
<?php
        }else{
            echo "<center><h3>Nenhum banner foi encontrado...</h3><br><a href='pew-banners.php' class='btn-padrao'>Voltar</a></center>";
        }
    }else{
        echo "<script>window.location.href='pew-banners.php?msg=Selecione um banner para editar';</script>";
    }
?>
    </body>
</html>