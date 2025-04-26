<?php

require_once("./Common/CommonLib/Error404.php");

if (constant("APP_SECRET") != $_ENV["APP_SECRET"])
    die(showError404());

function showError404()
{
?>
    <link href="./public\assets\Style_css\Erreur404" rel="stylesheet" />

    <h1>Error 404</h1>
    <p class="zoom-area"><b>Ticket Pro +</b> Unknown Page </p>
    <section class="error-container">
        <span class="four"><span class="screen-reader-text">4</span></span>
        <span class="zero"><span class="screen-reader-text">0</span></span>
        <span class="four"><span class="screen-reader-text">4</span></span>
    </section>
    <div class="link-container">
        <a href="index.php?module=login&action=connexion" class="more-link">Back to home page</a>
    </div>
<?php

}

function showError404Admin()
{
?>
    <link rel="stylesheet" href="Style_css/Erreur404">
    <h1>Error 404</h1>
    <p class="zoom-area"><b>Ticket Pro +</b> Unknown Page </p>
    <section class="error-container">
        <span class="four"><span class="screen-reader-text">4</span></span>
        <span class="zero"><span class="screen-reader-text">0</span></span>
        <span class="four"><span class="screen-reader-text">4</span></span>
    </section>
    <div class="link-container">
        <a href="index.php?module=administration&action=connexion" class="more-link">Back to home page</a>
    </div>
<?php

}


?>