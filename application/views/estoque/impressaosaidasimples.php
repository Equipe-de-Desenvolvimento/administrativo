<style>
    .linha_abaixo{
        border-bottom: 1px solid black;
    }
    .tabela_principal{
        margin: 0 0 -30pt 0;
    }
    .cabecalho_principal{
        font-size: 10pt;
        margin-bottom: -20pt;
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
        font-size: 10pt;
    }
    .corpo{
        margin-top: 5pt;
        min-height: 150pt;
    }
    .tabela_fim{
        font-size: 9pt;
    }
</style>

<meta charset="utf-8">

<div>
    <table style="width: 100%;">
        <tr>
            <!-- LADO ESQUERDO -->
            <td>
                <div style="float: left;">
                <table class="tabela_principal">

                    <!-- PRIMEIRO CABECALHO -->
                    <tr>
                        <td>
                            <img src="" alt="" width="150" height="100" border="1" style="margin-bottom: -10pt;">
                        </td>
                        <td>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                        </td>
                        <td>
                            <table class="cabecalho_principal" cellspacing="8" cellpadding="4">
                                <tr>
                                    <td colspan="6"><?= @$empresa[0]->empresa; ?></td>
                                </tr>
                                <tr>
                                    <td><span class="negrito">Fone: </span> <?= @$empresa[0]->telefone; ?></td>
                                    <td>&nbsp;&nbsp;</td>
                                    <td><span class="negrito">Fax: </span> <?= @$empresa[0]->fax; ?></td>
                                    <td>&nbsp;&nbsp;</td>
                                    <td><span class="negrito">Cod: </span> <?= @$empresa[0]->cod; ?></td>
                                    <td>&nbsp;&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="3"><span class="negrito">Email: </span><?= @$empresa[0]->email; ?></td>
                                    <td colspan="3"><span class="negrito">Data de Saida: </span><?= date("d/m/Y", strtotime($destinatario[0]->data_fechamento)); ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                    <tr>
                        <td class="linha_abaixo" colspan="3" height="2">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    </tr>

                    <!-- SEGUNDO CABECALHO -->
                    <tr>
                        <td colspan="3">
                            <table class="cabecalho_secundario" cellspacing="2" cellpadding="4">
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
                                <tr>

                                    <td colspan="9"><span class="negrito">Vendedor: </span>
                                        <span class="dados_cabecalho">CESINHA AUGUSTO PAIVA NETOSDASDASDAS</span>
                                    </td>
                                </tr>
                                <tr>

                                    <td colspan="4"><span class="negrito">Entregador: </span>
                                        <span class="dados_cabecalho">ENTREGADOR TAL TAL TAL</span>
                                    </td>
                                    <td colspan="5"><span class="negrito">Rota: </span>
                                        <span class="dados_cabecalho">DIVERSIFICADAMENTE DIVERSO</span>
                                    </td>
                                </tr>

                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="3"  class="linha_abaixo">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    </tr>
                    
                    <!-- CORPO -->
                    <tr>
                        <td colspan="3">
                            <div class="corpo">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td>PRODUTOS</td>
                                            <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                            <td>QUANTIDADE</td>
                                        </tr>
                                    <!-- LANÇAR O FOREACH DOS PRODUTOS AQUI -->
                                    
                                        <? foreach ($produtossaida as $value) :?>
                                        <tr> 
                                            <td><?= @$value->descricao; ?></td>
                                            <td></td>
                                            <td><?= @$value->quantidade; ?></td>
                                        </tr>
                                        <? endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>

                    <tr >
                        <td colspan="3" class="linha_abaixo">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    </tr>

                    <!-- OBSERVAÇÕES -->
                    <tr>
                        <td colspan="3">Obs: &nbsp;&nbsp;&nbsp;&nbsp;</td>
                    </tr> 

                    <tr>
                        <td colspan="3"  class="linha_abaixo">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    </tr>
                    
                    <!-- RODAPE -->
                    <tr>
                        <td colspan="3">
                            <table>
                                <tr>
                                    <!--RODAPE PARTE 1 -->

                                    <td>
                                        <table>
                                            <tr>
                                                <td>

                                                    <table>
                                                        <tr>
                                                            <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                            <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>

                                                            <td colspan="5" style="padding-bottom: 8pt">
                                                                <span class="negrito">Comprovante do Movimento</span>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>
                                                                <span class="negrito">Cliente: </span>
                                                            </td>
                                                            <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                            <td colspan="5">
                                                                LABORATORIO ROPE
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>
                                                                <span class="negrito">Data: </span>
                                                            </td>
                                                            <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>

                                                            <td>
                                                                12/02/2019
                                                            </td>

                                                            <td>&nbsp;&nbsp;</td>

                                                            <td>
                                                                <span class="negrito">Cód: </span>
                                                            </td>

                                                            <td>
                                                                122019
                                                            </td>

                                                            <td>&nbsp;&nbsp;</td>

                                                            <td>
                                                                <span class="negrito">Venc: </span>
                                                            </td>

                                                            <td>
                                                                12/02/2019
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>
                                                                <span class="negrito">Qtd.Tot: </span>
                                                            </td>
                                                            <td>1</td>

                                                            <td align="right">
                                                                <span class="negrito" style="text-align: right;">Peso bt: </span>
                                                            </td>
                                                            <td></td>    
                                                            <td>
                                                                <span style="margin-left: -5pt;">0,00</span>
                                                            </td>
                                                            <td>
                                                                <span class="negrito">Peso liq: </span>
                                                            </td>

                                                            <td></td>
                                                            <td colspan="3">0,00</td>
                                                        </tr>
                                                    </table>

                                                </td>
                                            </tr>
                                        </table>
                                    </td>

                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>

                                    <td>
                                        <table>
                                            <tr>
                                                <td>

                                                    <table style="height: 40pt">
                                                        <tr>
                                                            <td>
                                                                <span class="negrito">Dados do Movimento</span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                VENDA
                                                            </td>
                                                        </tr>
                                                    </table>

                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                <tr>
                                    <!--RODAPE PARTE 2 -->
                                    <td colspan="2">
                                        <table>
                                            <tr>
                                                <td>
                                                    F.Pagamento: 28 DIAS <br>
                                                    <div style="margin-bottom: 15pt;"></div>  
                                                </td>
                                                <td>&nbsp;&nbsp;&nbsp;</td>
                                                <td style="width: 250pt;"></td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;&nbsp;&nbsp;</td>
                                                <td>&nbsp;&nbsp;&nbsp;</td>
                                                <td style="border-bottom: 1px solid black;"> </td>
                                            </tr>
                                        </table>
                                    </td>   
                                    <td>&nbsp;&nbsp;&nbsp;</td>
                                </tr>

                                <tr>
                                    <!--RODAPE PARTE 3 -->
                                    <td colspan="2">
                                        <table>
                                            <tr>
                                                <td style="width: 75pt;"></td>
                                                <td style="width: 75pt;"></td>
                                                <td style="width: 75pt;"></td>
                                                <td style="width: 75pt;">
                                                    <span class="negrito">Assinatura</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 75pt; height:30pt;" colspan="4"></td>
                                            </tr>
                                        </table>
                                    </td>   
                                    <td>
                                        <table class="tabela_fim">
                                            <tr>
                                                <td><span class="negrito">Usuário Emissão:</span></td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;&nbsp;&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td><span class="negrito">Data/Hora Emissão:</span></td>
                                            </tr>
                                            <tr>
                                                <td>12/12/2019 19:52:07</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr> 

                </table>
                </div>
            </td>
            


            <!-- LADO DIREITO -->
            <td>
                <div style="float: right;">
                <table class="tabela_principal">

                    <!-- PRIMEIRO CABECALHO -->
                    <tr>
                        <td>
                            <img src="" alt="" width="150" height="100" border="1" style="margin-bottom: -10pt;">
                        </td>
                        <td>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                        </td>
                        <td>
                            <table class="cabecalho_principal" cellspacing="8" cellpadding="4">
                                <tr>
                                    <td colspan="6"><?= @$empresa[0]->empresa; ?></td>
                                </tr>
                                <tr>
                                    <td><span class="negrito">Fone: </span> <?= @$empresa[0]->telefone; ?></td>
                                    <td>&nbsp;&nbsp;</td>
                                    <td><span class="negrito">Fax: </span> <?= @$empresa[0]->fax; ?></td>
                                    <td>&nbsp;&nbsp;</td>
                                    <td><span class="negrito">Cod: </span> <?= @$empresa[0]->cod; ?></td>
                                    <td>&nbsp;&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="3"><span class="negrito">Email: </span><?= @$empresa[0]->email; ?></td>
                                    <td colspan="3"><span class="negrito">Data de Saida: </span><?= date("d/m/Y", strtotime($destinatario[0]->data_fechamento)); ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                    <tr>
                        <td class="linha_abaixo" colspan="3" height="2">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    </tr>

                    <!-- SEGUNDO CABECALHO -->
                    <tr>
                        <td colspan="3">
                            <table class="cabecalho_secundario" cellspacing="2" cellpadding="4">
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
                                <tr>

                                    <td colspan="9"><span class="negrito">Vendedor: </span>
                                        <span class="dados_cabecalho">CESINHA AUGUSTO PAIVA NETOSDASDASDAS</span>
                                    </td>
                                </tr>
                                <tr>

                                    <td colspan="4"><span class="negrito">Entregador: </span>
                                        <span class="dados_cabecalho">ENTREGADOR TAL TAL TAL</span>
                                    </td>
                                    <td colspan="5"><span class="negrito">Rota: </span>
                                        <span class="dados_cabecalho">DIVERSIFICADAMENTE DIVERSO</span>
                                    </td>
                                </tr>

                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="3"  class="linha_abaixo">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    </tr>
                    
                    <!-- CORPO -->
                    <tr>
                        <td colspan="3">
                            <div class="corpo">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td>PRODUTOS</td>
                                            <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                            <td>QUANTIDADE</td>
                                        </tr>
                                    <!-- LANÇAR O FOREACH DOS PRODUTOS AQUI -->
                                    
                                        <? foreach ($produtossaida as $value) :?>
                                        <tr> 
                                            <td><?= @$value->descricao; ?></td>
                                            <td></td>
                                            <td><?= @$value->quantidade; ?></td>
                                        </tr>
                                        <? endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>

                    <tr >
                        <td colspan="3" class="linha_abaixo">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    </tr>

                    <!-- OBSERVAÇÕES -->
                    <tr>
                        <td colspan="3">Obs: &nbsp;&nbsp;&nbsp;&nbsp;</td>
                    </tr> 

                    <tr>
                        <td colspan="3"  class="linha_abaixo">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    </tr>
                    
                    <!-- RODAPE -->
                    <tr>
                        <td colspan="3">
                            <table>
                                <tr>
                                    <!--RODAPE PARTE 1 -->

                                    <td>
                                        <table>
                                            <tr>
                                                <td>

                                                    <table>
                                                        <tr>
                                                            <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                            <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>

                                                            <td colspan="5" style="padding-bottom: 8pt">
                                                                <span class="negrito">Comprovante do Movimento</span>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>
                                                                <span class="negrito">Cliente: </span>
                                                            </td>
                                                            <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                            <td colspan="5">
                                                                LABORATORIO ROPE
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>
                                                                <span class="negrito">Data: </span>
                                                            </td>
                                                            <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>

                                                            <td>
                                                                12/02/2019
                                                            </td>

                                                            <td>&nbsp;&nbsp;</td>

                                                            <td>
                                                                <span class="negrito">Cód: </span>
                                                            </td>

                                                            <td>
                                                                122019
                                                            </td>

                                                            <td>&nbsp;&nbsp;</td>

                                                            <td>
                                                                <span class="negrito">Venc: </span>
                                                            </td>

                                                            <td>
                                                                12/02/2019
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>
                                                                <span class="negrito">Qtd.Tot: </span>
                                                            </td>
                                                            <td>1</td>

                                                            <td align="right">
                                                                <span class="negrito" style="text-align: right;">Peso bt: </span>
                                                            </td>
                                                            <td></td>    
                                                            <td>
                                                                <span style="margin-left: -5pt;">0,00</span>
                                                            </td>
                                                            <td>
                                                                <span class="negrito">Peso liq: </span>
                                                            </td>

                                                            <td></td>
                                                            <td colspan="3">0,00</td>
                                                        </tr>
                                                    </table>

                                                </td>
                                            </tr>
                                        </table>
                                    </td>

                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>

                                    <td>
                                        <table>
                                            <tr>
                                                <td>

                                                    <table style="height: 40pt">
                                                        <tr>
                                                            <td>
                                                                <span class="negrito">Dados do Movimento</span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                VENDA
                                                            </td>
                                                        </tr>
                                                    </table>

                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                <tr>
                                    <!--RODAPE PARTE 2 -->
                                    <td colspan="2">
                                        <table>
                                            <tr>
                                                <td>
                                                    F.Pagamento: 28 DIAS <br>
                                                    <div style="margin-bottom: 15pt;"></div>  
                                                </td>
                                                <td>&nbsp;&nbsp;&nbsp;</td>
                                                <td style="width: 250pt;"></td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;&nbsp;&nbsp;</td>
                                                <td>&nbsp;&nbsp;&nbsp;</td>
                                                <td style="border-bottom: 1px solid black;"> </td>
                                            </tr>
                                        </table>
                                    </td>   
                                    <td>&nbsp;&nbsp;&nbsp;</td>
                                </tr>

                                <tr>
                                    <!--RODAPE PARTE 3 -->
                                    <td colspan="2">
                                        <table>
                                            <tr>
                                                <td style="width: 75pt;"></td>
                                                <td style="width: 75pt;"></td>
                                                <td style="width: 75pt;"></td>
                                                <td style="width: 75pt;">
                                                    <span class="negrito">Assinatura</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 75pt; height:30pt;" colspan="4"></td>
                                            </tr>
                                        </table>
                                    </td>   
                                    <td>
                                        <table class="tabela_fim">
                                            <tr>
                                                <td><span class="negrito">Usuário Emissão:</span></td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;&nbsp;&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td><span class="negrito">Data/Hora Emissão:</span></td>
                                            </tr>
                                            <tr>
                                                <td>12/12/2019 19:52:07</td>
                                            </tr>
                                        </table>
                                    </td>
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