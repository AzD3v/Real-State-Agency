<?php session_start(); ?>
<?php include("assets/ficheiros.php"); ?>
<?php include("assets/logout.php"); ?>

<?php

  // Verificação do ID

  $file = fopen("data/$fileimoveis", "r");

  while (!feof($file)) {

    $gestor=fgetcsv($file, 0, ";");
    // Se o imóvel for encontrado e o id do gestor for igual ao que possui sessão iniciada
    if ($gestor[1] == $_SESSION['admin'] && $gestor[0] == $_GET['id']) {
      // Fecha o a estrutura de controlo
      break;
    }
  /* Caso o ficheiro chegue ao fim do ficheiro e o imóvel não for encontrado
  com o id do gestor o logout é executado */
  if ($gestor[0] == "") {
    header("location:index.php?acao=logout");
  }
}
fclose($file);

  // Adquirir informações do imóvel
  $file = fopen('imoveis/' . $_GET['id'] . '/' . $_GET['id'] . 'imovel.csv', 'r');

  $imovel = fgetcsv($file, 0,';');

  fclose($file);

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
    <title>Azores Property | Editar imóveis</title>

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
            //ler o ficheiro ilhas.csv e criar as diferentes options
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
    if (isset($_SESSION['cliente'])) {

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

    <!-- Edição do imóvel -->
    <div class="featured_box1">

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



      <h1 class="text-center titulo_geral"><?php echo "Edicão $imovel[2] - $imovel[6] - $data_ilha[0] - $data_concelho[0] - $data_concelho[0]"; ?> </h1>

      <div class="formulario_criar_conta formulario_editar_imovel">

        <form action="editar_imovel_ok.php" method="post" enctype="multipart/form-data">

          <!-- Imagem do imóvel em questão -->
          <img src="<?php echo "imoveis/" . $imovel[0] . "/" . $imovel[0] . "_0.jpg"; ?>" class="edicao_imovel_img">

          <!-- Inserir descrição do imóvel -->
          <div class="nome label_registo">
            <div>
              <p>Descrição do imóvel em questão:</p>
              <textarea name="descricao" cols="50" rows="8"><?php echo $imovel[9]; ?></textarea>
            </div>

          <!-- Inserir morada, tipo, tipologia e preço do imóvel -->
          <div class="morada label_registo morada">
            <p>Morada do imóvel:</p>
            <input value="<?php echo $imovel[8] ?>" type="text" name="morada" class="form-control">

            <p>Tipo do imóvel:</p>
            <input value="<?php echo $imovel[2] ?>" type="text" name="tipo" class="form-control">

            <p>Tipologia:</p>
            <select name="tipologia" class="custom-select col-sm-2">
            <option value="T0" <?php if($imovel[6] == "T0") {echo "selected";} ?>>T0</option>
            <option value="T1" <?php if($imovel[6] == "T1") {echo "selected";} ?>>T1</option>
            <option value="T2" <?php if($imovel[6] == "T2") {echo "selected";} ?>>T2</option>
            <option value="T3" <?php if($imovel[6] == "T3") {echo "selected";} ?>>T3</option>
            <option value="T4" <?php if($imovel[6] == "T4") {echo "selected";} ?>>T4</option>
            <option value="T5" <?php if($imovel[6] == "T5") {echo "selected";} ?>>T5</option>
            <option value="T5+" <?php if($imovel[6] == "T5+") {echo "selected";} ?>>T5+</option>
            </select>

            <p>Preço do imóvel:</p>
            <input name="preco" type="text" value="<?php echo $imovel[7]; ?>" class="form-control col-sm-3">

            <p>Finalidade:</p>
            <select name="finalidade" class="custom-select col-sm-3" name="finalidade">
            <option value="arrendar">Arrendar</option>
            <option value="comprar">Comprar</option>
            </select>

            <p>Estado do imóvel:</p>
            <select name="estado" class="custom-select col-sm-4">
            <option value="Disponível">Disponível</option>
            <option value="Vendido">Vendido</option>
            </select>

            <p>Adicionar fotografias à galeria:</p>
            <div class="input-group-prepend">
            <span class="input-group-text selecionar_fotos">Selecione:</span>
            <input name="img" type="file" class="custom-file-input">
            <i type="file" class="fas fa-upload fa-2x"></i>
            <span class="custom-file-control"></span>
            </div>
            <p>Deseja eliminar o imóvel?</p>
            <a href="eliminar_imovel.php?id=<?php echo $_GET['id']; ?>"><i class="far fa-trash-alt fa-2x"></i></a>
          </div>
        </div>


        <div class="label_registo">
        <p class="local_ei">Localização do imóvel:</p>
        <select id ="slct1" name="slct1" onchange="functionConcelho(this.id, 'slct2')" class="custom-select col-sm-2 options">
        <option value="">Ilha</option>
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
        <br><br>
        <select id="slct2" name="slct2" onchange="functionFreguesia(this.id, 'slct3')" class="custom-select col-sm-2">
        <option value="" <?php if($imovel[4] == "arrendar") {echo "selected";} ?>>Concelho</option>
      </select>
        <br><br>
        <select id="slct3" name="slct3" class="custom-select col-sm-2">
        <option value="" <?php if($imovel[5] == "arrendar") {echo "selected";} ?>>Freguesia</option>
        </select>

        <div class="criar_conta">
          <input type="hidden" value="<?php echo $imovel[0]; ?>" name="id">
          <input type="submit" class="submeter_form submeter_edicao" name="submeter" value="Concluir edição">
        </div>

        </form>
      </div>
    </div>



    <!-- Footer -->
    <div class="footer footer_ei">
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
  <script src="js/pesquisa.js"></script>
  <script src="js/filter.js"></script>
  <script src="js/popup.js"></script>

  </body>
</html>
