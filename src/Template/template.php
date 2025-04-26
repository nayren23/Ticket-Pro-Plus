<?php
require_once("./Common/CommonLib/Error404.php");
if (constant("APP_SECRET") != $_ENV["APP_SECRET"])
  die(showError404());
?>

<html lang="en">
<!DOCTYPE html>

<head>
  <meta charset='utf-8'>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- FlowBite -->
  <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />

  <!-- CSS only -->
  <link href="./public\assets\Style_css\Main.css" rel="stylesheet" />
  <link rel=" icon" href="ressource/images/TabA2Z.png" type="image/x-icon">

  <!-- Script only -->
</head>

<body>
  <?php


  if (!isset($_SESSION["login"])) {  //page accessible uniquement si on est connecter
    require_once("./composants/NavbarLoginComp/NavbarLoginComp.php");
    $navbar_Connexion = new NavbarLoginComp();
  } else {
    require_once("./composants/NavbarComp/NavbarComp.php");
    $navbar = new NavbarComp();
  }

  echo $Controller->resultat; // affichage ici comme ça le contenu des modules sera toujours entre la navbar et le footer

  require_once("./composants/FooterComp/FooterComp.php");
  $footer = new FooterComp();

  ?>

</body>

</html>