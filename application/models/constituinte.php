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

    /*
     * @var date
     */
    public $DataNascimento;

    /*
     * @var varchar
     */
    public $Nome;


    const TABELA = 'constituinte';

    public function __construct() {
        parent::__construct();
        $this->load->database('default');
    }


    /**
     * Função que preenche a propriedade IdEscalao do obj, em função dos escalões existentes na base de dados
     *
     * @param $Id
     *
     * @return Constituinte
     */
    public function calculaEscalao() {
        $this->load->model('Escalao');

        // Se $this->Idade não estiver definido, calcular a idade a partir da data de nascimento
        if (!isset($this->Idade) && isset($this->DataNascimento)) {
            $dataNascimento = new DateTime($this->DataNascimento);
            $hoje = new DateTime();
            $idade = $hoje->diff($dataNascimento)->y; // Calcula a diferença em anos

//            $this->Idade = $idade; // Define a idade calculada
        } else {
            $idade = $this->Idade;
        }

        // Consulta ao banco de dados para encontrar o escalão com base na idade
        $query = $this->db->query('SELECT * FROM ' . Escalao::TABELA . ' WHERE IdadeInicial <= ' . $idade . ' AND IdadeFinal >= ' . $idade . ' AND estado = 1');

        if ($query->num_rows() > 0) {
            $dados = $query->row_array();
            $this->IdEscalao = $dados['Id'];
        }
    }

    public function organizaPorNiss($constituintes) {
        $constituintesOrganizados = [];
        foreach ($constituintes as $constituinte) {
            $constituintesOrganizados[$constituinte->Niss] = $constituinte;
        }
        return $constituintesOrganizados;
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
            // $this->firephp->log("já está carregado");
            foreach ($this->Agregados as $Agregado) {
                if ($Agregado->getId() == $this->IdAgregado) {
                    $niss = $Agregado->getNissConstituintePrincipal();
                }
            }
        } else {
            //$this->firephp->log("Não está carregado");
            $this->Agregados = (new Agregado_Familiar)->obtemElementos(null, ['Estado' => 1]);

            foreach ($this->Agregados as $Agregado) {
                if ($Agregado->getId() == $this->IdAgregado) {
                    $niss = $Agregado->getNissConstituintePrincipal();
                }
            }
        }

        if ($this->session->userdata('ModoPrivacidade') == false) {
            return "xxx xxx " . substr($niss, 6, 9);
        } else {
            return $niss;
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
    public function getIdEscalao() {
        return $this->IdEscalao;
    }

    /**
     * @param mixed $IdEscalao
     */
    public function setIdEscalao($IdEscalao): void {
        $this->IdEscalao = $IdEscalao;
    }

    /**
     * @return mixed
     */
    public function getDataNascimento() {
        return $this->DataNascimento;
    }

    /**
     * @param mixed $DataNascimento
     */
    public function setDataNascimento($DataNascimento): void {
        $this->DataNascimento = $DataNascimento;
    }

    /**
     * @return mixed
     */
    public function getNome() {
        return $this->Nome;
    }

    /**
     * @param mixed $Nome
     */
    public function setNome($Nome): void {
        $this->Nome = $Nome;
    }


}
