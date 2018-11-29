<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Bridges</title>
    <style>
        img {
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>
<form action="" method="post">
    <input type="submit" name="logout" value="Déconnexion">
</form>

<form action="" method="post">
    <div style="width:420px">
        <?php
        for ($i = 0; $i < 7; $i++) {
            for ($j = 0; $j < 7; $j++) {
                if ($_SESSION["villes"]->existe($i, $j)) {
                    echo "<input type=\"submit\" class=\"" . $_SESSION["villes"]->getVille($i, $j)->getNombrePontsMax().
                        "\" name=\"" . $i . "|" . $j . "\" value=\"\">";
                } else {
                    echo "<img src=\"vue/img/_.png\" width=\"60px\">";
                }
            }
        }

        echo $_SESSION["villes"]->isLinkable(0, 0, 6, 0) ? 'true' : 'false';
        echo $_SESSION["villes"]->isLinkable(0, 0, 5, 0) ? 'true' : 'false';
        echo $_SESSION["villes"]->isLinkable(0, 0, 0, 3) ? 'true' : 'false';
        echo $_SESSION["villes"]->isLinkable(0, 0, 2, 4) ? 'true' : 'false';
        ?>
    </div>
</form>
</body>
</html>