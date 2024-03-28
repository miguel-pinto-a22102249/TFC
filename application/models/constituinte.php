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
    public $IdAgregado;

    /*
     * @var int
     */
    public $IdEscalao;


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

    public function getDesignacaoAgregado() {
        $this->load->model('Agregado_Familiar');

        //Vamos validar se já foram obtidos os agregados, sendo assim não precisamos de fazer um novo pedido à BD
        if (isset($this->Agregados) && !empty($this->Agregados)) {
            $this->firephp->log("já está carregado");
            foreach ($this->Agregados as $Agregado) {
                if ($Agregado->getId() == $this->IdAgregado) {
                    return substr($Agregado->getNissConstituintePrincipal(), 0, 3) . " xxx xxx";
                }
            }
        } else {
            $this->firephp->log("Não está carregado");
            $this->Agregados = (new Agregado_Familiar)->obtemElementos(null, ['Estado' => 1]);

            foreach ($this->Agregados as $Agregado) {
                if ($Agregado->getId() == $this->IdAgregado) {
                    return substr($Agregado->getNissConstituintePrincipal(), 0, 3) . " xxx xxx";
                }
            }
        }
        return "-";
    }

    public function getDesignacaoEscalao() {
        $this->load->model('Escalao');

        //Vamos validar se já foram obtidos os agregados, sendo assim não precisamos de fazer um novo pedido à BD
        if (isset($this->Escaloes) && !empty($this->Escaloes)) {
            foreach ($this->Escaloes as $Escalao) {
                if ($Escalao->getId() == $this->IdEscalao) {
                    return $Escalao->getDesignacao();
                }
            }
        } else {
            $this->Escaloes = (new Escalao())->obtemElementos(null, ['Estado' => 1]);

            foreach ($this->Escaloes as $Escalao) {
                if ($Escalao->getId() == $this->IdEscalao) {
                    return $Escalao->getDesignacao();
                }
            }
        }
        return "-";
    }


}
