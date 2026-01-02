<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Room') }}
        </h2>
    </x-slot>

  @include('message.flash-message')  
    <div class="container py-12">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <form action="{{ route('admin.room_registration.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="form-group mb-4">
                                <label for="accommodation_id" class="form-label">Which accommodation you are registering the room for:</label>
                                <select name="accommodation_id" id="accommodation_id" class="form-control" required>
                                    @foreach ($accomodationregistration as $accommodation)
                                        <option value="{{ $accommodation->id }}">{{ $accommodation->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('accommodation_id')" class="mt-2" />
                            </div>


                            <div class="form-group mb-4">
                                <label for="room_number" class="form-label">Room Number</label>
                                <input type="text" name="room_number" id="room_number" class="form-control" required>
                                <x-input-error :messages="$errors->get('accommodation_id')" class="mt-2" />

                            </div>

                            <div class="form-row mb-4">
                                <div class="col">
                                    <label for="room_type" class="form-label">Room Type</label>
                                    <select name="room_type" id="room_type">
                                        <option value="Self-contained">Self Contained</option>
                                        <option value="Shared">Shared</option>
                                    </select>
                                <x-input-error :messages="$errors->get('room_type')" class="mt-2" />
                                  
                                </div>
                                <div class="col">
                                    <label for="bed_type" class="form-label">Bed Type</label>
                                    <select name="bed_type" id="room_type">
                                        <option value="Single">Single</option>
                                        <option value="Double">Double</option>
                                    </select>
                                <x-input-error :messages="$errors->get('bed_type')" class="mt-2" />

                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label for="max_occupancy" class="form-label">Maximum Occupant</label>
                                <input type="number" name="max_occupancy" id="max_occupancy" class="form-control" required>
                                <x-input-error :messages="$errors->get('max_occupancy')" class="mt-2" />
                           
                            </div>
                            <div class="form-group mb-4">
                                <label for="rate" class="form-label">Room Price Per Occupant</label>
                                <input type="number" name="rate" id="rate" class="form-control" required>
                                <x-input-error :messages="$errors->get('rate')" class="mt-2" />
                            
                            </div>
                            <div class="form-group mb-4">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="room_type">
                                    <option value="Available">Available</option>
                                    <option value="Unavailable">Unavailable</option>
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            
                            </div>
                            <div class="form-group mb-4">
                                <label for="amenities" class="form-label">Amenities</label>
                                <input type="text" name="amenities" id="amenities" class="form-control" required>
                                <x-input-error :messages="$errors->get('amenities')" class="mt-2" />
                           
                            </div>
                            <div class="form-group mb-4">
                                <label for="photo" class="form-label">Photo of the Room</label>
                                <input type="file" name="photo" id="photo" class="form-control" >
                                <x-input-error :messages="$errors->get('photo')" class="mt-2" />
                            
                            </div>
                            <div class="form-group mb-4">
                                <label for="video" class="form-label">Video of the Room</label>
                                <input type="file" name="video" id="video" class="form-control" >
                                <x-input-error :messages="$errors->get('video')" class="mt-2" />
                            
                            </div>
                            
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary">Save Room Details</button>
                                {{-- <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary"><i class="fas fa-dashboard"></i> Dashboard</a> --}}
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
