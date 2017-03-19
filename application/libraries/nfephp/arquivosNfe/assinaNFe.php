<?php

require_once ('/home/johnny/projetos/administrativo/application/libraries/nfephp/vendor/nfephp-org/nfephp/bootstrap.php');

use NFePHP\NFe\ToolsNFe;

$nfe = new ToolsNFe($config);

// $filename = "/var/www/nfe/homologacao/entradas/{$chave}-nfe.xml"; // Ambiente Linux
$filename = "/home/johnny/projetos/administrativo/upload/nfe/{$solicitacao_cliente_id}/homologada/{$chave}-nfe.xml"; // Ambiente Linux
$xml = file_get_contents($filename);
$xml = $nfe->assina($xml);

if (!is_dir("/home/johnny/projetos/administrativo/upload/nfe/{$solicitacao_cliente_id}/assinada/")) {
    mkdir("/home/johnny/projetos/administrativo/upload/nfe/{$solicitacao_cliente_id}/assinada");
    $destino = "/home/johnny/projetos/administrativo/upload/nfe/{$solicitacao_cliente_id}/assinada";
    chmod($destino, 0777);
}

$filename = "/home/johnny/projetos/administrativo/upload/nfe/{$solicitacao_cliente_id}/assinada/{$chave}-nfe.xml"; // Ambiente Linux
file_put_contents($filename, $xml);
chmod($filename, 0777);
//echo $chave;
