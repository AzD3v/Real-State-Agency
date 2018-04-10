<?php

  session_start();


  $num_destaques=0;

  $id=0;
  //ler os imoveis e verificar quantos existem em destaque
  $file=fopen('../data/imoveis.csv', "r");
  while(!feof($file) ) {
    $destaque[$id]=fgetcsv($file,0,";");
    if($destaque[$id][0]==$_GET['id']){
      $destaque[$id]=array($destaque[$id][0], $destaque[$id][1],"destaque");
      ++$num_destaque;
    }

    if($destaque[$id][2]=="destaque"){
      ++$num_destaque;

    }
    ++$id;
  }
  fclose($file);
  //se já existir 6 em destaque nao entra
  if ($num_destaque>7) {

    header("location:admin.php?acao=destaqueko");

  }else{
    //se existem menos que 6 reescreve o ficheiro colocando o imovel em destaque
    $file=fopen('../data/imoveis.csv', "w");
    $novoid=0;
    while($novoid<$id){
      fputcsv($file, $destaque[$novoid], ";");
      ++$novoid;
    }
    fclose($file);

    header("location:admin.php?acao=destaqueok");
}
?>
