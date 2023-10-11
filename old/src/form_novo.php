<?php include 'db_conf.php';
include 'functions_php.php' ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous" />
  <link rel="stylesheet" href="estilos.css">
</head>

<body>

  <?php include 'header.php'; ?>
  <?php

  if (isset($_POST['novoP'])) {
    novoPeriodo($conn);
  }
  ?>
  <main style="margin: 50px;">
    <br>
    <h1 style="text-align: center;">Novo Periódo de Distribuição</h1>
    <br>
    <hr>
    <br>
    <p style="font-size: 1.5em">Ao clicar neste botão, a base de dados será resetada, levando a deleção de todos os dados. Por favor certifique-se que exportou os documentos antes de proceder.</p>
    <br>
    <div class="novo2">
      <label class="my-1 mr-2" for="tipo">Clique no botão abaixo se tem a certeza..</label>
      <br>
      <form method="post">
        <input type="submit" class="btn btn-primary" name="novoP" value="Confirmar">
        <button type="button" onclick="location.href='index.php'" class="btn btn-secondary">Cancelar</button>
      </form>
    </div>
  </main>

  <?php include 'footer.php'; ?>

  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>