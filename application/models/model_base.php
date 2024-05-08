<?php

class Model_Base extends CI_Model {
    /*
     * @var int
     */
    public $Id;
    /*
     * @var int
     */
    public $Estado;
    /*
     * @var Date
     */
    public $DataCriacao;
    /*
     * @var String
     */
    public $Segmento;

    const CAMPO_DESIGNACAO_DEFAULT = 'Designacao';

    const TABELA = '';

    const ESTADO_INATIVO = 2;
    const ESTADO_ATIVO = 1;
    const ESTADO_ELIMINADO = 3;

    public function __construct() {
        parent::__construct();
    }

    /**
     * Função define conpativel com qualquer class child, serve para inicializar os valores
     *
     * @param $dados
     *
     * @return void
     */
    public function define($dados) {
        // Itera sobre os dados e define os valores correspondentes
        foreach ($dados as $campo => $valor) {
            // Verifica se a propriedade existe na classe antes de atribuir o valor
            if (property_exists($this, $campo)) {
                // Verifica se o campo é diferente de 'Id' antes de atribuir o valor
                if ($campo !== 'Id' || (isset($campo['Id']) && !empty($valor))) {
                    $this->$campo = $valor;
                }
            }

            if (isset($dados['Id'])) {
                $this->Id = (int)$dados['Id'];
            }

            if (!key_exists('Estado', $dados)) {
                $this->Estado = self::ESTADO_ATIVO;
            }

            if (!key_exists('DataCriacao', $dados)) {
                $this->DataCriacao = date('Y-m-d H:i:s');
            }
        }
    }

    public function grava() {
        $nome_class = get_class($this);

        $this->load->model('log');
        $Log = new Log();

        $Log->define([
            'Objeto' => $nome_class,
            'Acao' => 'Adicionar',
            'Descricao' => $this->getDesignacaoDefault()
        ]);

        $Log->grava();

        return $this->db->insert($nome_class::TABELA, $this);
    }

    /**
     * @param $idResponsavelAcao // Por defeito é 0, 0 é o sistema
     *
     * @return true
     */
    public function edita($idResponsavelAcao = 0) {
        $nome_class = get_class($this);

        $this->db->where('Id', $this->Id);
        $this->db->update($nome_class::TABELA, $this);

        if ($idResponsavelAcao != 0) {
            $Log = new Log();

            $Log->define([
                'Objeto' => $nome_class,
                'Acao' => 'Editar',
                'Descricao' => $this->getDesignacaoDefault()
            ]);
            $Log->grava();
        }
        return true;
    }

    public function eliminar($Id) {
        $nome_class = get_class($this);
        $resultado = $this->db->delete($nome_class::TABELA, ['Id' => $Id]);

        if ($this->db->affected_rows() == '1') {
            return true;
        } else {
            return false;
        }
    }

    public function alterar($Id) {
        $nome_class = get_class($this);
        $this->db->where('Id', $Id);
        $this->db->update($nome_class::TABELA, $this);
    }

    public function carregaPorId($Id = false) {
        $nome_class = get_class($this);
        if (is_null($Id)) {
            return false;
        }

        $query = $this->db->get_where($nome_class::TABELA, ['Id' => $Id]);
        $dados_obj = $query->row_array();

        if (!empty($dados_obj)) {
            //definir os seus valores
            $this->define($dados_obj);
            return true;
        }
        return false;
    }

    /**
     * Carrega uma Formação para consulta através do seguemento
     *
     * @param type $segmento
     *
     * @return type
     */
    public function carregaPorSegmento($segmento = false) {
        $nome_class = get_class($this);

        if ($segmento === false) {
            $query = $this->db->get($nome_class::TABELA);
            return $query->result_array();
        }

        $query = $this->db->get_where($nome_class::TABELA, ['Segmento' => $segmento]);

        $dados_escalao = $query->row_array();

        if (!empty($dados_escalao)) {
            $this->define($dados_escalao);
            return true;
        }
        return false;
    }

    /**
     * Obtem Elementos
     *
     * @param array $ordenacao - ['Id' => 'DESC']
     * @param array $filtragem - [Campo => Valor] OU [Campo => [Valor,filtro]] - Exemplo: ['Estado' => 1] OU ['Estado' => [Valor,'in]]
     * @param array $limites - ['limite' => 10, 'offset' => 0]
     * @param type $contar
     *
     * @return array|Model_Base|OBJ
     */
    public function obtemElementos($ordenacao = null, $filtragem = null, $limites = null, $contar = false) {
        $nome_class = get_class($this);

        if (!is_array($ordenacao)) {
            $ordenacao = [];
        }

        if (!is_array($filtragem)) {
            $filtragem = [];
        }

        if (!is_array($limites)) {
            $limites = [];
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


        $CI = &get_instance();
//        $CI->firephp->log($filtragem);
        //FILTRAGEM
        foreach ($filtragem as $campo_filtragem => $filtro) {
            if (is_array($filtro)) {
                $condicao = (String)$filtro[1];
                $this->db->$condicao($campo_filtragem,$filtro[0]);
            } else {
                $this->db->like($campo_filtragem, $filtro);
            }
        }


        // FIM FILTRAGEM
        if ($contar == true && empty($filtragem)) {
            return $this->db->count_all_results($nome_class::TABELA);
        } elseif ($contar == true) {
            foreach ($filtragem as $campo_filtragem => $filtro) {
                $this->db->like($campo_filtragem, $filtro);
                $this->db->or_like($campo_filtragem, $filtro);
            }
            return $this->db->count_all_results($nome_class::TABELA);
        }


        // obter as registos da BD
        $query = $this->db->get($nome_class::TABELA, $limite, $offset);


        $array_dados_obj = $query->result_array();
        $array_objs = [];

        $dados_obj = [];
        //transformar o array de arrays em array de objectos do tipo noticia
        foreach ($array_dados_obj as $dados_obj) {
            $obj = new $nome_class;
            $obj->define($dados_obj);
            $array_objs[$obj->getId()] = $obj;
        }

        return $array_objs;
    }

    public
    function getDesignacaoDefault() {
        $nome_class = get_class($this);

        if (property_exists($nome_class, $nome_class::CAMPO_DESIGNACAO_DEFAULT)) {
            return $this->{$nome_class::CAMPO_DESIGNACAO_DEFAULT};
        }
        return "-";
    }

    //<editor-fold defaultstate="collapsed" desc="Getters e Setters">
    function getId() {
        return $this->Id;
    }

    function getEstado() {
        return $this->Estado;
    }

    function getDesignacaoEstado() {
        switch ($this->Estado) {
            case self::ESTADO_ATIVO:
                return "Ativo";
            case self::ESTADO_INATIVO:
                return "Inativo";
        }
        return "-";
    }

    function setId($Id) {
        $this->Id = $Id;
    }

    function setEstado($Estado) {
        $this->Estado = $Estado;
    }

    function getDataCriacao() {
        return $this->DataCriacao;
    }

    function setDataCriacao($DataCriacao) {
        $this->DataCriacao = $DataCriacao;
    }

    /**
     * @return mixed
     */
    public
    function getSegmento() {
        return $this->Segmento;
    }

    /**
     * @param mixed $Segmento
     */
    public
    function setSegmento($Segmento): void {
        $this->Segmento = $Segmento;
    }
//</editor-fold>
}
