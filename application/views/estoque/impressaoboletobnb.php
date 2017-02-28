<?

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
                        00490.01605 00119.321230 45674.550004 2 10690000100000
                    </div>
                </div>
                <!--Linha1-->
                <div class="linha">
                    <!-- Cedente -->
                    <div class="cedente item">
                        <label>Cedente</label>
                        José Claudio Medeiros de Lima        </div>
                    <!-- Agência/Código do Cedente -->
                    <div class="agencia item">
                        <label>Ag./Código do Cedente</label>
                        0016-6 / 0001193-2        </div>
                    <!-- Espécie Moeda -->
                    <div class="moeda item">
                        <label>Moeda</label>
                        R$
                    </div>
                    <!-- Quantidade -->
                    <div class="qtd item">
                        <label>Qtd.</label>
                        1        </div>
                    <!-- Nosso Número -->
                    <div class="nosso_numero item">
                        <label>Nosso Número</label>
                        1234567-9        </div>
                </div>

                <!--Linha 2-->
                <div class="linha">
                    <!-- Número do Documento -->
                    <div class="num_doc item">
                        <label>Número do Documento</label>
                        27.030195.10        </div>
                    <!-- CPF/CNPJ -->
                    <div class="cpf_cnpj item">
                        <label>CPF/CNPJ</label>
                        012.345.678-39        </div>
                    <!-- Vencimento -->
                    <div class="vencimento item">
                        <label>Vencimento</label>
                        10/09/2000        </div>
                    <!-- Valor do Documento -->
                    <div class="valor item">
                        <label>Valor do Documento</label>
                        1.000,00        </div>
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
                        Maria Joelma Bezerra de Medeiros        </div>
                </div>

                <!--Linha 5-->
                <div class="linha">
                    <!-- Demonstrativo -->
                    <div class="demonstrativo item">
                        <label>Demonstrativo</label>
                        Detalhes da compra<br>
                        Detalhes da compra<br>
                        Detalhes da compra<br>
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
                    <div class="banco_logo "><img src="http://localhost/administrativo/img/boleto/bnb/images/bnb.png" /></div>
                    <div class="banco_codigo ">004-3</div>
                    <div class="linha_digitavel  last">00490.01605 00119.321230 45674.550004 2 10690000100000</div>
                </div>

                <div id="colunaprincipal" class="">
                    <!--  linha1  -->
                    <!--local de pagamento-->
                    <div class="local_pagamento item">
                        <label>Local de Pagamento</label>
                        Pagável em qualquer banco até o vencimento                        </div>

                    <!--  linha2  -->
                    <!--Cedente-->
                    <div class="cedente item">
                        <label>Cedente </label>
                        José Claudio Medeiros de Lima                        </div>

                    <!--  linha3  -->
                    <div class="linha">
                        <!--data emissao-->
                        <div class="data_doc item">
                            <label>Data do documento</label>
                            28/02/2017                        </div>
                        <!--numdocumento-->
                        <div class="num_doc item">
                            <label>Número do documento</label>
                            27.030195.10                        </div>
                        <!--especiedocumento-->
                        <div class="espec_doc item">
                            <label>Espécie Doc.</label>

                        </div>
                        <!--aceite-->
                        <div class="aceite item">
                            <label>Aceite</label>

                        </div>
                        <!--data processamento-->
                        <div class="dt_proc item">
                            <label>Data proc</label>
                            28/02/2017                        </div>
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
                            55                        </div>
                        <!--especie moeda-->
                        <div class="moeda item">
                            <label>Moeda</label>
                            R$
                        </div>
                        <!--quantidade-->
                        <div class="qtd item">
                            <label>Quantidade</label>
                            1                        </div>
                        <!--valor-->
                        <div class="valor item">
                            <label>(x) Valor</label>
                            1.000,00                        </div>
                    </div>

                    <!--  instrucoes/mensagens  -->
                    <div class="mensagens ">
                        <label>Instruções (Texto de responsabilidade do cedente)</label>
                    </div>

                </div>
                <!--Coluna direita-->
                <div id="colunadireita" class="">
                    <div class="">
                        <label>Vencimento</label>
                        10/09/2000                    </div>
                    <div class="">
                        <label>Agência / Código cedente </label>
                        0016-6 / 0001193-2                    </div>
                    <div class="">
                        <label>Nosso número</label>
                        1234567-9                    </div>
                    <div class="">
                        <label>(=) Valor do documento</label>
                        1.000,00                    </div>
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
                        Maria Joelma Bezerra de Medeiros<br>CPF: 111.999.888-39<br>                    
                    </div>
                    
                    <div style="display: block; width: 100%; margin-top: 15pt;">
                        <label>Sacador/Avalista</label>
                    </div>
                </div>

                
                <!--  codigo_barras  -->
                <div id="codigo_barras" class="">
                    <div style="margin: 4pt;">
                        <?php fbarcode('00492106900001000000016000119321234567455000'); ?>
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