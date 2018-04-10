<?php
  include('../assets/ficheiros.php');
  $validade=0;
  $filename_imoveis="../data/$fileimoveis";
  //verificar se o gestor tem imoveis em seu nome
  $file=fopen($filename_imoveis, "r");
  while (!feof($file)){
    $data=fgetcsv($file, 0, ";");
    if($data[1]==$_GET['id']){
      $validade=1;
    }
  }
  fclose($file);

  if ($validade!=1) {
    //se nao tem imoveis, elemina o gestor
  $file=fopen("../data/$filegestor", "r");
  while (!feof($file)) {
    $gestor=fgetcsv($file,0,";");
    if ($gestor[0]!=$_GET['id'] && !empty($gestor[0]) ) {
      $novosgestores[]=$gestor;
    }

  }

  fclose($file);


  $file=fopen("../data/$filegestor","w");

  foreach($novosgestores as $value) {
    fputcsv($file, $value , ";");
  }
  fclose($file);

  header("location:admin.php");
}else{
  header("location:admin.php?acao=gestor");
}

?>
