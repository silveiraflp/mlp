<?php
//CURRYING
define("VERTICAL", 0);
define("HORIZONTAL", 1);
define("TAMANHO_MINA", 1);
define("TAMANHO_SUBMARINO", 2);
define("TAMANHO_NAVIO", 3);

function insert_embarcacao($tipo){
    return function ($quantidade) use($tipo){
        return function ($tabuleiro) use ($tipo, $quantidade){
            switch($tipo){
                case "sub":
                    $size = TAMANHO_SUBMARINO;

                break;
                case "nav":
                    $size = TAMANHO_NAVIO;

                break;
                case "min":
                    $size = TAMANHO_MINA;
                    
                        
                break;
            }

            $tabuleiro = repeat_it($quantidade, $mark_position = function($tabuleiro, $size) use (&$mark_position){
                $linha = RAND(0, TAMANHO_TABULEIRO-1);
                $coluna = RAND(0, TAMANHO_TABULEIRO-1);
                $orientation = RAND(0, 1);

                if(($result = follow($tabuleiro, $orientation, $size-1, $linha, $coluna)) == 0)
                    $tabuleiro = $mark_position($tabuleiro, $size);
                else
                    $tabuleiro = $result;

                return $tabuleiro;
            }, $tabuleiro, $size);

            return $tabuleiro;
        };
    };
};


function repeat_it($times, $my_function, $tabuleiro, $size){
    if($times != 1)
        $tabuleiro = repeat_it($times-1, $my_function, $tabuleiro, $size);

    return $my_function($tabuleiro, $size);
};

// function mark_position($tabuleiro, $size){

//     $linha = RAND(0, TAMANHO_TABULEIRO-1);
//     $coluna = RAND(0, TAMANHO_TABULEIRO-1);
//     $orientation = RAND(0, 1);

//     if(!$result = follow($tabuleiro, $orientation, $size-1, $linha, $coluna))
//         $tabuleiro = call_user_func(__FUNCTION__, $tabuleiro, $size);
//     else
//         $tabuleiro = $result;

//     return $tabuleiro;
// };

function no_bounds($tabuleiro, $linha, $coluna){

    $result = checkline($tabuleiro, $linha, $coluna, -1);

    return $result;
}

function checkline($tabuleiro, $linha, $coluna, $index){
    if($index != 1){
        if($result = checkline($tabuleiro, $linha, $coluna, $index+1))
            $result = checkcol($tabuleiro, $linha+$index, $coluna, -1);
    }
    else{
        $result = checkcol($tabuleiro, $linha+$index, $coluna, -1);
    }

    //echo $result;
    return $result;
}

function checkcol($tabuleiro, $linha, $coluna, $index){
    if($index != 1){
        if(checkcol($tabuleiro, $linha, $coluna, $index+1) == 0){
            return 0;
        }
    }

    if((0 <= $linha && $linha <= TAMANHO_TABULEIRO) && (0 <= $coluna+$index && $coluna+$index <= TAMANHO_TABULEIRO)){
        if($tabuleiro[$linha][$coluna+$index] == NO_TARGET)
            return 1;
        else
            return 0;
    }
    else{
        return 1;
    }
}

function follow($tabuleiro, $orientation, $size, $linha, $coluna){
    if($orientation == VERTICAL){
        if($linha+$size < TAMANHO_TABULEIRO){
            if(no_bounds($tabuleiro, $linha+$size, $coluna))
                if($size == 0){
                    $tabuleiro[$linha+$size][$coluna] = TARGET;
                    return $tabuleiro;
                }
                else if($tabuleiro = follow($tabuleiro, $orientation, $size-1, $linha, $coluna)){
                    $tabuleiro[$linha+$size][$coluna] = TARGET;
                    return $tabuleiro;
                }
        }
    }
    else if($orientation == HORIZONTAL){
        if($coluna+$size < TAMANHO_TABULEIRO){
            if(no_bounds($tabuleiro, $linha, $coluna+$size))
                if($size == 0){
                    $tabuleiro[$linha][$coluna+$size] = TARGET;
                    return $tabuleiro;
                }
                else if($tabuleiro = follow($tabuleiro, $orientation, $size-1, $linha, $coluna)){
                    $tabuleiro[$linha][$coluna+$size] = TARGET;
                    return $tabuleiro;
                }
        }
    }

    return 0;
}