
<?

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Logins
 * 
 * @version 1.0
 * 
 */
class Logs extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('log');
        $this->load->model('login');
        $login = new Login;
        if ($this->session->userdata('login_efetuado') == FALSE || $login->eAdmin() == FALSE) {
            redirect(base_url('admin/login'));
        }
    }

    public function index() {
        $this->load->view('admin/logs/area_logs');
    }

    public function listaLogs() {
        $limites = array();
//        $limites['limite'] = 3;
        
        $logs = $this->log->obtemLogs(false, false, false);
//        $this->firephp->log($logs);
        
        $this->load->view('admin/template/header');
        $this->load->view('admin/logs/area_logs', array('logs' => $logs));
        $this->load->view('admin/template/footer');
    }

}
