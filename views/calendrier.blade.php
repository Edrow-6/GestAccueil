<!DOCTYPE html>
<html lang="fr">
    <head>
        @include('modules.head')
        <?php include dirname(__DIR__) . '/../lang/fr.php'; ?>
    </head>
    <body x-data="sidebar()" class="text-gray-700 bg-gray-200 select-none" @resize.window="handleResize()">
        <div class="xl:flex">
            @include('modules.sidebar')
            <div class="w-full">
                @include('modules.navbar') {{-- DIV EN DEV DE LA BARRE DE RECHERCHE --}}
                <div id="recherche" class="font-bold"></div>
                <main class="grid gap-4 px-4 md:grid-cols-1 lg:grid-cols-1">
                    <div class="relative">
                        <div class="absolute px-10 py-5 -mt-10 transform -translate-x-1/2 bg-blue-100 rounded-lg shadow-lg top-1/2 left-1/2">
                            <button
                                id="mois_precedent"
                                class="absolute left-0 px-3 py-2 text-white duration-75 transform bg-blue-300 rounded-full shadow-md -translate-x-2/3 top-1/3 hover:bg-blue-400 hover:scale-105"
                            >
                                <i class="fas fa-arrow-left"></i>
                            </button>
                            <h1 class="self-center justify-center text-xl font-bold text-gray-600 select-none md:text-2xl">Calendrier</h1>
                            <button
                                id="mois_suivant"
                                class="absolute right-0 px-3 py-2 text-white duration-75 transform bg-blue-300 rounded-full shadow-md translate-x-2/3 top-1/3 hover:bg-blue-400 hover:scale-105"
                            >
                                <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                    <div class="px-4 pt-8">
                        <div class="grid grid-cols-4 gap-4">
                            <a href="/visites-expirees" class="flex flex-col justify-center px-4 py-4 mt-4 duration-100 transform bg-white border-2 border-gray-300 shadow-sm rounded-xl sm:mt-0 hover:shadow-lg hover:scale-105">
                                <div>
                                    <p class="absolute items-center">
                                        <i class="text-3xl text-gray-500 opacity-50 fas fa-times-circle"></i>
                                    </p>
                                    <p class="flex items-center justify-end text-gray-500 text-md">
                                        <span class="font-bold">
                                            {{ round($percent_expiree, 2) }}%
                                        </span>
                                    </p>
                                </div>
                                <p class="text-3xl font-semibold text-center text-gray-800">{{ $expiree[0]['count(1)'] }}</p>
                                <p class="text-lg text-center text-gray-500">Visites expirées</p>
                            </a>

                            <a href="/visites-en-attente" class="flex flex-col justify-center px-4 py-4 mt-4 duration-100 transform bg-white border-2 border-gray-300 shadow-sm rounded-xl sm:mt-0 hover:shadow-lg hover:scale-105">
                                <div>
                                    <p class="absolute items-center">
                                        <i class="text-3xl text-yellow-500 opacity-50 fas fa-clock"></i>
                                    </p>
                                    <p class="flex items-center justify-end text-yellow-500 text-md">
                                        <span class="font-bold">
                                            {{ round($percent_attente, 2) }}%
                                        </span>
                                    </p>
                                </div>
                                <p class="text-3xl font-semibold text-center text-gray-800">{{ $attente[0]['count(1)'] }}</p>
                                <p class="text-lg text-center text-gray-500">Visites en attente</p>
                            </a>

                            <a href="/visites-validees" class="flex flex-col justify-center px-4 py-4 mt-4 duration-100 transform bg-white border-2 border-gray-300 shadow-sm rounded-xl sm:mt-0 hover:shadow-lg hover:scale-105">
                                <div>
                                    <p class="absolute items-center">
                                        <i class="text-3xl text-green-500 opacity-50 fas fa-check-circle"></i>
                                    </p>
                                    <p class="flex items-center justify-end text-green-500 text-md">
                                        <span class="font-bold">
                                            {{ round($percent_validee, 2) }}%
                                        </span>
                                    </p>
                                </div>
                                <p class="text-3xl font-semibold text-center text-gray-800">{{ $validee[0]['count(1)'] }}</p>
                                <p class="text-lg text-center text-gray-500">Visites validées</p>
                            </a>

                            <div class="flex flex-col justify-center px-4 py-4 mt-4 duration-100 transform bg-white border-2 border-gray-300 shadow-sm select-none rounded-xl sm:mt-0 hover:shadow-lg">
                                <div>
                                    <p class="absolute items-center">
                                        <i class="text-3xl text-blue-500 opacity-50 fas fa-globe-europe"></i>
                                    </p>
                                    <p class="flex items-center justify-end text-blue-500 text-md">
                                        <span class="font-bold">100%</span>
                                    </p>
                                </div>
                                <p class="text-3xl font-semibold text-center text-gray-800">{{ $totale[0]['count(1)'] }}</p>
                                <p class="text-lg text-center text-gray-500">Visites totales</p>
                            </div>
                        </div>
                        <?= $calendrier ?>
                    </div>
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
