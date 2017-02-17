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

    function gerarboleto() {
        //dados 
        $data['conta'] = $this->solicitacao->listarcontaboleto($_POST['forma_pagamento_id']);
        $data['empresa'] = $this->solicitacao->empresaboleto();
        $data['destinatario'] = $this->solicitacao->listaclientenotafiscal($_POST['solicitacao_cliente_id']);
        $data['dados_faturamento'] = $this->solicitacao->listasolicitacaofaturamento($_POST['solicitacao_cliente_id']);
        $data['data_venc'] = $_POST['vencimento'];
        
        //tratando acentuações
        $data['empresa'][0]->logradouro = utf8_decode($data['empresa'][0]->logradouro);
        $data['empresa'][0]->estado = utf8_decode($data['empresa'][0]->estado);
        $data['empresa'][0]->municipio = utf8_decode($data['empresa'][0]->municipio);
        $data['empresa'][0]->razao_social = utf8_decode($data['empresa'][0]->razao_social);
        $data['destinatario'][0]->nome = utf8_decode($data['destinatario'][0]->nome);
        $data['destinatario'][0]->logradouro = utf8_decode($data['destinatario'][0]->logradouro);
        $data['destinatario'][0]->municipio = utf8_decode($data['destinatario'][0]->municipio);
        $data['destinatario'][0]->estado = utf8_decode($data['destinatario'][0]->estado);
        

        //valores
        if ((float) $data['dados_faturamento'][0]->desconto != '0') {
            $desconto = (float) $data['dados_faturamento'][0]->desconto;
        } else {
            $desconto = '0,00';
        }
        $deducoes = '0,00';

        $acrescimos = '0,00';
        $multa = '0,00';
        $taxa_boleto = (float) str_replace(',', '.', str_replace('.', '', $_POST['taxa_boleto']));

        $data['valor_cobrado'] = (float) $data['dados_faturamento'][0]->valor_total - (float) $deducoes + (float) $multa + (float) $acrescimos + $taxa_boleto;

//        $var = ereg_replace("[áàâãª]","a",$var);	
//	$var = ereg_replace("[éèê]","e",$var);	
//	$var = ereg_replace("[óòôõº]","o",$var);	
//	$var = ereg_replace("[úùû]","u",$var);	
//	$var = str_replace("ç","c",$var);

//        echo  '<pre>';
//        var_dump($taxa_boleto);die;

        include ("boleto/boleto_bb.php");
        include ("boleto/include/funcoes_bb.php");
        include ("boleto/include/layout_bb.php");
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
//        $data['produtossaida'] = $this->solicitacao->listaritemliberado($estoque_solicitacao_id);
        $this->load->View('estoque/impressaosaida', $data);
    }

    function imprimirsimples($estoque_solicitacao_id) {

        $data['estoque_solicitacao_id'] = $estoque_solicitacao_id;
        $data['empresa'] = $this->solicitacao->empresa();
        $data['destinatario'] = $this->solicitacao->listadadossolicitacaoliberada($estoque_solicitacao_id);
        $data['nome'] = $this->solicitacao->solicitacaonome($estoque_solicitacao_id);
        $data['produtossaida'] = $this->solicitacao->listarsaidaitem($estoque_solicitacao_id);
//        $data['produtossaida'] = $this->solicitacao->listaritemliberado($estoque_solicitacao_id);
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
        $data['forma_pagamento'] = $this->solicitacao->formadepagamentoprocedimento();
        $data['solicitacao'] = $this->solicitacao->listarsolicitacaofaturamento($estoque_solicitacao_id);
//        echo "<pre>";var_dump($data['solicitacao'], $estoque_solicitacao_id);
        $data['estoque_solicitacao_id'] = $estoque_solicitacao_id;
        $data['valor'] = 0.00;
        $this->load->View('estoque/faturarsolicitacao-form', $data);
    }

    function liberarsolicitacao($estoque_solicitacao_id) {

        $this->solicitacao->liberarsolicitacao($estoque_solicitacao_id);
        $data['valor_total'] = $this->solicitacao->calculavalortotalsolicitacao($estoque_solicitacao_id);
        $valorTotalProduto = 0;
        $valorTotalIcms = 0;
        $valorTotalIpi = 0;
        $valorTotalIcmsSt = 0;

        foreach ($data['valor_total'] as $item) {
//        //calcula valor total
//            $v = (float) $item->valor_venda;
//            $a = (int) str_replace('.', '', $item->quantidade);
//            $preco = (float) $a * $v;
//            $valortotal += $preco;

            $v = (float) $item->valor_venda;
            $a = (int) str_replace('.', '', $item->quantidade);
            $preco = (float) $a * $v;
            $valorTotalProduto += $preco;

            $item->icms = (float) $item->icms;
            $icms = $preco * (($item->icms) / 100);
            if ($icms != 0) {
                $valorTotalIcms += $icms;
            }

            $item->ipi = (float) $item->ipi;
            $ipi = $preco * (($item->ipi) / 100);
            if ($ipi != 0) {
                $valorTotalIpi += $ipi;
            }
            if ($item->icmsst == 't') {
                $item->mva = (float) $item->mva;
                $baseIcmsSt = ($preco + $ipi) * (1 + ($item->mva / 100));
                $valorIcmsSt = ($baseIcmsSt * (($item->icms) / 100)) - $icms;

//                        $baseTotalIcmsSt += $baseIcmsSt;
                $valorTotalIcmsSt += $valorIcmsSt;
            }
        }

        $valortotal = $valorTotalProduto + $valorTotalIcms + $valorTotalIpi + $valorTotalIcmsSt;

        $this->solicitacao->gravarsolicitacaofaturamento($estoque_solicitacao_id, $valortotal);
        redirect(base_url() . "estoque/solicitacao");
    }

    function liberarsolicitacaofaturar($estoque_solicitacao_id) {

        $this->solicitacao->liberarsolicitacao($estoque_solicitacao_id);
        $data['valor_total'] = $this->solicitacao->calculavalortotalsolicitacao($estoque_solicitacao_id);
        $valorTotalProduto = 0;
        $valorTotalIcms = 0;
        $valorTotalIpi = 0;
        $valorTotalIcmsSt = 0;

        foreach ($data['valor_total'] as $item) {
//        //calcula valor total
//            $v = (float) $item->valor_venda;
//            $a = (int) str_replace('.', '', $item->quantidade);
//            $preco = (float) $a * $v;
//            $valortotal += $preco;

            $v = (float) $item->valor_venda;
            $a = (int) str_replace('.', '', $item->quantidade);
            $preco = (float) $a * $v;
            $valorTotalProduto += $preco;

            $item->icms = (float) $item->icms;
            $icms = $preco * (($item->icms) / 100);
            if ($icms != 0) {
                $valorTotalIcms += $icms;
            }

            $item->ipi = (float) $item->ipi;
            $ipi = $preco * (($item->ipi) / 100);
            if ($ipi != 0) {
                $valorTotalIpi += $ipi;
            }
            if ($item->icmsst == 't') {
                $item->mva = (float) $item->mva;
                $baseIcmsSt = ($preco + $ipi) * (1 + ($item->mva / 100));
                $valorIcmsSt = ($baseIcmsSt * (($item->icms) / 100)) - $icms;

//                        $baseTotalIcmsSt += $baseIcmsSt;
                $valorTotalIcmsSt += $valorIcmsSt;
            }
        }

        $valortotal = $valorTotalProduto + $valorTotalIcms + $valorTotalIpi + $valorTotalIcmsSt;
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
