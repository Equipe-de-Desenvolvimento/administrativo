<?php

require_once ('/home/ubuntu/projetos/administrativo/application/libraries/nfephp/vendor/nfephp-org/nfephp/bootstrap.php');

use NFePHP\NFe\ToolsNFe;

//ini_set('display_errors', 1);
//ini_set('display_startup_erros', 1);
//error_reporting(E_ALL);

$nfe = new ToolsNFe($config);
$nfe->setModelo('55'); //55 = nf , 65 = nfc

$aResposta = array();
$tpAmb = $tipoAmbiente;
$idLote = '';
$flagZip = false;
$retorno = $nfe->sefazEnviaLote($xml, $tpAmb, $idLote, $aResposta, $indSinc, $flagZip);

if (is_dir('/home/ubuntu/projetos/administrativo/upload/nfe/' . $solicitacao_cliente_id . '/')) {
    chmod('/home/ubuntu/projetos/administrativo/upload/nfe/' . $solicitacao_cliente_id . '/', 0777);
}
//echo '<pre>', htmlspecialchars($nfe->soapDebug), "<hr>";
//print_r($aResposta);
//print_r($retorno);
//die;
if (count(@$aResposta['prot'][0]) == 0 OR empty($aResposta['prot'])) {
    if ($aResposta['cStat'] != '103') {
        $data['mensagem'] = $aResposta['xMotivo'];
        $this->session->set_flashdata('message', $data['mensagem']);
        header("Location: " . base_url() . "estoque/notafiscal/carregarnotafiscalopcoes/{$solicitacao_cliente_id}/{$notafiscal_id}");
        exit;
    }
} else {
    if ($aResposta['prot'][0]['nProt'] == '') {
        $data['mensagem'] = $aResposta['prot'][0]['xMotivo'];
        $this->session->set_flashdata('message', $data['mensagem']);

        header("Location: " . base_url() . "estoque/notafiscal/carregarnotafiscalopcoes/{$solicitacao_cliente_id}/{$notafiscal_id}");
        exit;
    }
}
