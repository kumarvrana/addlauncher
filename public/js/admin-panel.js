
$(function(){
	$("#light-content").hide();
	var category_id = 0;
	var descriptionTD;
	$('.edit-category').on('click', function(event){

		event.preventDefault();

		var title = $(this).parent().parent().parent().find('td:eq(1)').text();
		descriptionTD = $(this).parent().parent().parent().find('td:eq(2)');
		var description = descriptionTD.text();
		var image = $(this).parent().parent().parent().find('td:eq(3)').find('img').attr('src');
		category_id = $(this).parent().parent().parent().find('#category-id').val();//alert(title+"  "+description+"  "+image);
		//alert(category_id);
		$('#title').val(title);
		$('#description').val(description);
		$('#update-category-image').attr('src', image);
		$('#edit-ad-category').modal();
	});

	$('#update-cat-modal').on('click', function(){
		
		var token = $("input[name=_token]").val();
		
		$.ajax({
			method: 'POST',
			url: updateCatUrl,
			data: {description: tinyMCE.get('description'), catID: category_id, _token: token}
		})
		.done(function (msg){
			console.log(JSON.stringify(msg));
			descriptionTD.text(msg['description']);
			$('#edit-ad-category').modal('hide');

		});
	});
	// kjkk

});
 function htmlbodyHeightUpdate(){
		var height3 = $( window ).height()
		var height1 = $('.nav').height()+50
		height2 = $('.main').height()
		if(height2 > height3){
			$('html').height(Math.max(height1,height3,height2)+10);
			$('body').height(Math.max(height1,height3,height2)+10);
		}
		else
		{
			$('html').height(Math.max(height1,height3,height2));
			$('body').height(Math.max(height1,height3,height2));
		}
		
	}
	$(document).ready(function () {
		htmlbodyHeightUpdate()
		$( window ).resize(function() {
			htmlbodyHeightUpdate()
		});
		$( window ).scroll(function() {
			height2 = $('.main').height()
  			htmlbodyHeightUpdate()
		});
	});
$(function () {
    setNavigation();
});

function setNavigation() {
    var path = window.location.pathname;
    path = path.replace(/\/$/, "");
    path = decodeURIComponent(path);
	path = "http://myshop.dev"+path;
    $(".sidebar-nav a").each(function () {
        var href = $(this).attr('href');
		
        if (path.substring(0, href.length) === href) {
			
            $(this).closest('li').addClass('active');
        }
    });
}

