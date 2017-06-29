<?php
abstract class EmbarcacaoLonga extends Embarcacao
{
    protected $posicaoInicial;
    protected $posicaoFinal;
    protected $orientacao;
    
    function __construct2($posicaIincial, $posicaoFinal)
    {
        $this->setPosicalIncial($posicaIincial);
        $this->setPosicaoFinal($posicaoFinal);
        $this->setAfundou(false);
    }
        
    public function getPosicaoInicial()
    {
        return $this->posicaoInicial;
    }

    public function getPosicaoFinal()
    {
        return $this->posicaoFinal;
    }

    protected function setPosicalIncial($posicaoInicial)
    {
        $this->posicaoInicial = $posicaoInicial;
    }

    protected function setPosicaoFinal($posicaoFinal)
    {
        $this->posicaoFinal = $posicaoFinal;
    }
    
    protected function getOrientacao()
    {
        return $this->orientacao;
    }

    protected function setOrientacao($orientacao)
    {
        $this->orientacao = $orientacao;
    }

    protected function sortearOrientacao()
    {
        $random = rand(0, 1);
        $orientacao = "H";
        
        if ($random)
        {
            $orientacao = "V";
        }
            
        $this->setOrientacao($orientacao);
    }
    
    public function setarPosicaoValida($tabuleiro)
    {        
        $this->sortearOrientacao();
        
        parent::setarPosicaoValida($tabuleiro);
    }
}
