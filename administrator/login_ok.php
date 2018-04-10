<?php
  include('../assets/ficheiros.php');
  //definir variaveis que vão guardar os valores do formulario
  $username = $password =  "";
  //definir variavei de erro
  $err_username = $err_password  = "";
  //verificar se houver um reques via post
  if ($_SERVER['REQUEST_METHOD']=='POST') {
    //header('location: index.php');

    if (!empty(trim($_POST['user']))) {
      $username=$_POST['user'];
    }

    if (!empty(trim($_POST['password']))) {
      $password=$_POST['password'];
    }

    //verificar se existe um utilizador com este username e password
    if(empty($err_mail) && empty($err_password)){
      $filename="../data/$filegestor";
        $file= fopen($filename,"r");
        while(!feof($file)){
          $user=fgetcsv($file,0,";");
          if ($username == $user[1] && $password==$user[2]){
            $err_username="Login bem sucedido";
            fclose($file);
            session_start();
            $_SESSION['admin']=$user[0];
            if($_SESSION['admin']==1){
              header('location:admin.php?acao=ok');
            }else{
              header('location:management/manager.php?acao=ok');
            }
          }
        }

    }else{
      header('location:log_in.php');
    }
    header('location:log_in.php');
  }
  header('location:log_in.php');


?>
