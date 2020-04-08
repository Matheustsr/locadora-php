$(document).ready(function(){
    
    var buscar_filmes_locados =  $(".busca_locados").find("#buscar_filmes");
    var tabela = $(".table").find($("#example"));
    
    buscar_filmes_locados.on("keyup", function(){
        var busca_digitada = $(this).val();
        var pagina = $(this).attr('data-pagina');
        $.ajax({
            url: "inc/"+pagina+".php",
            type:"post",
            data:"busca="+busca_digitada,
            //beforeSend: tabela.html("<p id='realizando_busca'>Aguarde, realizando a busca</p>"),
            success: function(data){
                $("tbody").html(data);
            }      
        });
    });
    
    
    $("body").on('click', 'a#devolveu', function(event){
        event.preventDefault();
        var id = $(this).attr('data-id');
        $.ajax({
            url: "inc/buscar_filmes_locados.php",
            type:"post",
            data:"status=ok&id="+id,
            //beforeSend: tabela.html("<p id='realizando_busca'>Aguarde, realizando a busca</p>"),
            success: function(data){
                $("tbody").html(data);
            }      
        });         
    }); 
    
    
    $("body").on('click', 'a#remover', function(event){
        event.preventDefault();
        var id = $(this).attr('data-id');
        $.ajax({
            url: "inc/buscar_filmes_locados.php",
            type:"post",
            data:"remover=ok&idLocado="+id,
            //beforeSend: tabela.html("<p id='realizando_busca'>Aguarde, realizando a busca</p>"),
            success: function(data){
                $("tbody").html(data);
            }      
        });         
    }); 
    
});