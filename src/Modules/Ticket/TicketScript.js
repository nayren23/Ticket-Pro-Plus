/**
 * Suppression d'un client avec une requête ajax, en passant l'id en paramètre
 */
$(document).ready(function () {

    // Attache l'événement d'ouverture du modal de suppression
    $('table').on('click', '[data-modal-target="popup-modal"]', function (event) {
        event.preventDefault()
        const ticketIdToDelete = this.dataset.ticketId
        const confirmDeleteButton = $('#popup-modal .delete-ticket-link')
        confirmDeleteButton.data('ticket-id', ticketIdToDelete)
        const rowToRemove = $(this).closest('tr')
        confirmDeleteButton.data('row-to-remove', rowToRemove)
    })

    $('#popup-modal .delete-ticket-link').on('click', function (event) {
        event.preventDefault()

        const ticketId = $(this).data('ticket-id')
        const rowToRemove = $(this).data('row-to-remove')
        const urlToDelete = "/Ticket-Pro-Plus/?module=ticket&action=deleteTicket"

        $.ajax({
            url: urlToDelete,
            type: 'POST',
            data: { id: ticketId },
        })
            .done(function () {
                afficherMessage("Ticket successfully deleted!", 'success', true)
                if (rowToRemove) {
                    rowToRemove.remove()
                }
            })
            .fail(function (jqXHR) {
                console.error("Failed to delete ticket.", jqXHR.responseText)
            })
    })
})

// Pour voir la description d'un ticket dans un modal
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.view-description-btn').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            const desc = this.getAttribute('data-description');
            document.getElementById('description-modal-content').textContent = desc || 'No description';
            document.getElementById('description-modal').classList.remove('hidden');
        });
    });
    document.getElementById('close-description-modal').addEventListener('click', function () {
        document.getElementById('description-modal').classList.add('hidden');
    });
});