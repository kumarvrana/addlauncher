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
                $loaderImage.show();
                let isChecked = $(this).is(':checked');
                
               // if(isChecked){
                if (working) {
                    xhr.abort();
                }

                working = true;

                xhr = $.ajax({

                url : airportFilterURL,
                method : "GET",
                async : true,
                data : $("#airport-filter").serialize(),
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
           


           //filter script starts
            let $mainElementFilter = $('.adfilter2');
            let $loaderImage = $('.loader');
            let working = false;
            $mainElementFilter.on('click', function(){
                $loaderImage.show();
                let isChecked = $(this).is(':checked');
                
               // if(isChecked){
                if (working) {
                    xhr.abort();
                }

                working = true;

                xhr = $.ajax({

                url : autoFilterURL,
                method : "GET",
                async : true,
                data : $("#auto-filter").serialize(),
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