<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cancelamento de Notafiscal</a></h3>

        <div>
            <form name="form_entrada" id="form_entrada" action="<?= base_url() ?>estoque/notafiscal/cancelarnotafiscal/<?= $solicitacao_cliente_id ?>/<?= $notafiscal_id ?>" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                        <label>Motivo do Cancelamento</label>
                    </dt>
                    <dd>
                        <!--<input type="hidden" name="txtsolicitacao_id" id="txtsolicitacao_id" value="<?= @$obj->_estoque_entrada_id; ?>" />-->
                        <!--<input type="hidden" name="txtnotafiscal_id" id="txtnotafiscal_id" value="<?= @$obj->_produto_id; ?>" />-->
                        <input type="text" name="txtmotivo" id="txtmotivo" class="texto10" required maxlength="255" minlength="15"/>
                    </dd>
                </dl>    
                <hr/>
                <button type="submit" name="btnEnviar" onclick="javascript: return confirm('Deseja realmente cancelar essa Nota Fiscal?');">Enviar</button>
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