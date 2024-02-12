<?

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Logins
 * 
 * @version 1.0
 * 
 */
class Logins extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('login');
        $this->load->model('log');
        $this->load->helper('form');
        $this->load->library('form_validation');
        parse_str($_SERVER['QUERY_STRING'], $_GET);
        $this->load->library('session');
    }

    public function index() {
        $this->load->view('admin/login/area_login');
    }

    public function consultar($id) {

//consultar utilizador por password e id
        $Data['utilizador'] = $this->Login->carregaPorIdPass($id);

        if (empty($Data['utilizador'])) {
            show_404();
        }
        $Data['Nome'] = $Data['utilizador']['Nome'];

        $this->load->view('admin/templates/header');
        $this->load->view('admin/utilizadores/utilizador', $Data);
        $this->load->view('admin/templates/footer');
    }

    public function login() {
        $this->load->helper(array('form', 'url'));
        $this->load->helper('form');
        $this->load->library('form_validation');

        $username = $this->input->post('Username');
        $password = $this->input->post('Password');

        $utilizador = new Login;
        $this->form_validation->set_rules('Username', 'Username', 'required');
        $this->form_validation->set_rules('Password', 'Password', 'required');

//        if ($this->form_validation->set_rules('Username', 'Username', 'required') == TRUE) {
//            $this->form_validation->set_rules('Password', 'Password', 'required');
//        }
        $this->form_validation->set_message('required', '<i class="fas fa-exclamation-triangle"></i> Por favor preencha o campo corretamente.');
//        var_dump($this->form_validation);

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('admin/login/area_login');
        } else {
            if (!$utilizador->carregaPorLogin($username, $password)) {
                $erro = TRUE;
                $this->load->view('admin/login/area_login', array('erro' => $erro));
                return;
            }
            if (is_null($utilizador->Foto)) {
                $foto = "default-user.png";
            } else {
                $foto = $utilizador->Foto;
            }

            $userData = array(
                'login_efetuado' => TRUE,
                'Id' => $utilizador->Id,
                'Estado' => $utilizador->Estado,
                'DataCriacao' => $utilizador->DataCriacao,
                'Nome' => $utilizador->Nome,
                'Username' => $utilizador->Username,
                'Password' => $utilizador->Password,
                'Foto' => $foto,
                'TipoUtilizador' => $utilizador->TipoUtilizador,
            );
            $this->session->set_userData($userData);
            $erro = FALSE;
            $this->load->view('admin/login/area_login', array('erro' => $erro));
        }
    }

    /**
     * Função par enviar email com a nova password
     * 
     * @author André Carvalho
     */
    public function resetPassword() {
        $this->load->helper(array('form', 'url'));
        $this->load->helper('form');
        $Utilizador = new Login;

        $Username = $this->input->post('username');

        if ($Username == "") {
            $data = array(
                "Sucesso" => FALSE,
                "Mensagem" => "Username incorreto!"
            );
            echo json_encode($data);
        } else {

            if ($Utilizador->carregaUserName($Username)) {

                //Gera password
                $NovaPassword = generatePassword();

                //Cria password hash e define no utilizador a nova password
                $Utilizador->setPassword(criaPasswordHash($NovaPassword));

                if ($Utilizador->edita($Utilizador->getId())) {

                    $config = array(
                        'from' => "ecpp@ecpp.com",
                        'nome' => "ECPP - Escola de Condução de Pero Pinheiro",
                        'to' => $Utilizador->Email,
                        'subject' => "Reset Password",
                        'mensagem' => $this->load->view('admin/email/template_email', array("Username" => $Username, "NovaPassword" => $NovaPassword), true),
                        'debugger_mode' => false
                    );

                    if (enviaEmail($config)) {
                        $data = array(
                            "Sucesso" => TRUE,
                            "Mensagem" => '<div><i class="fas fa-check-circle" style="color:#b5d56d;"></i> Foi enviado um email com a nova password 
                        para o email associado a este username.</div>'
                        );
                        echo json_encode($data);
                    }
                } else {
                    $data = array(
                        "Sucesso" => FALSE,
                        "Mensagem" => '<div><i class="fas fa-exclamation-circle" style="color:#e13300;"></i> Algo de inesperado aconteceu por favor recarregue a página e tente novamente, caso o problema persista, por favor contacte o suporte.</div>'
                    );
                    echo json_encode($data);
                }
            } else {
                $data = array(
                    "Sucesso" => FALSE,
                    "Mensagem" => 'O Username inserido não foi encontrado no nosso sistema.'
                );
                echo json_encode($data);
            }
        }
    }

    public function logout() {

        if ($this->session->userData('login_efetuado')) {
            $this->session->unset_userData('login_efetuado');
            $this->session->unset_userData('Id');
            $this->session->unset_userData('Estado');
            $this->session->unset_userData('DataCriacao');
            $this->session->unset_userData('Nome');
            $this->session->unset_userData('Username');
            $this->session->unset_userData('Password');
            $this->session->unset_userData('Foto');
            $this->session->unset_userData('TipoUtilizador');
            $this->session->sess_destroy();
            redirect(base_url() . 'admin');
        } else {
            show_404();
            exit;
        }
    }

    public function eliminar($id) {

        if ($this->session->userdata('login_efetuado') == FALSE) {
            redirect(base_url('admin/login'));
        }

        $utilizadorNaoAlterada = new Login;
        $utilizadorNaoAlterada->carregaPorId($id);

        if ($utilizadorNaoAlterada->Foto != "") {

            $eliminar = 'assets/fotos_utilizadores/' . $utilizadorNaoAlterada->Foto;
            unlink($eliminar);
        }
        $resultado = $utilizadorNaoAlterada->eliminar($id);

        if ($resultado === true) {
            $data = array(
                "Sucesso" => TRUE,
                "Mensagem" => 'Utilizador eliminado com sucesso'
            );
            echo json_encode($data);
        } else {
            $data = array(
                "Sucesso" => FALSE,
                "Mensagem" => 'Não foi possivel eliminar o Utilizador solicitado.'
            );
            echo json_encode($data);
        }
    }

    /**
     * Abre a view de edicao
     * 
     * @param int $id
     */
    public function viewEditar($id) {
//        $this->firephp->log("** View EDITAR **");

        /* Verifica se o login atual é de um ADMIN */
        $Utilizador = new Login;
        $Utilizador->eAdmin() != TRUE ? redirect(base_url('admin/login')) : '';

        $Utilizador->carregaPorId($id);

        $this->load->view('admin/template/header');
        $this->load->view('admin/login/editar_utilizador', array('Utilizador' => $Utilizador));
        $this->load->view('admin/template/footer');
    }

    public function editar($id) {
//        $this->firephp->log("** EDITAR **");
//        exit();
        /* Verifica se o login atual é de um ADMIN */
        $Utilizador = new Login;
        $Utilizador->eAdmin() != TRUE ? redirect(base_url('admin/login')) : '';

        $log = new Log();

        $Utilizador->carregaPorId($id);

        $Nome = $this->input->post('Nome');
        $Username = $this->input->post('Username');
//        $Password = $this->input->post('Password');
        $Estado = $this->input->post('Estado');
        $TipoUtilizador = $this->input->post('TipoUtilizador');

        $this->form_validation->set_rules('Nome', 'Nome', 'required');
//        $this->form_validation->set_rules('Username', 'Username', 'required|is_unique[utilizador.Username]');
//        $this->form_validation->set_rules('Password', 'Password', 'required|matches[ConfirmPassword]');
        $this->form_validation->set_rules('Estado', 'Estado', 'required');
        $this->form_validation->set_rules('TipoUtilizador', 'TipoUtilizador', 'required');

        $this->form_validation->set_message('required', '<i class="fas fa-exclamation-triangle"></i> Por favor preencha o campo corretamente.');
        $this->form_validation->set_message('is_unique', '<i class="fas fa-exclamation-triangle"></i> Username já existe.');
        $this->form_validation->set_message('matches', '<i class="fas fa-exclamation-triangle"></i> Passwords não coincidem.');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('admin/template/header');
            $this->load->view('admin/login/editar_utilizador', array('Utilizador' => $Utilizador));
            $this->load->view('admin/template/footer');
        } else {
//
//            $Utilizador->define(array(
//                'Nome' => $Nome,
//                'Username' => $Username,
//                'Estado' => $Estado,
//                'TipoUtilizador' => $TipoUtilizador
//            ));
//            $this->firephp->log($TipoUtilizador);
            $Utilizador->setNome($Nome);
            $Utilizador->setUsername($Username);
            $Utilizador->setEstado($Estado);
            $Utilizador->setTipoUtilizador($TipoUtilizador);

            if ($Utilizador->edita($id) == true) {
                $log->define(array(
                    'Descricao' => "Utilizador: " . $this->session->userdata('Id') . " editou a Categoria: Id= " . $Utilizador->getId() . " Nome = " . $Utilizador->getNome()
                ));
                $log->grava();
                $this->load->view('admin/template/header');
                $this->load->view('admin/login/editar_utilizador', array('Utilizador' => $Utilizador));
                $this->load->view('admin/base/popup_sucesso', array("menssagem" => "Utilizador editado com sucesso"));
                $this->load->view('admin/template/footer');
            } else {
                $this->load->view('admin/template/header');
                $this->load->view('admin/login/editar_utilizador', array('Utilizador' => $Utilizador));
                $this->load->view('admin/base/popup_sucesso', array("menssagem" => "Ocorreu um erro ao gravar a edição"));
                $this->load->view('admin/template/footer');
            }
        }
    }

    public function criar() {
        if ($this->session->userdata('login_efetuado') == FALSE) {
            redirect(base_url('admin/login'));
        }

        $utilizador = new Login();
        $Log = new Log();
        $this->load->helper('form');
        $this->load->library('form_validation');

        $Nome = $this->input->post('Nome');
        $Username = $this->input->post('Username');
        $Email = $this->input->post('Email');
        $Password = $this->input->post('Password');
        $Estado = $this->input->post('Estado');
        $TipoUtilizador = $this->input->post('TipoUtilizador');

        $this->form_validation->set_rules('Nome', 'Nome', 'required');
        $this->form_validation->set_rules('Username', 'Username', 'required|is_unique[utilizador.Username]');
        $this->form_validation->set_rules('Password', 'Password', 'required|matches[ConfirmPassword]');
        $this->form_validation->set_rules('Estado', 'Estado', 'required');
        $this->form_validation->set_rules('TipoUtilizador', 'TipoUtilizador', 'required');
        $this->form_validation->set_rules('Email', 'Email', 'required');

        $this->form_validation->set_message('required', '<i class="fas fa-exclamation-triangle"></i> Por favor preencha o campo corretamente.');
        $this->form_validation->set_message('is_unique', '<i class="fas fa-exclamation-triangle"></i> Username já existe.');
        $this->form_validation->set_message('matches', '<i class="fas fa-exclamation-triangle"></i> Passwords não coincidem.');
//        $this->firephp->log($_FILES);
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('admin/template/header');
            $this->load->view('admin/login/novo_utilizador');
            $this->load->view('admin/template/footer');
        } else {
            if (empty($_FILES["Foto"]["name"])) {
                $utilizador->define(array(
                    'Nome' => $Nome,
                    'DataCriacao' => date('Y-m-d H:i:s'),
                    'Username' => $Username,
                    'Email' => $Email,
                    'Estado' => $Estado,
                    'Foto' => $Foto = null,
                    'Password' => criaPasswordHash($Password),
                    'TipoUtilizador' => $TipoUtilizador,
                    'Segmento' => url_title($Username, 'dash', TRUE) . '-' . time(),
                ));
            } else {
                $name = mt_rand(0, 99) . "_" . date('Y-m-d_H-i-s') . "_" . $_FILES["Foto"]["name"];
                $destino = 'ficheiros/fotos_utilizadores/' . $name;
//                $this->firephp->log(move_uploaded_file($_FILES["Foto"]["tmp_name"], $destino));
                $utilizador->define(array(
                    'Nome' => $Nome,
                    'DataCriacao' => date('Y-m-d H:i:s'),
                    'Username' => $Username,
                    'Email' => $Email,
                    'Estado' => $Estado,
                    'Foto' => $Foto = $name,
                    'Password' => criaPasswordHash($Password),
                    'TipoUtilizador' => $TipoUtilizador,
                    'Segmento' => url_title($Username, 'dash', TRUE) . '-' . time(),
                ));
            }


            $Log->define(array(
                'Descricao' => "Utilizador: {$this->session->userdata('Id')} registou um novo utilizador - Username: {$Username}"
            ));
            $utilizador->grava();

            $this->listarUtilizadores();
//            $this->load->view('admin/template/header');
//            $this->load->view('admin/home');
//            $this->load->view('admin/template/footer');
        }
    }

    public function ConfirmPassword($Password, $ConfirmPassword) {
        if ($this->session->userdata('login_efetuado') == FALSE) {
            redirect(base_url('admin/login'));
        }
        $this->firephp->log("ConfirmPassword", $ConfirmPassword);
        $this->firephp->log("--------------");
        $this->firephp->log("Password", $Password);
        if ($Password != $ConfirmPassword) {
            return FALSE;
        }
        return TRUE;
    }

    public function listarUtilizadores($campoOrdenacao = null, $sentidoOrdenacao = null, $pagina = 1) {

        $this->load->library('pagination');

//        listar todos os utilizadores
        $filtragem = array(
            'Nome' => $this->input->get('search'),
            'Username' => $this->input->get('search')
        );

        //optimizar: criar metodo/ou usar mesmo metodo mas com parametro para contar as maquinas,
        // em vez de as obter da BD e construir objectos.
        $num_rows = (new Login)->obtemUtilizadores(null, $filtragem, null, true);

        if (strtolower($sentidoOrdenacao) == 'asc') {
            $sentidoOrdenacao = 'asc';
        } else {
            $sentidoOrdenacao = 'desc';
        }

        //TODO: adicionar os segmentos de ordenacao, caso eles existam.
        if (!is_null($campoOrdenacao)) {
            $base_url = base_url('utilizadores/listar/ordenar/' . $campoOrdenacao . '/' . $sentidoOrdenacao . '/');
            $uri_segment = 6;
        } else {
            //Campo default para ordenação
            $campoOrdenacao = 'DataCriacao';
            $base_url = base_url('utilizadores/listar/');
            $uri_segment = 3;
        }



        //numero de registos por pagina
        $porPagina = 4;

        if (count($_GET) > 0) {
            $config['suffix'] = '?' . http_build_query($_GET, '', "&");
            $pesquisaAtual = http_build_query($_GET, '', "&");
            $testeExistePesquisa = Str_replace("search=", "", $pesquisaAtual);
            $base_url = "pesquisar?" . $pesquisaAtual;
            $porPagina = 9999; //porque não tem paginação quando à pesquisa
        } else {
            $pesquisaAtual = '';
        }

        $config['base_url'] = $base_url;
        $Data['pesquisaAtual'] = $pesquisaAtual;
        $limites = array();

        $limites['limite'] = $porPagina;
        $limites['offset'] = $pagina * $porPagina - $porPagina;
        if ($campoOrdenacao && $campoOrdenacao) {
            $ordenacao = array(
                $campoOrdenacao => $sentidoOrdenacao
            );
        } else {
            $ordenacao = "";
        }

        $Data['utilizadores'] = (new Login)->obtemUtilizadores($ordenacao, $filtragem, $limites, false);

        $config = getConfigPaginacao($base_url, $num_rows, $porPagina, $uri_segment, 3, $pagina);

        $this->pagination->initialize($config);

        $Data['links'] = $this->pagination->create_links();
        $Data['slider'] = true;
        $this->load->view('admin/template/header', $Data);
        $this->load->view('admin/login/listar_utilizadores', $Data);
        $this->load->view('admin/template/footer');
    }

}
