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

        !eUtilizador() ? '' : redirect(base_url('dashboard'));
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
        $IdsEntidadesDistribuidoras = $this->input->post('IdsEntidadesDistribuidoras');

        $this->form_validation->set_rules('NissConstituintePrincipal', 'NissConstituintePrincipal', 'required|is_unique[' . Agregado_Familiar::TABELA . '.NissConstituintePrincipal]');
        $this->form_validation->set_rules('Grupo', 'Grupo', 'required|is_unique[' . Agregado_Familiar::TABELA . '.Grupo]');
        $this->form_validation->set_rules('IdsEntidadesDistribuidoras', 'IdsEntidadesDistribuidoras', 'required');

        $this->form_validation->set_message('required', '<i class="fas fa-exclamation-triangle"></i> Por favor preencha o campo corretamente.');
        $this->form_validation->set_message('numeric', '<i class="fas fa-exclamation-triangle"></i> Por favor preencha o campo corretamente.');
        $this->form_validation->set_message('is_unique', '<i class="fas fa-exclamation-triangle"></i> Já existe um agregado com este valor.');

        if ($this->form_validation->run() === false) {
            $errors = [];

            // Construa um array de erros associados aos campos
            $fields = ['NissConstituintePrincipal', 'Grupo', 'IdsEntidadesDistribuidoras'];

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
                'IdsEntidadesDistribuidoras' => $IdsEntidadesDistribuidoras,
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


        $NissConstituintePrincipal = $this->input->post('NissConstituintePrincipal');
        $Grupo = $this->input->post('Grupo');
        $IdsEntidadesDistribuidoras = $this->input->post('IdsEntidadesDistribuidoras');


        $this->form_validation->set_rules('NissConstituintePrincipal', 'NissConstituintePrincipal', 'required');
        $this->form_validation->set_rules('Grupo', 'Grupo', 'numeric');
        $this->form_validation->set_rules('IdsEntidadesDistribuidoras', 'IdsEntidadesDistribuidoras', 'required');

        $this->form_validation->set_message('required', '<i class="fas fa-exclamation-triangle"></i> Por favor preencha o campo corretamente.');
        $this->form_validation->set_message('numeric', '<i class="fas fa-exclamation-triangle"></i> Por favor preencha o campo corretamente.');

        if ($this->form_validation->run() === false) {
            $errors = [];

            // Construa um array de erros associados aos campos
            $fields = ['NissConstituintePrincipal', 'Grupo', 'IdsEntidadesDistribuidoras'];

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
                $this->load->view('admin/template/header', ["tituloArea" => "Agregados", "subtituloArea" => "Editar"]);
                $this->load->view('admin/agregados/editar');
                $this->load->view('admin/template/footer');
            }
        } else {
//            if ($Agregado_Familiar->getNissConstituintePrincipal() != $NissConstituintePrincipal) {
//                $Agregado_Familiar->setNissConstituintePrincipal($NissConstituintePrincipal);
//                $Agregado_Familiar->setSegmento(url_title($NissConstituintePrincipal, 'dash', true) . '-' . time() . '-' . rand(0, 1000));
//            }
            $Agregado_Familiar->setIdsEntidadesDistribuidoras(json_encode($IdsEntidadesDistribuidoras));
            $Agregado_Familiar->setGrupo($Grupo);


            if ($Agregado_Familiar->edita($id)) {
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'Agregado editado com sucesso']);
                return;
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Ocorreu um erro ao editar o agregado']);
                return;
            }
        }
    }

    public function viewEditarAgregado($id, $soConsulta = false) {
        if ($this->session->userdata('login_efetuado') == false) {
            redirect(base_url('admin/login'));
        }

        $log = new Log();
        $Agregado = new Agregado_Familiar();
        $Agregado->carregaPorId($id);

        if ($this->input->is_ajax_request()) {
            $html = $this->load->view('admin/agregados/editar', ['Agregado' => $Agregado], true);
            $html = $this->load->view('admin/popup/default_popup', ['titulo' => 'Editar Agregado',
                                                                    'soConsulta' => $soConsulta,
                                                                    'html' => $html, 'URLNewWindow' => base_url("admin/agregados/editar/{$id}")], true);
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'message' => '', 'view' => $html]);
            return;
        } else {
            // Se não for uma requisição AJAX, carregue a view normalmente
            $this->load->view('admin/template/header', ["tituloArea" => "Agregados", "subtituloArea" => "Editar"]);
            $this->load->view('admin/agregados/editar', ['Agregado' => $Agregado]);
            $this->load->view('admin/template/footer');
            return;
        }
    }

    public function eliminar($id) {
        if ($this->session->userdata('login_efetuado') == false) {
            redirect(base_url('admin/login'));
        }

        if (count((new Constituinte())->obtemElementos(null, ['IdAgregado' => $id])) > 0) {
            echo json_encode(['success' => false, 'message' => 'Não é possivel eliminar o agregado porque existem constituintes associados.']);
            return;
        }

        $Agregado = new Agregado_Familiar();
        $Agregado->carregaPorId($id);

        $resultado = $Agregado->eliminar($id);


        if ($resultado === true) {
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'message' => 'Agregado eliminado com sucesso.']);
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Não foi possivel eliminar o Agregado solicitado.']);
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
        $DataNascimento = $this->input->post('DataNascimento');

        $this->form_validation->set_rules('Niss', 'Niss', 'required|numeric');
        $this->form_validation->set_rules('IdEscalao', 'IdEscalao', 'required|numeric');
        $this->form_validation->set_rules('IdAgregado', 'IdAgregado', 'required|numeric');
        $this->form_validation->set_rules('IdAgregado', 'IdAgregado', 'required|date_valid');

        $this->form_validation->set_message('required', '<i class="fas fa-exclamation-triangle"></i> Por favor preencha o campo corretamente.');
        $this->form_validation->set_message('numeric', '<i class="fas fa-exclamation-triangle"></i> Por favor preencha o campo corretamente.');

        if ($this->form_validation->run() === false) {
            $errors = [];

            // Construa um array de erros associados aos campos
            $fields = ['Niss', 'IdEscalao', 'IdAgregado', 'DataNascimento'];

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
                'DataNascimento' => $DataNascimento,
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
        $Constituinte = new Constituinte();
        $Constituinte->carregaPorId($id);
        $resultado = $Constituinte->eliminar($id);

        if ($resultado === true) {
            $data = [
                "success" => true,
                "message" => 'Constituinte eliminado com sucesso'
            ];
            echo json_encode($data);
        } else {
            $data = [
                "success" => false,
                "message" => 'Não foi possivel eliminar o Constituinte.'
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

        $Constituinte = new Constituinte();

        $Constituinte->carregaPorId($id);

        if (!$this->input->is_ajax_request()) {
            // Se não for uma requisição AJAX, carregue a view normalmente
            $this->load->view('admin/template/header', ["tituloArea" => "Constituinte", "subtituloArea" => "Editar"]);
            $this->load->view('admin/agregados/editarConstituinte', ['Constituinte' => $Constituinte]);
            $this->load->view('admin/template/footer');
            return;
        }


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
                echo json_encode(['success' => false, 'errors' => $errors, 'message' => 'Erro ao editar constituinte']);
                return;
            } else {
                // Se não for uma requisição AJAX, carregue a view normalmente
                $this->load->view('admin/template/header', ["tituloArea" => "Constituintes", "subtituloArea" => "Editar"]);
                $this->load->view('admin/agregados/editarConstituinte', ['Constituinte' => $Constituinte]);
                $this->load->view('admin/template/footer');
            }
        } else {
            if ($Constituinte->getNiss() != $Niss) {
                $Constituinte->setNiss($Niss);
                $Constituinte->setSegmento(url_title($Niss, 'dash', true) . '-' . time() . '-' . rand(0, 1000));
            }
            $Constituinte->setIdEscalao($IdEscalao);
            $Constituinte->setIdAgregado($IdAgregado);


            if ($Constituinte->edita($id)) {
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'Constituinte editado com sucesso']);
                return;
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Ocorreu um erro ao editar o constituinte']);
                return;
            }
        }
    }

    public function viewEditarConstituinte($id, $soConsulta = false) {
        if ($this->session->userdata('login_efetuado') == false) {
            redirect(base_url('admin/login'));
        }

        $log = new Log();
        $Constituinte = new Constituinte();
        $Constituinte->carregaPorId($id);

        if ($this->input->is_ajax_request()) {
            $html = $this->load->view('admin/agregados/editarConstituinte', ['Constituinte' => $Constituinte], true);
            $html = $this->load->view('admin/popup/default_popup', ['titulo' => 'Editar Constituinte',
                                                                    'soConsulta' => $soConsulta,
                                                                    'html' => $html, 'URLNewWindow' => base_url("admin/agregados/constituintes/editar/{$id}")], true);
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'message' => '', 'view' => $html]);
            return;
        } else {
            // Se não for uma requisição AJAX, carregue a view normalmente
            $this->load->view('admin/template/header', ["tituloArea" => "Constituintes", "subtituloArea" => "Editar"]);
            $this->load->view('admin/agregados/editarConstituinte', ['Constituinte' => $Constituinte]);
            $this->load->view('admin/template/footer');
            return;
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

            //Obter os constituintes que estão na base de dados para validarmos se já existem
            $constituintes_bd = (new Constituinte())->obtemElementos();
            //Obter os agregados que estão na base de dados para validarmos se já existem
            $agregados_bd = (new Agregado_Familiar())->obtemElementos();

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

                $constituinte->Erros = [];
                $constituinte->Importar = true;

                $CI = &get_instance();

                //Validações dos dados do excell com os constituintes já existentes na base de dados
                foreach ($constituintes_bd as $constituinte_temp) {
                    //Validar se já existe um constituinte com o mesmo NISS
                    if ($constituinte_temp->getNiss() == $constituinte->getNiss()) {
                        $constituinte->Erros[] = 'O constituinte já existe na base de dados';
                        $constituinte->Importar = false;
                    }
                }

                //Validações dos dados do excell com os constituintes já existentes na base de dados
                foreach ($agregados_bd as $agregado_temp) {
                    //Validar se já existe um agregado com o mesmo niss
                    if ($agregado_temp->getNissConstituintePrincipal() == $constituinte->getNiss()) {
                        $constituinte->Erros[] = 'O Agregado já existe na base de dados';
                        $constituinte->Importar = false;
                    }
                }

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
            $IdsEntidadesSelecionadas = json_encode($_POST['entidadesDistribuidoras'], true);

            $CI = &get_instance();


            //Obter os agregados que estão na base de dados para validarmos se já existem
            $agregados_bd = (new Agregado_Familiar())->obtemElementos();
            $agregados_bd_por_niss = [];

            foreach ($agregados_bd as $agregado) {
                $agregados_bd_por_niss[$agregado->getNissConstituintePrincipal()] = $agregado;
            }


            $n_agregados_importados = 0;
            foreach ($dados as $IdAgregado => $constituinte_temp) {
                if (!key_exists($IdAgregado, $agregados_bd_por_niss)) {
                    $agregado = new Agregado_Familiar();
                    $agregado->define([
                        'NissConstituintePrincipal' => $IdAgregado,
                        'IdsEntidadesDistribuidoras' => $IdsEntidadesSelecionadas,
                        'Grupo' => null,
                        'Segmento' => url_title($IdAgregado, 'dash', true) . '-' . time() . '-' . rand(0, 1000),
                        'Estado' => 1
                    ]);
                    $n_agregados_importados++;
                    $agregado->grava();
                }
            }

            //Para obter todos os agregados que estão na base de dados
            $agregados = (new Agregado_Familiar())->obtemElementos(null, ['Estado' => 1]);

            //Obter os constituintes que estão na base de dados para validarmos se já existem
            $constituintes_bd = (new Constituinte())->obtemElementos();
            $constituintes_bd_por_niss = [];
            foreach ($constituintes_bd as $constituinte_temp) {
                $constituintes_bd_por_niss[$constituinte_temp->getNiss()] = $constituinte_temp;
            }

            $n_constituintes_importados = 0;
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
                    if ($constituinte_novo['Importar'] && !key_exists($constituinte_novo['Niss'], $constituintes_bd_por_niss)) {
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
                        $n_constituintes_importados++;
                    }
                }
            }

            header('Content-Type: application/json');
            if ($n_constituintes_importados > 0 || $n_agregados_importados > 0) {
                echo json_encode(['success' => true, 'message' => 'Foram importados:  ' . $n_constituintes_importados . ' constituintes e ' . $n_agregados_importados . ' agregados com sucesso']);
            } else {
                echo json_encode(['success' => true, 'message' => 'Não existem dados a importar']);
            }
            return;
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Ocorreu um erro ao gravar os dados importados']);
            return;
        }
    }


}
