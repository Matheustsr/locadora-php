$(document).ready(function(){
    
    var slug = $("#slug");
    var link = $("#link");
    var rd_visivel = $("#visivelMenu");
    
    slug.on('keyup',function(){            
        link.val("http://netfilmes.com.br/"+$(this).val());
    });
    
    $("#example #visivelMenu").on('click', rd_visivel, function(){
        var valor = $(this).val();
        var id = $(this).attr('data-id');
        $.ajax({
            url: '?p=menus',
            type: 'post',
            data: 'alterarStatus=ok&id='+id+'&valor='+valor,
            success: function(){
                window.location.href='http://netfilmes.com.br/admin/painel/?p=menus';
            }
        })
        
    });
});
