@extends('layouts.global')

@section('title') Edit Category @endsection 

@section('content')
  <div class="col-md-8">
    <form action="{{route('categories.update', [$category->id])}}" enctype="multipart/form-data" method="POST"class="bg-white shadow-sm p-3" >
      @csrf 
        <input  type="hidden"  value="PUT"  name="_method">
        <input type="text" 
          class="form-control 
          {{$errors->first('name') ? "is-invalid" : ""}}" 
          value="{{old('name') ? old('name') : $category->name}}" 
          name="name"
          >
          <div class="invalid-feedback">{{ $errors->first('name') }}</div>
        <br>

        <label for="Category Slug"></label>
        <input type="text" 
          class="form-control 
          {{$errors->first('slug') ? "is-invalid" : ""}}" 
          value="{{old('slug') ? old('slug') : $category->slug}}" 
          name="slug">
          <div class="invalid-feedback">
            {{ $errors->first('slug') }}
          </div>
          <br><br>

          <label for="">Category Image</label>
        @if($category->image)
            <span>Current Image</span>
            <br>
            <img src="{{ asset('storage/'.$category->image) }}" width="120px" alt="" class="">
        @endif

        <input type="file" 
          name="image" 
          class="form-control{{ $errors->first('image')? "is-invalid":"" }}">
        <small class="text-muted">Kosongkan Jika Tidak ingin Dirubah</small>
        <input type="submit" class="btn btn-primary" value="Update">
    </form>
  </div>
@endsection 