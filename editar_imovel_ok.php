<?php

    $id = $finalidade = $tipo = $slct1 = $slct2 = $slct3 = $tipologia = $preco = $descricao = "";
    $erro="";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        //header('location: index.php');
      if (!empty(trim($_POST['id']))) {

          $id=$_POST['id'];

      } else {

          $erro="erro";

      }

      if (!empty(trim($_POST['finalidade']))) {

          $finalidade=$_POST['finalidade'];

      } else {

          $erro="erro";

      }

      if (!empty(trim($_POST['tipo']))) {

          $tipo=$_POST['tipo'];

      } else {

          $erro="erro";

      }
      if (!empty(trim($_POST['slct1']))) {

          $slct1=$_POST['slct1'];

      } else {

          $erro="erro";

      }
      if (!empty(trim($_POST['slct2']))) {

          $slct2=$_POST['slct2'];

      } else {

          $erro="erro";

      }
      if (!empty(trim($_POST['slct3']))) {

          $slct3=$_POST['slct3'];

      } else {

          $erro="erro";

      }
      if (!empty(trim($_POST['tipologia']))) {

          $tipologia=$_POST['tipologia'];

      } else {

          $erro="erro";

      }
      if (!empty(trim($_POST['preco']))) {

          $preco=$_POST['preco'];

      } else {

          $erro="erro";

      }
      if (!empty(trim($_POST['descricao']))) {

          $descricao=$_POST['descricao'];

      } else {

          $erro="erro";

      }
      if (isset($_POST['estado']) && $_POST['estado']=="Disponível") {
        $estado="Disponível";
      }else{
        $estado="Vendido";
      }

    }
    // //adicionar imagens
    // if (!empty($_FILES)) {
    //   for ($i=0; $i < count($_FILES['img']['tmp_name']) ; $i++) {
    //     $folderPath = "../../imoveis/$id";
    //     $countFile = count(scandir('../../imoveis/'.$id)) - 2;
    //
    //
    //     $destino = "../../imoveis/$id/" . "".$id."_".$countFile.".jpg";
    //
    //     $arquivo_tmp = $_FILES['img']['tmp_name'][$i];
    //
    //     move_uploaded_file( $arquivo_tmp, $destino );
    //   }
    // }

    //editar o imovel
    if (empty(trim($erro))) {
      $imovel = array($id, $finalidade, $tipo, $slct1 , $slct2, $slct3, $tipologia, $preco, $moradia, $descricao, $estado);
      $file = fopen("imoveis/" . $_POST['id'] . "/" . $_POST['id'] . "imovel.csv", 'w');
      fputcsv($file, $imovel, ';');
      fclose($file);
      header("Location:p_imovel.php?id=" . $_POST['id']);
    }header("Location:edicao_imovel.php?id=" . $_POST['id']);

?>
