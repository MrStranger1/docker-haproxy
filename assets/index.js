$(document).ready(function () {

    let $add_srv_form    = false
    let nbr_element      = 0
    let elementsuivant   = false
    let data             = {}

    /**
    * afficher l'élément suivant
    */
    $('#add-srv-form').on('click', function(){
        $add_srv_form           =   $(this)
        elementsuivant          =   $add_srv_form.data('target')
        var nbr_element         =   parseInt($('.add-srv-input:visible').length)

        $('#'+elementsuivant).slideDown(300, 'linear', function () {
            $add_srv_form.data('target', 'add-srv-form-2')
            if (nbr_element === 2 ) {
                $add_srv_form.hide()
            } else {
               $add_srv_form.show()
            }
        }).attr('data-send', 'yes')
        nbr_element += 1
    })

    /*
    * supprimer 1er champs backup 
    */
    $('#del-srv-1').on('click', function () {
        $(this).parent().slideUp(300, 'linear', function () {   
            $(this).hide().attr('data-send', 'no')
            $add_srv_form.data('target', 'add-srv-form-1').show().addClass('yes')
        })
    })

    /*
    * supprimer 2ème champs backup 
    */
    $('#del-srv-2').on('click', function () {  
        $(this).parent().slideUp(300, 'linear', function () {
            $(this).hide().attr('data-send', 'no')
            nbr_element     =   parseInt($('.add-srv-input:visible').length)
            if (nbr_element === 0) {
                $add_srv_form.data('target', 'add-srv-form-1').show().addClass('yes')
            } else {
                $add_srv_form.data('target', 'add-srv-form-2').show().addClass('yes')
            }
        })  
    }) 

    /**
    * traitement du formulaire
    */
    $('#form').submit(function (event) {
        event.preventDefault();
        // prends les donné visibles / autorisés à être envoyer
        let form_data = $('.form-group[data-send="yes"] input')
        form_data.each(function(index, element){
            data[element.name] = element.value
        })

        $.post('execute.php', data, function (message) {
                
            if(message.error){
                    $('#help-'+message.champ).slideDown().css('display', 'block').html(message.error).delay(3000).slideUp()
            }
           if(message.code === 'OK'){
                  $('#site_message').slideDown().css('display', 'block').html(message.error).delay(3000).slideUp()
                  $('#site_nom_0').val('')
                  $('#site_nom_serveur_0').val('')
                  $('#site_nombre_connexion_0').val('')
                  $('#site_adresse_ip_0').val('')
                  $('#site_adresse_ip_1').val('').parent().hide()
                  $('#site_adresse_ip_2').val('').parent().hide()
                  $('#add-srv-form').show().data('target', 'add-srv-form-1')
           }
           console.log(message)
        },'json')
        
    })

   
}) 