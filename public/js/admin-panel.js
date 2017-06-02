$(document).ready(function() {
    $('.dropdown-menu li a').click(function(event) {
        var option = $(event.target).text();
        $(event.target).parents('.btn-group').find('.dropdown-toggle').html(option + ' <span class="caret"></span>');
    });
});

function ConfirmDelete() {
    var x = confirm("Are you sure you want to delete?");
    if (x)
        return true;
    else
        return false;
}


$(function() {
    $(".tip-left").tooltip({
        placement: 'left',
    });
    $("#light-content").hide();
    var category_id = 0;
    var descriptionTD;
    $('.edit-category').on('click', function(event) {

        event.preventDefault();

        var title = $(this).parent().parent().parent().find('td:eq(1)').text();
        descriptionTD = $(this).parent().parent().parent().find('td:eq(2)');
        var description = descriptionTD.text();
        var image = $(this).parent().parent().parent().find('td:eq(3)').find('img').attr('src');
        category_id = $(this).parent().parent().parent().find('#category-id').val(); //alert(title+"  "+description+"  "+image);
        //alert(category_id);
        $('#title').val(title);
        $('#description').val(description);
        $('#update-category-image').attr('src', image);
        $('#edit-ad-category').modal();
    });
    $('#update-cat-modal').on('click', function() {

        var token = $("input[name=_token]").val();

        $.ajax({
                method: 'POST',
                url: updateCatUrl,
                data: {
                    description: tinyMCE.get('description'),
                    catID: category_id,
                    _token: token
                }
            })
            .done(function(msg) {
                console.log(JSON.stringify(msg));
                descriptionTD.text(msg['description']);
                $('#edit-ad-category').modal('hide');

            });
    });
    // kjkk

});

function htmlbodyHeightUpdate() {
    var height3 = $(window).height()
    var height1 = $('.nav').height() + 50
    height2 = $('.main').height()
    if (height2 > height3) {
        $('html').height(Math.max(height1, height3, height2) + 10);
        $('body').height(Math.max(height1, height3, height2) + 10);
    } else {
        $('html').height(Math.max(height1, height3, height2));
        $('body').height(Math.max(height1, height3, height2));
    }

}
$(document).ready(function() {
    htmlbodyHeightUpdate()
    $(window).resize(function() {
        htmlbodyHeightUpdate()
    });
    $(window).scroll(function() {
        height2 = $('.main').height()
        htmlbodyHeightUpdate()
    });
});
$(function() {
    setNavigation();
});

function setNavigation() {
    var path = window.location.pathname;
    path = path.replace(/\/$/, "");
    path = decodeURIComponent(path);
    path = "http://myshop.dev" + path;
    $(".sidebar-nav a").each(function() {
        var href = $(this).attr('href');

        if (path.substring(0, href.length) === href) {

            $(this).closest('li').addClass('active');
        }
    });
}

var msg = '';
$(function() {
    $('#mediatype').on('change', function() {
        var mediaCat = $(this).find(':selected').data('name');
        if (typeof mediaCat === "undefined") {
            msg = "Select Category";
            return msg;
        } else {
            $.ajax({
                    method: 'GET',
                    url: CathtmlUrl,
                    data: {
                        mediaCat: mediaCat
                    }
                })
                .done(function(msg) {
                    $('.results').html(msg['response']);
                });
        }
    });

    //Start Auto options code

    var fieldisieditpage = document.getElementById("priceData");
    $('.e_rickshawOtions, .autorikshawOtions, .magazine, .newspaper').hide();
    if (fieldisieditpage) {
        var selectedAutotypeEdit = $('#autotype').find(':selected').attr('value');
        if (selectedAutotypeEdit == 'auto_rikshaw') {
            $('.autorikshawOtions').addClass('selected');
            $('.autorikshawOtions').show();
        }
        if (selectedAutotypeEdit == 'e_rikshaw') {
            $('.e_rickshawOtions').addClass('selected');
            $('.e_rickshawOtions').show();
        }

        var selectedPrintMediatypeEdit = $('#printmedia_type').find(':selected').attr('value');
        if (selectedPrintMediatypeEdit == 'newspaper') {
            $('.newspaper').addClass('selected');
            $('.newspaper').show();
        }
        if (selectedPrintMediatypeEdit == 'magazine') {
            $('.magazine').addClass('selected');
            $('.magazine').show();
        }
    }


    $('#autotype').on('change', function() {
        $('.selected').hide();
        $('.selected').removeClass('selected');
        var selectedAutotype = $(this).find(':selected').attr('value');
        if (typeof selectedAutotype === "undefined") {
            msg = "Select Auto Type";
            return msg;
        } else {
            if (selectedAutotype == 'auto_rikshaw') {
                $('.autorikshawOtions').addClass('selected');
                $('.autorikshawOtions').show();
            }
            if (selectedAutotype == 'e_rikshaw') {
                $('.e_rickshawOtions').addClass('selected');
                $('.e_rickshawOtions').show();
            }
        }
    });
//print media

    $('#printmedia_type').on('change', function() {
        $('.selected').hide();
        $('.selected').removeClass('selected');
        var selectedprintmediatype = $(this).find(':selected').attr('value');
        
        if (typeof selectedprintmediatype === "undefined") {
            msg = "Select Print Media Type";
            return msg;
        } else {
             $('.'+selectedprintmediatype).addClass('selected');
             $('.'+selectedprintmediatype).show();
        }
    });
    
    //End Auto options code
    //Start Television options code
    var fieldisieditpage = document.getElementById("priceData");
    $('.newsoptions').hide();
    if (fieldisieditpage) {
        var selectedTelevisiontypeEdit = $('#genre').find(':selected').attr('value');
        if (selectedTelevisiontypeEdit == 'News') {
            $('.newsoptions').addClass('selected');
            $('.newsoptions').show();
        }

    }

    $('#genre').on('change', function() {
        $('.selected').hide();
        $('.selected').removeClass('selected');
        var selectedTelevisiontype = $(this).find(':selected').attr('value');
        if (typeof selectedTelevisiontype === "undefined") {
            msg = "Select Genre Type";
            return msg;
        } else {
            if (selectedTelevisiontype == 'News') {
                $('.newsoptions').addClass('selected');
                $('.newsoptions').show();
            }

        }
    });
    //End Television options code


});

