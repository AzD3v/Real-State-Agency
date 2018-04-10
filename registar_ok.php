<?php include("assets/ficheiros.php"); ?>

<?php

    //definir variáveis que irão guardar os valores do formulario
    $nome = $apelido = $mail = $password = $retype = $numero = $ilha = $concelho = $freguesia = "";
    $id=0;

    // definir variável de erro
    $err_nome = $err_username = $err_password = $err_numero = $err_ilha = $err_concelho = $err_freguesia  = "";

    // verificar se houver um request via post
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      //header('location: index.php');
    if (empty(trim($_POST['nome']))) {

        $err_nome = 'O nome e o apelido deverão ser preenchidos';

    } else {

        $nome=$_POST['nome'];

    }

    if (empty(trim($_POST['sobrenome']))) {

        $err_nome = 'Os campos de nome e apelido deverão ser preenchidos';

    } else {

        $apelido = $_POST['sobrenome'];

    }

    if (empty(trim($_POST['mail']))) {

        $err_username = 'O campo de email deverá ser preenchido';

    } else {

        $mail = $_POST['mail'];

    }

    if (empty(trim($_POST['password']))) {

        $err_password = 'O campo de password terá que ser preenchido';

    } else {

        $password = $_POST['password'];

    }

    if (empty(trim($_POST['retype']))) {

        $err_password = 'O campo de password terá que ser preenchido';

    } else {

      $retype = $_POST['retype'];

    }

    if (empty(trim($_POST['numero']))) {

        $err_numero = 'O campo de contacto terá de ser preenchido';

    } else {

      $numero = $_POST['numero'];

    }

    if ($_POST['ilha'] == "") {

        $err_ilha = 'Terá que escolher uma ilha e em seguida um concelho e freguesia';

    } else {

      $ilha = $_POST['ilha'];

    }

    if ($_POST['concelho'] == 'Concelho') {

      $err_concelho = 'Terá que escolher um concelho';

    } else {

      $concelho = $_POST['concelho'];

    }

    if ($_POST['freguesia'] == 'Freguesia') {
      $err_freguesia = 'Terá que escolher uma freguesia';

    } else {

      $freguesia = $_POST['freguesia'];

    }


    // Verifica se a palavra-passe tem um minimo de 8 caracteres
    if(!empty($password) && strlen($password) < 8 ){
      $err_password = 'A password tem de ter um minimo de 8 caracteres';
      $retype = $password = "";
    }

    // Verifica se palavra-passe e a de confirmação são diferentes
    if(empty($err_password) && $password != $retype ){
      $err_password = 'A password e a de confirmação deverão ser iguais';
      $retype = $password = "";
    }

    //verificar se o contacto tem 9 numeros
    //if(strlen($numero) != 9 ){
      //$err_numero = 'Numero incorreto';
      //$numero = "";
    //}


    // Verifica se já existe um utilizador com este username
    if(empty($err_username)){
      $filename="data/$filecliente";
      if(!file_exists($filename)){
        $file = fopen($filename, "w");
        fclose($file);

      } else {

        $file= fopen($filename,"r");
        while(!feof($file)){
          $user=fgetcsv($file, 0, ";");
          if ($user[0]=="") {
            ++$id;
            break;
          }
          $id=$user[0];
          if ($mail == $user[3]) {
            $err_username="Email já em uso";
            $mail="";
            fclose($file);
            break;
          }
        }
      }
    }

    //verifica um novo utilizador pode ser registado
    if (empty($err_nome) && empty($err_username) && empty($err_password) && empty($err_numero) && empty($err_ilha) && empty($err_concelho) && empty($err_freguesia)) {
      $file = fopen($filename,"a");
      $dados = array($id, $nome, $apelido, $mail, $password, $numero, $ilha, $concelho, $freguesia);
      fputcsv($file, $dados, ";");
      fclose($file);
      $_SESSION['cliente']=$id;
      echo "<script>alert('Foi registado com sucesso');</script>";
      header('location: index.php');
      //fwrite($file, $nome.";".$apelido.";".$username.";".$password."; \n\r")
      }
    }else{
      //header('location: index.php');
    }
?>
