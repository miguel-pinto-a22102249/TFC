<?

class Generico extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('login');
        $this->load->model('log');
        $this->load->library('session');
        if ($this->session->userdata('login_efetuado') == FALSE) {
            redirect(base_url());
            return;
        }
    }

    public function index() {
        
    }

    /**
     * Efetua o Backup da BD
     * 
     * @version 1.0
     * 
     */
    public function AJAXbackupBD() {

        $format = "gzip";

        $nome_ficheiro = date("Y_m_d_h_i_s") . " _" . $this->db->database . '.' . $format;

        $prefs = array(
            'tables' => array(), // Array of tables to backup.
            'ignore' => array(), // List of tables to omit from the backup
            'format' => $format, // gzip, zip, txt
            'filename' => 'mybackup.sql', // File name - NEEDED ONLY WITH ZIP FILES
            'add_drop' => TRUE, // Whether to add DROP TABLE statements to backup file
            'add_insert' => TRUE, // Whether to add INSERT data to backup file
            'newline' => "\n"               // Newline character used in backup file
        );

        // Load the DB utility class
        $this->load->dbutil();

        // Backup your entire database and assign it to a variable
        $backup = & $this->dbutil->backup($prefs);

        // Load the file helper and write the file to your server
        $this->load->helper('file');
        $res = write_file('./ficheiros/backup_bd/' . $nome_ficheiro, $backup);

        if (!$res) {
            $data = array(
                "success" => FALSE,
                "message" => 'Não foi possivel guardar o ficheiro.'
            );
            echo json_encode($data);
        } else {
            $data = array(
                "success" => TRUE,
                "message" => 'Backup efetuado com sucesso'
            );
            echo json_encode($data);
        }
    }

    /**
     * Efetua o Backup da BD
     * 
     * @version 1.0
     * 
     */
    public function geraSiteMapAJAX() {

        $this->load->model('url');

        $urls = (new URL)->obtemUrls();
        $this->firephp->log($urls);




        /*
          <?xml version="1.0" encoding="UTF-8"?>
          <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
          <url>
          <loc>https://www.ecpp.pt/</loc>
          <lastmod>2020-01-07</lastmod>
          </url>
          <url>
          <loc>https://www.ecpp.pt/home</loc>
          <lastmod>2020-01-07</lastmod>
          </url>
          <url>
          <loc>https://www.ecpp.pt/sobre-nos</loc>
          <lastmod>2020-01-07</lastmod>
          </url>
          <url>
          <loc>https://www.ecpp.pt/servicos</loc>
          <lastmod>2020-01-07</lastmod>
          </url>
          <url>
          <loc>https://www.ecpp.pt/formacoes</loc>
          <lastmod>2020-01-07</lastmod>
          </url>
          <url>
          <loc>https://www.ecpp.pt/contactos</loc>
          <lastmod>2020-01-07</lastmod>
          </url>
          <url>
          <loc>https://www.ecpp.pt/politica-privacidade</loc>
          <lastmod>2020-01-07</lastmod>
          </url>
          </urlset>
         */


        if (!$res) {
            $data = array(
                "success" => FALSE,
                "message" => 'Não foi possivel guardar o ficheiro.'
            );
            echo json_encode($data);
        } else {
            $data = array(
                "success" => TRUE,
                "message" => 'Backup efetuado com sucesso'
            );
            echo json_encode($data);
        }
    }

}
