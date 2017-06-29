<?php
class Navio extends EmbarcacaoLonga
{
    private $posicaoIntermediaria;
    
    function __construct3($posicaoInicial, $posicaoFinal, $posicaoIntermediaria)
    {
        parent::__construct($posicaoInicial, $posicaoFinal);
        
        $this->setPosicaoIntermediaria($posicaoIntermediaria);
    }
    
    public function getPosicaoIntermediaria()
    {
        return $this->posicaoIntermediaria;
    }

    private function setPosicaoIntermediaria($posicaoIntermediaria)
    {
        $this->posicaoIntermediaria = $posicaoIntermediaria;
    }

    
    protected function verificaPosicao($posicao, $tabuleiro)
    {
        if (!$tabuleiro->verificaPosicoesAoRedor($posicao))
        {
            return false;
        }
        
        $posicaoAuxiliar1 = new Posicao;
        $posicaoAuxiliar2 = new Posicao;
        if ($this->getOrientacao() == "H")
        {
            $posicaoAuxiliar1->setLinha($posicao->getLinha());
            $posicaoAuxiliar2->setLinha($posicao->getLinha());
            
            if (($posicao->getColuna() > 1) && ($posicao->getColuna() < $tabuleiro->getLargura()))
            {
                $posicaoAuxiliar1->setColuna($posicao->getColuna() - 1);  
                $posicaoAuxiliar2->setColuna($posicao->getColuna() + 1);
                
                if ($tabuleiro->verificaPosicoesAoRedor($posicaoAuxiliar1) && $tabuleiro->verificaPosicoesAoRedor($posicaoAuxiliar2))
                {
                    $this->setPosicalIncial($posicaoAuxiliar1);
                    $this->setPosicaoIntermediaria($posicao);
                    $this->setPosicaoFinal($posicaoAuxiliar2);
                    
                    return true;
                }               
            } 
            elseif ($posicao->getColuna() == 1)
            {
                $posicaoAuxiliar1->setColuna($posicao->getColuna() + 1);  
                $posicaoAuxiliar2->setColuna($posicao->getColuna() + 2);
                
                if ($tabuleiro->verificaPosicoesAoRedor($posicaoAuxiliar1) && $tabuleiro->verificaPosicoesAoRedor($posicaoAuxiliar2))
                {
                    $this->setPosicalIncial($posicao);
                    $this->setPosicaoIntermediaria($posicaoAuxiliar1);
                    $this->setPosicaoFinal($posicaoAuxiliar2);
                    
                    return true;
                }   
            }
            elseif ($posicao->getColuna() == $tabuleiro->getLargura())
            {
                $posicaoAuxiliar1->setColuna($posicao->getColuna() - 2);  
                $posicaoAuxiliar2->setColuna($posicao->getColuna() - 1);
                
                if ($tabuleiro->verificaPosicoesAoRedor($posicaoAuxiliar1) && $tabuleiro->verificaPosicoesAoRedor($posicaoAuxiliar2))
                {
                    $this->setPosicalIncial($posicaoAuxiliar1);
                    $this->setPosicaoIntermediaria($posicaoAuxiliar2);
                    $this->setPosicaoFinal($posicao);
                    
                    return true;
                }
            }         
        }
        else
        {
            $posicaoAuxiliar1->setColuna($posicao->getColuna());
            $posicaoAuxiliar2->setColuna($posicao->getColuna());
            
            if (($posicao->getLinha() > 1) && ($posicao->getLinha() < $tabuleiro->getAltura()))
            {
                $posicaoAuxiliar1->setLinha($posicao->getLinha() - 1);  
                $posicaoAuxiliar2->setLinha($posicao->getLinha() + 1);
                
                if ($tabuleiro->verificaPosicoesAoRedor($posicaoAuxiliar1) && $tabuleiro->verificaPosicoesAoRedor($posicaoAuxiliar2))
                {
                    $this->setPosicalIncial($posicaoAuxiliar1);
                    $this->setPosicaoIntermediaria($posicao);
                    $this->setPosicaoFinal($posicaoAuxiliar2);
                    
                    return true;
                }               
            } 
            elseif ($posicao->getLinha() == 1)
            {
                $posicaoAuxiliar1->setLinha($posicao->getLinha() + 1);  
                $posicaoAuxiliar2->setLinha($posicao->getLinha() + 2);
                
                if ($tabuleiro->verificaPosicoesAoRedor($posicaoAuxiliar1) && $tabuleiro->verificaPosicoesAoRedor($posicaoAuxiliar2))
                {
                    $this->setPosicalIncial($posicao);
                    $this->setPosicaoIntermediaria($posicaoAuxiliar1);
                    $this->setPosicaoFinal($posicaoAuxiliar2);
                    
                    return true;
                }   
            }
            elseif ($posicao->getColuna() == $tabuleiro->getLargura())
            {
                $posicaoAuxiliar1->setLinha($posicao->getLinha() - 2);  
                $posicaoAuxiliar2->setLinha($posicao->getLinha() - 1);
                
                if ($tabuleiro->verificaPosicoesAoRedor($posicaoAuxiliar1) && $tabuleiro->verificaPosicoesAoRedor($posicaoAuxiliar2))
                {
                    $this->setPosicalIncial($posicaoAuxiliar1);
                    $this->setPosicaoIntermediaria($posicaoAuxiliar2);
                    $this->setPosicaoFinal($posicao);
                    
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
        elseif ($this->getPosicaoIntermediaria()->isIgual($posicao))
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
        $atingiu1 = $this->getPosicaoInicial()->getAtingida();
        $atingiu2 = $this->getPosicaoFinal()->getAtingida();
        $atingiu3 = $this->getPosicaoIntermediaria()->getAtingida();
        
        if ($atingiu1 && $atingiu2 && $atingiu3)
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
        elseif ($this->getPosicaoIntermediaria()->isIgual($posicao))
        {
            $this->getPosicaoIntermediaria()->setAtingida(true);
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
            $posIntermediariaIgual = $this->getPosicaoIntermediaria()->isIgual($embarcacao->getPosicaoIntermediaria());
            $posFinalIgual = $this->getPosicaoFinal()->isIgual($embarcacao->getPosicaoFinal());

            return ($posInicialIgual && $posIntermediariaIgual && $posFinalIgual);
        }
        
        return false;
    }
    
    public function imprimirPosicao()
    {
        $this->getPosicaoInicial()->imprimir();
        $this->getPosicaoIntermediaria()->imprimir();
        $this->getPosicaoFinal()->imprimir();
    }
}