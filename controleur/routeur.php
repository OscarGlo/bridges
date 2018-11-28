<?php

require_once HOME."vue/vue.php";
require_once "controleurAuth.php";

class Routeur {
    private $vue, $controlAuth;

    public function __construct() {
        $this->controlAuth = new ControleurAuth();
        $this->vue = new Vue();
    }

    function routerRequete() {
        if (isset($_POST["login"]) && isset($_POST["mdp"]))
            $this->controlAuth->auth();
        else
            $this->vue->auth();
    }
}