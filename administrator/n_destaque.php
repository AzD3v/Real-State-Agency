<?php

  session_start();
  include('../assets/ficheiros.php');

  if (isset($_SESSION['admin'])&&$_SESSION['admin']!=1) {
    header("location:log_in.php");
  }

  $id=0;
  //ver o ficheiro mudando o imovel selecionado para nao pendente
  $file=fopen("../data/$fileimoveis", "r");
  while(!feof($file) ) {
    $destaque[$id]=fgetcsv($file,0,";");
    if($destaque[$id][0]==$_GET['id']){
      $destaque[$id]=array($destaque[$id][0], $destaque[$id][1],"npendente");
    }
    ++$id;
  }
  fclose($file);

  //reescrever ficheiro
  $file=fopen("../data/$fileimoveis", "w");
  $novoid=0;
  while($novoid<$id){
    fputcsv($file, $destaque[$novoid], ";");
    ++$novoid;
  }
  fclose($file);

  header("location:admin.php");

?>
