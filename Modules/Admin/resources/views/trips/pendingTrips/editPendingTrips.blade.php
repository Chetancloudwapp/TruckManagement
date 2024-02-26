@extends('admin::layouts.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $common['title'] }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">{{ $common['title'] }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title nofloat"> <span>{{ $common['heading_title']}} </span>
                                {{--<a href="{{ url('admin/trips')}}">
                                    <button onClick="back();"
                                        class="btn btn-primary waves-effect waves-light f-right d-inline-block md-trigger"
                                        data-modal="modal-13" style="float: right"> <i
                                            class="fa-solid fa-backward"></i>&nbsp;&nbsp; Back
                                    </button>
                                </a>--}}
                            </h3>
                        </div>
                        <div class="card-body">
                            <form name="TripDetailForm" id="main" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    {{-- <div class="col-md-6">
                                        <div class="form-group mb-3 {{ $errors->has('client_name') ? 'has-danger' : '' }}">
                                            <label class="col-form-label">Client Name*</label>
                                            <input
                                                class="form-control {{ $errors->has('client_name') ? 'form-control-danger' : '' }}"
                                                name="client_name" type="text" value="{{ old('client_name') }}"
                                                placeholder="Enter client name">
                                            @error('client_name')
                                            <div class="col-form-alert-label">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div> --}}
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 {{ $errors->has('name') ? 'has-danger' : '' }}">
                                            <label class="col-form-label">Customer Name*</label>
                                            <input
                                                class="form-control {{ $errors->has('name') ? 'form-control-danger' : '' }}"
                                                name="name" type="text" value="{{ $trips->name }}"
                                                placeholder="Enter name">
                                            @error('name')
                                            <div class="col-form-alert-label">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 {{ $errors->has('revenue') ? 'has-danger' : '' }}">
                                            <label class="col-form-label">Trip Cost (paid by client)*</label>
                                            <input
                                                class="form-control {{ $errors->has('revenue') ? 'form-control-danger' : '' }}"
                                                name="revenue" type="text" value="{{ $trips->revenue }}"
                                                placeholder="Enter revenue">
                                            @error('revenue')
                                            <div class="col-form-alert-label">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div
                                            class="form-group mb-3 {{ $errors->has('loading_location') ? 'has-danger' : '' }}">
                                            <label class="col-form-label">Loading Location*</label>
                                            <input
                                                class="form-control controls {{ $errors->has('loading_location') ? 'form-control-danger' : '' }}"
                                                name="loading_location" type="text"
                                                value="{{ old('loading_location', $trips['loading_location']) }}"
                                                 id="pac-input"
                                                placeholder="Enter loading location">
                                            @error('loading_location')
                                            <div class="col-form-alert-label">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                            <input type="hidden" name="lat" value="{{ $trips['lat']}}" id="lat"/>
                                            <input type="hidden" name="lng" value="{{ $trips['lng']}}" id="lng"/>
                                            <!--<div id="map"></div>-->
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div
                                            class="form-group mb-3 {{ $errors->has('offloading_location') ? 'has-danger' : '' }}">
                                            <label class="col-form-label">OffLoading Location*</label>
                                            <input
                                                class="form-control {{ $errors->has('offloading_location') ? 'form-control-danger' : '' }}"
                                                name="offloading_location" type="text"
                                                value="{{ old('offloading_location', $trips['offloading_location']) }}"
                                                 id="pac-input1"
                                                placeholder="Enter loading location">
                                            @error('offloading_location')
                                            <div class="col-form-alert-label">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                            <input type="hidden" name="offloading_location_lat" value="{{ $trips['offloading_location_lat'] }}" id="offloading_location_lat"/>
                                            <input type="hidden" name="offloading_location_lng" value="{{ $trips['offloading_location_lng'] }}" id="offloading_location_lng"/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div
                                            class="form-group mb-3 {{ $errors->has('start_date') ? 'has-danger' : '' }}">
                                            <label class="col-form-label">Start Date</label>
                                            <input
                                                class="form-control {{ $errors->has('start_date') ? 'form-control-danger' : '' }}"
                                                name="start_date" type="date" value="{{ $trips->start_date }}">
                                            @error('start_date')
                                            <div class="col-form-alert-label">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 {{ $errors->has('end_date') ? 'has-danger' : '' }}">
                                            <label class="col-form-label">End Date</label>
                                            <input
                                                class="form-control {{ $errors->has('end_date') ? 'form-control-danger' : '' }}"
                                                name="end_date" type="date" value="{{ $trips->end_date }}">
                                            @error('end_date')
                                            <div class="col-form-alert-label">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div
                                            class="form-group mb-3 {{ $errors->has('type_of_cargo') ? 'has-danger' : '' }}">
                                            <label class="col-form-label">Type of Cargo*</label>
                                            <input
                                                class="form-control {{ $errors->has('type_of_cargo') ? 'form-control-danger' : '' }}"
                                                name="type_of_cargo" type="text" value="{{ $trips->type_of_cargo }}"
                                                placeholder="Enter cargo type">
                                            @error('type_of_cargo')
                                            <div class="col-form-alert-label">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div
                                            class="form-group mb-3 {{ $errors->has('weight_of_cargo') ? 'has-danger' : '' }}">
                                            <label class="col-form-label">Weight of Cargo*</label>
                                            <input
                                                class="form-control {{ $errors->has('weight_of_cargo') ? 'form-control-danger' : '' }}"
                                                name="weight_of_cargo" type="text" value="{{ $trips->weight_of_cargo }}"
                                                placeholder="Enter cargo weight">
                                            @error('weight_of_cargo')
                                            <div class="col-form-alert-label">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div
                                            class="form-group mb-3 {{ $errors->has('initial_diesel') ? 'has-danger' : '' }}">
                                            <label class="col-form-label">Initial Diesel*</label>
                                            <input
                                                class="form-control {{ $errors->has('initial_diesel') ? 'form-control-danger' : '' }}"
                                                name="initial_diesel" type="text" value="{{ $trips->initial_diesel }}"
                                                placeholder="Enter initial diesel">
                                            @error('initial_diesel')
                                            <div class="col-form-alert-label">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="col-form-label">Mileage (allowance)*</label>
                                            <div class="row">
                                                <div class="col-2 pr-0"> 
                                                    <select class="form-control" id="mileage_currency" name="mileage_currency">
                                                        <option value="">Select</option>
                                                        @foreach($get_currency as $key => $value)
                                                        <option value="{{ $value['id']}}" {{ $value['id'] == $trips['mileage_allowance_currency'] ? 'selected' : '' }}>{{ $value['name']}}</option>
                                                        @endforeach
                                                    </select>
                                            </div>
                                            <div class="col-16 pl-0">
                                               <input placeholder="Enter Mileage Allowance" value="{{ $trips->mileage_allowance }}" class="form-control" name="mileage_allowance" type="text">
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="col-form-label">Movement Sheet</label>
                                            <div class="row">
                                                <div class="col-2 pr-0"> 
                                                    <select class="form-control" id="movement_sheet_currency" name="movement_sheet_currency">
                                                        <option value="">Select Currency</option>
                                                        @foreach($get_currency as $key => $value)
                                                        <option value="{{ $value['id']}}" {{ $value['id'] == $trips['movement_sheet_currency'] ? 'selected' : ''}}>{{ $value['name']}}</option>
                                                        @endforeach
                                                    </select>
                                            </div>
                                            <div class="col-16 pl-0">
                                               <input placeholder="Enter Amount" value="{{ $trips->movement_sheet }}" class="form-control" name="movement_sheet" type="text">
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="col-form-label">Road Toll</label>
                                            <div class="row">
                                                <div class="col-2 pr-0"> 
                                                    <select class="form-control" id="road_toll_currency" name="road_toll_currency">
                                                        <option value="">Select Currency</option>
                                                        @foreach($get_currency as $key => $value)
                                                        <option value="{{ $value['id']}}" {{ $value['id'] == $trips['road_toll_currency'] ? 'selected' : ''}}>{{ $value['name']}}</option>
                                                        @endforeach
                                                    </select>
                                            </div>
                                            <div class="col-16 pl-0">
                                               <input placeholder="Enter Road Toll" value="{{ $trips->road_toll }}" class="form-control" name="road_toll" type="text" value="">
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row align-items-end">
                                    <div class="col-md-5">
                                        <div class="form-group mb-3 {{ $errors->has('truck') ? 'has-danger' : '' }}">
                                            <label class="col-form-label">Select Truck*</label>
                                            <select class="form-control" id="truck" name="truck">
                                                <option value="">Select Truck</option>
                                                @foreach($get_trucks as $key => $trucks)
                                                <option value="{{ $trucks['id']}}" {{ $trucks['id'] == $trips['truck_id'] ? 'selected' : ''}}>{{ $trucks['brand'].' - '.$trucks['plate_number']}}</option>
                                                @endforeach
                                            </select>
                                            @error('truck')
                                            <div class="col-form-alert-label">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group mb-3 {{ $errors->has('driver') ? 'has-danger' : '' }}">
                                            <label class="col-form-label">{{('Driver')}}*</label>
                                            <select class="form-control" id="driver" name="driver">
                                                <option value="">Select Driver</option>
                                                @foreach($get_drivers as $driver)
                                                   <option value="{{ $driver['id']}}" {{ $driver['id'] == $trips['driver_id'] ? 'selected' : ''}}>{{ $driver['first_name']}} {{ $driver['last_name']}}</option>
                                                @endforeach
                                            </select>
                                            @error('driver')
                                            <div class="col-form-alert-label">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                   
                                </div>
                                
                                <main>
                                    
                                </main>
                                <div class="card-footer"> <button type="submit"
                                        class="btn btn-primary">{{$common['button']}}</button> </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>


<script src="https://maps.google.com/maps/api/js?key=AIzaSyB5hhlYpfzytLFmZM7H5iw6fvsrWIA_PtY&libraries=places&callback=initAutocomplete" type="text/javascript"></script>

<script type="text/javascript">

   google.maps.event.addDomListener(window, 'load', initialize);

       function initialize() {
           var input = document.getElementById('pac-input');
           var autocomplete = new google.maps.places.Autocomplete(input);
           autocomplete.addListener('place_changed', function() {
               var place = autocomplete.getPlace();
              $('#lat').val(place.geometry['location'].lat());
              $('#lng').val(place.geometry['location'].lng());

            // --------- show lat and long ---------------
            //   $("#lat_area").removeClass("d-none");
            //   $("#long_area").removeClass("d-none");
           });
       }
</script>



<script type="text/javascript">

   google.maps.event.addDomListener(window, 'load', initialize);

   function initialize() {
           var input = document.getElementById('pac-input1');
           var autocomplete = new google.maps.places.Autocomplete(input);
           autocomplete.addListener('place_changed', function() {
               var place = autocomplete.getPlace();
              $('#offloading_location_lat').val(place.geometry['location'].lat());
              $('#offloading_location_lng').val(place.geometry['location'].lng());

            // --------- show lat and long ---------------
            //   $("#lat_area").removeClass("d-none");
            //   $("#long_area").removeClass("d-none");
           });
       }
</script>




<script>
$(document).ready(function(){
    $('#addmorebtn').click(function(){
        $('main').append('<div class="align-items-end myparent row"><div class=col-md-5><div class="form-group mb-3"><label class=col-form-label>Select Truck*</label> <select class=form-control id=truck name=truck[]><option value="">Select Truck</option>@foreach($get_trucks as $key => $trucks)<option value="{{ $trucks["id"]}}">{{ $trucks["brand"]}}</option>@endforeach</select></div></div><div class=col-md-5><div class="form-group mb-3"><label class=col-form-label>Driver*</label> <select class=form-control id=driver name=driver[]><option value="">Select Driver</option>@foreach($get_drivers as $driver)<option value="{{ $driver["id"]}}">{{ $driver["first_name"]}} {{ $driver["last_name"]}}</option>@endforeach</select></div></div><div class=col-md-2><div class="form-group mb-3"><button class="btn btn-danger deleterow"type=button>Delete</button></div></div></div>');  
    })
    $(document).on('click', '.deleterow', function(){
        $(this).parent().parent().parent().remove();
    });
});
</script>
 <script>
//   function initAutocomplete() {
//   const map = new google.maps.Map(document.getElementById("map"), {
//     center: { lat: -33.8688, lng: 151.2195 },
//     zoom: 13,
//     mapTypeId: "roadmap",
//   });
//   // Create the search box and link it to the UI element.
//   const input = document.getElementById("pac-input");
//   const searchBox = new google.maps.places.SearchBox(input);

//   map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
//   // Bias the SearchBox results towards current map's viewport.
//   map.addListener("bounds_changed", () => {
//     searchBox.setBounds(map.getBounds());
//   });

//   let markers = [];

//   // Listen for the event fired when the user selects a prediction and retrieve
//   // more details for that place.
//   searchBox.addListener("places_changed", () => {
//     const places = searchBox.getPlaces();

//     if (places.length == 0) {
//       return;
//     }

//     // Clear out the old markers.
//     markers.forEach((marker) => {
//       marker.setMap(null);
//     });
//     markers = [];

//     // For each place, get the icon, name and location.
//     const bounds = new google.maps.LatLngBounds();

//     places.forEach((place) => {
//       if (!place.geometry || !place.geometry.location) {
//         console.log("Returned place contains no geometry");
//         return;
//       }

//       const icon = {
//         url: place.icon,
//         size: new google.maps.Size(71, 71),
//         origin: new google.maps.Point(0, 0),
//         anchor: new google.maps.Point(17, 34),
//         scaledSize: new google.maps.Size(25, 25),
//       };

//       // Create a marker for each place.
//       markers.push(
//         new google.maps.Marker({
//           map,
//           icon,
//           title: place.name,
//           position: place.geometry.location,
//         }),
//       );
//       if (place.geometry.viewport) {
//         // Only geocodes have viewport.
//         bounds.union(place.geometry.viewport);
//       } else {
//         bounds.extend(place.geometry.location);
//       }
//     });
//     map.fitBounds(bounds);
//   });
// }

</script>

