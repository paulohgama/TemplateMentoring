var getBasePath = function () {
    return window.location.href.split('/')[0] 
    + '//' + window.location.href.split('/')[2] + '/api/';
}

$('.verba ul li .price .fa-pencil').bind('click', function(){
    var self = this;
    $.confirm({
        title: 'Modal',
        //content: '<input type="text" name="verba_clique" class="form-control" data-currency-masked value="'+ verba +'"/>',
        buttons: {
            Confirmar: function () {
                var id_number = $(self).parents('li').data('identifier');
                var newVerba = $('input[name="verba_clique"]').val();
                // $.ajax({
                //     url: getBasePath() + 'alterar-verba-click/' + id_number,
                //     dataType: 'json',                  
                //     data: {
                //         'verba_click': newVerba
                //     },
                //     method: 'post'
                // }).done(function (data) {
                //     console.log('response: ', data);
                //     $.alert('Verba Click alterada!');
                // }).fail(function (e) {
                //     console.log('erro: ', e)
                //     $.alert('Erro de solicitação.');
                // });

            },
            Cancelar: function () {
                $.alert('Cancelado!');
            },
        }
    });
});