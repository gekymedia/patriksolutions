<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Youtube Posts') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <a href="{{ route('youtube.create') }}" class="btn btn-primary mb-4">Create New Post</a>
                {{-- <a href="{{ route('admin-dashboard') }}" class="btn btn-primary mb-4"><i class="fas fa-dashboard"></i> Dashboard</a> --}}
                <div class="table-responsive">
                    @if ($youtubes->isEmpty())
                        <p>No YouTube links Posted Yes</p>
                    @else
                    <table  class="table">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>Title</th>
   
                            <th>View</th>
                        </tr>    
                        </thead>
                        <tbody>
                            @foreach($youtubes as $youtube)
                        <tr>
                            <th>
                                {{$youtube->id}}
                            </th>
                            <td>
                                {{$youtube->title}}
                            </td>
                            <td>
                                {!!$youtube->url!!}
                            </td>
 
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-danger dropdown-toggle" type="button" id="actionsDropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Actions
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="actionsDropdownMenuButton">
                                        <a class="dropdown-item btn btn-info" href="{{ route('index') }}"><i class="fas fa-eye"></i> View</a> 
                                        <a class="dropdown-item btn btn-success" href="{{ route('youtube.edit', $youtube->id) }}"><i class="fas fa-pen"></i> Update</a>
                                        <div class="dropdown-divider"></div>
                                        <form action="{{ route('youtube.destroy', $youtube->id) }}" method="POST" style="display:inline;">
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
