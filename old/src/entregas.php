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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
            <a class="nav-link active" aria-current="page" href="#">Entregas</a>
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
    <table class="table">
      <thead>
        <tr>
          <th>NISS</th>
          <th>Status</th>
          <th>Descrição</th>
          <th>Tipo</th>
          <th>Início</th>
          <th>Fim</th>
          <th> </th>
        </tr>
      </thead>

      <tbody>
        <?php
        $niss;
        $sql  = 'SELECT * from 8entrega';
        $result = mysqli_query($conn, $sql);
        $entrega = mysqli_fetch_all($result, MYSQLI_ASSOC);

        foreach ($entrega as $item) :
          $niss = $item['niss'];
          $descricao = $item['descricao'];
          if (strlen($descricao) == 0) {
            $descricao = "n/a";
          }
          echo "<tr>
            <td>" . $item["niss"] . "</td>
            <td>" . betterStatus($item["status"]) . "</td>
            <td>" . $descricao . "</td>
            <td>" . betterTipo($item["tipo_entrega"]) . "</td>
            <td>" . betterDate($item["data_inicio"]) . "</td>
            <td>" . betterDate($item["data_fim"]) . "</td>
            <td>
                <a  style='text-decoration: none; font-size: 2em' href='form_entrega.php?id={$niss}' <i class='fa fa-edit' style='font-size:36px'> </i> </a>
            </td>
             </tr>";
        endforeach;
        ?>
      </tbody>
    </table>
  </main>

  <?php include 'footer.php'; ?>

  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>