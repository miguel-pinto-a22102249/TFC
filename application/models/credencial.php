<?

/**
 * Model Credencial
 */
class Credencial extends Model_Base {

    public $IdsObjetosAssociados;
    public $GrupoDistribuicao;

    public $Estado;
    public $TipoCredencial;
    public $Descricao;
    public $CaminhoAssinaturaResponsavel;
    public $CaminhoAssinaturaResponsavelAgregado;
    public $Html;


    const TABELA = 'credencial';

    const TIPO_CREDENCIAL_A = 11;
    const TIPO_CREDENCIAL_B = 10;

    const ESTADO_ASSINADA = 5;

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
    public function getTipoCredencial() {
        return $this->TipoCredencial;
    }

    /**
     * @param mixed $TipoCredencial
     */
    public function setTipoCredencial($TipoCredencial): void {
        $this->TipoCredencial = $TipoCredencial;
    }

    /**
     * @return mixed
     */
    public function getCaminhoAssinaturaResponsavel() {
        return $this->CaminhoAssinaturaResponsavel;
    }

    /**
     * @param mixed $CaminhoAssinaturaResponsavel
     */
    public function setCaminhoAssinaturaResponsavel($CaminhoAssinaturaResponsavel): void {
        $this->CaminhoAssinaturaResponsavel = $CaminhoAssinaturaResponsavel;
    }

    /**
     * @return mixed
     */
    public function getCaminhoAssinaturaResponsavelAgregado() {
        return $this->CaminhoAssinaturaResponsavelAgregado;
    }

    /**
     * @param mixed $CaminhoAssinaturaResponsavelAgregado
     */
    public function setCaminhoAssinaturaResponsavelAgregado($CaminhoAssinaturaResponsavelAgregado): void {
        $this->CaminhoAssinaturaResponsavelAgregado = $CaminhoAssinaturaResponsavelAgregado;
    }

    /**
     * @return mixed
     */
    public function getHtml() {
        return $this->Html;
    }

    /**
     * @param mixed $Html
     */
    public function setHtml($Html): void {
        $this->Html = $Html;
    }






}
