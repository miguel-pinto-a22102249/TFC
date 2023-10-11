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

<?php
if (isset($_POST['export'])) {
  EXPORT_DATABASE($conn);
}
if (isset($_POST['import'])) {
  #ImportData($conn); 
  header("Location: ../src/form_import.php");
}
?>

<body>

  <?php include 'header.php'; ?>
  <main class="home2">
    <div class="home">
      <h1>Importação e Exportação de documentos</h1>
      <br>
      <form method="post">
        <input type="submit" class="btn btn-secondary" name="import" value="Import">
        <hr style="margin-top: 3vh">
        <br>
        <input type="submit" class="btn btn-secondary" name="export" value="Export">
      </form>
    </div>
  </main>
  <div class="novo">
    <h1>Novo período de distribuição</h1>
    <br>
    <button type="button" class="btn btn-danger"> <a style='text-decoration: none; color: white' href='form_novo.php'>Novo Período</a></button>
  </div>
  <?php include 'footer.php'; ?>

  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>