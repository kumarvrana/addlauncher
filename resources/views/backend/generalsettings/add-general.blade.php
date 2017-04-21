@extends('backend.layouts.backend-master')

@section('title')
   General Settings | Add Launcher
@endsection

@section('content')
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <h1 class="page-header">General Settings</h1>
    <div class="row">
        <div class="col-md-12">
            @if(count($errors) > 0 )
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            @if(Session::has('message'))
                <div class="alert alert-success">
                    <p>{{Session::get('message')}}</p>
                </div>
            @endif

           
            
            <form class="form" action="{{route('dashboard.updategeneralsettings')}}" method="post" class="form-horizontal" enctype="multipart/form-data">
                <div class="col-md-6">
                    <h2>Site Options</h2>
                    <hr>
                    <div class="form-group">
                        <label for="sitename">Site Name</label>
                        <input type="text" id="sitename" name="sitename" class="form-control" value="{{$general->sitename}}" placeholder="Site name">
                    </div>

                    <div class="form-group">
                        <label for="tagline">Tagline</label>
                        <input type="text" id="tagline" name="tagline" placeholder="Tagline" value="{{$general->tagline}}" class="form-control">
                    </div>
                     <div class="form-group">
                        <label for="logo">Logo</label>
                        <input type="file" id="logo" name="logo" class="form-control" value="{{$general->logo}}">
                    </div>
                    <div class="form-group">
                        <label for="firstemail">First Email</label>
                        <input type="text" id="firstemail" name="firstemail" class="form-control" value="{{$general->firstemail}}" placeholder="Enter your email">
                    </div>
                    <div class="form-group">
                        <label for="secondemail">Second Email</label>
                        <input type="text" id="secondemail" name="secondemail" class="form-control" value="{{$general->secondemail}}" placeholder="Enter your email">
                    </div>
                      <div class="form-group">
                        <label for="firstphone">First Phone</label>
                        <input type="text" id="firstphone" name="firstphone" class="form-control" value="{{$general->firstphone}}" placeholder="Phone Number">
                    </div>
                     <div class="form-group">
                        <label for="secondphone">Second Phone</label>
                        <input type="text" id="secondphone" name="secondphone" class="form-control" value="{{$general->secondphone}}" placeholder="Phone Number">
                    </div>

                     <div class="form-group">
                        <label for="address">Address</label>
                        <textarea class="form-control" id="address" name="address" placeholder="Address">{{$general->address}}</textarea>
                    </div>
                </div>

                <div class="col-md-6">
                    <h2>Social Links</h2>
                    <hr>
                    <div class="form-group">
                        <label for="facebook">Facebook</label>
                        <input type="text" id="" name="facebook" placeholder="www.facebook.com" value="{{$general->facebook}}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="twitter">Twitter</label>
                        <input type="text" id="twitter" name="twitter" placeholder="www.twitter.com" value="{{$general->twitter}}" class="form-control">
                    </div>
                                 
                    <div class="form-group">
                        <label for="linkedin">Linkedin</label>
                        <input type="text" id="linkedin" name="linkedin" placeholder="www.linkedin.com" value="{{$general->linkedin}}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="google">Google Plus</label>
                        <input type="text" id="google" name="google" placeholder="www.googleplus.com" value="{{$general->google}}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="youtube">Youtube</label>
                        <input type="text" id="youtube" name="youtube" placeholder="www.youtube.com" value="{{$general->youtube}}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="instagram">Instagram</label>
                        <input type="text" id="instagram" name="instagram" placeholder="www.instagram.com" value="{{$general->instagram}}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="reddit">Reddit</label>
                        <input type="text" id="reddit" name="reddit" placeholder="www.reddit.com" value="{{$general->reddit}}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="rss">RSS</label>
                        <input type="text" id="rss" name="rss" placeholder="www.rss.com" value="{{$general->rss}}" class="form-control">
                    </div>
                    {{csrf_field()}}
                <button type="submit" class="action submit btn btn-success btn-block">Submit</button>   
                     
                </div>
            </form>
        </div>

    </div>
</div>     
        
@endsection

@section('scripts')

<script>
    
</script>

@endsection