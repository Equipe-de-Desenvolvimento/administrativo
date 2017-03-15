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
    $dhEmi = date("Y-m-d\TH:i:sP");//Formato: “AAAA-MM-DDThh:mm:ssTZD” (UTC - Universal Coordinated Time).
    $dhSaiEnt = date("Y-m-d\TH:i:sP");//Não informar este campo para a NFC-e.
    $tpNF = $dadosNFe['tipoNF'];

    $idDest = $dadosNFe['identificaDestOp']; //1=Operação interna; 2=Operação interestadual; 3=Operação com exterior.

    $cMunFG = $dadosNFe['cMunFG'];
    $tpImp = '1'; //0=Sem geração de DANFE; 1=DANFE normal, Retrato; 2=DANFE normal, Paisagem;
                  //3=DANFE Simplificado; 4=DANFE NFC-e; 5=DANFE NFC-e em mensagem eletrônica
                  //(o envio de mensagem eletrônica pode ser feita de forma simultânea com a impressão do DANFE;
                  //usar o tpImp=5 quando esta for a única forma de disponibilização do DANFE).
    $tpEmis = '1'; //1=Emissão normal (não em contingência);
                   //2=Contingência FS-IA, com impressão do DANFE em formulário de segurança;
                   //3=Contingência SCAN (Sistema de Contingência do Ambiente Nacional);
                   //4=Contingência DPEC (Declaração Prévia da Emissão em Contingência);
                   //5=Contingência FS-DA, com impressão do DANFE em formulário de segurança;
                   //6=Contingência SVC-AN (SEFAZ Virtual de Contingência do AN);
                   //7=Contingência SVC-RS (SEFAZ Virtual de Contingência do RS);
                   //9=Contingência off-line da NFC-e (as demais opções de contingência são válidas também para a NFC-e);
                   //Nota: Para a NFC-e somente estão disponíveis e são válidas as opções de contingência 5 e 9.
    $tpAmb = '2'; //1=Produção; 2=Homologação
    
    $finNFe = $dadosNFe['finalidadeNFe']; //1=NF-e normal; 2=NF-e complementar; 3=NF-e de ajuste; 4=Devolução/Retorno.
    $indFinal = '0'; //0=Normal; 1=Consumidor final;
    $indPres = $dadosNFe['indPres']; //0=Não se aplica (por exemplo, Nota Fiscal complementar ou de ajuste);
                   //1=Operação presencial;
                   //2=Operação não presencial, pela Internet;
                   //3=Operação não presencial, Teleatendimento;
                   //4=NFC-e em operação com entrega a domicílio;
                   //9=Operação não presencial, outros.
    $procEmi = '0'; //0=Emissão de NF-e com aplicativo do contribuinte;
                    //1=Emissão de NF-e avulsa pelo Fisco;
                    //2=Emissão de NF-e avulsa, pelo contribuinte com seu certificado digital, através do site do Fisco;
                    //3=Emissão NF-e pelo contribuinte com aplicativo fornecido pelo Fisco.
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

    //produtos (Limite da API é de 56 itens por Nota)
    foreach ($dadosProdutos as $produto) {
        $aP[] = array(
                'nItem' => $produto['numItem'],
                'cProd' => $produto['codigoProduto'],
                'cEAN' => $produto['cEAN'], /* CASO O PRODUTO POSSUA */
                'CEST' => $produto['prodCEST'], 
                'xProd' => $produto['nomeProd'],
                'NCM' => $produto['ncm'],
                'EXTIPI' => $produto['ex_tipi'],
                'CFOP' => $produto['cfop'],
                'uCom' => $produto['unCompra'],
                'qCom' => $produto['qtdeCompra'],
                'vUnCom' => $produto['valUniComp'],
                'vProd' => $produto['valProduto'],
                'cEANTrib' => $produto['cEAN_Trib'],
                'uTrib' => $produto['uniTrib'],
                'qTrib' => $produto['qtdeTrib'],
                'vUnTrib' => $produto['valUniTrib'],
                'vFrete' => $produto['valorFrete'],
                'vSeg' => $produto['valorSeguro'],
                'vDesc' => $produto['valorDesconto'],
                'vOutro' => $produto['valorOutros'],
                'indTot' => $produto['indTot'],
                'xPed' => $produto['numPedido'],
                'nItemPed' => $produto['itemPedido'],
                'nFCI' => '');
    }

    foreach ($aP as $prod) {
        $nItem = $prod['nItem'];
        $cProd = $prod['cProd'];
        $cEAN = $prod['cEAN'];
        $xProd = $prod['xProd'];
        $NCM = $prod['NCM'];
        $EXTIPI = $prod['EXTIPI'];
        $CFOP = $prod['CFOP'];
        $uCom = $prod['uCom'];
        $qCom = $prod['qCom'];
        $vUnCom = $prod['vUnCom'];
        $vProd = $prod['vProd'];
        $cEANTrib = $prod['cEANTrib'];
        $uTrib = $prod['uTrib'];
        $qTrib = $prod['qTrib'];
        $vUnTrib = $prod['vUnTrib'];
        $vFrete = $prod['vFrete'];
        $vSeg = $prod['vSeg'];
        $vDesc = $prod['vDesc'];
        $vOutro = $prod['vOutro'];
        $indTot = $prod['indTot'];
        $xPed = $prod['xPed'];
        $nItemPed = $prod['nItemPed'];
        $nFCI = $prod['nFCI'];
        $resp = $nfe->tagprod($nItem, $cProd, $cEAN, $xProd, $NCM, $EXTIPI, $CFOP, $uCom, $qCom, $vUnCom, $vProd, $cEANTrib, $uTrib, $qTrib, $vUnTrib, $vFrete, $vSeg, $vDesc, $vOutro, $indTot, $xPed, $nItemPed, $nFCI);
    }

    foreach ($aP as $prod) {
        $nfe->tagCEST($prod['nItem'], $prod['CEST']);
    }
    // Informações adicionais na linha do Produto
    /*$nItem = 1; //produtos 1
    $vDesc = 'Barril 30 Litros Chopp Tipo Pilsen - Pedido Nº15';
    $resp = $nfe->taginfAdProd($nItem, $vDesc);*/
    // $nItem = 2; //produtos 2
    // $vDesc = 'Caixa com 1000 unidades';
    // $resp = $nfe->taginfAdProd($nItem, $vDesc);

    foreach ($aP as $prod) {
        $resp = $nfe->taginfAdProd($prod['nItem'], $prod['prodDescricao']);
    }

    //DI - Declaração de Importação
    /*$nItem = '1';
    $nDI = '234556786';
    $dDI = date('Y-m-d'); // Formato: “AAAA-MM-DD”
    $xLocDesemb = 'SANTOS';
    $UFDesemb = 'SP';
    $dDesemb = date('Y-m-d'); // Formato: “AAAA-MM-DD”
    $tpViaTransp = '1';
    $vAFRMM = '1.00';
    $tpIntermedio = '1';
    $CNPJ = '';
    $UFTerceiro = '';
    $cExportador = '111';
    $resp = $nfe->tagDI($nItem, $nDI, $dDI, $xLocDesemb, $UFDesemb, $dDesemb, $tpViaTransp, $vAFRMM, $tpIntermedio, $CNPJ, $UFTerceiro, $cExportador);*/

    //adi - Adições
    /*$nItem = '1';
    $nDI = '234556786';
    $nAdicao = '1';
    $nSeqAdicC = '123';
    $cFabricante = 'Klima Chopp';
    $vDescDI = '5.00';
    $nDraw = '9393939';
    $resp = $nfe->tagadi($nItem, $nDI, $nAdicao, $nSeqAdicC, $cFabricante, $vDescDI, $nDraw);*/

    //detExport
    //$nItem = '2';
    //$nDraw = '9393939';
    //$exportInd = '1';
    //$nRE = '2222';
    //$chNFe = '1234567890123456789012345678901234';
    //$qExport = '100';
    //$resp = $nfe->tagdetExport($nItem, $nDraw, $exportInd, $nRE, $chNFe, $qExport);

    foreach ($dadosProdutos as $produto) {
        $nItem = $produto['nItem']; 
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
    }

    // //ICMS 10
    // $nItem = 1; //produtos 1
    // $orig = '0';
    // $cst = '10'; // Tributada e com cobrança do ICMS por substituição tributária
    // $modBC = '3';
    // $pRedBC = '';
    // $vBC = '840.00';
    // $pICMS = '27.00'; // Alíquota do Estado de GO p/ 'NCM 2203.00.00 - Cervejas de Malte, inclusive Chope'
    // $vICMS = '226.80'; // = $vBC * ( $pICMS / 100 )
    // $vICMSDeson = '';
    // $motDesICMS = '';
    // $modBCST = '5'; // Calculo Por Pauta (valor)
    // $pMVAST = '';
    // $pRedBCST = '';
    // $vBCST = '1030.80'; // Pauta do Chope Claro 1000ml em GO R$ 8,59 x 60 Litros
    // $pICMSST = '27.00'; // GO para GO
    // $vICMSST = '51.50'; // = (Valor da Pauta * Alíquota ICMS ST) - Valor ICMS Próprio
    // $pDif = '';
    // $vICMSDif = '';
    // $vICMSOp = '';
    // $vBCSTRet = '';
    // $vICMSSTRet = '';
    // $resp = $nfe->tagICMS($nItem, $orig, $cst, $modBC, $pRedBC, $vBC, $pICMS, $vICMS, $vICMSDeson, $motDesICMS, $modBCST, $pMVAST, $pRedBCST, $vBCST, $pICMSST, $vICMSST, $pDif, $vICMSDif, $vICMSOp, $vBCSTRet, $vICMSSTRet);

    $vST = $vICMSST; // Total de ICMS ST

    //ICMSPart - ICMS em Operações Interestaduais - CST 10 e 90 quando possui partilha (com partilha do ICMS entre a UF origem e a UF de destino ou UF definida na legislação)
    //$resp = $nfe->tagICMSPart($nItem, $orig, $cst, $modBC, $vBC, $pRedBC, $pICMS, $vICMS, $modBCST, $pMVAST, $pRedBCST, $vBCST, $pICMSST, $vICMSST, $pBCOp, $ufST);

    //ICMSST - Tributação ICMS por Substituição Tributária (ST) - CST 41 (devido para a UF de destino, nas operações interestaduais de produtos que tiveram retenção antecipada de ICMS por ST na UF do remetente)
    //$resp = $nfe->tagICMSST($nItem, $orig, $cst, $vBCSTRet, $vICMSSTRet, $vBCSTDest, $vICMSSTDest);

    //ICMSSN - Tributação ICMS pelo Simples Nacional - CRT (Código de Regime Tributário) = 1 
    //$resp = $nfe->tagICMSSN($nItem, $orig, $csosn, $modBC, $vBC, $pRedBC, $pICMS, $vICMS, $pCredSN, $vCredICMSSN, $modBCST, $pMVAST, $pRedBCST, $vBCST, $pICMSST, $vICMSST, $vBCSTRet, $vICMSSTRet);

    foreach ($dadosProdutos as $produto) {
        //IPI - Imposto sobre Produto Industrializado
        $nItem = $produto['nItem']; //produtos 1
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
    }

    // $nItem = 2; //produtos 2
    // $cst = '53'; // 53 - Saída Não-Tributada
    // $clEnq = '';
    // $cnpjProd = '';
    // $cSelo = '';
    // $qSelo = '';
    // $cEnq = '999';
    // $vBC = '';
    // $pIPI = '';
    // $qUnid = '';
    // $vUnid = '';
    // $vIPI = ''; // = $vBC * ( $pIPI / 100 )
    // $resp = $nfe->tagIPI($nItem, $cst, $clEnq, $cnpjProd, $cSelo, $qSelo, $cEnq, $vBC, $pIPI, $qUnid, $vUnid, $vIPI);

    foreach ($dadosProdutos as $produto) {
        //PIS - Programa de Integração Social
        $nItem = $produto['nItem']; //produtos 1
        $cst = $produto['cst_PIS']; //Operação Tributável (base de cálculo = quantidade vendida x alíquota por unidade de produto)
        $vBC = $produto['valorBC_PIS']; 
        $pPIS = $produto['percPIS_PIS'];
        $vPIS = $produto['valorPIS_PIS'];
        $qBCProd = $produto['nItem'];
        $vAliqProd = $produto['nItem'];
        $resp = $nfe->tagPIS($nItem, $cst, $vBC, $pPIS, $vPIS, $qBCProd, $vAliqProd);
    }

    // $nItem = 2; //produtos 2
    // $cst = '01'; //Operação Tributável (base de cálculo = (valor da operação * alíquota normal) / 100
    // $vBC = '180.00'; 
    // $pPIS = '0.6500';
    // $vPIS = '2.34';
    // $qBCProd = '';
    // $vAliqProd = '';
    // $resp = $nfe->tagPIS($nItem, $cst, $vBC, $pPIS, $vPIS, $qBCProd, $vAliqProd);

    //PISST
    //$resp = $nfe->tagPISST($nItem, $vBC, $pPIS, $qBCProd, $vAliqProd, $vPIS);

    foreach ($dadosProdutos as $produto) {
        //COFINS - Contribuição para o Financiamento da Seguridade Social
        $nItem = $produto['nItem']; //produtos 1
        $cst = $produto['cst_COFINS']; //Operação Tributável (base de cálculo = quantidade vendida x alíquota por unidade de produto)
        $vBC = $produto['valorBC_COFINS'];
        $pCOFINS = $produto['percPIS_COFINS'];
        $vCOFINS = $produto['valorCOFINS_COFINS'];
        $qBCProd = '';
        $vAliqProd = '';
        $resp = $nfe->tagCOFINS($nItem, $cst, $vBC, $pCOFINS, $vCOFINS, $qBCProd, $vAliqProd);
    }
    // $nItem = 2; //produtos 2
    // $cst = '01'; //Operação Tributável (base de cálculo = (valor da operação * alíquota normal) / 100
    // $vBC = '180.00';
    // $pCOFINS = '3.00';
    // $vCOFINS = '10.80';
    // $qBCProd = '';
    // $vAliqProd = '';
    // $resp = $nfe->tagCOFINS($nItem, $cst, $vBC, $pCOFINS, $vCOFINS, $qBCProd, $vAliqProd);

    //COFINSST
    //$resp = $nfe->tagCOFINSST($nItem, $vBC, $pCOFINS, $qBCProd, $vAliqProd, $vCOFINS);

    //II
    //$resp = $nfe->tagII($nItem, $vBC, $vDespAdu, $vII, $vIOF);

    //ICMSTot
    //$resp = $nfe->tagICMSTot($vBC, $vICMS, $vICMSDeson, $vBCST, $vST, $vProd, $vFrete, $vSeg, $vDesc, $vII, $vIPI, $vPIS, $vCOFINS, $vOutro, $vNF, $vTotTrib);

    //ISSQNTot
    //$resp = $nfe->tagISSQNTot($vServ, $vBC, $vISS, $vPIS, $vCOFINS, $dCompet, $vDeducao, $vOutro, $vDescIncond, $vDescCond, $vISSRet, $cRegTrib);

    //retTrib
    //$resp = $nfe->tagretTrib($vRetPIS, $vRetCOFINS, $vRetCSLL, $vBCIRRF, $vIRRF, $vBCRetPrev, $vRetPrev);

    //Inicialização de váriaveis não declaradas...
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
    $vNF = number_format($vProd-$vDesc-$vICMSDeson+$vST+$vFrete+$vSeg+$vOutro+$vII+$vIPI, 2, '.', '');
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

    //valores retidos para transporte
    //$vServ = '258,69'; //Valor do Serviço
    //$vBCRet = '258,69'; //BC da Retenção do ICMS
    //$pICMSRet = '10,00'; //Alíquota da Retenção
    //$vICMSRet = '25,87'; //Valor do ICMS Retido
    //$CFOP = '5352';
    //$cMunFG = '3509502'; //Código do município de ocorrência do fato gerador do ICMS do transporte
    //$resp = $nfe->tagretTransp($vServ, $vBCRet, $pICMSRet, $vICMSRet, $CFOP, $cMunFG);

    //dados dos veiculos de transporte
    //$placa = 'AAA1212';
    //$UF = 'SP';
    //$RNTC = '12345678';
    //$resp = $nfe->tagveicTransp($placa, $UF, $RNTC);

    //dados dos reboques
    //$aReboque = array(
    //    array('ZZQ9999', 'SP', '', '', ''),
    //    array('QZQ2323', 'SP', '', '', '')
    //);
    //foreach ($aReboque as $reb) {
    //    $placa = $reb[0];
    //    $UF = $reb[1];
    //    $RNTC = $reb[2];
    //    $vagao = $reb[3];
    //    $balsa = $reb[4];
    //    //$resp = $nfe->tagreboque($placa, $UF, $RNTC, $vagao, $balsa);
    //}

    //Dados dos Volumes Transportados
    // $aVol = array(
    //     array('4','Barris','','','120.000','120.000',''),
    //     array('2','Volume','','','10.000','10.000','')
    // );
    // foreach ($aVol as $vol) {
    //     $qVol = $vol[0]; //Quantidade de volumes transportados
    //     $esp = $vol[1]; //Espécie dos volumes transportados
    //     $marca = $vol[2]; //Marca dos volumes transportados
    //     $nVol = $vol[3]; //Numeração dos volume
    //     $pesoL = intval($vol[4]); //Kg do tipo Int, mesmo que no manual diz que pode ter 3 digitos verificador...
    //     $pesoB = intval($vol[5]); //...se colocar Float não vai passar na expressão regular do Schema. =\
    //     $aLacres = $vol[6];
    //     $resp = $nfe->tagvol($qVol, $esp, $marca, $nVol, $pesoL, $pesoB, $aLacres);
    // }

