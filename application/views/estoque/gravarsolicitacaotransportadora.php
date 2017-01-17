
        <link href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url() ?>css/jquery-treeview.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
        <script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.8.5.custom.min.js" ></script>
        <script type="text/javascript" src="<?= base_url() ?>js/jquery-cookie.js" ></script>
        <script type="text/javascript" src="<?= base_url() ?>js/jquery-treeview.js" ></script>
        <script type="text/javascript" src="<?= base_url() ?>js/jquery-meiomask.js" ></script>
        <script type="text/javascript" src="<?= base_url() ?>js/jquery.bestupper.min.js"  ></script>
        <script type="text/javascript" src="<?= base_url() ?>js/scripts_alerta.js" ></script>

<style>
    #form_faturar{
        overflow-y: auto;
    }
</style>
<body bgcolor="#C0C0C0">
    <div class="content"> <!-- Inicio da DIV content -->
        <h3 class="singular">Informar Transportadora</h3>
        <form name="form_transportadora" id="form_transportadora" action="<?= base_url() ?>estoque/solicitacao/gravarsolicitacaotransportadora" method="post">
            <table>
                <tr>
                    <td>
                        <label>Transportadora:</label>
                    </td>
                    <td>
                        <input type="hidden" name="solicitacao_cliente_id" id="solicitacao_cliente_id" class="texto02" value="<?= @$estoque_solicitacao_id; ?>" />
                        <input type="hidden" name="transportadora_id" id="transportadora_id" class="texto02" value="<?= @$solicitacao_transportadora->transportadora_id; ?>" />
                        <input type="hidden" name="solicitacaotransportadora_id" id="transportadora_id" class="texto02" value="<?= @$solicitacao_transportadora->solicitacao_transportadora_id; ?>" />
                        <input type="text" name="transportadoraNome" id="transportadoraNome" class="texto10" value="<?= @$solicitacao_transportadora->descricao; ?>" />
                    </td>
                </tr>
                <tr>
                    <td><label>Volume:</label></td>
                    <td><input type="text" name="txtvolume" id="txtvolume" class="texto10" value="<?= @$solicitacao_transportadora->volume; ?>" /></td>
                </tr>
                <tr>
                    <td><label>Peso:</label></td>
                    <td><input type="text" name="peso" id="peso" class="texto10" onkeyup="validar(this, 'num');" value="<?= @$solicitacao_transportadora->peso; ?>" /></td>
                </tr>
                <tr>
                    <td><label>Forma:</label></td>
                    <td><input type="text" name="txtforma" id="txtforma" class="texto10" value="<?= @$solicitacao_transportadora->forma; ?>" /></td>
                </tr>
            </table>    
            <hr/>
            <button type="submit" name="btnEnviar">Enviar</button>
        </form>
    </div>
</body>
<style>
    #form_faturar{
        overflow-y: auto;
    }
</style>

<script type="text/javascript">
                        function validar(dom, tipo) {
                            switch (tipo) {
                                case'num':
                                    var regex = /[A-Za-z]/g;
                                    break;
                                case'text':
                                    var regex = /\d/g;
                                    break;
                            }
                            dom.value = dom.value.replace(regex, '');
                        }

                        $(function () {
                            $("#transportadoraNome").autocomplete({
                                source: "<?= base_url() ?>index.php?c=autocomplete&m=solicitacaotransportadora",
                                minLength: 3,
                                focus: function (event, ui) {
                                    $("#transportadoraNome").val(ui.item.label);
                                    return false;
                                },
                                select: function (event, ui) {
                                    $("#transportadoraNome").val(ui.item.value);
                                    $("#transportadora_id").val(ui.item.id);
                                    return false;
                                }
                            });
                        });
</script>