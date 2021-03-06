$('document').ready(() => {
    /* Ajouter un listener à chacun des boutons */
    let nbModal = $('.callModal').length;
    for(let i = 0; i < nbModal; i++) {
        (function (i) {
            $('.callModal:eq('+i+')').click(function(e) {
                /* récupérer l'id du post sélectionné et l'intégrer au formulaire en select caché */
                postID = e.target.dataset.post;
                $('#form_post').val(postID);
            })
        })(i)
    }
    
    /* Récupération des erreurs de formulaires back sans rechargement de la page */
    $('#post_submit').on('click', (e) => {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            }
        });
        $.ajax({
            url: 'http://localhost:8000/testpost',
            method: 'POST',
            data: {
                content: $('#post_content').val(),
            },
            success: function(result) {
                if(result[0].detail) {
                    let message = result[0].violations[0].title
                    console.log(message)
                    if(!$('.form-back-validation').length) {
                    $('#post_content').before('<p class="form-back-validation">* ' + message + '</p>')
                    }
                    return
                } else {
                $('#post').submit()
                }
            },
            error: function(result) {
                console.log('erreur')
            }
        });
        
    })

    $('#form_submit').on('click', (e) => {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            }
        });
        $.ajax({
            url: 'http://localhost:8000/testvote',
            method: 'POST',
            data: {
                rating: $('#form_rating').prop('selectedIndex'),
            },
            success: function(result) {
                console.log(result)
                if(result[0].detail) {
                    let message = result[0].violations[0].title
                    console.log(message)
                    if(!$('.form-back-validation').length) {
                    $('#form_post').before('<p class="form-back-validation">* ' + message + '</p>')
                    }
                    return
                } else {
                $('#vote').submit()
                }
            },
            error: function(result) {
                console.log('erreur')
            }
        });
        
    })
})