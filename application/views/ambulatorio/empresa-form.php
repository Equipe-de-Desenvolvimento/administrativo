<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Sala</a></h3>
        <div>
            <form name="form_empresa" id="form_empresa" action="<?= base_url() ?>ambulatorio/empresa/gravar" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                        <label>Nome</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="txtempresaid" class="texto10" value="<?= @$obj->_empresa_id; ?>" />
                        <input type="text" name="txtNome" class="texto10" value="<?= @$obj->_nome; ?>" />
                    </dd>
                    <dt>
                        <label>Raz&atilde;o social</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtrazaosocial" id="txtrazaosocial" class="texto10" value="<?= @$obj->_razao_social; ?>" />
                    </dd>
                    <dt>
                        <label>CNPJ</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtCNPJ" maxlength="14" alt="cnpj" class="texto03" value="<?= @$obj->_cnpj; ?>" />
                    </dd>

                    <!--                    <dt>
                                            <label>CNES</label>
                                        </dt>
                                        <dd>
                                            <input type="text" name="txtCNES" maxlength="14" class="texto03" value="<?= @$obj->_cnes; ?>" />-->
                    <!--</dd>-->

                    <dt>
                        <label>Inscrição Municipal</label>
                    </dt>
                    <dd>
                        <input type="text" id="inscricaomunicipal" class="texto04" name="inscricaomunicipal" value="<?= @$obj->_inscricao_municipal; ?>" />
                    </dd>

                    <dt>
                        <label>CNAE</label>
                    </dt>
                    <dd>
                        <input type="text" id="txtCnae" class="texto03" maxlength="19" name="txtCnae" value="<?= @$obj->_cnae; ?>" />
                    </dd>

                    <dt>
                        <label>Inscrição Estadual</label>
                    </dt>
                    <dd>
                        <input type="text" id="inscricaoestadual" class="texto04" name="inscricaoestadual" alt="99.999.9999-9" value="<?= @$obj->_inscricao_estadual; ?>" />
                    </dd>

                    <dt>
                        <label>Inscrição Estadual St</label>
                    </dt>
                    <dd>
                        <input type="text" id="inscricaoestadualst" class="texto04" name="inscricaoestadualst" alt="99.999.9999-9" value="<?= @$obj->_inscricao_estadual_st; ?>" />
                    </dd>

                    <dt>
                        <label>Regime Tributario</label>
                    </dt>
                    <dd>
                        <select name="crt" id="crt" required="">
                            <option value="">Selecione</option>
                            <option value="1" <?= (@$obj->_cod_regime_tributario == '1') ? 'selected' : '' ?> >Simples Nacional</option>
                            <option value="2" <?= (@$obj->_cod_regime_tributario == '2') ? 'selected' : '' ?>>Simples Nacional - excesso de sublimite da receita bruta</option>
                            <option value="3" <?= (@$obj->_cod_regime_tributario == '3') ? 'selected' : '' ?>>Regime Normal</option>
                        </select>
                    </dd>

                    <dt>
                        <label>Email</label>
                    </dt>
                    <dd>
                        <input type="text" id="email" class="texto08" name="email" value="<?= @$obj->_email; ?>" />
                    </dd>
                    <dt>
                        <label>Endere&ccedil;o</label>
                    </dt>
                    <dd>
                        <input type="text" id="txtendereco" class="texto10" name="endereco" value="<?= @$obj->_logradouro; ?>" />
                    </dd>
                    <dt>
                        <label>N&uacute;mero</label>
                    </dt>
                    <dd>
                        <input type="text" id="txtNumero" class="texto02" name="numero" value="<?= @$obj->_numero; ?>" />
                    </dd>
                    <dt>
                        <label>Bairro</label>
                    </dt>
                    <dd>
                        <input type="text" id="txtBairro" class="texto03" name="bairro" value="<?= @$obj->_bairro; ?>" />
                    </dd>
                    <dt>
                        <label>CEP</label>
                    </dt>
                    <dd>
                        <input type="text" id="txtCEP" class="texto02" name="CEP" alt="cep" value="<?= @$obj->_cep; ?>" />
                    </dd>
                    <dt>
                        <label>Telefone</label>
                    </dt>
                    <dd>
                        <input type="text" id="txtTelefone" class="texto03" name="telefone" alt="phone" value="<?= @$obj->_telefone; ?>" />
                    </dd>
                    <dt>
                        <label>Celular</label>
                    </dt>
                    <dd>
                        <input type="text" id="txtCelular" class="texto03" name="celular" alt="phone" value="<?= @$obj->_celular; ?>" />
                    </dd>
                    <dt>
                        <label>Município</label>
                    </dt>
                    <dd>
                        <input type="hidden" id="txtCidadeID" class="texto_id" name="municipio_id" value="<?= @$obj->_municipio_id; ?>" readonly="true" />
                        <input type="text" id="txtCidade" class="texto04" name="txtCidade" value="<?= @$obj->_municipio; ?>" />
                    </dd>
                    <dt>
                        <label>Ambiente de Produção (NFe)</label>
                    </dt>
                    <dd>
                        <select name="ambienteProdcao" id="ambienteProdcao" required="">
                            <option value="2" <?= (@$obj->_ambienteProducao == '2' OR empty(@$obj->_ambienteProducao)) ? 'selected' : '' ?>>Ambiente de Homologação
                            </option>
                            <option value="1" <?= (@$obj->_ambienteProducao == '1') ? 'selected' : '' ?>>Ambiente de Produção</option>
                        </select>
                    </dd>
                    <dt>
                        <label>Possui Almoxarifado?</label>
                    </dt>
                    <dd>
                        <input type="checkbox" name="almoxarifado" <?if(@$obj->_almoxarifado == 't'){echo 'checked';} ?>/>
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

<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">
//    $('#btnVoltar').click(function () {
//        $(location).attr('href', '<?= base_url(); ?>ponto/cargo');
//    });

    $(function () {
        $("#accordion").accordion();
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

    $(document).ready(function () {
        jQuery('#form_empresa').validate({
            rules: {
                txtNome: {
                    required: true,
                    minlength: 2
                }
            },
            messages: {
                txtNome: {
                    required: "*",
                    minlength: "!"
                }
            }
        });
    });

</script>