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

                    $CI = &get_instance();

                    //Colocar os produtos do escalao no constituinte
                    $constituinte->ProdtutosQuantidades = $produtos_escalao;

                    $agregados_constituintes[$agregado->getNissConstituintePrincipal()][] = $constituinte;
                }
            }
        }


        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'message' => 'Dados Importados com sucesso', 'view' => $this->load->view('admin/distribuicao/area_distribuicao_passo_2', ["agregados_constituintes" => $agregados_constituintes], true)]);
        return;
    }


}
