
<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_new">
        <a href="<?php echo base_url() ?>estoque/solicitacao/criarsolicitacao/0">
            Novo Pedido
        </a>
    </div>
    <?
    $perfil_id = $this->session->userdata('perfil_id');
    $almoxarifado = $this->solicitacao->almoxarifadosaida();
    ?>
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Pedido</a></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th colspan="5" class="tabela_title">
                            <form method="get" action="<?= base_url() ?>estoque/solicitacao/pesquisar">
                                <input type="text" name="nome" class="texto10 bestupper" value="<?php echo @$_GET['nome']; ?>" />
                                <button type="submit" id="enviar">Pesquisar</button>
                            </form>
                        </th>
                    </tr>
                    <tr>
                        <th class="tabela_header">Pedido</th>
                        <th class="tabela_header">Data</th>
                        <th class="tabela_header">Status</th>
                        <th class="tabela_header" width="70px;" colspan="4"><center>Detalhes</center></th>
                </tr>
                </thead>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->solicitacao->listar($_GET);
                $total = $consulta->count_all_results();
                $limit = 10;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        $lista = $this->solicitacao->listar($_GET)->orderby('es.estoque_solicitacao_setor_id desc')->limit($limit, $pagina)->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {

                            if ($item->situacao == 'ABERTA') {
                                $verifica = 2;
                            } elseif ($item->situacao == 'FECHADA') {
                                $verifica = 1;
                            } elseif ($item->situacao == 'LIBERADA') {
                                $verifica = 3;
                            }

                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->estoque_solicitacao_setor_id ?> - <?= $item->cliente; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= substr($item->data_cadastro, 8, 2) . "/" . substr($item->data_cadastro, 5, 2) . "/" . substr($item->data_cadastro, 0, 4); ?></td>
                                <? if ($verifica == 1) { ?>
                                    <td class="<?php echo $estilo_linha; ?>"><font color="red"><b><?= $item->situacao; ?></b></td>
                                <? }if ($verifica == 2) { ?>
                                    <td class="<?php echo $estilo_linha; ?>"><font color="blue"><b><?= $item->situacao; ?></b></td>
                                <? }if ($verifica == 3) { ?>
                                    <td class="<?php echo $estilo_linha; ?>"><font color="green"><b><?= $item->situacao; ?></b></td>
                                    <?
                                }
                                if ($item->situacao == 'ABERTA') {
                                    ?>
                                    <td class="<?php echo $estilo_linha; ?>" width="60px;">  <div class="bt_link">                                
                                            <a href="<?= base_url() ?>estoque/solicitacao/carregarsolicitacao/<?= $item->estoque_solicitacao_setor_id ?>">Cadastrar</a>
                                        </div>
                                    </td>
                                    <?
                                }
                                if ($item->situacao == 'LIBERADA' && ($perfil_id == 1 || $perfil_id == 8)) {
                                    if ($item->faturado == 'f') {
                                        ?>
                                        <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">                                
                                                <a href="<?= base_url() ?>estoque/solicitacao/gravarfaturamento/<?= $item->estoque_solicitacao_setor_id ?>">Finalizar</a>

                                            </div>
                                        </td>
                                        <? if ($item->transportadora == 'f') { ?>
                                            <td class="<?php echo $estilo_linha; ?>" width="60px;">
                                                <div class="bt_link">                                  
                                                    <a onclick="javascript: window.open('<?= base_url() ?>estoque/solicitacao/gravartransportadora/<?= $item->estoque_solicitacao_setor_id ?>', '_blank', 'toolbar=no,Location=no,menubar=no,scrollbars=yes,width=750,height=400');">Transportadora</a>
                                                </div> 
                                            </td>

                                            <?
                                        }
                                    }
//                                    var_dump($almoxarifado);die;
                                    if ($almoxarifado[0]->almoxarifado == 't') {
                                        if ($item->faturado == 't') {
                                            ?>

                                            <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">                                
                                                    <a href="<?= base_url() ?>estoque/solicitacao/carregarsaida/<?= $item->estoque_solicitacao_setor_id ?>">Saida</a>
                                                </div>
                                            </td>
                                            <?
                                        }
                                    }
                                    if ($item->faturado == 't' && $item->boleto == 't') {
                                        ?>

                                        <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">                                
                                                <a href="<?= base_url() ?>estoque/boleto/carregarboletos/<?= $item->estoque_solicitacao_setor_id ?>">Boleto</a>
                                            </div>
                                        </td>
                                    <?
                                    }
                                }

                                if ($item->situacao != 'ABERTA') {
                                    ?>
                                    <td class="<?php echo $estilo_linha; ?>" width="60px;" colspan="">  <div class="bt_link">                                
                                            <a href="<?= base_url() ?>estoque/solicitacao/carregarimpressoes/<?= $item->estoque_solicitacao_setor_id ?>">Impressoes</a>
                                        </div>
                                    </td>
                                    <?
                                }
                                if (($perfil_id == 1 || $perfil_id == 8) && $item->notafiscal == 't' && $item->faturado == 't') {
                                    ?>
                                    <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">                                  
                                            <a href="<?= base_url() ?>estoque/notafiscal/carregarnotafiscalopcoes/<?= $item->estoque_solicitacao_setor_id ?>/<?= $item->notafiscal_id ?>">N. Fiscal</a>
                                        </div>
                                    </td>
                                    <?
                                }
                                if ($item->situacao != 'FECHADA' && ($perfil_id == 1 || $perfil_id == 8) && ($item->faturado != 't')) {
                                    ?>
                                    <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">                                  
                                            <a onclick="javascript: return confirm('Deseja realmente exlcuir esse Solicitacao?');" href="<?= base_url() ?>estoque/solicitacao/excluir/<?= $item->estoque_solicitacao_setor_id ?>">Excluir</a>
                                        </div>
                                    </td>
        <? } ?>
                            </tr>

                        </tbody>
                        <?php
                    }
                }
                ?>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="7">
<?php $this->utilitario->paginacao($url, $total, $pagina, $limit); ?>
                            Total de registros: <?php echo $total; ?>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

</div> <!-- Final da DIV content -->
<style>
    .bt_link{
        min-width:100px;
    }
    .bt_link a {
        text-align: center;        
    }
</style>
<script type="text/javascript">

    $(function () {
        $("#accordion").accordion();
    });

</script>
