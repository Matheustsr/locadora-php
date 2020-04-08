
$(document).ready(function(){
    
    function drawVisualization() {
                         
        $.getJSON("charts/mais_locados_cliente.php", function(dados){
         
            if(dados.length >= 5){   
                var todos_filmes = [];
                var todas_locacoes = [];
                    
                for(var i=0;i<dados.length;i++){
                    todos_filmes.push(dados[i]['filmes_nome']);
                    todas_locacoes.push(parseInt(dados[i]['locacoes_cliente_total']));
                    var mesAtual = dados[i]['meses_nome'];
                }
                      
                      
                // Create and populate the data table.
                var data = google.visualization.arrayToDataTable([
                    ['Mês', todos_filmes[0], todos_filmes[1], todos_filmes[2],todos_filmes[3],todos_filmes[4]],
                    [mesAtual, todas_locacoes[0] , todas_locacoes[1], todas_locacoes[2], todas_locacoes[3],todas_locacoes[4]],
                    ]);

                // Create and draw the visualization.
                new google.visualization.BarChart(document.getElementById('visualization')).
                draw(data,
                {
                    title:"Filmes mais locados pelo cliente",
                    width:1100, 
                    height:400,
                    vAxis: {
                        title: "Mês"
                    },
                    hAxis: {
                        title: "Locações"
                    }
                }
                ); 
            }else{
                $("#visualization").append("<div id='grafico_indisponivel'>Dados insuficientes para gerar o gráfico.</div>")
            }     
        });
    }
    google.setOnLoadCallback(drawVisualization);  
});