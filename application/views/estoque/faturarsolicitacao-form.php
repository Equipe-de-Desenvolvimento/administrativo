
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.8.5.custom.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-meiomask.js" ></script>
<!--<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>-->
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<style>
    #form_faturar{
        overflow-y: auto;
    }
</style>
<body bgcolor="#C0C0C0">
    <div class="content"> <!-- Inicio da DIV content -->
        <h3 class="singular">Faturar</h3>
        <div>
            <form name="form_faturar" id="form_faturar" action="<?= base_url() ?>estoque/solicitacao/gravarfaturamento" method="post">
                <fieldset>

                    <table>
                        <tr>
                            <td colspan="10">
                                <label>Valor total a faturar</label>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="10">
                                <input type="text" style="width:100pt" name="valorafaturar" id="valorafaturar" class="texto01" value="<?= @$solicitacao[0]->valor_total; ?>" readonly />
                                <!--<input type="hidden" name="financeiro" id="financeiro" class="texto01" value="<?= @$solicitacao_cliente[0]->financeiro; ?>"/>-->
                                <input type="hidden" name="estoque_solicitacao_id" id="estoque_solicitacao_id" class="texto01" value="<?= @$estoque_solicitacao_id; ?>"/>
                                <input type="hidden" name="contrato_id" id="contrato_id" class="texto01" value="<?= @$solicitacao_cliente[0]->contrato_id; ?>"/>
                                <input type="hidden" name="credor_devedor_id" id="credor_devedor_id" class="texto01" value="<?= @$solicitacao_cliente[0]->credor_devedor_id; ?>"/>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="10">
                                <label>Desconto</label>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="10">
                                <input style="width:100pt" type="text" name="desconto" id="desconto" class="texto01" value="<?= $solicitacao[0]->desconto; ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td>Valor</td>
                            <td>Descricao de pagamento</td>
                            <td>Forma de pagamento</td>
<!--                            <td>Ajuste(%)</td>
                            <td>Valor Ajustado</td>-->
                            <!--<td>Parcelas1</td>-->
                        </tr>
                        <tr>
                            <td>
                                <input style="width:100pt" type="text" name="valor1" id="valor1" class="texto01" value="<?= @$solicitacao[0]->valor_total; ?>" onblur="history.go(0)" />
                            </td>
                            <td>
                                <input type="hidden" name="formapamento1_boleto" id="formapamento1_boleto" class="texto01"/>
                                <select  name="formapamento1" id="formapamento1" class="size4" style="min-width: 200pt">
                                    <option value="">Selecione</option>
                                    <? foreach ($descricao_pagamento as $item) : ?>
                                        <option value="<?= $item->descricao_forma_pagamento_id; ?>" ><?= $item->nome; ?></option>
                                    <? endforeach; ?>
                                </select>
                            </td>
                            <td>
                                <select  name="forma_pagamento_1" id="forma_pagamento_1" class="size03" style="width:150pt">
                                    <option value="">Selecione</option>
                                    <? foreach ($forma_pagamento as $item) : ?>
                                        <option value="<?= $item->forma_pagamento_id; ?>" ><?= $item->nome; ?></option>
                                    <? endforeach; ?>
                                </select>
                            </td>
<!--                            <td>
                                <input type="text" name="ajuste1" id="ajuste1" size="1" value="<?= $valor; ?>" onblur="history.go(0)"/>                                                                           
                            </td> 
                            <td> 
                                <input type="text" name="valorajuste1" id="valorajuste1" size="1" value="<?= $valor; ?>" onblur="history.go(0)"/> 
                            </td>-->
<!--                            <td>
                                <input style="width: 60px;" type="number" name="parcela1" id="parcela1"  value="1" min="1" /> 
                            </td>-->


                        </tr>
                        <br/>
                        <tr>
                            <td colspan="10"><label>Diferen&ccedil;a</label></td>
                        </tr>
                        <tr>
                            <td colspan="10">
                                <input type="text" name="valortotal" id="valortotal"  class="texto01" readonly/>
                                <input type="hidden" name="valorcadastrado" id="valorcadastrado" value="<?= $solicitacao[0]->valor_total; ?>"/>
                                <input type="hidden" name="novovalortotal" id="novovalortotal">
                            </td>  
                        </tr>   
                    </table>

                    <hr/>
                    <button type="submit" name="btnEnviar" >Enviar</button>
            </form>
            </fieldset>
        </div>
    </div> <!-- Final da DIV content -->
</body>

<script type="text/javascript">


    $(document).ready(function () {

        function multiplica()
        {
            total = 0;
            valor = parseFloat(document.form_faturar.valorcadastrado.value.replace(",", "."));
            valordesconto = parseFloat(document.form_faturar.desconto.value.replace(",", "."));
            desconto = (100 - valordesconto) / 100;
            numer1 = parseFloat(document.form_faturar.valor1.value.replace(",", "."));
            total += numer1;

            valordescontado = valor - valordesconto;
            resultado = valor - (total + valordesconto);
            y = resultado.toFixed(2);
            $('#valortotal').val(y);
            $('#novovalortotal').val(valordescontado);
        }
        multiplica();

        $(function () {
            $('#formapamento1').change(function () {
                if ($(this).val()) {
                    forma_pagamento_id = document.getElementById("formapamento1").value;
                    $('.carregando').show();
                    $.getJSON('<?= base_url() ?>autocomplete/formapagamentosolicitacao/' + forma_pagamento_id + '/', {formapamento1: $(this).val(), ajax: true}, function (j) {
                        options = "";
                        parcelas = "";
                        document.getElementById("formapamento1_boleto").value = j[0].boleto;
                        options = j[0].ajuste;
                        parcelas = j[0].parcelas;
                        numer_1 = parseFloat(document.form_faturar.valor1.value.replace(",", "."));
                        if (j[0].parcelas != null) {
                            document.getElementById("parcela1").max = parcelas;
                        } else {
                            document.getElementById("parcela1").max = '1';
                        }
                        if (j[0].ajuste != null) {
                            document.getElementById("ajuste1").value = options;
                            valorajuste1 = (numer1 * options) / 100;
                            pg1 = numer_1 + valorajuste1;
                            document.getElementById("valorajuste1").value = pg1;
//                                                        document.getElementById("desconto1").type = 'text';
//                                                        document.getElementById("valordesconto1").type = 'text';
                        } else {
                            document.getElementById("ajuste1").value = '0';
                            document.getElementById("valorajuste1").value = '0';

                        }
                        $('.carregando').hide();
                    });
                } else {
                    $('#ajuste1').html('value=""');
                }
            });
        });
    });
</script>