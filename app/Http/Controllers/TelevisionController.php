<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Session;
use App\Televisions;
use App\Televisionsprice;
use Image;
use App\Product;
use Illuminate\Support\Facades\File;
use App\Cart;
use App\Order;


class TelevisionController extends Controller
{
    //Backend functions below

	// get list of all the products in television stop media type
	public function getDashboardTelevisionList()
	{
        $television_ads = Televisions::all();
        return view('backend.mediatypes.televisions.television-list', ['television_ads' => $television_ads]);
    }

    // get form of television stop media type
     public function getDashboardTelevisionForm()
    {
        return view('backend.mediatypes.televisions.television-addform');
    }

    // post list of all the products in television media type

    public function postDashboardTelevisionForm(Request $request)
    {
         // dd($request->all());
        $this->validate( $request, [
           'title' => 'required',
           'price' => 'numeric',
           'image' => 'required|image',
           'location' => 'required',
           'state' => 'required',
           'city' => 'required',
           'rank' => 'numeric',
           'description' => 'required',
           'status' => 'required'
        ]);

        if($request->hasFile('image')){
            $file = $request->file('image');
            $filename = time() .'.'. $file->getClientOriginalExtension();
            $location = public_path("images\\televisions\\" . $filename);
            Image::make($file)->resize(800, 400)->save($location);
        }

        $television = new Televisions([
                'title' => $request->input('title'),
                'price' => $request->input('price'),
                'image' => $filename,
                'location' => $request->input('location'),
                'state' =>  $request->input('state'),
                'city' => $request->input('city'),
                'rank' => $request->input('rank'),
                'landmark' => $request->input('landmark'),
                'description' => $request->input('description'),
                'references' => $request->input('reference'),
                'status' => $request->input('status'),
                'display_options' => serialize($request->input('televisiondisplay')),
                'light_option' => $request->input('aplighting'),
                'discount' => $request->input('televisiondiscount'),
                'televisionnumber' => $request->input('televisionsnumber')
        ]);

        $television->save();
       
        //return to television product list
       return redirect()->route('dashboard.getTelevisionList')->with('message', 'Successfully Added!');
    }

    // delete television product 

    public function getDeleteTelevisionad($televisionadID)
    {
        $delele_televisionad = Televisions::where('id', $televisionadID)->first();
        $delele_televisionad->delete();
        
       
        return redirect()->route('dashboard.getTelevisionList')->with(['message' => "Successfully Deleted From the List!"]);
    }

    // update television product
    public function getUpdateeTelevisionad($ID)
    {
        $televisionData = Televisions::find($ID);
        
        $fieldData = array();

        $fieldDatas = serialize($fieldData);
        return view('backend.mediatypes.televisions.television-editform', ['television' => $televisionData,  'fieldData' => $fieldDatas]);
    }

    public function postUpdateeTelevisionad(Request $request, $ID)
    {
       $this->validate( $request, [
           'title' => 'required',
           'price' => 'numeric',
           //'image' => 'required|image',
           'location' => 'required',
           'state' => 'required',
           'city' => 'required',
           'rank' => 'numeric',
           'description' => 'required',
           'status' => 'required'
        ]);

        $edittelevision = Televisions::find($ID);

         $edittelevision->title = $request->input('title');
         $edittelevision->price = $request->input('price');
         $edittelevision->location = $request->input('location');
         $edittelevision->state = $request->input('state');
         $edittelevision->city = $request->input('city');
         $edittelevision->rank = $request->input('rank');
         $edittelevision->landmark = $request->input('landmark');
         $edittelevision->description = $request->input('description');
         $edittelevision->status = $request->input('status');
         $edittelevision->references = $request->input('reference');
         $edittelevision->display_options = serialize($request->input('televisiondisplay'));
         
        if($request->hasFile('image')){
            $file = $request->file('image');
            $filename = time() .'.'. $file->getClientOriginalExtension();
            $location = public_path("images\\televisions\\" . $filename);
            Image::make($file)->resize(800, 400)->save($location);
            $oldimage = $edittelevision->image;
            $edittelevision->image = $filename;
        }

       $edittelevision->update();

        //television display prices insertion
        
     
        //return to television product list
       return redirect()->route('dashboard.getTelevisionList')->with('message', 'Successfully Edited!');
    }

}

