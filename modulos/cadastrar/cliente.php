<div id="pagina">

    <?php
    try {
        if (isset($_POST['ok'])):

            /* PEGAR DADOS COM AS VALIDACOES */
            $nome = validarDados($_POST['nome'], "nome", "STRING");
            $email = validarDados($_POST['email'], "email", "EMAIL");
            $cidade = validarDados($_POST['cidade'], "cidade", "STRING");
            $telefone = validarDados($_POST['telefone'], "telefone", "STRING");
            $celular = validarDados($_POST['celular'], "celular", "STRING");
            $cpf = validarDados($_POST['cpf'], "cpf", "STRING");
            $newsletter = validarDados($_POST['newsletter'], "newsletter", "STRING");
            $login = validarDados($_POST['login'], "login", "STRING");
            $senha = validarDados($_POST['senha'], "senha", "STRING");


            /* DELETAR AS SESSOES */
            $sessoes = array('nome', 'email', 'cidade', 'telefone', 'celular', 'cpf', 'login', 'senha');
            foreach ($sessoes as $s):
                if (isset($_SESSION[$s])):
                    unset($_SESSION[$s]);
                endif;
            endforeach;


            /* PEGAR OS DADOS DIGITADOS */
            recuperaDados('nome', $nome);
            recuperaDados('email', $email);
            recuperaDados('cidade', $cidade);
            recuperaDados('telefone', $telefone);
            recuperaDados('celular', $celular);
            recuperaDados('cpf', $cpf);
            recuperaDados('login', $login);
            recuperaDados('senha', $senha);

            global $mensagem;

            if (!isset($mensagem)):
                /* SE NAO TIVER NENHUM ERRO */
                $pastaFotosClientes = "fotos/clientes/";
                $pastaFotosClientesDetalhes = "fotos/clientes/detalhes/";


                if (empty($_FILES['foto']['name'])):
                    $novoNomeFoto = 'sem_foto.jpg';
                else:
                    $extensao = end(explode(".", $_FILES['foto']['name']));
                    $novoNomeFoto = uniqid() . "." . $extensao;
                    $temp = $_FILES['foto']['tmp_name'];


                    $imagem = WideImage::load($temp);
                    $redimensionar = $imagem->resize(37, 36, "fill");
                    $redimensionar->saveToFile($pastaFotosClientes . $novoNomeFoto);


                    $redimensionar = $imagem->resize(80, 75, "fill");
                    $redimensionar->saveToFile($pastaFotosClientesDetalhes . $novoNomeFoto);

                    /* DADOS CADASTRADO NO BANCO */
                    $fotoCadastrada = $pastaFotosClientes . $novoNomeFoto;
                    $fotoCadastradaDetalhes = $pastaFotosClientesDetalhes . $novoNomeFoto;

                endif;


                $dados = array(
                    "nome" => $nome,
                    "email" => $email,
                    "cidade" => $cidade,
                    "telefone" => $telefone,
                    "celular" => $celular,
                    "cpf" => $cpf,
                    "newsletter" => $newsletter,
                    "foto" => $pastaFotosClientes . $novoNomeFoto,
                    "fotoDetalhes" => $pastaFotosClientesDetalhes . $novoNomeFoto,
                    "login" => $login,
                    "senha" => md5($senha)
                );

                if (existeCadastro("clientes", "clientes_nome", $nome)):
                    $erro = "Ja existe um cliente cadastrado com esse nome !";
                else:
                    if (existeCadastro('clientes', 'clientes_login', $login)):
                        $erro = 'Já existe um login cadastrado come esse nome';
                    else:
                        if (cadastrarCliente($dados)):
                            $sucesso = "Cadastrado com sucesso";
                            ?>
                            <script type="text/javascript">
                                setTimeout("window.close()", 2000);                              
                            </script>
                            <?php
                        else:
                            unlink($fotoCadastrada);
                            unlink($fotoCadastradaDetalhes);
                            $erro = "Erro ao cadastrar cliente";
                        endif;
                    endif;

                endif;

            else:
                /* SE TIVER ERRO ATRIBUI ELE PARA A VARIAVEL ERRO */
                throw new Exception($mensagem);
            endif;
        else:
            throw new Exception('Preencha o formulário de cadastro');

        endif;
    } catch (Exception $e) {
        $erro = $e->getMessage();
    }

    if (isset($erro)):
        echo '<div class="mensagem">' . $erro . "<br />";
        echo '<a href="http://netfilmes.com.br/cadastro">Voltar</a>';
        echo '</div>';
    else:
        echo '';
    endif;


    if (isset($sucesso)):
        echo '<div class="mensagem">' . $sucesso . "<br />";
        echo '<a href="http://netfilmes.com.br/cadastro">Voltar</a>';
        echo '</div>';
    else:
        echo '';
    endif;
    ?>
</div>