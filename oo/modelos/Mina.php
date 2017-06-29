<?php
class Mina extends Embarcacao
{
    private $posicao;
        
    public function __construct2($posicao)
    {
        $this->setPosicao($posicao);
        $this->setAfundou(false);
    }
    
    public function getPosicao()
    {
        return $this->posicao;
    }

    protected function setPosicao($posicao)
    {
        $this->posicao = $posicao;
    }

    protected function verificaPosicao($posicao, $tabuleiro)
    {        
        if ($tabuleiro->verificaPosicoesAoRedor($posicao))
        {
            $this->setPosicao($posicao);
            
            return true;
        }
        
        return false;
    }

    public function estaNaPosicao($posicao)
    {
        return $this->getPosicao()->isIgual($posicao);
    }
    
    protected function verificaSeAfundou()
    {
        if ($this->getPosicao()->getAtingida())
        {
            $this->setAfundou(true);
        }
    }

    public function atingir($posicao)
    {
        if ($this->getPosicao()->isIgual($posicao))
        {
            $this->getPosicao()->setAtingida(true);
        }

        $this->verificaSeAfundou();
    }
    
    public function isIgual($embarcacao)
    {        
        if (get_class($embarcacao) == get_class($this))
        {
            return ($this->getPosicao()->isIgual($embarcacao->getPosicao()));
        }
        
        return false;
    }
    
    public function imprimirPosicao()
    {
        $this->getPosicao()->imprimir();
    }

}
