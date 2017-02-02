<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;
use App\User;
use Auth;
use Image;
use App\Mainaddtype;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class MainaddtypeController extends Controller
{
     public function getAddList(){
        $cat_list  = Mainaddtype::all();
        return view('backend.admin.add-cat-list', ['categories' => $cat_list]);
    }

    public function getAddCategory(){
        return view('backend.admin.post-category');

    }

    public function postAddCategory(Request $request){
        
         $this->validate( $request, [
            'title' => 'required|unique:mainaddtypes',
            'description' => 'required',
            'image' => 'required|image',
            'slug' => 'required'
        ]);
        //dd($request->file('slug'));
       if($request->hasFile('image')){
           $file = $request->file('image');
           $filename = time() .'.'. $file->getClientOriginalExtension();
           //$path = public_path();
           $location = public_path("images\\" . $filename);
           Image::make($file)->resize(800, 400)->save($location);
       }
        
        $cat = new Mainaddtype([
            'image' => $filename,
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'slug' => $request->input('slug')
        ]);
        $message = 'There is some problem in posting category!';
        $success = $cat->save();

        if($success){
             $message = 'Successfully added!!';
        }

        return redirect()->route('dashboard.addCategory')->with(['message' => $message]);
    }

    public function getCatImageinList($filename){
        $file = Storage::disk('local')->get($filename);

        return New Response($file, 200);
    }

    public function getDeleteCategory($catID){
        $delele_cat = Mainaddtype::where('id', $catID)->first();
        $delele_cat->delete();

        return redirect()->route('dashboard.addCategoryList')->with(['message' => "Successfully Deleted From the List!"]);
    }
    
    public function getDeleteCategoryimage($catID){

        $delete_cat_image = Mainaddtype::where('id', $catID)->first();
        $delete_cat_image->delete();
    }
    public function getEditCategory($editcatID){
         $cat_list  = Mainaddtype::find($editcatID);
         return view('backend.admin.edit-cat', ['categorycontent' => $cat_list]);

    }
    public function postUpdateCategory(Request $request, $editcatID){
       
        $this->validate( $request, [
           'title' => 'required',
           'description' => 'required',
           'slug' => 'required',
           'image' => 'image'
        ]);
             
        $cat = Mainaddtype::find($editcatID);
        $cat->description = $request->input('description');
        $cat->slug = $request->input('slug');
      
       if($request->hasFile('image')){
           $file = $request->file('image');
           $filename = time() .'.'. $file->getClientOriginalExtension();
           $location = public_path("images\\" . $filename);
           Image::make($file)->resize(800, 400)->save($location);
           $oldimage = $cat->image;
           $cat->image = $filename;
       }
        $cat->update();

        return redirect()->route('dashboard.addCategoryList');;
        
    }

    /*public function getAddProduct(){
         $cat_list  = Mainaddtype::all();
         return view('backend.admin.add-product', ['categories' => $cat_list]);
    }*/
}
