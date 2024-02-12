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
                            <!--<a href="{{ url('admin/drivers')}}">-->
                            <!--    <button onClick="back();"-->
                            <!--        class="btn btn-primary waves-effect waves-light f-right d-inline-block md-trigger"-->
                            <!--        data-modal="modal-13" style="float: right"> <i class="fa-solid fa-backward"></i>&nbsp;&nbsp; Back-->
                            <!--    </button>-->
                            <!--</a>-->
                            </h3>
                        </div>
                        <div class="card-body">
                            <form name="DriversDetailForm" id="main" 
                            method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3 {{ $errors->has('first_name') ? 'has-danger' : '' }}">
                                        <label class="col-form-label">First Name*</label>
                                        <input
                                            class="form-control {{ $errors->has('first_name') ? 'form-control-danger' : '' }}"
                                            name="first_name" type="text"
                                            value="{{ old('first_name', $drivers['first_name']) }}" placeholder="Enter first name">      
                                        @error('first_name')
                                            <div class="col-form-alert-label">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3 {{ $errors->has('last_name') ? 'has-danger' : '' }}">
                                        <label class="col-form-label">Last Name*</label>
                                        <input
                                            class="form-control {{ $errors->has('last_name') ? 'form-control-danger' : '' }}"
                                            name="last_name" type="text"
                                            value="{{ old('last_name', $drivers['last_name']) }}" placeholder="Enter last name">      
                                        @error('last_name')
                                            <div class="col-form-alert-label">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3 {{ $errors->has('email') ? 'has-danger' : '' }}">
                                        <label class="col-form-label">Email*</label>
                                        <input
                                            class="form-control {{ $errors->has('email') ? 'form-control-danger' : '' }}"
                                            name="email" type="text"
                                            value="{{ old('email', $drivers['email']) }}" placeholder="Enter email">      
                                        @error('email')
                                            <div class="col-form-alert-label">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3 {{ $errors->has('phone_number') ? 'has-danger' : '' }}">
                                        <label class="col-form-label">Phone Number (with country code)*</label>
                                        <input
                                            class="form-control {{ $errors->has('phone_number') ? 'form-control-danger' : '' }}"
                                            name="phone_number" type="text"
                                            value="{{ old('phone_number', $drivers['phone_number']) }}" placeholder="+91- XXXXXXXXXX">      
                                        @error('phone_number')
                                            <div class="col-form-alert-label">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                {{--<div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="col-form-label">Phone Number</label>
                                        <div class="row">
                                            <div class="col-2 pr-0"> 
                                                <select class="form-control" name="country_code" id="country_code">
                                                    <option value="91">+91</option>
                                                    @foreach($get_countries as $value)
                                                        <option value="{{ $value['phonecode']}}">{{ $value['phonecode']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-16 pl-0">
                                               <input placeholder="Enter Phone number" value="{{ old('phone_number', $drivers['phone_number']) }}" class="form-control" name="phone_number" type="text" value="">
                                            </div>
                                        </div>
                                    </div>
                                </div>--}}
                                <div class="col-md-6">
                                    <div class="form-group mb-3 {{ $errors->has('image') ? 'has-danger' : '' }}">
                                        <label class="col-form-label">Image*</label>
                                        <input type="file"
                                            class="form-control {{ $errors->has('image') ? 'form-control-danger' : '' }}"
                                            onchange="loadFile(event,'image_1')" name="image">
                                        @error('image')
                                            <div class="col-form-alert-label">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="media-left">
                                        <a href="#" class="profile-image">
                                            <img class="user-img img-css" id="image_1" width="30%;"
                                                src="{{ $drivers['image'] !='' ? asset('public/uploads/drivers/' .$drivers['image']) : asset('uploads/placeholder/default_user.png') }}">
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3 {{ $errors->has('license') ? 'has-danger' : '' }}">
                                        <label class="col-form-label">License*</label>
                                        <input
                                            class="form-control {{ $errors->has('license') ? 'form-control-danger' : '' }}"
                                            name="license" type="text"
                                            value="{{ old('license', $drivers['license']) }}" placeholder="Enter license number">      
                                        @error('license')
                                            <div class="col-form-alert-label">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3 {{ $errors->has('national_id') ? 'has-danger' : '' }}">
                                        <label class="col-form-label">National ID*</label>
                                        <input
                                            class="form-control {{ $errors->has('national_id') ? 'form-control-danger' : '' }}"
                                            name="national_id" type="text"
                                            value="{{ old('national_id', $drivers['national_id']) }}" placeholder="Enter National Id">      
                                        @error('national_id')
                                            <div class="col-form-alert-label">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                {{-- <div class="col-md-6">
                                    <div class="form-group mb-3 {{ $errors->has('password') ? 'has-danger' : '' }}">
                                        <label class="col-form-label">{{('Password')}}*</label>
                                        <input
                                            class="form-control {{ $errors->has('password') ? 'form-control-danger' : '' }}"
                                            name="password" type="password" placeholder="Enter password">      
                                        @error('password')
                                            <div class="col-form-alert-label">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div> --}}
                                <div class="col-md-6">
                                    <div class="form-group mb-3 {{ $errors->has('status') ? 'has-danger' : '' }}">
                                        <label class="col-form-label">Status</label>
                                        <select id="status" name="status" class="form-control stock">
                                            <option value="Active">Active</option>
                                            {{-- <option value="Deactive">Deactive</option> --}}
                                            <option value="Deactive"
                                                {{ $drivers['status'] == 'Deactive' ? 'selected' : '' }}>Deactive
                                            </option>
                                        </select>
                                        @error('status')
                                            <div class="col-form-alert-label">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer" style="float:right"> <button type="submit" class="btn btn-primary">{{$common['button']}}</button> </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

