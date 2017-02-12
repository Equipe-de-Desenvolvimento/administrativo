<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <div class="clear"></div>
    <form name="form_sala" id="form_sala" action="<?= base_url() ?>estoque/solicitacao/gerarboleto" method="post">
        <fieldset>
            <legend>Dados da Conta</legend>
            <div>        
                <label>Forma de Pagamento</label>
                <input type="hidden" name="solicitacao_cliente_id" id="solicitacao_cliente_id" class="texto01" value="<?= $solicitacao_cliente_id ?>"/>
                <input type="hidden" name="forma_pagamento_id" id="forma_pagamento_id" class="texto01" value="<?= $conta[0]->forma_pagamento_id; ?>"/>
                <input type="text" name="forma_pagamento" id="forma_pagamento" class="texto05" value="<?= $conta[0]->forma_pagamento; ?>" readonly />
            </div>
            <div>        
                <label>Conta</label>
                <input type="text" name="conta" id="conta" class="texto02" value="<?= $conta[0]->conta; ?>" readonly />
            </div>
            <div>        
                <label>Agencia</label>
                <input type="text" name="agencia" id="agencia" class="texto02" value="<?= $conta[0]->agencia; ?>" readonly />
            </div>
            <div>        
                <label>Descriçao</label>
                <input type="text" name="descricao" id="descricao" class="texto05" value="<?= $conta[0]->descricao; ?>" readonly />
            </div>

        </fieldset>
        <fieldset>
            <div>        
                <label>Vencimento</label>
                <input type="text" name="vencimento" id="vencimento" alt="date"/>
            </div>
            <div style="display: block; width: 100%">
                <hr>
                <button type="submit" name="btnEnviar">enviar</button>
            </div>

        </fieldset>
    </form>
</div> <!-- Final da DIV content -->

<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">
    $(function () {
        $("#accordion").accordion();
    });
    
    $(function() {
        $("#vencimento").datepicker({
            autosize: true,
//            minDate: <?= date("d/m/Y")?>,
            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            dateFormat: 'dd/mm/yy'
        });
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