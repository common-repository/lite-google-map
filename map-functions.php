<?php
/**
 * @package Google Map Lite
 * @version 1.2
 */
/*
*/

//======== Enque Map API ==========
function gml_map_scripts() {
	$value 		= get_option( 'gmap_settings' );
	
	if($value!=""){
		$key		= $value['maps_key'];	
	}else{
		$key		='AIzaSyDtsjF6u_cJFz57xJqzbWT0Q6Ddl3EsMQ0';
	}
    wp_enqueue_script('map-api', 'http://maps.googleapis.com/maps/api/js?key='.$key.'');	
}
add_action('wp_enqueue_scripts', 'gml_map_scripts');

//===== Enque Map Settings ========
function gml_map_setings(){
	$value 		= get_option( 'gml_map_options' );
	if($value!="")
	{
		$lat		= $value['lat'];
		$long	  	= $value['long'];
		$zoom	 	= $value['zoom'];
		$icon 		= $value['map_icon'];
		$map_theme 	= $value['maps_theme'];
		$fullscreenControl 	= $value['full_screen'];
		$mapTypeControl 	= $value['mapTypeControl'];
		$rotateControl 		= $value['rotateControl'];
		$imagery 			= $value['imagery'];
		$isMapMarker 		= $value['mapMarker'];
		$mapTypeId 			= $value['mapTypeId'];
		
			//===== fullScreen====
			if($fullscreenControl=="on"){
				$fullscreenControl="true";
			}else{
				$fullscreenControl="false";
			}
			//===== mapTypeControl====
			if($mapTypeControl=="on"){
				$mapTypeControl="true";
			}else{
				$mapTypeControl="false";
			}
			//===== rotateControl ====
			if($rotateControl=="on"){
				$rotateControl="true";
			}else{
				$rotateControl="false";
			}
			//===== 45° imagery =====
			if($imagery=="on"){
				$imagery=45;
			}else{
				$imagery=0;
			}
			//===== mapMarker =======
			if($isMapMarker =="on"){
				$isMapMarker ='true';
			}else{
				$isMapMarker ='false';
			}
			if($mapTypeId!="setelliet"){
				$isMapMarker ='true';
			}else{
				$isMapMarker ='false';
			}
			//===== End Controls ======
	}
	else
	{
		//===== Default =======
		$lat		= 48.864716;
		$long	  	= 2.349014;
		$zoom	 	= 12;
		$fullscreenControl= true;
		$mapTypeId	= 'roadmap';
	}
	echo
	'<script>
    // These are the values for your desired longitude and latitude
    var lat='.$lat.';
    var long='.$long.';
    var myCenter = new google.maps.LatLng(
        lat, long 
    );
    function changeMarker(newLogo) {
        "use strict";
        var marker = new google.maps.Marker({
            position: myCenter,
            icon: newLogo,
			visible: '.$isMapMarker.',
        });
        var map = new google.maps.Map(document.getElementById("googleMap"), {
            center: myCenter,
            zoom: '.$zoom.',
            mapTypeId:"'.$mapTypeId.'",
            scrollwheel: false,
            mapTypeControl: '.$mapTypeControl.',
            scaleControl: false,
            streetViewControl: false,
            rotateControl: '.$rotateControl.',
			tilt: '.$imagery.',
            fullscreenControl: '.$fullscreenControl.',';
			
		//======Default======
		switch($map_theme){
			case 'standard':
				echo 'styles: [],';
                break;
			case 'blue':
				include('themes/blue.php');
				break;
			case 'dark':
				include('themes/dark.php');
				break;
			case 'dark-blue':
				include('themes/dark-blue.php');
				break;
			case 'gray':
				include('themes/gray.php');
				break;
			case 'gray-blue':
				include('themes/gray-blue.php');
				break;
			case 'green':
				include('themes/green.php');
				break;
			case 'hue':
				include('themes/hue.php');
				break;
			case 'night':
				include('themes/night.php');
				break;
			case 'orange':
				include('themes/orange.php');
				break;
			case 'silver':
				include('themes/silver.php');
				break;
		}
			
			//== End Style====
			echo '});
			marker.setMap(map);
			}
			google.maps.event.addDomListener(window, "load", function () {
			changeMarker("'.$icon.'");
			});
			
		</script>';
}
add_action('wp_footer', 'gml_map_setings');

//======= ShortCode =======

function gml_shortcode( $atts ){
	$value 		= get_option( 'gml_map_options' );
	$height		= $value['height'];
	if($height!=""){
		$height		= $value['height'];
	}else{
		$height		='300px';
	}
	return
	'<section class="maps">
			<div class="location">
				<div id="googleMap" class="mapwrap" style="height:'.$height.'">
					<div class="google-map" id="location"></div>
				</div>
			</div>
	</section>';
}
add_shortcode( 'google_maps', 'gml_shortcode' );
//======Maps Option========
//======== Enque Map API ==========
function gml_map_controls() {
	wp_enqueue_script('map-controls', plugin_dir_url( __FILE__ ).'assets/js/maps-controls.js');
}
add_action('admin_enqueue_scripts', 'gml_map_controls');