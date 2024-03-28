<?


class Login extends Model_Base {
    /*
     * var string
     */

    public $Id;
    public $Nome;
    public $Password;
    public $TipoUtilizador;
    public $Username;
    public $Foto;
    public $Segmento;
    public $Email;

    const SUPER_ADMIN = 5;
    const ADMIN = 4;
    const UTILIZADOR = 3;
    const TABELA = 'utilizador';

    public function __construct() {
        parent::__construct();
        $this->load->database('default');
    }

    public function define($dados) {
        if (empty($dados['Id'])) {
            $this->Estado = $dados['Estado'];
            $this->DataCriacao = $dados['DataCriacao'];
            $this->Nome = $dados['Nome'];
            $this->Username = $dados['Username'];
            $this->Email = $dados['Email'];
            $this->Foto = $dados['Foto'];
            $this->Password = $dados['Password'];
            $this->TipoUtilizador = $dados['TipoUtilizador'];
            $this->Segmento = $dados['Segmento'];
        } else {
            $this->Id = $dados['Id'];
            $this->Estado = $dados['Estado'];
            $this->DataCriacao = $dados['DataCriacao'];
            $this->Nome = $dados['Nome'];
            $this->Username = $dados['Username'];
            $this->Email = $dados['Email'];
            $this->Foto = $dados['Foto'];
            $this->Password = $dados['Password'];
            $this->TipoUtilizador = $dados['TipoUtilizador'];
            $this->Segmento = $dados['Segmento'];
        }
    }

    public function carregaPorIdPass($Id = false) {
        if ($Id === false) {
            $query = $this->db->get('utilizador');
            return $query->result_array();
        }

        $query = $this->db->get_where('utilizador', ['Id' => $Id]);
        return $query->row_array();
    }

    /**
     * Carrega utilizador pelo Username, caso não encontre ou a password esteja errada devolve false
     *
     * @param string $Username
     * @param string $Password
     *
     * @return boolean
     */
    public function carregaPorLogin($Username, $Password) {
        if (is_null($Username) || is_null($Password)) {
            return false;
        }

        $query = $this->db->get_where('utilizador', ['Username' => $Username]);

        $dados_utilizador = $query->row_array();

        if (!empty($dados_utilizador)) {
            if (verificaPassword($Password, $dados_utilizador['Password']) == true) {
                $this->define($dados_utilizador);
                return true;
            }
        }
        return false;
    }


    /**
     * Carrega um utilizador através do seu username
     * @author André Carvalho
     *
     *
     * @param String $Username
     *
     * @return boolean+
     */
    public function carregaUserName($Username = false) {
        if (is_null($Username)) {
            return false;
        }

        //obter noticias (- falta obter noticias com base na ordenacao e filtragens, caso definidas)
        $query = $this->db->get_where('utilizador', ['Username' => $Username]);
        $dados_utilizador = $query->row_array();

        if (!empty($dados_utilizador)) {
            //definir os seus valores
            $this->define($dados_utilizador);

            return true;
        }
        return false;
    }


    /**
     * Se o login atual for um admin a função devolve TRUE, caso contrário devolve FALSE
     *
     * @version 1.0
     * @return boolean
     */
    public function eAdmin() {
        if ($this->session->userdata('TipoUtilizador') == Login::ADMIN) {
            return true;
        }
        return false;
    }

    /**
     * Se o login atual for um Super Admin a função devolve TRUE, caso contrário devolve FALSE
     *
     * @version 1.0
     * @return boolean
     */
    public function eSuperAdmin() {
        if ($this->session->userdata('TipoUtilizador') == Login::SUPER_ADMIN) {
            return true;
        }
        return false;
    }

    //<editor-fold defaultstate="collapsed" desc="Getters e Setters">

    /**
     * @return mixed
     */
    public function getNome() {
        return $this->Nome;
    }

    /**
     * @param mixed $Nome
     */
    public function setNome($Nome): void {
        $this->Nome = $Nome;
    }

    /**
     * @return mixed
     */
    public function getPassword() {
        return $this->Password;
    }

    /**
     * @param mixed $Password
     */
    public function setPassword($Password): void {
        $this->Password = $Password;
    }

    /**
     * @return mixed
     */
    public function getTipoUtilizador() {
        return $this->TipoUtilizador;
    }

    /**
     * @param mixed $TipoUtilizador
     */
    public function setTipoUtilizador($TipoUtilizador): void {
        $this->TipoUtilizador = $TipoUtilizador;
    }

    /**
     * @return mixed
     */
    public function getUsername() {
        return $this->Username;
    }

    /**
     * @param mixed $Username
     */
    public function setUsername($Username): void {
        $this->Username = $Username;
    }

    /**
     * @return mixed
     */
    public function getFoto() {
        return $this->Foto;
    }

    /**
     * @return mixed
     */
    public function getCaminhoFoto() {
        return CAMINHO_IMAGENS_DINAMICAS . "fotos_utilizadores/" . $this->Foto;
    }

    /**
     * @param mixed $Foto
     */
    public function setFoto($Foto): void {
        $this->Foto = $Foto;
    }

    /**
     * @return mixed
     */
    public function getSegmento() {
        return $this->Segmento;
    }

    /**
     * @param mixed $Segmento
     */
    public function setSegmento($Segmento): void {
        $this->Segmento = $Segmento;
    }

    /**
     * @return mixed
     */
    public function getEmail() {
        return $this->Email;
    }

    /**
     * @param mixed $Email
     */
    public function setEmail($Email): void {
        $this->Email = $Email;
    }

    //</editor-fold>


}
