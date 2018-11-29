<?php

session_start();

require_once "config/config.php";
require_once "controleur/routeur.php";
require_once HOME."modele/Villes.php";

$routeur = new Routeur();
$routeur->routerRequete();