// making category slug
var Slug = '';

function makeSlug() {

    var title_val = document.getElementById("category-name");
    var Slug = title_val.value.replace(/([~!@#$%^&*()_+=`{}\[\]\|\\:;'<>,.\/? ])+/g, '-').replace(/^(-)+|(-)+$/g, '');
    Slug = Slug.toLowerCase();
    Slug = 'media/' + Slug;
    document.getElementById('category-slug').value = Slug;
}

$("#category-name").focusout(function() {
    var title_val = document.getElementById("category-name");
    var Slug = title_val.value.replace(/([~!@#$%^&*()_+=`{}\[\]\|\\:;'<>,.\/? ])+/g, '-').replace(/^(-)+|(-)+$/g, '');
    Slug = Slug.toLowerCase();
    Slug = 'media/' + Slug;
    document.getElementById('category-slug').value = Slug;
});
//ends


fieldData = [];
var fieldisi = document.getElementById("priceData");
if (fieldisi) {
    var editfieldData = fieldisi.value;
    editfieldData = JSON.parse(editfieldData);
    fieldData = fieldData.concat(editfieldData);

    var formTable = document.getElementById("tablename");
    if( formTable.value === 'cinemas' ){
        var generalOptions = document.getElementById("display_options");
        var otherOptions = document.getElementById("additional_adsoption");
        if (generalOptions) {
            var generalOptionsData = generalOptions.value;
            generalOptionsData = JSON.parse(generalOptionsData);

        }
        if (otherOptions) {
            var otherOptionsData = otherOptions.value;
            otherOptionsData = JSON.parse(otherOptionsData);
        }
    }
    if (formTable.value == 'newspapers') {
        var generalOptions = document.getElementById("general_options");
        var otherOptions = document.getElementById("other_options");
        var classifiedOptions = document.getElementById("classified_options");
        var pricingOptions = document.getElementById("pricing_options");


        if (generalOptions) {
            var generalOptionsData = generalOptions.value;
            generalOptionsData = JSON.parse(generalOptionsData);

        }

        if (otherOptions) {
            var otherOptionsData = otherOptions.value;
            otherOptionsData = JSON.parse(otherOptionsData);


        }


        if (classifiedOptions) {
            var classifiedOptionsData = classifiedOptions.value;
            classifiedOptionsData = JSON.parse(classifiedOptionsData);

        }

        if (pricingOptions) {
            var pricingOptionsData = pricingOptions.value;
            pricingOptionsData = JSON.parse(pricingOptionsData);

        }
    }

    

    if (formTable.value == 'televisions') {
        var displayOptions = document.getElementById("display_options");
        var frontPampletsOptions = document.getElementById("ticker_options");
        var frontStickersOptions = document.getElementById("aston_options");
        var hoodOptions = document.getElementById("fct_options");
        var interiorOptions = document.getElementById("time_check_options");

        if (displayOptions.value) {
            var displayOptionsData = displayOptions.value;
            displayOptionsData = JSON.parse(displayOptionsData);

        }

        if (frontPampletsOptions.value) {
            var frontPampletsOptionsData = frontPampletsOptions.value;
            frontPampletsOptionsData = JSON.parse(frontPampletsOptionsData);


        }


        if (frontStickersOptions.value) {
            var frontStickersOptionsData = frontStickersOptions.value;
            frontStickersOptionsData = JSON.parse(frontStickersOptionsData);

        }

        if (hoodOptions.value) {
            var hoodOptionsData = hoodOptions.value;
            hoodOptionsData = JSON.parse(hoodOptionsData);

        }

        if (interiorOptions.value) {
            var interiorOptionsData = interiorOptions.value;
            interiorOptionsData = JSON.parse(interiorOptionsData);

        }
    }

}

var chkElm = '';

function addDomToPriceOptions(name, type) {

    var click = 1;
    var option_type = type;

    var chkExist = fieldData.indexOf(name);
    console.log(fieldData);
    if (chkExist == -1) {
        var model = document.getElementById("modelname").value;
        var labeltext = "Price for " + name + " " + model + " Ad Per unit:";
        var labelnumbertext = "Number of " + model + " for " + name + " Ad:";
        var labeldurationtext = "Ad Duration of " + model + " for " + name + " Ad (in Months):";
        var iname = name.toLowerCase();
        var res = iname.split(' ').join('_');
        var inputname = "price_" + res;
        var numberbuses = "number_" + res;
        var durationbuses = "duration_" + res;
        var priceElement = document.getElementById('pricing-options-step');

        var divrow = document.createElement('div');
        divrow.className = 'form-group';
        divrow.id = 'p' + inputname;

        var divrownum = document.createElement('div');
        divrownum.className = 'form-group';
        divrownum.id = 'p' + numberbuses;

        var divrowduration = document.createElement('div');
        divrowduration.className = 'form-group';
        divrowduration.id = 'p' + durationbuses;
        //iput field
        var labelhtm = document.createElement('label');
        labelhtm.setAttribute("for", inputname);
        labelhtm.innerText = labeltext;

        var inputhtm = document.createElement("input"); //input element, text
        inputhtm.setAttribute('type', "text");
        inputhtm.setAttribute('name', inputname);
        inputhtm.setAttribute('class', "form-control");
        inputhtm.setAttribute('id', inputname);
        inputhtm.setAttribute('required', 'required');
        inputhtm.setAttribute('placeholder', 'put value as number eg: 35345');

        //number of buses
        var labelnumhtm = document.createElement('label');
        labelnumhtm.setAttribute("for", numberbuses);
        labelnumhtm.innerText = labelnumbertext;

        var inputnumhtm = document.createElement("input"); //input element, text
        inputnumhtm.setAttribute('type', "text");
        inputnumhtm.setAttribute('name', numberbuses);
        inputnumhtm.setAttribute('class', "form-control");
        inputnumhtm.setAttribute('id', numberbuses);
        inputnumhtm.setAttribute('required', 'required');
        inputnumhtm.setAttribute('placeholder', 'put number of buses as number');

        //Duration of buses
        var labeldurationhtm = document.createElement('label');
        labeldurationhtm.setAttribute("for", durationbuses);
        labeldurationhtm.innerText = labeldurationtext;

        var inputdurationhtm = document.createElement("input"); //input element, text
        inputdurationhtm.setAttribute('type', "text");
        inputdurationhtm.setAttribute('name', durationbuses);
        inputdurationhtm.setAttribute('class', "form-control");
        inputdurationhtm.setAttribute('id', durationbuses);
        inputdurationhtm.setAttribute('required', 'required');
        inputdurationhtm.setAttribute('placeholder', 'put duration of ad for buses(in Months)');

        fieldData.push(name);
        if (fieldisi) {
            fieldisi.value = JSON.stringify(fieldData);
        }
        divrow.appendChild(labelhtm);
        divrow.appendChild(inputhtm);
        divrownum.appendChild(labelnumhtm);
        divrownum.appendChild(inputnumhtm);
        divrowduration.appendChild(labeldurationhtm);
        divrowduration.appendChild(inputdurationhtm);
        priceElement.appendChild(divrow);
        priceElement.appendChild(divrownum);
        priceElement.appendChild(divrowduration);
    } else {
        removeItem(name, option_type);
    }

}

function removeItem(name, option_type) {

    var iname = name.toLowerCase();
    var res = iname.split(' ').join('_');

    var inputname = "price_" + res;
    var numberbuses = "number_" + res;
    var durationbuses = "duration_" + res;
    var divId = 'p' + inputname;

    var divnumId = 'p' + numberbuses;

    var divdurId = 'p' + durationbuses;

    fieldData.splice(fieldData.indexOf(name), 1);
    if (fieldisi) {
        editfieldData.splice(editfieldData.indexOf(name), 1);

        var id = document.getElementById("uncheckID").value;
        var tableName = document.getElementById("tablename").value;
        var update_options = '';

        if (tableName == 'newspapers') {

            switch (option_type) {
                case 'general_options':
                    if (generalOptionsData) {
                        generalOptionsData.splice(generalOptionsData.indexOf(res), 1);
                        generalOptions.value = JSON.stringify(generalOptionsData);
                        update_options = generalOptionsData;
                    }
                    break;
                case 'other_options':
                    if (otherOptionsData) {
                        otherOptionsData.splice(otherOptionsData.indexOf(res), 1);
                        otherOptions.value = JSON.stringify(otherOptionsData);
                        update_options = otherOptionsData;
                    }
                    break;
                case 'classified_options':
                    if (classifiedOptionsData) {
                        classifiedOptionsData.splice(classifiedOptionsData.indexOf(res), 1);
                        classifiedOptions.value = JSON.stringify(classifiedOptionsData);
                        update_options = classifiedOptionsData;
                    }
                    break;
                case 'pricing_options':
                    if (pricingOptionsData) {
                        pricingOptionsData.splice(pricingOptionsData.indexOf(res), 1);
                        pricingOptions.value = JSON.stringify(pricingOptionsData);
                        update_options = pricingOptionsData;
                    }
                    break;

            }
            if (update_options !== '') {
                fieldisi.value = JSON.stringify(fieldData);
                $.ajax({
                        method: 'GET',
                        url: uncheckDeleteURL,
                        data: {
                            id: id,
                            option_type: option_type,
                            option_name: name,
                            price_key: inputname,
                            number_key: numberbuses,
                            duration_key: durationbuses,
                            table: tableName,
                            displayoptions: JSON.stringify(update_options)
                        }
                    })
                    .done(function(msg) {
                        console.log(msg);
                    });
            }
        } else if (tableName == 'autos') {

            switch (option_type) {
                case 'display_options':
                    if (displayOptionsData) {
                        displayOptionsData.splice(displayOptionsData.indexOf(res), 1);
                        displayOptions.value = JSON.stringify(displayOptionsData);
                        update_options = displayOptionsData;
                    }
                    break;
                case 'front_pamphlets_reactanguler_options':
                    if (frontPampletsOptionsData) {
                        frontPampletsOptionsData.splice(frontPampletsOptionsData.indexOf(res), 1);
                        frontPampletsOptions.value = JSON.stringify(frontPampletsOptionsData);
                        update_options = frontPampletsOptionsData;
                    }
                    break;
                case 'front_stickers_options':
                    if (frontStickersOptionsData) {
                        frontStickersOptionsData.splice(frontStickersOptionsData.indexOf(res), 1);
                        frontStickersOptions.value = JSON.stringify(frontStickersOptionsData);
                        update_options = frontStickersOptionsData;
                    }
                    break;
                case 'hood_options':
                    if (hoodOptionsData) {
                        hoodOptionsData.splice(hoodOptionsData.indexOf(res), 1);
                        hoodOptions.value = JSON.stringify(hoodOptionsData);
                        update_options = hoodOptionsData;
                    }
                    break;
                case 'interior_options':
                    if (interiorOptionsData) {
                        interiorOptionsData.splice(interiorOptionsData.indexOf(res), 1);
                        interiorOptions.value = JSON.stringify(interiorOptionsData);
                        update_options = interiorOptionsData;
                    }
                    break;

            }
            if (update_options !== '') {
                fieldisi.value = JSON.stringify(fieldData);
                $.ajax({
                        method: 'GET',
                        url: uncheckDeleteURL,
                        data: {
                            id: id,
                            option_type: option_type,
                            option_name: name,
                            price_key: inputname,
                            number_key: numberbuses,
                            duration_key: durationbuses,
                            table: tableName,
                            displayoptions: JSON.stringify(update_options)
                        }
                    })
                    .done(function(msg) {
                        console.log(msg);
                    });
            }

        } else if (tableName == 'televisions') {

            switch (genre) {
                case 'display_options':
                    if (displayOptionsData) {
                        displayOptionsData.splice(displayOptionsData.indexOf(res), 1);
                        displayOptions.value = JSON.stringify(displayOptionsData);
                        update_options = displayOptionsData;
                    }
                    break;
                case 'ticker_options':
                    if (frontPampletsOptionsData) {
                        frontPampletsOptionsData.splice(frontPampletsOptionsData.indexOf(res), 1);
                        frontPampletsOptions.value = JSON.stringify(frontPampletsOptionsData);
                        update_options = frontPampletsOptionsData;
                    }
                    break;
                case 'aston_options':
                    if (frontStickersOptionsData) {
                        frontStickersOptionsData.splice(frontStickersOptionsData.indexOf(res), 1);
                        frontStickersOptions.value = JSON.stringify(frontStickersOptionsData);
                        update_options = frontStickersOptionsData;
                    }
                    break;
                case 'fct_options':
                    if (hoodOptionsData) {
                        hoodOptionsData.splice(hoodOptionsData.indexOf(res), 1);
                        hoodOptions.value = JSON.stringify(hoodOptionsData);
                        update_options = hoodOptionsData;
                    }
                    break;
                case 'time_check_options':
                    if (interiorOptionsData) {
                        interiorOptionsData.splice(interiorOptionsData.indexOf(res), 1);
                        interiorOptions.value = JSON.stringify(interiorOptionsData);
                        update_options = interiorOptionsData;
                    }
                    break;

            }
            if (update_options !== '') {
                fieldisi.value = JSON.stringify(fieldData);
                $.ajax({
                        method: 'GET',
                        url: uncheckDeleteURL,
                        data: {
                            id: id,
                            genre: genre,
                            option_name: name,
                            rate_key: inputname,
                            time_band_key: numberbuses,
                            exposure_key: durationbuses,
                            table: tableName,
                            displayoptions: JSON.stringify(update_options)
                        }
                    })
                    .done(function(msg) {
                        console.log(msg);
                    });
            }

        } else {
            fieldisi.value = JSON.stringify(fieldData);
            $.ajax({
                    method: 'GET',
                    url: uncheckDeleteURL,
                    data: {
                        id: id,
                        price_key: inputname,
                        number_key: numberbuses,
                        duration_key: durationbuses,
                        displayoptions: JSON.stringify(fieldData)
                    }
                })
                .done(function(msg) {
                    console.log(msg);
                });
        }



    }

    var deleteNode = document.getElementById(divId);
    deleteNode.remove();
    var deletenumNode = document.getElementById(divnumId);
    deletenumNode.remove();
    var deletedurNode = document.getElementById(divdurId);
    deletedurNode.remove();

}


function addDomToPriceOptionsWithLight(value) {

    if (value == 'Yes') {
        $("#light-content").show();
    } else if (value == 'No') {
        $("#light-content").hide();
    }
}

$('ul.nav li.dropdown').hover(function() {
    $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(500);
}, function() {
    $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(500);
});



// order page JS
let showStatusOptions = function showStatusOptions(dividi, orderID) {
    $('.selectform' + dividi).toggle();
    let self = $(this);
    $('.selectform' + dividi).on('change', function() {
        $(".editstatus" + dividi).hide();
        let changeStatus = this.value;
        let columnName = '';
        if (dividi == 1) {
            columnName = 'order_status';
        }
        if (dividi == 2) {
            columnName = 'payment_status';
        }
        $.ajax({
                method: 'GET',
                url: OrderStatusURL,
                data: {
                    id: orderID,
                    columnName: columnName,
                    status: changeStatus
                }
            })
            .done(function(msg) {
                let outPut = changeStatus + '<i class="fa fa-pencil edit" onclick="showStatusOptions(' + dividi + ', ' + orderID + ')" aria-hidden="true"></i>';
                $('.selectform' + dividi).hide();
                $(".editstatus" + dividi).html(outPut);
                $(".editstatus" + dividi).show();

            });
    });
}

// js for cinema

function addDomToPriceOptionsCinema(name, type) {
    var click = 1;
    var option_type = type;

    var chkExist = fieldData.indexOf(name);

    if (chkExist == -1) {
        var model = document.getElementById("modelname").value;
        var labeltext = "Price for " + model + "'s " + name + " :";
        var labelnumbertext = "Number of " + model + " for " + name + " :";
        var labeldurationtext = "Ad duration/period of " + model + " for " + name + "  (in Sec):";
        var iname = name.toLowerCase();
        var res = iname.split(' ').join('_');
        var inputname = "price_" + res;
        var duration = "duration_" + res;
        var priceElement = document.getElementById('pricing-options-step');

        var divrow = document.createElement('div');
        divrow.className = 'form-group';
        divrow.id = 'p' + inputname;


        var divrowduration = document.createElement('div');
        divrowduration.className = 'form-group';
        divrowduration.id = 'p' + duration;
        //iput field
        var labelhtm = document.createElement('label');
        labelhtm.setAttribute("for", inputname);
        labelhtm.innerText = labeltext;

        var inputhtm = document.createElement("input"); //input element, text
        inputhtm.setAttribute('type', "text");
        inputhtm.setAttribute('name', inputname);
        inputhtm.setAttribute('class', "form-control");
        inputhtm.setAttribute('id', inputname);
        inputhtm.setAttribute('required', 'required');
        inputhtm.setAttribute('placeholder', 'put price value as number eg: 35345');


        
        var labeldurationhtm = document.createElement('label');
        labeldurationhtm.setAttribute("for", duration);
        labeldurationhtm.innerText = labeldurationtext;

        var inputdurationhtm = document.createElement("input"); //input element, text
        inputdurationhtm.setAttribute('type', "text");
        inputdurationhtm.setAttribute('name', duration);
        inputdurationhtm.setAttribute('class', "form-control");
        inputdurationhtm.setAttribute('id', duration);
        inputdurationhtm.setAttribute('required', 'required');
        inputdurationhtm.setAttribute('placeholder', 'put duration of ad for Cinema(in Sec)');

        fieldData.push(name);
        if (fieldisi) {
            fieldisi.value = JSON.stringify(fieldData);
        }
        divrow.appendChild(labelhtm);
        divrow.appendChild(inputhtm);

        divrowduration.appendChild(labeldurationhtm);
        divrowduration.appendChild(inputdurationhtm);
        priceElement.appendChild(divrow);

        priceElement.appendChild(divrowduration);
    } else {
        removeItemCinema(name, option_type);
    }
}

function removeItemCinema(name, option_type) {

    var iname = name.toLowerCase();
    var res = iname.split(' ').join('_');

    var inputname = "price_" + res;

    var duration = "duration_" + res;
    var divId = 'p' + inputname;

    var divdurId = 'p' + duration;

    fieldData.splice(fieldData.indexOf(name), 1);
    if (fieldisi) {
        editfieldData.splice(editfieldData.indexOf(name), 1);
        

        var id = document.getElementById("uncheckID").value;
        var tableName = document.getElementById("tablename").value;
        var update_options = '';
        switch (option_type) {
            case 'display_options':
                if (generalOptionsData) {
                    generalOptionsData.splice(generalOptionsData.indexOf(name), 1);
                    generalOptions.value = JSON.stringify(generalOptionsData);
                    update_options = generalOptionsData;
                }
                break;
            case 'additional_adsoption':
                if (otherOptionsData) {
                    otherOptionsData.splice(otherOptionsData.indexOf(name), 1);
                    otherOptions.value = JSON.stringify(otherOptionsData);
                    update_options = otherOptionsData;
                }
                break;
        }
        fieldisi.value = JSON.stringify(fieldData);
        $.ajax({
                method: 'GET',
                url: uncheckDeleteURL,
                data: {
                    id: id,
                    price_key: inputname,
                    duration_key: duration,
                    option: option_type,
                    displayoptions: JSON.stringify(update_options)
                }
            })
            .done(function(msg) {
                console.log(msg);
            });
    }

    var deleteNode = document.getElementById(divId);
    deleteNode.remove();

    var deletedurNode = document.getElementById(divdurId);
    deletedurNode.remove();

}



function addDomToPriceOptionsAuto(name, type) {
    var option_type = type;
    var chkExist = fieldData.indexOf(name);
    console.log(fieldData);
    if (chkExist == -1) {
        var model = document.getElementById("modelname").value;
        var labeltext = "Price for " + name + " " + model + " Ad Per unit:";
        var labelnumbertext = "Number of " + model + " for " + name + " Ad:";
        var labeldurationtext = "Ad Duration of " + model + " for " + name + " Ad (in Months):";
        var iname = name.toLowerCase();
        var res = iname.split(' ').join('_');
        var inputname = "price_" + res;
        var numberbuses = "number_" + res;
        var durationbuses = "duration_" + res;
        var priceElement = document.getElementById('pricing-options-step');

        var divrow = document.createElement('div');
        divrow.className = 'form-group';
        divrow.id = 'p' + inputname;

        var divrownum = document.createElement('div');
        divrownum.className = 'form-group';
        divrownum.id = 'p' + numberbuses;

        var divrowduration = document.createElement('div');
        divrowduration.className = 'form-group';
        divrowduration.id = 'p' + durationbuses;
        //iput field
        var labelhtm = document.createElement('label');
        labelhtm.setAttribute("for", inputname);
        labelhtm.innerText = labeltext;

        var inputhtm = document.createElement("input"); //input element, text
        inputhtm.setAttribute('type', "text");
        inputhtm.setAttribute('name', inputname);
        inputhtm.setAttribute('class', "form-control");
        inputhtm.setAttribute('id', inputname);
        inputhtm.setAttribute('required', 'required');
        inputhtm.setAttribute('placeholder', 'put value as number eg: 35345');

        //number of buses
        var labelnumhtm = document.createElement('label');
        labelnumhtm.setAttribute("for", numberbuses);
        labelnumhtm.innerText = labelnumbertext;

        var inputnumhtm = document.createElement("input"); //input element, text
        inputnumhtm.setAttribute('type', "text");
        inputnumhtm.setAttribute('name', numberbuses);
        inputnumhtm.setAttribute('class', "form-control");
        inputnumhtm.setAttribute('id', numberbuses);
        inputnumhtm.setAttribute('required', 'required');
        inputnumhtm.setAttribute('placeholder', 'put number of buses as number');

        //Duration of buses
        var labeldurationhtm = document.createElement('label');
        labeldurationhtm.setAttribute("for", durationbuses);
        labeldurationhtm.innerText = labeldurationtext;

        var inputdurationhtm = document.createElement("input"); //input element, text
        inputdurationhtm.setAttribute('type', "text");
        inputdurationhtm.setAttribute('name', durationbuses);
        inputdurationhtm.setAttribute('class', "form-control");
        inputdurationhtm.setAttribute('id', durationbuses);
        inputdurationhtm.setAttribute('required', 'required');
        inputdurationhtm.setAttribute('placeholder', 'put duration of ad for buses(in Months)');

        fieldData.push(name);
        if (fieldisi) {
            fieldisi.value = JSON.stringify(fieldData);
        }
        divrow.appendChild(labelhtm);
        divrow.appendChild(inputhtm);
        divrownum.appendChild(labelnumhtm);
        divrownum.appendChild(inputnumhtm);
        divrowduration.appendChild(labeldurationhtm);
        divrowduration.appendChild(inputdurationhtm);
        priceElement.appendChild(divrow);
        priceElement.appendChild(divrownum);
        priceElement.appendChild(divrowduration);
    } else {
        removeItemAuto(name, option_type);
    }

}

function removeItemAuto(name, option_type) {

    var iname = name.toLowerCase();
    var res = iname.split(' ').join('_');

    var inputname = "price_" + res;
    var numberbuses = "number_" + res;
    var durationbuses = "duration_" + res;
    var divId = 'p' + inputname;

    var divnumId = 'p' + numberbuses;

    var divdurId = 'p' + durationbuses;

    fieldData.splice(fieldData.indexOf(name), 1);
    if (fieldisi) {
        editfieldData.splice(editfieldData.indexOf(name), 1);

        var id = document.getElementById("uncheckID").value;
        var tableName = document.getElementById("tablename").value;
        var update_options = '';


        fieldisi.value = JSON.stringify(fieldData);
        $.ajax({
                method: 'GET',
                url: uncheckDeleteURL,
                data: {
                    id: id,
                    price_key: inputname,
                    option_type: option_type,
                    number_key: numberbuses,
                    duration_key: durationbuses,
                    displayoptions: JSON.stringify(fieldData)
                }
            })
            .done(function(msg) {
                console.log(msg);
            });
    }

    var deleteNode = document.getElementById(divId);
    deleteNode.remove();
    var deletenumNode = document.getElementById(divnumId);
    deletenumNode.remove();
    var deletedurNode = document.getElementById(divdurId);
    deletedurNode.remove();

}

// js for television

function addDomToPriceOptionsTelevision(name, type) {
    var genre = type;
    var chkExist = fieldData.indexOf(name);
    console.log(fieldData);
    if (chkExist == -1) {
        var model = document.getElementById("modelname").value;
        var labeltext = "Rate for " + name + " Ad Per unit:";
        var labelnumbertext = "Time band of " + name + " Ad:";
        var labeldurationtext = "Exposure for " + name + " Ad (in Days):";
        var iname = name.toLowerCase();
        var res = iname.split(' ').join('_');
        var inputname = "rate_" + res;
        var numberbuses = "time_band_" + res;
        var durationbuses = "exposure_" + res;
        var priceElement = document.getElementById('pricing-options-step');

        var divrow = document.createElement('div');
        divrow.className = 'form-group';
        divrow.id = 'p' + inputname;

        var divrownum = document.createElement('div');
        divrownum.className = 'form-group';
        divrownum.id = 'p' + numberbuses;

        var divrowduration = document.createElement('div');
        divrowduration.className = 'form-group';
        divrowduration.id = 'p' + durationbuses;
        //iput field
        var labelhtm = document.createElement('label');
        labelhtm.setAttribute("for", inputname);
        labelhtm.innerText = labeltext;

        var inputhtm = document.createElement("input"); //input element, text
        inputhtm.setAttribute('type', "text");
        inputhtm.setAttribute('name', inputname);
        inputhtm.setAttribute('class', "form-control");
        inputhtm.setAttribute('id', inputname);
        inputhtm.setAttribute('required', 'required');
        inputhtm.setAttribute('placeholder', 'put value as number eg: 35345');

        //number of buses
        var labelnumhtm = document.createElement('label');
        labelnumhtm.setAttribute("for", numberbuses);
        labelnumhtm.innerText = labelnumbertext;

        var inputnumhtm = document.createElement("input"); //input element, text
        inputnumhtm.setAttribute('type', "text");
        inputnumhtm.setAttribute('name', numberbuses);
        inputnumhtm.setAttribute('class', "form-control");
        inputnumhtm.setAttribute('id', numberbuses);
        inputnumhtm.setAttribute('required', 'required');
        inputnumhtm.setAttribute('placeholder', 'put number of buses as number');

        //Duration of buses
        var labeldurationhtm = document.createElement('label');
        labeldurationhtm.setAttribute("for", durationbuses);
        labeldurationhtm.innerText = labeldurationtext;

        var inputdurationhtm = document.createElement("input"); //input element, text
        inputdurationhtm.setAttribute('type', "text");
        inputdurationhtm.setAttribute('name', durationbuses);
        inputdurationhtm.setAttribute('class', "form-control");
        inputdurationhtm.setAttribute('id', durationbuses);
        inputdurationhtm.setAttribute('required', 'required');
        inputdurationhtm.setAttribute('placeholder', 'put duration of ad for buses(in Days)');

        fieldData.push(name);
        if (fieldisi) {
            fieldisi.value = JSON.stringify(fieldData);
        }
        divrow.appendChild(labelhtm);
        divrow.appendChild(inputhtm);
        divrownum.appendChild(labelnumhtm);
        divrownum.appendChild(inputnumhtm);
        divrowduration.appendChild(labeldurationhtm);
        divrowduration.appendChild(inputdurationhtm);
        priceElement.appendChild(divrow);
        priceElement.appendChild(divrownum);
        priceElement.appendChild(divrowduration);
    } else {
        removeItemTelevision(name, genre);
    }

}

function removeItemTelevision(name, genre) {

    var iname = name.toLowerCase();
    var res = iname.split(' ').join('_');

    var numberbuses = "time_band_" + res;
    var inputname = "rate_" + res;
    var durationbuses = "exposure_" + res;
    var divId = 'p' + inputname;

    var divnumId = 'p' + numberbuses;

    var divdurId = 'p' + durationbuses;

    fieldData.splice(fieldData.indexOf(name), 1);
    if (fieldisi) {
        editfieldData.splice(editfieldData.indexOf(name), 1);

        var id = document.getElementById("uncheckID").value;
        var tableName = document.getElementById("tablename").value;
        var update_options = '';


        fieldisi.value = JSON.stringify(fieldData);
        $.ajax({
                method: 'GET',
                url: uncheckDeleteURL,
                data: {
                    id: id,
                    rate_key: inputname,
                    genre: genre,
                    time_band_key: numberbuses,
                    exposure_key: durationbuses,
                    displayoptions: JSON.stringify(fieldData)
                }
            })
            .done(function(msg) {
                console.log(msg);
            });
    }

    var deleteNode = document.getElementById(divId);
    deleteNode.remove();
    var deletenumNode = document.getElementById(divnumId);
    deletenumNode.remove();
    var deletedurNode = document.getElementById(divdurId);
    deletedurNode.remove();

}

function addDomToPriceOptionsMegazine(name, printmedia_type){
    //var genre = printmedia_type;
    var chkExist = fieldData.indexOf(name);
   
    if (chkExist == -1) {
        var labeltext = "Price for " + name + " Megazine Ad Per unit:";
        var labelnumbertext = "Number of Times Megazine print "+ name + " Ad(in 1 month):";
        
        var iname = name.toLowerCase();
        var res = iname.split(' ').join('_');
        var inputname = "price_" + res;
        var megazineduration = "number_" + res;
       
        var priceElement = document.getElementById('pricing-options-step');

        var divrow = document.createElement('div');
        divrow.className = 'form-group';
        divrow.id = 'p' + inputname;

        var divrownum = document.createElement('div');
        divrownum.className = 'form-group';
        divrownum.id = 'p' + megazineduration;

        
        //iput field
        var labelhtm = document.createElement('label');
        labelhtm.setAttribute("for", inputname);
        labelhtm.innerText = labeltext;

        var inputhtm = document.createElement("input"); //input element, text
        inputhtm.setAttribute('type', "text");
        inputhtm.setAttribute('name', inputname);
        inputhtm.setAttribute('class', "form-control");
        inputhtm.setAttribute('id', inputname);
        inputhtm.setAttribute('required', 'required');
        inputhtm.setAttribute('placeholder', 'put value as number eg: 35345');

        //number of buses
        var labelnumhtm = document.createElement('label');
        labelnumhtm.setAttribute("for", megazineduration);
        labelnumhtm.innerText = labelnumbertext;

        var inputnumhtm = document.createElement("input"); //input element, text
        inputnumhtm.setAttribute('type', "text");
        inputnumhtm.setAttribute('name', megazineduration);
        inputnumhtm.setAttribute('class', "form-control");
        inputnumhtm.setAttribute('id', megazineduration);
        inputnumhtm.setAttribute('required', 'required');
        inputnumhtm.setAttribute('placeholder', 'How many times this megazine print in a month eg: 1');

        //Duration of buses
      
        fieldData.push(name);
        if (fieldisi) {
            fieldisi.value = JSON.stringify(fieldData);
        }
        divrow.appendChild(labelhtm);
        divrow.appendChild(inputhtm);
        divrownum.appendChild(labelnumhtm);
        divrownum.appendChild(inputnumhtm);
        
        priceElement.appendChild(divrow);
        priceElement.appendChild(divrownum);
        
    } else {
        removeItemMegazine(name, printmedia_type);
    }
}

function removeItemMegazine(name, genre) {

    var iname = name.toLowerCase();
    var res = iname.split(' ').join('_');

    var numberTimeMagezinePrints = "number_" + res;
    var inputname = "price_" + res;
    
    var divId = 'p' + inputname;
    var divnumId = 'p' + numberTimeMagezinePrints;

    fieldData.splice(fieldData.indexOf(name), 1);
    if (fieldisi) {
        editfieldData.splice(editfieldData.indexOf(name), 1);
        var id = document.getElementById("uncheckID").value;
        var tableName = document.getElementById("tablename").value;
        var update_options = '';
        fieldisi.value = JSON.stringify(fieldData);
        $.ajax({
                method: 'GET',
                url: uncheckDeleteURL,
                data: {
                    id: id,
                    price_key: inputname,
                    printmedia_type: genre,
                    number_key: numberTimeMagezinePrints,
                    //exposure_key: durationbuses,
                    displayoptions: JSON.stringify(fieldData)
                }
            })
            .done(function(msg) {
                console.log(msg);
            });
    }

    var deleteNode = document.getElementById(divId);
    deleteNode.remove();
    var deletenumNode = document.getElementById(divnumId);
    deletenumNode.remove();    
}

function addDomToPriceOptionsNewspaper(name, printmedia_type){
    //var genre = printmedia_type;
    var chkExist = fieldData.indexOf(name);
   
    if (chkExist == -1) {
        var labelbasepricetext = "Base Price for " + name + " Newspaper Ad:";
        var labeladdonpricetext = "Add-on Price for " + name + " Newspaper Ad:";
        var labelTotalPricetext = "Total Price for " + name + " Newspaper Ad:";
        var labelclassifiedType = "Select Ad Genre: ";
        var labelRateType = "Select printing Options: ";
        var labelColorType = "Select Color Ad Or not:";
        
        var iname = name.toLowerCase();
        var res = iname.split(' ').join('_');
        var inputbasepricename = "base_price_" + res;
        var inputaddonpricename = "add_on_price_" + res;
        var inputTotalPricename = "total_price_" + res;
        var newspaperGenreName = "genre_" + res;
        var newspaperRateName = "rate_" + res;
        var newspaperColorName = "color_" + res;
       
        var priceElement = document.getElementById('pricing-options-step');

        var divrowbasePrice = document.createElement('div');
        divrowbasePrice.className = 'form-group';
        divrowbasePrice.id = 'p' + inputbasepricename;

        var divrowAddonPrice = document.createElement('div');
        divrowAddonPrice.className = 'form-group';
        divrowAddonPrice.id = 'p' + inputaddonpricename;

        var divrowTotalPrice = document.createElement('div');
        divrowTotalPrice.className = 'form-group';
        divrowTotalPrice.id = 'p' + inputTotalPricename;

        var divrowGenre = document.createElement('div');
        divrowGenre.className = 'form-group';
        divrowGenre.id = 'p' + newspaperGenreName;

        var divrowRate = document.createElement('div');
        divrowRate.className = 'form-group';
        divrowRate.id = 'p' + newspaperRateName;

        var divrowColor = document.createElement('div');
        divrowColor.className = 'form-group';
        divrowColor.id = 'p' + newspaperColorName;

        
        //base price field
        var labelbaseprice = document.createElement('label');
        labelbaseprice.setAttribute("for", inputbasepricename);
        labelbaseprice.innerText = labelbasepricetext;

        var inputbaseprice = document.createElement("input"); //input element, text
        inputbaseprice.setAttribute('type', "text");
        inputbaseprice.setAttribute('name', inputbasepricename);
        inputbaseprice.setAttribute('class', "form-control");
        inputbaseprice.setAttribute('id', inputbasepricename);
        inputbaseprice.setAttribute('required', 'required');
        inputbaseprice.setAttribute('placeholder', 'base price eg: 35345');

        //add on  price
        var labeladdonprice = document.createElement('label');
        labeladdonprice.setAttribute("for", inputaddonpricename);
        labeladdonprice.innerText = labeladdonpricetext;

        var inputaddonprice = document.createElement("input"); //input element, text
        inputaddonprice.setAttribute('type', "text");
        inputaddonprice.setAttribute('name', inputaddonpricename);
        inputaddonprice.setAttribute('class', "form-control");
        inputaddonprice.setAttribute('id', inputaddonpricename);
        inputaddonprice.setAttribute('required', 'required');
        inputaddonprice.setAttribute('placeholder', 'Add on eg: 35345');

        //total price
        var labelTotalPrice = document.createElement('label');
        labelTotalPrice.setAttribute("for", inputTotalPricename);
        labelTotalPrice.innerText = labelTotalPricetext;

        var inputTotalPrice = document.createElement("input"); //input element, text
        inputTotalPrice.setAttribute('type', "text");
        inputTotalPrice.setAttribute('name', inputTotalPricename);
        inputTotalPrice.setAttribute('class', "form-control");
        inputTotalPrice.setAttribute('id', inputTotalPricename);
        inputTotalPrice.setAttribute('required', 'required');
        inputTotalPrice.setAttribute('placeholder', 'total price eg: 35345');

        // classified type
        var classfiedType = {'matrimonial':'Matrimonial', 'recruitment':'Recruitment','business':'Business','property' : 'Property','education':'Education','astrology':'Astrology','public_notices':'Public Notices','services':'Services','automobile':'Automobile','shopping':'Shopping', 'appointment':'Appointment', 'computers':'Computers', 'personal':'Personal', 'travel':'Travel', 'package':'Package'};

        var labelGenre = document.createElement('label');
        labelGenre.setAttribute("for", newspaperGenreName);
        labelGenre.innerText = labelclassifiedType;

        var selectGenre = document.createElement("select"); //input element, text
        selectGenre.setAttribute('name', newspaperGenreName);
        selectGenre.setAttribute('class', "form-control");
        selectGenre.setAttribute('id', newspaperGenreName);
        selectGenre.setAttribute('required', 'required');

        for (var key in classfiedType) {
            var option = document.createElement("option");
            option.value = key;
            option.text = classfiedType[key];
            selectGenre.appendChild(option);
	    }

        // rate type
        var insertType = {"sq cm":"sq cm", "column":"column", "insert":"insert", "day":"day"};
        var labelRate = document.createElement('label');
        labelRate.setAttribute("for", newspaperRateName);
        labelRate.innerText = labelRateType;

        var selectRate = document.createElement("select"); //input element, text
        selectRate.setAttribute('name', newspaperRateName);
        selectRate.setAttribute('class', "form-control");
        selectRate.setAttribute('id', newspaperRateName);
        selectRate.setAttribute('required', 'required');

        for (var key in insertType) {
            var option = document.createElement("option");
            option.value = key;
            option.text = insertType[key];
            selectRate.appendChild(option);
	    }

        // Color type
        var colorType = {"yes":"YES", "no":"NO"};
        var labelColor = document.createElement('label');
        labelColor.setAttribute("for", newspaperColorName);
        labelColor.innerText = labelColorType;

        var selectColor = document.createElement("select"); //input element, text
        selectColor.setAttribute('name', newspaperColorName);
        selectColor.setAttribute('class', "form-control");
        selectColor.setAttribute('id', newspaperColorName);
        selectColor.setAttribute('required', 'required');

        for (var key in colorType) {
            var option = document.createElement("option");
            option.value = key;
            option.text = colorType[key];
            selectColor.appendChild(option);
	    }
        


        fieldData.push(name);
        if (fieldisi) {
            fieldisi.value = JSON.stringify(fieldData);
        }
        divrowbasePrice.appendChild(labelbaseprice);
        divrowbasePrice.appendChild(inputbaseprice);
        divrowAddonPrice.appendChild(labeladdonprice);
        divrowAddonPrice.appendChild(inputaddonprice);
        divrowTotalPrice.appendChild(labelTotalPrice);
        divrowTotalPrice.appendChild(inputTotalPrice);
        divrowGenre.appendChild(labelGenre);
        divrowGenre.appendChild(selectGenre);
        divrowRate.appendChild(labelRate);
        divrowRate.appendChild(selectRate);
        divrowColor.appendChild(labelColor);
        divrowColor.appendChild(selectColor);
        
        priceElement.appendChild(divrowbasePrice);
        priceElement.appendChild(divrowAddonPrice);
        priceElement.appendChild(divrowTotalPrice);
        priceElement.appendChild(divrowGenre);
        priceElement.appendChild(divrowRate);
        priceElement.appendChild(divrowColor);
        
    } else {
        removeItemNewspaper(name, printmedia_type);
    }
}

function removeItemNewspaper(name, genre) {

    var iname = name.toLowerCase();
    var res = iname.split(' ').join('_');

    var inputbasepricename = "base_price_" + res;
    var inputaddonpricename = "add_on_price_" + res;
    var inputTotalPricename = "total_price_" + res;
    var newspaperGenreName = "genre_" + res;
    var newspaperRateName = "rate_" + res;
    var newspaperColorName = "color_" + res;

    var divbaseprice = 'p' + inputbasepricename;
    var divaddonprice = 'p' + inputaddonpricename;
    var divTotalPrice = 'p' + inputTotalPricename;
    var divGenre = 'p' + newspaperGenreName;
    var divRate = 'p' + newspaperRateName;
    var divColor = 'p' + newspaperColorName;

    fieldData.splice(fieldData.indexOf(name), 1);
    if (fieldisi) {
        editfieldData.splice(editfieldData.indexOf(name), 1);
        var id = document.getElementById("uncheckID").value;
        var tableName = document.getElementById("tablename").value;
        var update_options = '';
        fieldisi.value = JSON.stringify(fieldData);
        $.ajax({
                method: 'GET',
                url: uncheckDeleteURL,
                data: {
                    id: id,
                    price_key: inputname,
                    printmedia_type: genre,
                    number_key: numberTimeMagezinePrints,
                    //exposure_key: durationbuses,
                    displayoptions: JSON.stringify(fieldData)
                }
            })
            .done(function(msg) {
                console.log(msg);
            });
    }

    var deletebaseprice = document.getElementById(divbaseprice);
    deletebaseprice.remove();
    var deleteaddonprice = document.getElementById(divaddonprice);
    deleteaddonprice.remove();
    var deleteTotalPrice = document.getElementById(divTotalPrice);
    deleteTotalPrice.remove();
    var deleteGenre = document.getElementById(divGenre);
    deleteGenre.remove();
    var deleteRate = document.getElementById(divRate);
    deleteRate.remove();
    var deleteColor = document.getElementById(divColor);
    deleteColor.remove();    
}

/* 
    Airports settings

*/
function deleteairportOption(varid, index){
    
    var id = Number(varid);

    $.ajax({
      url: airportFieldRemoveURL,
      type: 'GET',
      data: {deleteID: id},
      success: function(response){
        $('#room_fileds'+index).remove();
      },
      error: function(error){
        console.log(error);
      }

    });
}



var removeLinkMain = '<a class="btn btn-danger remove" href="#" onclick="$(this).parent().slideUp(function(){ $(this).remove() }); return false">Remove Main Field -</a><hr/>';

var removeLinkSubField = '<a class="btn btn-danger remove" href="#" onclick="$(this).parent().slideUp(function(){ $(this).remove() }); return false">Remove Sub Field -</a><hr/>';

$('.copy').relCopyMain({ append: removeLinkMain});

//$('.sub-copy').relCopySubFields({ append: removeLinkSubField});