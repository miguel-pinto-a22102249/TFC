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

    /*
 * @var String
 */
    public $IdsEntidadesDistribuidoras;

    /* Estado */

    const TABELA = 'agregado_familiar';

    public function __construct() {
        parent::__construct();
        $this->load->database('default');
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

    /**
     * @return mixed
     */
    public function getIdsEntidadesDistribuidoras() {
        return $this->IdsEntidadesDistribuidoras;
    }

    /**
     * @param mixed $IdsEntidadesDistribuidoras
     */
    public function setIdsEntidadesDistribuidoras($IdsEntidadesDistribuidoras): void {
        $this->IdsEntidadesDistribuidoras = $IdsEntidadesDistribuidoras;
    }



}
