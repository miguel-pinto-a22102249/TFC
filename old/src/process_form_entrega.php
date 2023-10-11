<?php
include 'db_conf.php';
include 'functions_php.php';

$niss = $_POST["niss"];
$tipo = $_POST["tipo"];
$status = $_POST["status"];
$descricao = $_POST["descricao"];

$descricao = setString($descricao);

$form_entrega = "update 8entrega
set tipo_entrega = $tipo,
status = $status,
descricao = $descricao
where niss = $niss";

mysqli_query($conn, $form_entrega);

mysqli_close($conn);

header("Location: ../src/entregas.php");

exit;
