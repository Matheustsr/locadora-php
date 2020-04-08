$(document).ready(function(){
    
    var edit_comentario = $("#conteudo").find($("#edit_comentario"));
    
    var redirecionarURL = function(){
        var urlSite = $(location).attr('href');
        setTimeout( function() {
            location=urlSite
        }, 1500 );
    }

      
    $("#conteudo #edit_comentario").on('click', edit_comentario,function(event){
        event.preventDefault();
        var id = $(event.currentTarget).closest("#form_edit_comentario").find("#id").attr('data-id');
        var comentario = $(event.currentTarget).closest("#form_edit_comentario").find("#comentario").val();
        $.ajax({
            url: '../../modulos/alterar/comentario_jquery.php',
            type: 'post',
            data: 'atualizar_comentario=ok&id='+id+'&comentario='+comentario,
            success: function(data){            
                $(".mensagem_alterar_comentario").html(data);
                redirecionarURL();
            }   
        });
    });
});

