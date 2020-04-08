$(document).ready(function(){
    
    var noticia =  $("#noticia_titulo");
    var slug = $("#slug_noticia");
  
    noticia.on('keyup', function(){      
        $.ajax({
            url: '../../modulos/cadastrar/slug_noticia.php',
            type:'post',
            data: 'noticia='+noticia.val(),
            success: function(data){
                  slug.val(data);
            }       
        });
    });   
})