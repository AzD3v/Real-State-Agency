<?php

  session_start();
  include("assets/ficheiros.php");

  if (!isset($_SESSION['admin'])) {
    header("location:../log_in.php");
  }

  if ($_SESSION['admin']==1) {
    header("location:index.php");
  }

  if($_SERVER['REQUEST_METHOD']=='GET'){

      $file=fopen("imoveis/".$_GET['id']. "/".$_GET['id']."imovel.csv","r");
      $imovel=fgetcsv($file,0,";");
      fclose($file);
      $imovel[10]="Vendido";

      if(!file_exists("data/$filevendas")){
        //criar ficheiro vendas caso não exista
        $file=fopen("data/$filevendas", "w");
        //insirir venda
        $data=array($_GET['id'],$_SESSION['admin'], $imovel[2] , $imovel[3], $imovel[4] , $imovel[5], $imovel[7], date("d"), date("m"), date("Y") );
        fputcsv($file, $data,";");
        fclose($file);

      }else{
        //inserir venda
        $file=fopen("data/$filevendas", "a");
        $data=array($_GET['id'],$_SESSION['admin'], $imovel[2] , $imovel[3], $imovel[4] , $imovel[5], $imovel[7], date("d"), date("m"), date("Y"));
        fputcsv($file, $data,";");
        fclose($file);

      }
      //mudar estado do imovel para vendido
      $file=fopen("imoveis/".$_GET['id']."/".$_GET['id']."imovel.csv","w");
      $imovel=fputcsv($file,$imovel,";");
      fclose($file);

      $file=fopen("data/$fileimoveis","r");
      while (!feof($file)) {
        $data=fgetcsv($file,0,";");
        if ($data[0]==$_GET['id']) {
          $data[2]="Vendido";
        }
        var_dump($data);
        $estado[]=$data;
      }
      fclose($file);

      $file=fopen("data/$fileimoveis","w");
      foreach ($estado as $key => $value) {

        $imovel=fputcsv($file,$value,";");
      }
      fclose($file);

      header("location:p_imovel.php?id=".$_GET['id']);

  }



?>
