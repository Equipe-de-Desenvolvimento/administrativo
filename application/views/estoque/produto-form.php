<style>
    .optTipo{
        color: #3A539B; font-style:italic; background-color: #DADFE1; padding: 5pt 0pt 5pt 0pt;
    }
    .optClasse{
        color: #F2784B; font-style:italic; background-color: #DADFE1; text-indent: 10pt;
    }
    .option{
        text-indent: 30pt; color: black; font-weight: bold;
    }
</style>
<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Produto</a></h3>

        <div>
            <form name="form_produto" id="form_produto" action="<?= base_url() ?>estoque/produto/gravar" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                        <label>Nome</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="txtestoqueprodutoid" class="texto10" value="<?= @$obj->_estoque_produto_id; ?>" />
                        <input type="text" name="nome" class="texto10" value="<?= @$obj->_descricao; ?>" />
                    </dd>
                    <dt>
                        <label>Sub-classe</label>
                    </dt>
                    <dd>
                        <select name="sub" id="sub" class="size4">

                            <? foreach ($tipo as $value) : ?>
                                <optgroup label="<?= $value->descricao ?>" class="optTipo">
                                    <?
                                    foreach ($classe as $value2) :
                                        if ($value->estoque_tipo_id == $value2->tipo_id) {
                                            ?>
                                        <optgroup label="<?= $value2->descricao ?>" class="optClasse">
                                            <?
                                            foreach ($sub as $item) :
                                                if ($item->classe_id == $value2->estoque_classe_id) {
                                                    ?>
                                                    <option 
                                                        class="option"
                                                        value="<?= $item->estoque_sub_classe_id; ?>"
                                                        <? if (@$obj->_sub_classe_id == $item->estoque_sub_classe_id):echo'selected';endif; ?>>
                                                    <?= $item->descricao; ?>
                                                    </option>
                                                    <?
                                                }
                                            endforeach;
                                        }
                                        ?>
                                    </optgroup>
                                    <? endforeach; ?>

                                </optgroup>
                                <?
                            endforeach;
                            ?>
                        </select>
                    </dd>

                    <dt>
                        <label>Unidade</label>
                    </dt>
                    <dd>
                        <select name="unidade" id="unidade" class="size4">
                            <? foreach ($unidade as $value) : ?>
                                <option value="<?= $value->estoque_unidade_id; ?>"<?
                            if (@$obj->_unidade_id == $value->estoque_unidade_id):echo'selected';
                            endif;
                                ?>><?php echo $value->descricao; ?></option>
                                    <? endforeach; ?>
                        </select>
                    </dd>

                    <dt>
                        <label>Marca</label>
                    </dt>
                    <dd>
                        <select name="marca" id="marca" class="size4">
                            <? foreach ($marca as $value) : ?>
                                <option value="<?= $value->estoque_marca_id; ?>"<?
                            if (@$obj->_unidade_id == $value->estoque_marca_id):echo'selected';
                            endif;
                                ?>><?php echo $value->descricao; ?></option>
                                    <? endforeach; ?>
                        </select>
                    </dd>

                    <dt>
                        <label>Codigo</label>
                    </dt>
                    <dd>
                        <input type="text" name="codigo" id="codigo" class="texto2" value="<?= @$obj->_codigo; ?>" />
                    </dd>

                    <dt>
                        <label>NCM</label>
                    </dt>
                    <dd>
                        <input type="text" name="ncm" id="codigo_ncm" alt="9999.99.99" class="texto2" value="<?= @$obj->_ncm; ?>" />
                        <input type="text" name="descricao_ncm" id="descricao_ncm" alt="" class="texto07" readonly="" value="<?= @$obj->_ncm_descricao; ?>"/>
                    </dd>

                    <dt>
                        <label>CEST</label>
                    </dt>
                    <dd>
                        <input type="text" name="cest" alt="99.999.99" id="cest" class="texto2" value="<?= @$obj->_cest; ?>" />
                    </dd>

                    <dt>
                        <label>IPI</label>
                    </dt>
                    <dd>
                        <input type="text" id="ipi" alt="decimal" class="texto02" name="ipi" value="<?= @$obj->_ipi; ?>" />
                    </dd>

                    <dt>
                        <label>Valor de compra</label>
                    </dt>
                    <dd>
                        <input type="text" id="compra" alt="decimal" class="texto02" name="compra" value="<?= @$obj->_valor_compra; ?>" />
                    </dd>
                    <dt>
                        <label>Valor de venda</label>
                    </dt>
                    <dd>
                        <input type="text" id="venda" alt="decimal" class="texto02" name="venda" value="<?= @$obj->_valor_venda; ?>" />
                    </dd>

                    <dt>
                        <label>Estoque minimo</label>
                    </dt>
                    <dd>
                        <input type="text" id="minimo" alt="integer" class="texto02" name="minimo" value="<?= @$obj->_estoque_minimo; ?>" />
                    </dd>
                </dl>    
                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
                <button type="button" id="btnVoltar" name="btnVoltar">Voltar</button>
            </form>
        </div>
    </div>
</div> <!-- Final da DIV content -->

<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">
    $('#btnVoltar').click(function () {
        $(location).attr('href', '<?= base_url(); ?>estoque/produto');
    });

    $(function () {
        $("#codigo_ncm").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=autocompletencm",
            minLength: 2,
            focus: function (event, ui) {
                $("#codigo_ncm").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#codigo_ncm").val(ui.item.codigo);
                $("#descricao_ncm").val(ui.item.descricao);
                if (ui.item.aliquota != "NT") {
                    $("#ipi").val(ui.item.aliquota);
                }
                $.getJSON('<?= base_url() ?>autocomplete/autocompletencmcest', {ncm: ui.item.codigo}, function (j) {
                    $("#cest").val(j[0].codigo_cest);
                });
                return false;
            }
        });
    });


    $(function () {
        $("#txtCidade").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=cidade",
            minLength: 3,
            focus: function (event, ui) {
                $("#txtCidade").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#txtCidade").val(ui.item.value);
                $("#txtCidadeID").val(ui.item.id);
                return false;
            }
        });
    });

    $(function () {
        $("#procedimento").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=procedimentoproduto",
            minLength: 3,
            focus: function (event, ui) {
                $("#procedimento").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#procedimento").val(ui.item.value);
                $("#procedimentoID").val(ui.item.id);
                return false;
            }
        });
    });


    $(function () {
        $("#accordion").accordion();
    });

    $(document).ready(function () {
        jQuery('#form_produto').validate({
            rules: {
                nome: {
                    required: true,
                    minlength: 3
                },
                compra: {
                    required: true
                },
                venda: {
                    required: true
                },
                minimo: {
                    required: true
                }

            },
            messages: {
                nome: {
                    required: "*",
                    minlength: "*"
                },
                compra: {
                    required: "*"
                },
                venda: {
                    required: "*"
                },
                minimo: {
                    required: "*"
                }
            }
        });
    });

</script>
