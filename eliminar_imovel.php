<?php
  include("assets/ficheiros.php");
  //retirar ficheiro csv do imovel
  unlink('imoveis/' . $_GET['id'] . '/' . $_GET['id'] . 'imovel.csv');
  $dir = opendir("imoveis/".$_GET['id']);
$i = 0;

//saber quantas imagens existem no ficheiro do imovel
$count= count(scandir('imoveis/'. $_GET['id'])) - 2;
$aux=0;
while ($count>$aux) {
  //retirar as imagens
  unlink('imoveis/' . $_GET['id'] .  '/' . $_GET['id'] . "_$aux.jpg");
  ++$aux;
}
//como pasta vazia retirar o diretório do imovel
rmdir("imoveis/".$_GET['id']);
//ler o ficheiro imoveis e guardando no array retirando o imovel em questao
  $i = 0;
  $file = fopen("data/$fileimoveis", 'r');
  while(!feof($file)) {

    $imovel = fgetcsv($file, 0, ';');

    if($imovel[0] != "") {
      if($imovel[0] != $_GET['id']) {

          $imovel_a_eliminar[$i] = $imovel;
          ++$i;
      }
    }
  }

  fclose($file);
  //reescrever ficheiro imoveis
  $file = fopen("data/$fileimoveis", 'w');
  foreach($imovel_a_eliminar as $key => $value) {

      fputcsv($file, $imovel_a_eliminar[$key], ';');

  }
  fclose($file);

  //eliminar visitas de visitas.csv com este imovel
  $visita_a_cancelar = [];
  $file = fopen("data/$filevisitas", 'r');
  while(!feof($file)) {

    $visita = fgetcsv($file, 0, ';');

    if($visita[0] != "") {
      if($visita[0] != $_GET['id']) {

        $visita_a_cancelar[] = $visita;

      }
    }
  }
  fclose($file);
  $file = fopen("data/$filevisitas", 'w');
  foreach($visita_a_cancelar as $key => $value) {

    fputcsv($file, $value, ';');

  }
  fclose($file);
  header("location:administrator/index.php");
?>
