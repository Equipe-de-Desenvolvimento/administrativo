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
class Boleto extends BaseController {

    function Boleto() {
        parent::Controller();
        $this->load->model('estoque/boleto_model', 'boleto');
        $this->load->model('cadastro/convenio_model', 'convenio');
        $this->load->model('estoque/fornecedor_model', 'fornecedor');
        $this->load->library('mensagem');
//        $this->load->library('barcode_i2_5');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index() {
        $this->pesquisar();
    }

    function pesquisar($args = array()) {

        $this->loadView('estoque/boleto-lista', $args);
    }

    function carregarboletoscontrato($contrato_id) {
        $data['contrato_id'] = $contrato_id;
        $data['boletos'] = $this->boleto->listarsolicitacaoboletocontrato($contrato_id);
//        var_dump(count($data['boletos']));die;
        if (count($data['boletos']) > 1) {
            $this->loadView('estoque/solicitacaoboletocontrato', $data);
        } else {
            $estoque_boleto_id = $data['boletos'][0]->estoque_boleto_id;
            redirect(base_url() . "estoque/boleto/solicitacaoboletocontrato/$estoque_boleto_id");
        }
    }
    
    function carregarboletos($solicitacao_cliente_id) {

        $data['solicitacao_cliente_id'] = $solicitacao_cliente_id;
        $data['boletos'] = $this->boleto->listarsolicitacaoboleto($solicitacao_cliente_id);
//        var_dump($data['boletos']);die;
        if (count($data['boletos']) > 1) {
            $this->loadView('estoque/solicitacaoboleto', $data);
        } else {
            $estoque_boleto_id = $data['boletos'][0]->estoque_boleto_id;
            redirect(base_url() . "estoque/boleto/solicitacaoboleto/$estoque_boleto_id");
        }
    }

    function solicitacaoboletocontrato($estoque_boleto_id) {
//        $estoque_boleto_id;
        $data['boleto'] = $this->boleto->instanciarboleto($estoque_boleto_id);
        $contrato_id = $data['boleto'][0]->contrato_id;
        $data['conta'] = $this->boleto->listarcontaboletocontrato($contrato_id);
        $data['devedor'] = $this->boleto->listarcredordevedorcontrato($contrato_id);
//        echo "<pre>";
//        var_dump($data['conta']);die;
        $this->loadView('estoque/dadosboletocontrato', $data);
    }

    function solicitacaoboleto($estoque_boleto_id) {
        $estoque_boleto_id;
//        var_dump($estoque_boleto_id);die;
        $data['boleto'] = $this->boleto->instanciarboleto($estoque_boleto_id);
        $descricao_id = $data['boleto'][0]->descricaopagamento_id;
        $data['conta'] = $this->boleto->listarcontaboleto($descricao_id);
//        echo "<pre>";
//        var_dump($data['conta']);die;
        $this->loadView('estoque/dadosboleto', $data);
    }

    function selecionabancoboleto($estoque_boleto_id) {
        $data['estoque_boleto_id'] = $estoque_boleto_id;
        $data['bancos'] = $this->boleto->listarbancos();
        $this->loadView('estoque/boletobanco-form', $data);
    }

    function gerarboleto033($estoque_boleto_id) {
        $data['estoque_boleto_id'] = $estoque_boleto_id;
        $data['boleto'] = $this->boleto->instanciarboleto($estoque_boleto_id);
        $this->loadView('estoque/boletosantander-form', $data);
    }

    function gerarboleto004($estoque_boleto_id) {
        $data['estoque_boleto_id'] = $estoque_boleto_id;
        $data['boleto'] = $this->boleto->instanciarboleto($estoque_boleto_id);
        $this->loadView('estoque/boletobnb-form', $data);
    }

    function imprimirboletobnb($estoque_boleto_id) {
        $data['estoque_boleto_id'] = $estoque_boleto_id;
        $data['boleto'] = $this->boleto->instanciarboleto($estoque_boleto_id);
        $data['empresa'] = $this->boleto->empresaboleto();
        $this->load->view('estoque/impressaoboletobnb', $data);
    }

    function gerarboletosbnb($solicitacao_cliente_id) {
        $data['solicitacao_cliente_id'] = $solicitacao_cliente_id;
//        $data['boleto'] = $this->boleto->instanciarboleto($estoque_boleto_id);
        $this->loadView('estoque/boletosbnb-form', $data);
    }

