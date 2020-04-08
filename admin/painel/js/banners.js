$(document).ready(function(){
    
    var select_banner = $("#select_banner");
    var slug = $("#slug");
   
    select_banner.on('change', function(){
        var idFilme = $(this).val();
        
        $.ajax({
            url: '../../inc/banners.php',
            type:'post',
            data:'cadastrarBanner=ok&id='+idFilme,
            success: function(data){
                slug.val(data);
            }
        }); 
    });
});