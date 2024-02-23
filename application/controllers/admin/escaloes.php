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
class Escaloes extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('escalao');
        $this->load->model('log');
        $this->load->helper('form');
        $this->load->library('form_validation');
        parse_str($_SERVER['QUERY_STRING'], $_GET);
        $this->load->library('session');
    }

    public function index() {
        $this->load->view('admin/escaloes/area_escaloes');
    }

    public function listarEscaloes() {
        $Data['escaloes'] = (new Escalao)->obtemEscaloes(null, null, null, false);

        $this->load->view('admin/template/header', ["tituloArea" => "Escalões", "subtituloArea" => "Listar"]);
        $this->load->view('admin/escaloes/listar', $Data);
        $this->load->view('admin/template/footer');
    }

    public function adicionar() {
        if ($this->session->userdata('login_efetuado') == false) {
            redirect(base_url('admin/login'));
        }

        $this->load->helper('form');
        $this->load->library('form_validation');

        $escalao = new Escalao();
        $Log = new Log();

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
                echo json_encode(['success' => false, 'errors' => $errors, 'message' => 'Erro ao criar utilizador']);
                return;
            } else {
                // Se não for uma requisição AJAX, carregue a view normalmente
                $this->load->view('admin/template/header', ["tituloArea" => "Escalões", "subtituloArea" => "Adicionar"]);
                $this->load->view('admin/escaloes/adicionar');
                $this->load->view('admin/template/footer');
            }
        } else {
            $escalao->define([
                'Designacao' => $Designacao,
                'IdadeInicial' => $IdadeInicial,
                'IdadeFinal' => $IdadeFinal,
                'Segmento' => url_title($Designacao, 'dash', true) . '-' . time() . '-' . rand(0, 1000),
            ]);


            $Log->define([
                'Descricao' => "Escalão: {$this->session->userdata('Id')} adicionou um novo escalão - Username: {$this->session->userdata('Username')}"
            ]);

            if ($escalao->grava()) {
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'Escalão adicionado com sucesso']);
                return;
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Ocorreu um erro ao adicionar o escalão']);
                return;
            }
        }
    }

}
