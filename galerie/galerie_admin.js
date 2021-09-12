
function onDeleteColPressed () {
    message = "Attention, vous êtes sur le point de supprimer toute une collection, et ce qu'il y a dedans. "
     + "Voulez-vous continuer ?" ;
    if (confirm(message)) {
        // Alors confirmer l'envoi de la requete
        document.forms["delete_col_form"].submit() ;
    }
}

// Override l'affichage classique d'un input file
function onAddImagePressed () {
    let bouton = document.getElementById('add_image_link') ;
    // Le bouton est directement relie a l'input file cache
    bouton.click() ;
    // Lorsqu'on selectionne une image elle est envoyee sans confirmation
    bouton.addEventListener("input", function () {
        document.forms['form_add_image'].submit() ;
    }) ;
}


