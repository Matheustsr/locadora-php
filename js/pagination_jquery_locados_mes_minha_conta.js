$(document).ready(function(){
    $.getJSON("modulos/listar/locados_mes_minha_conta.php", function(data){
        
        
        if($(data).length <= 0){
            $('#locados_mes').html('<div class="mensagem">Nenhum filme locados messe mês até o momento</div>');
        }else{
        
        
            function pageselectCallback(page_index, jq){
                // Get number of elements per pagionation page from form
                var items_per_page = 5;

                var max_elem = Math.min((page_index+1) * items_per_page, data.length);
                var newcontent2 = '';
            
                newcontent2 += '<h4>Mais locados do mês</h4>';
                newcontent2 += '<table width="780" cellspacing="0" class=tabela_meus_dados>';
                newcontent2 += '<thead>';
                newcontent2 += '<tr>';
                newcontent2 += '<th>Foto</th>';
                newcontent2 += '<th>Filme</th>';
                newcontent2 += '<th align="center">Total locações</th>';
                newcontent2 += '</tr>';
                newcontent2 += '</thead>';
                newcontent2 += '<tbody>';   
                      
                // Iterate through a selection of the content and build an HTML string
                for(var i=page_index*items_per_page;i<max_elem;i++)
                {   
                    newcontent2 += '<tr class="tabela_filmes_locados">';
                    newcontent2 += '<td width="20%"><a href="http://netfilmes.com.br/detalhes/filme/'+data[i]['filmes_slug']+'"><img src="'+data[i]['filmes_foto']+'" width="45" height="35" /></a></td>';
                    newcontent2 += '<td class="state">' + data[i]['filmes_nome'] + '</td>';
                    newcontent2 += '<td class="state" align="center">' + data[i]['locacoes_cliente_total'] + '</td>';                
                    newcontent2 += '</tr>';
                }
                newcontent2 += '<tbody></table>';  
                // Replace old content with new content
                $('#locados_mes').html(newcontent2);
                
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
            $("#Pagination_locados").pagination(data.length, optInit);
        }
    });
});