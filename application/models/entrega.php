<?


/**
 * Model Entrega
 */
class Entrega extends Model_Base {

    /*
     * @var String
     */
    public $IdsDistribuicoesIndividuais;

    /*
     * @var int
     */
    public $IdAgregado;

    /*
     * @var string
     */
    public $Descricao;

    /*
     * @var date
     */
    public $DataEntrega;

    /*
     * @var int
     */
    public $TipoEntrega;


    const TABELA = 'entrega';

    const TIPO_ENTREGA_LOCAL = '20';
    const TIPO_ENTREGA_RESIDENCIA = '21';

    const ESTADO_TERMINADA = 2;

    public function __construct() {
        parent::__construct();
        $this->load->database('default');
    }

    /**
     * @return mixed
     */
    public function getIdsDistribuicoesIndividuais() {
        return $this->IdsDistribuicoesIndividuais;
    }

    /**
     * @param mixed $IdsDistribuicoesIndividuais
     */
    public function setIdsDistribuicoesIndividuais($IdsDistribuicoesIndividuais): void {
        $this->IdsDistribuicoesIndividuais = $IdsDistribuicoesIndividuais;
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
    public function getDescricao() {
        return $this->Descricao;
    }

    /**
     * @param mixed $Descricao
     */
    public function setDescricao($Descricao): void {
        $this->Descricao = $Descricao;
    }

    /**
     * @return mixed
     */
    public function getDataEntrega() {
        return $this->DataEntrega;
    }

    /**
     * @param mixed $DataEntrega
     */
    public function setDataEntrega($DataEntrega): void {
        $this->DataEntrega = $DataEntrega;
    }

    /**
     * @return mixed
     */
    public function getTipoEntrega() {
        return $this->TipoEntrega;
    }

    /**
     * @param mixed $TipoEntrega
     */
    public function setTipoEntrega($TipoEntrega): void {
        $this->TipoEntrega = $TipoEntrega;
    }

    public function getDesignacaoEstado() {
        switch ($this->Estado) {
            case self::ESTADO_TERMINADA:
                echo "Terminada";
                break;
            case self::ESTADO_ATIVO:
                echo "Por Assinar";
                break;
            case self::ESTADO_INATIVO:
                echo "Inativo";
                break;
        }
    }


}
