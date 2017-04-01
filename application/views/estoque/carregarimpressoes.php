<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <div class="clear"></div>
    <form name="form_solicitacaoitens" id="form_solicitacaoitens" action="<?= base_url() ?>estoque/solicitacao/impressoes" method="post">
        <fieldset>
            <legend>Impressoes</legend>
            <input type="hidden" value="<?= @$estoque_solicitacao_id;?>" name="estoque_solicitacao_id" id="estoque_solicitacao_id"/>
            <div>
                <select  name="impressao" id="impressao" class="size4" required>
                    <option value=''>SELECIONE</option>
                    <option value='pedido_simples'>Pedido simples</option>
                    <option value='pedido'>Pedido</option>
                    
                    <?if($solicitacao[0]->situacao == "FECHADA"):?>
                        <option value='saida_simples'>Saida simples</option>  
                        <option value='saida'>Saida</option>
                        <option value='espNota'>Espelho da Nota</option>
                    <? endif;?>
                    
                    <option value='recibo'>Recibo</option>
                </select>
            </div>
            <div style="display: block; width: 100%; margin: 10pt;">
                <button type="submit">Enviar</button>
            </div>
        </fieldset>   
    </form>    
        
</div> <!-- Final da DIV content -->

<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">
    
    $(function() {
        $("#accordion").accordion();
    });


    $(document).ready(function() {
        jQuery('#form_exametemp').validate({
            rules: {
                txtNome: {
                    required: true,
                    minlength: 3
                },
                nascimento: {
                    required: true
                },
                idade: {
                    required: true
                }
            },
            messages: {
                txtNome: {
                    required: "*",
                    minlength: "!"
                },
                nascimento: {
                    required: "*"
                },
                idade: {
                    required: "*"
                }
            }
        });
    });

</script>