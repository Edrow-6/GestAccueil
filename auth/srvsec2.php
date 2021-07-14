<?php
// Initialisation du fichier d'environement .env
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();


session_start();

// Recuperation du jeton passé en parametre
if (isset ($_POST['Jeton'])) $jeton = $_POST['Jeton'];
if (isset ($_GET['Jeton'])) $jeton = $_GET['Jeton'];

// Test du retour SRVSEC
if (array_key_exists ("Jeton", $_GET) && $_GET['Jeton'] == "SRVSEC_INDISPONIBLE")
{
	if ($_SESSION["vsDeuxiemePassage"])
	{
		//print "Echec authentification ACCESSMASTER : le composant de sécurité (SRVSEC) sur le poste de travail est indisponible";
		echo "<html><HEAD><TITLE>Erreur</TITLE></HEAD><BODY>";
		echo "<BR><CENTER><H2>Echec authentification ACCESSMASTER : le composant de sécurité (SRVSEC) sur le poste de travail est indisponible</H2></CENTER>";
		echo "</BODY></html>";
		exit;
	}
	else
	{
		$_SESSION["vsDeuxiemePassage"] = true;
		sleep(10);
		header('Location: /');
		exit;
	}	
	
}

// Protection contre l'insertion de script
$jeton = escapeshellarg($jeton);

// Verification du jeton
$res=exec($_ENV['PROG_CHECK_TOKEN'] . " " . $_SESSION['vsAlea'] ." 1 " . $jeton);

if ($res == "0") {
	$vServiceAramis = $_ENV['ARAMIS_SERVICE'];
	$vAttribAramis = $_ENV['ARAMIS_ATTRIBUT'];
	$vProgGetParam = $_ENV['PROG_GET_PARAM'];

	$service = exec($_ENV['PROG_GET_SERVERS'] . $jeton);
	$systeme = exec($vProgGetParam .' '.$jeton." A $vServiceAramis $vAttribAramis");
	$perimetre = exec($vProgGetParam .' '.$jeton." S0 $vServiceAramis $vAttribAramis");
	$nom = exec($vProgGetParam .' '.$jeton." F $vServiceAramis $vAttribAramis");
	$prenom = exec($vProgGetParam .' '.$jeton." G $vServiceAramis $vAttribAramis");
	$agent = exec($vProgGetParam .' '.$jeton." E $vServiceAramis $vAttribAramis");
	$caisse = substr(exec($vProgGetParam .' '.$jeton." H $vServiceAramis $vAttribAramis"),5,14);
	$caissedigit = substr(exec($vProgGetParam .' '.$jeton." R $vServiceAramis $vAttribAramis"),5,14);
	$idgdp = substr(exec($vProgGetParam .' '.$jeton." H $vServiceAramis $vAttribAramis"),0,5);
	
	$_SESSION['prenom'] = $prenom;
	$_SESSION['nom'] = $nom;
	$_SESSION['agent'] = $agent;
	$_SESSION['caisse'] = $caisse;
	$_SESSION['caissedigit'] = $caissedigit;
	$_SESSION['idgdp'] = $idgdp;
    $_SESSION['systeme'] = $systeme;
	$_SESSION['service'] = $service;
	$_SESSION['perimetre'] = $perimetre;
	header ("Location: /");
} else {
	echo "ERREUR D'AUTHENTIFICATION ARAMIS";
}	
?>
</body>

</html>