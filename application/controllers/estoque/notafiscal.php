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
class Notafiscal extends BaseController {

    function Notafiscal() {
        parent::Controller();
        $this->load->model('estoque/notafiscal_model', 'notafiscal');
        $this->load->model('cadastro/convenio_model', 'convenio');
        $this->load->model('estoque/fornecedor_model', 'fornecedor');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index() {
        $this->pesquisar();
    }

    function pesquisar($args = array()) {

        $this->loadView('estoque/notafiscal-lista', $args);
    }

    function carregarnotafiscalopcoes($solicitacao_cliente_id, $notafiscal_id = null) {
        $data['solicitacao_cliente_id'] = $solicitacao_cliente_id;
        $data['notafiscal_id'] = $notafiscal_id;
        $data['destinatario'] = $this->notafiscal->listaclientenotafiscal($solicitacao_cliente_id);
        $data['produtos'] = $this->notafiscal->listarresumosolicitacao($solicitacao_cliente_id);
//        echo "<pre>";
//        var_dump($data['produtos']);die;
        $this->loadView('estoque/notafiscal-ficha', $data);
    }

    function informacoesnotafiscal($solicitacao_cliente_id, $notafiscal_id = null) {
        $data['solicitacao_cliente_id'] = $solicitacao_cliente_id;
        $data['notafiscal_id'] = $notafiscal_id;
        $this->loadView('estoque/notafiscal-form', $data);
    }

    function gravarnotafiscaleletronica() {
        $solicitacao_id = $_POST['estoque_cliente_id'];
        $notafiscal_id = $this->notafiscal->gravarnotafiscaleletronica();
        $this->gerarnotafiscal($solicitacao_id, $notafiscal_id);
        redirect(base_url() . "estoque/notafiscal/carregarnotafiscalopcoes/$solicitacao_id/$notafiscal_id");
    }

    function geraconfignfephp() {
        $data['empresa'] = $this->notafiscal->empresa();
        $json = '
        {
                "atualizacao":"' . date("Y-m-d H:i:s") . '",
                "tpAmb": 2, 
                "pathXmlUrlFileNFe":"nfe_ws3_mod55.xml",
                "pathXmlUrlFileCTe":"cte_ws2.xml",
                "pathXmlUrlFileMDFe":"mdf2_ws1.xml",
                "pathXmlUrlFileCLe":"",
                "pathXmlUrlFileNFSe":"",
                "pathNFeFiles":"\/home\/johnny\/projetos\/administrativo\/upload\/nfe\/",
                "pathCTeFiles":"",
                "pathMDFeFiles":"",
                "pathCLeFiles":"",
                "pathNFSeFiles":"",
                "pathCertsFiles":"\/home\/johnny\/projetos\/administrativo\/upload\/certificado\/' . $data['empresa'][0]->empresa_id . '\/",
                "siteUrl":"' . base_url() . '\/ambulatorio\/empresa",
                "schemesNFe":"PL_008i2",
                "schemesCTe":"PL_CTe_200",
                "schemesMDFe":"PL_MDFe_100",
                "schemesCLe":"","schemesNFSe":"",
                "razaosocial":"' . $data['empresa'][0]->razao_social . '",
                "nomefantasia":"' . $data['empresa'][0]->empresa . '",
                "siglaUF":"'.$this->utilitario->codigo_uf($data['empresa'][0]->codigo_ibge, 'sigla').'",
                "cnpj":"' . $this->utilitario->remover_caracter($data['empresa'][0]->cnpj) . '",
                "ie":"' . $this->utilitario->remover_caracter($data['empresa'][0]->inscricao_estadual) . '",
                "im":"' . $this->utilitario->remover_caracter($data['empresa'][0]->inscricao_municipal) . '",
                "iest":"' . $this->utilitario->remover_caracter($data['empresa'][0]->inscricao_estadual_st) . '",
                "cnae":"' . $this->utilitario->remover_caracter($data['empresa'][0]->cnae) . '",
                "regime": ' . $this->utilitario->remover_caracter($data['empresa'][0]->cod_regime_tributario) . ',
                "tokenIBPT":"",
                "tokenNFCe":"",
                "tokenNFCeId":"",
                "certPfxName":"' . $data['empresa'][0]->certificado_nome . '",
                "certPassword":"' . $data['empresa'][0]->certificado_senha . '",
                "certPhrase":"",
                "aDocFormat":
                {
                        "format":"L",
                        "paper":"A4",
                        "southpaw":"1",
                        "pathLogoFile":"\/home\/johnny\/projetos\/administrativo\/img\/notafiscal\/empresa.jpg",
                        "pathLogoNFe":"\/home\/johnny\/projetos\/administrativo\/img\/notafiscal\/logo-nfe.png",
                        "pathLogoNFCe":"\/home\/johnny\/projetos\/administrativo\/img\/notafiscal\/logo-nfce.png",
                        "logoPosition":"L",
                        "font":"Times",
                        "printer":""
                },
                "aMailConf":
                {
                        "mailAuth":"1",
                        "mailFrom":false,
                        "mailSmtp":"",
                        "mailUser":"",
                        "mailPass":"",
                        "mailProtocol":"",
                        "mailPort":"",
                        "mailFromMail":false,
                        "mailFromName":"",
                        "mailReplayToMail":false,
                        "mailReplayToName":"",
                        "mailImapHost":null,
                        "mailImapPort":null,
                        "mailImapSecurity":null,
                        "mailImapNocerts":null,
                        "mailImapBox":null
                },
                "aProxyConf":
                {
                        "proxyIp":"",
                        "proxyPort":"",
                        "proxyUser":"",
                        "proxyPass":""
                }
        }';

        return $json;
    }

    function gerarnotafiscal($solicitacao_cliente_id, $notafiscal_id) {

        $notafiscal = $this->notafiscal->instanciarnotafiscal($notafiscal_id);
        $data['empresa'] = $this->notafiscal->empresa();
        $data['destinatario'] = $this->notafiscal->listaclientenotafiscal($solicitacao_cliente_id);
        $data['produtos'] = $this->notafiscal->listarsolicitacaosnota($solicitacao_cliente_id);
        if($this->utilitario->codigo_uf($data['empresa'][0]->codigo_ibge) == $this->utilitario->codigo_uf($data['destinatario'][0]->codigo_ibge)){
            $data['identificaDestOp'] = '1';
        }
        else {
            $data['identificaDestOp'] = '2';
        }
        
        //Essa variavel de configuração sera usada para carregar as configurações iniciais da NFe
        $config = $this->geraconfignfephp();
        
        $dadosNFe = array(
            /* Dados da NFe - infNFe */
            'verProc' => '1.0', //Versao do SISTEMA STG
            'cUF' => $this->utilitario->codigo_uf($data['empresa'][0]->codigo_ibge, 'codigo'), //codigo do estado (IBGE)
            'identificaDestOp' => $data['identificaDestOp'], // Olhar se as UF's da empresa e do destinatario sao as mesmas.
            'cNF' => $this->utilitario->tamanho_string($solicitacao_cliente_id, 8, 'numero'),
            'cMunFG' => $data['empresa'][0]->codigo_ibge, //codigo do municipio da empresa (IBGE)
            'naturezaOpe' => $notafiscal[0]->natureza_operacao,
            'modeloNota' => $notafiscal[0]->modelo_nf,
            'numSerie' => $notafiscal[0]->notafiscal_id, //deve ser incrementado a cada nova nota_fiscal gerada
            'numNF' => $notafiscal[0]->notafiscal_id,
            'tipoNF' => $notafiscal[0]->tipo_nf, // 0 = entrada | 1 = saida
            'indPres' => $notafiscal[0]->indicador_presenca, // Tipo de Compra. (1=Presencial, 2=Nao Presencial e etc...)
            'finalidadeNFe' => $notafiscal[0]->finalidade_nf,
            'indicadorPagamento' => '0', //0=Pagamento à vista; 1=Pagamento a prazo; 2=Outros
            
            /*ENDEREÇO DO EMITENTE*/
            "logradouro" => $data['empresa'][0]->logradouro,
            "numero" => $data['empresa'][0]->numero,
            "complemento" => $data['empresa'][0]->complemento,
            "bairro" => $data['empresa'][0]->bairro,
            "codMunicipio" => $data['empresa'][0]->codigo_ibge,
            "nomMunicipio" => $data['empresa'][0]->municipio,
            "UF" => $this->utilitario->codigo_uf($data['empresa'][0]->codigo_ibge, 'sigla'),
            "cep" => $this->utilitario->remover_caracter($data['empresa'][0]->cep),
            "fone" => $this->utilitario->remover_caracter($data['empresa'][0]->telefone), 
            
            /*DADOS DO DESTINATARIO*/
            "destCNPJ" => $data['destinatario'][0]->cnpj,
            "destCPF" => '',
            "destNOME" => $data['destinatario'][0]->nome,
            "destIND_IE" => '1', //criar um novo campo na tb_estoque_cliente (VERIFICAR SE O CLIENTE É ISENTO DE IE)
            "destIE" => $data['destinatario'][0]->inscricao_estadual, 
            "destIM" => '', //criar um novo campo na tb_estoque_cliente
            "destEMAIL" => $data['destinatario'][0]->email,
            "destLOG" => $data['destinatario'][0]->logradouro, 
            "destNUM" => $data['destinatario'][0]->numero, 
            "destCOMP" => $data['destinatario'][0]->complemento, 
            "destBAIRRO" => $data['destinatario'][0]->bairro,
            "destCOD_MUN" => $data['destinatario'][0]->codigo_ibge,
            "destMUN" => $data['destinatario'][0]->municipio, 
            "destUF" => $this->utilitario->codigo_uf($data['destinatario'][0]->codigo_ibge, 'sigla'),
            "destCEP" => $data['destinatario'][0]->cep,
            "destFONE" => $this->utilitario->remover_caracter($data['destinatario'][0]->telefone)
        );
        
        /* DADOS DOS PRODUTOS */
        for($i = 0, $n = 1; $i <= count($data['produtos']); $i++, $n++){
            
            $percPis = 0.65;
            $valBC = ((int)$data['produtos'][$i]->quantidade * (float)$data['produtos'][$i]->valor_venda );
            $valTotICMS = $valBC * ( ((float)$data['produtos'][$i]->icms)/100 );
            $valTotIPI = $valBC * ( ((float)$data['produtos'][$i]->ipi)/100 );
            $valTotPIS = $valBC * ( $percPis/100 );
            
            
            $valTotImpostos = $valTotICMS+$valTotIPI+$valTotPIS;
            
            $dadosProdutos[$i] = array(
                /* Dados Basicos */
                "numItem" => $n,
                "codigoProduto" => $data['produtos'][$i]->estoque_produto_id, // Codigo de controle no sistema do cliente
                "cEAN" => $data['produtos'][$i]->codigo,
                "nomeProd" => $data['produtos'][$i]->descricao,
                "ncm" => $data['produtos'][$i]->ncm, 
                "ex_tipi" => '',
                "cfop" => $data['produtos'][$i]->codigo_cfop,
                "unCompra" => $data['produtos'][$i]->unidade,
                "qtdeCompra" => $data['produtos'][$i]->quantidade,
                "valUniComp" => $data['produtos'][$i]->valor_venda,
                "valProduto" => (int)$data['produtos'][$i]->quantidade * (float)$data['produtos'][$i]->valor_venda,
                "cEAN_Trib" => '',
                "uniTrib" => $data['produtos'][$i]->unidade,
                "qtdeTrib" => $data['produtos'][$i]->quantidade,
                "valUniTrib" => (int)$data['produtos'][$i]->quantidade * (float)$data['produtos'][$i]->valor_venda,
                "valorFrete" => '', //deixar em branco
                "valorSeguro" => '', //deixar em branco
                "valorDesconto" => '', //deixar em branco   
                "valorOutros" => '', //deixar em branco   
                "indTot" => 1, // | 1 = somar ao valor total da NFe | 0 = nao somar ao vlr tot da nota |
                "numPedido" => $solicitacao_cliente_id, 
                "itemPedido" => $n,
                "prodCEST" => $data['produtos'][$i]->cest,
                
                /* DESCRIÇÃO DO PRODUTO(informações adicionais. Ex: Validade, Lote e etc) */
                "prodDescricao" => '',
                
                /* CALCULO DE IMPOSTOS 
                +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ 
                * EXISTEM VARIAS MODALIDADES PARA O CALCULO DO ICMS, E CADA UMA DELAS 
                * DIFERE EM ALGUNS DETALHES. 
                  EXEMPLOS: 
                    + icms 00,
                    + icms 10,                         
                    + icms 20,                         
                    + icms 30,                         
                    + icms 41 entre outros.
                * CASO NECESSITE MUDAR O TIPO DE ICMS É BOM QUE OLHE NO ARQUIVO 'geraXml.php'
                * PARA ENTENDER QUAIS AS TAGS NECESSARIAS QUE DEVEM SER ACRESCENTADAS 
                * ENTRE OUTRAS INFORMAÇÕES          
                +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++     */
                //ICMS
                "orig_ICMS" => substr($data['produtos'][$i]->cst, 0, 1),
                "cst_ICMS" => substr($data['produtos'][$i]->cst, 1),
                //CASO SEJA 40, 41 OU 50, SERÃO NECESSARIAS APENAS AS INFORMAÇÕES ACIMAS
                "modBC_ICMS" => '3',
                "valorBC_ICMS" => (int)$data['produtos'][$i]->quantidade * (float)$data['produtos'][$i]->valor_venda,
                "percICMS_ICMS" => $data['produtos'][$i]->icms, //tag pICMS
                "valorICMS_ICMS" => $valTotICMS,
                
                //IPI
                "codEnq_IPI" => '999',
                "cst_IPI" => '', //CRIAR UM CST EXCLUSIVO PARA O IPI
                "valorBC_IPI" => (int)$data['produtos'][$i]->quantidade * (float)$data['produtos'][$i]->valor_venda,
                "percIPI_IPI" => $data['produtos'][$i]->ipi,
                "valorIPI_IPI" => $valTotIPI,
                
                //PIS
                "cst_PIS" => '', 
                "valorBC_PIS" => (int)$data['produtos'][$i]->quantidade * (float)$data['produtos'][$i]->valor_venda,
                "percPIS_PIS" => $percPis,
                "valorPIS_PIS" => $valTotPIS,
                "qBCProd" => '',
                "vAliqProd" => '',
                
                //CONFINS
                
                /* VALOR TOTAL DE IMPOSTO */
                "valTotImposto" => '',
            );
        }
        
        /*
         * POR ALGUM MOTIVO, O PHP NÃO PERMITE O USO DO COMANDO 'USE'
         * DENTRO DE UMA FUNÇÃO/METODO, POR ISSO, TODO O XML DA NFe SERA 
         * GERADO DENTRO DO ARQUIVO 'geraXml.php'
         */
        
        require_once ('/home/johnny/projetos/administrativo/application/libraries/nfephp/vendor/nfephp-org/nfephp/bootstrap.php');
        require_once ('/home/johnny/projetos/administrativo/application/libraries/nfephp/arquivosNfe/geraXml.php');
    }

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
