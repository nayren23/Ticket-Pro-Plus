<?php

namespace TicketProPlus\App\Core;

class GenericView
{

    public function  __construct()
    {
        ob_start();
    }

    public function showTampon()
    {
        return ob_get_clean();
    }


    /**
     * Affiche une notification toast à l'utilisateur.
     * Le toast est positionné en haut à droite de la fenêtre.
     *
     * @param string $type Le type de toast à afficher, doit correspondre à une
     * des valeurs de l'énumération `ToastType` (par exemple,
     * `ToastType::SUCCESS->value`, `ToastType::error->value`).
     * Ceci détermine la couleur de l'icône et potentiellement
     * d'autres styles.
     * @param string $message Le message à afficher dans le toast.
     *
     * @return void Affiche directement le code HTML du toast.
     */
    public function displayToast($type, $message): void
    {
?>
<div id="<?php echo $type ?>"
    class="fixed flex items-center w-full max-w-xs p-4 space-x-4 text-gray-500 bg-white divide-x rtl:divide-x-reverse divide-gray-200 rounded-lg shadow-sm top-5 right-5 dark:text-gray-400 dark:divide-gray-700 dark:bg-gray-800"
    role="alert">
    <div
        class="inline-flex items-center justify-center shrink-0 w-8 h-8 <?php echo ($type === ToastType::SUCCESS->value ? 'text-green-500 bg-green-100 dark:bg-green-800 dark:text-green-200' : ($type === ToastType::error->value ? 'text-red-500 bg-red-100 dark:bg-red-800 dark:text-red-200' : ($type === ToastType::WARNING->value ? 'text-yellow-500 bg-yellow-100 dark:bg-yellow-800 dark:text-yellow-200' : 'text-blue-500 bg-blue-100 dark:bg-blue-800 dark:text-blue-200'))) ?> rounded-lg">
        <?php if ($type === ToastType::SUCCESS->value): ?>
        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
            viewBox="0 0 20 20">
            <path
                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
        </svg>
        <span class="sr-only">Check icon</span>
        <?php elseif ($type === ToastType::error->value): ?>
        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
            viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm1-11a1 1 0 1 1-2 0V5a1 1 0 1 1 2 0v2Zm-1 4a1 1 0 1 1-2 0v-2a1 1 0 1 1 2 0v2Z"
                clip-rule="evenodd" />
        </svg>
        <span class="sr-only">Error icon</span>
        <?php elseif ($type === ToastType::WARNING->value): ?>
        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
            viewBox="0 0 20 20">
            <path
                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793-4-4a1 1 0 0 1-1.414 0l-2 2a1 1 0 0 1 1.414 1.414L9 10.586l3.293 3.293a1 1 0 0 1 0 1.414Z" />
        </svg>
        <span class="sr-only">Warning icon</span>
        <?php else: ?>
        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
            viewBox="0 0 20 20">
            <path
                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm-3 6a1 1 0 1 1 2 0v6a1 1 0 1 1-2 0V7Zm6 0a1 1 0 1 1 2 0v6a1 1 0 1 1-2 0V7Z" />
        </svg>
        <span class="sr-only">Information icon</span>
        <?php endif; ?>
    </div>
    <div class="ms-3 text-sm font-normal"><?php echo $message ?></div>
    <button type="button"
        class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
        data-dismiss-target="#<?php echo $type ?>" aria-label="Close">
        <span class="sr-only">Close</span>
        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
        </svg>
    </button>
</div>
<?php

    }
}

enum ToastType: string
{
    case SUCCESS = 'toast-success';
    case error = 'toast-danger';
    case WARNING = 'toast-warning';
}