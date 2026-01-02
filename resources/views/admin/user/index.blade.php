@extends('admin.components.base')
@section('title', 'Patrik Solutions | Users ')
@section ('content-action')
<a href="{{ route('user.create') }}" class="btn btn-info">Add New</a>
@endsection

@section ('content')

<div class="card-body">
    <div class="table-responsive-lg">
        <table>
            <thead>
            <tr>
                <th>No.</th>
                <th>Name</th>
                <th>Role</th>
                <th>Photo</th>
                <th>Email</th>

            </tr>    
            </thead>
            <tbody>
                @foreach($users as $user)
            <tr>
                <th>
                    {{ $user->id}}
                </th>
                <td>
                    {{$user->name}}
                </td>
                <td>
                    {{$user->role}}
                </td>
                <td>
                    {{-- <img src="{{ $user->photo }}" alt="user profile image">  --}}
                </td>
                <td>
                    {{$user->email}}
                </td>

            </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection