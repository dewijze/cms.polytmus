<?php
// links start with a dot+slash (i.e. start from root)

$c['global_googlemaps'] = "Home";
//$c['global_apikey'] = 'AIzaSyA5RYTpbXlO9MHGP9KU9v83XVC9j18BWIg';
$c['mapsmode'] = "place";
$c['location'] = "52.373266, 4.889642";

$hook['style'][] = "<link rel='stylesheet' type='text/css' href='./plugins/googlemaps/styles.css' media='screen'/>";
$hook['css'][] = "plugins/googlemaps/styles.css";

//$hook['jslib'][] = "<script type='text/javascript' src='https://maps.googleapis.com/maps/api/js?v=3&amp;sensor=false'></script>";
//$hook['js'][] = "./plugins/googlemaps/maps-api-v3.js";

$hook['script'][] = "
<script>
    function initialize() {
        var div = document.getElementById('dom-gmaps');
        var userLoc = div.textContent.split(',');
	
        var myLatlng = new google.maps.LatLng(parseFloat(userLoc[0]), parseFloat(userLoc[1]));
        var mapOptions = {
            zoom: 11,
            center: myLatlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
	
        var marker = new google.maps.Marker({
            position: myLatlng,
            map: map,
            title: 'Hello World!'
        });
        var circle = new google.maps.Circle({
            map: map,
            radius: 8000,    // 10 miles in metres
            fillColor: '#90abc6',
            strokeColor: '#ffffff',
            strokeWeight: 2
        });
        circle.bindTo('center', marker, 'position');
    }
	
    google.maps.event.addDomListener(window, 'load', initialize);
</script>";

function insertLocation()
{
	global $c;
	echo "<div id='dom-gmaps' style='display: none;'>
	
	".$c['location']."
	
	</div>";    
}
?>
