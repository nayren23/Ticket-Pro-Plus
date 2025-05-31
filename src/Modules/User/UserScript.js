/**
 * Suppression d'u utilisateur avec une requetes ajax, en passant l'id en parametre
 */
$(document).ready(function () {

    // Attache l'événement d'ouverture du modal de suppression
    $('table').on('click', '[data-modal-target="popup-modal"]', function (event) {
        event.preventDefault()
        const userIdToDelete = this.dataset.userId
        const confirmDeleteButton = $('#popup-modal .delete-user-link')
        confirmDeleteButton.data('user-id', userIdToDelete)
        const rowToRemove = $(this).closest('tr')
        confirmDeleteButton.data('row-to-remove', rowToRemove)
    })

    $('#popup-modal .delete-user-link').on('click', function (event) {
        event.preventDefault()

        const userId = $(this).data('user-id')
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
                console.error("Failed to delete user.", jqXHR.responseText)
            })
    })
})