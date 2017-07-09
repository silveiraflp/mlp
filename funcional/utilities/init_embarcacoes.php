<?php
//CURRYING
define("VERTICAL", 0);
define("HORIZONTAL", 1);
define("TAMANHO_MINA", 1);
define("TAMANHO_SUBMARINO", 2);
define("TAMANHO_NAVIO", 3);

function insert_embarcacao($tipo){
    return function ($tabuleiro) use($tipo){
        return function ($quantidade) use ($tipo, $tabuleiro){
            switch($tipo){
                case "sub":
                    $size = TAMANHO_SUBMARINO;
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
                break;
                case "nav":
                    $size = TAMANHO_NAVIO;
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
                break;
                case "min":
                    $size = TAMANHO_MINA;
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
                        
                break;
            }

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

function follow($tabuleiro, $orientation, $size, $linha, $coluna){
    if($orientation == VERTICAL){
        if($linha+$size < TAMANHO_TABULEIRO){
            if($tabuleiro[$linha+$size][$coluna] == NO_TARGET)
                if($size == 0){
                    $tabuleiro[$linha+$size][$coluna] = TARGET;
                    return $tabuleiro;
                }
                else if($tabuleiro = follow($tabuleiro, $orientation, $size-1, $linha, $coluna)){
                    $tabuleiro[$linha+$size][$coluna] = TARGET;
                    return $tabuleiro;
                }
        }
        else if($linha-$size >= 0){
            if($tabuleiro[$linha-$size][$coluna] == NO_TARGET)
                if($size == 0){
                    $tabuleiro[$linha-$size][$coluna] = TARGET;
                    return $tabuleiro;
                }
                else if($tabuleiro = follow($tabuleiro, $orientation, $size-1, $linha, $coluna)){
                    $tabuleiro[$linha-$size][$coluna] = TARGET;
                    return $tabuleiro;
                }
        }
    }
    else if($orientation == HORIZONTAL){
        if($coluna+$size < TAMANHO_TABULEIRO){
            if($tabuleiro[$linha][$coluna+$size] == NO_TARGET)
                if($size == 0){
                    $tabuleiro[$linha][$coluna+$size] = TARGET;
                    return $tabuleiro;
                }
                else if($tabuleiro = follow($tabuleiro, $orientation, $size-1, $linha, $coluna)){
                    $tabuleiro[$linha][$coluna+$size] = TARGET;
                    return $tabuleiro;
                }
        }
        else if($coluna-$size >= 0){
            if($tabuleiro[$linha][$coluna-$size] == NO_TARGET)
                if($size == 0){
                    $tabuleiro[$linha][$coluna-$size] = TARGET;
                    return $tabuleiro;
                }
                else if($tabuleiro = follow($tabuleiro, $orientation, $size-1, $linha, $coluna)){
                    $tabuleiro[$linha][$coluna-$size] = TARGET;
                    return $tabuleiro;
                }
        }
    }

    return 0;
}