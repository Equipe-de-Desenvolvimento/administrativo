<div class="content"> <!-- Inicio da DIV content -->
<? $medicos = $this->operador_m->listarvendedor(); ?>
    
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Cliente</a></h3>
        <div>
            <form name="form_sala" id="form_sala" action="<?= base_url() ?>estoque/cliente/gravar" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                        <label>Nome Fantasia</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtfantasia" id="txtfantasia" class="texto10" value="<?= @$obj->_nome; ?>" />
                    </dd>
                    <dt>
                        <label>Raz&atilde;o social</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="txtestoqueclienteid" class="texto10" value="<?= @$obj->_estoque_cliente_id; ?>" />
                        <input type="text" name="txtrazaosocial" id="txtrazaosocial" class="texto10" value="<?= @$obj->_razao_social; ?>" />
                    </dd>
                    <dt>
                        <label>CNPJ</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtCNPJ" maxlength="14" alt="cnpj" class="texto03" value="<?= @$obj->_cnpj; ?>" />
                    </dd>

                    <dt>
                        <label>Tipo</label>
                    </dt>
                    <dd>
                        <select name="txttipo_id" id="txttipo_id" class="size4">
                            <? foreach ($tipo as $value) : ?>
                                <option value="<?= $value->tipo_logradouro_id; ?>"<?
                                if (@$obj->_tipo_logradouro_id == $value->tipo_logradouro_id):echo'selected';
                                endif;
                                ?>><?php echo $value->descricao; ?></option>
<? endforeach; ?>
                        </select>
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
                        <label>Complemento</label>
                    </dt>
                    <dd>
                        <input type="text" id="txtComplemento" class="texto10" name="complemento" value="<?= @$obj->_complemento; ?>" />
                    </dd>

                    <dt>
                        <label>CEP</label>
                    </dt>
                    <dd>
                        <input type="text" id="txtCep" alt="cep" class="texto02" name="txtCep" value="<?= @$obj->_cep; ?>" />
                    </dd>

                    <dt>
                        <label>Município</label>
                    </dt>
                    <dd>
                        <input type="hidden" id="txtCidadeID" class="texto_id" name="municipio_id" value="<?= @$obj->_municipio_id; ?>" readonly="true" />
                        <input type="text" id="txtCidade" class="texto04" name="txtCidade" value="<?= @$obj->_municipio_nome; ?>" />
                    </dd>

                    <dt>
                        <label>Telefone</label>
                    </dt>
                    <dd>
                        <input type="text" id="txtTelefone" class="texto02" name="telefone" alt="(99) 9999-9999" value="<?= @$obj->_telefone; ?>" />
                    </dd>
                    <dt>
                        <label>Celular</label>
                    </dt>
                    <dd>
                        <input type="text" id="txtCelular" class="texto02" name="celular" alt="phone" value="<?= @$obj->_celular; ?>" />
                    </dd>

                    <dt>
                        <label>Email</label>
                    </dt>
                    <dd>
                        <input type="text" id="email" class="texto08" name="email" value="<?= @$obj->_email; ?>" />
                    </dd>


                    <dt>
                        <label>Indicador da IE do Destinatário</label>
                    </dt>
                    <dd>
                        <select name="indIEdest" id="indIEdest" class="size4">
                            <option value="">SELECIONE</option>
                            <option value="1" required>Contribuinte de ICMS</option>
                            <option value="2">Contribuinte isento</option>
                            <option value="9">Não Contribuinte</option>
                        </select>
                    </dd>

                    <dt>
                        <label>Inscrição Estadual</label>
                    </dt>
                    <dd>
                        <input type="text" id="inscricaoestadual" class="texto04" name="inscricaoestadual" alt="99.999.9999-9" value="<?= @$obj->_inscricao_estadual; ?>" />
                    </dd>

                    <dt>
                        <label>Inscrição Municipal</label>
                    </dt>
                    <dd>
                        <input type="text" id="inscricaomunicipal" class="texto04" name="inscricaomunicipal" alt="" />
                    </dd>

                    <dt>
                        <label>Criar Credor</label>
                    </dt>
                    <dd>
                        <input type="checkbox" name="criarcredor"/>
                    </dd>

<!--                    <dt>
                        <label>Saida</label>
                    </dt>
                    <dd>
                        <input type="checkbox" name="saida" <? if (@$obj->_saida == 't') {
    echo 'checked';
} ?>/>
                    </dd>-->


                    <dt>
                        <label>Menu</label>
                    </dt>
                    <dd>
                        <select name="menu" id="menu" class="size4">
                            <? // var_dump($obj->_menu_id);die;
                            foreach ($menu as $value) : ?>
                                <option value="<?= $value->estoque_menu_id; ?>"<?
                                        if (@$obj->_menu_id == $value->estoque_menu_id):echo 'selected';
                                        endif;
                                        ?>><?php echo $value->descricao; ?></option>
<? endforeach; ?>
                        </select>
                    </dd>

<!--                    <dt>
                        <label>Sala</label>
                    </dt>-->
<!--                    <dd>
                        <select name="sala" id="sala" class="size4">
                            <option value="">SELECIONE</option>
<? // foreach ($sala as $item) { ?>
                                <option value="<?= $item->exame_sala_id; ?>"><?= $item->nome; ?></option>
<? // } ?>
                        </select>
                    </dd>-->


                    <dt>
                        <label>Credor / Devedor</label>
                    </dt>
                    <dd>
                        <select name="credor_devedor" id="credor_devedor" class="size2" >
                            <option value='' >selecione</option>
                            <?php
                            $credor_devedor = $this->convenio->listarcredordevedor();
                            foreach ($credor_devedor as $item) {
                                ?>

                                <option   value =<?php echo $item->financeiro_credor_devedor_id; ?> <?
                                          if (@$obj->_credor_devedor_id == $item->financeiro_credor_devedor_id):echo 'selected';
                                          endif;
                                          ?>><?php echo $item->razao_social; ?></option>
    <?php
}
?> 
                        </select>
                    </dd>
                    <dt>
                        <label>Descrição de Pagamento</label>
                    </dt>
                    <dd>
                        <select name="descricaopagamento" id="descricaopagamento" class="size3" >
                            <option value="">Selecione</option>
                            <? foreach ($descricao_pagamento as $value) : ?>
                                <option value="<?= $value->descricao_forma_pagamento_id ?>"
                                        <? if (@$obj->_descricaopagamento == $value->descricao_forma_pagamento_id) echo 'selected'; ?>><?= $value->nome ?></option>
                            <? endforeach; ?>
                        </select>
                    </dd>
                    <dt>
                        <label>Vendedor</label>
                    </dt>
                    <dd>
                        <select name="vendedor_id" id="vendedor_id" class="size3">
                            <option value="">Selecione</option>
                            <? foreach ($medicos as $value) : ?>
                                <option value="<?= $value->operador_id ?>"
                                        <? if (@$obj->_vendedor_id == $value->operador_id) echo 'selected'; ?>><?= $value->nome ?></option>
                            <? endforeach; ?>
                        </select>
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
    $('#btnVoltar').click(function () {
        $(location).attr('href', '<?= base_url(); ?>estoque/cliente');
    });

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


</script>