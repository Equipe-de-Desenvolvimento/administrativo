<?

//NUMERAÇÃO DA CARTEIRA
if ($boleto[0]->carteira == '1') {
    $carteira = "21";
} elseif ($boleto[0]->carteira == '2') {
    $carteira = "41";
} elseif ($boleto[0]->carteira == '4') {
    $carteira = "21";
} elseif ($boleto[0]->carteira == '5') {
    $carteira = "41";
} elseif ($boleto[0]->carteira == 'I') {
    $carteira = "51";
}

//ESPECIE DO DOCUMENTO
if ($boleto[0]->especie_documento == '01') {
    $especie = "DM";
} elseif ($boleto[0]->especie_documento == '02') {
    $especie = "NP";
} elseif ($boleto[0]->especie_documento == '03') {
    $especie = "CH";
} elseif ($boleto[0]->especie_documento == '04') {
    $especie = "Carnê";
} elseif ($boleto[0]->especie_documento == '05') {
    $especie = "RC";
} elseif ($boleto[0]->especie_documento == '06') {
    $especie = "DS";
} elseif ($boleto[0]->especie_documento == '19') {
    $especie = "OU";
}

ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
error_reporting(E_ALL);

/* CONTRUINDO CODIGO DE BARRAS */
$fatorVencimento = $this->utilitario->fatorVencimentoBNB($boleto[0]->data_vencimento);
$codParcial = '0049' /*DV COD BARRAS*/ .$fatorVencimento . $this->utilitario->tamanho_string(str_replace('.', '', $boleto[0]->valor), 10, 'numero')
        . $boleto[0]->conta_agencia . $boleto[0]->empresa_conta . $boleto[0]->conta_digito
        . $boleto[0]->nosso_numero . $this->utilitario->digito_nosso_numeroBNB($boleto[0]->nosso_numero)
        . $carteira . '000';
$dvCodBarra = $this->utilitario->dvCodigoBNB($codParcial);
$codigo = substr($codParcial, 0, 4) . $dvCodBarra . substr($codParcial, 4);


/* CONTRUINDO A LINHA DIGITÁVEL*/
$parametroDV1 = '0049'. $boleto[0]->conta_agencia . substr($boleto[0]->empresa_conta, 0, 1);
$priCampoDv = $this->utilitario->dvLinhaBNB($parametroDV1);
$priCampo = '0049' . substr($boleto[0]->conta_agencia, 0 ,1). '.' 
            . substr($boleto[0]->conta_agencia, 1) 
            . substr($boleto[0]->empresa_conta, 0, 1)
            . $priCampoDv;

$parametroDV2 = substr($codigo, 24, 10); 
$segCampoDv = $this->utilitario->dvLinhaBNB($parametroDV2);
$segCampo = substr($parametroDV2, 0, 5) . '.' .substr($parametroDV2, 5) . $segCampoDv;

$parametroDV3 = substr($codigo, 34, 10); 
$terCampoDv = $this->utilitario->dvLinhaBNB($parametroDV3);
$terCampo = substr($parametroDV3, 0, 5) . '.' .substr($parametroDV3, 5) . $terCampoDv;

$quaCampo = $dvCodBarra; //definido na hora de criar o cod de barras

$quiCampo = $fatorVencimento //definido na hora de criar o cod de barras
            . $this->utilitario->tamanho_string(str_replace('.', '', $boleto[0]->valor), 10, 'numero'); 

$linha = "{$priCampo} {$segCampo} {$terCampo} {$quaCampo} {$quiCampo}"; 

//DEMONSTRATIVOS
$demonstrativo1 = "Pagamento de Compra na empresa " . $empresa[0]->empresa;
$demonstrativo2 = "Mensalidade referente a " . $empresa[0]->empresa;

//INSTRUÇÕES DO DOCUMENTO
if ($boleto[0]->instrucao_boleto == '05') {
    $instrucao = "Acatar instruções contidas no título.";
} elseif ($boleto[0]->instrucao_boleto == '08') {
    $instrucao = "Não cobrar encargos moratórios.";
} elseif ($boleto[0]->instrucao_boleto == '12') {
    $instrucao = "Não receber após vencimento.";
} elseif ($boleto[0]->instrucao_boleto == '15') {
    $instrucao = "Após vencimento, cobrar comissão de permanência do BANCO DO NORDESTE.";
} elseif ($boleto[0]->instrucao_boleto == '00') {
    $instrucao = "Sem Instruções – Acata as instruções da Carteira do Cedente.";
}

