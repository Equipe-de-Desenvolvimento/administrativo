<?php

class transportadora_model extends Model {

    var $_estoque_transportadora_id = null;
    var $_descricao = null;
    var $_cnpj = null;
    var $_cep = null;
    var $_logradouro = null;
    var $_numero = null;
    var $_complemento = null;
    var $_bairro = null;
    var $_municipio_id = null;
    var $_municipio_nome = null;
    var $_inscricao_estadual = null;
    var $_celular = null;
    var $_telefone = null;
    var $_email = null;
    var $_razao_social = null;
    var $_tipo_logradouro_id = null;
    var $_menu_id = null;
    var $_sala_id = null;
    var $_saida = null;
    var $_credor_devedor_id = null;

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
            $this->db->set('telefone', $_POST['telefone']);
            $this->db->set('celular', str_replace("(", "", str_replace(")", "", str_replace("-", "", $_POST['celular']))));
            $this->db->set('razao_social', $_POST['txtrazaosocial']);
            $this->db->set('cep', $_POST['txtCep']);
            $this->db->set('logradouro', $_POST['endereco']);
            $this->db->set('numero', $_POST['numero']);
            $this->db->set('bairro', $_POST['bairro']);
            $this->db->set('complemento', $_POST['complemento']);
            $this->db->set('email', $_POST['email']);
            if ($_POST['txtCNPJ'] != '') {
                $this->db->set('cnpj', str_replace("/", "", str_replace(".", "", $_POST['txtCNPJ'])));
            }

            if ($_POST['municipio_id'] != '') {
                $this->db->set('municipio_id', $_POST['municipio_id']);
            }
            if ($_POST['txttipo_id'] != '') {
                $this->db->set('tipo_logradouro_id', $_POST['txttipo_id']);
            }
            if ($_POST['inscricaoestadual'] != '') {
                $this->db->set('inscricao_estadual', $_POST['inscricaoestadual']);
            }

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['txtestoqueclienteid'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_estoque_transportadora');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $estoque_transportadora_id = $this->db->insert_id();
            }
            else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $exame_cliente_id = $_POST['txtestoqueclienteid'];
                $this->db->where('estoque_cliente_id', $estoque_transportadora_id);
                $this->db->update('tb_estoque_transportadora');
            }
            return $estoque_transportadora_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    private function instanciar($estoque_transportadora_id) {
        if ($estoque_transportadora_id != 0) {
            $this->db->select('estoque_transportadora_id, 
                               descricao, 
                               cnpj, 
                               cep, 
                               logradouro, 
                               numero, 
                               complemento, 
                               bairro, 
                               et.municipio_id, 
                               celular, 
                               telefone, 
                               ativo,
                               menu_id, 
                               sala_id, 
                               razao_social, 
                               saida, 
                               tipo_logradouro_id, 
                               inscricao_estadual, 
                               email, 
                               credor_devedor_id,
                               m.nome as municipio_nome');
            $this->db->from('tb_estoque_transportadora et');
            $this->db->join('tb_municipio m', 'm.municipio_id = et.municipio_id', 'left');
            $this->db->where("estoque_transportadora_id", $estoque_transportadora_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_estoque_transportadora_id = $estoque_transportadora_id;
            $this->_descricao = $return[0]->descricao;
            $this->_telefone = $return[0]->telefone;
            $this->_cnpj = $return[0]->cnpj;
            $this->_cep = $return[0]->cep;
            $this->_bairro = $return[0]->bairro;
            $this->_logradouro = $return[0]->logradouro;
            $this->_inscricao_estadual = $return[0]->inscricao_estadual;
            $this->_numero = $return[0]->numero;
            $this->_complemento = $return[0]->complemento;
            $this->_municipio_id = $return[0]->municipio_id;
            $this->_municipio_nome = $return[0]->municipio_nome;
            $this->_tipo_logradouro_id = $return[0]->tipo_logradouro_id;
            $this->_celular = $return[0]->celular;
            $this->_email = $return[0]->email;
            $this->_razao_social = $return[0]->razao_social;
            $this->_menu_id = $return[0]->menu_id;
            $this->_sala_id = $return[0]->sala_id;
            $this->_saida = $return[0]->saida;
            $this->_credor_devedor_id = $return[0]->credor_devedor_id;
        } else {
            $this->_estoque_transportadora_id = null;
        }
    }

}

?>
