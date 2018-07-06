<?php
    require_once "@include-global-vars.php";

    $diretorioAPI = isset($_POST["diretorio"]) ? str_replace(" ", "", $_POST["diretorio"]) : "../";

    class Pedidos{
        private $id = 0;
        private $codigo_confirmacao = null;
        private $codigo_transacao = null;
        private $codigo_transporte = null;
        private $codigo_pagamento = null;
        private $referencia = null;
        private $token_carrinho = null;
        private $id_cliente = 0;
        private $nome_cliente = null;
        private $cpf_cliente = null;
        private $email_cliente = null;
        private $cep = null;
        private $rua = null;
        private $numero = 0;
        private $complemento = null;
        private $bairro = null;
        private $cidade = "Curitiba";
        private $estado = "PR";
        private $valor_total = 0;
        private $data_controle;
        private $status_transporte = 0;
        private $status = 0;
        public $valor_frete = 0;
        public $codigo_rastreamento = 0;
        public $global_vars;
        public $pew_functions;
        
        function __construct(){
            global $globalVars, $pew_functions;
            $this->global_vars = $globalVars;
            $this->pew_functions = $pew_functions;            
        }
        
        function montar($id){
            $conexao = $this->global_vars["conexao"];
            $tabela_pedidos = $this->global_vars["tabela_pedidos"];
            $tabela_carrinhos = $this->global_vars["tabela_carrinhos"];
            $total = $this->pew_functions->contar_resultados($tabela_pedidos, "id = '$id'");
            if($total > 0){
                $query = mysqli_query($conexao, "select * from $tabela_pedidos where id = '$id'");
                $info = mysqli_fetch_array($query);
                $this->id = $info["id"];
                $this->codigo_confirmacao = $info["codigo_confirmacao"];
                $this->codigo_transacao = $info["codigo_transacao"];
                $this->codigo_transporte = $info["codigo_transporte"];
                $this->codigo_pagamento = $info["codigo_pagamento"];
                $this->referencia = $info["referencia"];
                $this->token_carrinho = $info["token_carrinho"];
                $this->id_cliente = $info["id_cliente"];
                $this->nome_cliente = $info["nome_cliente"];
                $this->cpf_cliente = $info["cpf_cliente"];
                $this->email_cliente = $info["email_cliente"];
                $this->cep = $info["cep"];
                $this->rua = $info["rua"];
                $this->numero = $info["numero"];
                $this->complemento = $info["complemento"];
                $this->bairro = $info["bairro"];
                $this->cidade = $info["cidade"];
                $this->estado = $info["estado"];
                $this->data_controle = $info["data_controle"];
                $this->status_transporte = $info["status_transporte"];
                $this->status = $info["status"];
                $this->valor_frete = $info["vlr_frete"];
                $this->codigo_rastreamento = $info["codigo_rastreamento"];
                
                $_POST["console"] = false;
                $_POST["codigo_referencia"] = $info["referencia"];
                
                global $diretorioAPI;
                
                require "{$diretorioAPI}pagseguro/ws-pagseguro-consulta-referencia.php"; // Retorna o $statusPagseguro
                
                
                if(isset($statusPagseguro) && $statusPagseguro != $info["status"]){
                    switch($statusPagseguro){
                        case 1:
                            $statusTransporte = 0;
                            break;
                        case 2:
                            $statusTransporte = 0;
                            break;
                        case 3:
                            $statusTransporte = 1;
                            break;
                        case 4:
                            $statusTransporte = 1;
                            break;
                        case 5:
                            $statusTransporte = 4;
                            break;
                        case 6:
                            $statusTransporte = 4;
                            break;
                        case 7:
                            $statusTransporte = 4;
                            break;
                        default:
                            $statusTransporte = 0;
                    }
                    
                    $statusTransporte = $this->status_transporte == 0 ? $statusTransporte : $this->status_transporte;
                    
                    mysqli_query($conexao, "update $tabela_pedidos set status = '$statusPagseguro', status_transporte = '$statusTransporte' where id = '{$info["id"]}'");
                    $this->status = $statusPagseguro;
                }
                
                $tokenCarrinho = $info["token_carrinho"];
                

                $valorTotal = 0;

                $queryValorTotal = mysqli_query($conexao, "select preco_produto, quantidade_produto from $tabela_carrinhos where token_carrinho = '$tokenCarrinho'");
                while($info = mysqli_fetch_array($queryValorTotal)){
                    $valorTotal += $info["preco_produto"] * $info["quantidade_produto"];
                }

                $this->valor_total = $valorTotal + $this->valor_frete;
                
                return true;
            }else{
                return false;
            }
        }
        
        function montar_array(){
            $array = array();
            $array["id"] = $this->id;
            $array["codigo_confirmacao"] = $this->codigo_confirmacao;
            $array["codigo_transacao"] = $this->codigo_transacao;
            $array["codigo_transporte"] = $this->codigo_transporte;
            $array["codigo_pagamento"] = $this->codigo_pagamento;
            $array["referencia"] = $this->referencia;
            $array["token_carrinho"] = $this->token_carrinho;
            $array["id_cliente"] = $this->id_cliente;
            $array["nome_cliente"] = $this->nome_cliente;
            $array["cpf_cliente"] = $this->cpf_cliente;
            $array["email_cliente"] = $this->email_cliente;
            $array["cep"] = $this->cep;
            $array["rua"] = $this->rua;
            $array["numero"] = $this->numero;
            $array["complemento"] = $this->complemento;
            $array["bairro"] = $this->bairro;
            $array["cidade"] = $this->cidade;
            $array["estado"] = $this->estado;
            $array["data_controle"] = $this->data_controle;
            $array["valor_total"] = $this->valor_total;
            $array["status"] = $this->status;
            $array["valor_frete"] = $this->valor_frete;
            $array["codigo_rastreamento"] = $this->codigo_rastreamento;
            $array["status_transporte"] = $this->status_transporte;
            return $array;
        }
        
        function buscar_pedidos($condicao){
            $conexao = $this->global_vars["conexao"];
            $tabela_pedidos = $this->global_vars["tabela_pedidos"];
            $total = $this->pew_functions->contar_resultados($tabela_pedidos, $condicao);
            if($total > 0){
                
                $selected_pedidos = array();
                $ctrl = 0;
                
                $query = mysqli_query($conexao, "select id from $tabela_pedidos where $condicao");
                while($infoPedido = mysqli_fetch_array($query)){
                    $selected_pedidos[$ctrl] = $infoPedido["id"];
                    $ctrl++;
                }
                
                return $selected_pedidos;
            }else{
                return false;
            }
        }
        
        function get_produtos_pedido(){
            $conexao = $this->global_vars["conexao"];
            $tabela_carrinhos = $this->global_vars["tabela_carrinhos"];
            $tokenCarrinho = $this->token_carrinho;
            $total = $this->pew_functions->contar_resultados($tabela_carrinhos, "token_carrinho = '$tokenCarrinho'");
            
            $produtos = array();
            $ctrl = 0;
            
            if($total > 0){
                $queryProdutos = mysqli_query($conexao, "select * from $tabela_carrinhos where token_carrinho = '$tokenCarrinho'");
                while($info = mysqli_fetch_array($queryProdutos)){
                    $produtos[$ctrl] = array();
                    $produtos[$ctrl]["id"] = $info["id_produto"];
                    $produtos[$ctrl]["nome"] = $info["nome_produto"];
                    $produtos[$ctrl]["quantidade"] = $info["quantidade_produto"];
                    $produtos[$ctrl]["preco"] = $info["preco_produto"];
                    $ctrl++;
                }
                return $produtos;
            }else{
                return false;
            }
        }
        
        function get_status_string($status){
            switch($status){
                case 1:
                    $str = "Aguardando pagamento";
                    break;
                case 2:
                    $str = "Em análise";
                    break;
                case 3:
                    $str = "Paga";
                    break;
                case 4:
                    $str = "Disponível";
                    break;
                case 5:
                    $str = "Em disputa";
                    break;
                case 6:
                    $str = "Devolvido";
                    break;
                case 7:
                    $str = "Cancelado";
                    break;
                default:
                    $str = "Validando";
            }
            return $str;
        }
        
        function get_status_transporte_string($status){
            switch($status){
                case 1:
                    //$str = "Pronto para envio";
                    $str = "<a class='link-padrao btn-add-rastreamento' id='addRastreamento{$this->id}'>Adicionar código de rastreio</a>";
                    break;
                case 2:
                    //$str = "Enviado";
                    $str = "<a class='link-padrao btn-add-rastreamento' id='addRastreamento{$this->id}'>" . $this->codigo_rastreamento . "</a>";
                    break;
                case 3:
                    $str = "Entregue";
                    break;
                case 4:
                    $str = "Cancelado";
                    break;
                default:
                    $str = "Confirmar pagamento";
            }
            return $str;
        }
        
        function get_pagamento_string($codigo){
            switch($codigo){
                case "1":
                    $str = "Cartão de crédito";
                    break;
                case "2":
                    $str = "Boleto";
                    break;
                case "3":
                    $str = "Débito online";
                    break;
                case "4":
                    $str = "Saldo PagSeguro";
                    break;
                case "5":
                    $str = "Oi Paggo";
                    break;
                case "6":
                    $str = "Depósito em conta";
                    break;
                default:
                    $str = "Não especificado";
            }
            
            return $str;
        }
        
        function get_transporte_string(){
            switch($this->codigo_transporte){
                case "7777":
                    $str = "Retirada na Loja";
                    break;
                case "8888":
                    $str = "Motoboy";
                    break;
                case "40010":
                    $str = "Correios - SEDEX";
                    break;
                case "40215":
                    $str = "Correios - SEDEX 10";
                    break;
                case "40290":
                    $str = "Correios - SEDEX Hoje";
                    break;
                default:
                    $str = "Correios - PAC";
            }
            return $str;
        }
        
        function listar_pedidos($selectedIDs){
            
            foreach($selectedIDs as $id){
                $listar = $this->montar($id) == true ? true : false;
                if($listar && !isset($_POST["box_type"])){
                    $infoProduto = $this->montar_array();
                    
                    $statusStr = $this->get_status_string($this->status);
                    $statusTransporteStr = $this->get_status_transporte_string($this->status_transporte);
                    $pagamentoStr = $this->get_pagamento_string($this->codigo_pagamento);
                    $transporteStr = $this->get_transporte_string();
                    
                    $data = substr($this->data_controle, 0, 10);
                    $data = $this->pew_functions->inverter_data($data);
                    $horario = substr($this->data_controle, 10);
                    
                    $valor = $this->pew_functions->custom_number_format($this->valor_total);
                    
                    $txtComplemento = $this->complemento != "" ? ", ".$this->complemento : "";
                    
                    $enderecoFinal = $this->rua . ", ". $this->numero . $txtComplemento . " - " . $this->cep . " - " . $this->cidade . " | " . $this->estado;
                    
                    echo "<div class='box-produto display-pedido' id='boxProduto$id'>";
                        echo "<div class='informacoes'>";
                            echo "<h3 class='nome-produto'><a>{$this->nome_cliente}</a></h3>";
                            echo "<div class='half box-info'>";
                                echo "<h4 class='titulo'><i class='fas fa-clipboard'></i> Status</h4>";
                                echo "<h3 class='descricao'>$statusStr</h3>";
                            echo "</div>";
                            echo "<div class='half box-info'>";
                                echo "<h4 class='titulo'><i class='fas fa-hashtag'></i> Referencia</h4>";
                                echo "<h3 class='descricao'>{$this->referencia}</h3>";
                            echo "</div>";
                            echo "<div class='half box-info clear'>";
                                echo "<h4 class='titulo'><i class='far fa-calendar-alt'></i> Data</h4>";
                                echo "<h3 class='descricao'>$data</h3>";
                            echo "</div>";
                            echo "<div class='half box-info'>";
                                echo "<h4 class='titulo'><i class='fas fa-dollar-sign'></i> Valor</h4>";
                                echo "<h3 class='descricao'>R$ $valor</h3>";
                            echo "</div>";
                            echo "<div class='half box-info clear'>";
                                echo "<h4 class='titulo'><i class='fas fa-truck'></i> Transporte</h4>";
                                echo "<h3 class='descricao'>$transporteStr</h3>";
                            echo "</div>";
                            echo "<div class='half box-info'>";
                                echo "<h4 class='titulo'><i class='fas fa-parachute-box'></i> Entrega</h4>";
                                echo "<h3 class='descricao'>$statusTransporteStr</h3>";
                            echo "</div>";
                            echo "<div class='bottom-buttons group clear'>";
                                echo "<div class='box-button' style='margin: 0px;'>";
                                    echo "<a class='btn-alterar btn-alterar-produto botao-ver-produtos' title='Clique para fazer alterações no produto' id-pedido='idPedido$id'>Ver produtos</a>";;
                                echo "</div>";
                                echo "<div class='box-button' style='margin: 0px;'>";
                                    echo "<a class='btn-alterar btn-alterar-produto botao-ver-info' title='Mais informações' id-pedido='infoPedido$id'>Mais informações</a>";
                                echo "</div>";
                            echo "</div>";
                        echo "</div>";
                        // Produtos da compra
                        echo "<div class='display-produtos-pedido' id='idPedido$id'>";
                            echo "<h3 class='titulo-info'>Produtos do pedido: <b>{$this->referencia}</b></h3>";
                            $selectedProdutos = $this->get_produtos_pedido();
                            if(is_array($selectedProdutos)){
                                foreach($selectedProdutos as $infoProduto){
                                    $nome = $infoProduto["nome"];
                                    $quantidade = $infoProduto["quantidade"];
                                    $preco = $infoProduto["preco"];
                                    $subtotal = $preco * $quantidade;
                                    $subtotal = $this->pew_functions->custom_number_format($subtotal);
                                    echo "<div class='box'>";
                                        echo "<div class='quantidade'>$quantidade x</div>";
                                        echo "<div class='nome'>$nome</div>";
                                        echo "<div class='subtotal'>$subtotal</div>";
                                    echo "</div>";
                                }
                                echo "<div class='box'>";
                                    echo "<div class='quantidade'>1 x</div>";
                                    echo "<div class='nome'>" . $this->get_transporte_string() . "</div>";
                                    echo "<div class='subtotal'>" . $this->valor_frete . "</div>";
                                echo "</div>";
                                echo "<button class='btn-voltar btn-voltar-produtos' id-pedido='idPedido$id'>Voltar</button>";
                            }
                        echo "</div>";
                        // Informações adicionais
                        echo "<div class='display-info-pedido' id='infoPedido$id'>";
                            echo "<div class='informacoes'>";
                                echo "<div class='half box-info'>";
                                    echo "<h4 class='titulo'><i class='fas fa-credit-card'></i> Pagamento</h4>";
                                    echo "<h3 class='descricao'>$pagamentoStr</h3>";
                                echo "</div>";
                                echo "<div class='half box-info'>";
                                    echo "<h4 class='titulo'><i class='fas fa-id-card'></i> CPF</h4>";
                                    echo "<h3 class='descricao'>{$this->pew_functions->mask($this->cpf_cliente, "###.###.###-##")}</h3>";
                                echo "</div>";
                                echo "<div class='full clear box-info'>";
                                    echo "<h4 class='titulo'><i class='far fa-envelope'></i> E-mail</h4>";
                                    echo "<h3 class='descricao'>{$this->email_cliente}</h3>";
                                echo "</div>";
                                echo "<div class='full box-info'>";
                                    echo "<h4 class='titulo'><i class='fas fa-map-marker'></i> Endereço entrega</h4>";
                                    echo "<h3 class='descricao'>$enderecoFinal</h3>";
                                echo "</div>";
                                echo "<div class='half box-info'>";
                                    echo "<h4 class='titulo'><i class='far fa-clock'></i> Hora</h4>";
                                    echo "<h3 class='descricao'>$horario</h3>";
                                echo "</div>";
                            echo "</div>";
                            echo "<button class='btn-voltar btn-voltar-info' id-pedido='infoPedido$id'>Voltar</button>";
                        echo "</div>";
                    echo "</div>";
                }
            }
        }
        
        function get_pedidos_conta($idCliente){
            $tabela_minha_conta = $this->global_vars["tabela_minha_conta"];
            
            $pedidosCliente = $this->buscar_pedidos("id_cliente = '$idCliente' order by id desc");
            
            $selected = array();
            $count = 0;
            
            if($pedidosCliente != false){
                foreach($pedidosCliente as $idPedido){
                    if(in_array($idPedido, $selected) == false){
                        $selected[$count] = $idPedido;
                        $count++;
                    }
                }
                
                return $selected;
            }else{
                return false;
            }
            
        }
    }