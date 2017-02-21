<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <div class="clear"></div>
    <form name="form_solicitacaoitens" id="form_solicitacaoitens" action="<?= base_url() ?>estoque/solicitacao/gravaritens" method="post">
        <fieldset>
            <legend>Forma de Pagamento</legend>

            <div>
                <label>Nome</label>
                <input type="hidden" name="txtestoque_solicitacao_id" value="<?php echo $estoque_solicitacao_id; ?>"/>
                <input type="text" name="txtNome" class="texto10" value="<?php echo $nome[0]->nome; ?>" readonly />
            </div>
        </fieldset>

        <fieldset>
            <legend>Cadastro de Parcelas</legend>
            <div>
                <label>Produtos</label>
                <select name="produto_id" id="produto_id" class="size4" required>
                    <option value=""  onclick="carregaValor('0.00')">SELECIONE</option>
                    <?
                    foreach ($produto as $value) :
                        $parametro = $value->valor_venda . '|' . $value->ipi
                        ?>
                        <option value="<?= $value->estoque_produto_id; ?>"  onclick="carregaValor('<?= $parametro; ?>')">
                        <?php echo $value->descricao; ?></option>
<? endforeach; ?>
                </select>
            </div>
            <div>
                <label>Lote</label>
                <select name="lote" id="lote" class="size1" >
                    <option value="">Selecione</option>
                </select>
            </div>
            <div>
                <label for="txtqtde">Quantidade</label>
                <input type="text" name="txtqtde" id="txtqtde" class="texto01" alt="integer" required/>
            </div>
            <div style="width: 100%">
                <hr>
                <button type="submit" name="btnEnviar">Adicionar</button>
            </div>
    </form>
</fieldset>

<fieldset>
    <?
    if ($contador > 0) {
        ?>
        <table id="table_agente_toxico" border="0">
            <thead>

                <tr>
                    <th class="tabela_header">Produto</th>
                    <th class="tabela_header">Qtde</th>
                    <th class="tabela_header">Valor (R$)</th>
                    <th class="tabela_header">&nbsp;</th>
                </tr>
            </thead>
            <?
            $valortotal = 0;
            $estilo_linha = "tabela_content01";
            ?>
            <tbody>
                <tr id="tot">
                    <td class="<?php echo $estilo_linha; ?>">&nbsp;</td>
                    <td class="<?php echo $estilo_linha; ?>" id="textovalortotal"><span id="spantotal"> Total:</span> </td>
                    <td class="<?php echo $estilo_linha; ?>"><span id="spantotal">
                            R$ <?= number_format($valortotal, 2, ',', '.') ?>
                        </span>
                    </td>
                    <td class="<?php echo $estilo_linha; ?>">&nbsp;
                    </td>
                </tr>
            </tbody>    
            <?
        }
        ?>
        <tfoot>
            <tr>
                <th class="tabela_footer" colspan="4">
                </th>
            </tr>
        </tfoot>
    </table> 
    <br>

    <div class="bt_link">                                  
        <a onclick="javascript: window.open('<?= base_url() ?>estoque/solicitacao/gravartransportadora/<?= $estoque_solicitacao_id ?>', '_blank', 'toolbar=no,Location=no,menubar=no,scrollbars=yes,width=750,height=400');">Transportadora</a>
    </div>                                        
    <div class="bt_link">                                  
        <a  href="<?= base_url() ?>estoque/solicitacao/pesquisar" onclick="javascript: var a = confirm('Deseja realmente Liberar e Faturar a solicitacao?');
                if (a == true) {
                    window.open('<?= base_url() ?>estoque/solicitacao/liberarsolicitacaofaturar/<?= $estoque_solicitacao_id ?>', '_blank', 'toolbar=no,Location=no,menubar=no,scrollbars=yes,width=1000,height=750')};">Liberar/Faturar</a>
    </div>                                        
    <div class="bt_link">                                  
        <a onclick="javascript: return confirm('Deseja realmente Liberar a solicitacao?');" href="<?= base_url() ?>estoque/solicitacao/liberarsolicitacao/<?= $estoque_solicitacao_id ?>">Liberar</a>
    </div>
</fieldset>
</div> <!-- Final da DIV content -->

<style>
    #spantotal{

        color: black;
        font-weight: bolder;
        font-size: 18px;
    }
    #textovalortotal{
        text-align: right;
    }
    #tot td{
        background-color: #bdc3c7;
    }

    #form_solicitacaoitens div{
        margin: 3pt;
    }
</style>


<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">


</script>