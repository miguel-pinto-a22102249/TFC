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
//        $entregas = (new Entrega())->obtemElementos(['Estado' => ESTADO_ATIVO]);

        $this->load->view('admin/template/header',
            ["tituloArea" => "Distribuições",
             "subtituloArea" => "Listar Distribuição: " . reset($distribuicoes)->getData() . "- Por Constituinte",
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

    public function listarPorAgregado($NumeroGrupoDistribuicao) {
//        $this->load->model('escalao');
        $this->load->model('produto');
//        $this->load->model('constituinte');
        $this->load->model('distribuicao');
        $this->load->model('distribuicao_individual_constituinte');
        $this->load->model('entrega');

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


        $this->load->view('admin/template/header', ["tituloArea" => "Distribuições",
                                                    "subtituloArea" => "Listar Distribuição: " . reset($distribuicoes)->getData() . "- Por Agregado", "acoes" => [
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
        $this->load->model('entidade_distribuidora');
        $CI = &get_instance();

        $IdsAgregados = $this->input->post('agregados');
        $TipoDistribuicao = $this->input->post('TipoDistribuicao');
        $IdEntidadeDistribuidora = $this->input->post('IdEntidadeDistribuidora');
        $EsgotarStock = $this->input->post('EsgotarStock');

        $this->form_validation->set_rules('agregados', 'agregados', 'required');
        $this->form_validation->set_rules('EsgotarStock', 'EsgotarStock', 'required');
        $this->form_validation->set_rules('TipoDistribuicao', 'TipoDistribuicao', 'required');
        //vamos validar se existem produtos e que tenham stock da entidade distribuidora selecionada
        $this->form_validation->set_rules('IdEntidadeDistribuidora', 'IdEntidadeDistribuidora', 'required|callback_validaProdutosEntidadeDistribuidora');

        $this->form_validation->set_message('required', '<i class="fas fa-exclamation-triangle"></i> Por favor preencha o campo corretamente.');


        if ($this->form_validation->run() === false) {
            $errors = [];

            // Construa um array de erros associados aos campos
            $fields = ['agregados', 'TipoDistribuicao', 'IdEntidadeDistribuidora', 'EsgotarStock'];

            foreach ($fields as $field) {
                $error = form_error($field);
                if (!empty($error)) {
                    $errors[] = ['field' => $field, 'message' => $error];
                }
            }
            if ($this->input->is_ajax_request()) {
                // Se for uma requisição AJAX, envie os erros como resposta JSON
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'errors' => $errors, 'message' => 'Erro ao criar agregado']);
                return;
            }
        } else {
            $dados = [];

            switch ($TipoDistribuicao) {
                case 1:
                    $dados = $this->distribuicaoPorTotais($IdsAgregados, $TipoDistribuicao, $IdEntidadeDistribuidora, $EsgotarStock);
                    break;
                case 2:
                    $dados = $this->distribuicaoEquitativa($IdsAgregados, $TipoDistribuicao, $IdEntidadeDistribuidora, $EsgotarStock);
                    break;
            }

            $EntidadeDistribuidoras = (new Entidade_Distribuidora())->obtemElementos(null, ['Estado' => ESTADO_ATIVO]);

            $dados['EntidadeDistribuidora'] = $EntidadeDistribuidoras[$IdEntidadeDistribuidora];

            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'message' => 'Dados Importados com sucesso',
                              'view' => $this->load->view('admin/distribuicao/area_distribuicao_passo_2', $dados, true)]);
            return;
        }
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
                //Caso o numero seja negativo (DEVIA MOSTRAR UM ERRO)
                if ((int)$produtos_bd[$produto_id]->getStockAtual() - $quantidade < 0) {
                    $produtos_bd[$produto_id]->setStockAtual(0);
                } else {
                    $produtos_bd[$produto_id]->setStockAtual((int)$produtos_bd[$produto_id]->getStockAtual() - $quantidade);
                }
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

    public function distribuicaoPorTotais($IdsAgregados, $TipoDistribuicao, $IdEntidadeDistribuidora, $EsgotarStock) {
        // <editor-fold defaultstate="collapsed" desc="Obter os agregados selecionados">
        $agregados_temp = (new Agregado_Familiar())->obtemElementos(['Estado' => ESTADO_ATIVO]);
        $agregados = [];
        foreach ($agregados_temp as $agregado) {
            if (in_array($agregado->getId(), $IdsAgregados)) {
                $agregados[] = $agregado;
            }
        }
        // </editor-fold>

        $CI = &get_instance();
        //Obter escalões
        $escaloes_temp = (new Escalao())->obtemElementos(['Estado' => ESTADO_ATIVO]);

        //organizar o array de escaloes por id
        foreach ($escaloes_temp as $escalao) {
            $escaloes[$escalao->getId()] = $escalao;
        }

        //Obter produtos
        $produtos = (new Produto())->obtemElementos(null, ['Estado' => ESTADO_ATIVO, 'IdEntidadeDistribuidora' => $IdEntidadeDistribuidora]);

        $this->produtos = $produtos; // Para poder ser usado nos proximos passos

        //Obter constituintes - São todos obtidos de uma unica vez para que seja mais rápido e eficiente
        $constituintes = (new Constituinte())->obtemElementos(null, ['Estado' => ESTADO_ATIVO]);


        //Vamos guardar os produtos que são necessários
        $produtos_necessarios = [];
        foreach ($agregados as $agregado) {
            //Ir a cada constituinte do agregado e fazer os calculos da distribuicao
            foreach ($constituintes as $constituinte) {
                if ($constituinte->getIdAgregado() == $agregado->getId()) {
                    if ($constituinte->getIdEscalao()) {
                        $escalao = $escaloes[$constituinte->getIdEscalao()];
                    }

                    if ($escalao) {
                        $produtos_escalao = json_decode($escalao->getProdutos());
                    } else {
                        continue;
                    }

                    foreach ($produtos_escalao as $produto_id => $quantidade) {
                        $produtos_necessarios[$produto_id] = $produtos[$produto_id];
                    }
                }
            }
        }
        $produtos_apos_distribuicao = $produtos_necessarios;


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

        //Vamos distribuir 1 unidade de cada produto que ainda tenha stock até esgotar o stock
        if ($EsgotarStock == 1) {
            do {
                //Vamos criar um array com os produtos que ainda têm stock
                $produtos_com_stock = [];
                $existeStocks = false;
                foreach ($produtos_apos_distribuicao as $produto) {
                    if ($produto->getStockAtual() > 0) {
                        $produtos_com_stock[] = $produto;
                        $existeStocks = true;
                    }
                }

                //Vamos distribuir 1 unidade de cada produto que ainda tenha stock até esgotar o stock
                foreach ($agregados_constituintes as $nissAgregado => $constituintes) {
                    foreach ($constituintes as $constituinte) {
                        foreach ($produtos_com_stock as $produto) {
                            if (array_key_exists($produto->getId(), $constituinte->ProdtutosQuantidades)) {
                                if ($produto->getStockAtual() > 0) {
                                    $constituinte->ProdtutosQuantidades[$produto->getId()][1]++;
                                    $stock_temp = $produto->getStockAtual() - 1;
                                    $produto->setStockAtual($stock_temp);
                                    $produtos_apos_distribuicao[$produto->getId()]->setStockAtual($stock_temp);
                                }
                            }
                        }
                    }
                }
            } while ($existeStocks);
        }

        return ["agregados_constituintes" => $agregados_constituintes, "produtos_apos_distribuicao" => $produtos_apos_distribuicao];
    }

    public function distribuicaoEquitativa($IdsAgregados, $TipoDistribuicao, $IdEntidadeDistribuidora, $EsgotarStock) {
        $CI = &get_instance();
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
        $escaloes = (new Escalao())->obtemElementos(null, ['Estado' => ESTADO_ATIVO]);

        //Obter Produtos
        $produtos = (new Produto())->obtemElementos(null, ['Estado' => ESTADO_ATIVO, 'IdEntidadeDistribuidora' => $IdEntidadeDistribuidora]);
        $this->produtos = $produtos;                                  // Para poder ser usado nos proximos passos

        //Obter constituintes - São todos obtidos de uma unica vez para que seja mais rápido e eficiente
        $constituintes = (new Constituinte())->obtemElementos(null, ['Estado' => ESTADO_ATIVO]);
        //Vamos guardar apenas os constituintes que pertencem aos agregados selecionados para a distribuicao
        foreach ($constituintes as $constituinte) {
            $constituinte->Idade = $constituinte->getIdade();
            if (!in_array($constituinte->getIdAgregado(), $IdsAgregados)) {
                unset($constituintes[$constituinte->getId()]);
            }
        }

        $produtos_apos_distribuicao = [];

        //Obter os totais que vamos necessitar
        $totais_produtos_necessarios = [];                            //Vai conter o id do produto como key e dentro [quantidade segundo o escalão, numero de constituintes que necessitam deste produto]
        foreach ($agregados as $agregado) {
            //Ir a cada constituinte do agregado e fazer os calculos da distribuicao
            foreach ($constituintes as $constituinte) {
                if ($constituinte->getIdAgregado() == $agregado->getId()) {
                    if ($constituinte->getIdEscalao()) {
                        $escalao = $escaloes[$constituinte->getIdEscalao()];
                    }

                    if ($escalao) {
                        $produtos_escalao = json_decode($escalao->getProdutos());
                    } else {
                        continue;
                    }

                    foreach ($produtos_escalao as $produto_id => $quantidade) {
                        if (array_key_exists($produto_id, $totais_produtos_necessarios)) {
                            $totais_produtos_necessarios[$produto_id]["quantidadeTotal"] += $quantidade;
                            $totais_produtos_necessarios[$produto_id]["numeroConstituintes"]++;
                        } else {
                            $totais_produtos_necessarios[$produto_id] = ["quantidadeTotal" => $quantidade, "numeroConstituintes" => 1];
                        }

                        $produtos_apos_distribuicao[$produto_id] = $produtos[$produto_id];
                    }
                }
            }
        }


        $produtos_quantidades_a_distribuir = [];
        //Agora vamos fazer o calculo do que é possivel distribuir para cada constituinte
        foreach ($totais_produtos_necessarios as $IdProduto => $total_produto_necessario) {
            $stockAtual = $produtos[$IdProduto]->getStockAtual();


            //floor para arredondar para baixo (ex.: 1.5 = 1)
            //ceil para arredondar para cima   (ex.: 1.5 = 2)
            //Usamos a função intdiv($Nprodutos, $Npessoas) para calcular a divisão inteira (quociente).
            $quantidadeADistribuir = floor($stockAtual / $total_produto_necessario["numeroConstituintes"]);

            if ($quantidadeADistribuir == 0 || $quantidadeADistribuir == false) {
                $quantidadeADistribuir = 1;
            }

            $produtos_quantidades_a_distribuir[$IdProduto] = $quantidadeADistribuir;
        }


        //Vamos obter o metodo para a distribuicao (ex.: idade) - Se for por idade quem tem prioridade são os mais novos
        $value = substr(config_item('distribuicao_variavel'), 1, -1); //Futuramente isto deveria estar numa bd
        $opcao_de_distribuicao = explode(',', $value)[0];


        //Se for por idade vamos ordenar os constituintes por idade para depois fazer a distribuicao
        $constituintes = array_values($constituintes);
        if ($opcao_de_distribuicao == "Idade") {
//          vamos ordenar por idades
            usort($constituintes, function($a, $b) {
                return $a->Idade <=> $b->Idade;
            });
        }

        //Agora que já temos o calculo e a ordenação de cosntituintes vamos atribuir aos constituintes os produtos
        $agregados_constituintes = [];


        //Depois de ordenado vamos então fazer a distribuição
        foreach ($constituintes as $constituinte) {
            if ($constituinte->getIdEscalao()) {
                $escalao = $escaloes[$constituinte->getIdEscalao()];
            }

            if ($escalao) {
                $produtos_escalao = json_decode($escalao->getProdutos());
            }

            //vai conter o id do produto como key e dentro [quantidade segundo o escalão, quantidade efetivamente atribuida]
            $produtos_atribuidos = [];


            //Estrotura do array $produtos_quantidades_a_distribuir
            //$produtos_quantidades_a_distribuir[$IdProduto] = $quantidadeADistribuir;

            foreach ($produtos_escalao as $produto_id => $quantidade) {
                if (array_key_exists($produto_id, $produtos_apos_distribuicao)) {
                    $quantidadeADistribuir = $produtos_quantidades_a_distribuir[$produto_id];

                    //Se não for para esgotar sotck, vamos apenas distribuir até ao valor de stock estipulado no escalão
                    if ($EsgotarStock == 0 && $quantidadeADistribuir > $quantidade) {
                        $quantidadeADistribuir = $quantidade;
                    }

                    $stockAtualProduto = $produtos_apos_distribuicao[$produto_id]->getStockAtual();

                    //Aqui validamos que o stock atual é suficiente para atribuir a quantidade calculada
                    if (($stockAtualProduto - $quantidadeADistribuir) > 0) {
                        $produtos_apos_distribuicao[$produto_id]->setStockAtual($produtos_apos_distribuicao[$produto_id]->getStockAtual() - $quantidadeADistribuir);
                        $produtos_atribuidos[$produto_id] = [$quantidade, $quantidadeADistribuir];
                    } else if ($stockAtualProduto > 0) {
                        //Se nao for suficiente vamos atribuir o que ainda houver e colocar o stock a 0
                        $produtos_atribuidos[$produto_id] = [$quantidade, $stockAtualProduto];
                        $produtos_apos_distribuicao[$produto_id]->setStockAtual(0);
                    } else {
                        $produtos_atribuidos[$produto_id] = [$quantidade, $stockAtualProduto];
                    }
                }
            }

            //Colocar os produtos do escalao no constituinte
            $constituinte->ProdtutosQuantidades = $produtos_atribuidos;

            $agregados_constituintes[$agregado->getNissConstituintePrincipal()][] = $constituinte;
        }


        //Vamos distribuir 1 unidade de cada produto que ainda tenha stock até esgotar o stock
        if ($EsgotarStock == 1) {
            do {
                //Vamos criar um array com os produtos que ainda têm stock
                $produtos_com_stock = [];
                $existeStocks = false;
                foreach ($produtos_apos_distribuicao as $produto) {
                    if ($produto->getStockAtual() > 0) {
                        $produtos_com_stock[] = $produto;
                        $existeStocks = true;
                    }
                }

                //Vamos distribuir 1 unidade de cada produto que ainda tenha stock até esgotar o stock
                foreach ($agregados_constituintes as $nissAgregado => $constituintes) {
                    foreach ($constituintes as $constituinte) {
                        foreach ($produtos_com_stock as $produto) {
                            if (array_key_exists($produto->getId(), $constituinte->ProdtutosQuantidades)) {
                                if ($produto->getStockAtual() > 0) {
                                    $constituinte->ProdtutosQuantidades[$produto->getId()][1]++;
                                    $produto->setStockAtual($produto->getStockAtual() - 1);
                                    $produtos_apos_distribuicao[$produto->getId()]->setStockAtual($produto->getStockAtual());
                                }
                            }
                        }
                    }
                }
            } while ($existeStocks);
        }

        return ["agregados_constituintes" => $agregados_constituintes, "produtos_apos_distribuicao" => $produtos_apos_distribuicao];
    }

    /**
     * Função que valida se existem produtos para a entidade distribuidora selecionada para a distribuicao
     *
     * @param $IdEntidadeDistribuidora
     *
     * @return bool
     */
    public function validaProdutosEntidadeDistribuidora($IdEntidadeDistribuidora) {
        $produtos = (new Produto())->obtemElementos(null, ['Estado' => ESTADO_ATIVO, 'IdEntidadeDistribuidora' => $IdEntidadeDistribuidora]);
        if (empty($produtos)) {
            $this->form_validation->set_message('validaProdutosEntidadeDistribuidora', '<i class="fas fa-exclamation-triangle"></i> Não existem produtos para a entidade distribuidora selecionada. Por favor adicione produtos à entidade distribuidora selecionada.');
            return false;
        }
        return true;
    }
}
