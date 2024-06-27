<?php

$this->load->model('distribuicao');

$mesesAbreviados = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
$distribuicoes = (new Distribuicao())->obtemElementos(null, ['Estado' => Distribuicao::ESTADO_TERMINADA]);

// Agrupar por mês
$distribuicoesPorMes = [];
foreach ($distribuicoes as $distribuicao) {
    $mes = date('m', strtotime($distribuicao->getData()));
    if (!isset($distribuicoesPorMes[$mes])) {
        $distribuicoesPorMes[$mes] = 0;
    }
    $distribuicoesPorMes[$mes]++;
}

// Remover meses sem distribuições
$mesesComDistribuicoes = [];
$quantidadesPorMes = [];
foreach ($distribuicoesPorMes as $mes => $quantidade) {
    if ($quantidade > 0) {
        $mesesComDistribuicoes[] = $mesesAbreviados[$mes - 1];
        $quantidadesPorMes[] = $quantidade;
    }
}

// Converter para JSON
$mesesJson = json_encode($mesesComDistribuicoes);
$quantidadesJson = json_encode($quantidadesPorMes);
?>

<h3 class="">Distribuições Finalizadas</h3>
<canvas id="Grafico-Numero-Total-Entregas-Finalizadas-Mes" width="400" height="400"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const mesesComDistribuicoes = <?php echo $mesesJson; ?>;
    const quantidadesPorMes = <?php echo $quantidadesJson; ?>;

    var ctx = document.getElementById('Grafico-Numero-Total-Entregas-Finalizadas-Mes').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar', // Tipo de gráfico: 'line', 'bar', 'pie', etc.
        data: {
            labels: mesesComDistribuicoes,
            datasets: [{
                label: 'Distribuições Finalizadas',
                data: quantidadesPorMes,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});
</script>
