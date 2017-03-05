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

    function carregarnotafiscalopcoes($solicitacao_cliente_id) {
//        die('morreu');
        $data['solicitacao_cliente_id'] = $solicitacao_cliente_id;
        $this->loadView('estoque/notafiscal-ficha', $data);
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
                "pathCertsFiles":"\/home\/johnny\/projetos\/administrativo\/upload\/certificado\/'. $data['empresa'][0]->empresa_id. '\/",
                "siteUrl":"' . base_url() . '\/ambulatorio\/empresa",
                "schemesNFe":"PL_008i2",
                "schemesCTe":"PL_CTe_200",
                "schemesMDFe":"PL_MDFe_100",
                "schemesCLe":"","schemesNFSe":"",
                "razaosocial":"' . $data['empresa'][0]->razao_social . '",
                "nomefantasia":"' . $data['empresa'][0]->empresa . '",
                "siglaUF":"CE",
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

    function gerarnotafiscal($solicitacao_cliente_id) {
        
        $data['empresa'] = $this->notafiscal->empresa();
        $data['destinatario'] = $this->notafiscal->listaclientenotafiscal($solicitacao_cliente_id);
        $data['produtos'] = $this->notafiscal->listarsolicitacaosnota($solicitacao_cliente_id);
        foreach ($data['produtos'] as $value) {
            if ($value->descricao_cfop != ''){
                $natureza_operacao = $value->descricao_cfop;
                break;
            }
            else{
                continue;
            }
        }
//        $natureza = descricao_cfop

        $config = $this->geraconfignfephp();
        $dadosNFe = array(
            /* Dados da NFe - infNFe */
            'cUF' => '23', //codigo do estado (IBGE)
            'cMunFG' => $data['empresa'][0]->codigo_ibge, //codigo do municipio da empresa (IBGE)
            'cNF' => $this->utilitario->tamanho_string($solicitacao_cliente_id, 8, 'numero'),
            'naturezaOpe' => $natureza_operacao,
            'numSerie' => 1, //deve ser incrementado a cada nova nota_fiscal gerada
            'numNF' => $solicitacao_cliente_id,
            'tipoNF' => '1', // 0 = entrada | 1 = saida
            'identificaDestOp' => '1', // Olhar se as UF's da empresa e do destinatario sao as mesmas.
            'indPres' => '1', //Tipo de Compra. (1=Presencial, 2=Nao Presencial e etc...)
            'verProc' => '1.0', //Versao do SISTEMA STG
            
            
        );
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
