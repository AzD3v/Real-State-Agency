<?php session_start(); ?>
<?php include("assets/ficheiros.php"); ?>
<?php include("assets/logout.php"); ?>

<?php

  // Login de clientes
  if (isset($_GET['acao']) && ($_GET['acao']=='ok')) {

      echo "<script>alert('Login bem sucedido');</script>";
      header("Location:index.php");

  }

  // Login da administração
  if (isset($_SESSION['admin'])) {

    $ver = 0;

    $file = fopen("data/$fileimoveis","r");

      while (!feof($file)) {

        $gestor=fgetcsv($file,0,";");

     /* O imóvel é preocurado e verifica-se se o ID do gestor
     é igual ao que se encontra com a sessão iniciada */
     if ($gestor[1] == $_SESSION["admin"] && $gestor[0] == $_GET["id"]) {
       // Caso a condição seja retorna verdadeira, a sessão é valida
       $ver = 1;
       // O ciclo é quebrado
       break;
     }
  }
  fclose($file);
}

  /* As informações do imóvel em questão são apresentadas e o ficheiro
  é aberto */
  $id = $_GET["id"];

  if(!file_exists("imoveis/$id/". $id . "imovel.csv")) {

      header("location:index.php");

  }

  $file = fopen("imoveis/$id/" . $id . "imovel.csv", "r");

    while(!feof($file)) {

      $imovel = fgetcsv($file, 0, ";");

      if ($imovel[0] == $_GET['id']) {

          fclose($file);
          break;

      }
   }

  // O ficheiro referente à gestão dos imóveis é aberto
  $file = fopen("data/$fileimoveis", "r");

    while(!feof($file)) {

      $gest_imovel = fgetcsv($file, 0, ";");

        if ($gest_imovel[0] == $_GET['id']) {

        fclose($file);

        break;

        }
    }

  // O ficheiro com as informações do gestor é aberto
  $file = fopen("data/$filegestor", "r");

    while(!feof($file)) {

      $gestor = fgetcsv($file, 0, ";");

        if ($gestor[0] == $gest_imovel[1]) {

        fclose($file);

        break;

        }
      }

      // Criação de uma quebra de linha (muda ";" por ";<br>)
      $imovel[9] = str_replace(";", ";<br>", $imovel[9]);

?>

