<?php

session_start();
include '../../assets/ficheiros.php';
if (!isset($_SESSION['admin'])) {
header("location:manager.php");
}

$file=fopen("../../data/$filevisitas", "r");
while (!feof($file)) {
  $data=fgetcsv($file, 0,";");
  if ($data[0]==$_GET['id']) {
    $data[6]="aceite";

  }
  $destaque[]=$data;
}
fclose($file);

$file=fopen("../../data/$filevisitas", "w");
  foreach ($destaque as $value) {
    fputcsv($file, $value,";");
  }
fclose($file);

header("location:manager.php");


?>
