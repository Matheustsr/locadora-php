$(document).ready(function(){
    var aprovar =  $("#aprovar");
    
    $("#example #aprovar").on('click', aprovar,function(){
        var valor = $(this).val();
        var id = $(this).attr('data-id');
        $.ajax({
            url: '?p=comentarios',
            type: 'post',
            data: 'aprovarComentario=ok&id='+id+'&valor='+valor   
        });
    });
})