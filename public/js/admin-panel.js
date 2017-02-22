
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
});

	// making category slug
	var Slug = '';
	function makeSlug(){
		
		var title_val = document.getElementById("category-name");
		var Slug = title_val.value.replace(/([~!@#$%^&*()_+=`{}\[\]\|\\:;'<>,.\/? ])+/g, '-').replace(/^(-)+|(-)+$/g,'');
		Slug = Slug.toLowerCase();
		
		document.getElementById('category-slug').value = Slug;
	}
	$("#category-slug").focus(function() {
		var title_val = document.getElementById("category-name");
		var Slug = title_val.value.replace(/([~!@#$%^&*()_+=`{}\[\]\|\\:;'<>,.\/? ])+/g, '-').replace(/^(-)+|(-)+$/g,'');
		Slug = Slug.toLowerCase();
		
		document.getElementById('category-slug').value = Slug;
	});
	//ends

	
	fieldData = [];
	var fieldisi = document.getElementById("priceData");
	if(fieldisi){
		var editfieldData = fieldisi.value;
		editfieldData = JSON.parse(editfieldData);
		fieldData = fieldData.concat(editfieldData);
	}	
	
	var chkElm = '';
	
	function addDomToPriceOptions(name){
			
			var click = 1;
			         	
			var chkExist = fieldData.indexOf(name);
    				 
			if(chkExist == -1){
				var model = document.getElementById("modelname").value;
				var labeltext = "Price for "+name+" "+model+" Ad Per unit:";
				var labelnumbertext = "Number of "+model+" for "+name+" Ad:";
				var labeldurationtext = "Ad Duration of "+model+" for "+name+" Ad:";
				var iname = name.toLowerCase();
				var res = iname.replace(" ", "_");
				var inputname = "price_"+res;
				var numberbuses = "number_"+res;
				var durationbuses = "duration_"+res;

				var priceElement = document.getElementById('pricing-options-step');
				
				var divrow = document.createElement('div');
				divrow.className = 'form-group';
				divrow.id = 'p'+inputname;
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
				inputdurationhtm.setAttribute('placeholder', 'put duration of ad for buses');

				fieldData.push(name);
				if(fieldisi){
					fieldisi.value = JSON.stringify(fieldData);
				}
				divrow.appendChild(labelhtm);
				divrow.appendChild(inputhtm);
				divrow.appendChild(labelnumhtm);
				divrow.appendChild(inputnumhtm);
				divrow.appendChild(labeldurationhtm);
				divrow.appendChild(inputdurationhtm);
				priceElement.appendChild(divrow);
			}else{
				removeItem(name);
			}

        }

		function removeItem(name) {
						
			var iname = name.toLowerCase();
			var res = iname.replace(" ", "_");
            var inputname = "price_"+res;
			var divId = 'p'+inputname;
			fieldData.splice(fieldData.indexOf(name), 1);
			if(fieldisi){
				editfieldData.splice(editfieldData.indexOf(name), 1);
				var id = document.getElementById("uncheckID").value;
			var tableName = document.getElementById("tablename").value;
				fieldisi.value = JSON.stringify(fieldData);
				$.ajax({
						method: 'GET',
						url: uncheckDeleteURL,
						data: {id: id, price_key: inputname, table:tableName, displayoptions: JSON.stringify(fieldData) }
					})
					.done(function (msg){
						console.log(msg);
					});
			}
			var deleteNode = document.getElementById(divId);
			deleteNode.remove();
			
		}


		function addDomToPriceOptionsWithLight(value){
			
			if(value == 'Yes'){
				$("#light-content").show();
			}else if(value == 'No'){
				$("#light-content").hide();
			}
		}

	// products options ends

	function inertFunct(){

		
	}