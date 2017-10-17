<?php

class produto_model extends Model {

    var $_estoque_produto_id = null;
    var $_descricao = null;
    var $_unidade_id = null;
    var $_unidade = null;
    var $_codigo = null;
    var $_ncm = null;
    var $_ncm_descricao = null;
    var $_cest = null;
    var $_ipi = null;
    var $_sub_classe_id = null;
    var $_sub_classe = null;
    var $_valor_compra = null;
    var $_valor_venda = null;
    var $_estoque_minimo = null;

    function Produto_model($estoque_produto_id = null) {
        parent::Model();
        if (isset($estoque_produto_id)) {
            $this->instanciar($estoque_produto_id);
        }
    }

    function autocompleteproduto($parametro = null) {
        $this->db->select('p.estoque_produto_id,
                           p.descricao,
                           p.codigo,
                           u.descricao as unidade');
        $this->db->from('tb_estoque_produto p');
        $this->db->join('tb_estoque_unidade u', 'u.estoque_unidade_id = p.unidade_id', 'left');
        if ($parametro != null) {
            $this->db->where("(p.descricao ilike '$parametro%' OR p.codigo ilike '$parametro%')");
        }
        $return = $this->db->get();
        return $return->result();
    }

    function listar($args = array()) {
        $this->db->select('p.estoque_produto_id,
                            p.descricao,
                            p.codigo,
                            p.unidade_id,
                            u.descricao as unidade,
                            p.sub_classe_id,
                            sc.descricao as sub_classe,
                            ec.descricao as classe,
                            em.descricao as marca,
                            p.valor_compra');
        $this->db->from('tb_estoque_produto p');
        $this->db->join('tb_estoque_sub_classe sc', 'sc.estoque_sub_classe_id = p.sub_classe_id', 'left');
        $this->db->join('tb_estoque_classe ec', 'ec.estoque_classe_id = sc.classe_id', 'left');
        $this->db->join('tb_estoque_unidade u', 'u.estoque_unidade_id = p.unidade_id', 'left');
        $this->db->join('tb_estoque_marca em', 'em.estoque_marca_id = p.marca_id', 'left');
        $this->db->where('p.ativo', 'true');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('p.descricao ilike', "%" . $args['nome'] . "%");
        }
        if (isset($args['codigo']) && strlen($args['codigo']) > 0) {
            $this->db->where('p.codigo ilike', "%".$args['codigo']."%");
        }
        if (isset($args['subclasse_id']) && strlen($args['subclasse_id']) > 0) {
            $this->db->where('sc.estoque_sub_classe_id', $args['subclasse_id']);
        }
        if (isset($args['classe_id']) && strlen($args['classe_id']) > 0) {
            $this->db->where('sc.classe_id', $args['classe_id']);
        }
        if (isset($args['tipo_id']) && strlen($args['tipo_id']) > 0) {
            $this->db->where('ec.tipo_id', $args['tipo_id']);
        }
        if (isset($args['marca_id']) && strlen($args['marca_id']) > 0) {
            $this->db->where('p.marca_id', $args['marca_id']);
        }
        return $this->db;
    }

    function listarmarca() {
        $this->db->select('em.estoque_marca_id,
                           em.descricao');
        $this->db->from('tb_estoque_marca em');
        $this->db->where('em.ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function listarsub() {
        $this->db->select('sc.estoque_sub_classe_id,
                            sc.descricao,
                            sc.classe_id');
        $this->db->from('tb_estoque_sub_classe sc');
        $this->db->where('sc.ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function listarclasse() {
        $this->db->select('ec.estoque_classe_id,
                            ec.descricao,
                            ec.tipo_id');
        $this->db->from('tb_estoque_classe ec');
//        $this->db->join('tb_estoque_classe ec', 'ec.estoque_classe_id = sc.classe_id', 'left');
        $this->db->where('ec.ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function listartipo() {
        $this->db->select('et.estoque_tipo_id,
                            et.descricao');
        $this->db->from('tb_estoque_tipo et');
//        $this->db->join('tb_estoque_classe ec', 'ec.estoque_classe_id = sc.classe_id', 'left');
        $this->db->where('et.ativo', 'true');
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
    
    function autocompleteestoquepedidolote($produto_id) {
        
        $this->db->select(' ee.validade,
                            ee.estoque_entrada_id,
                            ee.lote,
                            sum(ep.quantidade) as total');
        $this->db->from('tb_estoque_saldo ep');
        $this->db->join('tb_estoque_produto p', 'p.estoque_produto_id = ep.produto_id');
        $this->db->join('tb_estoque_armazem ea', 'ea.estoque_armazem_id = ep.armazem_id');
        $this->db->join('tb_estoque_entrada ee', 'ee.estoque_entrada_id = ep.estoque_entrada_id');
        $this->db->where('p.estoque_produto_id', $produto_id);
        $this->db->where('ep.ativo', 'true');
        
        $this->db->groupby('ee.validade, ee.lote, ee.estoque_entrada_id');
        
        $this->db->orderby('ee.validade');
        $return = $this->db->get();
        return $return->result();
        
    }

    function excluir($estoque_produto_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('estoque_produto_id', $estoque_produto_id);
        $this->db->update('tb_estoque_produto');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function gravar() {
        try {
            /* inicia o mapeamento no banco */
            $estoque_produto_id = $_POST['txtestoqueprodutoid'];
            $this->db->set('descricao', $_POST['nome']);
            $this->db->set('ipi', str_replace(",", ".", str_replace(".", "", $_POST['ipi'])));
            $this->db->set('valor_compra', str_replace(",", ".", str_replace(".", "", $_POST['compra'])));
            $this->db->set('valor_venda', str_replace(",", ".", str_replace(".", "", $_POST['venda'])));
            $this->db->set('estoque_minimo', $_POST['minimo']);
            $this->db->set('unidade_id', $_POST['unidade']);
            $this->db->set('sub_classe_id', $_POST['sub']);
            if($_POST['marca'] != ''){
                $this->db->set('marca_id', $_POST['marca']);
            }
            if($_POST['codigo'] != ''){
                $this->db->set('codigo', $_POST['codigo']);
            }
            if($_POST['ncm'] != ''){
                $this->db->set('ncm', $this->utilitario->remover_caracter($_POST['ncm']));
            }
            if($_POST['cest'] != ''){
                $this->db->set('cest', $this->utilitario->remover_caracter($_POST['cest']));
            }
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['txtestoqueprodutoid'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_estoque_produto');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $estoque_produto_id = $this->db->insert_id();
            }
            else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('estoque_produto_id', $estoque_produto_id);
                $this->db->update('tb_estoque_produto');
            }
            return $estoque_produto_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    private function instanciar($estoque_produto_id) {
        if ($estoque_produto_id != 0) {
            $this->db->select('p.estoque_produto_id,
                            p.descricao,
                            p.unidade_id,
                            u.descricao as unidade,
                            p.sub_classe_id,
                            p.codigo,
                            p.ncm,
                            n.descricao_ncm,
                            p.cest,
                            p.ipi,
                            p.marca_id,
                            sc.descricao as sub_classe,
                            p.valor_compra,
                            p.valor_venda,
                            p.estoque_minimo');
            $this->db->from('tb_estoque_produto p');
            $this->db->join('tb_estoque_sub_classe sc', 'sc.estoque_sub_classe_id = p.sub_classe_id', 'left');
//            $this->db->join('tb_estoque_marca em', 'em.estoque_marca_id = p.marca_id', 'left');
            $this->db->join('tb_ncm n', 'n.codigo_ncm = p.ncm', 'left');
            $this->db->join('tb_estoque_unidade u', 'u.estoque_unidade_id = p.unidade_id', 'left');
            $this->db->where("estoque_produto_id", $estoque_produto_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_estoque_produto_id = $estoque_produto_id;
            $this->_descricao = $return[0]->descricao;
            $this->_unidade_id = $return[0]->unidade_id;
            $this->_unidade = $return[0]->unidade;
            $this->_codigo = $return[0]->codigo;
            $this->_ncm = $return[0]->ncm;
            $this->_ncm_descricao = $return[0]->descricao_ncm;
            $this->_ipi = $return[0]->ipi;
            $this->_cest = $return[0]->cest;
            $this->_sub_classe_id = $return[0]->sub_classe_id;
            $this->_sub_classe = $return[0]->sub_classe;
            $this->_valor_compra = $return[0]->valor_compra;
            $this->_valor_venda = $return[0]->valor_venda;
            $this->_estoque_minimo = $return[0]->estoque_minimo;
            $this->_marca_id = $return[0]->marca_id;
//            var_dump($return[0]->ncm); die;
        } else {
            $this->_estoque_produto_id = null;
        }
    }

}

?>
