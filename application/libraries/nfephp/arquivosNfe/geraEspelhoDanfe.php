<?php
ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
error_reporting(E_ALL);

use NFePHP\NFe\ToolsNFe;
use NFePHP\Extras\Danfe;
use NFePHP\Common\Files\FilesFolders;

$nfe = new ToolsNFe($config);

$xmlProt = "{$caminho}/{$solicitacao_cliente_id}/espelho/{$chave}-nfe.xml";
$docxml = FilesFolders::readFile($xmlProt);
$danfe = new Danfe($docxml, 'P', 'A4', $nfe->aConfig['aDocFormat']['pathLogoFile'], 'I', '');
$id = $danfe->montaDANFE();

$pdfDanfe = "{$caminho}/{$solicitacao_cliente_id}/espelho/{$chave}-danfe.pdf";

$salva = $danfe->printDANFE($pdfDanfe, 'F'); //Salva o PDF na pasta

chmod($pdfDanfe, 0777);

/*
 * OPÇÕES:
 *      F = Salva o arquivo
 *      I = Abre no navegador
 *      D = Faz o download do arquivo
 *      S = Manipular o arquivo manualmente (caso queira usar tem que ir no codigo e colocar o que desejar)  
 */
$abre = $danfe->printDANFE("{$pdfDanfe}", 'I'); //Abre o PDF no Navegador