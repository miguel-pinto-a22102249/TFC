<?php
include 'db_conf.php';
include 'functions_php.php';

$niss = $_POST["niss"];
$produto_id = $_POST["produto_id"];
$antes =  $_POST["antes"];
$quantidade = $_POST["quantidade"];

if (isInteger($quantidade)) {
    $time = setString(getTime());

    $form_quantidade = "update 7distribuicao_individual
set quantidade = $quantidade
where niss = $niss and produto_id = $produto_id";

    mysqli_query($conn, $form_quantidade);

    $log_regist = "INSERT INTO 9quantity_change_log(data_1, id_accessed, quantidade_antes, quantidade_depois) 
    values(" . $time . "," . $niss . "," . $antes . "," . $quantidade . ")";

    mysqli_query($conn, $log_regist);

    mysqli_close($conn);
}

header("Location: ../src/distribuicao.php");

exit;
