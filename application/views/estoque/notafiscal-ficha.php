
<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Opções NF-e</a></h3>
        <div>
            <a href="<?= base_url() ?>estoque/notafiscal/gerarnotafiscal/<?=$solicitacao_cliente_id?>">
                <button>Gerar NF</button>
            </a>
            <button>Assinar NF</button>
            <button>Validar NF</button>
            <button>Cancelar NF</button>
            <button>Gerar DANFe</button>
        </div>

        <h3 class="singular"><a href="#">Arquivos NF-e</a></h3>
        <div>
            <table>
                <tr>
                    <?
                    $this->load->helper('directory');
//                    /home/sisprod/projetos/administrativo/upload/nfe/209
                    $path = "/home/sisprod/projetos/administrativo/upload/nfe";
                    $arquivo_pasta = directory_map("$path/$solicitacao_cliente_id");
                    if ($arquivo_pasta):
                        foreach ($arquivo_pasta as $value):
                            ?>
                            <td width="10px"> <img  width="50px" height="50px" onclick="javascript:window.open('<?= base_url() . "upload/nfe/$solicitacao_cliente_id/" . $value ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=1200,height=600');"><br><? echo $value ?></td>
                            <td>&nbsp;</td><br>
                    <?
                        endforeach;
                    endif;
                    ?>
                </tr>
            </table>
        </div>
    </div>
</div> <!-- Final da DIV content -->
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">

                                $(function () {
                                    $("#datainicio").datepicker({
                                        autosize: true,
                                        changeYear: true,
                                        changeMonth: true,
                                        monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                                        dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
                                        buttonImage: '<?= base_url() ?>img/form/date.png',
                                        dateFormat: 'dd/mm/yy'
                                    });
                                });

                                $(function () {
                                    $("#datafim").datepicker({
                                        autosize: true,
                                        changeYear: true,
                                        changeMonth: true,
                                        monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                                        dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
                                        buttonImage: '<?= base_url() ?>img/form/date.png',
                                        dateFormat: 'dd/mm/yy'
                                    });
                                });

                                $(function () {
                                    $("#accordion").accordion();
                                });

</script>
