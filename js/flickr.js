$(document).ready(function() {
	$(".form-search-flickr input:radio").change(formSearchManage);
	$(".form-search-flickr input:checked").trigger("change");

})

/**
 * Evenement sur les bouton radion du formulaire 
 */
var formSearchManage = function(evt){
	var value = $(this).val();
	switch(value) {
		case 'tag':
			var tags = searchMeta("XMP","Subject");
			
			if(typeof  tags != 'undefined')
				searchFlickrTag(tags,viewPictureFlickr);
			else
				$(".flickr-image").html($("<p>Aucun tag défini dans les métadonnées</p>").attr("class","text-center"));
			break;		
		case 'title':
			var title =  searchMeta("XMP",'Title');
			if(typeof  title != 'undefined')
				searchFlickrTitle(title,viewPictureFlickr);
			else
				$(".flickr-image").html($("<p>Aucun titre défini les métadonnées</p>").attr("class","text-center"));
			break;		
		case 'gps':
			var gpsMeta = metaGPS();
			if(typeof  gpsMeta != 'undefined'){
				searchFlickrGPS(gpsMeta.latitude,gpsMeta.longitude,viewPictureFlickr);
			}
			else{
				var geocoder = new google.maps.Geocoder();
				var city = searchMeta("XMP","City");
				if(typeof  city != 'undefined'){
					geocoder.geocode( { 'address': city}, function(results, status) {
						if (status == google.maps.GeocoderStatus.OK) {
							coord = results[0].geometry.location;
							searchFlickrGPS(coord.k,coord.B,viewPictureFlickr);
						}
					});
				}
			}
			$(".flickr-image").html($("<p>Aucune coordonnée défini les métadonnées</p>").attr("class","text-center"));
			break;
	}
}

/**
 * Extrait les coordonnées GPS
 */
var metaGPS = function(){
	var latitudeRef = searchMeta("EXIF","GPSLatitudeRef");
	var latitude = searchMeta("EXIF","GPSLatitude");	
	var longitudeRef = searchMeta("EXIF","GPSLongitudeRef");
	var longitude = searchMeta("EXIF","GPSLongitude");
	if(typeof latitudeRef != 'undefined' && typeof latitude != 'undefined' && typeof longitudeRef != 'undefined' && typeof longitude != 'undefined'){
		return {
			latitude:getGPS(latitude,latitudeRef),
			longitude:getGPS(longitude,longitudeRef),
		}
	}
	return undefined;
}

/**
 * Recherche les images flickr en relation selon les coordonnee 
 */
var searchFlickrGPS = function(latitude,longitude,callback){
	ApiFlickr.query('flickr.photos.search',{'lat':encodeURI(latitude),'lon':encodeURI(longitude)},function(data){
		callback(data);
	});
}

/**
 * Recherche les images flickr en relation selon les tags
 */
var searchFlickrTag = function(tags,callback){
	ApiFlickr.query('flickr.photos.search',{'tags':encodeURI(tags)},function(data){
		callback(data);
	});
}

/**
 * Recherche les images flickr en relation selon le titre
 */
var searchFlickrTitle = function(title,callback){
	ApiFlickr.query('flickr.photos.search',{'text':encodeURI(title)},function(data){
		callback(data);
	});
}

/**
 * Mise à forme des resultats de l'aPI flickr
 */
var viewPictureFlickr = function(data){
	if(data.photos.photo.length > 0) {
		var liste = $("<ul></ul>").attr('class','list-inline');
		jQuery.each(data.photos.photo, function(i,e) {
			var li = $('<li></li>'),
			     a = $('<a></a>').attr('target', '_blank').attr('href', ApiFlickr.url_page(e)),
			     img = $('<img />').attr('src', ApiFlickr.url_photo(e, 's' ));

			a.append(img);
			li.append(a);
			liste.append(li);
	    });
	    $(".flickr-image").html(liste);
	}
	else{
		var p = $("<p>Aucune photos</p>").attr("class","text-center");
		$(".flickr-image").html(p);
	}
}


/**
 * Recherche une meta d'une image
 * @param  {String} group Groupe de la meta
 * @param  {String} name  Nom de la meta
 * @return {String}       Valeur de la meta
 */
var searchMeta = function(group , name){
	return $("tr").find("[data-meta='" + group +":"+name+"']").html();
}
