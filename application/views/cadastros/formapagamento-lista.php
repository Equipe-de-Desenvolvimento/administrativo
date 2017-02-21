<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_new" style="width: 200pt;">
        <center>
            <a style="width: 200pt;" href="<?php echo base_url() ?>cadastros/formapagamento/carregarformapagamento/0">
                Nova Forma de Pagamento
            </a>
        </center>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Forma de Pagamento</a></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th colspan="5" class="tabela_title">
                            <form method="get" action="<?= base_url() ?>cadastros/formapagamento/pesquisar">
                                <input type="text" name="nome" class="texto10 bestupper" value="<?php echo @$_GET['nome']; ?>" />
                                <button type="submit" id="enviar">Pesquisar</button>
                            </form>
                        </th>
                    </tr>
                    <tr>
                        <th class="tabela_header">Nome</th>
                        <th class="tabela_header">Pagamento</th>
                        <th class="tabela_header" width="70px;" colspan="3"><center>Detalhes</center></th>
                    </tr>
                </thead>
                <?php
                    $url      = $this->utilitario->build_query_params(current_url(), $_GET);
                    $consulta = $this->formapagamento->listar($_GET);
                    $total    = $consulta->count_all_results();
                    $limit    = 10;
                    isset ($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;
                    if ($total > 0) {
                ?>
                <tbody>
                    <?php
                        $lista = $this->formapagamento->listar($_GET)->orderby('nome')->limit($limit, $pagina)->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                     ?>
                            <tr >
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->nome; ?></td>
                                <? if($item->tipo == '1'):?>
                                    <td class="<?php echo $estilo_linha; ?>">AVISTA</td>
                                <? elseif($item->tipo == '2'):?>
                                    <td class="<?php echo $estilo_linha; ?>">PARCELADO</td>
                                <? elseif($item->tipo == '3'):?>
                                    <td class="<?php echo $estilo_linha; ?>">CADASTRO MANUAL</td>
                                <?endif;?>
                                    

                                <td class="<?php echo $estilo_linha; ?>" width="70px;">                                  
                                    <a href="<?= base_url() ?>cadastros/formapagamento/carregarformapagamento/<?= $item->forma_pagamento_id ?>">Editar</a>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>" width="70px;">                                  
                                    <a onclick="javascript: return confirm('Deseja realmente exlcuir esse Forma?');" href="<?= base_url() ?>cadastros/formapagamento/excluir/<?= $item->forma_pagamento_id ?>">Excluir</a>
                                </td>
                                
                                <? if($item->tipo == '1'):?>
                                    <td class="<?php echo $estilo_linha; ?>" width="70px;">                                  
                                        <a href="<?= base_url() ?>cadastros/formapagamento/formapagamentoavistaprazo/<?= $item->forma_pagamento_id ?>">Prazo</a>
                                    </td>
                                <? elseif($item->tipo == '2'):?>
                                    <td class="<?php echo $estilo_linha; ?>" width="70px;">                                  
                                        <a href="<?= base_url() ?>cadastros/formapagamento/formapagamentoparcelado/<?= $item->forma_pagamento_id ?>">Parcelas</a>
                                    </td>
                                <? elseif($item->tipo == '3'):?>
                                    <td class="<?php echo $estilo_linha; ?>" width="70px;">                                  
                                        <a href="<?= base_url() ?>cadastros/formapagamento/formapagamentomanual/<?= $item->forma_pagamento_id ?>">Cadastrar</a>
                                    </td>
                                <?endif;?>
                        </tr>

                        </tbody>
                        <?php
                                }
                            }
                        ?>
                        <tfoot>
                            <tr>
                                <th class="tabela_footer" colspan="5">
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