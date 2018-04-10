<?php

    if(isset($_GET['id'])) {

        $id = $_GET['id'];

    }
    //mudar o imovel e colocá-lo como comprado
    $file = fopen('imoveis/' . $id . '/' . $id . "imovel.csv", 'r');
    $estado = fgetcsv($file , 0, ';');
    fclose($file);
    $estado[9] = "Comprado";
    $file = fopen('imoveis/' . $id . '/' . $id . 'imovel.csv', 'w');
    fputcsv($file, $estado, ';');
    fclose($file);
    //ler ficheiro vendas
    $file = fopen('data/vendas.csv', 'r');
    while (!feof($file)) {
      $data=fgetcsv($file,0,";")
      if ($data[0]==$id) {
        break 1;
      }
      $vendas[]=$data;
    }
    fclose($file);
    //reescrever ficheiro vendas
    $file = fopen('data/vendas.csv', 'w');
    fputcsv($file, $estado, ';');
    foreach ($venda as $value) {
      fputcsv($file,$value,";")
    }
    fclose($file);


    header("location:p_imovel.php?id=$id");

?>
