@extends('Admin.layouts.common')
@section('content')
    <div>
        <!-- Page header -->
        <div class="page-header">
            <div class="page-header-content">
                <div class="page-title">
                    <h4>
                        <a href="{{ route('generator.index') }}"><i class="icon-arrow-left52 position-left"></i></a>
                        <span class="text-semibold">Generator Create</span>
                    </h4>
                </div>

            </div>
            <div class="breadcrumb-line breadcrumb-line-component">
                <ul class="breadcrumb">
                    <li><a href="{{ route('dashboard') }}"><i class="icon-home2 position-left"></i> Home</a></li>
                    <li>Generator Create</li>
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

                            <form action="{{ route('generator.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="panel-body">

                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for="tool_id">Select Tool:</label>
                                        <div class="col-lg-9">
                                            <select class="select" name="tool_id" id="tool_id">
                                                <option value="">Select Tool</option>
                                                @foreach ($toolList as $tool)
                                                    <option value="{{ $tool->id }}">{{ $tool->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('tool_id')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for="name">Generator Name:</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control" name="name" id="name"
                                                placeholder="Enter Generator Name" value="{{ old('name') }}">
                                            @error('name')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for="link">Generator Link:</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control" name="link" id="link"
                                                placeholder="Enter Generator Link" value="{{ old('link') }}">
                                            @error('link')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for="logo">Generator Logo:</label>
                                        <div class="col-lg-9">
                                            <input type="file" class="file-styled" name="logo" id="logo"
                                                value="{{ old('logo') }}">
                                            @error('logo')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for="image">Generator Image:</label>
                                        <div class="col-lg-9">
                                            <input type="file" class="file-styled" name="image" id="image"
                                                value="{{ old('image') }}">
                                            @error('image')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" for="description">Generator
                                            Description:</label>
                                        <div class="col-lg-9">
                                            <textarea rows="2" cols="5" class="form-control" id="description" name="description"
                                                placeholder="Enter Generator Description">{{ old('description') }}</textarea>
                                            @error('description')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
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
                    <!-- /Generator Information -->

                </div>
            </div>
            <!-- /Horizontal form options -->
        </div>
        <!-- /content area -->
    </div>
@endsection
