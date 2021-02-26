@extends('layouts.global')
@section('title')
    Create Category
@endsection
@section('content')
    @if(session('status'))
    <div class="alert alert-success">
        {{session('status')}}
    </div>
    @endif 
    <form action="{{ route('categories.store') }}" class="bg-white shadow-sm p-3" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="">Category Name</label>
        <input type="text" class="form-control" name="name" id="">
        <br>
        <label for="">Category Image</label>
        <input type="file" class="form-control" name="image" id="">
        <br>
        <input type="submit" class=" btn btn-primary" value="Save">
        

    </form>
@endsection