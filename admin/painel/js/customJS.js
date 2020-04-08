window.onload = function(){
    
    setInterval("refresh()", 50000);
    
    var cadastrarAdmin = document.getElementById("cadastrarAdmin");
    var cadastrarCliente = document.getElementById("cadastrarCliente");
    var cadastrarFilme = document.getElementById("cadastrarFilmes");
    var cadastrarCategoria = document.getElementById("cadastrarCategoria");
    var cadastrarMenus= document.getElementById("cadastrarMenus");
    var cadastrarBanner= document.getElementById("cadastrarBanner");
    var cadastrarNoticia= document.getElementById("cadastrarNoticia");

    if(cadastrarAdmin == null){
        cadastrarAdmin = new Object();
    }else{
        cadastrarAdmin.onclick = function(event){
            event.preventDefault();
            window.open("modulos/cadastrar/administrador.php","Cadastrar","width=400, height=450, left=300,top=100");
        }
    }
    
    
    if(cadastrarCliente == null){
        cadastrarCliente = new Object();
    }else{
        cadastrarCliente.onclick = function(event){
            event.preventDefault();
            window.open("modulos/cadastrar/cliente.php","Cadastrar","width=400, height=620, left=300,top=100");
        }
    }
    
     
    if(cadastrarFilme == null){
        cadastrarFilme = new Object();
    }else{
        cadastrarFilme.onclick = function(event){
            event.preventDefault();
            window.open("modulos/cadastrar/filme.php","Cadastrar","width=650, height=780, left=300,top=100");
        }
    }
    
    if(cadastrarCategoria == null){
        cadastrarCategoria = new Object();
    }else{
        cadastrarCategoria.onclick = function(event){
            event.preventDefault();
            window.open("modulos/cadastrar/categoria.php","Cadastrar","width=650, height=400, left=300,top=100");
        }
    }
    
    if(cadastrarMenus == null){
        cadastrarMenus = new Object();
    }else{
        cadastrarMenus.onclick = function(event){
            event.preventDefault();
            window.open("modulos/cadastrar/menu.php","Cadastrar","width=650, height=400, left=300,top=100");
        }
    }
    
    if(cadastrarBanner == null){
        cadastrarBanner = new Object();
    }else{
        cadastrarBanner.onclick = function(event){
            event.preventDefault();
            window.open("modulos/cadastrar/banner.php","Cadastrar","width=650, height=400, left=300,top=100");
        }
    }
    
    if(cadastrarNoticia == null){
        cadastrarNoticia = new Object();
    }else{
        cadastrarNoticia.onclick = function(event){
            event.preventDefault();
            window.open("modulos/cadastrar/noticia.php","Cadastrar","width=450, height=500, left=300,top=100");
        }
    }
    
}

//ABRIR JANELA ALTERAR
function janelaAlterar(id,pagina){
    window.open("modulos/alterar/"+pagina+".php?id="+id,"Cadastrar","width=600, height=750, left=300,top=10");
}

/*DELETAR USUARIO*/
function deletar(id, pagina){
    if(confirm("Tem certeza que deseja deletar ?")){
        window.open("modulos/deletar/"+pagina+".php?id="+id,"Deletar","width=400, height=450, left=300,top=100");
    }else{
        return false;
    } 
}

function refresh(){
    window.location = "http://netfilmes.com.br/admin/painel/index.php";
}