<?php

class AC_Model_Base extends CI_Model {
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
    protected static $Tabela;

    const ESTADO_INATIVO = 2;
    const ESTADO_ATIVO = 1;
    const ESTADO_ELIMINADO = 3;

    public function __construct() {
        parent::__construct();
    }

    function getId() {
        return $this->Id;
    }

    function getEstado() {
        return $this->Estado;
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

}
