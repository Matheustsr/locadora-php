$(document).ready(function(){
    
    $.getJSON("modulos/listar/comentarios_cliente.php", function(comentarios_cliente){
         

        function pageselectCallback(page_index, jq){
            // Get number of elements per pagionation page from form
            var items_per_page = 5;
            var max_elem = Math.min((page_index+1) * items_per_page, comentarios_cliente.length);
            var newcontent = '';
                
            // Iterate through a selection of the content and build an HTML string
            for(var i=page_index*items_per_page;i<max_elem;i++)
            {
                newcontent += '<dt>' + comentarios_cliente[i]['comentarios_cliente'] + '</dt>';
                newcontent += '<dd class="state">' + comentarios_cliente[i]['filmes_nome'] + '</dd>';
                newcontent += '<dd class="party">' + comentarios_cliente[i]['comentarios_texto']+ '</dd>';
            }
                
            // Replace old content with new content
            $('.content').html(newcontent);
                
            // Prevent click eventpropagation
            return false;
        }

        function getOptionsFromForm(){
            var opt = {
                callback: pageselectCallback
            };
            return opt;
        }
			


        var optInit = getOptionsFromForm();
        $("#Pagination").pagination(comentarios_cliente.length, optInit);
    });
                
});