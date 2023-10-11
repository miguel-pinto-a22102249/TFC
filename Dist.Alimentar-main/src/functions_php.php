<?php

function getTime()
{
    date_default_timezone_set('Europe/Lisbon');
    return date("Y-m-d H:i:s");
}

function getMonth()
{
    date_default_timezone_set('Europe/Lisbon');
    $mes = date("m");
    $mesStr = "";
    switch ($mes) {
        case 1:
            $mesStr = "Janeiro";
            break;
        case 2:
            $mesStr = "Fevereiro";
            break;
        case 3:
            $mesStr = "Março";
            break;
        case 4:
            $mesStr = "Abril";
            break;
        case 5:
            $mesStr = "Maio";
            break;
        case 6:
            $mesStr = "Junho";
            break;
        case 7:
            $mesStr = "Julho";
            break;
        case 8:
            $mesStr = "Agosto";
            break;
        case 9:
            $mesStr = "Setembro";
            break;
        case 10:
            $mesStr = "Outubro";
            break;
        case 11:
            $mesStr = "Novembro";
            break;
        case 12:
            $mesStr = "Dezembro";
            break;
        default:
            $mesStr = "";
    }
    return $mesStr;
}

function append_string($str1, $str2)
{

    $str1 .= $str2;
    return $str1;
}

function betterDate($date)
// Formatar a data para o menu de Entregas
{
    $date = new DateTime($date);
    $result = $date->format('m/d H:i');
    return $result;
}

function betterTipo($tipo)
// Input ja preenchido no formulário de edição do menu de entregas campo tipo_entrega
{
    $betterTipoR = "";
    if ($tipo == 0) {
        $betterTipoR = "Instituição";
    } else if ($tipo == 1) {
        $betterTipoR = "Local 1";
    } else {
        $betterTipoR = "Local 2";
    }

    return $betterTipoR;
}

function betterStatus($status)
// Input ja preenchido no formulário de edição do menu de entregas, campo status
{
    $betterStatusR = "";
    if ($status == 0) {
        $betterStatusR = "Entregue";
    } else if ($status == 1) {
        $betterStatusR = "Pendente";
    } else {
        $betterStatusR = "Cancelada";
    }

    return $betterStatusR;
}

function setString($item)
// Converter algo para string para não dar erro ao inserir na base de dados
{
    $string2 = "\"";
    $str = append_string($string2, $item);
    $str_final = append_string($str, $string2);
    return $str_final;
}

function getNecessidade($produto_id, $conn)
// Soma cumulativa da quantidade necessária de um produto, para distribuir por todos os agregados face as porções indicadas na tabela das referências
{
    $sql  = 'select MAX(escalao) from 6referencia r where produto_id = ' . $produto_id;
    $result = mysqli_query($conn, $sql);
    $escalaoMax = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $escalaoMaxNum = $escalaoMax[0]['MAX(escalao)'];

    $count = 1;
    $necessidade = 0;

    for ($count = 1; $count <= $escalaoMaxNum; $count++) { // Itera pelos escalões e vê quantos existem
        $sql2 = 'select COUNT(*) from 3constituinte c where escalao = ' . $count;
        $result2 = mysqli_query($conn, $sql2);
        $quantidade = mysqli_fetch_all($result2, MYSQLI_ASSOC);
        $quantidadeNum = $quantidade[0]['COUNT(*)'];

        $sql3 = 'select * from 6referencia c where escalao = ' . $count . ' and produto_id = ' . $produto_id;
        $result3 = mysqli_query($conn, $sql3);
        $porcao = mysqli_fetch_all($result3, MYSQLI_ASSOC);
        $porcaoNum = $porcao[0]['porcao'];
        $necessidade = $necessidade + ($porcaoNum * $quantidadeNum);
    }
    return $necessidade;
}

function getNecessidadeIndividual($niss, $produto_id, $conn)
// Enquanto que na função getNecessidade() faz se o cálculo para todos os agregados pertencentes à instituição, nesta função faz-se o cálculo para um único agregado já que este é composto
// por várias pessoas que têm necessidades diferentes
{
    $sql  = 'select MAX(escalao) from 6referencia r where produto_id = ' . $produto_id;
    $result = mysqli_query($conn, $sql);
    $escalaoMax = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $escalaoMaxNum = $escalaoMax[0]['MAX(escalao)'];

    $count = 1;
    $necessidade = 0;

    for ($count = 1; $count <= $escalaoMaxNum; $count++) {
        $sql2 = 'select COUNT(*) from 3constituinte c where escalao = ' . $count . ' and  agregado = ' . $niss;
        $result2 = mysqli_query($conn, $sql2);
        $quantidade = mysqli_fetch_all($result2, MYSQLI_ASSOC);
        $quantidadeNum = $quantidade[0]['COUNT(*)'];

        $sql3 = 'select * from 6referencia c where escalao = ' . $count . ' and produto_id = ' . $produto_id;
        $result3 = mysqli_query($conn, $sql3);
        $porcao = mysqli_fetch_all($result3, MYSQLI_ASSOC);
        $porcaoNum = $porcao[0]['porcao'];
        $necessidade = $necessidade + ($porcaoNum * $quantidadeNum);
    }
    return $necessidade;
}

