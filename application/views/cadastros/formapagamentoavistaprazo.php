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
                        <input type="text" alt="integer" name="prazo" class="texto01" value="<?= @$parcelas[0]->prazo ?>"/>dias
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
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript">
    $(function () {
        $("#accordion").accordion();
    });
    function prazo(){
        alert('ola');
        var dt = "<div class='remover'><dt><label>Prazo</label></dt>";
        var dd = '<dd><input type="text" name="prazo" class="texto05" required=""/></dd></div>';
        $('dl').append();
    }
//    $(document).ready(function () {
//        jQuery('#form_formapagamento').validate({
//            rules: {
//                txtNome: {
//                    required: true,
//                    minlength: 3
//                },
//                conta: {
//                    required: true
//                },
//                credor_devedor: {
//                    required: true
//                },
//                parcelas: {
//                    required: true
//                }
//            },
//            messages: {
//                txtNome: {
//                    required: "*",
//                    minlength: "!"
//                },
//                conta: {
//                    required: "*"
//                },
//                credor_devedor: {
//                    required: "*"
//                },
//                parcelas: {
//                    required: "*"
//                }
//            }
//        });
//    });
</script>