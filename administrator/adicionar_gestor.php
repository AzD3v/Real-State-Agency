<?php

    
    //definir variaveis que vão guardar os valores do formulario
    $nome = $username = $password = $retype = "";
    $id=0;
    //definir variavei de erro
    $err_nome = $err_username = $err_password = "";
    //verificar se houver um reques via post
  if ($_SERVER['REQUEST_METHOD']=='POST') {
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

    //verificar se existe um utilizador com este username
    if(empty($err_username)){
      $filename="../data/$filegestor";
      if(!file_exists($filename)){
        $file = fopen($filename, "w");
        fclose($file);
      }else{

        $file= fopen($filename,"r");
        while(!feof($file)){
          $user=fgetcsv($file,0,";");
          if ($user[0]=="") {
            ++$id;
            break;
          }
          $id=$user[0];
          if ($username == $user[2]) {
            $err_username="Nome de utilizador já em uzo";
            $username="";
            fclose($file);
            break;
          }
        }
      }
    }

    //verifica se pode registar um novo utilizador
    if (empty($err_nome) && empty($err_username) && empty($err_password)) {
      $file = fopen($filename,"a");
      $users=fgetcsv($file,0,";");
      $dados = array($id, $username, $password, $nome);
      fputcsv($file, $dados, ";");
      fclose($file);
      echo "<script>window.alert('Foi registado com sucesso');</script>";
      }
    }
?>
