@extends('Admin.layouts.common')
@section('content')
    <div>
        <!-- Page header -->
        <div class="page-header">
            <div class="page-header-content">
                <div class="page-title">
                    <h4>
                        <a href="{{ route('tool.index') }}"><i class="icon-arrow-left52 position-left"></i></a>
                        <span class="text-semibold">Tool Edit</span>
                    </h4>
                </div>

            </div>
            <div class="breadcrumb-line breadcrumb-line-component">
                <ul class="breadcrumb">
                    <li><a href="{{ route('dashboard') }}"><i class="icon-home2 position-left"></i> Home</a></li>
                    <li>Tool Edit</li>
                </ul>
            </div>
        </div>
        <!-- /page header -->

        <!-- Content area -->
        <div class="content">

            <!-- Horizontal form options -->
            <div class="row">
                <div class="col-md-12">

                    <!-- Tool Information-->
                    <div class="form-horizontal">
                        <div class="panel panel-flat">
                            <div class="panel-heading">
                                <h5 class="panel-title">Tool Information</h5>
                            </div>

                            <form action="{{ route('tool.update', base64_encode($tool->id)) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="panel-body">

                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for="name">Tool Name:</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control" name="name" id="name"
                                                placeholder="Enter Tool Name" value="{{ $tool->name }}">
                                            @error('name')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for="image">Tool Image:</label>
                                        <div class="col-lg-9">
                                            <input type="file" class="file-styled" name="image" id="image">
                                            @error('image')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                            <img src="{{ $tool->image_url }}" alt="Tool Image" class="img-thumbnail"
                                                width="100" height="100">
                                        </div>
                                    </div>

                                    <div class="text-right">
                                        <button type="submit" class="btn btn-primary">Submit form <i
                                                class="icon-arrow-right14 position-right"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /Tool Information -->

                </div>
            </div>
            <!-- /vertical form options -->

        </div>
        <!-- /content area -->
    </div>
@endsection
