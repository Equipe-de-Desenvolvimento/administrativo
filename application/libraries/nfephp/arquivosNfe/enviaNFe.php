<?php

require_once ('/home/sisprod/projetos/administrativo/application/libraries/nfephp/vendor/nfephp-org/nfephp/bootstrap.php');

use NFePHP\NFe\ToolsNFe;

ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
error_reporting(E_ALL);

$nfe = new ToolsNFe($config);
$nfe->setModelo('55'); //55 = nf , 65 = nfc

$aResposta = array();
$tpAmb = $tipoAmbiente;
//$aXml = file_get_contents("/home/sisprod/projetos/administrativo/upload/nfe/{$solicitacao_cliente_id}/assinada/{$chave}-nfe.xml"); // Ambiente Linux
$idLote = '';
$indSinc = '0';
$flagZip = false;
$retorno = $nfe->sefazEnviaLote($xml, $tpAmb, $idLote, $aResposta, $indSinc, $flagZip);

if (is_dir('/home/sisprod/projetos/administrativo/upload/nfe/' . $solicitacao_cliente_id . '/')) {
    chmod('/home/sisprod/projetos/administrativo/upload/nfe/' . $solicitacao_cliente_id . '/', 0777);
}
//echo '<pre>';
//echo htmlspecialchars($nfe->soapDebug), "<hr>";
//print_r($aResposta);
//print_r($retorno);
//die;
if (count(@$aResposta['prot'][0]) == 0 OR empty($aResposta['prot'])) {
    $data['mensagem'] = $aResposta['xMotivo'];
    $this->session->set_flashdata('message', $data['mensagem']);
    header("Location: " . base_url() . "estoque/notafiscal/carregarnotafiscalopcoes/{$solicitacao_cliente_id}/{$notafiscal_id}");
    exit;
} else {
    $data['mensagem'] = $aResposta['prot'][0]['xMotivo'];
    $this->session->set_flashdata('message', $data['mensagem']);
    
    if ($aResposta['prot'][0]['nProt'] == '') {
        header("Location: " . base_url() . "estoque/notafiscal/carregarnotafiscalopcoes/{$solicitacao_cliente_id}/{$notafiscal_id}");
        exit;
    } else {
        $protocoloRecibo = $aResposta['prot'][0]['nProt'];
    }
}
