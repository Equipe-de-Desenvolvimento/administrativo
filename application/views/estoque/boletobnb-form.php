<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <form name="form_sala" id="form_sala" action="<?= base_url() ?>estoque/boleto/criarboletobanconordeste" method="post">
        <fieldset>
            <legend>Informações Necessarias para Gerar o Boleto</legend>
            <div style="width: 100%;">        
                <div>        
                    <input type="hidden" name="servico" id="servico" value="01">
                    <input type="hidden" name="estoque_boleto_id" id="estoque_boleto_id" value="<?=$estoque_boleto_id?>">
                    <label>Carteira *</label>
                    <select name="carteira" required="" class="size2">
                        <option value="">Selecione</option>
                        <option value="1">21 - Cobrança Simples Escritural - Boleto Emitido Pelo Banco</option>
                        <option value="2">41 - Cobrança Vinculada – Boleto Emitido Pelo Banco</option>
                        <option value="4" selected="">21 - Cobrança Simples - Boleto Emitido Pelo Cliente</option>
                        <option value="5">41 - Cobrança Vinculada - Boleto Emitido Pelo Cliente</option>
                        <option value="1">51 - Cobrança Simplificada (Sem Registro)</option>
                    </select>
                </div>

<!--                <div>        
                    <label>Serviço *</label>
                    <select name="servico" required="" class="size2">
                        <option value="">Selecione</option>
                        <option value="01">Entrada Normal</option>
                        <option value="02">Pedido de baixa</option>
                        <option value="04">Concessão de Abatimento</option>
                        <option value="06">Alteração de Vencimento</option>
                        <option value="07">Alteração do Uso da empresa (Número de Controle)</option>
                        <option value="08">Alteração de Seu número</option>
                        <option value="09">Protestar</option>
                        <option value="10">Não Protestar</option>
                        <option value="12">Inclusão de Ocorrência</option>
                        <option value="13">Exclusão de ocorrência</option>
                        <option value="31">Alteração de Outros Dados</option>
                        <option value="32">Pedido de Devolução</option>
                        <option value="33">Pedido de Devolução (entregue ao Sacado).</option>
                        <option value="99">Pedido dos Títulos em Aberto</option>
                    </select>
                </div>-->

                <div>        
                    <label>Especie *</label>
                    <select name="especie" required="" class="size2">
                        <option value="">Selecione</option>
                        <option value="01" selected="">DM - Duplicata Mercantil</option>
                        <option value="02">NP - Nota Promissória</option>
                        <option value="03">CH - Cheque</option>
                        <option value="04">Carnê</option>
                        <option value="05">RC - Recibo</option>
                        <option value="06">DS - Duplicata Prest. Serviços</option>
                        <option value="19">OU - Outros</option>
                    </select>
                </div>

                <div>        
                    <label>Aceite *</label>
                    <select name="aceite" required="" class="size2">
                        <option value="">Selecione</option>
                        <option value="N" selected="">N ou B</option>
                        <option value="S">S ou A</option>
                    </select>
                </div>

                <div>        
                    <label>Instrução *</label>
                    <select name="instrucao" required="" class="size2">
                        <option value="">Selecione</option>
                        <option value="0005" >Acatar instruções contidas no título</option>
                        <option value="0008" >Não cobrar encargos moratórios</option>
                        <option value="0012" >Não receber após vencimento</option>
                        <option value="0015" >Após vencimento, cobrar comissão de permanência do BANCO DO NORDESTE</option>
                        <option value="0000" >Sem Instruções – Acata as instruções da Carteira do Cedente</option>
                    </select>
                </div>
            </div>


            <div>        
                <label>Vencimento *</label>
                <input type="text" name="vencimento" id="vencimento" alt="date" class="texto02" required=""/>
            </div>            

            <div>        
                <label>Num. Documento</label>
                <input type="text" name="numDoc" id="numDoc" maxlength="25"/>
            </div>

            <div>        
                <label>Juros (R$)</label>
                <input type="text" name="juros" id="juros" alt="decimal" class="texto01"/>
            </div>

            <div>        
                <label>Mensagem do Cedente</label>
                <input type="text" name="mensagem" id="mensagem" class="texto06" maxlength="40"/>
            </div>

            <div style="display: block; width: 100%">
                <br>
                <hr>
                <button type="submit" name="btnEnviar">enviar</button>
            </div>

        </fieldset>
    </form>



</div> <!-- Final da DIV content -->

<script type="text/javascript">
    $(function () {
        $("#accordion").accordion();
    });

    $(function () {
        $("#vencimento").datepicker({
            autosize: true,
//            minDate: <?= date("d/m/Y") ?>,
            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            dateFormat: 'dd/mm/yy'
        });
    });

    $(function () {
        $('#convenio1').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenio', {convenio1: $(this).val(), ajax: true}, function (j) {
                    options = '<option value=""></option>';
                    for (var c = 0; c < j.length; c++) {
                        options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + '</option>';
                    }
                    $('#procedimento1').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#procedimento1').html('<option value="">Selecione</option>');
            }
        });
    });

</script>