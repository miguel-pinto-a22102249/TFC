<?

class Configuracoes extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('login');
        $this->load->model('log');
        $this->load->library('session');
        if ($this->session->userdata('login_efetuado') == false) {
            redirect(base_url());
            return;
        }

        eSuperAdmin() ? '' : redirect(base_url('dashboard'));
    }

    public function index() {
        consultarConfigs();
    }

    public function consultarConfigs() {
        $config_file = 'application/config/config_editavel.php';
        $config_data = file_get_contents($config_file);

        // Inicializar array para armazenar as configurações
        $config_array = [];

        // Expressão regular para encontrar chave e valor
        $pattern = '/\$config\[\'([^\']+)\'\]\s*=\s*["\']?([^"\']+)["\']?;/';


        // Encontrar todas as correspondências no texto
        preg_match_all($pattern, $config_data, $matches, PREG_SET_ORDER);

        // Construir o array associativo
        foreach ($matches as $match) {
            $config_array[$match[1]] = $match[2];
        }


        $this->load->view('admin/template/header', ["tituloArea" => "Configurações",
                                                    "subtituloArea" => "Editar", "acoes" => [
            ]]);
        $this->load->view('admin/configuracoes/editar', ['data' => $config_array]);
        $this->load->view('admin/template/footer');
        return;
    }

    public function gravarConfigs() {
        //Obter configurações atualizadas do formulário
        $updated_config = $this->input->post();

        // Construir texto de configuração atualizado
        $new_config_text = "<?php\n\n  \n\n";
        foreach ($updated_config as $key => $value) {
            $new_config_text .= "\$config['$key'] = \"$value\";\n";
        }

        // Salvar as configurações de volta no arquivo
        $config_file = 'application/config/config_editavel.php';
        file_put_contents($config_file, $new_config_text);

        header('Content-Type: application/json');
        echo json_encode(['success' => true, null, 'message' => 'Configurações editadas com sucesso']);
        return;
    }

    private function parseConfigText($config_text) {
        // Initialize array to store configurations
        $config_array = [];

        // Regular expression pattern to find keys and values
        $pattern = '/\$config\[\'([^\']+)\'\]\s*=\s*["\']?([^"\']+)["\']?;/';

        // Find all matches in the text
        preg_match_all($pattern, $config_text, $matches, PREG_SET_ORDER);

        // Build the associative array
        foreach ($matches as $match) {
            $config_array[$match[1]] = $match[2];
        }

        return $config_array;
    }

}
