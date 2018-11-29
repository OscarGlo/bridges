<?php
// cette classe ne doit pas être modifiée
require "Ville.php";

class Villes {

    private $villes;

    function __construct() {
        // tableau représentatif d'un jeu qui servira à développer votre code

        $this->villes[0][0] = new Ville("0", 3, 0);
        $this->villes[0][6] = new Ville("1", 2, 0);
        $this->villes[3][0] = new Ville("2", 6, 0);
        $this->villes[3][5] = new Ville("3", 2, 0);
        $this->villes[5][1] = new Ville("4", 1, 0);
        $this->villes[5][6] = new Ville("5", 2, 0);
        $this->villes[6][0] = new Ville("6", 2, 0);

    }


    // sélecteur qui retourne la ville en position $i et $j
    // précondition: la ville en position $i et $j existe

    function getVille($i, $j) {
        return $this->villes[$i][$j];
    }


    // modifieur qui value le nombre de ponts de la ville en position $i et $j;
    // précondition: la ville en position $i et $j existe

    function setVille($i, $j, $nombrePonts) {
        $this->villes[$i][$j]->setNombrePonts($nombrePonts);
    }


    // permet de tester si la ville en position $i et $j existe
    // postcondition: vrai si la ville existe, faux sinon

    function existe($i, $j) {
        return isset($this->villes[$i][$j]);
    }

    //rajout d'éventuelles méthodes

    function onSameAxis($x1, $y1, $x2, $y2) {
        return ($x1 == $x2 || $y1 == $y2) && !($x1 == $x2 && $y1 == $y2);
    }

    function nbPontPossible($x1, $y1, $x2, $y2){
        return ($this->villes[$x1, $y1]->nombrePonts < $this->villes[$x1, $y1]->nombrePontsMax && $this->villes[$x2, $y2]->nombrePonts < $this->villes[$x2, $y2]->nombrePontsMax);
    }

    function wrongChoice($x1, $y1, $x2, $y2){
        return !$this->nbPontPossible($x1, $y1, $x2, $y2);
    }

    function villesEntre($x1, $y1, $x2, $y2){
        if($x1 == $x2){
            if($x1 < $x2){
                $i = $x1+1;
                $y = $x2-1;
            }else{
                $i = $x2+1;
                $y = $x1-1;
            }

            for ($i < $y; i++){
            }
        }
    }

    function nbLink($x1, $y1, $x2, $y2){
        $tmpNbVilles = $this->villes[$x1][$y1]->getVillesLiees;
        $nb = 0;

        for $ville in $tmpNbVilles{
            if($ville[0] == $x1 && $ville[1] == $x2){
                nb++;
            }
        }

        if ($nb >1){
            return false;
        }

        $tmpNbVilles = $this->villes[$x2][$y2]->getVillesLiees;
        $nb = 0;

        if ($nb >1){
            return false;
        }

        return true;

    }



    //tester si deux villes sont reliables
    function isLinkable($x1, $y1, $x2, $y2) {

        if(!is_null($this->villes[$x1][$y1]) && !is_null($this->villes[$x2][$y2])){
            if($this->nbLink($x1, $y1, $x2, $y2)){
                if ($this->onSameAxis($x1, $y1, $x2, $y2)){
                    return true;
                }
            }

        }
        return false;
    }

    function link($x1, $y1, $x2, $y2) {
        if($this->isLinkable($x1, $y1, $x2, $y2)){
            $this->villes[$x1, $y1]->linkWith($x2, $y2);
            $this->villes[$x1, $y1]->nombrePonts++;
            $this->villes[$x2, $y2]->linkWith($x1, $y1);
            $this->villes[$x2, $y2]->nombrePonts++;
        }
    }

}
