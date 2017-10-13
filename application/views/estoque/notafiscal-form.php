<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <form name="form_sala" id="form_sala" action="<?= base_url() ?>estoque/notafiscal/gravarnotafiscaleletronica" method="post">
        <fieldset>
            <legend>Informações Necessarias para Gerar a NF-e</legend>
            <div style="width: 100%;">        
                <div>        
                    <input type="hidden" name="estoque_cliente_id" id="estoque_cliente_id" value="<?=@$solicitacao_cliente_id?>">
                    <input type="hidden" name="nota_fiscal_id" id="nota_fiscal_id" value="<?=@$notafiscal_id?>">
                    <input type="hidden" name="modeloNota" id="modeloNota" value="55"> <!-- NF-e -->
                    
                    <label>Tipo de NF*</label>
                    <select name="tpNF" required="" class="size2">
                        <option value="">Selecione</option>
                        <option value="0" >Entrada</option>
                        <option value="1" selected="">Saida</option>
                    </select>
                </div>
                
<!--                <div> 
                    <label>Modelo de Nota *</label>
                    <select name="modeloNota" required="" class="size1">
                        <option value="">Selecione</option>
                        <option value="55" selected="">NF-e</option>
                        <option value="65">NFC-e</option>
                    </select>
                </div>-->
                
                <div> 
                    <label>Tipo de Pagamento *</label>
                    <select name="tpPag" required="" class="size6">
                        <option value="">Selecione</option>
                        <option value="0" selected="">Pagamento à vista</option>
                        <option value="1">Pagamento a prazo</option>
                        <option value="2">Outros</option>
                    </select>
                </div>
                
                <div> 
                    <label>Finalidade da Nota *</label>
                    <select name="finalidadeNota" required="" class="size2">
                        <option value="">Selecione</option>
                        <option value="1" selected="">NF-e normal</option>
                        <option value="2">NF-e complementar</option>
                        <option value="3">NF-e de ajuste</option>
                        <option value="4">Devolução de mercadoria</option>
                    </select>
                </div>
                
                <div>        
                    <? $titleInd = "Indicador de presença do comprador no estabelecimento comercial no momento da operação"; ?>
                    
                    <label><span title="<?= $titleInd ?>">Indicador de Presença *</span></label>
                    <select name="indicadorPresenca" required="" class="size2">
                        <option value="">Selecione</option>
                        <option value="0">Não se aplica (por exemplo, Nota Fiscal complementar ou de ajuste).</option>
                        <option value="1" selected="">Operação presencial.</option>
                        <option value="3">Operação não presencial, Teleatendimento.</option>
                        <option value="4">NFC-e em operação com entrega a domicílio.</option>
                        <option value="9">Operação não presencial, outros.</option>
                    </select>
                </div>                

            </div>


            <div>        
                <label>Natureza da Operaçao</label>
                <input type="text" name="natOperacap" id="natOperacap" class="texto05" required="" placeholder="Ex: Venda, Compra,  Bonificaçao..."/>
            </div>            


            <div>        
                <label>Observações</label>
                <input name="observacoes" id="observacoes" class="texto10" />
            </div>
            
            

<!--            <div>        
                <label>Juros (R$)</label>
                <input type="text" name="juros" id="juros" alt="decimal" class="texto01"/>
            </div>-->

<!--            <div style="display: block; width: 100%">
                <br>
                <input type="checkbox" name="enviar" id="enviar"/>
                <label for="enviar" style="display: inline-block;font-weight: bold;color: black; font-size: 10pt">Enviar p/ email.</label>
            </div>-->
            <div style="display: block; width: 100%">
                <br>
                <hr>
                <button type="submit" name="btnEnviar">Enviar</button>
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