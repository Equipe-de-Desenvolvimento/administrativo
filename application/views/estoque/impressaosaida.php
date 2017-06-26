<head>
    <style>
        .linha_abaixo{
            border-bottom: 1px solid black;
        }
        .tabela_principal{
            margin: 0 0 -30pt 0;
        }
        .cabecalho_principal{
            font-size: 9pt;
            margin-bottom: -15pt;
            margin-top: -15pt;
        }
        .cabecalho_secundario{
            font-size:10pt;
            margin-bottom: -10pt;
        }
        .negrito{
            font-weight: bolder;
        }
        .dados_cabecalho{
            font-size: 8pt;
        }
        .corpo{
            margin-top: 5pt;
            min-height: 100pt;
        }
        .tabela_fim{
            font-size: 8pt;
        }
    </style>

    <meta charset="utf-8">
    <title>Saida</title>
</head>
<body>
    <div>
        <table style="width: 100%;">
            <tr>
                <!-- LADO ESQUERDO -->
                <td>
                    <div style="float: left;">
                        <table class="tabela_principal">

                            <!-- PRIMEIRO CABECALHO -->
                            <tr colspan="2">
                                <td>
                                    <img src="img/logo peq.jpg" alt="" width="150" height="100" border="1" style="margin-bottom: -10pt;">
                                </td>
                                <td>
                                    <table class="cabecalho_principal">
                                        <tr>
                                            <td colspan="5"><?= @$empresa[0]->empresa; ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><span class="negrito">Fone: </span> <?= @$empresa[0]->telefone; ?></td>
                                            <td colspan="2"><span class="negrito">Fax: </span> <?= @$empresa[0]->fax; ?></td>
                                            <td colspan=""><span class="negrito">Cod: </span> <?= @$empresa[0]->cod; ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3"><span class="negrito">Email: </span><?= @$empresa[0]->email; ?></td>
                                            <td colspan="2"><span class="negrito">Dt Saida: </span><?= date("d/m/Y", strtotime($destinatario[0]->data_fechamento)); ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">Cnpj: <?= @$empresa[0]->cnpj; ?></td>

                                            <td colspan="2">Insc: <?= @$empresa[0]->inscricao_estadual; ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5"><?= @$empresa[0]->logradouro . ', ' . @$empresa[0]->numero . ' <br>' . @$empresa[0]->bairro . ' - ' . @$empresa[0]->estado; ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">CEP: <?= @$empresa[0]->cep; ?></td>
                                            <td colspan="3"><span class="negrito">Data de Saida: </span><?= date("d/m/Y", strtotime($destinatario[0]->data_fechamento)); ?></td>
                                        
                                        </tr><!--
                                        <tr>
                                            </tr>-->
                                    </table>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="3" class="linha_abaixo">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            </tr>

                            <!-- SEGUNDO CABECALHO -->
                            <tr>
                                <td colspan="3">
                                    <table class="cabecalho_secundario">
                                        <tr>

                                            <td colspan="4"><span class="negrito">Cliente: </span><span class="dados_cabecalho"><?= @$destinatario[0]->nome; ?></span></td>
        <!--                                    <td colspan="2">&nbsp;&nbsp;</td>-->

                                        </tr>
                                        <tr>
                                            <td colspan="3"><span class="negrito">Cnpj: </span><span class="dados_cabecalho"><?= @$destinatario[0]->cnpj; ?></span></td>
                                            <td><span class="negrito">CEP: </span><span class="dados_cabecalho"><?= @$destinatario[0]->cep; ?></span></td>

                                        </tr>
                                        <tr>

                                            <td colspan="3"><span class="negrito">End: </span>
                                                <span class="dados_cabecalho">
                                                    <?= @$destinatario[0]->logradouro; ?> <?= @$destinatario[0]->numero; ?>
                                                </span>
                                            </td>
                                            <!--<td>&nbsp;&nbsp;</td>-->

                                            <td><span class="negrito">Fone: </span><span class="dados_cabecalho"><?= @$destinatario[0]->telefone; ?></span></td>
        <!--                                    <td>&nbsp;&nbsp;</td>
                                            <td>&nbsp;&nbsp;</td>-->

                                    <!--<td>&nbsp;&nbsp;</td>-->

                                        </tr>
                                        <tr>

                                            <td><span class="negrito">Bairro: </span><span class="dados_cabecalho"><?= @$destinatario[0]->bairro; ?></span></td>
                                            <!--<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>-->

                                            <td><span class="negrito">Cid: </span><span class="dados_cabecalho"><?= @$destinatario[0]->municipio; ?></span></td>
                                            <!--<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>-->

                                            <td><span class="negrito">UF: </span><span class="dados_cabecalho"><?= @$destinatario[0]->estado; ?></span></td>
                                            <!--<td>&nbsp;&nbsp;</td>-->

                                        </tr>
                                        <tr>

                                            <td colspan="9"><span class="negrito">Vendedor: </span>
                                                <span class="dados_cabecalho"><?= @$destinatario[0]->vendedor; ?></span>
                                            </td>
                                        </tr>
                                        <tr>

                                            <td colspan="4"><span class="negrito">Entregador: </span>
                                                <span class="dados_cabecalho"><?= @$destinatario[0]->entregador; ?></span>
                                            </td>
        <!--                                    <td colspan="5"><span class="negrito">Rota: </span>
                                                <span class="dados_cabecalho"></span>
                                            </td>-->
                                        </tr>
                                        <tr>
                                            <td colspan="5"><span class="negrito">Rota: </span>
                                                <span class="dados_cabecalho"></span>
                                            </td>
                                        </tr>

                                    </table>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="3" class="linha_abaixo">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            </tr>

                            <!-- CORPO -->
                            <tr>
                                <td colspan="3">
                                    <div class="corpo">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <th align="left">COD</th>
                                                    <th align="left">PRODUTO</th>
                                                    <th>UNIDADE</th>
                                                    <th>QUANTIDADE</th>
                                                </tr>
                                                <!-- LANÇAR O FOREACH DOS PRODUTOS AQUI -->

                                                <? foreach ($produtossaida as $value) : ?>
                                                    <tr> 
                                                        <td><?= @$value->codigo; ?></td>
                                                        <td><?= @$value->descricao; ?></td>
                                                        <td style="text-align: right"><?= @$value->unidade; ?></td>
                                                        <td style="text-align: right"><?= @$value->quantidade; ?></td>
                                                    </tr>
                                                <? endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="3" class="linha_abaixo">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            </tr>

                            <!-- OBSERVAÇÕES -->
                            <tr>
                                <td colspan="3"><span style="font-size: 11pt;">Obs:</span>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            </tr> 

                            <tr>
                                <td colspan="3" class="linha_abaixo">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            </tr>

                            <!-- RODAPE -->
                            <tr>
                                <td colspan="3" >
                                    <div>
                                        <table cellspacing="1">
                                            <tr>
                                                <!--RODAPE PARTE 1 -->

                                                <td>
                                                    <table>
                                                        <tr>
                                                            <td>

                                                                <table>
                                                                    <tr>
                                                                        <td colspan="4" style="padding-bottom: 8pt; text-align: center">
                                                                            <span class="negrito" style="text-align: center">Comprovante do Movimento</span>
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td colspan="4">
                                                                            <span class="negrito">Cliente: </span>
                                                                            <!--                                                                        </td>
                                                                                                                                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                                                                                                                    <td colspan="5">-->
                                                                            <?= @$destinatario[0]->nome; ?>
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td colspan="2">
                                                                            <span class="negrito">Data: </span>

                                                                            <span style="text-align: right"><?= date("d/m/Y"); ?></span>
                                                                        </td>

                                                                        <!--<td>&nbsp;&nbsp;</td>-->

                                                                        <td colspan="2">
                                                                            <span class="negrito">Venc: </span>
                                                                            <span style="text-align: right">

                                                                            </span>

                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td colspan="2">

                                                                            <span class="negrito">Cód: </span>
                                                                            <span style="text-align: right">
                                                                                <?= @$solicitacao_id; ?>
                                                                            </span>
                                                                        </td>
                                                                        <td colspan="2">
                                                                            <span class="negrito">Qtd.Tot: </span>
                                                                            <span style="text-align: right">
                                                                                <!--AQUI VEM A QTDE TOTAL-->
                                                                            </span>
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td colspan="2" align="right">
                                                                            <span class="negrito" style="text-align: right;">Peso bt: </span>
                                                                            <span style="margin-left: -5pt;"><!--AQUI VEM O PESO BT--></span>
                                                                        </td>    
                                                                        <td colspan="2" align="right">
                                                                            <span class="negrito" style="text-align: right;">Peso liq: </span>
                                                                            <span style="margin-left: -5pt;"><!--AQUI VEM O PESO BT--></span>
                                                                        </td>
                                                                    </tr>
                                                                </table>

                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>

                                                <td colspan="2">
                                                    <div style="height: 40pt">
                                                        <div class="negrito" style="display: block; text-align: center">Dados do Movimento</div>
                                                        <span>
                                                            <!--AQUI VEM O "DADOS DO MOVIMENTO". EX: "VENDA"-->
                                                        </span>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <!--RODAPE PARTE 2 -->
                                                <td colspan="3" >
                                                    <table>
                                                        <tr>
                                                            <td colspan="3">
                                                                F.Pagamento: <?= @$nome[0]->forma_pagamento; ?> <br>
                                                                <div style="margin-bottom: 15pt; width: 70pt;"></div>  
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>   
                                                <!--<td>&nbsp;&nbsp;&nbsp;</td>-->
                                            </tr>

                                            <tr>
                                                <!--RODAPE PARTE 3 -->
                                                <td colspan="" align="center">

                                                    <span style="width: 75pt; text-align: center" class="negrito">Assinatura</span>
                                                </td>   
                                                <td>
                                                    <table class="tabela_fim">
                                                        <tr>
                                                            <td><span class="negrito">Usuário Emissão:</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td><?= @$usuario[0]->nome; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><span class="negrito">Data/Hora Emissão:</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td><?= date("d/m/Y H:i:s"); ?></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </td>
                            </tr> 

                        </table>
                    </div>
                </td>

                <!--<td><div style="width: 50pt;"></div></td>-->

                <!-- LADO DIREITO -->
                <td>
                    <div style="float: right;">

                        <table class="tabela_principal">

                            <!-- PRIMEIRO CABECALHO -->
                            <tr colspan="2">
                                <td>
                                    <img src="img/logo peq.jpg" alt="" width="150" height="100" border="1" style="margin-bottom: -10pt;">
                                </td>
                                <td>
                                    <table class="cabecalho_principal">
                                        <tr>
                                            <td colspan="5"><?= @$empresa[0]->empresa; ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><span class="negrito">Fone: </span> <?= @$empresa[0]->telefone; ?></td>
                                            <td colspan="2"><span class="negrito">Fax: </span> <?= @$empresa[0]->fax; ?></td>
                                            <td colspan=""><span class="negrito">Cod: </span> <?= @$empresa[0]->cod; ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3"><span class="negrito">Email: </span><?= @$empresa[0]->email; ?></td>
                                            <td colspan="2"><span class="negrito">Dt Saida: </span><?= date("d/m/Y", strtotime($destinatario[0]->data_fechamento)); ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">Cnpj: <?= @$empresa[0]->cnpj; ?></td>

                                            <td colspan="2">Insc: <?= @$empresa[0]->inscricao_estadual; ?></td>
                                        </tr>
