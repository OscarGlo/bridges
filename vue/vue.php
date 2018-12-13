<?php
include_once HOME."modele/Connection.php";

class Vue {
    private $connect;

    function __construct() {
        $this->connect = new Connexion();
    }

    function auth() {
        include "auth.php";
    }

    function jeu() {
        include "jeu.php";
    }

    function resultat($str) {
        echo "<!DOCTYPE html>
            <html>
            <head>
                <meta charset=\"UTF-8\">
                <title>Bridges — Authentification</title>
            </head>
            <body>
                <h2>Vous avez ".$str."</h2>
                <p>Vous pouvez recharger la page pour rejouer.</p>
                <form action=\"\" method=\"post\">
                    <input type=\"submit\" value=\"Relancer le jeu\">
                    <input type=\"submit\" name=\"logout\" value=\"Déconnexion\">
                </form><br>
                <b>Mes statistiques:</b><br>";
        foreach ($this->connect->winLoseJoueurs() as $row)
            if ($row["p"] == $_SESSION["login"])
                echo "Nombre de parties jouées: ".($row["win"]+$row["lose"])."<br>".
                    "Nombre de parties gagnées: ".($row["win"])." (".($row["win"] / ($row["win"]+$row["lose"])*100)."%)<br><br>";
        echo "<b>3 meilleurs joueurs:</b><br>";
        foreach ($this->connect->troisMeilleursJoueurs() as $row)
            echo "[".$row[0]."] ".($row[1]*100)."% de victoires<br>";
        echo "</body></html>";
    }
}