function getPorcoesPercentagem($produto_id, $conn)
// Quantidade percentual do que realmente se pode distribuir por todas as pessoas, já que o inventário pode não alcançar as expectativas
{
    $sql  = 'SELECT * from 5produto WHERE produto_id =' . $produto_id;
    $result = mysqli_query($conn, $sql);
    $porcoes = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $quantidade = $porcoes[0]['quantidade_inicial'];
    $necessidade = getNecessidade($produto_id, $conn);
    $percentagem = $quantidade / $necessidade;
    return $percentagem;
}

function getNumeroDeProdutos($conn)
// Conta a quantidade de produtos únicos existentes
{
    $sql  = 'SELECT COUNT(*) from 5produto';
    $result = mysqli_query($conn, $sql);
    $produtos = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $produtosNum = $produtos[0]['COUNT(*)'];
    return $produtosNum;
}

function setPorcaoIndividual($produto_id, $niss, $conn)
// Para cada agregado atribui-lhe uma porção de um certo produto, esta quantidade é calculada face as suas necessidades e ao inventário
// IDX (Index) serve para indentificar se cumpriu as necessidades do agregado, sendo 1 - 100% (Cumpriu na totalidade) , 0 - 0% (Não recebeu nada)
{
    $quantidade_percentagem = getPorcoesPercentagem($produto_id, $conn);
    $idx = number_format($quantidade_percentagem, 2, '.', '');

    $quantidade_normal = getNecessidadeIndividual($niss, $produto_id, $conn);
    $quantidade_calculada = floor($quantidade_normal * $quantidade_percentagem);
    $distribuicao_individual = "update 7distribuicao_individual
    set quantidade = $quantidade_calculada,
    index_1 = $idx
    where niss = $niss and produto_id =" . $produto_id;
    mysqli_query($conn, $distribuicao_individual);
}

function distribuicaoIndividual($conn)
// Itera pelos diversos produtos e a cada iteração, chama a função setPorcaoIndividual() para cada agregado iterado.
{
    $produtos = getNumeroDeProdutos($conn);
    $count = 1;
    $sql  = 'SELECT DISTINCT * from 1agregado_familiar';
    $result = mysqli_query($conn, $sql);
    $agregados = mysqli_fetch_all($result, MYSQLI_ASSOC);

    for ($count = 1; $count <= $produtos; $count++) {
        foreach ($agregados as $item) {
            setPorcaoIndividual($count, $item['niss'], $conn);
        }
    }
}

function isInteger($number)
{
    if (ctype_digit($number) && intval($number) >= 0 && strpos($number, '.') == false) {
        echo "true";
        return true;
    } else {
        echo "false";
        return false;
    }
}

