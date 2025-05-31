/**
 * Suppression d'un client avec une requête ajax, en passant l'id en paramètre
 */
$(document).ready(function () {

    // Attache l'événement d'ouverture du modal de suppression
    $('table').on('click', '[data-modal-target="popup-modal"]', function (event) {
        event.preventDefault()
        const clientIdToDelete = this.dataset.clientId
        const confirmDeleteButton = $('#popup-modal .delete-client-link')
        confirmDeleteButton.data('client-id', clientIdToDelete)
        const rowToRemove = $(this).closest('tr')
        confirmDeleteButton.data('row-to-remove', rowToRemove)
    })

    $('#popup-modal .delete-client-link').on('click', function (event) {
        event.preventDefault()

        const clientId = $(this).data('client-id')
        const rowToRemove = $(this).data('row-to-remove')
        const urlToDelete = "/Ticket-Pro-Plus/?module=client&action=deleteClient"

        $.ajax({
            url: urlToDelete,
            type: 'POST',
            data: { id: clientId },
        })
            .done(function () {
                afficherMessage("Client successfully deleted!", 'success', true)
                if (rowToRemove) {
                    rowToRemove.remove()
                }
            })
            .fail(function (jqXHR) {
                console.error("Failed to delete client.", jqXHR.responseText)
            })
    })
})