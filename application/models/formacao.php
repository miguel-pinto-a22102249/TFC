<?

/**
 * Model Formacao
 */
class Formacao extends CI_Model {
    /*
     * @var int
     */

    public $Id;
    /*
     * @var int
     */
    public $Estado;
    /*
     * @var int
     */
    public $DataCriacao;
    /*
     * var string
     */
    public $Foto;
    public $Segmento;
    public $Nome;
    public $Descricao;
    public $DataInicio;
    public $DataInicioDestaque;
    public $DataFimDestaque;
    public $DestaqueHome;

    /* Estado */

    const ESTADO_ACTIVA = 1;
    const ESTADO_INATIVA = 2;
    const ESTADO_NOVA = 3;

    public function __construct() {
        parent::__construct();
        $this->load->database('default');
    }

    /**
     * Para Colocar definir os valores passados num objeto
     * 
     * @param array[] $dados
     */
    public function define($dados) {
        if (empty($dados['Id'])) {
            $this->Estado = $dados['Estado'];
            $this->DataCriacao = $dados['DataCriacao'];
            $this->Descricao = $dados['Descricao'];
            $this->Nome = $dados['Nome'];
            $this->Foto = $dados['Foto'];
            $this->Segmento = $dados['Segmento'];
            $this->DataInicio = $dados['DataInicio'] ? $dados['DataInicio'] : null;
            $this->DataInicioDestaque = $dados['DataInicioDestaque'] ? $dados['DataInicioDestaque'] : null;
            $this->DataFimDestaque = $dados['DataFimDestaque'] ? $dados['DataFimDestaque'] : null;
            $this->DestaqueHome = $dados['DestaqueHome'] ? $dados['DestaqueHome'] : 0;
        } else {
            $this->Id = $dados['Id'];
            $this->Estado = $dados['Estado'];
            $this->DataCriacao = $dados['DataCriacao'];
            $this->Descricao = $dados['Descricao'];
            $this->Nome = $dados['Nome'];
            $this->Foto = $dados['Foto'];
            $this->Segmento = $dados['Segmento'];
            $this->DataInicio = $dados['DataInicio'];
            $this->DataInicioDestaque = $dados['DataInicioDestaque'];
            $this->DataFimDestaque = $dados['DataFimDestaque'];
            $this->DestaqueHome = $dados['DestaqueHome'];
        }
    }

    /**
     * Carrega uma Formação para consulta através do seguemento
     * 
     * @param type $segmento
     * @return type
     */
    public function carregaPorSegmento($segmento = FALSE) {
        if ($segmento === FALSE) {
            $query = $this->db->get('formacao');
            return $query->result_array();
        }

        $query = $this->db->get_where('formacao', array('Segmento' => $segmento));
        
        $dados_formacao = $query->row_array();
        
         if (!empty($dados_formacao)) {
            $this->define($dados_formacao);
            return true;
        }
        return false;
        
    }

    public function carregaPorLogin($Username, $Password) {
        $this->firephp->log("carregaPorLogin");
        if (is_null($Username) || is_null($Password)) {
            return false;
        }
//        exit($Username);
        $query = $this->db->get_where('utilizador', array('Password' => $Password, 'Username' => $Username));

        $dados_utilizador = $query->row_array();

        if (!empty($dados_utilizador)) {
            $this->define($dados_utilizador);

            return true;
        }
        return false;
    }

    /**
     * Obtem Formações
     * 
     * @param array $ordenacao
     * @param array $filtragem
     * @param array $limites
     * @param type $contar
     * @return \Formcao
     */
    public function obtemFormacoes($ordenacao = null, $filtragem = null, $limites = null, $contar = false) {

        if (!is_array($ordenacao)) {
            $ordenacao = array();
        }
        if (!is_array($filtragem)) {
            $filtragem = array();
        }

        if (!is_array($limites)) {
            $limites = array();
        }

        $limite = null;
        if (key_exists('limite', $limites)) {
            $limite = $limites['limite'];
        }

        $offset = null;
        if (key_exists('offset', $limites)) {
            $offset = $limites['offset'];
        }

        foreach ($ordenacao as $campo_ordenar => $sentido_ordenar) {
            if ($campo_ordenar) {
                $this->db->order_by($campo_ordenar, $sentido_ordenar);
            }
        }

//        $this->firephp->log($filtragem);
        //FILTRAGEM 
        foreach ($filtragem as $campo_filtragem => $filtro) {
//            $this->firephp->log("campo_filtragem", $campo_filtragem);
////            $this->firephp->log("filtro", $filtro);
            $this->db->like($campo_filtragem, $filtro);
        }
        // FIM FILTRAGEM

        $array_formacoes = array();
        if ($contar == true && empty($filtragem)) {
            return $this->db->count_all_results('formacao');
        } elseif ($contar == true) {
            foreach ($filtragem as $campo_filtragem => $filtro) {
                $this->db->like($campo_filtragem, $filtro);
                $this->db->or_like($campo_filtragem, $filtro);
            }
            return $this->db->count_all_results('formacao');
        }


        // obter as registos da BD 
        $query = $this->db->get('formacao', $limite, $offset);

//        $this->firephp->log($this->db->last_query());

        $array_dados_formacao = $query->result_array();




//transformar o array de arrays em array de objectos do tipo noticia
        foreach ($array_dados_formacao as $dados_formacao) {

            $formacao = new Formacao;
            $formacao->define($dados_formacao);
            $array_formacoes[] = $formacao;
        }

        return $array_formacoes;
    }

