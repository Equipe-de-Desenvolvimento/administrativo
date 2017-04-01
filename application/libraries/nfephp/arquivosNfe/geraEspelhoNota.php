<?php

use NFePHP\NFe\MakeNFe;
use NFePHP\NFe\ToolsNFe;

$nfe = new NFePHP\NFe\MakeNFe();
$nfeTools = new NFePHP\NFe\ToolsNFe($config);

//Dados da NFe - infNFe
$cUF = $dadosNFe['cUF']; //codigo numerico do estado
$cNF = $dadosNFe['cNF']; //numero aleatório da NF
$natOp = $dadosNFe['naturezaOpe']; //natureza da operação

$indPag = $dadosNFe['indicadorPagamento']; //0=Pagamento à vista; 1=Pagamento a prazo; 2=Outros

$mod = $dadosNFe['modeloNota']; //modelo da NFe 55 ou 65 essa última NFCe
$serie = $dadosNFe['numSerie']; //serie da NFe
$nNF = $dadosNFe['numNF']; // numero da NFe
$dhEmi = date("Y-m-d\TH:i:sP"); //Formato: “AAAA-MM-DDThh:mm:ssTZD” (UTC - Universal Coordinated Time).
$dhSaiEnt = date("Y-m-d\TH:i:sP"); //Não informar este campo para a NFC-e.
$tpNF = $dadosNFe['tipoNF'];

$idDest = $dadosNFe['identificaDestOp']; //1=Operação interna; 2=Operação interestadual; 3=Operação com exterior.

$cMunFG = $dadosNFe['cMunFG'];
$tpImp = '1'; 
$tpEmis = '1'; 
$tpAmb = 99; //1=Produção; 2=Homologação; 99=Espelho da Nota

$finNFe = $dadosNFe['finalidadeNFe']; //1=NF-e normal; 2=NF-e complementar; 3=NF-e de ajuste; 4=Devolução/Retorno.
$indFinal = '0'; //0=Normal; 1=Consumidor final;
$indPres = $dadosNFe['indPres']; //0=Não se aplica (por exemplo, Nota Fiscal complementar ou de ajuste);
$procEmi = '0'; //0=Emissão de NF-e com aplicativo do contribuinte;
$verProc = $dadosNFe['verProc']; //versão do aplicativo emissor
$dhCont = ''; //entrada em contingência AAAA-MM-DDThh:mm:ssTZD
$xJust = ''; //Justificativa da entrada em contingência
//Numero e versão da NFe (infNFe)
$ano = date('y', strtotime($dhEmi));
$mes = date('m', strtotime($dhEmi));
$cnpj = $nfeTools->aConfig['cnpj'];
$chave = $nfe->montaChave($cUF, $ano, $mes, $cnpj, $mod, $serie, $nNF, $tpEmis, $cNF);
$versao = '3.10';
$resp = $nfe->taginfNFe($chave, $versao);

$cDV = substr($chave, -1); //Digito Verificador da Chave de Acesso da NF-e, o DV é calculado com a aplicação do algoritmo módulo 11 (base 2,9) da Chave de Acesso.
//tag IDE
$resp = $nfe->tagide($cUF, $cNF, $natOp, $indPag, $mod, $serie, $nNF, $dhEmi, $dhSaiEnt, $tpNF, $idDest, $cMunFG, $tpImp, $tpEmis, $cDV, $tpAmb, $finNFe, $indFinal, $indPres, $procEmi, $verProc, $dhCont, $xJust);

//Dados do emitente - (Importando dados do config.json)
$CNPJ = $nfeTools->aConfig['cnpj'];
$CPF = ''; // Utilizado para CPF na nota
$xNome = $nfeTools->aConfig['razaosocial'];
$xFant = $nfeTools->aConfig['nomefantasia'];
$IE = $nfeTools->aConfig['ie'];
$IEST = $nfeTools->aConfig['iest'];
$IM = $nfeTools->aConfig['im'];
$CNAE = $nfeTools->aConfig['cnae'];
$CRT = $nfeTools->aConfig['regime'];
$resp = $nfe->tagemit($CNPJ, $CPF, $xNome, $xFant, $IE, $IEST, $IM, $CNAE, $CRT);

//endereço do emitente
$xLgr = $dadosNFe['logradouro'];
$nro = $dadosNFe['numero'];
$xCpl = $dadosNFe['complemento'];
$xBairro = $dadosNFe['bairro'];
$cMun = $dadosNFe['codMunicipio'];
$xMun = $dadosNFe['nomMunicipio'];
$UF = $dadosNFe['UF'];
$CEP = $dadosNFe['cep'];
$cPais = '1058';
$xPais = 'Brasil';
$fone = $dadosNFe['fone'];
$resp = $nfe->tagenderEmit($xLgr, $nro, $xCpl, $xBairro, $cMun, $xMun, $UF, $CEP, $cPais, $xPais, $fone);

