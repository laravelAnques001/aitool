@extends('Admin.layouts.common')
@section('title')
    {{ 'Profile - User ' }}{{ config('constants.PROJECT_TITLE') }}
@endsection

@section('content')
    <script>
        $(document).ready(function() {
            $('#formadd').validate({ // initialize the plugin
                rules: {
                    name: {
                        required: true,
                    },
                    email: {
                        required: true,
                    },
                    mobile_number: {
                        required: true,
                    },
                    image: {
                        required: false,
                    },
                },
                messages: {
                    name: {
                        required: "Name field is required.",
                    },
                    mobile_number: {
                        required: "Mobile Number field is required.",
                    },
                    email: {
                        required: "Email field is required.",
                    }

                },
            });
        });

        $('#formadd').submit(function() {
            if ($(this).valid()) {

                $(this).find('button[type=submit]').prop('disabled', true);
            }
        });
    </script>
    <script></script>
    </script>
    <!-- Page header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h4><a href="{{ route('dashboard') }}"><i class="icon-arrow-left52 position-left"></i></a> <span
                        class="text-semibold">User Profile</span></h4>
            </div>

        </div>
        <div class="breadcrumb-line breadcrumb-line-component">
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard') }}"><i class="icon-home2 position-left"></i> Home</a></li>
                <li>User Profile</li>
            </ul>
        </div>
    </div>
    <!-- /page header -->
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <form method="post" action="{{ route('profile.update') }}" id="formadd" enctype="multipart/form-data">
                    @csrf
                    <div class="form-horizontal">
                        <div class="panel panel-flat">
                            <div class="panel-heading">
                                <h5 class="panel-title">Profile Update</h5>
                            </div>

                            <div class="panel-body">
                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="name">Name: <span class="text-danger">*</span></label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="name" id="name"
                                            placeholder="Enter Name" value="{{ old('name', $users->name) }}">
                                        @error('name')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="email">Email: <span class="text-danger">*</span></label>
                                    <div class="col-lg-9">
                                        <input type="email" class="form-control" name="email" id="email"
                                            placeholder="Enter Email" value="{{ old('email', $users->email) }}"
                                            pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$">
                                        @error('email')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="mobile_number">Mobile Number: <span class="text-danger">*</span></label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="mobile_number" id="mobile_number"
                                            placeholder="Enter Mobile Number" pattern="[0-9]{10}"
                                            value="{{ old('mobile_number', $users->mobile_number) }}">
                                        <span class="text-brown">(Only 10 Number Required)</span>
                                        @error('mobile_number')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="image">Image:</label>
                                    <div class="col-lg-9">
                                        <input type="file" class="file-styled" name="image" id="image"
                                            value="{{ old('image') }}" accept="image/*">
                                        @error('image')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                        @if ($users->image_url)
                                            <img src="{{ $users->image_url }}" alt="User Profile" width="100"
                                                height="100">
                                        @endif
                                    </div>
                                </div>

                                <div class="text-right">
                                    <button type="submit" class="btn btn-labeled-right1 bg-blue heading-btn">Update
                                        Profile</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endsection
