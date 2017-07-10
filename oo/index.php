<?php

foreach (glob("oo/modelos/*.php") as $filename)
{
    if ($filename !=  "index.php")
        include $filename;
}

session_start();

if (!isset($_SESSION['jogo']))
{
    $jogo = new Jogo(TAMANHO_TABULEIRO);
    $jogo->iniciar(QTD_SUBMARINOS,QTD_NAVIOS,QTD_MINAS);
    
    $_SESSION['jogo'] = $jogo;
}
else
{
    $jogo = $_SESSION['jogo'];
}

$embarcacoes = $jogo->getTabuleiro()->getArrEmbarcacoesEmJogo();

// Imprime embarcações no Tabuleiro
if (false)
{
    foreach ($embarcacoes as $embarcacao)
    {
        if (is_a($embarcacao,"Submarino"))
        {
            $top = $embarcacao->getPosicaoInicial()->getLinha() * TAMANHO_GRID;
            $left = $embarcacao->getPosicaoInicial()->getColuna() * TAMANHO_GRID;        
            echo "<div class='embarcacao' style='top: {$top}px; left: {$left}px'></div>";

            $top = $embarcacao->getPosicaoFinal()->getLinha() * TAMANHO_GRID;
            $left = $embarcacao->getPosicaoFinal()->getColuna() * TAMANHO_GRID;        
            echo "<div class='embarcacao' style='top: {$top}px; left: {$left}px'></div>";
        }
        elseif (is_a($embarcacao,"Navio"))
        {            
            $top = $embarcacao->getPosicaoInicial()->getLinha() * TAMANHO_GRID;
            $left = $embarcacao->getPosicaoInicial()->getColuna() * TAMANHO_GRID;        
            echo "<div class='embarcacao' style='top: {$top}px; left: {$left}px; background: blue;'></div>";

            $top = $embarcacao->getPosicaoIntermediaria()->getLinha() * TAMANHO_GRID;
            $left = $embarcacao->getPosicaoIntermediaria()->getColuna() * TAMANHO_GRID;        
            echo "<div class='embarcacao' style='top: {$top}px; left: {$left}px; background: blue;'></div>";

            $top = $embarcacao->getPosicaoFinal()->getLinha() * TAMANHO_GRID;
            $left = $embarcacao->getPosicaoFinal()->getColuna() * TAMANHO_GRID;        
            echo "<div class='embarcacao' style='top: {$top}px; left: {$left}px; background: blue;'></div>";

        }
        elseif (is_a($embarcacao,"Mina"))
        {
            $top = $embarcacao->getPosicao()->getLinha() * TAMANHO_GRID;
            $left = $embarcacao->getPosicao()->getColuna() * TAMANHO_GRID;        
            echo "<div class='embarcacao' style='top: {$top}px; left: {$left}px; background: red;'></div>";
        }
    }
}
?>

<table class='tblInfo'>
    <tr>
        <th><br /><br />Posições das Embarcações: </th>
        <td><br /><br />
           <?php
                foreach ($embarcacoes as $embarcacao)
                {
                    echo $embarcacao->imprimirPosicao() . "<br />";
                }
           ?> 
        </td>
    </tr>
</table>
