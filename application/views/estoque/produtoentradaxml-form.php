<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <div style="display: block; position: relative; width: 100%;">
        <h3>Entrada por Xml</h3>
        <form name="form_menuitens" id="form_menuitens" action="<?= base_url() ?>estoque/entrada/gravarentradaxml" method="post">
            <fieldset>
                <legend>Dados da nota</legend>
                <div>
                    <input type="hidden" name="fornecedor_id" value="<?= $fornecedor[0]->estoque_fornecedor_id; ?>"/>
                    <label>Fornecedor</label><input type="text" name="fornecedor"  id="fornecedor" class="texto10 bestupper" value="<?= $fornecedor[0]->razao_social; ?>"/>
                    <label>Numero NF</label><input type="text" name="numnf" id="numnf" value="<?= $numnotafiscal; ?>"/>
                    <span title="Código Fiscal de Operações e Prestações" style="text-decoration: none">
                        <label for="cfop">CFOP</label>
                    </span>
                    <dd>
                        <input type="hidden" name="cfop_id" id="cfop_id" class="texto01"/>
                        <input type="text" name="cfop" id="cfop" alt="9.999 " class="texto01"/>
                        <input type="text" name="descricao_cfop" id="descricao_cfop" class="texto08" readonly/>
                    </dd>
                </div>
            </fieldset>
            <fieldset>
                <legend>Produtos</legend>
                <table>
                    <?
                    $i = 1;
                    foreach ($produtos as $value):
                        ?>
                        <tr style="border-bottom: 1px solid gray;">
                            <td>
                                <label>Produto</label>
                                <input type="hidden" name="produto_id[<?= $i ?>]" id="produto_id<?= $i ?>" value="<?= $value['produto_id']; ?>"/>
                                <input type="text" class="texto07" name="produto[<?= $i ?>]" id="produto<?= $i ?>" value="<?= $value['descricao']; ?>" required/>
                            </td>
                            <td>
                                <label>Armazem</label>
                                <select name="txtarmazem[<?= $i ?>]" id="txtarmazem<?= $i ?>" required>
                                    <? foreach ($sub as $item) : ?>
                                        <option value="<?= $item->estoque_armazem_id; ?>"><?php echo $item->descricao; ?></option>
                                    <? endforeach; ?>
                                </select>
                            </td>
                            <td>
                                <label>Valor de compra</label>
                                <input text="text" alt="decimal" class="texto02" name="valor[<?= $i ?>]" id="valor<?= $i ?>" value="<?= $value['valorcompra']; ?>" required/>
                            </td>
                            <td>
                                <label>Quantidade</label>
                                <input text="text" alt="integer" class="texto02" name="qtde[<?= $i ?>]" id="qtde<?= $i ?>" value="<?= $value['qtde']; ?>" required/>
                            </td>
                            <td>
                                <label>Validade</label>
                                <input text="text" class="texto02" name="validade[<?= $i ?>]" id="validade<?= $i ?>" required/>
                            </td>
                            <td>
                                <label>Lote</label>
                                <input type="text" id="lote<?= $i ?>" class="texto02" name="lote[<?= $i ?>]" required/>
                            </td>
                        </tr>
                        <?
                        $i++;
                    endforeach;
                    ?>
                </table>
                <hr>
                
                <button type="submit" style="width: 80pt;height: 20pt; border-radius: 10pt;border: 1pt solid gray; font-weight: bold;">Enviar</button>
                
            </fieldset>
<!--            <fieldset>
            </fieldset>-->
        </form>
    </div> 
</div> <!-- Final da DIV content -->
<div class="clear"></div>
<style>

    .produtosSubClasse{
        border: 1px solid gray;
        border-radius: 10pt;
        padding: 5pt;
    }

    .tbTitulo {font-size: 11pt; text-decoration: none; text-transform: uppercase}
</style>

<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">
    
<? for ($x = 1; $x <= count($produtos); $x++): ?>
        $(function () {
            $("#produto<?= $x ?>").autocomplete({
                source: "<?= base_url() ?>index.php?c=autocomplete&m=produto",
                minLength: 2,
                focus: function (event, ui) {
                    $("#produto<?= $x ?>").val(ui.item.label);
                    return false;
                },
                select: function (event, ui) {
                    $("#produto<?= $x ?>").val(ui.item.value);
                    $("#produto_id<?= $x ?>").val(ui.item.id);
                    return false;
                }
            });
        });

        $(function () {
            $("#validade<?= $x ?>").datepicker({
                autosize: true,
                changeYear: true,
                changeMonth: true,
                monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
                buttonImage: '<?= base_url() ?>img/form/date.png',
                dateFormat: 'dd/mm/yy'
            });
        });
<? endfor; ?>



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
        $("#fornecedor").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=fornecedor",
            minLength: 2,
            focus: function (event, ui) {
                $("#fornecedor").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#fornecedor").val(ui.item.value);
                $("#fornecedor_id").val(ui.item.id);
                return false;
            }
        });
    });


</script>