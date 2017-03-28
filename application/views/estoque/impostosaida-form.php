<head>
    <meta charset="utf8"/>
    <!--<link href="<?= base_url() ?>css/form.css" rel="stylesheet" type="text/css" />-->

    <script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
    <script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.8.5.custom.min.js" ></script>
    <script type="text/javascript" src="<?= base_url() ?>js/jquery-cookie.js" ></script>
    <script type="text/javascript" src="<?= base_url() ?>js/jquery-treeview.js" ></script>
    <script type="text/javascript" src="<?= base_url() ?>js/jquery-meiomask.js" ></script>
    <script type="text/javascript" src="<?= base_url() ?>js/jquery.bestupper.min.js"  ></script>
    <script type="text/javascript" src="<?= base_url() ?>js/scripts_alerta.js" ></script>
    <script type="text/javascript">

        (function ($) {
            $(function () {
                $('input:text').setMask();
            });
        })(jQuery);
    </script>

    <style>
        form fieldset div {display: inline-block}
        form fieldset div fieldset{
            min-height: 22pt;
            min-width: 75pt;
            display: inline;
            position: relative;
        }
    </style>
</head>
<body bgcolor="#C0C0C0">
    <div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
        <div class="clear"></div>
        <h2>Cadastro de Impostos</h2>
        <form name="form_faturar" id="form_faturar" action="<?= base_url() ?>estoque/notafiscal/gravarimpostosaida" method="post">
            <fieldset>
                <legend>Dados</legend>
                <table>
                    <tr>
                        <td colspan="4">Produto</td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <input type="hidden" value="<?= $solicitacao_itens_id ?>" readonly="" id="solicitacao_itens" name="solicitacao_itens">
                            <input type="text" value="<?= $produto[0]->descricao ?>" readonly="" id="produto_id" name="produto_id" style="width: 400pt">

                        </td>
                    </tr>
                    <tr>
                        <td>Valor</td>
                        <td>Qtde</td>
                        <td>Valor Total</td>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" value="<?= number_format($produto[0]->valor, 2, ',', '') ?>" readonly="" id="valor" name="valor" style="width: 120pt">
                        </td>
                        <td>
                            <input type="text" value="<?= $produto[0]->qtde_total ?>" readonly="" id="qtde" name="qtde" style="width: 50pt">

                        </td>
                        <td>
                            <input type="text" value="<?= number_format($produto[0]->valor_total, 2, ',', '') ?>" readonly="" id="valortot" name="valortot" style="width: 120pt">

                        </td>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    </tr>
                </table>
            </fieldset>

            <fieldset>
                <legend>CFOP</legend>
                <table cellspacing="5">
                    <tr>
                        <td>
                            <label for="cfop">Codigo</label>
                        </td>
                        <td>
                            <label>Descrição</label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="hidden" name="cfop_id" id="cfop_id" class="texto01"/>
                            <input type="text" name="cfop" id="cfop" alt="integer" class="texto01" required="" style="width: 50pt"/>
                        </td>
                        <td>
                            <input type="text" name="descricao_cfop" id="descricao_cfop" class="texto08" readonly style="width: 400pt"/>
                        </td>
                    </tr>
                </table>
                
                <hr>
                <div>
                    <button type="submit">Cadastrar</button>
                </div>
            </fieldset>
            <fieldset>
                <legend>Impostos</legend>
                <div>
                    <fieldset>
                        <legend>ICMS</legend>
                        <div>
                            <table cellspacing="5">
                                <tr>
                                    <td><label>Perc(%)</label></td>
                                    <td><label>CST</label></td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="icms" id="icms" alt="decimal" class="texto01" style="width: 50pt"/></td>
                                    <td>
                                        <select name="cst_icms" id="cst_icms" style="width: 100pt">
                                            <option>Selecione</option>
                                            <? foreach ($cst_icms as $value) : ?>
                                                <option value="<?= $value->cst ?>" <?= ((int) $value->cst == 340) ? 'selected' : ''; ?>>
                                                    <?= $value->cst ?> - <?= $value->situacao_tributaria ?>
                                                </option>
                                            <? endforeach; ?>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </fieldset>
                </div>
                <div>
                    <fieldset>
                        <legend>IPI</legend>
                        <div>
                            <table cellspacing="5">
                                <tr>
                                    <td><label>Perc(%)</label></td>
                                    <td><label>CST</label></td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="ipi" id="ipi" alt="decimal" class="texto01" style="width: 50pt"/></td>
                                    <td>
                                        <select name="cst_ipi" id="cst_ipi" style="width: 100pt" required="">
                                            <option>Selecione</option>
                                            <? foreach ($cst_ipi as $value) : ?>
                                                <option value="<?= $value->cst ?>" <?= ((int) $value->cst == 99) ? 'selected' : ''; ?>>
                                                    <?= $value->cst ?> - <?= $value->situacao_tributaria ?>
                                                </option>
                                            <? endforeach; ?>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </fieldset>
                </div>
                <div>
                    <fieldset>
                        <legend>PIS</legend>
                        <div>
                            <table cellspacing="5">
                                <tr>
                                    <td><label>Perc(%)</label></td>
                                    <td><label>CST</label></td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="pis" id="pis" alt="decimal" class="texto01" style="width: 50pt"/></td>
                                    <td>
                                        <select name="cst_pis" id="cst_pis" style="width: 100pt" required="">
                                            <option>Selecione</option>
                                            <? foreach ($cst_pis_cofins as $value) : ?>
                                                <option value="<?= $value->cst ?>" <?= ((int) $value->cst == 7) ? 'selected' : ''; ?>>
                                                    <?= $value->cst ?> - <?= $value->situacao_tributaria ?>
                                                </option>
                                            <? endforeach; ?>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </fieldset>
                </div>
                <div>
                    <fieldset>
                        <legend>COFINS</legend>
                        <div>
                            <table cellspacing="5">
                                <tr>
                                    <td><label>Perc(%)</label></td>
                                    <td><label>CST</label></td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="cofins" id="cofins" alt="decimal" class="texto01" style="width: 50pt"/></td>
                                    <td>
                                        <select name="cst_cofins" id="cst_cofins" style="width: 100pt" required="">
                                            <option>Selecione</option>
                                            <? foreach ($cst_pis_cofins as $value) : ?>
                                                <option value="<?= $value->cst ?>" <?= ((int) $value->cst == 7) ? 'selected' : ''; ?>>
                                                    <?= $value->cst ?> - <?= $value->situacao_tributaria ?>
                                                </option>
                                            <? endforeach; ?>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </fieldset>
                </div>
            </fieldset>

        </form>

    </div> <!-- Final da DIV content -->
</body>
<link href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">

//        var jQuery = jQuery.noConflict();

        jQuery(function () {
            jQuery("#cfop").autocomplete({
                source: "<?= base_url() ?>index.php?c=autocomplete&m=autocompletecfop",
                minLength: 1,
                focus: function (event, ui) {
                    jQuery("#cfop").val(ui.item.label);
                    return false;
                },
                select: function (event, ui) {
                    jQuery("#descricao_cfop").val(ui.item.descricao);
                    jQuery("#cfop").val(ui.item.cfop);
                    jQuery("#cfop_id").val(ui.item.id);
                    return false;
                }
            });
        });

</script>