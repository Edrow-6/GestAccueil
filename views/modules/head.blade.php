<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>{{ $titre . $app }}</title>

<link href="favicon-32x32.png" rel="icon" />
<link href="css/compiled.css" rel="stylesheet" />
<link href="css/all.min.css" rel="stylesheet" />

<script src="https://unpkg.com/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://unpkg.com/tippy.js@6.3.1/dist/tippy-bundle.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    console.log('%c DARK ZONE!', 'font-weight: bold; font-size: 50px;color: cyan; text-shadow: 3px 3px 0 rgb(4,77,145) , 6px 6px 0 rgb(42,21,113)'); 
    console.log('%c ~ Vous n\'avez rien à faire ici. Avez-vous besoin d\'aide ? http://perdu.com', 'color: gray;font-weight: bold;font-size: 25px;');

    //SCRIPT EN DEV DE LA BARRE DE RECHERCHE
    function showResult(str) {
        if (str.length == 0) {
            document.getElementById("recherche").innerHTML = "";
            return;
        }
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("recherche").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "/recherche?res=" + str, true);
        xmlhttp.send();
    }
</script>