<!DOCTYPE html>
<html lang="pt">

  <head>

    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Folhas de estilo utlizadas -->
    <link rel="stylesheet" media='screen and (min-width: 260px) and (max-width: 767px)' href="css/mobile.css"/>
    <link rel="stylesheet" media='screen and (min-width: 768px) and (max-width: 1100px)' href="css/tablet.css"/>
    <link rel="stylesheet" media='screen and (min-width: 1101px)' href="css/desktop.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

    <!-- Font Awesome -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.4/js/all.js"></script>

    <!-- Título da página -->
    <title>Azores Property | Perfil imóvel</title>

  </head>

  <body>

    <!-- Header -->
    <div class="nav_box">
      <div class="logo_box">
        <a href="index.php"><img src="images/logo.png" alt=""></a>
      </div>

      <!-- Zona de pesquisa -->
      <div class="search_box">
        <form class="search_input" action="listagem.php" method="GET">
            <input class="caixa_pesquisa" type="search" name="search" placeholder="O que procura exatamente?">
            <input class="botao_pesquisa" type="submit" name="" value="Efetuar pesquisa avançada ">
        <div class="search_filter">
          <img id="icon_filter" src="images/icons/icon_down.png" alt="Abrir pesquisa detalhada"/>
          <img id="icon_filter1" src="images/icons/icon_up.png" alt="Fechar pesquisa detalhada"/>
          <div id="open_filter" class="search_filters_box">
        <div class="search_filters">

          <!-- Opções de pesquisa avançada -->
          <!-- Finalidade -->
          <select class="selection opcoes" name="finalidade">
            <option value="finalidade">A sua finalidade:</option>
            <option value="comprar">Comprar</option>
            <option value="arrendar">Arrendar</option>
          </select>

          <!-- Tipo de imóvel procurado -->
          <select class="selection opcoes" name="tipo_de_imovel" id="tipo_de_imovel" onchange="functionTipologia(this.id, 'tipologia')">
            <option value="tipo">O tipo de imóvel que procura:</option>
            <option value="Terreno">Terreno</option>
            <option value="Apartamento">Apartamento</option>
            <option value="Moradia">Moradia</option>
            <option value="Quinta">Quinta</option>
          </select>

          <!-- Tipologia do imóvel procurado -->
          <select class="selection opcoes" name="tipologia"  id="tipologia">
            <option value="">Tipologia do imóvel desejado:</option>
            <option value="T0">T0</option>
            <option value="T1">T1</option>
            <option value="T2">T2</option>
            <option value="T3">T3</option>
            <option value="T4">T4</option>
            <option value="T5+">T5+</option>
          </select>

          <!-- Ilha do imóvel procurado -->
            <select class="selection opcoes" name="ilha" id="ilha" onchange="functionConcelho(this.id,'concelho') ">
            <option value="">Ilha em que procura:</option>

            <?php

            $file = fopen("data/pesquisa/ilha.csv", "r");

            while (!feof($file)) {

              $ilha = fgetcsv($file, 0, ";");

                if($ilha[0]=="")
                break;

                echo '<option value="'.$ilha[1].'">'.$ilha[0].'</option>';
            }

            fclose($file);

            ?>

          </select>

          <!-- Concelho do imóvel procurado -->
          <select class="selection opcoes" name="concelho" id="concelho" onchange="functionFreguesia(this.id,'freguesia')">
            <option value="arrendar">Concelho em que procura:</option>
          </select>

          <!-- Freguesia do imóvel procurado -->
          <select class="selection opcoes" name="freguesia" id="freguesia" >
            <option value="arrendar">Freguesia em que procura:</option>
          </select>

          <!-- Valor mínimo do imóvel procurado -->
          <select class="selection opcoes" name="valor_minimo">
            <option value="">Preço mínimo desejado:</option>
            <option value="5000">5.000€</option>
            <option value="10000">10.000€</option>
            <option value="20000">20.000€</option>
            <option value="30000">30.000€</option>
            <option value="40000">40.000€</option>
            <option value="50000">50.000€</option>
            <option value="60000">60.000€</option>
            <option value="70000">70.000€</option>
            <option value="70000">80.000€</option>
            <option value="90000">90.000€</option>
            <option value="100000">100.000€</option>
            <option value="110000">110.000€</option>
            <option value="120000">120.000€</option>
            <option value="130000">130.000€</option>
            <option value="140000">140.000€</option>
            <option value="150000">150.000€</option>
            <option value="160000">160.000€</option>
            <option value="170000">170.000€</option>
            <option value="180000">180.000€</option>
            <option value="190000">190.000€</option>
            <option value="200000">200.000€</option>
            <option value="250000">250.000€</option>
            <option value="300000">300.000€</option>
            <option value="350000">350.000€</option>
            <option value="400000">400.000€</option>
            <option value="450000">450.000€</option>
            <option value="500000">500.000€</option>
            <option value="600000">600.000€</option>
            <option value="700000">700.000€</option>
            <option value="800000">800.000€</option>
            <option value="900000">900.000€</option>
            <option value="1000000">1.000.000€</option>
          </select>

          <!-- Valor máximo do imóvel procurado -->
          <select class="selection opcoes" name="valor_maximo">
            <option value="">Preço máximo desejado:</option>
            <option value="10000">10.000€</option>
            <option value="15000">15.000€</option>
            <option value="20000">20.000€</option>
            <option value="25000">25.000€</option>
            <option value="30000">30.000€</option>
            <option value="35000">35.000€</option>
            <option value="40000">40.000€</option>
            <option value="45000">45.000€</option>
            <option value="50000">50.000€</option>
            <option value="60000">60.000€</option>
            <option value="70000">70.000€</option>
            <option value="80000">80.000€</option>
            <option value="90000">90.000€</option>
            <option value="100000">100.000€</option>
            <option value="120000">120.000€</option>
            <option value="140000">140.000€</option>
            <option value="160000">160.000€</option>
            <option value="180000">180.000€</option>
            <option value="200000">200.000€</option>
            <option value="240000">240.000€</option>
            <option value="260000">260.000€</option>
            <option value="300000">300.000€</option>
            <option value="320000">320.000€</option>
            <option value="340000">340.000€</option>
            <option value="360000">360.000€</option>
            <option value="380000">380.000€</option>
            <option value="400000">400.000€</option>
            <option value="440000">440.000€</option>
            <option value="480000">480.000€</option>
            <option value="520000">520.000€</option>
            <option value="580000">580.000€</option>
            <option value="620000">620.000€</option>
            <option value="660000">660.000€</option>
            <option value="700000">700.000€</option>
            <option value="750000">750.000€</option>
            <option value="800000">800.000€</option>
            <option value="850000">850.000€</option>
            <option value="900000">900.000€</option>
            <option value="950000">950.000€</option>
            <option value="1000000">1.000.000€</option>
            <option value="2000000">2.000.000€</option>
            <option value="3000000">3.000.000€</option>
            <option value="">+5.000.000€</option>
          </select>
        </div>

          <!-- Botão que permite filtrar os resultados -->
          <button type="button" id="btn_filter" name="filter"><img src="images/icons/filter.png"/>Filtrar resultados</button>

        </div>
      </div>
    </form>
  </div>

      <!-- Login e registo tanto para o lado do cliente como para o lado do servidor -->
      <div class="user_box">

      <?php

      /* Caso o utilizador seja um cliente,
      * o seguinte bloco de código é ativado e
      * o utlizador entra no seu perfil de cliente */
      if (isset($_SESSION['cliente'])){

        ?>

          <a href="area_cliente.php"><button class="user_status verificar_visitas">Verificar visitas</button></a>
          <a href="editar_cliente.php"><button class="user_status">Editar dados</button></a>
          <a href="?acao=logout"><button class="user_status">Logout</button></a>

        <?php

        /* Caso o utilizador faça parte da administração,
        * o seguinte bloco de código é ativado e o utilizador
        * entra na área administrativa */
      } elseif(isset($_SESSION['admin'])) {

        ?>

        <a href="administrator/log_in.php"><button  class="user_status">Área Administrativa</button></a>
        <a href="administrator/admin.php?acao=logout"><button class="user_status logout_admin">Logout</button></a>

        <?php

      /* Caso o utilizador não se encontre com sessão iniciada no website
      * ou não possua conta é apresentado com as opções predefinidas de Login
      * e Registo */
      } else {

        ?>

        <div class="login_registo">
          <button id="modalBtn" class="user_status">Login</button>
          <a href="registar.php"><button id="registarBtn" class="user_status">Registo</button></a>

      <?php } ?>

      </div>
    </div>

      <!-- Módulo de Login -->
      <div id="modal" class="modal">

        <div class="modal-content">

          <div class="modal_header">
              <h2>Acesso à área de cliente</h2>
              <span class="closeBtn">&times;</span>
          </div>

          <div class="modal_body">
            <form class="login" action="login_ok.php" method="post">
              <input type="email" name="mail" placeholder="Introduza o seu email">
              <input type="password" name="password" placeholder="Introduza a sua palavra-passe">
              <input type="submit" value="Iniciar sessão">
            </form>

          <div class="modal_footer">
            <h3>Ainda não possui conta? <a class="opcao_registo" href="registar.php">Registe-se agora!</a></h3>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="nav_holder"></div>

  <!-- Perfil do imóvel -->

  <div class="p_imovel">

    <?php

      $file_ilha=fopen("data/pesquisa/ilha.csv","r");
      while (!feof($file_ilha)) {
        $data_ilha=fgetcsv($file_ilha,0,";");
        if ($data_ilha[1]==$imovel[3]) {
          break;
        }
      }
      fclose($file_ilha);
      $file_concelho=fopen("data/pesquisa/concelho/".trim($data_ilha[1]).".csv","r");
      while (!feof($file_concelho)) {
        $data_concelho=fgetcsv($file_concelho,0,";");
        if (trim($data_concelho[1])==trim($imovel[4])) {
          break;
        }
      }
      fclose($file_concelho);
      $file_freguesia=fopen("data/pesquisa/freguesia/".trim($data_concelho[1]).".csv","r");
      while (!feof($file_freguesia)) {
        $data_freguesia=fgetcsv($file_freguesia,0,";");
        if (trim($data_freguesia[1])==trim($imovel[5])) {
          break;
        }
      }
      fclose($file_freguesia);

    ?>
  <div class="text-center titulo_geral titulo_perfil">
    <h1><?php echo "$imovel[2] - $imovel[6] - $data_ilha[0] - $data_concelho[0] - $data_freguesia[0]"; ?></h1>
  </div>

  <!-- Imagem/cartão do imóvel -->

  <div class="imovel-container">

    <div class="cartao">

    <div class="front"><img class="img-imovel" src="imoveis/<?php echo $id; ?>/<?php echo $id; ?>_0.jpg"></div>

    <div class="back">

      <div class="cartao_icons">
        <a href="#galeria"><i class="fas fa-camera cartao_icon"></i></i></a>
        <a href="#"><i class="fab fa-facebook  cartao_icon"></i></a>
        <a href="#"><i class="fab fa-twitter-square  cartao_icon"></i></a>
        <a href="#"><i class="fab fa-instagram  cartao_icon"></i></a>
        <a href="#"><i class="fab fa-google-plus cartao_icon cartao_icon_down"></i></a>
        <a href="#"><i class="fas fa-envelope-square cartao_icon cartao_icon_down"></i></a>

     </div>
    </div>
   </div>
  </div>

 <!-- Informações acerca do imóvel -->

 <h1 class="titulo_geral_secundario text-center">Informações acerca deste imóvel</h1>
  <div class="thumbnail thumbnail_p_imovel">

   <div class="info-detalhes">
     <!-- Descrição do imóvel -->
     <div class="descricao">
       <h4 class="info"><strong>Descrição do imóvel:</strong><br> <?php echo "$imovel[9] "; ?> </h4>
     </div>

     <!-- Tipo de imóvel -->
     <h4 class="info"><strong>Tipo do imóvel:</strong> <?php echo "$imovel[2] "; ?> </h4>

     <!-- Tipologia do imóvel -->
     <h4 class="info"><strong>Tipologia:</strong> <?php echo "$imovel[6] "; ?></h4>

     <!-- Informações acerca do imóvel -->
     <h4 class="info"><strong>Preço:</strong> <?php echo "$imovel[7] "; ?> </h4>

     <!-- Vendedor do imóvel -->
     <h4 class="info"><strong>Vendedor:</strong> <?php echo "$gestor[3] "; ?> </h4>
   </div>
  </div>

   <?php if (isset($_SESSION['cliente'])) { ?>

     <!-- Formulário para marcar visita ao imóvel -->
     <form class="visita" action="adicionar_visita.php" method="post">

       <h1 class="titulo_geral_secundario">Deseja marcar uma visita a este imóvel?</h1>
       <input type="hidden" name="id_user" value="<?php echo $_SESSION['cliente']; ?>">
       <input type="hidden" name="id_imovel" value="<?php echo $_GET['id']; ?>">
       <input type="hidden" name="id_gestor" value="<?php echo $gestor[0]; ?>">
       <br>
       <!-- Data de visita ao imóvel -->
       Data: <input type="date" name="data" min="2017-12-06" required>
       <br><br>
       <!-- Hora de visita ao imóvel -->
       Hora: <input type="time" name="hora" required>
       <br><br>

      <div class="botao_visita">
        <input class="submeter_form marcar_visita" type="submit" value="Marcar visita">
      </div>

   </form>

 <?php  }  ?>

   <!-- Slider da galeria -->
   <h2 id="galeria" class="titulo_geral_secundario text-center">Percorra a galeria do imóvel</h2>

   <div id="slider">

     <div id="box">
       <img class="img_slider" src="<?php echo "imoveis/".$_GET['id']."/".$_GET['id']."_0.jpg"; ?>">
     </div>

     <!-- Butões de controlo do slider -->
     <button class="slider_button prew" onclick="nextImage()"><</button>
     <button class="slider_button next" onclick="prewImage()">></button>
   </div>

