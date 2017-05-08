<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Pedido</a></h3>
        <div>
            <form name="form_sala" id="form_sala" action="<?= base_url() ?>estoque/solicitacao/gravar" method="post">
                <input type="hidden" name="solicitacao_id" id="solicitacao_id" value="<?= @$obj->_estoque_solicitacao_id ?>"/>
                <dl class="dl_desconto_lista">
                    <dt>
                        <label>Cliente</label>
                    </dt>
                    <dd>
                        <select name="setor" id="setor" class="size4" required="" x-moz-errormessage="Selecione um Cliente">
                            <option value="">Selecione</option>
                            <? foreach ($setor as $value) : ?>
                                <option value="<?= $value->estoque_cliente_id; ?>"
                                        <? if (@$obj->_cliente_id == $value->estoque_cliente_id) echo 'selected'; ?>><?php echo $value->nome; ?></option>
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
                    <? $medicos = $this->operador_m->listarvendedor(); ?>
                    <dt>
                        <label>Descrição de Pagamento</label>
                    </dt>
                    <dd>
                        <select name="descricaopagamento" id="descricaopagamento" class="size3" required="">
                            <option value="">Selecione</option>
                            <? foreach ($descricao_pagamento as $value) : ?>
                                <option value="<?= $value->descricao_forma_pagamento_id ?>"
                                        <? if (@$obj->_descricaopagamento == $value->descricao_forma_pagamento_id) echo 'selected'; ?>><?= $value->nome ?></option>
                                    <? endforeach; ?>
                        </select>
                    </dd>
                    <dt>
                        <label>Forma de Pagamento</label>
                    </dt>
                    <dd>
                        <select name="formapagamento" id="formapagamento" class="size3">
                            <option value="">Selecione</option>
                            <? foreach ($forma_pagamento as $value) : ?>
                                <option value="<?= $value->forma_pagamento_id ?>"
                                        <? if (@$obj->_formadepagamento == $value->forma_pagamento_id) echo 'selected'; ?>><?= $value->nome ?></option>
                                    <? endforeach; ?>
                        </select>
                    </dd>
                    <dt>
                        <label>Vendedor</label>
                    </dt>
                    <dd>
                        <select name="vendedor_id" id="vendedor_id" class="size3">
                            <option value="">Selecione</option>
                            <? foreach ($medicos as $value) : ?>
                                <option value="<?= $value->operador_id ?>"
                                        <? if (@$obj->_vendedor_id == $value->operador_id) echo 'selected'; ?>><?= $value->nome ?></option>
                                    <? endforeach; ?>
                        </select>
                    </dd>
                    <dt>
                        <label>Entregador</label>
                    </dt>
                    <dd>
                        <select name="entregador" id="setor" class="size4" >
                            <option value="">Selecione</option>
                            <? foreach ($entregadores as $value) : ?>
                                <option value="<?= $value->entregador_id; ?>"><?php echo $value->nome; ?></option>
                            <? endforeach; ?>
                        </select>
                    </dd>
                    <dt>
                        <label>&nbsp;</label>
                    </dt>
                    <dd>
                        <?
                        if (@$obj->_enviada == 't') {
                            @$nfe = 'disable="true"';
                            ?>
                            <input type="hidden" name="nfeenviada" id="nfeenviada" value="true"/>
                        <? }
                        ?>
                        <input type="checkbox" name="usanota" id="usanota" 
                               <? if (@$obj->_notafiscal == 't') echo 'checked'; ?>
<? if (@$obj->_enviada == 't') @$nfe; ?>/>
                        <label for="usanota"> Usa NFe</label>
                        <input type="checkbox" name="financeiro" id="financeiro"
                               <? if (@$obj->_financeiro == 't') echo 'checked'; ?>/><label for="financeiro">Financeiro</label>
                        <input type="checkbox" name="boleto" id="boleto"
<? if (@$obj->_boleto == 't') echo 'checked'; ?>/><label for="boleto">Boleto</label>
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
        $('#setor').change(function () {
            if ($(this).val()) {
//                alert('ola');
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/contratocliente', {setor: $(this).val(), ajax: true}, function (j) {
                    options = '<option value=""></option>';
                    for (var c = 0; c < j.length; c++) {
                        options += '<option value="' + j[c].estoque_contrato_id + '">' + j[c].contrato + ' - ' + j[c].tipo + '</option>';
                    }
                    $('#contrato').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#contrato').html('<option value="">Selecione</option>');
            }
        });
    });

</script>