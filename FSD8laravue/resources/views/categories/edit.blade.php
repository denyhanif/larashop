@extends('layouts.global')

@section('title') Edit Category @endsection 

@section('content')
  <div class="col-md-8">
    <form action="{{route('categories.update', [$category->id])}}" enctype="multipart/form-data" method="POST"class="bg-white shadow-sm p-3" >
      @csrf 
        <input  type="hidden"  value="PUT"  name="_method">
        <input type="text" class="form-control" value="{{ $category->name }}" name="name">
        <br>
        <label for="Category Slug"></label>
        <input type="text" class="form-control" name="slug" value="{{ $category->slug }}">
        @if($category->image)
            <span>Current Image</span>
            <br>
            <img src="{{ asset('storage/'.$category->image) }}" width="120px" alt="" class="">
        @endif

        <input type="file" name="image" class="form-control">
        <small class="text-muted">Kosongkan Jika Tidak ingin Dirubah</small>
        <input type="submit" class="btn btn-primary" value="Update">
    </form>
  </div>
@endsection 