$boleto[0]->numero_documento = substr($boleto[0]->numero_documento, 10, 10);

function esquerda($entra, $comp) {
    return substr($entra, 0, $comp);
}

function direita($entra, $comp) {
    return substr($entra, strlen($entra) - $comp, $comp);
}

function fbarcode($valor) {

    $fino = 1;
    $largo = 3;
    $altura = 50;

    $barcodes[0] = "00110";
    $barcodes[1] = "10001";
    $barcodes[2] = "01001";
    $barcodes[3] = "11000";
    $barcodes[4] = "00101";
    $barcodes[5] = "10100";
    $barcodes[6] = "01100";
    $barcodes[7] = "00011";
    $barcodes[8] = "10010";
    $barcodes[9] = "01010";
    for ($f1 = 9; $f1 >= 0; $f1--) {
        for ($f2 = 9; $f2 >= 0; $f2--) {
            $f = ($f1 * 10) + $f2;
            $texto = "";
            for ($i = 1; $i < 6; $i++) {
                $texto .= substr($barcodes[$f1], ($i - 1), 1) . substr($barcodes[$f2], ($i - 1), 1);
            }
            $barcodes[$f] = $texto;
        }
    }


//Desenho da barra
//Guarda inicial
    ?>
    <img src="<?= base_url() ?>img/boleto/p.png" width=<?php echo $fino ?> height=<?php echo $altura ?> border=0>
    <img src="<?= base_url() ?>img/boleto/b.png" width=<?php echo $fino ?> height=<?php echo $altura ?> border=0>
    <img src="<?= base_url() ?>img/boleto/p.png" width=<?php echo $fino ?> height=<?php echo $altura ?> border=0>
    <img src="<?= base_url() ?>img/boleto/b.png" width=<?php echo $fino ?> height=<?php echo $altura ?> border=0>
    <img <?php
    $texto = $valor;
    if ((strlen($texto) % 2) <> 0) {
        $texto = "0" . $texto;
    }

// Draw dos dados
    while (strlen($texto) > 0) {
        $i = round(esquerda($texto, 2));
        $texto = direita($texto, strlen($texto) - 2);
        $f = $barcodes[$i];
        for ($i = 1; $i < 11; $i+=2) {
            if (substr($f, ($i - 1), 1) == "0") {
                $f1 = $fino;
            } else {
                $f1 = $largo;
            }
            ?>
                src="<?= base_url() ?>img/boleto/p.png" width=<?php echo $f1 ?> height=<?php echo $altura ?> border=0><img 
                <?php
                if (substr($f, $i, 1) == "0") {
                    $f2 = $fino;
                } else {
                    $f2 = $largo;
                }
                ?>
                src="<?= base_url() ?>img/boleto/b.png" width=<?php echo $f2 ?> height=<?php echo $altura ?> border=0><img 
                <?php
            }
        }

// Draw guarda final
        ?>
        src="<?= base_url() ?>img/boleto/p.png" width=<?php echo $largo ?> height=<?php echo $altura ?> border=0><img 
        src="<?= base_url() ?>img/boleto/b.png" width=<?php echo $fino ?> height=<?php echo $altura ?> border=0><img 
        src="<?= base_url() ?>img/boleto/p.png" width=<?php echo 1 ?> height=<?php echo $altura ?> border=0> 
        <?php
    }

