// let $sortie_ville = $("#sortie_villes_no_ville");
// let $token = $("#sortie_token");
//
// console.log($sortie_ville);
// $sortie_ville.change(function (){
//     let $form = $(this).closest('form')
//
//     let data = {}
//
//     data[$token.attr('nom')] = $token.val();
//     data[$sortie_ville.attr('nom')] = $sortie_ville.val();
//
//     $.post($form.attr('action'), data).then(function (response){
//
//         $("#sortie_lieux_noLieu").replaceWith(
//             $(response).find("#sortie_lieux_noLieu")
//         )
//     })
//     console.log(data);
//
// })

$(document).on('change','#sortie_villes_no_ville', '#sortie_lieux_noLieu', function(){
    let $field = $(this)
    let $villeField = $('#sortie_villes_no_ville')
    let $form = $field.closest('form')
    let data = {}
    // data[$field.attr('name')] = $field.val()
    data[$villeField.attr('name')] = $villeField.val()

    $.post($form.attr('action'), data).then(function (data) {
        let $input = $(data).find('#sortie_lieux_noLieu')
        $('#sortie_lieux_noLieu').replaceWith($input)
    })

})