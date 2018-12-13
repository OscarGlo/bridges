<?php
require_once HOME."vue/vue.php";

class ControleurJeu {
    private $vue;

    public function __construct() {
        $this->vue = new Vue();
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
            } else
                $villes->link($x1, $y1, $x2, $y2);

            if ($villes->gagne()) {
                $this->vue->gagne();
                return;
            }
        }

        $_SESSION["villes"] = serialize($villes);

        $this->vue->jeu();
    }

    function perdu() {
        

        $this->vue->perdu();
    }
}