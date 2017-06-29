<?php
class Jogada
{
    private $posicao;
    
    public function __construct($linha, $coluna)
    {
        $posicao = new Posicao($linha, $coluna);
        
        $this->setPosicao($posicao);
    }
    
    public function getPosicao()
    {
        return $this->posicao;
    }

    private function setPosicao($posicao)
    {
        $this->posicao = $posicao;
    }

}
