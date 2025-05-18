/**
 * Suppression d'u utilisateur avec une requetes ajax, en passant l'id en parametre
 */
$(document).ready(function () {
    $('.delete-user-link').on('click', function (event) {
        event.preventDefault()

        const userId = this.dataset.userId
        const urlToDelete = "/Ticket-Pro-Plus/?module=user&action=deleteUser"
        const deleteLink = $(this)

        $.ajax({
            url: urlToDelete,
            type: 'POST',
            data: { id: userId },
        })
            .done(function () {
                console.log("Succes: User " + userId + " deleted")
                const rowToRemove = deleteLink.closest('tr')
                if (rowToRemove) {
                    rowToRemove.remove()
                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                console.error("Erreur lors de la suppression de l\'utilisateur.", textStatus, errorThrown, jqXHR.responseText)
            })
    })
})