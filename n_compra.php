<?php

  session_start();
  include("assets/ficheiros.php");

  if (!isset($_SESSION['admin'])) {
    header("assets/location:../log_in.php");
  }

  if ($_SESSION['admin']==1) {
    header("location:index.php");
  }

  if($_SERVER['REQUEST_METHOD']=='GET'){
      //gurdar no array as caracteristicas do imovel e mudar para disponivel
      $file=fopen("imoveis/".$_GET['id']. "/".$_GET['id']."imovel.csv","r");
      $imovel=fgetcsv($file,0,";");
      fclose($file);
      $imovel[10]="Disponível";


      //retirar o ficheiro como vendido em vendas.csv
        $file=fopen("data/$filevendas", "r");
        while (!feof($file)) {
          $data=fgetcsv($file,0,";");
          if ($data[0]==$_GET['id']) {
            break 1;
          }
          $venda[]=$data;
        }
        fclose($file);




        $file=fopen("data/$filevendas", "w");
        foreach ($venda as $value) {
          fputcsv($file,$value,";");
        }
        fclose($file);

      //reescrever o imovel como Disponivel
      $file=fopen("imoveis/".$_GET['id']."/".$_GET['id']."imovel.csv","w");
      $imovel=fputcsv($file,$imovel,";");
      fclose($file);

      $file=fopen("data/$fileimoveis","r");
      while (!feof($file)) {
        $data=fgetcsv($file,0,";");
        if ($data[0]==$_GET['id']) {
          $data[2]="npendente";
        }
        $estado[]=$data;
      }
      $file=fopen("data/$fileimoveis","w");
      foreach ($estado as $value) {
        var_dump($value);
        fputcsv($file,$value,";");
      }
      fclose($file);

      header("location:p_imovel.php?id=".$_GET['id']);

  }



?>
