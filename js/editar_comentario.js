$(document).ready(function(){
    
    var edit = $("#conteudo").find("#edit");
    var edit_comentario = $("#conteudo").find($("#edit_comentario"));
    var deletar_comentario = $("#conteudo").find("#deletar_comentario");
    
    
     /*
      *FUNCAO PARA REDIRECIONAR
      */
    var redirecionarURL = function(){
        var urlSite = $(location).attr('href');
        setTimeout( function() {
            location=urlSite
        }, 1000 );
    }
    
    
    /*
     *EDITAR COMENTARIO
     */
    $("#conteudo #edit").on('click',edit ,function(event){
        event.preventDefault();      
        var idComentario = $(this).attr('data-id');
        
        $.ajax({
            url: "../../modulos/alterar/comentario.php",
            data: "id="+idComentario,
            type: "post",
            success: function(data){
                $(event.currentTarget).closest(".listar_comentarios").find(".editar_comentario_jquery").toggle();
                $(event.currentTarget).closest(".listar_comentarios").find(".editar_comentario_jquery").html(data);
            }   
        }) ; 
    });
    
    
    /*
     *DELETAR COMENTARIO
     */
    $("#conteudo #deletar_comentario").on('click',deletar_comentario ,function(event){
        event.preventDefault();
        var idComentario = $(this).attr('data-id');
        $.ajax({
            url: "../../modulos/excluir/comentario.php",
            data: "id="+idComentario,
            type: "post",
            success: function(data){
              redirecionarURL();
            }   
        }) ; 
    });
    
});