<?php

include("utilities/init_embarcacoes.php");

session_start();

define("NO_TARGET"          , 0);
define("TARGET"             , 1);
define("ALREADY_CLICKED"   , 2);

/** 
** Inicialização do tabuleiro funcional 
** Completa item de "Usar recursão como iteração"
**/

function inicializar_tabuleiro($dimensao){

    return linha_init($dimensao, $dimensao);
};

function linha_init($index, $dimensao_col){
    $array = ($index == 0) ?  [] : linha_init($index-1, $dimensao_col);
        
    $array[$index] = coluna_init($dimensao_col);
    
    return $array;
};

function coluna_init($index){
    $array = ($index == 0) ?  [] : coluna_init($index-1);
        
    $array[$index] = NO_TARGET;
    
    return $array;
};

function iniciar_jogo($tamanho_tabuleiro){
    $insert_submarino = insert_embarcacao("sub");
    $insert_navio = insert_embarcacao("nav");
    $insert_mina = insert_embarcacao("min");

    $tabuleiro = inicializar_tabuleiro($tamanho_tabuleiro);

    $tabuleiro = $insert_mina($tabuleiro)(25);

    return $tabuleiro;
};

function jogo(){
    return !isset($_SESSION['jogo']) ? $_SESSION['jogo'] = iniciar_jogo(TAMANHO_TABULEIRO) : $_SESSION['jogo'];
};


print_r(jogo());

die();