//destinatário
$CNPJ = $dadosNFe['destCNPJ'];
$CPF = $dadosNFe['destCPF'];
$idEstrangeiro = '';
$xNome = $dadosNFe['destNOME'];
$indIEDest = $dadosNFe['destIND_IE'];
$IE = $dadosNFe['destIE'];
$ISUF = '';
$IM = $dadosNFe['destIM'];
$email = $dadosNFe['destEMAIL'];
$resp = $nfe->tagdest($CNPJ, $CPF, $idEstrangeiro, $xNome, $indIEDest, $IE, $ISUF, $IM, $email);

//Endereço do destinatário
$xLgr = $dadosNFe['destLOG'];
$nro = $dadosNFe['destNUM'];
$xCpl = $dadosNFe['destCOMP'];
$xBairro = $dadosNFe['destBAIRRO'];
$cMun = $dadosNFe['destCOD_MUN'];
$xMun = $dadosNFe['destMUN'];
$UF = $dadosNFe['destUF'];
$CEP = $dadosNFe['destCEP'];
$cPais = '1058';
$xPais = 'Brasil';
$fone = $dadosNFe['destFONE'];
$resp = $nfe->tagenderDest($xLgr, $nro, $xCpl, $xBairro, $cMun, $xMun, $UF, $CEP, $cPais, $xPais, $fone);

foreach ($dadosProdutos as $produto) {
    $nItem = $produto['numItem'];
    $cProd = $produto['codigoProduto'];
    $cEAN = $produto['cEAN'];
    $xProd = $produto['nomeProd'];
    $NCM = $produto['ncm'];
    $EXTIPI = $produto['ex_tipi'];
    $CFOP = $produto['cfop'];
    $uCom = $produto['unCompra'];
    $qCom = $produto['qtdeCompra'];
    $vUnCom = $produto['valUniComp'];
    $vProd = $produto['valProduto'];
    $cEANTrib = $produto['cEAN_Trib'];
    $uTrib = $produto['uniTrib'];
    $qTrib = $produto['qtdeTrib'];
    $vUnTrib = $produto['valUniTrib'];
    $vFrete = $produto['valorFrete'];
    $vSeg = $produto['valorSeguro'];
    $vDesc = $produto['valorDesconto'];
    $vOutro = $produto['valorOutros'];
    $indTot = $produto['indTot'];
    $xPed = $produto['numPedido'];
    $nItemPed = $produto['itemPedido'];
    $nFCI = '';
    $resp = $nfe->tagprod($nItem, $cProd, $cEAN, $xProd, $NCM, $EXTIPI, $CFOP, $uCom, $qCom, $vUnCom, $vProd, $cEANTrib, $uTrib, $qTrib, $vUnTrib, $vFrete, $vSeg, $vDesc, $vOutro, $indTot, $xPed, $nItemPed, $nFCI);


    $nfe->tagCEST($produto['numItem'], $produto['prodCEST']);

    $resp = $nfe->taginfAdProd($produto['numItem'], $produto['prodDescricao']);


    //VALOR TOTAL DE IMPOSTOS
    $nItem = $produto['numItem'];
    $vTotTrib = $produto['valTotImposto'];
    $resp = $nfe->tagimposto($nItem, $vTotTrib);

    //ICMS - Imposto sobre Circulação de Mercadorias e Serviços
    $orig = $produto['orig_ICMS'];
    $cst = $produto['cst_ICMS']; // Tributado Integralmente
    $modBC = $produto['modBC_ICMS'];
    $pRedBC = '';
    $vBC = $produto['valorBC_ICMS']; // = $qTrib * $vUnTrib
    $pICMS = $produto['percICMS_ICMS'];
    $vICMS = $produto['valorICMS_ICMS']; // = $vBC * ( $pICMS / 100 )
    $vICMSDeson = '';
    $motDesICMS = '';
    $modBCST = '';
    $pMVAST = '';
    $pRedBCST = '';
    $vBCST = '';
    $pICMSST = '';
    $vICMSST = '';
    $pDif = '';
    $vICMSDif = '';
    $vICMSOp = '';
    $vBCSTRet = '';
    $vICMSSTRet = '';
    $resp = $nfe->tagICMS($nItem, $orig, $cst, $modBC, $pRedBC, $vBC, $pICMS, $vICMS, $vICMSDeson, $motDesICMS, $modBCST, $pMVAST, $pRedBCST, $vBCST, $pICMSST, $vICMSST, $pDif, $vICMSDif, $vICMSOp, $vBCSTRet, $vICMSSTRet);

    //IPI - Imposto sobre Produto Industrializado
    $nItem = $produto['numItem']; //produtos 1
    $cst = $produto['cst_IPI']; // 50 - Saída Tributada (Código da Situação Tributária)
    $clEnq = '';
    $cnpjProd = '';
    $cSelo = '';
    $qSelo = '';
    $cEnq = $produto['codEnq_IPI'];
    $vBC = $produto['valorBC_IPI'];
    $pIPI = $produto['percIPI_IPI']; //Calculo por alíquota - 6% Alíquota GO.
    $qUnid = '';
    $vUnid = '';
    $vIPI = $produto['valorIPI_IPI']; // = $vBC * ( $pIPI / 100 )
    $resp = $nfe->tagIPI($nItem, $cst, $clEnq, $cnpjProd, $cSelo, $qSelo, $cEnq, $vBC, $pIPI, $qUnid, $vUnid, $vIPI);


    //PIS - Programa de Integração Social
    $nItem = $produto['numItem']; //produtos 1
    $cst = $produto['cst_PIS']; //Operação Tributável (base de cálculo = quantidade vendida x alíquota por unidade de produto)
    $vBC = $produto['valorBC_PIS'];
    $pPIS = $produto['percPIS_PIS'];
    $vPIS = $produto['valorPIS_PIS'];
    $qBCProd = '';
    $vAliqProd = '';
    $resp = $nfe->tagPIS($nItem, $cst, $vBC, $pPIS, $vPIS, $qBCProd, $vAliqProd);

    //COFINS - Contribuição para o Financiamento da Seguridade Social
    $nItem = $produto['numItem']; //produtos 1
    $cst = $produto['cst_COFINS']; //Operação Tributável (base de cálculo = quantidade vendida x alíquota por unidade de produto)
    $vBC = $produto['valorBC_COFINS'];
    $pCOFINS = $produto['percPIS_COFINS'];
    $vCOFINS = $produto['valorCOFINS_COFINS'];
    $qBCProd = '';
    $vAliqProd = '';
    $resp = $nfe->tagCOFINS($nItem, $cst, $vBC, $pCOFINS, $vCOFINS, $qBCProd, $vAliqProd);
}

