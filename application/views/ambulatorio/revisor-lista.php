
<div class="content"> <!-- Inicio da DIV content -->
    <?
    $operador_id = $this->session->userdata('operador_id');
    $salas = $this->exame->listartodassalas();
    $medicos = $this->operador_m->listarmedicos();
    ?>
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Laudo Revisor</a></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th colspan="5" class="tabela_title">
                <form method="get" action="<?= base_url() ?>ambulatorio/laudo/pesquisarrevisor">
                    <tr>
                        <th class="tabela_title">Salas</th>
                        <th class="tabela_title">Medico</th>
                        <th class="tabela_title">Status</th>
                        <th class="tabela_title">Data</th>
                        <th class="tabela_title">Prontu&aacute;rio</th>
                        <th colspan="2" class="tabela_title">Nome</th>
                    </tr>
                    <tr>
                        <th class="tabela_title">
                            <select name="sala" id="sala" class="size1">
                                <option value=""></option>
                                <? foreach ($salas as $value) : ?>
                                    <option value="<?= $value->exame_sala_id; ?>"><?php echo $value->nome; ?></option>
                                <? endforeach; ?>
                            </select>
                        </th>
                        <th class="tabela_title">
                            <select name="medicorevisor" id="medicorevisor" class="size2">
                                <option value=""></option>
                                <? foreach ($medicos as $value) : ?>
                                    <option value="<?= $value->operador_id; ?>" ><?php echo $value->nome; ?></option>
                                <? endforeach; ?>
                            </select>
                        </th>
                        <th class="tabela_title">
                            <select name="situacaorevisor" id="situacaorevisor" class="size1" >
                                <option value='' ></option>
                                <option value='AGUARDANDO' >AGUARDANDO</option>
                                <option value='DIGITANDO' >DIGITANDO</option>
                                <option value='FINALIZADO' >FINALIZADO</option>
                            </select>
                        </th>
                        <th class="tabela_title">
                            <input type="text"  id="data" name="data" class="size1"  value="<?php echo @$_GET['data']; ?>" />
                        </th>
                        <th class="tabela_title">
                            <input type="text"  id="prontuario" name="prontuario" class="size1"  value="<?php echo @$_GET['prontuario']; ?>" />
                        </th>
                        <th colspan="2" class="tabela_title">
                            <input type="text" name="nome" class="texto06 bestupper" value="<?php echo @$_GET['nome']; ?>" />
                        </th>
                        <th class="tabela_title">
                            <button type="submit" id="enviar">Pesquisar</button>
                        </th>
                </form>
                </thead>
            </table>
            <table>
                <thead>
                    <tr>
                        <th class="tabela_header" width="200px;">Nome</th>
                        <th class="tabela_header" width="30px;">Idade</th>
                        <th class="tabela_header" width="30px;">Dias</th>
                        <th class="tabela_header" width="200px;">M&eacute;dico Revisor</th>
                        <th class="tabela_header">Status Revisor</th>
                        <th class="tabela_header" width="350px;">Procedimento</th>
                        <th class="tabela_header" colspan="4" width="140px;"><center>A&ccedil;&otilde;es</center></th>
                </tr>
                </thead>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->laudo->listarrevisor($_GET);
                $total = $consulta->count_all_results();
                $limit = 10;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        $lista = $this->laudo->listar2revisor($_GET)->limit($limit, $pagina)->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            $dataFuturo = date("Y-m-d H:i:s");
                            $dataAtual = $item->data_cadastro;

                            $date_time = new DateTime($dataAtual);
                            $diff = $date_time->diff(new DateTime($dataFuturo));
                            $teste = $diff->format('%d');

                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->paciente; ?></td>
                                <td class="<?php echo $estilo_linha; ?>" width="30px;"><?= $item->idade; ?></td>
                                <td class="<?php echo $estilo_linha; ?>" width="30px;"><?= $teste; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->medicorevisor; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->situacao_revisor; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->procedimento; ?></td>

                                <? if (($item->medico_parecer2 == $operador_id) || $operador_id == 1) { ?>
                                    <td class="<?php echo $estilo_linha; ?>" width="70px;"><div class="bt_link">
                                            <a href="<?= base_url() ?>ambulatorio/laudo/carregarrevisao/<?= $item->ambulatorio_laudo_id ?>/<?= $item->exame_id ?>/<?= $item->paciente_id ?>/<?= $item->procedimento_tuss_id ?>">
                                                Revis&atilde;o</a></div>
                                    </td>
                                <? } else { ?>
                                    <td class="<?php echo $estilo_linha; ?>" width="40px;"><font size="-2">
                                        <a>Bloqueado</a></font>
                                    </td>
                                <? }
                                ?>



                                <td class="<?php echo $estilo_linha; ?>" width="70px;"><div class="bt_link">
                                        <a href="<?= base_url() ?>ambulatorio/laudo/impressaolaudo/<?= $item->ambulatorio_laudo_id ?>/<?= $item->exame_id ?>">
                                            Imprimir</a></div>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>" width="70px;"><div class="bt_link">
                                        <a href="<?= base_url() ?>ambulatorio/laudo/impressaoimagem/<?= $item->ambulatorio_laudo_id ?>/<?= $item->exame_id ?>">
                                            imagem</a></div>
                                </td>
                            </tr>

                        </tbody>
                        <?php
                    }
                }
                ?>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="12">
                            <?php $this->utilitario->paginacao($url, $total, $pagina, $limit); ?>
                            Total de registros: <?php echo $total; ?>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

</div> <!-- Final da DIV content -->
<script type="text/javascript">

    $(function() {
        $("#data").datepicker({
            autosize: true,
            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            dateFormat: 'dd/mm/yy'
        });
    });


    $(function() {
        $("#accordion").accordion();
    });

</script>
