$(function(){
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
		alert(tinyMCE.get('description'));
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
					/*console.log(JSON.stringify(msg));
					descriptionTD.text(msg['description']);
					$('#edit-ad-category').modal('hide');
					*/
					$('.results').html(msg['response']);
				});
			}
	});
});