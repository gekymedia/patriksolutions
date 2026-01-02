@extends('admin.components.base')
@section('title', 'Patrik Solutions | Courses ')

@section ('content')
<form action="{{ route('user.store')}}" method="post">
    @csrf
    <div class="col-md-4">
        <label for="name" class="form-label"> Name</label>
        <input type="text" name="name" id="name" class="form-control">
        @if($errors->has('name'))
            <span class="text-danger">{{$errors->first('name')}}</span>
        @endif
    </div>
    <div class="col-md-4">
        <label for="role" class="form-label">Role</label>
        <input type="text" name="role" id="role" class="form-control">
        @if($errors->has('role'))
        <span class="text-danger">{{$errors->first('role')}}</span>
    @endif
    </div>
    <div class="col-md-4">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" id="email" class="form-control">
        @if($errors->has('email'))
        <span class="text-danger">{{$errors->first('email')}}</span>
    @endif
    </div>
    <div class="col-md-4">
        <label for="photo" class="form-label">Upload Photo</label>
        <input type="file" name="photo" id="photo" class="form-control">
        @if($errors->has('photo'))
        <span class="text-danger">{{$errors->first('photo')}}</span>
    @endif
    </div>
    {{-- Password --}}
    <div class="col-md-4">
        <label for="password" class="form-label">Upload Photo</label>
        <input type="password" name="password" id="password" class="form-control">
        @if($errors->has('password'))
        <span class="text-danger">{{$errors->first('password')}}</span>
    @endif
    </div>

    {{--Confirmed Password
    <div class="col-md-4">
        <label for="password" class="form-label">Upload Photo</label>
        <input type="password" name="password_confirmation" id="password" class="form-control">
        @if(errors->has('password'))
        <span class="text-danger">{{errors->first('password')}}</span>
    @endif
    </div> --}}

    <button type="submit">Submit</button>
</form>
@endsection