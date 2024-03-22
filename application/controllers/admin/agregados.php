<?

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Escalões
 *
 * @version 1.0
 *
 */
class Agregados extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('agregado_familiar');
        $this->load->model('constituinte');
        $this->load->model('log');
        $this->load->helper('form');
        $this->load->library('form_validation');
        parse_str($_SERVER['QUERY_STRING'], $_GET);
        $this->load->library('session');
    }

    public function index() {
        self::listar();
    }

    public function listar() {
        $Agregados = (new Agregado_Familiar())->obtemElementos();

        $this->load->view('admin/template/header', ["tituloArea" => "Agregados", "subtituloArea" => "Listar"]);
        $this->load->view('admin/agregados/listar', ['Agregados' => $Agregados]);
        $this->load->view('admin/template/footer');
    }

    public function adicionar() {
        if ($this->session->userdata('login_efetuado') == false) {
            redirect(base_url('admin/login'));
        }

        $this->load->helper('form');
        $this->load->library('form_validation');

        $Agregado = new Agregado_Familiar();

        $NissConstituintePrincipal = $this->input->post('NissConstituintePrincipal');
        $Grupo = $this->input->post('Grupo');

        $this->form_validation->set_rules('NissConstituintePrincipal', 'NissConstituintePrincipal', 'required');
        $this->form_validation->set_rules('Grupo', 'Grupo', 'required');

        $this->form_validation->set_message('required', '<i class="fas fa-exclamation-triangle"></i> Por favor preencha o campo corretamente.');
        $this->form_validation->set_message('numeric', '<i class="fas fa-exclamation-triangle"></i> Por favor preencha o campo corretamente.');

        if ($this->form_validation->run() === false) {
            $errors = [];

            // Construa um array de erros associados aos campos
            $fields = ['NissConstituintePrincipal', 'Grupo'];

            foreach ($fields as $field) {
                $error = form_error($field);
                if (!empty($error)) {
                    $errors[] = ['field' => $field, 'message' => $error];
                }
            }
            if ($this->input->is_ajax_request()) {
                // Se for uma requisição AJAX, envie os erros como resposta JSON
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'errors' => $errors, 'message' => 'Erro ao criar agregado']);
                return;
            } else {
                // Se não for uma requisição AJAX, carregue a view normalmente
                $this->load->view('admin/template/header', ["tituloArea" => "Agregados", "subtituloArea" => "Adicionar"]);
                $this->load->view('admin/agregados/adicionar');
                $this->load->view('admin/template/footer');
            }
        } else {
            $Agregado->define([
                'NissConstituintePrincipal' => $NissConstituintePrincipal,
                'Grupo' => $Grupo,
                'Segmento' => url_title($NissConstituintePrincipal, 'dash', true) . '-' . time() . '-' . rand(0, 1000),
            ]);


            if ($Agregado->grava()) {
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'Agregado adicionado com sucesso']);
                return;
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Ocorreu um erro ao adicionar o agregado']);
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

        $Agregado_Familiar = new Agregado_Familiar();

        $Agregado_Familiar->carregaPorId($id);

        if (!$this->input->is_ajax_request()) {
            // Se não for uma requisição AJAX, carregue a view normalmente
            $this->load->view('admin/template/header', ["tituloArea" => "Escalões", "subtituloArea" => "Editar"]);
            $this->load->view('admin/escaloes/editar', ['Escalao' => $Agregado_Familiar]);
            $this->load->view('admin/template/footer');
            return;
        }


        $Designacao = $this->input->post('Designacao');
        $IdadeInicial = $this->input->post('IdadeInicial');
        $IdadeFinal = $this->input->post('IdadeFinal');

        $this->form_validation->set_rules('Designacao', 'Designacao', 'required');
        $this->form_validation->set_rules('IdadeInicial', 'IdadeInicial', 'required|numeric');
        $this->form_validation->set_rules('IdadeFinal', 'IdadeFinal', 'required|numeric');

        $this->form_validation->set_message('required', '<i class="fas fa-exclamation-triangle"></i> Por favor preencha o campo corretamente.');
        $this->form_validation->set_message('numeric', '<i class="fas fa-exclamation-triangle"></i> Por favor preencha o campo corretamente.');

        if ($this->form_validation->run() === false) {
            $errors = [];

            // Construa um array de erros associados aos campos
            $fields = ['Designacao', 'IdadeInicial', 'IdadeFinal'];

            foreach ($fields as $field) {
                $error = form_error($field);
                if (!empty($error)) {
                    $errors[] = ['field' => $field, 'message' => $error];
                }
            }
            if ($this->input->is_ajax_request()) {
                // Se for uma requisição AJAX, envie os erros como resposta JSON
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'errors' => $errors, 'message' => 'Erro ao editar agregado']);
                return;
            } else {
                // Se não for uma requisição AJAX, carregue a view normalmente
                $this->load->view('admin/template/header', ["tituloArea" => "Escalões", "subtituloArea" => "Editar"]);
                $this->load->view('admin/escaloes/editar');
                $this->load->view('admin/template/footer');
            }
        } else {
            if ($Agregado_Familiar->getDesignacao() != $Designacao) {
                $Agregado_Familiar->setDesignacao($Designacao);
                $Agregado_Familiar->setSegmento(url_title($Designacao, 'dash', true) . '-' . time() . '-' . rand(0, 1000));
            }
            $Agregado_Familiar->setIdadeInicial($IdadeInicial);
            $Agregado_Familiar->setIdadeFinal($IdadeFinal);


            if ($Agregado_Familiar->edita($id)) {
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'Escalão editado com sucesso']);
                return;
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Ocorreu um erro ao editar o agregado']);
                return;
            }
        }
    }

    public function eliminar($id) {
        if ($this->session->userdata('login_efetuado') == false) {
            redirect(base_url('admin/login'));
        }

        $Escalao = new Agregado_Familiar();
        $Escalao->carregaPorId($id);

        $resultado = $Escalao->eliminar($id);

        if ($resultado === true) {
            $data = [
                "Sucesso" => true,
                "Mensagem" => 'Escalão eliminado com sucesso'
            ];
            echo json_encode($data);
        } else {
            $data = [
                "Sucesso" => false,
                "Mensagem" => 'Não foi possivel eliminar o Escalão solicitado.'
            ];
            echo json_encode($data);
        }
    }

    public function adicionarConstituinte() {
        if ($this->session->userdata('login_efetuado') == false) {
            redirect(base_url('admin/login'));
        }

        $this->load->helper('form');
        $this->load->library('form_validation');

        $Constituinte = new Constituinte();

        $Niss = $this->input->post('Niss');
        $IdEscalao = $this->input->post('IdEscalao');
        $IdAgregado = $this->input->post('IdAgregado');

        $this->form_validation->set_rules('Niss', 'Niss', 'required|numeric');
        $this->form_validation->set_rules('IdEscalao', 'IdEscalao', 'required|numeric');
        $this->form_validation->set_rules('IdAgregado', 'IdAgregado', 'required|numeric');

        $this->form_validation->set_message('required', '<i class="fas fa-exclamation-triangle"></i> Por favor preencha o campo corretamente.');
        $this->form_validation->set_message('numeric', '<i class="fas fa-exclamation-triangle"></i> Por favor preencha o campo corretamente.');

        if ($this->form_validation->run() === false) {
            $errors = [];

            // Construa um array de erros associados aos campos
            $fields = ['Niss', 'IdEscalao', 'IdAgregado'];

            foreach ($fields as $field) {
                $error = form_error($field);
                if (!empty($error)) {
                    $errors[] = ['field' => $field, 'message' => $error];
                }
            }
            if ($this->input->is_ajax_request()) {
                // Se for uma requisição AJAX, envie os erros como resposta JSON
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'errors' => $errors, 'message' => 'Erro ao criar constituinte']);
                return;
            } else {
                // Se não for uma requisição AJAX, carregue a view normalmente
                $this->load->view('admin/template/header', ["tituloArea" => "Agregados - Constituinte", "subtituloArea" => "Adicionar"]);
                $this->load->view('admin/agregados/adicionarConstituinte');
                $this->load->view('admin/template/footer');
            }
        } else {
            $Constituinte->define([
                'Niss' => $Niss,
                'IdEscalao' => $IdEscalao,
                'IdAgregado' => $IdAgregado,
                'Segmento' => url_title($Niss, 'dash', true) . '-' . time() . '-' . rand(0, 1000),
            ]);


            if ($Constituinte->grava()) {
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'Constituinte adicionado com sucesso']);
                return;
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Ocorreu um erro ao adicionar o constituinte']);
                return;
            }
        }
    }

    public function listarConstituintes() {
        $Constituintes = (new Constituinte())->obtemElementos();

        $this->load->view('admin/template/header', ["tituloArea" => "Agregados - Constituintes", "subtituloArea" => "Listar"]);
        $this->load->view('admin/agregados/listarConstituintes', ['Constituintes' => $Constituintes]);
        $this->load->view('admin/template/footer');
    }

    public function eliminarConstituinte($id) {
        if ($this->session->userdata('login_efetuado') == false) {
            redirect(base_url('admin/login'));
        }

        $Constituinte = new Constituinte();
        $Constituinte->carregaPorId($id);

        $resultado = $Constituinte->eliminar($id);

        if ($resultado === true) {
            $data = [
                "Sucesso" => true,
                "Mensagem" => 'Constituinte eliminado com sucesso'
            ];
            echo json_encode($data);
        } else {
            $data = [
                "Sucesso" => false,
                "Mensagem" => 'Não foi possivel eliminar o Constituinte.'
            ];
            echo json_encode($data);
        }
    }
}
