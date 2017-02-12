<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <form name="form_paciente" id="form_paciente" action="<?= base_url() ?>estoque/solicitacao/gravarentregador" method="post">
        <fieldset>
            <legend>Dados do Entregador</legend>
            <div>
                <label>Nome*</label>                      
                <input type ="hidden" name ="entregador_id"  value ="<?= @$entregador[0]->entregador_id; ?>" id ="entregador_id">
                <input type="text" id="txtNome" name="nome" class="texto10"  value="<?= @$entregador[0]->nome; ?>" />
            </div>
            <div>
                <label>Nascimento</label>
                <input type="text" name="nascimento" id="txtNascimento" class="texto02" alt="date" value="<?php echo substr(@$entregador[0]->nascimento, 8, 2) . '/' . substr(@$entregador[0]->nascimento, 5, 2) . '/' . substr(@$entregador[0]->nascimento, 0, 4); ?>" />
            </div>
            <div>
                <label>Email</label>
                <input type="text" id="txtCns" name="cns"  class="texto06" value="<?= @$entregador[0]->cns; ?>" />
            </div>
            <div>
                <label>Sexo*</label>
                <select name="sexo" id="txtSexo" class="size1">
                    <option value="" <? if (@$entregador[0]->sexo == ""):echo 'selected'; endif;?>>Selecione</option>
                    <option value="M" <?if (@$entregador[0]->sexo == "M"):echo 'selected';endif;?>>Masculino</option>
                    <option value="F" <?if (@$entregador[0]->sexo == "F"):echo 'selected';endif;?>>Feminino</option>
                </select>

            </div>
        </fieldset>
        <fieldset>
            <legend>Documentos</legend>
            <div>
                <label>CPF</label>


                <input type="text" name="cpf" id ="txtCpf" maxlength="11" alt="cpf" class="texto02" value="<?= @$entregador[0]->cpf; ?>" />
            </div>
            <div>
                <label>RG</label>
                <input type="text" name="rg"  id="txtDocumento" class="texto04" maxlength="20" value="<?= @$entregador[0]->rg; ?>" />
            </div>
        </fieldset>
        
        <fieldset>
            <legend>Domicilio</legend>

            <div>
                <label>Endere&ccedil;o</label>
                <input type="text" id="txtendereco" class="texto10" name="endereco" value="<?= @$entregador[0]->logradouro; ?>" />
            </div>
            <div>
                <label>N&uacute;mero</label>


                <input type="text" id="txtNumero" class="texto02" name="numero" value="<?= @$entregador[0]->numero; ?>" />
            </div>
            <div>
                <label>Complemento</label>


                <input type="text" id="txtComplemento" class="texto04" name="complemento" value="<?= @$entregador[0]->complemento; ?>" />
            </div>
            <div>
                <label>Bairro</label>


                <input type="text" id="txtBairro" class="texto03" name="bairro" value="<?= @$entregador[0]->bairro; ?>" />
            </div>


            <div>
                <label>Município</label>


                <input type="hidden" id="txtCidadeID" class="texto_id" name="municipio_id" value="<?= @$entregador[0]->cidade; ?>" readonly="true" />
                <input type="text" id="txtCidade" class="texto04" name="txtCidade" value="<?= @$entregador[0]->cidade_nome; ?>" />
            </div>
            <div>
                <label>CEP</label>


                <input type="text" id="cep" class="texto02" name="cep" alt="cep" value="<?= @$entregador[0]->cep; ?>" />
            </div>


            <div>
                <label>Telefone 1*</label>


                <input type="text" id="txtTelefone" class="texto02" name="telefone" alt="(99) 9999-9999" value="<?= @$entregador[0]->telefone; ?>" />
            </div>
            <div>
                <label>Telefone 2</label>
                <input type="text" id="txtCelular" class="texto02" name="celular" alt="(99) 99999-9999" value="<?= @$entregador[0]->celular; ?>" />
            </div>
        </fieldset>
        <button type="submit">Enviar</button>
        <button type="reset">Limpar</button>

        <a href="<?= base_url() ?>cadastros/pacientes">
            <button type="button" id="btnVoltar">Voltar</button>
        </a>

    </form>
</div>



<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">


        $(document).ready(function () {
            jQuery('#form_paciente').validate({
                rules: {
                    nome: {
                        required: true,
                        minlength: 3
                    },
                    sexo: {
                        required: true
                    },
                    telefone: {
                        required: true
                    }

                },
                messages: {
                    nome: {
                        required: "*",
                        minlength: "*"
                    },
                    sexo: {
                        required: "*"
                    },
                    telefone: {
                        required: "*"
                    }
                }
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
            $("#txtEstado").autocomplete({
                source: "<?= base_url() ?>index.php?c=autocomplete&m=estado",
                minLength: 2,
                focus: function (event, ui) {
                    $("#txtEstado").val(ui.item.label);
                    return false;
                },
                select: function (event, ui) {
                    $("#txtEstado").val(ui.item.value);
                    $("#txtEstadoID").val(ui.item.id);
                    return false;
                }
            });
        });




</script>
