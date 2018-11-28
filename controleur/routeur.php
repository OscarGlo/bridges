<?php

require_once "../vue/vue.php";
require_once "controleurAuth.php";

class Routeur {
    private $vue, $controlAuth;

    public function __construct() {
        $this->controlAuth = new ControleurAuth();
        $this->vue = new Vue();
    }

    function routerRequete() {
        if (isset($_POST["pseudo"]) && isset($_POST["mdp"]))
            $this->controlAuth->auth();
        else
            $this->vue->auth();
    }
}