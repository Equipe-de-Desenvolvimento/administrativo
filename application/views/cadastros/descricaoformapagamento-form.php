<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastrar Descrição de Pagamento</a></h3>
        <div>
            <form name="form_formapagamento" id="form_formapagamento" action="<?= base_url() ?>cadastros/formapagamento/gravardescricao" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                        <label>Nome</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="txtcadastrosformapagamentoid" class="texto10" value="<?= @$descricao[0]->descricao_forma_pagamento_id; ?>" />
                        <input type="text" name="txtNome" class="texto05" value="<?= @$descricao[0]->nome; ?>" />
                    </dd>

                    <dt>
                        <label>Ajuste</label>
                    </dt>
                    <dd>
                        <input type="text" name="ajuste" class="texto02" id="ajuste" value="<?= @$descricao[0]->ajuste; ?>" />%
                    </dd>

                    <dt>
                        <label>Data de Recebimento</label>
                    </dt>
                    <dd>
                        <input type="text" name="diareceber" class="texto02" id="diareceber" value="<?= @$descricao[0]->dia_receber; ?>"/>
                    </dd>
                    <dt>
                        <label>Tempo Recebimento</label>
                    </dt>
                    <dd>
                        <input type="text" name="temporeceber" class="texto02" id="temporeceber" value= "<?= @$descricao[0]->tempo_receber; ?>" />
                        <input type="checkbox" name="arrendondamento" id="arrendondamento" <? if (@$descricao[0]->fixar == 't') { ?>checked <? } ?>  />Fixar
                    </dd>
                    <dt>
                        <label>N° Maximo de Parcelas</label>
                    </dt>
                    <dd>
                        <input type="text" name="parcelas" class="texto02" id="parcelas" value= "<?= @$descricao[0]->parcelas; ?>" />
                    </dd>
                    <dt>
                        <label>Valor Mínimo da Parcela</label>
                    </dt>
                    <dd>
                        <input type="text" name="parcela_minima" class="texto02" id="parcela_minima" value= "<?= @$descricao[0]->parcela_minima; ?>" />
                    </dd>
                    <dt>
                        <label>Conta</label>
                    </dt>
                    <dd>
                        <select name="conta" id="conta" class="texto03">
                            <option value="">SELECIONE</option>
                            <? foreach ($conta as $value) { ?>
                                <option value="<?= $value->forma_entradas_saida_id ?>" <?
                                if (@$descricao[0]->conta_id == $value->forma_entradas_saida_id):echo 'selected';
                                endif;
                                ?>><?= $value->descricao ?></option>
                                    <? } ?>                            
                        </select>
                    </dd>
                    <dt>
                        <label>Credor/Devedor</label>
                    </dt>
                    <dd>
                        <select name="credor_devedor" id="credor_devedor" class="texto03">
                            <option value="">SELECIONE</option>
                            <? foreach ($credor_devedor as $value) { ?>
                                <option value="<?= $value->financeiro_credor_devedor_id ?>" <?
                                if (@$descricao[0]->credor_devedor == $value->financeiro_credor_devedor_id):echo 'selected';
                                endif;
                                ?>><?= $value->razao_social ?></option>
                                    <? } ?>                            
                        </select>
                    </dd>
                    <dt>
                        <label for="cartao">Forma de Pagamento Cartão</label>
                    </dt>
                    <dd>
                        <input type="checkbox" name="cartao" id="cartao" <? if (@$descricao[0]->cartao == 't') { ?>checked <? } ?>  />
                    </dd>
                    <dt>
                        <label for="boleto">Forma de Pagamento Boleto</label>
                    </dt>
                    <dd>
                        <input type="checkbox" name="boleto" id="boleto" <? if (@$descricao[0]->boleto == 't') { ?>checked <? } ?>  />
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
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript">

    $(function () {
        $("#accordion").accordion();
    });

    $("#cartao").click(function () {
        $("#boleto").removeAttr('checked');
    });
    $("#boleto").click(function () {
        $("#cartao").removeAttr('checked');
    });


    $(document).ready(function () {
        jQuery('#form_formapagamento').validate({
            rules: {
                txtNome: {
                    required: true,
                    minlength: 3
                },
                conta: {
                    required: true

                },
//                credor_devedor: {
//                    required: true
//                },
                parcelas: {
                    required: true
                }

            },
            messages: {
                txtNome: {
                    required: "*",
                    minlength: "!"
                },
                conta: {
                    required: "*"

                },
//                credor_devedor: {
//                    required: "*"
//                },
                parcelas: {
                    required: "*"
                }
            }
        });
    });

</script>
