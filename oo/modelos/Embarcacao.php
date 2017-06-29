<?php
abstract class Embarcacao
{
    private $afundou;
    
    public function getAfundou()
    {
        return $this->afundou;
    }
    
    public function setAfundou($afundou)
    {
        $this->afundou = $afundou;
    }
    
    public abstract function estaNaPosicao($posicao);
    
    protected abstract function verificaPosicao($posicao, $tabuleiro);
    
    public abstract function atingir($posicao);
    protected abstract function verificaSeAfundou();
    
    public function setarPosicaoValida($tabuleiro)
    {        
        $posicao = new Posicao();
        
        do 
        {
            $posicao->sortearPosicao($tabuleiro);
            
            $posicaoValida = $this->verificaPosicao($posicao, $tabuleiro);
            
        } while (!$posicaoValida);
    }
    
    
    
    public abstract function isIgual($embarcacao);
    public abstract function imprimirPosicao();
}