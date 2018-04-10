<?php
  session_start();
  include('../assets/ficheiros.php');
  if (isset($_SESSION['admin'])) {
    header("location:admin.php");
  }

  //criar ficheiro gestores caso nao exista
  if (!file_exists("../data/$filegestor")) {
    $file=fopen("../data/$filegestor","w");
    $data=array(1,"admin", "admin123", "nomeadmin");
    fputcsv($file,$data,";");
    fclose($file);
  }


?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Login Administração</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" media='screen and (min-width: 260px) and (max-width: 767px)' href="../css/mobile.css"/>
    <link rel="stylesheet" media='screen and (min-width: 768px) and (max-width: 1100px)' href="../css/tablet.css"/>
    <link rel="stylesheet" media='screen and (min-width: 1101px)' href="../css/admin_desktop.css"/>
    <link href="https://fonts.googleapis.com/css?family=Roboto+Mono" rel="stylesheet">
  </head>
  <body>
    <div class="backend_container">
      <form class="log_in_backend" action="login_ok.php" method="post">
        <h1 class="titulo_geral titulo_login_backend text-center">Login Administração</h1>
        <label for="">Username: <input class="login_backend" type="text" name="user"/></label>
        <label for="">Password: <input class="login_backend" type="password" name="password"/></label>
        <input class="iniciar_backend" type="submit" name="" value="Iniciar sessão">
      </form>
    </div>
  </body>
</html>
