$(document).ready(function(){
    
    $.getJSON("modulos/listar/comentarios_minha_conta.php", function(data){

        if($(data).length <= 0){
            $('#comentarios_cliente').html('<div class="mensagem">Nenhum comentário feito até o momento</div>');
        }else{
            function pageselectCallback(page_index, jq){
                // Get number of elements per pagionation page from form
                var items_per_page = 5;
                var max_elem = Math.min((page_index+1) * items_per_page, data.length);
                var newcontent = '';
            
                newcontent += '<h4>Comentários</h4>';
                newcontent += '<table width="780" cellspacing="0" class=tabela_meus_dados>';
                newcontent += '<thead>';
                newcontent += '<tr>';
                newcontent += '<th>Filme</th>';
                newcontent += '<th align="center">Comentário</th>';
                newcontent += '</tr>';
                newcontent += '</thead>';
                newcontent += '<tbody>';   
                      
                // Iterate through a selection of the content and build an HTML string
                for(var i=page_index*items_per_page;i<max_elem;i++)
                {   
                    newcontent += '<tr class="tabela_filmes_locados">';
                    newcontent += '<td width="20%"><a href="http://netfilmes.com.br/detalhes/filme/'+data[i]['filmes_slug']+'">' + data[i]['filmes_nome'] + '</a></td>';
                    newcontent += '<td class="state">' + data[i]['comentarios_texto'] + '</td>';
                    newcontent += '</tr>';
                }
                newcontent += '<tbody></table>';  
                // Replace old content with new content
                $('#comentarios_cliente').html(newcontent);
                
                // Prevent click eventpropagation
                return false;
            }
            

            function getOptionsFromForm(){
                var opt = {
                    callback: pageselectCallback
                };
      
                return opt;
            }
    
            // Create pagination element with options from form
            var optInit = getOptionsFromForm();
            $("#Pagination_comentarios").pagination(data.length, optInit);

        }
    });
});
