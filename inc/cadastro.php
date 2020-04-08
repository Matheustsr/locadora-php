<div id="pagina">
    <h2>Cadastro de Clientes</h2>

    <div id="form_cadastro">

        <form action="http://netfilmes.com.br/modulos/cadastrar/cliente" method="post" enctype="multipart/form-data">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" class="input" value="<?php echo recuperaDados('nome', $valor = null) ?>" />

            <label for="email">E-mail:</label>
            <input type="text" name="email" class="input" value="<?php echo recuperaDados('email', $valor = null) ?>" />

            <label for="cidade">Cidade:</label>
            <input type="text" name="cidade" class="input" value="<?php echo recuperaDados('cidade', $valor = null) ?>" />

            <label for="telefone">Telefone:</label>
            <input type="text" name="telefone" id="telefone" class="input_menor" value="<?php echo recuperaDados('telefone', $valor = null) ?>" />

            <label for="celular">Celular:</label>
            <input type="text" name="celular" id="celular" class="input_menor" value="<?php echo recuperaDados('celular', $valor = null) ?>" />

            <label for="cpf">CPF:</label>
            <input type="text" name="cpf" id="cpf" class="input_menor" value="<?php echo recuperaDados('cpf', $valor = null) ?>" />

            <label for="login">Login:</label>
            <input type="text" name="login" class="input" value="<?php echo recuperaDados('login', $valor = null) ?>" />

            <label for="senha">Senha:</label>
            <input type="text" name="senha" class="input" value="<?php echo recuperaDados('senha', $valor = null) ?>" />

            <label for="login">Newsletter:</label>
            SIM
            <input type="radio" name="newsletter" checked="checked" value="sim" class="input_radio" />
            NÃO
            <input type="radio" name="newsletter" value="nao" class="input_radio" />

            <label for="foto">Foto:</label>
            <input type="file" name="foto" class="input_file" />

            <label for="submit"></label>
            <input type="submit" name="ok" value="Cadastrar" class="input_button" />
        </form>

    </div>



</div>