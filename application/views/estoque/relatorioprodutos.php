<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3><a href="#">Gerar relatorio Produtos</a></h3>
        <div>
            <form method="post" action="<?= base_url() ?>estoque/entrada/gerarelatorioprodutos">
                <dl>
                    <dt>
                        <label>Tipo</label>
                    </dt>
                    <dd>
                        <select name="tipo_id" id="tipo_id" class="size3">
                            <option value="">SELECIONE</option>
                            <? foreach ($tipo as $value) : ?>
                                <option value="<?= $value->estoque_tipo_id; ?>"
                                        <?= (@$_GET['tipo_id'] == $value->estoque_tipo_id) ? 'selected' : '' ?>>
                                            <?php echo $value->descricao; ?>
                                </option>
                            <? endforeach; ?>
                        </select>
                    </dd>
                    <dt>
                        <label>Classe</label>
                    </dt>
                    <dd>
                        <select name="classe_id" id="classe_id" class="size3">
                            <option value="">SELECIONE</option>
                            <? foreach ($classe as $item) : ?>
                                <option value="<?= $item->estoque_classe_id; ?>"
                                        <?= (@$_GET['classe_id'] == $item->estoque_classe_id) ? 'selected' : '' ?>>
                                            <?php echo $item->descricao; ?>
                                </option>
                            <? endforeach; ?>
                        </select>
                    </dd>
                    <dt>
                        <label>Sub-classe</label>
                    </dt>
                    <dd>
                        <select name="subclasse_id" id="subclasse_id" class="size3">
                            <option value="">SELECIONE</option>
                            <? foreach ($sub as $sclasse) : ?>
                                <option value="<?= $sclasse->estoque_sub_classe_id; ?>"
                                        <?= (@$_GET['subclasse_id'] == $sclasse->estoque_sub_classe_id) ? 'selected' : '' ?>>
                                            <?php echo $sclasse->descricao; ?>
                                </option>
                            <? endforeach; ?>
                        </select>
                    <dd>
                    <dt>
                        <label>Empresa</label>
                    </dt>
                    <dd>
                        <select name="empresa" id="empresa" class="size2">
                            <? foreach ($empresa as $value) : ?>
                                <option value="<?= $value->empresa_id; ?>" ><?php echo $value->nome; ?></option>
                            <? endforeach; ?>
                            <option value="0">TODOS</option>
                        </select>
                    </dd>
                </dl>
                <button type="submit" >Pesquisar</button>
            </form>

        </div>
    </div>


</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">
    $(function () {
        $('#classe_id').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/estoquesubclasseporclasse', {classe_id: $(this).val(), ajax: true}, function (j) {
                    options = '<option value="">SELECIONE -></option>';
                    for (var c = 0; c < j.length; c++) {
                        options += '<option value="' + j[c].estoque_sub_classe_id + '">' + j[c].descricao + '</option>';
                    }
                    $('#subclasse_id').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#subclasse_id').html('<option value="">SELECIONE</option>');
            }
        });
    });
    $(function () {
        $('#tipo_id').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                //Pega todas as classes para esse tipo
                $.getJSON('<?= base_url() ?>autocomplete/estoqueclasseportipo', {tipo_id: $(this).val(), ajax: true}, function (j) {
                    options = '<option value="">SELECIONE -></option>';
                    for (var c = 0; c < j.length; c++) {
                        options += '<option value="' + j[c].estoque_classe_id + '">' + j[c].descricao + '</option>';
                    }
                    $('#classe_id').html(options).show();
                    $('.carregando').hide();
                });
                
                //Pega todas as subclasses para esse subtipo
                $.getJSON('<?= base_url() ?>autocomplete/estoqueprodutoportipo', {tipo_id: $(this).val(), ajax: true}, function (j) {
                    options = '<option value="">SELECIONE -></option>';
                    for (var c = 0; c < j.length; c++) {
                        options += '<option value="' + j[c].estoque_sub_classe_id + '">' + j[c].descricao + '</option>';
                    }
                    $('#subclasse_id').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#classe_id').html('<option value="">SELECIONE</option>');
            }
        });
    });
    
    $(function () {
        $("#txtfornecedorlabel").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=fornecedor",
            minLength: 2,
            focus: function (event, ui) {
                $("#txtfornecedorlabel").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#txtfornecedorlabel").val(ui.item.value);
                $("#txtfornecedor").val(ui.item.id);
                return false;
            }
        });
    });

    $(function () {
        $("#txtprodutolabel").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=produto",
            minLength: 2,
            focus: function (event, ui) {
                $("#txtprodutolabel").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#txtprodutolabel").val(ui.item.value);
                $("#txtproduto").val(ui.item.id);
                return false;
            }
        });
    });



    $(function () {
        $("#accordion").accordion();
    });

</script>