<!--                                        <tr>
                                            <td colspan="2">Fone: <?= @$empresa[0]->telefone; ?></td>
                                            <td colspan="3">E-mail: <?= @$empresa[0]->email; ?></td>
                                        </tr>-->
                                        <tr>
                                             <td colspan="5"><?= @$empresa[0]->logradouro . ', ' . @$empresa[0]->numero . ' <br>' . @$empresa[0]->bairro . ' - ' . @$empresa[0]->estado; ?></td> 
                                        
                                        </tr>
                                        <tr>
                                            <td colspan="2">CEP: <?= @$empresa[0]->cep; ?></td>
                                            <td colspan="3"><span class="negrito">Data de Saida: </span><?= date("d/m/Y", strtotime($destinatario[0]->data_fechamento)); ?></td>
                                        
                                        </tr><!--
                                        <tr>
                                            </tr>-->
                                    </table>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="3" class="linha_abaixo">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            </tr>

                            <!-- SEGUNDO CABECALHO -->
                            <tr>
                                <td colspan="3">
                                    <table class="cabecalho_secundario">
                                        <tr>

                                            <td colspan="4"><span class="negrito">Cliente: </span><span class="dados_cabecalho"><?= @$destinatario[0]->nome; ?></span></td>
        <!--                                    <td colspan="2">&nbsp;&nbsp;</td>-->

                                        </tr>
                                        <tr>
                                            <td colspan="3"><span class="negrito">Cnpj: </span><span class="dados_cabecalho"><?= @$destinatario[0]->cnpj; ?></span></td>
                                            <td><span class="negrito">CEP: </span><span class="dados_cabecalho"><?= @$destinatario[0]->cep; ?></span></td>

                                        </tr>
                                        <tr>

                                            <td colspan="3"><span class="negrito">End: </span>
                                                <span class="dados_cabecalho">
                                                    <?= @$destinatario[0]->logradouro; ?> <?= @$destinatario[0]->numero; ?>
                                                </span>
                                            </td>
                                            <!--<td>&nbsp;&nbsp;</td>-->

                                            <td><span class="negrito">Fone: </span><span class="dados_cabecalho"><?= @$destinatario[0]->telefone; ?></span></td>
        <!--                                    <td>&nbsp;&nbsp;</td>
                                            <td>&nbsp;&nbsp;</td>-->

                                    <!--<td>&nbsp;&nbsp;</td>-->

                                        </tr>
                                        <tr>

                                            <td><span class="negrito">Bairro: </span><span class="dados_cabecalho"><?= @$destinatario[0]->bairro; ?></span></td>
                                            <!--<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>-->

                                            <td><span class="negrito">Cid: </span><span class="dados_cabecalho"><?= @$destinatario[0]->municipio; ?></span></td>
                                            <!--<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>-->

                                            <td><span class="negrito">UF: </span><span class="dados_cabecalho"><?= @$destinatario[0]->estado; ?></span></td>
                                            <!--<td>&nbsp;&nbsp;</td>-->

                                        </tr>
                                        <tr>

                                            <td colspan="9"><span class="negrito">Vendedor: </span>
                                                <span class="dados_cabecalho"><?= @$destinatario[0]->vendedor; ?></span>
                                            </td>
                                        </tr>
                                        <tr>

                                            <td colspan="4"><span class="negrito">Entregador: </span>
                                                <span class="dados_cabecalho"><?= @$destinatario[0]->entregador; ?></span>
                                            </td>
        <!--                                    <td colspan="5"><span class="negrito">Rota: </span>
                                                <span class="dados_cabecalho"></span>
                                            </td>-->
                                        </tr>
                                        <tr>
                                            <td colspan="5"><span class="negrito">Rota: </span>
                                                <span class="dados_cabecalho"></span>
                                            </td>
                                        </tr>

                                    </table>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="3" class="linha_abaixo">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            </tr>

                            <!-- CORPO -->
                            <tr>
                                <td colspan="3">
                                    <div class="corpo">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <th align="left">COD</th>
                                                    <th align="left">PRODUTO</th>
                                                    <th>UNIDADE</th>
                                                    <th>QUANTIDADE</th>
                                                </tr>
                                                <!-- LANÇAR O FOREACH DOS PRODUTOS AQUI -->

                                                <? foreach ($produtossaida as $value) : ?>
                                                    <tr> 
                                                        <td><?= @$value->codigo; ?></td>
                                                        <td><?= @$value->descricao; ?></td>
                                                        <td style="text-align: right"><?= @$value->unidade; ?></td>
                                                        <td style="text-align: right"><?= @$value->quantidade; ?></td>
                                                    </tr>
                                                <? endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="3" class="linha_abaixo">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            </tr>

                            <!-- OBSERVAÇÕES -->
                            <tr>
                                <td colspan="3"><span style="font-size: 11pt;">Obs:</span>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            </tr> 

                            <tr>
                                <td colspan="3" class="linha_abaixo">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            </tr>

                            <!-- RODAPE -->
                            <tr>
                                <td colspan="3" >
                                    <div>
                                        <table cellspacing="1">
                                            <tr>
                                                <!--RODAPE PARTE 1 -->

                                                <td>
                                                    <table>
                                                        <tr>
                                                            <td>

                                                                <table>
                                                                    <tr>
                                                                        <td colspan="4" style="padding-bottom: 8pt; text-align: center">
                                                                            <span class="negrito" style="text-align: center">Comprovante do Movimento</span>
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td colspan="4">
                                                                            <span class="negrito">Cliente: </span>
                                                                            <!--                                                                        </td>
                                                                                                                                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                                                                                                                    <td colspan="5">-->
                                                                            <?= @$destinatario[0]->nome; ?>
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td colspan="2">
                                                                            <span class="negrito">Data: </span>

                                                                            <span style="text-align: right"><?= date("d/m/Y"); ?></span>
                                                                        </td>

                                                                        <!--<td>&nbsp;&nbsp;</td>-->

                                                                        <td colspan="2">
                                                                            <span class="negrito">Venc: </span>
                                                                            <span style="text-align: right">

                                                                            </span>

                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td colspan="2">

                                                                            <span class="negrito">Cód: </span>
                                                                            <span style="text-align: right">
                                                                                <?= @$solicitacao_id; ?>
                                                                            </span>
                                                                        </td>
                                                                        <td colspan="2">
                                                                            <span class="negrito">Qtd.Tot: </span>
                                                                            <span style="text-align: right">
                                                                                <!--AQUI VEM A QTDE TOTAL-->
                                                                            </span>
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td colspan="2" align="right">
                                                                            <span class="negrito" style="text-align: right;">Peso bt: </span>
                                                                            <span style="margin-left: -5pt;"><!--AQUI VEM O PESO BT--></span>
                                                                        </td>    
                                                                        <td colspan="2" align="right">
                                                                            <span class="negrito" style="text-align: right;">Peso liq: </span>
                                                                            <span style="margin-left: -5pt;"><!--AQUI VEM O PESO BT--></span>
                                                                        </td>
                                                                    </tr>
                                                                </table>

                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>

                                                <td colspan="2">
                                                    <div style="height: 40pt">
                                                        <div class="negrito" style="display: block; text-align: center">Dados do Movimento</div>
                                                        <span>
                                                            <!--AQUI VEM O "DADOS DO MOVIMENTO". EX: "VENDA"-->
                                                        </span>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <!--RODAPE PARTE 2 -->
                                                <td colspan="3" >
                                                    <table>
                                                        <tr>
                                                            <td colspan="3">
                                                                F.Pagamento: <?= @$nome[0]->forma_pagamento; ?> <br>
                                                                <div style="margin-bottom: 15pt; width: 70pt;"></div>  
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>   
                                                <!--<td>&nbsp;&nbsp;&nbsp;</td>-->
                                            </tr>

                                            <tr>
                                                <!--RODAPE PARTE 3 -->
                                                <td colspan="" align="center">

                                                    <span style="width: 75pt; text-align: center" class="negrito">Assinatura</span>
                                                </td>   
                                                <td>
                                                    <table class="tabela_fim">
                                                        <tr>
                                                            <td><span class="negrito">Usuário Emissão:</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td><?= @$usuario[0]->nome; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><span class="negrito">Data/Hora Emissão:</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td><?= date("d/m/Y H:i:s"); ?></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </td>
                            </tr> 

                        </table>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</body>