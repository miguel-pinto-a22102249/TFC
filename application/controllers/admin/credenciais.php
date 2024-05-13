<?

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Escalões
 *
 * @version 1.0
 *
 */
class Credenciais extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('escalao');
        $this->load->model('log');
        $this->load->helper('form');
        $this->load->library('form_validation');
        parse_str($_SERVER['QUERY_STRING'], $_GET);
        $this->load->library('session');
        if ($this->session->userdata('login_efetuado') == false) {
            redirect(base_url('admin/login'));
        }
    }

    public function gerarCredencialA($NumeroGrupoDistribuicao) {
        $this->load->model('produto');
        $this->load->model('distribuicao');
        $this->load->model('distribuicao_individual_constituinte');
        $this->load->model('entrega');
        $this->load->model('agregado_familiar');

        $distribuicoes = (new Distribuicao())->obtemElementos(null, ['Estado' => ESTADO_ATIVO, 'NumeroGrupoDistribuicao' => $NumeroGrupoDistribuicao]);
        $IDSEntregas = [];
        foreach ($distribuicoes as $distribuicao) {
            $IDSEntregas = array_merge($IDSEntregas, json_decode($distribuicao->getIdsEntregas()));
        }

        $entregas = (new Entrega())->obtemElementos(null, ['Estado' => ESTADO_ATIVO, 'Id' => [$IDSEntregas, 'where_in']]);

        $IDSDistribuicoesIndividuais = [];
        foreach ($entregas as $entrega) {
            $IDSDistribuicoesIndividuais = array_merge($IDSDistribuicoesIndividuais, json_decode($entrega->getIdsDistribuicoesIndividuais()));
        }
        $distribuicoes_individuais = (new Distribuicao_Individual_Constituinte())->obtemElementos(null, ['Estado' => ESTADO_ATIVO, 'Id' => [$IDSDistribuicoesIndividuais, 'where_in']]);


        $agregados = (new Agregado_Familiar())->obtemElementos(null, ['Estado' => ESTADO_ATIVO]);
        $produtos = (new Produto())->obtemElementos(null, ['Estado' => ESTADO_ATIVO]);

        $this->load->view('admin/template/header',
            ["tituloArea" => "Credencial A",
             "subtituloArea" => "Gerar Credencial A: " . reset($distribuicoes)->getData(),
             "acoes" => [
//                 [
////                     "titulo" => "Adicionar",
////                     "link" => base_url('admin/distribuicoes/distribuicaoPasso1'),
////                     "icone" => "fas fa-plus",
////                     'class' => 'button--add button--success'
//                 ]
             ]
            ]);
        $this->load->view('admin/credenciais/gerar_credencial_a',
            ['distribuicoes' => $distribuicoes,
             'distribuicoes_individuais' => $distribuicoes_individuais,
             'entregas' => $entregas, 'agregados' => $agregados,
             'produtos' => $produtos]);
        $this->load->view('admin/template/footer');
    }
}
