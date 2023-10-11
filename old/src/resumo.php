<?php include 'db_conf.php';
include 'functions_php.php' ?>
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
            <a class="nav-link" href="referencias.php">Referências</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Resumo</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  </header>
  <main style="margin: 50px;">
    <h1 style="text-align: center;"> Distribuição de <?php echo getMonth() ?> </h1>
    <br>
    <table class="table">
      <thead>
        <tr>
          <th>NISS</th>
          <th>Index Médio</th>
        </tr>
      </thead>

      <tbody>
        <?php
        $sql  = 'SELECT DISTINCT * from 1agregado_familiar';
        $result = mysqli_query($conn, $sql);
        $agregados = mysqli_fetch_all($result, MYSQLI_ASSOC);
        foreach ($agregados as $item) {
          $sql2  = 'select avg(index_1) from 7distribuicao_individual di where niss =' . $item['niss'];
          $result2 = mysqli_query($conn, $sql2);
          $resumo = mysqli_fetch_all($result2, MYSQLI_ASSOC);
          $niss = $item['niss'];
          foreach ($resumo as $item2) :
            $idx = $item2['avg(index_1)'];
            $idx = number_format($idx, 2, '.', '');
            echo "<tr>
              <td>" . $niss . "</td>
              <td>" . $idx . "</td>
               </tr>";
          endforeach;
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