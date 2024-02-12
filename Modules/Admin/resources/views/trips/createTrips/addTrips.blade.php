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
                                <a href="{{ url('admin/trips')}}">
                                    <button onClick="back();"
                                        class="btn btn-primary waves-effect waves-light f-right d-inline-block md-trigger"
                                        data-modal="modal-13" style="float: right"> <i
                                            class="fa-solid fa-backward"></i>&nbsp;&nbsp; Back
                                    </button>
                                </a>
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
                                                name="name" type="text" value="{{ old('name') }}"
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
                                                name="revenue" type="text" value="{{ old('revenue') }}"
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
                                                class="form-control {{ $errors->has('loading_location') ? 'form-control-danger' : '' }}"
                                                name="loading_location" type="text"
                                                value="{{ old('loading_location') }}"
                                                placeholder="Enter loading location">
                                            @error('loading_location')
                                            <div class="col-form-alert-label">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div
                                            class="form-group mb-3 {{ $errors->has('offloading_location') ? 'has-danger' : '' }}">
                                            <label class="col-form-label">OffLoading Location*</label>
                                            <input
                                                class="form-control {{ $errors->has('offloading_location') ? 'form-control-danger' : '' }}"
                                                name="offloading_location" type="text"
                                                value="{{ old('offloading_location') }}"
                                                placeholder="Enter loading location">
                                            @error('offloading_location')
                                            <div class="col-form-alert-label">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div
                                            class="form-group mb-3 {{ $errors->has('start_date') ? 'has-danger' : '' }}">
                                            <label class="col-form-label">Start Date</label>
                                            <input
                                                class="form-control {{ $errors->has('start_date') ? 'form-control-danger' : '' }}"
                                                name="start_date" type="date" value="{{ old('start_date') }}">
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
                                                name="end_date" type="date" value="{{ old('end_date') }}">
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
                                                name="type_of_cargo" type="text" value="{{ old('type_of_cargo') }}"
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
                                                name="weight_of_cargo" type="text" value="{{ old('weight_of_cargo') }}"
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
                                                name="initial_diesel" type="text" value="{{ old('initial_diesel') }}"
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
                                                        <option value="{{ $value['id']}}">{{ $value['name']}}</option>
                                                        @endforeach
                                                    </select>
                                            </div>
                                                <div class="col-16 pl-0">
                                            <input placeholder="Enter Mileage Allowance" value="{{ old('mileage_allowance') }}" class="form-control" name="mileage_allowance" type="text" value="">
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
                                                        <option value="{{ $value['id']}}">{{ $value['name']}}</option>
                                                        @endforeach
                                                    </select>
                                            </div>
                                                <div class="col-16 pl-0">
                                            <input placeholder="Enter Amount" value="{{ old('movement_sheet') }}" class="form-control" name="movement_sheet" type="text" value="">
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
                                                        <option value="{{ $value['id']}}">{{ $value['name']}}</option>
                                                        @endforeach
                                                    </select>
                                            </div>
                                                <div class="col-16 pl-0">
                                            <input placeholder="Enter Road Toll" value="{{ old('road_toll') }}" class="form-control" name="road_toll" type="text" value="">
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row align-items-end">
                                    <div class="col-md-5">
                                        <div class="form-group mb-3 {{ $errors->has('truck') ? 'has-danger' : '' }}">
                                            <label class="col-form-label">Select Truck*</label>
                                            <select class="form-control" id="truck" name="truck[]">
                                                <option value="">Select Truck</option>
                                                @foreach($get_trucks as $key => $trucks)
                                                <option value="{{ $trucks['id']}}">{{ $trucks['brand']}}</option>
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
                                            <select class="form-control" id="driver" name="driver[]">
                                                <option value="">Select Driver</option>
                                                @foreach($get_drivers as $driver)
                                                   <option value="{{ $driver['id']}}">{{ $driver['first_name']}} {{ $driver['last_name']}}</option>
                                                @endforeach
                                            </select>
                                            @error('driver')
                                            <div class="col-form-alert-label">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group mb-3 ">
                                            <button class="btn btn-primary" type="button" id="addmorebtn"> Add More </button>
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
<script>
$(document).ready(function(){
    $('#addmorebtn').click(function(){
        $('main').append('<div class="align-items-end myparent row"><div class=col-md-5><div class="form-group mb-3"><label class=col-form-label>Select Truck*</label> <select class=form-control id=truck name=truck[]><option value="">Select Truck</option>@foreach($get_trucks as $key => $trucks)<option value="{{ $trucks["id"]}}">{{ $trucks["brand"]}}</option>@endforeach</select></div></div><div class=col-md-5><div class="form-group mb-3"><label class=col-form-label>Driver*</label> <select class=form-control id=driver name=driver[]><option value="">Select Driver</option>@foreach($get_drivers as $driver)<option value="{{ $driver["id"]}}">{{ $driver["first_name"]}} {{ $driver["last_name"]}}</option>@endforeach</select></div></div><div class=col-md-2><div class="form-group mb-3"><button class="btn btn-danger deleterow"type=button>Delete</button></div></div></div>');        
    });
    $(document).on('click', '.deleterow', function(){
        $(this).parent().parent().parent().remove();
    });
});
</script>
