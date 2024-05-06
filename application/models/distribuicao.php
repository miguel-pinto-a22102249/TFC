<?


/**
 * Model Distribuicao
 */
class Distribuicao extends Model_Base {

    /*
     * @var String
     */
    public $NissAgregado;

    /*
     * @var int
     */
    public $IdAgregado;

    /*
     * @var int
     */
    public $IdsEntregas;

    /*
     * @var date
     */
    public $Data;


    const TABELA = 'distribuicao';

    public function __construct() {
        parent::__construct();
        $this->load->database('default');
    }

    /**
     * @return mixed
     */
    public function getNissAgregado() {
        return $this->NissAgregado;
    }

    /**
     * @param mixed $NissAgregado
     */
    public function setNissAgregado($NissAgregado): void {
        $this->NissAgregado = $NissAgregado;
    }

    /**
     * @return mixed
     */
    public function getIdAgregado() {
        return $this->IdAgregado;
    }

    /**
     * @param mixed $IdAgregado
     */
    public function setIdAgregado($IdAgregado): void {
        $this->IdAgregado = $IdAgregado;
    }

    /**
     * @return mixed
     */
    public function getIdsEntregas() {
        return $this->IdsEntregas;
    }

    /**
     * @param mixed $IdsEntregas
     */
    public function setIdsEntregas($IdsEntregas): void {
        $this->IdsEntregas = $IdsEntregas;
    }

    /**
     * @return mixed
     */
    public function getData() {
        return $this->Data;
    }

    /**
     * @param mixed $Data
     */
    public function setData($Data): void {
        $this->Data = $Data;
    }

    public function getDesignacaoEstado(){
    }

}
