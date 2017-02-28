<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro Forma de Pagamento</a></h3>
        <div>
            <form name="form_formapagamento" id="form_formapagamento" action="<?= base_url() ?>cadastros/formapagamento/gravaravistaprazo" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                        <label>Prazo</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="formapagamento_id" class="texto01" value="<?= @$formapagamento_id ?>"/>
                        <input type="hidden" name="formapagamentoparcela_id" class="texto01" value="<?= @$parcelas[0]->formapagamento_pacela_juros_id ?>"/>
                        <input type="text" alt="integer" name="prazo" class="texto01" value="<?= @$parcelas[0]->prazo ?>" required=""/>dias
                    </dd>

                </dl>    
                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
            </form>
        </div>
    </div>
</div> <!-- Final da DIV content -->

<script type="text/javascript">
    $(function () {
        $("#accordion").accordion();
    });
    
</script>