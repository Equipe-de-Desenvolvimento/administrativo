<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <div class="bt_link_voltar">
        <a href="<?= base_url() ?>estoque/contrato">
            Voltar
        </a>
    </div>

    <h3 class="singular"><a href="#">Cadastro de Contrato</a></h3>
    <div>
        <form name="form_contrato" id="form_contrato" action="<?= base_url() ?>estoque/contrato/gravar" method="post" style="margin-bottom: 50px;">
            <fieldset>
                <legend>Dados Cadastrais</legend>
                <div>
                    <label>Nome</label>                      
                    <input type="hidden" name ="contrato_id" value ="<?= @$obj->_estoque_contrato_id; ?>" id ="txtcontratoId">
                    <input type="text" id="txtNome" name="nome"  class="texto09" value="<?= @$obj->_nome; ?>" />
                </div>
                <div>
                    <label>Data inicio</label>
                    <input type="text" name="txtdata_inicio" id="txtdata_inicio" alt="date" class="texto02" value="<?= date("d/m/Y", strtotime($obj->_dt_inicio)); ?>"/>
                </div>
                <div>
                    <label>Data Termino</label>
                    <input type="text" name="txtdata_fim" id="txtdata_fim" alt="date" class="texto02" value="<?= date("d/m/Y", strtotime(@$obj->_dt_fim)); ?>"/>
                </div>
            </fieldset>
            <fieldset>
                <legend>Local do Contrato</legend>
                <div>
                    <label>Endere&ccedil;o</label>
                    <input type="text" id="txtendereco" class="texto10" name="endereco" value="<?= @$obj->_logradouro; ?>" />
                </div>
                <div>
                    <label>N&uacute;mero</label>


                    <input type="text" id="txtNumero" class="texto02" name="numero" value="<?= @$obj->_numero; ?>" />
                </div>
                <div>
                    <label>Bairro</label>
                    <input type="text" id="txtBairro" class="texto03" name="bairro" value="<?= @$obj->_bairro; ?>" />
                </div>
                <div>
                    <label>Complemento</label>


                    <input type="text" id="txtComplemento" class="texto06" name="complemento" value="<?= @$obj->_complemento; ?>" />
                </div>

                <div>
                    <label>Município</label>


                    <input type="hidden" id="txtCidadeID" class="texto_id" name="municipio_id" value="<?= @$obj->_municipio_id; ?>" readonly="true" />
                    <input type="text" id="txtCidade" class="texto04" name="txtCidade" value="<?= @$obj->_municipio_nome; ?>" />
                </div>
            </fieldset>

            <fieldset>
                <legend>Informaçoes do Contrato</legend>

                <div>
                    <label>Credor/Devedor *</label>
                    <select name="credor_devedor" id="credor_devedor" class="size8" required="">
                        <option value='' >selecione</option>
                        <?php
                        $credor_devedor = $this->convenio->listarcredordevedor();
                        foreach ($credor_devedor as $item) {
                            ?>

                            <option   value =<?php echo $item->financeiro_credor_devedor_id; ?> <?
                            if (@$obj->_credor_devedor == $item->financeiro_credor_devedor_id):echo 'selected';
                            endif;
                            ?>><?php echo $item->razao_social; ?></option>
                                      <?php
                                  }
                                  ?> 
                    </select>

                    <label>Tipo do Contrato *</label>
                    <select name="tipoContrato" id="tipoContrato" class="size8" required="">
                        <option value="">Selecione</option>required
                        <? foreach ($tipo_contrato as $tipo) : ?>
                            <option value="<?= $tipo->tipo_id; ?>" <?
                            if (@$obj->_tipo_contrato == $tipo->tipo_id):echo 'selected';
                            endif;
                            ?>>
                                <?= $tipo->descricao; ?> (<?= $tipo->tipo_movimentacao; ?>)</option>
                        <? endforeach; ?>
                    </select>

                </div>
                <div>
                    <label>Situaçao</label>
                    <input type="text" id="situacaoContrato" class="texto04" name="situacaoContrato" value="<?= @$obj->_situacao; ?>" />


                    <label>Numero do Contrato *</label>
                    <input type="text" id="numContrato" name="numContrato"  class="texto03" value="<?= @$obj->_numero_contrato; ?>"/>

                </div>
                <div>
                    <label>Data Assinatura</label>
                    <input type="text" name="txtdata_assinatura" id="txtdata_assinatura" alt="date" class="texto02" value="<?= date("d/m/Y", strtotime(@$obj->_dt_assinatura)); ?>"/>
                    <!--                </div>
                                    <div>-->
                    <label>Valor Inicial</label>
                    <input type="text" id="valorInicial" class="texto02" alt="decimal" name="valorInicial" value="<?= @$obj->_valor_inicial; ?>" />
                </div>


                <div>
                    <label>Calçao</label>
                    <input type="text" id="calcao" class="texto02" alt="decimal" name="calcao" value="<?= @$obj->_calcao; ?>" />
                </div>



            </fieldset>

            <fieldset>
                <legend>Dados do Pagamento</legend>
                <?
                $readonly = '';
                $required = 'required="true"';
                if (@$obj->_faturado == 't'): $readonly = 'readonly="true"'; $required = '';
                    ?>
                    <h4 style="color: red; font-weight: bold; text-decoration: underline">Esse contrato ja foi faturado! Nao sera possivel alterar os dados do pagamento.</h4>
                <? endif; ?>

                <div>
                    <label>Conta</label>
                    <select name="conta" id="conta" class="texto03">
                        <option value="">SELECIONE</option>
                        <? foreach ($conta as $value) { ?>
                            <option value="<?= $value->forma_entradas_saida_id ?>" <?
                            if (@$obj->_conta_id == $value->forma_entradas_saida_id):echo 'selected';
                            endif;
                            ?>><?= $value->descricao ?></option>
                                <? } ?>                            
                    </select>
                </div>
                <div>
                    <label>Valor da Parcela</label>
                    <input type="hidden" id="faturado" class="texto02" name="faturado" value="<?= @$obj->_faturado ?>"/>
                    <input type="text" id="valorParcela" class="texto02" alt="decimal" name="valorParcela" <?= $readonly ?> value="<?= @$dados_pagamento[0]->valor ?>"/>
                </div>

                <div>
                    <label>N° de Parcelas</label>
                    <input type="text" name="numParcela" id="numParcela" class="texto01" alt="integer" <?= $readonly ?> value="<?= count(@$dados_pagamento) ?>"/>
                </div>


                <div>
                    <label>Tipo</label>

                    <input type="radio" name="tipoPagamento" value="fixo" id="fixo" <?//echo $required; ?>/>
                    <label for="fixo" style="display: inline; color: black; font-size: 9pt">
                        Dia Fixo
                    </label>
                    <input type="radio" name="tipoPagamento" value="periodico" id="periodico" <?//echo $required; ?>/>
                    <label for="periodico" style="display: inline; color: black; font-size: 9pt">
                        Periodico
                    </label>
                </div>
                <div style="width: 100%" id="adcionaisPagamento">
                    <hr>    

                    <div>
                        <label>Data do Primeiro Vencimento</label>
                        <input type="text" id="txtdata_vencimento" class="texto02" alt="date" name="txtdata_vencimento" value="<?=  (@$dados_pagamento[0]->data != '') ? @date("d//m/Y", strtotime($dados_pagamento[0]->data)): '' ?>" <?= $readonly ?>/>
                    </div>

                    <div id="intervalo">
                    </div>
                </div>
            </fieldset>

            <fieldset>
                <legend>Adcionais</legend>
                <div>
                    <label>Clasulas</label>
                    <textarea name="clasulas" id="clasulas" rows="15" cols="60"  ><?= @$obj->_clasulas; ?></textarea>
                </div>
                <div>
                    <label>Observaçoes</label>
                    <textarea name="observacoes" id="observacoes" rows="15" cols="60"  ><?= @$obj->_observacoes; ?></textarea>
                </div>
            </fieldset>

            <fieldset style="dislpay:block">

                <button type="submit" name="btnEnviar">Enviar</button>

                <button type="reset" name="btnLimpar">Limpar</button>
            </fieldset>
        </form>
    </div>

