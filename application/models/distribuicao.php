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

    /*
     * @var bigint
     */
    public $NumeroGrupoDistribuicao;

    public $IdEntidadeDistribuidora;

    const ESTADO_TERMINADA = 2;

    const TABELA = 'distribuicao';

    public function __construct() {
        parent::__construct();
        $this->load->database('default');
    }

    /**
     * Para obter o numero do grupo da ultima distribuicao
     *
     *
     * @return mixed
     */
    public function getNumeroGrupoUltimaDistribuicao($idEntidadeDistribuidora = null) {
        if ($idEntidadeDistribuidora == null) {
            $this->db->select('*, (SELECT MAX(NumeroGrupoDistribuicao) FROM distribuicao) AS MaxNumeroGrupoDistribuicao');
            $this->db->from(Distribuicao::TABELA);
            $query = $this->db->get();
            $row = $query->row();
        } else {
            $this->db->select('*, (SELECT MAX(NumeroGrupoDistribuicao) FROM distribuicao WHERE IdEntidadeDistribuidora = ' . $idEntidadeDistribuidora . ') AS MaxNumeroGrupoDistribuicao');
            $this->db->from(Distribuicao::TABELA);
            $this->db->where('IdEntidadeDistribuidora', $idEntidadeDistribuidora); // Adiciona a cláusula WHERE
            $query = $this->db->get();
            $row = $query->row();
        }


        if ($query->num_rows() > 0) {
            $row = $query->row();
            // Esta variavel serve para colocarmos todas as distribuicoes no mesmo grupo (num foturo podemos ter um obj acima deste para agrupar)
            return $row->MaxNumeroGrupoDistribuicao + 1;
        }
        return 0;
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

    /**
     * @return mixed
     */
    public function getNumeroGrupoDistribuicao() {
        return $this->NumeroGrupoDistribuicao;
    }

    /**
     * @param mixed $NumeroGrupoDistribuicao
     */
    public function setNumeroGrupoDistribuicao($NumeroGrupoDistribuicao): void {
        $this->NumeroGrupoDistribuicao = $NumeroGrupoDistribuicao;
    }

    /**
     * @return mixed
     */
    public function getIdEntidadeDistribuidora() {
        return $this->IdEntidadeDistribuidora;
    }

    /**
     * @param mixed $IdEntidadeDistribuidora
     */
    public function setIdEntidadeDistribuidora($IdEntidadeDistribuidora): void {
        $this->IdEntidadeDistribuidora = $IdEntidadeDistribuidora;
    }


}
