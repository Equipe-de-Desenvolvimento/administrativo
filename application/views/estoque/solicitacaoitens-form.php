<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <div class="clear"></div>
    <form name="form_solicitacaoitens" id="form_solicitacaoitens" action="<?= base_url() ?>estoque/solicitacao/gravaritens" method="post">
        <fieldset>
            <legend>Solicitacao produtos</legend>

            <div>
                <label>Nome</label>
                <input type="hidden" name="txtestoque_solicitacao_id" value="<?php echo $estoque_solicitacao_id; ?>"/>
                <input type="text" name="txtNome" class="texto10" value="<?php echo $nome[0]->nome; ?>" readonly />
            </div>
        </fieldset>

        <fieldset>
            <legend>Cadastro de Produtos</legend>
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
                <input type="text" name="txtqtde" id="txtqtde" class="texto01" alt="integer" value="1" required/>
            </div>

            <div style="margin-left: -10pt; margin-right: 0;">
                <label>Valor</label>
                <input type="text" name="valor" id="valor" alt="decimal" class="texto01" required readonly/>
            </div>

            <div style="width: 100%;">
                <span title="Código Fiscal de Operações e Prestações" style="text-decoration: none">
                    <label for="cfop">CFOP</label>
                </span>
                <input type="hidden" name="cfop_id" id="cfop_id" class="texto01"/>
                <input type="text" name="cfop" id="cfop" alt="9.999" class="texto01"/>
                <input type="text" name="descricao_cfop" id="descricao_cfop" class="texto08" readonly/>
            </div>


            <div style="margin-right: 0;">
                <span title="Imposto sobre Circulação de Mercadorias e Prestação de Serviços" style="text-decoration: none">
                    <label for="icms">ICMS (%)</label>
                </span>
                <input type="text" name="icms" id="icms" alt="decimal" class="texto01"/>
            </div>

            <div style="margin-left: -10pt; margin-right: 0;">
                <span title="Imposto sobre Produtos Industrializados" style="text-decoration: none">
                    <label for="ipi">IPI (%)</label>
                </span>
                <input type="text" name="ipi" id="ipi" alt="decimal" class="texto01"/>
            </div>

            <div style="margin-left: 10pt; margin-right: 0;">
                <span title="Margem de Valor Agregado" style="text-decoration: none">
                    <label for="mva">MVA</label>
                </span>
                <input type="text" name="mva" id="mva" alt="decimal" class="texto01"/>
            </div>

            <div style="margin-left: -10pt; margin-right: 0;">
                <span title="Código de Situação Tributaria" style="text-decoration: none"><label for="sit_trib">Sit. Trib.</label></span>
                <input type="text" name="sit_trib" id="sit_trib" alt="999" class="texto01" maxlength="3"/>
            </div>

            <div style="margin-left: -10pt; margin-right: 0;">
                <span title="Usa ICMS de Situação Tributaria" style="text-decoration: none"><label for="icmsst">ICMS ST</label></span>
                <input type="checkbox" name="icmsst" id="icmsst"/>
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
                <?
                foreach ($produtos as $item) {
                    ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                    ?>
                    <tr>
                        <td class="<?php echo $estilo_linha; ?>"><?= $item->descricao; ?></td>
                        <td class="<?php echo $estilo_linha; ?>"><?= $item->quantidade; ?></td>
                        <td class="<?php echo $estilo_linha; ?>"><?
                            $v = (float) $item->valor_venda;
                            $a = (int) str_replace('.', '', $item->quantidade);
                            $preco = (float) $a * $v;
                            $valortotal += $preco;
                            echo "R$ <span id='valorunitario'>" . number_format($preco, 2, ',', '.') . '</span>';
                            ?></td>
                        <td class="<?php echo $estilo_linha; ?>" width="100px;">
                            <a href="<?= base_url() ?>estoque/solicitacao/excluirsolicitacao/<?= $item->estoque_solicitacao_itens_id; ?>/<?= $estoque_solicitacao_id; ?>" class="delete">
                            </a>

                        </td>
                    </tr>


                <?
                }
                ?>
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

            function carregaValor(valor) {
                var valores = valor.split('|');
                var valVenda = valores[0];
                var valIpi = valores[1];
                $("#valor").val(valVenda);
                $("#ipi").val(valIpi);
            }


            $(function () {
                $("#sit_trib").autocomplete({
                    source: "<?= base_url() ?>index.php?c=autocomplete&m=autocompletecst",
                    minLength: 1,
                    focus: function (event, ui) {
                        $("#sit_trib").val(ui.item.label);
                        return false;
                    },
                    select: function (event, ui) {
                        $("#sit_trib").val(ui.item.id);
                        return false;
                    }
                });
            });
 $(function () {
        $("#cfop").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=autocompletecfop",
            minLength: 1,
            focus: function (event, ui) {
                $("#cfop").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#descricao_cfop").val(ui.item.descricao);
                $("#cfop").val(ui.item.cfop);
                $("#cfop_id").val(ui.item.id);
                return false;
            }
        });
    });

            $(function () {
                $('#produto_id').change(function () {
                    if ($(this).val()) {
                        $('.carregando').show();
                        $.getJSON('<?= base_url() ?>autocomplete/estoquepedidolote', {produto_id: $(this).val()}, function (j) {
                            $('#lote option').remove();
                            options = '<option value=""></option>';
//                            alert('teste');
                            for (var c = 0; c < j.length; c++) {
                                var data = '';
                                if (j[c].validade != 'null' && j[c].validade != null && j[c].validade != undefined) {
                                    var dia = j[c].validade.substring(8, 10);
                                    var mes = j[c].validade.substring(5, 7);
                                    var ano = j[c].validade.substring(0, 4);

                                    data = dia + '/' + mes + '/' + ano;
                                }


                                if (j[c].lote == 'null' || j[c].lote == null) {
                                    j[c].lote = ' ';
                                }


                                if (j[c].lote === ' ' && data === '') {
                                    continue;
                                } else {
                                    options += '<option value="' + j[c].estoque_entrada_id + '">LOTE: ' + j[c].lote + ' - ' + data + '</option>';
                                }
                            }
                            $('#lote').html(options).show();
                            $('.carregando').hide();
                        });
                    } else {
                        $('#lote').html('<option value="">Selecione</option>');
                    }
                });
            });


</script>