<?php
require_once("./Common/Bibliotheque_Communes/errreur404.php");
if (constant("a2z") != "rya")
  die(affichage_erreur404());
?>

<html lang="fr">
<!DOCTYPE html>

<head>
    <meta charset='utf-8'>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- FlowBite -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />

    <!-- CSS only -->
    <link href="./public\assets\Style_css\main.css" rel="stylesheet" />

    <!-- Script only -->
</head>

<body>
    <?php


  if (!isset($_SESSION["identifiant"])) {  //page accessible uniquement si on est connecter
    require_once("./composants/comp_navbar_Connexion/composants_navbar_Connexion.php");
    $navbar_Connexion = new Composant_navbar_Connexion();
  } else {
    require_once("./composants/comp_navbar/composants_navbar.php");
    $navbar = new Composant_navbar();
  }

  echo $controleur->resultat; // affichage ici comme ça le contenu des modules sera toujours entre la navbar et le footer
  
  require_once("./composants/comp_footer/composants_footer.php");
  $footer = new Composant_footer();

  ?>

</body>

</html>