</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">

    $(function () {
        $("input[type=radio][name=tipoPagamento]").click(function () {
            var tipoPagamento = $("input[type=radio][name=tipoPagamento]:checked").val();
            if (tipoPagamento == 'periodico') {
                if ($("#intervalo label").length == 0) {
                    var label = '<label>Intervalo (em dias)</label>';
                    var input = '<input type="text" name="intervalo" class="texto01" alt="integer" required <?= $readonly ?>/>';
                    var campo = label + input;
                    $("#intervalo").append(campo);
                }
            } else {
                $("#intervalo label").remove();
                $("#intervalo input").remove();
            }
        });
    });


    $(function () {
        $("#txtdata_assinatura").datepicker({
            autosize: true,
            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            dateFormat: 'dd/mm/yy'
        });
    });

<? if (@$obj->_faturado != 't'): ?>

        $(function () {
            $("#txtdata_vencimento").datepicker({
                autosize: true,
                changeYear: true,
                changeMonth: true,
                monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
                buttonImage: '<?= base_url() ?>img/form/date.png',
                dateFormat: 'dd/mm/yy'
            });
        });

<? endif; ?>
    $(function () {
        $("#txtdata_inicio").datepicker({
            autosize: true,
            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            dateFormat: 'dd/mm/yy'
        });
    });

    $(function () {
        $("#txtdata_fim").datepicker({
            autosize: true,
            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            dateFormat: 'dd/mm/yy'
        });
    });

    $(function () {
        $("#txtCidade").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=cidade",
            minLength: 3,
            focus: function (event, ui) {
                $("#txtCidade").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#txtCidade").val(ui.item.value);
                $("#txtCidadeID").val(ui.item.id);
                return false;
            }
        });
    });

    $(function () {
        $("#txtcbo").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=cboprofissionais",
            minLength: 3,
            focus: function (event, ui) {
                $("#txtcbo").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#txtcbo").val(ui.item.value);
                $("#txtcboID").val(ui.item.id);
                return false;
            }
        });
    });

