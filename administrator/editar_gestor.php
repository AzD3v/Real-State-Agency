<?php

  session_start();
  include('../assets/ficheiros.php');

  if (!isset($_SESSION['admin'])){

    header("location:index.php");
  }

  if($_SESSION['admin']!=1){
    header('location:management/manager.php?');
  }

    if ($_SERVER['REQUEST_METHOD']=='GET') {
      $file=fopen("../data/$filegestor","r");
      while (!feof($file)) {
        $gestor=fgetcsv($file,0,";");
        if ($gestor[0]==$_GET['id']) {
          break;
        }
        if ($gestor[0]=="") {
          header("location:admin.php");
        }
      }
  fclose($file);
  }

  if ($_SERVER['REQUEST_METHOD']=='POST') {
  //definir variaveis que vão guardar os valores do formulario
  $nome = $username = $password = $retype = "";
  $id=0;
  //definir variavei de erro
  $err_nome = $err_username = $err_password = "";
  //verificar se houver um reques via post
    //header('location: index.php');
  if (empty(trim($_POST['nome']))) {
    $err_nome = 'O nome tem de ser preenchido';
  }else{

    $nome=$_POST['nome'];

  }


  if (empty(trim($_POST['username']))) {
    $err_username = 'O nome de utilizador tem de ser preenchido';
  }else{

    $username=$_POST['username'];

  }

  if (empty(trim($_POST['password']))) {
    $err_password = 'A password tem de ser preenchido';
  }else{

    $password=$_POST['password'];

  }

  if (empty(trim($_POST['retype']))) {
    $err_password = 'A password tem de ser preenchido';
  }else{

    $retype=$_POST['retype'];

  }



  //verificar se a palavra-passe tem um minimo de 8 caracteres
  if(!empty($password) && strlen($password) < 8 ){
    $err_password = 'A password tem de ter um minimo de 8 caracteres';
    $retype = $password = "";
  }

  //verifica se palavra-pass e a de confirmação são diferentes
  if(empty($err_password) && $password != $retype ){
    $err_password = 'A password e a de confirmação deverão ser iguais';
    $retype = $password = "";
  }

  //verificar se existe um utilizador com este username e fazer array editado para reescrever ficheiro
  if(empty($err_username)){
    $filename="../data/$filegestor";
      $file= fopen($filename,"r");
      while(!feof($file)){
        $novo_gestor=fgetcsv($file,0,";");
        if ($novo_gestor[0]=="") {
          break;
        }
        if ($novo_gestor[0]==$_POST['id']) {
          $novo_gestor[3]=$nome;
          $novo_gestor[1]=$username;
          $novo_gestor[2]=$password;
        }
        $gestores[]=$novo_gestor;

        if ($username == $gestor[2]) {
            $err_username="Nome de utilizador já em uzo";
            $username="";
            fclose($file);
            break;
        }
      }
    }
    //reescrever ficheiro
    if (empty($err_nome) && empty($err_username) && empty($err_password)) {
      $file=fopen("../data/$filegestor", "w");
      foreach ($gestores as $value) {
        fputcsv($file, $value, ";");
      }
    }
    header("location:admin.php");
  }



?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Site name</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" media='screen and (min-width: 260px) and (max-width: 767px)' href="../css/mobile.css"/>
    <link rel="stylesheet" media='screen and (min-width: 768px) and (max-width: 1100px)' href="../css/tablet.css"/>
    <link rel="stylesheet" media='screen and (min-width: 1101px)' href="../css/desktop.css"/>
    <link href="https://fonts.googleapis.com/css?family=Roboto+Mono" rel="stylesheet">
  </head>
  <body>
    <div class="nav_box">
      <div class="logo_box">
        <a href="../index.php"><img src="../images/logo.png" alt=""></a>
      </div>
      <div class="backend_admin">
        <h1>Administração</h1>
      </div>
      <div class="user_box">
        <a href="?acao=logout"><button id="modalBtn1" class="user_status">logout</button></a>
      </div>
    </div>
    <div class="admin_container">
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
      <h1>Editar Gestor</h1>
      <form class="add_manager" action="" method="post">
        Nome:<input type="text" name="nome" value="<?php echo $gestor[3]; ?>"><br>
        Username:<input type="text" name="username" value="<?php echo $gestor[1]; ?>"><br>
        Password<input type="password" name="password" value="<?php echo $gestor[2]; ?>"><br>
        Confirmar Password:<input type="password" name="retype" value="<?php echo $gestor[2]; ?>"><br>
        <input type="hidden" name="id" value="<?php echo $gestor[0]; ?>">
        <input type="submit" value="Editar Gestor">
      </form>
    </div>
</body>
</html>
