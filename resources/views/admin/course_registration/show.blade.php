<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
             Room  {{  $roomRegistration->room_number }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <a href="{{ route('admin.room_registration.create') }}" class="btn btn-primary mb-4">Add New Room</a>
                <a href="#" class="btn btn-primary mb-4"><i class="fas fa-dashboard"></i> Dashboard</a>
                <div class="table-responsive">

                  
                    <div class="col-md-4">
                        <h3>Room Number:</h3> {{$roomRegistration->room_number}}
                    </div>
                  
                    <div>
                        {{$roomRegistration->room_number}}
                    </div> 
                    @if($roomRegistration->photo)
                    <img src="{{ asset('storage/'. $roomRegistration->photo) }}" alt="Room Photo" width="200">
                @else
                    <p>No Image of room was provided.</p>
                @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
