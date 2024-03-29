@extends('admin::layouts.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{$common['title']}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">{{$common['title']}}</li>
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
                            @if(Session::has('success_message'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Success:</strong> {{ Session::get('success_message')}}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @endif
                            <h3 class="card-title nofloat"> <span>{{$common['title']}}</span>
                            </h3>
                        </div>
                        <div class="card-body">
                            <table id="categories" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Name</th>
                                        <th>Loading Location</th>
                                        <th>OffLoading Location</th>
                                        <th>Start Date</th>
                                        <th>Truck/Driver</th>
                                        <th>Revenue</th>
                                        <th>status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($get_pending_trips as $key => $pending_trips)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $pending_trips['name'] }}</td>
                                        <td>{{ $pending_trips['loading_location'] }}</td>
                                        <td>{{ $pending_trips['offloading_location'] }}</td>
                                        <td>{{ date("Y-m-d",strtotime($pending_trips['start_date'])) }}</td>
                                        <td>
                                            <?php 
                                            $get_data = Modules\Admin\app\Models\TruckDriver::where(['trip_id' =>$pending_trips['id']])->first();
                                            if(!empty($get_data)){
                                                $get_truck_name = Modules\Admin\app\Models\Truck::where(['id'=>$get_data->truck_id])->select('id','brand')->first();
                                                if(!empty($get_truck_name)){
                                                    echo $get_truck_name->brand;
                                                }else{
                                                    echo "-";
                                                }
                                            }else{
                                                "-";
                                            }
                                            ?>
                                        </td>
                                        <td>{{ $pending_trips['revenue'] }}</td>
                                        <td>
                                            @if($pending_trips['status'] == "Pending")
                                                <span class="badge badge-pill badge-warning">{{ $pending_trips['status'] }}</span>
                                            @else
                                                <span class="badge badge-pill badge-success">{{ $pending_trips['status'] }}</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ url('admin/pending-trips/view/'. encrypt($pending_trips['id'])) }}"> 
                                               <i class="fa-solid fa-eye"></i> 
                                            </a>
                                            
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $(document).on('click', ".confirmDelete", function(){
           var record = $(this).attr('record');
           var record_id = $(this).attr('record_id');
           Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
                )

                root = "{{ config('app.url') }}"
                window.location.href = root + "/admin/"+record+"/"+record_id;
            }
            });
        });
    });
</script>
@endsection