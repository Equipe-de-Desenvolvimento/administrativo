<?php

class boleto_model extends Model {

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

    function Boleto_model($estoque_contrato_id = null) {
        parent::Model();
        if (isset($estoque_contrato_id)) {
            $this->instanciar($estoque_contrato_id);
        }
    }

    function listarsolicitacaoboleto($solicitacao_cliente_id) {

        $this->db->select('eb.estoque_boleto_id,
                           fp.nome as formapagamento,
                           dfp.nome as descricaopagamento,
                           eb.valor,
                           eb.registrado,
                           eb.pagado');
        $this->db->from('tb_estoque_boleto eb');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = eb.formapagamento_id', 'left');
        $this->db->join('tb_descricao_forma_pagamento dfp', 'dfp.descricao_forma_pagamento_id = eb.descricaopagamento_id', 'left');
        $this->db->where('eb.ativo', 'true');
        $this->db->where('eb.solicitacao_cliente_id', $solicitacao_cliente_id);
        $return = $this->db->get();
        $return = $return->result();
        return $return;
    }

    function listarcontaboleto($descricaopagamento_id) {

        $this->db->select('fs.conta,
                            fs.agencia,
                            fs.digito,
                            fs.descricao as descricao_conta');
        $this->db->from('tb_descricao_forma_pagamento fp');
        $this->db->join('tb_forma_entradas_saida fs', 'fs.forma_entradas_saida_id = fp.conta_id', 'left');
        $this->db->where('fp.descricao_forma_pagamento_id', $descricaopagamento_id);
        $return = $this->db->get();
        return $return->result();
    }

    function empresaboleto() {
        $empresa = $this->session->userdata('empresa_id');
        $this->db->select('e.empresa_id,
                            e.nome as empresa,
                            e.cnpj,
                            e.cep,
                            e.razao_social,
                            e.logradouro,
                            e.bairro,
                            e.telefone,
                            e.inscricao_estadual,
                            e.email,
                            m.estado,
                            m.nome as municipio,
                            e.numero');
        $this->db->from('tb_empresa e');
        $this->db->where('empresa_id', $empresa);
        $this->db->join('tb_municipio m', 'm.municipio_id = e.municipio_id', 'left');
        $return = $this->db->get();
        return $return->result();
    }

    function listasolicitacaofaturamento($estoque_solicitacao_id) {
        $operador_id = $this->session->userdata('operador_id');
        $this->db->select('esf.*,
                           ct.valor_frete ');
        $this->db->from('tb_estoque_solicitacao_faturamento esf');
        $this->db->join('tb_estoque_solicitacao_cliente_transportadora ct', 'ct.solicitacao_cliente_id = esf.estoque_solicitacao_id', 'left');
        $this->db->where('esf.estoque_solicitacao_id', $estoque_solicitacao_id);
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
                           ec.nome as cliente');
        $this->db->from('tb_estoque_contrato ect');
        $this->db->where('ect.ativo', 'true');
        $this->db->join('tb_estoque_cliente ec', 'ec.estoque_cliente_id = ect.cliente_id', 'left');
        $this->db->join('tb_estoque_tipo_contrato tc', 'tc.estoque_tipo_contrato_id = ect.tipo_contrato_id', 'left');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('ect.nome ilike', "%" . $args['nome'] . "%");
        }
        return $this->db;
    }

    function empresa() {
        $empresa = $this->session->userdata('empresa_id');
        $this->db->select('e.empresa_id,
                            e.nome as empresa,
                            e.cnpj,
                            e.cep,
                            e.razao_social,
                            e.logradouro,
                            e.bairro,
                            e.telefone,
                            e.inscricao_estadual,
                            e.email,
                            m.estado,
                            m.nome as municipio,
                            e.numero');
        $this->db->from('tb_empresa e');
        $this->db->where('empresa_id', $empresa);
        $this->db->join('tb_municipio m', 'm.municipio_id = e.municipio_id', 'left');
        $return = $this->db->get();
        return $return->result();
    }

    function listaclienteboleto($estoque_solicitacao_id) {
        $operador_id = $this->session->userdata('operador_id');
        $this->db->select('ec.*, m.estado, 
                           m.nome as municipio,  
                           m.codigo_ibge,  
                           esc.data_fechamento, 
                           ct.valor_frete ');
        $this->db->from('tb_estoque_solicitacao_cliente esc');
        $this->db->join('tb_estoque_cliente ec', 'ec.estoque_cliente_id = esc.cliente_id', 'left');
        $this->db->join('tb_municipio m', 'm.municipio_id = ec.municipio_id', 'left');
        $this->db->join('tb_estoque_solicitacao_cliente_transportadora ct', 'ct.solicitacao_cliente_id = esc.estoque_solicitacao_setor_id', 'left');
        $this->db->where('esc.estoque_solicitacao_setor_id', $estoque_solicitacao_id);
        $this->db->where('esc.ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function instanciarboleto($estoque_boleto_id) {
        $this->db->select(' eb.estoque_boleto_id,
                            eb.valor,
                            eb.registrado,
                            eb.pagado,
                            eb.data_registro,
                            eb.data_pagamento,
                            eb.data_vencimento,
                            eb.numero_documento,
                            eb.nosso_numero,
                            eb.seu_numero,
                            eb.juros,
                            eb.mensagem_cedente,
                            eb.especie_documento,
                            eb.carteira,
                            eb.servico,
                            eb.aceite,
                            eb.instrucao_boleto,
                            eb.baixa,
                            eb.descricaopagamento_id,
                            dfp.nome as descricao,
                            fes.descricao as conta_descricao,
                            fes.agencia as conta_agencia,
                            fes.conta as empresa_conta,
                            fes.digito as conta_digito,
                            eb.formapagamento_id,
                            fp.nome as forma_pagamento,
                            eb.credor_devedor_id,
                            fcd.razao_social as credor_devedor,
                            eb.solicitacao_cliente_id,
                            cli.nome as cliente,
                            cli.telefone as cliente_telefone,
                            cli.celular as cliente_celular,
                            cli.cnpj as cliente_cnpj,
                            cli.email as cliente_email,
                            cli.logradouro as cliente_logradouro,
                            cli.numero as cliente_numero,
                            cli.bairro as cliente_bairro,
                            m.nome as cliente_municipio,
                            m.estado as cliente_estado,
                            eb.contrato_id,
                            ec.nome as contrato_nome,
                            ec.data_inicio as contrato_inicio,
                            ec.data_fim as contrato_fim,
                            ec.tipo_contrato_id as contrato_tipo,
                            ec.situacao as contrato_situacao');
        $this->db->from('tb_estoque_boleto eb');
        $this->db->join('tb_descricao_forma_pagamento dfp', 'dfp.descricao_forma_pagamento_id = eb.descricaopagamento_id', 'left');
        $this->db->join('tb_forma_entradas_saida fes', 'fes.forma_entradas_saida_id = dfp.conta_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = eb.formapagamento_id', 'left');
        $this->db->join('tb_financeiro_credor_devedor fcd', 'fcd.financeiro_credor_devedor_id = eb.credor_devedor_id', 'left');
        $this->db->join('tb_estoque_solicitacao_cliente esc', 'esc.estoque_solicitacao_setor_id = eb.solicitacao_cliente_id', 'left');
        $this->db->join('tb_estoque_cliente cli', 'cli.estoque_cliente_id = esc.cliente_id', 'left');
        $this->db->join('tb_municipio m', 'm.municipio_id = cli.municipio_id', 'left');
        $this->db->join('tb_estoque_contrato ec', 'ec.estoque_contrato_id = eb.contrato_id', 'left');
        $this->db->join('tb_estoque_tipo_contrato etc', 'etc.estoque_tipo_contrato_id = ec.tipo_contrato_id', 'left');
        $this->db->where('eb.estoque_boleto_id', $estoque_boleto_id);
        $this->db->where('eb.ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function listarsolicitacaosnota($estoque_solicitacao_id) {
        $this->db->select(' es.estoque_saida_id,
                            ep.descricao,
                            ep.estoque_produto_id,
                            ep.codigo, ep.ncm,
                            esi.estoque_solicitacao_itens_id, 
                            es.validade,
                            es.quantidade,
                            esi.cst,
                            esi.icms, 
                            esi.ipi, 
                            esi.icmsst, 
                            c.cfop_id, 
                            c.codigo_cfop, 
                            c.descricao_cfop,
                            esi.mva,    
                            esi.valor as valor_venda, 
                            eu.descricao as unidade,                          
                            esi.quantidade as quantidade_solicitada');
        $this->db->from('tb_estoque_saida es');
        $this->db->join('tb_estoque_produto ep', 'ep.estoque_produto_id = es.produto_id');
        $this->db->join('tb_estoque_unidade eu', 'eu.estoque_unidade_id= ep.unidade_id');
        $this->db->join('tb_estoque_solicitacao_itens esi', 'esi.estoque_solicitacao_itens_id = es.estoque_solicitacao_itens_id', 'left');
        $this->db->join('tb_cfop c', 'c.cfop_id = esi.cfop_id', 'left');
        $this->db->where('es.solicitacao_cliente_id', $estoque_solicitacao_id);
        $this->db->where('es.ativo', 'true');
        $this->db->orderby('es.estoque_saida_id');
        $return = $this->db->get();
        return $return->result();
    }

    function gravardadoscnab() {
        $this->db->set('data_vencimento', $_POST['vencimento']);
        $this->db->set('numero_documento', $_POST['numDoc']);
        $this->db->set('nosso_numero', $_POST['nosso_numero']);
        $this->db->set('juros', $_POST['juros']);
        $this->db->set('mensagem_cedente', $_POST['mensagem']);
        $this->db->set('instrucao_boleto', $_POST['instrucao']);
        $this->db->set('aceite', $_POST['aceite']);
        $this->db->set('especie_documento', $_POST['especie']);
        $this->db->set('carteira', $_POST['carteira']);
        $this->db->set('servico', $_POST['servico']);
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('estoque_boleto_id', $_POST['estoque_boleto_id']);
        $this->db->update('tb_estoque_boleto');
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

    function gravarsolicitacaoboleto($valor, $solicitacao_id, $descricao_id, $forma_id, $credor_devedor_id, $contrato_id) {

        $this->db->set('valor', $valor);
        $this->db->set('solicitacao_cliente_id', $solicitacao_id);
        $this->db->set('descricaopagamento_id', $descricao_id);
        $this->db->set('formapagamento_id', $forma_id);
        if ($credor_devedor_id != '') {
            $this->db->set('credor_devedor_id', $credor_devedor_id);
        }
        if ($contrato_id != '') {
            $this->db->set('contrato_id', $contrato_id);
        }
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador_id);
        $this->db->insert('tb_estoque_boleto');
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

    function gravar() {
        try {
            /* inicia o mapeamento no banco */
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
            if ($_POST['cliente_id'] != '') {
                $this->db->set('cliente_id', $_POST['cliente_id']);
            }
            if ($_POST['formapagamento_id'] != '') {
                $this->db->set('formapagamento_id', $_POST['formapagamento_id']);
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
            return $estoque_contrato_id;
        } catch (Exception $exc) {
            return -1;
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