<div class="botoes">
   <?php

   if (isset($_SESSION['admin']) && $_SESSION['admin']==1) { ?>
            <a href="administrator/n_destaque.php?id=<?php echo $_GET['id']; ?>"><button class="botoes_edicao">Retirar imóvel da secção de destaque</button></a>
     <?php }


   if(isset($ver) && $ver == 1) { ?>

   <a href="edicao_imovel.php?id=<?php echo $_GET['id']; ?>"><button class="botoes_edicao">Editar dados do imóvel</button></a>
   <a href="eliminar_imovel.php?id=<?php echo $_GET['id']; ?>"><button class="botoes_edicao">Eliminar imóvel</button></a>

   <?php if ($imovel[10] == "Disponível") { ?>

    <a href="compra.php?id=<?php echo $_GET['id']; ?>"><button class="botoes_edicao">Definir imóvel como comprado</button></a>

   <?php

  } else {

   ?>

   <a href="n_compra.php?id=<?php echo $_GET['id']; ?>"><button class="botoes_edicao">Imovel Vendido</button></a>

 <?php }

  }

  ?>
</div>

</div>

  <!-- Footer -->
  <div class="footer footer_pi">
    <p class="texto_footer"> &#169; Azores Property 2018</p>
    <hr class="separador"></hr>
    <div class="media_icons">
      <a href="#"><i class="fab fa-facebook fa-2x"></i></a>
      <a href="#"><i class="fab fa-twitter-square fa-2x"></i></a>
      <a href="#"><i class="fab fa-instagram fa-2x"></i></a>
      <a href="#"><i class="fas fa-phone-square fa-2x"></i></a>
      <a href="#"><i class="fas fa-envelope-square fa-2x"></i></i></a>
    </div>
  </div>

   <!-- JavaScript -->
   <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
   <script src="js/slider.js"></script>
   <script src="js/pesquisa.js"></script>
   <script src="js/filter.js"></script>
   <script src="js/popup.js"></script>

   <script type="text/javascript">
   var slider_content = document.getElementById('box');

  <?php
  $img="[";
  foreach (glob("imoveis/".$_GET['id']."/".$_GET['id']."*.jpg") as $filename) {
    $img = $img."'".$filename."',";
  }
  $img=$img."]";

  echo ($img);

  ?>

   // Guarda as imagens num array (dinamizar isto)
   var image = <?php echo "$img"; ?>;

   var i = image.length;

   // Função para passar ao próximo slide
   function nextImage() {

       if(i < image.length) {

           i = i + 1;

       } else {

           i = 1;

       }

       slider_content.innerHTML = "<img class='img_slider' src="+image[i-1]+">";
   }

   // Função para slider anterior

   function prewImage() {

       if(i < image.length - 1 && i > 1) {

         i = i - 1;

       } else {

         i = image.length;

       }

     slider_content.innerHTML = "<img class='img_slider' src="+image[i-1]+">";

     }
   </script>

</body>
</html>
