<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    define("TAMANHO_TABULEIRO"  , 15);
    define("TAMANHO_GRID"       , 45); // número de pixels
    define("QTD_NAVIOS"         , 3);
    define("QTD_SUBMARINOS"     , 4);
    define("QTD_MINAS"          , 5);
    define("PARADIGMA"          , "funcional");
    
    include PARADIGMA . '/index.php';
?>
<style>
    .embarcacao
    {
        width: <?php echo TAMANHO_GRID; ?>px;
        height: <?php echo TAMANHO_GRID; ?>px;
        background: black;
        position: absolute;
    }
    .grid
    {
        width: <?php echo TAMANHO_GRID; ?>px;
        height: <?php echo TAMANHO_GRID; ?>px;
        position: absolute;
        border: 1px solid #000;
        box-sizing: border-box;
    }
    .semBorda
    {
        border: none !important; 
        text-align: center;
        padding-top: <?php echo TAMANHO_GRID/4; ?>px;
    }
    .tblInfo
    {
        position: absolute;
        right: 0px;
    }
    .tblInfo th {
        vertical-align: top;
    }
</style>

<table class='tblInfo'>
    <tr>
        <th>Embarcações em Jogo: </th>
        <td style='' id='qtdEmbarcacoesEmJogo'></td>
    </tr>
</table>

<?php

for ($i=0; $i <= (TAMANHO_TABULEIRO + 1); $i++)
{
    for ($j=0; $j <= (TAMANHO_TABULEIRO + 1); $j++)
    {
        $top = TAMANHO_GRID * $i;
        $left = TAMANHO_GRID * $j;
        
        if (($i == 0 || $i == (TAMANHO_TABULEIRO + 1)) && in_array($j, range(1, TAMANHO_TABULEIRO)))
        {
            echo "<div class='grid semBorda' style='top: {$top}px; left: {$left}px;'>$j</div>";
        } 
        elseif (($j == 0 || $j == (TAMANHO_TABULEIRO + 1)) && in_array($i, range(1, TAMANHO_TABULEIRO)))
        {
            echo "<div class='grid semBorda' style='top: {$top}px; left: {$left}px;'>$i</div>"; 
        }
        else
        {
            if ($i != 0 && $j != 0 && $i != (TAMANHO_TABULEIRO + 1) && $j != (TAMANHO_TABULEIRO + 1))
            {
                echo "<div linha={$i} coluna={$j} class='grid hover' onclick='atirar({$i}, {$j}, \"". PARADIGMA ."\")' style='top: {$top}px; left: {$left}px;'></div>";
            }
        }
    }   
}

?>
<script src="js/jquery-latest.min.js" type="text/javascript"></script>
<script>
    function atirar(linha, coluna, paradigma)
    {
        $.ajax({
            method: "GET",
            url: paradigma + "/acoes.php",
            data: { acao: 'atirar', linha: linha, coluna: coluna }
        })
        .done(function( retorno ) {
            if (retorno == -1) // Errou
            {
                adicionaIcone(linha, coluna, "erro.png");
            }
            else // Acertou embarcaï¿½ï¿½o
            {
                adicionaIcone(linha, coluna, "fire.gif");
                setTimeout(function(){
                    adicionaIcone(linha, coluna, "acerto.png");
                }, 500);
                
                if (retorno == 1) // Afundou embarcaï¿½ï¿½o
                {
                    verificarFim(paradigma);                    
                }
            }
        }); 
    }
    
    function verificarFim(paradigma)
    {
        $.ajax({
            method: "GET",
            url: paradigma + "/acoes.php",
            data: { acao: 'verificaFim' }
        })
        .done(function( qtdEmbarcacoes ) {
            $('#qtdEmbarcacoesEmJogo').html(qtdEmbarcacoes);
    
            if (qtdEmbarcacoes == 0)
                alert( "Voc? afundou todas as embarca?ões! Fim de Jogo!" );
        });   
    }
    
    function adicionaIcone(linha, coluna, img)
    {
        img = "img/" + img;
        var top = <?php echo TAMANHO_GRID; ?> * linha;
        var left = <?php echo TAMANHO_GRID; ?> * coluna;
        
        $("body").append("<div class='grid icone' linha="+ linha +" coluna="+ coluna +" style='top: "+ top +"px; left: "+ left +"px; background-size: <?php echo TAMANHO_GRID; ?>px <?php echo TAMANHO_GRID; ?>px; background-image: url("+ img +")'></div>");        
        $("div[linha='"+ linha +"'][coluna='"+ coluna +"']").hover(adicionarMira);
    }
    
    function adicionarMira()
    {
        $(".hover, .icone").css("background-color", "transparent");
       
        var linha = $(this).attr("linha");
        var coluna = $(this).attr("coluna");
        
        $("div[linha='"+ linha +"']").css("background-color", "lemonchiffon");
        $("div[coluna='"+ coluna +"']").css("background-color", "lemonchiffon");   
        $("div[linha='"+ linha +"'][coluna='"+ coluna +"']").css("cursor", "crosshair");  
    }
    
    $(document).ready(function(){
        verificarFim('<?php echo PARADIGMA; ?>');
        $(".hover, .icone").hover(adicionarMira);
    });
    
</script>