/**
 * Suppression d'u utilisateur avec une requetes ajax, en passant l'id en parametre
 */
$(document).ready(function () {

    // Attacher l'événement d'ouverture du modal de suppression
    $('table').on('click', '[data-modal-target="popup-modal"]', function (event) {
        event.preventDefault()
        const userIdToDelete = this.dataset.userId // Récupérer l'ID depuis le lien cliqué
        const confirmDeleteButton = $('#popup-modal .delete-user-link') // Sélectionner le bouton "Yes, I'm sure"
        confirmDeleteButton.data('user-id', userIdToDelete) // Attribuer l'ID au bouton
        const rowToRemove = $(this).closest('tr') // Récupérer la ligne à supprimer
        confirmDeleteButton.data('row-to-remove', rowToRemove) // Stocker la ligne
    })

    $('#popup-modal .delete-user-link').on('click', function (event) {
        event.preventDefault()

        const userId = $(this).data('user-id') // Récupérer l'ID stocké dans le bouton
        const rowToRemove = $(this).data('row-to-remove')
        const urlToDelete = "/Ticket-Pro-Plus/?module=user&action=deleteUser"

        $.ajax({
            url: urlToDelete,
            type: 'POST',
            data: { id: userId },
        })
            .done(function () {
                afficherMessage("User successfully deleted !", 'success', true)
                if (rowToRemove) {
                    rowToRemove.remove()
                }
            }
            )
            .fail(function (jqXHR) {
                afficherMessage("You cannot delete your own account !", 'error', true)
                console.error("Erreur lors de la suppression de l'utilisateur.", jqXHR.responseText)
            })
    })
})