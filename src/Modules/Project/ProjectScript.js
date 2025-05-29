/**
 * Suppression d'un client avec une requête ajax, en passant l'id en paramètre
 */
$(document).ready(function () {

    // Attache l'événement d'ouverture du modal de suppression
    $('table').on('click', '[data-modal-target="popup-modal"]', function (event) {
        event.preventDefault()
        const projectIdToDelete = this.dataset.projectId
        const confirmDeleteButton = $('#popup-modal .delete-project-link')
        confirmDeleteButton.data('project-id', projectIdToDelete)
        const rowToRemove = $(this).closest('tr')
        confirmDeleteButton.data('row-to-remove', rowToRemove)
    })

    $('#popup-modal .delete-project-link').on('click', function (event) {
        event.preventDefault()

        const projectId = $(this).data('project-id')
        const rowToRemove = $(this).data('row-to-remove')
        const urlToDelete = "/Ticket-Pro-Plus/?module=project&action=deleteProject"

        $.ajax({
            url: urlToDelete,
            type: 'POST',
            data: { id: projectId },
        })
            .done(function () {
                afficherMessage("Project successfully deleted!", 'success', true)
                if (rowToRemove) {
                    rowToRemove.remove()
                }
            })
            .fail(function (jqXHR) {
                console.error("Failed to delete project.", jqXHR.responseText)
            })
    })
})