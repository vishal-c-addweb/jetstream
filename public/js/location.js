var getLatitude = document.getElementById('latitude').value;
var getLongitude = document.getElementById('longitude').value;

window.addEventListener("DOMContentLoaded", function () {
    // (B1) INSERT ACCESS TOKEN HERE!
    mapboxgl.accessToken = 'pk.eyJ1IjoidmlzaGFsOTg3NiIsImEiOiJja3B4dmo4bnowZXBrMndsb3E1aTNsbjZvIn0.4IIcMd8lRuGUbCgMB_Hvag';

        let map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11',
            center: [getLongitude, getLatitude],
            zoom:13
        });

        let marker = new mapboxgl.Marker()
            .setLngLat([getLongitude, getLatitude])
            .addTo(map);
        
        var place_name; 
        
        fetch('https://api.mapbox.com/geocoding/v5/mapbox.places/'+getLongitude+','+getLatitude+'.json?access_token=pk.eyJ1IjoidmlzaGFsOTg3NiIsImEiOiJja3B4dmo4bnowZXBrMndsb3E1aTNsbjZvIn0.4IIcMd8lRuGUbCgMB_Hvag')
        .then(res => res.json())
        .then((data) => {
            console.log(data);
            place_name = data.features[0].place_name;
        }).catch(err => console.error(err));

        map.on('click',function(){
            let info = new mapboxgl.Popup()
            .setLngLat([getLongitude, getLatitude])
            .setHTML('<h6>'+place_name+'</h6>')
            .addTo(map);
        }); 
});

function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition, showError);
  } else { 
    alert("Geolocation is not supported by this browser.");
  }
}

function showPosition(position) {
    let latitude = position.coords.latitude; 
    let longitude =  position.coords.longitude;
    $.ajax({
        url:"/location/store",
        type:'post',
        data:{latitude:latitude,longitude:longitude},
        dataType: 'json',
        success:function(response){
            console.log(response);   
            window.location.reload();                      
        }
    });    
}

function showError(error) {
  switch(error.code) {
    case error.PERMISSION_DENIED:
      alert("User denied the request for Geolocation.");
      break;
    case error.POSITION_UNAVAILABLE:
      alert("Location information is unavailable.");
      break;
    case error.TIMEOUT:
      alert("The request to get user location timed out.");
      break;
    case error.UNKNOWN_ERROR:
      alert("An unknown error occurred.");
      break;
  }
}

