
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
                <form name="form_sala" id="form_sala" action="<?= base_url() ?>estoque/boleto/criarboletosantander" method="post">
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
                                <option value="1" <? if(@$boleto[0]->carteira == '1') echo 'selected'?> >Eletrônica com registro</option>
                                <option value="3" <? if(@$boleto[0]->carteira == '3') echo 'selected'?> >Penhor eletrônica</option>
                                <option value="5" <? if(@$boleto[0]->carteira == '5') echo 'selected'?> <?=$selected?>>Rapida com registro - Boleto Emitido Pelo Cliente</option>
                                <option value="6" <? if(@$boleto[0]->carteira == '6') echo 'selected'?>>Penhor rápida</option>
                                <option value="7" <? if(@$boleto[0]->carteira == '7') echo 'selected'?>>Desconto Eletrônico</option>
                            </select>
                            <? $selected = '';  ?>
                        </dd>

                        <dt>
                            <label>Ocorrencia *</label>
                        </dt>
                        <dd>         
                            <?
                            $selected = 'selected=""';
                            if(isset($boleto[0]->servico)){
                                $selected = '';                                
                            }
                            ?>
                            <select name="servico" id="servico" required="" class="size2">
                                <option value="">Selecione</option>
                                <option value="01" <? if(@$boleto[0]->servico == '01') echo 'selected'?> >Entrada Normal</option>
                                <option value="02" <? if(@$boleto[0]->servico == '02') echo 'selected'?> >Pedido de baixa</option>
                                <option value="04" <? if(@$boleto[0]->servico == '04') echo 'selected'?> >Concessão de Abatimento</option>
                                <option value="06" <? if(@$boleto[0]->servico == '06') echo 'selected'?> >Alteração de Vencimento</option>
                                <option value="09" <? if(@$boleto[0]->servico == '09') echo 'selected'?> >Protestar</option>
                                <option value="98" <? if(@$boleto[0]->servico == '98') echo 'selected'?> <?=$selected?>>Não Protestar</option>
                            </select>
                            <div style="display: inline-block" id="divProtesto">
                                <label>Dias Protesto</label>
                                <input type="text" name="diasprotesto" id="diasprotesto" alt="integer" class="texto01" value="0"/>
                            </div>
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
                            $('#servico').change(function () {
                                if($(this).val() == '09'){
                                    $("#divProtesto").show();
                                }
                                else{
                                    $("#divProtesto").hide();
                                    $("#diasprotesto").val(0);
                                }
                                    
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