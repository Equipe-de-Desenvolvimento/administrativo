<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <form name="form_sala" id="form_sala" method="post">
        <fieldset>
            <legend>Status do Boleto</legend>
            <div class="table">    
                <? 
                foreach ($bancos as $value) {?>
                    <div>
                        <fieldset>
                            <span class="title"><?= $value->nome_banco ?></span>
                            <a href="<?= base_url() ?>estoque/boleto/gerarboleto<?= $value->codigo_banco ?>/<?= $estoque_boleto_id ?>"><span class="conteudo">Gerar Boleto</span></a>
                        </fieldset>
                    </div>
                <? } ?>

            </div>
        </fieldset>
    </form>
</div> <!-- Final da DIV content -->
<style>
    table {
        padding: 50pt;
    }
    div fieldset{
        min-height: 22pt;
        min-width: 150pt;
        font-weight: bold;
        display: inline;
        position: relative;
    }

    div span.title{
        font-size: 9pt;
        font-weight:501;
        text-align: center;
        color: black;
        position: absolute;
        margin-top: -5pt; 
    }

    div span.conteudo{
        font-size: 9pt;
        text-align: center;
        color: #f39c12;
        font-weight:bolder;
        position: absolute;
        margin-top: 10pt; 
    }
</style>

<script type="text/javascript">
    $(function () {
        $("#accordion").accordion();
    });



</script>