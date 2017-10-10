<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Tipo Contrato</a></h3>
        <div>
            <form name="form_sala" id="form_sala" action="<?= base_url() ?>estoque/contrato/gravarcontratotipo" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                        <label>Nome</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="tipo_id" class="texto10" value="<?= @$tipo[0]->tipo_id; ?>" />
                        <input type="text" name="txtNome" class="texto10" value="<?= @$tipo[0]->descricao; ?>" required=""/>
                    </dd>
                    <dt>
                        <label>&nbsp;</label>
                    </dt>
                    <dd>
                        <input type="radio" name="tipoFinanceiro" value="ENTRADA" id="fixo" required="" <? if (@$tipo[0]->tipo_movimentacao == 'ENTRADA') echo "checked"; ?>/>
                        <label for="fixo" style="display: inline; color: black; font-size: 9pt">
                            Entrada
                        </label>
                        <input type="radio" name="tipoFinanceiro" value="SAIDA" id="periodico" required="" <? if (@$tipo[0]->tipo_movimentacao == 'SAIDA') echo "checked"; ?>/>
                        <label for="periodico" style="display: inline; color: black; font-size: 9pt">
                            Saida
                        </label>
                    </dd>
                    <dt>
                        <label>&nbsp;</label>
                    </dt>
                    <dd>
                        <input type="checkbox" name="boleto" id="boleto" <? if (@$tipo[0]->boleto == 't') echo "checked"; ?> />
                        <label for="boleto">Gerar Boleto?</label>
                    </dd>
                </dl>    
                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
            </form>
        </div>
    </div>
</div> <!-- Final da DIV content -->

<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">
    $(function () {
        $("#accordion").accordion();
    });


    $(document).ready(function () {
        jQuery('#form_sala').validate({
            rules: {
                txtNome: {
                    required: true,
                    minlength: 1
                }
            },
            messages: {
                txtNome: {
                    required: "*",
                    minlength: "!"
                }
            }
        });
    });

</script>