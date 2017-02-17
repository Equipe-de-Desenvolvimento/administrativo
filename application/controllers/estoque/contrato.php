<?php

require_once APPPATH . 'controllers/base/BaseController.php';

/**
 * Esta classe é o controler de Servidor. Responsável por chamar as funções e views, efetuando as chamadas de models
 * @author Equipe de desenvolvimento APH
 * @version 1.0
 * @copyright Prefeitura de Fortaleza
 * @access public
 * @package Model
 * @subpackage GIAH
 */
class Contrato extends BaseController {

    function Contrato() {
        parent::Controller();
        $this->load->model('estoque/contrato_model', 'contrato');
        $this->load->model('cadastro/convenio_model', 'convenio');
        $this->load->model('estoque/fornecedor_model', 'fornecedor');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index() {
        $this->pesquisar();
    }

    function pesquisar($args = array()) {

        $this->loadView('estoque/contrato-lista', $args);

//            $this->carregarView($data);
    }

    function pesquisarcontratotipo($args = array()) {
//        die('ola');
        $this->loadView('estoque/contratotipo-lista', $args);

//            $this->carregarView($data);
    }

    function carregarcontrato($estoque_contrato_id) {
        $obj_contrato = new contrato_model($estoque_contrato_id);
        $data['obj'] = $obj_contrato;
        $data['forma_pagamento'] = $this->contrato->listarformapagamento();
        $data['clientes'] = $this->contrato->listarclientes();
        $data['tipo_contrato'] = $this->contrato->listartipos();
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('estoque/contrato-form', $data);
    }

    function carregarcontratotipo($contratotipo_id) {
        $data['tipo'] = $this->contrato->carregarcontratotipo($contratotipo_id);
        $this->loadView('estoque/contratotipo-form', $data);
    }

    function excluircontratotipo($contratotipo_id) {
        $valida = $this->contrato->excluircontratotipo($contratotipo_id);
        if ($valida == 0) {
            $data['mensagem'] = 'Sucesso ao excluir a Tipo';
        } else {
            $data['mensagem'] = 'Erro ao excluir a Tipo. Opera&ccedil;&atilde;o cancelada.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "estoque/contrato/pesquisarcontratotipo");
    }
    function excluir($estoque_contrato_id) {
        $valida = $this->contrato->excluir($estoque_contrato_id);
        if ($valida == 0) {
            $data['mensagem'] = 'Sucesso ao excluir a Contrato';
        } else {
            $data['mensagem'] = 'Erro ao excluir a contrato. Opera&ccedil;&atilde;o cancelada.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "estoque/contrato");
    }

    function contratosetor($operador_id) {

        $data['operadores'] = $this->contrato->listaroperadores($operador_id);
        $data['contratos'] = $this->contrato->listarcontratos();
        $data['contador'] = $this->contrato->contador($operador_id);
        if ($data['contador'] > 0) {
            $data['contrato'] = $this->contrato->listarcontrato($operador_id);
        }
        $this->loadView('estoque/contratosoperador-form', $data);
    }

    function gravarcontratos() {
        $operador_id = $_POST['txtoperador_id'];        
        $contratos_id = $_POST['contratos_id'];
        $data['contrato'] = $this->contrato->testacontratorepetidos($contratos_id);
        if ( count($data['contrato']) == 0 ){
            $this->contrato->gravarcontratos();
        }
        $this->contratosetor($operador_id);
    }

    function excluircontratos($operado_contrato, $operador_id) {
        $this->contrato->excluircontratos($operado_contrato);
        $this->contratosetor($operador_id);
    }

    function gravarcontratotipo() {
        $verifica = $this->contrato->gravarcontratotipo();
        if ($verifica == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Tipo. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Tipo.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "estoque/contrato/pesquisarcontratotipo");
    }

    function gravar() {
//        echo "<pre>";
//        var_dump($_POST); die;
        $exame_contrato_id = $this->contrato->gravar();
        if ($exame_contrato_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Contrato. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Contrato.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "estoque/contrato");
    }

    private function carregarView($data = null, $view = null) {
        if (!isset($data)) {
            $data['mensagem'] = '';
        }

        if ($this->utilitario->autorizar(2, $this->session->userdata('modulo')) == true) {
            $this->load->view('header', $data);
            if ($view != null) {
                $this->load->view($view, $data);
            } else {
                $this->load->view('giah/servidor-lista', $data);
            }
        } else {
            $data['mensagem'] = $this->mensagem->getMensagem('login005');
            $this->load->view('header', $data);
            $this->load->view('home');
        }
        $this->load->view('footer');
    }

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
