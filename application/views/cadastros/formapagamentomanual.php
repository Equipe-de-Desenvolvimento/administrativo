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
                            <td><label>Periodo (dias)</label></td>
                            <td><label>Valor (%)</label></td>
                            <td><label>Prazo (dias)</label></td>
                            <td>&nbsp;</td>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <td colspan="5">
                                <div class="bt_link">
                                    <a href="#" id="novaParcela">Adicionar</a>
                                </div>
                            </td>
                        </tr>
                    </tfoot>

                    <tbody>
                        <tr class="linha1">
                            <td><input type="text" name="parcela[1]" class="texto01" required="" value="1"/></td>
                            <td><input type="text" name="dias[1]" class="texto01" required=""/></td>
                            <td><input type="text" name="valor[1]" class="texto01" required=""/></td>
                            <td><input type="text" name="prazo[1]" class="texto01" required=""/></td>
                            <td>
                                <a href="#" class="delete">Excluir</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- Fim da tabela de Infusão de Drogas -->
        </fieldset>
        <fieldset>




        <hr/>
        <button type="submit" name="btnEnviar">Enviar</button>
        </fieldset>

    </form>





</div> 

<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.maskedinput.js"></script>
<script type="text/javascript">
    $("#valor").mask('99,99');
    var idlinha = 2;
    var classe = 2;
    $(document).ready(function () {
        $('#novaParcela').click(function () {
            var linha = "<tr class='linha" + classe + "'>";
            linha += '<td><input type="text" name="parcela[' + idlinha + ']" class="texto01" required="" value="' + idlinha + '"/></td>';
            linha += '<td><input type="text" name="dias[' + idlinha + ']" class="texto01" required=""/></td>';
            linha += '<td><input type="text" name="valor[' + idlinha + ']" class="texto01" id="valor" required=""/></td>';
            linha += '<td><input type="text" name="prazo[' + idlinha + ']" class="texto01" required=""/></td>';
            linha += "<td>";
            linha += "<a href='#' class='delete'>Excluir</a>";
            linha += "</td>";
            linha += "</tr>";
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