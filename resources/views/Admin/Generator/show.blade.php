@extends('Admin.layouts.common')
@section('content')
    <div>
        <!-- Page header -->
        <div class="page-header">
            <div class="page-header-content">
                <div class="page-title">
                    <h4>
                        <a href="{{ route('generator.index') }}"><i class="icon-arrow-left52 position-left"></i></a>
                        <span class="text-semibold">Generator Show</span>
                    </h4>
                </div>

            </div>
            <div class="breadcrumb-line breadcrumb-line-component">
                <ul class="breadcrumb">
                    <li><a href="{{ route('dashboard') }}"><i class="icon-home2 position-left"></i> Home</a></li>
                    <li>Generator Show</li>
                </ul>
            </div>
        </div>
        <!-- /page header -->

        <!-- Content area -->
        <div class="content">

            <!-- Horizontal form options -->
            <div class="row">
                <div class="col-md-12">

                    <!-- Generator Information-->
                    <div class="form-horizontal">
                        <div class="panel panel-flat">
                            <div class="panel-heading">
                                <h5 class="panel-title">Generator Information</h5>
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Generator Tool:</label>
                                    <div class="col-lg-9">
                                        <p class="form-control">{{ $generator->tool->name ?? '' }}</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Generator name:</label>
                                    <div class="col-lg-9">
                                        <p class="form-control">{{ $generator->name }}</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Generator Link:</label>
                                    <div class="col-lg-9">
                                        <a href="{{ $generator->link }}" target="_blank"
                                            class="form-control">{{ $generator->link }}</a>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Generator Logo:</label>
                                    <div class="col-lg-9">
                                        <img src="{{ $generator->logo_url }}" alt="Generator Logo" class="img-thumbnail"
                                            width="100" height="100">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Generator Image:</label>
                                    <div class="col-lg-9">
                                        <img src="{{ $generator->image_url }}" alt="Generator Image" class="img-thumbnail"
                                            width="100" height="100">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Generator Description:</label>
                                    <div class="col-lg-9">
                                        <p class="form-control">{{ $generator->description }}</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- /Generator Information -->

                </div>
            </div>
            <!-- /vertical form options -->

        </div>
        <!-- /content area -->
    </div>
@endsection
