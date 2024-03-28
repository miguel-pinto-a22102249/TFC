<?

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('login');
        $this->load->model('log');
        $this->load->library('session');
        if ($this->session->userdata('login_efetuado') == false) {
            redirect(base_url());
            return;
        }
    }

    public function index() {
        $login = new Login();

        // <editor-fold defaultstate="collapsed" desc="Obtem Logs">
        $Data['logs'] = "";

        if ($login->eAdmin() == true || $login->eSuperAdmin() == true) {
            $ordenacao = [
                'DataCriacao' => 'Desc'
            ];
            $limites['limite'] = 5;
            $Data['logs'] = $this->log->obtemLogs($ordenacao, null, $limites, false);
        }
//        $this->firephp->log($Data['logs']);
        // </editor-fold>

        $this->load->view('admin/template/header', ["tituloArea" => "Dashboard", "subtituloArea" => "Bem vindo"]);
        $this->load->view('admin/home', ['logs' => $Data['logs']]);
        $this->load->view('admin/template/footer');
    }

    /**
     * manda para a view de page not found
     *
     * @version 1.0
     *
     */
    public function pagenotfound() {
        $this->load->view('admin/template/header', ['menu' => false]);
        $this->load->view('base/page_not_found');
        $this->load->view('admin/template/footer');
    }

}
