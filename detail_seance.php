<?php
    include 'db_passwd_cfg.php';

    $WhereSelectParlBySlug = "AND pa.slug = 'jean-jacques-urvoas'";
    $date = "2012-10-25";
    if(isset($_GET['slug'])) {
        // Mot tapé par l'utilisateur
        $slug = htmlentities($_GET['slug']);
        $WhereSelectParlBySlug = " AND pa.slug = '$slug'";
    }
    if(isset($_GET['date'])) {
        // Mot tapé par l'utilisateur
        $date = htmlentities($_GET['date']);
    }

    // Connexion à la base de données
    try {
        $bdd = new PDO('mysql:host='.$db_host.';dbname='.$db_name, $db_login, $db_passwd);
        $bdd->query("SET NAMES UTF8") or die(print_r($bdd->errorInfo()));
    } catch(Exception $e) {
        exit('Impossible de se connecter à la base de données.');
    }

    // Requête SQL
    //$requete = "SELECT unix_timestamp(date) as myts, count( * ) as mycnt FROM `presence`, parlementaire"
    //    ." WHERE parlementaire.id = presence.parlementaire_id"
    //    . $WhereSelectParlBySlug
    //    ." GROUP BY date";
    $requete = "SELECT COALESCE( o.nom, s.type ) AS nom, moment "
        ."FROM `presence` p "
        ."INNER JOIN seance s ON ( s.id = p.seance_id ) "
        ."INNER JOIN parlementaire pa ON (pa.id = p.parlementaire_id) "
        ."LEFT JOIN organisme o ON ( o.id = s.organisme_id ) "
        ."WHERE p.date = '$date' "
        .$WhereSelectParlBySlug
        ." ORDER BY moment ASC" ;

    // Exécution de la requête SQL
    $resultat = $bdd->query($requete) or die(print_r($bdd->errorInfo()));

    // On parcourt les résultats de la requête SQL
    while($donnees = $resultat->fetch(PDO::FETCH_ASSOC)) {
        echo $donnees['nom']." - ".$donnees['moment']." <br/>";
        // On ajoute les données dans un tableau
        //$suggestions[$donnees['myts']] = intval($donnees['mycnt']);
    }

    // On renvoie le données au format JSON pour le plugin
    //echo json_encode($suggestions);
    
?>
