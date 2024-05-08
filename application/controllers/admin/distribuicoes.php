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

    public function listar() {
        $CI = &get_instance();

        $this->db->select('DATE(Data) as Data, NumeroGrupoDistribuicao, COUNT(*) as numero_distribuicoes');
        $this->db->from('distribuicao');
        $this->db->group_by('Data, NumeroGrupoDistribuicao');
        $this->db->order_by('Data', 'DESC');
        $query = $this->db->get();
        $resultados = $query->result();

        $this->load->view('admin/template/header', ["tituloArea" => "Distribuições", "subtituloArea" => "Listar", "acoes" => [
            [
                "titulo" => "Adicionar",
                "link" => base_url('admin/distribuicoes/distribuicaoPasso1'),
                "icone" => "fas fa-plus",
                'class' => 'button--add button--success'
            ]
        ]]);
        $this->load->view('admin/distribuicao/listar_por_data', ["Datas" => $resultados]);
        $this->load->view('admin/template/footer');
    }

    public function listarPorConstituinte($NumeroGrupoDistribuicao) {
        $this->load->model('produto');
        $this->load->model('distribuicao');
        $this->load->model('distribuicao_individual_constituinte');
        $this->load->model('entrega');

        $distribuicoes = (new Distribuicao())->obtemElementos(null,['Estado' => ESTADO_ATIVO, 'NumeroGrupoDistribuicao' => $NumeroGrupoDistribuicao]);
        $IDSEntregas = [];
        foreach ($distribuicoes as $distribuicao) {
            $IDSEntregas = array_merge($IDSEntregas, json_decode($distribuicao->getIdsEntregas()));
        }

        $entregas = (new Entrega())->obtemElementos(null,['Estado' => ESTADO_ATIVO, 'Id' => [$IDSEntregas,'where_in']]);

        $IDSDistribuicoesIndividuais = [];
        foreach ($entregas as $entrega) {
            $IDSDistribuicoesIndividuais = array_merge($IDSDistribuicoesIndividuais, json_decode($entrega->getIdsDistribuicoesIndividuais()));
        }
        $distribuicoes_individuais = (new Distribuicao_Individual_Constituinte())->obtemElementos(null,['Estado' => ESTADO_ATIVO,'Id' => [$IDSDistribuicoesIndividuais,'where_in']]);



        $agregados = (new Agregado_Familiar())->obtemElementos(null,['Estado' => ESTADO_ATIVO]);
        $produtos = (new Produto())->obtemElementos(null,['Estado' => ESTADO_ATIVO]);
//        $entregas = (new Entrega())->obtemElementos(['Estado' => ESTADO_ATIVO]);

        $this->load->view('admin/template/header',
            ["tituloArea" => "Distribuições",
             "subtituloArea" => "Listar - Distribuição de ".reset($distribuicoes)->getData(),
             "acoes" => [
                 [
                     "titulo" => "Adicionar",
                     "link" => base_url('admin/distribuicoes/distribuicaoPasso1'),
                     "icone" => "fas fa-plus",
                     'class' => 'button--add button--success'
                 ]
             ]
            ]);
        $this->load->view('admin/distribuicao/listar_por_constituinte',
            ['distribuicoes' => $distribuicoes,
             'distribuicoes_individuais' => $distribuicoes_individuais,
             'entregas' => $entregas, 'agregados' => $agregados,
             'produtos' => $produtos]);
        $this->load->view('admin/template/footer');
    }

    public function listarPorAgregado() {
//        $this->load->model('escalao');
        $this->load->model('produto');
//        $this->load->model('constituinte');
        $this->load->model('distribuicao');
        $this->load->model('distribuicao_individual_constituinte');
        $this->load->model('entrega');

        $distribuicoes = (new Distribuicao())->obtemElementos(['Estado' => ESTADO_ATIVO]);
        $agregados = (new Agregado_Familiar())->obtemElementos(['Estado' => ESTADO_ATIVO]);
        $produtos = (new Produto())->obtemElementos(['Estado' => ESTADO_ATIVO]);
        $entregas = (new Entrega())->obtemElementos(['Estado' => ESTADO_ATIVO]);
        $distribuicoes_individuais = (new Distribuicao_Individual_Constituinte())->obtemElementos(['Estado' => ESTADO_ATIVO]);

        $this->load->view('admin/template/header', ["tituloArea" => "Distribuições", "subtituloArea" => "Listar por Agregado", "acoes" => [
            [
                "titulo" => "Adicionar",
                "link" => base_url('admin/distribuicoes/distribuicaoPasso1'),
                "icone" => "fas fa-plus",
                'class' => 'button--add button--success'
            ]
        ]]);
        $this->load->view('admin/distribuicao/listar_por_agregado', ['distribuicoes' => $distribuicoes, 'distribuicoes_individuais' => $distribuicoes_individuais, 'entregas' => $entregas, 'agregados' => $agregados, 'produtos' => $produtos]);
        $this->load->view('admin/template/footer');
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

        $this->produtos = $produtos; // Para poder ser usado nos proximos passos

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

        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'message' => 'Dados Importados com sucesso', 'view' => $this->load->view('admin/distribuicao/area_distribuicao_passo_2', ["agregados_constituintes" => $agregados_constituintes, "produtos_apos_distribuicao" => $produtos_apos_distribuicao], true)]);
        return;
    }

    public function distribuicaoPasso3() {
        $this->load->model('escalao');
        $this->load->model('produto');
        $this->load->model('constituinte');
        $this->load->model('distribuicao');
        $this->load->model('distribuicao_individual_constituinte');
        $this->load->model('entrega');

        $CI = &get_instance();
        $agregados = (new Agregado_Familiar())->obtemElementos(['Estado' => ESTADO_ATIVO]);
        $produtos_bd = (new Produto())->obtemElementos(['Estado' => ESTADO_ATIVO]);
        $constituintes = (new Constituinte())->obtemElementos(['Estado' => ESTADO_ATIVO]);
        $constituintesPorNiss = (new Constituinte())->organizaPorNiss($constituintes);


        $QuantidadeAjustada = $this->input->post('QuantidadeAjustada');
        $NissConstituintes = $this->input->post('NissConstituintes');

        //Vamos criar uma distribuição por agregado, esta distribuição pode ter multiplas entregas e
        // cada entrega tem multiplas distribuições individuais (as distribuicoes individuais tem o registo dos produtos de cada constituinte)

        $count = 0;
        //------ 1º - Vamos criar as distribuições individuais
        foreach ($QuantidadeAjustada as $IdConstituinte => $produtos) {
//            $CI->firephp->log($constituintes[$IdConstituinte]);

            //Gerar a distribuicao individual para este constituinte
            $DistribuicaoIndividual = new Distribuicao_Individual_Constituinte();
            $produtos_constituinte = [];
            foreach ($produtos as $produto_id => $quantidade) {
                $produtos_constituinte[$produto_id] = $quantidade;
//                $CI->firephp->log($produtos_bd[$produto_id]);
                $produtos_bd[$produto_id]->setStockAtual((int)$produtos_bd[$produto_id]->getStockAtual() - $quantidade);
                $produtos_bd[$produto_id]->edita(0);
            }

            $DistribuicaoIndividual->define([
                'NissConstituinte' => $constituintes[$IdConstituinte]->getNiss(),
                'ProdutosQuantidades' => json_encode($produtos_constituinte),
                'Data' => date('Y-m-d H:i:s'),
            ]);
            $DistribuicaoIndividual->grava();
            $count++;
        }

        //------ 2º - Vamos obter as distribuições individuais que foram agora criadas
        $distribuicoes_individuais = (new Distribuicao_Individual_Constituinte())->obtemElementos(
            ['Id' => 'DESC'],
            null,
            ['limite' => $count]
        );

        //------ 3º - Vamos organizar as distribuições individuais por agregado
        $distribuicoesPorAgregado = [];
        foreach ($distribuicoes_individuais as $distribuicao_individual) {
            $distribuicoesPorAgregado[$constituintesPorNiss[$distribuicao_individual->getNissConstituinte()]->getIdAgregado()][] = $distribuicao_individual;
        }


        //------ 4º - Com base nas distribuições individuais vamos criar as entregas
        $count = 0;
        foreach ($distribuicoesPorAgregado as $IdAgregado => $distribuicoes) {
            $ids_distribuicoes = [];
            foreach ($distribuicoes as $distribuicao) {
                $ids_distribuicoes[] = $distribuicao->getId();
            }

            $Entrega = new Entrega();
            $Entrega->define([
                'IdsDistribuicoesIndividuais' => json_encode($ids_distribuicoes), // Aqui deve ter os ids das distribuicoes do mesmo agregado
                'IdAgregado' => $IdAgregado,
                'Descricao' => "Entrega gerada automáticamente pelo sistema",
                'DataEntrega' => date('Y-m-d H:i:s'),
                'TipoEntrega' => Entrega::TIPO_ENTREGA_LOCAL,
            ]);
            $Entrega->grava();
            $count++;
        }


        //------ 5º - Vamos obter as entregas que foram agora criadas
        $entregas = (new Entrega())->obtemElementos(
            ['Id' => 'DESC'],
            null,
            ['limite' => $count]
        );

        //------ 6º - Vamos organizar as entregas por id de agregado
        $entregasPorAgregado = [];
        foreach ($entregas as $entrega) {
            $entregasPorAgregado[$entrega->getIdAgregado()][] = $entrega;
        }

        //------ 7º - Vamos criar as distribuições
        $count = 0;

        $this->db->select('*, (SELECT MAX(NumeroGrupoDistribuicao) FROM distribuicao) AS MaxNumeroGrupoDistribuicao');
        $this->db->from('distribuicao');
        $query = $this->db->get();
        $row = $query->row();
        // Esta variavel serve para colocarmos todas as distribuicoes no mesmo grupo (num foturo podemos ter um obj acima deste para agrupar)
        $MaxNumeroGrupoDistribuicao = $row->MaxNumeroGrupoDistribuicao + 1;

        foreach ($entregasPorAgregado as $IdAgregado => $entregas) {
            $ids_entregas = [];
            foreach ($entregas as $entrega) {
                $ids_entregas[] = $entrega->getId();
            }

            $Distribuicao = new Distribuicao();
            $Distribuicao->define([
                'NissAgregado' => $agregados[$IdAgregado]->getNissConstituintePrincipal(),
                'IdAgregado' => $IdAgregado,
                'IdsEntregas' => json_encode($ids_entregas),
                'Data' => date('Y-m-d H:i:s'),
                'NumeroGrupoDistribuicao' => $MaxNumeroGrupoDistribuicao
            ]);
            $Distribuicao->grava();
            $count++;
        }

        //------ 8º - Vamos obter as distribuições que foram agora criadas
        $distribuicoes = (new Distribuicao())->obtemElementos(
            ['Id' => 'DESC'],
            null,
            ['limite' => $count]
        );


//        $CI->db->trans_complete();
//
//        // Verificar se a transação foi bem-sucedida
//        if ($CI->db->trans_status() === false) {
//            // Se a transação falhar, reverta todas as alterações feitas no banco de dados
//            $CI->db->trans_rollback();
//            // Lidar com o erro, se necessário
//        } else {
//            // Se a transação for bem-sucedida, confirme as alterações feitas no banco de dados
//            $CI->db->trans_commit();
//            // Lidar com o sucesso, se necessário
//        }


        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'message' => 'Distribuições Geradas com Sucesso',
                          'view' => $this->load->view('admin/distribuicao/area_distribuicao_passo_3',
                              ['distribuicoes' => $distribuicoes, 'produtos' => $produtos_bd, 'agregados' => $agregados], true)]);
        return;
    }
}
