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
                <main class="grid gap-4 px-4 md:grid-cols-1 lg:grid-cols-1">
                    <div class="relative">
                        <div class="absolute px-10 py-5 -mt-10 transform -translate-x-1/2 bg-blue-100 rounded-lg shadow-lg top-1/2 left-1/2">
                            <a id="visites_expirees" class="absolute left-0 px-3 py-2 text-white duration-75 transform bg-blue-300 rounded-full shadow-md -translate-x-2/3 top-1/3 hover:bg-blue-400 hover:scale-105" href="/visites-expirees">
                                <i class="fas fa-arrow-left"></i>
                            </a>
                            <h1 class="self-center justify-center text-xl font-bold text-gray-600 select-none md:text-2xl">
                                <?php echo $lang['visites']; ?>
                                <span class="italic font-normal text-yellow-500">en attente</span>
                            </h1>
                            <a id="visites_validees" class="absolute right-0 px-3 py-2 text-white duration-75 transform bg-blue-300 rounded-full shadow-md translate-x-2/3 top-1/3 hover:bg-blue-400 hover:scale-105" href="/visites-validees">
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="px-4 py-2">
                        <div class="flex items-center justify-center overflow-x-auto font-sans min-w-screen" style="place-items: start;">
                            <div>
                                <div class="my-6 bg-white rounded shadow-md" x-data="app()">
                                    @include('tableaux-visites.tableau')
                                    @include('modules.edit-modal') @include('modules.delete-modal')
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        @include('modules.scripts')
        <script>
            tippy("#visites_expirees", {
                content: "Visites expir??es",
                placement: "left",
                theme: "translucent",
            });
            tippy("#visites_validees", {
                content: "Visites valid??es",
                placement: "right",
                theme: "translucent",
            });
            tippy("#yellow", {
                content: "En attente",
                placement: "right",
                theme: "translucent",
            });
            tippy("#green", {
                content: "Valid??e",
                placement: "right",
                theme: "translucent",
            });
            tippy("#gray", {
                content: "Expir??e",
                placement: "right",
                theme: "translucent",
            });
        </script>
    </body>
</html>
