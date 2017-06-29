<?php
class Tabuleiro
{
    private $altura;
    private $largura;
    private $arrEmbarcacoesEmJogo;
    
    public function __construct($altura, $largura)
    {
        $this->setAltura($altura);
        $this->setLargura($largura);
    }
    
    public function getAltura()
    {
        return $this->altura;
    }

    public function getLargura()
    {
        return $this->largura;
    }

    public function setAltura($altura)
    {
        $this->altura = $altura;
    }

    public function setLargura($largura)
    {
        $this->largura = $largura;
    }
    
    public function getArrEmbarcacoesEmJogo()
    {
        return $this->arrEmbarcacoesEmJogo;
    }
    
    private function adicionarEmbarcao($embarcacao)
    {
        $embarcacao->setarPosicaoValida($this);
        
        $this->arrEmbarcacoesEmJogo[] = $embarcacao;
    }
    
    private function resetEmbarcacoes()
    {
        $this->arrEmbarcacoesEmJogo = array();
    }
    
    public function setarConfiguracaoIncial($numSubmarinos, $numNavios, $numMinas)
    {
        $this->resetEmbarcacoes();
        $this->setarMinas($numMinas);
        $this->setarNavios($numNavios);
        $this->setarSubmarinos($numSubmarinos);
    }
    
    private function setarSubmarinos($numSubmarinos)
    {
        for ($i = 0; $i < $numSubmarinos; $i++)
        {
            $submarino = new Submarino();
            
            $this->adicionarEmbarcao($submarino);
        } 
    }
    
    private function setarNavios($numNavios)
    {
        for ($i = 0; $i < $numNavios; $i++)
        {
            $navio = new Navio();
            
            $this->adicionarEmbarcao($navio);
        }
    }
    
    private function setarMinas($numMinas)
    {        
        for ($i = 0; $i < $numMinas; $i++)
        {
            $mina = new Mina();
            
            $this->adicionarEmbarcao($mina);
        }
    }
    
    public function isPosicaoLivre($posicao, $retonarEmbarcao = false)
    {
        $embarcacoes = $this->getArrEmbarcacoesEmJogo();
        
        if (count($embarcacoes) > 0)
        {
            foreach ($embarcacoes as $embarcacao)
            {
                if ($embarcacao->estaNaPosicao($posicao))
                {
                    if (!$retonarEmbarcao)
                    {
                        return false;
                    }
                    else
                    {
                        return $embarcacao;
                    }
                }
            }
        }
        
        return true;        
    }
    
    public function verificaPosicoesAoRedor($posicao)
    {        
        if (!$this->isPosicaoLivre($posicao))
        {
            return false;
        }
            
        $linha = $posicao->getLinha();
        $coluna = $posicao->getColuna();
                
        // Esquerda
        if ($coluna > 1)
        {
            $posicaoAux = new Posicao($linha, ($coluna - 1));
            if (!$this->isPosicaoLivre($posicaoAux))
            {
                return false;
            }
        }
        
        // Direita
        if ($coluna < $this->getLargura())
        {
            $posicaoAux = new Posicao($linha, ($coluna + 1));
            if (!$this->isPosicaoLivre($posicaoAux))
            {
                return false;
            }
        }
        
        if ($linha > 1)
        {
            // Acima
            $posicaoAux = new Posicao(($linha - 1), $coluna);
            if (!$this->isPosicaoLivre($posicaoAux))
            {
                return false;
            }
                 
            // Diagonal esquerda superior   
            if ($coluna > 1)
            {
                $posicaoAux->setColuna($coluna - 1);
                if (!$this->isPosicaoLivre($posicaoAux))
                {
                    return false;
                }
            }
            
            // Diagonal direita superior
            if ($coluna < $this->getLargura())
            {
                $posicaoAux->setColuna($coluna + 1);
                if (!$this->isPosicaoLivre($posicaoAux))
                {
                    return false;
                }
            }
        }        
        
        if ($linha < $this->getAltura())
        {
            // Abaixo
            $posicaoAux = new Posicao(($linha + 1), $coluna);
            if (!$this->isPosicaoLivre($posicaoAux))
            {
                return false;
            }
                 
            // Diagonal esquerda inferior   
            if ($coluna > 1)
            {
                $posicaoAux->setColuna($coluna - 1);
                if (!$this->isPosicaoLivre($posicaoAux))
                {
                    return false;
                }
            }
            
            // Diagonal direita inferior
            if ($coluna < $this->getLargura())
            {
                $posicaoAux->setColuna($coluna + 1);
                if (!$this->isPosicaoLivre($posicaoAux))
                {
                    return false;
                }
            }
        }
        
        return true;
    }
    
    public function verificaSeAcertouAlgo($jogada)
    {
        $embarcacaoAcertada = $this->isPosicaoLivre($jogada->getPosicao(), true);
        
        if ($embarcacaoAcertada !== true)
        {
            $embarcacaoAcertada->atingir($jogada->getPosicao());
            
            return $embarcacaoAcertada;
        }
        else
        {
            return false;
        }
    }
    
    public function removeEmbarcacaoDoJogo($embarcacao)
    {
        if (count($this->arrEmbarcacoesEmJogo) > 0)
        {
            foreach ($this->arrEmbarcacoesEmJogo as $k=>$e)
            {
                if ($e->isIgual($embarcacao))
                {
                    unset($this->arrEmbarcacoesEmJogo[$k]);                    
                    break;
                }
            }
        }
    }
}
