<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Bridges</title>
    <style>
        div {
            line-height: 0;
        }

        input[type^="image"] {
            width: 60px;
        }
    </style>
</head>
<body>
<form action="" method="post">
    <input type="submit" name="logout" value="Déconnexion">
</form>
<form action="" method="post">
    <?php
    $villes = unserialize($_SESSION["villes"]);

    $current = null;

    if (count(array_keys($_POST)) > 0 && mb_ereg_match("^[0-9]|[0-9]_x$", array_keys($_POST)[0]))
        $current = substr(array_keys($_POST)[0], 0, 3);

    var_dump($current);

    $last = null;

    if (isset($_SESSION["last"])) {
        $last = $_SESSION["last"];
        unset($_SESSION["last"]);
    } else {
        $_SESSION["last"] = $current;
    }

    var_dump($last);

    echo "<br>";

    if (!is_null($current) && !is_null($last)) {
        $x1 = intval(substr($last, 0, 1));
        $y1 = intval(substr($last, 2, 1));
        $x2 = intval(substr($current, 0, 1));
        $y2 = intval(substr($current, 2, 1));

        echo $villes->nbLink($x1, $y1, $x2, $y2) ? "link ok" : "link no";
        echo "<br>";
        echo $villes->onSameAxis($x1, $y1, $x2, $y2) ? "axis ok" : "axis no";
        echo "<br>";
        echo $villes->villesEntre($x1, $y1, $x2, $y2) ? "entre ok" : "entre no";
        echo "<br>";

        echo get_class($villes->getVille(1, 1));

        /*if ($villes->isLinkable($x1, $y1, $x2, $y2))
            $villes->link($x1, $y1, $x2, $y2);*/
    }

    echo "<br>";

    for ($i = 0; $i < 7; $i++) {
        for ($j = 0; $j < 7; $j++) {
            if ($villes->existe($i, $j)) {
                echo "<input type=\"image\" src=\"vue/img/ville" .
                    $villes->getVille($i, $j)->getNombrePontsMax() . ".png\" name=\"" . $i . "|" . $j . "\">";
            } else {
                echo "<img src=\"vue/img/_.png\" width=\"60px\">";
            }
        }
        echo "<br>";
    }
    ?>
</form>
</body>
</html>