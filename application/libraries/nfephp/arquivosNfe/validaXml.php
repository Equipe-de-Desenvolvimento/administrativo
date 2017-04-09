<?php
require_once ('/home/ubuntu/projetos/administrativo/application/libraries/nfephp/vendor/nfephp-org/nfephp/bootstrap.php');

use NFePHP\NFe\ToolsNFe;

$nfe = new ToolsNFe($config);
$nfe->setModelo('55');

$tpAmb = $tipoAmbiente;
//$aXml = file_get_contents("/home/ubuntu/projetos/administrativo/upload/nfe/{$solicitacao_cliente_id}/assinada/{$chave}-nfe.xml"); // Ambiente Linux

if (! $nfe->validarXml($xml) || sizeof($nfeTools->errors)) {
    echo "<meta charset='utf-8'/>"
    . "<h3>Erros na estrutura do XML... </h3>";    
    foreach ($nfe->errors as $erro) {
        if (is_array($erro)) { 
            foreach ($erro as $err) {
                echo "$err <br>";
            }
        } else {
            echo "$erro <br>";
        }
    }
    exit;
}
echo "NFe Valida !";