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
        $this->load->model('credencial');
        $this->load->model('distribuicao');
        $this->load->model('entidade_distribuidora');
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

        $distribuicoes = (new Distribuicao())->obtemElementos(null, ['NumeroGrupoDistribuicao' => $NumeroGrupoDistribuicao]);
        $IDSEntregas = [];
        foreach ($distribuicoes as $distribuicao) {
            $IDSEntregas = array_merge($IDSEntregas, json_decode($distribuicao->getIdsEntregas()));
        }

        $entregas = (new Entrega())->obtemElementos(null, ['Id' => [$IDSEntregas, 'where_in']]);

        $IDSDistribuicoesIndividuais = [];
        foreach ($entregas as $entrega) {
            $IDSDistribuicoesIndividuais = array_merge($IDSDistribuicoesIndividuais, json_decode($entrega->getIdsDistribuicoesIndividuais()));
        }
        $distribuicoes_individuais = (new Distribuicao_Individual_Constituinte())->obtemElementos(null, ['Estado' => ESTADO_ATIVO, 'Id' => [$IDSDistribuicoesIndividuais, 'where_in']]);


        $agregados = (new Agregado_Familiar())->obtemElementos(null, ['Estado' => ESTADO_ATIVO]);
        $produtos = (new Produto())->obtemElementos(null, ['Estado' => ESTADO_ATIVO]);
        $entidades_distribuidoras = (new Entidade_Distribuidora())->obtemElementos(null, ['Estado' => ESTADO_ATIVO]);


        if ($this->input->is_ajax_request()) {
            $html = $this->load->view('admin/credenciais/gerar_credencial_a', ['distribuicoes' => $distribuicoes,
                                                                               'distribuicoes_individuais' => $distribuicoes_individuais,
                                                                               'entregas' => $entregas, 'agregados' => $agregados,
                                                                               'produtos' => $produtos,
                                                                               'entidades_distribuidoras' => $entidades_distribuidoras], true);
            $html = $this->load->view('admin/popup/default_popup', ['titulo' => "Gerar Credencial A: " . reset($distribuicoes)->getData(),
                                                                    'soConsulta' => false,
                                                                    'html' => $html, 'URLNewWindow' => base_url("admin/credenciais/gerarCredencialA/{$NumeroGrupoDistribuicao}")], true);
            header('Content-Type: application/json');
            $html = '<div class="dialog-credencial-a">' . $html . '</div>';
            echo json_encode(['success' => true, 'message' => '', 'view' => $html]);
            return;
        } else {
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
                 'produtos' => $produtos,
                 'entidades_distribuidoras' => $entidades_distribuidoras]);
            $this->load->view('admin/template/footer');
        }
    }

    public function gerarCredencialB($NumeroGrupoDistribuicao, $IdAgregado) {
        $this->load->model('produto');
        $this->load->model('distribuicao');
        $this->load->model('distribuicao_individual_constituinte');
        $this->load->model('entrega');
        $this->load->model('agregado_familiar');

        $distribuicoes = (new Distribuicao())->obtemElementos(null, ['NumeroGrupoDistribuicao' => $NumeroGrupoDistribuicao, 'IdAgregado' => $IdAgregado]);
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
        $entidades_distribuidoras = (new Entidade_Distribuidora())->obtemElementos(null, ['Estado' => ESTADO_ATIVO]);

        if ($this->input->is_ajax_request()) {
            $html = $this->load->view('admin/credenciais/gerar_credencial_b', ['distribuicoes' => $distribuicoes,
                                                                               'entidades_distribuidoras' => $entidades_distribuidoras, // 'distribuicoes_individuais' => $distribuicoes_individuais,
                                                                               'distribuicoes_individuais' => $distribuicoes_individuais,
                                                                               'entregas' => $entregas, 'agregados' => $agregados,
                                                                               'produtos' => $produtos], true);
            $html = $this->load->view('admin/popup/default_popup', ['titulo' => "Gerar Credencial B: " . reset($distribuicoes)->getData(),
                                                                    'soConsulta' => false,
                                                                    'html' => $html, 'URLNewWindow' => base_url("admin/credenciais/gerarCredencialB/{$NumeroGrupoDistribuicao}")], true);

            $html = '<div class="dialog-credencial-b">' . $html . '</div>';
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'message' => '', 'view' => $html]);
            return;
        } else {
            $this->load->view('admin/template/header',
                ["tituloArea" => "Credencial B",
                 "subtituloArea" => "Gerar Credencial B: " . reset($distribuicoes)->getData(),
                 "acoes" => [
//                 [
////                     "titulo" => "Adicionar",
////                     "link" => base_url('admin/distribuicoes/distribuicaoPasso1'),
////                     "icone" => "fas fa-plus",
////                     'class' => 'button--add button--success'
//                 ]
                 ]
                ]);
            $this->load->view('admin/credenciais/gerar_credencial_b',
                ['distribuicoes' => $distribuicoes,
                 'distribuicoes_individuais' => $distribuicoes_individuais,
                 'entregas' => $entregas, 'agregados' => $agregados,
                 'produtos' => $produtos]);
            $this->load->view('admin/template/footer');
        }
    }

    public function gravarCredencial() {
        $Signatures = $this->input->post('signatures');
        $IdDistribuicao = $this->input->post('IdDistribuicao');
        $GrupoDistribuicao = $this->input->post('GrupoDistribuicao');
        $TipoCredencial = $this->input->post('TipoCredencial');
        $Html = $this->input->post('html');


        $credencial = new Credencial();
        $credencial->define([
            'IdsObjetosAssociados' => $IdDistribuicao,
            'Html' => $Html,
            'GrupoDistribuicao' => $GrupoDistribuicao,
            'TipoCredencial' => $TipoCredencial,
            'Estado' => Credencial::ESTADO_ASSINADA,
            'Descricao' => "Credencial gerada automaticamente pelo sistema",
            'CaminhoAssinaturaResponsavel' => $Signatures[0],
            'CaminhoAssinaturaResponsavelAgregado' => $TipoCredencial == Credencial::TIPO_CREDENCIAL_B ? $Signatures[1] : null
        ]);

        $distribuicao = new Distribuicao();
        $distribuicao->carregaPorId($IdDistribuicao);
        $distribuicao->setEstado(Distribuicao::ESTADO_TERMINADA);
        $distribuicao->setData(date('Y-m-d H:i:s'));
        $distribuicao->edita($IdDistribuicao);

        if ($credencial->grava()) {
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'message' => 'Credencial guardada com sucesso']);
            return;
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Ocorreu um erro ao guardar a Credencial']);
            return;
        }
    }

    public function consultarCredencialB($IdCredencial) {
        $credencial = new Credencial();
        $credencial->carregaPorId($IdCredencial);


        $this->load->view('admin/template/header',
            ["tituloArea" => "Credencial B",
             "subtituloArea" => $credencial->getDataCriacao(),
             "acoes" => [
                 [
                     "titulo" => "Imprimir",
                     "link" => 'javascript:;',
                     "icone" => "fas fa-print",
                     'class' => 'button--add button--success printButton',
                 ]
             ]
            ]);
        $this->load->view('admin/credenciais/consultar_credencial',
            ['credencial' => $credencial]);
        $this->load->view('admin/template/footer');
    }

    public function consultarCredencialA($IdCredencial) {
        $credencial = new Credencial();
        $credencial->carregaPorId($IdCredencial);


        $this->load->view('admin/template/header',
            ["tituloArea" => "Credencial A",
             "subtituloArea" => $credencial->getDataCriacao(),
             "acoes" => [
                 [
                     "titulo" => "Imprimir",
                     "link" => 'javascript:;',
                     "icone" => "fas fa-print",
                     'class' => 'button--add button--success printButton',
                 ]
             ]
            ]);
        $this->load->view('admin/credenciais/consultar_credencial',
            ['credencial' => $credencial]);
        $this->load->view('admin/template/footer');
    }

}
