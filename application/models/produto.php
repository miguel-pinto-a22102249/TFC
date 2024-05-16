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
     * @var String
     */
    public $Categoria;

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

    /**
     * @return mixed
     */
    public function getCategoria() {
        return $this->Categoria;
    }

    public function getDesignacaoCategoria() {
        $categorias = explode(',',
            str_replace(["[", "]"], "", config_item("produtos.classificacao")));
        foreach ($categorias as $categoria) {
            $codigo = explode(':', $categoria)[0];
            $nome = explode(':', $categoria)[1];
            if ($codigo == $this->Categoria) {
                return $nome;
            }
        }
        return '';
    }

    /**
     * @param mixed $Categoria
     */
    public function setCategoria($Categoria): void {
        $this->Categoria = $Categoria;
    }


//</editor-fold>


}
