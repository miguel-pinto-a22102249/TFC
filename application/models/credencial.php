<?

/**
 * Model Credencial
 */
class Credencial extends Model_Base {

    public $IdsObjetosAssociados;
    public $GrupoDistribuicao;

    public $Estado;
    public $Descricao;
    public $CaminhoAssinatura;


    const TABELA = 'credencial';

    public function __construct() {
        parent::__construct();
        $this->load->database('default');
    }

    /**
     * @return mixed
     */
    public function getIdsObjetosAssociados() {
        return $this->IdsObjetosAssociados;
    }

    /**
     * @param mixed $IdsObjetosAssociados
     */
    public function setIdsObjetosAssociados($IdsObjetosAssociados): void {
        $this->IdsObjetosAssociados = $IdsObjetosAssociados;
    }

    /**
     * @return mixed
     */
    public function getGrupoDistribuicao() {
        return $this->GrupoDistribuicao;
    }

    /**
     * @param mixed $GrupoDistribuicao
     */
    public function setGrupoDistribuicao($GrupoDistribuicao): void {
        $this->GrupoDistribuicao = $GrupoDistribuicao;
    }

    /**
     * @return mixed
     */
    public function getEstado() {
        return $this->Estado;
    }

    /**
     * @param mixed $Estado
     */
    public function setEstado($Estado): void {
        $this->Estado = $Estado;
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
    public function getCaminhoAssinatura() {
        return $this->CaminhoAssinatura;
    }

    /**
     * @param mixed $CaminhoAssinatura
     */
    public function setCaminhoAssinatura($CaminhoAssinatura): void {
        $this->CaminhoAssinatura = $CaminhoAssinatura;
    }


}
