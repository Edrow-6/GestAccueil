<div class="flex justify-center item-center">
    <div class="w-4 mr-2 duration-75 transform cursor-pointer hover:text-blue-500 hover:scale-125" @click="goToCalendar()">
        <i class="far fa-calendar-alt"></i>
    </div>
    <div class="w-4 mr-2 duration-75 transform cursor-pointer hover:text-blue-500 hover:scale-125" @click="showEditModal()">
        <i class="far fa-edit"></i>
    </div>
    <div class="w-4 text-red-500 duration-75 transform cursor-pointer hover:scale-125 hover:text-red-500" @click="showDeleteModal()">
        <i class="far fa-trash-alt"></i>
    </div>
</div>
