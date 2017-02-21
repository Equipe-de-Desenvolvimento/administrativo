<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Parcelas</a></h3>
        <div>
            <form name="form_grupoconvenio" id="form_grupoconvenio" action="<?= base_url() ?>cadastros/formapagamento/gravarpagamentoparcelado" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                        <label>Parcelas</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="formapagamento_id" class="texto01" value="<?= @$formapagamento[0]->forma_pagamento_id; ?>" />
                        <input type="text" name="tot_parcelas" class="texto01" value="<?= @$obj->_nome; ?>" alt="integer"/>
                    </dd>
                    <dt>
                        <label>Periodo entre parcelas</label>
                    </dt>
                    <dd>
                        <input type="text" name="dias" class="texto01" value="<?= @$obj->_nome; ?>" alt="integer"/> dia(s)
                    </dd>
                    <dt>
                        <label>Prazo</label>
                    </dt>
                    <dd>
                        <input type="text" name="prazo" class="texto01" alt="integer" value="0"/> dia(s)
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

    $(function() {
        $( "#accordion" ).accordion();
    });


    $(document).ready(function(){
        jQuery('#form_grupoconvenio').validate( {
            rules: {
                txtNome: {
                    required: true,
                    minlength: 2
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