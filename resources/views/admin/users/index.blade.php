<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Patrik Solutions Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <a href="{{ route('users.create') }}" class="btn btn-primary mb-4"><i class="fas fa-plus-circle"></i> Create</a>
                <a href="{{ route('admin-dashboard') }}" class="btn btn-success mb-4"><i class="fas fa-dashboard"></i> Dashboard</a>

                <div class="table-responsive">
                    @if ($users->isEmpty())
                        <p>No users found.</p>
                    @else
                        <table class="table">
                            <thead>
                                <tr>
                                    <th><i class="fas fa-id-card"></i> User ID</th>
                                    <th><i class="fas fa-user"></i> Name</th>
                                    <th><i class="fas fa-envelope"></i> Email</th>
                                    <th><i class="fas fa-user-tag"></i> Role</th>
                                    <th><i class="fas fa-ellipsis-h"></i> Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->unique_id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if($user->hasRole('admin'))
                                                <span class="badge bg-danger">Admin</span>
                                            @else
                                                <span class="badge bg-secondary">User</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-danger dropdown-toggle" type="button" id="actionsDropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Actions
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="actionsDropdownMenuButton">
                                                    {{-- <a class="dropdown-item btn btn-info" href="{{ route('users.show', $user->id) }}"><i class="fas fa-eye"></i> View</a> --}}
                                                    <a class="dropdown-item btn btn-success" href="{{ route('users.edit', $user->id) }}"><i class="fas fa-pen"></i> Update</a>
                                                    <div class="dropdown-divider"></div>
                                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger dropdown-item"><i class="fas fa-trash"></i> Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
