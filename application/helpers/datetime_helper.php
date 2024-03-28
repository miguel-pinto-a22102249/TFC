<?

/**
 * Devolve uma data formatada num formato à escolha (formato base: dd-mm-aa às hh:mm)
 * 
 * @param DateTime $Data data a formatar (usualmente resultado da BD)
 * @param String $Formato Formato PHP para a data
 * 
 * @return String Data formatada 
 */
function dataFormatada($Data, $Formato = '%d-%m-%y às %H:%M') {
    $CI = &get_instance();
    if ($Data == null) {
        return '-';
    }
    return strftime($Formato, strtotime($Data));
}

/**
 * Devolve uma data formatada num formato 
 * 
 * @param DateTime $Data data a formatar (usualmente resultado da BD) 
 * 
 * @return String Data formatada 
 */
function dataFormatadaMesAno($Data) {
    return dataFormatada($Data, '%m-%Y');
}

/**
 * Devolve uma data formatada num formato 
 * 
 * @param DateTime $Data data a formatar (usualmente resultado da BD) 
 * 
 * @return String Data formatada 
 */
function dataFormatadaDiaMesAno($Data) {
    return dataFormatada($Data, '%d-%m-%Y');
}

/**
 * 
 * @param string $numMes
 * @return string
 */
function getDesignacaoMes($numMes) {
    $ar = array(
        '01' => 'Janeiro',
        '02' => 'Fevereiro',
        '03' => 'Março',
        '04' => 'Abril',
        '05' => 'Maio',
        '06' => 'Junho',
        '07' => 'Julho',
        '08' => 'Agosto',
        '09' => 'Setembro',
        '10' => 'Outubro',
        '11' => 'Novembro',
        '12' => 'Dezembro'
    );


    return key_exists($numMes, $ar) ? $ar[$numMes] : '-';
}

/**
 * 
 * Devolve a representação textual do dia da semana (1 - segunda feira, 7 - Domingo)
 * 
 * @param int $diaSemana
 * @param bool $versaoCurta
 * @return string
 */
function getDesignacaoDiaSemana($diaSemana, $versaoCurta = TRUE) {

    if ($versaoCurta) {
        $ar = array(
            1 => '2ª Feira',
            2 => '3ª Feira',
            3 => '4ª Feira',
            4 => '5ª Feira',
            5 => '6ª Feira',
            6 => 'Sábado',
            7 => 'Domingo'
        );
    } else {

        $ar = array(
            1 => 'Segunda-feira',
            2 => 'Terça-feira',
            3 => 'Quarta-feira',
            4 => 'Quinta-feira',
            5 => 'Sexta-feira',
            6 => 'Sábado',
            7 => 'Domingo'
        );
    }

    return key_exists($diaSemana, $ar) ? $ar[$diaSemana] : '-';
}

/**
 * 
 * Retorna o número de dias que faltam até uma certa data.
 * 
 * @param string|date $data
 * 
 * @return string|false
 */
function diasAte($data) {
    $difference = strtotime($data) - time();
    if ($difference < 0) {
        $difference = 0;
    }

    return isset($data) ? floor($difference / 60 / 60 / 24) : FALSE;
}

/**
 * Extrai o ano de uma data
 */
function getAno($pdate) {
    $date = DateTime::createFromFormat("Y-m-d", $pdate);
    return $date->format("Y");
}

/**
 * Devolve a data/hora actual no formato Y-m-d H:i:s
 * 
 * return DateTime
 */
function dataHoraActual() {
    return date('Y-m-d H:i:s');
}
