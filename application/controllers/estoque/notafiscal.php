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
        for($i = 1; $i <= count($data['produtos']); $i++){
            $dadosProdutos[$i] = array(
                /* Dados Basicos */
                "numItem" => $i,
                "codigoProduto" => $i,
                "cEAN" => $i, //codigo de barras do produto (cod GTIN). Caso não possua, não criar esta TAG.
                "nomeProd" => $i,
                "ncm" => $i,
                "ex_tipi" => $i,
                "cfop" => $i,
                "unCompra" => $i,
                "qtdeCompra" => $i,
                "valUniComp" => $i,
                "valProduto" => $i,
                "cEAN_Trib" => $i,
                "uniTrib" => $i,
                "valorFrete" => $i,
                "valorSeguro" => $i,
                "valorDesconto" => $i,
            );
        }
        
        /*
         * POR ALGUM MOTIVO, O PHP NÃO PERMITE O USO DO COMANDO 'USE'
         * DENTRO DE UMA FUNÇÃO/METODO, POR ISSO, TODO O XML DA NFe SERA 
         * GERADO DENTRO DO ARQUIVO 'geraXml.php'
         */
        
        //endereco do emitente
        require_once ('/home/johnny/projetos/administrativo/application/libraries/nfephp/vendor/nfephp-org/nfephp/bootstrap.php');
        require_once ('/home/johnny/projetos/administrativo/application/libraries/nfephp/arquivosNfe/geraXml.php');
    }

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
