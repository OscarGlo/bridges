<?php

require_once "../modele/Connection.php";
require_once "../vue/vue.php";

class ControleurAuth {
    private $vue, $connexion;

    public function __construct() {
        $this->vue = new Vue();
        $this->connexion = new Connexion();
    }

    public function auth() {
        if ($this->connexion->authentification($_POST["pseudo"], $_POST["mdp"])) {
            $_SESSION["pseudo"] = $_POST["pseudo"];
            $this->vue->jeu();
        } else
            $this->vue->auth();
    }
}