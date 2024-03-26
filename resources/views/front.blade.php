@extends('layouts.front.app')
@section('title')
Tata Ruang
@endsection

@push('style')
<style>
    #map {
        width: auto;
        height: 700px;
    }
</style>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
    integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
<link rel="stylesheet" href="{{asset('css/L.Control.Locate.min.css')}}" />
<link rel="stylesheet" href="{{asset('css/Leaflet.NavBar.css')}}" />





@endpush

@section('content')





<div class="page has-sidebar-left bg-light">
    {{-- <header class="blue accent-3 relative nav-sticky">
        <div class="container-fluid text-white">
            <div class="row p-t-b-10 ">
                <div class="col">
                    <h4>
                        <i class="icon-box"></i>
                        {{ $title}}
    </h4>
</div>
</div>
<div class="row">
    <ul class="nav responsive-tab nav-material nav-material-white" id="v-pills-tab">



    </ul>

</div>
</div>
</header> --}}

<div class="container-fluid my-3">

    <div id="map"></div>
</div>
</div>

@endsection


@push('script')
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
<script type="text/javascript" src="{{asset('js/Control.Geocoder.HerePlaces.js')}}"></script>
<script type="text/javascript" src="{{asset('js/Leaflet.NavBar.js')}}"></script>
<script type="text/javascript" src="{{asset('js/L.Control.Locate.js')}}"></script>
<script type="text/javascript" src="{{asset('js/choropleth.js')}}"></script>
<script type="text/javascript" src="{{asset('js/spin.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/leaflet.spin.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/Leaflet.Control.Custom.js')}}"></script>
<script src="https://unpkg.com/leaflet-kmz@latest/dist/leaflet-kmz.js"></script>

<script>
    var marKerSRC;
    var popupSrc;
    $( document ).ready(function() {
        $("#kota_04144351").trigger('click');
        
        
    });
    function isLatitude(lat) {
  return isFinite(lat) && Math.abs(lat) <= 90;
}

function isLongitude(lng) {
  return isFinite(lng) && Math.abs(lng) <= 180;
}

    function searchCor(){
        let kor = $('#search_kor').val().split(',');
        let lat = kor[0];
        let long = kor[1];
            if(isLatitude(lat) == false ||isLongitude(long) == false ){
                $.alert({
                            title: 'error!',
                            type: 'red',
                            content: 'Latitude / Longitude tidak valid!',
                        });
            }else{
                if(marKerSRC){
                    map.removeLayer(marKerSRC);
                }
                if(popupSrc){
                    map.removeLayer(popupSrc);
                }
                popupSrc = L.popup()
                        .setLatLng(new L.LatLng(lat, long))
                        .setContent('<p>'+lat+','+long+'</p>');
                        
                marKerSRC = L.marker(new L.LatLng(lat, long)).addTo(map)
                marKerSRC.bindPopup(popupSrc).openPopup();
                map.setView(new L.LatLng(lat, long),18);
                
            }
        // console.log(kor);
        }
    
    l_layers = [];

    function loadLayer(id){
        
        $.post(  "{{ route('getLayer', ':id') }}".replace(':id', id), )
        .done(function( data ) {
            
            if(data.file_kmz){
                if($('#'+data.slug).is(":checked")){
                    map.spin(true);
                    $('#'+data.slug).prop('disabled',true);
                    
            
                loadKmz('{{asset("storage")}}/'+data.file_kmz);
                $("#ic_"+data.id).show();

            }else{
                let nama = data.file_kmz.split("/");
                unLoadKmz(nama[1]); 
                $("#ic_"+data.id).hide();
                // $("#treeview_"+data.menu_id).css('background-color','white');
            }
            }
        });
    }

   

    function loadKmz(url){
        kmz.load(url);
    }

    function unLoadKmz(nameLayer){
        if (l_layers[nameLayer] !==undefined){
            map.removeLayer(l_layers[nameLayer]);
                
            }
    }
    OpenStreetMap = L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png");
				
				googleHybrid = L.tileLayer("https://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}",{ maxZoom: 20, subdomains:["mt0","mt1","mt2","mt3"]}),
				
				googleTraffic = L.tileLayer("https://{s}.google.com/vt/lyrs=m@221097413,traffic&x={x}&y={y}&z={z}", { maxZoom: 20, minZoom: 2, subdomains:["mt0","mt1","mt2","mt3"]});
                
                // //HitamPutih = L.tileLayer("https://{s}.tiles.wmflabs.org/bw-mapnik/{z}/{x}/{y}.png"),  
                
                googleStreets = L.tileLayer("https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}",{ maxZoom: 20, minZoom: 2, subdomains:["mt0","mt1","mt2","mt3"]});
				
         		jalan = L.tileLayer("https://1.base.maps.api.here.com/maptile/2.1/maptile/newest/normal.day/{z}/{x}/{y}/256/png8?pois=true&lg=ind&app_id=1g1pBeObAdqzorA7Avdd&app_code=3IsuKQ82__s_-kgjjiCRCw");
            
            var pc = true;
            if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
              pc = false;
            }

			var map = L.map("map",{
				center: [-6.291100,106.715421],
				zoom: 11.5,
				//dragging: 1,
				dragging: pc,
                tap: pc,
				pixelRatio: window.devicePixelRatio || 1,
				fullscreenControl: true,
				fullscreenControlOptions: {
				position: "topleft"
				  },
				measureControl: false,
				layers: [OpenStreetMap,jalan,googleHybrid,googleTraffic,googleStreets]   
			})
    //         var logo= L.control({
    //             position : 'topleft'
    //         });
    //     logo.onAdd = function(map) {
    //         this._div = L.DomUtil.create('div', 'myControl');
    //         var img_log = `<div id="search_bar">
    //     <input type="text" name="" id="latlng_search" placeholder="Latitude,Longitude" id="" class="form-control">
    // </div>`;

    //         this._div.innerHTML = img_log;
    //         return this._div;

    //     }
    //     logo.addTo(map);
    L.control.custom({
                position: 'topleft',
                content : `<div class="input-group mb-3">
  <input type="text" id="search_kor" class="form-control s-14" placeholder="-6.322690,106.708109" aria-label="-6.322690,106.708109" aria-describedby="basic-addon2" >
  <div class="input-group-append">
    <button class="btn " type="button" onclick="searchCor()"><span class="icon icon-search p-0"></span></button>
  </div>
</div>`,
    //             `<div id="search_bar">
    //     <input type="text" name="" id="latlng_search" placeholder="-6.322690,106.708109" id="" class="form-control">
    // </div>`,
                classes : '',
                style   :
                {
                    position: 'absolute',
                    left: '50px',
                    top: '0px',
                    width: '250px',
                },
            })
            .addTo(map);
            
            geocoder1 = L.Control.Geocoder.hereplaces({
              app_id:"1g1pBeObAdqzorA7Avdd",
              app_code: "3IsuKQ82__s_-kgjjiCRCw",
              geocodingQueryParams: {at: "-6.4746876,105.7446632"},            
    		}),
		    control = L.Control.geocoder({
		        geocoder: geocoder1
		    }).addTo(map);

            
    
            L.control.navbar().addTo(map);	
            
				
                L.control.locate({
                    position: "topright",			
                   locateOptions: {
                       enableHighAccuracy: true
                }}).addTo(map); //mylocation
                 
                 // Add GeoJSON
                        
                          function zoomToFeature(e) {
                            map.fitBounds(e.target.getBounds());
                        }
                    
                 var baseLayers = {
                    //  "Citra Satelit HereMaps": satelit,
                     "Citra Jalan HereMaps": jalan,
                     "OpenStreetMap":OpenStreetMap,
                     "Citra Trafik GoogleMaps": googleTraffic,
                     "Citra Hybrid GoogleMaps" : googleHybrid,
                     "Citra Jalan GoogleMaps" :googleStreets,
                };

               
                var kmz = L.kmzLayer().addTo(map);
                kmz.on('load', function(e) {
                    // control.addOverlay(e.layer, e.name);
                    
                    l_layers[e.name] = e.layer;
                    map.spin(false);
                    $("input[type=checkbox]").prop('disabled',false);
                    // e.layer.addTo(map);
                });
	

                
</script>



@endpush