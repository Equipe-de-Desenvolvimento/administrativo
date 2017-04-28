
<?
$tipo = $this->menu->listartipos();
$classe = $this->produto->listarclasse();
$sub = $this->produto->listarsub();
$marca = $this->produto->listarmarca();
?>
<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_new">
        <a href="<?php echo base_url() ?>estoque/produto/carregarproduto/0">
            Novo Produto
        </a>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Produto</a></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th colspan="3" class="tabela_title">
                            <form method="get" action="<?= base_url() ?>estoque/produto/pesquisar/<?=$limite_paginacao?>">
                                <tr>
                                    <th class="tabela_title">Produto</th>
                                    <th class="tabela_title">Código</th>
                                    <th class="tabela_title">Marca</th>
                                    <th class="tabela_title">Tipo</th>
                                    <th class="tabela_title">Classe</th>
                                    <th class="tabela_title">Sub-classe</th>
                                    <th class="tabela_title"></th>                              
                                </tr>
                                <tr>
                                    <td> <input type="text" name="nome" class="texto06 bestupper" value="<?php echo @$_GET['nome']; ?>" /></td>
                                    <td> <input type="text" name="codigo" class="texto02" value="<?php echo @$_GET['codigo']; ?>" /></td>
                                    <td> 
                                        <select name="marca_id" id="marca_id" class="texto02">
                                            <option value="">SELECIONE</option>
                                            <? foreach ($marca as $value) : ?>
                                                <option value="<?= $value->estoque_marca_id; ?>"
                                                         <?= (@$_GET['marca_id'] == $value->estoque_marca_id)?'selected':'' ?>>
                                                    <?php echo $value->descricao; ?>
                                                </option>
                                            <? endforeach; ?>
                                        </select>
                                    </td>
                                    <td> 
                                        <select name="tipo_id" id="tipo_id" class="texto02">
                                            <option value="">SELECIONE</option>
                                            <? foreach ($tipo as $value) : ?>
                                                <option value="<?= $value->estoque_tipo_id; ?>"
                                                        <?= (@$_GET['tipo_id'] == $value->estoque_tipo_id)?'selected':'' ?>>
                                                            <?php echo $value->descricao; ?>
                                                </option>
                                            <? endforeach; ?>
                                        </select></td>
                                    <td>
                                        <select name="classe_id" id="classe_id" class="texto02">
                                            <option value="">SELECIONE</option>
                                            <? foreach ($classe as $item) : ?>
                                                <option value="<?= $item->estoque_classe_id; ?>"
                                                        <?= (@$_GET['classe_id'] == $item->estoque_classe_id)?'selected':'' ?>>
                                                            <?php echo $item->descricao; ?>
                                                </option>
                                            <? endforeach; ?>
                                        </select>

                                    </td>
                                    <td>
                                        <select name="subclasse_id" id="subclasse_id" class="texto02">
                                            <option value="">SELECIONE</option>
                                            <? foreach ($sub as $sclasse) : ?>
                                                <option value="<?= $sclasse->estoque_sub_classe_id; ?>"
                                                        <?= (@$_GET['subclasse_id'] == $sclasse->estoque_sub_classe_id)?'selected':'' ?>>
                                                            <?php echo $sclasse->descricao; ?>
                                                </option>
                                            <? endforeach; ?>
                                        </select>
                                    </td>
                                    <td> <button type="submit" id="enviar">Pesquisar</button></td>                          
                                </tr>
                            </form>
                        </th>
                    </tr>
                </thead>
            </table>
            <table>
                <thead>
                  <tr>
                        <th class="tabela_header">Codigo</th>
                        <th class="tabela_header">Nome</th>
                        <th class="tabela_header">Marca</th>
                        <th class="tabela_header">Unidade</th>
                        <th class="tabela_header">Classe</th>
                        <th class="tabela_header">Sub-classe</th>
                        <th class="tabela_header">Valor</th>
                        <th class="tabela_header" colspan="2"><center>Detalhes</center></th>
                </tr>
                </thead>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->produto->listar($_GET);
                $total = $consulta->count_all_results();
                $limit = $limite_paginacao;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        if ($limit != "todos") {
                            $lista = $this->produto->listar($_GET)->limit($limit, $pagina)->get()->result();
                        } else {
                            $lista = $this->produto->listar($_GET)->get()->result();
                        }
                        
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->codigo ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->descricao; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->marca; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->unidade; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->classe; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->sub_classe; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= number_format($item->valor_compra, 2, ',', '.'); ?></td>
                                <td class="<?php echo $estilo_linha; ?>">                                  
                                    <a href="<?= base_url() ?>estoque/produto/carregarproduto/<?= $item->estoque_produto_id ?>">Editar</a>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>" colspan="2">                                  
                                    <a onclick="javascript: return confirm('Deseja realmente exlcuir esse Produto?');" href="<?= base_url() ?>estoque/produto/excluir/<?= $item->estoque_produto_id ?>">Excluir</a>
                                </td>
                            </tr>

                        </tbody>
                        <?php
                    }
                }
                ?>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="16">
                            <?php $this->utilitario->paginacao($url, $total, $pagina, $limit); ?>
                            Total de registros: <?php echo $total; ?>
                            <div style="display: inline">
                                <span style="margin-left: 15px; color: white; font-weight: bolder;"> Limite: </span>
                                <select style="width: 50px">
                                    <option onclick="javascript:window.location.href = ('<?= base_url() ?>estoque/produto/pesquisar/25');" <? if ($limit == 25) {
                                echo "selected";
                            } ?>> 25 </option>
                                    <option onclick="javascript:window.location.href = ('<?= base_url() ?>estoque/produto/pesquisar/50');" <? if ($limit == 50) {
                                echo "selected";
                            } ?>> 50 </option>
                                    <option onclick="javascript:window.location.href = ('<?= base_url() ?>estoque/produto/pesquisar/100');" <? if ($limit == 100) {
                                echo "selected";
                            } ?>> 100 </option>
                                    <option onclick="javascript:window.location.href = ('<?= base_url() ?>estoque/produto/pesquisar/todos');" <? if ($limit == "todos") {
                                echo "selected";
                            } ?>> Todos </option>
                                </select>
                            </div>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

