<?
//Da erro no home

if ($this->session->userdata('autenticado') != true) {
    redirect(base_url() . "login/index/login004", "refresh");
}
$perfil_id = $this->session->userdata('perfil_id');
$operador_id = $this->session->userdata('operador_id');
$internacao = $this->session->userdata('internacao');

function alerta($valor) {
    echo "<script>alert('$valor');</script>";
}

function debug($object) {
    
}
?>
<!DOCTYPE html PUBLIC "-//carreW3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd" >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="pt-BR" >
    <head>
        <title>STG - SOLUCAO EM TECNOLOGIA DE GESTAO v1.0</title>
        <meta http-equiv="Content-Style-Type" content="text/css" />
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
        <!-- Reset de CSS para garantir o funcionamento do layout em todos os brownsers -->
        <link href="<?= base_url() ?>css/reset.css" rel="stylesheet" type="text/css" />

        <link href="<?= base_url() ?>css/estilo.css" rel="stylesheet" type="text/css" />

        <link href="<?= base_url() ?>css/form.css" rel="stylesheet" type="text/css" />

        <link href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url() ?>css/jquery-treeview.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
        <script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.8.5.custom.min.js" ></script>
        <script type="text/javascript" src="<?= base_url() ?>js/jquery-cookie.js" ></script>
        <script type="text/javascript" src="<?= base_url() ?>js/jquery-treeview.js" ></script>
        <script type="text/javascript" src="<?= base_url() ?>js/jquery-meiomask.js" ></script>
        <script type="text/javascript" src="<?= base_url() ?>js/jquery.bestupper.min.js"  ></script>
        <script type="text/javascript" src="<?= base_url() ?>js/scripts_alerta.js" ></script>
        <script type="text/javascript">
