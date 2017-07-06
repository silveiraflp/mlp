<?php
//CURRYING
function insert_embarcacao($tipo){
    return function ($tabuleiro) use($tipo){
        return function ($quantidade) use ($tipo, $tabuleiro){
            switch($tipo){
                case "sub":
                    for($i = 0; $i < $quantidade; $i++)
                        echo "insert submarino<br>";
                break;
                case "nav":
                    for($i = 0; $i < $quantidade; $i++)
                        echo "insert navio\n";
                break;
                case "min":
                    for($i = 0; $i < $quantidade; $i++){
                        do{
                            $linha = RAND(0, TAMANHO_TABULEIRO-1);
                            $coluna = RAND(0, TAMANHO_TABULEIRO-1);
                                
                        }while($tabuleiro[$linha][$coluna] != NO_TARGET);

                        $tabuleiro[$linha][$coluna] = TARGET;
                    }
                break;
            }

            return $tabuleiro;
        };
    };
}

