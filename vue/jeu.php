<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Bridges</title>
    <style>
        form {
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
    <br>
    <?php
    $villes = unserialize($_SESSION["villes"]);

    $size = $villes->getTaille() + 1;

    for ($i = 0; $i < $size; $i++) {
        for ($j = 0; $j < $size; $j++) {
            if ($villes->existe($i, $j)) {
                $ville = $villes->getVille($i, $j);
                if (get_class($ville) == "Ville")
                    echo "<input type=\"image\" src=\"vue/img/ville" .
                        $ville->getNombrePontsMax() . ".png\" name=\"" . $i . "|" . $j . "\">";
                else {
                    $str = "<img src=\"vue/img/";
                    if ($ville->nb == 2)
                        $str .= ($ville->v ? "vv" : "hh");
                    else
                        $str .= ($ville->v ? "v" : "h");
                    echo $str.".png\" width=\"60px\">";
                }
            } else {
                echo "<img src=\"vue/img/_.png\" width=\"60px\">";
            }
        }
        echo "<br>";
    }
    ?>
</form>

<form action="" method="post">
    <input type="submit" name="reinit" value="Réinitialiser le jeu">
    <input type="submit" name="retour" value="Annuler le pont">
</form>

</body>
</html>