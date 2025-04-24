<?php

require_once("./Common/Bibliotheque_Communes/errreur404.php");
if (constant("a2z") != "rya")
    die(affichage_erreur404());

require_once "./Common/Classe_Generique/vue_generique.php";

class Vue_footer extends Vue_Generique
{

    public function  __construct()
    {
        parent::__construct(); // comme un super
    }
    //fonction pour l'affichage du Footer
   
   
    function footerHabillage(){
        ?>
<footer
    class="fixed bottom-0 left-0 z-20 w-full p-4 bg-white border-t border-gray-200 shadow-sm md:flex md:items-center md:justify-between md:p-6 dark:bg-gray-800 dark:border-gray-600">
    <div class="w-full max-w-screen-xl mx-auto p-4 md:py-8">
        <div class="sm:flex sm:items-center sm:justify-between">
            <a href="index.php?module=principale" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img src="ressource/images/TabA2Z.png" class="h-8" alt="Site Logo" />
                <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Ticket Pro
                    Plus</span>
            </a>
            <ul class="flex flex-wrap items-center mb-6 text-sm font-medium text-gray-500 sm:mb-0 dark:text-gray-400">
                <li>
                    <a href="#" class="hover:underline me-4 md:me-6">About</a>
                </li>
                <li>
                    <a href="#" class="hover:underline me-4 md:me-6">Privacy Policy</a>
                </li>
                <li>
                    <a href="#" class="hover:underline me-4 md:me-6">Licensing</a>
                </li>
                <li>
                    <a href="#" class="hover:underline">Contact</a>
                </li>
            </ul>
        </div>
        <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />
        <span class="block text-sm text-gray-500 sm:text-center dark:text-gray-400">©
            <script>
            document.write(new Date().getFullYear())
            </script>
            <a href="#" class="hover:underline">Ticket Pro Plus™</a>. All Rights Reserved.
        </span>
    </div>
</footer>
<?php
    }
}
?>