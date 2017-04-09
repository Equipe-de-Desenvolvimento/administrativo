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
class Empresa extends BaseController {

    function Empresa() {
        parent::Controller();
        $this->load->model('ambulatorio/empresa_model', 'empresa');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index() {
        $this->pesquisar();
    }

    function pesquisar($args = array()) {

        $this->loadView('ambulatorio/empresa-lista', $args);

//            $this->carregarView($data);
    }

    function carregarempresa($exame_empresa_id) {
        $obj_empresa = new empresa_model($exame_empresa_id);
        $data['obj'] = $obj_empresa;
        //$this->carregarView($data, 'giah/servidor-form');
        $this->loadView('ambulatorio/empresa-form', $data);
    }

    function importarcertificado() {
        $empresa_id = $_POST['empresa_id'];
        $this->load->helper('directory');
        if (!is_dir("./upload/certificado")) {
            mkdir("./upload/certificado");
            $destino = "./upload/certificado";
            chmod($destino, 0777);
        }

        if (!is_dir("./upload/certificado/$empresa_id")) {
            mkdir("./upload/certificado/$empresa_id");
            $destino = "./upload/certificado/$empresa_id";
            chmod($destino, 0777);
        }

        $verifica = $data['arquivo_pasta'] = directory_map("/home/ubuntu/projetos/administrativo/upload/certificado/$empresa_id");
        $teste = false;
        foreach ($verifica as $chave => $valor) {
            if ($chave == "excluidos") {
                continue;
            }

            $ext = explode('.', $valor);
            if ($ext[1] == 'pfx') {
                $teste = true;
            }
        }
        if ($teste) {
            $mensagem = 'Erro. Ja ha um certificado para esta empresa.';
        } else {
            if(count($verifica) > 0) { 
                // Caso nao tenha arquivo pfx mas tenha os outros arquivos (necessarios para assinatura digital)
                if (!is_dir("./upload/certificado/$empresa_id/excluidos")) {
                    mkdir("./upload/certificado/$empresa_id/excluidos");
                    $pasta = "./upload/certificado/$empresa_id/excluidos";
                    chmod($pasta, 0777);
                }

                foreach ($verifica as $chave => $valor) {
                    if ($chave == "excluidos") {
                        continue;
                    }

                    $origem = "./upload/certificado/$empresa_id/$valor";
                    $destino = "./upload/certificado/$empresa_id/excluidos/$valor";
                    copy($origem, $destino);
                    unlink($origem);
                }
            }

            $extensao = explode('.', $_FILES["userfile"]['name']);
            if ($extensao[1] == 'pfx') {
                $config['upload_path'] = "/home/ubuntu/projetos/administrativo/upload/certificado/" . $empresa_id . "/";
                $config['allowed_types'] = 'pfx';
                $config['overwrite'] = TRUE;
                $config['encrypt_name'] = TRUE;
                $this->load->library('upload', $config);

                if (!$this->upload->do_upload()) {
                    $error = array('error' => $this->upload->display_errors());
                } else {
                    $error = null;
                    $data = array('upload_data' => $this->upload->data());
                }
                $this->empresa->salvarcertificado();
                $mensagem = 'Certificado salvo com sucesso.';
            }
        }
        //gerando arquivos 
        $obj_empresa = new empresa_model($empresa_id);
        require_once ('/home/ubuntu/projetos/administrativo/application/libraries/nfephp/arquivosNfe/geraCertsNFe.php');
        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/empresa/carregarempresacertificado/$empresa_id");
    }

    function excluircertificado($empresa_id, $arquivo) {
        if (!is_dir("./upload/certificado/$empresa_id/excluidos")) {
            mkdir("./upload/certificado/$empresa_id/excluidos");
            $pasta = "./upload/certificado/$empresa_id/excluidos";
            chmod($pasta, 0777);
        }
        $origem = "./upload/certificado/$empresa_id/$arquivo";
        $destino = "./upload/certificado/$empresa_id/excluidos/$arquivo";
        copy($origem, $destino);
        unlink($origem);
        $this->empresa->removercertificado($empresa_id);
        redirect(base_url() . "ambulatorio/empresa/carregarempresacertificado/$empresa_id");
    }

    function carregarempresacertificado($empresa_id) {
        $obj_empresa = new empresa_model($empresa_id);
        $data['obj'] = $obj_empresa;

        $data['empresa_id'] = $empresa_id;
        $this->load->helper('directory');

        $data['arquivo_pasta'] = directory_map("/home/ubuntu/projetos/administrativo/upload/certificado/$empresa_id");
        if ($data['arquivo_pasta'] != false) {
            sort($data['arquivo_pasta']);
        }
        $data['arquivos_deletados'] = directory_map("/home/ubuntu/projetos/administrativo/upload/certificado/$empresa_id/excluidos");
        $this->loadView('ambulatorio/empresacertificado', $data);
    }

    function excluir($exame_empresa_id) {
        if ($this->procedimento->excluir($exame_empresa_id)) {
            $mensagem = 'Sucesso ao excluir a Empresa';
        } else {
            $mensagem = 'Erro ao excluir a empresa. Opera&ccedil;&atilde;o cancelada.';
        }

        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "ambulatorio/empresa");
    }

    function gravar() {
        $empresa_id = $this->empresa->gravar();
        if ($empresa_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Empresa. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Empresa.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/empresa");
    }

    function ativar($exame_empresa_id) {
        $this->empresa->ativar($exame_empresa_id);
        $data['mensagem'] = 'Sucesso ao ativar a Empresa.';
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "ambulatorio/empresa");
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
