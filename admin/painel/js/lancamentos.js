$(document).ready(function(){
    var lancamento =  $("#lancamento");
    
    $("#example #lancamento").on('click', lancamento,function(){
        var valor = $(this).val();
        var id = $(this).attr('data-id');
        $.ajax({
            url: '?p=filmes',
            type: 'post',
            data: 'alterarlancamento=ok&id='+id+'&valor='+valor
                  
        });
    });
})