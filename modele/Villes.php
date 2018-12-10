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

    //renvoie true si le nombre de ponts des deux Ville sont compatibles
    function nbPontPossible($x1, $y1, $x2, $y2) {
        return ($this->villes[$x1][$y1]->nombrePonts < $this->villes[$x1][$y1]->nombrePontsMax && $this->villes[$x2][$y2]->nombrePonts < $this->villes[$x2][$y2]->nombrePontsMax);
    }

    //test si le choix provoque un arret du jeu
    function wrongChoice($x1, $y1, $x2, $y2) {
        return !$this->nbPontPossible($x1, $y1, $x2, $y2) or $this->pontEntre($x1, $y1, $x2, $y2);
    }

    //test si il y a des Ville entre deux Ville
    function villesEntre($x1, $y1, $x2, $y2) {
        if ($x1 == $x2) {
            while ($y1 < $y2) {
                $y1++;
                if($this->existe($x1, $y1) && get_class ($this->villes[$x1][$y1]) == "Ville"){
                    return true;
                }
            }
            while ($y1 > $y2) {
                $y2++;
                if($this->existe($x2, $y2) && get_class ($this->villes[$x2][$y2]) == "Ville"){
                    return true;
                }
            }
        }else if ($y1 == $y2) {
            while ($x1 < $x2) {
                $x1++;
                if($this->existe($x1, $y1) && get_class ($this->villes[$x1][$y1]) == "Ville"){
                    return true;
                }
            }
            while ($x1 > $x2) {
                $x2++;
                if($this->existe($x2, $y2) && get_class ($this->villes[$x2][$y2]) == "Ville"){
                    return true;
                }
            }
        }
        return false;

    }

    //vérifie si il y a des ponts entre les Ville
    function pontEntre($x1, $y1, $x2, $y2){
        if ($x1 == $x2) {
            while ($y1 < $y2) {
                $y1++;
                if(get_class ($this->villes[$x2][$y2]) == "Bridge"){
                    return true;
                }
            }
            while ($y1 > $y2) {
                $y2++;
                if(get_class ($this->villes[$x2][$y2]) == "Bridge"){
                    return true;
                }
            }
        }else if ($y1 == $y2) {
            while ($x1 < $x2) {
                $x1++;
                if(get_class ($this->villes[$x2][$y2]) == "Bridge"){
                    return true;
                }
            }
            while ($x1 > $x2) {
                $x2++;
                if(get_class ($this->villes[$x2][$y2]) == "Bridge"){
                    return true;
                }
            }
        }
        return false;
    }

    function nbLink($x1, $y1, $x2, $y2) {
        $tmpNbVilles = $this->villes[$x1][$y1]->getVillesLiees();
        $nb = 0;

        foreach ($tmpNbVilles as $ville) {
            if ($ville[0] == $x2 && $ville[1] == $y2) {
                $nb++;
            }
        }

        return $nb < 2;
    }


    //tester si deux villes sont reliables
    function isLinkable($x1, $y1, $x2, $y2) {
        if ($this->existe($x1, $y1) && $this->existe($x2, $y2)) {
            if ($this->nbLink($x1, $y1, $x2, $y2)) {
                if ($this->onSameAxis($x1, $y1, $x2, $y2)) {
                    if ($this->villesEntre($x1, $y1, $x2, $y2)){
                        return true;
                    }
                }
            }
        }
        return false;
    }

    function link($x1, $y1, $x2, $y2) {
        if ($this->isLinkable($x1, $y1, $x2, $y2)) {
            $this->villes[$x1][$y1]->linkWith($x2, $y2);
            $this->villes[$x1][$y1]->nombrePonts++;
            $this->villes[$x2][$y2]->linkWith($x1, $y1);
            $this->villes[$x2][$y2]->nombrePonts++;
        }
    }

}
