<?

/**
 * Model Produto
 */
class Entidade_Distribuidora extends Model_Base {

    /*
     * @var String
     */
    public $Nome;

    /*
     * @var String
     */
    public $NomeCompleto;

    /*
    * @var String
    */
    public $TipoOperacao;

    /*
     * @var String
     */
    public $NIF;

    /*
     * @var String
     */
    public $Morada;

    /*
     * @var String
     */
    public $Logo;


    const TABELA = 'entidade_distribuidora';

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
    public function getNIF() {
        return $this->NIF;
    }

    /**
     * @param mixed $NIF
     */
    public function setNIF($NIF): void {
        $this->NIF = $NIF;
    }

    /**
     * @return mixed
     */
    public function getMorada() {
        return $this->Morada;
    }

    /**
     * @param mixed $Morada
     */
    public function setMorada($Morada): void {
        $this->Morada = $Morada;
    }

    /**
     * @return mixed
     */
    public function getLogo() {
        return $this->Logo;
    }

    /**
     * @param mixed $logo
     */
    public function setLogo($logo): void {
        $this->Logo = $logo;
    }

    /**
     * @return mixed
     */
    public function getNomeCompleto() {
        return $this->NomeCompleto;
    }

    /**
     * @param mixed $NomeCompleto
     */
    public function setNomeCompleto($NomeCompleto): void {
        $this->NomeCompleto = $NomeCompleto;
    }

    /**
     * @return mixed
     */
    public function getTipoOperacao() {
        return $this->TipoOperacao;
    }

    /**
     * @param mixed $TipoOperacao
     */
    public function setTipoOperacao($TipoOperacao): void {
        $this->TipoOperacao = $TipoOperacao;
    }


//</editor-fold>


}
