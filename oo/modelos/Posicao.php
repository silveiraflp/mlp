<?php
class Posicao
{
    private $linha;
    private $coluna;
    private $atingida;
 
    function __construct()
    {
        $a = func_get_args();
        $i = func_num_args();
        if (method_exists($this,$f='__construct'.$i)) {
            call_user_func_array(array($this,$f),$a);
        }
    }
    function __construct2($linha, $coluna)
    {
        $this->setLinha($linha);
        $this->setColuna($coluna);
        $this->setAtingida(false);
    }
    
    public function getLinha()
    {
        return $this->linha;
    }

    public function getColuna()
    {
        return $this->coluna;
    }
    
    public function getAtingida()
    {
        return $this->atingida;
    }

    public function setLinha($linha)
    {
        $this->linha = $linha;
    }

    public function setColuna($coluna)
    {
        $this->coluna = $coluna;
    }
    
    public function setAtingida($atingida)
    {
        $this->atingida = $atingida;
    }
    
    public function sortearPosicao($tabuleiro)
    {        
        $qtdLinhas = $tabuleiro->getAltura();
        $qtdColunas = $tabuleiro->getLargura();
        
        $randLinha = rand(1, $qtdLinhas);
        $randColuna = rand(1, $qtdColunas);
        
        $this->setLinha($randLinha);
        $this->setColuna($randColuna);
    }
    
    public function isIgual($posicao)
    {
        return (($this->getLinha() == $posicao->getLinha()) && ($this->getColuna() == $posicao->getColuna()));
    }
    
    public function imprimir()
    {
        echo "(". $this->getLinha() .",". $this->getColuna() .")";
    }
}
