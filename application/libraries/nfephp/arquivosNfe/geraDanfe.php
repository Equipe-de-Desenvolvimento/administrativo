<?php

/**
 * ATENÇÃO : Esse exemplo usa classe PROVISÓRIA que será removida assim que 
 * a nova classe DANFE estiver refatorada e a pasta EXTRAS será removida.
 */
ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
error_reporting(E_ALL);

use NFePHP\NFe\ToolsNFe;
use NFePHP\Extras\Danfe;
use NFePHP\Common\Files\FilesFolders;

$nfe = new ToolsNFe($config);
// Uso da nomeclatura '-danfe.pdf' para facilitar a diferenciação entre PDFs DANFE e DANFCE salvos na mesma pasta...
$xmlProt = "{$caminho}/{$solicitacao_cliente_id}/validada/{$chave}-protNFe.xml";
$docxml = FilesFolders::readFile($xmlProt);
$danfe = new Danfe($docxml, 'P', 'A4', $nfe->aConfig['aDocFormat']['pathLogoFile'], 'I', '');
$id = $danfe->montaDANFE();

$pdfDanfe = "{$caminho}/{$solicitacao_cliente_id}/validada/{$chave}-danfe.pdf";

$salva = $danfe->printDANFE($pdfDanfe, 'F'); //Salva o PDF na pasta

chmod($pdfDanfe, 0777);

/*
 * OPÇÕES:
 *      F = Salva o arquivo
 *      I = Abre no navegador
 *      D = Faz o download do arquivo
 *      S = Manipular o arquivo manualmente (caso queira usar tem que ir no codigo e colocar o que desejar)  
 */
if(isset($download) && @$download){
    $abre = $danfe->printDANFE("{$pdfDanfe}", 'D');
}
else{
    $abre = $danfe->printDANFE("{$pdfDanfe}", 'I'); //Abre o PDF no Navegador
}