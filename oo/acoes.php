<?php

foreach (glob("modelos/*.php") as $filename)
{
    if ($filename !=  "index.php")
        include $filename;
}

$resultado = -1;

if (isset($_GET['acao']))
{
    session_start();

    $jogo = $_SESSION['jogo'];
    
    switch ($_GET['acao'])
    {
        case "atirar":
            $jogada = new Jogada($_GET['linha'], $_GET['coluna']);

            $embarcacao = $jogo->jogar($jogada);

            if ($embarcacao !== false)
            {
                $resultado += 1;

                if ($embarcacao->getAfundou())
                {
                    $resultado += 1;
                }
            }
            
            break;
        case "verificaFim":
            
            $resultado = $jogo->quantidadeDeEmbarcacoesNoJogo();
            
            break;
    }
}

echo $resultado;