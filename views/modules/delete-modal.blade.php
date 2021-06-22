{{-- Delete Modal --}}
@foreach($visites as $visite)
<div style="background-color: rgba(0, 0, 0, 0.8);" class="fixed top-0 bottom-0 left-0 right-0 z-40 w-full h-full" x-show.transition.opacity="openDeleteModal">
    <div class="absolute left-0 right-0 max-w-xl p-4 mx-auto mt-24 overflow-hidden">
        <div class="absolute top-0 right-0 inline-flex items-center justify-center w-10 h-10 text-gray-500 bg-white rounded-full shadow cursor-pointer hover:text-gray-800" x-on:click="openDeleteModal{{ visite['id'] }} = !openDeleteModal">
            <svg class="w-6 h-6 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M16.192 6.344L11.949 10.586 7.707 6.344 6.293 7.758 10.535 12 6.293 16.242 7.707 17.656 11.949 13.414 16.192 17.656 17.606 16.242 13.364 12 17.606 7.758z" />
            </svg>
        </div>

        <div class="block w-full p-8 overflow-hidden bg-white rounded-lg shadow">
            <h2 class="pb-2 mb-6 text-2xl font-bold text-gray-800 border-b">Suppression du visiteur</h2>

            Êtes-vous sûr de vouloir supprimer ce visiteur ?

            <div class="mt-8 text-right">
                <button type="button" class="px-4 py-2 mr-2 font-semibold text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-100" @click="openDeleteModal = !openDeleteModal">
                    Annuler
                </button>
                <form method="POST">
                    <input name="id" value="{{ $visite['id'] }}" />
                    <button name="delete" type="submit" class="px-4 py-2 font-semibold text-white bg-red-500 border border-red-400 rounded-lg shadow-sm hover:bg-red-400">
                        Supprimer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
{{-- /Delete Modal --}}
