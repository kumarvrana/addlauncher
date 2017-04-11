

  <div class="nav-container visible-lg visible-md">
    <div class="nav1">
      <div class="nav2">
        <div id="pt_custommenu" class="pt_custommenu">
          <div class="container-fluid">
            <div id="pt_menu_home" class="pt_menu">
              <div class="parentMenu">

                <a href="#" class="category-link"> Category <em class="lnr lnr-chevron-right"></em><em class="lnr lnr-chevron-right"></em></a>
                @if(!empty($mediacats))
                  @foreach($mediacats as $mediacat) 
                    <a href="{{$mediacat->slug}}"><span class="cat-menu-img {{str_replace(' ','_', strtolower($mediacat->title))}}"></span> {{$mediacat->label}}</a>
                  @endforeach
                @endif
                
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div> <!-- end of fixed-div -->


