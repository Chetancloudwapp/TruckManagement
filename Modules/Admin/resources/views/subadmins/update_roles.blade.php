@extends('admin::layouts.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Subadmin Roles</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Subadmin Roles</li>
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
                            <h3 class="card-title nofloat"> <span>Subadmin Roles </span></h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ url('admin/update-role/'.$subadminDetails->id)}}" name="SubadminsDetailForm" id="main" 
                            method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <input type="hidden" name="subadmin_id" value="{{ $subadminDetails->id }}">
                                @if(!empty($subadminRoles))
                                   @foreach($subadminRoles as $role)
                                     @if($role['module'] == 'trucks')
                                        @if($role['view_access'] == 1)
                                            @php $viewTrucks = "checked" @endphp
                                            @else
                                            @php $viewTrucks = "" @endphp
                                        @endif
                                        @if($role['edit_access'] == 1)
                                            @php $editTrucks = "checked" @endphp
                                            @else
                                            @php $editTrucks = "" @endphp
                                        @endif
                                        @if($role['full_access'] == 1)
                                            @php $fullTrucks = "checked" @endphp
                                            @else
                                            @php $fullTrucks = "" @endphp
                                        @endif
                                     @endif
                                   @endforeach
                                @endif
                                <div class="form-group col-md-12">
                                    <label for="trucks">Trucks: &nbsp;&nbsp;&nbsp;</label>
                                    <input type="checkbox" name="trucks_view" value="1" @if(isset($viewTrucks)) {{$viewTrucks}} @endif>&nbsp;&nbsp; View Access &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="trucks_edit" value="1" @if(isset($editTrucks)) {{$editTrucks}} @endif>&nbsp;&nbsp; Edit Access &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="trucks_full" value="1" @if(isset($fullTrucks)) {{$fullTrucks}} @endif>&nbsp;&nbsp; Full Access &nbsp;&nbsp;&nbsp;&nbsp;
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="drivers">Drivers: &nbsp;&nbsp;&nbsp;</label>
                                    <input type="checkbox" name="drivers_view" value="1">&nbsp;&nbsp; View Access &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="drivers_edit" value="1">&nbsp;&nbsp; Edit Access &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="drivers_full" value="1">&nbsp;&nbsp; Full Access &nbsp;&nbsp;&nbsp;&nbsp;
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button> 
                            </div>
                            </form>
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
        $('input[type="checkbox"]').on('change', function(){
            var value     = $(this).val(); // value is 1 
            var isChecked = $(this).is(':checked'); // return true or false
            var fieldName = $(this).attr('name'); // return name 
            // alert(fieldName);

            // send data to server via ajax
            $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type : 'post',
            url : "{{ url('admin/roles-and-permission')}}",
            data : {value:value, isChecked:isChecked, fieldName:fieldName},
            success: function(resp){
                console.log('Data Updated Successfully!');
            }, error:function(){
                alert('Error');
            }

            });
        });
    });
</script>
@endsection