//Fim da função
    ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <title>Boleto Banco do Nordeste</title>
        <link rel="stylesheet" type="text/css" media="all" href="<?= base_url() ?>css/boleto/css/default.css" />
        <meta charset="utf-8"/>
    </head>

    <body>
        <!--    DIV CENTRAL    -->
        <div id="container">

            <!--DIV DADOS DO VENDEDOR-->
            <div id="dados_vendedor">

            </div>

            <!--DIV RECIBO DO SACADO-->
            <div id="recibo">
                <!--  cabecalho  -->
                <div class="cabecalho">
                    <div class="banco_logo "><img src="<?= base_url() ?>img/boleto/bnb.png" /></div>
                    <div class="banco_codigo ">004-3</div>
                    <div class="linha_digitavel">
                        <?= $linha; ?>        
                    </div>
                </div>
                <!--Linha1-->
                <div class="linha">
                    <!-- Cedente -->
                    <div class="cedente item">
                        <label>Cedente</label>
                        <?= $empresa[0]->razao_social; ?>        
                    </div>
                    <!-- Agência/Código do Cedente -->
                    <div class="agencia item">
                        <label>Ag./Código do Cedente</label>
                        <?= $boleto[0]->conta_agencia; ?> / <?= $boleto[0]->empresa_conta; ?> - <?= $boleto[0]->conta_digito; ?>
                    </div>
                    <!-- Espécie Moeda -->
                    <div class="moeda item">
                        <label>Moeda</label>
                        R$
                    </div>
                    <!-- Quantidade -->
                    <div class="qtd item">
                        <label>Qtd.</label>
                        1        
                    </div>
                    <!-- Nosso Número -->
                    <div class="nosso_numero item">
                        <label>Nosso Número</label>
                        <?= $boleto[0]->nosso_numero; ?>        
                    </div>
                </div>

                <!--Linha 2-->
                <div class="linha">
                    <!-- Número do Documento -->
                    <div class="num_doc item">
                        <label>Número do Documento</label>
                        <?= $boleto[0]->numero_documento; ?>        
                    </div>
                    <!-- CPF/CNPJ -->
                    <div class="cpf_cnpj item">
                        <label>CPF/CNPJ</label>
                        <?= $empresa[0]->cnpj; ?>        
                    </div>
                    <!-- Vencimento -->
                    <div class="vencimento item">
                        <label>Vencimento</label>
                        <?= date("d/m/Y", strtotime($boleto[0]->data_vencimento)); ?>        
                    </div>
                    <!-- Valor do Documento -->
                    <div class="valor item">
                        <label>Valor do Documento</label>
                        <span>R$ </span> <span style="text-align: right;"><?= str_replace('.', ',', $boleto[0]->valor); ?></span>        
                    </div>
                </div>

                <!--Linha 3-->
                <div class="linha">
                    <!-- Descontos/Abatimentos -->
                    <div class="descontos item">
                        <label>(-) Desconto/Abatimento</label>
                    </div>
                    <!-- Outras Deduções -->
                    <div class="outras_deducoes item">
                        <label>(-) Outras Deduções</label>
                    </div>
                    <!-- Mora/Multa -->
                    <div class="multa item">
                        <label>(+) Mora/Multa</label>
                    </div>
                    <!-- Outros Acréscimos -->
                    <div class="outros_acrescimos item">
                        <label>(+) Outros Acréscimos</label>
                    </div>
                    <!-- Valor Cobrado -->
                    <div class="valor item">
                        <label>(=) Valor Cobrado</label>
                    </div>
                </div>

                <!--Linha 4-->
                <div class="linha">
                    <!-- Sacado -->
                    <div class="sacado item">
                        <label>Sacado</label>
                        <?= $boleto[0]->cliente; ?>        
                    </div>
                </div>

                <!--Linha 5-->
                <div class="linha">
                    <!-- Demonstrativo -->
                    <div class="demonstrativo item">
                        <label>Demonstrativo</label>
                        <?= $demonstrativo1; ?><br>
                        <?= $demonstrativo2; ?><br>
                    </div>
                    <!-- Autenticação Mecânica -->
                    <div class="autenticacao_mecanica">
                        <label>Autenticação Mecânica</label>
                    </div>
                </div>

                <!--Linha pontilhada para corte-->
                <div class="linha_corte"><label>Corte na linha pontilhada</label></div>
            </div>            
            <!--DIV FICHA DE COMPENSACAO-->

            <div id="ficha_compensacao">
                <!--  cabecalho  -->
                <div class="cabecalho">
                    <div class="banco_logo "><img src="<?= base_url() ?>img/boleto/bnb.png" /></div>
                    <div class="banco_codigo ">004-3</div>
                    <div class="linha_digitavel  last"><?= $linha; ?></div>
                </div>

                <div id="colunaprincipal" class="">
                    <!--  linha1  -->
                    <!--local de pagamento-->
                    <div class="local_pagamento item">
                        <label>Local de Pagamento</label>
