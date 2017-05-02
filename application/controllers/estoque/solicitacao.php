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
        $this->load->model('estoque/notafiscal_model', 'notafiscal');
        $this->load->model('estoque/boleto_model', 'boleto');
        $this->load->model('ambulatorio/guia_model', 'guia');
        $this->load->model('cadastro/convenio_model', 'convenio');
        $this->load->model('cadastro/paciente_model', 'paciente');
        $this->load->model('seguranca/operador_model', 'operador_m');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index() {
        $this->pesquisar();
    }

    function geraconfignfephp($solicitacao_id) {
        $data['empresa'] = $this->notafiscal->empresa();
        $json = array(
            'atualizacao' => date('Y-m-d H:i:s'),
            'tpAmb' => (int) $data["empresa"][0]->ambiente_producao,
            'pathXmlUrlFileNFe' => 'nfe_ws3_mod55.xml',
            'pathXmlUrlFileCTe' => 'cte_ws2.xml',
            'pathXmlUrlFileMDFe' => 'mdf2_ws1.xml',
            'pathXmlUrlFileCLe' => '',
            'pathXmlUrlFileNFSe' => '',
            'pathNFeFiles' => '/home/sisprod/projetos/administrativo/upload/nfe/' . $solicitacao_id . '/',
            'pathCTeFiles' => '',
            'pathMDFeFiles' => '',
            'pathCLeFiles' => '',
            'pathNFSeFiles' => '',
            'pathCertsFiles' => '/home/sisprod/projetos/administrativo/upload/certificado/' . $data["empresa"][0]->empresa_id . '/',
            'siteUrl' => base_url() . '/ambulatorio/empresa',
            'schemesNFe' => 'PL_008i2',
            'schemesCTe' => 'PL_CTe_200',
            'schemesMDFe' => 'PL_MDFe_100',
            'schemesCLe' => '',
            'schemesNFSe' => '',
            'razaosocial' => $data["empresa"][0]->razao_social,
            'nomefantasia' => $data["empresa"][0]->empresa,
            'siglaUF' => $this->utilitario->codigo_uf($data["empresa"][0]->codigo_ibge, "sigla"),
            'cnpj' => $this->utilitario->remover_caracter($data["empresa"][0]->cnpj),
            'ie' => $this->utilitario->remover_caracter($data["empresa"][0]->inscricao_estadual),
            'im' => $this->utilitario->remover_caracter($data["empresa"][0]->inscricao_municipal),
            'iest' => $this->utilitario->remover_caracter($data["empresa"][0]->inscricao_estadual_st),
            'cnae' => $this->utilitario->remover_caracter($data["empresa"][0]->cnae),
            'regime' => $this->utilitario->remover_caracter($data["empresa"][0]->cod_regime_tributario),
            'tokenIBPT' => '',
            'tokenNFCe' => '',
            'tokenNFCeId' => '',
            'certPfxName' => $data["empresa"][0]->certificado_nome,
            'certPassword' => $data["empresa"][0]->certificado_senha,
            'certPhrase' => '',
            'aDocFormat' => array(
                'format' => 'L',
                'paper' => 'A4',
                'southpaw' => '1',
                'pathLogoFile' => '/home/sisprod/projetos/administrativo/img/stg - logo.jpg',
                'pathLogoNFe' => '/home/sisprod/projetos/administrativo/img/stg - logo.jpg',
                'pathLogoNFCe' => '/home/sisprod/projetos/administrativo/img/stg - logo.jpg',
                'logoPosition' => 'L',
                'font' => 'Times',
                'printer' => ''
            ),
            'aMailConf' => array(
                'mailAuth' => '1',
                'mailFrom' => false,
                'mailSmtp' => '',
                'mailUser' => '',
                'mailPass' => '',
                'mailProtocol' => '',
                'mailPort' => '',
                'mailFromMail' => false,
                'mailFromName' => '',
                'mailReplayToMail' => false,
                'mailReplayToName' => '',
                'mailImapHost' => null,
                'mailImapPort' => null,
                'mailImapSecurity' => null,
                'mailImapNocerts' => null,
                'mailImapBox' => null
            ),
            'aProxyConf' => array(
                'proxyIp' => '',
                'proxyPort' => '',
                'proxyUser' => '',
                'proxyPass' => ''
            )
        );

//        $str = json_encode($json);
//        var_dump("<pre>", $str, "<hr>");
//        $conv = json_decode($str, true);
//        var_dump($conv);die;
        return json_encode($json);
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
        } elseif ($_POST['impressao'] == 'espNota') {
            redirect(base_url() . "estoque/solicitacao/gerarespelhonotafiscal/$estoque_solicitacao_id");
        }
    }

    function gerarespelhonotafiscal($solicitacao_cliente_id) {

        $data['empresa'] = $this->notafiscal->empresa();

        $tipoAmbiente = (int) $data["empresa"][0]->ambiente_producao; //1=Produção; 2=Homologação

        $data['destinatario'] = $this->notafiscal->listaclientenotafiscal($solicitacao_cliente_id);
        $data['produtos'] = $this->notafiscal->listarsolicitacaoespelhonota($solicitacao_cliente_id);

        if ($this->utilitario->codigo_uf($data['empresa'][0]->codigo_ibge) == $this->utilitario->codigo_uf($data['destinatario'][0]->codigo_ibge)) {
            $data['identificaDestOp'] = '1';
        } else {
            $data['identificaDestOp'] = '2';
        }

        //Essa variavel de configuração sera usada para carregar as configurações iniciais da NFe
        $config = $this->geraconfignfephp($solicitacao_cliente_id);

        $dadosNFe = array(
            /* Dados da NFe - infNFe */
            'verProc' => '1.0', //Versao do SISTEMA ADMINISTRATIVO
            'cUF' => $this->utilitario->codigo_uf($data['empresa'][0]->codigo_ibge, 'codigo'), //codigo do estado (IBGE)
            'identificaDestOp' => $data['identificaDestOp'], // Olhar se as UF's da empresa e do destinatario sao as mesmas.
            'cNF' => $this->utilitario->tamanho_string($solicitacao_cliente_id, 8, 'numero'),
            'cMunFG' => $data['empresa'][0]->codigo_ibge, //codigo do municipio da empresa (IBGE)
            'naturezaOpe' => 'Venda de produtos e mercadorias',
            'modeloNota' => '55',
            'numSerie' => '0', //deve ser incrementado a cada nova nota_fiscal gerada
            'numNF' => '0',
            'tipoNF' => '1', // 0 = entrada | 1 = saida
            'indPres' => '1', // Tipo de Compra. (1=Presencial, 2=Nao Presencial e etc...)
            'finalidadeNFe' => '1',
            'indicadorPagamento' => '0', //0=Pagamento à vista; 1=Pagamento a prazo; 2=Outros

            /* ENDEREÇO DO EMITENTE */
            "logradouro" => $data['empresa'][0]->logradouro,
            "numero" => $data['empresa'][0]->numero,
            "complemento" => $data['empresa'][0]->complemento,
            "bairro" => $data['empresa'][0]->bairro,
            "codMunicipio" => $data['empresa'][0]->codigo_ibge,
            "nomMunicipio" => $data['empresa'][0]->municipio,
            "UF" => $this->utilitario->codigo_uf($data['empresa'][0]->codigo_ibge, 'sigla'),
            "cep" => $this->utilitario->remover_caracter($data['empresa'][0]->cep),
            "fone" => $this->utilitario->remover_caracter(str_replace(' ', '', $data['empresa'][0]->telefone)),
            /* DADOS DO DESTINATARIO */
            "destCNPJ" => $this->utilitario->remover_caracter($data['destinatario'][0]->cnpj),
            "destCPF" => '',
            "destNOME" => $data['destinatario'][0]->nome,
            "destIND_IE" => '1', //criar um novo campo na tb_estoque_cliente (VERIFICAR SE O CLIENTE É ISENTO DE IE)
            "destIE" => $this->utilitario->remover_caracter($data['destinatario'][0]->inscricao_estadual),
            "destIM" => '', //criar um novo campo na tb_estoque_cliente
            "destEMAIL" => $data['destinatario'][0]->email,
            "destLOG" => $data['destinatario'][0]->logradouro,
            "destNUM" => $data['destinatario'][0]->numero,
            "destCOMP" => $data['destinatario'][0]->complemento,
            "destBAIRRO" => $data['destinatario'][0]->bairro,
            "destCOD_MUN" => $data['destinatario'][0]->codigo_ibge,
            "destMUN" => $data['destinatario'][0]->municipio,
            "destUF" => $this->utilitario->codigo_uf($data['destinatario'][0]->codigo_ibge, 'sigla'),
            "destCEP" => $this->utilitario->remover_caracter(str_replace(' ', '', $data['destinatario'][0]->cep)),
            "destFONE" => $this->utilitario->remover_caracter(str_replace(' ', '', $data['destinatario'][0]->telefone))
        );

        $totalProduto = 0;
        /* DADOS DOS PRODUTOS */
        for ($i = 0, $n = 1; $i < count($data['produtos']); $i++, $n++) {
            $totProdItem = number_format(( (int) $data['produtos'][$i]->quantidade * (float) $data['produtos'][$i]->valor_venda), 2, '.', '');

            /* CALCULANDO VALORES TOTAIS DA NOTA */
            $totalProduto += $totProdItem;

            $dadosProdutos[$i] = array(
                /* Dados Basicos */
                "numItem" => $n,
                "codigoProduto" => $data['produtos'][$i]->codigo, // Codigo de controle no sistema do cliente
                "cEAN" => '', //FALTA ESSE
                "nomeProd" => $data['produtos'][$i]->descricao,
                "ncm" => $data['produtos'][$i]->ncm,
                "ex_tipi" => '',
                "cfop" => $data['produtos'][$i]->codigo_cfop,
                "unCompra" => $data['produtos'][$i]->unidade,
                "qtdeCompra" => $data['produtos'][$i]->quantidade,
                "valUniComp" => $data['produtos'][$i]->valor_venda,
                "valProduto" => number_format((int) $data['produtos'][$i]->quantidade * (float) $data['produtos'][$i]->valor_venda, 2, '.', ''),
                "cEAN_Trib" => '',
                "uniTrib" => $data['produtos'][$i]->unidade,
                "qtdeTrib" => $data['produtos'][$i]->quantidade,
                "valUniTrib" => number_format((float) $data['produtos'][$i]->valor_venda, 2, '.', ''),
                "valorFrete" => '', //deixar em branco
                "valorSeguro" => '', //deixar em branco
                "valorDesconto" => '', //deixar em branco   
                "valorOutros" => '', //deixar em branco   
                "indTot" => 1, // | 1 = somar ao valor total da NFe | 0 = nao somar ao vlr tot da nota |
                "numPedido" => $solicitacao_cliente_id,
                "itemPedido" => $n,
                "prodCEST" => $data['produtos'][$i]->cest,
                /* DESCRIÇÃO DO PRODUTO(informações adicionais. Ex: Validade, Lote e etc) */
                "prodDescricao" => 'Lote: ' . $data['produtos'][$i]->lote . ' - ' . date('d/m/Y', strtotime($data['produtos'][$i]->validade)),
                //ICMS
                "orig_ICMS" => '0',
                "cst_ICMS" => '40',
                //CASO SEJA 40, 41 OU 50, SERÃO NECESSARIAS APENAS AS INFORMAÇÕES ACIMAS
                "modBC_ICMS" => '3',
                "valorBC_ICMS" => 0,
                "percICMS_ICMS" => 0, //tag pICMS
                "valorICMS_ICMS" => 0,
                //IPI
                "codEnq_IPI" => '999',
                "cst_IPI" => 99, //CRIAR UM CST EXCLUSIVO PARA O IPI
                "valorBC_IPI" => 0,
                "percIPI_IPI" => 0,
                "valorIPI_IPI" => 0,
                //PIS
                "cst_PIS" => 7,
                "valorBC_PIS" => 0,
                "percPIS_PIS" => 0,
                "valorPIS_PIS" => 0,
                "qBCProd" => '',
                "vAliqProd" => '',
                //COFINS
                "cst_COFINS" => 7,
                "valorBC_COFINS" => 0,
                "percPIS_COFINS" => 0,
                "valorCOFINS_COFINS" => 0,
                /* VALOR TOTAL DE IMPOSTO */
                "valTotImposto" => 0
            );
        }

        //VALORES TOTAIS DA NOTA
        $totalNota = array(
            "totalBC" => number_format(0, 2, '.', ''),
            "totalICMS" => number_format(0, 2, '.', ''),
            "totalIPI" => number_format(0, 2, '.', ''),
            "totalPIS" => number_format(0, 2, '.', ''),
            "totalCOFINS" => number_format(0, 2, '.', ''),
            "totalProduto" => number_format($totalProduto, 2, '.', ''),
            "totalImposto" => number_format(0, 2, '.', '')
        );

        require_once ('/home/sisprod/projetos/administrativo/application/libraries/nfephp/vendor/nfephp-org/nfephp/bootstrap.php');

        // GERA O XML PRINCIPAL
        require_once ('/home/sisprod/projetos/administrativo/application/libraries/nfephp/arquivosNfe/geraEspelhoNota.php');

        $caminho = "/home/sisprod/projetos/administrativo/upload/nfe";
        if (is_dir("{$caminho}/{$solicitacao_cliente_id}")) {
            system("rm -R {$caminho}/{$solicitacao_cliente_id}");
        }
        mkdir("{$caminho}/{$solicitacao_cliente_id}");
        mkdir("{$caminho}/{$solicitacao_cliente_id}/espelho");
        chmod($caminho, 0777);

        $filename = "{$caminho}/{$solicitacao_cliente_id}/espelho/{$chave}-nfe.xml"; // Ambiente Linux
        $arq = fopen($filename, 'w+');
        fwrite($arq, $xml);
        fclose($arq);
        chmod($filename, 0777);

        // GERANDO DANFE
        require_once ('/home/sisprod/projetos/administrativo/application/libraries/nfephp/arquivosNfe/geraEspelhoDanfe.php');
    }

    function impressaorecibo($estoque_solicitacao_id) {

        $this->load->plugin('mpdf');

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

        $html = $this->load->View('estoque/impressaorecibo', $data, true);
        pdf($html);
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
        $this->load->plugin('mpdf');
        $data['solicitacao_id'] = $estoque_solicitacao_id;
        $data['estoque_solicitacao_id'] = $estoque_solicitacao_id;
        $data['empresa'] = $this->solicitacao->empresa();
        $data['destinatario'] = $this->solicitacao->listadadossolicitacaoliberada($estoque_solicitacao_id);
        $data['nome'] = $this->solicitacao->solicitacaonome($estoque_solicitacao_id);
        $data['produtossaida'] = $this->solicitacao->listarsaidaitem($estoque_solicitacao_id);
        $data['usuario'] = $this->solicitacao->usuarioemitente();
//        $data['produtossaida'] = $this->solicitacao->listaritemliberado($estoque_solicitacao_id);
        $html = $this->load->View('estoque/impressaosaida', $data, true);
        
        pdf($html, null, null,null,'',true);
    }

    function imprimirsimples($estoque_solicitacao_id) {
        $this->load->plugin('mpdf');

        $data['solicitacao_id'] = $estoque_solicitacao_id;
        $data['estoque_solicitacao_id'] = $estoque_solicitacao_id;
        $data['empresa'] = $this->solicitacao->empresa();
        $data['destinatario'] = $this->solicitacao->listadadossolicitacaoliberada($estoque_solicitacao_id);
        $data['nome'] = $this->solicitacao->solicitacaonome($estoque_solicitacao_id);
        $data['produtossaida'] = $this->solicitacao->listarsaidaitem($estoque_solicitacao_id);
        $data['usuario'] = $this->solicitacao->usuarioemitente();
//        $this->load->View('estoque/impressaosaidasimples', $data);
        $html = $this->load->View('estoque/impressaosaidasimples', $data, true);
        pdf($html, null, null,null,'',true);
    }

    function imprimirliberadasimples($estoque_solicitacao_id) {
        $this->load->plugin('mpdf');
        $data['solicitacao_id'] = $estoque_solicitacao_id;
        $data['empresa'] = $this->solicitacao->empresa();
        $data['destinatario'] = $this->solicitacao->listadadossolicitacaoliberada($estoque_solicitacao_id);
        $data['estoque_solicitacao_id'] = $estoque_solicitacao_id;
        $data['nome'] = $this->solicitacao->solicitacaonomeliberado($estoque_solicitacao_id);
        $data['produtossaida'] = $this->solicitacao->listaritemliberado($estoque_solicitacao_id);
        $html = $this->load->View('estoque/impressaoliberadasimples', $data, true);
        pdf($html);
        
    }

    function imprimirliberada($estoque_solicitacao_id) {

        $this->load->plugin('mpdf');
        $data['solicitacao_id'] = $estoque_solicitacao_id;
        $data['empresa'] = $this->solicitacao->empresa();
        $data['destinatario'] = $this->solicitacao->listadadossolicitacaoliberada($estoque_solicitacao_id);
        $data['estoque_solicitacao_id'] = $estoque_solicitacao_id;
        $data['nome'] = $this->solicitacao->solicitacaonomeliberado($estoque_solicitacao_id);
        $data['produtossaida'] = $this->solicitacao->listaritemliberado($estoque_solicitacao_id);
        $html = $this->load->View('estoque/impressaoliberada', $data, true);
        pdf($html);
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
            $data['mensagem'] = 'Selecione um produto valido.';
            $this->session->set_flashdata('message', $data['mensagem']);
        } elseif ($_POST['txtqtde'] == '') {
            $data['mensagem'] = 'Insira uma quantidade valida.';
            $this->session->set_flashdata('message', $data['mensagem']);
        } elseif ($_POST['valor'] == '') {
            $data['mensagem'] = 'Valor do produto nao configurado adequadamente.';
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
            
            $solicitacao_cliente = $this->solicitacao->listarsolicitacaofaturamentocliente($_POST['estoque_solicitacao_id']);
            
            

            if ($solicitacao_cliente[0]->boleto == 't') {
                $valor = $_POST['valor1'];
                $descricao_id = $_POST['formapamento1'];
                $forma_id = $_POST['forma_pagamento_1'];
                $verifica = $this->boleto->gravarsolicitacaoboleto($valor, $solicitacao_id, $descricao_id, $forma_id, $credor_devedor_id, $contrato_id);
            }
            
            if($solicitacao_cliente[0]->financeiro == 't'){
                $this->solicitacao->gravarfinanceirofaturamento();
            }

            if ($verifica) {
                $data['mensagem'] = 'Faturado com sucesso.';
            } else {
                $data['mensagem'] = 'Erro ao Faturar.';
            }
        } else {
            $data['mensagem'] = 'Erro ao Faturar. Valor total diferente de 0!';
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
        $data['entregadores'] = $this->solicitacao->listarentregadores();
        $data['forma_pagamento'] = $this->solicitacao->formadepagamento();
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
