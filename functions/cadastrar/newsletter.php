<?php

function cadastrarNewsletter($email) {
    $pdo = conectarBanco();
    try {
        $cadastrarNewsletter = $pdo->prepare('insert into newsletter(newsletter_email)values(?)');
        $cadastrarNewsletter->bindValue(1, $email);
        $cadastrarNewsletter->execute();
        return ($cadastrarNewsletter->rowCount() == 1) ? true : false;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}