    function gerarboletocontratobnb($estoque_boleto_id) {
        $data['estoque_boleto_id'] = $estoque_boleto_id;
        $data['boleto'] = $this->boleto->instanciarboleto($estoque_boleto_id);
        $this->loadView('estoque/boletocontratobnb-form', $data);
    }

    function criarboletosantander() {
        $solicitacao_id = $_POST['solicitacao_cliente_id'];
        $boletos = $this->boleto->listarsolicitacaoboletoscnab($solicitacao_id);

        $_POST['mensagem'] = mb_strtoupper($this->remover_caracter(utf8_decode($_POST['mensagem'])));
        $_POST['juros'] = str_replace(',', '.', str_replace('.', '', $_POST['juros']));
        $_POST['seu_numero'] = $this->tamanho_string(date('dmyHi'), 10, 'numero');

        foreach ($boletos as $item) {
            $_POST['nosso_numero'] = $this->tamanho_string($item->estoque_boleto_id, 7, 'numero');
            $_POST['numDoc'] = $this->tamanho_string($item->estoque_boleto_id, 25, 'numero');
            $_POST['vencimento'] = $item->data_vencimento;
            $this->boleto->gravardadoscnabtodos($item->estoque_boleto_id);
            $this->geracnabSATANDER($item->estoque_boleto_id);
        }
        $mensagem = 'Boletos gerado com sucesso.';
        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "estoque/boleto/carregarboletos/$solicitacao_id");
    }

    function criarboletosbanconordestetodos() {
        $solicitacao_id = $_POST['solicitacao_cliente_id'];
        $boletos = $this->boleto->listarsolicitacaoboletoscnab($solicitacao_id);

        $_POST['mensagem'] = mb_strtoupper($this->remover_caracter(utf8_decode($_POST['mensagem'])));
        $_POST['juros'] = str_replace(',', '.', str_replace('.', '', $_POST['juros']));
        $_POST['seu_numero'] = $this->tamanho_string(date('dmyHi'), 10, 'numero');

        foreach ($boletos as $item) {
            $_POST['nosso_numero'] = $this->tamanho_string($item->estoque_boleto_id, 7, 'numero');
            $_POST['numDoc'] = $this->tamanho_string($item->estoque_boleto_id, 25, 'numero');
            $_POST['vencimento'] = $item->data_vencimento;
            $this->boleto->gravardadoscnabtodos($item->estoque_boleto_id);
            $this->geracnabBNB($item->estoque_boleto_id);
        }
        $mensagem = 'Boletos gerado com sucesso.';
        $this->session->set_flashdata('message', $mensagem);
        redirect(base_url() . "estoque/boleto/carregarboletos/$solicitacao_id");
    }

    function criarboletocontratobanconordeste() {
//        $data['boleto'] = $this->boleto->instanciarboleto($_POST['estoque_boleto_id']);
        $nosso_numero = $_POST['estoque_boleto_id'];

        $_POST['mensagem'] = mb_strtoupper($this->remover_caracter(utf8_decode($_POST['mensagem'])));
        $_POST['juros'] = str_replace(',', '.', str_replace('.', '', $_POST['juros']));
        $_POST['multa'] = str_replace(',', '.', str_replace('.', '', $_POST['multa']));
        $_POST['seu_numero'] = $this->tamanho_string(date('dmyH:i'), 10, 'numero');
        $_POST['nosso_numero'] = $this->tamanho_string($_POST['estoque_boleto_id'], 7, 'numero');
        $_POST['numDoc'] = $this->tamanho_string($_POST['estoque_boleto_id'], 25, 'numero');
        $_POST['vencimento'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['vencimento'])));

        $this->boleto->gravardadoscnab();
        $estoque_boleto_id = $_POST['estoque_boleto_id'];
        $this->geracnabBNB($estoque_boleto_id);
        redirect(base_url() . "estoque/boleto/solicitacaoboleto/$estoque_boleto_id");
    }

    function criarboletobanconordeste() {
//        $data['boleto'] = $this->boleto->instanciarboleto($_POST['estoque_boleto_id']);
        $nosso_numero = $_POST['estoque_boleto_id'];

        $_POST['mensagem'] = mb_strtoupper($this->remover_caracter(utf8_decode($_POST['mensagem'])));
        $_POST['juros'] = str_replace(',', '.', str_replace('.', '', $_POST['juros']));
        $_POST['multa'] = str_replace(',', '.', str_replace('.', '', $_POST['multa']));
        $_POST['seu_numero'] = $this->tamanho_string(date('dmyH:i'), 10, 'numero');
        $_POST['nosso_numero'] = $this->tamanho_string($_POST['estoque_boleto_id'], 7, 'numero');
        $_POST['numDoc'] = $this->tamanho_string($_POST['estoque_boleto_id'], 25, 'numero');
        $_POST['vencimento'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['vencimento'])));

        $this->boleto->gravardadoscnab();
        $estoque_boleto_id = $_POST['estoque_boleto_id'];
        $this->geracnabBNB($estoque_boleto_id);
        redirect(base_url() . "estoque/boleto/solicitacaoboleto/$estoque_boleto_id");
    }

    function filler($tamanho) {

        $filler = "";
        for ($i = 0; $i < $tamanho; $i++) {
            $filler .= "_";
        }
        $filler = str_replace("_", " ", $filler);
        return $filler;
    }

    function zeros($tamanho) {

        $zero = "";
        for ($i = 0; $i < $tamanho; $i++) {
            $zero .= "0";
        }
        return $zero;
    }

    function remover_caracter($string) {
        $string = preg_replace("/[áàâãä]/", "a", $string);
        $string = preg_replace("/[ÁÀÂÃÄ]/", "A", $string);
        $string = preg_replace("/[éèê]/", "e", $string);
        $string = preg_replace("/[ÉÈÊ]/", "E", $string);
        $string = preg_replace("/[íì]/", "i", $string);
        $string = preg_replace("/[ÍÌ]/", "I", $string);
        $string = preg_replace("/[óòôõö]/", "o", $string);
        $string = preg_replace("/[ÓÒÔÕÖ]/", "O", $string);
        $string = preg_replace("/[úùü]/", "u", $string);
        $string = preg_replace("/[ÚÙÜ]/", "U", $string);
        $string = preg_replace("/ç/", "c", $string);
        $string = preg_replace("/Ç/", "C", $string);
        $string = preg_replace("/[][><}{)(:;,!?*%~^`@\.-]/", "", $string);
        return $string;
    }

    function tamanho_string($texto, $tamCampo, $tipo = 'text') {
        if ($tipo == 'text') {
            $tamanho = strlen($texto);
            if ($tamanho < $tamCampo) {
                $diferenca = (int) $tamCampo - (int) $tamanho;
                $texto .= $this->filler($diferenca);
            } elseif ($tamanho > $tamCampo) {
                $texto = substr($texto, 0, $tamCampo);
            }
            return $texto;
        } else {
            $tamanho = strlen($texto);
            $zeros = '';
            if ($tamanho < $tamCampo) {
                $diferenca = (int) $tamCampo - (int) $tamanho;
                $zeros .= $this->zeros($diferenca);
            } elseif ($tamanho > $tamCampo) {
                $texto = substr($texto, 0, $tamCampo);
            }
            $texto = $zeros . $texto;
            return $texto;
        }
    }

    function digito_nosso_numero($nossoNum) {
        $nossoNum = (string) $nossoNum;
        $algarismos = array(
            "um" => (int) substr($nossoNum, 0, 1),
            "dois" => (int) substr($nossoNum, 1, 1),
            "tres" => (int) substr($nossoNum, 2, 1),
            "quatro" => (int) substr($nossoNum, 3, 1),
            "cinco" => (int) substr($nossoNum, 4, 1),
            "seis" => (int) substr($nossoNum, 5, 1),
            "sete" => (int) substr($nossoNum, 6, 1)
        );
        $soma = 0;
        $i = 8;
        foreach ($algarismos as $value) {
            $soma = + $value * $i;
            $i--;
        }
        $modulo = $soma % 11;
        if ($modulo === 0 || $modulo === 1) {
            $digito = 0;
        } else {
            $digito = 11 - $modulo;
        }
        return $digito;
    }

    function geracnabBNB($estoque_boleto_id) {
        $data['empresa'] = $this->boleto->empresaboleto();
        $data['boleto'] = $this->boleto->instanciarboleto($estoque_boleto_id);

        $data['destinatario'] = $this->boleto->listaclienteboleto($data['boleto'][0]->solicitacao_cliente_id);
        $data['conta'] = $this->boleto->listarcontaboleto($data['boleto'][0]->descricaopagamento_id);
        $data['dados_faturamento'] = $this->boleto->listasolicitacaofaturamento($data['boleto'][0]->solicitacao_cliente_id);

        $nossoNumero = $this->tamanho_string($data['boleto'][0]->nosso_numero, 7, 'numero');
        $seuNumero = $this->tamanho_string($data['boleto'][0]->seu_numero, 10, 'numero');
        $numeroDoc = $this->tamanho_string($data['boleto'][0]->numero_documento, 25, 'numero');

        $carteira = $data['boleto'][0]->carteira;
        $especie = $data['boleto'][0]->especie_documento;
        $aceite = $data['boleto'][0]->aceite;
        $servico = $data['boleto'][0]->servico;
        $instrucao = $data['boleto'][0]->instrucao_boleto;
        $mensagem = $data['boleto'][0]->mensagem_cedente;
        $data_venc = date("dmy", strtotime($data['boleto'][0]->data_vencimento));

        //tratando os valores
        $valor = str_replace('.', '', $data['boleto'][0]->valor);
        $juros = str_replace('.', '', $data['boleto'][0]->juros);

        //tratando os textos para se adequarem ao padrao CNAB400
        //tratando acentuações e caracteres especiais
        $data['empresa'][0]->logradouro = mb_strtoupper($this->remover_caracter(utf8_decode($data['empresa'][0]->logradouro)));
        $data['empresa'][0]->estado = mb_strtoupper($this->remover_caracter(utf8_decode($data['empresa'][0]->estado)));
        $data['empresa'][0]->municipio = mb_strtoupper($this->remover_caracter(utf8_decode($data['empresa'][0]->municipio)));
        $data['empresa'][0]->razao_social = mb_strtoupper($this->remover_caracter(utf8_decode($data['empresa'][0]->razao_social)));

        $data['destinatario'][0]->nome = mb_strtoupper($this->remover_caracter(utf8_decode($data['destinatario'][0]->nome)));
        $data['destinatario'][0]->logradouro = mb_strtoupper($this->remover_caracter(utf8_decode($data['destinatario'][0]->logradouro)));
        $data['destinatario'][0]->bairro = mb_strtoupper($this->remover_caracter(utf8_decode($data['destinatario'][0]->bairro)));
        $data['destinatario'][0]->complemento = mb_strtoupper($this->remover_caracter(utf8_decode($data['destinatario'][0]->complemento)));
        $data['destinatario'][0]->municipio = mb_strtoupper($this->remover_caracter(utf8_decode($data['destinatario'][0]->municipio)));
        $data['destinatario'][0]->estado = mb_strtoupper($this->remover_caracter(utf8_decode($data['destinatario'][0]->estado)));
        $data['destinatario'][0]->cep = $this->remover_caracter($data['destinatario'][0]->cep);
        $data['destinatario'][0]->cnpj = $this->remover_caracter($data['destinatario'][0]->cnpj);
        $data['destinatario'][0]->endereco = $data['destinatario'][0]->logradouro . ' ' . $data['destinatario'][0]->numero . ' ' . $data['destinatario'][0]->bairro;

        $data['conta'][0]->conta = $this->remover_caracter($data['conta'][0]->conta);
        $data['conta'][0]->agencia = $this->remover_caracter($data['conta'][0]->agencia);

        $header = array(
            "codigo_registro" => '0',
            "indentificacao_arquivo_remessa" => '1',
            "indentificacao_extenso" => "REMESSA",
            "codigo_servico" => '01',
            "literal_servico" => "COBRANCA       ",
            "agencia_cedente" => $data['conta'][0]->agencia, //@@ 4 digitos 
            "filler" => '00',
            "conta_cedente" => $data['conta'][0]->conta, //** 7 digitos
            "digito_conta" => $data['conta'][0]->digito, //** 1 digito
            "filler2" => $this->filler(6),
            "nome_cedente" => $this->tamanho_string($data['empresa'][0]->empresa, 30), //@@ 30 caracteres
            "numero_banco" => '004',
            "nome_banco" => 'B. DO NORDESTE ',
            "data_arquivo" => date("dmy"), //@@
            "cod_usuario" => $this->zeros(3), //** 3 digitos (Caixa Postal sistema EDI, fornecido pelo Banco)
            "filler3" => $this->filler(291),
            "sequencial_reg" => '000001'
        );

        $transacao = array(
            "cod_registro" => '1',
            "filler" => $this->filler(16),
            "agencia_cedente" => $data['conta'][0]->agencia, //@@ 4 digitos 
            "filler2" => $this->zeros(2),
            "conta_cedente" => $data['conta'][0]->conta, //@@ 7 digitos
            "digito_conta" => $data['conta'][0]->digito, //@@ 1 digito
            "taxa_multa" => '00', // Percentual da multa por atraso. 2 digitos
            "filler3" => $this->filler(4),
            /* O SISTEMA IRA GERAR BASEADO EM INFORMAÇÕES VINDAS DO BANCO */
            "numero_controle" => $this->tamanho_string($numeroDoc, 25, 'numero'), // N° Controle do Título do Cliente. (Controle da empresa). 25 digitos
            "nosso_numero" => $this->tamanho_string($nossoNumero, 7, 'numero'), // Se o boleto for emitido pelo Cliente. Caso contrário 7 zeros.
            "dig_nosso_num" => $this->digito_nosso_numero($nossoNumero),
            "num_contrato" => $this->zeros(10), // Número do Contrato para cobrança. 10 zeros para cobrança simples.
            "dt_segundo_desc" => $this->zeros(6),
            "vlr_segundo_desc" => $this->zeros(13),
            "filler4" => $this->filler(8),
            /* INFORMAÇÕES */
            "carteira" => $carteira, //** Carteira a ser utilizada
            "cod_servico" => $servico, //** Servico desejado
            "seu_numero" => $this->tamanho_string($seuNumero, 10, 'numero'), //** indentificação do boleto pela empresa 

            /* INFORMAÇÕES */
            "dt_vencimento" => $data_venc, //**

            /* VALOR TOTAL. A virgula deve ser omitida, portanto as duas ultimas casas serao tidas como decimais */
            "valor" => $this->tamanho_string($valor, 13, 'numero'), //@@ valor total a pagar 

            /* INFORMAÇÕES */
            "num_banco" => $this->zeros(3),
            "agencia_cobradora" => $this->zeros(4), //BNB que definira baseado no CEP
            "filler5" => $this->filler(1),
            "especie" => $especie, //** 
            "aceite" => $aceite, //** 
            "dt_emissao" => date("dmy"), //@@
            "cod_instrucao" => $instrucao, //**

            /* JUROS E DESCONTOS */
            "juros" => $this->tamanho_string($juros, 13, 'numero'), //** 
            "dt_desconto" => $this->zeros(6), //@@ CASO TENHA SIDO DADO DESCONTO
            "vlr_desconto" => $this->zeros(13), //@@ CASO TENHA SIDO DADO DESCONTO
            "vlr_ioc" => $this->zeros(13), //@@ 
            "vlr_abatimento" => $this->zeros(13), //** 

            /* INFORMAÇÃO DO CLIENTE */
            "cod_ins_sacado" => "02", //@@ 01 = cpf | 02 = cnpj
            "cpf_cnpj_sacado" => $this->tamanho_string($data['destinatario'][0]->cnpj, 14, 'numero'), //@@ 
            "nome_sacado" => $this->tamanho_string($data['destinatario'][0]->nome, 40), //@@  
            "endereco_sacado" => $this->tamanho_string($data['destinatario'][0]->endereco, 40), //@@ 
            "complemento_sacado" => $this->tamanho_string($data['destinatario'][0]->complemento, 12), //@@ 
            "cep_sacado" => $data['destinatario'][0]->cep, //@@ 8 digitos
            "cidade_sacado" => $this->tamanho_string($data['destinatario'][0]->municipio, 15), //@@ 
            "uf" => $this->utilitario->codigo_uf($data['destinatario'][0]->codigo_ibge, 'sigla'), //@@

            /* INFORMAÇÃO */
            "mensagem_cedente" => $this->tamanho_string($mensagem, 40), //**
            "prazo_protesto" => "99", //** Em dias. Caso não vá protestar, preencher com 99
            "cod_moeda" => "0", //** Em dias. Caso não vá protestar, preencher com 99
            "sequencial_reg" => '000002'
        );

        $trailer = array(
            "cod_registro" => '9',
            "filler" => $this->filler(393),
            "sequencial_reg" => '000003'
        );

        $txtHeader = implode('', $header);
        $txtTransacao = implode('', $transacao);
        $txtTrailer = implode('', $trailer);

        $txtCnab = $txtHeader . chr(13) . chr(10) . $txtTransacao . chr(13) . chr(10) . $txtTrailer . chr(13) . chr(10) . chr(26);

        //criando o arquivo CNAB txt
        $nomeArquivo = $data['destinatario'][0]->nome . $nossoNumero;
        $pasta = $data['destinatario'][0]->nome;
        
        if (!is_dir("./upload/cnab/")) {
            mkdir("./upload/cnab/", 0777);
            chmod("./upload/cnab/", 0777);
        }
        
        if (!is_dir("./upload/cnab/{$servico}")) {
            mkdir("./upload/cnab/{$servico}", 0777);
            chmod("./upload/cnab/{$servico}", 0777);
        }
        $pathRoot = "./upload/cnab/{$servico}/" . date("Y-m-d");
        if (!is_dir($pathRoot)) {
            mkdir($pathRoot, 0777);
            chmod($pathRoot, 0777);
        }
        if (!is_dir("{$pathRoot}/$pasta")) {
            mkdir("{$pathRoot}/$pasta", 0777);
            chmod("{$pathRoot}/$pasta", 0777);
        }

        $txt = fopen("{$pathRoot}/$pasta/$nomeArquivo.txt", "w+");
        $inserindo = fwrite($txt, $txtCnab);
        fclose($txt);
        chmod("{$pathRoot}/$pasta/$nomeArquivo.txt", 0777);

        $solicitacao_cliente_id = $data['boleto'][0]->solicitacao_cliente_id;
        $mensagem = 'Boleto gerado com sucesso.';
        $this->session->set_flashdata('message', $mensagem);
//        redirect(base_url() . "estoque/boleto/solicitacaoboleto/$estoque_boleto_id");
    }

    function geracnabSATANDER($estoque_boleto_id) {
        $data['empresa'] = $this->boleto->empresaboleto();
        $data['boleto'] = $this->boleto->instanciarboleto($estoque_boleto_id);

        $data['destinatario'] = $this->boleto->listaclienteboleto($data['boleto'][0]->solicitacao_cliente_id);
        $data['conta'] = $this->boleto->listarcontaboleto($data['boleto'][0]->descricaopagamento_id);
        $data['dados_faturamento'] = $this->boleto->listasolicitacaofaturamento($data['boleto'][0]->solicitacao_cliente_id);

        $nossoNumero = $this->tamanho_string($data['boleto'][0]->nosso_numero, 7, 'numero');
        $seuNumero = $this->tamanho_string($data['boleto'][0]->seu_numero, 10, 'numero');
        $numeroDoc = $this->tamanho_string($data['boleto'][0]->numero_documento, 25, 'numero');

        $carteira = $data['boleto'][0]->carteira;
        $especie = $data['boleto'][0]->especie_documento;
        $aceite = $data['boleto'][0]->aceite;
        $servico = $data['boleto'][0]->servico;
        $instrucao = $data['boleto'][0]->instrucao_boleto;
        $mensagem = $data['boleto'][0]->mensagem_cedente;
        $data_venc = date("dmy", strtotime($data['boleto'][0]->data_vencimento));

        //tratando os valores
        $valor = str_replace('.', '', $data['boleto'][0]->valor);
        $juros = str_replace('.', '', $data['boleto'][0]->juros);

        //tratando os textos para se adequarem ao padrao CNAB400
        //tratando acentuações e caracteres especiais
        $data['empresa'][0]->logradouro = mb_strtoupper($this->remover_caracter(utf8_decode($data['empresa'][0]->logradouro)));
        $data['empresa'][0]->estado = mb_strtoupper($this->remover_caracter(utf8_decode($data['empresa'][0]->estado)));
        $data['empresa'][0]->municipio = mb_strtoupper($this->remover_caracter(utf8_decode($data['empresa'][0]->municipio)));
        $data['empresa'][0]->razao_social = mb_strtoupper($this->remover_caracter(utf8_decode($data['empresa'][0]->razao_social)));

        $data['destinatario'][0]->nome = mb_strtoupper($this->remover_caracter(utf8_decode($data['destinatario'][0]->nome)));
        $data['destinatario'][0]->logradouro = mb_strtoupper($this->remover_caracter(utf8_decode($data['destinatario'][0]->logradouro)));
        $data['destinatario'][0]->bairro = mb_strtoupper($this->remover_caracter(utf8_decode($data['destinatario'][0]->bairro)));
        $data['destinatario'][0]->complemento = mb_strtoupper($this->remover_caracter(utf8_decode($data['destinatario'][0]->complemento)));
        $data['destinatario'][0]->municipio = mb_strtoupper($this->remover_caracter(utf8_decode($data['destinatario'][0]->municipio)));
        $data['destinatario'][0]->estado = mb_strtoupper($this->remover_caracter(utf8_decode($data['destinatario'][0]->estado)));
        $data['destinatario'][0]->cep = $this->remover_caracter($data['destinatario'][0]->cep);
        $data['destinatario'][0]->cnpj = $this->remover_caracter($data['destinatario'][0]->cnpj);
        $data['destinatario'][0]->endereco = $data['destinatario'][0]->logradouro . ' ' . $data['destinatario'][0]->numero . ' ' . $data['destinatario'][0]->bairro;

        $data['conta'][0]->conta = $this->remover_caracter($data['conta'][0]->conta);
        $data['conta'][0]->agencia = $this->remover_caracter($data['conta'][0]->agencia);

        $header = array(
            "codigo_registro" => '0',
            "indentificacao_arquivo_remessa" => '1',
            "indentificacao_extenso" => "REMESSA",
            "codigo_servico" => '01',
            "literal_servico" => "COBRANCA       ",
            "cod_transmissao" => $this->zeros(20), 
            "nome_cedente" => $this->tamanho_string($data['empresa'][0]->empresa, 30), //@@ 30 caracteres
            "numero_banco" => '033',
            "nome_banco" => 'SANTANDER      ',
            "data_arquivo" => date("dmy"), //@@
            "zeros" => $this->zeros(16),
            "mensagem_1" => $this->filler(47),
            "mensagem_2" => $this->filler(47),
            "mensagem_3" => $this->filler(47),
            "mensagem_4" => $this->filler(47),
            "mensagem_5" => $this->filler(47),
            "brancos_1" => $this->filler(34),
            "brancos_2" => $this->filler(6),
            "num_versao" => $this->zeros(3),
            "sequencial_reg" => '000001'
        );

        $transacao = array(
            "cod_registro" => '1',
            "filler" => $this->filler(16),
            "agencia_cedente" => $data['conta'][0]->agencia, //@@ 4 digitos 
            "filler2" => $this->zeros(2),
            "conta_cedente" => $data['conta'][0]->conta, //@@ 7 digitos
            "digito_conta" => $data['conta'][0]->digito, //@@ 1 digito
            "taxa_multa" => '00', // Percentual da multa por atraso. 2 digitos
            "filler3" => $this->filler(4),
            /* O SISTEMA IRA GERAR BASEADO EM INFORMAÇÕES VINDAS DO BANCO */
            "numero_controle" => $this->tamanho_string($numeroDoc, 25, 'numero'), // N° Controle do Título do Cliente. (Controle da empresa). 25 digitos
            "nosso_numero" => $this->tamanho_string($nossoNumero, 7, 'numero'), // Se o boleto for emitido pelo Cliente. Caso contrário 7 zeros.
            "dig_nosso_num" => $this->digito_nosso_numero($nossoNumero),
            "num_contrato" => $this->zeros(10), // Número do Contrato para cobrança. 10 zeros para cobrança simples.
            "dt_segundo_desc" => $this->zeros(6),
            "vlr_segundo_desc" => $this->zeros(13),
            "filler4" => $this->filler(8),
            /* INFORMAÇÕES */
            "carteira" => $carteira, //** Carteira a ser utilizada
            "cod_servico" => $servico, //** Servico desejado
            "seu_numero" => $this->tamanho_string($seuNumero, 10, 'numero'), //** indentificação do boleto pela empresa 

            /* INFORMAÇÕES */
            "dt_vencimento" => $data_venc, //**

            /* VALOR TOTAL. A virgula deve ser omitida, portanto as duas ultimas casas serao tidas como decimais */
            "valor" => $this->tamanho_string($valor, 13, 'numero'), //@@ valor total a pagar 

            /* INFORMAÇÕES */
            "num_banco" => $this->zeros(3),
            "agencia_cobradora" => $this->zeros(4), //BNB que definira baseado no CEP
            "filler5" => $this->filler(1),
            "especie" => $especie, //** 
            "aceite" => $aceite, //** 
            "dt_emissao" => date("dmy"), //@@
            "cod_instrucao" => $instrucao, //**

            /* JUROS E DESCONTOS */
            "juros" => $this->tamanho_string($juros, 13, 'numero'), //** 
            "dt_desconto" => $this->zeros(6), //@@ CASO TENHA SIDO DADO DESCONTO
            "vlr_desconto" => $this->zeros(13), //@@ CASO TENHA SIDO DADO DESCONTO
            "vlr_ioc" => $this->zeros(13), //@@ 
            "vlr_abatimento" => $this->zeros(13), //** 

            /* INFORMAÇÃO DO CLIENTE */
            "cod_ins_sacado" => "02", //@@ 01 = cpf | 02 = cnpj
            "cpf_cnpj_sacado" => $this->tamanho_string($data['destinatario'][0]->cnpj, 14, 'numero'), //@@ 
            "nome_sacado" => $this->tamanho_string($data['destinatario'][0]->nome, 40), //@@  
            "endereco_sacado" => $this->tamanho_string($data['destinatario'][0]->endereco, 40), //@@ 
            "complemento_sacado" => $this->tamanho_string($data['destinatario'][0]->complemento, 12), //@@ 
            "cep_sacado" => $data['destinatario'][0]->cep, //@@ 8 digitos
            "cidade_sacado" => $this->tamanho_string($data['destinatario'][0]->municipio, 15), //@@ 
            "uf" => $this->utilitario->codigo_uf($data['destinatario'][0]->codigo_ibge, 'sigla'), //@@

            /* INFORMAÇÃO */
            "mensagem_cedente" => $this->tamanho_string($mensagem, 40), //**
            "prazo_protesto" => "99", //** Em dias. Caso não vá protestar, preencher com 99
            "cod_moeda" => "0", //** Em dias. Caso não vá protestar, preencher com 99
            "sequencial_reg" => '000002'
        );

        $trailer = array(
            "cod_registro" => '9',
            "filler" => $this->filler(393),
            "sequencial_reg" => '000003'
        );

        $txtHeader = implode('', $header);
        $txtTransacao = implode('', $transacao);
        $txtTrailer = implode('', $trailer);

        $txtCnab = $txtHeader . chr(13) . chr(10) . $txtTransacao . chr(13) . chr(10) . $txtTrailer . chr(13) . chr(10) . chr(26);

        //criando o arquivo CNAB txt
        $nomeArquivo = $data['destinatario'][0]->nome . $nossoNumero;
        $pasta = $data['destinatario'][0]->nome;
        
        if (!is_dir("./upload/cnab/")) {
            mkdir("./upload/cnab/", 0777);
            chmod("./upload/cnab/", 0777);
        }
        
        if (!is_dir("./upload/cnab/{$servico}")) {
            mkdir("./upload/cnab/{$servico}", 0777);
            chmod("./upload/cnab/{$servico}", 0777);
        }
        $pathRoot = "./upload/cnab/{$servico}/" . date("Y-m-d");
        if (!is_dir($pathRoot)) {
            mkdir($pathRoot, 0777);
            chmod($pathRoot, 0777);
        }
        if (!is_dir("{$pathRoot}/$pasta")) {
            mkdir("{$pathRoot}/$pasta", 0777);
            chmod("{$pathRoot}/$pasta", 0777);
        }

        $txt = fopen("{$pathRoot}/$pasta/$nomeArquivo.txt", "w+");
        $inserindo = fwrite($txt, $txtCnab);
        fclose($txt);
        chmod("{$pathRoot}/$pasta/$nomeArquivo.txt", 0777);

        $solicitacao_cliente_id = $data['boleto'][0]->solicitacao_cliente_id;
        $mensagem = 'Boleto gerado com sucesso.';
        $this->session->set_flashdata('message', $mensagem);
//        redirect(base_url() . "estoque/boleto/solicitacaoboleto/$estoque_boleto_id");
    }

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
