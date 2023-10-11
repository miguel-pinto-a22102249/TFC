<?php include 'db_conf.php'; ?>
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
            <a class="nav-link" href="distribuicao.php">Distribuição</a>
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
            <a class="nav-link active" aria-current="page" href="#">Referências</a>
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
    echo "<form method='POST'>
    <select class='form-select' name='Produto'>
    <option selected disabled> Select </option>";

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
    }

    echo "<table class='table'>
    <thead>
    <tr>
    <th>Escalao</th>
    <th>Idade Inicial</th>
    <th>Idade Final</th>
    <th>Produto</th>
    <th>Porção</th>
    </tr>
    </thead>
    <tbody>";

    if (isset($getfood)) {
      $sql2  = "select e.escalao_id, e.idade_inicial, e.idade_final, s.produto, s.porcao from 2escalao e inner join (SELECT p.produto, r.escalao, r.porcao from 5produto p inner join 6referencia r on p.produto_id = r.produto_id 
          where p.produto = '" . $getfood . "') as s on s.escalao = e.escalao_id";
      $fk_query =  mysqli_query($conn, $sql2);
      $referencias =  mysqli_fetch_all($fk_query, MYSQLI_ASSOC);

      foreach ($referencias as $item2) :
        echo "<tr>
          <td>" . $item2["escalao_id"] . "</td>
          <td>" . $item2["idade_inicial"] . "</td>
          <td>" . $item2["idade_final"] . "</td>
          <td>" . $item2["produto"] . "</td>
          <td>" . $item2["porcao"] . "</td>
          </tr>";
      endforeach;
    } else {
      echo "Selecione uma opção.";
    }
    ?>
    </tbody>
    </table>
  </main>

  <?php include 'footer.php'; ?>

  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>