<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Fracionamento de Entrada</a></h3>

        <div>
            <form name="form_entrada" id="form_entrada" action="<?= base_url() ?>estoque/entrada/gravarfracionamento" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                        <label>Entrada</label>
                    </dt>
                    <dd>
                        <input type="hidden" id="validade" name="validade" value="<?= (isset($obj->_validade)) ? date("d/m/Y", strtotime($obj->_validade)) : "";?>" required/>
                        <input type="hidden" name="txtestoque_entrada_id" id="txtestoque_entrada_id" value="<?= @$obj->_estoque_entrada_id; ?>" />
                        <input type="hidden" name="txtfornecedor" id="txtfornecedor" value="<?= @$obj->_fornecedor_id; ?>" />
                        <input type="hidden" name="txtarmazem" id="txtarmazem" value="<?= @$obj->_armazem_id; ?>" />
                        <input type="hidden" name="txtprodutoentrada" id="txtprodutoentrada" value="<?= @$obj->_produto_id; ?>" />
                        <input type="hidden" id="compra" name="compra" value="<?= @$obj->_valor_compra; ?>" />
                        <input type="hidden" id="lote" name="lote" value="<?= @$obj->_lote; ?>" required/>
                        <input type="hidden" name="cfop" id="cfop" value="<?= @$obj->_codigo_cfop; ?>" />
                        <input type="hidden" id="nota" name="nota" value="<?= @$obj->_nota_fiscal; ?>" />
                        <input type="hidden" name="txtprodutoentrada_id" id="txtprodutoentrada_id" value="<?= @$obj->_produto_id; ?>"/>
                        
                        <input type="text" name="txtprodutoentrada" id="txtprodutoentrada" class="texto10" value="<?= @$obj->_produto; ?>" required readonly=""/>
                    </dd>
                    <dt>
                        <label>Quantidade Entrada</label>
                    </dt>
                    <dd>
                        <input type="text" id="qtde_entrada" name="qtde_entrada" class="texto02" value="<?= @$obj->_quantidade; ?>" readonly=""/>
                    </dd>
                    <dt>
                        <label>Produto</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="txtprodutofrac" id="txtprodutofrac"/>
                        <input type="text" name="txtprodutofraclabel" id="txtprodutofraclabel" class="texto10" required/>
                    </dd>
                    <dt>
                        <label>Quantidade a Fracionar</label>
                    </dt>
                    <dd>
                        <input type="number" id="qtde_fracionamento" class="texto02" name="qtde_fracionamento" min="1" max="<?= @$obj->_quantidade; ?>" required=""/>
                    </dd>
                    <dt>
                        <label>Quantidade Resultante</label>
                    </dt>
                    <dd>
                        <input type="text" id="qtde_resultante" name="qtde_resultante" class="texto02" alt="integer"/>
                    </dd>
                    
                </dl>    
                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
                <button type="button" id="btnVoltar" name="btnVoltar">Voltar</button>
            </form>
        </div>
    </div>
</div> <!-- Final da DIV content -->

<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">
//    function validaQuantidade(){
//        alert('tret');
//        if( $("#qtde_fracionamento") > 0 &&  $("#qtde_fracionamento") < $("#qtde_entrada")){
//            return true;
//        }
//        return false;
//    }
    
    $(function () {
        $("#txtprodutofraclabel").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=produtofracionar&produto_id=" + $("#txtprodutoentrada_id"),
            minLength: 2,
            focus: function (event, ui) {
                $("#txtprodutofraclabel").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#txtprodutofraclabel").val(ui.item.value);
                $("#txtprodutofrac").val(ui.item.id);
                return false;
            }
        });
    });

    $(function () {
        $("#validade").datepicker({
            autosize: true,
            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            dateFormat: 'dd/mm/yy'
        });
    });


//    $(document).ready(function () {
//        jQuery('#form_entrada').validate({
//            rules: {
//                txtproduto: {
//                    required: true
//                },
//                quantidade: {
//                    required: true
//                },
//                compra: {
//                    required: true
//                }
//
//            },
//            messages: {
//                txtproduto: {
//                    required: "*"
//                },
//                quantidade: {
//                    required: "*"
//                },
//                compra: {
//                    required: "*"
//                }
//            }
//        });
//    });


    $(function () {
        $("#accordion").accordion();
    });
</script>