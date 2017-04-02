<?php

ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
error_reporting(E_ALL);

use NFePHP\NFe\ToolsNFe;

$nfe = new ToolsNFe($config);
$nfe->setModelo($modelo);

$aResposta = array();
$chave = $chave;
$nProt = $numProtocolo;
$tpAmb = $tpAmbiente;
$xJust = $motivo;
$retorno = $nfe->sefazCancela($chave, $tpAmb, $xJust, $nProt, $aResposta);
//echo '<br><br><PRE>';
//echo htmlspecialchars($nfe->soapDebug);
//echo '</PRE><BR>';
//print_r($aResposta);
//echo "<br>";
