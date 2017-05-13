
<style>
    .label{
        font-size: 12pt;
        font-weight: bold;
        display: inline;
        color: red;
    }
</style>
<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Informações Necessarias para Gerar o Boleto</a></h3>
        <div>
            <dl class="dl_desconto_lista">
                <form name="form_sala" id="form_sala" action="<?= base_url() ?>estoque/boleto/criarboletosbanconordestetodos" method="post">
                    <dl>
                        <dt>
                            <label>Carteira *</label>
                        </dt>
                        <dd>
                            <input type="hidden" name="solicitacao_cliente_id" id="solicitacao_cliente_id" value="<?= $solicitacao_cliente_id ?>">  
                            <select name="carteira" required="" class="size2">
                                <option value="">Selecione</option>
                                <option value="1">21 - Cobrança Simples Escritural - Boleto Emitido Pelo Banco</option>
                                <option value="2">41 - Cobrança Vinculada – Boleto Emitido Pelo Banco</option>
                                <option value="4" selected="">21 - Cobrança Simples - Boleto Emitido Pelo Cliente</option>
                                <option value="5">41 - Cobrança Vinculada - Boleto Emitido Pelo Cliente</option>
                                <option value="1">51 - Cobrança Simplificada (Sem Registro)</option>
                            </select>
                        </dd>

                        <dt>
                            <label>Serviço *</label>
                        </dt>
                        <dd>         
                            <select name="servico" required="" class="size2">
                                <option value="">Selecione</option>
                                <option value="01">Entrada Normal</option>
                                <option value="02">Pedido de baixa</option>
                                <option value="04">Concessão de Abatimento</option>
                                <option value="06">Alteração de Vencimento</option>
                                <!--                        <option value="07">Alteração do Uso da empresa (Número de Controle)</option>
                                                        <option value="08">Alteração de Seu número</option>-->
                                <option value="09">Protestar</option>
                                <option value="10">Não Protestar</option>
                                <option value="12">Inclusão de Ocorrência</option>
<!--                                <option value="13">Exclusão de ocorrência</option>
                                <option value="31">Alteração de Outros Dados</option>-->
                                <option value="32">Pedido de Devolução</option>
                                <option value="33">Pedido de Devolução (entregue ao Sacado).</option>
                                <option value="99">Pedido dos Títulos em Aberto</option>
                            </select>
                        </dd>

                        <dt>
                            <label>Especie *</label>
                        </dt>
                        <dd>   

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
                        </dd>

                        <dt>
                            <label>Aceite *</label>
                        </dt>
                        <dd>  
                            <select name="aceite" required="" class="size2">
                                <option value="">Selecione</option>
                                <option value="N" selected="">N ou B</option>
                                <option value="S">S ou A</option>
                            </select>
                        </dd>

                        <dt>
                            <label>Instrução *</label>
                        </dt>
                        <dd>  
                            <select name="instrucao" required="" class="size2">
                                <option value="">Selecione</option>
                                <option value="0005" >Acatar instruções contidas no título</option>
                                <option value="0008" >Não cobrar encargos moratórios</option>
                                <option value="0012" >Não receber após vencimento</option>
                                <option value="0015" >Após vencimento, cobrar comissão de permanência do BANCO DO NORDESTE</option>
                                <option value="0000" >Sem Instruções – Acata as instruções da Carteira do Cedente</option>
                            </select>
                        </dd>

<!--                        <dt>
                            <label>Vencimento *</label>
                        </dt>
                        <dd>  
                            <input type="text" name="vencimento" id="vencimento" alt="date" value="<?= date("d/m/Y", strtotime($boleto[0]->data_vencimento)) ?>" class="texto02" required=""/>
                        </dd>-->

                        <dt>
                            <label>Juros (R$)</label>
                        </dt>
                        <dd>  
                            <input type="text" name="juros" id="juros" alt="decimal" class="texto01"/>
                        </dd>
                        <dt>
                            <label>Mensagem do Cedente</label>
                        </dt>
                        <dd>  
                            <input type="text" name="mensagem" id="mensagem" class="texto06" maxlength="40"/>
                        </dd>
                        <dt>

                        </dt>
                        <dd>  
                            <button type="submit" name="btnEnviar">enviar</button>
                        </dd>

                        <!--</fieldset>-->
                    </dl>
                </form>
                <dl class="dl_desconto_lista">



                    </div> 
                    </div> 
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