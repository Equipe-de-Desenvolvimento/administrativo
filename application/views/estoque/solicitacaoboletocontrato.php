
<style>
    #novaParcela{
        width: 150pt;
        height: 22pt;
        background-color: #2c3e50;
        font-size: 10pt;
        color: black;
        border-radius: 20pt;
    }
    #novaParcela:hover{
        cursor: pointer;
        border: 1pt solid #999;
        font-weight: bold;
        color: #b30707;
    }
</style>
<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <form name="form_sala" id="form_sala" action="<?= base_url() ?>estoque/boleto/solicitacaoboleto" method="post">
        <a href="<?= base_url() ?>estoque/boleto/gerarboletosbnb/<?= @$contrato_id; ?>">
                <button type="button" id="novaParcela">Gerar Boletos</button>
            </a>
        
        <fieldset>
            <legend>Boletos</legend>
            <div class="boletos">
                <?
                $i = 1;
                foreach ($boletos as $value) :
                    if ($value->pagado == 't'):
                        $pagado = "<span style='color:green;'>PAGAMENTO EFETUADO</span>";
                    else:
                        $pagado = "<span style='color:red;'>PAGAMENTO PENDENTE</span>";
                    endif;
                    ?>
                    <div>
                        <fieldset>
                            <legend>BOLETO <? echo $i; $i++;?></legend>
                            <span class="label" title="">Devedor: </span> <span class="text"><?= $value->credor_devedor; ?></span><br>
                            <!--<span class="label" title="Forma de Pagamento">FORM(...): </span> <span class="text"><?= $value->formapagamento; ?></span><br>-->
                            <!--//<? // echo $registro; ?><br>-->
                            VENC: <?= date("d/m/Y", strtotime($value->data_vencimento)); ?><br>
                            VALOR: R$ <?= number_format($value->valor, 2, ',',''); ?><br>
                            <?= $pagado; ?><br>
                            <center>
                                <a href="<?= base_url() ?>estoque/boleto/solicitacaoboletocontrato/<?= $value->estoque_boleto_id; ?>">
                                    <button type="button">Detalhes</button>
                                </a>
                            </center>
                        </fieldset>
                    </div>
                <? endforeach; ?>
            </div>

        </fieldset>
    </form>
</div> <!-- Final da DIV content -->
<style>
    .label{
        cursor: pointer;
    }
    .text{
        font-weight: normal;
    }
    .boletos{
        /*position: absolute;*/
    }
    .boletos div fieldset{
        font-weight: bold;
        min-height: 22pt;
        min-width: 60pt;
        display: inline;
        position: relative;
    }
</style>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">

</script>