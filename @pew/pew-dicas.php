<?php
    session_start();
    
    $thisPageURL = substr($_SERVER["REQUEST_URI"], strpos($_SERVER["REQUEST_URI"], '@pew'));
    $_POST["next_page"] = str_replace("@pew/", "", $thisPageURL);
    $_POST["invalid_levels"] = array(1);
    
    require_once "@link-important-functions.php";
    require_once "@valida-sessao.php";

    $navigation_title = "Dicas - " . $pew_session->empresa;
    $page_title = "Gerenciamento de dicas";
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
        <h1 class="titulos"><?php echo $page_title; ?></h1>
        <section class="conteudo-painel">
            <div class="group clear">
                <form action="pew-dicas.php" method="get" class="label half clear">
                    <label class="group">
                        <div class="group">
                            <h3 class="label-title">Busca de dicas</h3>
                        </div>
                        <div class="group">
                            <div class="xlarge" style="margin-left: -5px; margin-right: 0px;">
                                <input type="search" name="busca" placeholder="Titulo, subtitulo ou descrição curta" class="label-input" title="Buscar">
                            </div>
                            <div class="xsmall" style="margin-left: 0px;">
                                <button type="submit" class="btn-submit label-input btn-flat" style="margin: 10px;">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </label>
                </form>
                <div class="label half jc-left">
                    <div class="full">
                        <h4 class="subtitulos" align=left>Mais funções</h4>
                    </div>
                    <div class="label full">
                        <a href="pew-cadastra-dica.php" class="btn-padrao btn-flat" title="Cadastre uma novo dica"><i class="fas fa-plus"></i> Cadastrar dica</a>
                    </div>
                </div>
            </div>
            <table class="table-padrao group clear" cellspacing="0">
            <?php
                $tabela_dicas = $pew_custom_db->tabela_dicas;
                if(isset($_GET["busca"]) && $_GET["busca"] != ""){
                    $busca = $pew_functions->sqli_format($_GET["busca"]);
                    $strBusca = "where titulo like '%{$busca}%' or subtitulo like '%{$busca}%' or descricao_curta like '%{$busca}%'";
                    echo "<div class='full clear'><h3>Exibindo resultados para: $busca</h3></div>";
                }else{
                    $strBusca = "";
                }
                $contarDicas = mysqli_query($conexao, "select count(id) as total from $tabela_dicas");
                $contagemDicas = mysqli_fetch_assoc($contarDicas);
                $totalDicas = $contagemDicas["total"];
                if($totalDicas > 0){
                    echo "<thead>";
                        echo "<td>Titulo</td>";
                        echo "<td>Sub-titulo</td>";
                        echo "<td>Descricao curta</td>";
                        echo "<td>Data Controle</td>";
                        echo "<td>Status</td>";
                        echo "<td>Informações</td>";
                    echo "</thead>";
                    echo "<tbody>";
                    $queryDicas = mysqli_query($conexao, "select * from $tabela_dicas $strBusca order by data_controle desc");
                    while($dica = mysqli_fetch_array($queryDicas)){
                        $id = $dica["id"];
                        $titulo = $dica["titulo"];
                        $subtitulo = $dica["subtitulo"];
                        $descricaoCurta = $dica["descricao_curta"];
                        $dataControle = $dica["data_controle"];
                        $status = $dica["status"];
                        switch($status){
                            case 1:
                                $status = "Manter contato";
                                break;
                            case 2:
                                $status = "Finalizado";
                                break;
                            case 3:
                                $status = "Cancelado";
                                break;
                            default:
                                $status = "Fazer primeiro contato";
                        }
                        echo "<tr><td>$titulo</td>";
                        echo "<td>$subtitulo</td>";
                        echo "<td>$descricaoCurta</td>";
                        echo "<td>$dataControle</td>";
                        echo "<td>$status</td>";
                        echo "<td align=center><a href='pew-edita-dica.php?id_dica=$id' class='btn-editar'><i class='fa fa-eye' aria-hidden='true'></i></a></td></tr>";
                    }
                    echo "</tbody></table>";
                }else{
                    $msg = $strBusca != "" ? "Nenhum resultado encontrado. <a href='pew-dicas.php' class='link-padrao'><b>Voltar<b></a>" : "Nenhum pedido foi enviado ainda.";
                    echo "<br><br><br><br><br><h3 align='center'>$msg</h3></td>";
                }
            ?>
            </table>
        </section>
    </body>
</html>
