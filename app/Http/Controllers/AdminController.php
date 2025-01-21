<?php

namespace App\Http\Controllers;

use id;
use File;
use Carbon\Carbon;
use App\Models\Brand;
// use Illuminate\Support\Carbon;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Intervention\Image\Laravel\Facades\Image;

class AdminController extends Controller
{
    public function index(){
        return view('admin.index');
    }

    public function brands(){
        $brands = Brand::orderBy('id','ASC' )->paginate(10);
        return view('admin.brands', compact('brands'));
    }

    public function add_brand(){
        return view('admin.add-brand');
    }

    public function brand_store(Request $request){

        $request->validate([
            'name' => 'required',
            'slugg' => 'required|unique:brands',
            'image'=> ' max:2048'
        ]);

        $brand = new Brand();
        $brand->name = $request->name;
        $brand->slugg = Str::slug($request->name);
        $image = $request->file('image');
        $file_extention = $request->file('image')->extension();
        $file_name = Carbon::now()->timestamp.'.'.$file_extention;
        $this->brandThumbailsImage($image, $file_name);
        $brand->image= $file_name;
        $brand -> save();

        return redirect() -> route('admin.brands')-> with('status', 'brand has been successfully added');

    }

    public function brandThumbailsImage($image, $imageName){
        $destinationPath = public_path('uploads/brands');
        
        $img = Image::read($image->path());
        $img -> cover(124,124, "top");
        $img -> resize(124,124);
        $img->save(path: $destinationPath.'/'.$imageName);
    }

    public function brand_edit($id) {
        $brand = Brand::find($id);
        return view('admin.brand-edit', compact('brand'));
    }

    public function brand_update(Request $request){

        $request->validate([
            'name' => 'required',
            'slugg' => 'required',
            'image'=> 'mimes:png,jpg,jpeg | max:2048'
        ]);
        $brand = Brand::find($request->id);

        $brand->name = $request->name;
        $brand->slugg = Str::slug($request->name);
        if($request->hasFile('image')){
            if(File::exists(public_path('uploads/brands').'/'.$brand->image))
            {
                File::delete(public_path('uploads/brands').'/'.$brand->image);
            }
            $image = $request->file('image');
            $file_extention = $request->file('image')->extension();
            $file_name = Carbon::now()->timestamp.'.'.$file_extention;
            $this->brandThumbailsImage($image, $file_name);
            $brand->image= $file_name;
        }
       
        $brand -> save();

        return redirect() -> route('admin.brands')-> with('status', 'brand has been successfully updated');
    }

    public function brand_delete($id)  {
        $brand = Brand::find($id);
        if(File::exists(public_path('uploads/brands').'/'.$brand->image))
            {
                File::delete(public_path('uploads/brands').'/'.$brand->image);
            }
            $brand->delete();
            return redirect() -> route('admin.brands')-> with('status', 'brand has been successfully deleted');

    }

    public function categories(){
        $categories = Category::orderBy('id', 'DESC')->paginate(10);
        return view('admin.categories', compact('categories'));
    }

    public function add_category(){
        return view('admin.add-category');
    }

    public function store_category(Request $request){
        $request->validate([
            'name' => 'required',
            'slugg' => 'required|unique:categories',
            'image'=> ' max:2048'
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->slugg = Str::slug($request->name);
        $image = $request->file('image');
        $file_extention = $request->file('image')->extension();
        $file_name = Carbon::now()->timestamp.'.'.$file_extention;
        $this->categoryThumbailsImage($image, $file_name);
        $category->image= $file_name;
        $category -> save();

        return redirect() -> route('admin.categories')-> with('status', 'Category has been successfully added');
    }

    public function categoryThumbailsImage($image, $imageName){
        $destinationPath = public_path('uploads/categories');
        
        $img = Image::read($image->path());
        $img -> cover(124,124, "top");
        $img -> resize(124,124);
        $img->save(path: $destinationPath.'/'.$imageName);
    }

    public function edit_category($id){
        $category = Category::find($id);
        return view('admin.edit-category', compact('category'));
    }

    public function category_update(Request $request){

        $request->validate([
            'name' => 'required',
            'slugg' => 'required',
            'image'=> 'mimes:png,jpg,jpeg | max:2048'
        ]);
        $category = Category::find($request->id);

        $category->name = $request->name;
        $category->slugg = Str::slug($request->name);
        if($request->hasFile('image')){
            if(File::exists(public_path('uploads/categories').'/'.$category->image))
            {
                File::delete(public_path('uploads/categories').'/'.$category->image);
            }
            $image = $request->file('image');
            $file_extention = $request->file('image')->extension();
            $file_name = Carbon::now()->timestamp.'.'.$file_extention;
            $this->categoryThumbailsImage($image, $file_name);
            $category->image= $file_name;
        }
       
        $category -> save();

        return redirect() -> route('admin.categories')-> with('status', 'Category has been successfully updated');
    }

    public function category_delete($id)  {
        $brand = Category::find($id);
        if(File::exists(public_path('uploads/categories').'/'.$brand->image))
            {
                File::delete(public_path('uploads/categories').'/'.$brand->image);
            }
            $brand->delete();
            return redirect() -> route('admin.categories')-> with('status', 'Category has been successfully deleted');

    }

}
