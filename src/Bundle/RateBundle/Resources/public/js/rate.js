

$(document).ready(function () {
    // on check le code à la soumission du formulaire
    $('.ilikeit').on('click', function (e) {
        console.log($(this));                
        var element = $(this);
        $.ajax(rateLikeUrl+"?id=" + element.attr('id'))
            .success(function () {
                element.parent().html('You like it');
                var nbLikers = $('#'+element.attr('id')+'_nbLikers').html();
                $('#'+element.attr('id')+'_nbLikers').html(nbLikers*1.0+1.0);
            })
            .fail(function () {
                alert("ajax error");
            });
    });
});