/*ESSES DADOS SERÁ PREENCHIHDO COM AS FORMAS DE PAGAMENDO
    //dados da fatura
    $nFat = '';
    $vOrig = '';
    $vDesc = '';
    $vLiq = '';
    $resp = $nfe->tagfat($nFat, $vOrig, $vDesc, $vLiq);

    //dados das duplicatas (Pagamentos)
    $nDup = ''; //Código da Duplicata
    $dVenc = ''; //Vencimento
    $vDup = $totalNota[]; // Valor
    $resp = $nfe->tagdup($nDup, $dVenc, $vDup);
*/

    // $aDup = array(
    //     array('35342-1','2016-06-20','300.00'),
    //     array('35342-2','2016-07-20','300.00'),
    //     array('35342-3','2016-08-20','300.00'),
    //     array('35342-4','2016-09-20','300.00')
    // );
    // foreach ($aDup as $dup) {
    // }


    //*************************************************************
    //Grupo obrigatório para a NFC-e. Não informar para a NF-e.
    //$tPag = '03'; //01=Dinheiro 02=Cheque 03=Cartão de Crédito 04=Cartão de Débito 05=Crédito Loja 10=Vale Alimentação 11=Vale Refeição 12=Vale Presente 13=Vale Combustível 99=Outros
    //$vPag = '1452,33';
    //$resp = $nfe->tagpag($tPag, $vPag);

    //se a operação for com cartão de crédito essa informação é obrigatória
    //$CNPJ = '31551765000143'; //CNPJ da operadora de cartão
    //$tBand = '01'; //01=Visa 02=Mastercard 03=American Express 04=Sorocred 99=Outros
    //$cAut = 'AB254FC79001'; //número da autorização da tranzação
    //$resp = $nfe->tagcard($CNPJ, $tBand, $cAut);
    //**************************************************************

    // Calculo de carga tributária similar ao IBPT - Lei 12.741/12
    // $federal = number_format($vII+$vIPI+$vIOF+$vPIS+$vCOFINS, 2, ',', '.');
    // $estadual = number_format($vICMS+$vST, 2, ',', '.');
    // $municipal = number_format($vISS, 2, ',', '.');
    // $totalT = number_format($federal+$estadual+$municipal, 2, ',', '.');
    // $textoIBPT = "Valor Aprox. Tributos R$ {$totalT} - {$federal} Federal, {$estadual} Estadual e {$municipal} Municipal.";

    //Informações Adicionais
    //$infAdFisco = "SAIDA COM SUSPENSAO DO IPI CONFORME ART 29 DA LEI 10.637";
    $infAdFisco = "";
    $infCpl = "";
    $resp = $nfe->taginfAdic($infAdFisco, $infCpl);

    //monta a NFe e retorna na tela
    $resp = $nfe->montaNFe();
    if ($resp) {
        // header('Content-type: text/xml; charset=UTF-8');
        $xml = $nfe->getXML();
        
        if (!is_dir("./home/sisprod/projetos/administrativo/upload/nfe/$solicitacao_cliente_id")) {
            mkdir("./home/sisprod/projetos/administrativo/upload/nfe/$solicitacao_cliente_id");
            $destino = "./home/sisprod/projetos/administrativo/upload/nfe/$solicitacao_cliente_id";
            chmod($destino, 0777);
        }
        $filename = "/home/sisprod/projetos/administrativo/upload/nfe/{$solicitacao_cliente_id}/{$chave}-nfe.xml"; // Ambiente Linux
        $arq = fopen($filename, 'w+');
        fwrite($arq, $xml);
        fclose($arq);
        echo $xml;
    } else {
        header('Content-type: text/html; charset=UTF-8');
        foreach ($nfe->erros as $err) {
            echo 'tag: &lt;'.$err['tag'].'&gt; ---- '.$err['desc'].'<br>';
        }
    }