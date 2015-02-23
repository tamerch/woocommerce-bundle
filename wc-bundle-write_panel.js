jQuery( function($){

	//init by hiding or showing bundle form
	if ($('#_bundle').is(":checked")) {
		$('.show_if_bundle').show();
	} else {
		$('.show_if_bundle').hide();
	}

	// Product general data bundle visibility
	$('#_bundle').click(function () {
		if ($('#_bundle').is(":checked")) {
			$('.show_if_bundle').slideUp('fast');
			$('.show_if_bundle').show();
		} else {
			$('.show_if_bundle').slideDown('fast');
			$('.show_if_bundle').hide();
		}
	});	
	
	// Product general data bundle visibility
	$('#_bundle_ids').change(function () {
		a=1;
	});	
	
	$('div#_bundle_ids_chzn ul.chzn-choices').each(function() {
	var elem = $(this);
	var elemli = $(this).find('li.search-choice');
	var nli = elemli.size();
	// Save current value of element
	elem.data('nli', nli);
	
	var i
	for (i=0;i<nli;i++) {
	}
	// Look for changes in the value
	elem.bind("DOMNodeInserted", function(event){
		//console.debug("fire script");
		// If value has changed...
		if (elem.data('nli') < elemli.size()) {
			// Updated stored value
			elem.data('nli', elemli.size());
			// Do action
			console.debug("ul changed added : " + (elemli.size()));
		}
   });
   
  elem.bind("DOMNodeRemoved", function(event){
		if (elem.data('nli')=== elemli.size() & jQuery('.show_if_bundle').find('input').val()=='') {
		elem.data('nli', elem.data('nli')-1);
		console.debug("ul changed removed: " + elemli.size());
		
		}
		
   });
 });

});