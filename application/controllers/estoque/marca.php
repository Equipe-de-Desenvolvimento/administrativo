<?php

require_once APPPATH . 'controllers/base/BaseController.php';

/**
 * Esta marca é o controler de Servidor. Responsável por chamar as funções e views, efetuando as chamadas de models
 * @author Equipe de desenvolvimento APH
 * @version 1.0
 * @copyright Prefeitura de Fortaleza
 * @access public
 * @package Model
 * @subpackage GIAH
 */
class Marca extends BaseController {

    function Marca() {
        parent::Controller();
        $this->load->model('estoque/marca_model', 'marca');
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

        $this->loadView('estoque/marca-lista', $args);

//            $this->carregarView($data);
    }

    function carregarmarca($estoque_marca_id) {
        $obj_marca = new marca_model($estoque_marca_id);
        $data['obj'] = $obj_marca;
        
        $data['tipo'] = $this->fornecedor->listartipo();
        $this->loadView('estoque/marca-form', $data);
    }

    function excluir($estoque_marca_id) {
        $valida = $this->marca->excluir($estoque_marca_id);
        if ($valida == 0) {
            $data['mensagem'] = 'Sucesso ao excluir a Marca';
        } else {
            $data['mensagem'] = 'Erro ao excluir a marca. Opera&ccedil;&atilde;o cancelada.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "estoque/marca");
    }

    function gravar() {
        $exame_marca_id = $this->marca->gravar();
        if ($exame_marca_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Marca. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Marca.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "estoque/marca");
    }
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