$vST = isset($vICMSST) ? $vICMSST : 0;
; // Total de ICMS ST

$vII = isset($vII) ? $vII : 0;
$vIPI = isset($vIPI) ? $vIPI : 0;
$vIOF = isset($vIOF) ? $vIOF : 0;
$vPIS = isset($vPIS) ? $vPIS : 0;
$vCOFINS = isset($vCOFINS) ? $vCOFINS : 0;
$vICMS = isset($vICMS) ? $vICMS : 0;
$vBCST = isset($vBCST) ? $vBCST : 0;
$vST = isset($vST) ? $vST : 0;
$vISS = isset($vISS) ? $vISS : 0;

//total
$vBC = $totalNota['totalBC'];
$vICMS = $totalNota['totalICMS'];
$vICMSDeson = '0.00';
$vBCST = '0.00';
$vST = '0.00';
$vProd = $totalNota['totalProduto'];
$vFrete = '0.00';
$vSeg = '0.00';
$vDesc = '0.00';
$vII = '0.00';
$vIPI = $totalNota['totalIPI'];
$vPIS = $totalNota['totalPIS'];
$vCOFINS = $totalNota['totalCOFINS'];
$vOutro = '0.00';
$vNF = number_format($vProd - $vDesc - $vICMSDeson + $vST + $vFrete + $vSeg + $vOutro + $vII + $vIPI, 2, '.', '');
$vTotTrib = number_format($totalNota['totalImposto'], 2, '.', '');
$resp = $nfe->tagICMSTot($vBC, $vICMS, $vICMSDeson, $vBCST, $vST, $vProd, $vFrete, $vSeg, $vDesc, $vII, $vIPI, $vPIS, $vCOFINS, $vOutro, $vNF, $vTotTrib);

//frete
$modFrete = '0'; //0=Por conta do emitente; 1=Por conta do destinatário/remetente; 2=Por conta de terceiros; 9=Sem Frete;
$resp = $nfe->tagtransp($modFrete);

//transportadora
$CNPJ = '';
$CPF = '';
$xNome = '';
$IE = '';
$xEnder = '';
$xMun = '';
$UF = '';
$resp = $nfe->tagtransporta($CNPJ, $CPF, $xNome, $IE, $xEnder, $xMun, $UF);

$infAdFisco = "";
$infCpl = "";
$resp = $nfe->taginfAdic($infAdFisco, $infCpl);

//monta a NFe e retorna na tela
$resp = $nfe->montaNFe();
if ($resp) {
    // header('Content-type: text/xml; charset=UTF-8');
    $xml = $nfe->getXML();
} else {
    header('Content-type: text/html; charset=UTF-8');
    foreach ($nfe->erros as $err) {
        echo 'tag: &lt;' . $err['tag'] . '&gt; ---- ' . $err['desc'] . '<br>';
    }
}