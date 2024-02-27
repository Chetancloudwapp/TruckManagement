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
                                <span> 
                                    <a href="{{ url('admin/truck/add') }}"> <button type="button"
                                        class="btn btn-block btn-primary"><i
                                            class="fa-solid fa-plus"></i>&nbsp;&nbsp;Add Trucks</button>
                                    </a> 
                                </span>
                            </h3>
                        </div>
                        <div class="card-body">
                            <table id="categories" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Brand</th>
                                        <th>Modal</th>
                                        <th>Km Driven</th>
                                        <th>Next Oil Change Km</th>
                                        <th>Year</th>
                                        <th>Plate Number</th>
                                        <th>status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($trucks as $key => $truck)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $truck['brand'] }}</td>
                                        <td>{{ $truck['modal'] }}</td>
                                        <td>{{ $truck['km_driven'] }}</td>
                                        <td>{{ $truck['next_oil_change_km'] }}</td>
                                        <td>{{ $truck['year'] }}</td>
                                        <td>{{ $truck['plate_number'] }}</td>
                                        <td>
                                            @if($truck['status'] == 'Active')
                                               <span class="badge badge-pill badge-success">{{ $truck['status']}}</span>
                                            @else
                                               <span class="badge badge-pill badge-danger">{{ $truck['status'] }}</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ url('admin/truck/view/'. encrypt($truck['id'])) }}"> 
                                               <i class="fa-solid fa-eye"></i> 
                                            </a>
                                            @if($TruckPermission['edit_access'] == 1 || $TruckPermission['full_access']  == 1)
                                                <a href="{{ url('admin/truck/edit/'. encrypt($truck['id'])) }}"> 
                                                    <i class="fa-solid fa-pencil"></i>
                                                </a>
                                            @endif
                                            @if($TruckPermission['full_access'] == 1)
                                                <a href="javascript:void(0)" style="margin-left:0em" record="truck/delete"
                                                    record_id="{{ $truck['id'] }}" class="confirmDelete" name="truck"
                                                    title="Delete truck Page"> 
                                                    <i class="fa-solid fa-trash"></i>
                                                </a>
                                            @endif
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