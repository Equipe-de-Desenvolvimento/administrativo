<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <div class="clear"></div>
    <form name="form_sala" id="form_sala" action="<?= base_url() ?>estoque/solicitacao/solicitacaoboleto/<?=$solicitacao_cliente_id?>" method="post">
        <fieldset>
            <legend>Boleto</legend>
            <div>
                <label>Forma de Pagamento</label>
                <select name="formapagamento" id="formapagamento" class="size4" required="">
                    <option value="">Selecione</option>
                    <? foreach ($formaspagamento as $value) : ?>
                        <option value="<?= $value->forma_pagamento_id; ?>"><?php echo $value->forma_pagamento; ?></option>
                    <? endforeach; ?>
                </select>
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

</script>