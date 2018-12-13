<?php

// Classe generale de definition d'exception
class MonException extends Exception {
    private $chaine;

    public function __construct($chaine) {
        $this->chaine = $chaine;
    }

    public function afficher() {
        return $this->chaine;
    }

}


// Exception relative à un probleme de connexion
class ConnexionException extends MonException {
}

// Exception relative à un probleme d'accès à une table
class TableAccesException extends MonException {
}


// Classe qui gère les accès à la base de données

class Connexion {
    private $connexion;

    // Constructeur de la classe

    public function __construct() {
        try {
            $chaine = "mysql:host=" . HOST . ";dbname=" . BD;
            $this->connexion = new PDO($chaine, LOGIN, PASSWORD);
            $this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new ConnexionException("problème de connexion à la base");
        }
    }




    // A développer
    // méthode qui permet de se deconnecter de la base
    public function deconnexion() {
        $this->connexion = null;
    }

    /*
    //A développer
    // utiliser une requête classique
    // méthode qui permet de récupérer les pseudos dans la table pseudo
    // post-condition:
    //retourne un tableau à une dimension qui contient les pseudos.
    // si un problème est rencontré, une exception de type TableAccesException est levée

    public function getPseudos(){
     try{

    $statement=$this->connexion->query("SELECT pseudo from pseudonyme;");

    while($ligne=$statement->fetch()){
    $result[]=$ligne['pseudo'];
    }
    return($result);
    }
    catch(PDOException $e){
        throw new TableAccesException("problème avec la table pseudonyme");
      }
    }
    */

    //A développer
    // utiliser une requête préparée
    //vérifie qu'un pseudo existe dans la table pseudonyme
    // post-condition retourne vrai si le pseudo existe sinon faux
    // si un problème est rencontré, une exception de type TableAccesException est levée
    public function authentification($pseudo, $password) {
        try {
            $statement = $this->connexion->prepare("select motDePasse from joueurs where pseudo=?;");
            $statement->bindParam(1, $pseudo);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);

            if ($result["motDePasse"] != null) {
                return (crypt($password, $result["motDePasse"]) == $result["motDePasse"]);
            } else {
                return false;
            }
        } catch (PDOException $e) {
            throw new TableAccesException("problème avec la table pseudonyme");
        }
    }

    public function enregPartie($gagne, $pseudo) {
        try {
            $this->connexion->exec("INSERT INTO parties VALUES (NULL, '" . $pseudo . "', ". $gagne .");");
        } catch (PDOException $e) {
            echo $e;
            throw new TableAccesException("problème avec la table parties");
        }
    }

    public function winLoseJoueurs() {
        try {
            $query = "SELECT pseudo as p, (SELECT COUNT(*) FROM parties WHERE pseudo = p AND partieGagnee = 1) as win,
                                          (SELECT COUNT(*) FROM parties WHERE pseudo = p AND partieGagnee = 0) as lose
                      FROM parties GROUP BY p";
            return $this->connexion->query($query)->fetchAll();
        } catch (PDOException $e) {
            echo $e;
            throw new TableAccesException("problème avec la table parties");
        }
    }

    public function troisMeilleursJoueurs() {
        $winLose = $this->winLoseJoueurs();
        $best = array();
        foreach ($winLose as $row) {
            $pseudo = $row["p"];
            $ratio = $row["win"] / ($row["win"] + $row["lose"]);
            for ($i = 0; $i < 3; $i++)
                if (!isset($best[$i])) {
                    $best[$i] = array($pseudo, $ratio);
                    break;
                } else if ($best[$i][1] < $ratio) {
                    for ($j = 2; $j > $i; $j--)
                        if (isset($best[$j - 1]))
                            $best[$j] = $best[$j - 1];
                    $best[$i] = array($pseudo, $ratio);
                    break;
                }
        }
        return $best;
    }
}