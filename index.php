<?php

require_once "config/config.php";
require_once "controleur/routeur.php";

$routeur = new Routeur();
$routeur->routerRequete();