<?

/**
 * Model Produto
 */
class Produto extends Model_Base {

    /*
     * @var String
     */
    public $Nome;

    /*
     * @var Int
     */
    public $StockInicial;

    /*
     * @var String
     */
    public $Detalhes;

    /*
     * @var Int
     */
    public $StockAtual;



    const TABELA = 'produto';

    const CAMPO_DESIGNACAO_DEFAULT = 'Nome';

    public function __construct() {
        parent::__construct();
        $this->load->database('default');
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
    public function getStockInicial() {
        return $this->StockInicial;
    }

    /**
     * @param mixed $StockInicial
     */
    public function setStockInicial($StockInicial): void {
        $this->StockInicial = $StockInicial;
    }

    /**
     * @return mixed
     */
    public function getDetalhes() {
        return $this->Detalhes;
    }

    /**
     * @param mixed $Detalhes
     */
    public function setDetalhes($Detalhes): void {
        $this->Detalhes = $Detalhes;
    }

    /**
     * @return mixed
     */
    public function getStockAtual() {
        return $this->StockAtual;
    }

    /**
     * @param mixed $StockAtual
     */
    public function setStockAtual($StockAtual): void {
        $this->StockAtual = $StockAtual;
    }


//</editor-fold>


}