//            var jQuery = jQuery.noConflict();

            (function ($) {
                $(function () {
                    $('input:text').setMask();
                });
            })(jQuery);

        </script>

    </head>
    <script type="text/javascript" src="<?= base_url() ?>js/funcoes.js"></script>

    <?php
    $this->load->library('utilitario');
    Utilitario::pmf_mensagem($this->session->flashdata('message'));
    ?>


    <div class="container">
        <div class="header">
            <div id="imglogo">
                <img src="<?= base_url(); ?>img/stg - logo.jpg" alt="Logo"
                     title="Logo" height="70" id="Insert_logo"
                     style="display:block;" />
            </div>
            <div id="login">
                <div id="user_info">
                    <label style='font-family: serif; font-size: 8pt;'>Seja bem vindo <?= $this->session->userdata('login'); ?>! </label>
                    <label style='font-family: serif; font-size: 8pt;'>Empresa: <?= $this->session->userdata('empresa'); ?> </label>
                </div>
                <div id="login_controles">
                    <!--
                    <a href="#" alt="Alterar senha" id="login_pass">Alterar Senha</a>
                    -->
                    <a id="login_sair" title="Sair do Sistema" onclick="javascript: return confirm('Deseja realmente sair da aplicação?');"
                       href="<?= base_url() ?>login/sair">Sair</a>
                </div>
                <!--<div id="user_foto">Imagem</div>-->

            </div>
        </div>
        <div class="decoration_header">&nbsp;</div>

        <!-- Fim do Cabeçalho -->
        <div class="correcaoEstilo">
            <div class="barraMenus" style="float: left;">
                <ul id="menu" class="filetree">
                    <li><span class="folder">Estoque</span>
                        <ul>
                            <li><span class="folder">Rotinas</span>
                                <? if ($perfil_id != 9 && $perfil_id != 2 && $perfil_id != 11 && $perfil_id != 12) { ?>
                                    <ul><span class="file"><a href="<?= base_url() ?>estoque/solicitacao">Manter Pedido</a></span></ul>
                                <? } if ($perfil_id == 1 || $perfil_id == 8) { ?>
                                    <ul><span class="file"><a href="<?= base_url() ?>estoque/entrada">Manter Entrada</a></span></ul>
                                    <ul><span class="file"><a href="<?= base_url() ?>estoque/inventario">Manter Inventario</a></span></ul>
                                    <ul><span class="file"><a href="<?= base_url() ?>estoque/fornecedor">Manter Fornecedor</a></span></ul>
                                    <ul><span class="file"><a href="<?= base_url() ?>estoque/produto">Manter Produto</a></span></ul>
                                    <ul><span class="file"><a href="<?= base_url() ?>estoque/transportadora">Manter Transportadora</a></span></ul>
                                <? } ?>
                            </li> 
                            <li><span class="folder">Relatorios</span>
                                <? if ($perfil_id == 1 || $perfil_id == 8) { ?>
                                    <ul><span class="file"><a href="<?= base_url() ?>estoque/entrada/relatorioentradaarmazem">Relatorio Entrada Produtos</a></span></ul>
                                    <ul><span class="file"><a href="<?= base_url() ?>estoque/entrada/relatoriosaidaarmazem">Relatorio Saida Produtos</a></span></ul>
                                    <ul><span class="file"><a href="<?= base_url() ?>estoque/entrada/relatoriosaldoarmazem">Relatorio Saldo Produtos/Entrada</a></span></ul>
                                    <ul><span class="file"><a href="<?= base_url() ?>estoque/entrada/relatoriosaldo">Relatorio Saldo Produtos</a></span></ul>
                                    <ul><span class="file"><a href="<?= base_url() ?>estoque/entrada/relatoriominimo">Relatorio Estoque Minimo</a></span></ul>
                                    <ul><span class="file"><a href="<?= base_url() ?>estoque/entrada/relatorioprodutos">Relatorio Produtos</a></span></ul>
                                    <ul><span class="file"><a href="<?= base_url() ?>estoque/entrada/relatoriofornecedores">Relatorio Fornecedores</a></span></ul>

                                <? } ?>
                            </li> 
                        </ul>
                    </li>

                    <li><span class="folder">Contratos</span>
                        <? if ($perfil_id == 1) { ?>          
                            <ul><span class="file"><a href="<?= base_url() ?>estoque/contrato">Manter Contrato</a></span></ul>
                            <ul><span class="file"><a href="<?= base_url() ?>estoque/contrato/pesquisarcontratotipo">Manter Contrato Tipo</a></span></ul>
                        <? } ?>
                    </li> 
                    <li><span class="folder">Financeiro</span>
                        <ul>
                            <li><span class="folder">Rotinas</span>
                                <? if ($perfil_id == 1) { ?>
                                    <ul><span class="file"><a href="<?= base_url() ?>cadastros/caixa">Manter Entrada</a></span></ul>
                                    <ul><span class="file"><a href="<?= base_url() ?>cadastros/caixa/pesquisar2">Manter Saida</a></span></ul>
                                    <ul><span class="file"><a href="<?= base_url() ?>cadastros/contaspagar">Manter Contas a pagar</a></span></ul>
                                    <ul><span class="file"><a href="<?= base_url() ?>cadastros/contasreceber">Manter Contas a Receber</a></span></ul>
                                    <ul><span class="file"><a href="<?= base_url() ?>cadastros/caixa/pesquisar3">Manter Sangria</a></span></ul>
                                    <ul><span class="file"><a href="<?= base_url() ?>cadastros/fornecedor">Manter Credor/Devedor</a></span></ul>
                                <? }
                                ?>
                            </li> 
                            <li><span class="folder">Relatorios</span>
                                <?
                                if ($perfil_id == 1) {
                                    ?>
                                    <ul><span class="file"><a href="<?= base_url() ?>cadastros/caixa/relatorioarquivoscnab">Arquivos CNAB</a></span></ul>
                                    <ul><span class="file"><a href="<?= base_url() ?>cadastros/caixa/relatoriosaida">Relatorio Saida</a></span></ul>
                                    <ul><span class="file"><a href="<?= base_url() ?>cadastros/caixa/relatoriosaidagrupo">Relatorio Saida Tipo</a></span></ul>
                                    <ul><span class="file"><a href="<?= base_url() ?>cadastros/caixa/relatorioentrada">Relatorio Entrada</a></span></ul>
                                    <ul><span class="file"><a href="<?= base_url() ?>cadastros/caixa/relatorioentradagrupo">Relatorio Entrada Conta</a></span></ul>
                                    <ul><span class="file"><a href="<?= base_url() ?>cadastros/contaspagar/relatoriocontaspagar">Relatorio Contas a pagar</a></span></ul>
                                    <ul><span class="file"><a href="<?= base_url() ?>cadastros/contasreceber/relatoriocontasreceber">Relatorio Contas a Receber</a></span></ul>
                                    <ul><span class="file"><a href="<?= base_url() ?>cadastros/caixa/relatoriomovitamentacao">Relatorio Moviten&ccedil;&atilde;o</a></span></ul>
                                    <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriovalormedio">Relatorio Valor Medio</a></span></ul>
                                    <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatorionotafiscal">Relatorio Nota</a></span></ul>
                                    <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatorioresumogeral">Relatorio Resumo</a></span></ul>
                                    <ul><span class="file"><a href="<?= base_url() ?>cadastros/caixa/relatorioacompanhamentodecontas">Relatorio Acompanhamento de contas</a></span></ul>
                                    <?
                                }
                                if ($perfil_id == 1 || $perfil_id == 5) {
                                    ?>
                                    <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriocaixa">Relatorio Caixa</a></span></ul>
                                    <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriocaixafaturado">Relatorio Caixa Faturamento</a></span></ul>
                                    <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriocaixacartao">Relatorio Caixa Cartao</a></span></ul>
                                    <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatoriocaixacartaoconsolidado">Relatorio Consolidado Cartao</a></span></ul>
                                    <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/guia/relatorioindicacao">Relatorio Indicacao</a></span></ul>
                                    <?
                                }
                                ?>

                            </li> 

                        </ul>
                    </li>

                    <li><span class="folder">Configura&ccedil;&atilde;o</span>
                        <ul>

                            <li><span class="folder">Estoque</span>
                                <? if ($perfil_id == 1 || $perfil_id == 8) { ?>
                                    <ul><span class="file"><a href="<?= base_url() ?>estoque/menu">Manter Menu</a></span></ul>
                                    <ul><span class="file"><a href="<?= base_url() ?>estoque/tipo">Manter Tipo</a></span></ul>
                                    <ul><span class="file"><a href="<?= base_url() ?>estoque/classe">Manter Classe</a></span></ul>
                                    <ul><span class="file"><a href="<?= base_url() ?>estoque/subclasse">Manter Sub-Classe</a></span></ul>
                                    <ul><span class="file"><a href="<?= base_url() ?>estoque/unidade">Manter Medida</a></span></ul>
                                    <ul><span class="file"><a href="<?= base_url() ?>estoque/armazem">Manter Armazem</a></span></ul>
                                    <ul><span class="file"><a href="<?= base_url() ?>estoque/cliente">Manter Cliente</a></span></ul>
                                    <ul><span class="file"><a href="<?= base_url() ?>estoque/marca">Manter Marca</a></span></ul>
                                    <ul><span class="file"><a href="<?= base_url() ?>estoque/solicitacao/entregador">Manter Entregador</a></span></ul>
                                    <ul><span class="file"><a href="<?= base_url() ?>seguranca/operador/operadorsetor">Listar Operadores</a></span></ul>
                                <? } ?>
                            </li> 
                            <li><span class="folder">Financeiro</span>
                                <? if ($perfil_id == 1) { ?>
                                    <ul><span class="file"><a href="<?= base_url() ?>cadastros/tipo">Manter Tipo</a></span></ul>
                                    <ul><span class="file"><a href="<?= base_url() ?>cadastros/classe">Manter Classe</a></span></ul>
        <!--                                <ul><span class="file"><a href="<?= base_url() ?>cadastros/subclasse">Manter Sub-Classe</a></span></ul>-->
                                    <ul><span class="file"><a href="<?= base_url() ?>cadastros/forma">Manter Conta</a></span></ul>
                                    <ul><span class="file"><a href="<?= base_url() ?>cadastros/formapagamento/pesquisardescricao">Manter Descricao do Pagamento</a></span></ul>
                                    <ul><span class="file"><a href="<?= base_url() ?>cadastros/formapagamento">Manter Forma de Pagamento</a></span></ul>
                                    <ul><span class="file"><a href="<?= base_url() ?>cadastros/formapagamento/grupospagamento">Forma de Pagamento Grupo</a></span></ul>
                                <? } ?>
                            </li> 
    <!--                        <li><span class="folder">Tabelas</span>
                            <? if ($perfil_id == 1) { ?>
                                                <ul><span class="file"><a href="<?= base_url() ?>cadastros/tabelas/pesquisarnaturezaoperacao">Manter Natureza de Operação</a></span></ul>
                                                <ul><span class="file"><a href="<?= base_url() ?>cadastros/tabelas/pesquisarcfop">Manter CFOP</a></span></ul>
                                                <ul><span class="file"><a href="<?= base_url() ?>cadastros/tabelas/pesquisarcst">Manter CST (ICMS)</a></span></ul>
                                                <ul><span class="file"><a href="<?= base_url() ?>cadastros/tabelas/pesquisarcst">Manter CST (IPI)</a></span></ul>
                                                <ul><span class="file"><a href="<?= base_url() ?>cadastros/tabelas/pesquisarcst">Manter CST (PIS/COFINS)</a></span></ul>
                                                <ul><span class="file"><a href="<?= base_url() ?>cadastros/tabelas/pesquisarncm">Manter NCM</a></span></ul>
                                                <ul><span class="file"><a href="<?= base_url() ?>cadastros/tabelas/pesquisarcest">Manter CEST</a></span></ul>
                                                <ul><span class="file"><a href="<?= base_url() ?>cadastros/tabelas/pesquisarcean">Manter cEAN / cEANTrib</a></span></ul>
                            <? } ?>
                            </li> -->
                            <li><span class="folder">Administrativas</span>
                                <? if ($perfil_id == 1 || $perfil_id == 3) { ?>
                                    <ul><span class="file"><a href="<?= base_url() ?>seguranca/operador">Listar Profissionais</a></span></ul>    
                                    <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/empresa">Manter Empresa</a></span></ul>
                                    <ul><span class="file"><a href="<?= base_url() ?>ambulatorio/versao">Vers&atilde;o</a></span></ul>
                                <? } ?>
                            </li> 
                        </ul>
                    </li>
                    <li><span class="file"><a onclick="javascript: return confirm('Deseja realmente sair da aplicação?');"
                                              href="<?= base_url() ?>login/sair">Sair</a></span>
                    </li>
                </ul>                       
                <!-- Fim da Barra Lateral -->
            </div>
            <div class="mensagem"><?
                if (isset($mensagem)): echo $mensagem;
                endif;
                ?></div>
            <script type="text/javascript">
                $("#menu").treeview({
                    animated: "normal",
                    persist: "cookie",
                    collapsed: true,
                    unique: true
                });

            </script>