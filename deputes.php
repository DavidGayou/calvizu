<?php
    include "db_passwd_cfg.php";

    if(isset($_GET['query'])) {
        // Mot tapé par l'utilisateur
        $q = htmlentities($_GET['query']);

        // Connexion à la base de données
        try {
            $bdd = new PDO("mysql:host=$db_host;dbname=$db_name", $db_login, $db_passwd);
        } catch(Exception $e) {
            exit('Impossible de se connecter à la base de données.');
        }

        // Requête SQL
        $requete = "SELECT * FROM parlementaire WHERE fin_mandat IS NULL AND slug LIKE '%". $q ."%' LIMIT 0, 10";

        // Exécution de la requête SQL
        $resultat = $bdd->query($requete) or die(print_r($bdd->errorInfo()));

        // On parcourt les résultats de la requête SQL
        while($donnees = $resultat->fetch(PDO::FETCH_ASSOC)) {
            // On ajoute les données dans un tableau
            $suggestions['suggestions'][] = $donnees['slug'];
        }

        // On renvoie le données au format JSON pour le plugin
        echo json_encode($suggestions);
    }
?>
