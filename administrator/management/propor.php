<?php

session_start();
include '../../assets/ficheiros.php';
//verificar se existe sessão de admin
if (!isset($_SESSION['admin'])) {
header("location:manager.php");
}
//ler o ficheiro e mudar o imovel a propor
$file=fopen("../../data/$fileimoveis", "r");
while (!feof($file)) {
  $data=fgetcsv($file, 0,";");
  if ($data[0]==$_GET['id']) {
    $data[2]="pendente";

  }
  $destaque[]=$data;
}
fclose($file);
//reescrever o ficheiro csv com os novos valores
$file=fopen("../../data/$fileimoveis", "w");
  foreach ($destaque as $value) {
    fputcsv($file, $value,";");
  }
fclose($file);

header("location:manager.php?acao=destaque");

?>
