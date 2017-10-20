<?php

class solicitacao_model extends Model {

    var $_estoque_solicitacao_id = null;
    var $_descricao = null;
    var $_cliente_id = null;
    var $_vendedor_id = null;
    var $_boleto = null;
    var $_notafiscal = null;
    var $_financeiro = null;
    var $_enviada = null;
    var $_descricaopagamento = null;
    var $_formadepagamento = null;

    function Solicitacao_model($estoque_solicitacao_id = null) {
        parent::Model();
        if (isset($estoque_solicitacao_id)) {
            $this->instanciar($estoque_solicitacao_id);
        }
    }

    function contador($estoque_solicitacao_id) {
        $this->db->select('ep.descricao');
        $this->db->from('tb_estoque_solicitacao_itens esi');
        $this->db->join('tb_estoque_produto ep', 'ep.estoque_produto_id = esi.produto_id');
        $this->db->where('esi.ativo', 'true');
        $this->db->where('esi.solicitacao_cliente_id', $estoque_solicitacao_id);
        $return = $this->db->count_all_results();
        return $return;
    }

    function listaclientenotafiscal($estoque_solicitacao_id) {
        $operador_id = $this->session->userdata('operador_id');
        $this->db->select('ec.*, m.estado, 
                           m.nome as municipio,  
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

    function listarautocompleteclientecontrato($parametro = null) {
        $operador_id = $this->session->userdata('operador_id');
        $this->db->select('ec.nome as contrato, ec.estoque_contrato_id, etc.descricao as tipo');
        $this->db->from('tb_estoque_cliente cli');
        $this->db->join('tb_estoque_contrato ec', 'ec.credor_devedor_id = cli.credor_devedor_id', 'left');
        $this->db->join('tb_estoque_tipo_contrato etc', 'etc.estoque_tipo_contrato_id = ec.tipo_contrato_id', 'left');
//        $this->db->join('tb_financeiro_credor_devedor fcd', 'fcd.financeiro_credor_devedor_id = ec.credor_devedor_id', 'left');
        $this->db->where('ec.ativo', 'true');
        if ($parametro != null) {
            $this->db->where('cli.estoque_cliente_id', $parametro);
        }
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

    function listadadossolicitacaoliberada($estoque_solicitacao_id) {
        $operador_id = $this->session->userdata('operador_id');
        $this->db->select('ec.*, 
                           m.estado, m.nome as municipio,  
                           esc.data_fechamento, 
                           o.nome as vendedor,
                           ent.nome as entregador, 
                           sf.desconto, 
                           sf.valor_total');
        $this->db->from('tb_estoque_solicitacao_cliente esc');
        $this->db->join('tb_estoque_cliente ec', 'ec.estoque_cliente_id = esc.cliente_id', 'left');
        $this->db->join('tb_municipio m', 'm.municipio_id = ec.municipio_id', 'left');
        $this->db->join('tb_estoque_solicitacao_faturamento sf', 'sf.estoque_solicitacao_id = esc.estoque_solicitacao_setor_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = esc.vendedor_id', 'left');
        $this->db->join('tb_estoque_solicitacao_cliente_transportadora ct', 'ct.solicitacao_cliente_id = esc.estoque_solicitacao_setor_id', 'left');
        $this->db->join('tb_entregador ent', 'ent.entregador_id = esc.entregador', 'left');
        $this->db->where('esc.estoque_solicitacao_setor_id', $estoque_solicitacao_id);
        $this->db->where('esc.ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function listarclientes() {
        $operador_id = $this->session->userdata('operador_id');
        $this->db->select('estoque_cliente_id,
                            nome');
        $this->db->from('tb_estoque_cliente ec');
        $this->db->join('tb_estoque_operador_cliente oc', 'oc.cliente_id = ec.estoque_cliente_id');
        $this->db->where('oc.operador_id', $operador_id);
        $this->db->where('ec.ativo', 'true');
        $this->db->where('oc.ativo', 'true');
        $this->db->orderby('ec.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function jurosporparcelas($formapagamento_id) {
        $this->db->select('valor, prazo, parcela, dias');
        $this->db->from('tb_formapagamento_pacela_juros');
        $this->db->where('forma_pagamento_id', $formapagamento_id);
        $this->db->where('ativo', 't');
        $query = $this->db->get();

        return $query->result();
    }

    function gravarfinanceirofaturamento($solicitacao_id) {
        /* inicia o mapeamento no banco */
        $this->db->select('ec.nome, ec.telefone, 
                           ec.credor_devedor_id, 
                           esc.descricaopagamento, 
                           esc.formadepagamento, 
                           fp.tipo,
                           esf.*');
        $this->db->from('tb_estoque_solicitacao_cliente esc');
        $this->db->join('tb_estoque_cliente ec', 'ec.estoque_cliente_id = esc.cliente_id');
        $this->db->join('tb_descricao_forma_pagamento dfp', 'dfp.descricao_forma_pagamento_id = esc.descricaopagamento');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = esc.formadepagamento');
        $this->db->join('tb_estoque_solicitacao_faturamento esf', 'esf.estoque_solicitacao_id = esc.estoque_solicitacao_setor_id');
        $this->db->where("estoque_solicitacao_setor_id", $solicitacao_id);
        $this->db->where("esf.ativo", 't');
        $faturamento = $this->db->get()->result();

        $cliente = $faturamento[0]->credor_devedor_id;
        $valorPedido = $faturamento[0]->valor_total;
//        echo "<pre>";
//        var_dump($faturamento);die;

        if ($valorPedido != '0.00') {
            $valor = $faturamento[0]->valor_total;
            $tipo = $faturamento[0]->tipo;
            $parcelas = $faturamento[0]->parcelas1;

            $classe = "PEDIDO FATURAMENTO";


            $parcelas = $this->jurosporparcelas($faturamento[0]->formadepagamento);
            $prazo = (int) $parcelas[0]->prazo;

//FORMA DE PAGAMENTO 'AVISTA'
// O valor 100 se refere a porcentagem de juros cadastrada na parcela.
            if ($tipo == 1) {
                $prazo = (int) $parcelas[0]->prazo;

                if ($prazo == 0 || $prazo == '') { //CASO SEJA AVISTA E NAO HAJA PRAZO (vai receber o dinheiro no caixa)
                    $this->db->set('data', $data);
                    $this->db->set('valor', $valor);
                    $this->db->set('classe', $classe);
                    $this->db->set('descricaopagamento', $faturamento[0]->descricaopagamento);
                    $this->db->set('tipo', 'PEDIDO');
                    $this->db->set('nome', $cliente);
                    $this->db->set('observacao', $observacao);
                    $this->db->set('pedido_id', $solicitacao_id);
                    $this->db->set('data_cadastro', $horario);
                    $this->db->set('operador_cadastro', $operador_id);
                    $this->db->insert('tb_entradas');
                    $entradas_id = $this->db->insert_id();

                    $this->db->set('data', $data);
                    $this->db->set('valor', $valor);
                    $this->db->set('entrada_id', $entradas_id);
                    $this->db->set('pedido_id', $solicitacao_id);
                    $this->db->set('nome', $cliente);
                    $this->db->set('data_cadastro', $horario);
                    $this->db->set('operador_cadastro', $operador_id);
                    $this->db->insert('tb_saldo');
                } else { //CASO HAJA UM PRAZO
                    $data_receber = date("Y-m-d");
                    $data_receber = date("Y-m-d", strtotime("+$prazo days", strtotime($data_receber)));
                    $this->db->set('valor', $valor);
                    $this->db->set('devedor', $cliente);
                    $this->db->set('tipo', 'PEDIDO');
                    $this->db->set('data', $data_receber);
                    $this->db->set('descricaopagamento', $faturamento[0]->descricaopagamento);
                    $this->db->set('pedido_id', $solicitacao_id);
                    $this->db->set('parcela', $parcelas[0]->parcela);
                    $this->db->set('classe', $classe);
                    $this->db->set('observacao', $observacao);
                    $this->db->set('data_cadastro', $horario);
                    $this->db->set('operador_cadastro', $operador_id);
                    $this->db->insert('tb_financeiro_contasreceber');
                }
            }
//FORMA DE PAGAMENTO 'PARCELADO' ou 'CADASTRO MANUAL'
            else {

                $data_receber = date("Y-m-d");
                foreach ($parcelas as $item) {
                    $obs = "Parc. " . $item->parcela . '/' . count($parcelas) . ' ' . $observacao;

                    $percParcela = (float) $item->valor;
                    $valorParcela = $valor * ($percParcela / 100);
                    $periodo = $item->dias;
                    $data_receber = date("Y-m-d", strtotime("+$periodo days", strtotime($data_receber)));

                    $this->db->set('valor', $valorParcela);
                    $this->db->set('devedor', $cliente);
                    $this->db->set('tipo', 'PEDIDO');
                    $this->db->set('data', $data_receber);
                    $this->db->set('pedido_id', $solicitacao_id);
                    $this->db->set('descricaopagamento', $faturamento[0]->descricaopagamento);
                    $this->db->set('parcela', $item->parcela);
                    $this->db->set('classe', $classe);
                    $this->db->set('observacao', $obs);
                    $this->db->set('data_cadastro', $horario);
                    $this->db->set('operador_cadastro', $operador_id);
                    $this->db->insert('tb_financeiro_contasreceber');
                }
            }
        }
    }

    function solicitacaonome($estoque_solicitacao_id) {
        $this->db->select('ec.nome, 
                           esc.data_fechamento, 
                           o.nome as liberou, 
                           op.nome as solicitante, 
                           es.data_cadastro, 
                           fp.nome as forma_pagamento');
        $this->db->from('tb_estoque_solicitacao_cliente esc');
        $this->db->join('tb_estoque_cliente ec', 'ec.estoque_cliente_id = esc.cliente_id');
        $this->db->join('tb_operador o', 'o.operador_id = esc.operador_fechamento', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = esc.operador_liberacao', 'left');
        $this->db->join('tb_estoque_saida es', 'es.solicitacao_cliente_id = esc.estoque_solicitacao_setor_id', 'left');
        $this->db->join('tb_estoque_solicitacao_faturamento esf', 'esf.estoque_solicitacao_id = esc.estoque_solicitacao_setor_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = esf.forma_pagamento', 'left');
        $this->db->where('esc.estoque_solicitacao_setor_id', $estoque_solicitacao_id);
        $return = $this->db->get();
        return $return->result();
    }

    function solicitacaonomeliberado($estoque_solicitacao_id) {

        $this->db->select('ec.nome, esc.data_liberacao , o.nome as solicitante, fp.nome as forma_pagamento, df.nome as descricao_pagamento');
        $this->db->from('tb_estoque_solicitacao_cliente esc');
        $this->db->join('tb_estoque_cliente ec', 'ec.estoque_cliente_id = esc.cliente_id');
        $this->db->join('tb_operador o', 'o.operador_id = esc.operador_liberacao', 'left');
        $this->db->join('tb_estoque_solicitacao_faturamento esf', 'esf.estoque_solicitacao_id = esc.estoque_solicitacao_setor_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = esf.forma_pagamento', 'left');
        $this->db->join('tb_descricao_forma_pagamento df', 'df.descricao_forma_pagamento_id = esc.descricaopagamento', 'left');
        $this->db->where('esc.estoque_solicitacao_setor_id', $estoque_solicitacao_id);
        $return = $this->db->get();
        return $return->result();
    }

    function autocompletencmcest($parametro = null) {
        $this->db->select('codigo_cest, codigo_ncm, descricao_cest, cest_id');
        $this->db->from('tb_cest');
        if ($parametro != null) {
            $this->db->where('codigo_ncm ilike', $parametro);
        }
        $return = $this->db->get();
        return $return->result();
    }

    function autocompletencm($parametro = null) {

        $this->db->select('ncm_id, codigo_ncm, descricao_ncm, aliquota');
        $this->db->from('tb_ncm');
        if ($parametro != null) {
            $this->db->where('codigo_ncm ilike', $parametro . "%");
        }
        $return = $this->db->get();
        return $return->result();
    }

    function autocompletecst($parametro = null) {

        $this->db->select('cst, tipo, situacao_tributaria');
        $this->db->from('tb_cst');
        if ($parametro != null) {
            $this->db->where('cst ilike', $parametro . "%");
        }
        $return = $this->db->get();
        return $return->result();
    }

    function autocompletecfop($parametro = null) {

        $this->db->select('cfop_id, codigo_cfop, descricao_cfop');
        $this->db->from('tb_cfop');
        if ($parametro != null) {
            $this->db->where('codigo_cfop ilike', $parametro . "%");
        }
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

    function calculavalortotalsolicitacao($estoque_solicitacao_id) {
        $this->db->select('esi.quantidade, 
                           esi.valor as valor_venda');
        $this->db->from('tb_estoque_solicitacao_itens esi');
        $this->db->join('tb_estoque_produto ep', 'ep.estoque_produto_id = esi.produto_id');
        $this->db->where('esi.ativo', 'true');
        $this->db->where('esi.solicitacao_cliente_id', $estoque_solicitacao_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarsolicitacaos($estoque_solicitacao_id) {
        $this->db->select('ep.descricao, 
                           esi.estoque_solicitacao_itens_id, 
                           esi.quantidade, esi.exame_id, 
                           esi.valor as valor_venda,
                           esi.icms, 
                           esi.mva, 
                           esi.icmsst, 
                           esi.ipi');
        $this->db->from('tb_estoque_solicitacao_itens esi');
        $this->db->join('tb_estoque_produto ep', 'ep.estoque_produto_id = esi.produto_id');
        $this->db->where('esi.ativo', 'true');
        $this->db->where('esi.solicitacao_cliente_id', $estoque_solicitacao_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarsolicitacaosvalortotal($estoque_solicitacao_id) {
        $this->db->select('ep.descricao, esi.estoque_solicitacao_itens_id, esi.quantidade, esi.exame_id, ep.valor_venda');
        $this->db->from('tb_estoque_solicitacao_itens esi');
        $this->db->join('tb_estoque_produto ep', 'ep.estoque_produto_id = esi.produto_id');
        $this->db->where('esi.ativo', 'true');
        $this->db->where('esi.solicitacao_cliente_id', $estoque_solicitacao_id);
        $return = $this->db->get();
        return $return->result();
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

    function listarsolicitacaofaturamentocliente($estoque_solicitacao_id) {
        $operador_id = $this->session->userdata('operador_id');
        $this->db->select('esc.contrato_id, 
                           ec.credor_devedor_id, 
                           esc.financeiro,
                           esc.boleto,
                           esc.formadepagamento,
                           esc.descricaopagamento');
        $this->db->from('tb_estoque_solicitacao_cliente esc');
        $this->db->join('tb_estoque_cliente ec', 'ec.estoque_cliente_id = esc.cliente_id', 'left');
        $this->db->where('esc.estoque_solicitacao_setor_id', $estoque_solicitacao_id);
        $this->db->where('esc.ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function removerfinanceiro($estoque_solicitacao_id) {
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('ativo', 'f');
        $this->db->set('excluido', 't');
        $this->db->where('pedido_id', $estoque_solicitacao_id);
        $this->db->update('tb_financeiro_contasreceber');

        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('ativo', 'f');
        $this->db->where('pedido_id', $estoque_solicitacao_id);
        $this->db->update('tb_entradas');
    }

    function cancelarsolicitacaofinanceiro($estoque_solicitacao_id) {
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('ativo', 'f');
        $this->db->set('excluido', 't');
        $this->db->where('pedido_id', $estoque_solicitacao_id);
        $this->db->update('tb_financeiro_contasreceber');

        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('ativo', 'f');
        $this->db->where('pedido_id', $estoque_solicitacao_id);
        $this->db->update('tb_entradas');
    }

    function cancelarnotafiscal($estoque_solicitacao_id, $config) {
        $this->db->select(' chave_nfe,
                            numero_protocolo,
                            modelo_nf,
                            tipo_ambiente,
                            enviada');
        $this->db->from('tb_notafiscal');
        $this->db->where('solicitacao_cliente_id', $estoque_solicitacao_id);
        $this->db->where('ativo', 't');
        $retorno = $this->db->get()->result();

        if (count($retorno) > 0 && @$retorno[0]->enviada != 'f') {
            $chave = $retorno[0]->chave_nfe;
            $numProtocolo = $retorno[0]->numero_protocolo;
            $modelo = $retorno[0]->modelo_nf;
            $tpAmbiente = $retorno[0]->tipo_ambiente;
            $motivo = $_POST['txtmotivo'];

            require_once ('/home/sisprod/projetos/administrativo/application/libraries/nfephp/vendor/nfephp-org/nfephp/bootstrap.php');
            require_once ('/home/sisprod/projetos/administrativo/application/libraries/nfephp/arquivosNfe/cancelaNfe.php');

            $horario = date("Y-m-d H:i:s");
            $this->db->set('data_cancelamento', $horario);
            $this->db->set('cancelada', 't');
            $this->db->set('motivo_cancelamento', $_POST['txtmotivo']);

            $this->db->where('solicitacao_cliente_id', $estoque_solicitacao_id);
            $this->db->update('tb_notafiscal');
        }
    }

    function cancelarpedido($estoque_solicitacao_id) {
        $this->db->set('situacao', 'CANCELADO');
        $this->db->set('cancelada', 't');
        $this->db->set('motivo_cancelamento', $_POST['txtmotivo']);
        $this->db->where('estoque_solicitacao_setor_id', $estoque_solicitacao_id);
        $this->db->update('tb_estoque_solicitacao_cliente');
    }

    function usanotafiscal($estoque_solicitacao_id) {
        $operador_id = $this->session->userdata('operador_id');
        $this->db->select('esc.notafiscal, financeiro');
        $this->db->from('tb_estoque_solicitacao_cliente esc');
        $this->db->where('esc.estoque_solicitacao_setor_id', $estoque_solicitacao_id);
        $this->db->where('esc.ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function almoxarifadosaida() {
        $empresa = $this->session->userdata('empresa_id');
        $this->db->select('almoxarifado');
        $this->db->from('tb_empresa e');
        $this->db->where('empresa_id', $empresa);
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

    function valorprodutosolicitacao($estoque_solicitacao_id, $produto_id) {
        $this->db->select('emp.valor as valor_venda');
        $this->db->from('tb_estoque_produto ep');
        $this->db->join('tb_estoque_menu_produtos emp', 'emp.produto = ep.estoque_produto_id');
        $this->db->join('tb_estoque_menu em', 'em.estoque_menu_id = emp.menu_id');
        $this->db->join('tb_estoque_cliente ec', 'ec.menu_id = emp.menu_id');
        $this->db->join('tb_estoque_solicitacao_cliente esc', 'esc.cliente_id = ec.estoque_cliente_id');
        $this->db->where('esc.estoque_solicitacao_setor_id', $estoque_solicitacao_id);
        $this->db->where('ep.estoque_produto_id', $produto_id);
        $this->db->where('ep.ativo', 'true');
        $this->db->where('emp.ativo', 'true');
        $this->db->orderby('ep.descricao');
        $this->db->orderby('ep.codigo');

        $return = $this->db->get();
        return $return->result();
    }

    function listarprodutos($estoque_solicitacao_id) {
        $this->db->select('ep.codigo,
                            ep.estoque_produto_id,
                            ep.descricao,
                            ep.ipi,
                            emp.valor as valor_venda');
        $this->db->from('tb_estoque_produto ep');
        $this->db->join('tb_estoque_menu_produtos emp', 'emp.produto = ep.estoque_produto_id');
        $this->db->join('tb_estoque_menu em', 'em.estoque_menu_id = emp.menu_id');
        $this->db->join('tb_estoque_cliente ec', 'ec.menu_id = emp.menu_id');
        $this->db->join('tb_estoque_solicitacao_cliente esc', 'esc.cliente_id = ec.estoque_cliente_id');
        $this->db->where('esc.estoque_solicitacao_setor_id', $estoque_solicitacao_id);
        $this->db->where('ep.ativo', 'true');
        $this->db->where('emp.ativo', 'true');
        $this->db->orderby('ep.descricao');
        $this->db->orderby('ep.codigo');

        $return = $this->db->get();
        return $return->result();
    }

    function listardadoscliente($estoque_solicitacao_id) {
        $this->db->select('ep.estoque_produto_id,
                            ep.descricao');
        $this->db->from('tb_estoque_produto ep');
        $this->db->join('tb_estoque_menu_produtos emp', 'emp.produto = ep.estoque_produto_id');
        $this->db->join('tb_estoque_menu em', 'em.estoque_menu_id = emp.menu_id');
        $this->db->join('tb_estoque_cliente ec', 'ec.menu_id = emp.menu_id');
        $this->db->join('tb_estoque_solicitacao_cliente esc', 'esc.cliente_id = ec.estoque_cliente_id');
        $this->db->where('esc.estoque_solicitacao_setor_id', $estoque_solicitacao_id);
        $this->db->where('ep.ativo', 'true');
        $this->db->where('emp.ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function contadorprodutositem($estoque_solicitacao_itens_id) {
        $this->db->select('ep.estoque_entrada_id,
                            p.descricao,
                            ep.validade,
                            ea.descricao as armazem');
        $this->db->from('tb_estoque_saldo ep');
        $this->db->join('tb_estoque_produto p', 'p.estoque_produto_id = ep.produto_id');
        $this->db->join('tb_estoque_solicitacao_itens esi', 'esi.produto_id = ep.produto_id');
        $this->db->join('tb_estoque_armazem ea', 'ea.estoque_armazem_id = ep.armazem_id');
        $this->db->where('esi.estoque_solicitacao_itens_id', $estoque_solicitacao_itens_id);
        $this->db->where('ep.ativo', 'true');
        $return = $this->db->count_all_results();
        return $return;
    }

    function listarprodutositem($estoque_solicitacao_itens_id) {
        $this->db->select('ep.estoque_entrada_id,
                            p.descricao,
                            ep.validade,
                            ea.descricao as armazem,
                            sum(ep.quantidade) as total');
        $this->db->from('tb_estoque_saldo ep');
        $this->db->join('tb_estoque_produto p', 'p.estoque_produto_id = ep.produto_id');
        $this->db->join('tb_estoque_solicitacao_itens esi', 'esi.produto_id = ep.produto_id');
        $this->db->join('tb_estoque_armazem ea', 'ea.estoque_armazem_id = ep.armazem_id');
        $this->db->where('esi.estoque_solicitacao_itens_id', $estoque_solicitacao_itens_id);
        $this->db->where('ep.ativo', 'true');
        $this->db->groupby('ep.estoque_entrada_id, p.descricao, ep.validade, ea.descricao');
        $this->db->orderby('ep.validade');
        $return = $this->db->get();
        return $return->result();
    }

    function saidaprodutositemverificacao($produto_id) {
        $this->db->select('ep.estoque_entrada_id,
                            p.descricao,
                            ep.validade,
                            ea.descricao as armazem,
                            sum(ep.quantidade) as total');
        $this->db->from('tb_estoque_saldo ep');
        $this->db->join('tb_estoque_produto p', 'p.estoque_produto_id = ep.produto_id');
        $this->db->join('tb_estoque_solicitacao_itens esi', 'esi.produto_id = ep.produto_id');
        $this->db->join('tb_estoque_armazem ea', 'ea.estoque_armazem_id = ep.armazem_id');
        $this->db->where('esi.estoque_solicitacao_itens_id', $estoque_solicitacao_itens_id);
        $this->db->where('ep.ativo', 'true');
        $this->db->groupby('ep.estoque_entrada_id, p.descricao, ep.validade, ea.descricao');
        $this->db->orderby('ep.validade');
        $return = $this->db->get();
        return $return->result();
    }

    function listarsaidaprodutositem($estoque_solicitacao_itens_id) {
        $this->db->select('ep.estoque_saida_id,
                            p.descricao,
                            ep.validade,
                            ep.quantidade');
        $this->db->from('tb_estoque_saida ep');
        $this->db->join('tb_estoque_produto p', 'p.estoque_produto_id = ep.produto_id');
        $this->db->where('ep.estoque_solicitacao_itens_id', $estoque_solicitacao_itens_id);
        $this->db->where('ep.ativo', 'true');
        $this->db->orderby('ep.estoque_saida_id');
        $return = $this->db->get();
        return $return->result();
    }

    function contadorsaida($estoque_solicitacao_itens_id) {
        $this->db->select('ep.estoque_saida_id');
        $this->db->from('tb_estoque_saida ep');
        $this->db->join('tb_estoque_produto p', 'p.estoque_produto_id = ep.produto_id');
        $this->db->where('ep.estoque_solicitacao_itens_id', $estoque_solicitacao_itens_id);
        $this->db->where('ep.ativo', 'true');
        $this->db->orderby('ep.estoque_saida_id');
        $return = $this->db->count_all_results();
        return $return;
    }

    function listarsaidaitem($estoque_solicitacao_id) {
        $this->db->select('situacao');
        $this->db->from('tb_estoque_solicitacao_cliente esc');
        $this->db->where('esc.estoque_solicitacao_setor_id', $estoque_solicitacao_id);
        $this->db->where('esc.ativo', 'true');
        $returno = $this->db->get()->result();

//        if ($returno[0]->situacao == "FECHADA") {
//
//            $this->db->select(' ep.estoque_saida_id,
//                            p.descricao,
//                            ep.validade,
//                            ep.quantidade,
//                            u.descricao as unidade,
//                            sum(s.quantidade) as saldo,                           
//                            si.quantidade as quantidade_solicitada');
//            $this->db->from('tb_estoque_saida ep');
//            $this->db->join('tb_estoque_produto p', 'p.estoque_produto_id = ep.produto_id');
//            $this->db->join('tb_estoque_unidade u', 'u.estoque_unidade_id= p.unidade_id');
//            $this->db->join('tb_estoque_saldo s', 's.produto_id = ep.produto_id', 'left');
//            $this->db->join('tb_estoque_solicitacao_itens si', 'si.estoque_solicitacao_itens_id = ep.estoque_solicitacao_itens_id', 'left');
//            $this->db->where('ep.solicitacao_cliente_id', $estoque_solicitacao_id);
//            $this->db->where('ep.ativo', 'true');
//            $this->db->groupby('ep.estoque_saida_id, p.descricao, ep.validade , u.descricao , si.quantidade');
//            $this->db->orderby('ep.estoque_saida_id');
//            $return = $this->db->get();
//        } else {
        $this->db->select('
                               p.descricao,
                               p.codigo,
                               e.lote,
                               e.validade,
                               si.solicitacao_cliente_id,
                               u.descricao as unidade,
                               sum(si.quantidade) as quantidade');
        $this->db->from('tb_estoque_solicitacao_itens si');
        $this->db->join('tb_estoque_produto p', 'p.estoque_produto_id = si.produto_id', 'left');
        $this->db->join('tb_estoque_unidade u', 'u.estoque_unidade_id= p.unidade_id', 'left');
        $this->db->join('tb_estoque_entrada e', 'e.estoque_entrada_id= si.entrada_id', 'left');
        $this->db->where('si.solicitacao_cliente_id', $estoque_solicitacao_id);
        $this->db->where('si.ativo', 'true');
        $this->db->groupby('p.descricao, p.codigo, si.solicitacao_cliente_id, u.descricao, e.lote,e.validade');
        $this->db->orderby('si.solicitacao_cliente_id');
        $return = $this->db->get();
//        }

        return $return->result();
    }

    function listaritemliberado($estoque_solicitacao_id) {
        $this->db->select('sc.estoque_solicitacao_setor_id,
                          p.descricao as produto,
                          p.codigo,
                          p.ncm,
                          e.lote,
                          e.validade,
                          u.descricao as unidade,
                          si.quantidade as quantidade_solicitada,
                          si.valor');
        $this->db->from('tb_estoque_solicitacao_cliente sc');
        $this->db->join('tb_estoque_solicitacao_itens si', 'si.solicitacao_cliente_id = sc.estoque_solicitacao_setor_id', 'left');
        $this->db->join('tb_estoque_produto p', 'p.estoque_produto_id = si.produto_id', 'left');
        $this->db->join('tb_estoque_unidade u', 'u.estoque_unidade_id= p.unidade_id', 'left');
        $this->db->join('tb_estoque_entrada e', 'e.estoque_entrada_id= si.entrada_id', 'left');

        $this->db->where('sc.estoque_solicitacao_setor_id', $estoque_solicitacao_id);
        $this->db->where('sc.ativo', 'true');
        $this->db->where("(sc.situacao = 'LIBERADA' OR sc.situacao = 'FECHADA')");
        $this->db->orderby('sc.estoque_solicitacao_setor_id');
        $return = $this->db->get();
        return $return->result();
    }

    function contadorsaidaitem($estoque_solicitacao_id) {
        $this->db->select('ep.estoque_saida_id');
        $this->db->from('tb_estoque_saida ep');
        $this->db->join('tb_estoque_produto p', 'p.estoque_produto_id = ep.produto_id');
        $this->db->where('ep.solicitacao_cliente_id', $estoque_solicitacao_id);
        $this->db->where('ep.ativo', 'true');
        $return = $this->db->count_all_results();
        return $return;
    }

    function formadepagamento() {
        $this->db->select('fp.forma_pagamento_id,
                                fp.nome');
        $this->db->from('tb_forma_pagamento fp');
        $this->db->where('ativo', 't');
        $this->db->orderby('fp.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function descricaodepagamento() {
        $this->db->select('fp.descricao_forma_pagamento_id,
                            fp.boleto,
                            fp.nome as nome');
        $this->db->from('tb_descricao_forma_pagamento fp');
        $this->db->where('ativo', 't');
        $this->db->orderby('fp.nome');
        $return = $this->db->get();
        $retorno = $return->result();

        if (empty($retorno)) {
            $this->db->select('fp.descricao_forma_pagamento_id,
                                fp.boleto,
                                fp.nome as nome');
            $this->db->from('tb_descricao_forma_pagamento fp');
            $this->db->orderby('fp.nome');
            $return = $this->db->get();
            return $return->result();
        } else {
            return $retorno;
        }
    }

    function listarsolicitacaofaturamento($estoque_solicitacao_id) {
        $this->db->select('*');
        $this->db->from('tb_estoque_solicitacao_faturamento');
        $this->db->where('estoque_solicitacao_id', $estoque_solicitacao_id);
        $this->db->where('ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function usuarioemitente() {
        $operador_id = $this->session->userdata('operador_id');
        $this->db->select('nome');
        $this->db->from('tb_operador');
        $this->db->where('operador_id', $operador_id);
//        $this->db->where('ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function listarformapagamentoboleto($solicitacao_cliente_id) {

        $this->db->select('fs.conta,
                               fs.agencia,
                               fp.nome as descricao_pagamento,
                               fp.descricao_forma_pagamento_id,
                               fs.descricao');
        $this->db->from('tb_estoque_solicitacao_faturamento sf');
        $this->db->join('tb_descricao_forma_pagamento fp', 'fp.descricao_forma_pagamento_id = sf.descricao_pagamento', 'left');
        $this->db->join('tb_forma_entradas_saida fs', 'fs.forma_entradas_saida_id = fp.conta_id', 'left');
        $this->db->where('sf.ativo', 'true');
        $this->db->where('sf.estoque_solicitacao_id', $solicitacao_cliente_id);
        $retorno = $this->db->get()->result();
        return $retorno;
    }

    function listarcontaboleto($forma_pagamento_id) {

        $this->db->select('fs.conta,
                            fs.agencia,
                            fp.nome as forma_pagamento,
                            fp.descricao_forma_pagamento_id,
                            fs.descricao');
        $this->db->from('tb_descricao_forma_pagamento fp');
        $this->db->join('tb_forma_entradas_saida fs', 'fs.forma_entradas_saida_id = fp.conta_id', 'left');
        $this->db->where('fp.descricao_forma_pagamento_id', $forma_pagamento_id);
//        $this->db->where('fp.boleto', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function listar($args = array()) {
        $operador_id = $this->session->userdata('operador_id');
        $this->db->select(' DISTINCT(n.notafiscal_id),
                            es.estoque_solicitacao_setor_id,
                            es.cliente_id,
                            ec.nome as cliente,
                            ec.saida,
                            es.boleto,
                            es.data_cadastro,
                            es.faturado,
                            es.transportadora,
                            es.situacao, 
                            es.observacao, 
                            es.cancelada, 
                            es.notafiscal,
                            n.enviada');
        $this->db->from('tb_estoque_solicitacao_cliente es');
        $this->db->join('tb_estoque_cliente ec', 'ec.estoque_cliente_id = es.cliente_id');
        $this->db->join('tb_estoque_operador_cliente oc', 'oc.cliente_id = es.cliente_id');
        $this->db->join('tb_notafiscal n', 'n.solicitacao_cliente_id = es.estoque_solicitacao_setor_id', 'left');
        $this->db->where('es.ativo', 'true');
        $this->db->where('oc.operador_id', $operador_id);
        $this->db->where('oc.ativo', 't');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where("(ec.nome ilike '%" . $args['nome'] . "%' 
                               OR es.estoque_solicitacao_setor_id = " . $args['nome'] .")");
        }
        return $this->db;
    }

    function listarentregadores() {

        $this->db->select(' es.entregador_id,
                            es.nome');
        $this->db->from('tb_entregador es');
        $this->db->where('es.ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function listarobservacao($estoque_solicitacao_id) {
        $this->db->select('observacao');
        $this->db->from('tb_estoque_solicitacao_cliente');
        $this->db->where('estoque_solicitacao_setor_id', $estoque_solicitacao_id);
        $return = $this->db->get();
        return $return->result();
    }
    
    

    function observacao($estoque_solicitacao_id) {
        try {
            $this->db->set('observacao', $_POST['txtobservacao']);
            $this->db->where('estoque_solicitacao_setor_id', $estoque_solicitacao_id);
            $this->db->update('tb_estoque_solicitacao_cliente');
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    
    function listarentregador($args = array()) {
        $operador_id = $this->session->userdata('operador_id');

        $this->db->select(' es.entregador_id,
                            es.nome,
                            es.cep,
                            es.logradouro,
                            es.numero,
                            es.complemento,
                            es.bairro,
                            m.estado,
                            m.nome as municipio,
                            es.sexo,
                            es.nascimento,
                            es.rg,
                            es.cns,
                            es.cpf,
                            es.celular,
                            es.telefone,
                            es.observacao');
        $this->db->from('tb_entregador es');
        $this->db->join('tb_municipio m', 'm.municipio_id = es.municipio_id', 'left');
        $this->db->where('es.ativo', 'true');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('es.nome ilike', "%" . $args['nome'] . "%");
        }
//        $return = $this->db->get();
        return $this->db;
    }

    function instanciarentregador($entregador_id) {
        $this->db->select(' es.entregador_id,
                            es.nome,
                            es.cep,
                            es.logradouro,
                            es.numero,
                            es.complemento,
                            es.bairro,
                            m.estado,
                            m.nome as municipio,
                            es.sexo,
                            es.nascimento,
                            es.rg,
                            es.cns,
                            es.cpf,
                            es.celular,
                            es.telefone,
                            es.observacao');
        $this->db->from('tb_entregador es');
        $this->db->join('tb_municipio m', 'm.municipio_id = es.municipio_id', 'left');
        $this->db->where('es.ativo', 'true');
        $this->db->where('es.entregador_id', $entregador_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarsolicitacaoimpressao($estoque_solicitacao_id) {
        $operador_id = $this->session->userdata('operador_id');
        $this->db->select('es.estoque_solicitacao_setor_id,
                            es.cliente_id,
                            ec.nome as cliente,
                            ec.saida,
                            es.data_cadastro,
                            es.faturado,
                            es.situacao');
        $this->db->from('tb_estoque_solicitacao_cliente es');
        $this->db->join('tb_estoque_cliente ec', 'ec.estoque_cliente_id = es.cliente_id');
        $this->db->join('tb_estoque_operador_cliente oc', 'oc.cliente_id = es.cliente_id');
        $this->db->where('es.ativo', 'true');
        $this->db->where('es.estoque_solicitacao_setor_id', $estoque_solicitacao_id);
        $this->db->where('oc.operador_id', $operador_id);
        $this->db->where('oc.ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function listarsolicitacao($estoque_solicitacao_id) {
        $this->db->select('estoque_solicitacao_id,
                            descricao');
        $this->db->from('tb_estoque_solicitacao');
        $this->db->where('ativo', 'true');
        $this->db->where('estoque_solicitacao_id', $estoque_solicitacao_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarsolicitacaoclientetransportadora($estoque_solicitacao_id) {
        $this->db->select('st.solicitacao_transportadora_id,
                            st.volume,
                            st.peso,
                            st.forma,
                            st.valor_frete,
                            st.transportadora_id,
                            et.descricao');
        $this->db->from('tb_estoque_solicitacao_cliente_transportadora st');
        $this->db->join('tb_estoque_transportadora et', 'et.estoque_transportadora_id = st.transportadora_id', 'left');
        $this->db->where('st.ativo', 'true');
        $this->db->where('st.solicitacao_cliente_id', $estoque_solicitacao_id);
        $return = $this->db->get();
        return $return->result();
    }

    function carregarsolicitacao($estoque_solicitacao_id) {
        $this->db->select('estoque_solicitacao_id,
                            descricao');
        $this->db->from('tb_estoque_solicitacao');
        $this->db->where('estoque_solicitacao_id', $estoque_solicitacao_id);
        $return = $this->db->get();
        return $return->result();
    }

    function excluirentregador($entregador_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('entregador_id', $entregador_id);
        $this->db->update('tb_entregador');

        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function excluir($estoque_solicitacao_setor_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('estoque_solicitacao_setor_id', $estoque_solicitacao_setor_id);
        $this->db->update('tb_estoque_solicitacao_cliente');

        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('solicitacao_cliente_id', $estoque_solicitacao_setor_id);
        $this->db->update('tb_estoque_saida');

        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function gravarfaturamento($solicitacao_id) {
        try {

            $this->db->select('formadepagamento,descricaopagamento');
            $this->db->from('tb_estoque_solicitacao_cliente');
            $this->db->where("estoque_solicitacao_setor_id", $solicitacao_id);
            $return = $this->db->get();
            $descricaoPagamento = $return->result();
            $formadepagamento = $descricaoPagamento[0]->formadepagamento;
            $descpag = $descricaoPagamento[0]->descricaopagamento;

            $this->db->select('ep.descricao, 
                           esi.estoque_solicitacao_itens_id, 
                           esi.quantidade, esi.exame_id, 
                           esi.valor as valor_venda,
                           esi.icms, 
                           esi.mva, 
                           esi.icmsst, 
                           esi.ipi');
            $this->db->from('tb_estoque_solicitacao_itens esi');
            $this->db->join('tb_estoque_produto ep', 'ep.estoque_produto_id = esi.produto_id');
            $this->db->where('esi.ativo', 'true');
            $this->db->where('esi.solicitacao_cliente_id', $solicitacao_id);
            $retorno = $this->db->get()->result();


            $valortotal = 0;
            foreach ($retorno as $item) {
                $v = (float) $item->valor_venda;
                $a = (int) $item->quantidade;
                $preco = (float) $a * $v;
                $valortotal += $preco;
            }

            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($formadepagamento != '') {
                $this->db->set('forma_pagamento', $formadepagamento);
            }
            if ($formadepagamento != '') {
                $this->db->set('descricao_pagamento', $descpag);
            }


            $this->db->set('valor_total', $valortotal);
            $this->db->set('data_faturamento', $horario);
            $this->db->set('operador_faturamento', $operador_id);
            $this->db->set('faturado', 't');
            $this->db->set('estoque_solicitacao_id', $solicitacao_id);
            $this->db->insert('tb_estoque_solicitacao_faturamento');


            $this->db->set('faturado', 't');
            $this->db->where('estoque_solicitacao_setor_id', $solicitacao_id);
            $this->db->update('tb_estoque_solicitacao_cliente');

            $erro = $this->db->_error_message();
            if (trim($erro) != "") { // erro de banco
                return false;
            }
            return true;
        } catch (Exception $exc) {
            return false;
        }
    }

    function gravar() {
        try {
            /* inicia o mapeamento no banco */
            $this->db->set('cliente_id', $_POST['setor']);
            if ( $_POST['entregador'] != '' ) {
                $this->db->set('entregador', $_POST['entregador']);
            }
            if (isset($_POST['vendedor_id']) && $_POST['vendedor_id'] != '') {
                $this->db->set('vendedor_id', $_POST['vendedor_id']);
            }

            if (@$_POST['nfeenviada'] != 'true') {
                if (isset($_POST['usanota']) && @$_POST['nfeenviada'] != 'true') {
                    $this->db->set('notafiscal', 't');
                } else {
                    $this->db->set('notafiscal', 'f');
                }
            }

            $this->db->set('faturado', 'f');

            if (isset($_POST['financeiro'])) {
                $this->db->set('financeiro', 't');
            } else {
                $this->db->set('financeiro', 'f');
            }

            if (isset($_POST['boleto'])) {
                $this->db->set('boleto', 't');
            } else {
                $this->db->set('boleto', 'f');
            }

            if (isset($_POST['contrato']) && $_POST['contrato'] != '') {
                $this->db->set('contrato', 't');
                $this->db->set('contrato_id', $_POST['contrato']);
            }
            if (isset($_POST['formapagamento']) && $_POST['formapagamento'] != '') {
                $this->db->set('formadepagamento', $_POST['formapagamento']);
            }
            if (isset($_POST['descricaopagamento']) && $_POST['descricaopagamento'] != '') {
                $this->db->set('descricaopagamento', $_POST['descricaopagamento']);
            }
            if ($_POST['observacao'] != '') {
                $this->db->set('observacao', $_POST['observacao']);
            }

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            if ($_POST['solicitacao_id'] == '0') {
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_estoque_solicitacao_cliente');
                $estoque_solicitacao_id = $this->db->insert_id();
            } else {
                $estoque_solicitacao_id = $_POST['solicitacao_id'];
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('estoque_solicitacao_setor_id', $estoque_solicitacao_id);
                $this->db->update('tb_estoque_solicitacao_cliente');
            }

            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('ativo', 'f');
            $this->db->set('excluido', 't');
            $this->db->where('pedido_id', $estoque_solicitacao_id);
            $this->db->update('tb_financeiro_contasreceber');

            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('ativo', 'f');
            $this->db->where('pedido_id', $estoque_solicitacao_id);
            $this->db->update('tb_entradas');

            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('ativo', 'f');
            $this->db->where('solicitacao_cliente_id', $estoque_solicitacao_id);
            $this->db->update('tb_estoque_boleto');

            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('ativo', 'f');
            $this->db->where('estoque_solicitacao_id', $estoque_solicitacao_id);
            $this->db->update('tb_estoque_solicitacao_faturamento');

            return $estoque_solicitacao_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarentregador() {

        try {
            $this->db->set('nome', $_POST['nome']);
            if ($_POST['cpf'] != '') {
                $this->db->set('cpf', str_replace("-", "", str_replace(".", "", $_POST['cpf'])));
            }
            if ($_POST['nascimento'] != '') {
                $this->db->set('nascimento', date("Y-m-d", str_replace("/", "-", $_POST['nascimento'])));
            }
            $this->db->set('cns', $_POST['cns']);
            $this->db->set('rg', $_POST['rg']);
            $this->db->set('sexo', $_POST['sexo']);
            $this->db->set('celular', str_replace("(", "", str_replace(")", "", str_replace("-", "", $_POST['celular']))));
            $this->db->set('telefone', str_replace("(", "", str_replace(")", "", str_replace("-", "", $_POST['telefone']))));
            $this->db->set('logradouro', $_POST['endereco']);

            $this->db->set('numero', $_POST['numero']);
            $this->db->set('bairro', $_POST['bairro']);
            $this->db->set('complemento', $_POST['complemento']);
            if ($_POST['municipio_id'] != '') {
                $this->db->set('municipio_id', $_POST['municipio_id']);
            }
            $this->db->set('cep', $_POST['cep']);

            $horario = date("Y-m-d H:i:s");
//            $data = date("Y-m-d");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['entregador_id'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_entregador');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") { // erro de banco
                    return false;
                } else
                    $entregador_id = $this->db->insert_id();
            }
            else { // update
                $entregador_id = $_POST['entregador_id'];
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('entregador_id', $entregador_id);
                $this->db->update('tb_entregador');
            }


            return $paciente_id;
        } catch (Exception $exc) {
            return false;
        }
    }

    function gravarsolicitacaopaciente($setor) {
        try {
            /* inicia o mapeamento no banco */
            $this->db->set('cliente_id', $setor);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_estoque_solicitacao_cliente');
            $estoque_solicitacao_id = $this->db->insert_id();
            return $estoque_solicitacao_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function excluirsolicitacao($estoque_saida_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('estoque_solicitacao_itens_id', $estoque_saida_id);
        $this->db->update('tb_estoque_solicitacao_itens');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function excluirsaida($estoque_saida_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('estoque_saida_id', $estoque_saida_id);
        $this->db->update('tb_estoque_saida');

        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('estoque_saida_id', $estoque_saida_id);
        $this->db->update('tb_estoque_saldo');
    }

    function liberarsolicitacao($estoque_solicitacao_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('situacao', 'LIBERADA');
        $this->db->set('data_liberacao', $horario);
        $this->db->set('operador_liberacao', $operador_id);
        $this->db->where('estoque_solicitacao_setor_id', $estoque_solicitacao_id);
        $this->db->update('tb_estoque_solicitacao_cliente');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function gravarsolicitacaofaturamento($estoque_solicitacao_id, $valor) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('estoque_solicitacao_id', $estoque_solicitacao_id);
        $this->db->set('valor_total', $valor);
        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador_id);
        $this->db->insert('tb_estoque_solicitacao_faturamento');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function fecharsolicitacao($estoque_solicitacao_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('situacao', 'FECHADA');
        $this->db->set('data_fechamento', $horario);
        $this->db->set('operador_fechamento', $operador_id);
        $this->db->where('estoque_solicitacao_setor_id', $estoque_solicitacao_id);
        $this->db->update('tb_estoque_solicitacao_cliente');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function gravarsolicitacaotransportadora() {
        try {

            /* inicia o mapeamento no banco */
            $_POST['peso'] = str_replace(",", ".", $_POST['peso']);
            $_POST['valor_frete'] = str_replace(",", ".", $_POST['valor_frete']);

            $this->db->set('transportadora_id', $_POST['transportadora_id']);
            $this->db->set('solicitacao_cliente_id', $_POST['solicitacao_cliente_id']);
            $this->db->set('volume', $_POST['txtvolume']);
            $this->db->set('peso', $_POST['peso']);
            $this->db->set('valor_frete', $_POST['valor_frete']);
            $this->db->set('forma', $_POST['txtforma']);

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $solicitacaotransportadora_id = $_POST['solicitacaotransportadora_id'];
            if ($solicitacaotransportadora_id == '') { //insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_estoque_solicitacao_cliente_transportadora');
            } else { //update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('solicitacao_transportadora_id', $solicitacaotransportadora_id);
                $this->db->update('tb_estoque_solicitacao_cliente_transportadora');
            }

            $this->db->set('transportadora', 't');
            $this->db->where('estoque_solicitacao_setor_id', $_POST['solicitacao_cliente_id']);
            $this->db->update('tb_estoque_solicitacao_cliente');
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravaritens() {
        try {
            /* inicia o mapeamento no banco */
//            if ($_POST['ipi'] == '') {
//                $_POST['ipi'] = 0;
//            }
//            $_POST['icms'] = str_replace(",", ".", $_POST['icms']);
//            $_POST['ipi'] = str_replace(",", ".", $_POST['ipi']);
//            $_POST['mva'] = str_replace(",", ".", $_POST['mva']);
//            $this->db->set('icms', $_POST['icms']);
//            $this->db->set('ipi', $_POST['ipi']);
//            $this->db->set('mva', $_POST['mva']);
//            $this->db->set('codigo_cfop', str_replace('.', '', $_POST['cfop']));
//            if ($_POST['sit_trib'] != '') {
//                $this->db->set('cst', $_POST['sit_trib']);
//            }
//            if (isset($_POST['icmsst'])) {
//                $this->db->set('icmsst', 't');
//            }

            $this->db->set('solicitacao_cliente_id', $_POST['txtestoque_solicitacao_id']);
            $this->db->set('quantidade', $_POST['txtqtde']);
            $this->db->set('valor', $_POST['valor']);
            $this->db->set('produto_id', $_POST['produto_id']);

            if ($_POST['lote'] != '') {
                $this->db->set('entrada_id', $_POST['lote']);
            }

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_estoque_solicitacao_itens');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
                $estoque_solicitacao_produtos_id = $this->db->insert_id();

            return $estoque_solicitacao_produtos_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function finalizarsaidapedido($solicitacao_id) {
        try {
            /* inicia o mapeamento no banco */
            $this->db->select('sum(esi.quantidade) as qtde,
                               esi.produto_id,
                               esi.entrada_id,
                               esi.estoque_solicitacao_itens_id,
                               ee.fornecedor_id,
                               ee.armazem_id,
                               ee.nota_fiscal,
                               ee.validade,
                               (sum(esi.quantidade) * esi.valor)  as valor');
            $this->db->from('tb_estoque_solicitacao_itens esi');
            $this->db->where("esi.ativo", 't');
            $this->db->where("solicitacao_cliente_id", $solicitacao_id);
            $this->db->join('tb_estoque_entrada ee', 'ee.estoque_entrada_id = esi.entrada_id', 'left');
            $this->db->groupby('esi.produto_id,
                                esi.entrada_id,
                                esi.estoque_solicitacao_itens_id,
                                ee.fornecedor_id,
                                ee.armazem_id,
                                ee.nota_fiscal,
                                ee.validade,');
            $query = $this->db->get();
            $returno = $query->result();

            for ($i = 0; $i < count($returno); $i++) {
                $estoque_entrada_id = $returno[$i]->entrada_id;
                $this->db->set('estoque_entrada_id', $estoque_entrada_id);
                $this->db->set('estoque_solicitacao_itens_id', $returno[$i]->estoque_solicitacao_itens_id);
                $this->db->set('solicitacao_cliente_id', $solicitacao_id);

                $this->db->set('produto_id', $returno[$i]->produto_id);
                $this->db->set('fornecedor_id', $returno[$i]->fornecedor_id);
                $this->db->set('armazem_id', $returno[$i]->armazem_id);
                $this->db->set('valor_venda', $returno[$i]->valor);
                $this->db->set('quantidade', $returno[$i]->qtde);
                $this->db->set('nota_fiscal', $returno[$i]->nota_fiscal);
                if ($returno[$i]->validade != "") {
                    $this->db->set('validade', $returno[$i]->validade);
                }
                $horario = date("Y-m-d H:i:s");
                $operador_id = $this->session->userdata('operador_id');

                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_estoque_saida');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $estoque_saida_id = $this->db->insert_id();

                $this->db->set('estoque_entrada_id', $estoque_entrada_id);
                $this->db->set('estoque_saida_id', $estoque_saida_id);
                $this->db->set('produto_id', $returno[$i]->produto_id);
                $this->db->set('fornecedor_id', $returno[$i]->fornecedor_id);
                $this->db->set('armazem_id', $returno[$i]->armazem_id);
                $this->db->set('valor_compra', $returno[$i]->valor);
                $quantidade = -1 * $returno[$i]->qtde;
                $this->db->set('quantidade', $quantidade);
                $this->db->set('nota_fiscal', $returno[$i]->nota_fiscal);
                if ($returno[$i]->validade != "") {
                    $this->db->set('validade', $returno[$i]->validade);
                }
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_estoque_saldo');

                $horario = date("Y-m-d H:i:s");
                $operador_id = $this->session->userdata('operador_id');
            }
            $this->db->set('situacao', 'FECHADA');
            $this->db->set('data_fechamento', $horario);
            $this->db->set('operador_fechamento', $operador_id);
            $this->db->where('estoque_solicitacao_setor_id', $solicitacao_id);
            $this->db->update('tb_estoque_solicitacao_cliente');
            return true;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarsaidaitens() {
        try {
            /* inicia o mapeamento no banco */
            $this->db->select('estoque_entrada_id,
                            produto_id,
                            fornecedor_id,
                            armazem_id,
                            valor_compra,
                            quantidade,
                            nota_fiscal,
                            validade');
            $this->db->from('tb_estoque_entrada');
            $this->db->where("estoque_entrada_id", $_POST['produto_id']);
            $query = $this->db->get();
            $returno = $query->result();

            $this->db->select('valor');
            $this->db->from('tb_estoque_solicitacao_itens');
            $this->db->where("estoque_solicitacao_itens_id", $_POST['txtestoque_solicitacao_itens_id']);
            $query = $this->db->get();
            $returno2 = $query->result();

            $estoque_entrada_id = $_POST['produto_id'];
            $this->db->set('estoque_entrada_id', $estoque_entrada_id);
            $this->db->set('estoque_solicitacao_itens_id', $_POST['txtestoque_solicitacao_itens_id']);
            $this->db->set('solicitacao_cliente_id', $_POST['txtestoque_solicitacao_id']);
            if ($_POST['txtexame'] != '') {
                $this->db->set('exames_id', $_POST['txtexame']);
            }
            $this->db->set('produto_id', $returno[0]->produto_id);
            $this->db->set('fornecedor_id', $returno[0]->fornecedor_id);
            $this->db->set('armazem_id', $returno[0]->armazem_id);
            $this->db->set('valor_venda', $returno2[0]->valor);
            $this->db->set('quantidade', str_replace(",", ".", str_replace(".", "", $_POST['txtqtde'])));
            $this->db->set('nota_fiscal', $returno[0]->nota_fiscal);
            if ($returno[0]->validade != "") {
                $this->db->set('validade', $returno[0]->validade);
            }
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_estoque_saida');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
                $estoque_saida_id = $this->db->insert_id();

            $this->db->set('estoque_entrada_id', $estoque_entrada_id);
            $this->db->set('estoque_saida_id', $estoque_saida_id);
            $this->db->set('produto_id', $returno[0]->produto_id);
            $this->db->set('fornecedor_id', $returno[0]->fornecedor_id);
            $this->db->set('armazem_id', $returno[0]->armazem_id);
            $this->db->set('valor_compra', $returno2[0]->valor);
            $quantidade = -(str_replace(",", ".", str_replace(".", "", $_POST['txtqtde'])));
            $this->db->set('quantidade', $quantidade);
            $this->db->set('nota_fiscal', $returno[0]->nota_fiscal);
            if ($returno[0]->validade != "") {
                $this->db->set('validade', $returno[0]->validade);
            }
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_estoque_saldo');
            return $estoque_saida_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    private
            function instanciar($estoque_solicitacao_id) {

        if ($estoque_solicitacao_id != 0) {
            $this->db->select('es.estoque_solicitacao_setor_id, 
                               es.cliente_id, 
                               es.vendedor_id, 
                               es.descricaopagamento, 
                               es.formadepagamento, 
                               es.boleto,
                               es.notafiscal,
                               es.financeiro,
                               n.enviada');
            $this->db->from('tb_estoque_solicitacao_cliente es');
            $this->db->where("estoque_solicitacao_setor_id", $estoque_solicitacao_id);
            $this->db->join('tb_notafiscal n', 'n.solicitacao_cliente_id = es.estoque_solicitacao_setor_id', 'left');
            $query = $this->db->get();
            $return = $query->result();
            $this->_estoque_solicitacao_id = $estoque_solicitacao_id;
//            $this->_descricao = $return[0]->descricao;
            $this->_cliente_id = $return[0]->cliente_id;
            $this->_vendedor_id = $return[0]->vendedor_id;
            $this->_boleto = $return[0]->boleto;
            $this->_notafiscal = $return[0]->notafiscal;
            $this->_financeiro = $return[0]->financeiro;
            $this->_enviada = $return[0]->enviada;
            $this->_descricaopagamento = $return[0]->descricaopagamento;
            $this->_formadepagamento = $return[0]->formadepagamento;
        } else {
            $this->_estoque_solicitacao_id = 0;
        }
    }

}

?>
