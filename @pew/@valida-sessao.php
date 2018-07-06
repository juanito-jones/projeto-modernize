<?php
    $loginPage = "index.php?msg=Área restrita, faça login para continuar.";
    $nextPage = isset($_POST["next_page"]) ? addslashes($_POST["next_page"]) : null;
    $next = $nextPage != null ? "&next=$nextPage" : null;

    if(isset($_SESSION["pew_session"])){
        require_once "pew-system-config.php";
        $sessionUsuario = $_SESSION["pew_session"]["usuario"];
        $sessionSenha = $_SESSION["pew_session"]["senha"];
        $sessionNivel = $_SESSION["pew_session"]["nivel"];
        $sessionEmpresa = $_SESSION["pew_session"]["empresa"];
        $pew_session = new Pew_Session($sessionUsuario, $sessionSenha, $sessionNivel, $sessionEmpresa);
        if(!$pew_session->auth() == true){
            echo "<script>window.location.href = '$loginPage$next';</script>";
        }else{
            if(isset($_POST["invalid_levels"])){
                $invalid_levels = $_POST["invalid_levels"];
                if(is_array($invalid_levels) && count($invalid_levels) > 0){
                    foreach($invalid_levels as $nivel){
                        if(in_array($sessionNivel, $invalid_levels)){
                            $block_level = true;
                        }
                    }
                }
            }
        }
    }else{
        echo "<script>window.location.href = '$loginPage$next';</script>";
    }
?>