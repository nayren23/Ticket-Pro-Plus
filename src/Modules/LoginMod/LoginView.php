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
<title> Sign up | Ticket Pro + </title>
<div class="pageCompte">
    <div class="contenir">
        <div class="auth-title">
            <h1>Sign up</h1>
            <p class="balise_p_generique">Sign up to Ticket Pro +</p>
        </div>
        <?php
                if (!isset($_SESSION["login"])) { // pour afficher le formulaire uniquement si on n'est pas déjà connecter

                ?>
        <form class="max-w-md mx-auto" action="index.php?module=login&action=createAccount" method="POST">
            <h2 class="text-4xl font-extrabold dark:text-white">Add a person</h2>

            <!--Token- -->
            <input type="hidden" name="token" value='<?php echo $_SESSION['token'] ?>'>

            <div class="relative z-0 w-full mb-5 group">
                <input type="text" name="login" id="login"
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                    placeholder=" " required />
                <label for="login"
                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Login</label>
            </div>

            <div class="grid md:grid-cols-2 md:gap-6">
                <div class="relative z-0 w-full mb-5 group">
                    <input type="text" name="firstname" id="firstname"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" " required />
                    <label for="firstname"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">First
                        name</label>
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input type="text" name="lastname" id="lastname"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" " required />
                    <label for="lastname"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Last
                        name</label>
                </div>
            </div>

            <div class="relative z-0 w-full mb-5 group">
                <input type="email" name="email" id="email"
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                    placeholder=" " required />
                <label for="email"
                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Email
                    address</label>
            </div>

            <div class="relative z-0 w-full mb-5 group">
                <input type="password" name="firstpassword" id="firstpassword"
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                    placeholder=" " required />
                <label for="firstpassword"
                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Password</label>
            </div>

            <div class="relative z-0 w-full mb-5 group">
                <input type="password" name="secondpassword" id="floating_secondpassword"
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                    placeholder=" " required />
                <label for="floating_secondpassword"
                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Confirm
                    password</label>
            </div>

            <div class="relative z-0 w-full mb-5 group">
                <input type="tel" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" name="phone" id="phone"
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                    placeholder=" " required />
                <label for="phone"
                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Phone
                    number (123-456-7890)</label>
            </div>


            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">Upload
                file</label>
            <input
                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                aria-describedby="file_input_help" id="pfp" type="file">
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">SVG, PNG, JPG or GIF (MAX.
                800x400px).</p>

            <div class="max-w-sm mx-auto">
                <label for="gender" class="block mb-2 text-sm font-medium text-gray-500 dark:text-gray-400">Select your
                    gender</label>
                <select id="gender"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="2">Rather not say</option>
                    <option value="0">Male</option>
                    <option value="1">Female</option>
                </select>
            </div>




            <div class="max-w-sm mx-auto">
                <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your
                    description</label>
                <textarea id="message" rows="4"
                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Leave a description of you..."></textarea>
            </div>







            <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
        </form>

















        <form class="formulairegenerale" action="index.php?module=login&action=createAccount" method="post">




            <div> <input class="saisieText" type="text" placeholder="Id" name="login" required maxlength="50"></div>

            <!--Premier Mot de Passe- -->
            <div class="boutonMdp">
                <input class="saisieText" id="firstpassword" type="password" placeholder="Password" name="u_password"
                    required maxlength="100">
                <button type="button" class="checkboxMdp"> <img alt="oeil affichage mot de passe" id="oeil"
                        src="ressource/images/oeilCacherMdp.png" onclick="basculerAffichageMotDePasse(premierMdp,oeil)">
                </button>
            </div>

            <input class="saisieText" id="secondpassword" type="password" placeholder="Confirm password" <input
                class="saisieText" id="deuxiemeMdp" type="password" placeholder="Confirmation Mdp" name="secondPassword"
                required maxlength="100" onKeyUp="checkMdp()">
            <button type="button" class="checkboxMdp"> <img alt="oeil affichage mot de passe" id="deuxiemeOeil"
                    src="ressource/images/oeilCacherMdp.png"
                    onclick="basculerAffichageMotDePasse(deuxiemeMdp,deuxiemeOeil)"> </button>

    </div>
    <div><input class="saisieText" type="email" placeholder="Mail" name="mail" required maxlength="75">
    </div>
    <div><input class="saisieText" type="submit" value="Sign up 👋🏻 !"> </div>
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
        if (!isset($_SESSION["login"])) {
        ?>
<div class="loginPage">
    <div>
        <form class="max-w-sm mx-auto" action="index.php?module=login&action=idCheck" method="POST">

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