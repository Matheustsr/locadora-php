<?php
/* PEGA MES ATUAL */

function pegaMesAtual($mes) {

    switch ($mes):
        case '08':
            return 'Agosto';
            break;
        case '09':
            return 'Setembro';
            break;
    endswitch;
}

/* MOSTRA O TEMPO QUE FALTA OU TEMPO QUE JA PASSOU DE DEVOLVER O FILME */

function tempoDevolverFilme($data, $f, $vencimento, $calculo_vencimento) {
    if ($f->current()->locados_status == 'Locado'):

        if ($data->format("Y-m-d H:i:s") > $data->format($f->current()->locados_devolucao)):
            echo "<span class='vencido'>Vencido</span><br />";
            echo "Ja passaram " . $vencimento->d . " dias e " . $vencimento->h . " horas e " . $vencimento->i . " minutos e " . $vencimento->s . " segundos.<br />";
            echo "<span class='total_vencimento'>Total após o vencimento: R$ " . number_format(($calculo_vencimento * pegarHoras($vencimento->d,$vencimento->h)) + $f->current()->filmes_preco, 2, ",", ".") . "<span><br />";
            ?>                                                                                  <!--0.45*-->
            Locado para: <a href="?p=dados_cliente&id=<?php echo $f->current()->clientes_id; ?>"><?php echo $f->current()->clientes_nome; ?></a>
            <?php
        else:
            echo "<span class='locado'>" . $f->current()->locados_status . "</span><br />";
            echo "Faltam " . $vencimento->d . " dias e " . $vencimento->h . " horas e " . $vencimento->i . " minutos e " . $vencimento->s . " segundos<br />";
            ?>
            Locado para: <a href="?p=dados_cliente&id=<?php echo $f->current()->clientes_id; ?>"><?php echo $f->current()->clientes_nome; ?></a><br />
            Valor a ser pago: R$ <?php echo number_format($f->current()->locados_valor, 2, ",", "."); ?>
        <?php
        endif;
    else:
        echo "<span class='devolvido'>" . $f->current()->locados_status . "<span>";
    endif;
}

function pegarHoras($dias, $horas) {
    if ($dias == 0):
        return $horas;
    else:
        return($dias * 24) + $horas;
                //1*24+0 = 24
    endif;
}
