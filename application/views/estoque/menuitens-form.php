<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <!--<div class="clear"></div>-->
    <div style="display: block; position: relative; width: 100%;">
        <form name="form_menuitens" id="form_menuitens" action="<?= base_url() ?>estoque/menu/gravaritens" method="post">
            <fieldset>
                <legend>Menu produtos</legend>
                <div>
                    <label>Nome</label>
                    <input type="hidden" name="txtestoque_menu_id" value="<?= $menu[0]->estoque_menu_id; ?>" />
                    <input type="hidden" name="configTodosItens" id="configTodosItens" readonly value="false"/>
                    <input type="text" name="txtNome" class="texto10 bestupper" value="<?= $menu[0]->descricao; ?>"  readonly />
                </div>
            </fieldset>
            <fieldset>
                <legend>Cadastro de Produtos</legend>
                <!--            <div>-->
                <dl>
                    <label>Tipo</label>
                </dl>
                <dd>
                    <select name="tipo_id" id="tipo_id" class="size3">
                        <option value="">SELECIONE</option>
                        <? foreach ($tipo as $value) : ?>
                            <option value="<?= $value->estoque_tipo_id; ?>"><?php echo $value->descricao; ?></option>
                        <? endforeach; ?>
                    </select>
                </dd>
                <dl>
                    <label>Classe</label>
                </dl>
                <dd>
                    <select name="classe_id" id="classe_id" class="size3">
                        <option value="">SELECIONE</option>
                    </select>
                </dd>
                <dl>
                    <label>Sub-classe</label>
                </dl>
                <dd>
                    <select name="subclasse_id" id="subclasse_id" class="size3">
                        <option value="">SELECIONE</option>
                    </select>
                    &nbsp;&nbsp;&nbsp;
                    <input type="checkbox" name="configTodos" id="configTodos" />
                    <span style="font-weight: bold;">Conf. Todos os Produtos</span>

                </dd>
                <!--            </div>-->
                <br/>
                <div style='width: 98%;' class="produtosSubClasse">
                    <div>
                        <table>
                            <tr>
                                <td>
                                    <div>
                                        <label>Produtos</label>
                                        <select name="produto_id_item" id="produto_id_item" class="size4" required="true">
                                            <option value="">SELECIONE</option>
                                            <? foreach ($produto as $value) : ?>
                                                <option value="<?= $value->estoque_produto_id; ?>" onclick="carregaValor('<?= $value->valor_venda; ?>:<?= $value->valor_compra; ?>')"><?php echo $value->descricao; ?></option>
                                            <? endforeach; ?>
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <label>Valor Compra</label>
                                        <input type="text" name="valorCompra[0]" id="valorCompra[0]" alt="decimal" class="texto02" required/>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <label>Percentual</label>
                                        <input type="text" name="percentual[0]" id="percentual[0]" alt="decimal" class="texto02" onblur="calculaValorVenda('0')" required/>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <input type="checkbox" name="desconto[0]" id="valor[0]" onchange="calculaValorVenda('0')"/>
                                        <span style="font-weight: bold; margin-left:3pt;">Desconto</span>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <label>Valor Venda</label>
                                        <input type="text" name="valorvenda[0]" id="valorvenda[0]" alt="decimal" class="texto02" required/>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <label>Valor Venda Menu</label>
                                        <input type="text" name="valor[0]" id="valor[0]" alt="decimal" class="texto02" required/>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <dl>
                    <label>&nbsp;</label>
                </dl>
                <dd>
                    <button type="submit" name="btnEnviar">Adicionar</button>
                </dd>
        </form>
        </fieldset>

        <fieldset>
            <legend>Produtos Adicionados</legend>
            <?
            if ($contador > 0) {
                ?>
                <table id="table_agente_toxico" border="0">
                    <thead>

                        <tr>
                            <th class="tabela_header">Produtos</th>
                            <th class="tabela_header">Valor</th>
                            <th class="tabela_header">&nbsp;</th>
                        </tr>
                    </thead>
                    <?
                    $estilo_linha = "tabela_content01";
                    foreach ($produtos as $item) {
                        ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                        ?>
                        <tbody>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->descricao; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= number_format($item->valor, 2, ',', '.'); ?></td>
                                <td class="<?php echo $estilo_linha; ?>" width="100px;">
                                    <a href="<?= base_url() ?>estoque/menu/excluirmenu/<?= $item->estoque_menu_produtos_id; ?>/<?= $menu[0]->estoque_menu_id; ?>" class="delete">
                                    </a>

                                </td>
                            </tr>

                        </tbody>
                        <?
                    }
                }
                ?>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="4">
                        </th>
                    </tr>
                </tfoot>
            </table> 

        </fieldset>
        </form>
    </div> 
