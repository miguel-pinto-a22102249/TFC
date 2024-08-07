<?

/**
 * Serve para guardar qualquer alteracao feita na plataforma por qualquer utilizador
 *
 * Model Log
 */
class Log extends CI_Model {


    /*
     * @var int
     */
    public $Id;
    /*
     * @var date
     */
    public $DataCriacao;
    /*
     * var int
     */
    public $IdUtilizador;

    /*
     * var String
     */
    public $Objeto;

    /*
     * var String
     */
    public $Acao;

    /*
     * @var string
     */
    public $Descricao;

    const TABELA = 'log';

    public function __construct() {
        parent::__construct();
    }

    /**
     * Caso no Array de dados enviado não seja definido a DataCriacao e o IdUtilizador, são definidos automaticamente
     * exemplo: $log->define(array('Descricao' => "Cria Máquina"));
     *
     * @param type $dados
     */
    public function define($dados) {
        if (empty($dados['Id'])) {
            !empty($dados['IdUtilizador']) ? $this->IdUtilizador = $dados['IdUtilizador'] : $this->IdUtilizador = $this->session->userdata('Id');
            $this->Acao = $dados['Acao'];
            $this->Objeto = $dados['Objeto'];
            $this->Descricao = $dados['Descricao'];
            !empty($dados['DataCriacao']) ? $this->DataCriacao = $dados['DataCriacao'] : $this->DataCriacao = date('Y-m-d H:i:s');
        } else {
            $this->Id = $dados['Id'];
            !empty($dados['IdUtilizador']) ? $this->IdUtilizador = $dados['IdUtilizador'] : $this->IdUtilizador = $this->session->userdata('Id');
            $this->Acao = $dados['Acao'];
            $this->Objeto = $dados['Objeto'];
            $this->Descricao = $dados['Descricao'];
            !empty($dados['DataCriacao']) ? $this->DataCriacao = $dados['DataCriacao'] : $this->DataCriacao = date('Y-m-d H:i:s');
        }
    }

    /**
     * Obtem Logs
     *
     * @param array $ordenacao
     * @param array $filtragem
     * @param array $limites
     * @param type $contar
     *
     * @return \Log
     */
    public function obtemLogs($ordenacao = null, $filtragem = null, $limites = null, $contar = false) {
        // <editor-fold defaultstate="collapsed" desc="Oredenação">
        if (!is_array($ordenacao)) {
            $ordenacao = [];
        }
// </editor-fold>
        // <editor-fold defaultstate="collapsed" desc="Filtragem">
        if (!is_array($filtragem)) {
            $filtragem = [];
        }
        // </editor-fold>
        // <editor-fold defaultstate="collapsed" desc="Limites">
        if (!is_array($limites)) {
            $limites = [];
        }
        // </editor-fold>

        $limite = null;
        if (key_exists('limite', $limites)) {
            $limite = $limites['limite'];
        }

        $offset = null;
        if (key_exists('offset', $limites)) {
            $offset = $limites['offset'];
        }

        //Filtragem
        foreach ($ordenacao as $campo_ordenar => $sentido_ordenar) {
            $this->db->order_by($campo_ordenar, $sentido_ordenar);
        }
        // Fim Filtragem
        //Pesquisa 
        foreach ($filtragem as $campo_filtragem => $filtro) {
            $this->db->like($campo_filtragem, $filtro);
            $this->db->or_like($campo_filtragem, $filtro);
        }
        //Fim de pesquisa

        $array_log = [];
        if ($contar == true && empty($filtragem)) {
            return $this->db->count_all_results(Log::TABELA);
        } elseif ($contar == true) {
            foreach ($filtragem as $campo_filtragem => $filtro) {
                $this->db->like($campo_filtragem, $filtro);
                $this->db->or_like($campo_filtragem, $filtro);
            }
            return $this->db->count_all_results(Log::TABELA);
        }


        // obter as noticias da BD 
        $query = $this->db->get(Log::TABELA, $limite, $offset);
        $array_dados_log = $query->result_array();


        //transformar o array de arrays em array de objectos do tipo log
        foreach ($array_dados_log as $dados_log) {
            $log = new log;
            $log->define($dados_log);
            $array_log[] = $log;
        }

        return $array_log;
    }

    public function carregaPorId($Id = false) {
        //carregar uma noticia por id
        if (is_null($Id)) {
            return false;
        }

        //obter noticias (- falta obter noticias com base na ordenacao e filtragens, caso definidas)
        $query = $this->db->get_where(self::TABELA, ['Id' => $Id]);
        $dados_utilizador = $query->row_array();

        if (!empty($dados_utilizador)) {
            //definir os seus valores
            $this->define($dados_utilizador);

            return true;
        }


        return false;
    }

    public function alterar($Id) {
//      $this->db->get_where('noticias', array('id' => $id))->$this->db->update('noticias');

        $this->db->where('Id', $Id);
        $this->db->update('utilizador', $this);
    }

    public function grava() {
        $this->DataCriacao = date('Y-m-d H:i:s');

        return $this->db->insert(Log::TABELA, $this);
    }

    public function eliminar($Id) {
        $resultado = $this->db->delete(Log::TABELA, ['Id' => $Id]);

        if ($this->db->affected_rows() == '1') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Recebendo o Id do utilizador devolve o Nome do mesmo
     *
     * @param type $Id
     *
     * @return boolean
     */
    public function getNomeUtilizador($Id = false) {
        if (is_null($Id)) {
            return false;
        }
        $query = $this->db->get_where('utilizador', ['Id' => $Id]);
        $dados_utilizador = $query->row_array();
        if (!empty($dados_utilizador)) {
            return $dados_utilizador['Nome'];
        }
        return false;
    }

    // <editor-fold defaultstate="collapsed" desc="GET / SET">

    function getId() {
        return $this->Id;
    }

    function getDataCriacao() {
        return $this->DataCriacao;
    }

    function getIdUtilizador() {
        return $this->IdUtilizador;
    }

    function getDescricao() {
        return $this->Descricao;
    }

    function setId($Id) {
        $this->Id = $Id;
    }

    function setDataCriacao($DataCriacao) {
        $this->DataCriacao = $DataCriacao;
    }

    function setIdUtilizador($IdUtilizador) {
        $this->IdUtilizador = $IdUtilizador;
    }

    function setDescricao($Descricao) {
        $this->Descricao = $Descricao;
    }

    /**
     * @return mixed
     */
    public function getObjeto() {
        return $this->Objeto;
    }

    /**
     * @param mixed $Objeto
     */
    public function setObjeto($Objeto): void {
        $this->Objeto = $Objeto;
    }

    /**
     * @return mixed
     */
    public function getAcao() {
        return $this->Acao;
    }

    /**
     * @param mixed $Acao
     */
    public function setAcao($Acao): void {
        $this->Acao = $Acao;
    }


    // </editor-fold>
}
