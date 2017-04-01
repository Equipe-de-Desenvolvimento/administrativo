<head>
<style>
    .linha_abaixo{
        border-bottom: 1px solid black;
    }
    .tabela_principal{
        width: 100%;
    }
    .cabecalho_principal{
        font-size: 12pt;
    }
    .cabecalho_secundario{
        font-size:12pt;
        margin-bottom: -10pt;
    }
    .negrito{
        font-weight: bolder;
    }
    .dados_cabecalho{
        font-size: 12pt;
    }
    .corpo{
        margin-top: 5pt;
        min-height: 150pt;
    }
    .tabela_fim{
        font-size: 10pt;
    }
    table{
        width: 100%;
    }
</style>

<meta charset="utf-8">
<title>Pedido</title>
</head>
<body>
<div style="width: 100%">
    <table class="tabela_principal" cellpadding="2" cellspacing="2">

        <!-- PRIMEIRO CABECALHO -->
        <tr>
            <td width="400">
                <img src="" alt="" width="350" height="150" border="1">
            </td>
            <td >
                <table class="cabecalho_principal" cellspacing="5" cellpadding="1">
                    <tr>
                        <td colspan="6"><?= @$empresa[0]->empresa; ?></td>
                    </tr>
                    <tr>
                        <td width="50"><span class="negrito">Fone: </span> </td>
                        <td width="200"><?= @$empresa[0]->telefone; ?></td>
                        <td width="50"><span class="negrito">Fax: </span> </td>
                        <td width="200"><?= @$empresa[0]->fax; ?></td>
                        <td width="50"><span class="negrito">Cod: </span></td>
                        <td width="200"><?= @$empresa[0]->cod; ?></td>
                    </tr>
                    <tr>
                        <td colspan="6"><span class="negrito">Email: </span><?= @$empresa[0]->email; ?></td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td colspan="2"  class="linha_abaixo">&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>

        <!-- SEGUNDO CABECALHO -->
        <tr>
            <td colspan="2">
                <table class="cabecalho_secundario" cellspacing="5" cellpadding="5">
                    <tr>

                        <td width='70'><span class="negrito">Cliente: </span></td>
                        <td colspan="4"><?= @$destinatario[0]->nome; ?></td>

                        <td align="right"><span class="negrito">E-mail: </span></td>
                        <td colspan="4"><?= @$destinatario[0]->email; ?></td>

                    </tr>
                    <tr>

                        <td width='70'><span class="negrito">CNPJ: </span></td>
                        <td colspan="2"><?= @$destinatario[0]->cnpj; ?></td>

                        <td align="right"><span class="negrito">Insc: </span></td>
                        <td><?= @$destinatario[0]->inscricao_estadual; ?></td>

                        <td align="right"><span class="negrito">FONE: </span></td>
                        <td><?= @$destinatario[0]->telefone; ?></td>

                        <td>&nbsp;&nbsp;</td>

                        <td align="right"><span class="negrito">FAX: </span></td>
                        <td></td>

                    </tr>
                    <tr>

                        <td width='70'><span class="negrito">Endereço: </span></td>
                        <td colspan="10"><?= @$destinatario[0]->logradouro; ?> <?= @$destinatario[0]->numero; ?> - <?= @$destinatario[0]->bairro; ?> - <?= @$destinatario[0]->municipio; ?> <?= @$destinatario[0]->estado; ?> - CEP: <?= @$destinatario[0]->cep; ?></td>

                    </tr>

                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2"  class="linha_abaixo">&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>

        <!-- TERCEIRO CABECALHO -->
        <tr>
            <td colspan="2">
                <table class="cabecalho_secundario" cellspacing="5" cellpadding="5">
                    <tr>

                        <td><span class="negrito">Emissão: </span></td>
                        <td><?= date("d/m/Y"); ?></td>

                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>

                        <td align="right"><span class="negrito">Saída: </span></td>
                        <td>
                            <?
                            if (isset($destinatario[0]->data_fechamento)) {
                                echo date("d/m/Y H:i", strtotime($destinatario[0]->data_fechamento));
                            } else {
                                echo "EM ABERTO";
                            }
                            ?>
                        </td>

                        <td>&nbsp;&nbsp;</td>

                        <td align="right"><span class="negrito">Número: </span></td>
                        <td></td>

                        <td>&nbsp;&nbsp;</td>

                        <td align="right"><span class="negrito">Cód: </span></td>
                        <td><?= @$solicitacao_id; ?></td>

                        <td>&nbsp;&nbsp;</td>

                        <td align="right"><span class="negrito">Entregador: </span></td>
                        <td><?= @$destinatario[0]->entregador; ?></td>

                    </tr>
                    <tr>

                        <td><span class="negrito">Vendedor: </span></td>
                        <td colspan="4"><?= @$destinatario[0]->vendedor; ?></td>

                        <td align="right" colspan="2"><span class="negrito">F.pgto: </span></td>
                        <td colspan="3"><?= @$nome[0]->forma_pagamento; ?></td>

                        <td align="right" colspan="2"><span class="negrito">Tp.Doc: </span></td>
                        <td colspan="4"></td>

                    </tr>

                    <tr>

                        <td><span class="negrito">Obs: </span></td>
                        <td colspan="14"></td>

                    </tr>

                </table>
            </td>
        </tr>

        <tr>
            <td colspan="2"  class="linha_abaixo">&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>


        <!--PRODUTOS -->
        <tr>
            <td colspan="2">
                <table>
                    <thead>
                    <th width="125" align="left">CÓDIGO</th>
                    <th width="500" align="left">PRODUTO</th>
                    <th align="left" width="125">NCM</th>
                    <th align="left" width="60">UND</th>
                    <th align="left" width="125">QTD.TOT</th>
                    <th align="left" width="200">PREÇO</th>
                    <th align="left">S.TOTAL</th>
                    </thead>
                    <tbody>
                        <?
                        $valortotal = 0;
                        foreach ($produtossaida as $value) :
                            ?>
                            <tr> 
                                <?
                                $v = (float) $value->valor;
                                $a = (int) str_replace('.', '', $value->quantidade_solicitada);
                                $preco = (float) $a * $v;
                                $valortotal += $preco;
                                ?>

                                <td><?= @$value->codigo; ?></td>
                                <td><?= @$value->produto; ?></td>
                                <td><?= @$value->ncm; ?></td>
                                <td><?= @$value->unidade; ?></td>
                                <td align="center"><?= @$value->quantidade_solicitada; ?></td>
                                <td><?= number_format($value->valor, 2, '.', ',') ?></td>
                                <td><?= number_format($preco, 2, '.', ',') ?></td>
                            </tr>
                        <? endforeach; ?>
                    </tbody>
                </table>
            </td>
        </tr>


        <tr>
            <td colspan="2"  class="linha_abaixo">&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>

        <tr>
            <td colspan="2">
                <table cellspacing="8" cellpadding="1" style="margin-top: 10pt;">
                    <tr>
                        <td><span class="negrito">Tot.Bruto: </span></td>
                        <td width="225"><?= number_format($valortotal, 2, '.', ',') ?></td>

                        <td><span class="negrito">Desconto: </span></td>
                        <td width="225"><?= number_format($destinatario[0]->desconto, 2, '.', ',') ?></td>

                        <?
                        $desconto = (float) $destinatario[0]->desconto;
                        $totLiq = $valortotal - $desconto;
                        ?>
                        <td><span class="negrito">Tot.Líquido: </span></td>
                        <td width="150"><?= number_format($totLiq, 2, '.', ',') ?></td>

                        <td><span class="negrito">Assinatura: </span></td>
                        <td colspan="3"  class="linha_abaixo" width="300"></td>
                    </tr>
                </table>
            </td>
        </tr>

    </table>

</body>