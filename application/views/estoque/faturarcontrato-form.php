
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.8.5.custom.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-meiomask.js" ></script>
<!--<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>-->
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<style>
    #form_faturar{
        overflow-y: auto;
    }
</style>
<body bgcolor="#C0C0C0">
    <div class="content"> <!-- Inicio da DIV content -->
        <h3 class="singular">Faturar</h3>
        <div>
            <form name="form_faturar" id="form_faturar" action="<?= base_url() ?>estoque/solicitacao/gravarfaturamento" method="post">
                <fieldset>
                    <table>
                        <tr>
                            <td colspan="10">
                                <label>Valor total a faturar</label>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="10">
                                <input type="text" name="valorafaturar" id="valorafaturar" class="texto01" value="<?= @$valor[0]->valor_total; ?>" readonly />
                                <input type="hidden" name="estoque_solicitacao_id" id="estoque_solicitacao_id" class="texto01" value="<?= @$contrato_id; ?>"/>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="10">
                                <label>Valor</label>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="10">
                                <input type="text" name="valor" id="valor" class="texto01" onkeyup="validar(this, 'num');"/>
                            </td>
                        </tr>
                    </table>  
                    <hr/>
                    <button type="submit" name="btnEnviar" >Enviar</button>
                </fieldset>

            </form>
        </div>
    </div> <!-- Final da DIV content -->
</body>

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
</script>