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
    $quantidade_form = [];
    if (isset($_GET['id'])) {
      $id = $_GET['id'];
      $sql  = 'SELECT * from 7distribuicao_individual WHERE niss =' . $id;
      $result = mysqli_query($conn, $sql);
      $quantidade_form = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    if (isset($_GET['id2'])) {
      $produto = $_GET['id2'];
      $sql2  = "select distinct p.produto_id as food from 5produto p inner join 7distribuicao_individual di on di.produto_id = p.produto_id
          where p.produto = '" . $produto . "'";
      $result2 = mysqli_query($conn, $sql2);
      $quantidade_form2 = mysqli_fetch_all($result2, MYSQLI_ASSOC);
    }
    if (isset($_GET['id3'])) {
      $antes = $_GET['id3'];
    }
    ?>
    <br>
    <h1 style="text-align: center;">Edição da Distribuição Individual do Agregado: <?php echo $id ?></h1>
    <h2 style="text-align: center;">Produto: <?php echo $produto ?></h1>
      <br>
      <form class="form-inline" action="process_form_qnt.php" method="post">

        <select hidden name="niss" id="niss">
          <option value=<?php echo $id ?> selected hidden> </option>
        </select>
        <select hidden name="produto_id" id="produto_id">
          <option value=<?php echo $quantidade_form2[0]['food'] ?> selected hidden> </option>
        </select>
        <select hidden name="antes" id="antes">
          <option value=<?php echo $antes ?> selected hidden> </option>
        </select>
        <br>
        <div class="form-group">
          <br>
          <div class='qnt'>
            <label for="descricao">Quantidade:</label>
            <?php echo "<textarea class='form-control' id='quantidade' name='quantidade' maxlength='10' rows='1'>" . $quantidade_form[0]["quantidade"] . "</textarea>" ?>
            <br>
            <button type="submit" class="btn btn-primary my-1">Submeter</button>
            <button type="button" onclick="location.href='distribuicao.php'" class="btn btn-secondary">Cancelar</button>
          </div>
        </div>
      </form>
  </main>

  <?php include 'footer.php'; ?>

  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>