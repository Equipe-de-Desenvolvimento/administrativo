<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Pedido</a></h3>
        <div>
            <form name="form_sala" id="form_sala" action="<?= base_url() ?>estoque/solicitacao/gravar" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                        <label>Cliente</label>
                    </dt>
                    <dd>
                        <select name="setor" id="setor" class="size4" required="">
                            <? foreach ($setor as $value) : ?>
                                <option value="<?= $value->estoque_cliente_id; ?>"><?php echo $value->nome; ?></option>
                            <? endforeach; ?>
                        </select>
                    </dd>

                    <dt>
                        <label>Contrato</label>
                    </dt>
                    <dd>
                        <select name="contrato" id="contrato" class="size4">
                            <option value="">Selecione</option>
                        </select>
                    </dd>
                </dl>    
                <hr/>
                <button type="submit" name="btnEnviar">cadastrar</button>
            </form>
        </div>
    </div>
</div> <!-- Final da DIV content -->

<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">
    $('#btnVoltar').click(function () {
        $(location).attr('href', '<?= base_url(); ?>estoque/cliente');
    });

    $(function () {
        $("#accordion").accordion();
    });

    $(function () {
        $('#convenio1').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenio', {convenio1: $(this).val(), ajax: true}, function (j) {
                    options = '<option value=""></option>';
                    for (var c = 0; c < j.length; c++) {
                        options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + '</option>';
                    }
                    $('#procedimento1').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#procedimento1').html('<option value="">Selecione</option>');
            }
        });
    });

</script>