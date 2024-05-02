<?

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Distribuicoes
 *
 * @version 1.0
 *
 */
class Distribuicoes extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('agregado_familiar');
        $this->load->model('constituinte');
        $this->load->model('log');
        $this->load->helper('form');
        $this->load->library('form_validation');
        parse_str($_SERVER['QUERY_STRING'], $_GET);
        $this->load->library('session');

        if ($this->session->userdata('login_efetuado') == false) {
            redirect(base_url('admin/login'));
        }
    }

    public function index() {
        self::listar();
    }

    public function distribuicaoPasso1() {
        $agregados = (new Agregado_Familiar())->obtemElementos(['Estado' => ESTADO_ATIVO]);

        $this->load->view('admin/template/header', ["tituloArea" => "Distribuições", "subtituloArea" => "Seleção de Agregados", "acoes" => [
//            [
//                "titulo" => "Adicionar",
//                "link" => base_url('admin/escaloes/adicionar'),
//                "icone" => "fas fa-plus",
//                'class' => 'button--add button--success'
//            ]
        ]]);
        $this->load->view('admin/distribuicao/area_distribuicao', ['Agregados' => $agregados]);
        $this->load->view('admin/template/footer');
    }

    public function distribuicaoPasso2() {
        $this->load->model('escalao');
        $this->load->model('produto');
        $this->load->model('constituinte');

        $CI = &get_instance();

        $IdsAgregados = $this->input->post('agregados');

        // <editor-fold defaultstate="collapsed" desc="Obter os agregados selecionados">
        $agregados_temp = (new Agregado_Familiar())->obtemElementos(['Estado' => ESTADO_ATIVO]);
        $agregados = [];
        foreach ($agregados_temp as $agregado) {
            if (in_array($agregado->getId(), $IdsAgregados)) {
                $agregados[] = $agregado;
            }
        }
        // </editor-fold>


        //Obter escalões
        $escaloes_temp = (new Escalao())->obtemElementos(['Estado' => ESTADO_ATIVO]);
        //organizar o array de escaloes por id
        foreach ($escaloes_temp as $escalao) {
            $escaloes[$escalao->getId()] = $escalao;
        }

        //Obter produtos
        $produtos = (new Produto())->obtemElementos(['Estado' => ESTADO_ATIVO]);

        //Vamos mexer nesta variavel removendo logo stock à medida que é atribuido
        $produtos_apos_distribuicao = $produtos;

        //Obter constituintes - São todos obtidos de uma unica vez para que seja mais rápido e eficiente
        $constituintes = (new Constituinte())->obtemElementos(['Estado' => ESTADO_ATIVO]);

        /** @var Agregado_Familiar $agregado */
        /** @var Escalao $escalao */

        foreach ($agregados as $agregado) {
            //Ir a cada constituinte do agregado e fazer os calculos da distribuicao
            foreach ($constituintes as $constituinte) {
                if ($constituinte->getIdAgregado() == $agregado->getId()) {
                    if ($constituinte->getIdEscalao()) {
                        $escalao = $escaloes[$constituinte->getIdEscalao()];
                    }

                    if ($escalao) {
                        $produtos_escalao = json_decode($escalao->getProdutos());
                    }

                    //vai conter o id do produto como key e dentro [quantidade segundo o escalão, quantidade efetivamente atribuida]
                    $produtos_atribuidos = [];

                    foreach ($produtos_escalao as $produto_id => $quantidade) {
                        if (array_key_exists($produto_id, $produtos_apos_distribuicao)) {
                            //Aqui validamos que o stock atual é suficiente para atribuir
                            if (($produtos_apos_distribuicao[$produto_id]->getStockAtual() - $quantidade) > 0) {
                                $produtos_apos_distribuicao[$produto_id]->setStockAtual($produtos_apos_distribuicao[$produto_id]->getStockAtual() - $quantidade);
                                $produtos_atribuidos[$produto_id] = [$quantidade, $quantidade];
                            } else if ($produtos_apos_distribuicao[$produto_id]->getStockAtual() > 0) {
                                //Se nao for suficiente vamos atribuir o que ainda houver e colocar o stock a 0
                                $produtos_atribuidos[$produto_id] = [$quantidade, $produtos_apos_distribuicao[$produto_id]->getStockAtual()];
                                $produtos_apos_distribuicao[$produto_id]->setStockAtual(0);
                            } else {
                                $produtos_atribuidos[$produto_id] = [$quantidade, $produtos_apos_distribuicao[$produto_id]->getStockAtual()];
                            }
                        }
                    }


                    //Colocar os produtos do escalao no constituinte
                    $constituinte->ProdtutosQuantidades = $produtos_atribuidos;

                    $agregados_constituintes[$agregado->getNissConstituintePrincipal()][] = $constituinte;
                }
            }
        }

//        $CI = &get_instance();
//        $CI->firephp->log($agregados_constituintes);
//        return;

        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'message' => 'Dados Importados com sucesso', 'view' => $this->load->view('admin/distribuicao/area_distribuicao_passo_2', ["agregados_constituintes" => $agregados_constituintes, "produtos_apos_distribuicao" => $produtos_apos_distribuicao], true)]);
        return;
    }


}
