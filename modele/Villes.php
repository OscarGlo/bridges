<?php
// cette classe ne doit pas être modifiée
require "Ville.php";
require "Bridge.php";

class Villes {

    private $villes;

    function __construct() {
        // tableau représentatif d'un jeu qui servira à développer votre code

        $this->villes[0][0] = new Ville("0", 3, 0);
        $this->villes[0][6] = new Ville("1", 2, 0);
        $this->villes[3][0] = new Ville("2", 6, 0);
        $this->villes[3][5] = new Ville("3", 2, 0);
        $this->villes[5][2] = new Ville("4", 1, 0);
        $this->villes[5][6] = new Ville("5", 2, 0);
        $this->villes[6][0] = new Ville("6", 2, 0);

    }


    // sélecteur qui retourne la ville en position $i et $j
    // précondition: la ville en position $i et $j existe

    function getVille($i, $j) {
        return $this->villes[$i][$j];
    }

    //renvoie la taille du plateau de jeu (la valeur la plus grande entre hauteur et largeur du plateau)
    function getTaille(){
        $max = 0;
        foreach(array_keys($this->villes) as $row) {
            foreach (array_keys($this->villes[$row]) as $col)
                if ($col > $max) $max = $col;
            if ($row > $max) $max = $row;
        }

        return $max;

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





    //teste si la partie est gagnée
    function gagne(){

        foreach($this->villes as $row){
            foreach($row as $elem){

                if(get_class ($elem) == "Ville"){
                    if($elem->getNombrePonts() != $elem->getNombrePontsMax()) return false;
                }
            }
        }
        return true;
    }


    //teste si deux Ville sont allignées
    function onSameAxis($x1, $y1, $x2, $y2) {
        return ($x1 == $x2 || $y1 == $y2) && !($x1 == $x2 && $y1 == $y2);
    }

    //renvoie true ou false si les Ville 1 et 2 peuvent encore avoir des ponts
    function nbPontPossible($x1, $y1, $x2, $y2) {
        return ($this->villes[$x1][$y1]->getNombrePonts() < $this->villes[$x1][$y1]->getNombrePontsMax() && $this->villes[$x2][$y2]->getNombrePonts() < $this->villes[$x2][$y2]->getNombrePontsMax());
    }

    //test si le choix des Ville provoque un arret du jeu
    function wrongChoice($x1, $y1, $x2, $y2) {
        return !$this->nbPontPossible($x1, $y1, $x2, $y2) /*or $this->pontEntre($x1, $y1, $x2, $y2)*/;
    }

    //test si deux Ville peuvent être reliées par un pont supplémentaire
    function nbMaxPontEntre($x1, $y1, $x2, $y2){
        return ($this->villes[$x1][$y1]->getNbLinkWith($x2, $y2) <2);
    }

    //test si il y a des Ville entre deux Ville
    function villesEntre($x1, $y1, $x2, $y2) {
        if ($x1 == $x2) {
            while ($y1 < $y2-1) {
                $y1++;
                if($this->existe($x1, $y1) && get_class ($this->villes[$x1][$y1]) == "Ville"){
                    return true;
                }
            }
            while ($y1-1 > $y2) {
                $y2++;
                if($this->existe($x2, $y2) && get_class ($this->villes[$x2][$y2]) == "Ville"){
                    return true;
                }
            }
        }else if ($y1 == $y2) {
            while ($x1 < $x2-1) {
                $x1++;
                if($this->existe($x1, $y1) && get_class ($this->villes[$x1][$y1]) == "Ville"){
                    return true;
                }
            }
            while ($x1-1 > $x2 ) {
                $x2++;
                if($this->existe($x2, $y2) && get_class ($this->villes[$x2][$y2]) == "Ville"){
                    return true;
                }
            }
        }
        return false;

    }

    //vérifie si il y a des ponts entre les Ville
    //renvoie true si il y a entre les deux Ville un pont qui n'a pas le bon axe(donc si un pont coupe le chemin)
    function pontEntre($x1, $y1, $x2, $y2){
        if ($x1 == $x2) {
            while ($y1 < $y2) {
                $y1++;
                if($this->existe($x1, $y1) && get_class ($this->villes[$x1][$y1]) == "Bridge"){
                    if($this->villes[$x1][$y1]->v == true){
                        return true;
                    }
                }
            }
            while ($y1 > $y2) {
                $y2++;
                if($this->existe($x2, $y2) && get_class ($this->villes[$x2][$y2]) == "Bridge"){
                    if($this->villes[$x2][$y2]->v == true){
                        return true;
                    }
                }
            }
        }else if ($y1 == $y2) {
            while ($x1 < $x2) {
                $x1++;
                if($this->existe($x1, $y1) && get_class ($this->villes[$x1][$y1]) == "Bridge"){
                    if($this->villes[$x1][$y1]->v == false){
                        return true;
                    }
                }
            }
            while ($x1 > $x2) {
                $x2++;
                if($this->existe($x2, $y2) && get_class ($this->villes[$x2][$y2]) == "Bridge"){
                    if($this->villes[$x2][$y2]->v == false){
                        return true;
                    }
                }
            }
        }
        return false;
    }

    //renvoie true si la Ville 1 peut être liée une seconde fois à la Ville 2
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
            if ($this->onSameAxis($x1, $y1, $x2, $y2)) {
                if (!$this->villesEntre($x1, $y1, $x2, $y2)){
                    if (!$this->pontEntre($x1, $y1, $x2, $y2)){
                        if($this->nbMaxPontEntre($x1, $y1, $x2, $y2)){
                            return true;
                        }
                    }
                }
            }

        }
        return false;
    }

    function link($x1, $y1, $x2, $y2) {
        if ($this->isLinkable($x1, $y1, $x2, $y2)) {
            $this->villes[$x1][$y1]->linkWith($x2, $y2);
            $this->villes[$x2][$y2]->linkWith($x1, $y1);

            if ($x1 == $x2) {
                while ($y1 < $y2-1) {
                    $y1++;
                    if($this->existe($x1,$y1)){
                        $this->villes[$x1][$y1]->nb++;
                    }else{
                        $this->villes[$x1][$y1] = new Bridge(false, 1);
                    }


                }
                while ($y1-1 > $y2) {
                    $y2++;
                    if($this->existe($x2,$y2)){
                        $this->villes[$x2][$y2]->nb++;
                    }else{
                        $this->villes[$x2][$y2] = new Bridge(false, 1);
                    }
                }
            }else if ($y1 == $y2) {
                while ($x1 < $x2-1) {
                    $x1++;
                    if($this->existe($x1,$y1)){
                        $this->villes[$x1][$y1]->nb++;
                    }else{
                        $this->villes[$x1][$y1] = new Bridge(true, 1);
                    }
                }
                while ($x1-1 > $x2 ) {
                    $x2++;
                    if($this->existe($x2, $y2)){
                        $this->villes[$x2][$y2]->nb++;
                    }else{
                        $this->villes[$x2][$y2] = new Bridge(true, 1);
                    }
                }
            }

        }
    }

}
