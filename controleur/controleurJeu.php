<?php
require_once HOME."modele/Connection.php";
require_once HOME."vue/vue.php";

class ControleurJeu {
    private $vue;

    public function __construct() {
        //initialisation lors du premier lancement
        $_SESSION["villes"] = serialize(new Villes());
        $this->vue = new Vue();
        $this->connexion = new Connexion();

    }

    function jeu() {


        $villes = unserialize($_SESSION["villes"]);

        $current = null;

        if (count(array_keys($_POST)) > 0 && mb_ereg_match("^[0-9]|[0-9]_x$", array_keys($_POST)[0]))
            $current = substr(array_keys($_POST)[0], 0, 3);

        $last = null;

        if (isset($_SESSION["last"])) {
            $last = $_SESSION["last"];
            unset($_SESSION["last"]);
        } else
            $_SESSION["last"] = $current;

        if (!is_null($current) && !is_null($last)) {
            $x1 = intval(substr($last, 0, 1));
            $y1 = intval(substr($last, 2, 1));
            $x2 = intval(substr($current, 0, 1));
            $y2 = intval(substr($current, 2, 1));

            if (!$villes->isLinkable($x1, $y1, $x2, $y2))
                echo "Ces deux villes ne peuvent pas être connectées<br>";
            else if ($villes->wrongChoice($x1, $y1, $x2, $y2)) {
                $this->perdu();
                return;
            } else {

                //lorsque le choix est valide on empile le jeu dans la pileDeJeu
                if(!isset($_SESSION["pileDeJeu"])){
                    $_SESSION["pileDeJeu"] = array();
                }
                $_SESSION["pileDeJeu"][] = serialize($villes);

                //ensuite lie les villes entre elles
                $villes->link($x1, $y1, $x2, $y2);
            }

            if ($villes->gagne()) {
                $this->gagne();
                return;
            }
        }

        $_SESSION["villes"] = serialize($villes);

        $this->vue->jeu();
    }

    //si on a appuyé sur le bouton retour
    function retour(){
        //si la pile de jeu n'est pas vide, Villes est remplacé par le Villes en haut de la pile
        if (isset($_SESSION["pileDeJeu"][0])){
            $_SESSION["villes"] = $_SESSION["pileDeJeu"][count($_SESSION["pileDeJeu"])-1];
            unset($_SESSION["pileDeJeu"][count($_SESSION["pileDeJeu"])-1]);
            unset($_SESSION["last"]);
        }

        //On appelle le jeu pour qu'il se recharge avec la nouvelle Villes
        $this->jeu();

    }

    //fonction de réinitialisation
    //reset des variables puis ajout à la BDD
    //relancement du jeu
    function reinitialisation(){
        unset($_SESSION["pileDeJeu"]);
        unset($_SESSION["last"]);
        $_SESSION["villes"] = serialize(new Villes());
        $this->connexion->enregPartie(0, $_SESSION["login"]);
        $this->jeu();


    }

    //Si on a perdu le jeu
    //reset des variables puis ajout à la BDD
    //redirection vers la Vue des resultats
    function perdu() {
        $_SESSION["villes"] = serialize(new Villes());
        unset($_SESSION["pileDeJeu"]);
        unset($_SESSION["last"]);
        $this->connexion->enregPartie(0, $_SESSION["login"]);
        $this->vue->resultat("perdu...");
    }

    //Si on gagne le jeu
    //reset des variables puis ajout à la BDD
    //redirection vers la Vue des resultats
    function gagne() {
        $_SESSION["villes"] = serialize(new Villes());
        unset($_SESSION["pileDeJeu"]);
        unset($_SESSION["last"]);
        $this->connexion->enregPartie(1, $_SESSION["login"]);
        $this->vue->resultat("gagné !");
    }
}