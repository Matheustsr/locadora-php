$(document).ready(function(){
    
    var tbody = $("tbody");
    var input_cliente = tbody.find($("#input_cliente"));
    var linkLocar = tbody.find($("#locarFilme"));
    
    $("#example #input_cliente").on('keyup',input_cliente,function(event){
        var id_filme = $(this).attr('data-id');
        var nome_cliente = $(this).val();
        $.ajax({
            url: "inc/link_locar.php",
            type:"post",
            data: "filme="+id_filme+"&cliente="+nome_cliente,
            success: function(data){               
                $(event.currentTarget).closest('tr').children("tbody #locar").find("#link").html(data);
            }
        });
    });
    
    $("#example #link").on('click',linkLocar,function(event){
        event.preventDefault();
        var idFilme = $(this).find("#locarFilme").attr('data-filme');
        var idCliente = $(this).find("#locarFilme").attr('data-id');
        var nomeCliente = $(this).find("#locarFilme").attr('data-cliente')
       
        $.ajax({
            url: "inc/locar.php",
            type:"post",
            data: "locar=ok&filme="+idFilme+"&cliente="+idCliente,
            success: function(data){                        
                $("#mensagem_filme_locado").append('<div id="msg_filme_locado">Filme locado para '+nomeCliente+'</div>');
                setTimeout("window.location.href='http://netfilmes.com.br/admin/painel/?p=filmes'", 2000);
            }
        });   
    });  
})