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

  <main style="margin: 50px;">
    <?php
    $entrega_form = [];
    if (isset($_GET['id'])) {
      $id = $_GET['id'];
      $sql  = 'SELECT * from 8entrega WHERE niss =' . $id;
      $result = mysqli_query($conn, $sql);
      $entrega_form = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    ?>
    <br>
    <h1 style="text-align: center;">Entrega do Agregado: <?php echo $id ?></h1>
    <br>
    <form class="form-inline" action="process_form_entrega.php" method="post">
      <label class="my-1 mr-2" for="tipo">Tipo de Entrega:</label>
      <select class="custom-select my-1 mr-sm-2" name="tipo" id="tipo">
        <option disabled>Selecione</option>
        <option value="0" <?php if ($entrega_form[0]["tipo_entrega"] == 0)  echo 'selected="selected"'; ?>>Instituição</option>
        <option value="1" <?php if ($entrega_form[0]["tipo_entrega"] == 1)  echo 'selected="selected"'; ?>>Local 1</option>
        <option value="2" <?php if ($entrega_form[0]["tipo_entrega"] == 2)  echo 'selected="selected"'; ?>>Local 2</option>
      </select>
      <select hidden name="niss" id="niss">
        <option value=<?php echo $id ?> selected hidden> </option>
      </select>
      <br>
      <label class="my-1 mr-2" for="status">Estado:</label>
      <select class="custom-select my-1 mr-sm-2" name="status" id="status">
        <option disabled>Selecione</option>
        <option value="0" <?php if ($entrega_form[0]['status'] == 5)  echo 'selected = "selected"'; ?>>Entregue</option>
        <option value="1" <?php if ($entrega_form[0]['status'] == 1)  echo 'selected = "selected"'; ?>>Pendente</option>
        <option value="2" <?php if ($entrega_form[0]['status'] == 2)  echo 'selected = "selected"'; ?>>Cancelada</option>
      </select>
      <div class="form-group">
        <br>
        <label for="descricao">Descrição:</label>
        <?php echo "<textarea class='form-control' id='descricao' name='descricao' rows='3'>" . $entrega_form[0]["descricao"] . "</textarea>" ?>
      </div>
      <br>
      <button type="submit" class="btn btn-primary my-1">Submeter</button>
      <button type="button" onclick="location.href='entregas.php'" class="btn btn-secondary">Cancelar</button>
    </form>
  </main>

  <?php include 'footer.php'; ?>

  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>