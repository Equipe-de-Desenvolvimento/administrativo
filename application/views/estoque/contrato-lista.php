
<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_new">
        <a href="<?php echo base_url() ?>estoque/contrato/carregarcontrato/0">
            Novo Contrato
        </a>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Contrato</a></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th colspan="5" class="tabela_title">
                            <form method="get" action="<?= base_url() ?>estoque/contrato/pesquisar">
                                <input type="text" name="nome" class="texto10 bestupper" value="<?php echo @$_GET['nome']; ?>" />
                                <button type="submit" id="enviar">Pesquisar</button>
                            </form>
                        </th>
                    </tr>
                    <tr>
                        <th class="tabela_header">Nome</th>
                        <th class="tabela_header">Credor/Devedor</th>
                        <th class="tabela_header">Nr. Contrato</th>
                        <th class="tabela_header">Tp. de Contrato</th>
                        <th class="tabela_header">Data Inicio</th>
                        <th class="tabela_header">Data Fim</th>
                        <th class="tabela_header">Vlr. Inicial</th>
                        <th class="tabela_header" width="70px;" colspan="2"><center>Detalhes</center></th>
                    </tr>
                </thead>
                <?php
                    $url      = $this->utilitario->build_query_params(current_url(), $_GET);
                    $consulta = $this->contrato->listar($_GET);
                    $total    = $consulta->count_all_results();
                    $limit    = 10;
                    isset ($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                    if ($total > 0) {
                ?>
                <tbody>
                    <?php
                        $lista = $this->contrato->listar($_GET)->orderby('ect.nome')->limit($limit, $pagina)->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                     ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->contrato; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->credor_devedor; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->numero_contrato; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->tipo; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= date("d/m/Y", strtotime($item->data_inicio) ); ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= date("d/m/Y", strtotime($item->data_fim) ); ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= number_format((float)$item->valor_inicial, 2, ',', ''); ?></td>

                                <td class="<?php echo $estilo_linha; ?>" width="70px;">                                  
                                    <a href="<?= base_url() ?>estoque/contrato/carregarcontrato/<?= $item->estoque_contrato_id ?>">Editar</a>
                            </td>
                                <td class="<?php echo $estilo_linha; ?>" width="70px;">                                  
                                    <a onclick="javascript: return confirm('Deseja realmente exlcuir esse Contrato?');" href="<?= base_url() ?>estoque/contrato/excluir/<?= $item->estoque_contrato_id ?>">Excluir</a>
                            </td>
                        </tr>

                        </tbody>
                        <?php
                                }
                            }
                        ?>
                        <tfoot>
                            <tr>
                                <th class="tabela_footer" colspan="9">
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
        $( "#accordion" ).accordion();
    });

</script>
