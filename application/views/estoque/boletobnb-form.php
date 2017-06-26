
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
                <form name="form_sala" id="form_sala" action="<?= base_url() ?>estoque/boleto/criarboletobanconordeste" method="post">
                    <dl>
                        <dt>
                            <label>Carteira *</label>
                        </dt>
                        <dd>
                            <?
                            $selected = 'selected=""';
                            if(isset($boleto[0]->carteira)){
                                $selected = '';                                
                            }
                            ?>
                            <!--<input type="hidden" name="servico" id="servico" value="01">-->
                            <input type="hidden" name="estoque_boleto_id" id="estoque_boleto_id" value="<?= $estoque_boleto_id ?>">  
                            <select name="carteira" required="" class="size2">
                                <option value="">Selecione</option>
                                <option value="1" <? if(@$boleto[0]->carteira == '1') echo 'selected'?> >21 - Cobrança Simples Escritural - Boleto Emitido Pelo Banco</option>
                                <option value="2" <? if(@$boleto[0]->carteira == '2') echo 'selected'?>>41 - Cobrança Vinculada – Boleto Emitido Pelo Banco</option>
                                <option value="4" <? if(@$boleto[0]->carteira == '4') echo 'selected'?> <?=$selected?>>21 - Cobrança Simples - Boleto Emitido Pelo Cliente</option>
                                <option value="5" <? if(@$boleto[0]->carteira == '5') echo 'selected'?>>41 - Cobrança Vinculada - Boleto Emitido Pelo Cliente</option>
                                <!--<option value="1" <? if(isset($boleto[0]->carteira)) echo 'selected'?>>51 - Cobrança Simplificada (Sem Registro)</option>-->
                            </select>
                            <? $selected = '';  ?>
                        </dd>

                        <dt>
                            <label>Serviço *</label>
                        </dt>
                        <dd>         
                            <?
                            $selected = 'selected=""';
                            if(isset($boleto[0]->servico)){
                                $selected = '';                                
                            }
                            ?>
                            <select name="servico" required="" class="size2">
                                <option value="">Selecione</option>
                                <option value="01" <? if(@$boleto[0]->servico == '01') echo 'selected'?> >Entrada Normal</option>
                                <option value="02" <? if(@$boleto[0]->servico == '02') echo 'selected'?> >Pedido de baixa</option>
                                <option value="04" <? if(@$boleto[0]->servico == '04') echo 'selected'?> >Concessão de Abatimento</option>
                                <option value="06" <? if(@$boleto[0]->servico == '06') echo 'selected'?> >Alteração de Vencimento</option>
                                <!--                        <option value="07">Alteração do Uso da empresa (Número de Controle)</option>
                                                        <option value="08">Alteração de Seu número</option>-->
                                <option value="09" <? if(@$boleto[0]->servico == '09') echo 'selected'?>  <?=$selected?>>Protestar</option>
                                <option value="10" <? if(@$boleto[0]->servico == '10') echo 'selected'?> >Não Protestar</option>
                                <option value="12" <? if(@$boleto[0]->servico == '12') echo 'selected'?> >Inclusão de Ocorrência</option>
                                <!--<option value="13">Exclusão de ocorrência</option>-->
                                <!--<option value="31">Alteração de Outros Dados</option>-->
                                <option value="32" <? if(@$boleto[0]->servico == '32') echo 'selected'?> >Pedido de Devolução</option>
                                <option value="33" <? if(@$boleto[0]->servico == '33') echo 'selected'?> >Pedido de Devolução (entregue ao Sacado).</option>
                                <option value="99" <? if(@$boleto[0]->servico == '99') echo 'selected'?> >Pedido dos Títulos em Aberto</option>
                            </select>
                            <? $selected = '';  ?>
                        </dd>

                        <dt>
                            <label>Especie *</label>
                        </dt>
                        <dd>   
         
                            <?
                            $selected = 'selected=""';
                            if(isset($boleto[0]->especie_documento)){
                                $selected = '';                                
                            }
                            ?>
                            <select name="especie" required="" class="size2">
                                <option value="">Selecione</option>
                                <option value="01" <? if(@$boleto[0]->especie_documento == '01') echo 'selected'?> <?=$selected?>>DM - Duplicata Mercantil</option>
                                <option value="02" <? if(@$boleto[0]->especie_documento == '02') echo 'selected'?> >NP - Nota Promissória</option>
                                <option value="03" <? if(@$boleto[0]->especie_documento == '03') echo 'selected'?> >CH - Cheque</option>
                                <option value="04" <? if(@$boleto[0]->especie_documento == '04') echo 'selected'?> >Carnê</option>
                                <option value="05" <? if(@$boleto[0]->especie_documento == '05') echo 'selected'?> >RC - Recibo</option>
                                <option value="06" <? if(@$boleto[0]->especie_documento == '06') echo 'selected'?> >DS - Duplicata Prest. Serviços</option>
                                <option value="19" <? if(@$boleto[0]->especie_documento == '19') echo 'selected'?> >OU - Outros</option>
                            </select>
                        </dd>
                        <? $selected = '';  ?>

                        <dt>
                            <label>Aceite *</label>
                        </dt>
                        <dd>  
                            
                            <?
                            $selected = 'selected=""';
                            if(isset($boleto[0]->aceite)){
                                $selected = '';                                
                            }
                            ?>
                            <select name="aceite" required="" class="size2">
                                <option value="">Selecione</option>
                                <option value="N"  <? if(@$boleto[0]->aceite == 'N') echo 'selected'?> <?=$selected?>>N ou B</option>
                                <option value="S" <? if(@$boleto[0]->aceite == 'S') echo 'selected'?>>S ou A</option>
                            </select>
                        </dd>
                        
                        <? $selected = '';  ?>

                        <dt>
                            <label>Instrução *</label>
                        </dt>
                        <dd>  
                            <?
                            $selected = 'selected=""';
                            if(isset($boleto[0]->instrucao_boleto)){
                                $selected = '';                                
                            }
                            ?>
                            <select name="instrucao" required="" class="size2">
                                <option value="">Selecione</option>
                                <option value="0005" <? if(@$boleto[0]->instrucao_boleto == '0005') echo 'selected'?>>Acatar instruções contidas no título</option>
                                <option value="0008" <? if(@$boleto[0]->instrucao_boleto == '0008') echo 'selected'?>>Não cobrar encargos moratórios</option>
                                <option value="0012" <? if(@$boleto[0]->instrucao_boleto == '0012') echo 'selected'?>>Não receber após vencimento</option>
                                <option value="0015" <? if(@$boleto[0]->instrucao_boleto == '0015') echo 'selected'?>>Após vencimento, cobrar comissão de permanência do BANCO DO NORDESTE</option>
                                <option value="0000" <? if(@$boleto[0]->instrucao_boleto == '0000') echo 'selected'?> <?=$selected?>>Sem Instruções – Acata as instruções da Carteira do Cedente</option>
                            </select>
                            
                        <? $selected = '';  ?>
                        </dd>
                        

                        <dt>
                            <label>Vencimento *</label>
                        </dt>
                        <dd>  
                            <input type="text" name="vencimento" id="vencimento" alt="date" value="<?= date("d/m/Y", strtotime($boleto[0]->data_vencimento)) ?>" class="texto02" required=""/>
                        </dd>

                        <dt>
                            <label>Juros (R$ ao dia)</label>
                        </dt>
                        <dd>  
                            <? //$value = "value='".str_replace()"'"?>
                            <input type="text" name="juros" id="juros" alt="decimal" class="texto01"/>
                        </dd>
                        <dt>
                            <label>Multa (R$)</label>
                        </dt>
                        <dd>  
                            <? //$value = "value='".str_replace()"'"?>
                            <input type="text" name="multa" id="multa" alt="decimal" class="texto01"/>
                        </dd>
                        <dt>
                            <label>Mensagem do Cedente</label>
                        </dt>
                        <dd>  
                            <input type="text" name="mensagem" id="mensagem" class="texto06" maxlength="40" value="<?=@$boleto[0]->mensagem_cedente?>"/>
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