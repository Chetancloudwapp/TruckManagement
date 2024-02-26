@extends('admin::layouts.master')
@section('content')
<style>
   .nav-tabs {
   border-bottom: none;
   margin-bottom: 5px;
   }
   .nav-tabs li{
   margin-right: 5px;
   }
   .nav-tabs li a {
   padding: 8px 15px;
   border: 1px solid #dfdfdf;
   display: block;
   background: #fff;
   border-radius: 5px;
   color: #222;
   }
   .nav-tabs li.active a{
   background: #13a6e9 !important;
   color: #fff !important;
   }
</style>
<div class="content-wrapper">
   <section class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               <h1></h1>
            </div>
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active"></li>
               </ol>
            </div>
         </div>
      </div>
   </section>
   <section class="content">
      <div class="container-fluid">
         <div class="row">
            <div class="col-md-12">
               @csrf
               @if ($message = Session::get('success'))
               <div class="alert alert-success">
                  <strong>{{ $message }}</strong>
               </div>
               @endif
               @if (count($errors) > 0)
               <div class="alert alert-danger">
                  <ul>
                     @foreach ($errors->all() as $error)
                     <li>{{ $error }}</li>
                     @endforeach
                  </ul>
               </div>
               @endif
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#general_trip_report">General Trip Report</a></li>
                    <li><a data-toggle="tab" href="#trip_expenses">Trip Expenses</a></li>
                    <li><a data-toggle="tab" href="#office_expenses">Office Expenses</a></li>
                    <li><a data-toggle="tab" href="#monthly_expenses">Monthly Expenses</a></li>
                </ul>
                <div class="tab-content">
                    <div id="general_trip_report" class="tab-pane in active">
                       <form action="{{url('admin/trip-expense-export')}}">
                           <input type="hidden" name="general_report" value="general_report"/>
                            <div class="card">
                            <div class="card-body">
                                <div class="row">
                                <div class="col-md-6">
                                    <div
                                        class="form-group mb-3 {{ $errors->has('start_date') ? 'has-danger' : '' }}">
                                        <label class="col-form-label">Start Date</label>
                                        <input
                                            class="form-control {{ $errors->has('start_date') ? 'form-control-danger' : '' }}"
                                            name="start_date" type="date" value="{{ old('start_date') }}" required>
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
                                            name="end_date" type="date" value="{{ old('end_date') }}" required>
                                        @error('end_date')
                                        <div class="col-form-alert-label">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <h3 class="card-title nofloat" > 
                                <span> 
                                    <button type="submit" class="btn btn-block btn-primary">Export Trip Report</button>
                                </span>
                            </h3>
                            <div>
                            </div>
                            </div>
                        </div>
                       </form>
                    </div>
                    <div id="trip_expenses" class="tab-pane">
                        <form action="{{url('admin/trip-expense-export')}}">
                        <input type="hidden" name="general_report" value="trip_expenses"/>
                        <div class="card">
                            <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div
                                        class="form-group mb-3 {{ $errors->has('start_date') ? 'has-danger' : '' }}">
                                        <label class="col-form-label">Start Date</label>
                                        <input
                                            class="form-control {{ $errors->has('start_date') ? 'form-control-danger' : '' }}"
                                            name="start_date" type="date" value="{{ old('start_date') }}" required>
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
                                            name="end_date" type="date" value="{{ old('end_date') }}" required>
                                        @error('end_date')
                                        <div class="col-form-alert-label">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <h3 class="card-title nofloat" > 
                                    <span> 
                                        <!--<a href="{{ url('admin/trip-expense-export')}}"> -->
                                        <button type="submit" class="btn btn-block btn-primary">Export Trip Expense</button>
                                        <!--</a> -->
                                    </span>
                                </h3>
                            </div>
                        </div>
                        </form>
                    </div>
                    <div id="office_expenses" class="tab-pane">
                        <form action="{{url('admin/trip-expense-export')}}">
                        <input type="hidden" name="general_report" value="office_expenses"/>
                        <div class="card">
                            <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div
                                        class="form-group mb-3 {{ $errors->has('start_date') ? 'has-danger' : '' }}">
                                        <label class="col-form-label">Start Date</label>
                                        <input
                                            class="form-control {{ $errors->has('start_date') ? 'form-control-danger' : '' }}"
                                            name="start_date" type="date" value="{{ old('start_date') }}" required>
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
                                            name="end_date" type="date" value="{{ old('end_date') }}" required>
                                        @error('end_date')
                                        <div class="col-form-alert-label">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                                <h3 class="card-title nofloat" > 
                                    <span> 
                                        <button type="submit" class="btn btn-block btn-primary">Export Office Expense</button>
                                    </span>
                                </h3>
                            </div>
                        </div>
                        </form>
                    </div>
                    <div id="monthly_expenses" class="tab-pane">
                        <form action="{{url('admin/trip-expense-export')}}">
                        <input type="hidden" name="general_report" value="monthly_expenses"/>
                        <div class="card">
                            <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div
                                        class="form-group mb-3 {{ $errors->has('start_date') ? 'has-danger' : '' }}">
                                        <label class="col-form-label">Start Date</label>
                                        <input
                                            class="form-control {{ $errors->has('start_date') ? 'form-control-danger' : '' }}"
                                            name="start_date" type="date" value="{{ old('start_date') }}" required>
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
                                            name="end_date" type="date" value="{{ old('end_date') }}" required>
                                        @error('end_date')
                                        <div class="col-form-alert-label">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <h3 class="card-title nofloat" > 
                                <span> 
                                    <button type="submit" class="btn btn-block btn-primary">Export Monthly Expense</button>
                                </span>
                            </h3>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
         </div>
      </div>
   </section>
</div>
@endsection