function novoPeriodo($conn)
{
    $sql  = 'use tfc;

    drop table if exists 6referencia;
    drop table if exists 8entrega;
    drop table if exists 7distribuicao_individual;
    drop table if exists 5produto;
    drop table if exists 4info_sensivel;
    drop table if exists 3constituinte;
    drop table if exists 2escalao;
    drop table if exists 1agregado_familiar;
    DROP TABLE IF EXISTS 9access_log;
    DROP TABLE IF EXISTS 9quantity_change_log;
    
    
    create table 1agregado_familiar
    (
        niss int primary key,
        grupo tinyint
    );
    
    create table 2escalao
    (
        escalao_id int primary key,
        idade_inicial int,
        idade_final int
    );
    
    create table 3constituinte
    (
        niss int primary key,
        agregado int,
        escalao int,
        foreign key(agregado) references 1agregado_Familiar(niss) ON DELETE cascade,
        foreign key(escalao) references 2escalao(escalao_id) on delete cascade
        
    );
    
    create table 4info_sensivel
    (
        niss int,
        telefone varchar(20),
        endereco varchar(50),
        codigo_postal varchar(15),
        foreign key(niss) references 1agregado_Familiar(niss) ON DELETE CASCADE
    );
    
    
    create table 5produto
    (
        produto_id int primary key AUTO_INCREMENT,
        produto varchar(50),
        quantidade_inicial int,
        quantidade_disponivel int
    );
    
    create table 6referencia
    (
        produto_id int,
        escalao int,
        porcao int,
        foreign key(produto_id) references 5produto(produto_id) ON DELETE cascade,
        foreign key(escalao) references 2escalao(escalao_id) on delete cascade
    );
    
    
    create table 7distribuicao_individual
    (
        distribuicao_id int primary key AUTO_INCREMENT,
        niss int,
        produto_id int,
        quantidade int,
        index_1 float,
        data_1 DATETIME,
        foreign key(niss) references 1agregado_Familiar(niss) ON DELETE CASCADE,
        foreign key(produto_id) references 5produto(produto_id) ON DELETE CASCADE
    );
    
    create table 8entrega
    (
        entrega_id int primary key AUTO_INCREMENT,
        niss int,
        distribuicao_id int,
        status tinyint(5) default 0,
        descricao varchar(200),
        tipo_entrega tinyint(5),
        data_inicio DATETIME,
        data_fim DATETIME,
        foreign key(niss) references 1agregado_Familiar(niss) ON DELETE CASCADE,
        foreign key(distribuicao_id) references 7distribuicao_individual(distribuicao_id) ON DELETE CASCADE
    );
    
    
    CREATE TABLE 9access_log
    (
        access_id int PRIMARY key AUTO_INCREMENT,
        data_1 DATETIME,
        id_accessed int
    );
    
    create table 9quantity_change_log
    (
        change_id int PRIMARY key AUTO_INCREMENT,
        data_1 DATETIME,
        id_accessed int,
        quantidade_antes int,
        quantidade_depois int
    )';
    mysqli_multi_query($conn, $sql);
}

function EXPORT_DATABASE($conn, $tables = false, $backup_name = false)
#função adaptada para este caso, créditos a @ttodua, https://github.com/ttodua/useful-php-scripts/blob/master/my-sql-export%20(backup)%20database.php
{
    set_time_limit(3000);
    $conn->query("SET NAMES 'utf8'");
    $queryTables = $conn->query('SHOW TABLES');
    while ($row = $queryTables->fetch_row()) {
        $target_tables[] = $row[0];
    }
    if ($tables !== false) {
        $target_tables = array_intersect($target_tables, $tables);
    }
    $content = "use tfc;";
    foreach ($target_tables as $table) {
        if (empty($table)) {
            continue;
        }
        $result    = $conn->query('SELECT * FROM `' . $table . '`');
        $fields_amount = $result->field_count;
        $rows_num = $conn->affected_rows;
        for ($i = 0, $st_counter = 0; $i < $fields_amount; $i++, $st_counter = 0) {
            while ($row = $result->fetch_row()) {
                if ($st_counter % 100 == 0 || $st_counter == 0) {
                    $content .= "\nINSERT INTO " . $table . " VALUES";
                }
                $content .= "\n(";
                for ($j = 0; $j < $fields_amount; $j++) {
                    $row[$j] = str_replace("\n", "\\n", addslashes($row[$j]));
                    if (isset($row[$j])) {
                        $content .= '"' . $row[$j] . '"';
                    } else {
                        $content .= '""';
                    }
                    if ($j < ($fields_amount - 1)) {
                        $content .= ',';
                    }
                }
                $content .= ")";
                if ((($st_counter + 1) % 100 == 0 && $st_counter != 0) || $st_counter + 1 == $rows_num) {
                    $content .= ";";
                } else {
                    $content .= ",";
                }
                $st_counter = $st_counter + 1;
            }
        }
        $content .= "\n\n\n";
    }
    $name = "distribuicao";
    $backup_name = $backup_name ? $backup_name : $name . '_(' . date('d-m-Y') . ').sql';
    ob_get_clean();
    header('Content-Type: application/octet-stream');
    header("Content-Transfer-Encoding: Binary");
    header('Content-Length: ' . (function_exists('mb_strlen') ? mb_strlen($content, '8bit') : strlen($content)));
    header("Content-disposition: attachment; filename=\"" . $backup_name . "\"");
    echo $content;
    exit;
}

/*function ImportData($conn) # FUNCIONA SEM DOCKER
{
    $sql = file_get_contents('distribuicao_(21-07-2023) (1).sql');
    mysqli_multi_query($conn, $sql);
}
*/
