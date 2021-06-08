<?php
use Bramus\Router\Router;
use eftec\bladeone\BladeOne;
use eftec\PdoOne;
use eftec\ValidationOne;

$root_dir = dirname(__DIR__);
require $root_dir . '/vendor/autoload.php';

$val = new ValidationOne(); // Library de validation


// Initialisation du fichier d'environement .env
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

// Rendu avec le système blade indépendant
function render($template, $params)
{
    $root_dir = dirname(__DIR__);
    $views = $root_dir . '/views';
    $cache = $root_dir . '/storage/cache';
    $blade = new BladeOne($views, $cache, BladeOne::MODE_DEBUG);
    $blade->addInclude('modules.sidebar', 'sidebar');
    $blade->addInclude('modules.navbar', 'navbar');

    echo $blade->run($template, $params);
}

// Initialisation de la base de données avec PDO
function initDB()
{
    $con = new PdoOne("mysql", $_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASS'], $_ENV['DB_NAME']);
    $con->logLevel = 3; // Utile pour debug et permet de trouver les problèmes en rapport avec les requêtes MySQL.
    $con->open();

    return $con;
}

// Exporter les données des tableaux sous un fichier .csv
function exportCsv()
{
    if (isset($_POST['download'])) {
        $con = initDB();

        $visites = $con->runRawQuery('SELECT * from visites');

        $nom_fichier = "visites_" . date('d-m-Y\_H-i') . ".csv";
        $fichier = fopen('php://memory', "w");

        fputcsv($fichier, ['Nom', 'Prenom', 'Société', 'Motif', 'Lieu rendez-vous', 'Commentaires', 'Date d\'arrivée', 'Date de départ'], ";");

        foreach ($visites as $ligne) {
            $date_arrivee_format = date("d/m/y", strtotime($ligne['date_arrivee']));
            $heure_arrivee_format = date("H:i", strtotime($ligne['heure_arrivee']));
            $total_arrivee = $date_arrivee_format . " à " . $heure_arrivee_format;

            $date_depart_format = date("d/m/y", strtotime($ligne['date_arrivee']));
            $heure_depart_format = date("H:i", strtotime($ligne['heure_arrivee']));
            $total_depart = $date_depart_format . " à " . $heure_depart_format;

            fputcsv($fichier, [$ligne['nom'], $ligne['prenom'], $ligne['societe'], $ligne['motif'], $ligne['lieu_rdv'], $ligne['commentaires'], $total_arrivee, $total_depart], ";");
        }
        fseek($fichier, 0);

        header('Content-Encoding: UTF-8');
        header('Content-Disposition: attachment; filename="' . $nom_fichier . '";');
        header('Content-Type: text/csv; charset=UTF-8');
        echo "\xEF\xBB\xBF";

        fpassthru($fichier);
        exit();
    }
}

$router = new Router();
$router->get('/recherche', function () {
    $con = initDB();

    $res = $_GET["res"];
    $visites = $con->runRawQuery('SELECT * FROM visites');

    //lookup all links from the xml file if length of q>0
    if (strlen($res) > 0) {
        $resultat = "";
        foreach ($visites as $visite) {
            $show = $visite['nom'] . " " . $visite['prenom'];
            $url = $visite['nom'];
            if (isset($show)) {
                // Trouver une correspondance avec la recherche
                if (stristr($show, $res)) {
                    if ($resultat == "") {
                        $resultat = '<a href="' . $url . '" target="_blank">' . $show . '</a>';
                    } else {
                        $resultat = $resultat . '<br /><a href="' . $url . '" target="_blank">' . $show . '</a>';
                    }
                }
            }
        }
    }

    // Affiche aucun résultat si rien de correspond ou affiche la valeur trouvée
    if ($resultat == "") {
        $reponse = "Aucun résultat";
    } else {
        $reponse = $resultat;
    }

    // Retourner la réponse
    echo $reponse;
});
$router->get('/', function () {
    $con = initDB();
    $totale = $con->runRawQuery('SELECT count(1) FROM visites');
    $validee = $con->runRawQuery('SELECT count(1) FROM visites WHERE statut="validée"');
    $expiree = $con->runRawQuery('SELECT count(1) FROM visites WHERE statut="expirée"');
    $attente = $con->runRawQuery('SELECT count(1) FROM visites WHERE statut="en attente"');
    $nb_visite = $totale[0]['count(1)'];
    $percent_validee = ($validee[0]['count(1)'] / $nb_visite) * 100;
    $percent_expiree = ($expiree[0]['count(1)'] / $nb_visite) * 100;
    $percent_attente = ($attente[0]['count(1)'] / $nb_visite) * 100;

    render('calendrier', ['titre' => 'Calendrier • ', 'app' => $_ENV['APP_NAME'], 'totale' => $totale, 'validee' => $validee, 'attente' => $attente, 'expiree' => $expiree, 'percent_validee' => $percent_validee, 'percent_expiree' => $percent_expiree, 'percent_attente' => $percent_attente]); // [] = array()
});
$router->get('/enregistrement', function () {
    $con = initDB();

    $motifs = $con->runRawQuery('SELECT nom FROM motifs');

    render('creation-visite', ['titre' => 'Création d\'une visite • ', 'app' => $_ENV['APP_NAME'], 'motifs' => $motifs]); // [] = array()
});
// TABLEAUX visites
$router->get('/visites-expirees', function () {
    $con = initDB();

    $identifiants = $con->runRawQuery('SELECT * FROM identifiants');
    $statuts = $con->runRawQuery('SELECT * FROM statuts');
    $motifs = $con->runRawQuery('SELECT * FROM motifs');
    $visites = $con->runRawQuery('SELECT * FROM visites WHERE statut = "expirée" ORDER BY nom');

    render('tableaux-visites.expire', ['titre' => 'Visites expirées • ', 'app' => $_ENV['APP_NAME'], 'visites' => $visites, 'statuts' => $statuts, 'motifs' => $motifs, 'identifiants'=>$identifiants]); // [] = array()
});
$router->get('/visites-en-attente', function () {
    $con = initDB();

    $identifiants = $con->runRawQuery('SELECT * FROM identifiants');
    $statuts = $con->runRawQuery('SELECT * FROM statuts');
    $motifs = $con->runRawQuery('SELECT * FROM motifs');
    $visites = $con->runRawQuery('SELECT * FROM visites WHERE statut = "en attente" ORDER BY nom');

    render('tableaux-visites.en-attente', ['titre' => 'Visites en attente • ', 'app' => $_ENV['APP_NAME'], 'visites' => $visites, 'statuts' => $statuts, 'motifs' => $motifs, 'identifiants'=>$identifiants]); // [] = array()
});
$router->get('/visites-validees', function () {
    $con = initDB();

    $identifiants = $con->runRawQuery('SELECT * FROM identifiants');
    $statuts = $con->runRawQuery('SELECT * FROM statuts');
    $motifs = $con->runRawQuery('SELECT * FROM motifs');
    $visites = $con->runRawQuery('SELECT * FROM visites WHERE statut = "validée" ORDER BY nom');

    render('tableaux-visites.valide', ['titre' => 'Visites validées • ', 'app' => $_ENV['APP_NAME'], 'visites' => $visites, 'statuts' => $statuts, 'motifs' => $motifs, 'identifiants'=>$identifiants]); // [] = array()
});

// Methodes POST
$router->post('/enregistrement', function () {
    $con = initDB();

    // Définition des variables
    $nom = $prenom = $societe = $motif = $date_arrivee = $heure_arrivee = $date_depart = $heure_depart = $lieu_rdv = $commentaires = $statut = $message = "";

    if (
        isset($_POST['nom']) &&
        isset($_POST['prenom']) &&
        isset($_POST['motif']) &&
        isset($_POST['date_arrivee']) &&
        isset($_POST['heure_arrivee']) &&
        isset($_POST['date_depart']) &&
        isset($_POST['heure_depart']) &&
        isset($_POST['lieu_rdv'])
    ) {
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $motif = $_POST['motif'];
        $date_arrivee = $_POST['date_arrivee'];
        $heure_arrivee = $_POST['heure_arrivee'];
        $date_depart = $_POST['date_depart'];
        $heure_depart = $_POST['heure_depart'];
        $lieu_rdv = $_POST['lieu_rdv'];

        $message = "Visite enregistrée avec succès !";
    } else {
        $message = "Vous devez remplir tout les champs requis.";
    }

    $societe = $_POST['societe'];
    $commentaires = $_POST['commentaires'];
    $statut = $_POST['statut'];

    $sql =
        'INSERT INTO visites(nom, prenom, societe, motif, date_arrivee, heure_arrivee, date_depart, heure_depart, lieu_rdv, commentaires, statut) values (:nom, :prenom, :societe, :motif, :date_arrivee, :heure_arrivee, :date_depart, :heure_depart, :lieu_rdv, :commentaires, :statut)';
    $args = [
        'nom' => $nom,
        'prenom' => $prenom,
        'societe' => $societe,
        'motif' => $motif,
        'date_arrivee' => $date_arrivee,
        'heure_arrivee' => $heure_arrivee,
        'date_depart' => $date_depart,
        'heure_depart' => $heure_depart,
        'lieu_rdv' => $lieu_rdv,
        'commentaires' => $commentaires,
        'statut' => $statut,
    ];
    $con->runRawQuery($sql, $args, true);

    echo $message;
    header('Location: /visites-en-attente');
});

// Seulement pour l'exportation en .csv
$router->post('/visites-en-attente', function () {
    exportCsv();

    $con = initDB();

    if (isset($_POST['statut'])) {
        $statut = $_POST['statut'];
        $id = $_POST['id'];

        $type_id = $con->runRawQuery('SELECT type_id FROM visites WHERE id = :id', ['id' => $id]);

        foreach ($type_id[0] as $test) {
            if ($test == null) {
                echo "<script>alert('Vous n\'avez pas validé l\'identité du visiteur !'); window.location = '/visites-en-attente'</script>";
            } else {
                $sql = 'UPDATE visites SET statut = :statut WHERE id = :id';
                $args = [
                    'statut' => $statut,
                    'id' => $id,
                ];
                $con->runRawQuery($sql, $args, true);
    
                if ($_POST['statut'] == 'expirée') {
                    // Faire un if tableau vide rediriger else actualiser
                    header('Location: /visites-expirees');
                } elseif ($_POST['statut'] == 'en attente') {
                    header('Location: /visites-en-attente');
                } elseif ($_POST['statut'] == 'validée') {
                    header('Location: /visites-validees');
                }
            }
        }
        
    }

    if (isset($_POST['type_id']) && $_POST['num_id']) {
        $type_id = $_POST['type_id'];
        $num_id = $_POST['num_id'];
        $id = $_POST['id'];

        $sql = 'UPDATE visites SET type_id = :type_id, num_id = :num_id WHERE id = :id';
        $args = [
            'type_id' => $type_id,
            'num_id' => $num_id,
            'id' => $id,
        ];
        $con->runRawQuery($sql, $args, true);

        header('Location: /visites-en-attente');
    } elseif (isset($_POST['type_id'])) {
        $type_id = $_POST['type_id'];
        $id = $_POST['id'];

        $sql = 'UPDATE visites SET type_id = :type_id WHERE id = :id';
        $args = [
            'type_id' => $type_id,
            'id' => $id,
        ];
        $con->runRawQuery($sql, $args, true);

        header('Location: /visites-en-attente');
    } elseif ($_POST['num_id']) {
        $num_id = $_POST['num_id'];
        $id = $_POST['id'];

        $sql = 'UPDATE visites SET num_id = :num_id WHERE id = :id';
        $args = [
            'num_id' => $num_id,
            'id' => $id,
        ];
        $con->runRawQuery($sql, $args, true);

        header('Location: /visites-en-attente');
    }
});
$router->post('/visites-expirees', function () {
    exportCsv();

    $con = initDB();

    if (isset($_POST['statut'])) {
        $statut = $_POST['statut'];
        $id = $_POST['id'];

        $sql = 'UPDATE visites SET statut = :statut WHERE id = :id';
        $args = [
            'statut' => $statut,
            'id' => $id,
        ];
        $con->runRawQuery($sql, $args, true);

        if ($_POST['statut'] == 'expirée') {
            // Faire un if tableau vide rediriger else actualiser
            header('Location: /visites-expirees');
        } elseif ($_POST['statut'] == 'en attente') {
            header('Location: /visites-en-attente');
        } elseif ($_POST['statut'] == 'validée') {
            header('Location: /visites-validees');
        }
    }

    if (isset($_POST['num_id'])) {
        $num_id = $_POST['num_id'];
        $id = $_POST['id'];
        $sql = 'UPDATE visites SET num_id = :num_id WHERE id = :id';
        $args = [
            'num_id' => $num_id,
            'id' => $id,
        ];
        $con->runRawQuery($sql, $args, true);
    }

    /*if (isset($_POST['supprimer']) {
        $sql = 'DELETE visites WHERE id = :id';
    }*/
});
$router->post('/visites-validees', function () {
    exportCsv();

    $con = initDB();

    if (isset($_POST['statut'])) {
        $statut = $_POST['statut'];
        $id = $_POST['id'];

        $sql = 'UPDATE visites SET statut = :statut WHERE id = :id';
        $args = [
            'statut' => $statut,
            'id' => $id,
        ];
        $con->runRawQuery($sql, $args, true);

        if ($_POST['statut'] == 'expirée') {
            // Faire un if tableau vide rediriger else actualiser
            header('Location: /visites-expirees');
        } elseif ($_POST['statut'] == 'en attente') {
            header('Location: /visites-en-attente');
        } elseif ($_POST['statut'] == 'validée') {
            header('Location: /visites-validees');
        }
    }

    if (isset($_POST['num_id'])) {
        $num_id = $_POST['num_id'];
        $id = $_POST['id'];
        $sql = 'UPDATE visites SET num_id = :num_id WHERE id = :id';
        $args = [
            'num_id' => $num_id,
            'id' => $id,
        ];
        $con->runRawQuery($sql, $args, true);
    }
});

$router->run();