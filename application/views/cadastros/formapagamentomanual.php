<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <h3 class="h3_title">Cadastro de Parcelas</h3>
    <form name="form_grupoconvenio" id="form_grupoconvenio" action="<?= base_url() ?>cadastros/formapagamento/gravarpagamentomanual" method="post">
        <fieldset>
            <legend>Parcelas</legend>
            <input type="hidden" name="formapagamento_id" class="texto01" value="<?= @$formapagamento[0]->forma_pagamento_id; ?>" />
            <div style="width:300pt">
                <table id="cadastroParcelas">
                    <thead>
                        <tr>
                            <td><label>Parcela</label></td>
                            <td><label><span title="Periodo, em dias, entre esta parcela e a proxima.">Periodo (dias)</span></label></td>
                            <td><label><span title="Valor percentual que devera ser pago nessa parcela.">Valor (%)</span></label></td>
                            <!--<td><label><span title="Prazo para o pagamento desta parcela.">Prazo (dias)</span></label></td>-->
                            <td>&nbsp;</td>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <td colspan="5"><hr></td>
                        </tr>
                        <tr>
                            <td colspan="1">
                                <button id="novaParcela">Adicionar</button>
                            </td>
                            <td colspan="4">

                                <input type="submit" name="btnEnviar" value="Enviar"/>
                            </td>
                        </tr>
                    </tfoot>

                    <tbody>
                        <tr class="linha1">
                            <td><input type="text" name="parcela[1]" class="texto01" required="" value="1"/></td>
                            <td><input type="text" name="dias[1]" class="texto01" required=""/></td>
                            <td><input type="text" name="valor[1]" class="texto01" required=""/></td>
                            <!--<td><input type="text" name="prazo[1]" class="texto01" value="0"/></td>-->
                            <td>
                                <a href="#" class="delete">Excluir</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- Fim da tabela de Infusão de Drogas -->
        </fieldset>
        <? if (count($parcelas) > 0): ?>
        <fieldset style="width: 50%;">
                <legend>Parcelas cadastradas</legend>
                <table>
                    <thead>
                        <th class="tabela_header" width="60">Parcela</th>
                        <th class="tabela_header">Dias</th>
                        <th class="tabela_header">Valor</th>
                        <!--<th class="tabela_header">Prazo</th>-->
                    </thead>
                    <tbody>
                        <?
                        $estilo_linha = "tabela_content01";
                        foreach ($parcelas as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->parcela; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->dias; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= number_format($item->valor, 2, ',', ''); ?> %</td>
                                <td class="<?php // echo $estilo_linha; ?>"><?= $item->prazo; ?></td>
                            </tr>
                        <? } ?>
                    </tbody>
                </table>
            </fieldset>
        <? endif; ?>

    </form>





</div> 
<style>
    #novaParcela{
        width: 55pt;
        height: 22pt;
        background-color: #2c3e50;
        font-size: 10pt;
        color: black;
        border-radius: 20pt;
    }
</style>
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.maskedinput.js"></script>
<script type="text/javascript">
    var idlinha = 2;
    var classe = 2;
    $(document).ready(function () {
        $('#novaParcela').click(function () {
            var linha = "<tr class='linha" + classe + "'>";
            linha += '<td><input type="text" name="parcela[' + idlinha + ']" class="texto01" required="" value="' + idlinha + '"/></td>';
            linha += '<td><input type="text" name="dias[' + idlinha + ']" class="texto01" required/></td>';
            linha += '<td><input type="text" name="valor[' + idlinha + ']" class="texto01" id="valor" required=""/></td>';
            linha += "<td>";
            linha += "<a href='#' class='delete'>Excluir</a>";
            linha += "</td>";
            linha += "</tr>";
//            var anterior = idlinha-1;
//            $('input:text[name="dias['+ anterior +']"]').attr("required",true);
            idlinha++;
            classe = (classe == 1) ? 2 : 1;
            $('#cadastroParcelas').append(linha);
            addRemove();
            return false;
        });
        function addRemove() {
            $('.delete').click(function () {
                $(this).parent().parent().remove();
                return false;
            });
        }
    });
</script>