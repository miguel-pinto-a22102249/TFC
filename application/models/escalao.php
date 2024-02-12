<?

/**
 * Model Escalao
 */
class Escalao extends CI_Model {
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
            $this->Designacao = $dados['Designacao'];
            $this->IdadeInicial = $dados['IdadeInicial'];
            $this->IdadeFinal = $dados['IdadeFinal'];
            $this->Segmento = $dados['Segmento'];
        } else {
            $this->Id = $dados['Id'];
            $this->Designacao = $dados['Designacao'];
            $this->IdadeInicial = $dados['IdadeInicial'];
            $this->IdadeFinal = $dados['IdadeFinal'];
            $this->Segmento = $dados['Segmento'];
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
            $query = $this->db->get('escalao');
            return $query->result_array();
        }

        $query = $this->db->get_where('escalao', array('Segmento' => $segmento));
        
        $dados_escalao = $query->row_array();
        
         if (!empty($dados_escalao)) {
            $this->define($dados_escalao);
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
    public function obtemEscaloes($ordenacao = null, $filtragem = null, $limites = null, $contar = false) {

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

        $array_escaloes = array();
        if ($contar == true && empty($filtragem)) {
            return $this->db->count_all_results('escalao');
        } elseif ($contar == true) {
            foreach ($filtragem as $campo_filtragem => $filtro) {
                $this->db->like($campo_filtragem, $filtro);
                $this->db->or_like($campo_filtragem, $filtro);
            }
            return $this->db->count_all_results('escalao');
        }


        // obter as registos da BD 
        $query = $this->db->get('escalao', $limite, $offset);

//        $this->firephp->log($this->db->last_query());

        $array_dados_escalao = $query->result_array();




//transformar o array de arrays em array de objectos do tipo noticia
        foreach ($array_dados_escalao as $dados_escalao) {

            $escalao = new Escalao;
            $escalao->define($dados_escalao);
            $array_escaloes[] = $escalao;
        }

        return $array_escaloes;
    }

    /**
     * Obtem apenas as Formações em destaque com base nas datas de Inicio e Fim de destaque
     * 
     * @param int $numeroMaximoEscaloes
     * @return \Formcao
     */
    public function obtemEscaloesEmDestaque($numeroMaximoEscaloes = NULL) {

        if ($numeroMaximoEscaloes == NULL) {
            $numeroMaximoEscaloes = 3;
        }

        $this->db->where('DataInicioDestaque <=', date("Y-m-d H:i:s"));
        $this->db->where('DataFimDestaque >=', date("Y-m-d H:i:s"));
        $this->db->where('Estado =', Escalao::ESTADO_ACTIVA);

        $query = $this->db->get('escalao', $numeroMaximoEscaloes);

        // obter as registos da BD 
        $array_dados_escalao = $query->result_array();

        //caso não tenho obtido nada
        if (empty($array_dados_escalao)) {

            $this->db->where('Estado =', Escalao::ESTADO_ACTIVA);
            $this->db->order_by("DataCriacao", "desc");

            $query = $this->db->get('escalao', $numeroMaximoEscaloes);

            // obter as registos da BD 
            $array_dados_escalao = $query->result_array();
        }


        //transformar o array de arrays em array de objectos do tipo escalao
        foreach ($array_dados_escalao as $dados_escalao) {

            $escalao = new Escalao;
            $escalao->define($dados_escalao);
            $array_escaloes[] = $escalao;
        }

        return $array_escaloes;
    }

    public function carregaPorId($Id = FALSE) {
//carregar uma noticia por id
        if (is_null($Id)) {
            return false;
        }

//obter noticias (- falta obter noticias com base na ordenacao e filtragens, caso definidas)
        $query = $this->db->get_where('escalao', array('Id' => $Id));
        $dados_escalao = $query->row_array();

        if (!empty($dados_escalao)) {

//definir os seus valores
            $this->define($dados_escalao);

            return true;
        }
        return false;
    }

    public function alterar($Id) {


//      $this->db->get_where('noticias', array('id' => $id))->$this->db->update('noticias');

        $this->db->where('Id', $Id);
        $this->db->update('escalao', $this);
    }

    public function grava() {
        return $this->db->insert('escalao', $this);
    }

    public function edita($id) {
        $this->db->where('Id', $id);
        return $this->db->update('escalao', $this);
    }

    public function eliminar($Id) {

        $resultado = $this->db->delete("escalao", array('Id' => $Id));

        if ($this->db->affected_rows() == '1') {
            return TRUE;
        } else {
            return FALSE;
        }
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




}