</div> <!-- Final da DIV content -->
<div class="clear"></div>
<style>

    .produtosSubClasse{
        border: 1px solid gray;
        border-radius: 10pt;
        padding: 5pt;
    }

    .tbTitulo {font-size: 11pt; text-decoration: none; text-transform: uppercase}
</style>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.maskedinput.js" ></script>
<script type="text/javascript">
                                            var formPadrao = '<div><table><tr><td><div><label>Produtos</label><select name="produto_id_item" id="produto_id_item" class="size4" required="true"><option value="">SELECIONE</option>';
<? foreach ($produto as $value) : ?>
                                                formPadrao += '<option value="<?= $value->estoque_produto_id; ?>" onclick="carregaValor(\'<?= $value->valor_venda; ?>:<?= $value->valor_compra; ?>\')"><?= $value->descricao; ?></option>';
<? endforeach; ?>
                                            formPadrao += '</select></div></td><td><div><label>Valor Compra</label><input type="text" name="valorCompra[0]" id="valorCompra[0]" alt="decimal" class="texto02" required/>';
                                            formPadrao += '</div></td><td><div><label>Percentual</label><input type="text" name="percentual[0]" id="percentual[0]" alt="decimal" class="texto02" onblur="calculaValorVenda(\'0\')" required/></div>';
                                            formPadrao += '</td><td><div><input type="checkbox" name="desconto[0]" id="valor[0]" onchange="calculaValorVenda(\'0\')"/><span style="font-weight: bold; margin-left:3pt;">Desconto</span>';
                                            formPadrao += '</div></td><td><div><label>Valor Venda</label><input type="text" name="valorvenda[0]" id="valorvenda[0]" alt="decimal" class="texto02" required/></div></td>';
                                            formPadrao += '<td><div><label>Valor Venda Menu</label><input type="text" name="valor[0]" id="valor[0]" alt="decimal" class="texto02" required/></div></td></tr></table></div>';

                                            var totResultados = 0;
                                            function calculaValorVenda(indice) {
                                                var vPer = parseFloat($("input:text[name='percentual[" + indice + "]']").val());
                                                if ($("input:checkbox[name='desconto[" + indice + "]']").attr('checked')) {
                                                    var vCompra = parseFloat($("input:text[name='valorvenda[" + indice + "]']").val());
                                                    vPer = vPer * (-1);
                                                    var vVenda = (new Intl.NumberFormat('pt-BR', {minimumFractionDigits: 2,
                                                        maximumFractionDigits: 2}).format(
                                                            (vCompra + (vCompra * (vPer / 100)))));
                                                }
                                                else{
                                                    var vCompra = parseFloat($("input:text[name='valorCompra[" + indice + "]']").val());
                                                    var vVenda = (new Intl.NumberFormat('pt-BR', {minimumFractionDigits: 2,
                                                        maximumFractionDigits: 2}).format(
                                                            (vCompra + (vCompra * (vPer / 100)))));
                                                }
                                                var res = vVenda.replace(".", '');
                                                $("input:text[name='valor[" + indice + "]']").val(res);
                                            }

                                            function validar(dom, tipo) {
                                                switch (tipo) {
                                                    case'num':
                                                        var regex = /[A-Za-z\.\-\+]/g;
                                                        break;
                                                    case'text':
                                                        var regex = /\d/g;
                                                        break;
                                                }
                                                dom.value = dom.value.replace(regex, '');
                                            }

                                            function carregaValor(valor) {
                                                var splitValores = valor.split(':');
//                                                    console.log(splitValores);
                                                $("input:text[name='valorvenda[0]']").val(splitValores[0]);
                                                $("input:text[name='valor[0]']").val(splitValores[0]);
                                                $("input:text[name='valorCompra[0]']").val(splitValores[1]);
//                                                    $("#valorCompra[0]").val(splitValores[1]);
                                            }

                                            function configuraTodos() {
                                                $("#configTodosItens").val('true');
                                                var opcoesCabecalho = '<table border="1" cellspacing="5" cellpadding="5">\n\
                                                                                <tr> \n\
                                                                                   <td colspan="1" style="text-align:right">&nbsp;&nbsp;&nbsp;</td> \n\
                                                                                   <td><span style="font-weight: bold; margin-right:3pt;">Percentual</span><input type="text" name="percentualTodos" id="percentualTodos" onkeyup="validar(this, \'num\');" class="texto01" /></td> \n\
                                                                                   <td> <input type="checkbox" name="descontoTodos" id="descontoTodos"/><span style="font-weight: bold; margin-left:3pt;">Desconto</span></td>';
//                                                            opcoesCabecalho += '<td></td>';
                                                opcoesCabecalho += '<td colspan="2" ><button type="button" id="aplicarTodos">Aplicar a Todos</button></td>';
                                                opcoesCabecalho += '<td colspan="2" ><input type="checkbox" name="selTodos" id="selTodos"/><span style="font-weight: bold; margin-left:3pt;">Salvar Todos</span></tr>';
                                                opcoesCabecalho += '<tr><td colspan="8"  style="border-bottom: 1px solid black;"></td></tr>';
                                                opcoesCabecalho += '<tr> <td>&nbsp;</td> <td><span class="tbTitulo">Produto</span></td> <td><span class="tbTitulo">Vlr Compra</span></td> <td><span class="tbTitulo">Percentual</span></td> <td><span class="tbTitulo">Desconto</span></td> <td><span class="tbTitulo">Vlr Venda</span></td> <td><span class="tbTitulo">Vlr Venda Menu</span></td> <td><span class="tbTitulo">Salvar?</span></td> </tr>';
                                                var options = '';
                                                $.getJSON('<?= base_url() ?>autocomplete/estoqueprodutosporsubclasse', {subclasse_id: $("#subclasse_id").val(), ajax: true}, function (j) {
//                                                                console.log(j);
                                                    for (var c = 0; c < j.length; c++) {
                                                        var prodID = '<td><input type="hidden" name="produto_id[' + [c] + ']" id="produto_id[' + [c] + ']" value="' + j[c].estoque_produto_id + '" class="texto02" /></td>';
                                                        var nome = '<td><input type="text" name="nome[' + [c] + ']" id="nome[' + [c] + ']" alt="decimal" class="texto06" value="' + j[c].descricao + '" readonly/></td>';
                                                        var vlrCompra = '<td><input type="text" name="valorCompra[' + [c] + ']" id="valorCompra[' + [c] + ']"  onkeyup="validar(this, \'num\');" class="texto02" value="' + j[c].valor_compra + '"/></td>';
                                                        var vlrVendaMenu = '<td><input type="text" name="valor[' + [c] + ']" id="valor[' + [c] + ']"  onkeyup="validar(this, \'num\');" class="texto02" value="' + j[c].valor_venda + '"/></td>';
                                                        var vlrVenda = '<td><input type="text" name="valorvenda[' + [c] + ']" id="valorvenda[' + [c] + ']"  onkeyup="validar(this, \'num\');" class="texto02" value="' + j[c].valor_venda + '"/></td>';
                                                        var percentual = '<td><input type="text" name="percentual[' + [c] + ']" onblur="calculaValorVenda(\'' + c + '\')" onchange="calculaValorVenda(\'' + c + '\')" id="percentual[' + [c] + ']"  onkeyup="validar(this, \'num\');" class="texto01" /></td>';
                                                        var desconto = '<td><input type="checkbox" name="desconto[' + [c] + ']" id="desconto[' + [c] + ']" onchange="calculaValorVenda(\'' + c + '\')"/></td>';
                                                        var ativo = '<td><input type="checkbox" name="ativo[' + [c] + ']" id="ativo[' + [c] + ']"/></td>';
                                                        options += "<tr>" + prodID + nome + vlrCompra + percentual + desconto + vlrVenda + vlrVendaMenu + ativo + "</tr>";

                                                    }

                                                    totResultados = c;
                                                    options += '</table>';
                                                    var tudo = opcoesCabecalho + options;
                                                    $('.produtosSubClasse div').remove();
                                                    $('.produtosSubClasse').html(tudo).show();
                                                    $('.carregando').hide();
                                                });
                                            }

                                            $(function () {
                                                $('#classe_id').change(function () {
                                                    if ($(this).val()) {
                                                        $('.carregando').show();
                                                        $.getJSON('<?= base_url() ?>autocomplete/estoquesubclasseporclasse', {classe_id: $(this).val(), ajax: true}, function (j) {
                                                            options = '<option value="">SELECIONE -></option>';
                                                            for (var c = 0; c < j.length; c++) {
                                                                options += '<option value="' + j[c].estoque_sub_classe_id + '">' + j[c].descricao + '</option>';
                                                            }
                                                            $('#subclasse_id').html(options).show();
                                                            $('.carregando').hide();
                                                        });
                                                    } else {
                                                        $('#subclasse_id').html('<option value="">SELECIONE</option>');
                                                    }
                                                });
                                            });
                                            $(function () {
                                                $('#tipo_id').change(function () {
                                                    if ($(this).val()) {
                                                        $('.carregando').show();
                                                        $.getJSON('<?= base_url() ?>autocomplete/estoqueclasseportipo', {tipo_id: $(this).val(), ajax: true}, function (j) {
                                                            options = '<option value="">SELECIONE -></option>';
                                                            for (var c = 0; c < j.length; c++) {
                                                                options += '<option value="' + j[c].estoque_classe_id + '">' + j[c].descricao + '</option>';
                                                            }
                                                            $('#classe_id').html(options).show();
                                                            $('.carregando').hide();
                                                        });
                                                    } else {
                                                        $('#classe_id').html('<option value="">SELECIONE</option>');
                                                    }
                                                });
                                            });

                                            $(function () {
                                                $('#configTodos').change(function () {
                                                    if ($('#configTodos').attr('checked')) {
                                                        if ($('#subclasse_id').val() != '') {
                                                            configuraTodos();
                                                        }
                                                    } else {
                                                        $('.produtosSubClasse table').remove();
                                                        $('.produtosSubClasse').html(formPadrao).show();

                                                        if ($("#subclasse_id").val() != '') {
                                                            var options = '';
                                                            $.getJSON('<?= base_url() ?>autocomplete/estoqueprodutosporsubclasse', {subclasse_id: $("#subclasse_id").val(), ajax: true}, function (j) {
                                                                for (var c = 0; c < j.length; c++) {
                                                                    options += '<option value="' + j[c].estoque_produto_id + '" onclick="carregaValor(\'' + j[c].valor_venda + ":" + j[c].valor_compra + '\')">' + j[c].descricao + '</option>';
                                                                }
                                                                $('#produto_id').html(options).show();
                                                                if ($('#configTodos').attr('checked')) {
                                                                    configuraTodos();
                                                                }
                                                                $('.carregando').hide();
                                                            });
                                                        }
                                                    }
                                                });
                                            });

                                            $(function () {
                                                $('#subclasse_id').change(function () {
                                                    if ($(this).val()) {
                                                        $('.carregando').show();
                                                        var options = '';
                                                        $.getJSON('<?= base_url() ?>autocomplete/estoqueprodutosporsubclasse', {subclasse_id: $(this).val(), ajax: true}, function (j) {
//                                                              options = '<option value="">SELECIONE -></option>';
                                                            for (var c = 0; c < j.length; c++) {
//                                                                    console.log(j[c].valor_venda,j[c].valor_compra);
                                                                options += '<option value="' + j[c].estoque_produto_id + '" onclick="carregaValor(\'' + j[c].valor_venda + ":" + j[c].valor_compra + '\')">' + j[c].descricao + '</option>';
                                                            }
                                                            $('#produto_id').html(options).show();
                                                            if ($('#configTodos').attr('checked')) {
                                                                configuraTodos();
                                                            }
                                                            $('.carregando').hide();
                                                        });
                                                    } else {
                                                        $('#produto_id').html('<option value="">SELECIONE</option>');
                                                    }
                                                });
                                            });

                                            jQuery(function () {
                                                $("#selTodos").live('change', function () {
                                                    if (this.checked) {//passa todos para 'ativo'
                                                        for (var n = 0; n <= totResultados; n++) {
                                                            $('input:checkbox[name="ativo[' + n + ']"]').attr('checked', 'true');
                                                        }
                                                    } else {//tira todos do ativo
                                                        for (var n = 0; n <= totResultados; n++) {
                                                            $('input:checkbox[name="ativo[' + n + ']"]').removeAttr('checked');
                                                        }
                                                    }
                                                });
                                            });
                                            jQuery(function () {
                                                $("#aplicarTodos").live('click', function () {
                                                    var percentual = $('#percentualTodos').val();
                                                    var __desconto = $('input:checkbox[name="descontoTodos"]').attr('checked');
                                                    if (__desconto == true) {
                                                        var desconto = true;
                                                    } else {
                                                        var desconto = false;
                                                    }

                                                    for (var n = 0; n <= totResultados; n++) {
                                                        $('input:text[name="percentual[' + n + ']"]').val(percentual);
                                                        if (desconto) {
                                                            $('input:checkbox[name="desconto[' + n + ']"]').attr('checked', 'true');
                                                        } else {
                                                            $('input:checkbox[name="desconto[' + n + ']"]').removeAttr('checked');
                                                        }
                                                        calculaValorVenda(n);
                                                    }
                                                });
                                            });
                                            $(function () {
                                                $("#accordion").accordion();
                                            });

                                            $(document).ready(function () {
                                                jQuery('#form_exametemp').validate({
                                                    rules: {
                                                        txtNome: {
                                                            required: true,
                                                            minlength: 3
                                                        },
                                                        nascimento: {
                                                            required: true
                                                        },
                                                        idade: {
                                                            required: true
                                                        }
                                                    },
                                                    messages: {
                                                        txtNome: {
                                                            required: "*",
                                                            minlength: "!"
                                                        },
                                                        nascimento: {
                                                            required: "*"
                                                        },
                                                        idade: {
                                                            required: "*"
                                                        }
                                                    }
                                                });
                                            });

</script>