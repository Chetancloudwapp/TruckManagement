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
                            <!--<a href="{{ url('admin/truck')}}">-->
                            <!--    <button onClick="back();"-->
                            <!--        class="btn btn-primary waves-effect waves-light f-right d-inline-block md-trigger"-->
                            <!--        data-modal="modal-13" style="float: right"> <i class="fa-solid fa-backward"></i>&nbsp;&nbsp; Back-->
                            <!--    </button>-->
                            <!--</a>-->
                            </h3>
                        </div>
                        <div class="card-body">
                            <form name="TruckDetailForm" id="main" 
                            method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3 {{ $errors->has('brand') ? 'has-danger' : '' }}">
                                        <label class="col-form-label">Brand*</label>
                                        <input
                                            class="form-control {{ $errors->has('brand') ? 'form-control-danger' : '' }}"
                                            name="brand" type="text"
                                            value="{{ old('brand') }}" placeholder="Enter brand">      
                                        @error('brand')
                                            <div class="col-form-alert-label">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3 {{ $errors->has('modal') ? 'has-danger' : '' }}">
                                        <label class="col-form-label">Modal*</label>
                                        <input
                                            class="form-control {{ $errors->has('modal') ? 'form-control-danger' : '' }}"
                                            name="modal" type="text"
                                            value="{{ old('modal') }}" placeholder="Enter modal">      
                                        @error('modal')
                                            <div class="col-form-alert-label">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3 {{ $errors->has('km_driven') ? 'has-danger' : '' }}">
                                        <label class="col-form-label">Km Driven*</label>
                                        <input
                                            class="form-control {{ $errors->has('km_driven') ? 'form-control-danger' : '' }}"
                                            name="km_driven" type="text"
                                            value="{{ old('km_driven') }}" placeholder="Enter km driven">      
                                        @error('km_driven')
                                            <div class="col-form-alert-label">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3 {{ $errors->has('next_oil_change') ? 'has-danger' : '' }}">
                                        <label class="col-form-label">Next oil Change (in Km's)*</label>
                                        <input
                                            class="form-control {{ $errors->has('next_oil_change') ? 'form-control-danger' : '' }}"
                                            name="next_oil_change" type="text"
                                            value="{{ old('next_oil_change') }}" placeholder="Enter km driven">      
                                        @error('next_oil_change')
                                            <div class="col-form-alert-label">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3 {{ $errors->has('year') ? 'has-danger' : '' }}">
                                        <label class="col-form-label">Year*</label>
                                        <input
                                            class="form-control {{ $errors->has('year') ? 'form-control-danger' : '' }}"
                                            name="year" type="text"
                                            value="{{ old('year') }}" placeholder="Enter year">      
                                        @error('year')
                                            <div class="col-form-alert-label">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3 {{ $errors->has('plate_number') ? 'has-danger' : '' }}">
                                        <label class="col-form-label">Plate Number*</label>
                                        <input
                                            class="form-control {{ $errors->has('plate_number') ? 'form-control-danger' : '' }}"
                                            name="plate_number" type="text"
                                            value="{{ old('plate_number') }}" placeholder="Enter plate number">      
                                        @error('plate_number')
                                            <div class="col-form-alert-label">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3 {{ $errors->has('status') ? 'has-danger' : '' }}">
                                        <label class="col-form-label">Status</label>
                                        <select id="status" name="status" class="form-control stock">
                                            <option value="Active">Active</option>
                                            <option value="Deactive">Deactive</option>
                                            {{-- <option value="Reject">Reject</option> --}}
                                            {{-- <option value="Deactive"
                                                {{ $news['status'] == 'Deactive' ? 'selected' : '' }}>Deactive
                                            </option> --}}
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

