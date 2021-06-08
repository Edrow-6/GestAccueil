{{-- SCRIPT EN DEV DU TRI EN FONCTION DE LA OU ON CLIQUE --}}
<script>
    function triTableau(numCol, idTableau, estAsc) {
        var tableau, lignes, inversion, i, a, b;
        tableau = document.getElementById(idTableau);
        inversion = true;
        
        while (inversion) {
            inversion = false;
            lignes = tableau.rows;

            for (i = 1; i < lignes.length - 1; i++) {
                if (lignes[i].getElementsByTagName("td")[numCol] != undefined && lignes[i + 1].getElementsByTagName("td")[numCol] != undefined) {
                    a = lignes[i].getElementsByTagName("td")[numCol].innerHTML.toLowerCase();
                    b = lignes[i + 1].getElementsByTagName("td")[numCol].innerHTML.toLowerCase();

                    if ((a < b && estAsc == false) || (a > b && estAsc == true)) {
                        lignes[i].parentNode.insertBefore(lignes[i + 1], lignes[i]);
                        inversion = true;
                        break;
                    }
                }
            }
        }
    }
    let estAsc = true;

    let bouton_0 = document.getElementById('ordre_0');
    bouton_0.addEventListener('click', function () {
        estAsc = !estAsc;
        triTableau(number, 'liste_visites', estAsc)
    });

    let bouton_1 = document.getElementById('ordre_1');
    bouton_1.addEventListener('click', function () {
        estAsc = !estAsc;
        triTableau(number, 'liste_visites', estAsc)
    });

    let bouton_2 = document.getElementById('ordre_2');
    bouton_2.addEventListener('click', function () {
        estAsc = !estAsc;
        triTableau(number, 'liste_visites', estAsc)
    });

    let bouton_3 = document.getElementById('ordre_3');
    bouton_3.addEventListener('click', function () {
        estAsc = !estAsc;
        triTableau(number, 'liste_visites', estAsc)
    });

    let bouton_4 = document.getElementById('ordre_4');
    bouton_4.addEventListener('click', function () {
        estAsc = !estAsc;
        triTableau(number, 'liste_visites', estAsc)
    });

    function sidebar() {
        const breakpoint = 1280;

        return {
            open: {
                above: true,
                below: false,
            },
            isAboveBreakpoint: window.innerWidth > breakpoint,

            handleResize() {
                this.isAboveBreakpoint = window.innerWidth > breakpoint;
            },

            isOpen() {
                console.log(this.isAboveBreakpoint);
                if (this.isAboveBreakpoint) {
                    return this.open.above;
                }
                return this.open.below;
            },
            handleOpen() {
                if (this.isAboveBreakpoint) {
                    this.open.above = true;
                }
                this.open.below = true;
            },
            handleClose() {
                if (this.isAboveBreakpoint) {
                    this.open.above = false;
                }
                this.open.below = false;
            },
            handleAway() {
                if (!this.isAboveBreakpoint) {
                    this.open.below = false;
                }
            },
        };
    };

    function app() {
        return {
            openDeleteModal: false,
            openEditModal: false,
            openIdModal: false,
            openValidIdModal: false,

            // Fonctions de la fenêtre d'édition de l'identifiant
            showIdModal() {
                // Ouvrir
                this.openIdModal = true;
            },
            hideIdModal() {
                // Fermer
                this.openIdModal = false;
            },

            // Fonctions de la fenêtre d'édition de l'identifiant
            showValidIdModal() {
                // Ouvrir
                this.openValidIdModal = true;
            },
            hideValidIdModal() {
                // Fermer
                this.openValidIdModal = false;
            },

            // Fonctions de la fenêtre de suppression
            showDeleteModal() {
                // Ouvrir
                this.openDeleteModal = true;
            },
            hideDeleteModal() {
                // Fermer
                this.openDeleteModal = false;
            },

            // Fonctions de la fenêtre d'édition
            showEditModal() {
                // Ouvrir
                this.openEditModal = true;
            },
            hideEditModal() {
                // Fermer
                this.openEditModal = false;
            },

            // Redirection vers la visite dans le calendrier
            goToCalendar() {
                // Todo
            },
        };
    }

    tippy("#no_comments", {
        content: "Aucun commentaires",
        placement: "right",
        theme: "translucent",
    });
    tippy("#download", {
        content: "Télécharger au format .csv",
        placement: "left",
        theme: "translucent",
    });
</script>