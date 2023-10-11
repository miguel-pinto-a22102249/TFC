<?php include 'db_conf.php';
include 'functions_php.php'; ?>
<style>
  <?php include 'estilos.css'; ?>
</style>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous" />
  <link rel="stylesheet" href="estilos.css">
</head>

<body>
  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">CEBI</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav me-auto mb-2 mb-md-0">
          <li class="nav-item">
            <a class="nav-link" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Distribuição</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="inventarios.php">Inventários</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="agregados.php">Agregados</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="entregas.php">Entregas</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="referencias.php">Referências</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="resumo.php">Resumo</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  </header>
  <main style="margin: 50px;">

    <?php

    $sql  = 'SELECT 5produto.produto from 5produto';
    $result = mysqli_query($conn, $sql);
    $produtos = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $options = array();

    foreach ($produtos as $produto) {
      array_push($options, $produto);
    }

    echo "
    <form method='POST'>
    <select class='form-select' name='Produto'>
    <option selected disabled> Select </option>
    ";

    foreach ($options as $option) {
      $temp = implode($option);
      echo "<option value='$temp'> " . implode($option) . "</option>";
    }

    echo "
    </select>
    <br>
    <button type='submit' name='submit' class='btn btn-secondary'>Submit</button>
    </form>";

    if (isset($_POST['submit'])) {
      $getfood = $_POST['Produto'];
      echo 'Produto Selecionado: ' . $getfood;
      echo '<br>';
    }

    echo "
    <table class='table'>
    <thead>
    <tr>
    <th>NISS</th>
    <th>Produto</th>
    <th>Quantidade</th>
    <th>Index</th>
    <th> </th>
    </tr>
    </thead>
    <tbody>";

    if (isset($getfood)) {
      $sql2  = "select di.niss, p.produto, di.quantidade, di.index_1 from 7distribuicao_individual di inner join 5produto p on di.produto_id = p.produto_id
          where p.produto = '" . $getfood . "'";
      $fk_query =  mysqli_query($conn, $sql2);
      $distribuicao =  mysqli_fetch_all($fk_query, MYSQLI_ASSOC);

      foreach ($distribuicao as $item2) :
        echo "<tr>
          <td>" . $item2["niss"] . "</td>
          <td>" . $item2["produto"] . "</td>
          <td>" . $item2["quantidade"] . "</td>
          <td>" . $item2["index_1"] . "</td>
          <td>
                <a  style='text-decoration: none; font-size: 2em' href='form_quantidade.php?id={$item2["niss"]}&id2={$item2["produto"]}&id3={$item2["quantidade"]}' <i class='fa fa-edit' style='font-size:36px'> </i> </a>
            </td>
           </tr>";
      endforeach;
    } else {
      echo "Selecione uma opção. <br>";
    }

    ?>

    <br>

    <?php

    if (isset($_POST['distribui'])) {
      distribuicaoIndividual($conn);
    }
    ?>

    <form method="post">
      <input type="submit" class="btn btn-primary" name="distribui" value="Distribuir">
    </form>
    <br>
    <br>
    </tbody>
    </table>
  </main>

  <?php include 'footer.php'; ?>

  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>