var msg = '';
$(function(){
	$('#mediatype').on('change', function(){
		var mediaCat = $(this).find(':selected').data('name');
			if (typeof mediaCat === "undefined") {
				msg = "Select Category";
				return msg; 
			}else{
				$.ajax({
					method: 'GET',
					url: CathtmlUrl,
					data: {mediaCat: mediaCat}
				})
				.done(function (msg){
					$('.results').html(msg['response']);
				});
			}
	});

	//Start Auto options code

	var fieldisieditpage = document.getElementById("priceData");
	$('.e_rickshawOtions, .autorikshawOtions').hide();
	if(fieldisieditpage){
		var selectedAutotypeEdit = $('#autotype').find(':selected').attr('value');
		if(selectedAutotypeEdit == 'auto_rikshaw'){
				$('.autorikshawOtions').addClass('selected');
				$('.autorikshawOtions').show();
			}
			if(selectedAutotypeEdit == 'e_rikshaw'){
				$('.e_rickshawOtions').addClass('selected');
				$('.e_rickshawOtions').show();
			}	
	}
	
	$('#autotype').on('change', function(){
		$('.selected').hide();
		$('.selected').removeClass('selected');
		var selectedAutotype = $(this).find(':selected').attr('value');
		if (typeof selectedAutotype === "undefined") {
				msg = "Select Auto Type";
				return msg; 
		}else{
			if(selectedAutotype == 'auto_rikshaw'){
				$('.autorikshawOtions').addClass('selected');
				$('.autorikshawOtions').show();
			}
			if(selectedAutotype == 'e_rikshaw'){
				$('.e_rickshawOtions').addClass('selected');
				$('.e_rickshawOtions').show();
			}	
		}
	});
	//End Auto options code
});

	// making category slug
	var Slug = '';
	function makeSlug(){
		
		var title_val = document.getElementById("category-name");
		var Slug = title_val.value.replace(/([~!@#$%^&*()_+=`{}\[\]\|\\:;'<>,.\/? ])+/g, '-').replace(/^(-)+|(-)+$/g,'');
		Slug = Slug.toLowerCase();
		Slug = 'media/'+Slug;
		document.getElementById('category-slug').value = Slug;
	}
	
	$("#category-name").focusout(function() {
		var title_val = document.getElementById("category-name");
		var Slug = title_val.value.replace(/([~!@#$%^&*()_+=`{}\[\]\|\\:;'<>,.\/? ])+/g, '-').replace(/^(-)+|(-)+$/g,'');
		Slug = Slug.toLowerCase();
		Slug = 'media/'+Slug;
		document.getElementById('category-slug').value = Slug;
	});
	//ends

	
	fieldData = [];
	var fieldisi = document.getElementById("priceData");
	if(fieldisi){
		var editfieldData = fieldisi.value;
		editfieldData = JSON.parse(editfieldData);
		fieldData = fieldData.concat(editfieldData);

		var formTable = document.getElementById("tablename");

		if(formTable.value == 'newspapers'){
			var generalOptions = document.getElementById("general_options");
			var otherOptions = document.getElementById("other_options");
			var classifiedOptions = document.getElementById("classified_options");
			var pricingOptions = document.getElementById("pricing_options");


			if(generalOptions){
				var generalOptionsData = generalOptions.value;
				generalOptionsData = JSON.parse(generalOptionsData);
				
			}
			
			if(otherOptions){
				var otherOptionsData = otherOptions.value;
				otherOptionsData = JSON.parse(otherOptionsData);
				
					
			}
			

			if(classifiedOptions){
				var classifiedOptionsData = classifiedOptions.value;
				classifiedOptionsData = JSON.parse(classifiedOptionsData);
				
			}
			
			if(pricingOptions){
				var pricingOptionsData = pricingOptions.value;
				pricingOptionsData = JSON.parse(pricingOptionsData);
				
			}
		}

		if(formTable.value == 'autos'){
			var displayOptions = document.getElementById("display_options");
			var frontPampletsOptions = document.getElementById("front_pamphlets_reactanguler_options");
			var frontStickersOptions = document.getElementById("front_stickers_options");
			var hoodOptions = document.getElementById("hood_options");
			var interiorOptions = document.getElementById("interior_options");

			if(displayOptions.value){
				var displayOptionsData = displayOptions.value;
				displayOptionsData = JSON.parse(displayOptionsData);
				
			}
			
			if(frontPampletsOptions.value){
				var frontPampletsOptionsData = frontPampletsOptions.value;
				frontPampletsOptionsData = JSON.parse(frontPampletsOptionsData);
				
					
			}
			

			if(frontStickersOptions.value){
				var frontStickersOptionsData = frontStickersOptions.value;
				frontStickersOptionsData = JSON.parse(frontStickersOptionsData);
				
			}
			
			if(hoodOptions.value){
				var hoodOptionsData = hoodOptions.value;
				hoodOptionsData = JSON.parse(hoodOptionsData);
				
			}

			if(interiorOptions.value){
				var interiorOptionsData = interiorOptions.value;
				interiorOptionsData = JSON.parse(interiorOptionsData);
				
			}
		}
	
	}	
	
	var chkElm = '';
	
	function addDomToPriceOptions(name, type){
			
			var click = 1;
			var option_type = type;
				
			var chkExist = fieldData.indexOf(name);
    		console.log(fieldData);		 
			if(chkExist == -1){
				var model = document.getElementById("modelname").value;
				var labeltext = "Price for "+name+" "+model+" Ad Per unit:";
				var labelnumbertext = "Number of "+model+" for "+name+" Ad:";
				var labeldurationtext = "Ad Duration of "+model+" for "+name+" Ad (in Months):";
				var iname = name.toLowerCase();
				var res = iname.split(' ').join('_');
				var inputname = "price_"+res;
				var numberbuses = "number_"+res;
				var durationbuses = "duration_"+res;
				var priceElement = document.getElementById('pricing-options-step');
				
				var divrow = document.createElement('div');
				divrow.className = 'form-group';
				divrow.id = 'p'+inputname;

				var divrownum = document.createElement('div');
				divrownum.className = 'form-group';
				divrownum.id = 'p'+numberbuses;

				var divrowduration = document.createElement('div');
				divrowduration.className = 'form-group';
				divrowduration.id = 'p'+durationbuses;
				//iput field
				var labelhtm = document.createElement('label');
				labelhtm.setAttribute("for", inputname);
				labelhtm.innerText = labeltext;

				var inputhtm = document.createElement("input"); //input element, text
				inputhtm.setAttribute('type',"text");
				inputhtm.setAttribute('name',inputname);
				inputhtm.setAttribute('class', "form-control");
				inputhtm.setAttribute('id', inputname);
				inputhtm.setAttribute('required', 'required');
				inputhtm.setAttribute('placeholder', 'put value as number eg: 35345');

				//number of buses
				var labelnumhtm = document.createElement('label');
				labelnumhtm.setAttribute("for", numberbuses);
				labelnumhtm.innerText = labelnumbertext;

				var inputnumhtm = document.createElement("input"); //input element, text
				inputnumhtm.setAttribute('type',"text");
				inputnumhtm.setAttribute('name',numberbuses);
				inputnumhtm.setAttribute('class', "form-control");
				inputnumhtm.setAttribute('id', numberbuses);
				inputnumhtm.setAttribute('required', 'required');
				inputnumhtm.setAttribute('placeholder', 'put number of buses as number');

				//Duration of buses
				var labeldurationhtm = document.createElement('label');
				labeldurationhtm.setAttribute("for", durationbuses);
				labeldurationhtm.innerText = labeldurationtext;

				var inputdurationhtm = document.createElement("input"); //input element, text
				inputdurationhtm.setAttribute('type',"text");
				inputdurationhtm.setAttribute('name',durationbuses);
				inputdurationhtm.setAttribute('class', "form-control");
				inputdurationhtm.setAttribute('id', durationbuses);
				inputdurationhtm.setAttribute('required', 'required');
				inputdurationhtm.setAttribute('placeholder', 'put duration of ad for buses(in Months)');

				fieldData.push(name);
				if(fieldisi){
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
			}else{
				removeItem(name, option_type);
			}

        }

		function removeItem(name, option_type) {
						
			var iname = name.toLowerCase();
			var res = iname.split(' ').join('_');
		
            var inputname = "price_"+res;
			var numberbuses = "number_"+res;
			var durationbuses = "duration_"+res;
			var divId = 'p'+inputname;
			
			var divnumId = 'p'+numberbuses;
			
			var divdurId = 'p'+durationbuses;
			
			fieldData.splice(fieldData.indexOf(name), 1);
			if(fieldisi){
				editfieldData.splice(editfieldData.indexOf(name), 1);
				
				var id = document.getElementById("uncheckID").value;
				var tableName = document.getElementById("tablename").value;
				var update_options = '';
				
				if(tableName == 'newspapers'){
					
					switch(option_type) {
						case 'general_options':
							if(generalOptionsData){
								generalOptionsData.splice(generalOptionsData.indexOf(res), 1);
								generalOptions.value = JSON.stringify(generalOptionsData);
								update_options = generalOptionsData;
							}
							break;
						case 'other_options':
							if(otherOptionsData){
								otherOptionsData.splice(otherOptionsData.indexOf(res), 1);
								otherOptions.value = JSON.stringify(otherOptionsData);
								update_options = otherOptionsData;
							}
							break;
						case 'classified_options':
							if(classifiedOptionsData){
								classifiedOptionsData.splice(classifiedOptionsData.indexOf(res), 1);
								classifiedOptions.value = JSON.stringify(classifiedOptionsData);
								update_options = classifiedOptionsData;
							}
							break;
						case 'pricing_options':
							if(pricingOptionsData){
								pricingOptionsData.splice(pricingOptionsData.indexOf(res), 1);
								pricingOptions.value = JSON.stringify(pricingOptionsData);
								update_options = pricingOptionsData;
							}
							break;
						
					}
					if(update_options !== ''){
						fieldisi.value = JSON.stringify(fieldData);
						$.ajax({
								method: 'GET',
								url: uncheckDeleteURL,
								data: {id: id, option_type: option_type, option_name: name, price_key: inputname, number_key: numberbuses, duration_key: durationbuses, table:tableName, displayoptions: JSON.stringify(update_options) }
							})
							.done(function (msg){
								console.log(msg);
							});
					}
				} else if (tableName == 'autos') { 
					
					switch(option_type) {
						case 'display_options':
							if(displayOptionsData){
								displayOptionsData.splice(displayOptionsData.indexOf(res), 1);
								displayOptions.value = JSON.stringify(displayOptionsData);
								update_options = displayOptionsData;
							}
						break;
						case 'front_pamphlets_reactanguler_options':
							if(frontPampletsOptionsData){
								frontPampletsOptionsData.splice(frontPampletsOptionsData.indexOf(res), 1);
								frontPampletsOptions.value = JSON.stringify(frontPampletsOptionsData);
								update_options = frontPampletsOptionsData;
							}
							break;
						case 'front_stickers_options':
							if(frontStickersOptionsData){
								frontStickersOptionsData.splice(frontStickersOptionsData.indexOf(res), 1);
								frontStickersOptions.value = JSON.stringify(frontStickersOptionsData);
								update_options = frontStickersOptionsData;
							}
							break;
						case 'hood_options':
							if(hoodOptionsData){
								hoodOptionsData.splice(hoodOptionsData.indexOf(res), 1);
								hoodOptions.value = JSON.stringify(hoodOptionsData);
								update_options = hoodOptionsData;
							}
							break;
						case 'interior_options':
							if(interiorOptionsData){
								interiorOptionsData.splice(interiorOptionsData.indexOf(res), 1);
								interiorOptions.value = JSON.stringify(interiorOptionsData);
								update_options = interiorOptionsData;
							}
							break;
						
					}
					if(update_options !== ''){
						fieldisi.value = JSON.stringify(fieldData);
						$.ajax({
							method: 'GET',
							url: uncheckDeleteURL,
							data: {id: id, option_type: option_type, option_name: name, price_key: inputname, number_key: numberbuses, duration_key: durationbuses, table:tableName, displayoptions: JSON.stringify(update_options) }
						})
						.done(function (msg){
							console.log(msg);
						}); 
					}
					
				} else {
					fieldisi.value = JSON.stringify(fieldData);
					$.ajax({
							method: 'GET',
							url: uncheckDeleteURL,
							data: {id: id, price_key: inputname, number_key: numberbuses, duration_key: durationbuses, displayoptions: JSON.stringify(fieldData) }
						})
						.done(function (msg){
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


		function addDomToPriceOptionsWithLight(value){
			
			if(value == 'Yes'){
				$("#light-content").show();
			}else if(value == 'No'){
				$("#light-content").hide();
			}
		}

$('ul.nav li.dropdown'). hover(function() {
$(this). find('.dropdown-menu'). stop(true, true). delay(200). fadeIn(500);
}, function() {
$(this). find('.dropdown-menu'). stop(true, true). delay(200). fadeOut(500);
});



	// order page JS
let showStatusOptions = function showStatusOptions(dividi, orderID){
	$('.selectform'+dividi).toggle();
	let self = $(this);
	$('.selectform'+dividi).on('change', function(){
		$(".editstatus"+dividi).hide();
		let changeStatus = this.value;
		let columnName = ''; 
		if(dividi == 1){
			columnName = 'order_status';
		}
		if(dividi == 2){
			columnName = 'payment_status';
		}
		$.ajax({
			method: 'GET',
			url: OrderStatusURL,
			data: {id: orderID, columnName: columnName, status: changeStatus}
		})
		.done(function (msg){
			let outPut = changeStatus+'<i class="fa fa-pencil edit" onclick="showStatusOptions('+dividi+', '+orderID+')" aria-hidden="true"></i>';
			$('.selectform'+dividi).hide();
			$(".editstatus"+dividi).html(outPut);
			$(".editstatus"+dividi).show();
			
		});
	});
}

// js for cinema

function addDomToPriceOptionsCinema(name, type){
	var click = 1;
	var option_type = type;
		
	var chkExist = fieldData.indexOf(name);
		
	if(chkExist == -1){
		var model = document.getElementById("modelname").value;
		var labeltext = "Price for "+name+" "+model+" Ad Per unit:";
		var labelnumbertext = "Number of "+model+" for "+name+" Ad:";
		var labeldurationtext = "Ad Duration of "+model+" for "+name+" Ad (in Sec):";
		var iname = name.toLowerCase();
		var res = iname.split(' ').join('_');
		var inputname = "price_"+res;
		var duration = "duration_"+res;
		var priceElement = document.getElementById('pricing-options-step');
		
		var divrow = document.createElement('div');
		divrow.className = 'form-group';
		divrow.id = 'p'+inputname;

		
		var divrowduration = document.createElement('div');
		divrowduration.className = 'form-group';
		divrowduration.id = 'p'+duration;
		//iput field
		var labelhtm = document.createElement('label');
		labelhtm.setAttribute("for", inputname);
		labelhtm.innerText = labeltext;

		var inputhtm = document.createElement("input"); //input element, text
		inputhtm.setAttribute('type',"text");
		inputhtm.setAttribute('name',inputname);
		inputhtm.setAttribute('class', "form-control");
		inputhtm.setAttribute('id', inputname);
		inputhtm.setAttribute('required', 'required');
		inputhtm.setAttribute('placeholder', 'put price value as number eg: 35345');

		
		//Duration of buses
		var labeldurationhtm = document.createElement('label');
		labeldurationhtm.setAttribute("for", duration);
		labeldurationhtm.innerText = labeldurationtext;

		var inputdurationhtm = document.createElement("input"); //input element, text
		inputdurationhtm.setAttribute('type',"text");
		inputdurationhtm.setAttribute('name',duration);
		inputdurationhtm.setAttribute('class', "form-control");
		inputdurationhtm.setAttribute('id', duration);
		inputdurationhtm.setAttribute('required', 'required');
		inputdurationhtm.setAttribute('placeholder', 'put duration of ad for Cinema(in Sec)');

		fieldData.push(name);
		if(fieldisi){
			fieldisi.value = JSON.stringify(fieldData);
		}
		divrow.appendChild(labelhtm);
		divrow.appendChild(inputhtm);
		
		divrowduration.appendChild(labeldurationhtm);
		divrowduration.appendChild(inputdurationhtm);
		priceElement.appendChild(divrow);
		
		priceElement.appendChild(divrowduration);
	}else{
		removeItemCinema(name, option_type);
	}
}

function removeItemCinema(name, option_type) {
						
	var iname = name.toLowerCase();
	var res = iname.split(' ').join('_');

	var inputname = "price_"+res;

	var duration = "duration_"+res;
	var divId = 'p'+inputname;
		
	var divdurId = 'p'+duration;
	
	fieldData.splice(fieldData.indexOf(name), 1);
	if(fieldisi){
		editfieldData.splice(editfieldData.indexOf(name), 1);
		
		var id = document.getElementById("uncheckID").value;
		var tableName = document.getElementById("tablename").value;
		var update_options = '';
	
		fieldisi.value = JSON.stringify(fieldData);
		$.ajax({
				method: 'GET',
				url: uncheckDeleteURL,
				data: {id: id, price_key: inputname, duration_key: duration, displayoptions: JSON.stringify(fieldData) }
			})
			.done(function (msg){
				console.log(msg);
		});
	}
	
	var deleteNode = document.getElementById(divId);
	deleteNode.remove();
	
	var deletedurNode = document.getElementById(divdurId);
	deletedurNode.remove();
	
}



function addDomToPriceOptionsAuto(name, type){
	var option_type = type;
	var chkExist = fieldData.indexOf(name);
	console.log(fieldData);		 
	if(chkExist == -1){
		var model = document.getElementById("modelname").value;
		var labeltext = "Price for "+name+" "+model+" Ad Per unit:";
		var labelnumbertext = "Number of "+model+" for "+name+" Ad:";
		var labeldurationtext = "Ad Duration of "+model+" for "+name+" Ad (in Months):";
		var iname = name.toLowerCase();
		var res = iname.split(' ').join('_');
		var inputname = "price_"+res;
		var numberbuses = "number_"+res;
		var durationbuses = "duration_"+res;
		var priceElement = document.getElementById('pricing-options-step');
		
		var divrow = document.createElement('div');
		divrow.className = 'form-group';
		divrow.id = 'p'+inputname;

		var divrownum = document.createElement('div');
		divrownum.className = 'form-group';
		divrownum.id = 'p'+numberbuses;

		var divrowduration = document.createElement('div');
		divrowduration.className = 'form-group';
		divrowduration.id = 'p'+durationbuses;
		//iput field
		var labelhtm = document.createElement('label');
		labelhtm.setAttribute("for", inputname);
		labelhtm.innerText = labeltext;

		var inputhtm = document.createElement("input"); //input element, text
		inputhtm.setAttribute('type',"text");
		inputhtm.setAttribute('name',inputname);
		inputhtm.setAttribute('class', "form-control");
		inputhtm.setAttribute('id', inputname);
		inputhtm.setAttribute('required', 'required');
		inputhtm.setAttribute('placeholder', 'put value as number eg: 35345');

		//number of buses
		var labelnumhtm = document.createElement('label');
		labelnumhtm.setAttribute("for", numberbuses);
		labelnumhtm.innerText = labelnumbertext;

		var inputnumhtm = document.createElement("input"); //input element, text
		inputnumhtm.setAttribute('type',"text");
		inputnumhtm.setAttribute('name',numberbuses);
		inputnumhtm.setAttribute('class', "form-control");
		inputnumhtm.setAttribute('id', numberbuses);
		inputnumhtm.setAttribute('required', 'required');
		inputnumhtm.setAttribute('placeholder', 'put number of buses as number');

		//Duration of buses
		var labeldurationhtm = document.createElement('label');
		labeldurationhtm.setAttribute("for", durationbuses);
		labeldurationhtm.innerText = labeldurationtext;

		var inputdurationhtm = document.createElement("input"); //input element, text
		inputdurationhtm.setAttribute('type',"text");
		inputdurationhtm.setAttribute('name',durationbuses);
		inputdurationhtm.setAttribute('class', "form-control");
		inputdurationhtm.setAttribute('id', durationbuses);
		inputdurationhtm.setAttribute('required', 'required');
		inputdurationhtm.setAttribute('placeholder', 'put duration of ad for buses(in Months)');

		fieldData.push(name);
		if(fieldisi){
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
	}else{
		removeItemAuto(name, option_type);
	}

}

function removeItemAuto(name, option_type) {
						
	var iname = name.toLowerCase();
	var res = iname.split(' ').join('_');

	var inputname = "price_"+res;
	var numberbuses = "number_"+res;
	var durationbuses = "duration_"+res;
	var divId = 'p'+inputname;
	
	var divnumId = 'p'+numberbuses;
	
	var divdurId = 'p'+durationbuses;
	
	fieldData.splice(fieldData.indexOf(name), 1);
	if(fieldisi){
		editfieldData.splice(editfieldData.indexOf(name), 1);
		
		var id = document.getElementById("uncheckID").value;
		var tableName = document.getElementById("tablename").value;
		var update_options = '';
		
	
		fieldisi.value = JSON.stringify(fieldData);
		$.ajax({
				method: 'GET',
				url: uncheckDeleteURL,
				data: {id: id, price_key: inputname, option_type: option_type, number_key: numberbuses, duration_key: durationbuses, displayoptions: JSON.stringify(fieldData) }
			})
			.done(function (msg){
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