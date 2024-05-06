<?


/**
 * Model Distribuicao_Individual_Constituinte
 */
class Distribuicao_Individual_Constituinte extends Model_Base {

    /*
     * @var String
     */
    public $NissConstituinte;

    /*
     * @var int
     */
    public $ProdutosQuantidades; // [id_produto => quantidade]

    /*
     * @var date
     */
    public $Data;


    const TABELA = 'distribuicao_individual_constituinte';

    public function __construct() {
        parent::__construct();
        $this->load->database('default');
    }

    /**
     * @return mixed
     */
    public function getNissConstituinte() {
        return $this->NissConstituinte;
    }

    /**
     * @param mixed $NissConstituinte
     */
    public function setNissConstituinte($NissConstituinte): void {
        $this->NissConstituinte = $NissConstituinte;
    }

    /**
     * @return mixed
     */
    public function getIdEntrega() {
        return $this->IdEntrega;
    }

    /**
     * @param mixed $IdEntrega
     */
    public function setIdEntrega($IdEntrega): void {
        $this->IdEntrega = $IdEntrega;
    }

    /**
     * @return mixed
     */
    public function getProdutosQuantidades() {
        return $this->ProdutosQuantidades;
    }

    /**
     * @param mixed $ProdutosQuantidades
     */
    public function setProdutosQuantidades($ProdutosQuantidades): void {
        $this->ProdutosQuantidades = $ProdutosQuantidades;
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


}
