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
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Profile</h3>
                    </div>
                    <form class="form-horizontal form-label-left" action="{{ route('admin.change-password') }}" method="post" id="profileForm" enctype="multipart/form-data">
                        @csrf
                        <div class="box-body">
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4 col-xs-12">Current Password <span class="error">*</span></label>
                                <div class="col-md-4 col-sm-6 col-xs-6">
                                    <input type="password" class="form-control" name="old_password" id="old_password" placeholder="Current Password">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4 col-xs-12">New Password <span class="error">*</span></label>
                                <div class="col-md-4 col-sm-6 col-xs-6">
                                    <input title="Password must contain at least 6 characters, including UPPER/lowercase and numbers" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" type="password" class="form-control" name="new_password" id="new_password" placeholder="New Password" onchange="
  this.setCustomValidity(this.validity.patternMismatch ? this.title : '');
  if(this.checkValidity()) form.new_password.pattern = RegExp.escape(this.value);
">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4 col-xs-12">Confirm Password <span class="error">*</span></label>
                                <div class="col-md-4 col-sm-6 col-xs-6">
                                    <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm Password">
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <div class="form-group">
                                <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-4">
                                    <a class="btn btn-default" href="{{ route('admin.dashboard') }}">Cancel</a>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-footer -->
                    </form>
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

        jQuery.validator.addMethod("alphanumeric", function (value, element) {
            return this.optional(element) || /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{6,20}$/.test(value);
        }, "Password must be <br> <ul><li>Minimum six character.</li><li>One uppercase letter.</li><li>One lowercase letter.</li><li>One numeric digit.</li><li>One special character.</li></ul>");


        $("#profileForm").validate({
            rules: {
                old_password: {
                    required: true,
                },
                new_password: {
                    required: true,
                    alphanumeric: true
                },
                confirm_password: {
                    required: true,
                    equalTo: '#new_password',
                },
            },
            messages: {
                confirm_password: {
                    equalTo: "Confirm password does't match.",
                },
            }
        });

    });
</script>
@endsection