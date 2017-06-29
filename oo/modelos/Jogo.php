<?php
class Jogo
{
    private $tabuleiro;
    
    public function __construct($lado)
    {
        $tabuleiro = new Tabuleiro($lado, $lado);
        
        $this->setTabuleiro($tabuleiro);
    }
    
    public function __construct2($altura, $largura)
    {
        $tabuleiro = new Tabuleiro($altura, $largura);
        
        $this->setTabuleiro($tabuleiro);
    }
    
    public function getTabuleiro()
    {
        return $this->tabuleiro;
    }

    private function setTabuleiro($tabuleiro)
    {
        $this->tabuleiro = $tabuleiro;
    }
    
    public function iniciar($numSubmarinos, $numNavios, $numMinas)
    {
        $this->tabuleiro->setarConfiguracaoIncial($numSubmarinos, $numNavios, $numMinas);
    }
    
    public function jogar($jogada)
    {
        $embarcacao = $this->tabuleiro->verificaSeAcertouAlgo($jogada);
        
        if ($embarcacao && $embarcacao->getAfundou())
        {
            $this->tabuleiro->removeEmbarcacaoDoJogo($embarcacao);
        }
        
        return $embarcacao;
    }
    
    public function quantidadeDeEmbarcacoesNoJogo()
    {
        return count($this->tabuleiro->getArrEmbarcacoesEmJogo());            
    }
}
