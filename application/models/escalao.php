<?

/**
 * Model Escalao
 */
class Escalao extends Model_Base {
    /*
     * @var int
     */

    public $Id;
    /*
     * @var int
     */
    public $Designacao;
    /*
     * @var int
     */
    public $IdadeInicial;
    /*
     * @var int
     */
    public $IdadeFinal;

    public $Segmento;

    /*
      * @var JSON
     */
    public $Produtos;

    /* Estado */

    const ESTADO_ACTIVA = 1;
    const ESTADO_INATIVA = 2;
    const ESTADO_NOVA = 3;

    const TABELA = 'escalao';

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
    public function getDesignacao() {
        return $this->Designacao;
    }

    /**
     * @param mixed $Designacao
     */
    public function setDesignacao($Designacao): void {
        $this->Designacao = $Designacao;
    }

    /**
     * @return mixed
     */
    public function getIdadeInicial() {
        return $this->IdadeInicial;
    }

    /**
     * @param mixed $IdadeInicial
     */
    public function setIdadeInicial($IdadeInicial): void {
        $this->IdadeInicial = $IdadeInicial;
    }

    /**
     * @return mixed
     */
    public function getIdadeFinal() {
        return $this->IdadeFinal;
    }

    /**
     * @param mixed $IdadeFinal
     */
    public function setIdadeFinal($IdadeFinal): void {
        $this->IdadeFinal = $IdadeFinal;
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
    public function getProdutos() {
        return $this->Produtos;
    }

    /**
     * @param mixed $Produtos
     */
    public function setProdutos($Produtos): void {
        $this->Produtos = $Produtos;
    }



}
