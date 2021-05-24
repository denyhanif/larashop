@extends('layouts.global')

@section('title') Edit User @endsection 

@section('content')
<div class="col-md-8">

  @if(session('status'))
    <div class="alert alert-success">
      {{session('status')}}
    </div>
  @endif 

  <form 
    onsubmit=" retun confirm('Hapus User Permanen?')"
    enctype="multipart/form-data" 
    class="bg-white shadow-sm p-3" 
    action="{{route('users.update', [$user->id])}}" method="POST">

    @csrf

    <input 
      type="hidden" 
      value="PUT" 
      name="_method">
      <input 
      type="submit" 
      value="Delete" 
      class="btn btn-danger btn-sm">

    <label for="name">Name</label>
    <input 
      value="{{old('name') ? old('name'):$user->name}}" 
      class="form-control {{ $errors->first('name')?"is-invalid":"" }}" 
      placeholder="Full Name" 
      type="text" 
      name="name" 
      id="name"/>
    <br>

    <label for="username">Username</label>
    <input 
      value="old('username')? old('username') : {{$user->username}}" 
      disabled 
      class="form-control {{ $errors->first('username')? "is-invalid" : "" }}" 
      placeholder="username" 
      type="text" 
      name="username" 
      id="username"/>
    <br>

    <label for="">Status</label>
    <br/>
    <input {{$user->status == "ACTIVE" ? "checked" : ""}} 
      value="ACTIVE" 
      type="radio" 
      class="form-control" 
      id="active" 
      name="status"> 
      <label for="active">Active</label>

    <input {{$user->status == "INACTIVE" ? "checked" : ""}} 
      value="INACTIVE" 
      type="radio" 
      class="form-control" 
      id="inactive" 
      name="status"> 
      <label for="inactive">Inactive</label>
    <br><br>

    <label for="">Roles</label>
    <br>
    <input 
      type="checkbox" {{in_array("ADMIN", json_decode($user->roles)) ? "checked" : ""}} 
      name="roles[]" 
      id="ADMIN" 
      value="ADMIN"
      class="form-control {{ $errors->first('roles')?"is-invalid":"" }}"
      > 
      <label for="ADMIN">Administrator</label>

    <input 
      type="checkbox" {{in_array("STAFF", json_decode($user->roles)) ? "checked" : ""}} 
      name="roles[]" 
      id="STAFF" 
      value="STAFF"
      class="form-control {{ $errors->first('roles')?"is-invalid":"" }}"
    > 
      <label for="STAFF">Staff</label>

    <input 
      type="checkbox" {{in_array("CUSTOMER", json_decode($user->roles)) ? "checked" : ""}} 
      name="roles[]" 
      id="CUSTOMER" 
      value="CUSTOMER"
      class="form-control {{ $errors->first('roles')?"is-invalid":"" }}"

      >
       <label for="CUSTOMER">Customer</label>

    <br>

    <br>
    <label for="phone">Phone number</label> 
    <br>
    <input 
      type="text" 
      name="phone" 
      class="form-control {{ $erros->first('phone') ? "is-invalid" :"" }}" 
      value="old('phone')? old('phone') :{{$user->phone}}">
      <div class="invalid-fedback">{{ $errors->first('phone') }}</div>

    <br>
    <label for="address">Address</label>
    <textarea 
      name="address" 
      id="address" 
      class="form-control {{ $eroors->first('address') ? "is-invalid": ""}}">{{old('address')? old('address') :$user->address}}
    </textarea>
    <br>

    <label for="avatar">Avatar image</label>
    <br>
    Current avatar: <br>
    @if($user->avatar)
      <img 
        src="{{asset('storage/'.$user->avatar)}}" 
        width="120px" />
      <br>
    @else 
      No avatar
    @endif
    <br>
    <input 
      id="avatar" 
      name="avatar" 
      type="file" 
      class="form-control">
    <small 
      class="text-muted">Kosongkan jika tidak ingin mengubah avatar</small>

    <hr 
      class="my-3">

    <label for="email">Email</label>
     <input 
       value="old('email')? old('email') : {{$user->email}}" 
       disabled 
       class="form-control {{ $errors->first('email')?"is-invalid":"" }}" 
       placeholder="user@mail.com" 
       type="text" 
       name="email" 
       id="email"/>
    <br>

    <input 
      class="btn btn-primary" 
      type="submit" 
      value="Save"/>
  </form>
</div>
@endsection 