//    $(document).ready(function () {
//        jQuery('#form_contrato').validate({
//            rules: {
//                nome: {
//                    required: true,
//                    minlength: 6
//                }
//            },
//            messages: {
//                nome: {
//                    required: "*",
//                    minlength: "!"
//                }
//            }
//        });
//    });

    tinyMCE.init({
        // General options
        mode: "textareas",
        theme: "advanced",
        plugins: "autolink,lists,pagebreak,style,layer,table,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks",
        // Theme options
        theme_advanced_buttons1: "|,bold,italic,underline,pagebreak,strikethrough,justifyleft,justifycenter,justifyright,justifyfull",
        theme_advanced_buttons2: "styleselect,formatselect,fontselect,fontsizeselect",
        theme_advanced_toolbar_location: "top",
        theme_advanced_toolbar_align: "left",
        theme_advanced_statusbar_location: "bottom",
        theme_advanced_resizing: true,
        // Example content CSS (should be your site CSS)
        //                                    content_css : "css/content.css",
        content_css: "js/tinymce/jscripts/tiny_mce/themes/advanced/skins/default/img/content.css",
        // Drop lists for link/image/media/template dialogs
        template_external_list_url: "lists/template_list.js",
        external_link_list_url: "lists/link_list.js",
        external_image_list_url: "lists/image_list.js",
        media_external_list_url: "lists/media_list.js",
        // Style formats
        style_formats: [
            {title: 'Bold text', inline: 'b'},
            {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
            {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
            {title: 'Example 1', inline: 'span', classes: 'example1'},
            {title: 'Example 2', inline: 'span', classes: 'example2'},
            {title: 'Table styles'},
            {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
        ],
        // Replace values for the template plugin
        template_replace_values: {
            username: "Some User",
            staffid: "991234"
        }

    });

</script>