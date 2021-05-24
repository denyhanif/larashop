@extends('layouts.global')

@section('title') 
Create Book    
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        @if(session('status'))
            <div class="alert alert-success">
            {{session('status')}}
            </div>
        @endif
        <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data" class="shadow-sm p-3 bg-white">
            @csrf
            <label for="title" class="form-control">Title</label>
            <input 
              type="text" 
              class="form-control{{ $errors->first('cover')? "is-invalid":"" }}" 
              name="title" 
              placeholder="Book Title"
              value="{{ old('title') }}">
              <div class="invalid-feedback">
                {{ $errors->first('title') }}
              </div>
            <br>
            <label for="cover">Cover</label>
            <input 
              type="file" 
              class="form-control {{$errors->first('cover') ? "is-invalid" : """ 
              name="cover"
              value="">
              <div class="invalid-feedback">
                {{$errors->first('cover')}}
              </div>
            <br>

            <label for="desc" class="">Descrription</label>
            <Textarea 
              type="text" 
              name="desc" 
              class="form-control {{$errors->first('description') ? "is-invalid" : ""}}" 
              placeholder="GIve a desc about this book">{{old('description')}}</Textarea>
            <br>
            <div class="invalid-feedback">
                {{$errors->first('description')}}
            </div>
            <label for="categories">Categories</label><br>
            <select multiple name="categories[]"  
                id="categories" 
                class="form-control">
            </select>
            <label for="stock">Stok</label> 
            <input type="text" name="stock" id="stock" min=0  value="{{old('stock')}}" class="form-control {{$errors->first('stock') ? "is-invalid" : ""}} ">
            <div class="invalid-feedback">
              {{$errors->first('stock')}}
            </div>
            <br>
            <label for="author">Author</label><br>
            <input value="{{old('author')}}" type="text" class="form-control {{$errors->first('author') ? "is-invalid" : ""}} " name="author" id="author" placeholder="Book author">
            <div class="invalid-feedback">
              {{$errors->first('author')}}
            </div>
            <br>

             <label for="publisher">Publisher</label>  <br>
              <input value="{{old('publisher')}}" type="text" class="form-control {{$errors->first('publisher') ? "is-invalid" : ""}} " id="publisher" name="publisher" placeholder="Book publisher">
              <div class="invalid-feedback">
                {{$errors->first('publisher')}}
              </div>
              <br>


            <br><br/>
            <label for="Price">Price</label> <br>
            <input value="{{old('price')}}" type="number" class="form-control {{$errors->first('price') ? "is-invalid" : ""}} " name="price" id="price" placeholder="Book price">
            <div class="invalid-feedback">
              {{$errors->first('price')}}
            </div>
            <br>

            <button class="btn btn-primary" name="save_action" value="PUBLISH">Publish</button>
            <button class="btn btn-secondary" name="save_action" value="DRAFT">Save as Draft</button>
        </form>
    </div>
</div>
    
@endsection

@section('footer-script')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<script>
$('#categories').select2({
  ajax: {
    url: 'http://127.0.0.1:8000/ajax/categories/search',
    processResults: function(data){
      return {
        results: data.map(function(item){return {id: item.id, text: item.name} })
      }
    }
  }
});


</script>
@endsection