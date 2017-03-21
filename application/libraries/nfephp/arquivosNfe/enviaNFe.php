<?php
require_once ('/home/sisprod/projetos/administrativo/application/libraries/nfephp/vendor/nfephp-org/nfephp/bootstrap.php');

use NFePHP\NFe\ToolsNFe;

$nfe = new ToolsNFe($config);
$nfe->setModelo('55');

$aResposta = array();
$tpAmb = '2';
$aXml = file_get_contents("/home/sisprod/projetos/administrativo/upload/nfe/{$solicitacao_cliente_id}/assinada/{$chave}-nfe.xml"); // Ambiente Linux
$idLote = '';
$indSinc = '1';
$flagZip = false;
$retorno = $nfe->sefazEnviaLote($aXml, $tpAmb, $idLote, $aResposta, $indSinc, $flagZip);
echo '<br><br><pre>';
echo htmlspecialchars($nfe->soapDebug);
echo '</pre><br><br><pre>';
print_r($aResposta);
echo "</pre><br>";