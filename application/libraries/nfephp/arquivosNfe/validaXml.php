<?php

require_once ('./application/libraries/nfephp/vendor/nfephp-org/nfephp/bootstrap.php');

use NFePHP\NFe\ToolsNFe;

$nfe = new ToolsNFe($config);
$nfe->setModelo('55');

$tpAmb = $tipoAmbiente;
//$aXml = file_get_contents("/home/sisprod/projetos/administrativo/upload/nfe/{$solicitacao_cliente_id}/assinada/{$chave}-nfe.xml"); // Ambiente Linux
$validacaoXSD = false;

if (!$nfe->validarXml($xml) || sizeof($nfeTools->errors)) {
    $validacaoXSD = true;
    $mensagem = "<h4>Foi encontrado os seguintes erros no XML gerado: </h4><br>"
            . "<ul>";
//    echo "<pre>";
//    var_dump($nfe->errors);die;
    foreach ($nfe->errors as $erro) {
        
        if (is_array($erro)) {
            $ie = false;
            $crt = false;
            $cep = false;
            $ncm = false;
            $indie = false;
            
            foreach ($erro as $err) {
                if(!(strripos($err, "Elemento 'IE'")) && !$ie){
                    $ie = true;
                    $mensagem .= "<li> A inscriçao estadual de sua empresa nao esta configurada corretamente.</li>";
                }
                if(!(strripos($err, "Elemento 'CRT'")) && !$crt){
                    $crt = true;
                    $mensagem .= "<li> O codigo de regime tributario de sua empresa nao esta configurado corretamente.</li>";
                }
                if(!(strripos($err, "Elemento 'CEP'")) && !$cep){
                    $cep = true;
                    $mensagem .= "<li> O CEP de sua empresa nao esta configurado corretamente.</li>";
                }
                if(!(strripos($err, "Elemento 'indIEDest'")) && !$indie){
                    $indie = true;
                    $mensagem .= "<li> A inscriçao estadual de seu cliente nao esta configurada corretamente.</li>";
                }
                if(!(strripos($err, "Elemento 'NCM'")) && !$ncm){
                    $ncm = true;
                    $mensagem .= "<li> O NCM do(s) produto(s) nao esta configurado corretamente.</li>";
                }
            }
        } else {
//            echo "$erro <br>";
        }
    }
    
    $mensagem .= "</ul>"
            . "<h4>Verifique estes itens e tente novamente.";
} 
//echo "NFe Valida !";
