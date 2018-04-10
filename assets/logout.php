<?php
  if (isset($_GET['acao']) && $_GET['acao']=='logout') {
    session_destroy();
    header('location:index.php');
  }
?>
