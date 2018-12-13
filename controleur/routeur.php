<?php

require_once HOME."vue/vue.php";
require_once "controleurAuth.php";
require_once "controleurJeu.php";

class Routeur {
    private $vue, $controlAuth, $controlJeu;

    public function __construct() {
        $this->controlAuth = new ControleurAuth();
        $this->controlJeu = new ControleurJeu();
        $this->vue = new Vue();
    }

    function routerRequete() {
        if (isset($_POST["login"]) && isset($_POST["mdp"]))
            $this->controlAuth->auth();
        else if (isset($_POST["logout"])) {
            session_destroy();
            $this->vue->auth();
        } else if (isset($_SESSION["login"]))
            $this->controlJeu->jeu();
        else
            $this->vue->auth();
    }
}