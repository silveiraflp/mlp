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

function drawn($tabuleiro, $linha, $coluna){
    
    if($linha-1 >= 0)
        if($tabuleiro[$linha-1][$coluna] == TARGET)
            return 0;

    if($linha+1 < TAMANHO_TABULEIRO)
        if($tabuleiro[$linha+1][$coluna] == TARGET)
            return 0;

    if($coluna-1 >= 0)
        if($tabuleiro[$linha][$coluna-1] == TARGET)
            return 0;

    if($coluna+1 < TAMANHO_TABULEIRO)
        if($tabuleiro[$linha][$coluna+1] == TARGET)
            return 0;


    return 1;
}


$resultado = -1;

if (isset($_GET['acao']))
{
    session_start();

    $jogo = $_SESSION['jogo']['tabuleiro'];
    $num_embarc = $_SESSION['jogo']['num_embarc'];
    
    switch ($_GET['acao'])
    {
        case "atirar":
            $linha = $_GET['linha'] - 1;
            $coluna = $_GET['coluna'] - 1;

            if($jogo[$linha][$coluna] == TARGET){
                $resultado += 1;
                $jogo[$linha][$coluna] = ALREADY_CLICKED;

                if(drawn($jogo, $linha, $coluna)){
                    $resultado += 1;
                    $_SESSION['jogo']['num_embarc']--;
                }

                $_SESSION['jogo']['tabuleiro'] = $jogo;
            }
            
            break;
        case "verificaFim":
            
            $resultado = $_SESSION['jogo']['num_embarc'];
            
        break;
    }
}

echo $resultado;