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
                <main class="grid gap-4 px-4 md:grid-cols-1 lg:grid-cols-1">
                    <div class="relative">
                        <div class="absolute px-10 py-5 -mt-10 transform -translate-x-1/2 bg-blue-100 rounded-lg shadow-lg top-1/2 left-1/2">
                            <a id="expire" class="absolute left-0 px-3 py-2 text-white duration-75 transform bg-blue-300 rounded-full shadow-md -translate-x-2/3 top-1/3 hover:bg-blue-400 hover:scale-105" href="/visites-validees">
                                <i class="fas fa-arrow-left"></i>
                            </a>
                            <h1 class="self-center justify-center text-xl font-bold text-gray-600 select-none md:text-2xl">
                                <?php echo $lang['statistiques']; ?>
                            </h1>
                            <a id="valide" class="absolute right-0 px-3 py-2 text-white duration-75 transform bg-blue-300 rounded-full shadow-md translate-x-2/3 top-1/3 hover:bg-blue-400 hover:scale-105" href="/visites-en-attente">
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>

                    <div class="px-4 py-8">
                        <div class="grid grid-cols-3 gap-4">

                            <div class="flex flex-row justify-center duration-75 transform bg-red-400 shadow-sm rounded-xl h-28 hover:shadow-md hover:scale-95">
                                <div class="self-center">
                                    <i class="px-5 py-5 text-3xl text-red-200 align-middle fas fa-star-half-alt"></i>
                                </div>
                                <div class="grid grid-cols-1 gap-0">
                                    <h1 class="self-center text-xl font-bold text-red-100 select-none md:text-2xl">Visites totales</h1>
                                    <h1 class="self-center text-xl font-bold text-red-900 select-none md:text-2xl ">{{ $totale[0]['count(1)'] }}</h1>
                                </div>
                            </div>

                            <div class="flex flex-row justify-center duration-75 transform bg-green-400 shadow-sm rounded-xl hover:shadow-md hover:scale-95">
                                <div class="self-center">
                                    <i class="px-5 py-5 text-3xl text-green-200 fas fa-star-half-alt"></i>
                                </div>
                                <div class="grid grid-cols-1 gap-0">
                                    <h1 class="self-center text-xl font-bold text-green-100 select-none md:text-2xl">Visites validées</h1>
                                    <h1 class="self-center text-xl font-bold text-green-100 select-none md:text-2xl">{{ $validee[0]['count(1)'] }}</h1>
                                </div>
                            </div>
                            
                            <div class="flex flex-row justify-center duration-75 transform bg-yellow-400 shadow-sm rounded-xl hover:shadow-md hover:scale-95">
                                <div class="self-center">
                                    <i class="px-5 py-5 text-3xl text-yellow-200 fas fa-star-half-alt"></i>
                                </div>
                                <div class="grid grid-cols-1 gap-0">
                                    <h1 class="self-center text-xl font-bold text-yellow-100 select-none md:text-2xl">Visites en attente</h1>
                                    <h1 class="self-center text-xl font-bold text-yellow-100 select-none md:text-2xl">{{ $attente[0]['count(1)'] }}</h1>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </main>
            </div>
        </div>
        @include('modules.scripts')
    </body>
</html>
