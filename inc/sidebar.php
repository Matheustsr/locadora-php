<!-- genero -->
<div class="genero">
    <h2>GÊNEROS</h2>
    <ul>
        <?php
        $categoria = listar("categorias", "where categorias_visivel = 'habilitado'");
        $c = new ArrayIterator($categoria);
        while ($c->valid()):
            ?>
            <li><a href="http://netfilmes.com.br/categoria/<?php echo $c->current()->categorias_slug; ?>"><?php echo $c->current()->categorias_nome; ?></a></li>
            <?php
            $c->next();
        endwhile;
        ?>
    </ul>
</div>
<!-- genero -->


<!-- pesquisa -->
<div class="pesquisa">
    <h2>PESQUISAR</h2> 
    <form action="http://netfilmes.com.br/pesquisa" method="post">
        <input type="text" name="pesquisa" class="btpesquisa"/>
        <input type="submit" name="ok" id="button" value="OK" class="btok"/>
    </form>
</div>
<!-- pesquisa -->


<!--LOGIN-->
<div class="login">
    <h2>LOGIN</h2>
    <div id="form_login_sidebar">
        <?php if (!isset($_SESSION['logado_cliente'])): ?>
            <form action="" method="post">
                <label for="login">Login:</label>
                <input type="text" name="login" class="text_login" />

                <label for="senha">Senha:</label>
                <input type="password" name="senha" class="text_login" />

                <label for="submit"></label>
                <input type="submit" name="logar" value="Fazer login" class="button_sidebar" />
            </form>
        <?php else: ?>
            <a href="http://netfilmes.com.br/?logout=ok">Sair</a><br />
            Bem Vindo <?php echo $_SESSION['nome_cliente']; ?>
        <?php endif; ?>
        <div class="fix"></div>
    </div>
    <?php echo (isset($erroLogin)) ? '<div id="erroLogin">' . $erroLogin . '</div>' : ''; ?>
    <?php echo (isset($deslogado)) ? '<div id="erroLogin">' . $deslogado . '</div>' : ''; ?>
</div>
<!-- login -->


<!-- newslleter -->
<div class="newslleter">
    <h2>NEWSLLETER</h2>
    <div id="form_newsletter_sidebar">
        <form action="http://netfilmes.com.br/modulos/cadastrar/newsletter" method="post">
            <label for="email">E-mail</label>
            <input type="text" name="email" class="text_newsletter"  />

            <label for="submit"></label>
            <input type="submit" name="cadastrar_newsletter" value="Assinar" class="button_sidebar" />
        </form>
    </div>
</div>
<!-- newslleter -->



<!-- opnioes --> 
<div class="opnioes">
    <h2>OPINIÕES</h2>
    <div id="opinioes_sidebar">
        <?php
        $opinioes = listar('comentarios', 'INNER JOIN filmes ON comentarios.comentarios_filme = filmes.filmes_id ORDER BY comentarios_data DESC LIMIT 7');
        $o = new ArrayIterator($opinioes);
        while ($o->valid()):
            ?>
            <p><a href="http://netfilmes.com.br/detalhes/filme/<?php echo $o->current()->filmes_slug; ?>"><?php echo resumeTexto($o->current()->comentarios_texto,55); ?></a> - <?php  echo $o->current()->filmes_nome; ?></p>
            <?php
            $o->next();
        endwhile;
        ?>
    </div>
</div>
<!-- opnioes --> 