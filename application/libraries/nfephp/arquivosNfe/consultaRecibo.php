<?php
//ini_set('display_errors',1);
//ini_set('display_startup_erros',1);
//error_reporting(E_ALL);

require_once ('/home/sisprod/projetos/administrativo/application/libraries/nfephp/vendor/nfephp-org/nfephp/bootstrap.php');

use NFePHP\NFe\ToolsNFe;

$nfe = new ToolsNFe($config);
$nfe->setModelo('55');

$aResposta = array();
$tpAmb = $tipoAmbiente;
$dir123 = "{$caminho}/{$solicitacao_cliente_id}/homologacao/temporarias/" . $data;

if (is_dir($dir123)) {
    if ($dh = opendir($dir123)) {
        while (($file = readdir($dh)) !== false) {
            if ($file == '.' || $file == '..')
                continue;

            $explode = explode("-", $file);

            if ($explode[1] != 'retEnviNFe.xml') {
                continue;
            }
            //pegando o conteudo do arquivo de retorno
            $ret = file($dir123 . '/' . $file);

            //Pegando o conteudo da Tag <nRec>
            $retEnviNFe = preg_match_all("/<nRec>(.*)<\/nRec>/i", $ret[0], $tagRecibo);
            $numeroRecibo = substr($tagRecibo[0][0], 6, 15);
        }
    }
    //fechando a conexão com o diretorio
    closedir($dh);
}

//consultando situacao do recibo
$retorno = $nfe->sefazConsultaRecibo($numeroRecibo, $tpAmb, $aResposta);

// Verificando o retorno da Sefaz e buscando por Erros.
if (count(@$aResposta['aProt'][0]) == 0 OR empty($aResposta['aProt'])) {
    $mensagem = 'Cod '. $aResposta['cStat']. ': '. $aResposta['xMotivo'];
    $this->session->set_flashdata('message', $mensagem);
    header("Location: " . base_url() . "estoque/notafiscal/carregarnotafiscalopcoes/{$solicitacao_cliente_id}/{$notafiscal_id}");
    exit;
} else {
    
    $mensagem = 'Cod '. $aResposta['aProt'][0]['cStat']. ': '.$aResposta['aProt'][0]['xMotivo'];
    $this->session->set_flashdata('message', $mensagem);
    
    if ($aResposta['aProt'][0]['nProt'] == '') {
        header("Location: " . base_url() . "estoque/notafiscal/carregarnotafiscalopcoes/{$solicitacao_cliente_id}/{$notafiscal_id}");
        exit;
    }
}
//echo '<hr><pre>', htmlspecialchars($nfe->soapDebug), <hr>;
//print_r($aResposta);
//echo "</pre><hr>";

$pathNFefile = "{$caminho}/{$solicitacao_cliente_id}/validada/{$chave}-nfe.xml";
if (! $indSinc) {
    $pathProtfile = "{$caminho}/{$solicitacao_cliente_id}/homologacao/temporarias/{$data}/{$numeroRecibo}-retConsReciNFe.xml";
} else {
    $pathProtfile = "{$caminho}/{$solicitacao_cliente_id}/homologacao/temporarias/{$data}/{$numeroRecibo}-retEnviNFe.xml";
}

$saveFile = true;
//Adicionando TAG de protocolo ao XML
$xmlFinalizado = $nfe->addProtocolo($pathNFefile, $pathProtfile, $saveFile);

//echo '<hr><pre>', htmlspecialchars($xmlFinalizado), "</pre>";

/* SE TODAS AS ETAPAS TIVEREM SIDO BEM SUCEDIDAS O DANFe JA PODE SER GERADO */
?>