var app = angular.module('rzSliderDemo', ['rzModule', 'ui.bootstrap']);
app.controller('MainCtrl', function ($scope, $attrs, $rootScope, $timeout, $modal) {
    //Minimal slider config


    $scope.minSlider = {
        value: 10
    };
    //console.log($attrs.id);
    //Range slider config
    
    switch($attrs.id){
        case 'airport-nng':
            $scope.minRangeSlider = {
                minValue: 0,
                maxValue: 5000000,
                options: {
                    floor: 0,
                    ceil: 5000000,
                    step: 10000
                }
            };
        break;
        case 'auto-nng':
            $scope.minRangeSlider = {
                minValue: 0,
                maxValue: 50000,
                options: {
                    floor: 0,
                    ceil: 50000,
                    step: 1000
                }
            };
        break;
        case 'busstop-nng':
            $scope.minRangeSlider = {
                minValue: 0,
                maxValue: 50000,
                options: {
                    floor: 0,
                    ceil: 50000,
                    step: 1000
                }
            };
        break;
        case 'bus-nng':
            $scope.minRangeSlider = {
                minValue: 0,
                maxValue: 50000,
                options: {
                    floor: 0,
                    ceil: 50000,
                    step: 1000
                }
            };
        break;

    }
    

});

 $(function(){
    $("#addClass").click(function () {
        $('#qnimate').addClass('popup-box-on');
    });

    $("#removeClass").click(function () {
        $('#qnimate').removeClass('popup-box-on');
    });
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    });
           
    //filter script starts
    let $mainElementFilter = $('.adfilter');
    let $loaderImage = $('.loader');
    let working = false;
    $mainElementFilter.on('click', function(){
        var checkModel = $('form.filterform').attr('id');
        $loaderImage.show();
        let isChecked = $(this).is(':checked');
        
        // if(isChecked){
        var filterURL = '';
        switch(checkModel){
            case 'airport-filter':
                filterURL = airportFilterURL;
                dataFilter = '#'+checkModel;
            break;
            case 'auto-filter':
                filterURL = autoFilterURL;
                dataFilter = '#'+checkModel;
            break;
            case 'busstop-filter':
                filterURL = busstopFilterURL;
                dataFilter = '#'+checkModel;
            break;
            case 'bus-filter':
                filterURL = busFilterURL;
                dataFilter = '#'+checkModel;
            break;
            case 'car-filter':
                filterURL = carFilterURL;
                dataFilter = '#'+checkModel;
            break;
            case 'cinema-filter':
                filterURL = cinemaFilterURL;
                dataFilter = '#'+checkModel;
            break;
            case 'metro':
                filterURL = metroFilterURL;
                dataFilter = '#'+checkModel;
            break;
            case 'outdoor-advertising-filter':
                filterURL = outdoor_advertisingFilterURL;
                dataFilter = '#outdoor-advertising-filter';
            break;
            case 'shoppingmall-filter':
                filterURL = shoppingmallFilterURL;
                dataFilter = '#'+checkModel;
            break;
            case 'socialmedia':
                filterURL = socialmediaFilterURL;
                dataFilter = '#'+checkModel;
            break;
            case 'television-filter':
                filterURL = televisionFilterURL;
                dataFilter = '#television-filter';
            break;
        }
        if (working) {
            xhr.abort();
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