<!--                        ATE O VENCIMENTO PAGUE PREFERENCIALMENTE NO BANCO DO NORDESTE<br>
                        APOS O VENCIMENTO PAGUE SOMENTE NO BANCO DO NORDESTE<br>-->
                        Pagável em qualquer banco até o vencimento                        
                    </div>

                    <!--  linha2  -->
                    <!--Cedente-->
                    <div class="cedente item">
                        <label>Cedente </label>
                        <?= $empresa[0]->razao_social; ?>
                    </div>

                    <!--  linha3  -->
                    <div class="linha">
                        <!--data emissao-->
                        <div class="data_doc item">
                            <label>Data do documento</label>
                            <?= date("d/m/Y"); ?>
                        </div>
                        <!--numdocumento-->
                        <div class="num_doc item">
                            <label>Número do documento</label>
                            <?= $boleto[0]->numero_documento; ?>                        
                        </div>
                        <!--especiedocumento-->
                        <div class="espec_doc item">
                            <label>Espécie Doc.</label>
                            <?= $especie; ?>
                        </div>
                        <!--aceite-->
                        <div class="aceite item">
                            <label>Aceite</label>
                            <?= $boleto[0]->aceite; ?>
                        </div>
                        <!--data processamento-->
                        <div class="dt_proc item">
                            <label>Data proc</label>
                            <?= date("d/m/Y"); ?>                       
                        </div>
                    </div>

                    <!--  linha4  -->
                    <div class="linha">
                        <!--uso do banco-->
                        <div class="uso_banco item">
                            <label>Uso do Banco</label>

                        </div>
                        <!--carteira-->
                        <div class="carteira item">
                            <label>Carteira</label>
                            <?= $carteira; ?>                        
                        </div>
                        <!--especie moeda-->
                        <div class="moeda item">
                            <label>Moeda</label>
                            R$
                        </div>
                        <!--quantidade-->
                        <div class="qtd item">
                            <label>Quantidade</label>
                            1                        
                        </div>
                        <!--valor-->
                        <div class="valor item">
                            <label>(x) Valor</label>
                            <span>R$ </span> <span style="text-align: right;"><?= str_replace('.', ',', $boleto[0]->valor); ?></span>                        
                        </div>
                    </div>

                    <!--  instrucoes/mensagens  -->
                    <div class="mensagens ">
                        <label>Instruções </label>
                        <?= $demonstrativo1; ?><br>
                        <?= $demonstrativo2; ?><br>
                        - <?= $instrucao; ?>
                    </div>

                </div>
                <!--Coluna direita-->
                <div id="colunadireita" class="">
                    <div class="">
                        <label>Vencimento</label>
                        <?= date("d/m/Y", strtotime($boleto[0]->data_vencimento)); ?>                   
                    </div>
                    <div class="">
                        <label>Agência / Código cedente </label>
                        <?= $boleto[0]->conta_agencia; ?> / <?= $boleto[0]->empresa_conta; ?> - <?= $boleto[0]->conta_digito; ?>              
                    </div>
                    <div class="">
                        <label>Nosso número</label>
                        <?= $boleto[0]->nosso_numero; ?>                   
                    </div>
                    <div class="">
                        <label>(=) Valor do documento</label>
                        <span>R$ </span> <span style="text-align: right;"><?= str_replace('.', ',', $boleto[0]->valor); ?></span>                    
                    </div>
                    <div class="">
                        <label>(-) Desconto/Abatimento</label>
                    </div>
                    <div class="">
                        <label>(-) Outras deduções</label>
                    </div>
                    <div class="">
                        <label>(+) Mora/Multa</label>
                    </div>
                    <div class="">
                        <label>(+) Outros Acréscimos</label>
                    </div>
                    <div class="">
                        <label>(=) Valor cobrado</label>
                    </div>
                </div>

                <!--  sacado  -->
                <div id="sacado" class="">
                    <div class="">
                        <label>Sacado</label>
                        <?= $boleto[0]->cliente; ?><br>
                        CNPJ: <?= $boleto[0]->cliente_cnpj; ?><br>                    
                    </div>

                    <div style="display: block; width: 100%; margin-top: 15pt;">
                        <label>Sacador/Avalista</label>
                    </div>
                </div>


                <!--  codigo_barras  -->
                <div id="codigo_barras" class="">
                    <div style="margin: 4pt;">
                        <?php fbarcode($codigo); ?>
                    </div>
                    <div class="">
                        <!--<span>Autenticação Mecânica</span> / <span>Ficha de Compensação</span>-->
                        <span>Ficha de Compensação</span>
                        <label>Autenticação Mecânica</label>
                    </div>
                </div>

                <!--Linha pontilhada para corte-->
                <div class="linha_corte"><label>Corte na linha pontilhada</label></div>

                <!--Encerra ficha de compensação-->    
            </div>
        </div>
    </body>
</html>