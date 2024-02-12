@extends('admin::layouts.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $common['title']}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">{{ $common['title']}}</li>
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
                    <div class="card card-primary">
                        <form action="#" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="name">Expense Type</label>
                                            <h6> {{ $get_office_expense->category->name }}</h6>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="expense_amount">Expense Amount</label>
                                            <h6>{{ $get_office_expense->expense_amount}}</h6>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="expense_detail">Expense Detail</label>
                                            <h6>{{ $get_office_expense->expense_detail}}</h6>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="remark">Remark</label>
                                            <h6> {{ $get_office_expense->remark}}</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Attach File</label>
                                            <section class="uploadImg">
                                                @php
                                                $substr = pathinfo($get_office_expense['file'], PATHINFO_EXTENSION);
                                            @endphp
                                            @if(in_array($substr,['jpeg','jpg','png']))
                                            <a target="_blank"
                                                href="{{ asset('public/uploads/officeExpense/'. $get_office_expense['file'])}}"
                                                class="profile-image">
                                                <img class="user-img img-css" id="image_1" width="120px" height="120px" style="border-radius: 50%;"
                                                    src="{{ $get_office_expense['file'] !='' ? asset('public/uploads/officeExpense/'. $get_office_expense['file']) : asset('public/uploads/placeholder/default_user.png') }}">
                                            </a>
                                            @else
                                            <a target="_blank"
                                            href="{{ asset('public/uploads/officeExpense/'. $get_office_expense['file'])}}"
                                            class="profile-image">
                                            <img class="user-img img-css" id="image_1" width="100px" height="100px" style="border-radius: 50%;"
                                                src="{{ asset('public/download.png')}}">
                                            </a>
                                            @endif
                                            </section>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection