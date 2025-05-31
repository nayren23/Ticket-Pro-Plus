function afficherMessage(message, icon = 'success', isToast = false, position = 'top-end') {
    const options = {
        icon: icon,
        title: message,
        showConfirmButton: false,
        timer: 3000 // Durée d'affichage en millisecondes (ajustez si nécessaire)
    };

    if (isToast) {
        options.toast = true;
        options.position = position;
    }

    Swal.fire(options);
}