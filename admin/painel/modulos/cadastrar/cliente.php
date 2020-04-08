<?php
require_once "../../functions/functions.php";
carregarArquivos(array('validacoes', 'cadastrar', 'selecionar', 'wide_image'));

if (isset($_POST['ok']) AND $_SERVER['REQUEST_METHOD'] == 'POST'):

    $nome = validarDados($_POST['nome'], "nome", "STRING");
    $email = validarDados($_POST['email'], "email", "EMAIL");
    $cidade = validarDados($_POST['cidade'], "cidade", "STRING");
    $telefone = validarDados($_POST['telefone'], "telefone", "STRING");
    $celular = validarDados($_POST['celular'], "celular", "STRING");
    $cpf = validarDados($_POST['cpf'], "cpf", "STRING");
    $newsletter = validarDados($_POST['newsletter'], "newsletter", "STRING");
    $login = validarDados($_POST['login'], "login", "STRING");
    $senha = validarDados($_POST['senha'], "senha", "STRING");

    if (!isset($mensagem)):

        $pastaFotosClientes = "fotos/clientes/";
        $pastaFotosClientesDetalhes = "fotos/clientes/detalhes/";


        if (empty($_FILES['foto']['name'])):
            echo 'sem foto';
            $novoNomeFoto = 'sem_foto.jpg';
        else:
            $extensao = end(explode(".", $_FILES['foto']['name']));
            $novoNomeFoto = uniqid() . "." . $extensao;
            $temp = $_FILES['foto']['tmp_name'];


            $imagem = WideImage::load($temp);
            $redimensionar = $imagem->resize(37, 36, "fill");
            $redimensionar->saveToFile("../../../../" . $pastaFotosClientes . $novoNomeFoto);


            $redimensionar = $imagem->resize(80, 75, "fill");
            $redimensionar->saveToFile("../../../../" . $pastaFotosClientesDetalhes . $novoNomeFoto);

            /* DADOS CADASTRADO NO BANCO */
            $fotoCadastrada = "../" . $pastaFotosClientes . $novoNomeFoto;
            $fotoCadastradaDetalhes = "../../" . $pastaFotosClientesDetalhes . $novoNomeFoto;

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
                    $sucesso = "Cliente cadastrado com sucesso";
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
        $erro = $mensagem;
    endif;

endif;
?>

<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="../../css/styleJanela.css" rel="stylesheet" type="text/css" />
        <link href='http://fonts.googleapis.com/css?family=Cuprum' rel='stylesheet' type='text/css' />
    </head>
    <body>
        <div class="form_cadastrar">

            <div class="form">

                <h2>Cadastrar Cliente</h2>

                <form action="" method="post" enctype="multipart/form-data">
                    <label for="nome">Nome:</label>
                    <input type="text" name="nome" class="input" />

                    <label for="email">E-mail:</label>
                    <input type="text" name="email" class="input" />

                    <label for="cidade">Cidade:</label>
                    <input type="text" name="cidade" class="input" />

                    <label for="telefone">Telefone:</label>
                    <input type="text" name="telefone" id="telefone" class="input" />

                    <label for="celular">Celular:</label>
                    <input type="text" name="celular" id="celular" class="input" />

                    <label for="cpf">CPF:</label>
                    <input type="text" name="cpf" id="cpf" class="input" />

                    <label for="login">Login:</label>
                    <input type="text" name="login" class="input" />

                    <label for="senha">Senha:</label>
                    <input type="text" name="senha" class="input" />

                    <label for="login">Newsletter:</label>
                    SIM
                    <input type="radio" name="newsletter" value="sim" class="input_radio" />
                    NÃO
                    <input type="radio" name="newsletter" value="nao" class="input_radio" />

                    <label for="foto">Foto:</label>
                    <input type="file" name="foto" class="input_file" />

                    <label for="submit"></label>
                    <input type="submit" name="ok" value="Cadastrar" class="input_button" />
                </form>

                <?php echo isset($erro) ? '<div class="erro">' . $erro . '</div>' : ''; ?>
                <?php echo isset($sucesso) ? '<div class="sucesso">' . $sucesso . '</div>' : ''; ?>

            </div>
        </div>  
        <script type="text/javascript" src="../../js/jquery.js"></script>
        <script type="text/javascript" src="../../js/mask_plugin.js"></script>
        <script type="text/javascript" src="../../js/mask_clientes.js"></script>
    </body>
</html>
