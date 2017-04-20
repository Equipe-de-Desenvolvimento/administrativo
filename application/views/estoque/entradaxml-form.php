<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3><a href="#">Carregar XML</a></h3>
        <div >
            <?= form_open_multipart(base_url() . 'estoque/entrada/carregarentradaxml'); ?>
            <label>Informe o arquivo para importa&ccedil;&atilde;o</label><br>
            <input type="file" name="userfile" required=""/><br>
            <button type="submit" name="btnEnviar">Enviar</button>
            <?= form_close(); ?>

        </div>
    </div> <!-- Final da DIV content -->
    <script type="text/javascript">

        $(function () {
            $("#accordion").accordion();
        });

    </script>
