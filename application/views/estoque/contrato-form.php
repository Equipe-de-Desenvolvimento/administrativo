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
                    <label>Nome *</label>                      
                    <input type="hidden" name ="contrato_id" value ="<?= @$obj->_contrato_id; ?>" id ="txtcontratoId">
                    <input type="text" id="txtNome" name="nome"  class="texto09" value="<?= @$obj->_nome; ?>" required=""/>
                </div>
                <div>
                    <label>Data inicio</label>
                    <input type="text" name="txtdata_inicio" id="txtdata_inicio" alt="date" class="texto02" required=""/>
                </div>
                <div>
                    <label>Data Termino</label>
                    <input type="text" name="txtdata_fim" id="txtdata_fim" alt="date" class="texto02" required=""/>
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


                    <input type="hidden" id="txtCidadeID" class="texto_id" name="municipio_id" value="<?= @$obj->_cidade; ?>" readonly="true" />
                    <input type="text" id="txtCidade" class="texto04" name="txtCidade" value="<?= @$obj->_cidade_nome; ?>" />
                </div>
            </fieldset>
            
            <fieldset>
                <legend>Informaçoes do Contrato</legend>

                <div>
                    <label>Cliente *</label>
                    <select name="cliente_id" id="cliente_id" class="size8" required="">
                        <option value="">Selecione</option>
                        <? foreach ($clientes as $item) : ?>
                            <option value="<?= $item->estoque_cliente_id; ?>"><?= $item->nome; ?></option>
                        <? endforeach; ?>
                    </select>
<!--                </div>
                <div>-->
                    <label>Forma de Pagamento *</label>
                    <select name="formapagamento_id" id="formapagamento_id" class="size8" required="">
                        <option value="">Selecione</option>
                        <? foreach ($forma_pagamento as $forma) : ?>
                            <option value="<?= $forma->forma_pagamento_id; ?>"><?= $forma->nome; ?></option>
                        <? endforeach; ?>
                    </select>
                </div>
                <div>
                    <label>Numero do Contrato *</label>
                    <input type="text" id="numContrato" name="numContrato"  class="texto03" value="<?= @$obj->_conselho; ?>"/>
<!--                </div>
                <div>-->
                    <label>Tipo do Contrato *</label>
                    <select name="tipoContrato" id="tipoContrato" class="texto03" required="">
                        <option value="">Selecione</option>
                        <? foreach ($tipo_contrato as $tipo) : ?>
                            <option value="<?= $tipo->tipo_id; ?>"><?= $tipo->descricao; ?></option>
                        <? endforeach; ?>
                    </select>
                </div>
                <div>
                    <label>Situaçao</label>
                    <input type="text" id="situacaoContrato" class="texto06" name="situacaoContrato" value="<?= @$obj->_complemento; ?>" />
                </div>
                <div>
                    <label>Data Assinatura</label>
                    <input type="text" name="txtdata_assinatura" id="txtdata_assinatura" alt="date" class="texto02"/>
                </div>
                <div>
                    <label>Valor Inicial</label>
                    <input type="text" id="valorInicial" class="texto02" alt="decimal" name="valorInicial" value="<?= @$obj->_complemento; ?>" />
                </div>
                <div>
                    <label>Calçao</label>
                    <input type="text" id="calcao" class="texto02" alt="decimal" name="calcao" value="<?= @$obj->_complemento; ?>" />
                </div>
                

            </fieldset>

            <fieldset>
                <legend>Adcionais</legend>
                <div>
                    <label>Clasulas</label>
                    <textarea name="clasulas" id="clasulas" rows="15" cols="60"  ><?= @$obj->_carimbo; ?></textarea>
                </div>
                <div>
                    <label>Observaçoes</label>
                    <textarea name="observacoes" id="observacoes" rows="15" cols="60"  ><?= @$obj->_carimbo; ?></textarea>
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