    /**
     * Obtem apenas as Formações em destaque com base nas datas de Inicio e Fim de destaque
     * 
     * @param int $numeroMaximoFormacoes
     * @return \Formcao
     */
    public function obtemFormacoesEmDestaque($numeroMaximoFormacoes = NULL) {

        if ($numeroMaximoFormacoes == NULL) {
            $numeroMaximoFormacoes = 3;
        }

        $this->db->where('DataInicioDestaque <=', date("Y-m-d H:i:s"));
        $this->db->where('DataFimDestaque >=', date("Y-m-d H:i:s"));
        $this->db->where('Estado =', Formacao::ESTADO_ACTIVA);

        $query = $this->db->get('formacao', $numeroMaximoFormacoes);

        // obter as registos da BD 
        $array_dados_formacao = $query->result_array();

        //caso não tenho obtido nada
        if (empty($array_dados_formacao)) {

            $this->db->where('Estado =', Formacao::ESTADO_ACTIVA);
            $this->db->order_by("DataCriacao", "desc");

            $query = $this->db->get('formacao', $numeroMaximoFormacoes);

            // obter as registos da BD 
            $array_dados_formacao = $query->result_array();
        }


        //transformar o array de arrays em array de objectos do tipo formacao
        foreach ($array_dados_formacao as $dados_formacao) {

            $formacao = new Formacao;
            $formacao->define($dados_formacao);
            $array_formacoes[] = $formacao;
        }

        return $array_formacoes;
    }

    public function carregaPorId($Id = FALSE) {
//carregar uma noticia por id
        if (is_null($Id)) {
            return false;
        }

//obter noticias (- falta obter noticias com base na ordenacao e filtragens, caso definidas)
        $query = $this->db->get_where('formacao', array('Id' => $Id));
        $dados_formacao = $query->row_array();

        if (!empty($dados_formacao)) {

//definir os seus valores
            $this->define($dados_formacao);

            return true;
        }
        return false;
    }

    public function alterar($Id) {


//      $this->db->get_where('noticias', array('id' => $id))->$this->db->update('noticias');

        $this->db->where('Id', $Id);
        $this->db->update('formacao', $this);
    }

    public function grava() {
        return $this->db->insert('formacao', $this);
    }

    public function edita($id) {
        $this->db->where('Id', $id);
        return $this->db->update('formacao', $this);
    }

    public function eliminar($Id) {

        $resultado = $this->db->delete("formacao", array('Id' => $Id));

        if ($this->db->affected_rows() == '1') {
            return TRUE;
        } else {
            return FALSE;
        }
    }

// <editor-fold defaultstate="collapsed" desc="GET / SET">
    function getId() {
        return $this->Id;
    }

    function getEstado() {
        return $this->Estado;
    }

    function getDataCriacao() {
        return $this->DataCriacao;
    }

    function getFoto() {
        return $this->Foto;
    }

    function getSegmento() {
        return $this->Segmento;
    }

    function getNome() {
        return $this->Nome;
    }

    function getDescricao() {
        return $this->Descricao;
    }

    function getDataInicio() {
        return $this->DataInicio;
    }

    function getDataInicioDestaque() {
        return $this->DataInicioDestaque;
    }

    function getDataFimDestaque() {
        return $this->DataFimDestaque;
    }

    function getDestaqueHome() {
        return $this->DestaqueHome;
    }

    function setId($Id) {
        $this->Id = $Id;
    }

    function setEstado($Estado) {
        $this->Estado = $Estado;
    }

    function setDataCriacao($DataCriacao) {
        $this->DataCriacao = $DataCriacao;
    }

    function setFoto($Foto) {
        $this->Foto = $Foto;
    }

    function setSegmento($Segmento) {
        $this->Segmento = $Segmento;
    }

    function setNome($Nome) {
        $this->Nome = $Nome;
    }

    function setDescricao($Descricao) {
        $this->Descricao = $Descricao;
    }

    function setDataInicio($DataInicio) {
        $this->DataInicio = $DataInicio;
    }

    function setDataInicioDestaque($DataInicioDestaque) {
        $this->DataInicioDestaque = $DataInicioDestaque;
    }

    function setDataFimDestaque($DataFimDestaque) {
        $this->DataFimDestaque = $DataFimDestaque;
    }

    function setDestaqueHome() {
        return $this->DestaqueHome;
    }

// </editor-fold>
}
