<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <form name="form_sala" id="form_sala" method="post">

        <div>        
            <a href="<?= base_url() ?>estoque/notafiscal/informacoesnotafiscal/<?= @$solicitacao_cliente_id; ?>/<?= @$notafiscal_id; ?>">
                <button type="button" id="novaParcela">Gerar NF-e</button>
            </a>
            <a href="#">
                <button type="button" id="novaParcela">Cancelar NF-e</button>
            </a>
            <a href="#">
                <button type="button" id="novaParcela">Imprimir DANFe</button>
            </a>
        </div>

        <br>

        <fieldset>
            <legend>Dados do Cliente</legend>
            <div>        
                <label>Nome do Cliente</label>
                <input type="text" name="descricao" id="descricao" class="texto05" value="<?= @$destinatario[0]->nome; ?>" readonly />
            </div>
            <div>        
                <label>Telefone</label>
                <input type="text" name="forma_pagamento" id="forma_pagamento" class="texto03" value="<?= @$destinatario[0]->telefone; ?>" readonly />
            </div>
            <div>        
                <label>Email</label>
                <input type="text" name="forma_pagamento" id="forma_pagamento" class="texto05" value="<?= @$destinatario[0]->email; ?>" readonly />
            </div>
            <div>        
                <label>Endereço</label>
                <input type="text" name="descricao" id="descricao" class="texto05" value="<?= @$destinatario[0]->logradouro . ' ' . @$destinatario[0]->numero; ?>" readonly />
            </div>
            <div>        
                <label>Bairro</label>
                <input type="text" name="descricao" id="descricao" class="texto03" value="<?= @$destinatario[0]->bairro; ?>" readonly />
            </div>
            <div>        
                <label>Municipio</label>
                <input type="text" name="descricao" id="descricao" class="texto03" value="<?= @$destinatario[0]->municipio; ?>" readonly />
            </div>
            <div>        
                <label>UF</label>
                <input type="text" name="descricao" id="descricao" class="texto02" value="<?= @$destinatario[0]->estado; ?>" readonly />
            </div>
        </fieldset>

        <fieldset>
            <legend>Dados do Pedido</legend>
            <table>
                <thead>
                    <tr>
                        <th class="tabela_header">Produto</th>
                        <th class="tabela_header">Valor Unitario</th>
                        <th class="tabela_header">QTDE</th>
                        <th class="tabela_header">Valor Total</th>
                    </tr>
                </thead>
                <? $estilo_linha = "tabela_content01";
                   foreach ($produtos as $item) :
                       ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";?>
                       <tr>
                           <td class="<?php echo $estilo_linha; ?>"><?= $item->descricao; ?></td>
                           <td class="<?php echo $estilo_linha; ?>"><?= number_format($item->valor, 2, ',', ''); ?></td>
                           <td class="<?php echo $estilo_linha; ?>"><?= number_format($item->qtde_total, 0 , ',', ''); ?></td>
                           <td class="<?php echo $estilo_linha; ?>"><?= number_format($item->valor_total, 2, ',', ''); ?></td>
                       </tr>
                <? endforeach; ?>
            </table>
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