<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3><a href="#">Carregar Certificado</a></h3>
        <div >
            <?= form_open_multipart(base_url() . 'ambulatorio/empresa/importarcertificado'); ?>
            <label>Informe o arquivo para importa&ccedil;&atilde;o</label><br>
            <input type="file" name="userfile" required=""/><br>
            <label>Informe a senha do arquivo</label><br>
            <div>
                <input type="password" name="senha" id="senha"/><img src="<?= base_url() ?>/img/eye-icon.png" style="display: inline-block; margin-bottom:-5pt; " width="23pt" height="23pt" id="visualizar"/>
            </div>
            <button type="submit" name="btnEnviar">Enviar</button>
            <input type="hidden" name="empresa_id" value="<?= $empresa_id; ?>" />
            <?= form_close(); ?>

        </div>

        <h3><a href="#">Vizualizar Certificado </a></h3>
        <div >
            <table><pre>
                <?
                if (@$arquivo_pasta != false):
                    
//                    var_dump(@$arquivo_pasta);die;
                    foreach ($arquivo_pasta as $value) :
                        if(!is_array($value)):
                        ?>
                        <td><center>
                            <img  width="50px" height="50px" 
                                  onclick="javascript:window.open('<?= base_url() . "upload/certificado/".@$empresa_id."/".@$value ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=1200,height=600');" 
                                  src="<?= base_url()?>/img/digital_signature-icon.png"/><br><?= @$value ?><br>
                            <?  
                            $e = explode('.', @$value);
                            $extensao = $e[1];
                            if($extensao == 'pfx'):
                            ?>
                            <a href="<?= base_url() ?>ambulatorio/empresa/excluircertificado/<?= @$empresa_id ?>/<?= @$value ?>">
                                        Excluir
                            </a>
                            <?endif;?>
                            </center>
                        </td>
                        <?
                        endif;
                    endforeach;
                endif
                ?>
            </table>
        </div> <!-- Final da DIV content -->

<!--        <h3><a href="#">Imagens excluidas </a></h3>
        <div >
            <table>
                <?
                if (@$arquivos_deletados != false):
                    foreach ($arquivos_deletados as $item) :
                        ?>
                        <td><br>
                        <center>
                            <img  width="100px" height="100px" 
                                  src="<?= base_url() . "uploadopm/" . $exame_id . "/" . $item ?>"><br>
                            <a href="<?= base_url() ?>ambulatorio/exame/restaurarimagem/<?= $exame_id ?>/<?= $item ?>/<?= $sala_id ?>">
                                restaurar</a>
                        </center></td>
                        <?
                    endforeach;
                endif
                ?>
            </table>
        </div> -->
</div> <!-- Final da DIV content -->
<script type="text/javascript">

    $(function () {
        $("#accordion").accordion();
    });
    
    function mostraSenha(){
        document.getElementById('senha').setAttribute('type', 'text');
    }
    function escondeSenha(){
        document.getElementById('senha').setAttribute('type', 'password');
    }
    
    $(function(){
        $("#visualizar").mousedown(function(){
            mostraSenha();
        });
        $("#visualizar").mouseup(function(){
            escondeSenha();
        });
        $("#visualizar").mouseout(function(){
            escondeSenha();
        });
    });





</script>
