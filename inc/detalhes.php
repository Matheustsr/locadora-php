<?php carregarArquivos(array('locar')); ?>
<div id="pagina">
    <?php
    try {
        /* PEGA O SEGMENTO DA URL PARA USAR COMO SLUG */
        $segmento = count(explode("/", $_GET['p']));
        $slug = segmento_url($_GET['p'], $segmento);
        $filmes = pegarPeloId('filmes', 'filmes_slug', $slug);
        if (empty($filmes)):
            throw new Exception('Escolha uma filme !');
        else:
            $categoria = pegarPeloId('categorias', 'categorias_id', $filmes->filmes_categoria);
            ?>
            <!--DETALHES DO FILME COM A FOTO DESCRICAO DO FILME E MAIS DETLAHES-->
            <div id="foto_descricao">

                <!--PEGAR O NOME DA filme ATUAL-->
                <h2><?php echo $filmes->filmes_nome; ?></h2>
                <!--LISTAR O FILME ESCOLHIDO-->      
                <div id="foto_detalhes_filme">
                    <img src="http://netfilmes.com.br/<?php echo $filmes->filmes_foto_descricao; ?>" />
                    <div id="filme_detalhes"> 
                        <ul id="detalhes_lista_fime">
                            <li>Lançamento: <?php echo $filmes->filmes_lancamento; ?></li>
                            <li>Código do Filme: <?php echo $filmes->filmes_codigo; ?></li>
                            <li>Categoria do Filme: <?php echo $categoria->categorias_nome; ?><br />
                            <li>Preço do Filme: R$ <?php echo number_format($filmes->filmes_preco, 2, ",", "."); ?></li>
                        </ul>
                    </div>

                    <div id="botao_locar">
                        <?php
                        $locado = pegarPeloId('locados', 'locados_filme', $filmes->filmes_id);
                        if (!empty($locado)):
                            ?>
                            <img src="http://netfilmes.com.br/imagens/indisponivel_detalhes.jpg" />
                        <?php else: ?>                      
                            <a href="http://netfilmes.com.br/meus_filmes/filme/<?php echo $filmes->filmes_slug; ?>"><img src="http://netfilmes.com.br/imagens/locar_detalhes.jpg" /></a>
                        <?php endif; ?>
                    </div>

                    <!--DESCRICAO DO FILME-->
                </div>
                <div id="descricao_filme"><?php echo stripslashes($filmes->filmes_descricao); ?></div>
                <div class="fix"></div>
            </div>

            <!--SUGESTOES DE FILMES-->
            <div id="sugestoes_comentarios">
                <div id="sugestoes_filmes">
                    <h3>Filmes que talvez você possa se interessar</h3>


                    <?php
                    $sugestoes = listar("filmes", " where filmes_categoria = $filmes->filmes_categoria and filmes_id != $filmes->filmes_id order by rand() LIMIT 6");
                    if (!empty($sugestoes)):

                        $s = new ArrayIterator($sugestoes);
                        while ($s->valid()):
                            ?>
                            <!--BOTAO DE LOCAR OU INDISPONIVEL-->

                            <div class="filmes_categoria">


                                <?php
                                /* VERIFICA SE FILME ESTA LOCADO E COLOCA UMA FAIXA EM CIMA DA FOTO DO FILME */
                                $verificaLocado = listar('locados', 'where locados_filme = ' . $s->current()->filmes_id);

                                if (!empty($verificaLocado)):
                                    ?>
                                    <div class="faixa_locado"><img src="http://netfilmes.com.br/imagens/faixa.png" /></div>
                                    <?php
                                endif;
                                /* VERIFICA SE FILME ESTA LOCADO E COLOCA UMA FAIXA EM CIMA DA FOTO DO FILME */
                                ?>


                                <h3><?php echo $s->current()->filmes_nome; ?></h3>
                                <div class="foto_filme_categoria"><img src="http://netfilmes.com.br/<?php echo $s->current()->filmes_foto; ?>" /></div>
                                <div class="dados_filme">
                                    <?php echo "Código do filme " . $s->current()->filmes_codigo; ?><br />
                                    <?php echo "R$ " . number_format($s->current()->filmes_preco, 2, ",", "."); ?><br /><br />
                                    <a href="http://netfilmes.com.br/detalhes/filme/<?php echo $s->current()->filmes_slug; ?>" class="bt_detalhes">Detalhes</a> | 
                                    <?php
                                    if (!empty($verificaLocado)):
                                        ?>
                                        Filme Locado
                                        <?php
                                    else:
                                        //SE ESTIVER LOGADO VAI DIRETO PARA A PAGINA MEUS FILMES SENAO VAI PARA A PAGINA
                                        //VERIFICA_LOGADO
                                        (!isset($_SESSION['logado_cliente'])) ? $link = 'verifica_logado' : $link = 'meus_filmes/filme/' . $s->current()->filmes_slug;

                                        if (isset($_SESSION['locar']) && array_key_exists($s->current()->filmes_id, $_SESSION['locar'])):
                                            echo 'Filme já escolhido';
                                        else:
                                            ?>
                                            <a href="http://netfilmes.com.br/<?php echo $link; ?>" class="locar_filme">Locar Filme</a>
                                        <?php
                                        endif;
                                    endif;
                                    ?>
                                </div>        
                            </div>
                            <?PHP
                            $s->next();
                        endwhile;
                    endif;
                    ?>
                    <div class="fix"></div>
                </div>


                <!--COMENTARIOS DO FILMES-->
                <div id="comentarios">
                    <h3>Comentários (<?php echo contarPeloId('comentarios', 'comentarios_filme', $filmes->filmes_id); ?> comentários)</h3>

                    <?php
                    $listarComentarios = listar("comentarios", "INNER JOIN clientes ON comentarios.comentarios_cliente = clientes.clientes_id WHERE comentarios_filme = $filmes->filmes_id AND comentarios_aprovado = 1");
                    if (empty($listarComentarios)):
                        echo '<div id="sem_comentarios">Nenhum comentário cadastrado para esse filme, seja o primeiro</div>';
                    else:
                        $l = new ArrayIterator($listarComentarios);
                        while ($l->valid()):
                            ?> 
                            <!--LISTAR COMENTARIOS-->
                            <div class="listar_comentarios">                
                                <div class="foto_cliente">  
                                    <?php if (!empty($l->current()->clientes_foto)) { ?>

                                        <?php if (!is_file($l->current()->clientes_foto)): ?>
                                            <img src="http://netfilmes.com.br/fotos/clientes/sem_foto.jpg" />
                                        <?php else: ?>
                                            <img src="http://netfilmes.com.br/<?php echo $l->current()->clientes_foto; ?>" />
                                        <?php endif; ?>

                                    <?php }else { ?>
                                        <img src="http://netfilmes.com.br/fotos/clientes/sem_foto.jpg" />
                                    <?php } ?>
                                </div>
                                <div class="comentarios_cliente">
                                    <div class="data_comentario">Comantário feito por <?php echo $l->current()->clientes_nome; ?> no dia <?php echo date("Y/m/d H:i:s", strtotime($l->current()->comentarios_data)); ?></div>
                                    <?php echo nl2br($l->current()->comentarios_texto); ?>
                                </div>

                                <!--EDITAR OU DELETAR COMENTARIO-->
                                <div class="edit_comentario">
                                    <?php
                                    if (isset($_SESSION['logado_cliente'])):
                                        if (checkEdit($l->current()->clientes_id, $l->current()->comentarios_id)):
                                            $idCliente = pegarPeloId('clientes', 'clientes_nome', $_SESSION['nome_cliente']);
                                            if ($l->current()->clientes_id == $idCliente->clientes_id):
                                                ?>
                                                <a href="#" id="edit" data-id="<?php echo $l->current()->comentarios_id; ?>"><img src="http://netfilmes.com.br/imagens/edit.png" /></a> | <a href="#" id="deletar_comentario" data-id="<?php echo $l->current()->comentarios_id; ?>"><img src="http://netfilmes.com.br/imagens/delete.png" /></a>                                                         

                                                <?php
                                            endif;
                                        endif;
                                    endif;
                                    ?>

                                </div>
                                <div class="editar_comentario_jquery"></div>      

                                <div class="fix"></div>
                            </div>
                            <?php
                            $l->next();
                        endwhile;
                    endif;
                    ?>

                    <div class="fix"></div>     


                    <!--FORMULARIO PARA COMENTARIOS-->
                    <div id="form_comentarios">
                        <?php if (isset($_SESSION['logado_cliente'])): ?>
                            <form action="http://netfilmes.com.br/modulos/cadastrar/comentarios" method="post">
                                <label for="nome">Nome:</label>
                                <input type="text" name="nome" value="<?php echo isset($_SESSION['nome_cliente']) ? $_SESSION['nome_cliente'] : '' ?>" class="input_text" />

                                <input type="hidden" name="id" value="<?php echo $filmes->filmes_id; ?>" />
                                <input type="hidden" name="comentou" value="ok" />
                                <input type="hidden" name="filme" value="<?php echo $filmes->filmes_id; ?>" />

                                <label for="email">E-mail:</label>
                                <input type="text" name="email" value="<?php echo isset($_SESSION['email_cliente']) ? $_SESSION['email_cliente'] : '' ?>" class="input_text" />

                                <label for="comentario">Comentário:</label>
                                <textarea name="comentario" class="input_textarea"></textarea>

                                <label for="submit"></label>
                                <input type="submit" name="comentar" value="Comentar" class="input_submit" />
                            <?php else: ?>
                                <div id="sem_comentarios">Você tem que estar logado para fazer um comentário.</div>
                            <?php endif; ?>
                        </form>
                    </div>

                    <div class="fix"></div>
                </div>
            </div>

        <?php
        endif;
    } catch (Exception $e) {
        echo '<div class="erro_categoria">' . $e->getMessage() . '</div>';
    }
    ?>
    <div class="fix"></div>
</div>