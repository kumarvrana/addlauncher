@extends('layouts.master')

@section('title')

    Outdoor Advertising | Add Launcher

@endsection

@section('content')
        @if(Session::has('success'))
        <div class="row">
            <div class="col-sm-6 col-md-4 col-md-offset-4 col-sm-offset-3">
                <div id="charge-message" class="alert alert-success">
                    {{Session::get('success')}}
                </div>
            </div>
        </div>
        @endif

<section class="sec-banner">
     <div class="jumbotron jumbo-1 text-center">
     	 <h1><small>&emsp;ADVERTISE ON</small> <br><span>{{ucwords(str_replace('_', ' ', $billboardOption))}}</span></h1>
     </div>
</section>  

<section class="main-sec">
        <div class="container-fluid"> <!-- container fluid 1 starts here -->
            <div class="row">
                <div class="col-md-2">
				@include('partials.sidebar')
                    
                </div>
                
                <div class="col-md-8" id="ads-results">
					
					<div class="row ">
					
						@if($billboards)
							
							@include('frontend-mediatype.outdooradvertisings.billboarddata')

						@endif
						<div class="buttom">
							<button class="btn btn-success more">More</button>
						</div>	
							
		            </div><!-- row before style ends here -->

		            
        		</div><!-- col-md-8 ends here -->
        		<div class="col-md-2">
            @include('partials.sidebar-cart')
   					
        			
        		</div>
    		</div>
    	</div><!-- container fluid 1 ends here -->
    	<div class="loader text-center" style="display:none">
			
		</div>
           
</section>

@endsection
@section('scripts')
	<script type="text/javascript">
		var page = 1;
		$(".more").click(function() {
		        page++;
		        loadMoreData(page);
		});

		function loadMoreData(page){
		  $.ajax(
		        {
		            url: '?page=' + page,
		            type: "get",
		            beforeSend: function()
		            {
		                $('.loader').show();
		            }
		        })
		        .done(function(data)
		        {
		            if(data.html == " "){
		                $('.loader').html("No more records found");
		                return;
		            }
		            $('.loader').hide();
		            $("#ads-results").append(data.html);
		        })
		        .fail(function(jqXHR, ajaxOptions, thrownError)
		        {
		              console.log('server not responding...');
		        });
		}
	</script>
@endsection