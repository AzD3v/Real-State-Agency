<?php


  $finalidade = $tipo_imovel = $ilha = $concelho = $freguesia = $tipologia =  $valor = $featured = $img = $morada = $descricao= "";
  $err_finalidade = $err_tipo_imovel = $err_ilha = $err_concelho = $err_freguesia = $err_tipologia = $err_featured = $err_img = $err_morada = $err_descricao ="";

  if ($_SERVER['REQUEST_METHOD']=='POST') {

   if (empty(trim($_POST['finalidade']))) {
      $err_finalidade = '';
    }else{
      $finalidade=$_POST['finalidade'];

    }

    if (empty(trim($_POST['tipo_imovel']))) {
       $err_tipo_imovel = '';
     }else{
       $tipo_imovel=$_POST['tipo_imovel'];

    }

    if (empty(trim($_POST['ilha']))) {
        $err_ilha = '';
    }else{
        $ilha=$_POST['ilha'];

    }

    if (empty(trim($_POST['concelho']))) {
         $err_concelho = '';
    }else{
         $concelho=$_POST['concelho'];

    }

    if (empty(trim($_POST['freguesia']))) {
         $err_freguesia = '';
    }else{
         $freguesia=$_POST['freguesia'];

    }

    if (empty(trim($_POST['tipologia']))) {
         $err_tipologia = '';
    }else{
         $tipologia=$_POST['tipologia'];

    }

    if (empty(trim($_POST['valor']))) {
         $err_valor = 'O imovel tem de ter um custo';
    }else{
         $valor=$_POST['valor'];

    }

    if (empty(trim($_POST['morada']))) {
         $err_morada = 'Tem de preencher a morada do imovel';
    }else{
         $morada=$_POST['morada'];

    }

    if (empty(trim($_POST['descricao']))) {
         $err_descricao = ' O imovel tem de ter uma descrição';
    }else{
         $descricao=$_POST['descricao'];

    }

    if (isset($_POST['featured'])) {
         $destaque="pendente";
    }else{
      $destaque="ndestaque";
    }

    if (empty(trim($err_finalidade)) && empty(trim($err_tipo_imovel)) && empty(trim($err_ilha)) && empty(trim($err_concelho)) && empty(trim($err_freguesia)) && empty(trim($err_tipologia))) {

      $id=1;
      //saber id imovel
      $file=fopen("../../data/imoveis.csv", "r");
      while(!feof($file)) {
        $data=fgetcsv($file,0,";");
        if ($data[0]=="") {
          break;
        }
        $id=$data[0]+1;
      }
      fclose($file);

      //registar idimovel e idgestor
      $file=fopen("../../data/imoveis.csv", "a");
      $dados = array($id, $_SESSION['admin'], $destaque);
      fputcsv($file, $dados, ";");
      fclose($file);

      //criar nova pasta para o p_imovel
      mkdir("../../imoveis/$id", 0777);
      $file=fopen("../../imoveis/$id/".$id."imovel.csv", "w");
      $estado="Disponível";

      $dados = array($id, $finalidade, $tipo_imovel, $ilha, $concelho, $freguesia, $tipologia, $valor ,$morada ,$descricao,$estado);
      fputcsv($file, $dados, ";");
      fclose($file);

      //adicionar img https://php.eduardokraus.com/upload-de-imagens-com-php http://itsolutionstuff.com/post/how-to-count-number-of-files-in-directory-phpexample.html
      for ($i=0; $i < count($_FILES['img']['tmp_name']) ; $i++) {
        $folderPath = "../../imoveis/$id";
        $countFile = count(scandir('../../imoveis/'.$id)) - 3;


        $destino = "../../imoveis/$id/" . "".$id."_".$countFile.".jpg";

        $arquivo_tmp = $_FILES['img']['tmp_name'][$i];

        move_uploaded_file( $arquivo_tmp, $destino );
      }


      echo "<script> alert('Imovel adicionado'); </script>";
      header("location:manager.php");





    }


  }


?>
