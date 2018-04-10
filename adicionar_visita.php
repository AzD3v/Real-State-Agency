<?php

  session_start();
  include 'assets/ficheiros.php';

  if($_SERVER['REQUEST_METHOD']=='POST'){
    $id=1;
    //ler o ficheiro para saber o id da proxima visita
    $file=fopen("data/$filevisitas", "r");
    while (!feof($file)) {
      $data=fgetcsv($file,0,";");
      if ($data[0]=="") {
        break;
      }
      $id=$data[0]+1;

    }
    fclose($file);
    //insirir visita
    $data = array($id, $_SESSION['cliente'], $_POST["id_imovel"], $_POST["id_gestor"], $_POST["data"], $_POST["hora"],"pendente");
    $file=fopen("data/$filevisitas","a");
    fputcsv($file, $data , ";" );
    fclose($file);
    header("location:p_imovel.php?id=".$_POST['id_imovel']);

  }else{
    header("location:index.php");
  }

?>
