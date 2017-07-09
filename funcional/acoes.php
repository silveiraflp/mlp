<?php
define("TAMANHO_TABULEIRO"  , 15);
define("NO_TARGET"          , 0);
define("TARGET"             , 1);
define("ALREADY_CLICKED"   , 2);

function count_units($carry, $value){
    if($value == 1)
        $carry += $value;
    
    return $carry;
}

function count_arrays($carry, $array){
    $carry += array_reduce($array, "count_units");

    return $carry;
}

$resultado = -1;

if (isset($_GET['acao']))
{
    session_start();

    $jogo = $_SESSION['jogo'];
    
    switch ($_GET['acao'])
    {
        case "atirar":
            $linha = $_GET['linha'] - 1;
            $coluna = $_GET['coluna'] - 1;

            if($jogo[$linha][$coluna] == TARGET){
                $resultado += 1;
                $jogo[$linha][$coluna] = ALREADY_CLICKED;
            }
            
            break;
        case "verificaFim":
            
            $resultado = array_reduce($jogo, "count_arrays");
            
            break;
    }
}

echo $resultado;