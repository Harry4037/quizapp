@extends('layout.admin.app')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Profile Management
        </h1>
        @include('layout.admin.breadcrumbs')
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                @include('errors.errors-and-messages')
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title">Profile</h3>
                    </div>
                    <div class="box-body">
                        <form class="form-horizontal form-label-left" action="{{ route('admin.profile') }}" method="post" id="profileForm" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4 col-xs-12">Name <span class="error">*</span></label>
                                <div class="col-md-4 col-sm-6 col-xs-6">
                                    <input placeholder="Name" type="text" class="form-control"  name="name" id="name" value="{{auth()->user()->name}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4 col-xs-12">Select Profile Pic</label>
                                <div class="col-md-4 col-sm-6 col-xs-6">
                                    <input type="file" class="form-control" name="profile_pic" id="profile_pic">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4 col-xs-12">Profile Pic Preview</label>
                                <div class="col-md-4 col-sm-6 col-xs-6">
                                    <img class="img-bordered img-thumbnail" src="{{auth()->user()->profile_pic}}" style="width: 50%">
                                </div>
                            </div>
                            <div class="ln_solid"></div>

                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4 col-xs-12">Designation <span class="error">*</span></label>
                                <div class="col-md-4 col-sm-6 col-xs-6">
                                    <input placeholder="Designation" type="text" class="form-control" name="designation" id="designation" value="{{auth()->user()->designation}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4 col-xs-12">into_line <span class="error">*</span></label>
                                <div class="col-md-4 col-sm-6 col-xs-6">
                                    <input placeholder="About Us" type="text" class="form-control" name="into_line" id="into_line" value="{{auth()->user()->into_line}}">
                                </div>
                            </div>
                            <div class="box-footer">
                                <div class="form-group">
                                    <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-4">
                                        <a class="btn btn-default" href="{{ route('admin.dashboard') }}">Cancel</a>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection
@section('script')
<script>
    $(document).ready(function () {

        $("#profileForm").validate({
            rules: {
                profile_pic: {
                    accept: "image/*",
                },
                user_name: {
                    required: true
                },
                address1: {
                    required: true
                },
                city: {
                    required: true
                },
                state: {
                    required: true
                },
                pin_code: {
                    required: true,
                    digits: true,
                    minlength: 6,
                    maxlength: 6,
                },
                lat: {
                    required: true,
                    number: true,
                },
                long: {
                    required: true,
                    number: true,
                },
            },
            messages: {
                profile_pic: {
                    accept: "Not valid image type"
                },
                pin_code: {
                    digits: 'Please enter only digits.',
                    minlength: 'Please enter 6 digit number.',
                    maxlength: 'Please enter 6 digit number.',
                }
            }
        });
    });
</script>
@endsection
