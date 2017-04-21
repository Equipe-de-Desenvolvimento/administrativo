<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Informaçoẽs de envio</a></h3>
        <div>
            <form method="post" action="<?= base_url() ?>estoque/notafiscal/enviaremail">
                <dl class="dl_desconto_lista">
                    <dt>
                        <label>Seu Email</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="chave_nfe" id="chave_nfe" value="<? echo @$empresa[0]->empresa; ?>" />
                        <input type="hidden" name="empresa_nome" id="empresa_nome" value="<? echo @$empresa[0]->empresa; ?>" />
                        <input type="hidden" name="solicitacao_id" id="solicitacao_id" value="<? echo $solicitacao_cliente_id; ?>" />
                        <input type="hidden" name="notafiscal_id" id="notafiscal_id" value="<? echo $notafiscal_id; ?>" />
                        <input type="text" name="email" class="texto06" value="<?= @$empresa[0]->email; ?>" readonly=""/>
                    </dd>
                    <dt>
                        <label>Senha</label>
                    </dt>
                    <dd>
                        <input type="password" name="senha" id="senha" required=""/><img src="<?= base_url() ?>/img/eye-icon.png" style="display: inline-block; margin-bottom:-5pt; " width="23pt" height="23pt" id="visualizar"/>
                    </dd>
                    <dt>
                        <label>Remetente</label>
                    </dt>
                    <dd>
                        <input type="text" name="remetente" class="texto06"/>
                    </dd>
                    <dt>
                        <label>Texto</label>
                    </dt>
                    <dd>
                        <input type="text" name="texto" class="texto10"/>
                    </dd>
                    <dt>
                        <label for="danfe">Danfe</label>
                    </dt>
                    <dd>
                        <input type="checkbox" name="danfe" id="danfe"/>
                    </dd>
                    <dt>
                        <label for="xml">XML</label>
                    </dt>
                    <dd>
                        <input type="checkbox" name="xml" id="xml"/>
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

    function mostraSenha() {
        document.getElementById('senha').setAttribute('type', 'text');
    }
    function escondeSenha() {
        document.getElementById('senha').setAttribute('type', 'password');
    }

    $(function () {
        $("#visualizar").mousedown(function () {
            mostraSenha();
        });
        $("#visualizar").mouseup(function () {
            escondeSenha();
        });
        $("#visualizar").mouseout(function () {
            escondeSenha();
        });
    });
</script>