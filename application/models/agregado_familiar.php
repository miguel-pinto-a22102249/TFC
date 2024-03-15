<?


/**
 * Model Agregado_Familiar
 */
class Agregado_Familiar extends Model_Base {

    /*
     * @var String
     */
    public $NissConstituintePrincipal;

    /*
     * @var int
     */
    public $Grupo;

    /*
     * @var String
     */
    public $Segmento;

    /* Estado */

    const TABELA = 'agregado_familiar';

    public function __construct() {
        parent::__construct();
        $this->load->database('default');
    }

    /**
     * Para Colocar definir os valores passados num objeto
     *
     * @param array[] $dados
     */
    public function define($dados) {
        if (empty($dados['Id'])) {
            $this->NissConstituintePrincipal = $dados['NissConstituintePrincipal'];
            $this->Grupo = $dados['Grupo'];
            $this->Segmento = $dados['Segmento'];
        } else {
            $this->Id = $dados['Id'];
            $this->NissConstituintePrincipal = $dados['NissConstituintePrincipal'];
            $this->Grupo = $dados['Grupo'];
            $this->Segmento = $dados['Segmento'];
        }
    }

    /**
     * Carrega objeto
     *
     * @param type $segmento
     *
     * @return type
     */
    public function carregaPorSegmento($segmento = false) {
        if ($segmento === false) {
            $query = $this->db->get(Escalao::TABELA);
            return $query->result_array();
        }

        $query = $this->db->get_where(Escalao::TABELA, ['Segmento' => $segmento]);

        $obj = $query->row_array();

        if (!empty($obj)) {
            $this->define($obj);
            return true;
        }
        return false;
    }

    public function carregaPorLogin($Username, $Password) {
        $this->firephp->log("carregaPorLogin");
        if (is_null($Username) || is_null($Password)) {
            return false;
        }
//        exit($Username);
        $query = $this->db->get_where('utilizador', ['Password' => $Password, 'Username' => $Username]);

        $dados_utilizador = $query->row_array();

        if (!empty($dados_utilizador)) {
            $this->define($dados_utilizador);

            return true;
        }
        return false;
    }


    /**
     * @return mixed
     */
    public function getId() {
        return $this->Id;
    }

    /**
     * @param mixed $Id
     */
    public function setId($Id): void {
        $this->Id = $Id;
    }

    /**
     * @return mixed
     */
    public function getNissConstituintePrincipal() {
        return $this->NissConstituintePrincipal;
    }

    /**
     * @param mixed $NissConstituintePrincipal
     */
    public function setNissConstituintePrincipal($NissConstituintePrincipal): void {
        $this->NissConstituintePrincipal = $NissConstituintePrincipal;
    }

    /**
     * @return mixed
     */
    public function getGrupo() {
        return $this->Grupo;
    }

    /**
     * @param mixed $Grupo
     */
    public function setGrupo($Grupo): void {
        $this->Grupo = $Grupo;
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


}
