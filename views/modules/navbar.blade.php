<nav class="flex text-gray-700 bg-white shadow-sm">
    <div x-show="!isOpen()" class="flex">
        <a x-show="!isOpen()" @click.prevent="handleOpen()" class="p-3 duration-75 transform cursor-pointer hover:bg-blue-500 hover:text-white">
            <i class="mr-1 text-xl align-middle fas fa-bars"></i>
            <span class="font-semibold align-middle">{{ $app }} <span class="text-sm font-light">v2</span></span>
        </a>
    </div>
    <div class="flex self-center w-1/4 ml-5">
        <input
            class="px-3 py-1 my-1 duration-150 border-2 border-blue-300 rounded-lg shadow-inner w-60 focus:shadow-lg hover:shadow-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent"
            type="text"
            placeholder="Rechercher une visite"
            name="search"
            onkeyup="showResult(this.value)"
        />
        {{-- DIV DE LA BARRE DE RECHERCHE --}}
        <div id="hide" class="absolute z-10 text-center rounded-lg shadow-lg bg-gray-50 mt-11 w-60">
            <div class="flex flex-col py-2" id="recherche"></div>
        </div>
    </div>
    <div class="flex ml-auto">
        <form method="POST">
            <input type="hidden" name="download" />
            <button id="download" class="items-center h-full p-3 mr-2 text-blue-400 duration-75 transform hover:bg-blue-500 hover:text-white" type="submit">
                <i class="mr-1 align-middle fas fa-download"></i>
            </button>
        </form>
        <a class="p-3 duration-75 transform hover:bg-blue-500 hover:text-white" href="#">
            <i class="mr-1 align-middle fas fa-vector-square"></i>
            <span class="font-semibold align-middle">Portail</span>
        </a>
    </div>
</nav>
