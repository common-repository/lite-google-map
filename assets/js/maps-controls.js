 jQuery(document).ready(function($) {
    "use strict";
	$("#mapTypeId4, #mapTypeId3").attr('disabled',true);
	//== Get Initial value Onload====
	var checked=$('.cmb2-id-mapTypeId input[type=radio]:checked').val();
	//======= If checked Onload Go to Action========
	if(checked == 'satellite'){
		$('.cmb2-id-imagery, .cmb2-id-rotateControl').show();
		$('.cmb2-id-mapMarker, .cmb2-id-map-icon, .cmb2-id-maps-theme').hide();
	}else{
		$('.cmb2-id-imagery, .cmb2-id-rotateControl').hide();
	}
	//====== Onchenged Action=========
	$('.cmb2-id-mapTypeId input[type=radio]').on('change', function(e){
		var val= $(this).val();
		if( val == 'satellite' || val == 'hybrid' ){
			$('.cmb2-id-imagery, .cmb2-id-rotateControl').slideDown();
			$('.cmb2-id-mapMarker, .cmb2-id-map-icon, .cmb2-id-maps-theme').slideUp('linear');
		}else{
			$('.cmb2-id-imagery, .cmb2-id-rotateControl').slideUp('linear');
			$('.cmb2-id-mapMarker, .cmb2-id-map-icon, .cmb2-id-maps-theme').slideDown('linear');			
		}
		
	});

});