<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = \App\Models\Category::paginate(10);
        $filterKeyword = $request->get('name');
        if($filterKeyword){
        $categories = \App\Models\Category::where("name", "LIKE", "%$filterKeyword%")->paginate(10);
        }
        return view('categories.index',['categories'=>$categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        \Validator::make($request->all(), [
        "name" => "required|min:3|max:20",
        "image" => "required"
        ])->validate();
        
        $name = $request->name;

        $new_category = new \App\Models\Category;
        $new_category->name =$name;
        if($request->file('image')){
            $image_path = $request->file('image')->store('category_image','public');
            $new_category->image=$image_path;
        }
        $new_category->created_by= \Auth::user()->id;
        $new_category->slug = Str::slug($name,'-');
        $new_category->save();
        return redirect()->route('categories.create')->with('status','category telah dibuat');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = \App\Models\Category::findOrFail($id);

        return view('categories.show', ['category' => $category]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category_edit = \App\Models\Category::findOrFail($id);
        return view('categories.edit',['category'=>$category_edit]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        \Validator::make($request->all(),[
            "name"=>"required|min:3|max:20",
            "image"=>"required",
            "slug"=>[
                "required",Rule::unique("categories")->ignore($category->slug,"slug")
            ]
        ])->validate();

        $name=$request->get('name');
        $slug=$request->get('slug');

        $category = \App\Models\Category::findOrFail($id);
        $category->name = $name;
        $category->slug= $slug;
        if($request->file('image')){
            if($category->image && file_exists(storage_path('app/public'.$category->image))){
                \Storage::delete('public/'.$category->name);
            }
            $new_image = $request->file('image')->store('category_images','public');

            $category->image =$new_image;
        }
        $category->updated_by = \Auth::user()->id;
        $category->slug = \Str::slug($name);
        $category->save();
        return redirect()->route('categories.edit', [$id])->with('status', 'Category successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = \App\Models\Category::findOrFail($id);

        $category->delete();
         return redirect()->route('categories.index')
        ->with('status', 'Category successfully moved to trash');
    }
    public function trash(){
        $deleted_category = \App\Models\Category::onlyTrashed()->paginate(10);

        return view('categories.trash', ['categories' => $deleted_category]);
    }
    public function restore($id){
        //Perhatikan bahwa untuk mencari Category kita menggunakan method eloquent withTrashed() karena kita ingin mencari semua Category baik yang aktif maupun yang ada di trash / soft deleted. Jika tidak menggunakan withTrashed() akan sangat mungkin kita mendapatkan error not found.

        $category = \App\Models\Category::withTrashed()->findOrFail($id);
        if($category->trashed()){
            $category->restore();
        }else{
            return redirect()->route('categories.index')->with('status','Category is not in trash');
        }
        return redirect()->route('categories.index')->with('status','Category uscessfully restored');
    }
    public function deletePermanent($id){
        $category = \App\Models\Category::withTrashed()->findOrFail($id);

        if(!$category->trashed()){
        //Dengan kode di atas kita tetap menggunakan method withTrashed() saat melakukan query model Category
        //lalu kita cek jika kategori yang akan dihapus permanent statusnya tidak di tong sampah / trashed / soft delete 
        //maka kita stop operasi hapus permanent ini dan redirect dengan pesan tidak bisa menghapus kategori yang sedang aktif.

        return redirect()->route('categories.index')
            ->with('status', 'Can not delete permanent active category');
        } else {
            //Selanjutnya jika kategori tersebut memang sedang dalam tong sampah
            // maka kita hapus secara permanent menggunakan method forceDelete()
            // kemudian redirect kembali ke halaman categories list
            // dengan pesan bahwa kategori telah dihapus secara permanent.
            $category->forceDelete();

            return redirect()->route('categories.index')
            ->with('status', 'Category permanently deleted');

        }

    }

    public function ajaxSearch(Request $request){
        
         $keyword = $request->get('q');

//      $categories = \App\Models\Category::where("name", "LIKE", "%$keyword%")->get();
              $categories = \App\Models\Category::where("name" , "LIKE" ,"%$keyword%")->get();


      return $categories;
        
        
        // $keyword = $request->get('q');
        // $categories = \App\Models\Category::where("name" , "LIKE" ,"%keyword%")->get();
        // return $categories;
    }
    
}


