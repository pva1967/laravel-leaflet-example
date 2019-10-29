$.getScript("https://maps.googleapis.com/maps/api/js?key={!! env('GOOGLE_API') !!}&language=en", function(){

    var geocoder_en = new google.maps.Geocoder;


});
console.log (geocoder_en);
export default {geocoder_en};
