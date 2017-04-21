<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Produto</a></h3>

        <div>
            <form name="form_marca" id="form_marca" action="<?= base_url() ?>estoque/marca/gravar" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                        <label>Descrição</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="txtestoquemarcaid" class="texto10" value="<?= @$obj->_estoque_marca_id; ?>" />
                        <input type="text" name="nome" class="texto10" value="<?= @$obj->_descricao; ?>" />
                    </dd>
                
                </dl>  

                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>

            </form>
        </div>
    </div>
</div> <!-- Final da DIV content -->

<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">
 $(function () {
        $("#accordion").accordion();
    });
</script>
