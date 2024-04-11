<?


/**
 * Model Distribuicao_Individual_Produto
 */
class Distribuicao_Individual_Produto extends Model_Base {

    /*
     * @var String
     */
    public $Niss;

    /*
     * @var int
     */
    public $IdEntrega;

    /*
     * @var int
     */
    public $IdProduto;

    /*
     * @var date
     */
    public $Data;

    /*
     * @var float
     */
    public $Quantidade;


    const TABELA = 'distribuicao_individual_produto';

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
    public function getIdProduto() {
        return $this->IdProduto;
    }

    /**
     * @param mixed $IdProduto
     */
    public function setIdProduto($IdProduto): void {
        $this->IdProduto = $IdProduto;
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

    /**
     * @return mixed
     */
    public function getQuantidade() {
        return $this->Quantidade;
    }

    /**
     * @param mixed $Quantidade
     */
    public function setQuantidade($Quantidade): void {
        $this->Quantidade = $Quantidade;
    }


}
