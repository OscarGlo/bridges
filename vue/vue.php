<?php
/**
 * Created by PhpStorm.
 * User: e175089p
 * Date: 28/11/18
 * Time: 08:56
 */

class Vue {
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
                <form action=\"\" method=\"post\">
                    <label>Login: <input type=\"text\" name=\"login\"></label>
                    <label>Mot de passe: <input type=\"password\" name=\"mdp\"></label>
                    <input type=\"submit\">
                </form>
            </body>
            </html>;";
    }
}