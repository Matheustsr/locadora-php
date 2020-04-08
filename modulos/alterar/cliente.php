<?php
require_once "../../functions/functions.php";
carregarArquivos(array('validacoes', 'alterar', 'selecionar', 'wide_image'));
if (isset($_POST['ok']) AND $_SERVER['REQUEST_METHOD'] == 'POST'):

    $nome = validarDados($_POST['nome'], "nome", "STRING");
    $email = validarDados($_POST['email'], 'email', 'EMAIL');
    $cidade = validarDados($_POST['cidade'], "cidade", "STRING");
    $telefone = validarDados($_POST['telefone'], "telefone", "STRING");
    $celular = validarDados($_POST['celular'], "celular", "STRING");
    $cpf = validarDados($_POST['cpf'], "cpf", "STRING");
    $newsletter = validarDados($_POST['newsletter'], "newsletter", "STRING");
    $login = validarDados($_POST['login'], "login", "STRING");

    if (!isset($mensagem)):
   
        /*SE NAO DIGITAR A SENHA RECUPERA ELA DO BANCO*/
        if (empty($_POST['senha'])):
            $pegarSenha = pegarPeloId('clientes', 'clientes_id', $_POST['id']);
            $senha = $pegarSenha->clientes_senha;
        else:
             /*SE DIGITOU A SENHA CADASTRA ELA NO BANCO*/
            $senha = md5($_POST['senha']);
        endif;

        
        if (existeCadastroAlterar("clientes", "clientes_nome", $nome, "clientes_id", $_POST['id'])):
            $erro = "Ja existe um cliente com esse nome";
        else:
            if (existeCadastroAlterar("clientes", "clientes_email", $email, "clientes_id", $_POST['id'])):
                $erro = "Esse e-mail ja esta cadastrado";
            else:
                if (empty($_FILES['foto']['name'])):

                    $dadosCliente = pegarPeloId("clientes", "clientes_id", $_POST['id']);
                    $foto = $dadosCliente->clientes_foto;
                    $fotoDetalhes = $dadosCliente->clientes_foto_detalhes;

                    $dados = array(
                        "nome" => $nome,
                        "email" => $email,
                        "cidade" => $cidade,
                        "telefone" => $telefone,
                        "celular" => $celular,
                        "cpf" => $cpf,
                        "newsletter" => $newsletter,
                        "foto" => $foto,
                        "fotosDetalhes" => $fotoDetalhes,
                        "login" => $login,
                        "senha" => $senha
                    );

                    if (alterarCliente($dados, $_POST['id'])):
                        $sucesso = "Dados alterados !";
                        ?>
                        <script type="text/javascript">
                            setTimeout("window.close()", 2000);                              
                        </script>
                        <?php
                    else:
                        $erro = "Erro ao alterar dados !";
                    endif;


                else:
                    /* PEGAR EXTENSAO DA FOTO */
                    /* FOTO.2.JPG */
                    $extensao = end(explode(".", $_FILES['foto']['name']));
                    $novoNomeFoto = uniqid() . "." . $extensao;
                    $temp = $_FILES['foto']['tmp_name'];
                    $pastaFotosClientes = "fotos/clientes/";
                    $pastaFotosClientesDetalhes = "fotos/clientes/detalhes/";

                    $imagem = WideImage::load($temp);
                    $redimensionar = $imagem->resize(37, 36, "fill");
                    $redimensionar->saveToFile("../../".$pastaFotosClientes . $novoNomeFoto);

                    $redimensionar = $imagem->resize(80, 75, "fill");
                    $redimensionar->saveToFile("../../".$pastaFotosClientesDetalhes . $novoNomeFoto);

                    /* NOMES DAS FOTOS PARA CADASTRAR NO BANCO DE DADOS */
                    $fotoCadastrada = $pastaFotosClientes . $novoNomeFoto;
                    $fotoCadastradaDetalhes = $pastaFotosClientesDetalhes . $novoNomeFoto;

                    /* PEGA DADOS DO CLIENTE PARA DELETAR A FOTO */
                    $dadosCliente = pegarPeloId("clientes", "clientes_id", $_POST['id']);
                    $foto = $dadosCliente->clientes_foto;
                    $fotoDetalhes = $dadosCliente->clientes_foto_detalhes;

                    /* DELETAR A FOTO ANTES DE ATUALIZAR */
                    @unlink("../../".$foto);
                    @unlink("../../".$fotoDetalhes);

                    $dados = array(
                        "nome" => $nome,
                        "email" => $email,
                        "cidade" => $cidade,
                        "telefone" => $telefone,
                        "celular" => $celular,
                        "cpf" => $cpf,
                        "newsletter" => $newsletter,
                        "foto" => $fotoCadastrada,
                        "fotosDetalhes" => $fotoCadastradaDetalhes,
                        "login" => $login,
                        "senha" => $senha
                    );

                    if (alterarCliente($dados, $_POST['id'])):
                        $sucesso = "Dados alterados !";
                        ?>
                        <script type="text/javascript">
                            setTimeout("window.close()", 2000);                              
                        </script>
                        <?php
                    else:
                        $erro = "Erro ao alterar dados !";
                    endif;
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
        <link href='http://fonts.googleapis.com/css?family=Cuprum' rel='stylesheet' type='text/css' />
        <link href="../../css/styleJanela.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <div class="form_cadastrar">

            <div class="form">
                <?php
                try {
                    if (filter_var($_GET['id'], FILTER_VALIDATE_INT)):
                        /* LISTAR OS DADOS DO ADMINISTRADOR */
                        $dadosCliente = pegarPeloId("clientes", "clientes_id", $_GET['id']);
                        ?>  

                        <h2>Alterar Cliente</h2>

                        <form action="" method="post" enctype="multipart/form-data">
                            <label for="nome">Nome:</label>
                            <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
                            <input type="text" name="nome" class="input" value="<?php echo $dadosCliente->clientes_nome ?>" />

                            <label for="email">E-mail:</label>
                            <input type="text" name="email" class="input" value="<?php echo $dadosCliente->clientes_email ?>" />

                            <label for="cidade">Cidade:</label>
                            <input type="text" name="cidade" class="input" value="<?php echo $dadosCliente->clientes_cidade ?>" />                          

                            <label for="telefone">Telefone:</label>
                            <input type="text" name="telefone" id="telefone" class="input" value="<?php echo $dadosCliente->clientes_telefone ?>" />

                            <label for="celular">Celular:</label>
                            <input type="text" name="celular" id="celular" class="input" value="<?php echo $dadosCliente->clientes_celular ?>" />

                            <label for="cpf">CPF:</label>
                            <input type="text" name="cpf" id="cpf" class="input" value="<?php echo $dadosCliente->clientes_cpf ?>" />

                            <label for="login">Login:</label>
                            <input type="text" name="login" id="cpf" class="input" value="<?php echo $dadosCliente->clientes_login; ?>" />

                            <label for="senha">Senha:</label>
                            <input type="text" name="senha" id="cpf" class="input" />

                            <label for="login">Newsletter:</label>
                            SIM
                            <input type="radio" name="newsletter" <?php echo ($dadosCliente->clientes_newsletter == 'sim') ? "checked = 'checked'" : ''; ?> value="sim" class="input_radio" />
                            NÃO
                            <input type="radio" name="newsletter" <?php echo ($dadosCliente->clientes_newsletter == 'nao') ? "checked = 'checked'" : ''; ?> value="nao" class="input_radio" />

                            <label for="foto">Foto:</label>
                            <input type="file" name="foto" class="input_file" />


                            <label for="submit"></label>
                            <input type="submit" name="ok" value="Atualizar" class="input_button" />
                        </form>

                        <?php echo isset($erro) ? '<div class="erro">' . $erro . '</div>' : ''; ?>
                        <?php echo isset($sucesso) ? '<div class="sucesso">' . $sucesso . '</div>' : ''; ?>

                        <?php
                    else:
                        throw new Exception("O valor ID passado pela url, tem que ser um numero inteiro");
                    endif;
                } catch (Exception $e) {
                    echo "Erro " . $e->getMessage();
                }
                ?>
            </div>
        </div>   
        <script type="text/javascript" src="../../js/jquery.js"></script>
        <script type="text/javascript" src="../../js/mask_plugin.js"></script>
        <script type="text/javascript" src="../../js/mask_clientes.js"></script>
    </body>
</html>
