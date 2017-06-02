

  {{-- 

  <div class="nav-container">
    <div class="nav1">
      <div class="nav2">
        <div id="pt_custommenu" class="pt_custommenu">
          <div class="container-fluid">
            <div id="pt_menu_home" class="pt_menu">
              <div class="parentMenu">

                @if(!empty($mediacats))
                  @foreach($mediacats as $mediacat) 
                    <a href="{{env('APP_URL')}}{{$mediacat->slug}}"><span class="cat-menu-img {{str_replace(' ','_', strtolower($mediacat->title))}} hidden-md hidden-sm hidden-xs "></span> {{$mediacat->label}}</a>
                  @endforeach
                @endif
                
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div> 

  --}}

  
  
</div>
</div> <!-- end of fixed-div -->
</div><!-- end of desktop_menu -->


