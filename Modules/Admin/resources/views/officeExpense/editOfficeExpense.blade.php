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
                            </h3>
                        </div>
                        <div class="card-body">
                            <form name="OfficeExpenseDetailForm" id="main" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div
                                            class="form-group mb-3 {{ $errors->has('expense_type') ? 'has-danger' : '' }}">
                                            <label class="col-form-label">Expense Type*</label>
                                            <select class="form-control" id="expense_type" name="expense_type">
                                                <option value="">Select Expense Type</option>
                                                @foreach($get_categories as $categories)
                                                <option value="{{ $categories['id']}}" {{
                                                    $categories['id']==$get_office_expense['expense_type'] ? 'selected'
                                                    : '' }}>{{ $categories['name']}}</option>
                                                @endforeach
                                            </select>
                                            @error('expense_type')
                                            <div class="col-form-alert-label">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div
                                            class="form-group mb-3 {{ $errors->has('expense_amount') ? 'has-danger' : '' }}">
                                            <label class="col-form-label">Expense Amount*</label>
                                            <input
                                                class="form-control {{ $errors->has('expense_amount') ? 'form-control-danger' : '' }}"
                                                name="expense_amount" type="text"
                                                value="{{ old('expense_amount', $get_office_expense['expense_amount']) }}"
                                                placeholder="Enter expense amount">
                                            @error('expense_amount')
                                            <div class="col-form-alert-label">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div
                                            class="form-group mb-3 {{ $errors->has('expense_detail') ? 'has-danger' : '' }}">
                                            <label class="col-form-label">Expense Details*</label>
                                            <textarea
                                                class="form-control {{ $errors->has('expense_detail') ? 'form-control-danger' : '' }}"
                                                name="expense_detail" type="text"
                                                placeholder="Enter expense details">{{ old('expense_detail', $get_office_expense['expense_detail']) }}</textarea>
                                            @error('expense_detail')
                                            <div class="col-form-alert-label">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 {{ $errors->has('remark') ? 'has-danger' : '' }}">
                                            <label class="col-form-label">Remarks*</label>
                                            <textarea
                                                class="form-control {{ $errors->has('remark') ? 'form-control-danger' : '' }}"
                                                name="remark" type="text"
                                                placeholder="Enter remark">{{ old('remark', $get_office_expense['remark']) }}</textarea>
                                            @error('remark')
                                            <div class="col-form-alert-label">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 {{ $errors->has('document') ? 'has-danger' : '' }}">
                                            <label class="col-form-label">Attach File (Jpeg, jpg, png, pdf)*</label>
                                            <input type="file"
                                                class="form-control {{ $errors->has('document') ? 'form-control-danger' : '' }}"
                                                onchange="loadFile(event,'image_1')" name="document">
                                            @error('document')
                                            <div class="col-form-alert-label">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="media-left">
                                            @php
                                                $substr = pathinfo($get_office_expense['file'], PATHINFO_EXTENSION);
                                            @endphp
                                            @if(in_array($substr,['jpeg','jpg','png']))
                                            <a target="_blank"
                                                href="{{ asset('public/uploads/officeExpense/'. $get_office_expense['file'])}}"
                                                class="profile-image">
                                                <img class="user-img img-css" id="image_1" width="30%;"
                                                    src="{{ $get_office_expense['file'] !='' ? asset('public/uploads/officeExpense/'. $get_office_expense['file']) : asset('public/uploads/placeholder/default_user.png') }}">
                                            </a>
                                            @else
                                            <a target="_blank"
                                            href="{{ asset('public/uploads/officeExpense/'. $get_office_expense['file'])}}"
                                            class="profile-image">
                                            <img class="user-img img-css" id="image_1" width="30%;"
                                                src="{{ asset('public/download.png')}}">
                                            </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
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