<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Your Course at Patrik Solutions') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <a href="{{ route('course.register.create') }}" class="btn btn-primary mb-4">Add New Room</a>
                <a href="#" class="btn btn-primary mb-4"><i class="fas fa-dashboard"></i> Dashboard</a>
                <div class="table-responsive">
                    @if ($courseregistration->isEmpty())
                        <p>You haven't joined any of Patrik Solues course</p>
                        <a href="{{route('course.index')}}"> View Available courses</a>
                    @else
                      <div class="row justify-content-center g-4 mb-4">
                            <div class="col-md-6 col-lg-4 mb-2">
                                <div class="card h-100 shadow">
                                    <div class="card-body d-flex flex-column black-card">
                                        <h3 class="card-title text-success">
                                            <i class="fas fa-tachometer-alt fa-1x mb-3"></i> Black-Task
                                        </h3>
                                        <p class="card-text">
                                            Manage your black tasks efficiently with our comprehensive tracking system.
                                            Stay on top of deadlines and enhance productivity.
                                        </p>
                                        {{-- <a href="{{ route('course.register.show', courseregistration)}}" class="btn btn-success mt-auto">Go to --}}
                                            Black Task</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4 mb-2">
                                <div class="card h-100 shadow">
                                    <div class="card-body d-flex flex-column presence-card">
                                        <h5 class="card-title text-warning">
                                            <i class="fas fa-eye fa-1x mb-3"></i> Presence-keep
                                        </h5>
                                        <p class="card-text">
                                            Track and record your presence with ease. Our tool ensures you never miss a
                                            moment and keeps accurate records for your needs.
                                        </p>
                                        <a href="{{ route('course.register.show') }}"class="btn btn-warning mt-auto text-white">Go to Presence Keeping</a>
                                    </div>
                                </div>
                            </div>

                            <!-- Announcements Section -->
                            {{-- <div class="col-md-6 col-lg-4 mb-3">
                                <div class="card h-100 shadow announcement-card">
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title text-info">
                                            <i class="fas fa-bullhorn fa-1x mb-3"></i> Announcements
                                        </h5>
                                        <p class="card-text">
                                            Stay updated with the latest announcements and news.
                                        </p>
                                        <a href="#" class="btn btn-info mt-auto">View Announcements</a>
                                    </div>
                                </div>
                            </div> --}}
                            <!-- Announcements Section End -->
                        </div>
                        {{-- <table class="table">
                            <thead>
                                <tr>
                                    <th>Accomodation Name</th>
                                    <th>Room Number</th>
                                    <th>Room Type</th>
                                    <th>Bed Type</th>
                                    <th>No. of Occupants</th>
                                    <th>Amenities</th>
                                    <th>Rate</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roomRegistration as $roomRegistration)
                                    <tr>
                                        <td>{{ $roomRegistration->accommodation_id }}</td>
                                        <td>{{ $roomRegistration->room_number }}</td>
                                        <td>{{ $roomRegistration->room_type }}</td>
                                        <td>{{ $roomRegistration->bed_type }}</td>
                                        <td>{{ $roomRegistration->max_occupancy }}</td>
                                        <td>{{ $roomRegistration->amenities }}</td>
                                        <td>{{ $roomRegistration->rate }}</td>
                                        <td>{{ $roomRegistration->status }}</td>
                                       
                                        <td>
                                            <a href="{{ route('admin.room_registration.show', $roomRegistration->id) }}" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                            <a href="{{ route('admin.room_registration.edit', $roomRegistration->id) }}" class="btn btn-warning"><i class="fas fa-pen"></i></a>
                                            <form action="{{ route('admin.room_registration.destroy', $roomRegistration->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table> --}}
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
