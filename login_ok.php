<?php
    include("assets/ficheiros.php");
    //definir variaveis que vão guardar os valores do formulario
    $username = $password =  "";
    //definir variavei de erro
    $err_username = $err_password  = "";
    //verificar se houver um reques via post
    if ($_SERVER['REQUEST_METHOD']=='POST') {
      //header('location: index.php');

      if (!empty(trim($_POST['mail']))) {
        $mail=$_POST['mail'];
      }

      if (!empty(trim($_POST['password']))) {
        $password=$_POST['password'];
      }

      //verificar se existe um utilizador com este username e password
      if(empty($err_mail) && empty($err_password)){
        if(!file_exists("data/$filecliente")){
          echo "nãp entrou";
        }else{
          $file= fopen("data/$filecliente","r");
          while(!feof($file)){
            $user=fgetcsv($file,0,";");
            if ($mail == $user[3] && $password==$user[4]){
              $err_username="Login bem sucedido";
              fclose($file);
              session_start();
              $_SESSION['cliente']=$user[0];
              break;
              header('location:index.php?acao=ok');
            }
          }
        }
      }

    header('location:index.php?acao=ko');
  }else{
    header('location:index.php?acao=ko');
  }


?>
