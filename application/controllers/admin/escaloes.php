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

    public function listar() {
        $Escaloes = (new Escalao)->obtemElementos();

        $this->load->view('admin/template/header', ["tituloArea" => "Escalões", "subtituloArea" => "Listar", "acoes" => [
            [
                "titulo" => "Adicionar",
                "link" => base_url('admin/escaloes/adicionar'),
                "icone" => "fas fa-plus",
                'class' => 'button--add button--success'
            ]
        ]]);
        $this->load->view('admin/escaloes/listar', ['Escaloes' => $Escaloes]);
        $this->load->view('admin/template/footer');
    }

    public function adicionar() {
        if ($this->session->userdata('login_efetuado') == false) {
            redirect(base_url('admin/login'));
        }

        $this->load->helper('form');
        $this->load->library('form_validation');

        $escalao = new Escalao();

        $Designacao = $this->input->post('Designacao');
        $IdadeInicial = $this->input->post('IdadeInicial');
        $IdadeFinal = $this->input->post('IdadeFinal');
        $produtos = $this->input->post('produtos');
        $quantidades = $this->input->post('quantidades');

        $this->form_validation->set_rules('Designacao', 'Designacao', 'required|is_unique[escalao.Designacao]');
        $this->form_validation->set_rules('IdadeInicial', 'IdadeInicial', 'required|numeric');
        $this->form_validation->set_rules('IdadeFinal', 'IdadeFinal', 'required|numeric|callback_validar_idades');


        $this->form_validation->set_message('required', '<i class="fas fa-exclamation-triangle"></i> Por favor preencha o campo corretamente.');
        $this->form_validation->set_message('numeric', '<i class="fas fa-exclamation-triangle"></i> Por favor preencha o campo corretamente.');
        $this->form_validation->set_message('is_unique', '<i class="fas fa-exclamation-triangle"></i> Já existe um escalão com esta designação.');


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
                echo json_encode(['success' => false, 'errors' => $errors, 'message' => 'Erro ao criar escalão']);
                return;
            } else {
                // Se não for uma requisição AJAX, carregue a view normalmente
                $this->load->view('admin/template/header', ["tituloArea" => "Escalões", "subtituloArea" => "Adicionar"]);
                $this->load->view('admin/escaloes/adicionar');
                $this->load->view('admin/template/footer');
            }
        } else {
            // Constrói um array associativo com ID do produto => quantidade
            $produtos_quantidades = [];
            for ($i = 0; $i < count($produtos); $i++) {
                $produto_id = $produtos[$i];
                $quantidade = $quantidades[$i];
                // Adiciona o par ID do produto => quantidade ao array associativo
                $produtos_quantidades[$produto_id] = $quantidade;
            }

            $escalao->define([
                'Designacao' => $Designacao,
                'IdadeInicial' => $IdadeInicial,
                'IdadeFinal' => $IdadeFinal,
                'Segmento' => url_title($Designacao, 'dash', true) . '-' . time() . '-' . rand(0, 1000),
                'Produtos' => json_encode($produtos_quantidades)
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

    public function editar($id) {
        if ($this->session->userdata('login_efetuado') == false) {
            redirect(base_url('admin/login'));
        }

        $this->load->helper('form');
        $this->load->library('form_validation');

        $Escalao = new Escalao();

        $Escalao->carregaPorId($id);

        if (!$this->input->is_ajax_request()) {
            // Se não for uma requisição AJAX, carregue a view normalmente
            $this->load->view('admin/template/header', ["tituloArea" => "Escalões", "subtituloArea" => "Editar"]);
            $this->load->view('admin/escaloes/editar', ['Escalao' => $Escalao]);
            $this->load->view('admin/template/footer');
            return;
        }


        $Designacao = $this->input->post('Designacao');
        $IdadeInicial = $this->input->post('IdadeInicial');
        $IdadeFinal = $this->input->post('IdadeFinal');
        $produtos = $this->input->post('produtos');
        $quantidades = $this->input->post('quantidades');


        if ($Designacao != $Escalao->getDesignacao()) {
            $this->form_validation->set_rules('Designacao', 'Designacao', 'required|is_unique[escalao.Designacao]');
        }
        $this->form_validation->set_rules('IdadeInicial', 'IdadeInicial', 'required|numeric');
        $this->form_validation->set_rules('IdadeFinal', 'IdadeFinal', 'required|numeric|callback_validar_idades');

        $this->form_validation->set_message('required', '<i class="fas fa-exclamation-triangle"></i> Por favor preencha o campo corretamente.');
        $this->form_validation->set_message('numeric', '<i class="fas fa-exclamation-triangle"></i> Por favor preencha o campo corretamente.');
        $this->form_validation->set_message('is_unique', '<i class="fas fa-exclamation-triangle"></i> Já existe um escalão com esta designação.');

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
                echo json_encode(['success' => false, 'errors' => $errors, 'message' => 'Erro ao editar escalão']);
                return;
            } else {
                // Se não for uma requisição AJAX, carregue a view normalmente
                $this->load->view('admin/template/header', ["tituloArea" => "Escalões", "subtituloArea" => "Editar"]);
                $this->load->view('admin/escaloes/editar');
                $this->load->view('admin/template/footer');
            }
        } else {
            if ($Escalao->getDesignacao() != $Designacao) {
                $Escalao->setDesignacao($Designacao);
                $Escalao->setSegmento(url_title($Designacao, 'dash', true) . '-' . time() . '-' . rand(0, 1000));
            }
            $Escalao->setIdadeInicial($IdadeInicial);
            $Escalao->setIdadeFinal($IdadeFinal);


            // Constrói um array associativo com ID do produto => quantidade
            $produtos_quantidades = [];
            for ($i = 0; $i < count($produtos); $i++) {
                $produto_id = $produtos[$i];
                $quantidade = $quantidades[$i];
                // Adiciona o par ID do produto => quantidade ao array associativo
                $produtos_quantidades[$produto_id] = $quantidade;
            }

            $Escalao->setProdutos(json_encode($produtos_quantidades));

            if ($Escalao->edita($id)) {
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'Escalão editado com sucesso']);
                return;
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Ocorreu um erro ao editar o escalão']);
                return;
            }
        }
    }

    public function eliminar($id) {
        if ($this->session->userdata('login_efetuado') == false) {
            redirect(base_url('admin/login'));
        }

        $Escalao = new Escalao();
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

    function validar_idades($idade_final) {
        $idade_inicial = $this->input->post('IdadeInicial');
        if ($idade_final < $idade_inicial) {
            $this->form_validation->set_message('validar_idades', 'A idade final não pode ser menor que a idade inicial.');
            return false;
        }
        return true;
    }
}
