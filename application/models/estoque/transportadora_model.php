<?php

class transportadora_model extends Model {

    var $_estoque_transportadora_id = null;
    var $_descricao = null;

    function Transportadora_model($estoque_produto_id = null) {
        parent::Model();
        if (isset($estoque_produto_id)) {
            $this->instanciar($estoque_produto_id);
        }
    }

    function autocompleteproduto($parametro = null) {
        $this->db->select('estoque_produto_id,
                           descricao');
        if ($parametro != null) {
            $this->db->where('descricao ilike', $parametro . "%");
        }
        $this->db->from('tb_estoque_produto');
        $return = $this->db->get();
        return $return->result();
    }

    function listar($args = array()) {
        $this->db->select(' et.estoque_transportadora_id,
                            et.descricao');
        $this->db->from('tb_estoque_transportadora et');
        $this->db->where('et.ativo', 'true');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('et.descricao ilike', "%" . $args['nome'] . "%");
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

    function listarunidade() {
        $this->db->select('estoque_unidade_id,
                            descricao');
        $this->db->from('tb_estoque_unidade');
        $this->db->where('ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function autocompletetransportadora($parametro) {
        $this->db->select('estoque_transportadora_id,
                            descricao');
        $this->db->from('tb_estoque_transportadora');
        $this->db->where('ativo', 'true');
        if ($parametro != null) {
            $this->db->where('descricao ilike', $parametro . "%");
        }
        $return = $this->db->get();
        return $return->result();
    }

    function excluir($estoque_transportadora_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('estoque_transportadora_id', $estoque_transportadora_id);
        $this->db->update('tb_estoque_transportadora');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function gravar() {
        try {
            /* inicia o mapeamento no banco */
            $estoque_transportadora_id = $_POST['txtestoquetransportadoraid'];
            $this->db->set('descricao', $_POST['nome']);
            if ($_POST['txtestoquetransportadoraid'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_estoque_transportadora');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $estoque_produto_id = $this->db->insert_id();
            }
            else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('estoque_transportadora_id', $estoque_transportadora_id);
                $this->db->update('tb_estoque_transportadora');
            }
            return $estoque_produto_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    private function instanciar($estoque_transportadora_id) {
        if ($estoque_transportadora_id != 0) {
            $this->db->select('et.estoque_transportadora_id,
                               et.descricao');
            $this->db->from('tb_estoque_transportadora et');
            $this->db->where("estoque_transportadora_id", $estoque_transportadora_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_estoque_transportadora_id = $estoque_transportadora_id;
            $this->_descricao = $return[0]->descricao;
        } else {
            $this->_estoque_transportadora_id = null;
        }
    }

}

?>
