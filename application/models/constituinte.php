<?


/**
 * Model Agregado_Familiar
 */
class Constituinte extends Model_Base {

    /*
     * @var String
     */
    public $Niss;

    /*
     * @var int
     */
    public $Grupo;


    const TABELA = 'constituinte';

    public function __construct() {
        parent::__construct();
        $this->load->database('default');
    }

    /**
     * @return mixed
     */
    public function getNiss() {
        return $this->Niss;
    }

    /**
     * @param mixed $Niss
     */
    public function setNiss($Niss): void {
        $this->Niss = $Niss;
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




}
