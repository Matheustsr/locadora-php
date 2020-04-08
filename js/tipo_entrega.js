$(document).ready(function(){
    
    $("input[name=tipo_entrega]").on("click", function(){
        
        var tipo_entrega = $(this).val();
        $.ajax({
            url : "modulos/listar/tipo_entrega.php",
            type: 'post',
            data: 'tipo='+tipo_entrega,
            success: function(){
                
            }
        })
        
    });
});