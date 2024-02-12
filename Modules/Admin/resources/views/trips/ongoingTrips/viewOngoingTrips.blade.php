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
                    <li class="active"><a data-toggle="tab" href="#basic_detail">Basic detail</a></li>
                    <li><a data-toggle="tab" href="#addon_diesel">Addon diesel</a></li>
                    <li><a data-toggle="tab" href="#enroute_diesel">Enroute Diesel</a></li>
                    <li><a data-toggle="tab" href="#toll">Toll</a></li>
                    <li><a data-toggle="tab" href="#repair">Repair</a></li>
                    <li><a data-toggle="tab" href="#fines">Fines</a></li>
                    <li><a data-toggle="tab" href="#road_accidents">Road Accidents</a></li>
                    <li><a data-toggle="tab" href="#other_charges">Other charges</a></li>
                    @if($get_trip['is_status'] == 'Delivered')
                      <li><a data-toggle="tab" href="#delivery_note">Delivery Note</a></li>
                    @endif
                </ul>
                <div class="tab-content">
                    <div id="basic_detail" class="tab-pane in active">
                        <div class="card">
                            <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <h6> {{ $get_trip->name }}</h6>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="startDate">Start Date</label>
                                        <h6>{{ date('Y-m-d', strtotime($get_trip->start_date)) }}</h6>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="endDate">End Date</label>
                                        <h6>{{ date('Y-m-d', strtotime($get_trip->end_date)) }}</h6>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="revenue">Revenue</label>
                                        <h6> {{ $get_trip->revenue}}</h6>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="TypeOfCargo">Type of Cargo</label>
                                        <h6> {{ $get_trip->type_of_cargo}}</h6>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="WeightOfCargo">Weight of Cargo</label>
                                        <h6> {{ $get_trip->weight_of_cargo}}</h6>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="InitialDiesel">Initial Diesel</label>
                                        <h6> {{ $get_trip->initial_diesel}}</h6>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <h6> {{ $get_trip->is_status}}</h6>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                    <label for="mileage_allowance">Mileage Allowance</label>
                                    <h6> {{ $get_trip->mileage_allowance}} {{ $get_trip->mac->name ?? '-'}}</h6>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                    <label for="movement_sheet">Movement Sheet</label>
                                    <h6> {{ $get_trip->movement_sheet}} {{ $get_trip->msc->name ?? '-'}}</h6>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                    <label for="movement_sheet">Road Toll</label>
                                    <h6> {{ $get_trip->road_toll}} {{ $get_trip->rtc->name ?? '-'}}</h6>
                                    </div>
                                </div>
                            </div>
                            {{--
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Image </label>
                                        <section class="uploadImg">
                                        <img src="{{ $get_users->image !='' ? asset('uploads/userimage/'. $get_users->image) : asset('uploads/placeholder/default_user.png') }}" width="150px" height="150px" style="border-radius:50%;">
                                        </section>
                                    </div>
                                </div>
                            </div>
                            --}}
                            </div>
                        </div>
                    </div>
                    <div id="addon_diesel" class="tab-pane">
                        <div class="card">
                            <div class="card-body">
                            <table id="addOnDiesel" class="table table-bordered">
                                <tr>
                                    <th><label for="status">Image</label></th>
                                    <th><label for="status">Quantity in litre</label></th>
                                    <th><label for="status">Unit Price</label></th>
                                    <th><label for="status">Petrol Station</label></th>
                                </tr>
                                @foreach($get_trip->add_on_diesels as $diesel)
                                <tr>
                                    <td>
                                        <img class="tbl-img-css rounded-circle" width="60px" height="60px" style="border-radius:50%;"
                                            src="{{ $diesel['petrol_station_image'] }}">
                                    </td>
                                    <td>
                                        <span> {{ $diesel->quantity_in_litres ?? '-'}}</span>
                                    </td>
                                    <td>
                                        <span> {{ $diesel->unit_price ?? '-'}}</span>
                                    </td>
                                    <td>
                                        <span> {{ $diesel->petrol_station ?? '-'}}</span> 
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                            </div>
                        </div>
                    </div>
                    <div id="enroute_diesel" class="tab-pane">
                        <div class="card">
                            <div class="card-body">
                            <table id="example" class="table table-bordered">
                                <tr>
                                    <th><label for="status">Image</label></th>
                                    <th><label for="status">Quantity in litre</label></th>
                                    <th><label for="status">Unit Price</label></th>
                                    <th><label for="status">Petrol Station</label></th>
                                </tr>
                                @foreach($get_trip->enroute_diesels as $en)
                                <tr>
                                    <td>
                                        <img class="tbl-img-css rounded-circle" width="60px" height="60px" style="border-radius:50%;"
                                        src="{{ $en['petrol_station_image'] }}">
                                    </td>
                                    <td>
                                        <span> {{ $en->quantity ?? '-'}}</span>
                                    </td>
                                    <td>
                                        <span> {{ $en->unit_price ?? '-'}}</span>
                                    </td>
                                    <td>
                                        <span> {{ $en->petrol_station ?? '-'}}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                            </div>
                        </div>
                    </div>
                    <div id="toll" class="tab-pane">
                        <div class="card">
                            <div class="card-body">
                            <table id="example" class="table table-bordered">
                                <tr>
                                    <th><label for="image">Image</label></th>
                                    <th><label for="toll_name">toll name</label></th>
                                    <th><label for="amount">Amount</label></th>
                                </tr>
                                @foreach($get_trip->tolls as $toll)
                                <tr>
                                    <td>
                                        <img class="tbl-img-css rounded-circle" width="60px" height="60px" style="border-radius:50%;"
                                        src="{{ $toll['toll_image'] }}">
                                    </td>
                                    <td>
                                        <span> {{ $toll->toll_name ?? '-'}}</span>
                                    </td>
                                    <td>
                                        <span> {{ $toll->amount ?? '-'}}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                            </div>
                        </div>
                    </div>
                    <div id="repair" class="tab-pane">
                        <div class="card">
                            <div class="card-body">
                            <table id="example" class="table table-bordered">
                                <tr>
                                    <th><label for="image">Image</label></th>
                                    <th><label for="shop_name">shop name</label></th>
                                    <th><label for="repair_name">repair name</label></th>
                                    <th><label for="repair_cost">repair cost</label></th>
                                    <th><label for="spare_name">spare name</label></th>
                                    <th><label for="spare_cost">spare cost</label></th>
                                    <th><label for="total_amount">total amount</label></th>
                                </tr>
                                @foreach($get_trip->repairs as $repair)
                                <tr>
                                    <td>
                                        <img class="tbl-img-css rounded-circle" width="60px" height="60px" style="border-radius:50%;"
                                        src="{{ $repair['upload_bill'] }}">
                                    </td>
                                    <td>
                                        <span> {{ $repair->shop_name ?? '-'}}</span>
                                    </td>
                                    <td>
                                        <span> {{ $repair->repair_name ?? '-'}}</span>
                                    </td>
                                    <td>
                                        <span> {{ $repair->repair_cost ?? '-'}}</span>
                                    </td>
                                    <td>
                                        <span> {{ $repair->spare_name ?? '-'}}</span>
                                    </td>
                                    <td>
                                        <span> {{ $repair->spare_cost ?? '-'}}</span>
                                    </td>
                                    <td>
                                        <span> {{ $repair->total_amount ?? '-'}}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                            </div>
                        </div>
                    </div>
                    <div id="fines" class="tab-pane">
                        <div class="card">
                            <div class="card-body">
                            <table id="example" class="table table-bordered">
                                <tr>
                                    <th><label for="image">Image</label></th>
                                    <th><label for="fine">Fine Name</label></th>
                                    <th><label for="amount">Amount</label></th>
                                    <th><label for="description">Description</label></th>
                                </tr>
                                @foreach($get_trip->fines as $fine)
                                <tr>
                                    <td>
                                        <img class="tbl-img-css rounded-circle" width="60px" height="60px" style="border-radius:50%;"
                                        src="{{ $fine['image'] }}">
                                    </td>
                                    <td>
                                        <span> {{ $fine->name ?? '-'}}</span>
                                    </td>
                                    <td>
                                        <span> {{ $fine->amount ?? '-'}}</span>
                                    </td>
                                    <td>
                                        <span> {{ $fine->description ?? '-'}}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                            </div>
                        </div>
                    </div>
                    <div id="road_accidents" class="tab-pane">
                        <div class="card">
                            <div class="card-body">
                            <table id="example" class="table table-bordered">
                                <tr>
                                    <th><label for="image">Image</label></th>
                                    <th><label for="accident_type">Accident Type </label></th>
                                    <th><label for="cost">Cost</label></th>
                                    <th><label for="description">description</label></th>
                                </tr>
                                @foreach($get_trip->road_accidents as $road)
                                <tr>
                                    <td>
                                        <img class="tbl-img-css rounded-circle" width="60px" height="60px" style="border-radius:50%;"
                                        src="{{ $road['image'] }}">
                                    </td>
                                    <td>
                                        <span> {{ $road->accident_category ?? '-'}}</span>
                                    </td>
                                    <td>
                                        <span> {{ $road->cost ?? '-'}}</span>
                                    </td>
                                    <td>
                                        <span> {{ $road->description ?? '-'}}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                            </div>
                        </div>
                    </div>
                    <div id="other_charges" class="tab-pane">
                        <div class="card">
                            <div class="card-body">
                            <table id="example" class="table table-bordered">
                                <tr>
                                    <th><label for="image">Image</label></th>
                                    <th><label for="name">Name</label></th>
                                    <th><label for="amount">Amount</label></th>
                                    <th><label for="description">Description</label></th>
                                </tr>
                                @foreach($get_trip->other_charges as $other)
                                <tr>
                                    <td>
                                        <img class="tbl-img-css rounded-circle" width="60px" height="60px" style="border-radius:50%;"
                                        src="{{ $other['image'] }}">
                                    </td>
                                    <td>
                                        <span> {{ $other->name ?? '-'}}</span>
                                    </td>
                                    <td>
                                        <span> {{ $other->amount ?? '-'}}</span>
                                    </td>
                                    <td>
                                        <span> {{ $other->description ?? '-'}}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                            </div>
                        </div>
                    </div>
                    @if($get_trip['is_status'] == 'Delivered')
                    <div id="delivery_note" class="tab-pane">
                        <div class="card">
                            <div class="card-body">
                            <table id="example" class="table table-bordered">
                                <tr>
                                    <th><label for="image">Image</label></th>
                                    <th><label for="delivery_note">Delivery Note</label></th>
                                </tr>
                                @foreach($get_trip->delivery_note as $dn)
                                <tr>
                                    <td>
                                        <img class="tbl-img-css rounded-circle" width="60px" height="60px" style="border-radius:50%;"
                                        src="{{ $dn['image'] }}">
                                    </td>
                                    <td>
                                        <span> {{ $dn->delivery_note ?? '-'}}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
               <div class="card">
                   <div class="card-body">
                       <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d253568.15165262626!2d39.08947394491976!3d-6.76956345134875!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x185c4bae169bd6f1%3A0x940f6b26a086a1dd!2sDar%20es%20Salaam%2C%20Tanzania!5e0!3m2!1sen!2sin!4v1707311498814!5m2!1sen!2sin"  style="width: 100%; height: 250px" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                   </div>
               </div>
               
            </div>
         </div>
      </div>
   </section>
</div>
@endsection