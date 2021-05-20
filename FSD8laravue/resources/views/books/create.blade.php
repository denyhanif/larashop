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
            <input type="text" class="form-control" name="title" placeholder="Book Title">
            <br>
            <label for="cover">Cover</label>
            <input type="file" class="form-control" name="cover">
            <br>
            <label for="desc" class="">Descrription</label>
            <Textarea type="text" name="desc" class="form-control" placeholder="GIve a desc about this book"></Textarea>
            <br>
            <label for="categories">Categories</label><br>
            <select multiple name="categories[]"  
                id="categories" 
                class="form-control">
            </select>
            <label for="stock">Stok</label> 
            <input type="text" name="stock" id="stock" min=0 value=0 class="form-control">
            <br>
            <label for="author" class="">Author</label>
            <input type="text" name="author" id="author" class="form-control" placeholder="book author">
            <br>
            <label for="publisher">Publisher</label>
            <input type="text" name="publisher" id="publisher" class="form-control" placeholder="book publisher">
            <br>


            <br><br/>
            <label for="price">Price</label>
            <input type="number" name="price" id="price" class="form-control" placeholder="Book Price">
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