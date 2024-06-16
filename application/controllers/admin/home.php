<?

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('login');
        $this->load->model('log');
        $this->load->library('session');
        $this->load->driver('cache', ['adapter' => 'file']);
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

    public function tutoriais() {
        // Definindo se deve atualizar os vídeos ou não
        $atualizaVideos = false; // Mudar a true para atualizar os vídeos

        $tutoriais = [['olauPGtnNwc', '9qjW5ujPpKY'],
                      ['b-rsKv00P3w', 'OSOC25HAuxw'],
                      ['7-jZLWcBkIU', 'SZYZQjug--o'],
                      ['qSpkxx4wxCo', 'kYx8PwHPhlE', 'QXKej2__Fnc'],
                      ['eXuq7ZqQmAw'],
                      ['pP3pDjZHZQ8', '7DlrJBCqrJI'],
        ];

        // Flatten the $tutoriais array
        $flatTutoriais = array_merge(...$tutoriais);

        // Função para obter o título do vídeo
        function getVideoTitle($videoId) {
            $url = "https://www.youtube.com/watch?v=$videoId";

            // Initialize cURL session
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            // Execute cURL session and get the HTML
            $html = curl_exec($ch);
            curl_close($ch);

            // Check if HTML was retrieved
            if (!$html) {
                return 'Unknown title';
            }

            // Use regex to find the title in the HTML
            preg_match('/<title>(.*?)<\/title>/', $html, $matches);

            // The title is usually in the format "Video Title - YouTube"
            if (!empty($matches) && isset($matches[1])) {
                return str_replace(' - YouTube', '', $matches[1]);
            }

            return 'Unknown title';
        }

        // Carregar a cache existente ou criar uma nova
        $cacheKey = 'video_titles_cache';
        $cache = $this->cache->get($cacheKey);

        if ($cache === false || $atualizaVideos) {
            $cache = [];
            foreach ($flatTutoriais as $videoId) {
                $title = getVideoTitle($videoId);
                $cache[$videoId] = $title;
            }
            // Salvar a cache atualizada
            $this->cache->save($cacheKey, $cache, 86400); // 86400 segundos = 1 dia
        }

        // Passar os dados para a visão
        $data['tutoriais'] = $tutoriais;
        $data['cache'] = $cache;

        $this->load->view('admin/template/header', ["tituloArea" => "Tutoriais", "subtituloArea" => "Videos Tutoriais"]);
        $this->load->view('admin/tutoriais/listar', $data);
        $this->load->view('admin/template/footer');
    }


}
