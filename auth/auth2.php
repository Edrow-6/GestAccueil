<?php
// Initialisation du fichier d'environement .env
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

session_start();
if (!isset($_SESSION["vsDeuxiemePassage"]))
{
	session_unset();
	$_SESSION["vsDeuxiemePassage"] = false;
}

$vsAlea=strtoupper(sprintf("%08x%08x", rand(),rand()));
$_SESSION["vsAlea"]=$vsAlea;



if (isset($_SERVER['HTTPS']))
{
	$URL_SRVSEC = "https://127.0.0.1:1924/";
	$URL_RETOUR_SRVSEC = "https://";
}
else
{
	$URL_SRVSEC = "http://127.0.0.1:1923/";
	$URL_RETOUR_SRVSEC = "http://";
}

$WEB_SERVER = $_SERVER['HTTP_HOST'];
$URL_RETOUR_SRVSEC .= str_replace('//', '/', $WEB_SERVER . dirname($_SERVER['PHP_SELF']) . "/srvsec2.php?" . $goto . "version=");

session_write_close();
?>
<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf8">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="CACHE-CONTROL" content="NO-CACHE">
    <meta http-equiv="expires" content="0">


    <script>
    var etatComposant = null;
    alea = 100000 * (Math.random());
    var urlJS = "<?php print $URL_SRVSEC?>testcomposant?" + alea;

    function urlTestComposant() {
        document.write("<SCRIPT LANGUAGE='JavaScript' SRC='" + urlJS + "'><\/SCRIPT>");
    }
    urlTestComposant();
    </script>
</head>

<body>
    <form name="formSrvSec" action="<?php print $URL_SRVSEC?>secjava" method="GET">
        <input type="hidden" name="SERVEUR" value="<?php print $URL_RETOUR_SRVSEC?>">
        <input type="hidden" name="SYSTEM" value="<?php print $_ENV['ARAMIS_SYSTEM']?>">
        <input type="hidden" name="ATTRIBUTS" value="<?php print $_ENV['ARAMIS_ATTRIBUT']?>">
        <input type="hidden" name="ALEA" value="<?php print $vsAlea?>">

    </form>
    <script>
    if (etatComposant != null) {
        val = document.formSrvSec.SERVEUR.value + etatComposant
        document.formSrvSec.SERVEUR.value = val;
        document.formSrvSec.submit();
    } else {
        url = document.formSrvSec.elements["SERVEUR"].value + "null&Jeton=SRVSEC_INDISPONIBLE";
        document.location.href = url;
    }
    </script>
</body>

</html>