<?php

namespace NFePHP\install;

require_once ('./application/libraries/nfephp/vendor/nfephp-org/nfephp/bootstrap.php');

use NFePHP\Common\Configure\Configure;
//var_dump(INPUT_GET);die;

$cnpj = $obj_empresa->_cnpj;
$pathCertsFiles = "./upload/certificado/". $obj_empresa->_empresa_id . "/";
$certPfxName = $_FILES["userfile"]['name'];
$certPassword = $_POST['senha'];
$certPhrase = '';
$cnpj = preg_replace('/[^0-9]/', '', $cnpj);

$aResp = Configure::checkCerts($cnpj, $pathCertsFiles, $certPfxName, $certPassword);

print json_encode($aResp);