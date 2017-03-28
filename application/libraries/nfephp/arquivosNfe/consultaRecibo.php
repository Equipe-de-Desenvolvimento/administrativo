<?php

require_once ('/home/sisprod/projetos/administrativo/application/libraries/nfephp/vendor/nfephp-org/nfephp/bootstrap.php');

use NFePHP\NFe\ToolsNFe;

$nfe = new ToolsNFe($config);
$nfe->setModelo('55');

$aResposta = array();
$tpAmb = $tipoAmbiente;
$dir = "{$caminho}/{$solicitacao_cliente_id}/homologacao/temporarias/" . date('Ym');

if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
            if ($file == '.' || $file == '..')
                continue;

            $explode = explode("-", $file);
            
            if($explode[1] != 'retEnviNFe.xml'){
                continue;
            }
            echo $file, "<hr><pre>";
            $ret = file($dir.'/'.$file);
            $retEnviNFe = simplexml_load_string($ret[0]);
            foreach ($ret as $key => $value) {
               echo  $key, " => ", $value;
            }
//            print_r($retEnviNFe);
            die;
            
        }
    }
}

$retorno = $nfe->sefazConsultaRecibo($protocoloRecibo, $tpAmb, $aResposta);


//            echo "filename: $file : filetype: " . filetype($dir . $file) . "\n";
//        }
//        closedir($dh);
//echo '<br><br><pre>';
//echo htmlspecialchars($nfe->soapDebug);
//echo '</pre><hr><pre>';
//print_r($aResposta);
//echo "</pre><br>";
//die;
?>