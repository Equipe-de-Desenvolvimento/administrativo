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
class Notafiscal extends BaseController {

    function Notafiscal() {
        parent::Controller();
        $this->load->model('estoque/notafiscal_model', 'notafiscal');
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

        $this->loadView('estoque/notafiscal-lista', $args);
    }

    function carregarnotafiscalopcoes($solicitacao_cliente_id) {
        $data['solicitacao_cliente_id'] = $solicitacao_cliente_id;
        $this->loadView('estoque/notafiscal-ficha', $data);
    }

    function gerarnotafiscal($solicitacao_cliente_id) {
        $data['empresa'] = $this->notafiscal->empresa();
        $data['destinatario'] = $this->notafiscal->listaclientenotafiscal($solicitacao_cliente_id);
        $data['produtos'] = $this->notafiscal->listarsolicitacaosnota($solicitacao_cliente_id);

        //WEB SERVICE do NFePHP
        die('Ainda não esta finalizado!');
    }

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
