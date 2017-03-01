<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <form name="form_sala" id="form_sala" action="<?= base_url() ?>estoque/boleto/gerarboletobanconordeste" method="post">

        <div>        
            <a href="<?= base_url() ?>estoque/boleto/gerarboletobnb/<?= @$boleto[0]->estoque_boleto_id; ?>">
                <button type="button" id="novaParcela">Gerar Boleto</button>
            </a>
            <a href="<?= base_url() ?>estoque/boleto/imprimirboletobnb/<?= @$boleto[0]->estoque_boleto_id; ?>">
                <button type="button" id="novaParcela">Imprimir Boleto</button>
            </a>
            <a href="#">
                <button type="button" id="novaParcela">Pedido de baixa</button>
            </a>
            <a href="#">
                <button type="button" id="novaParcela">Alteração de Vencimento</button>
            </a>
            <a href="#">
                <button type="button" id="novaParcela">Alteração de Outros Dados</button>
            </a>
        </div>

        <br>


        <fieldset>
            <legend>Status do Boleto</legend>
            <?
            $baixa = ($boleto[0]->baixa == 't') ? "<span class='red'>BOLETO CANCELADO</span>" : "";
            $pagado = ($boleto[0]->pagado == 't') ? "<span class='green'>PAGAMENTO EFETUADO</span>" : "<span class='red'>PAGAMENTO PENDENTE</span>";
            $registro = ($boleto[0]->registrado == 't') ? "<span class='green'>REGISTRADO</span>" : "<span class='red'>NAO REGISTRADO</span>";
            $dataRegistro = ($boleto[0]->data_registro != '') ? date("d/m/Y", strtotime($boleto[0]->data_registro)) : "--";
            $dataPagamento = ($boleto[0]->data_pagamento != '') ? date("d/m/Y", strtotime($boleto[0]->data_pagamento)) : "--";
            $valor = number_format((float) $boleto[0]->valor, 2, ',', '');
            $boleto[0]->baixa;
            ?>
            <div class="table">    
                <div>
                    <fieldset><center><?= $registro ?></center></fieldset>
                </div>

                <div>
                    <fieldset>
                        <span class="title">Data de Registro</span>
                        <span class="conteudo"><center><?= $dataRegistro ?></center></span>
                    </fieldset>
                </div>

                <div>
                    <fieldset><center><?= $pagado ?></center></fieldset>
                </div>

                <div>
                    <fieldset>
                        <span class="title">Data do Pagamento</span>
                        <span class="conteudo"><center><?= $dataPagamento ?></center></span>
                    </fieldset>
                </div>

                <div>
                    <fieldset>
                        <span class="title">Valor</span>
                        <span class="conteudo"><center>R$ <?= $valor ?></center></span>
                    </fieldset>
                </div>

                <? if ($baixa != ''): ?>
                    <div>
                        <fieldset><center><?= $baixa ?></center></fieldset>
                    </div>
                <? endif; ?>

            </div>
        </fieldset>

        <fieldset>
            <legend>Dados do Cliente</legend>
            <div>        
                <label>Nome do Cliente</label>
                <input type="text" name="descricao" id="descricao" class="texto05" value="<?= @$boleto[0]->cliente; ?>" readonly />
            </div>
            <div>        
                <label>Telefone</label>
                <input type="text" name="forma_pagamento" id="forma_pagamento" class="texto03" value="<?= @$boleto[0]->cliente_telefone; ?>" readonly />
            </div>
            <div>        
                <label>Email</label>
                <input type="text" name="forma_pagamento" id="forma_pagamento" class="texto05" value="<?= @$boleto[0]->cliente_email; ?>" readonly />
            </div>
            <div>        
                <label>Endereço</label>
                <input type="text" name="descricao" id="descricao" class="texto05" value="<?= @$boleto[0]->cliente_logradouro . ' ' . @$boleto[0]->cliente_numero; ?>" readonly />
            </div>
            <div>        
                <label>Bairro</label>
                <input type="text" name="descricao" id="descricao" class="texto03" value="<?= @$boleto[0]->cliente_bairro; ?>" readonly />
            </div>
            <div>        
                <label>Municipio</label>
                <input type="text" name="descricao" id="descricao" class="texto03" value="<?= @$boleto[0]->cliente_municipio; ?>" readonly />
            </div>
            <div>        
                <label>UF</label>
                <input type="text" name="descricao" id="descricao" class="texto02" value="<?= @$boleto[0]->cliente_estado; ?>" readonly />
            </div>
        </fieldset>

        <fieldset>
            <legend>Dados do Pagamento</legend>
            <div>        
                <label>Descriçao do Pagamento</label>
                <input type="text" name="descricao" id="descricao" class="texto05" value="<?= @$boleto[0]->descricao; ?>" readonly />
            </div>
            <div>        
                <label>Forme de Pagamento</label>
                <input type="text" name="forma_pagamento" id="forma_pagamento" class="texto05" value="<?= @$boleto[0]->forma_pagamento; ?>" readonly />
            </div>
            <div>        
                <label>Nome da Conta</label>
                <input type="text" name="descricao" id="descricao" class="texto05" value="<?= @$conta[0]->descricao_conta; ?>" readonly />
            </div>
            <div>        
                <label>Agencia</label>
                <input type="text" name="agencia" id="agencia" class="texto01" value="<?= @$conta[0]->agencia; ?>" readonly />
            </div>
            <div>        
                <label>Conta</label>
                <input type="text" name="conta" id="conta" class="texto02" value="<?= @$conta[0]->conta; ?>" readonly />
            </div>
            <div>        
                <label>Digito</label>
                <input type="text" name="conta" id="conta" class="texto00" value="<?= @$conta[0]->digito; ?>" readonly />
            </div>
        </fieldset>

    </form>



</div> <!-- Final da DIV content -->
<style>
    #novaParcela{
        width: 150pt;
        height: 22pt;
        background-color: #2c3e50;
        font-size: 10pt;
        color: black;
        border-radius: 20pt;
    }
    #novaParcela:hover{
        cursor: pointer;
        border: 1pt solid #999;
        font-weight: bold;
        color: #b30707;
    }
    .red{
        color: #b30707;
        font-size: 9pt;
        font-weight:501;
    }
    .green{
        color: green;
        font-size: 9pt;
        font-weight:501;
    }
    table {
        padding: 50pt;
    }
    div fieldset{
        min-height: 22pt;
        min-width: 75pt;
        font-weight: bold;
        display: inline;
        position: relative;
    }

    div span.title{
        font-size: 9pt;
        font-weight:501;
        color: black;
        position: absolute;
        margin-top: -5pt; 
    }

    div span.conteudo{
        font-size: 9pt;
        color: green;
        font-weight:501;
        position: absolute;
        margin-top: 10pt; 
    }
</style>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
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