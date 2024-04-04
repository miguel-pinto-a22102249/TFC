<?

defined('BASEPATH') or exit('No direct script access allowed');

require 'application/libraries/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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

        if ($this->session->userdata('login_efetuado') == false) {
            redirect(base_url('admin/login'));
        }
    }

    public function index() {
        self::listar();
    }

    public function listar() {
        $Agregados = (new Agregado_Familiar())->obtemElementos();

        $this->load->view('admin/template/header', ["tituloArea" => "Agregados", "subtituloArea" => "Listar", "acoes" => [
            [
                "titulo" => "Adicionar",
                "link" => base_url('admin/agregados/adicionar'),
                "icone" => "fas fa-plus",
                'class' => 'button--add button--success'
            ]
        ]
        ]);
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
            $this->load->view('admin/template/header', ["tituloArea" => "Agregados", "subtituloArea" => "Editar"]);
            $this->load->view('admin/agregados/editar', ['Agregado' => $Agregado_Familiar]);
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

        $this->load->view('admin/template/header', ["tituloArea" => "Agregados - Constituintes", "subtituloArea" => "Listar", "acoes" => [
            [
                "titulo" => "Adicionar",
                "link" => base_url('admin/agregados/constituintes/adicionar'),
                "icone" => "fas fa-plus",
                'class' => 'button--add button--success'
            ]
        ]]);
        $this->load->view('admin/agregados/listarConstituintes', ['Constituintes' => $Constituintes]);
        $this->load->view('admin/template/footer');
    }

    public function eliminarConstituinte($id) {
        if ($this->session->userdata('login_efetuado') == false) {
            redirect(base_url('admin/login'));
        }

        echo $id;
        $Constituinte = new Constituinte();
        $Constituinte->carregaPorId($id);
//        $this->firephp->log($Constituinte);
//        var_dump($Constituinte);
        return;
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

    public function editarConstituinte($id) {
        if ($this->session->userdata('login_efetuado') == false) {
            redirect(base_url('admin/login'));
        }

        $this->load->helper('form');
        $this->load->library('form_validation');

        $Agregado_Familiar = new Agregado_Familiar();

        $Agregado_Familiar->carregaPorId($id);

        if (!$this->input->is_ajax_request()) {
            // Se não for uma requisição AJAX, carregue a view normalmente
            $this->load->view('admin/template/header', ["tituloArea" => "Agregados", "subtituloArea" => "Editar"]);
            $this->load->view('admin/agregados/editar', ['Agregado' => $Agregado_Familiar]);
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

    public function importacao() {
        // Inclua a biblioteca PHPExcel
        if ($this->session->userdata('login_efetuado') == false) {
            redirect(base_url('admin/login'));
        }

        if (!$this->input->is_ajax_request() && empty($_FILES['ficheiro']['name'])) {
            // Se não for uma requisição AJAX e não houver arquivo enviado, carregue a view normalmente
            $this->load->view('admin/template/header', ["tituloArea" => "Agregados", "subtituloArea" => "Importação"]);
            $this->load->view('admin/agregados/importacao');
            $this->load->view('admin/template/footer');
            return;
        }

        // Verifique se o arquivo foi enviado corretamente
        if (!empty($_FILES['ficheiro']['name'])) {
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($_FILES['ficheiro']['tmp_name']);
            $sheet = $spreadsheet->getActiveSheet();

            // Inicializar um array para armazenar os dados
            $dados = [];

            // Itera todas as linahs do documento
            foreach ($sheet->getRowIterator(2) as $row) {
                $rowData = [];
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false); // Permitir células vazias

                // Verifica se a linha contém pelo menos um valor
                $hasValue = false;
                foreach ($cellIterator as $cell) {
                    if (!is_null($cell->getValue())) {
                        $hasValue = true;
                        break;
                    }
                }

                // Se a linha não contiver nenhum valor, ignore-a
                if (!$hasValue) {
                    continue;
                }

                // Se a linha contiver pelo menos um valor, processe-a normalmente
                foreach ($cellIterator as $cell) {
                    $rowData[] = $cell->getValue();
                }

                // Adicione os dados da linha ao array principal
                $dados[] = $rowData;
            }

            $agregados = [];

            foreach ($dados as $dado) {
                $constituinte = new Constituinte();

                // Verifica se a data de nascimento é válida
                if (!empty($dado[3])) {
                    $aniversario = new DateTime($dado[3]);
                    $data_atual = new DateTime();

                    // Calcula a diferença entre as duas datas
                    $diferenca = $aniversario->diff($data_atual);

                    // Obtém a idade
                    $idade = $diferenca->y;
                } else {
                    // Define a idade como null (ou outro valor padrão, se preferir)
                    $idade = null;
                }

                // Define os atributos do constituinte
                $constituinte->define([
                    'NissAgregado' => $dado[0],
                    'Niss' => $dado[1],
                    'Nome' => $dado[2],
                    'DataNascimento' => $dado[3],
                    'IdAgregado' => null,
                ]);

                $constituinte->Idade = $idade;

                $constituinte->calculaEscalao();


                // Adiciona o constituinte ao array de agregados
                if (!isset($agregados[$dado[0]])) {
                    $agregados[$dado[0]] = [$constituinte];
                } else {
                    $agregados[$dado[0]][] = $constituinte;
                }
            }


            // Carrega a view para exibir os resultados
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'message' => 'Dados Importados com sucesso', 'view' => $this->load->view('admin/agregados/importacao_tabela', ['agregados' => $agregados], true)]);
            return;
        }
    }

    public function guardarImportacao() {
        // Inclua a biblioteca PHPExcel
        if ($this->session->userdata('login_efetuado') == false) {
            redirect(base_url('admin/login'));
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['dados'])) {
            $dados = json_decode($_POST['dados'], true);


            foreach ($dados as $IdAgregado => $constituinte_temp) {
                $agregado = new Agregado_Familiar();
                $agregado->define([
                    'NissConstituintePrincipal' => $IdAgregado,
                    'Grupo' => null,
                    'Segmento' => url_title($IdAgregado, 'dash', true) . '-' . time() . '-' . rand(0, 1000),
                    'Estado' => 1
                ]);
                $agregado->grava();
            }

            //Para obter todos os agregados que estão na base de dados
            $agregados = (new Agregado_Familiar())->obtemElementos(null, ['Estado' => 1]);

            foreach ($dados as $NissAgregado => $constituinte_temp) {


                $IdAgregado = null;
                //Para procurar qual o agregado para ser usado no constituinte para preencher o IdAgregado
                foreach ($agregados as $agregado) {
                    if ($agregado->getNissConstituintePrincipal() == $NissAgregado) {
                        $IdAgregado = $agregado->getId();
                        break;
                    }
                }

                foreach ($constituinte_temp as $constituinte_novo) {
                    $constituinte = new Constituinte();
                    $constituinte->define([
                        'Niss' => $constituinte_novo['Niss'],
                        'Nome' => $constituinte_novo['Nome'],
                        'DataNascimento' => $constituinte_novo['DataNascimento'],
                        'IdAgregado' => $IdAgregado,
                        'Estado' => 1,
                        'Segmento' => url_title($constituinte_novo['Niss'], 'dash', true) . '-' . time() . '-' . rand(0, 1000),
                    ]);
                    $constituinte->calculaEscalao();
                    unset($constituinte->Idade);
                    $constituinte->grava();
                }
            }
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'message' => 'Dados importados com sucesso']);
            return;
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Ocorreu um erro ao gravar os dados importados']);
            return;
        }
    }


}
