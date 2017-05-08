 $(function(){
            $("#addClass").click(function () {
                $('#qnimate').addClass('popup-box-on');
            });
            
            $("#removeClass").click(function () {
                $('#qnimate').removeClass('popup-box-on');
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
           


           //filter script starts
            let $mainElementFilter = $('.adfilter');
            let $loaderImage = $('.loader');
            let working = false;
            $mainElementFilter.on('click', function(){
                var checkModel = $(this).parent().attr('class');
                $loaderImage.show();
                let isChecked = $(this).is(':checked');
                
               // if(isChecked){
                if (working) {
                    xhr.abort();
                }
                var filterURL = '';
                switch(checkModel){
                    case 'airport':
                        filterURL = airportFilterURL;
                        dataFilter = '#airport-filter';
                    break;
                    case 'auto':
                        filterURL = autoFilterURL;
                        dataFilter = '#auto-filter';
                    break;

                    case 'busstop':
                    filterURL = busstopFilterURL;
                    dataFilter = '#busstop-filter';
                    break;

                    case 'bus':
                    filterURL = busFilterURL;
                    dataFilter = '#bus-filter';
                    break;

                    case 'car':
                    filterURL = carFilterURL;
                    dataFilter = '#car-filter';
                    break;

                    case 'cinema':
                    filterURL = cinemaFilterURL;
                    dataFilter = '#cinema-filter';
                    break;
                    case 'metro':
                    filterURL = metroFilterURL;
                    dataFilter = '#metro-filter';
                    break;

                    case 'outdoor-advertising':
                    filterURL = outdoor_advertisingFilterURL;
                    dataFilter = '#outdoor-advertising-filter';
                    break;

                    case 'shoppingmall':
                    filterURL = shoppingmallFilterURL;
                    dataFilter = '#shoppingmall-filter';
                    break;

                    case 'socialmedia':
                    filterURL = socialmediaFilterURL;
                    dataFilter = '#socialmedia-filter';
                    break;

                    case 'television':
                    filterURL = televisionFilterURL;
                    dataFilter = '#television-filter';
                    break;
                    
                }
                working = true;

                xhr = $.ajax({

                url : filterURL,
                method : "GET",
                async : true,
                data : $(dataFilter).serialize(),
                success : function(response) {
                    $("#table-results").html(response);
                    //console.log(response);
                    $loaderImage.hide();
                    working = false;
                    }
               }); 
               // }
            });

           
        
  });



  $(function(){
            $("#addClass").click(function () {
                $('#qnimate').addClass('popup-box-on');
            });
            
            $("#removeClass").click(function () {
                $('#qnimate').removeClass('popup-box-on');
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
           


          
  });