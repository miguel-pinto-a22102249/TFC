<?

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Produtos
 *
 * @version 1.0
 *
 */
class Produtos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('produto');
        $this->load->model('log');
        $this->load->helper('form');
        $this->load->library('form_validation');
        parse_str($_SERVER['QUERY_STRING'], $_GET);
        $this->load->library('session');
        if ($this->session->userdata('login_efetuado') == false) {
            redirect(base_url('admin/login'));
        }
        !eUtilizador() ? '' : redirect(base_url('dashboard'));
    }

    public function index() {
        $this->load->view('admin/escaloes/area_escaloes');
    }

    public function listar() {
        $Produtos = (new Produto)->obtemElementos();

        $this->load->view('admin/template/header', ["tituloArea" => "Produtos", "subtituloArea" => "Listar", "acoes" => [
            [
                "titulo" => "Adicionar",
                "link" => base_url('admin/produtos/adicionar'),
                "icone" => "fas fa-plus",
                'class' => 'button--add button--success'
            ],
            [
                "titulo" => "Registos",
                "link" => base_url('admin/produtos/logsEntradas'),
                "icone" => "fas fa-eye",
                'class' => 'button--add'
            ]
        ]]);
        $this->load->view('admin/produtos/listar', ['Produtos' => $Produtos]);
        $this->load->view('admin/template/footer');
    }

    public function listarLogsEntradas() {
        $Produtos = (new Produto)->obtemElementos();
        $logs = (new Log)->obtemLogs(['DataCriacao' => 'Desc'], ['Objeto' => 'Produto']);
        $utilizadores = (new Login)->obtemElementos();

        $this->load->view('admin/template/header', ["tituloArea" => "Produtos", "subtituloArea" => "Registos de Stocks", "acoes" => [
//            [
////                "titulo" => "Adicionar",
////                "link" => base_url('admin/produtos/adicionar'),
////                "icone" => "fas fa-plus",
////                'class' => 'button--add button--success'
//            ]
        ]]);
        $this->load->view('admin/produtos/lista_logs_entradas', ['Produtos' => $Produtos, 'logs' => $logs, 'utilizadores' => $utilizadores]);
        $this->load->view('admin/template/footer');
    }

    public function adicionar() {
        if ($this->session->userdata('login_efetuado') == false) {
            redirect(base_url('admin/login'));
        }

        $this->load->helper('form');
        $this->load->library('form_validation');

        $produto = new Produto();

        $Nome = $this->input->post('Nome');
        $Categoria = $this->input->post('Categoria');
        $Detalhes = $this->input->post('Detalhes');
        $StockAtual = $this->input->post('StockAtual');
        $IdEntidadeDistribuidora = $this->input->post('IdEntidadeDistribuidora');

        $this->form_validation->set_rules('Nome', 'Nome', 'required');
        $this->form_validation->set_rules('Categoria', 'Categoria', 'required');
        $this->form_validation->set_rules('StockAtual', 'StockAtual', 'required|numeric|greater_than[-1]');
        $this->form_validation->set_rules('IdEntidadeDistribuidora', 'IdEntidadeDistribuidora', 'required|numeric');

        $this->form_validation->set_message('required', '<i class="fas fa-exclamation-triangle"></i> Por favor preencha o campo corretamente.');
        $this->form_validation->set_message('numeric', '<i class="fas fa-exclamation-triangle"></i> Por favor preencha o campo corretamente.');
        $this->form_validation->set_message('greater_than', '<i class="fas fa-exclamation-triangle"></i> O valor tem de ser maior ou igual a 0.');

        if ($this->form_validation->run() === false) {
            $errors = [];

            // Construa um array de erros associados aos campos
            $fields = ['Nome', 'Categoria', 'Detalhes', 'StockAtual', 'IdEntidadeDistribuidora'];

            foreach ($fields as $field) {
                $error = form_error($field);
                if (!empty($error)) {
                    $errors[] = ['field' => $field, 'message' => $error];
                }
            }
            if ($this->input->is_ajax_request()) {
                // Se for uma requisição AJAX, envie os erros como resposta JSON
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'errors' => $errors, 'message' => 'Erro ao criar produto']);
                return;
            } else {
                // Se não for uma requisição AJAX, carregue a view normalmente
                $this->load->view('admin/template/header', ["tituloArea" => "Produtos", "subtituloArea" => "Adicionar"]);
                $this->load->view('admin/produtos/adicionar');
                $this->load->view('admin/template/footer');
            }
        } else {
            $produto->define([
                'Nome' => $Nome,
                'Categoria' => $Categoria,
                'StockInicial' => $StockAtual,
                'StockAtual' => $StockAtual,
                'Detalhes' => $Detalhes,
                'IdEntidadeDistribuidora' => $IdEntidadeDistribuidora,
                'Segmento' => url_title($Nome, 'dash', true) . '-' . time() . '-' . rand(0, 1000),
            ]);


            if ($produto->grava()) {
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'Produto adicionado com sucesso']);
                return;
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Ocorreu um erro ao adicionar o produto']);
                return;
            }
        }
    }

    public function editar($id) {
        if ($this->session->userdata('login_efetuado') == false) {
            redirect(base_url('admin/login'));
        }

        $this->load->helper('form');
        $this->load->library('form_validation');

        $Produto = new Produto();
        $Produto->carregaPorId($id);

        if (!$this->input->is_ajax_request()) {
            // Se não for uma requisição AJAX, carregue a view normalmente
            $this->load->view('admin/template/header', ["tituloArea" => "Produtos", "subtituloArea" => "Editar"]);
            $this->load->view('admin/produtos/editar', ['Produto' => $Produto]);
            $this->load->view('admin/template/footer');
            return;
        }

        $Nome = $this->input->post('Nome');
        $Detalhes = $this->input->post('Detalhes');
        $StockAtual = $this->input->post('StockAtual');
        $Categoria = $this->input->post('Categoria');
        $IdEntidadeDistribuidora = $this->input->post('IdEntidadeDistribuidora');


        $this->form_validation->set_rules('Nome', 'Nome', 'required');
        $this->form_validation->set_rules('Categoria', 'Categoria', 'required');
        $this->form_validation->set_rules('Detalhes', 'Detalhes', 'required');
        $this->form_validation->set_rules('StockAtual', 'StockAtual', 'required|numeric|greater_than[-1]');
        $this->form_validation->set_rules('IdEntidadeDistribuidora', 'IdEntidadeDistribuidora', 'required|numeric');

        $this->form_validation->set_message('required', '<i class="fas fa-exclamation-triangle"></i> Por favor preencha o campo corretamente.');
        $this->form_validation->set_message('numeric', '<i class="fas fa-exclamation-triangle"></i> Por favor preencha o campo corretamente.');
        $this->form_validation->set_message('greater_than', '<i class="fas fa-exclamation-triangle"></i> O valor tem de ser maior ou igual a 0.');


        if ($this->form_validation->run() === false) {
            $errors = [];

            // Construa um array de erros associados aos campos
            $fields = ['Nome', 'Categoria', 'Detalhes', 'StockAtual', 'IdEntidadeDistribuidora'];

            foreach ($fields as $field) {
                $error = form_error($field);
                if (!empty($error)) {
                    $errors[] = ['field' => $field, 'message' => $error];
                }
            }
            if ($this->input->is_ajax_request()) {
                // Se for uma requisição AJAX, envie os erros como resposta JSON
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'errors' => $errors, 'message' => 'Erro ao editar produto']);
                return;
            } else {
                // Se não for uma requisição AJAX, carregue a view normalmente
                $this->load->view('admin/template/header', ["tituloArea" => "Produtos", "subtituloArea" => "Editar"]);
                $this->load->view('admin/produtos/editar', ["Produto" => $Produto]);
                $this->load->view('admin/template/footer');
            }
        } else {
            if ($Produto->getNome() != $Nome) {
                $Produto->setNome($Nome);
                $Produto->setSegmento(url_title($Nome, 'dash', true) . '-' . time() . '-' . rand(0, 1000));
            }
            $Produto->setCategoria($Categoria);
            $Produto->setDetalhes($Detalhes);
            $Produto->setStockAtual($StockAtual);
            $Produto->setStockInicial($StockAtual);
            $Produto->setIdEntidadeDistribuidora($IdEntidadeDistribuidora);


            if ($Produto->edita($id)) {
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'Produto editado com sucesso']);
                return;
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Ocorreu um erro ao editar o produto']);
                return;
            }
        }
    }

    public function viewEditar($id, $soConsulta = false) {
        if ($this->session->userdata('login_efetuado') == false) {
            redirect(base_url('admin/login'));
        }

        $log = new Log();
        $Produto = new Produto();
        $Produto->carregaPorId($id);

        if ($this->input->is_ajax_request()) {
            $html = $this->load->view('admin/produtos/editar', ['Produto' => $Produto], true);
            $html = $this->load->view('admin/popup/default_popup', ['titulo' => 'Editar Produto',
                                                                    'soConsulta' => $soConsulta,
                                                                    'html' => $html, 'URLNewWindow' => base_url("admin/produtos/editar/{$id}")], true);
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'message' => '', 'view' => $html]);
            return;
        } else {
            // Se não for uma requisição AJAX, carregue a view normalmente
            $this->load->view('admin/template/header', ["tituloArea" => "Produtos", "subtituloArea" => "Editar"]);
            $this->load->view('admin/produtos/editar', ['Produto' => $Produto]);
            $this->load->view('admin/template/footer');
            return;
        }
    }

    public function eliminar($id) {
        if ($this->session->userdata('login_efetuado') == false) {
            redirect(base_url('admin/login'));
        }

        $Produto = new Produto();
        $Produto->carregaPorId($id);

        $resultado = $Produto->eliminar($id);

        if ($resultado === true) {
            $data = [
                "success" => true,
                "message" => 'Produto eliminado com sucesso'
            ];
            echo json_encode($data);
        } else {
            $data = [
                "success" => false,
                "message" => 'Não foi possivel eliminar o Produto solicitado.'
            ];
            echo json_encode($data);
        }
    }
}
