<!DOCTYPE html>
<html lang="fr">
    <head>
        @include('modules.head')
        <?php include dirname(__DIR__) . '/../lang/fr.php'; ?>
    </head>
    <body x-data="sidebar()" class="text-gray-700 bg-gray-200" @resize.window="handleResize()">
        <div class="xl:flex">
            @include('modules.sidebar')
            <div class="w-full">
                @include('modules.navbar')
                {{-- DIV EN DEV DE LA BARRE DE RECHERCHE --}}
                <div id="recherche"></div>
                <style>
                    [x-cloak] {
                        display: none;
                    }
                </style>
                <main class="grid gap-4 px-4 md:grid-cols-1 lg:grid-cols-1" x-data="app()" x-init="[initDate(), getNoOfDays()]" x-cloak>
                    <div class="relative">
                        <div class="absolute px-10 py-5 -mt-10 transform -translate-x-1/2 bg-blue-100 rounded-lg shadow-lg top-1/2 left-1/2">
                            <button
                                id="mois_precedent"
                                class="absolute left-0 px-3 py-2 text-white duration-75 transform bg-blue-300 rounded-full shadow-md -translate-x-2/3 top-1/3 hover:bg-blue-400 hover:scale-105"
                                :class="{'cursor-not-allowed opacity-25': mois == 0 }"
                                :disabled="mois == 0 ? true : false"
                                @click="mois--; getNoOfDays()"
                            >
                                <i class="fas fa-arrow-left"></i>
                            </button>
                            <h1 class="self-center justify-center text-xl font-bold text-gray-600 select-none md:text-2xl">Calendrier</h1>
                            <button
                                id="mois_suivant"
                                class="absolute right-0 px-3 py-2 text-white duration-75 transform bg-blue-300 rounded-full shadow-md translate-x-2/3 top-1/3 hover:bg-blue-400 hover:scale-105"
                                :class="{'cursor-not-allowed opacity-25': mois == 11 }"
                                :disabled="mois == 11 ? true : false"
                                @click="mois++; getNoOfDays()"
                            >
                                <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                    <div>
                        <div>
                            <div class="container px-4 py-2 mx-auto">
                                <div class="my-6 overflow-hidden bg-white rounded shadow">
                                    <div class="flex items-center justify-between px-6 py-2 mb-1 text-gray-600 uppercase bg-gray-300">
                                        <div>
                                            <span x-text="NOM_MOIS[mois]" class="text-lg font-bold text-gray-600"></span>
                                            <span x-text="annee" class="ml-1 text-lg font-normal text-gray-500"></span>
                                        </div>
                                    </div>

                                    <div class="-mx-1 -mb-1">
                                        <div class="flex flex-wrap" style="margin-bottom: -40px;">
                                            <template x-for="(jour, index) in JOURS" :key="index">
                                                <div style="width: 14.26%;" class="px-2 py-2">
                                                    <div x-text="jour" class="text-sm font-bold tracking-wide text-center text-gray-600 uppercase"></div>
                                                </div>
                                            </template>
                                        </div>

                                        <div class="flex flex-wrap border-t border-l">
                                            <template x-for="jour_vide in jours_vides">
                                                <div style="width: 14.28%; height: 120px;" class="px-4 pt-2 text-center border-b border-r"></div>
                                            </template>
                                            <template x-for="(date, dateIndex) in num_de_jours" :key="dateIndex">
                                                <div style="width: 14.28%; height: 120px;" class="relative px-4 pt-2 border-b border-r">
                                                    <div
                                                        @click="showEventModal(date)"
                                                        x-text="date"
                                                        class="inline-flex items-center justify-center w-6 h-6 leading-none text-center transition duration-100 ease-in-out rounded-full cursor-pointer"
                                                        :class="{'bg-blue-500 text-white': isToday(date) == true, 'text-gray-700 hover:bg-blue-200': isToday(date) == false }"
                                                    ></div>
                                                    <div style="height: 80px;" class="mt-1 overflow-y-auto">
                                                        <div
                                                            class="absolute top-0 right-0 inline-flex items-center justify-center w-6 h-6 mt-2 mr-2 text-sm leading-none text-white bg-gray-700 rounded-full"
                                                            x-show="events.filter(e => e.date_evenement === new Date(annee, mois, date).toDateString()).length"
                                                            x-text="events.filter(e => e.date_evenement === new Date(annee, mois, date).toDateString()).length"
                                                        ></div>

                                                        <template x-for="event in events.filter(e => new Date(e.date_evenement).toDateString() ===  new Date(annee, mois, date).toDateString() )">
                                                            <div
                                                                class="px-2 py-1 mt-1 overflow-hidden border rounded-lg"
                                                                :class="{
                                                                    'border-blue-200 text-blue-800 bg-blue-100': event.theme_evenement === 'blue',
                                                                    'border-red-200 text-red-800 bg-red-100': event.theme_evenement === 'red',
                                                                    'border-yellow-200 text-yellow-800 bg-yellow-100': event.theme_evenement === 'yellow',
                                                                    'border-green-200 text-green-800 bg-green-100': event.theme_evenement === 'green',
                                                                    'border-purple-200 text-purple-800 bg-purple-100': event.theme_evenement === 'purple'
                                                                }"
                                                            >
                                                                <p x-text="event.titre_evenement" class="text-sm leading-tight truncate"></p>
                                                            </div>
                                                        </template>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal -->
                            <div style=" background-color: rgba(0, 0, 0, 0.8)" class="fixed top-0 bottom-0 left-0 right-0 z-40 w-full h-full" x-show.transition.opacity="ouvrirModalEvenement">
                                <div class="relative left-0 right-0 max-w-xl p-4 mx-auto mt-24 overflow-hidden">
                                    <div class="absolute top-0 right-0 inline-flex items-center justify-center w-10 h-10 text-gray-500 bg-white rounded-full shadow cursor-pointer hover:text-gray-800"
                                        x-on:click="ouvrirModalEvenement = !ouvrirModalEvenement">
                                        <svg class="w-6 h-6 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <path
                                                d="M16.192 6.344L11.949 10.586 7.707 6.344 6.293 7.758 10.535 12 6.293 16.242 7.707 17.656 11.949 13.414 16.192 17.656 17.606 16.242 13.364 12 17.606 7.758z" />
                                        </svg>
                                    </div>
                    
                                    <div class="block w-full p-8 overflow-hidden bg-white rounded-lg shadow">
                                        
                                        <h2 class="pb-2 mb-6 text-2xl font-bold text-gray-800 border-b">Ajouter détails évenement (dev)</h2>
                                     
                                        <div class="mb-4">
                                            <label class="block mb-1 text-sm font-bold tracking-wide text-gray-800">Titre</label>
                                            <input class="w-full px-4 py-2 leading-tight text-gray-700 bg-gray-200 border-2 border-gray-200 rounded-lg appearance-none focus:outline-none focus:bg-white focus:border-blue-500" type="text" x-model="titre_evenement">
                                        </div>
                    
                                        <div class="mb-4">
                                            <label class="block mb-1 text-sm font-bold tracking-wide text-gray-800">Date</label>
                                            <input class="w-full px-4 py-2 leading-tight text-gray-700 bg-gray-200 border-2 border-gray-200 rounded-lg appearance-none focus:outline-none focus:bg-white focus:border-blue-500" type="text" x-model="date_evenement" readonly>
                                        </div>
                    
                                        <div class="inline-block w-64 mb-4">
                                            <label class="block mb-1 text-sm font-bold tracking-wide text-gray-800">Thème</label>
                                            <div class="relative">
                                                <select @change="theme_evenement = $event.target.value;" x-model="theme_evenement" class="block w-full px-4 py-2 pr-8 leading-tight text-gray-700 bg-gray-200 border-2 border-gray-200 rounded-lg appearance-none hover:border-gray-500 focus:outline-none focus:bg-white focus:border-blue-500">
                                                        <template x-for="(theme, index) in themes">
                                                            <option :value="theme.value" x-text="theme.label"></option>
                                                        </template>
                                                    
                                                </select>
                                                <div class="absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 pointer-events-none">
                                                <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                                </div>
                                            </div>
                                        </div>
                     
                                        <div class="mt-8 text-right">
                                            <button type="button" class="px-4 py-2 mr-2 font-semibold text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-100" @click="ouvrirModalEvenement = !ouvrirModalEvenement">
                                                Annuler
                                            </button>	
                                            <button type="button" class="px-4 py-2 font-semibold text-white bg-gray-800 border border-gray-700 rounded-lg shadow-sm hover:bg-gray-700" @click="addEvent()">
                                                Enregistrer
                                            </button>	
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /Modal -->
                        </div>
                    </div>

                    <script>
                        const NOM_MOIS = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"];
                        const JOURS = ["Lun", "Mar", "Mer", "Jeu", "Ven", "Sam", "Dim"];

                        function app() {
                            return {
                                mois: "",
                                annee: "",
                                num_de_jours: [],
                                jours_vides: [],
                                jours: ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche"],

                                events: [
                                    {
                                        date_evenement: new Date(2021, 3, 1),
                                        titre_evenement: "Poisson d'avril",
                                        theme_evenement: "blue",
                                    },
                                    {
                                        date_evenement: new Date(2021, 11, 25),
                                        titre_evenement: "Noël",
                                        theme_evenement: "green",
                                    },
                                ],
                                titre_evenement: "",
                                date_evenement: "",
                                theme_evenement: "blue",

                                themes: [
                                    {
                                        value: "blue",
                                        label: "Bleu",
                                    },
                                    {
                                        value: "red",
                                        label: "Rouge",
                                    },
                                    {
                                        value: "yellow",
                                        label: "Jaune",
                                    },
                                    {
                                        value: "green",
                                        label: "Vert",
                                    },
                                    {
                                        value: "purple",
                                        label: "Violet",
                                    },
                                ],

                                ouvrirModalEvenement: false,

                                initDate() {
                                    let aujourdhui = new Date();
                                    this.mois = aujourdhui.getMonth();
                                    this.annee = aujourdhui.getFullYear();
                                    this.datepickerValue = new Date(this.annee, this.mois, aujourdhui.getDate()).toDateString();
                                },

                                isToday(date) {
                                    const aujourdhui = new Date();
                                    const d = new Date(this.annee, this.mois, date);

                                    return aujourdhui.toDateString() === d.toDateString() ? true : false;
                                },

                                showEventModal(date) {
                                    // ouvre le modal
                                    this.ouvrirModalEvenement = true;
                                    this.date_evenement = new Date(this.annee, this.mois, date).toDateString();
                                },

                                addEvent() {
                                    if (this.titre_evenement == "") {
                                        return;
                                    }

                                    this.events.push({
                                        date_evenement: this.date_evenement,
                                        titre_evenement: this.titre_evenement,
                                        theme_evenement: this.theme_evenement,
                                    });

                                    //console.log(this.events);

                                    // reset les données du form
                                    this.titre_evenement = "";
                                    this.date_evenement = "";
                                    this.theme_evenement = "blue";

                                    // ferme le modal
                                    this.ouvrirModalEvenement = false;
                                },

                                getNoOfDays() {
                                    let joursDansMois = new Date(this.annee, this.mois + 1, 0).getDate();

                                    // trouve ou commencer le calendrier par rapport aux jours de la semaine
                                    let jourDeSemaine = new Date(this.annee, this.mois).getDay();
                                    let joursVidesArray = [];
                                    for (var i = 1; i <= jourDeSemaine; i++) {
                                        joursVidesArray.push(i);
                                    }

                                    let joursArray = [];
                                    for (var i = 1; i <= joursDansMois; i++) {
                                        joursArray.push(i);
                                    }

                                    this.jours_vides = joursVidesArray;
                                    this.num_de_jours = joursArray;
                                },
                            };
                        }
                    </script>
                </main>
            </div>
        </div>
        <script>
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
                        //console.log(this.isAboveBreakpoint);
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
            }
        </script>
        <script>
            tippy("#mois_precedent", {
                content: "Mois précédent",
                placement: "left",
                theme: "translucent",
            });
            tippy("#mois_suivant", {
                content: "Mois suivant",
                placement: "right",
                theme: "translucent",
            });
        </script>
    </body>
</html>
