<?php

require_once APPPATH . 'controllers/base/BaseController.php';

/**
 * Esta transportadora é o controler de Servidor. Responsável por chamar as funções e views, efetuando as chamadas de models
 * @author Equipe de desenvolvimento APH
 * @version 1.0
 * @copyright Prefeitura de Fortaleza
 * @access public
 * @package Model
 * @subpackage GIAH
 */
class Transportadora extends BaseController {

    function Transportadora() {
        parent::Controller();
        $this->load->model('estoque/transportadora_model', 'transportadora');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index() {
        $this->pesquisar();
    }

    function pesquisar($args = array()) {

        $this->loadView('estoque/transportadora-lista', $args);

//            $this->carregarView($data);
    }

    function carregartransportadora($estoque_transportadora_id) {
        $obj_transportadora = new transportadora_model($estoque_transportadora_id);
        $data['obj'] = $obj_transportadora;
        $this->loadView('estoque/transportadora-form', $data);
    }

    function excluir($estoque_transportadora_id) {
        $valida = $this->transportadora->excluir($estoque_transportadora_id);
        if ($valida == 0) {
            $data['mensagem'] = 'Sucesso ao excluir a Transportadora';
        } else {
            $data['mensagem'] = 'Erro ao excluir a transportadora. Opera&ccedil;&atilde;o cancelada.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "estoque/transportadora");
    }

    function gravar() {
        $exame_transportadora_id = $this->transportadora->gravar();
        if ($exame_transportadora_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Transportadora. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Transportadora.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "estoque/transportadora");
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
