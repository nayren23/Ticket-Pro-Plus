<?php

require_once("./Common/Bibliotheque_Communes/errreur404.php");
if (constant("a2z") != "rya")
  die(affichage_erreur404());

function affichagMotDePasseDifferent()
{
?>
<script src="Script_js/outils.js"></script>
<script type="text/javascript">
Toast.fire({
    icon: 'error',
    title: "Attention les mots de passe sont différents 😡 "
})
</script>

<?php
}

function affichagMotDePasseErrone()
{
?>
<script src="Script_js/outils.js"></script>
<script type="text/javascript">
Toast.fire({
    icon: 'error',
    title: "Échec de l'authentification 😡 "
})
</script>

<?php
}


function affichageTokenExpire()
{
?>
<script src="Script_js/outils.js"></script>
<script type="text/javascript">
Toast.fire({
    icon: 'info',
    title: "Échec de l'authentification le token a expiré 🙄 "
})
</script>

<?php
}

?>