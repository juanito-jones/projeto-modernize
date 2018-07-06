<?php
    session_start();
    
    $thisPageURL = substr($_SERVER["REQUEST_URI"], strpos($_SERVER["REQUEST_URI"], '@pew'));
    $_POST["next_page"] = str_replace("@pew/", "", $thisPageURL);
    $_POST["invalid_levels"] = array(1, 2);
    
    require_once "@link-important-functions.php";
    require_once "@valida-sessao.php";

    $navigation_title = "Editar usuário - " . $pew_session->empresa;
    $page_title = "Editando Usuário Administrativo";
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
        <style>
            .formulario{
                width: 40%;
                text-align: left;
                float: left;
            }
            .formulario h3{
                margin: 0px;
                margin-left: 5px;
            }
            .niveis{
                width: 40%;
                margin-left: 45%;
                background-color: #fbfbfb;
                color: #333;
                border-radius: 5px;
                padding: 1%;
                text-align: left;
            }
            .niveis h2{
                margin: 0px;
            }
            .niveis h3{
                margin: 5px;
                margin-top: 10px;
                margin-bottom: 10px;
            }
            .label-submit select{
                width: 40%;
                margin-right: 10%;
            }
            .buttons{
                text-align: left;
                position: relative;
                left: 5%;
            }
        </style>
        <script>
            $(document).ready(function(){
                function validarEmail(email){
                    usuario = email.substring(0, email.indexOf("@"));
                    dominio = email.substring(email.indexOf("@")+ 1, email.length);
                    if((usuario.length >=1) && (dominio.length >=3) && (usuario.search("@")==-1) && (dominio.search("@")==-1) && (usuario.search(" ")==-1) && (dominio.search(" ")==-1) && (dominio.search(".")!=-1) && (dominio.indexOf(".") >=1) && (dominio.lastIndexOf(".") < dominio.length - 1)){
                        return true;
                    }
                    else{
                        return false;
                    }
                }
                var enviarFormulario = false;
                $("#formUpdateUsuario").on("submit", function(){
                    if(enviarFormulario == false){
                        enviarFormulario = true;
                        event.preventDefault();
                        var objUsuario = $("#usuario");
                        var objSenha = $("#newsenha");
                        var objEmail = $("#email");
                        var objNivel = $("#nivel");
                        if(objUsuario.val().length < 3){
                            mensagemAlerta("O campo usuário deve conter no mínimo 3 caracteres.", objUsuario);
                            enviarFormulario = false;
                            return false;
                        }
                        if(objSenha.val().length > 0 && objSenha.val().length < 6){
                            mensagemAlerta("O campo senha deve conter no mínimo 6 caracteres.", objSenha);
                            enviarFormulario = false;
                            return false;
                        }
                        if(validarEmail(objEmail.val()) == false){
                            mensagemAlerta("O campo e-mail deve preenchido corretamente.", objEmail);
                            enviarFormulario = false;
                            return false;
                        }
                        if(objNivel.val() == ""){
                            mensagemAlerta("Selecione um nível para o usuário.", objNivel);
                            enviarFormulario = false;
                            return false;
                        }
                        $(this).submit();
                    }
                });
                $("#btnExcluirUsuario").off().on("click", function(){
                    var idUsuario = $(this).attr("data-id-usuario");
                    function excluir(){
                        $.ajax({
                            type: "POST",
                            url: "pew-deleta-usuario.php",
                            data: {acao: "excluir", id_usuario: idUsuario},
                            error: function(){
                                mensagemAlerta("Ocorreu um erro ao excluir o usuário. Tente novamente.");
                            },
                            success: function(resposta){
                                if(resposta == "true"){
                                    mensagemAlerta("O usuário foi excluido!", false, "limegreen", "pew-usuarios.php");
                                }else{
                                    mensagemAlerta("Ocorreu um erro ao excluir o usuário. Tente novamente.");
                                }
                            }
                        });
                    }
                    mensagemConfirma("Você tem certeza que deseja excluir esse usuário?", excluir);
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
            $tabela_usuarios = $pew_db->tabela_usuarios_administrativos;
            
            $idUsuario = isset($_GET["id_usuario"]) ? (int)$_GET["id_usuario"] : 0;
            $contarUsuario = mysqli_query($conexao, "select count(id) as total_usuario from $tabela_usuarios where id = '$idUsuario'");
            $contagem = mysqli_fetch_assoc($contarUsuario);
            $totalUsuario = $contagem["total_usuario"];
            if($totalUsuario > 0){
                $queryUsuario = mysqli_query($conexao, "select * from $tabela_usuarios where id = '$idUsuario'");
                $arrayUsuario = mysqli_fetch_array($queryUsuario);
                $usuario = $arrayUsuario["usuario"];
                $email = $arrayUsuario["email"];
                $nivel = $arrayUsuario["nivel"];
        ?>
        <!--PAGE CONTENT-->
        <h1 class="titulos"><?php echo $page_title; ?><a href="pew-usuarios.php" class="btn-voltar"><i class="fa fa-arrow-left" aria-hidden="true"></i> Voltar</a></h1>
        <section class="conteudo-painel">
            <div class="formulario">
                <form action="pew-update-usuario.php" method="post" id="formUpdateUsuario">
                    <input type="hidden" name="id_usuario" value="<?php echo $idUsuario;?>">
                    <label class="label full">
                        <h3 class="label-title">Usuário</h3>
                        <input type="text" class="label-input" placeholder="Usuário" name="usuario" id="usuario" value="<?php echo $usuario;?>">
                    </label>
                    <label class="label full">
                        <h3 class="label-title">Nova Senha</h3>
                        <input type="password" class="label-input" placeholder="Senha" name="newsenha" id="newsenha">
                    </label>
                    <label class="label full">
                        <h3 class="label-title">E-mail</h3>
                        <input type="email" class="label-input" placeholder="E-mail" name="email" id="email" value="<?php echo $email;?>">
                    </label>
                    <label class="label half">
                        <h3 class="label-title">Nível</h3>
                        <select class="label-input" name="nivel" id="nivel">
                            <option value="1" <?php if($nivel == 1){ echo "selected"; } ?>>Designer</option>
                            <option value="2" <?php if($nivel == 2){ echo "selected"; } ?>>Comercial</option>
                            <option value="3" <?php if($nivel == 3){ echo "selected"; } ?>>Administrador</option>
                        </select>
                    </label>
                    <label class="label half">
                        <h3 class="label-title"><!--ESPAÇAMENTO-->&nbsp;</h3>
                        <input type="submit" value="Atualizar" class="btn-submit label-input">
                    </label>
                </form>
            </div>
            <div class="niveis">
                <h2>Níveis:</h2>
                <h3>Designer: Acesso a Banners</h3>
                <h3>Comercial: Acesso a Banners, Produtos e Categorias</h3>
                <h3>Administrador: Acesso total</h3>
            </div>
            <div class="buttons">
                <br><br>
                <a href="pew-usuarios.php" class="btn-alterar">Voltar</a>
                <a class="btn-desativar" id="btnExcluirUsuario" data-id-usuario="<?php echo $idUsuario;?>">Excluir usuário</a>
            </div>
            <br style="clear: both;">
        </section>
    </body>
</html>
<?php
            }else{
                echo "<script>window.location.href='pew-usuarios.php?msg=O usuário não foi encontrado';</script>";
            }
?>
