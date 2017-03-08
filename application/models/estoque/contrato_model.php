<?php

class contrato_model extends Model {

    var $_estoque_contrato_id = null;
    var $_nome = null;
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

    function Contrato_model($estoque_contrato_id = null) {
        parent::Model();
        if (isset($estoque_contrato_id)) {
            $this->instanciar($estoque_contrato_id);
        }
    }

    function listarunidade($args = array()) {
        $this->db->select('estoque_unidade_vigencia_id as unidade_id,
                            descricao');
        $this->db->from('tb_estoque_unidade_vigencia');
        $this->db->where('ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function listar($args = array()) {
        $this->db->select('ect.estoque_contrato_id,
                           ect.nome as contrato, 
                           ect.numero_contrato,
                           ect.data_inicio,
                           ect.data_fim,
                           ect.valor_inicial,
                           tc.descricao as tipo,
                           ec.razao_social as credor_devedor');
        $this->db->from('tb_estoque_contrato ect');
        $this->db->where('ect.ativo', 'true');
        $this->db->join('tb_financeiro_credor_devedor ec', 'ec.financeiro_credor_devedor_id = ect.credor_devedor_id', 'left');
        $this->db->join('tb_estoque_tipo_contrato tc', 'tc.estoque_tipo_contrato_id = ect.tipo_contrato_id', 'left');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('ect.nome ilike', "%" . $args['nome'] . "%");
        }
        return $this->db;
    }

    function listarmenu() {
        $this->db->select('estoque_menu_id,
                            descricao');
        $this->db->from('tb_estoque_menu');
        $this->db->where('ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function listarclientes() {
        $this->db->select('estoque_cliente_id,
                            nome');
        $this->db->from('tb_estoque_cliente');
        $this->db->where('ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function listardescricaopagamento() {
        $this->db->select('fp.descricao_forma_pagamento_id,
                            fp.nome as nome');
        $this->db->from('tb_descricao_forma_pagamento fp');
//        $this->db->join('tb_grupo_formapagamento gf', 'gf.grupo_id = pp.grupo_pagamento_id', 'left');
//        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = gf.forma_pagamento_id', 'left');
        $this->db->where('ativo', 't');
        $this->db->orderby('fp.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function listarformapagamento() {
        $this->db->select('fp.forma_pagamento_id,
                            fp.nome as nome');
        $this->db->from('tb_forma_pagamento fp');
//        $this->db->join('tb_grupo_formapagamento gf', 'gf.grupo_id = pp.grupo_pagamento_id', 'left');
//        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = gf.forma_pagamento_id', 'left');
        $this->db->where('ativo', 't');
        $this->db->orderby('fp.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function listartipocontrato($args = array()) {
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('estoque_tipo_contrato_id as tipo_id,
                            descricao');
        $this->db->from('tb_estoque_tipo_contrato');
        $this->db->where('ativo', 'true');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('descricao ilike', "%" . $args['nome'] . "%");
        }
        return $this->db;
    }

    function listartipos() {
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('estoque_tipo_contrato_id as tipo_id,
                            descricao');
        $this->db->from('tb_estoque_tipo_contrato');
        $this->db->where('ativo', 'true');
//        $this->db->where('empresa_id', $empresa_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarsalamenu() {
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('exame_sala_id,
                            nome');
        $this->db->from('tb_exame_sala');
        $this->db->where('ativo', 'true');
        $this->db->where('empresa_id', $empresa_id);
        $return = $this->db->get();
        return $return->result();
    }

    function carregarcontratotipo($contratotipo_id) {
        $this->db->select('estoque_tipo_contrato_id as tipo_id,
                                descricao');
        $this->db->from('tb_estoque_tipo_contrato');
        $this->db->where('estoque_tipo_contrato_id', $contratotipo_id);
        $this->db->where('ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function listarcontratos() {
        $this->db->select('estoque_contrato_id,
                            nome');
        $this->db->from('tb_estoque_contrato');
        $this->db->where('ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function contador($operador_id) {
        $this->db->select();
        $this->db->from('tb_estoque_operador_contrato');
        $this->db->where('operador_id', $operador_id);
        $return = $this->db->count_all_results();
        return $return;
    }

    function listarcontrato($operador_id) {
        $this->db->select('ec.nome, oc.estoque_operador_contrato_id');
        $this->db->from('tb_estoque_operador_contrato oc');
        $this->db->join('tb_estoque_contrato ec', 'ec.estoque_contrato_id = oc.contrato_id');
        $this->db->where('oc.operador_id', $operador_id);
        $this->db->where('oc.ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function testacontratorepetidos($contrato_id) {
        $operador_id = $this->session->userdata('operador_id');
        $this->db->select('estoque_operador_contrato_id');
        $this->db->from('tb_estoque_operador_contrato oc');
        $this->db->join('tb_operador o', 'o.operador_id = oc.operador_id');
        $this->db->where('oc.operador_id', $operador_id);
        $this->db->where('oc.contrato_id', $contrato_id);
        $this->db->where('oc.ativo', 't');
        $this->db->where('o.ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function listaroperadores($operador_id) {
        $this->db->select('operador_id,
                            usuario');
        $this->db->from('tb_operador');
        $this->db->where('ativo', 'true');
        $this->db->where('operador_id', $operador_id);
        $return = $this->db->get();
        return $return->result();
    }

    function gravarcontratotipo() {
        try {
            /* inicia o mapeamento no banco */
            $this->db->set('descricao', $_POST['txtNome']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
//            var_dump($_POST['tipo_id']);die;
            if ($_POST['tipo_id'] == '0' || $_POST['tipo_id'] == '') {
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_estoque_tipo_contrato');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $tipo_id = $this->db->insert_id();
            }
            else {
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('estoque_tipo_contrato_id', $_POST['tipo_id']);
                $this->db->update('tb_estoque_tipo_contrato');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $tipo_id = $_POST['unidadevigencia_id'];
            }

            return $tipo_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarcontratos() {
        try {
            /* inicia o mapeamento no banco */
            $this->db->set('operador_id', $_POST['txtoperador_id']);
            $this->db->set('contrato_id', $_POST['contratos_id']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_estoque_operador_contrato');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
                $estoque_menu_produtos_id = $this->db->insert_id();

            return $estoque_menu_produtos_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function excluircontratos($operado_contrato) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('estoque_operador_contrato_id', $operado_contrato);
        $this->db->update('tb_estoque_operador_contrato');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function excluircontratotipo($contratotipo_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('estoque_tipo_contrato_id', $contratotipo_id);
        $this->db->update('tb_estoque_tipo_contrato');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function excluir($estoque_contrato_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('estoque_contrato_id', $estoque_contrato_id);
        $this->db->update('tb_estoque_contrato');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function gravar() {
        $estoque_contrato_id = $_POST['contrato_id'];

        $this->db->set('nome', $_POST['nome']);
        $this->db->set('data_inicio', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->set('data_fim', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        $this->db->set('logradouro', $_POST['endereco']);
        $this->db->set('numero', $_POST['numero']);
        $this->db->set('bairro', $_POST['bairro']);
        $this->db->set('complemento', $_POST['complemento']);
        if ($_POST['municipio_id'] != '') {
            $this->db->set('municipio_id', $_POST['municipio_id']);
        }

        $this->db->set('numero_contrato', $_POST['numContrato']);
        $this->db->set('situacao', $_POST['situacaoContrato']);
        if ($_POST['tipoContrato'] != '') {
            $this->db->set('tipo_contrato_id', $_POST['tipoContrato']);
        }
        if ($_POST['credor_devedor'] != '') {
            $this->db->set('credor_devedor_id', $_POST['credor_devedor']);
        }

        $this->db->set('data_assinatura', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_assinatura']))));
        $this->db->set('valor_inicial', str_replace(',', '.', str_replace('.', '', $_POST['valorInicial'])));
        $this->db->set('calcao', str_replace(',', '.', str_replace('.', '', $_POST['calcao'])));

        $this->db->set('observacao', $_POST['observacoes']);
        $this->db->set('clasulas', $_POST['clasulas']);

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        if ($_POST['contrato_id'] == "") {// insert
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_estoque_contrato');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
                $estoque_contrato_id = $this->db->insert_id();
        }
        else { // update
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('estoque_contrato_id', $estoque_contrato_id);
            $this->db->update('tb_estoque_contrato');
        }
        
            /* Atualizando as Parcelas */
        $this->db->set('ativo', 'f');
        $this->db->set('contrato_id', $estoque_contrato_id);
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('estoque_contrato_id', $estoque_contrato_id);
        $this->db->update('tb_estoque_contrato_pagamento');
        
        $dataVencimento = date("Y-m-d", strtotime( str_replace('/', '-', $_POST['txtdata_vencimento']) ) );
        $_POST['valorParcela'] = str_replace(',', '.', str_replace('.', '', $_POST['valorParcela']));
        $intervalo = (int)str_replace('.', '', $_POST['intervalo']);
        for($i = 1; $i <= (int)$_POST['numParcela']; $i++){
            
            $this->db->set('valor', $_POST['valorParcela']);
            $this->db->set('contrato_id', $estoque_contrato_id);
            $this->db->set('parcela', $i);
            $this->db->set('data', $dataVencimento);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_estoque_contrato_pagamento');
            
            if($_POST['tipoPagamento'] == 'fixo'){
                $dataVencimento = date("Y-m-d", strtotime("+1 month", strtotime($dataVencimento)));
//                $dataVencimento = date("Y-m-d", strtotime("+1 month", $dataVencimento));
            }
            else{
                $dataVencimento = date("Y-m-d", strtotime("+$intervalo days", strtotime($dataVencimento)));
//                $dataVencimento = date("Y-m-d", strtotime("+$intervalo days", $dataVencimento));
            }
        }
    }

    private function instanciar($estoque_contrato_id) {

        if ($estoque_contrato_id != 0) {
            $this->db->select('ec.*, m.nome as municipio_nome, tl.descricao');
            $this->db->from('tb_estoque_contrato ec');
            $this->db->join('tb_municipio m', 'm.municipio_id = ec.municipio_id', 'left');
            $this->db->join('tb_tipo_logradouro tl', 'tl.tipo_logradouro_id = ec.tipo_logradouro_id', 'left');
            $this->db->where("estoque_contrato_id", $estoque_contrato_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_estoque_contrato_id = $estoque_contrato_id;
            $this->_nome = $return[0]->nome;
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
        } else {
            $this->_estoque_contrato_id = null;
        }
    }

}

?>
