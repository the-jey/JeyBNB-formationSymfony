$('#add-image').click(function(){
    //Récupérer les futurs champs
    const index = +$('#widgets-counter').val();
    //Récupérer le prototype des entrées
    const tmpl = $('#annonce_images').data('prototype').replace(/__name__/g, index);
    console.log(tmpl);
    // J'injecte ce code au sein de la div
    $('#annonce_images').append(tmpl);

    $('#widgets-counter').val(index +1);

    //Je gère le bouton supprimer
    handleDeleteButtons();
});

function handleDeleteButtons() {
    $('button[data-action="delete"]').click(function(){
        const target = this.dataset.target;

        $(target).remove();
    });
}

function updateCounter(){
    const count =  +$('#annonce_images .form-group').length;

    $('#widgets-counter').val(count);
}

updateCounter();
handleDeleteButtons();