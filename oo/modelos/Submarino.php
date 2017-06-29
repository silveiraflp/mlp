
<?php
class Submarino extends EmbarcacaoLonga
{    
    protected function verificaPosicao($posicao, $tabuleiro)
    {
        if (!$tabuleiro->verificaPosicoesAoRedor($posicao))
        {
            return false;
        }
        
        $posicaoAuxiliar = new Posicao;
        if ($this->getOrientacao() == "H")
        {
            $posicaoAuxiliar->setLinha($posicao->getLinha());
            
            if ($posicao->getColuna() > 1)
            {
                $posicaoAuxiliar->setColuna($posicao->getColuna() - 1);  
                
                if ($tabuleiro->verificaPosicoesAoRedor($posicaoAuxiliar))
                {
                    $this->setPosicalIncial($posicaoAuxiliar);
                    $this->setPosicaoFinal($posicao);
                    
                    return true;
                }               
            }
            
            if ($posicao->getColuna() < $tabuleiro->getLargura())
            {
                $posicaoAuxiliar->setColuna($posicao->getColuna() + 1); 
                
                if ($tabuleiro->verificaPosicoesAoRedor($posicaoAuxiliar))
                {
                    $this->setPosicalIncial($posicaoAuxiliar);
                    $this->setPosicaoFinal($posicao);
                    
                    return true;
                }
            }    
            
        }
        else
        {
            $posicaoAuxiliar->setColuna($posicao->getColuna());
            
            if ($posicao->getLinha() > 1)
            {
                $posicaoAuxiliar->setLinha($posicao->getLinha() - 1);  
                
                if ($tabuleiro->verificaPosicoesAoRedor($posicaoAuxiliar))
                {
                    $this->setPosicalIncial($posicao);
                    $this->setPosicaoFinal($posicaoAuxiliar);
                    
                    return true;
                }               
            }
            
            if ($posicao->getLinha() < $tabuleiro->getAltura())
            {
                $posicaoAuxiliar->setLinha($posicao->getLinha() + 1);  
                
                if ($tabuleiro->verificaPosicoesAoRedor($posicaoAuxiliar))
                {
                    $this->setPosicalIncial($posicao);
                    $this->setPosicaoFinal($posicaoAuxiliar);
                    
                    return true;
                }               
            }
        }
        
        return false;
    }

    public function estaNaPosicao($posicao)
    {
        $estaNaPosicao = false;
        
        if ($this->getPosicaoInicial()->isIgual($posicao))
        {
            $estaNaPosicao = true;
        }
        elseif ($this->getPosicaoFinal()->isIgual($posicao))
        {            
            $estaNaPosicao = true;
        }
        
        return $estaNaPosicao;
    }
    
    protected function verificaSeAfundou()
    {
        if ($this->getPosicaoInicial()->getAtingida() && $this->getPosicaoFinal()->getAtingida())
        {
            $this->setAfundou(true);
        }
    }

    public function atingir($posicao)
    {
        if ($this->getPosicaoInicial()->isIgual($posicao))
        {
            $this->getPosicaoInicial()->setAtingida(true);
        }
        elseif ($this->getPosicaoFinal()->isIgual($posicao))
        {            
            $this->getPosicaoFinal()->setAtingida(true);
        }
        
        $this->verificaSeAfundou();
    }
    
    public function isIgual($embarcacao)
    {
        if (get_class($embarcacao) == get_class($this))
        {
            $posInicialIgual = $this->getPosicaoInicial()->isIgual($embarcacao->getPosicaoInicial());
            $posFinalIgual = $this->getPosicaoFinal()->isIgual($embarcacao->getPosicaoFinal());

            return ($posInicialIgual && $posFinalIgual);
        }
        
        return false;
    }
    
    public function imprimirPosicao()
    {
        $this->getPosicaoInicial()->imprimir();
        $this->getPosicaoFinal()->imprimir();
    }
}
