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
                                        <th>Truck Name/Driver Name</th>
                                        <th>Revenue</th>
                                        <th>status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($get_ongoing_trips as $key => $ongoing_trips)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $ongoing_trips['name'] }}</td>
                                        <td>{{ $ongoing_trips['loading_location'] }}</td>
                                        <td>{{ $ongoing_trips['offloading_location'] }}</td>
                                        <td>{{ date("Y-m-d",strtotime($ongoing_trips['start_date'])) }}</td>
                                        <td>
                                            <?php 
                                                $get_truck_name = Modules\Admin\app\Models\Truck::where(['id'=>$ongoing_trips->truck_id])->select('id','brand')->first();
                                                if(!empty($get_truck_name)){
                                                    $get_driver_name = App\Models\User::where(['id'=> $ongoing_trips->driver_id])->select('id','first_name','last_name')->first();
                                                    if(!empty($get_driver_name)){
                                                        echo $get_truck_name->brand .'/'. $get_driver_name->first_name .' '. $get_driver_name->last_name;
                                                    }else{
                                                        echo "-";
                                                    }
                                                }else{
                                                    echo "-";
                                                }
                                            ?>
                                        </td>
                                        <td>{{ $ongoing_trips['revenue'] }}</td>
                                        <td>
                                            @if($ongoing_trips['is_status'] == 'On the way')
                                              <span class="badge badge-pill badge-info">{{ $ongoing_trips['is_status'] }}</span>
                                              @else
                                              <span class="badge badge-pill badge-primary">{{ $ongoing_trips['is_status'] }}</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ url('admin/ongoing-trips-view/'. encrypt($ongoing_trips['id'])) }}"> 
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