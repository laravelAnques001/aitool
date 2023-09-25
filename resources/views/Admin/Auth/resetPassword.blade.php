@extends('Admin.layouts.common')
@section('title')
    {{ 'Change Password - ' }}{{ config('constants.PROJECT_TITLE') }}
@endsection
<!-- Theme JS files -->

@section('content')
    <script>
        $(document).ready(function() {
            $('#formadd').validate({ // initialize the plugin
                rules: {
                    old_password: {
                        required: true,
                    },
                    new_password: {
                        required: true,
                    },
                    confirm_password: {
                        required: true,
                        equalTo: '[name="new_password"]'
                    }

                },
                messages: {
                    old_password: {
                        required: "Old Password field is required.",
                    },
                    new_password: {
                        required: "New Password field is required.",
                    },
                    confirm_password: {
                        required: "Confirm Password field is required.",
                        equalTo: "New Password And Confirm Password Must Be Same."
                    }

                },
            });
        });

        {{--  function myFunction() {
            var x = document.getElementById("myInput");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }  --}}

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
                        class="text-semibold">Change Password</span></h4>
            </div>

        </div>
        <div class="breadcrumb-line breadcrumb-line-component">
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard') }}"><i class="icon-home2 position-left"></i> Home</a></li>
                <li>Change Password</li>
            </ul>
        </div>

    </div>
    <!-- /page header -->
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <form method="post" action="{{ route('resetpassword.store') }}" id="formadd">
                    @csrf
                    <div class="form-horizontal">
                        <div class="panel panel-flat">
                            <div class="panel-heading">
                                <h5 class="panel-title">Change Password</h5>

                            </div>

                            <div class="panel-body">
                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="old_password">Old Password <span
                                            class="text-danger">*</span></label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="old_password" id="old_password"
                                            placeholder="Enter Old Pasword" >
                                        @error('old_password')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="new_password">New Password <span
                                            class="text-danger">*</span></label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="new_password" id="new_password"
                                            placeholder="Enter New Pasword">
                                        @error('new_password')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label" for="confirm_password">Confirm Password <span
                                            class="text-danger">*</span></label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="confirm_password"
                                            id="confirm_password" placeholder="Enter Confirm Pasword">
                                        @error('confirm_password')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="text-right">
                                    <button type="submit" class="btn btn-labeled-right1 bg-blue heading-btn">Update
                                        Password</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endsection
