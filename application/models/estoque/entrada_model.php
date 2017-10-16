<?php

class entrada_model extends Model {

    var $_estoque_entrada_id = null;
    var $_razao_social = null;
    var $_produto_id = null;
    var $_produto = null;
    var $_fornecedor_id = null;
    var $_fornecedor = null;
    var $_armazem_id = null;
    var $_armazem = null;
    var $_nota_fiscal = null;
    var $_valor_compra = null;
    var $_validade = null;

    function Entrada_model($estoque_entrada_id = null) {
        parent::Model();
        if (isset($estoque_entrada_id)) {
            $this->instanciar($estoque_entrada_id);
        }
    }

    function listar($args = array()) {
        $this->db->select('e.estoque_entrada_id,
                            e.produto_id,
                            f.fantasia,
                            p.descricao as produto,
                            e.fornecedor_id,
                            f.razao_social as fornecedor,
                            e.armazem_id,
                            a.descricao as armazem,
                            e.valor_compra,
                            e.quantidade,
                            e.nota_fiscal,
                            e.validade');
        $this->db->from('tb_estoque_entrada e');
        $this->db->join('tb_estoque_produto p', 'p.estoque_produto_id = e.produto_id', 'left');
        $this->db->join('tb_estoque_fornecedor f', 'f.estoque_fornecedor_id = e.fornecedor_id', 'left');
        $this->db->join('tb_estoque_armazem a', 'a.estoque_armazem_id = e.armazem_id', 'left');
        $this->db->where('e.ativo', 'true');
        $this->db->where('e.inventario', 'false');
        if (isset($args['produto']) && strlen($args['produto']) > 0) {
            $this->db->where('p.descricao ilike', "%" . $args['produto'] . "%");
        }
        if (isset($args['fornecedor']) && strlen($args['fornecedor']) > 0) {
            $this->db->where('f.razao_social ilike', "%" . $args['fornecedor'] . "%");
        }
        if (isset($args['armazem']) && strlen($args['armazem']) > 0) {
            $this->db->where('a.descricao ilike', "%" . $args['armazem'] . "%");
        }
        if (isset($args['nota']) && strlen($args['nota']) > 0) {
            $this->db->where('e.nota_fiscal ilike', "%" . $args['nota'] . "%");
        }
        return $this->db;
    }

    function listarsub() {
        $this->db->select('sc.estoque_sub_classe_id,
                            sc.descricao');
        $this->db->from('tb_estoque_sub_classe sc');
        $this->db->where('sc.ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function listararmazem() {
        $this->db->select('estoque_armazem_id,
                            descricao');
        $this->db->from('tb_estoque_armazem');
        $this->db->where('ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function listararmazemcada($estoque_armazem_id) {
        $this->db->select('estoque_armazem_id,
                            descricao');
        $this->db->from('tb_estoque_armazem');
        if ($estoque_armazem_id != "0" && $estoque_armazem_id != "") {
            $this->db->where('estoque_armazem_id', $estoque_armazem_id);
        }
        $this->db->where('ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function listarfornecedorcada($estoque_fornecedor_id) {
        $this->db->select('estoque_fornecedor_id,
                            fantasia');
        $this->db->from('tb_estoque_fornecedor');
        if ($estoque_fornecedor_id != "0" && $estoque_fornecedor_id != "") {
            $this->db->where("estoque_fornecedor_id", $estoque_fornecedor_id);
        }
        $this->db->where('ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function listarprodutocada($estoque_produto_id) {
        $this->db->select('estoque_produto_id,
                            descricao');
        $this->db->from('tb_estoque_produto');
        if ($estoque_produto_id != "0" && $estoque_produto_id != "") {
            $this->db->where('estoque_produto_id', $estoque_produto_id);
        }
        $this->db->where('ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function listarprodutoentradaxml($codProduto) {
        $this->db->select('estoque_produto_id,
                            descricao');
        $this->db->from('tb_estoque_produto');
        $this->db->where('codigo', "$codProduto");
        $this->db->where('ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function listarfornecedorentradaxml($cnpj) {
        $this->db->select('estoque_fornecedor_id,
                            razao_social');
        $this->db->from('tb_estoque_fornecedor');
        $this->db->where('cnpj', $cnpj);
        $this->db->where('ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function listarunidade() {
        $this->db->select('estoque_unidade_id,
                            descricao');
        $this->db->from('tb_estoque_unidade');
        $this->db->where('ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriosaldoarmazem() {
        $this->db->select('es.nota_fiscal,
            es.validade as data,
            ea.descricao as armazem,
            ef.fantasia,
            sum(es.quantidade) as quantidade,
            es.valor_compra,
            ep.descricao as produto');
        $this->db->from('tb_estoque_saldo es');
        $this->db->join('tb_estoque_armazem ea', 'ea.estoque_armazem_id = es.armazem_id', 'left');
        $this->db->join('tb_estoque_fornecedor ef', 'ef.estoque_fornecedor_id = es.fornecedor_id', 'left');
        $this->db->join('tb_estoque_produto ep', 'ep.estoque_produto_id = es.produto_id', 'left');
        $this->db->where('es.ativo', 'true');
        if ($_POST['armazem'] != "0") {
            $this->db->where('es.armazem_id', $_POST['armazem']);
        }
        if ($_POST['txtfornecedor'] != "0" && $_POST['txtfornecedor'] != "") {
            $this->db->where("es.fornecedor_id", $_POST['txtfornecedor']);
        }
        if ($_POST['txtproduto'] != "0" && $_POST['txtproduto'] != "") {
            $this->db->where("es.produto_id", $_POST['txtproduto']);
        }
//        if ($_POST['empresa'] != "0") {
//            $this->db->where('ae.empresa_id', $_POST['empresa']);
//        }
        $this->db->groupby('es.nota_fiscal, es.validade, ea.descricao, ef.fantasia, ep.descricao, es.valor_compra');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriosaldoarmazemcontador() {
        $this->db->select('es.nota_fiscal,
            es.validade,
            ea.descricao as armazem,
            ef.fantasia,
            es.quantidade,
            es.valor_compra,
            ep.descricao as produto');
        $this->db->from('tb_estoque_saldo es');
        $this->db->join('tb_estoque_armazem ea', 'ea.estoque_armazem_id = es.armazem_id', 'left');
        $this->db->join('tb_estoque_fornecedor ef', 'ef.estoque_fornecedor_id = es.fornecedor_id', 'left');
        $this->db->join('tb_estoque_produto ep', 'ep.estoque_produto_id = es.produto_id', 'left');
        $this->db->where('es.ativo', 'true');
        if ($_POST['armazem'] != "0") {
            $this->db->where('es.armazem_id', $_POST['armazem']);
        }
        if ($_POST['txtfornecedor'] != "0" && $_POST['txtfornecedor'] != "") {
            $this->db->where("es.fornecedor_id", $_POST['txtfornecedor']);
        }
        if ($_POST['txtproduto'] != "0" && $_POST['txtproduto'] != "") {
            $this->db->where("es.produto_id", $_POST['txtproduto']);
        }
//        if ($_POST['empresa'] != "0") {
//            $this->db->where('ae.empresa_id', $_POST['empresa']);
//        }
        $return = $this->db->count_all_results();
        return $return;
    }

    function relatoriominimoarmazem() {
        $this->db->select('ea.descricao as armazem,
            sum(es.quantidade) as quantidade,
            ep.estoque_minimo,
            ep.descricao as produto');
        $this->db->from('tb_estoque_produto ep');
        $this->db->join('tb_estoque_saldo es', 'es.produto_id = ep.estoque_produto_id', 'left');
        $this->db->join('tb_estoque_armazem ea', 'ea.estoque_armazem_id = es.armazem_id', 'left');
        $this->db->where('ep.ativo', 'true');
        $this->db->where('es.ativo', 'true');
        if ($_POST['armazem'] != "0") {
            $this->db->where('es.armazem_id', $_POST['armazem']);
        }
//        if ($_POST['empresa'] != "0") {
//            $this->db->where('ae.empresa_id', $_POST['empresa']);
//        }
        $this->db->groupby('ea.descricao, ep.descricao, ep.estoque_minimo');
        $this->db->orderby('ea.descricao, ep.descricao, ep.estoque_minimo');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriominimoarmazemcontador() {
        $this->db->select('ea.descricao as armazem,
            sum(es.quantidade) as quantidade,
            ep.estoque_minimo,
            ep.descricao as produto');
        $this->db->from('tb_estoque_produto ep');
        $this->db->join('tb_estoque_saldo es', 'es.produto_id = ep.estoque_produto_id', 'left');
        $this->db->join('tb_estoque_armazem ea', 'ea.estoque_armazem_id = es.armazem_id', 'left');
        $this->db->where('ep.ativo', 'true');
        $this->db->where('es.ativo', 'true');
        if ($_POST['armazem'] != "0") {
            $this->db->where('es.armazem_id', $_POST['armazem']);
        }
//        if ($_POST['empresa'] != "0") {
//            $this->db->where('ae.empresa_id', $_POST['empresa']);
//        }
        $return = $this->db->count_all_results();
        return $return;
    }

    function relatoriosaldo() {
        $this->db->select('ea.descricao as armazem,
            ef.fantasia,
            sum(es.quantidade) as quantidade,
            ep.descricao as produto');
        $this->db->from('tb_estoque_saldo es');
        $this->db->join('tb_estoque_armazem ea', 'ea.estoque_armazem_id = es.armazem_id', 'left');
        $this->db->join('tb_estoque_fornecedor ef', 'ef.estoque_fornecedor_id = es.fornecedor_id', 'left');
        $this->db->join('tb_estoque_produto ep', 'ep.estoque_produto_id = es.produto_id', 'left');
        $this->db->where('es.ativo', 'true');
        if ($_POST['armazem'] != "0") {
            $this->db->where('es.armazem_id', $_POST['armazem']);
        }
        if ($_POST['txtfornecedor'] != "0" && $_POST['txtfornecedor'] != "") {
            $this->db->where("es.fornecedor_id", $_POST['txtfornecedor']);
        }
        if ($_POST['txtproduto'] != "0" && $_POST['txtproduto'] != "") {
            $this->db->where("es.produto_id", $_POST['txtproduto']);
        }
//        if ($_POST['empresa'] != "0") {
//            $this->db->where('ae.empresa_id', $_POST['empresa']);
//        }
        $this->db->groupby('ea.descricao, ef.fantasia, ep.descricao');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriosaldocontador() {
        $this->db->select('ea.descricao as armazem,
            ef.fantasia,
            es.quantidade,
            ep.descricao as produto');
        $this->db->from('tb_estoque_saldo es');
        $this->db->join('tb_estoque_armazem ea', 'ea.estoque_armazem_id = es.armazem_id', 'left');
        $this->db->join('tb_estoque_fornecedor ef', 'ef.estoque_fornecedor_id = es.fornecedor_id', 'left');
        $this->db->join('tb_estoque_produto ep', 'ep.estoque_produto_id = es.produto_id', 'left');
        $this->db->where('es.ativo', 'true');
        if ($_POST['armazem'] != "0") {
            $this->db->where('es.armazem_id', $_POST['armazem']);
        }
        if ($_POST['txtfornecedor'] != "0" && $_POST['txtfornecedor'] != "") {
            $this->db->where("es.fornecedor_id", $_POST['txtfornecedor']);
        }
        if ($_POST['txtproduto'] != "0" && $_POST['txtproduto'] != "") {
            $this->db->where("es.produto_id", $_POST['txtproduto']);
        }
//        if ($_POST['empresa'] != "0") {
//            $this->db->where('ae.empresa_id', $_POST['empresa']);
//        }
        $return = $this->db->count_all_results();
        return $return;
    }

    function relatorioproduto() {
        $this->db->select('sc.descricao as subclasse,
            eu.descricao as unidade,
            ep.estoque_minimo,
            ep.valor_compra,
            ep.valor_venda,
            ep.descricao as produto');
        $this->db->from('tb_estoque_produto ep');
        $this->db->join('tb_estoque_sub_classe sc', 'sc.estoque_sub_classe_id = ep.sub_classe_id', 'left');
        $this->db->join('tb_estoque_classe ec', 'ec.estoque_classe_id = sc.classe_id', 'left');
        $this->db->join('tb_estoque_unidade eu', 'eu.estoque_unidade_id = ep.unidade_id', 'left');
        $this->db->where('ep.ativo', 'true');
        if ($_POST['tipo_id'] != "") {
            $this->db->where('ec.tipo_id', $_POST['tipo_id']);
        }
        if ($_POST['classe_id'] != "") {
            $this->db->where('sc.classe_id', $_POST['classe_id']);
        }
        if ($_POST['subclasse_id'] != "") {
            $this->db->where('sc.estoque_sub_classe_id', $_POST['subclasse_id']);
        }
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioprodutocontador() {
        $this->db->select('sc.descricao as subclasse,
            eu.descricao as unidade,
            ep.estoque_minimo,
            ep.valor_compra,
            ep.valor_venda,
            ep.descricao as produto');
        $this->db->from('tb_estoque_produto ep');
        $this->db->join('tb_estoque_sub_classe sc', 'sc.estoque_sub_classe_id = ep.sub_classe_id', 'left');
        $this->db->join('tb_estoque_unidade eu', 'eu.estoque_unidade_id = ep.unidade_id', 'left');
        $this->db->where('ep.ativo', 'true');
//        if ($_POST['empresa'] != "0") {
//            $this->db->where('ae.empresa_id', $_POST['empresa']);
//        }
        $return = $this->db->count_all_results();
        return $return;
    }

    function relatoriofornecedores() {
        $this->db->select('fantasia,
                            telefone,
                            celular,
                            logradouro,
                            numero,
                            bairro');
        $this->db->from('tb_estoque_fornecedor');
        $this->db->where('ativo', 'true');
//        if ($_POST['empresa'] != "0") {
//            $this->db->where('ae.empresa_id', $_POST['empresa']);
//        }
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriofornecedorescontador() {
        $this->db->select('fantasia,
                            telefone,
                            celular');
        $this->db->from('tb_estoque_fornecedor');
        $this->db->where('ativo', 'true');
//        if ($_POST['empresa'] != "0") {
//            $this->db->where('ae.empresa_id', $_POST['empresa']);
//        }
        $return = $this->db->count_all_results();
        return $return;
    }

    function relatorioentradaarmazem() {
        $datainicio = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $datafim = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $datahorainicio = $datainicio . ' 00:00:00';
        $datahorafim = $datafim . ' 23:59:59';
        $this->db->select('es.nota_fiscal,
            es.validade as data,
            ea.descricao as armazem,
            ef.fantasia,
            es.quantidade,
            es.valor_compra,
            ep.descricao as produto,
            u.descricao as unidade,
            es.data_atualizacao,
            es.data_cadastro');
        $this->db->from('tb_estoque_entrada es');
        $this->db->join('tb_estoque_armazem ea', 'ea.estoque_armazem_id = es.armazem_id', 'left');
        $this->db->join('tb_estoque_fornecedor ef', 'ef.estoque_fornecedor_id = es.fornecedor_id', 'left');
        $this->db->join('tb_estoque_produto ep', 'ep.estoque_produto_id = es.produto_id', 'left');
        $this->db->join('tb_estoque_unidade u', 'u.estoque_unidade_id = ep.unidade_id', 'left');
        $this->db->where("es.data_cadastro >=", $datahorainicio);
        $this->db->where("es.data_cadastro <=", $datahorafim);
        $this->db->where('es.ativo', 'true');
        if ($_POST['armazem'] != "0") {
            $this->db->where('es.armazem_id', $_POST['armazem']);
        }
        if ($_POST['txtfornecedor'] != "0" && $_POST['txtfornecedor'] != "") {
            $this->db->where("es.fornecedor_id", $_POST['txtfornecedor']);
        }
        if ($_POST['txtproduto'] != "0" && $_POST['txtproduto'] != "") {
            $this->db->where("es.produto_id", $_POST['txtproduto']);
        }
        $this->db->orderby('ea.descricao');
//        if ($_POST['empresa'] != "0") {
//            $this->db->where('ae.empresa_id', $_POST['empresa']);
//        }
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioentradaarmazemcontador() {
        $datainicio = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $datafim = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $datahorainicio = $datainicio . ' 00:00:00';
        $datahorafim = $datafim . ' 23:59:59';
        $this->db->select('es.nota_fiscal,
            es.validade,
            ea.descricao as armazem,
            ef.fantasia,
            es.quantidade,
            es.valor_compra,
            ep.descricao as produto');
        $this->db->from('tb_estoque_entrada es');
        $this->db->join('tb_estoque_armazem ea', 'ea.estoque_armazem_id = es.armazem_id', 'left');
        $this->db->join('tb_estoque_fornecedor ef', 'ef.estoque_fornecedor_id = es.fornecedor_id', 'left');
        $this->db->join('tb_estoque_produto ep', 'ep.estoque_produto_id = es.produto_id', 'left');
        $this->db->where("es.data_cadastro >=", $datahorainicio);
        $this->db->where("es.data_cadastro <=", $datahorafim);
        $this->db->where('es.ativo', 'true');
        if ($_POST['armazem'] != "0") {
            $this->db->where('es.armazem_id', $_POST['armazem']);
        }
        if ($_POST['txtfornecedor'] != "0" && $_POST['txtfornecedor'] != "") {
            $this->db->where("es.fornecedor_id", $_POST['txtfornecedor']);
        }
        if ($_POST['txtproduto'] != "0" && $_POST['txtproduto'] != "") {
            $this->db->where("es.produto_id", $_POST['txtproduto']);
        }
//        if ($_POST['empresa'] != "0") {
//            $this->db->where('ae.empresa_id', $_POST['empresa']);
//        }
        $return = $this->db->count_all_results();
        return $return;
    }

    function relatoriosaidaarmazem() {
        $datainicio = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $datafim = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $datahorainicio = $datainicio . ' 00:00:00';
        $datahorafim = $datafim . ' 23:59:59';
        $this->db->select('es.nota_fiscal,
            es.validade as data,
            ea.descricao as armazem,
            ef.fantasia,
            es.quantidade,
            es.data_cadastro,
            ec.nome,
            es.valor_venda,
            ep.descricao as produto,
            u.descricao as unidade,
            e.data_atualizacao,
            e.data_cadastro data_entrada');
        $this->db->from('tb_estoque_saida es');
        $this->db->join('tb_estoque_armazem ea', 'ea.estoque_armazem_id = es.armazem_id', 'left');
        $this->db->join('tb_estoque_fornecedor ef', 'ef.estoque_fornecedor_id = es.fornecedor_id', 'left');
        $this->db->join('tb_estoque_produto ep', 'ep.estoque_produto_id = es.produto_id', 'left');
        $this->db->join('tb_estoque_solicitacao_itens esi', 'esi.estoque_solicitacao_itens_id = es.estoque_solicitacao_itens_id', 'left');
        $this->db->join('tb_estoque_solicitacao_cliente sc', 'sc.estoque_solicitacao_setor_id = esi.solicitacao_cliente_id', 'left');
        $this->db->join('tb_estoque_cliente ec', 'ec.estoque_cliente_id = sc.cliente_id', 'left');
        $this->db->join('tb_estoque_unidade u', 'u.estoque_unidade_id = ep.unidade_id', 'left');
        $this->db->join('tb_estoque_entrada e', 'e.estoque_entrada_id = es.estoque_entrada_id', 'left');
        $this->db->where("es.data_cadastro >=", $datahorainicio);
        $this->db->where("es.data_cadastro <=", $datahorafim);
        $this->db->where('es.ativo', 'true');
        if ($_POST['armazem'] != "0") {
            $this->db->where('es.armazem_id', $_POST['armazem']);
        }
        if ($_POST['setor'] != "0") {
            $this->db->where('ec.estoque_cliente_id', $_POST['setor']);
        }
        if ($_POST['txtfornecedor'] != "0" && $_POST['txtfornecedor'] != "") {
            $this->db->where("es.fornecedor_id", $_POST['txtfornecedor']);
        }
        if ($_POST['txtproduto'] != "0" && $_POST['txtproduto'] != "") {
            $this->db->where("es.produto_id", $_POST['txtproduto']);
        }
        $this->db->orderby('ea.descricao');
//        if ($_POST['empresa'] != "0") {
//            $this->db->where('ae.empresa_id', $_POST['empresa']);
//        }
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriosaidaarmazemcontador() {
        $datainicio = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $datafim = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $datahorainicio = $datainicio . ' 00:00:00';
        $datahorafim = $datafim . ' 23:59:59';
        $this->db->select('es.nota_fiscal,
            es.validade as data,
            ea.descricao as armazem,
            ef.fantasia,
            es.quantidade,
            ec.nome,
            es.valor_venda,
            ep.descricao as produto');
        $this->db->from('tb_estoque_saida es');
        $this->db->join('tb_estoque_armazem ea', 'ea.estoque_armazem_id = es.armazem_id', 'left');
        $this->db->join('tb_estoque_fornecedor ef', 'ef.estoque_fornecedor_id = es.fornecedor_id', 'left');
        $this->db->join('tb_estoque_produto ep', 'ep.estoque_produto_id = es.produto_id', 'left');
        $this->db->join('tb_estoque_solicitacao_itens esi', 'esi.estoque_solicitacao_itens_id = es.estoque_solicitacao_itens_id', 'left');
        $this->db->join('tb_estoque_cliente ec', 'ec.estoque_cliente_id = esi.solicitacao_cliente_id', 'left');
        $this->db->where("es.data_cadastro >=", $datahorainicio);
        $this->db->where("es.data_cadastro <=", $datahorafim);
        $this->db->where('es.ativo', 'true');
        if ($_POST['armazem'] != "0") {
            $this->db->where('es.armazem_id', $_POST['armazem']);
        }
        if ($_POST['txtfornecedor'] != "0" && $_POST['txtfornecedor'] != "") {
            $this->db->where("es.fornecedor_id", $_POST['txtfornecedor']);
        }
        if ($_POST['txtproduto'] != "0" && $_POST['txtproduto'] != "") {
            $this->db->where("es.produto_id", $_POST['txtproduto']);
        }
//        if ($_POST['empresa'] != "0") {
//            $this->db->where('ae.empresa_id', $_POST['empresa']);
//        }
        $return = $this->db->count_all_results();
        return $return;
    }

    function excluir($estoque_entrada_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('estoque_entrada_id', $estoque_entrada_id);
        $this->db->update('tb_estoque_entrada');

        //atualizando tabela estoque_saldo
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('estoque_entrada_id', $estoque_entrada_id);
        $this->db->update('tb_estoque_saldo');

        //atualizando tabela estoque_saida
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('estoque_entrada_id', $estoque_entrada_id);
        $this->db->update('tb_estoque_saida');


        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function gravarentradaxml($dados) {
        try {
            /* inicia o mapeamento no banco */
            //atualiza com o ultimo valor de compra
            $qtde = str_replace(",", ".", str_replace(".", "", $dados['quantidade']));
            $vlr = str_replace(",", ".", str_replace(".", "", $dados['compra']));
            $this->db->set('valor_compra', $vlr / $qtde);
            $this->db->where('estoque_produto_id', $dados['txtproduto']);
            $this->db->update('tb_estoque_produto');
            
            $this->db->set('produto_id', $dados['txtproduto']);
            $this->db->set('fornecedor_id', $dados['txtfornecedor']);
            $this->db->set('armazem_id', $dados['txtarmazem']);
            $this->db->set('valor_compra', str_replace(",", ".", str_replace(".", "", $dados['compra'])));
            $this->db->set('quantidade', str_replace(",", ".", str_replace(".", "", $dados['quantidade'])));
            $this->db->set('nota_fiscal', str_replace(",", ".", str_replace(".", "", $dados['nota'])));
            $this->db->set('lote', $dados['lote']);
            $this->db->set('codigo_cfop', str_replace('.', '', $dados['cfop']));

            if ($dados['validade'] != "//") {
                $this->db->set('validade', $dados['validade']);
            }

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_estoque_entrada');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
                $estoque_entrada_id = $this->db->insert_id();

            $this->db->set('estoque_entrada_id', $estoque_entrada_id);
            $this->db->set('produto_id', $dados['txtproduto']);
            $this->db->set('fornecedor_id', $dados['txtfornecedor']);
            $this->db->set('armazem_id', $dados['txtarmazem']);
            $this->db->set('valor_compra', str_replace(",", ".", str_replace(".", "", $dados['compra'])));
            $this->db->set('quantidade', str_replace(",", ".", str_replace(".", "", $dados['quantidade'])));
            $this->db->set('nota_fiscal', str_replace(",", ".", str_replace(".", "", $dados['nota'])));
            if ($dados['validade'] != "//") {
                $this->db->set('validade', $dados['validade']);
            }
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_estoque_saldo');

            return $estoque_entrada_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarfracionamento() {
        try {
            
            $qtde_fracionamento = str_replace(",", ".", str_replace(".", "", $_POST['qtde_fracionamento']));
            $novoValorEntrada = ($_POST['compra'] / $_POST['qtde_entrada']) * ($_POST['qtde_entrada'] - $qtde_fracionamento);
            $novaQtdeEntrada = ($_POST['qtde_entrada'] - $qtde_fracionamento);
            $estoque_entrada_id = $_POST['txtestoque_entrada_id'];
            
            /* inicia o mapeamento no banco */
            $this->db->set('produto_id', $_POST['txtprodutoentrada_id']);
            $this->db->set('fornecedor_id', $_POST['txtfornecedor']);
            $this->db->set('armazem_id', $_POST['txtarmazem']);
            $this->db->set('valor_compra', $novoValorEntrada);
            $this->db->set('quantidade', $novaQtdeEntrada);
            $this->db->set('nota_fiscal', $_POST['nota']);
            $this->db->set('lote', $_POST['lote']);
            $this->db->set('codigo_cfop', $_POST['cfop']);

            if ($_POST['validade'] != "//") {
                $this->db->set('validade', $_POST['validade']);
            }

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('estoque_entrada_id', $estoque_entrada_id);
            $this->db->update('tb_estoque_entrada');
            
            $this->db->set('produto_id', $_POST['txtprodutoentrada_id']);
            $this->db->set('fornecedor_id', $_POST['txtfornecedor']);
            $this->db->set('armazem_id', $_POST['txtarmazem']);
            $this->db->set('valor_compra', $novoValorEntrada);
            $this->db->set('quantidade', $novaQtdeEntrada);
            $this->db->set('nota_fiscal', $_POST['nota']);
            if ($_POST['validade'] != "//") {
                $this->db->set('validade', $_POST['validade']);
            }
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->where('estoque_entrada_id', $estoque_entrada_id);
            $this->db->update('tb_estoque_saldo');
            
            
            
            /* DANDO ENTRADA NOS PRODUTOS FRACIONADOS */
            $qtde_resultante = str_replace(",", ".", str_replace(".", "", $_POST['qtde_resultante']));
            $valorFracionamento = $_POST['compra'] - $novoValorEntrada;
//            echo "<pre>";
//            var_dump($novoValorEntrada, $valorFracionamento); die;
            
            $this->db->set('fracionamento_entrada_id', $estoque_entrada_id);
            $this->db->set('produto_id', $_POST['txtprodutofrac']);
            $this->db->set('fornecedor_id', $_POST['txtfornecedor']);
            $this->db->set('armazem_id', $_POST['txtarmazem']);
            $this->db->set('valor_compra', $valorFracionamento);
            $this->db->set('quantidade', $qtde_resultante);
            $this->db->set('nota_fiscal', $_POST['nota']);
            $this->db->set('lote', $_POST['lote']);
            $this->db->set('codigo_cfop', $_POST['cfop']);
            if ($_POST['validade'] != "//") {
                $this->db->set('validade', $_POST['validade']);
            }
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_estoque_entrada');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
                $estoque_fracionamento_id = $this->db->insert_id();
            
            
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);

            $this->db->set('estoque_entrada_id', $estoque_fracionamento_id);
            $this->db->set('produto_id', $_POST['txtprodutofrac']);
            $this->db->set('fornecedor_id', $_POST['txtfornecedor']);
            $this->db->set('armazem_id', $_POST['txtarmazem']);
            $this->db->set('valor_compra', $valorFracionamento);
            $this->db->set('quantidade', $qtde_resultante);
            $this->db->set('nota_fiscal', $_POST['nota']);
            if ($_POST['validade'] != "//") {
                $this->db->set('validade', $_POST['validade']);
            }
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_estoque_saldo');
            
            return $estoque_fracionamento_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravar() {
        try {
            /* inicia o mapeamento no banco */
            //atualiza com o ultimo valor de compra
            $qtde = str_replace(",", ".", str_replace(".", "", $_POST['quantidade']));
            $vlr = str_replace(",", ".", str_replace(".", "", $_POST['compra']));
            $this->db->set('valor_compra', $vlr / $qtde);
            $this->db->where('estoque_produto_id', $_POST['txtproduto']);
            $this->db->update('tb_estoque_produto');

            $estoque_entrada_id = $_POST['txtestoque_entrada_id'];
            $this->db->set('produto_id', $_POST['txtproduto']);
            $this->db->set('fornecedor_id', $_POST['txtfornecedor']);
            $this->db->set('armazem_id', $_POST['txtarmazem']);
            $this->db->set('valor_compra', str_replace(",", ".", str_replace(".", "", $_POST['compra'])));
            $this->db->set('quantidade', str_replace(",", ".", str_replace(".", "", $_POST['quantidade'])));
            $this->db->set('nota_fiscal', str_replace(",", ".", str_replace(".", "", $_POST['nota'])));
            $this->db->set('lote', $_POST['lote']);
            $this->db->set('codigo_cfop', str_replace('.', '', $_POST['cfop']));

            if ($_POST['validade'] != "//") {
                $this->db->set('validade', $_POST['validade']);
            }

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['txtestoque_entrada_id'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_estoque_entrada');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $estoque_entrada_id = $this->db->insert_id();

                $this->db->set('estoque_entrada_id', $estoque_entrada_id);
                $this->db->set('produto_id', $_POST['txtproduto']);
                $this->db->set('fornecedor_id', $_POST['txtfornecedor']);
                $this->db->set('armazem_id', $_POST['txtarmazem']);
                $this->db->set('valor_compra', str_replace(",", ".", str_replace(".", "", $_POST['compra'])));
                $this->db->set('quantidade', str_replace(",", ".", str_replace(".", "", $_POST['quantidade'])));
                $this->db->set('nota_fiscal', str_replace(",", ".", str_replace(".", "", $_POST['nota'])));
                if ($_POST['validade'] != "//") {
                    $this->db->set('validade', $_POST['validade']);
                }
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_estoque_saldo');
            } else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('estoque_entrada_id', $estoque_entrada_id);
                $this->db->update('tb_estoque_entrada');

                $this->db->set('estoque_entrada_id', $estoque_entrada_id);
                $this->db->set('produto_id', $_POST['txtproduto']);
                $this->db->set('fornecedor_id', $_POST['txtfornecedor']);
                $this->db->set('armazem_id', $_POST['txtarmazem']);
                $this->db->set('valor_compra', str_replace(",", ".", str_replace(".", "", $_POST['compra'])));
                $this->db->set('quantidade', str_replace(",", ".", str_replace(".", "", $_POST['quantidade'])));
                $this->db->set('nota_fiscal', str_replace(",", ".", str_replace(".", "", $_POST['nota'])));
                if ($_POST['validade'] != "//") {
                    $this->db->set('validade', $_POST['validade']);
                }
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->where('estoque_entrada_id', $estoque_entrada_id);
                $this->db->update('tb_estoque_saldo');
            }
            return $estoque_entrada_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    private function instanciar($estoque_entrada_id) {
        if ($estoque_entrada_id != 0) {
            $this->db->select('e.estoque_entrada_id,
                               e.produto_id,
                               p.descricao as produto,
                               e.armazem_id,
                               a.descricao as armazem,
                               e.fornecedor_id,
                               f.razao_social as fornecedor,
                               e.quantidade,
                               e.valor_compra,
                               e.validade,
                               e.nota_fiscal,
                               e.lote,
                               e.codigo_cfop');
            $this->db->from('tb_estoque_entrada e');
            $this->db->join('tb_estoque_armazem a', 'a.estoque_armazem_id = e.armazem_id', 'left');
            $this->db->join('tb_estoque_fornecedor f', 'f.estoque_fornecedor_id = e.fornecedor_id', 'left');
            $this->db->join('tb_estoque_produto p', 'p.estoque_produto_id = e.produto_id', 'left');
            $this->db->where("e.estoque_entrada_id", $estoque_entrada_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_estoque_entrada_id = $estoque_entrada_id;
            $this->_produto_id = $return[0]->produto_id;
            $this->_produto = $return[0]->produto;
            $this->_fornecedor_id = $return[0]->fornecedor_id;
            $this->_fornecedor = $return[0]->fornecedor;
            $this->_armazem_id = $return[0]->armazem_id;
            $this->_armazem = $return[0]->armazem;
            $this->_nota_fiscal = $return[0]->nota_fiscal;
            $this->_quantidade = $return[0]->quantidade;
            $this->_valor_compra = $return[0]->valor_compra;
            $this->_validade = $return[0]->validade;
            $this->_codigo_cfop = $return[0]->codigo_cfop;
            $this->_lote = $return[0]->lote;
        } else {
            $this->_estoque_entrada_id = null;
        }
    }

}

?>
