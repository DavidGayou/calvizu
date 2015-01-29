<?php
    include 'db_passwd_cfg.php';

    $WhereSelectParlBySlug = "";
    if(isset($_GET['slug'])) {
        // Mot tapé par l'utilisateur
        $slug = htmlentities($_GET['slug']);
        $WhereSelectParlBySlug = " AND parlementaire.slug = $slug";
    }

    // Connexion à la base de données
    try {
        $bdd = new PDO('mysql:host='.$db_host.';dbname='.$db_name, $db_login, $db_passwd);
    } catch(Exception $e) {
        exit('Impossible de se connecter à la base de données.');
    }

    // Requête SQL
    $requete = "SELECT unix_timestamp(date) as myts, count( * ) as mycnt FROM `presence`, parlementaire"
        ." WHERE parlementaire.id = presence.parlementaire_id"
        . $WhereSelectParlBySlug
        ." GROUP BY date";

    // Exécution de la requête SQL
    $resultat = $bdd->query($requete) or die(print_r($bdd->errorInfo()));

    // On parcourt les résultats de la requête SQL
    while($donnees = $resultat->fetch(PDO::FETCH_ASSOC)) {
        // On ajoute les données dans un tableau
        $suggestions[$donnees['myts']] = intval($donnees['mycnt']);
    }

    // On renvoie le données au format JSON pour le plugin
    echo json_encode($suggestions);
    
?>
