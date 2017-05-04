<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Generalsettings;
use Illuminate\Support\Facades\DB;
use Image;




class GeneralSettingsController extends Controller
{

  public function __construct()
    {
        $this->middleware('admin', ['only' => ['getGeneralSettings', 'postGeneralSettings', 'UpdateGeneralSettings']]);
    }
    // cash payment 

    public function getGeneralSettings()
    {

        $generalsetting = DB::table('generalsettings')
                ->where('id', '=', 1)
                ->first();

        $he = Generalsettings::find(1)->get(array('logo', 'sitename'));
       
        return view('backend.generalsettings.add-general')->with('general', $generalsetting);
    }

  public function postGeneralSettings(Request $request)
  {
      $this->validate($request, [

          'sitename' => 'required',
          'tagline' => 'required',
          'logo' => 'required| mimes:jpeg,bmp,png',
          'firstemail' => 'required|email',
          'secondemail' => 'email',
          'firstphone' => 'required|numeric',
          'secondphone' => 'numeric',
          'address' => 'required'
        ]);

      if($request->hasFile('logo'))
      {
        $file= $request->file('logo');
        $filename= time().'.'.$file->getClientOriginalExtension();

        $location= public_path("images\logo\\".$filename);
        Image::make($file)->save($location);
      }



      $general= new Generalsettings([

          'sitename'=>$request->input('sitename'),
          'tagline'=>$request->input('tagline'),
          'logo'=>$filename,
          'firstemail'=>$request->input('firstemail'),
          'secondemail'=>$request->input('secondemail'),
          'firstphone'=>$request->input('firstphone'),
          'secondphone'=>$request->input('secondphone'),
          'address'=>$request->input('address'),
          'facebook'=>$request->input('facebook'),
          'twitter'=>$request->input('twitter'),
          'linkedin'=>$request->input('linkedin'),
          'google'=>$request->input('google'),
          'youtube'=>$request->input('youtube'),
          'instagram'=>$request->input('instagram'),
          'reddit'=>$request->input('reddit'),
          'rss'=>$request->input('rss'),
        ]);


      $general->save();

       return redirect()->route('dashboard.generalsettings')->with('message', 'Successfully Added!');
       


  }


  public function UpdateGeneralSettings(Request $request)
    {
        $this->validate($request, [

          'sitename' => 'required',
          'tagline' => 'required',
          'logo' => 'mimes:jpeg,bmp,png',
          'logo_fixed' => 'mimes:jpeg,bmp,png',
          'favicon' => 'mimes:jpeg,bmp,png',
          'firstemail' => 'required|email',
          'secondemail' => 'email',
          'firstphone' => 'required',
          'address' => 'required'
        ]);

       
       
          



         $editsetting = Generalsettings::find(1);
          if($request->hasFile('logo'))
          {
            $file= $request->file('logo');
            $filename= time().'.'.$file->getClientOriginalExtension();

            $location= public_path("images\logo\\".$filename);
            Image::make($file)->save($location);

            $oldimage = $editsetting->logo;
            $editsetting->logo = $filename;
          }

          if($request->hasFile('logo_fixed'))
          {
            $file= $request->file('logo_fixed');
            $filename= time().'.'.$file->getClientOriginalExtension();

            $location= public_path("images\logo\\".$filename);
            Image::make($file)->save($location);

            $oldimage = $editsetting->logo_fixed;
            $editsetting->logo_fixed = $filename;
          }

          if($request->hasFile('favicon'))
          {
            $file= $request->file('favicon');
            $filename= time().'.'.$file->getClientOriginalExtension();

            $location= public_path("images\logo\\".$filename);
            Image::make($file)->save($location);

            $oldimage = $editsetting->favicon;
            $editsetting->favicon = $filename;
          }

         $editsetting->sitename = $request->input('sitename');
         $editsetting->tagline = $request->input('tagline');
         
         $editsetting->firstemail = $request->input('firstemail');
         $editsetting->secondemail = $request->input('secondemail');
         $editsetting->firstphone = $request->input('firstphone');
         $editsetting->secondphone = $request->input('secondphone');
         $editsetting->address = $request->input('address');
         $editsetting->facebook = $request->input('facebook');
         $editsetting->twitter = $request->input('twitter');
         $editsetting->linkedin = $request->input('linkedin');
          $editsetting->google = $request->input('google');
          $editsetting->youtube = $request->input('youtube');
          $editsetting->instagram = $request->input('instagram');
          $editsetting->reddit = $request->input('reddit');
          $editsetting->rss = $request->input('rss');

       $editsetting->save();

           return redirect()->route('dashboard.generalsettings')->with('message', 'Successfully Edited!');



    }


  

}
