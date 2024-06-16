<?

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Entidades_Distribuidoras
 *
 * @version 1.0
 *
 */
class Entidades_Distribuidoras extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('entidade_distribuidora');
        $this->load->model('log');
        $this->load->helper('form');
        $this->load->library('form_validation');
        parse_str($_SERVER['QUERY_STRING'], $_GET);
        $this->load->library('session');
        if ($this->session->userdata('login_efetuado') == false) {
            redirect(base_url('admin/login'));
        }
    }

    public function index() {
    }

    public function listar() {
        eSuperAdmin() ? '' : redirect(base_url('dashboard'));


        $EntidadesDistruibuidoras = (new Entidade_Distribuidora())->obtemElementos();

        $this->load->view('admin/template/header', ["tituloArea" => "Entidades Distribuidoras", "subtituloArea" => "Listar", "acoes" => [
            [
                "titulo" => "Adicionar",
                "link" => base_url('admin/entidadesDistribuidoras/adicionar'),
                "icone" => "fas fa-plus",
                'class' => 'button--add button--success'
            ]
        ]]);
        $this->load->view('admin/entidades_distribuidoras/listar', ['EntidadesDistribuidoras' => $EntidadesDistruibuidoras]);
        $this->load->view('admin/template/footer');
    }

    public function adicionar() {
        if ($this->session->userdata('login_efetuado') == false) {
            redirect(base_url('admin/login'));
        }

        eSuperAdmin() ? '' : redirect(base_url('dashboard'));

        $this->load->helper('form');
        $this->load->library('form_validation');

        $EntidadeDistribuidora = new Entidade_Distribuidora();


        $Nome = $this->input->post('Nome');
        $NomeCompleto = $this->input->post('NomeCompleto');
        $TipoOperacao = $this->input->post('TipoOperacao');
        $NIF = $this->input->post('NIF');
        $Morada = $this->input->post('Morada');

        $this->form_validation->set_rules('Nome', 'Nome', 'required|is_unique[entidade_distribuidora.Nome]');
        $this->form_validation->set_rules('NIF', 'NIF', 'required');
        $this->form_validation->set_rules('Morada', 'Morada', 'required');
        $this->form_validation->set_rules('NomeCompleto', 'NomeCompleto', 'required');
        $this->form_validation->set_rules('TipoOperacao', 'TipoOperacao', 'required');


        $this->form_validation->set_message('required', '<i class="fas fa-exclamation-triangle"></i> Por favor preencha o campo corretamente.');
        $this->form_validation->set_message('numeric', '<i class="fas fa-exclamation-triangle"></i> Por favor preencha o campo corretamente.');
        $this->form_validation->set_message('is_unique', '<i class="fas fa-exclamation-triangle"></i> Já existe uma entidade com este nome.');


        if ($this->form_validation->run() === false) {
            $errors = [];

            // Construa um array de erros associados aos campos
            $fields = ['Nome', 'NIF', 'Morada', 'NomeCompleto', 'TipoOperacao'];

            foreach ($fields as $field) {
                $error = form_error($field);
                if (!empty($error)) {
                    $errors[] = ['field' => $field, 'message' => $error];
                }
            }
            if ($this->input->is_ajax_request()) {
                // Se for uma requisição AJAX, envie os erros como resposta JSON
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'errors' => $errors, 'message' => 'Erro ao criar Entidade Distribuidora']);
                return;
            } else {
                // Se não for uma requisição AJAX, carregue a view normalmente
                $this->load->view('admin/template/header', ["tituloArea" => "Entidades Distribuidoras", "subtituloArea" => "Adicionar"]);
                $this->load->view('admin/entidades_distribuidoras/adicionar');
                $this->load->view('admin/template/footer');
            }
        } else {
            $EntidadeDistribuidora->define([
                'Nome' => $Nome,
                'NomeCompleto' => $NomeCompleto,
                'TipoOperacao' => $TipoOperacao,
                'NIF' => $NIF,
                'Morada' => $Morada,
                'Logo' => 'default-user.png',
                'Segmento' => url_title($Nome, 'dash', true) . '-' . time() . '-' . rand(0, 1000),
            ]);


            //Se tiver logo
            if (!empty($_FILES["Logo"]["name"])) {
                $name = mt_rand(0, 99) . "_" . date('Y-m-d_H-i-s') . "_" . $_FILES["Logo"]["name"];
                if ($name != $EntidadeDistribuidora->getLogo()) {
                    $destino = CAMINHO_IMAGENS_DINAMICAS . 'logos_entidades/' . $name;
                    move_uploaded_file($_FILES["Logo"]["tmp_name"], $destino);
                    $EntidadeDistribuidora->setLogo($name);
                }
            } else {
                $EntidadeDistribuidora->setLogo(null);
            }


            if ($EntidadeDistribuidora->grava()) {
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'Entidade Distribuidora adicionado com sucesso']);
                return;
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Ocorreu um erro ao adicionar o Entidade Distribuidora']);
                return;
            }
        }
    }

    public function editar($id) {
        if ($this->session->userdata('login_efetuado') == false) {
            redirect(base_url('admin/login'));
        }

        eSuperAdmin() ? '' : redirect(base_url('dashboard'));

        $this->load->helper('form');
        $this->load->library('form_validation');

        $EntidadeDistribuidora = new Entidade_Distribuidora();

        $EntidadeDistribuidora->carregaPorId($id);

        if (!$this->input->is_ajax_request()) {
            // Se não for uma requisição AJAX, carregue a view normalmente
            $this->load->view('admin/template/header', ["tituloArea" => "Entidades Distribuidoras", "subtituloArea" => "Editar"]);
            $this->load->view('admin/entidades_distribuidoras/editar', ['EntidadeDistribuidora' => $EntidadeDistribuidora]);
            $this->load->view('admin/template/footer');
            return;
        }


        $Nome = $this->input->post('Nome');
        $NomeCompleto = $this->input->post('NomeCompleto');
        $TipoOperacao = $this->input->post('TipoOperacao');
        $NIF = $this->input->post('NIF');
        $Morada = $this->input->post('Morada');


        $this->form_validation->set_rules('NomeCompleto', 'NomeCompleto', 'required');
        $this->form_validation->set_rules('TipoOperacao', 'TipoOperacao', 'required');
        $this->form_validation->set_rules('NIF', 'NIF', 'required');
        $this->form_validation->set_rules('Morada', 'Morada', 'required');


        $this->form_validation->set_message('required', '<i class="fas fa-exclamation-triangle"></i> Por favor preencha o campo corretamente.');
        $this->form_validation->set_message('numeric', '<i class="fas fa-exclamation-triangle"></i> Por favor preencha o campo corretamente.');
        $this->form_validation->set_message('is_unique', '<i class="fas fa-exclamation-triangle"></i> Já existe uma Entiddade com este nome.');


        if ($Nome != $EntidadeDistribuidora->getNome()) {
            $this->form_validation->set_rules('Nome', 'Nome', 'required|is_unique[entidade_distribuidora.Nome]');
        }

        if ($this->form_validation->run() === false) {
            $errors = [];

            // Construa um array de erros associados aos campos
            $fields = ['Nome', 'NIF', 'Morada', 'NomeCompleto', 'TipoOperacao'];

            foreach ($fields as $field) {
                $error = form_error($field);
                if (!empty($error)) {
                    $errors[] = ['field' => $field, 'message' => $error];
                }
            }
            if ($this->input->is_ajax_request()) {
                // Se for uma requisição AJAX, envie os erros como resposta JSON
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'errors' => $errors, 'message' => 'Erro ao editar Entidade']);
                return;
            } else {
                // Se não for uma requisição AJAX, carregue a view normalmente
                $this->load->view('admin/template/header', ["tituloArea" => "Entidades Distribuidoras", "subtituloArea" => "Editar"]);
                $this->load->view('admin/entidades_distribuidoras/editar');
                $this->load->view('admin/template/footer');
            }
        } else {
            if ($EntidadeDistribuidora->getNome() != $Nome) {
                $EntidadeDistribuidora->setNome($Nome);
                $EntidadeDistribuidora->setSegmento(url_title($Nome, 'dash', true) . '-' . time() . '-' . rand(0, 1000));
            }
            $EntidadeDistribuidora->setNomeCompleto($NomeCompleto);
            $EntidadeDistribuidora->setTipoOperacao($TipoOperacao);
            $EntidadeDistribuidora->setNIF($NIF);
            $EntidadeDistribuidora->setMorada($Morada);
            //Se tiver logo
            if (!empty($_FILES["Logo"]["name"])) {
                $name = mt_rand(0, 99) . "_" . date('Y-m-d_H-i-s') . "_" . $_FILES["Logo"]["name"];
                if ($name != $EntidadeDistribuidora->getLogo()) {
                    $destino = CAMINHO_IMAGENS_DINAMICAS . 'logos_entidades/' . $name;
                    move_uploaded_file($_FILES["Logo"]["tmp_name"], $destino);
                    $EntidadeDistribuidora->setLogo($name);
                }
            }


            if ($EntidadeDistribuidora->edita($id)) {
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'Entidade Distribuidora editada com sucesso']);
                return;
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Ocorreu um erro ao editar a Entidade Distribuidora']);
                return;
            }
        }
    }

    public function viewEditar($id, $soConsulta = false) {
        if ($this->session->userdata('login_efetuado') == false) {
            redirect(base_url('admin/login'));
        }

        eSuperAdmin() ? '' : redirect(base_url('dashboard'));

        $log = new Log();
        $EntidadeDistribuidora = new Entidade_Distribuidora();
        $EntidadeDistribuidora->carregaPorId($id);

        if ($this->input->is_ajax_request()) {
            $html = $this->load->view('admin/entidades_distribuidoras/editar', ['EntidadeDistribuidora' => $EntidadeDistribuidora], true);
            $html = $this->load->view('admin/popup/default_popup', ['titulo' => 'Editar Entidade Distribuidora',
                                                                    'soConsulta' => $soConsulta,
                                                                    'html' => $html, 'URLNewWindow' => base_url("admin/entidades_distribuidoras/editar/{$id}")], true);
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'message' => '', 'view' => $html]);
            return;
        } else {
            // Se não for uma requisição AJAX, carregue a view normalmente
            $this->load->view('admin/template/header', ["tituloArea" => "Entidades Distribuidoras", "subtituloArea" => "Editar"]);
            $this->load->view('admin/entidades_distribuidoras/editar', ['EntidadeDistribuidora' => $EntidadeDistribuidora]);
            $this->load->view('admin/template/footer');
            return;
        }
    }

    public function eliminar($id) {
        if ($this->session->userdata('login_efetuado') == false) {
            redirect(base_url('admin/login'));
        }

        eSuperAdmin() ? '' : redirect(base_url('dashboard'));

        $EntidadeDistribuidora = new Entidade_Distribuidora();
        $EntidadeDistribuidora->carregaPorId($id);


        if (trim($EntidadeDistribuidora->getLogo()) != "" || $EntidadeDistribuidora->getLogo() != null) {
            $eliminar = CAMINHO_IMAGENS_DINAMICAS . 'logos_entidades/' . $EntidadeDistribuidora->getLogo();
            if (file_exists($eliminar)) {
                unlink($eliminar);
            }
        }


        $resultado = $EntidadeDistribuidora->eliminar($id);

        if ($resultado === true) {
            $data = [
                "success" => true,
                "message" => 'Objeto eliminado com sucesso'
            ];
            echo json_encode($data);
        } else {
            $data = [
                "success" => false,
                "message" => 'Não foi possivel eliminar o objeto solicitado.'
            ];
            echo json_encode($data);
        }
    }
}
