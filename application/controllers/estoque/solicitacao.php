<?php

require_once APPPATH . 'controllers/base/BaseController.php';

/**
 * Esta classe é o controler de Servidor. Responsável por chamar as funções e views, efetuando as chamadas de models
 * @author Equipe de desenvolvimento APH
 * @version 1.0
 * @copyright Prefeitura de Fortaleza
 * @access public
 * @package Model
 * @subpackage GIAH
 */
class Solicitacao extends BaseController {

    function Solicitacao() {
        parent::Controller();
        $this->load->model('estoque/solicitacao_model', 'solicitacao');
        $this->load->model('estoque/boleto_model', 'boleto');
        $this->load->model('ambulatorio/guia_model', 'guia');
        $this->load->model('cadastro/convenio_model', 'convenio');
        $this->load->model('cadastro/paciente_model', 'paciente');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index() {
        $this->pesquisar();
    }

    function carregarsolicitacao($estoque_solicitacao_id) {

        $data['estoque_solicitacao_id'] = $estoque_solicitacao_id;
        $data['nome'] = $this->solicitacao->solicitacaonome($estoque_solicitacao_id);

        $data['produto'] = $this->solicitacao->listarprodutos($estoque_solicitacao_id);
        $data['contador'] = $this->solicitacao->contador($estoque_solicitacao_id);
        if ($data['contador'] > 0) {
            $data['produtos'] = $this->solicitacao->listarsolicitacaos($estoque_solicitacao_id);
        }
//        echo "<pre>";
//        var_dump($data['produtos']);die;
        $this->loadView('estoque/solicitacaoitens-form', $data);
    }

    function carregarsaida($estoque_solicitacao_id) {

        $data['estoque_solicitacao_id'] = $estoque_solicitacao_id;
        $data['nome'] = $this->solicitacao->solicitacaonome($estoque_solicitacao_id);
//        echo '<pre>';
//        var_dump($data['nome']);die;
        $data['contador'] = $this->solicitacao->contador($estoque_solicitacao_id);
        if ($data['contador'] > 0) {
            $data['produtos'] = $this->solicitacao->listarsolicitacaos($estoque_solicitacao_id);
        }
        $data['contadorsaida'] = $this->solicitacao->contadorsaidaitem($estoque_solicitacao_id);
        $data['produtossaida'] = $this->solicitacao->listarsaidaitem($estoque_solicitacao_id);
        $this->loadView('estoque/saida-form', $data);
    }

    function carregarboleto($solicitacao_cliente_id) {

        $data['solicitacao_cliente_id'] = $solicitacao_cliente_id;
        $data['formaspagamento'] = $this->solicitacao->listarformapagamentoboleto($solicitacao_cliente_id);
//                    die;

        if (count($data['formaspagamento']) > 1) {
//            die;
            $this->loadView('estoque/solicitacaoboleto', $data);
        } else {
            $pagamento_id = $data['formaspagamento'][0]->forma_pagamento_id;
            redirect(base_url() . "estoque/solicitacao/solicitacaoboleto/$solicitacao_cliente_id/$pagamento_id");
        }
    }

    function solicitacaoboleto($solicitacao_cliente_id, $pagamento_id = null) {
        $data['solicitacao_cliente_id'] = $solicitacao_cliente_id;
        if ($pagamento_id != null) {
            $forma_id = $pagamento_id;
        } else {
            $forma_id = $_POST['formapagamento'];
        }
        $data['conta'] = $this->solicitacao->listarcontaboleto($forma_id);
        $this->loadView('estoque/dadosboleto', $data);
    }

    function carregarimpressoes($estoque_solicitacao_id) {

        $data['estoque_solicitacao_id'] = $estoque_solicitacao_id;
        $data['solicitacao'] = $this->solicitacao->listarsolicitacaoimpressao($estoque_solicitacao_id);
        $this->loadView('estoque/carregarimpressoes', $data);
    }

    function impressoes() {
        $estoque_solicitacao_id = $_POST['estoque_solicitacao_id'];
        if ($_POST['impressao'] == 'pedido_simples') {
            redirect(base_url() . "estoque/solicitacao/imprimirliberadasimples/$estoque_solicitacao_id");
        } elseif ($_POST['impressao'] == 'pedido') {
            redirect(base_url() . "estoque/solicitacao/imprimirliberada/$estoque_solicitacao_id");
        } elseif ($_POST['impressao'] == 'saida_simples') {
            redirect(base_url() . "estoque/solicitacao/imprimirsimples/$estoque_solicitacao_id");
        } elseif ($_POST['impressao'] == 'saida') {
            redirect(base_url() . "estoque/solicitacao/imprimir/$estoque_solicitacao_id");
        } elseif ($_POST['impressao'] == 'nota') {
            redirect(base_url() . "estoque/solicitacao/carregarnotafiscal/$estoque_solicitacao_id");
        } elseif ($_POST['impressao'] == 'recibo') {
            redirect(base_url() . "estoque/solicitacao/impressaorecibo/$estoque_solicitacao_id");
        }
    }

    function impressaorecibo($estoque_solicitacao_id) {

        $data['emissao'] = date("d-m-Y");
        $empresa_id = $this->session->userdata('empresa_id');
        $data['exame'] = $this->guia->listarexame($exames_id);


        $data['empresa'] = $this->solicitacao->empresa();
        $data['destinatario'] = $this->solicitacao->listaclientenotafiscal($estoque_solicitacao_id);
        $data['produtos'] = $this->solicitacao->listarsolicitacaosnota($estoque_solicitacao_id);

        $grupo = $data['exame'][0]->grupo;
        $convenioid = $data['exame'][0]->convenio_id;
        $dinheiro = $data['exame'][0]->dinheiro;
        $data['exames'] = $this->guia->listarexamesguiaconvenio($guia_id, $convenioid);
        $exames = $data['exames'];
        $valor_total = 0;

        foreach ($exames as $item) :
            if ($dinheiro == "t") {
                $valor_total = $valor_total + ($item->valor_total);
            }
        endforeach;

        $data['guia'] = $this->guia->listar($paciente_id);
        $data['paciente'] = $this->paciente->listardados($paciente_id);
        $valor = number_format($valor_total, 2, ',', '.');

        $data['valor'] = $valor;

        if ($valor == '0,00') {
            $data['extenso'] = 'ZERO';
        } else {
            $valoreditado = str_replace(",", "", str_replace(".", "", $valor));
            if ($dinheiro == "t") {
                $data['extenso'] = GExtenso::moeda($valoreditado);
            }
        }

        $dataFuturo = date("Y-m-d");

        $this->load->View('estoque/impressaorecibo', $data);
    }

    function imprimirsaida($estoque_solicitacao_id) {

        $data['estoque_solicitacao_id'] = $estoque_solicitacao_id;
        $data['nome'] = $this->solicitacao->solicitacaonome($estoque_solicitacao_id);

        $data['armazem'] = $this->solicitacao->listararmazem();
        $data['contador'] = $this->solicitacao->contador($estoque_solicitacao_id);
        if ($data['contador'] > 0) {
            $data['produtos'] = $this->solicitacao->listarsolicitacaos($estoque_solicitacao_id);
        }
        $data['contadorsaida'] = $this->solicitacao->contadorsaidaitem($estoque_solicitacao_id);
        $data['produtossaida'] = $this->solicitacao->listarsaidaitem($estoque_solicitacao_id);
        $this->loadView('estoque/saida-form', $data);
    }

    function imprimir($estoque_solicitacao_id) {

        $data['estoque_solicitacao_id'] = $estoque_solicitacao_id;
        $data['empresa'] = $this->solicitacao->empresa();
        $data['destinatario'] = $this->solicitacao->listadadossolicitacaoliberada($estoque_solicitacao_id);
        $data['nome'] = $this->solicitacao->solicitacaonome($estoque_solicitacao_id);
        $data['produtossaida'] = $this->solicitacao->listarsaidaitem($estoque_solicitacao_id);
        $data['usuario'] = $this->solicitacao->usuarioemitente();
//        $data['produtossaida'] = $this->solicitacao->listaritemliberado($estoque_solicitacao_id);
        $this->load->View('estoque/impressaosaida', $data);
    }

    function imprimirsimples($estoque_solicitacao_id) {

        $data['estoque_solicitacao_id'] = $estoque_solicitacao_id;
        $data['empresa'] = $this->solicitacao->empresa();
        $data['destinatario'] = $this->solicitacao->listadadossolicitacaoliberada($estoque_solicitacao_id);
        $data['nome'] = $this->solicitacao->solicitacaonome($estoque_solicitacao_id);
        $data['produtossaida'] = $this->solicitacao->listarsaidaitem($estoque_solicitacao_id);
        $data['usuario'] = $this->solicitacao->usuarioemitente();
        $this->load->View('estoque/impressaosaidasimples', $data);
    }

    function imprimirliberadasimples($estoque_solicitacao_id) {

        $data['empresa'] = $this->solicitacao->empresa();
        $data['destinatario'] = $this->solicitacao->listadadossolicitacaoliberada($estoque_solicitacao_id);
        $data['estoque_solicitacao_id'] = $estoque_solicitacao_id;
        $data['nome'] = $this->solicitacao->solicitacaonomeliberado($estoque_solicitacao_id);
        $data['produtossaida'] = $this->solicitacao->listaritemliberado($estoque_solicitacao_id);
        $this->load->View('estoque/impressaoliberadasimples', $data);
    }

    function imprimirliberada($estoque_solicitacao_id) {

        $data['empresa'] = $this->solicitacao->empresa();
        $data['destinatario'] = $this->solicitacao->listadadossolicitacaoliberada($estoque_solicitacao_id);
        $data['estoque_solicitacao_id'] = $estoque_solicitacao_id;
        $data['nome'] = $this->solicitacao->solicitacaonomeliberado($estoque_solicitacao_id);
        $data['produtossaida'] = $this->solicitacao->listaritemliberado($estoque_solicitacao_id);

//        echo '<pre>';        var_dump($data);die;
        $this->load->View('estoque/impressaoliberada', $data);
    }

    function saidaitens($estoque_solicitacao_itens_id, $estoque_solicitacao_id) {

        $data['estoque_solicitacao_id'] = $estoque_solicitacao_id;
        $data['estoque_solicitacao_itens_id'] = $estoque_solicitacao_itens_id;
        $data['nome'] = $this->solicitacao->solicitacaonome($estoque_solicitacao_id);

        $data['armazem'] = $this->solicitacao->listararmazem();
        $data['contador'] = $this->solicitacao->contadorprodutositem($estoque_solicitacao_itens_id);
        $data['produto'] = $this->solicitacao->listarsolicitacaos($estoque_solicitacao_id);
        if ($data['contador'] > 0) {
            $data['produtos'] = $this->solicitacao->listarprodutositem($estoque_solicitacao_itens_id);
        }

        $data['contadorsaida'] = $this->solicitacao->contadorsaidaitem($estoque_solicitacao_id);
        $data['produtossaida'] = $this->solicitacao->listarsaidaitem($estoque_solicitacao_id);
//        echo "<pre>";
//        var_dump($data['produtossaida']);die;
        $this->loadView('estoque/saidaitens-form', $data);
    }

    function gravarsaidaitens() {
        $estoque_solicitacao_id = $_POST['txtestoque_solicitacao_id'];
        $estoque_solicitacao_itens_id = $_POST['txtestoque_solicitacao_itens_id'];
//        
//        $_POST['txtqtde'] = (int) $_POST['txtqtde'];
//        $_POST['qtdedisponivel'] = (int) $_POST['qtdedisponivel'];
//        var_dump($_POST['qtdedisponivel']); die;
        if ($_POST['produto_id'] == '') {
            $data['mensagem'] = 'Insira um produto valido.';
            $this->session->set_flashdata('message', $data['mensagem']);
        } elseif ($_POST['txtqtde'] == '') {
            $data['mensagem'] = 'Insira uma quantidade valida.';
            $this->session->set_flashdata('message', $data['mensagem']);
        } elseif (isset($_POST['qtdedisponivel']) && ( (int) $_POST['txtqtde'] > (int) $_POST['qtdedisponivel'])) {
            $data['mensagem'] = 'Quantidade selecionada excede o saldo disponivel.';
            $this->session->set_flashdata('message', $data['mensagem']);
        } else {
            //nao permitir quantidades maiores que o que tem
            $data['produtos'] = $this->solicitacao->listarprodutositem($estoque_solicitacao_itens_id);
            $this->solicitacao->gravarsaidaitens();
        }
        redirect(base_url() . "estoque/solicitacao/saidaitens/$estoque_solicitacao_itens_id/$estoque_solicitacao_id");
    }

    function gravaritens() {
        $estoque_solicitacao_id = $_POST['txtestoque_solicitacao_id'];
        if ($_POST['produto_id'] == '') {
            $data['mensagem'] = 'Insira um produto valido.';
            $this->session->set_flashdata('message', $data['mensagem']);
        } elseif ($_POST['txtqtde'] == '') {
            $data['mensagem'] = 'Insira uma quantidade valida.';
            $this->session->set_flashdata('message', $data['mensagem']);
        } elseif ($_POST['valor'] == '') {
            $data['mensagem'] = 'Insira um valor valido.';
            $this->session->set_flashdata('message', $data['mensagem']);
        } elseif (($_POST['cfop'] != '' || $_POST['descricao_cfop'] != '') && $_POST['cfop_id'] == '') {
            $data['mensagem'] = 'Insira um CFOP valido. Certifique-se de selecionar algum CFOP presente na lista.';
            $this->session->set_flashdata('message', $data['mensagem']);
        } else {
            $_POST['valor'] = str_replace(',', '.', $_POST['valor']);
            $this->solicitacao->gravaritens();
        }

        redirect(base_url() . "estoque/solicitacao/carregarsolicitacao/$estoque_solicitacao_id");
    }

    function gravartransportadora($estoque_solicitacao_id) {
        $data['estoque_solicitacao_id'] = $estoque_solicitacao_id;
        $data['solicitacao_transportadora'] = $this->solicitacao->listarsolicitacaoclientetransportadora($estoque_solicitacao_id);
        if (count($data['solicitacao_transportadora']) > 0) {
            $data['solicitacao_transportadora'] = $data['solicitacao_transportadora'][0];
        }

        $this->load->View('estoque/gravarsolicitacaotransportadora', $data);
    }

    function gravarsolicitacaotransportadora() {
        $solicitacao_id = $_POST['solicitacao_cliente_id'];

        if ($_POST['transportadora_id'] == '') {
            $data['mensagem'] = 'Insira uma transportadora valida. Certifique-se de escolher um item da lista.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "estoque/solicitacao/gravartransportadora/$solicitacao_id");
        } elseif ($_POST['entregador_id'] == '') {
            $data['mensagem'] = 'Insira um entregador valido. Certifique-se de escolher um item da lista.';
            $this->session->set_flashdata('message', $data['mensagem']);
            redirect(base_url() . "estoque/solicitacao/gravartransportadora/$solicitacao_id");
        } else {
//            die('ola');
            $this->solicitacao->gravarsolicitacaotransportadora();
            echo "<script type='text/javascript'> 
                    window.close();
                </script>";
        }
    }

    function gravarfaturamento() {
        if ($_POST['valortotal'] == '0.00') {
            $verifica = $this->solicitacao->gravarfaturamento();

            $contrato_id = $_POST['contrato_id'];
            $credor_devedor_id = $_POST['credor_devedor_id'];
            $solicitacao_id = $_POST['estoque_solicitacao_id'];

            if ($_POST['formapamento1_boleto'] == 't') {
                if ($_POST['ajuste1'] != "0") {
                    $valor = $_POST['valorajuste1'];
                } else {
                    $valor = $_POST['valor1'];
                }
                $descricao_id = $_POST['formapamento1'];
                $forma_id = $_POST['forma_pagamento_1'];
                $verifica = $this->boleto->gravarsolicitacaoboleto($valor, $solicitacao_id, $descricao_id, $forma_id, $credor_devedor_id, $contrato_id);
            }

            if ($_POST['formapamento2_boleto'] == 't') {
                if ($_POST['ajuste1'] != "0") {
                    $valor = $_POST['valorajuste2'];
                } else {
                    $valor = $_POST['valor2'];
                }
                $descricao_id = $_POST['formapamento2'];
                $forma_id = $_POST['forma_pagamento_2'];
                $verifica = $this->boleto->gravarsolicitacaoboleto($valor, $solicitacao_id, $descricao_id, $forma_id, $credor_devedor_id, $contrato_id);
            }
            if ($_POST['formapamento3_boleto'] == 't') {
                if ($_POST['ajuste1'] != "0") {
                    $valor = $_POST['valorajuste3'];
                } else {
                    $valor = $_POST['valor3'];
                }
                $descricao_id = $_POST['formapamento3'];
                $forma_id = $_POST['forma_pagamento_3'];
                $verifica = $this->boleto->gravarsolicitacaoboleto($valor, $solicitacao_id, $descricao_id, $forma_id, $credor_devedor_id, $contrato_id);
            }
            if ($_POST['formapamento4_boleto'] == 't') {
                if ($_POST['ajuste1'] != "0") {
                    $valor = $_POST['valorajuste4'];
                } else {
                    $valor = $_POST['valor4'];
                }
                $descricao_id = $_POST['formapamento4'];
                $forma_id = $_POST['forma_pagamento_4'];
                $verifica = $this->boleto->gravarsolicitacaoboleto($valor, $solicitacao_id, $descricao_id, $forma_id, $credor_devedor_id, $contrato_id);
            }
            
            $this->solicitacao->gravarfinanceirofaturamento();

            if ($verifica) {
                $data['mensagem'] = 'Faturado com sucesso.';
            } else {
                $data['mensagem'] = 'Erro ao Faturar.';
            }
        } else {
            $data['mensagem'] = 'Erro ao Faturar.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        echo "<script type='text/javascript'> 
                    window.close();
                </script>";
    }

    function excluirsolicitacao($estoque_solicitacao_itens_id, $estoque_solicitacao_id) {
        $this->solicitacao->excluirsolicitacao($estoque_solicitacao_itens_id);
        redirect(base_url() . "estoque/solicitacao/carregarsolicitacao/$estoque_solicitacao_id");
    }

    function excluirsaida($estoque_saida_id, $estoque_solicitacao_id, $estoque_solicitacao_itens_id) {
        $this->solicitacao->excluirsaida($estoque_saida_id);
        redirect(base_url() . "estoque/solicitacao/saidaitens/$estoque_solicitacao_itens_id/$estoque_solicitacao_id");
    }

    function faturarsolicitacao($estoque_solicitacao_id) {
        $data['descricao_pagamento'] = $this->solicitacao->descricaodepagamento();
        $data['forma_pagamento'] = $this->solicitacao->formadepagamento();
        $data['solicitacao'] = $this->solicitacao->listarsolicitacaofaturamento($estoque_solicitacao_id);
        $data['solicitacao_cliente'] = $this->solicitacao->listarsolicitacaofaturamentocliente($estoque_solicitacao_id);
//        echo "<pre>";var_dump($data['solicitacao'], $estoque_solicitacao_id);
        $data['estoque_solicitacao_id'] = $estoque_solicitacao_id;
        $data['valor'] = 0.00;
        $this->load->View('estoque/faturarsolicitacao-form', $data);
    }

    function liberarsolicitacao($estoque_solicitacao_id) {

        $this->solicitacao->liberarsolicitacao($estoque_solicitacao_id);
        $data['valor_total'] = $this->solicitacao->calculavalortotalsolicitacao($estoque_solicitacao_id);
        $valortotal = 0;
        foreach ($data['valor_total'] as $item) {
            //calcula valor total
            $v = (float) $item->valor_venda;
            $a = (int) str_replace('.', '', $item->quantidade);
            $preco = (float) $a * $v;
            $valortotal += $preco;
        }

        $this->solicitacao->gravarsolicitacaofaturamento($estoque_solicitacao_id, $valortotal);
        redirect(base_url() . "estoque/solicitacao");
    }

    function liberarsolicitacaofaturar($estoque_solicitacao_id) {

        $this->solicitacao->liberarsolicitacao($estoque_solicitacao_id);
        $data['valor_total'] = $this->solicitacao->calculavalortotalsolicitacao($estoque_solicitacao_id);
        $valortotal = 0;
        foreach ($data['valor_total'] as $item) {
            //calcula valor total
            $v = (float) $item->valor_venda;
            $a = (int) str_replace('.', '', $item->quantidade);
            $preco = (float) $a * $v;
            $valortotal += $preco;
        }

        $this->solicitacao->gravarsolicitacaofaturamento($estoque_solicitacao_id, $valortotal);
        redirect(base_url() . "estoque/solicitacao/faturarsolicitacao/$estoque_solicitacao_id");
    }

    function fecharsolicitacao($estoque_solicitacao_id) {
        $this->solicitacao->fecharsolicitacao($estoque_solicitacao_id);
        $this->pesquisar();
    }

    function carregarnotafiscal($estoque_solicitacao_id) {
        $data['empresa'] = $this->solicitacao->empresa();
        $data['destinatario'] = $this->solicitacao->listaclientenotafiscal($estoque_solicitacao_id);
        $data['produtos'] = $this->solicitacao->listarsolicitacaosnota($estoque_solicitacao_id);
//        echo "<pre>";var_dump($data['produtos']);die;
        $this->load->View('estoque/imprimirnotafiscal', $data);
    }

    function pesquisar($args = array()) {

        $this->loadView('estoque/solicitacao-lista', $args);

//            $this->carregarView($data);
    }

    function teste() {
        header('Content-type: text/html; charset=utf-8');
        $path = "/home/sisprod/projetos/administrativo/application/libraries/boleto/objectBoleto";
        include ("$path/OB_init.php");

        $ob = new OB('004');

        //*
        $ob->Vendedor
                ->setAgencia('0016')
                ->setConta('1193')
                ->setCarteira('55')
                ->setRazaoSocial('José Claudio Medeiros de Lima')
                ->setCpf('012.345.678-39')
                ->setEndereco('Rua dos Mororós 111 Centro, São Paulo/SP CEP 12345-678')
                ->setEmail('joseclaudiomedeirosdelima@uol.com.br')
        ;

        $ob->Configuracao
                ->setLocalPagamento('Pagável em qualquer banco até o vencimento')
        ;

        $ob->Template
                ->setTitle('PHP->OB ObjectBoleto')
                ->setTemplate('html5')
                ->set('instrucao', array('linha1', 'linha2', 'linha3'))
        ;

        $ob->Cliente
                ->setNome('Maria Joelma Bezerra de Medeiros')
                ->setCpf('111.999.888-39')
                ->setEmail('mariajoelma85@hotmail.com')
                ->setEndereco('')
                ->setCidade('')
                ->setUf('')
                ->setCep('')
        ;

        $ob->Boleto
                ->setValor(1000)
                //->setDiasVencimento(5)
                ->setVencimento(10, 9, 2000)
                ->setNossoNumero('1234567')
                ->setNumDocumento('27.030195.10')
                ->setQuantidade(1)
        ;

        $ob->render(); /**/
    }

    function entregador($args = array()) {
        $this->loadView('estoque/entregador-lista', $args);
    }

    function carregarentregador($entregador_id) {
        $data['entregador'] = $this->solicitacao->instanciarentregador($entregador_id);
//        die;
        $this->loadView('estoque/entregador-form', $data);
    }

    function gravarentregador() {
        $verifica = $this->solicitacao->gravarentregador();
        if ($verifica == "-1") {
            $data['mensagem'] = 'Erro ao gravar Entregador. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar Entregador.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "estoque/solicitacao/entregador");
    }

    function excluirentregador($entregador_id) {
        $verifica = $this->solicitacao->excluirentregador($entregador_id);
        if ($verifica == "-1") {
            $data['mensagem'] = 'Erro ao gravar Entregador. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar Entregador.';
        }
        redirect(base_url() . "estoque/solicitacao/entregador");
    }

    function criarsolicitacao($estoque_solicitacao_id) {
        $obj_solicitacao = new solicitacao_model($estoque_solicitacao_id);
        $data['obj'] = $obj_solicitacao;
        $data['setor'] = $this->solicitacao->listarclientes();
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('estoque/solicitacao-form', $data);
    }

    function excluir($estoque_solicitacao_setor_id) {
        $valida = $this->solicitacao->excluir($estoque_solicitacao_setor_id);
        if ($valida == 0) {
            $data['mensagem'] = 'Sucesso ao excluir a Solicitacao';
        } else {
            $data['mensagem'] = 'Erro ao excluir a solicitacao. Opera&ccedil;&atilde;o cancelada.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "estoque/solicitacao");
    }

    function gravar() {
        $estoque_solicitacao_setor_id = $this->solicitacao->gravar();
        if ($estoque_solicitacao_setor_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Solicitacao. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Solicitacao.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "estoque/solicitacao/carregarsolicitacao/$estoque_solicitacao_setor_id");
    }

    private function carregarView($data = null, $view = null) {
        if (!isset($data)) {
            $data['mensagem'] = '';
        }

        if ($this->utilitario->autorizar(2, $this->session->userdata('modulo')) == true) {
            $this->load->view('header', $data);
            if ($view != null) {
                $this->load->view($view, $data);
            } else {
                $this->load->view('giah/servidor-lista', $data);
            }
        } else {
            $data['mensagem'] = $this->mensagem->getMensagem('login005');
            $this->load->view('header', $data);
            $this->load->view('home');
        }
        $this->load->view('footer');
    }

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
