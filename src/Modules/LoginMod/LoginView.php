<?php

require_once("./Common/CommonLib/Error404.php");
if (constant("APP_SECRET") != $_ENV["APP_SECRET"])
    die(showError404());

require_once("./Common/GenericClass/GenericLoginView.php");


class LoginView extends GenericLoginView
{

    public function  __construct()
    {
        parent::__construct(); // comme un super
    }


    ////////////////////////////////////////////////// INSCRIPTION ///////////////////////////////////////////////////////
    // formulaire d'inscription au site 
    public function form_inscription()
    {
        //index.php?module=joueurs&action=ajout


?>
        <title> INSCRIPTION | Ticket Pro + </title>
        <div class="pageCompte">
            <div class="contenir">
                <div class="auth-title">
                    <h1>INSCRIPTION</h1>
                    <p class="balise_p_generique">Inscrivez-vous à Ticket Pro +</p>
                </div>
                <?php
                if (!isset($_SESSION["identifiant"])) { // pour afficher le formulaire uniquement si on n'est pas déjà connecter

                ?>
                    <form class="formulairegenerale" action="index.php?module=connexion&action=creationCompte" method="post">
                        <input type="hidden" name="token" value='<?php echo $_SESSION['token'] ?>'>
                        <!--Token- -->

                        <div> <input class="saisieText" type="text" placeholder="Identifiant" name="identifiant" required
                                maxlength="50"></div>

                        <!--Premier Mot de Passe- -->
                        <div class="boutonMdp">
                            <input class="saisieText" id="premierMdp" type="password" placeholder="Mot de passe" name="motDePasse"
                                required maxlength="100">
                            <button type="button" class="checkboxMdp"> <img alt="oeil affichage mot de passe" id="oeil"
                                    src="ressource/images/oeilCacherMdp.png" onclick="basculerAffichageMotDePasse(premierMdp,oeil)">
                            </button>
                        </div>

                        <!--Deuxième Mot de Passe- -->
                        <div class="boutonMdp">
                            <input class="saisieText" id="deuxiemeMdp" type="password" placeholder="Confirmation Mdp"
                                name="DeuxiemeMotDePasse" required maxlength="100" onKeyUp="checkMdp()">
                            <button type="button" class="checkboxMdp"> <img alt="oeil affichage mot de passe" id="deuxiemeOeil"
                                    src="ressource/images/oeilCacherMdp.png"
                                    onclick="basculerAffichageMotDePasse(deuxiemeMdp,deuxiemeOeil)"> </button>
                        </div>
                        <div><input class="saisieText" type="email" placeholder="E-mail" name="adresseMail" required maxlength="75">
                        </div>
                        <div><input class="saisieText" type="submit" value="S'inscrire 👋🏻 !"> </div>
                        <div id="deuxiemeAffichageMdp">
                            <!--Vide pour laisser la place au message d'erreur  -->
                        </div>
                        <p class="balise_p_generique">&copy;A2Z 2022</p>
                    </form>
                <?php
                } else {
                    $this->compteInexsistant();
                }

                ?>
            </div>
        </div>
    <?php

    }

    ////////////////////////////////////////////////// CONNEXION ///////////////////////////////////////////////////////

    //fonction pour afficher le foirmulaire de connexion
    public function form_connexion()
    {
    ?>
        <title>Login | Ticket Pro +</title>
        <?php
        if (!isset($_SESSION["identifiant"])) {
        ?>
            <div class="loginPage">
                <div>
                    <form class="max-w-sm mx-auto" action="index.php?module=connexion&action=connexionidentifiant" method="post">

                        <p class="text-lg font-medium text-gray-900 dark:text-white">Please Enter your Account details</p>
                        <br>

                        <input type="hidden" name="token" value='<?php echo $_SESSION['token'] ?>'>
                        <!--Token- -->

                        <div class="mb-5">
                            <label for="login" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your
                                Login</label>
                            <input type="text" id="login" name="login"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="John" required />
                        </div>
                        <div class="mb-5">
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your
                                password</label>
                            <input type="password" id="password" name="password"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                required />
                        </div>
                        <button type="submit"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                    </form>
                </div>
            </div>
<?php
        } else {
            $this->compteInexsistant();
        }
    }
}

?>