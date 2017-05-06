<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cancelamento de Pedido</a></h3>

        <div>
            <form name="form_entrada" id="form_entrada" action="<?= base_url() ?>estoque/solicitacao/cancelarsolicitacao" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                        <label>Motivo do Cancelamento</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="txtsolicitacao_id" id="txtsolicitacao_id" value="<?= @$solicitacao_id; ?>" />
                        <input type="hidden" name="financeiro" id="financeiro" value="<?= @$solicitacao[0]->financeiro; ?>" />
                        <input type="hidden" name="notafiscal" id="notafiscal" value="<?= @$solicitacao[0]->notafiscal; ?>" />
                        <input type="text" name="txtmotivo" id="txtmotivo" class="texto10" 
                               <? if ($solicitacao[0]->notafiscal == 't') { ?>
                                   required maxlength="255" minlength="15"
                               <? } ?>
                               />
                    </dd>
                </dl>    
                <hr/>
                <button type="submit" name="btnEnviar" onclick="javascript: return confirm('Deseja realmente cancelar esse Pedido?');">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
            </form>
        </div>
    </div>
</div> <!-- Final da DIV content -->

<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">
                    $(function () {
                        $("#accordion").accordion();
                    });
</script>