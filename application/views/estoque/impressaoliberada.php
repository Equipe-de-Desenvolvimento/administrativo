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
                            <td colspan="4"><span class="negrito"><?= @$empresa[0]->empresa; ?></span></td>
                        </tr>
                        <tr>
                            <td width="70">Cnpj: </td>
                            <td width="400"><?= @$empresa[0]->cnpj; ?></td>
                            
                            <td width="70">Insc:</td>
                            <td width="400"><?= @$empresa[0]->inscricao_estadual; ?></td>
                        </tr>
                        <tr>
                            <td>Fone: </td>
                            <td><?= @$empresa[0]->telefone; ?></td>
                            
                            <td >E-mail:</td>
                            <td colspan=""><?= @$empresa[0]->email; ?></td>
                        </tr>
                        <tr>
                            <td colspan="4"><?= @$empresa[0]->logradouro .', '.@$empresa[0]->numero .' - '. @$empresa[0]->bairro .' - '. @$empresa[0]->estado; ?></td>
                        </tr>
                        <tr>
                            <td>CEP: </td>
                            <td colspan="3"><?= @$empresa[0]->cep; ?></td>
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
                                    
                                    <td colspan="4"><span class="negrito">Cliente: </span><span class="dados_cabecalho"><?= @$destinatario[0]->nome; ?></span></td>
                                    <td colspan="2">&nbsp;&nbsp;</td>

                                    <td colspan="3"><span class="negrito">Cnpj: </span><span class="dados_cabecalho"><?= @$destinatario[0]->cnpj; ?></span></td>
                                    
                                </tr>
                                <tr>

                                    <td colspan="3"><span class="negrito">End: </span>
                                        <span class="dados_cabecalho">
                                        <?= @$destinatario[0]->logradouro; ?> <?= @$destinatario[0]->numero; ?>
                                        </span>
                                    </td>
                                    <td>&nbsp;&nbsp;</td>

                                    <td><span class="negrito">Fone: </span><span class="dados_cabecalho"><?= @$destinatario[0]->telefone; ?></span></td>
                                    <td>&nbsp;&nbsp;</td>
                                    <td>&nbsp;&nbsp;</td>

                                    <td><span class="negrito">CEP: </span><span class="dados_cabecalho"><?= @$destinatario[0]->cep; ?></span></td>
                                    <td>&nbsp;&nbsp;</td>

                                </tr>
                                <tr>

                                    <td><span class="negrito">Bairro: </span><span class="dados_cabecalho"><?= @$destinatario[0]->bairro; ?></span></td>
                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>

                                    <td><span class="negrito">Cid: </span><span class="dados_cabecalho"><?= @$destinatario[0]->municipio; ?></span></td>
                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>

                                    <td><span class="negrito">UF: </span><span class="dados_cabecalho"><?= @$destinatario[0]->estado; ?></span></td>
                                    <td>&nbsp;&nbsp;</td>

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
                                <? if( isset($destinatario[0]->data_fechamento) ){
                                        echo date("d/m/Y", strtotime($destinatario[0]->data_fechamento));
                                   }
                                   else {
                                        echo "EM ABERTO";
                                   }?>
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
                                foreach ($produtossaida as $value) :?>
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
                                    <td><?= number_format($value->valor, 2, '.', ',')?></td>
                                    <td><?= number_format($preco, 2, '.', ',')?></td>
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
                            <td width="225"><?= number_format($valortotal, 2, '.', ',')?></td>
                            
                            <td><span class="negrito">Desconto: </span></td>
                            <td width="225"><?= number_format($destinatario[0]->desconto, 2, '.', ',')?></td>

                            <?
                                $desconto = (float) $destinatario[0]->desconto;
                                $totLiq = $valortotal - $desconto;
                            ?>
                            <td><span class="negrito">Tot.Líquido: </span></td>
                            <td width="150"><?= number_format($totLiq, 2, '.', ',')?></td>

                            <td><span class="negrito">Assinatura: </span></td>
                            <td colspan="3"  class="linha_abaixo" width="300"></td>
                        </tr>
                    </table>
                </td>
            </tr>

        </table>

    </body>