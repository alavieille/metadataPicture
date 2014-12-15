$(document).ready(function() {
	google.maps.event.addDomListener(window, 'load', initMap);	
});

/**
 * Initialise la carte
 */
var initMap = function(){
	var mapOptions = {
		center: { lat: -34.397, lng: 150.644},
		zoom: 10
	};
	console.log(document.getElementById('map'));
	map = new google.maps.Map(document.getElementById('map'),mapOptions);
	bounds = new google.maps.LatLngBounds();
	addMarker();
	
}

/**
 * Ajoute les marker
 */
var addMarker = function(){
	$.getJSON( App.urls+"/image/listJson", function(data) {
		$.each(data,function(index,image){
			//console.log(searchMetaImage(image,"XMP","Title"));
			var gps = searchGPS(image);
			if(typeof  gps != 'undefined'){
				coord = new google.maps.LatLng(gps.latitude,gps.longitude);
				addMarkerImage(image,coord)
				// console.log(gps);
			}
			else if(typeof searchMetaImage(image,"XMP","City") != 'undefined'){
				addMarkerGeocoder(image,searchMetaImage(image,"XMP","City"));

			}
		});
  	});
}

var searchGPS = function(image){
	var latitudeRef = searchMetaImage(image,"EXIF","GPSLatitudeRef");
	var latitude = searchMetaImage(image,"EXIF","GPSLatitude");	
	var longitudeRef = searchMetaImage(image,"EXIF","GPSLongitudeRef");
	var longitude = searchMetaImage(image,"EXIF","GPSLongitude");
	if(typeof latitudeRef != 'undefined' && typeof latitude != 'undefined' && typeof longitudeRef != 'undefined' && typeof longitude != 'undefined'){
		return {
			latitude:getGPS(latitude,latitudeRef),
			longitude:getGPS(longitude,longitudeRef),
		}
	}
	return undefined;
}
/**
 * Crée un marker pour une image
 * @param {Image} image 
 * @param {LatLng} location Poisition du marker
 */	
var addMarkerImage = function(image,location){
	var title = searchMetaImage(image,"XMP","Title")
	var href = App.urls+App.databaseFolder+"images/"+image.file;
	var url = "view/"+image.id;

	var marker = new google.maps.Marker({
		map: map,
		title: title,
		position: location,
	});

	bounds.extend(marker.position);

	var content = "<div class='infoContent'>"+
				  	"<div><img class='img-responsive'src='" + href + "' alt='" + title + "' ></div>"+
				  	'<div><h3>' + title + '</h3><a href="'+ url +'">Voir</a></div>'+
				  "</div>";

	var infowindow = new google.maps.InfoWindow({
				content: content
	});

	google.maps.event.addListener(marker, 'click', function() {
		infowindow.open(map,marker);
	});

	map.fitBounds(bounds);
}

/**
 * Recherche les coordonnées de la ville et ajoute le marker
 * @param {Image} image 
 * @param {String} city  ville de l'image (metadonnées)
 */
var addMarkerGeocoder = function(image,city){
	var geocoder = new google.maps.Geocoder();
	//image = image;

	geocoder.geocode( { 'address': city}, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
			
			addMarkerImage(image,results[0].geometry.location);
		}
	});
}


/**
 * Recherche une metadonnées d'un image
 * @param  {Image} image 
 * @param  {String} group Groupe de la meta
 * @param  {Sring} meta  Nom de la meta
 * @return {String}   Contenue de la meta
 */
var searchMetaImage = function(image,group,meta){
	if(typeof image.meta[group] != 'undefined')
		return image.meta[group][meta];
	return undefined;
}

