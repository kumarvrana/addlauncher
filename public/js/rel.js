/**
 * jQuery-Plugin "relCopy"
 * 
 * @version: 1.1.0, 25.02.2010
 * 
 * @author: Andres Vidal
 *          code@andresvidal.com
 *          http://www.andresvidal.com
 *
 * Instructions: Call $(selector).relCopy(options) on an element with a jQuery type selector 
 * defined in the attribute "rel" tag. This defines the DOM element to copy.
 * @example: $('a.copy').relCopy({limit: 5}); // <a href="example.com" class="copy" rel=".phone">Copy Phone</a>
 *
 * @param: string	excludeSelector - A jQuery selector used to exclude an element and its children
 * @param: integer	limit - The number of allowed copies. Default: 0 is unlimited
 * @param: string	append - HTML to attach at the end of each copy. Default: remove link
 * @param: string	copyClass - A class to attach to each copy
 * @param: boolean	clearInputs - Option to clear each copies text input fields or textarea
 * 
 */

(function($) {

	$.fn.relCopyMain = function(options) {
		var settings = jQuery.extend({
			excludeSelector: ".exclude",
			emptySelector: ".empty",
			copyClass: "copy",
			append: '',
			clearInputs: true,
			limit: 0 // 0 = unlimited
		}, options);
		
		settings.limit = parseInt(settings.limit);
		
		// loop each element
		this.each(function() {
			
			// set click action
			$(this).click(function(){
				var rel = $(this).attr('rel'); // rel in jquery selector format				
				var counter = $(rel).length;
				
				// stop limit
				if (settings.limit != 0 && counter >= settings.limit){
					return false;
				};
				
				var master = $(rel+":first");
				var parent = $(master).parent();						
				var clone = $(master).clone(true).addClass(settings.copyClass+counter).append(settings.append);
				if(clone.length === 0){
					var htmlGenerate = generateNewBlock();
					//console.log(htmlGenerate);
					clone1 = $(this).after(htmlGenerate);//append(htmlGenerate);
					//console.log(clone);
				}
				//Remove Elements with excludeSelector
				if (settings.excludeSelector){
					$(clone).find(settings.excludeSelector).remove();
				};
				
				//Empty Elements with emptySelector
				if (settings.emptySelector){
					$(clone).find(settings.emptySelector).empty();
				};								
				
				if ( $(clone).attr('id') ){
					var newid = $(clone).attr('id') + (counter +1);
					$(clone).attr('id', newid);
				};
				//check
				$(clone).find('[class]').each(function(){
					if($(this).attr('class') === 'phone'){
						var className = 'phone'+ (counter +1);
						$(this).attr('class', className);
					}
					if($(this).attr('rel') === '.phone'){
						var relName = '.phone'+ (counter +1);
						$(this).attr('rel', relName);
					}
					if($(this).attr('class') === 'hideonClone'){
						$(this).hide();
					}
					
				});	
				// Increment Clone names
				if ( $(clone).attr('name') ){
					var newname = $(clone).attr('name') + (counter +1);
					$(clone).attr('name', newname);
				};
				
				if ( $(clone).attr('data-index') ){
					var dataIndex = counter +1;
					$(clone).attr('data-index', dataIndex);
				};
				if($(clone).attr('class') === 'hideonClone')
				{
					$(".hideonClone").hide();
				}
				
				// Increment Clone Children IDs
				$(clone).find('[id]').each(function(){
					var newid = $(this).attr('id') + (counter +1);
					$(this).attr('id', newid);
				});
				
				$(clone).find('[name]').each(function(){
					var newname = $(this).attr('name') + (counter +1);
					$(this).attr('name', newname);
				});
				 
				$(clone).find('[data-index]').each(function(){
					var dataIndex = counter +1;
					$(this).attr('data-index', dataIndex);
				});
				
				
				//Clear Inputs/Textarea
				if (settings.clearInputs){
					$(clone).find(':input').each(function(){
						var type = $(this).attr('type');
						switch(type)
						{
							case "button":
								break;
							case "reset":
								break;
							case "submit":
								break;
							case "checkbox":
								$(this).attr('checked', '');
								break;
							default:
							  $(this).val("");
						}						
					});					
				};
				
				$(parent).find(rel+':last').after(clone);
				
				return false;
				
			}); // end click action
			
		}); //end each loop
		
		return this; // return to jQuery
	};
	function generateNewBlock(){
		var airport_locations = [];
		airport_locations['after_security_check'] = 'After Security Check';
		airport_locations['arrival_area'] = 'Arrival Area';
		airport_locations['arrival_canyon'] = 'Arrival Canyon';
		airport_locations['arrival_check_in_hall'] = 'Arrival Check In Hall';
		airport_locations['arrival_concourse'] = 'Arrival Concourse';
		airport_locations['arrival_hall'] = 'Arrival Hall';
		airport_locations['arrival_outdoor'] = 'Arrival Outdoor';
		airport_locations['arrival_piers'] = 'Arrival Piers';
		airport_locations['departure_area'] = 'Departure Area';
		airport_locations['departure_check_in_hall'] = 'Departure Check In Hall';
		airport_locations['departure_canyon'] = 'Departure Canyon';
		airport_locations['departure_frisking'] = 'Departure Frisking';
		airport_locations['departure_indoor'] = 'Departure Indoor';
		airport_locations['departure_outdoor'] = 'Departure Outdoor';
		airport_locations['departure_piers'] = 'Departure Piers';
		airport_locations['departure_sha'] = 'Departure Sha';
			
		var airport_options = [];
		airport_options['backlit_panel'] = 'Backlit Panel';
		airport_options['luggage_trolley'] = 'Luggage Trolley';
		airport_options['totems'] = 'Totems';
		airport_options['video_wall'] = 'Video Wall';
		airport_options['ambient_lit'] = 'Ambient Lit';
		airport_options['sav'] = 'Sav';
		airport_options['backlit_flex'] = 'backlit Flex';
		airport_options['banner'] = 'Banner';
		airport_options['digital_screens'] = 'Digital Screens';
		airport_options['scroller'] = 'Scroller';
		var rawlocations = '';
        for (z in airport_locations) {
    		rawlocations += '<option value="'+z+'">'+airport_locations[z]+'</option>';
		} 
		var rawoptions = '';
        for (x in airport_options) {
    		rawoptions += '<option value="'+x+'">'+airport_options[x]+'</option>';
		}    
		var htmlGenerate = '<div class="full-html" id="room_fileds">';
            htmlGenerate += '<div class="form-group" ><label>Select Location</label><select required data-index="1" id="location" class="form-control" name="airport_location" class="location"><option value="">Select Location</option>'+rawlocations+'</select></div>';
            htmlGenerate += '<div class="form-group"><label>Select Category</label><select required data-index="1" id="displayoptions" name="airport_category" class="form-control displayoption"><option value="">Select Category</option>'+rawoptions+'</select></div>'; 
            htmlGenerate += '<div class="form-group"><label for="dimensions"> Dimensions: </label><input type="text" name="airport_dimensions" placeholder="Dimensions" class="form-control" required></div>';
            htmlGenerate += '<div class="form-group"><label for="price"> Price: </label><input type="text" name="airport_price" placeholder="Price" class="form-control" required></div>';
            htmlGenerate += '<div class="form-group"><label for="units"> Units: </label><input type="text" name="airport_units" placeholder="Units" class="form-control" required></div>';
            htmlGenerate += '</div>';
		return htmlGenerate;
			
	}
	
})(jQuery);