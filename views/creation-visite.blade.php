<!DOCTYPE html>
<html lang="fr">
    <head>
        @include('modules.head')
        <?php include dirname(__DIR__) . '/../lang/fr.php'; ?>
    </head>
    <body x-data="sidebar()" class="text-gray-600 bg-gray-200" @resize.window="handleResize()">
        <div class="xl:flex">
            @include('modules.sidebar')
            <div class="w-full">
                @include('modules.navbar')
                {{-- DIV EN DEV DE LA BARRE DE RECHERCHE --}}
                <div id="recherche"></div>
                <main class="grid gap-4 px-4 md:grid-cols-1 lg:grid-cols-1">
                    <div class="relative">
                        <div class="absolute px-10 py-5 -mt-10 transform -translate-x-1/2 bg-blue-100 rounded-lg shadow-lg top-1/2 left-1/2">
                            <h1 class="self-center justify-center text-xl font-bold text-gray-600 select-none md:text-2xl">Enregistrement</h1>
                        </div>
                    </div>
                    <form method="POST" class="flex items-center justify-center mt-20">
                        <div class="grid pr-10">
                            <div class="w-full bg-white rounded-lg shadow-xl">
                                <div class="flex justify-center">
                                    <div class="flex">
                                        <h1 class="mt-5 text-xl font-bold text-gray-600 md:text-2xl">Visiteur</h1>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 gap-2 mt-5 md:grid-cols-2 md:gap-4 mx-7">
                                    <div class="grid grid-cols-1">
                                        <label class="text-xs font-bold text-gray-600 uppercase md:text-sm">
                                            Nom
                                            <i class="text-red-500 align-text-top fas fa-star-of-life" style="font-size: 0.45rem;"></i>
                                        </label>
                                        <input
                                            class="px-3 py-2 mt-1 duration-150 border-2 border-blue-300 rounded-lg shadow-inner focus:shadow-lg hover:shadow-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent"
                                            type="text"
                                            name="nom"
                                            placeholder="Entrez un nom"
                                            required
                                        />
                                    </div>
                                    <div class="grid grid-cols-1">
                                        <label class="text-xs font-bold text-gray-600 uppercase md:text-sm">
                                            Prénom
                                            <i class="text-red-500 align-text-top fas fa-star-of-life" style="font-size: 0.45rem;"></i>
                                        </label>
                                        <input
                                            class="px-3 py-2 mt-1 duration-150 border-2 border-blue-300 rounded-lg shadow-inner focus:shadow-lg hover:shadow-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent"
                                            type="text"
                                            name="prenom"
                                            placeholder="Entrez un prénom"
                                            required
                                        />
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 gap-2 mt-5 md:grid-cols-2 md:gap-4 mx-7">
                                    <div class="grid grid-cols-1">
                                        <label class="text-xs font-bold text-gray-600 uppercase md:text-sm">
                                            Société
                                        </label>
                                        <input
                                            class="px-3 py-2 mt-1 duration-150 border-2 border-blue-300 rounded-lg shadow-inner focus:shadow-lg hover:shadow-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent"
                                            type="text"
                                            name="societe"
                                            placeholder="Entrez un nom de société"
                                        />
                                    </div>
                                    <div class="grid grid-cols-1">
                                        <label class="text-xs font-bold text-gray-600 uppercase md:text-sm">
                                            Motif
                                            <i class="text-red-500 align-text-top fas fa-star-of-life" style="font-size: 0.45rem;"></i>
                                        </label>
                                        <select
                                            name="motif"
                                            class="px-3 py-2 mt-1 duration-150 border-2 border-blue-300 rounded-lg shadow-inner focus:shadow-lg hover:shadow-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent"
                                        >
                                            @foreach($motifs as $motif)
                                            <option value="{{$motif['nom']}}">{{$motif['nom']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-2 mt-5 pb-7 md:grid-cols-4 md:gap-4 mx-7">
                                    <div class="grid grid-cols-1">
                                        <label class="text-xs font-bold text-gray-600 uppercase md:text-sm">
                                            Date d'arrivée
                                            <i class="text-red-500 align-text-top fas fa-star-of-life" style="font-size: 0.45rem;"></i>
                                        </label>
                                        <input
                                            class="px-3 py-2 mt-1 duration-150 border-2 border-blue-300 rounded-lg shadow-inner focus:shadow-lg hover:shadow-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent"
                                            type="date"
                                            name="date_arrivee"
                                            required
                                        />
                                    </div>
                                    <div class="grid grid-cols-1">
                                        <label class="text-xs font-bold text-gray-600 uppercase md:text-sm">
                                            Heure d'arrivée
                                            <i class="text-red-500 align-text-top fas fa-star-of-life" style="font-size: 0.45rem;"></i>
                                        </label>
                                        <input
                                            class="px-3 py-2 mt-1 duration-150 border-2 border-blue-300 rounded-lg shadow-inner focus:shadow-lg hover:shadow-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent"
                                            type="time"
                                            name="heure_arrivee"
                                            required
                                        />
                                    </div>
                                    <div class="grid grid-cols-1">
                                        <label class="text-xs font-bold text-gray-600 uppercase md:text-sm">
                                            Date de départ
                                            <i class="text-red-500 align-text-top fas fa-star-of-life" style="font-size: 0.45rem;"></i>
                                        </label>
                                        <input
                                            class="px-3 py-2 mt-1 duration-150 border-2 border-blue-300 rounded-lg shadow-inner focus:shadow-lg hover:shadow-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent"
                                            type="date"
                                            name="date_depart"
                                            required
                                        />
                                    </div>
                                    <div class="grid grid-cols-1">
                                        <label class="text-xs font-bold text-gray-600 uppercase md:text-sm">
                                            Heure de départ
                                            <i class="text-red-500 align-text-top fas fa-star-of-life" style="font-size: 0.45rem;"></i>
                                        </label>
                                        <input
                                            class="px-3 py-2 mt-1 duration-150 border-2 border-blue-300 rounded-lg shadow-inner focus:shadow-lg hover:shadow-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent"
                                            type="time"
                                            name="heure_depart"
                                            required
                                        />
                                    </div>
                                </div>
                            </div>

                            <div class="w-full mt-12 bg-white rounded-lg shadow-xl pb-7">
                                <div class="flex justify-center">
                                    <div class="flex">
                                        <h1 class="mt-5 text-xl font-bold text-gray-600 md:text-2xl">Agent</h1>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 gap-2 mt-5 md:grid-cols-2 md:gap-4 mx-7">
                                    <div class="grid grid-cols-1">
                                        <label class="text-xs font-bold text-gray-600 uppercase md:text-sm">Nom</label>
                                        <input class="px-3 py-2 mt-1 text-gray-600 bg-gray-200 border-2 border-gray-300 rounded-lg shadow-inner" type="text" placeholder="Nom de l'agent" value="Jesuis" disabled />
                                    </div>
                                    <div class="grid grid-cols-1">
                                        <label class="text-xs font-bold text-gray-600 uppercase md:text-sm">Prénom</label>
                                        <input class="px-3 py-2 mt-1 text-gray-600 bg-gray-200 border-2 border-gray-300 rounded-lg shadow-inner" type="text" placeholder="Prénom de l'agent" value="Temporaire" disabled />
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 mt-5 mx-7">
                                    <label class="text-xs font-bold text-gray-600 uppercase md:text-sm">Email</label>
                                    <input class="px-3 py-2 mt-1 text-gray-600 bg-gray-200 border-2 border-gray-300 rounded-lg shadow-inner focus:border-transparent" type="text" placeholder="Email de l'agent" value="Jesuistemporaire@test.fr" disabled />
                                </div>
                            </div>
                        </div>
                        <div class="grid">
                            <div class="w-full bg-white rounded-lg shadow-xl">
                                <div class="flex justify-center">
                                    <div class="flex">
                                        <h1 class="mt-5 text-xl font-bold text-gray-600 md:text-2xl">Informations</h1>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 mt-5 mx-7">
                                    <label class="text-xs font-bold text-gray-600 uppercase md:text-sm">
                                        Lieu de Rendez-vous
                                        <i class="text-red-500 align-text-top fas fa-star-of-life" style="font-size: 0.45rem;"></i>
                                    </label>
                                    <input
                                        class="px-3 py-2 mt-1 duration-150 border-2 border-blue-300 rounded-lg shadow-inner focus:shadow-lg hover:shadow-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent"
                                        type="text"
                                        name="lieu_rdv"
                                        placeholder="Entrez un lieu"
                                        required
                                    />
                                </div>
                                <div class="grid grid-cols-1 mt-5 pb-7 mx-7">
                                    <label class="text-xs font-bold text-gray-600 uppercase md:text-sm">Commentaires</label>
                                    <textarea
                                        class="px-3 py-2 mt-1 duration-150 border-2 border-blue-300 rounded-lg shadow-inner resize-y focus:shadow-lg hover:shadow-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent"
                                        rows="10"
                                        name="commentaires"
                                        placeholder="Écrivez des commentaires"
                                    ></textarea>
                                    <a class="mt-2 text-xs italic text-gray-600"><i class="text-red-500 align-text-top fas fa-star-of-life" style="font-size: 0.45rem;"></i> Champs de textes obligatoires</a>
                                </div>
                                <input type="hidden" value="en attente" name="statut" required />
                            </div>
                            <div class="flex items-center justify-center mt-10">
                                <button type="submit" class="w-auto px-6 py-3 font-bold text-white duration-200 transform bg-blue-500 rounded-lg shadow-xl hover:scale-110 hover:bg-blue-700">Enregistrer la visite</button>
                            </div>
                        </div>
                    </form>
                </main>
            </div>
        </div>
        @include('modules.scripts')
    </body>
</html>
