/**
 * Convertis les metadonnées gps en coordonnée decimal
 */
var getGPS = function(exifCoord, direction) {
    var parts = exifCoord.split(" ");
    var degrees = parseInt(parts[0]);
    var minutes = parseFloat(parts[2]);
    var seconds = parseFloat(parts[3]);
    var dd = degrees + minutes/60 + seconds/(3600);

    if (direction == "S" || direction == "W") {
        dd = dd * -1;
    }
    return dd;
};