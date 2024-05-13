<?
// ['distribuicoes' => $distribuicoes, 'produtos' => $produtos, 'agregados' => $agregados]

/* @var $distribuicao Distribuicao */
/* @var $produtos Produto */
/* @var $agregados Agregado */

$CI = &get_instance();

if (count($distribuicoes) > 0) {
    //Vamos organizar as distribuicoes por agregado
    $distribuicoes_Agregados = [];
    foreach ($distribuicoes as $distribuicao) {
        $distribuicoes_Agregados[$distribuicao->getNissAgregado()][] = $distribuicao;
    }

    //Agora vamos mostrar as distribuicoes por agregado
    foreach ($distribuicoes_Agregados as $distribuicao_Agregado) {
//        $CI->firephp->log($distribuicao_Agregado);
        foreach ($distribuicao_Agregado as $distribuicao) {
            $CI->firephp->log($distribuicao);
        }
        ?>

        <?
    }
}
?>

