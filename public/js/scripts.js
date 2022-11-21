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
    
    
    // Récupération des erreurs de formulaires back sans rechargement de la page //
    $('#post_submit').on('click', (e) => {
        e.preventDefault();
        if ($('#connected' !== null)) {
            console.log($('#connected').val());
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                    'Access-Control-Allow-Origin': '*',
                    'Access-Control-Allow-Methods': 'POST',
                    'Access-Control-Allow-Headers': 'Content-Type'
                }
            });
            $.ajax({
                url: 'https://recueil-de-blagues.herokuapp.com/testpost',
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
        } else {
            window.location.href = "https://recueil-de-blagues.herokuapp.com/login";
        }
    })

    $('#vote_submit').on('click', (e) => {
        e.preventDefault();
        $.ajaxSetup({
            headers: {

            }
        });
        $.ajax({
            url: 'https://recueil-de-blagues.herokuapp.com/testvote',
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

    $('#side-btn').on('click', (e) => {
        $('#side-menu').toggleClass('menu-open')
    })
})