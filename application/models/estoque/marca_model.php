<?php

class marca_model extends Model {

    var $_estoque_marca_id = null;
    var $_descricao = null;

    function Marca_model($estoque_produto_id = null) {
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
        $this->db->select(' et.estoque_marca_id,
                            et.descricao');
        $this->db->from('tb_estoque_marca et');
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

    function autocompletemarca($parametro) {
        $this->db->select('estoque_marca_id,
                            descricao');
        $this->db->from('tb_estoque_marca');
        $this->db->where('ativo', 'true');
        if ($parametro != null) {
            $this->db->where('descricao ilike', $parametro . "%");
        }
        $return = $this->db->get();
        return $return->result();
    }

    function autocompleteentregador($parametro) {
        $this->db->select('entregador_id,
                            nome,
                            sexo,
                            telefone');
        $this->db->from('tb_entregador');
        $this->db->where('ativo', 'true');
        if ($parametro != null) {
            $this->db->where('nome ilike', $parametro . "%");
        }
        $return = $this->db->get();
        return $return->result();
    }

    function excluir($estoque_marca_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('estoque_marca_id', $estoque_marca_id);
        $this->db->update('tb_estoque_marca');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function gravar() {
        try {
            /* inicia o mapeamento no banco */
            $estoque_marca_id = $_POST['txtestoquemarcaid'];
            $this->db->set('descricao', $_POST['nome']);
            
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['txtestoquemarcaid'] == "" OR $_POST['txtestoquemarcaid'] == 0) {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_estoque_marca');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $estoque_marca_id = $this->db->insert_id();
            }
            else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $exame_cliente_id = $_POST['txtestoquemarcaid'];
                $this->db->where('estoque_marca_id', $estoque_marca_id);
                $this->db->update('tb_estoque_marca');
            }
            return $estoque_marca_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    private function instanciar($estoque_marca_id) {
        if ($estoque_marca_id != 0) {
            $this->db->select('estoque_marca_id, 
                               descricao');
            $this->db->from('tb_estoque_marca et');
            $this->db->where("estoque_marca_id", $estoque_marca_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_estoque_marca_id = $estoque_marca_id;
            $this->_descricao = $return[0]->descricao;
        } else {
            $this->_estoque_marca_id = null;
        }
    }

}

?>
