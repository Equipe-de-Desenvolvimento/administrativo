<?php

require_once ('/home/sisprod/projetos/administrativo/application/libraries/nfephp/vendor/nfephp-org/nfephp/bootstrap.php');

use NFePHP\NFe\ToolsNFe;

$nfe = new ToolsNFe($config);

// $filename = "/var/www/nfe/homologacao/entradas/{$chave}-nfe.xml"; // Ambiente Linux
$filename = "/home/sisprod/projetos/administrativo/upload/nfe/{$solicitacao_cliente_id}/homologada/{$chave}-nfe.xml"; // Ambiente Linux
$xml = file_get_contents($filename);
$xml = $nfe->assina($xml);

if (!is_dir("/home/sisprod/projetos/administrativo/upload/nfe/{$solicitacao_cliente_id}/assinada/")) {
    mkdir("/home/sisprod/projetos/administrativo/upload/nfe/{$solicitacao_cliente_id}/assinada");
    $destino = "/home/sisprod/projetos/administrativo/upload/nfe/{$solicitacao_cliente_id}/assinada";
    chmod($destino, 0777);
}

$filename = "/home/sisprod/projetos/administrativo/upload/nfe/{$solicitacao_cliente_id}/assinada/{$chave}-nfe.xml"; // Ambiente Linux
file_put_contents($filename, $xml);
chmod($filename, 0777);
//echo $chave;
