<?php

require_once HOME."modele/Connection.php";
require_once HOME."vue/vue.php";

class ControleurAuth {
    private $vue, $connexion;

    public function __construct() {
        $this->vue = new Vue();
        $this->connexion = new Connexion();
    }

    public function auth() {
        if ($this->connexion->authentification($_POST["login"], $_POST["mdp"])) {
            $_SESSION["login"] = $_POST["login"];
            $_SESSION["villes"] = new Villes();
            $this->vue->jeu();
        } else
            $this->vue->auth();
    }
}