</div> <!-- Final da DIV content -->
<script type="text/javascript">

    $(function () {
        $("#accordion").accordion();
    });

    $(function () {
        $('#classe_id').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/estoquesubclasseporclasse', {classe_id: $(this).val(), ajax: true}, function (j) {
                    options = '<option value="">SELECIONE -></option>';
                    for (var c = 0; c < j.length; c++) {
                        options += '<option value="' + j[c].estoque_sub_classe_id + '">' + j[c].descricao + '</option>';
                    }
                    $('#subclasse_id').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#subclasse_id').html('<option value="">SELECIONE</option>');
            }
        });
    });
    $(function () {
        $('#tipo_id').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                //Pega todas as classes para esse tipo
                $.getJSON('<?= base_url() ?>autocomplete/estoqueclasseportipo', {tipo_id: $(this).val(), ajax: true}, function (j) {
                    options = '<option value="">SELECIONE -></option>';
                    for (var c = 0; c < j.length; c++) {
                        options += '<option value="' + j[c].estoque_classe_id + '">' + j[c].descricao + '</option>';
                    }
                    $('#classe_id').html(options).show();
                    $('.carregando').hide();
                });
                
                //Pega todas as subclasses para esse subtipo
                $.getJSON('<?= base_url() ?>autocomplete/estoqueprodutoportipo', {tipo_id: $(this).val(), ajax: true}, function (j) {
                    options = '<option value="">SELECIONE -></option>';
                    for (var c = 0; c < j.length; c++) {
                        options += '<option value="' + j[c].estoque_sub_classe_id + '">' + j[c].descricao + '</option>';
                    }
                    $('#subclasse_id').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#classe_id').html('<option value="">SELECIONE</option>');
            }
        });
    });

</script>
